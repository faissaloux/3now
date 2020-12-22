<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use Hash;
use Storage;
use Setting;
use Exception;
use Carbon\Carbon;
use App\Http\Controllers\SendPushNotification;
use App\Helpers\Helper;
use App\Http\Controllers\ProviderResources\TripController;
use App\Models\{Chat,PushNotification,Card,Zones,User,Provider,Promocode,ServiceType,UserRequests,RequestFilter,PromocodeUsage,ProviderService,UserRequestRating,UserLocationType,UserComplaint,FareSetting,PeakAndNight,UserRequestPayment};
use Stripe\Charge;
use Stripe\Stripe;



if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}


class UserApiController extends Controller {


    public $Google_Api_Key  ;


    public function __construct(){
        $this->Google_Api_Key = 'AIzaSyAaCcYWO2ClnRd-ZSlDnW17Jh2jnBatCmg';
    }
   



    public function androidToken(Request $request){
            $user = \Auth::user();
            $user->android_token = $request->android_token;
            $user->save();


            return response()->json(['success'=> 'saved success']);
    }
   

    public function iosToken(Request $request){

        try {

            $user = \Auth::user();
            $user->ios_token = $request->ios_token;
            $user->save();
            return response()->json(['success'=> 'saved success']);

        } catch( Exception $e){
            return response()->json([ 'error' => $e->getMessage()]);
        }
            
    }
   






  
       public function tips(Request $request) {
            
            $data = [];
            $data['error'] = 'something went wrong';
            if(isset($request->request_id) and is_numeric($request->request_id) and isset($request->tips) and is_numeric($request->tips)){
                $UserRequest = UserRequests::find($request->request_id);
                $UserRequest->tips = $request->tips;
                $UserRequest->save();
                $data['error'] = '';
                $data['success'] = 'saved successfully';

                \Log::info('tips worked');
            }

            return response()->json($data);
       }



       public function coupon(Request $request){

        
        $coupon_helper = new \App\Helper\CouponHelper();
        $check = $coupon_helper->check($request->coupon);
       
        $valid = $check->valid;
            if($valid){
                $data['error'] = '';
                $data['success'] = 'coupon available';
                $data['discount'] = $check->discount_value;
                $data['discount_value'] = $check->discount_value;
                $data['discount_type'] = $check->discount_type;
                $data['maxDiscount'] = $check->maxDiscount;
            } else {
                $data['error'] = 'this coupon not exists';
                $data['success'] = '';
            }
        return response()->json($data);
    
    
          $coupon_used = strtolower($request->coupon); 
    
          $coupon = \DB::table('coupons')->where('user_id', \Auth::user()->id)->where('coupon', $request->coupon)->first();
    
        
          if(count($coupon) > 0 ){
    
            $data['error'] = 'this coupon already used';
            $data['success'] = '';
    
          }else {
                
              
            if(  $coupon_used == '3nowlaunch2020' || $coupon_used == '3now2020'  ) {
    
                $data['error'] = '';
                $data['success'] = 'coupon available';
                $data['discount'] = '5';
                } else {
                    $data['error'] = 'this coupon not exists';
                    $data['success'] = '';
                }
              
          }
    
          return response()->json($data);
    
    } 
          
          

    public function coupon2(Request $request){

        $verify = (new \App\Helper\CalculateHelper())->verifyCoupon($request->coupon);


        $data =  [];
        
        if($verify){
            $data['error'] = '';
            $data['success'] = 'coupon available';
            $data['discount'] = '5'; 
            return response()->json($data); 
        }
  
        $data['error'] = 'this coupon already used or does not exist';
        return response()->json($data); 
    } 
          


public function send_schedule_payment(Request $request){

        
        
        $Payment               = new UserRequestPayment;
        $Payment->request_id   = $request->request_id;
        $Payment->fixed        = $request->total_payment;
        $Payment->distance     = $request->distance;
        $Payment->payment_mode = $request->method;
        $Payment->total        = $request->total_payment;

        if($request->has('payment_id')){
            $Payment->payment_id = $request->payment_id;
        }

        $Payment->save();

           return response()->json(['success' => 'paied']);

        $UserRequest = UserRequests::with('user','payment','provider','service_type')->findOrFail($request->request_id);


          $user = [ 
                        'email'     =>  $UserRequest->user->email,
                        'name'      =>  $UserRequest->user->first_name,
                        'total_fee' =>  $UserRequest->payment->fixed,
                        'invoice_id'=>  $UserRequest->booking_id,
                        's_address' =>  $UserRequest->s_address,
                        'd_address' =>  $UserRequest->d_address,
                        'date'      =>  date('d-m-Y'),
                        'car'      =>   $UserRequest->service_type->name,
                        's_address'      =>   $UserRequest->s_address,
                        'd_address'      =>   $UserRequest->d_address,
            ];
    

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


	
    public function contactme() {
		return response()->json(['messgae' => 'success']);
    }

    public function paied() {
        return response()->json(['messgae' => 'paied']);
    }
	
	
    public function getRequest(Request $request){
       $request = UserRequests::find($request->request_id);
       return response()->json(['request' => $request]);
    }

	
    public function calculatePrice(Request $request) {
   
       $kilometer = $request->distance;

       if($request->service_type == '19'){
          $Total = ($kilometer * 1.25) + 25;
          $Total = round($Total, 2);
        }

        if($request->service_type == '27'){
            $Total = ($kilometer * 1.35) + 35;
            $Total = round($Total, 2);
        }

        if($request->service_type == '32'){
            $Total = ($kilometer * 1.40) + 40;
            $Total = round($Total, 2);
        }


        if($request->kindersitz > 1 ){
            $Total  += (($request->kindersitz * 5 ) - 5);
        }


        if($request->babyschale > 1 ){
            $Total  += (($request->babyschale * 10 ) - 10 );
        }
        

        if ($request->nameschield == 'true' ) {
            $Total  += 15;
        }

        return response()->json([ 'price' => $Total ]);
    }





    public function signup(Request $request){
        $this->validate($request, [
                'social_unique_id' => ['required_if:login_by,facebook,google','unique:users'],
                'device_type' => 'required|in:android,ios',
                'device_token' => 'required',
                'device_id' => 'required',
                'login_by' => 'required|in:manual,facebook,google',
                'first_name' => 'required|max:255',
                //'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'mobile' => 'required',
                'password' => 'required|min:6',
            ]);

        try{
            
            $User = $request->all();

            $User['payment_mode'] = 'CASH';
            $User['password'] = bcrypt($request->password);
            
            $r = User::where('mobile',$request->mobile)->count();
            if($r !== 0){
                return response()->json(['msg'=>'The mobile has already been taken.']);
            }
            $User['ios_token'] = $request['ios_token'] ?? '';
             $User['android_token'] = $request['android_token'] ?? '';
            $User = User::create($User);

            return $User;
        }   catch (Exception $e) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        try {
            User::where('id', $request->id)->update(['device_id'=> '', 'device_token' => '']);
            return response()->json(['message' => trans('api.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function change_password(Request $request){

        $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'old_password' => 'required',
            ]);

        $User = Auth::user();

        if(Hash::check($request->old_password, $User->password))
        {
            $User->password = bcrypt($request->password);
            $User->save();

            if($request->ajax()) {
                return response()->json(['message' => trans('api.user.password_updated')]);
            }else{
                return back()->with('flash_success', 'Password Updated');
            }

        } else {
            return response()->json(['error' => trans('api.user.incorrect_password')], 500);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function update_location(Request $request){

        $this->validate($request, [
                'latitude' => 'required',
                'longitude' => 'required',
            ]);

        if($user = User::find(Auth::user()->id)){

            $point[0] = $request->latitude;
            $point[1] = $request->longitude;
            $zone_id	=	$this->getLatlngZone_id($point);
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->zone_id =  $zone_id;
            $user->save();

            return response()->json(['message' => trans('api.user.location_updated')]);

        }else{

            return response()->json(['error' => trans('api.user.user_not_found')], 500);

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function details(Request $request){

        $this->validate($request, [
            'device_type' => 'in:android,ios',
        ]);

        try{

            if($user = User::find(Auth::user()->id)){

                if($request->has('device_token')){
                    $user->device_token = $request->device_token;
                }

                if($request->has('device_type')){
                    $user->device_type = $request->device_type;
                }

                if($request->has('device_id')){
                    $user->device_id = $request->device_id;
                }

                $user->save();

                $user->currency = Setting::get('currency');
                $user->sos = Setting::get('sos_number', '911');
                $user->card = Setting::get('CARD');
                $user->paypal = Setting::get('PAYPAL');
                $user->cash = Setting::get('CASH');
                $user['location'] = UserLocationType::where('user_id',Auth::user()->id)->get(); 
                return $user;

            }   else {
                return response()->json(['error' => trans('api.user.user_not_found')], 500);
            }
        }   catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }

    }

 

    public function update_profile(Request $request)
    {

        $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'max:255',
                'email' => 'email|unique:users,email,'.Auth::user()->id,
                
                'picture' => 'mimes:jpeg,bmp,png',
            ]);

         try {

            $user = User::findOrFail(Auth::user()->id);

            if($request->has('first_name')){ 
                $user->first_name = $request->first_name;
            }
            
            if($request->has('last_name')){
                $user->last_name = $request->last_name;
            }
            
            if($request->has('email')){
                $user->email = $request->email;
            }
        
            if($request->has('mobile')){
                $user->mobile = $request->mobile;
            }

            if ($request->picture != "") {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('user/profile');
            }

            $user->save();

            if($request->ajax()) {
                return response()->json($user);
            }else{
                return back()->with('flash_success', trans('api.user.profile_updated'));
            }
        }

        catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('api.user.user_not_found')], 500);
        }

    }

    

    public function services() {
        if($serviceList = ServiceType::all()) {
            return $serviceList;
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }
    }


 

    public function save_schedule(Request $request) {
	
	
		
        $this->validate( $request, [
            's_latitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
            'promo_code' => 'exists:promocodes,promo_code',
            'distance' => 'required|numeric',
            'use_wallet' => 'numeric',
            'payment_mode' => 'required|in:CASH,CARD,PAYPAL',
            'card_id' => ['required_if:payment_mode,CARD','exists:cards,card_id,user_id,'.Auth::user()->id],
        ]);

        

        $spoint[0]	=	$request->s_latitude; 
		$spoint[1]	=	$request->s_longitude;
		$dpoint[0]	=	$request->d_latitude; 
		$dpoint[1]	=	$request->d_longitude;
		$szone_id	=	$this->getLatlngZone_id($spoint);
		$dzone_id	=	$this->getLatlngZone_id($dpoint);
		
        


		$szones = Zones::select('status')->where('id',$szone_id)->where('status','active')->first();

		if(count($szones) > 0)
    	{
    	        $dzones = Zones::select('status')->where('id',$dzone_id)->where('status','active')->first();
        		if(count($dzones) > 0)
        		{
                        $ActiveRequests = UserRequests::PendingRequest(Auth::user()->id)->count();

                        if($ActiveRequests > 1) {
                            if($request->ajax()) {
                                return response()->json(['error' => trans('api.ride.request_inprogress')], 500);
                            } else {
                                return redirect('dashboard')->with('flash_error', 'Already request is in progress. Try again later.');
                            }
                        }
                
                    
                        if($request->has('schedule_date') && $request->has('schedule_time')){
                            $beforeschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->subHour(1);
                            $afterschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->addHour(1);
                
                            $CheckScheduling = UserRequests::where('status','SCHEDULED')
                                                ->where('user_id', Auth::user()->id)
                                                ->whereBetween('schedule_at',[$beforeschedule_time,$afterschedule_time])
                                                ->count();
                
                            if($CheckScheduling > 0){
                                if($request->ajax()) {
                                    return response()->json(['error' => trans('api.ride.request_scheduled')], 500);
                                }else{
                                    return redirect('dashboard')->with('flash_error', 'Already request is Scheduled on this time.');
                                }
                            }
                        }
                
                    
                    

                        $distance     = Setting::get('provider_search_radius', '10');
                        $latitude     = $request->s_latitude;
                        $longitude    = $request->s_longitude;
                        $service_type = $request->service_type;
                		$promo_code	  = $request->promo_code;
            
                 
                
                        try{
                
                            $details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".$this->Google_Api_Key;
                
                            $json = curl($details);

                
                            $details = json_decode($json, TRUE);
                
                            
                            $route_key  = $details['routes'][0]['overview_polyline']['points'];
                            $booking_id = Helper::generate_booking_id();
                            
                            $UserRequest = new UserRequests;
                            $UserRequest->booking_id = $booking_id;
                            $UserRequest->user_id = Auth::user()->id;
                            $UserRequest->provider_id = '289';
                            $UserRequest->current_provider_id = '289';
                            $UserRequest->service_type_id = $request->service_type;
                            $UserRequest->payment_mode = $request->payment_mode;
                		//	$UserRequest->promo_code =	$request->promo_code;
                            
                    $count = \DB::table('coupons')->where('user_id', Auth::user()->id)->whereIn('coupon', ['3nowlaunch2020','3now2020'])->count();

                    if($count == 0 ){
                        $UserRequest->promo_code =  $request->promo_code;
                    }
                          
                                
                                
                            $UserRequest->status = 'SCHEDULED';
                
                            $UserRequest->s_address = $request->s_address ? : "";
                            $UserRequest->d_address = $request->d_address ? : "";
                
                            $UserRequest->s_latitude = $request->s_latitude;
                            $UserRequest->s_longitude = $request->s_longitude;
                
                            $UserRequest->d_latitude = $request->d_latitude;
                            $UserRequest->d_longitude = $request->d_longitude;
                            $UserRequest->distance = $request->distance;

                            $UserRequest->kindersitz  = $request->kindersitz;
                            $UserRequest->babyschale  = $request->babyschale;
                            $UserRequest->nameschield = $request->nameschield;
                            $UserRequest->note        = $request->note;
                


                            if(Auth::user()->wallet_balance > 0) {
                                $UserRequest->use_wallet = $request->use_wallet ? : 0;
                            }
                
                            $UserRequest->assigned_at = Carbon::now();
                            $UserRequest->route_key = $route_key;
                
                            
                            
                            if($request->has('schedule_date') && $request->has('schedule_time')){
                                $UserRequest->schedule_at = date("Y-m-d H:i:s",strtotime("$request->schedule_date $request->schedule_time"));
                            }
                           
                            $UserRequest->save();
                            
                            User::where('id',Auth::user()->id)->update(['payment_mode' => $request->payment_mode]);
                
                            if($request->has('card_id'))    {
                
                                Card::where('user_id',Auth::user()->id)->update(['is_default' => 0]);
                                Card::where('card_id',$request->card_id)->update(['is_default' => 1]);
                            }
                                            
                            $kilometer = $request->distance;

                           if($request->service_type == '19'){
                              $khla = ($kilometer * 1.25) + 25;
                              $khla = round($khla, 2);


                            if($khla > 0  && $khla < 5  ){
                                $khla = 5;
                            }
                            
                            }

                            if($request->service_type == '27'){
                                $khla = ($kilometer * 1.35) + 35;
                                $khla = round($khla, 2);
                            }

                            if($request->service_type == '32'){
                                $khla = ($kilometer * 1.40) + 40;
                                $khla = round($khla, 2);
                            }


                            
                            if($request->kindersitz > 1 ){
                                $khla  += (($request->kindersitz * 5 ) - 5);
                            }


                            if($request->babyschale > 1 ){
                             $khla  += (($request->babyschale * 10 ) - 10 );
                            }


                            if ($request->nameschield == 'true' ) {
                                $khla  += 15;
                            }


                            $UserRequest->total = $khla;
                            $UserRequest->save();




                            if($request->ajax()) {  


                                 $user = [ 
                                    'email'     =>  $UserRequest->user->email,
                                    'name'      =>  $UserRequest->user->first_name,
                                    'total_fee' =>  $UserRequest->total ,
                                    'invoice_id'=>  $UserRequest->booking_id,
                                    's_address' =>  $UserRequest->s_address,
                                    'd_address' =>  $UserRequest->d_address,
                                    'date'      =>  date('d-m-Y'),
                                    'car'      =>   $UserRequest->service_type->name,
                                    's_address'      =>   $UserRequest->s_address,
                                    'd_address'      =>   $UserRequest->d_address,
                                ];


                               // dd($user);

                                    $url = 'https://api.elasticemail.com/v2/email/send';
                                    try{
                                            $post = array('from' => 'contact@3now.de',
                                            'fromName' => '3now',
                                            'apikey' => '9ECAE3B0E7E28B94621D30D634B0238ACC12BE45DA5CC17DEC385C99EE08C9212403CDE46FE482701696293D221895D8',
                                            'subject' => 'Buchungsbestätigung',
                                            'to' => $user['email'],
                                            'bodyHtml' => view("emails.invoice_scheudle_website", ['user' => $user,'full_order' => $UserRequest]),
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

                                           // print_r($result);

                                    }
                                    catch(Exception $ex){
                                        echo $ex->getMessage();
                                      //  dd($ex->getMessage());
                                    }


                                return response()->json([
                                        'message' => 'New request Created!',
                                        'request_id' => $UserRequest->id,
                                        'price' => $khla,
                                    ]);
                            }else {
                                
                                return redirect('dashboard');
                            }
                
                        }   catch (Exception $e) {
                            
                            if($request->ajax()) {
                              
                                return response()->json(['error' => $e->getMessage() ], 500);
                            }else{
                                return back()->with('flash_error', 'Something went wrong while sending request. Please try again.');
                            }
                        } 
        		}   else{
        		    return response()->json(['error' => 'Sorry in this Destination location,We can not provide service.'], 200);
        		}
    	}   else{
    		    return response()->json(['error' => 'Sorry in this Source location,We can not provide service.'], 200);
    	}
    }







  public function invoice($request_id)
    {




        try {
            $UserRequest = UserRequests::findOrFail($request_id);
            $tax_percentage = Setting::get('tax_percentage',10);
            $commission_percentage = Setting::get('commission_percentage',10);
            $service_type = ServiceType::findOrFail($UserRequest->service_type_id);
            
            $kilometer = $UserRequest->distance;
            $Fixed = ($service_type->fixed > 5 ) ? $service_type->fixed : 5 ;
            $Distance = 0;
            $minutes = 0;
            $Discount = 0; // Promo Code discounts should be added here.
            $Wallet = 0;
            $Surge = 0;





            $trip_started_time      =   strtotime($UserRequest->started_at);
            $trip_finished_time     =   strtotime($UserRequest->finished_at);
            $trip_time_in_minute    =   round( ( $trip_finished_time - $trip_started_time ) / 60, 2 );
            
            $minutes = $trip_time_in_minute;

            if($service_type->calculator == 'MIN') {
                $Distance = $service_type->minute * $minutes;
                
            } else if($service_type->calculator == 'HOUR') {
                $Distance = $service_type->minute * round( $minutes / 60, 2 );
                
            } else if($service_type->calculator == 'DISTANCE') {
                $Distance = ($kilometer - $service_type->distance )  * $service_type->price;
                
            } else if($service_type->calculator == 'DISTANCEMIN') {
                $Distance = ( ( $kilometer - $service_type->distance ) * $service_type->price) + ($service_type->minute * $minutes);
                
            } else if($service_type->calculator == 'DISTANCEHOUR') {
                $Distance = ( ( $kilometer - $service_type->distance ) * $service_type->price) + ($service_type->minute * round(  $minutes / 60, 2 ) );
                
            } else {
                $Distance =  ( $kilometer - $service_type->distance )  * $service_type->price;
            }

            if($PromocodeUsage = PromocodeUsage::where('user_id',$UserRequest->user_id)->where('status','ADDED')->orderBy('id', 'DESC')->first()){
                if($Promocode  = Promocode::find($PromocodeUsage->promocode_id)){
                    $Discount  = $Promocode->discount;
                    $PromocodeUsage->status = 'USED';
                    $PromocodeUsage->save();
                }
            }

            /*$Commision = ($Distance + $Fixed) * ( $commission_percentage/100 );
            $Tax = ($Distance + $Fixed) * ( $tax_percentage/100 );
            $Total = $Fixed + $Distance + $Commision + $Tax - $Discount;
            // $Total = $Fixed + $Commision + $Tax - $Discount;

            if($UserRequest->surge){
                $Surge = (Setting::get('surge_percentage')/100) * $Total;
                $Total += $Surge;
            }*/
            



            $calculatefare = $Distance + $Fixed;
            $Commision     = $calculatefare * ( $commission_percentage/100 );
            $finalfare     = $calculatefare - $Discount;
            $Tax           = $calculatefare * ($tax_percentage/100);
            $Total         = $Commision + $finalfare + $Tax;
            
            if($UserRequest->surge){
                $Surge = (Setting::get('surge_percentage')/100) * $Total;
                $Total += $Surge;
            }
            








               if($service_type->service_type == '19'){
                  $khla = ($kilometer * 1.25) + 25;
                  $khla = round($khla, 2);

                    if($khla > 0  && $khla < 5  ){
                        $khla = 5;
                    }
                }

                if($service_type->service_type == '27'){
                    $khla = ($kilometer * 1.35) + 35;
                    $khla = round($khla, 2);
                }

                if($service_type->service_type == '32'){
                    $khla = ($kilometer * 1.40) + 40;
                    $khla = round($khla, 2);
                }
                  
    
                if($UserRequest->kindersitz > 1 ){
                    $khla  += ($request->kindersitz * 5 );
                }

                if($UserRequest->babyschale > 1 ){
                    $khla  += ($request->babyschale * 10 );
                }
                
                if ($UserRequest->nameschield == 'true' ) {
                    $khla  += 15;
                }



        	//return response()->json(['error' =>'here again 4' .$khla]);

              $Total = $khla;




            if($Total < 0){
                $Total = 0.00; // prevent from negative value
            }

            $Payment = new UserRequestPayment;
            $Payment->request_id = $UserRequest->id;
            $Payment->fixed = $Fixed;
            $Payment->distance = $Distance;
            $Payment->commision = $Commision;
            $Payment->surge = $Surge;
            if($Discount != 0 && $PromocodeUsage){
                $Payment->promocode_id = $PromocodeUsage->promocode_id;
            }
            $Payment->discount = $Discount;

            if($UserRequest->use_wallet == 1 && $Total > 0){

                $User = User::find($UserRequest->user_id);

                $Wallet = $User->wallet_balance;

                if($Wallet != 0){

                    if($Total > $Wallet) {

                        $Payment->wallet = $Wallet;
                        $Payable = $Total - $Wallet;
                        User::where('id',$UserRequest->user_id)->update(['wallet_balance' => 0 ]);
                        $Payment->total = abs($Payable);

                        // charged wallet money push 
                        (new SendPushNotification)->ChargedWalletMoney($UserRequest->user_id,currency($Wallet));

                    } else {

                        $Payment->total = 0;
                        $WalletBalance = $Wallet - $Total;
                        User::where('id',$UserRequest->user_id)->update(['wallet_balance' => $WalletBalance]);
                        $Payment->wallet = $Total;
                        
                        $Payment->payment_id = 'WALLET';
                        $Payment->payment_mode = $UserRequest->payment_mode;
                        $Payment->paid = 1;

                        $UserRequest->paid = 1;
                        $UserRequest->status = 'COMPLETED';
                        $UserRequest->save();

                        // charged wallet money push 
                        (new SendPushNotification)->ChargedWalletMoney($UserRequest->user_id,currency($Total));
                    }
                }

            } else {
                $Payment->total = abs($Total);
            }

            $Payment->tax = $Tax;
            $Payment->save();




                        $StripeCharge = $Payment->total * 100;

                            $Card = Card::where('user_id',Auth::user()->id)->where('is_default',1)->first();

                            Stripe::setApiKey(Setting::get('stripe_secret_key'));

                            $Charge = Charge::create(array(
                                  "amount" => $StripeCharge,
                                  "currency" => "usd",
                                  "customer" => Auth::user()->stripe_cust_id,
                                  "card" => $Card->card_id,
                                  "description" => "Payment Charge for ".Auth::user()->email,
                                  "receipt_email" => Auth::user()->email
                                ));

                             $Payment->payment_id = $Charge["id"];
                             $Payment->payment_mode = 'CARD';
                             $Payment->save();

                            $UserRequest->paid = 1;
                            $UserRequest->save();

           
        return $Payment;





        } catch (ModelNotFoundException $e) {



        	return response()->json(['error' =>'not']);
            return false;
        }
    }



  public function invoice_new($request_id)
    {




        try {
            $UserRequest = UserRequests::findOrFail($request_id);
            $tax_percentage = Setting::get('tax_percentage',10);
            $commission_percentage = Setting::get('commission_percentage',10);
            $service_type = ServiceType::findOrFail($UserRequest->service_type_id);
            
            $kilometer = $UserRequest->distance;
            $Fixed = ($service_type->fixed > 5 ) ? $service_type->fixed : 5 ;
            $Distance = 0;
            $minutes = 0;
            $Discount = 0; // Promo Code discounts should be added here.
            $Wallet = 0;
            $Surge = 0;





            $trip_started_time      =   strtotime($UserRequest->started_at);
            $trip_finished_time     =   strtotime($UserRequest->finished_at);
            $trip_time_in_minute    =   round( ( $trip_finished_time - $trip_started_time ) / 60, 2 );
            
            $minutes = $trip_time_in_minute;

            if($service_type->calculator == 'MIN') {
                $Distance = $service_type->minute * $minutes;
                
            } else if($service_type->calculator == 'HOUR') {
                $Distance = $service_type->minute * round( $minutes / 60, 2 );
                
            } else if($service_type->calculator == 'DISTANCE') {
                $Distance = ($kilometer - $service_type->distance )  * $service_type->price;
                
            } else if($service_type->calculator == 'DISTANCEMIN') {
                $Distance = ( ( $kilometer - $service_type->distance ) * $service_type->price) + ($service_type->minute * $minutes);
                
            } else if($service_type->calculator == 'DISTANCEHOUR') {
                $Distance = ( ( $kilometer - $service_type->distance ) * $service_type->price) + ($service_type->minute * round(  $minutes / 60, 2 ) );
                
            } else {
                $Distance =  ( $kilometer - $service_type->distance )  * $service_type->price;
            }

            if($PromocodeUsage = PromocodeUsage::where('user_id',$UserRequest->user_id)->where('status','ADDED')->orderBy('id', 'DESC')->first()){
                if($Promocode  = Promocode::find($PromocodeUsage->promocode_id)){
                    $Discount  = $Promocode->discount;
                    $PromocodeUsage->status = 'USED';
                    $PromocodeUsage->save();
                }
            }

            /*$Commision = ($Distance + $Fixed) * ( $commission_percentage/100 );
            $Tax = ($Distance + $Fixed) * ( $tax_percentage/100 );
            $Total = $Fixed + $Distance + $Commision + $Tax - $Discount;
            // $Total = $Fixed + $Commision + $Tax - $Discount;

            if($UserRequest->surge){
                $Surge = (Setting::get('surge_percentage')/100) * $Total;
                $Total += $Surge;
            }*/
            



            $calculatefare = $Distance + $Fixed;
            $Commision     = $calculatefare * ( $commission_percentage/100 );
            $finalfare     = $calculatefare - $Discount;
            $Tax           = $calculatefare * ($tax_percentage/100);
            $Total         = $Commision + $finalfare + $Tax;
            
            if($UserRequest->surge){
                $Surge = (Setting::get('surge_percentage')/100) * $Total;
                $Total += $Surge;
            }
            








               if($service_type->service_type == '19'){
                  $khla = ($kilometer * 1.25) + 25;
                  $khla = round($khla, 2);

                    if($khla > 0  && $khla < 5  ){
                        $khla = 5;
                    }
                }

                if($service_type->service_type == '27'){
                    $khla = ($kilometer * 1.35) + 35;
                    $khla = round($khla, 2);
                }

                if($service_type->service_type == '32'){
                    $khla = ($kilometer * 1.40) + 40;
                    $khla = round($khla, 2);
                }
                  
    
                if($UserRequest->kindersitz > 1 ){
                    $khla  += ($request->kindersitz * 5 );
                }

                if($UserRequest->babyschale > 1 ){
                    $khla  += ($request->babyschale * 10 );
                }
                
                if ($UserRequest->nameschield == 'true' ) {
                    $khla  += 15;
                }



        	//return response()->json(['error' =>'here again 4' .$khla]);

              $Total = $khla;




            if($Total < 0){
                $Total = 0.00; // prevent from negative value
            }

            $Payment = new UserRequestPayment;
            $Payment->request_id = $UserRequest->id;
            $Payment->fixed = $Fixed;
            $Payment->distance = $Distance;
            $Payment->commision = $Commision;
            $Payment->surge = $Surge;
            if($Discount != 0 && $PromocodeUsage){
                $Payment->promocode_id = $PromocodeUsage->promocode_id;
            }
            $Payment->discount = $Discount;

            if($UserRequest->use_wallet == 1 && $Total > 0){

                $User = User::find($UserRequest->user_id);

                $Wallet = $User->wallet_balance;

                if($Wallet != 0){

                    if($Total > $Wallet) {

                        $Payment->wallet = $Wallet;
                        $Payable = $Total - $Wallet;
                        User::where('id',$UserRequest->user_id)->update(['wallet_balance' => 0 ]);
                        $Payment->total = abs($Payable);

                        // charged wallet money push 
                        (new SendPushNotification)->ChargedWalletMoney($UserRequest->user_id,currency($Wallet));

                    } else {

                        $Payment->total = 0;
                        $WalletBalance = $Wallet - $Total;
                        User::where('id',$UserRequest->user_id)->update(['wallet_balance' => $WalletBalance]);
                        $Payment->wallet = $Total;
                        
                        $Payment->payment_id = 'WALLET';
                        $Payment->payment_mode = $UserRequest->payment_mode;
                        $Payment->paid = 1;

                        $UserRequest->paid = 1;
                        $UserRequest->status = 'COMPLETED';
                        $UserRequest->save();

                        // charged wallet money push 
                        (new SendPushNotification)->ChargedWalletMoney($UserRequest->user_id,currency($Total));
                    }
                }

            } else {
                $Payment->total = abs($Total);
            }

            $Payment->tax = $Tax;
            $Payment->save();




                        $StripeCharge = $Payment->total * 100;

                            $Card = Card::where('user_id',Auth::user()->id)->where('is_default',1)->first();

                            Stripe::setApiKey(Setting::get('stripe_secret_key'));

                            $Charge = Charge::create(array(
                                  "amount" => $StripeCharge,
                                  "currency" => "usd",
                                  "customer" => Auth::user()->stripe_cust_id,
                                  "card" => $Card->card_id,
                                  "description" => "Payment Charge for ".Auth::user()->email,
                                  "receipt_email" => Auth::user()->email
                                ));

                             $Payment->payment_id = $Charge["id"];
                             $Payment->payment_mode = 'CARD';
                             $Payment->save();

                            $UserRequest->paid = 1;
                            $UserRequest->save();

            /*$deletedDuplicatePayment = UserRequestPayment::where('request_id',$Payment->request->id)->orderBy('id','DESC')->take(1);
            $deletedDuplicatePayment->delete();*/
            
        return $Payment;





        } catch (ModelNotFoundException $e) {



        	return response()->json(['error' =>'not']);
            return false;
        }
    }







    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function cancel_request(Request $request) {

        // $this->validate($request, [
        //     'request_id' => 'required|numeric|exists:user_requests,id,user_id,'.Auth::user()->id,
        // ]);
        $this->validate($request, [
            'request_id' => 'required|numeric',
        ]);
        try{

            $UserRequest = UserRequests::findOrFail($request->request_id);



            $pa = UserRequestPayment::where('request_id',$UserRequest->id)->first();
            if($pa){
                $pa->total = 0;
                $pa->fixed = 0;
                $pa->save();
            }




            if($UserRequest->status == 'CANCELLED')
            {
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_cancelled')], 500); 
                }   else{
                    return back()->with('flash_error', 'Request is Already Cancelled!');
                }
            }
            /*if($UserRequest->status != 'SEARCHING')
            {
                (new SendPushNotification)->UserCancellRide($UserRequest);
            }*/
            
            if(in_array($UserRequest->status, ['SEARCHING','STARTED','ARRIVED','SCHEDULED'])) {

                if($UserRequest->status != 'SEARCHING'){
                    $this->validate($request, [
                        'cancel_reason'=> 'max:255',
                    ]);
                }

                $UserRequest->status = 'CANCELLED';
                $UserRequest->cancel_reason = $request->cancel_reason;
                $UserRequest->cancelled_by = 'USER';
                            $UserRequest->total = 0 ;

                $UserRequest->save();

                RequestFilter::where('request_id', $UserRequest->id)->delete();

                if($UserRequest->status != 'SCHEDULED') {

                    if($UserRequest->provider_id != 0)  {

                        ProviderService::where('provider_id',$UserRequest->provider_id)->update(['status' => 'active']);

                    }
                }

                // Send Push Notification to User
                
                (new SendPushNotification)->UserCancellRide2($UserRequest);

                if($request->ajax()) {
                    return response()->json(['message' => trans('api.ride.ride_cancelled')]); 
                }   else{
                    return redirect('dashboard')->with('flash_success','Request Cancelled Successfully');
                }

            }   else {
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_onride')], 500); 
                }else{
                    return back()->with('flash_error', 'Service Already Started!');
                }
            }
        }

        catch (ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }else{
                return back()->with('flash_error', 'No Request Found!');
            }
        }

    }



    public function getCurrentTrips() {
        try{
			
            $UserRequests = UserRequests::UserOngoingTrips(Auth::user()->id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".$this->Google_Api_Key;
                }
            }
			
            return $UserRequests;
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage() ]);
        }
    }







    public function currentProdiverLocation(Request $request) {


        $provider = UserRequests::find($request->request_id)->provider;

        return response()->json(['provider' => $provider ]);

       


    }

























    /**
     * Show the request status check.
     *
     * @return \Illuminate\Http\Response
     */

    public function request_status_check() {
    
        try{

            $check_status = ['CANCELLED', 'SCHEDULED'];

            $UserRequests = UserRequests::UserRequestStatusCheck(Auth::user()->id, $check_status)->get()->toArray();
    
            $search_status = ['SEARCHING','SCHEDULED'];

            $UserRequestsFilter = UserRequests::UserRequestAssignProvider(Auth::user()->id,$search_status)->get(); 

            $Timeout = Setting::get('provider_select_timeout', 180);
            if(!empty($UserRequestsFilter)){
                for ($i=0; $i < sizeof($UserRequestsFilter); $i++) {
                    $ExpiredTime = $Timeout - (time() - strtotime($UserRequestsFilter[$i]->assigned_at));
                    if($UserRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime < 0) {
                        $Providertrip = new TripController();
                        $Providertrip->assign_next_provider($UserRequestsFilter[$i]->id);
                    }else if($UserRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime > 0){
                        break;
                    }
                }
            }
            return response()->json(['data' => $UserRequests]);
            
        }   catch (Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function rate_provider(Request $request) {

        $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id,user_id,'.Auth::user()->id,
                'rating' => 'required|integer|in:1,2,3,4,5',
                'comment' => 'max:255',
            ]);
    
        $UserRequests = UserRequests::where('id' ,$request->request_id)
                ->where('status' ,'COMPLETED')
                //->where('paid', 1)
                ->where('paid', 0)
                ->first();
        
        if ($UserRequests) {
            if($request->ajax()){
                return response()->json(['error' => trans('api.user.not_paid')], 500);
            } else {
                return back()->with('flash_error', 'Service Already Started!');
            }
        }

        try{

            $UserRequest = UserRequests::findOrFail($request->request_id);
            $review = UserRequestRating::where('request_id',$request->request_id)->count();
            
            if($review==0) {
                UserRequestRating::create([
                    'provider_id' => $UserRequest->provider_id,
                    'user_id' => $UserRequest->user_id,
                    'request_id' => $UserRequest->id,
                    'user_rating' => $request->rating,
                    'user_comment' => $request->comment,
                ]);
            } else {
                $UserRequest->rating->update([
                    'user_rating' => $request->rating,
                    'user_comment' => $request->comment,
                ]);
            }
          

            $UserRequest->user_rated = 1;
            $UserRequest->save();
            
            $average = UserRequestRating::where('provider_id', $UserRequest->provider_id)->avg('user_rating');
            if($average='null')
            {
                $average=0;
            } 
            Provider::where('id',$UserRequest->provider_id)->update(['rating' => $average]);

            // Send Push Notification to Provider 
            if($request->ajax()){
                return response()->json(['message' => trans('api.ride.provider_rated')]); 
            }else{
                return redirect('dashboard')->with('flash_success', 'Driver Rated Successfully!');
            }
        }   catch (Exception $e) {
                if($request->ajax()){
                    return response()->json(['error' => trans('api.something_went_wrong')], 500);
                }else{
                    return back()->with('flash_error', 'Something went wrong');
                }
        }

    } 

    public function check_rate_provider(Request $request) {
	     
	     $data = UserRequests::select('id as request_id','paid','user_rated','provider_id')->where('user_id',Auth::user()->id)->where('status','COMPLETED')->orderBy('id','desc')->first();
         if($data){

	           $data->user_name = Auth::user()->first_name;
	           $data->provider_name = Provider::where('id',$data->provider_id)->value('first_name');
	           $data->provider_picture = Provider::where('id',$data->provider_id)->value('avatar');
         }
	     
	     return $data;
	 }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function trips() {
    
        try{
            $UserRequests = UserRequests::UserTrips(Auth::user()->id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x191919|weight:3|enc:".$value->route_key.
                            "&key=".$this->Google_Api_Key;
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */



    public function estimated_fare_new(Request $request) {
        
        $this->validate($request,[
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
        ]);

        try{

            $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$request->s_latitude.",".$request->s_longitude."&destinations=".$request->d_latitude.",".$request->d_longitude."&mode=driving&sensor=false&key=".$this->Google_Api_Key;

            $json = curl($details);

            $details = json_decode($json, TRUE);

            @$meter = $details['rows'][0]['elements'][0]['distance']['value'];
            @$time = $details['rows'][0]['elements'][0]['duration']['text'];
            @$seconds = $details['rows'][0]['elements'][0]['duration']['value'];

            @$kilometer = round($meter/1000);
            @$minutes = round($seconds/60);

            

            $tax_percentage = Setting::get('tax_percentage');
            $currency = Setting::get('currency');
            $commission_percentage = Setting::get('commission_percentage');
            $service_type = ServiceType::findOrFail($request->service_type);
			$total_discount = 0;
            $price = $service_type->fixed;
            $currentDay = date('l');
            $Time  = Carbon::now(env('APP_TIMEZONE'));
            $booking_time = $Time->toTimeString();
            //return $service_type;exit;

            
            // condition
      
		    $fareSetting = FareSetting::where('from_km','<=',round($kilometer,0))
		    	->where('upto_km','>=',round($kilometer,0))
		    	//->where('peak_hour','YES')
		   		->where('status',1)
		     	->orderBy('id','DESC')
		     	->first();
		    if(!empty($fareSetting)){
		    	$peakAndNight  = new PeakAndNight;
		    	$peakAndNight = $peakAndNight->where('start_time','<=',$booking_time)
		    	->where('end_time','>=',$booking_time)
		    	->where('status',1);
		    	if($fareSetting->peak_hour=='YES' && $fareSetting->late_night=='YES'){
		    		$peakAndNight = $peakAndNight->where(function($q) use($currentDay){
		    			$q->where('day',$currentDay)
		    			  ->orWhere('day',null);
		    		});

		    	}else{
		    		$peakAndNight = $peakAndNight->where(['day'=>$currentDay]);	
		    	}
		    	$peakAndNight = $peakAndNight->where('fare_setting_id',$fareSetting->id);
		    	$peakAndNight = $peakAndNight->orderBy('id','DESC')
		    	->first();
		    
		    	if(!empty($peakAndNight)){

		    		$amount = (($service_type->fixed+($kilometer*$fareSetting->price_per_km))*1); //double price on two way ride
		    		$extra_tax_price = ( $peakAndNight->fare_in_percentage/100 ) * $amount;
		    		$amount = $amount + $extra_tax_price;
		    		$tax_price = ( $tax_percentage/100 ) * $amount;
		    		$total = $amount+$tax_price;	
		    	}else{
		    			// fare setting applied without peak day and time
		    			$amount = (($service_type->fixed+($kilometer*$fareSetting->price_per_km))*1); //double price on two way ride
		    			$tax_price = ( $tax_percentage/100 ) * $amount;
		    			$total = $amount+$tax_price;
		    	         
		    	}
		    } else{
				// else condition
	            if($service_type->calculator == 'MIN') {
	                $price += $service_type->minute * $minutes;
	            } else if($service_type->calculator == 'HOUR') {
	                $price += $service_type->minute * 60;
	            } else if($service_type->calculator == 'DISTANCE') {
	                $price += ($kilometer * $service_type->price);
	            } else if($service_type->calculator == 'DISTANCEMIN') {
	                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes);
	            } else if($service_type->calculator == 'DISTANCEHOUR') {
	                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes * 60);
	            } else {
	                $price += ($kilometer * $service_type->price);
	            }
	            $tax_price = ( $tax_percentage/100 ) * $price;
	            $total = $price + $tax_price;
				//
		    }		
      /////////////////////////////////////////////////////////////////////////////////////////////
			//sid
			if ( $request->has('promo_code') ) {
				// Apply  promo code
				if($promo_code =  Promocode::where('promo_code', $request->promo_code)->first() ) {
					$total_discount =  ($total * $promo_code->discount)/100;
					$total = $total - $total_discount; 
				}
			}
		
            $ActiveProviders = ProviderService::AvailableServiceProvider($request->service_type)->get()->pluck('provider_id');

            $distance = Setting::get('provider_search_radius', '10');
            $latitude = $request->s_latitude;
            $longitude = $request->s_longitude;

            $Providers = Provider::whereIn('id', $ActiveProviders)
                ->where('status', 'approved')
                ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                ->get();

            $surge = 0;
            
            // if($Providers->count() <= Setting::get('surge_trigger') && $Providers->count() > 0){
            //     $surge_price = (Setting::get('surge_percentage')/100) * $total;
            //     $total += $surge_price;
            //     $surge = 1;
            // }
            


            $here = bcdiv($total,1,2);



               if($request->service_type == '19'){
                  $khla = ($kilometer * 1.2) + 2.10;
                  $khla = round($khla, 2);

                    if($khla > 0  && $khla < 5  ){
                        $price_19 = 5;
                    }
                }

                if($request->service_type == '27'){
                    $khla = ($kilometer * 1.2) + 7.10;
                    $price_27 = round($khla, 2);
                }

                if($request->service_type == '32'){
                    $khla = ($kilometer * 1.3) + 17;
                    $khla = round($khla, 2);
                }


	            $prices = [
	            	'19'  => $price_19 , 
	            	'27'  => $price_27 , 
	            	'32'  => $price_32 , 
	            ];
	            

                return response()->json([

                    'estimated_fare' => $prices, 
                    'distance' => $kilometer,
                    'time' => $time,
                    'tax_price' => bcdiv($tax_price,1,2),
                    'base_price' => $service_type->fixed,
                    'wallet_balance' => Auth::user()->wallet_balance,
                    'discount'      => bcdiv($total_discount,1,2),
                    'currency'   => $currency 
                ]);

        } catch(Exception $e) {
        	return $e;
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }



    public function estimated_fare(Request $request) {
        

        $this->validate($request,[
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
        ]);

        try{

            $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$request->s_latitude.",".$request->s_longitude."&destinations=".$request->d_latitude.",".$request->d_longitude."&mode=driving&sensor=false&key=".$this->Google_Api_Key;




            $json = curl($details);




            $details = json_decode($json, TRUE);

  


            @$meter = $details['rows'][0]['elements'][0]['distance']['value'];
            @$time = $details['rows'][0]['elements'][0]['duration']['text'];
            @$seconds = $details['rows'][0]['elements'][0]['duration']['value'];

            @$kilometer = round($meter/1000);
            @$minutes = round($seconds/60);

            

            $tax_percentage = Setting::get('tax_percentage');
            $currency = Setting::get('currency');
            $commission_percentage = Setting::get('commission_percentage');
            $service_type = ServiceType::findOrFail($request->service_type);
			$total_discount = 0;
            $price = $service_type->fixed;
            $currentDay = date('l');
            $Time  = Carbon::now(env('APP_TIMEZONE'));
            $booking_time = $Time->toTimeString();
            //return $service_type;exit;

            
            // condition
      
		    $fareSetting = FareSetting::where('from_km','<=',round($kilometer,0))
		    	->where('upto_km','>=',round($kilometer,0))
		    	//->where('peak_hour','YES')
		   		->where('status',1)
		     	->orderBy('id','DESC')
		     	->first();
		    if(!empty($fareSetting)){
		    	$peakAndNight  = new PeakAndNight;
		    	$peakAndNight = $peakAndNight->where('start_time','<=',$booking_time)
		    	->where('end_time','>=',$booking_time)
		    	->where('status',1);
		    	if($fareSetting->peak_hour=='YES' && $fareSetting->late_night=='YES'){
		    		$peakAndNight = $peakAndNight->where(function($q) use($currentDay){
		    			$q->where('day',$currentDay)
		    			  ->orWhere('day',null);
		    		});

		    	}else{
		    		$peakAndNight = $peakAndNight->where(['day'=>$currentDay]);	
		    	}
		    	$peakAndNight = $peakAndNight->where('fare_setting_id',$fareSetting->id);
		    	$peakAndNight = $peakAndNight->orderBy('id','DESC')
		    	->first();
		    
		    	if(!empty($peakAndNight)){

		    		$amount = (($service_type->fixed+($kilometer*$fareSetting->price_per_km))*1); //double price on two way ride
		    		$extra_tax_price = ( $peakAndNight->fare_in_percentage/100 ) * $amount;
		    		$amount = $amount + $extra_tax_price;
		    		$tax_price = ( $tax_percentage/100 ) * $amount;
		    		$total = $amount+$tax_price;	
		    	}else{
		    			// fare setting applied without peak day and time
		    			$amount = (($service_type->fixed+($kilometer*$fareSetting->price_per_km))*1); //double price on two way ride
		    			$tax_price = ( $tax_percentage/100 ) * $amount;
		    			$total = $amount+$tax_price;
		    	         
		    	}
		    } else{
				// else condition
	            if($service_type->calculator == 'MIN') {
	                $price += $service_type->minute * $minutes;
	            } else if($service_type->calculator == 'HOUR') {
	                $price += $service_type->minute * 60;
	            } else if($service_type->calculator == 'DISTANCE') {
	                $price += ($kilometer * $service_type->price);
	            } else if($service_type->calculator == 'DISTANCEMIN') {
	                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes);
	            } else if($service_type->calculator == 'DISTANCEHOUR') {
	                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes * 60);
	            } else {
	                $price += ($kilometer * $service_type->price);
	            }
	            $tax_price = ( $tax_percentage/100 ) * $price;
	            $total = $price + $tax_price;
				//
		    }		
      /////////////////////////////////////////////////////////////////////////////////////////////
			//sid
			if ( $request->has('promo_code') ) {
				// Apply  promo code
				if($promo_code =  Promocode::where('promo_code', $request->promo_code)->first() ) {
					$total_discount =  ($total * $promo_code->discount)/100;
					$total = $total - $total_discount; 
				}
			}
		
            $ActiveProviders = ProviderService::AvailableServiceProvider($request->service_type)->get()->pluck('provider_id');

            $distance = Setting::get('provider_search_radius', '10');
            $latitude = $request->s_latitude;
            $longitude = $request->s_longitude;

            $Providers = Provider::whereIn('id', $ActiveProviders)
                ->where('status', 'approved')
                ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                ->get();

            $surge = 0;
            
            // if($Providers->count() <= Setting::get('surge_trigger') && $Providers->count() > 0){
            //     $surge_price = (Setting::get('surge_percentage')/100) * $total;
            //     $total += $surge_price;
            //     $surge = 1;
            // }
            


            $here = bcdiv($total,1,2);


            if($request->when == 'now' or !isset($request->when) ) {

               if($request->service_type == '19'){
                  $khla = ($kilometer * 1.2) + 2.10;
                  $khla = round($khla, 2);

                    if($khla > 0  && $khla < 5  ){
                        $khla = 5;
                    }
                }

                if($request->service_type == '27'){
                    $khla = ($kilometer * 1.2) + 7.10;
                    $khla = round($khla, 2);
                }

                if($request->service_type == '32'){
                    $khla = ($kilometer * 1.3) + 17;
                    $khla = round($khla, 2);
                }

            }

            

            if($request->when == 'later') {

               if($request->service_type == '19'){
                  $khla = ($kilometer * 1.25) + 25;
                  $khla = round($khla, 2);
                }

                if($request->service_type == '27'){
                    $khla = ($kilometer * 1.35) + 35;
                    $khla = round($khla, 2);
                }

                if($request->service_type == '32'){
                    $khla = ($kilometer * 1.40) + 40;
                    $khla = round($khla, 2);
                }
            }         
            


            return response()->json([
                    'estimated_fare' => $khla, 
                    'distance' => $kilometer,
                    'time' => $time,
                    //'surge' => $surge,
                   // 'surge_value' => '1.4X',
                    'tax_price' => bcdiv($tax_price,1,2),
                    'base_price' => $service_type->fixed,
                    'wallet_balance' => Auth::user()->wallet_balance,
                    'discount'      => bcdiv($total_discount,1,2),
                    'currency'   => $currency,
                    'service_type' =>$request->service_type
                ]);

        } catch(Exception $e) {
        	return $e;
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function trip_details(Request $request) {

         $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
            ]);
    
        try{
            $UserRequests = UserRequests::UserTripDetails(Auth::user()->id,$request->request_id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x191919|weight:3|enc:".$value->route_key.
                            "&key=".$this->Google_Api_Key;
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * get all promo code.
     *
     * @return \Illuminate\Http\Response
     */

    public function promocodes() {
        try{
            $this->check_expiry();

            return PromocodeUsage::Active()
                    ->where('user_id', Auth::user()->id)
                    ->with('promocode')
                    ->get();

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    } 


    public function check_expiry(){
        try{
            $Promocode = Promocode::all();
            foreach ($Promocode as $index => $promo) {
                if(date("Y-m-d") > $promo->expiration){
                    $promo->status = 'EXPIRED';
                    $promo->save();
                    PromocodeUsage::where('promocode_id', $promo->id)->update(['status' => 'EXPIRED']);
                }else{
                    PromocodeUsage::where('promocode_id', $promo->id)->update(['status' => 'ADDED']);
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * add promo code.
     *
     * @return \Illuminate\Http\Response
     */

    public function add_promocode(Request $request) {

        $this->validate($request, [
                'promocode' => 'required|exists:promocodes,promo_code',
            ]);
        try{
            $find_promo = Promocode::where('promo_code',$request->promocode)->first();

            if($find_promo->status == 'EXPIRED' || (date("Y-m-d") > $find_promo->expiration)){

                if($request->ajax()){

                    return response()->json([
                        'message' => trans('api.promocode_expired'), 
                        'code' => 'promocode_expired'
                    ]);

                }   else{
                    return back()->with('flash_error', trans('api.promocode_expired'));
                }

            }   elseif(PromocodeUsage::where('promocode_id',$find_promo->id)->where('user_id', Auth::user()->id)->where('status','ADDED')->count() > 0){

                if($request->ajax()){

                    return response()->json([
                        'message' => trans('api.promocode_already_in_use'), 
                        'code' => 'promocode_already_in_use'
                        ]);

                }else{
                    return back()->with('flash_error', 'Promocode Already in use');
                }
            }   else{
                $promo = new PromocodeUsage;
                $promo->promocode_id = $find_promo->id;
                $promo->user_id = Auth::user()->id;
                $promo->status = 'ADDED';
                $promo->save();
                if($request->ajax()){
                    return response()->json([
                            'message' => trans('api.promocode_applied') ,
                            'code' => 'promocode_applied'
                         ]); 
                }else{
                    return back()->with('flash_success', trans('api.promocode_applied'));
                }
            }
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something Went Wrong');
            }
        }
    } 
    
    
    public function remove_promocode(Request $request)
    {
        $deletepromo = PromocodeUsage::where('promocode_id',$request->id)->delete();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function upcoming_trips() {
    
        try{
            $UserRequests = UserRequests::UserUpcomingTrips(Auth::user()->id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".$this->Google_Api_Key;
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function upcoming_trip_details(Request $request) {

         $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
            ]);
       
        try{
            $UserRequests = UserRequests::with('payment')->UserUpcomingTripDetails(Auth::user()->id,$request->request_id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".$this->Google_Api_Key;
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }


    /**
     * Show the nearby providers.
     *
     * @return \Illuminate\Http\Response
     */

    public function show_providers(Request $request) {

            $this->validate($request, [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'service' => 'numeric|exists:service_types,id',
            ]);

        try{

            $distance = Setting::get('provider_search_radius', '10');
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            if($request->has('service')){
                $ActiveProviders = ProviderService::AvailableServiceProvider($request->service)->get()->pluck('provider_id');
                $Providers = Provider::whereIn('id', $ActiveProviders)
                    ->where('status', 'approved')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->get();
            } else {
                $Providers = Provider::where('status', 'approved')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->get();
            }

            if(count($Providers) == 0) {
                if($request->ajax()) {
                    return response()->json(['message' => "No Providers Found"]); 
                }else{
                    return back()->with('flash_success', 'No Providers Found! Please try again.');
                }
            }
        
            return $Providers;

        } catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something went wrong while sending request. Please try again.');
            }
        }
    }






    /**
     * Forgot Password.
     *
     * @return \Illuminate\Http\Response
     */


    public function forgot_password(Request $request){

        $this->validate($request, [
                'email' => 'required|email|exists:users,email',
            ]);

        try{  
            
            $user = User::where('email' , $request->email)->first();

            // $otp = mt_rand(100000, 999999);

            // $user->otp = $otp;
            // $user->save();

            // Notification::send($user, new ResetPasswordOTP($otp));

            return response()->json([
                'message' => 'OTP sent to your email!',
                'user' => $user
            ]);

        }catch(Exception $e){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * Reset Password.
     *
     * @return \Illuminate\Http\Response
     */

    public function reset_password(Request $request){

        $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'id' => 'required|numeric|exists:users,id'
            ]);

        try{

            $User = User::findOrFail($request->id);
            $User->password = bcrypt($request->password);
            $User->save();

            if($request->ajax()) {
                return response()->json(['message' => 'Password Updated']);
            }

        }catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
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
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
        }
    }

    public function createDefaultLocation(Request $request){

        try{

                  $count = UserLocationType::where('user_id',Auth::user()->id)->where('location_type',$request->location_type)->count();

          if($count == 0){

           $data = UserLocationType::Create($request->all());

            }else{

              UserLocationType::where('user_id',Auth::user()->id)->where('location_type',$request->location_type)->update($request->all());


               }
            if($request->ajax()) {
                return response()->json(['status' =>1,'msg'=>'successfully created']);
            }

        }catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
        }
    }

    public function create_complaint(Request $request) {
        
	
                UserComplaint::Create($request->all());
               
                return response()->json([ 'success' =>'yes','message' => 'Compalint Created Successfuly !' ]);

      

    }

	
	
	function test() {
	
	
		$user = User::find(31);
		
		$UserReq = UserRequests::find(370);
		
		 
		(new SendPushNotification)->WalletMoney(31, 50 ); 
	
	}
	
	public function match_location(Request $request) {

        $this->validate($request, [
            
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

        try{

            $zones = Zones::orderBy('created_at' , 'desc')->get();
            $Locations = unserialize($zones[0]['coordinate']);
         $arr='';
         
            $match = $request->latitude.','.$request->longitude;
            $find = 0;
            foreach($Locations as $loc):
                
               if(strstr($match,substr($loc, 0, ((strpos($loc, '.')+1)+6))) !=false){
                   $find=1;
                   break;
                   
               }
            endforeach;
            
    
            if ($find==1)
            {
              return response()->json(['msg'=>'Data Found']);
            }else{
              return response()->json(['msg'=>'Data Not Found']);
            }
        }

        catch (Exception $e) {
            
            if($request->ajax()){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something Went Wrong');
            }
        }

    } 
    
    public function getChat(Request $request){
		
        $this->validate($request, [
                'request_id' => 'required',              
            ]);
			
        $userName = Auth::user()->first_name;

        if($request->has('message') && $request->has('provider_id') && $request->has('user_id') && $request->has('type'))   {

            //push notification
          

$order  = UserRequests::with('provider')->find($request->request_id);
        	
 define('API_ACCESS_KEY','AAAA828ROg8:APA91bGjLro6tk76nQ1JuS92na1PKc56eIRiiaHwPDyYPWl2DR-flcGBiJ7wZDvXhwdTot-ocml_CXlGz_HOj44hntnaYuZzAY0Uek6sddvqwAyKLkG0EZMAgWjHoqkQDAaSh06lReDJ');
 $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
 
        $notification = [
            'title' =>'chat',
            'body' => $request->message,
            'icon' => 'ic_message_icon'
        ];
        $extraNotificationData = ["message" => $notification];

        $fcmNotification = [
            'to'        => $order->provider->device->token, //single token
            'notification' => $notification,
            'data' => [
					"msg_type" =>"chat",
					"request_id" => $request->request_id,
					"image_url" =>"image_url",
					"user_name"=>$userName,
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
		
       


$msgCreate = Chat::Create([
						'request_id'=>$request->request_id,
						'provider_id'=>$request->provider_id,
						'user_id'=>$request->user_id,
						'message'=>$request->message,
						'type'=>$request->type,
				]);

            /*
			(new SendPushNotification)->chatNotifyProvider($request->provider_id,$request->message,$request->request_id,$userName);
			$message = $request->message;
			

			*/
			}
          
	 	$r = Chat::where('request_id',$request->request_id)->get();
	 	return response()->json(['status'=>1,"data"=>$r]);
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
	
	public function notification(Request $request)
    {
        $id = Auth::user()->id;
     
        try {
         
            $notifications = PushNotification::where('type',1)->whereRaw("find_in_set($id,to_user)")->whereDate('expiration_date', '>=', date('Y-m-d'))->orderBy('id','desc')->get();
            return response()->json(['Data' =>$notifications]);
            
        }   catch(Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }
    
    public function getvalidzone(Request $request)
    {
        $spoint[0]	=	$request->s_latitude; 
		$spoint[1]	=	$request->s_longitude;
		$dpoint[0]	=	$request->d_latitude; 
		$dpoint[1]	=	$request->d_longitude;
		$szone_id	=	$this->getLatlngZone_id($spoint);
		$dzone_id	=	$this->getLatlngZone_id($dpoint);
		
        $szones = Zones::select('status')->where('id',$szone_id)->where('status','active')->first();

		if(count($szones) > 0)
    	{
    	        $dzones = Zones::select('status')->where('id',$dzone_id)->where('status','active')->first();
        		if(count($dzones) > 0)
        		{
        		    return response()->json(['status'=>1,'success' => 'Valid Zones.'], 200);
        		} else{
        		    return response()->json(['status'=>0,'error' => 'Sorry we are not serveing this area.'], 200);
        		}
        }       else{
        		    return response()->json(['status'=>0,'error' => 'Sorry we are not serveing this area.'], 200);
        		}		
    }
    
    
    public function review(Request $request)
    {
        try{
            $review = UserRequestRating::select('user_rating','provider_comment','created_at')->where('user_id',Auth::user()->id)
                    ->orderBy('id', 'DESC')
                    ->get();
            
            return response()->json(['Data' =>$review]);
                
           
            
        } catch(Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }

}