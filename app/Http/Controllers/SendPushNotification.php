<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\{User,ProviderDevice,PushNotification,ProviderService};

class SendPushNotification extends Controller
{



    /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */
    public function UserCancellRide2($request){

        return $this->sendPushToProviderCancel($request->provider_id, trans('api.push.user_cancelled'));
    }

  /**
     * New Incoming request
     *
     * @return void
     */
    public function IncomingRequest_updated($provider){
      
        return $this->sendPushToProvider2($provider, trans('api.push.incoming_request'));

    }


    public function sendPushToProvider2($provider_id, $push_message,$msg_type = "",$request_id="",$username="",$admin="",$img="")
    {
        try{
            $provider = ProviderDevice::where('provider_id',$provider_id)->first();
            if($provider->token != ""){
                if($provider->type == 'ios'){
                    return \PushNotification::app('IOSProvider')
                        ->to($provider->token)
                        ->send($push_message);

                }elseif($provider->type == 'android'){
          

                shell_exec('curl -X POST --header "Authorization: key=AAAA828ROg8:APA91bGjLro6tk76nQ1JuS92na1PKc56eIRiiaHwPDyYPWl2DR-flcGBiJ7wZDvXhwdTot-ocml_CXlGz_HOj44hntnaYuZzAY0Uek6sddvqwAyKLkG0EZMAgWjHoqkQDAaSh06lReDJ" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$provider->token.'\",,\"priority\":\"high\",\"data\":{\"msg_type\":\"'.$msg_type.'\",\"request_id\":\"'.$request_id.'\",\"image_url\":\"'.$img.'\",\"user_name\":\"'.$username.'\",\"msg\":\"'.$push_message.'\"},\"message_type\":\"chat\",\"notification\":{\"body\": \"'.stripslashes($push_message).'\",\"title\":\"'.$msg_type.'\",\"image\":\"'.$img.'\",\"sound\":\"alert_tone\", \"icon\":\"ic_launcher_round\"}}"');
    
                }
            }

        } catch(Exception $e){
            return $e;
        }
    }

    public function sendPushToProviderCancel($provider_id, $push_message,$msg_type = "",$request_id="",$username="",$admin="",$img="")
    {
        try{
            $provider = ProviderDevice::where('provider_id',$provider_id)->first();
            if($provider->token != ""){
                if($provider->type == 'ios'){
                    return \PushNotification::app('IOSProvider')
                        ->to($provider->token)
                        ->send($push_message);

                }elseif($provider->type == 'android'){
          

                shell_exec('curl -X POST --header "Authorization: key=AAAA828ROg8:APA91bGjLro6tk76nQ1JuS92na1PKc56eIRiiaHwPDyYPWl2DR-flcGBiJ7wZDvXhwdTot-ocml_CXlGz_HOj44hntnaYuZzAY0Uek6sddvqwAyKLkG0EZMAgWjHoqkQDAaSh06lReDJ" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$provider->token.'\",,\"priority\":\"high\",\"data\":{\"msg_type\":\"'.$msg_type.'\",\"request_id\":\"'.$request_id.'\",\"image_url\":\"'.$img.'\",\"user_name\":\"'.$username.'\",\"msg\":\"'.$push_message.'\"},\"message_type\":\"chat\",\"notification\":{\"body\": \"'.stripslashes($push_message).'\",\"title\":\"'.$msg_type.'\",\"image\":\"'.$img.'\",\"sound\":\"alert_cancel\", \"icon\":\"ic_launcher_round\"}}"');
    
                }
            }

        } catch(Exception $e){
            return $e;
        }
    }







	/**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */
    public function RideAccepted( $user_id ){

    	return $this->sendPushToUser( $user_id , trans('api.push.request_accepted'));
    }

        public function chatNotify($userID,$msg,$request_id,$username){      //push notification to user
       
        return $this->sendPushToUser($userID,$msg,'chat',$request_id,$username);
    }
    public function userNotify($userID,$title,$msg,$msg_type,$notification_images){      //push notification to user
        //dd($notification_images);
        $notifications  = PushNotification::where('to_user',$userID)->orderBy('id','desc')->first();
        $img="";
        $image = "http://quickrideja.com/public/user/profile/".$notification_images;
        return $this->sendPushToUser($userID,$title,'admin',$msg,$msg_type,$img,$image);
    }
    
   	public function chatNotifyProvider($providerID,$msg,$request_id,$username){    //push notification to provider
       
        return $this->sendPushToProvider($providerID,$msg,'chat',$request_id,$username);
    }
    public function notifyProvider($providerID,$title,$msg,$msg_type,$notification_images)  {    //push notification to provider
    
        $notifications  = PushNotification::where('to_user',$providerID)->orderBy('id','desc')->first();
        $img="";
        $image = "http://quickrideja.com/public/user/profile/".$notification_images;
        return $this->sendPushToProvider($providerID,$title,'admin',$msg,$msg_type,$img,$image);
    }
    
    /**
     * Driver Arrived at your location.
     *
     * @return void
     */
    public function user_schedule($user){

        return $this->sendPushToUser($user, trans('api.push.schedule_start'));
    }

    /**
     * New Incoming request
     *
     * @return void
     */
    public function provider_schedule($provider){

        return $this->sendPushToProvider($provider, trans('api.push.schedule_start'));

    }

    /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */
    public function UserCancellRide($request){

        return $this->sendPushToProvider($request->provider_id, trans('api.push.user_cancelled'));
    }












    /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */
    public function ProviderCancellRide( $obj ){

        return $this->sendPushToUser($obj->user_id, trans('api.push.provider_cancelled'));
    }

    /**
     * Driver Arrived at your location.
     *
     * @return void
     */
    public function Arrived($request){

        return $this->sendPushToUser($request->user_id, trans('api.push.arrived'));
    }

    /**
     * Money added to user wallet.
     *
     * @return void
     */
    public function ProviderNotAvailable($user_id){

        return $this->sendPushToUser($user_id,trans('api.push.provider_not_available'));
    }

    /**
     * New Incoming request
     *
     * @return void
     */
    public function IncomingRequest($provider){
      
        return $this->sendPushToProvider($provider, trans('api.push.incoming_request'));

    }
    

    /**
     * Driver Documents verfied.
     *
     * @return void
     */
    public function DocumentsVerfied($provider_id) {

        return $this->sendPushToProvider($provider_id, trans('api.push.document_verfied'));
    }

	
	 /**
     * Dropped
     *
     * @return void
     */
    public function Dropped($user_id) {

          return $this->sendPushToUser($user_id,trans('api.push.drop'));
    }
	
	
    /**
     * Money added to user wallet.
     *
     * @return void
     */
    public function WalletMoney($user_id, $money){

        return $this->sendPushToUser($user_id, $money.' '.trans('api.push.added_money_to_wallet'));
    }

    /**
     * Money charged from user wallet.
     *
     * @return void
     */
    public function ChargedWalletMoney($user_id, $money){

        return $this->sendPushToUser($user_id, $money.' '.trans('api.push.charged_from_wallet'));
    }

    /**
     * Sending Push to a user Device.
     *
     * @return void
     */
    public function sendPushToUser($user_id, $push_message,$msg_type = "",$request_id="",$username="",$admin="",$img="")
    {
    //dd($img);
    	try{

            $user = User::findOrFail($user_id);
            
 
                if(!empty($user->ios_token)){
                    (new \App\Http\Controllers\Controller())->send_notification($user->ios_token,'3now chat',$push_message);
                   // shell_exec('curl -X POST --header "Authorization: key=AAAAxJsH8XU:APA91bEX41lZ2nvkXFLqd__il5MOsvyzAZbAsZgpgWMfXlE2YD6ai1OpKvGBLwyVBzose81XV9hDaOOBpYbBrxzycQcqOScVQXo2KCst8W0xfvYVgt6tpf-UY_zGxDY8hp5c3b7kwKfD" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$user->ios_token.'\",\"priority\":\"high\",\"data\":{\"msg_type\":\"'.$msg_type.'\",\"request_id\":\"'.$request_id.'\",\"image_url\":\"'.$img.'\",\"user_name\":\"'.$username.'\",\"msg\":\"'.$push_message.'\"},\"notification\":{\"body\": \"'.stripslashes($push_message).'\",\"title\":\"'.$msg_type.'\",\"image\":\"'.$img.'\"}}"');
                    return true;
                }
          

         
                if(!empty($user->device_token)){
                    (new \App\Http\Controllers\Controller())->send_notification($user->device_token,'3now chat',$push_message);
                    //shell_exec('curl -X POST --header "Authorization: key=AAAAxJsH8XU:APA91bEX41lZ2nvkXFLqd__il5MOsvyzAZbAsZgpgWMfXlE2YD6ai1OpKvGBLwyVBzose81XV9hDaOOBpYbBrxzycQcqOScVQXo2KCst8W0xfvYVgt6tpf-UY_zGxDY8hp5c3b7kwKfD" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$user->device_token.'\",\"priority\":\"high\",\"data\":{\"msg_type\":\"'.$msg_type.'\",\"request_id\":\"'.$request_id.'\",\"image_url\":\"'.$img.'\",\"user_name\":\"'.$username.'\",\"msg\":\"'.$push_message.'\"},\"notification\":{\"body\": \"'.stripslashes($push_message).'\",\"title\":\"'.$msg_type.'\",\"image\":\"'.$img.'\"}}"');
                    return true;
                }
           




            /*
            if($user->device_token != ""){
    	    	if($user->device_type == 'ios'){
    	    		return \PushNotification::app('IOSUser')
    		            ->to($user->device_token)
    		            ->send($push_message);

    	    	}elseif($user->device_type == 'android'){

					shell_exec('curl -X POST --header "Authorization: key=AAAAxJsH8XU:APA91bEX41lZ2nvkXFLqd__il5MOsvyzAZbAsZgpgWMfXlE2YD6ai1OpKvGBLwyVBzose81XV9hDaOOBpYbBrxzycQcqOScVQXo2KCst8W0xfvYVgt6tpf-UY_zGxDY8hp5c3b7kwKfD" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$user->device_token.'\",\"priority\":\"high\",\"data\":{\"msg_type\":\"'.$msg_type.'\",\"request_id\":\"'.$request_id.'\",\"image_url\":\"'.$img.'\",\"user_name\":\"'.$username.'\",\"msg\":\"'.$push_message.'\"},\"notification\":{\"body\": \"'.stripslashes($push_message).'\",\"title\":\"'.$msg_type.'\",\"image\":\"'.$img.'\"}}"');
    	    	}
            }
            */

    	}   catch(Exception $e){


           // \Log::info($e)
    		return $e;
    	}
    }




    /**
     * Sending Push to a user Device.
     *
     * @return void
     */
    public function sendPushToProvider($provider_id, $push_message,$msg_type = "",$request_id="",$username="",$admin="",$img="")
    {
        //dd($img);
    	try{
            $provider = ProviderDevice::where('provider_id',$provider_id)->first();
            if($provider->token != ""){
            	if($provider->type == 'ios'){
            		return \PushNotification::app('IOSProvider')
        	            ->to($provider->token)
        	            ->send($push_message);

            	}elseif($provider->type == 'android'){
            
        	   	shell_exec('curl -X POST --header "Authorization: key=AAAA828ROg8:APA91bGjLro6tk76nQ1JuS92na1PKc56eIRiiaHwPDyYPWl2DR-flcGBiJ7wZDvXhwdTot-ocml_CXlGz_HOj44hntnaYuZzAY0Uek6sddvqwAyKLkG0EZMAgWjHoqkQDAaSh06lReDJ" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$provider->token.'\",\"priority\":\"high\",\"data\":{\"msg_type\":\"'.$msg_type.'\",\"request_id\":\"'.$request_id.'\",\"image_url\":\"'.$img.'\",\"user_name\":\"'.$username.'\",\"msg\":\"'.$push_message.'\"},\"message_type\":\"chat\",\"notification\":{\"body\": \"'.stripslashes($push_message).'\",\"title\":\"'.$msg_type.'\",\"image\":\"'.$img.'\"}}"');
	
            	}
            }

    	} catch(Exception $e){
    		return $e;
    	}
    }
    public function offnotificationtoprovider()
    {
        $push_message = "You are offline.Please change your status.";
        $msg_type = "offline";
        $request_id=1;
        $username="upendra";
        //$admin="";
        //$img="";
        $data = ProviderService::where('status','offline')->get();
        foreach($data as $p)
        {
            return $this->sendPushToProvideroffline($p['provider_id'],$push_message,$msg_type);
        }    
    }
    public function sendPushToProvideroffline($provider_id, $push_message,$msg_type = "",$request_id="",$username="",$admin="",$img="")
    {
    	try{
            $provider = ProviderDevice::where('provider_id',$provider_id)->first();
            if($provider['token'] != ""){
            	if($provider->type == 'ios'){
            		return \PushNotification::app('IOSProvider')
        	            ->to($provider->token)
        	            ->send($push_message);

            	}   elseif($provider->type == 'android'){
           
        	   	shell_exec('curl -X POST --header "Authorization: key=AAAA828ROg8:APA91bGjLro6tk76nQ1JuS92na1PKc56eIRiiaHwPDyYPWl2DR-flcGBiJ7wZDvXhwdTot-ocml_CXlGz_HOj44hntnaYuZzAY0Uek6sddvqwAyKLkG0EZMAgWjHoqkQDAaSh06lReDJ" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$provider->token.'\",\"priority\":\"high\",\"data\":{\"msg_type\":\"'.$msg_type.'\",\"request_id\":\"'.$request_id.'\",\"image_url\":\"'.$img.'\",\"user_name\":\"'.$username.'\",\"msg\":\"'.$push_message.'\"},\"message_type\":\"chat\",\"notification\":{\"body\": \"'.stripslashes($push_message).'\",\"title\":\"'.$msg_type.'\",\"image\":\"'.$img.'\"}}"');
	
            	}
            }

    	} catch(Exception $e){
    		return $e;
    	}
    }
}