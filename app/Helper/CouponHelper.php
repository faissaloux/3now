<?php 

namespace App\Helper;
use App\Coupons;
use App\UserRequests;

/*
*
*	class usage example
*	$coupon_helper = new CouponHelper();
*	
*	to check if the coupon is valid or not !
*	$coupon_helper->check($coupon_code)->valid;
*	result : true or false;
*
*	to use the coupon
*	$coupon_helper->check($coupon_code)->request($request_id)->use();
*	result : true or false
*/


class CouponHelper {


	public $valid = true;
	public $user_id;
	public $coupon_id;
	public $coupon_code;
	public $instance;
	public $request_id;
	public $request_price;
    public $discount;
    public $discount_type;
	public $discount_value;
	public $maxDiscount;
	public $request_discount;
	public $resquest_instance;
	public $reason;


	public function check($coupon_code){


		$coupon_code = strtoupper($coupon_code);
		
		$this->coupon_code = $coupon_code;

		// set the user_id
		$this->user_id = \Auth::user()->id;

		// load the coupon
        $this->load_coupon($coupon_code);

		// check if the coupon is for specific user or all users
		$this->check_usage_type();

        // check if the coupon acheived the max usage
        $this->check_max_usage();

		// check if the user already used the coupon
        $this->check_user_usage();
        
        // check if the coupon date is valide or not!
        $this->check_date();
        
        // get the discount 
        $this->set_discount();

		return $this;
	}

	public function load_coupon($coupon_code){

		$coupon =  Coupons::where('code',$coupon_code)->where('statue','active')->first();

		if(!$coupon){
			$this->valid = false;
			$this->reason  = 'the coupon is not found';
			return false;
		}

		$this->instance = $coupon;
		$this->discount_type = $coupon->discount_type;
		$this->discount_value = $coupon->discount;
		$this->maxDiscount = $coupon->maxDiscount;
		
		return $this;
	}

	public function check_usage_type(){
        if( $this->valid == false) {return false;};

        if( ($this->instance->usage_type == 'single') and (\Auth::user()->id != $this->instance->user ) ){
			$this->reason  = 'the coupon is for another user only ';
            $this->valid = false;
		}else {
            $this->valid = true;
        }
		return $this;
	}

	public function check_date(){
		if($this->valid == false) {return false;};

		if(!empty($this->instance->valid_from) && !empty($this->instance->valid_to)){
				$startDate = \Carbon\Carbon::createFromFormat('Y-m-d',$this->instance->valid_from);
				$endDate = \Carbon\Carbon::createFromFormat('Y-m-d',$this->instance->valid_to);
				$this->valid = \Carbon\Carbon::now()->between($startDate,$endDate);
				
				if($this->valid == false){
					$this->reason  = 'the coupon is outdated ';
				}
        }
        
		return $this;
	}

	public function check_max_usage(){
		if($this->valid == false) {return false;};

		$count =  \DB::table('coupons_usage')->where('coupon_id',$this->instance->id)->count();

		if( $count >= $this->instance->maxUsage ) {
			$this->reason  = 'the coupon reached the max  usage';
			$this->valid = false;
		}

		return $this;
	}


	public function check_user_usage(){
		if($this->valid == false) {return false;};

        $count =  \DB::table('coupons_usage');
		$count = $count->where('user_id',$this->user_id)->where('coupon_id',$this->instance->id)->count();

		if($count >= 1){
			$this->reason  = 'the coupon is already used';
			$this->valid = false;
		}
		unset($count);
		return $this;
	}


	public function set_discount(){
		if($this->valid == false) {return false;};
        $this->discount_type = $this->instance->discount_type;
        $this->discount_value = $this->instance->discount;
		return $this;
	}


	public function check_min_cost(){
		return ($this->request_price > $this->instance->min_cost ) ? true : false ;
	}

	public function calculate_coupon(){

		if( $this->instance->discount_type == 'fixed' ) {
			return $this->request_price - $this->instance->discount;
		}

		if( $this->instance->discount_type == 'percent' ) {
			
			$discounted = ($this->request_price * ($this->instance->discount/100));

			if( ($discounted > $this->maxDiscount)  and ($this->request_price > $this->maxDiscount)  ){
				$discounted = $this->maxDiscount ;
			}

			return $this->request_price - $discounted;
		}
	}


	public function request($request_id){

		if(!is_numeric($request_id)){ return false; }

		$this->request_id = $request_id;

		
		$request = UserRequests::find($request_id);
		$this->resquest_instance = $request;
		if(!$request){
			$this->valid = false;
		}

		$this->request_price = $request->total;

		$this->valid = $this->check_min_cost();

		if($this->valid == false) {
			$this->reason  = 'the coupon didnt reach the minimum cost';
			return $this;};

		$this->request_discount = $this->calculate_coupon();
		
		unset($request,$request_id);

		return $this;

	}


	public function use(){
		if($this->valid == false) {return $this;};
		$data = [
			'user_id'    => $this->user_id,
			'coupon_id'  => $this->instance->id,
			'request_id' => $this->request_id
		];

		$count = \DB::table('coupons_usage')
			->where('user_id',$this->user_id)
			->where('coupon_id',$this->instance->id)
			->where('request_id',$this->request_id)->count();

			$this->resquest_instance->total = $this->request_discount;
			$this->resquest_instance->promo_code = $this->coupon_code;
			$this->resquest_instance->save();
		if( $count == 0 ) {
			\DB::table('coupons_usage')->insert($data);
		}

		return $this;
	}



}


