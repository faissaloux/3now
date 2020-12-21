<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Chatroom;
use DB;
use Log;
use Auth;
use Hash;
use Storage;
use Setting;
use Exception;
use Notification;
use Mail; 
use App\Chat;
use Carbon\Carbon;
use App\Http\Controllers\SendPushNotification;
use App\Notifications\ResetPasswordOTP;
use App\Helpers\Helper;
use App\PushNotification;
use App\Card;
use App\Zones;
use App\User;
use App\Provider;
use App\Settings;
use App\Promocode;
use App\ServiceType;
use App\UserRequests;
use App\RequestFilter;
use App\PromocodeUsage;
use App\ProviderService;
use App\UserRequestRating;
use App\Http\Controllers\ProviderResources\TripController;
use App\UserLocationType;
use App\UserComplaint;
use App\FareSetting;
use App\PeakAndNight;
use App\UserRequestPayment;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\StripeInvalidRequestError;
use \App\Helper\CalculateHelper;



if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}


         

class RequestsController extends Controller  {

   

   


   
   	public function estimated_fare_all(Request $request) {

        $this->validate($request,$this->estimated_fare_validate());

        $data = [
            's_latitude'       => $request->s_latitude,
            's_longitude'      => $request->s_longitude,
            'd_latitude'       => $request->d_latitude,
            'd_longitude'      => $request->d_longitude,
            'service_type'     => $request->service_type,
            'user_id'          => Auth::user()->id,
            'request_type'     => 'instant',
        ];

        $details = (new CalculateHelper($data))->all()->get();

        return response()->json($details['all']);
    }

    
   	public function estimated_fare(Request $request) {

        $this->validate($request,$this->estimated_fare_validate());

        $data = [
            's_latitude'       => $request->s_latitude,
            's_longitude'      => $request->s_longitude,
            'd_latitude'       => $request->d_latitude,
            'd_longitude'      => $request->d_longitude,
            'service_type'     => $request->service_type,
            'user_id'          => Auth::user()->id,
            'request_type'     => 'instant',
        ];

        $details = (new CalculateHelper($data))->api();
      
        $result = [
            'estimated_fare' => $details->price, 
            'distance' => $details->distance_kilometer,
            'time' => $details->distance_minutes_txt,
            'currency'   => '€',
            'service_type' =>$request->service_type
        ];

        return response()->json($result);
    }





	public function estimated_fare_validate() {
		return [
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
        ];
    }	

 

 	public function send_request(Request $request) {


        // this is for test perpose only
        // if(isset($request->promo_code) and !empty($request->promo_code)){
        //     $coupon_helper = new \App\Helper\CouponHelper();
        //     $result = $coupon_helper->check($request->promo_code)->request(5621)->use();
        // }
        // exit;



                    
                    



        	$this->validate( $request , $this->rules() );

		$spoint[0]	=	$request->s_latitude; 
		$spoint[1]	=	$request->s_longitude;
		$dpoint[0]	=	$request->d_latitude; 
		$dpoint[1]	=	$request->d_longitude;
		$szone_id	=	$this->getLatlngZone_id($spoint);
		$dzone_id	=	$this->getLatlngZone_id($dpoint);

		$szones = $this->szones($szone_id);
		$dzones = $this->dzones($dzone_id);

		$distance     = Setting::get('provider_search_radius', '10');
		$latitude     = $request->s_latitude;
		$longitude    = $request->s_longitude;
		$service_type = $request->service_type;
		$promo_code   = $request->promo_code;
		$booking_id   = Helper::generate_booking_id();


    	$data = [
            's_latitude'       => $request->s_latitude,
            's_longitude'      => $request->s_longitude,
            'd_latitude'       => $request->d_latitude,
            'd_longitude'      => $request->d_longitude,
            'service_type'     => $request->service_type,
            'coupon'           => $request->promo_code,
            'user_id'          => Auth::user()->id,
            'request_type'     => 'instant',
        ];



		$helper =  new CalculateHelper($data);
		$details = $helper->api();


		if( (count($szones) > 0 ) and (count($dzones) > 0 )) {


					$ActiveRequests = $this->getActiveRequests();

	                if($ActiveRequests > 1 ) {
	                      return response()->json(['error' => trans('api.ride.request_inprogress')], 500);
	                }
	        
	                if($request->has('schedule_date') && $request->has('schedule_time')){

						$date = $request->schedule_date;
						$time = $request->schedule_time;
						
	                	$CheckScheduling = $this->CheckScheduling($date ,$time);

	                    if($CheckScheduling > 0){
	                        return response()->json(['error' => trans('api.ride.request_scheduled')], 500);
	                    }
	                }
	                

					$Providers  = $this->getProviders($distance,$latitude,$longitude,$service_type);

					if(count($Providers) == 0) {
	                    return response()->json(['message' => trans('api.ride.no_providers_found')]); 
	                }
	                
					$UserRequest = new UserRequests;
					$UserRequest->booking_id = $booking_id;
					$UserRequest->user_id = Auth::user()->id;
					$UserRequest->provider_id = $Providers[0]->id;
					$UserRequest->current_provider_id = $Providers[0]->id;
					$UserRequest->service_type_id = $request->service_type;
					$UserRequest->payment_mode = $request->payment_mode;
					$UserRequest->status       = 'SEARCHING';
	    
	                $UserRequest->s_address   = $request->s_address ? : "";
	                $UserRequest->d_address   = $request->d_address ? : "";
	    
	                $UserRequest->s_latitude  = $request->s_latitude;
	                $UserRequest->s_longitude = $request->s_longitude;
	    
	                $UserRequest->d_latitude  = $request->d_latitude;
	                $UserRequest->d_longitude = $request->d_longitude;
	                $UserRequest->distance 	  = $request->distance;

	                $UserRequest->kindersitz  = $request->kindersitz;
	                $UserRequest->babyschale  = $request->babyschale;
	                $UserRequest->nameschield = $request->nameschield;

					$UserRequest->assigned_at = Carbon::now();
					$UserRequest->route_key = $details->distance_route_key;

	                if($Providers->count() <= Setting::get('surge_trigger') && $Providers->count() > 0) {
	                    $UserRequest->surge = 1;
	                }
	    
	                if($request->has('schedule_date') && $request->has('schedule_time')){
	                	$date = $request->schedule_date;
	                	$time = $request->schedule_time;
	                    $UserRequest->schedule_at = $this->schedule_at($date,$time);
	                }

	                $checkrequest = $this->checkrequest();

	                if( count($checkrequest) == 0) {
	                    $UserRequest->save();
	                }
	                
	               (new SendPushNotification)->IncomingRequest_updated($Providers[0]->id);

                    $UserRequest->total = $details->price;
              

					$UserRequest->distance = $details->distance_kilometer;
					$UserRequest->save();
                    

					if(isset($UserRequest->id) && $UserRequest->id!=''):
                     
                       $x = 0;
						foreach ($Providers as $key => $Provider) {

                            if($x == 0) {
                                \Log::info('current provider device_token is '.$Provider->device_token);
                                \Log::info('current provider android_token is '.$Provider->android_token);
                                \Log::info('current provider is '.$Provider->first_name . ' and his ID is :'.$Provider->id);
                                $this->send_notification($Provider->android_token,'New Request','You Recieved New Notification');
                            }
							$Filter = new RequestFilter;
							$Filter->request_id = $UserRequest->id;
							$Filter->provider_id = $Provider->id; 
							$Filter->save();
                            $x++;
						}
					endif;


            
                    $additional_price = Setting::get('additional_price') ?? NULL;

                    if( isset( $additional_price ) and is_numeric( $additional_price ) and ($additional_price > 0) and ($additional_price < 100 )) {
        
                        $calculated_additional_price = $UserRequest->total * ($additional_price / 100 );
                        $new_price = $UserRequest->total + $calculated_additional_price;
                        $UserRequest->total = $new_price;
                        $UserRequest->save();
                    }

                    unset($additional_price,$new_price,$additional_price);

                    // use the coupon
                    if(isset($request->promo_code) and !empty($request->promo_code)){
                        $coupon_helper = new \App\Helper\CouponHelper();
                        $result = $coupon_helper->check($request->promo_code)->request($UserRequest->id)->use();
                    }


					return response()->json([
						'message' => 'New request Created!',
						'request_id' => $UserRequest->id,
						'price' => $UserRequest->total,
						'current_provider' => $UserRequest->provider_id,
					]);

		}

    }


	public $Google_Api_Key  ;

    public function __construct(){
        $this->Google_Api_Key = 'AIzaSyAaCcYWO2ClnRd-ZSlDnW17Jh2jnBatCmg';
    }


	public function rules(){
        return [
            's_latitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
            'distance' => 'required|numeric',
            'use_wallet' => 'numeric',
            'payment_mode' => 'required|in:CASH,CARD,PAYPAL',
            'card_id' => ['required_if:payment_mode,CARD','exists:cards,card_id,user_id,'.Auth::user()->id],
        ];
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


    public function szones($szone_id){
    	return Zones::select('status')->where('id',$szone_id)->where('status','active')->first();
    }

    public function dzones($dzone_id){
    	return Zones::select('status')->where('id',$dzone_id)->where('status','active')->first();
    }

 	public function getProviders($distance,$latitude,$longitude,$service_type){
      return  Provider::with('service')
            ->select(DB::Raw("(6387 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"),'id','device_token','first_name','android_token')
            ->where('status', 'approved')
            ->whereRaw("(6387 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
            ->whereHas('service', function($query) use ($service_type){
                        $query->where('status','active');
                        $query->where('service_type_id',$service_type);
                    })
            ->orderBy('distance','asc')
            ->get();
    }  

    public function getActiveRequests(){
    	return UserRequests::PendingRequest(Auth::user()->id)->count();
    }


    public function CheckScheduling($schedule_date,$schedule_time){
	    $before = (new Carbon("$schedule_date $schedule_time"))->subHour(1);
	    $after = (new Carbon("$schedule_date $schedule_time"))->addHour(1);
	        
	    $CheckScheduling = UserRequests::where('status','SCHEDULED')
	                                        ->where('user_id', Auth::user()->id)
	                                        ->whereBetween('schedule_at',[$before,$after])
	                                        ->count();
	    return $CheckScheduling;
    }

    
    public function schedule_at($schedule_date,$schedule_time){
    	return date("Y-m-d H:i:s",strtotime("$schedule_date $schedule_time"));
    }

    public function checkrequest(){
    	return UserRequests::where('status','SEARCHING')->where('user_id', Auth::user()->id)->get();
    }


   




}