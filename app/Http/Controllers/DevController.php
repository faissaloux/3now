<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevController extends Controller
{
    public function ok1(){
        $coupon_helper = new \App\Helper\CouponHelper();
        $result = $coupon_helper->check('$request->promo_cod')->request(5997)->use();
        print_r($result);

      // if(isset($request->promo_code) and !empty($request->promo_code)){
                    //     $coupon_helper = new \App\Helper\CouponHelper();
                    //     $result = $coupon_helper->check($request->promo_code)->request(5997)->use();
                    // }
    }

    public function deleteLog(){
        $log_file = base_path().'/storage/logs/laravel.log';
        if(file_exists($log_file)){
            unlink($log_file);
            echo 'deleted';
        }else {
            echo 'already deleted';
        }
    }

    public function testNotification(){
        $device_token = 'cQ37OTzpQAS4r8fWVNU9QB:APA91bEjmKYDf_Km24kT_30NpvSfzqTFbIK7Q_BDIrNQhN7r6PmSbMgcI-n85OgCimjzTvuBcHHhDNM7LzstDN48UPJJof5z4iUYAGILr6s_cEymgPzdztLMNajt7VHKeSrd_4V_dhQJ';
        $title = 'hello';
        $message = 'request testing';



        shell_exec('curl -X POST --header "Authorization: key=AAAA828ROg8:APA91bGjLro6tk76nQ1JuS92na1PKc56eIRiiaHwPDyYPWl2DR-flcGBiJ7wZDvXhwdTot-ocml_CXlGz_HOj44hntnaYuZzAY0Uek6sddvqwAyKLkG0EZMAgWjHoqkQDAaSh06lReDJ" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$device_token.'\",,\"priority\":\"high\",\"data\":{\"body\": \"'.$message.'\",\"title\":\"'.$title.'\"},\"notification\":{\"body\": \"'.$message.'\",\"title\":\"'.$title.'\"}}"');

        exit;

        define('API_ACCESS_KEY', env('FB_KEY') );
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notification = [
          'title' => '3now title',
          'body' => '3now text body',
           'sound' => 1, "sound" =>
           "default", "click_action" => "Open_URI"];

        $extraNotificationData = [
          "message" => $notification,
          "moredata" => 'dd'
        ];

        $token = 'ea92-kHRRFKOjzn_j6u9gb:APA91bGXs3D2Cd2wQmHYYie5PAohsS9pHf21y-4N9pQLsCTrJeLpGRn49AVpjJFzeb3juB2U2embUclmQrBLpbYVwEljknT0GewcikAYhx55x_yVE7xha1cBhfxdRcXws6ulLf4xSVUZ';

        $fcmNotification = [
          'to' => $token,
          'notification' => $notification,
          'data' => [
            "uri" => "lld",
            "msg_type" => "Hello ",
            "request_id" => 7,
            "image_url" =>
            'https://www.gstatic.com/mobilesdk/160503_mobilesdk/logo/2x/firebase_28dp.png',
            "user_name" => "abdulwahab",
            "msg" => "msg"
          ]
        ];

        $headers = ['Authorization: key=' . API_ACCESS_KEY, 'Content-Type: application/json'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        print_r($result);


        exit;
    }

    public function checkGoogleApi(){
        $json = curl('https://maps.googleapis.com/maps/api/geocode/json?latlng=51.21507920,6.84209850&key=AIzaSyAaCcYWO2ClnRd-ZSlDnW17Jh2jnBatCmg');

        /*
        $details = json_decode($json, TRUE);


            $meter        = $details['routes'][0]['legs'][0]['distance']['value'] ?? 0;
            $meter_txt      = $details['routes'][0]['legs'][0]['distance']['text'] ?? 0;
            $kilometer      = round($meter/1000,1);
            $kilometer_txt  = "$kilometer km" ;
            $seconds    = $details['routes'][0]['legs'][0]['duration']['value'] ?? 0;
            $minutes    = round($seconds/60,1);
            $minutes_txt    = $minutes . ' mins';
            $route_key    = $details['routes'][0]['overview_polyline']['points'];

        */


        echo $json;

        // $json = curl($this->googleApi()); 
    }

    public function googleKeys(){
        $key = 'AIzaSyA3beYlqo75tyKd2zF4l0sP9ID-bBH2yP8';
        return response()->json(['key' => $key]);
    }
}
