<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function send_notification($device_token,$title,$message){

        $FB_KEY = env('FB_KEY');


        
        /*
        $device_token = 'cQ37OTzpQAS4r8fWVNU9QB:APA91bEjmKYDf_Km24kT_30NpvSfzqTFbIK7Q_BDIrNQhN7r6PmSbMgcI-n85OgCimjzTvuBcHHhDNM7LzstDN48UPJJof5z4iUYAGILr6s_cEymgPzdztLMNajt7VHKeSrd_4V_dhQJ';
        $title = 'hello';
        $message = 'request testing';
        */
        shell_exec('curl -X POST --header "Authorization: key=AAAA828ROg8:APA91bGjLro6tk76nQ1JuS92na1PKc56eIRiiaHwPDyYPWl2DR-flcGBiJ7wZDvXhwdTot-ocml_CXlGz_HOj44hntnaYuZzAY0Uek6sddvqwAyKLkG0EZMAgWjHoqkQDAaSh06lReDJ" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$device_token.'\",,\"priority\":\"high\",\"data\":{\"body\": \"'.$message.'\",\"title\":\"'.$title.'\"},\"notification\":{\"body\": \"'.$message.'\",\"title\":\"'.$title.'\"}}"');




        /*
        shell_exec('
        curl -X POST --header "Authorization: key='.$FB_KEY.'" \
    --Header "Content-Type: application/json" \
    https://fcm.googleapis.com/fcm/send \
    -d "{\"to\":\"'.$device_token.'\",\"priority\" : \"high\",\"data\":{\"title\":\"'.$title.'\",\"body\":\"'.$message.'\"},\"notification\":{\"title\":\"'.$title.'\",\"body\":\"'.$message.'\","sound" : "default"}}"
        ');
        */

    }




}
