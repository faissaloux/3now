<?php 


namespace App\Helper;
use Setting;

	/*
	*	this Helper made to solve all the distance problemes 
	*	and  make the all calcules in one place
	*   usage (new CalculateHelper)->directions($s_lat,$s_long,$d_lat,$d_long)->distance()->service()->get();
	*
	* App\Helper\CalculateHelper
		returs the following  

					price
					kilometer
					route_key
					time
					meter
					seconds
					kilometer
					errors
	*   
	*
	*	
	*/


	class CalculateHelper  {

		public $errors = [];
		public $success = [];

		//public $google_maps_key = 'AIzaSyA3beYlqo75tyKd2zF4l0sP9ID-bBH2yP8';
		public $google_maps_key = 'AIzaSyAaCcYWO2ClnRd-ZSlDnW17Jh2jnBatCmg';
		public $user_id;
		public $UserRequest;

		public $s_latitude;
		public $s_longitude;
		public $d_latitude;
		public $d_longitude;

		public $coupon;
		public $coupon_available;
		public $coupon_applied;

		public $distance_kilometer;
		public $distance_kilometer_txt;
		public $distance_route_key;
		public $distance_meter;
		public $distance_meter_txt;
		public $distance_minutes;
		public $distance_minutes_txt;
		public $distance_method;

		public $kindersitz;
		public $babyschale;
		public $nameschield;

		public $price;
		public $pricewithCoupon;

		public $price_total;
		public $price_kindersitz;
		public $price_babyschale;
		public $price_nameschield;

		public $service_type;
		public $request_type;

		public $distance;

		public $available_services = [ 19 , 27 , 32 ];
		public $available_coupons  = ['3nowlaunch2020','3now2020'];
		public $request_types      = ['instant','scheduled'];
		public $estimated_fares;
		public $additional_price;


		public function applyCoupon(){

			
			if($this->coupon_available == 1) {
				$this->pricewithCoupon = $this->price - 5 ;
				$this->coupon_applied = 1;
			}else {
				$this->coupon_applied = $this->price;
				$this->coupon_applied = 0;
			}
			
			return $this;
		}


		/*
		*	set data from request
		*/
		public function __construct($data = false) {

			if($data){
				$this->s_latitude   = $data['s_latitude'];
				$this->s_longitude  = $data['s_longitude'];
				$this->d_latitude   = $data['d_latitude'];
				$this->d_longitude  = $data['d_longitude'];
				$this->service_type = $data['service_type'];
				$this->coupon       = $data['coupon'] ?? '';
				$this->user_id      = $data['user_id'];
				$this->request_type = $data['request_type'];
				$this->kindersitz   = $data['kindersitz'] ?? '' ;
				$this->babyschale   = $data['babyschale'] ?? '' ;
				$this->nameschield  = $data['nameschield'] ?? '' ;
				$this->distance     = $data['distance'] ?? '' ;
				return $this->launch();
			}

			return $this;
		}



    	/*
		*   do the work ! and get result
		*/
		public function launch(){
			return	$this->checkServiceType()->checkCoupon()->getDistance()->calculatePrice()->applyCoupon();
		}



		public function caluclate_additional($price){
                    
			$additional_price = $price * ( $this->additional_price / 100 );
			return $price + $additional_price;
		}


    	public function all(){

			$data = [
				'distance' => $this->distance_kilometer,
        		'time' => $this->distance_minutes_txt,
        		'currency'   => '€',
			];


			$data['19']  = [ 'fare_price' => $this->instant_service19() ];
			$data['27']  = [ 'fare_price' => $this->instant_service27()  ];
			$data['32']  = [ 'fare_price'   => $this->instant_service32()  ];

			

			$this->estimated_fares = $data;
			return $this;
    	}




		
    	public function calculatePrice(){
    		
    		if($this->request_type == 'instant') {
    			$this->calculateInstantPrice();
    		}
    		
    		if($this->request_type == 'scheduled') {
    			$this->calculateScheduledPrice();
    		}
    		return $this;
    	}


    	public function calculateInstantPrice(){
			
			
    		if(isset($this->service_type)){

    			$this->price = 0 ;

				if($this->service_type == '19' ){
					$price = $this->instant_service19();
				}
				
				if($this->service_type == '27'){
					$price = $this->instant_service27();
				}
				
				if($this->service_type == '32'){
					$price = $this->instant_service32();
				}
    		}
			
			$additional_price = Setting::get('additional_price') ?? NULL;

			if( isset( $additional_price ) and is_numeric( $additional_price ) and ($additional_price > 0) and ($additional_price < 100 )) {

				$this->additional_price = $additional_price ;
				$price = $this->caluclate_additional($price);
			}

			

			$this->price = $price;
    	}



    	public function calculateScheduledPrice(){
    			

    		if(isset($this->service_type)){

		    		$this->price = 0;




		    		if($this->service_type  == '19'){
					    $price = ($this->distance_kilometer * 1.25) + 25;
					    $price = round($price, 2);
					}

					if($this->service_type   == '27'){
						$price = ($this->distance_kilometer * 1.35) + 35;
						$price = round($khla, 2);
					}

					if($this->service_type   == '32'){
						$price = ($this->distance_kilometer * 1.40) + 40;
						$price = round($price, 2);
					}

					if(isset($this->kindersitz)) {
						if($this->kindersitz > 1 ){
						$price  += (($this->kindersitz * 5 ) - 5);
						}
					}

					if(isset($this->babyschale)) {
						if($this->babyschale){
							$price  += (( $this->babyschale * 10 ) - 10 );
						}
					}
							
					if(isset($this->nameschield)) {
						if ($this->nameschield) {
							$price  += 15;
						}
					}	
					
					$this->price = $price;
			}

			return $this;
		}



		/*
		*	check if the service type is set and its from available_services
		*/
		public function checkServiceType(){

			if($this->service_type){
				if( ! in_array($this->service_type, $this->available_services) ){
					$this->errors[] = 'the service type is not available';
				}
			}else{
				$this->errors[] = 'the service type is required';
			}
		
			return $this;
		}



		public function verifyCoupon($coupon){

				$coupon = strtolower(trim($coupon));
							
				if(! $coupon == ''){

					if(in_array($coupon,$this->available_coupons)){

						if( $this->isCouponUsed() ){
							$this->errors[] = 'coupon ' . $this->coupon . ' is not availabe for this user ' ;
							$this->coupon_available = 0;
							return false;
						}
						else {
							$this->success[] = 'coupon availabe' ;
							$this->coupon_available = 1;
							return true;
						}
					}
				}

				$this->errors[] = 'please add coupon to activate it' ;
				$this->coupon_available = 0;
				return $this;
		}



		/*
		*	check if the service type is set and its from available_services
		*/
		public function checkCoupon(){
			
			$this->coupon_available = 0;

			$this->verifyCoupon($this->coupon);

			return $this;
		}


		/*
		*	check if the coupon is used by the current user
		*/
		public function isCouponUsed(){
			$coupons = \DB::table('coupons');
			$query = $coupons->where('user_id', $this->user_id)->whereIn('coupon', $this->available_coupons );
			$count = $query->count();
			return $count > 0 ? true : false;
		}



		/*
		*	get distance
		*/
		public function getDistance(){

			$this->getDistanceByGoogle();

			if( ! $this->checkGoogleApiResult() ){

				$this->GetDistanceAlternative();
			}
			
			return $this;
		}




		/*
		*   set the google maps link
		*/
		public function googleApi(){

			$link = "https://maps.googleapis.com/maps/api/directions/json?";

			$params = [
				'origin' 	  => $this->s_latitude.",".$this->s_longitude,
				'destination' => $this->d_latitude.",".$this->d_longitude,
				'mode'        => 'driving',
				'key'         => $this->google_maps_key
			];

			$link = $link.http_build_query($params);
			return $link;
		}


		/*
		*	get the distance from google 
		*/
		public function getDistanceByGoogle(){
			
			$json = curl($this->googleApi());

            $details = json_decode($json, TRUE);

			$meter 		    = $details['routes'][0]['legs'][0]['distance']['value'] ?? 0;
			$meter_txt 	    = $details['routes'][0]['legs'][0]['distance']['text'] ?? 0;
			$kilometer      = round($meter/1000,1);
			$kilometer_txt  = "$kilometer km" ;
			$seconds 		= $details['routes'][0]['legs'][0]['duration']['value'] ?? 0;
			$minutes		= round($seconds/60,1);
			$minutes_txt    = $minutes . ' mins';
			$route_key  	= $details['routes'][0]['overview_polyline']['points'];

			$this->distance_kilometer 	  = $kilometer;
			$this->distance_kilometer_txt = $kilometer_txt;
			$this->distance_meter 	 	  = $meter;
			$this->distance_meter_txt 	  = $meter_txt;
			$this->distance_minutes 	  = $minutes;
			$this->distance_minutes_txt   = $minutes_txt;
			$this->distance_route_key     = $route_key;
			$this->distance_method		  = 'google maps';

		}

		
		public function checkGoogleApiResult(){
			if( 
				($this->distance_kilometer == 0 ) OR
				($this->distance_kilometer == Null) OR
				empty($this->distance_kilometer) OR 
				!is_numeric($this->distance_kilometer)
			){
				return false;
			}
			return true;
		}


		public function GetDistanceAlternative(){
	        $p0 	  = $this->s_latitude;
	        $p1 	  = $this->s_longitude;
	        $p2 	  = $this->d_latitude;
	        $p3 	  = $this->d_longitude;
	        $distance = \DB::select(\DB::raw("select lat_lng_distance($p0, $p1, $p2, $p3) as distance "));
	        $distance = $distance[0]->distance;
	        $distance =  (($distance  * 0.4) + $distance);
	        $this->distance_kilometer = $distance;
	        $this->distance_method = 'alternative';
	        return $this;
    	}


		public function cleanPrices(){
			$this->price = round($this->price,1);
			$this->pricewithCoupon = round($this->pricewithCoupon,1);
		}


		public function cleanDistance(){
			$this->distance_kilometer = round($this->distance_kilometer,1);
			$this->distance_minutes = round($this->distance_minutes,1);
			$this->total = round($this->distance_kilometer,1);
		}




    	public function get(){

    		$this->cleanPrices();
    		$this->cleanDistance();

    		$result = ['errors' => $this->errors ];

    		$result['s_latitude'] = $this->s_latitude; 
    		$result['s_longitude'] = $this->s_longitude; 
    		$result['d_latitude']  = $this->d_latitude; 
    		$result['d_longitude'] = $this->d_longitude; 

    		$result['coupon'] = $this->coupon; 
    		$result['coupon_available'] = $this->coupon_available; 
    		$result['coupon_applied'] = $this->coupon_applied; 


    		$result['distance_kilometer'] = $this->distance_kilometer; 
    		$result['distance_kilometer_txt'] = $this->distance_kilometer_txt; 
    		$result['distance_route_key'] = $this->distance_route_key; 
    		$result['distance_meter'] = $this->distance_meter; 
    		$result['distance_meter_txt'] = $this->distance_meter_txt; 
    		$result['distance_minutes'] = $this->distance_minutes; 
    		$result['distance_minutes_txt'] = $this->distance_minutes_txt; 
    		$result['distance_method'] = $this->distance_method; 

			$result['kindersitz'] = $this->kindersitz; 
    		$result['babyschale'] = $this->babyschale; 
    		$result['nameschield'] = $this->nameschield; 

    		$result['price'] = $this->price;
    		$result['pricewithCoupon'] = $this->pricewithCoupon;
    		$result['total'] = $this->pricewithCoupon;

    		$result['price_kindersitz'] = $this->price_kindersitz ?? 0 ;
    		$result['price_babyschale'] = $this->price_babyschale ?? 0 ;
    		$result['price_nameschield'] = $this->price_nameschield ?? 0 ;
    		
    		$result['service_type'] = $this->service_type;
    		$result['request_type'] = $this->request_type;
    		$result['all'] = $this->estimated_fares;

    		return $result;
    	}

    	public function getJson(){
    		return json_encode($this->get());
    	}




		public function api(){
    		return (object)$this->get();
    	}


		public function saveCoupon() {
			if(!empty($this->coupon) && !empty($this->user_id)){
				return \DB::table('coupons')->insert(['user_id' => $this->user_id , 'coupon'  => $this->coupon]);
			}
	        return $this;
	    }
    	


		public function instant_service19() {
	       	$price = ($this->distance_kilometer * 1.2) + 2.10;
			if($price > 0  && $price < 5  ){
				$price = 5;
			} 
			return $this->cleanPrice($price);
	    }

		public function instant_service27() {
			return $this->cleanPrice(($this->distance_kilometer * 1.2) + 7.10);
	    }


		public function instant_service32() {
	        return $this->cleanPrice(($this->distance_kilometer * 1.3) + 17);
	    }


	    public function cleanPrice($price){
	    	return round($price,1);
	    }

}

