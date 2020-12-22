<?php

namespace App\Http\Controllers\ProviderResources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use Setting;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Http\Controllers\SendPushNotification;
use App\Chat;
use App\Chatroom;
use App\User;
use App\Zones;
use App\Admin;
use App\PushNotification;
use App\Promocode;
use App\UserRequests;
use App\RequestFilter;
use App\PromocodeUsage;
use App\ProviderService;
use App\UserRequestRating;
use App\UserRequestPayment;
use App\ServiceType;
use App\WithdrawalMoney;
use App\ProviderZone;
use Mail;
use DB;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            if($request->ajax()) {
                $Provider = Auth::user();
            } else {
                $Provider = Auth::guard('provider')->user();
            }   

            $provider = $Provider->id;

            $AfterAssignProvider = RequestFilter::with(['request.user', 'request.payment', 'request'])
                ->where('provider_id', $provider)
                ->whereHas('request', function($query) use ($provider) {
                        $query->where('status','<>', 'CANCELLED');
                        $query->where('status','<>', 'SCHEDULED');
                        $query->where('provider_id', $provider );
                        $query->where('current_provider_id', $provider);
                    });


            $BeforeAssignProvider = RequestFilter::with(['request.user', 'request.payment', 'request'])
                ->where('provider_id', $provider)
                ->whereHas('request', function($query) use ($provider){
                        $query->where('status','<>', 'CANCELLED');
                        $query->where('status','<>', 'SCHEDULED');
                        $query->where('current_provider_id',$provider);
                    });

            $IncomingRequests = $BeforeAssignProvider->union($AfterAssignProvider)->get();
            //$trips = UserRequests::where('status','COMPLETED')->where('provider_id',$provider )->count();
            $trips = UserRequests::where('provider_id',$provider)->count();
            $query = "SELECT SUM(user_request_payments.fixed + user_request_payments.distance + user_request_payments.tax ) as revenue FROM `user_requests` LEFT JOIN user_request_payments on user_requests.id=user_request_payments.request_id where provider_id=".$provider;
            $rev = collect(DB::select($query))->first();
            $totalride = UserRequests::where('provider_id',$provider)->pluck('id');       
            $totalEarning = UserRequestPayment::whereIn('request_id', $totalride)->sum('total');       
            $commission = UserRequestPayment::whereIn('request_id', $totalride)->sum('commision');
            $earnings = $totalEarning-$commission;
            $earnings = number_format($earnings, 2);
            //$earnings = $rev->revenue;
            //$commision = $rev->revenue;
            if(!empty($request->latitude)) {
                $point[0] = $request->latitude;
                $point[1] = $request->longitude;
                $zone_id =	$this->getLatlngZone_id($point);
                
                $Provider->update([
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'zone_id' =>  $zone_id
                ]);
                ProviderZone::updateOrCreate(['driver_id'=>$provider],
                    [ 'driver_id' => $provider,
                      'zone_id' =>  $zone_id
                    ]
                );
               
            }

            $Timeout = Setting::get('provider_select_timeout', 180);
                if(!empty($IncomingRequests)){
                    for ($i=0; $i < sizeof($IncomingRequests); $i++) {
                        $IncomingRequests[$i]->time_left_to_respond = $Timeout - (time() - strtotime($IncomingRequests[$i]->request->assigned_at));
                        if($IncomingRequests[$i]->request->status == 'SEARCHING' && $IncomingRequests[$i]->time_left_to_respond < 0) {
                           $this->assign_next_provider($IncomingRequests[$i]->request->id);
                        }
                    }
                }


            $Response = [
                    'account_status' => $Provider->status,
                    'service_status' => $Provider->service ? Auth::user()->service->status : 'offline',
                    'trips' => $trips,
                    'earnings' => $earnings,
                    'commision' => $commission,
                    'requests' => $IncomingRequests,
                ];

            return $Response;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Something went wrong']);
        }
    }





    /******** JUST MADE TODAY FOR API **********/
    public function InitQuery($type){

        $id = \Auth::user()->id;

        if($type=='week'){
            $date = Carbon::now()->subDays(7)->toDateTimeString();
        }
        if($type=='month'){
            $date = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        }

        return UserRequests::where('user_requests.status', '=', 'COMPLETED')
                    ->where('provider_id',$id)
                    ->where( 'finished_at', '>=',$date )
                    ->orderBy('finished_at','desc')
                    ->select('id','finished_at','total','status','provider_id','payment_mode');
    }


    public function resultApi($type){

        $query = $this->InitQuery($type);


        $total = $query->sum('total');
        $trips  = $query->get()->toArray();

        $totalcash = $this->InitQuery($type)->where('payment_mode','CASH')->sum('total');
        $totalpaypal = $this->InitQuery($type)->where('payment_mode','PAYPAL')->sum('total');
        $totalcard = $this->InitQuery($type)->where('payment_mode','CARD')->sum('total');
        
        $count = count($trips);

        $result = compact('total','count','totalcard','totalcash','totalpaypal','trips');

        echo json_encode($result);
        exit;
    }


    public function TotalFinishedcurrentMonth(Request $request){
        $query = $this->resultApi('month');
    }

    public function TotalFinishedcurrentWeek(Request $request){
        $query = $this->resultApi('week');
    }
    /******** JUST MADE TODAY FOR API **********/


                    



  
  

  




    /**
     * Cancel given request.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        $this->validate($request, [
            'cancel_reason'=> 'max:255',
        ]);
        try{

            $UserRequest = UserRequests::findOrFail($request->request_id);

            $pa = UserRequestPayment::where('request_id',$UserRequest->id)->first();
            if($pa){
                $pa->total = 0;
                $pa->fixed = 0;
                $pa->save();
            }
            



            $Cancellable = ['SEARCHING', 'ACCEPTED', 'ARRIVED', 'STARTED', 'CREATED','SCHEDULED'];
        
            if(!in_array($UserRequest->status, $Cancellable)) {
                return back()->with(['flash_error' => 'Cannot cancel request at this stage!']);
            }

            $UserRequest->status = "CANCELLED";
            $UserRequest->cancel_reason = $request->cancel_reason;
            $UserRequest->cancelled_by = "PROVIDER";
            $UserRequest->total = 0 ;
            $UserRequest->save();

            /*
            $data  = [
                'request_id' => $UserRequest->id,
                'provider_id' => Auth::user()->id,
            ];
            \DB::table('canceled_rides')->insert($data);
            */



            RequestFilter::where('request_id', $UserRequest->id)->delete();

            ProviderService::where('provider_id',$UserRequest->provider_id)->update(['status' =>'active']);

             // Send Push Notification to User
            (new SendPushNotification)->ProviderCancellRide($UserRequest);


            return $UserRequest;

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Something went wrong']);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rate(Request $request, $id)
    {
        $this->validate($request, [
                'rating' => 'required|integer|in:1,2,3,4,5',
                'comment' => 'max:255',
            ]);
    
        try {

            $UserRequest = UserRequests::where('id', $id)
                                        ->where('status', 'COMPLETED')
                                        ->firstOrFail();
            $review = UserRequestRating::where('request_id',$id)->count();
            
            if($review==0) {
                UserRequestRating::create([
                    'provider_id' => $UserRequest->provider_id,
                    'user_id' => $UserRequest->user_id,
                    'request_id' => $UserRequest->id,
                    'provider_rating' => $request->rating,
                    'provider_comment' => $request->comment,
                ]);
            } else {
                $UserRequest->rating->update([
                    'provider_rating' => $request->rating,
                    'provider_comment' => $request->comment,
                ]);
            }
            /*if($UserRequest->rating == null) {
                UserRequestRating::create([
                    'provider_id' => $UserRequest->provider_id,
                    'user_id' => $UserRequest->user_id,
                    'request_id' => $UserRequest->id,
                    'provider_rating' => $request->rating,
                    'provider_comment' => $request->comment,
                ]);
            } else {
                $UserRequest->rating->update([
                    'provider_rating' => $request->rating,
                    'provider_comment' => $request->comment,
                ]);
            }*/

            $UserRequest->update(['provider_rated' => 1]);

            // Delete from filter so that it doesn't show up in status checks.
            RequestFilter::where('request_id', $id)->delete();

            ProviderService::where('provider_id',$UserRequest->provider_id)->update(['status' =>'active']);

            // Send Push Notification to Provider 
            $average = UserRequestRating::where('provider_id', $UserRequest->provider_id)->avg('provider_rating');

            $UserRequest->user->update(['rating' => $average]);

            return response()->json(['message' => 'Request Completed!']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Request not yet completed!'], 500);
        }
    }

    /**
     * Get the trip history of the provider
     *
     * @return \Illuminate\Http\Response
     */
    public function scheduled(Request $request)
    {
        try{
            $Jobs = UserRequests::where('provider_id', Auth::user()->id)
                    ->where('status', 'SCHEDULED')
                    ->with('service_type')
                    ->get();

            if(!empty($Jobs)){
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($Jobs as $key => $value) {
                    $Jobs[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }
            return $Jobs;
        } catch(Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }


        
        // Verify OTP
        public function verifyOtp(Request $request){
            

            $this->validate($request,[
                    'request_id'    => 'required|numeric',  
                    'otp'   => 'required|numeric',
                ]);

            try{

                $user_request = UserRequests::where('id', $request->request_id)->first();
                if($user_request->verification_code == $request->otp){
                    return response()->json(["status" => 1, "msg" => 'Verifed']);
                }else{
                    return response()->json(["status" => 0, "msg" => 'Unverifed']);
                }
                
            } catch(Exception $e) {
                
                return response()->json(['error' => $e->getMessage() ], 500);
            
            }
        }
        
    /**
     * Get the trip history of the provider
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        if($request->ajax()) {

            $Jobs = UserRequests::where('provider_id', Auth::user()->id)
                    ->orderBy('created_at','desc')
                    ->with('payment')
                    ->get();

            if(!empty($Jobs)){
                $map_icon = asset('asset/marker.png');
                foreach ($Jobs as $key => $value) {
                    $Jobs[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }
            return $Jobs;
        }
        $Jobs = UserRequests::where('provider_id', Auth::guard('provider')->user()->id)->with('user', 'service_type', 'payment', 'rating')->get();
        return view('provider.trip.index', compact('Jobs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, $id)
    {

        try {

            $UserRequest = UserRequests::findOrFail($id);
            
            if($UserRequest->status != "SEARCHING") {
                return response()->json(['error' => 'Request already under progress!']);
            }
            
            $UserRequest->provider_id = Auth::user()->id;

            if($UserRequest->schedule_at != ""){

                $beforeschedule_time = strtotime($UserRequest->schedule_at."- 1 hour");
                $afterschedule_time = strtotime($UserRequest->schedule_at."+ 1 hour");

                $CheckScheduling = UserRequests::where('status','SCHEDULED')
                                    ->where('provider_id', Auth::user()->id)
                                    ->whereBetween('schedule_at',[$beforeschedule_time,$afterschedule_time])
                                    ->count();

                if($CheckScheduling > 0 ){
                    if($request->ajax()) {
                        return response()->json(['error' => trans('api.ride.request_already_scheduled')]);
                    }else{
                        return redirect('dashboard')->with('flash_error', 'If the ride is already scheduled then we cannot schedule/request another ride for the after 1 hour or before 1 hour');
                    }
                }

                RequestFilter::where('request_id',$UserRequest->id)->where('provider_id',Auth::user()->id)->update(['status' => 2]);

                $UserRequest->status = "SCHEDULED";
                $UserRequest->current_provider_id = Auth::user()->id;
                $UserRequest->save();

            }   else{
                $otp = mt_rand(1000, 9999);
                $UserRequest->verification_code = $otp;
                $UserRequest->status = "STARTED";
                $UserRequest->save();

                ProviderService::where('provider_id',$UserRequest->provider_id)->update(['status' =>'riding']);

                $Filters = RequestFilter::where('request_id', $UserRequest->id)->where('provider_id', '!=', Auth::user()->id)->get();
            
                foreach ($Filters as $Filter) {
                    $Filter->delete();
                }
            }

            $UnwantedRequest = RequestFilter::where('request_id','!=' ,$UserRequest->id)
                                ->where('provider_id',Auth::user()->id )
                                ->whereHas('request', function($query){
                                    $query->where('status','<>','SCHEDULED');
                                });

            if($UnwantedRequest->count() > 0){
                $UnwantedRequest->delete();
            }  

            // Send Push Notification to User
            (new SendPushNotification)->RideAccepted($UserRequest->user_id);


            return response()->json([['success' => [$UserRequest->id]] ]);


            return $UserRequest->with('user')->get();

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Unable to accept, Please try again later']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Connection Error']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
               
        $this->validate($request, [
            'status' => 'required|in:ACCEPTED,STARTED,ARRIVED,PICKEDUP,DROPPED,PAYMENT,COMPLETED',
        ]);

        try{

            $UserRequest = UserRequests::with('user','payment','provider','service_type')->findOrFail($id);

            if($request->status == 'DROPPED' && $UserRequest->payment_mode != 'CASH') {
                $UserRequest->status = $request->status;
            } else if ($request->status == 'COMPLETED' && $UserRequest->payment_mode == 'CASH') {
                $UserRequest->status = $request->status;
                $UserRequest->paid = 1;
                // ProviderService::where('provider_id',$UserRequest->provider_id)->update(['status' =>'active']);
            } else {
                $UserRequest->status = $request->status;
            }
			
			if($request->status == 'ARRIVED'){
				// Send Push Notification to User    
				(new SendPushNotification)->Arrived($UserRequest);
			}
		

            if($request->status == 'PICKEDUP'){
                $UserRequest->started_at = Carbon::now();
            }

            $UserRequest->save();

            if($request->status == 'DROPPED') {
                $UserRequest->finished_at = Carbon::now();
                $UserRequest->save();
                $UserRequest->with('user')->findOrFail($id);
                $UserRequest->invoice = $this->invoice($id);
            
				// Send Push Notification to User
				(new SendPushNotification)->Dropped($UserRequest->user_id);
		
				 $user = [ 
                            'email'      =>	$UserRequest->user->email,
                            'name'       =>	$UserRequest->user->first_name,
                            'total_fee'  =>	$UserRequest->invoice->total,
                            'status'     =>	'Pending',
                            'invoice_id' =>	$UserRequest->booking_id,
                            's_address'  =>	$UserRequest->s_address,
                            'd_address'  =>	$UserRequest->d_address,
                            'date'       =>	date('d-m-Y'),
                            'car'        =>   $UserRequest->service_type->name,
                            's_address'  =>   $UserRequest->s_address,
                            'd_address'  =>   $UserRequest->d_address,
				];
		


                
                    /*
                    Mail::send('emails.invoice', , function ($m) use ($user) {
                        $m->from('contact@3now.de');
                        $m->to($user['email'], $user['name'])->subject('Buchungsbestätigung');
                    });
                    */
                   
                    
                    $url = 'https://api.elasticemail.com/v2/email/send';
                    try{
                            $post = array('from' => 'contact@3now.de',
                            'fromName' => '3now',
                            'apikey' => '9ECAE3B0E7E28B94621D30D634B0238ACC12BE45DA5CC17DEC385C99EE08C9212403CDE46FE482701696293D221895D8',
                            'subject' => 'Buchungsbestätigung',
                            'to' => $user['email'],
                            'bodyHtml' => view("emails.invoice", ['user' => $user,'full_order' => $UserRequest]),
                            'isTransactional' => false);

                            $ch = curl_init();
                            curl_setopt_array($ch, array(
                                CURLOPT_URL => $url,
                                CURLOPT_POST => true,
                                CURLOPT_POSTFIELDS => $post,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_HEADER => false,
                                CURLOPT_SSL_VERIFYPEER => false
                            ));

                            $result=curl_exec ($ch);
                            curl_close ($ch);
                    }
                    catch(Exception $ex){
                        echo $ex->getMessage();
                    }
				
			}

       
            return $UserRequest;

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Unable to update, Please try again later']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Connection Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $UserRequest = UserRequests::find($id);

        try {
            $this->reject_provider($UserRequest->id);   
            return response()->json([['success' => [$UserRequest->id]] ]);

            return $UserRequest->with('user')->get();

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Unable to reject, Please try again later']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Connection Error']);
        }
    }
    
    
    public function reject_provider($request_id) {

        try {
            $UserRequest = UserRequests::findOrFail($request_id);
        } catch (ModelNotFoundException $e) {
            // Cancelled between update.
            return false;
        }

        $RequestFilter = RequestFilter::where('provider_id',Auth::user()->id)
                        ->where('request_id', $UserRequest->id)
                        ->delete();
                        
       
        try {

            $next_provider = RequestFilter::where('request_id', $UserRequest->id)
                            ->orderBy('id','asc')
                            ->firstOrFail();

            $UserRequest->current_provider_id = $next_provider->provider_id;
            $UserRequest->provider_id = $next_provider->provider_id;
            $UserRequest->assigned_at = Carbon::now();
            $UserRequest->save();

            // incoming request push to provider
            (new SendPushNotification)->IncomingRequest($next_provider->provider_id);
            
        } catch (ModelNotFoundException $e) {

            UserRequests::where('id', $UserRequest->id)->update(['status' => 'CANCELLED']);

            // No longer need request specific rows from RequestMeta
            RequestFilter::where('request_id', $UserRequest->id)->delete();

            //  request push to user provider not available
            (new SendPushNotification)->ProviderNotAvailable($UserRequest->user_id);
        }
    }
    

    public function assign_next_provider($request_id) {

        try {
            $UserRequest = UserRequests::findOrFail($request_id);
        } catch (ModelNotFoundException $e) {
            // Cancelled between update.
            return false;
        }

        /*$RequestFilter = RequestFilter::where('provider_id', $UserRequest->provider_id)
                        ->where('request_id', $UserRequest->id)
                        ->delete();*/
                        
        DB::table('request_filters')->where('provider_id',$UserRequest->provider_id)->where('request_id',$UserRequest->id)->take(1)->delete();                
       
        try {

            $next_provider = RequestFilter::where('request_id', $UserRequest->id)
                            ->orderBy('id','asc')
                            ->firstOrFail();

            $UserRequest->current_provider_id = $next_provider->provider_id;
            $UserRequest->provider_id = $next_provider->provider_id;
            $UserRequest->assigned_at = Carbon::now();
            $UserRequest->save();

            // incoming request push to provider
            (new SendPushNotification)->IncomingRequest($next_provider->provider_id);
            
        } catch (ModelNotFoundException $e) {

            UserRequests::where('id', $UserRequest->id)->update(['status' => 'CANCELLED']);

            // No longer need request specific rows from RequestMeta
            RequestFilter::where('request_id', $UserRequest->id)->delete();

            //  request push to user provider not available
            (new SendPushNotification)->ProviderNotAvailable($UserRequest->user_id);
        }
    }


    public function invoice($request_id) {

            $UserRequest = UserRequests::findOrFail($request_id);
            $Payment = new UserRequestPayment;
            $Payment->request_id = $UserRequest->id;
            $Payment->fixed = $UserRequest->total; ;
            $Payment->distance = $UserRequest->distance;
            $Payment->commision = 0;
            $Payment->surge = 0;
            $Payment->payment_mode = $UserRequest->payment_mode;
            $Payment->tax = '00';
            $Payment->total = $UserRequest->total;
            $Payment->save();
            return $Payment;
    }



    /**
     * Get the trip history details of the provider
     *
     * @return \Illuminate\Http\Response
     */
    public function history_details(Request $request)
    {
        $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
            ]);

        if($request->ajax()) {
            
            $Jobs = UserRequests::where('id',$request->request_id)
                                ->where('provider_id', Auth::user()->id)
                                ->with('payment','service_type','user','rating')
                                ->get();
            if(!empty($Jobs)){
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($Jobs as $key => $value) {
                    $Jobs[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }

            return $Jobs;
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function upcoming_trips() {
    
        try{
            $UserRequests = UserRequests::ProviderUpcomingRequest(Auth::user()->id)->get();
            if(!empty($UserRequests)){
                $map_icon = asset('asset/marker.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                                    "autoscale=1".
                                    "&size=320x130".
                                    "&maptype=terrian".
                                    "&format=png".
                                    "&visual_refresh=true".
                                    "&markers=icon:".$map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                                    "&markers=icon:".$map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                                    "&path=color:0x000000|weight:3|enc:".$value->route_key.
                                    "&key=".env('GOOGLE_MAP_KEY');
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return something_went_wrong();
        }
    }

    /**
     * Get the trip history details of the provider
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming_details(Request $request)
    {

        $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
            ]);

        //if($request->ajax()) {
            $Jobs = UserRequests::with('payment')->where('id',$request->request_id)
                                ->where('provider_id', Auth::user()->id)
                                ->with('service_type','user')
                                ->get();
            if(!empty($Jobs)){
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($Jobs as $key => $value) {
                    $Jobs[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }

            return $Jobs;
        //}

    }

    public function dailyearning_detail(Request $request)
    {

        $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
            ]);

        //if($request->ajax()) {
            $Jobs = UserRequests::where('provider_id',\Auth::guard('provider')->user()->id)
                    ->with('payment','service_type')
                    ->where('id',$request->request_id)
                    ->get();

            if(!empty($Jobs)){
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($Jobs as $key => $value) {
                    $Jobs[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }

            return $Jobs;
        //}

    }

    /**
     * Get the trip history details of the provider
     *
     * @return \Illuminate\Http\Response
     */
    public function summary(Request $request)
    {
        try{
            if($request->ajax()) {
                $rides = UserRequests::where('provider_id', Auth::user()->id)->count();
                $revenue = UserRequestPayment::whereHas('request', function($query) use ($request) {
                                $query->where('provider_id', Auth::user()->id);
                            })
                        ->sum('total');
                $cancel_rides = UserRequests::where('status','CANCELLED')->where('provider_id', Auth::user()->id)->count();
                $scheduled_rides = UserRequests::where('status','SCHEDULED')->where('provider_id', Auth::user()->id)->count();

                return response()->json([
                    'rides' => $rides, 
                    'revenue' => $revenue,
                    'cancel_rides' => $cancel_rides,
                    'scheduled_rides' => $scheduled_rides,
                ]);
            }

        } catch (Exception $e) {
            return something_went_wrong();
        }

    }


    /**
     * help Details.
     *
     * @return \Illuminate\Http\Response
     */

    public function help_details(Request $request){

        try{

            if($request->ajax()) {
                return response()->json([
                    'contact_number' => Setting::get('contact_number',''), 
                    'contact_email' => Setting::get('contact_email','')
                     ]);
            }

        }catch (Exception $e) {
            if($request->ajax()) {
                return something_went_wrong();
            }
        }
    }
	
	
	
	 public function test(){

		$UserRequest = UserRequests::with(['user' ,'payment'])->findOrFail(379);
		
		 $user = [ 
					'email'		=>	$UserRequest->user->email,
					'name'		=>	$UserRequest->user->first_name,
					'total_fee'	=>	Setting::get('currency').' '.abs( 45.45 ),
					'status'	=>	'Pending',
					'invoice_id'=>	$UserRequest->booking_id,
					's_address'	=>	$UserRequest->s_address,
					'd_address'	=>	$UserRequest->d_address,
					'date'		=>	date('d-m-Y'),
				];
  

		Mail::send('emails.invoice', ['user' => $user], function ($m) use ($user) {
			$m->from('support@quickrideja.com', '');
			$m->to($user['email'], $user['name'])->subject('Quickride - INVOICE');
		});

	
        
    }
    
    public function review(Request $request)
    {
        $this->validate($request, [
                'provider_id' => 'required|integer',
            ]);
            
        try{

            $review = UserRequestRating::select('user_rating','user_comment','created_at')->where('provider_id',Auth::user()->id)
                    ->orderBy('id', 'DESC')
                    ->get();
            
            return response()->json(['Data' =>$review]);
            
        } catch(Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }
    	//Get Chat
	public function getChat(Request $request){


		$this->validate($request, [
				'request_id' => 'required',              
			]);
	

		$userName = Auth::user()->first_name;
		if($request->has('message') && $request->has('provider_id') && $request->has('user_id') && $request->has('type')){

                    $order  = UserRequests::with('provider')->find($request->request_id);

         define('API_ACCESS_KEY','AAAA828ROg8:APA91bGjLro6tk76nQ1JuS92na1PKc56eIRiiaHwPDyYPWl2DR-flcGBiJ7wZDvXhwdTot-ocml_CXlGz_HOj44hntnaYuZzAY0Uek6sddvqwAyKLkG0EZMAgWjHoqkQDAaSh06lReDJ');
         $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
         

        $notification = [
            'title' =>'chat',
            'body' => $request->message,
        ];
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            'to'        =>  $order->user->device_token, //single token
            'notification' => $notification,
               

            'data' => [
                    "msg_type" =>"chat",
                    "request_id" =>$request->request_id,
                    "image_url" => 'image',
                    "user_name"=> $userName,
                    "msg"=>"msg"
                ]
        ];

        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
        



			//push notification
			(new SendPushNotification)->chatNotify($request->user_id,$request->message,$request->request_id,$userName);
		   
            $message = '$request->message';
			$msgCreate = Chat::Create([
				'request_id'	=>	$request->request_id,
				'provider_id'	=>	$request->provider_id,
				'user_id'		=>	$request->user_id,
				'message'		=>	$request->message,
				'type'			=>	$request->type,
			]);
		}

		$r = Chat::where('request_id',$request->request_id)->get();

		return response()->json(['status'=>1,"data"=>$r]);
	}
	
	public function dummyNotify()
	{
	    $msg= (new SendPushNotification)->chatNotify(43,'dummy',13,'john doe');
	    $msg2 = (new SendPushNotification)->chatNotifyProvider(80,'dummy',13,'john doe');
	    return $msg2;
	}
	
	public function notification(Request $request)
    {
        $id = Auth::user()->id;    
        try{
            
            $notifications = PushNotification::where('type',2)->whereRaw("find_in_set($id,to_user)")->whereDate('expiration_date', '>=', date('Y-m-d'))->orderBy('id','desc')->get();
            return response()->json(['Data' =>$notifications]);
            
        }   catch(Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }
    
    public function addNotification(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'title'=>'required',
            'notification_text'=>'required'
        ]);
        
            
        try {
                    
            $notification = new PushNotification;
            $notification->to_user = $request->to_user;
            $notification->type = $request->type;
            $notification->from_user = Auth::user()->id;
            $notification->title = $request->title;
            $notification->notification_text = $request->notification_text;
            $notification->url = $request->url;
            $notification->expiration_date = $request->expiration_date;
            $notification->zone = $request->zone;
            if($request->hasFile('image')) {
                
                $notification['image'] = $request->image->store('user/profile');
            }
            $notification->save();
            return response()->json(['message' =>'Notification saved.']);
                
        }   catch(Exception $e) {
            return response()->json(['error' => "Something Went Wrong."]);
        }
    }
    
    public function withdrawRequestList(Request $request){

        $Earn = UserRequestPayment::whereHas('request', function($query) use ($request) {
                                $query->where('provider_id', Auth::user()->id);
                            })
                        ->sum('total');
        $commision = UserRequestPayment::whereHas('request', function($query) use ($request) {
                                $query->where('provider_id', Auth::user()->id);
                            })
                        ->sum('commision');
        $totalEarn =    $Earn-$commision;
        $totalEarn? : 0;            

        $r =  WithdrawalMoney::where('provider_id',Auth::user()->id)->whereIn('status',['APPROVED','WAITING'])->orderBy('id','desc')->get();
        
      //  $takenAmount =  WithdrawalMoney::where('provider_id',Auth::user()->id)->where('status','APPROVED')->sum('amount');
      $takenAmount =  WithdrawalMoney::where('provider_id',Auth::user()->id)->whereIn('status',['APPROVED','WAITING'])->sum('amount');
    

        if(count($r) != 0){
            $res = $r;
            $status = 1;
            $afterdeduct = ($totalEarn-$takenAmount);
            $amount = $afterdeduct;
    
        }   else{
            $res = 0;
            $status = 0;
            $amount = $totalEarn;
        }
    
        return response()->json(["status"=>$status,"data"=>$res,'totalEarn'=>round($amount,2)]);
}
    
    public function withdrawalRequest(Request $request){

 $this->validate($request, [
                'provider_id' => 'required|int',
                'bank_account_id' => 'required',
                'amount' => 'required|int',  //bank token btok_we32e3
               
            ]);
   
        $Earn = UserRequestPayment::whereHas('request', function($query) use ($request) {
                                $query->where('provider_id', Auth::user()->id);
                            })
                        ->sum('total');
                        
        $commision = UserRequestPayment::whereHas('request', function($query) use ($request) {
                                $query->where('provider_id', Auth::user()->id);
                            })
                        ->sum('commision');
        $totalEarn =    $Earn-$commision;
        $totalEarn? : 0;  

        $r =  WithdrawalMoney::where('provider_id',Auth::user()->id)->whereIn('status',['APPROVED','WAITING'])->orderBy('id','desc')->get();
        
        $takenAmount =  WithdrawalMoney::where('provider_id',Auth::user()->id)->whereIn('status',['APPROVED','WAITING'])->sum('amount');
    

        if(count($r) != 0){
            $res = $r;
            $afterdeduct = ($totalEarn-$takenAmount);
            $amount = $afterdeduct;
    
        }   else{
            $res = 0;
            $amount = $totalEarn;
        }
   
    if($request->amount <= $amount){              
   $r = WithdrawalMoney::Create($request->all()); 
   $status = 1;
   $msg = 'successfully requested for withdrawal';
}
else
{
    $r = [];
    $status = 0;
   $msg = 'You do not have sufficient balance .please take less amount from your earned amount';

}

    if($request->ajax()) {
                   return response()->json(['status'=>$status,'data'=>$r,'msg'=>$msg]);
                } 
}

	public function getLatlngZone_id( $point ) {
		$id = 0;
		$zones = Zones::all(); 
		if( count( $zones ) ) {
			foreach( $zones as $zone ) {
				if( $zone->coordinate ) {
					$coordinate = unserialize( $zone->coordinate );
					$polygon = [];
					foreach( $coordinate as $coord ) {
						$new_coord = explode(",", $coord );
						$polygon[] = $new_coord;
					}
					
					if ( Helper::pointInPolygon($point, $polygon) ) {
						return $zone->id;
					}
				}
			}
		}		
		return $id;		
	}
}
