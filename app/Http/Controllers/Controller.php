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
        shell_exec('curl -X POST --header "Authorization: key=AAAA828ROg8:APA91bGjLro6tk76nQ1JuS92na1PKc56eIRiiaHwPDyYPWl2DR-flcGBiJ7wZDvXhwdTot-ocml_CXlGz_HOj44hntnaYuZzAY0Uek6sddvqwAyKLkG0EZMAgWjHoqkQDAaSh06lReDJ" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$device_token.'\",,\"priority\":\"high\",\"data\":{\"body\": \"'.$message.'\",\"title\":\"'.$title.'\"},\"notification\":{\"body\": \"'.$message.'\",\"title\":\"'.$title.'\"}}"');
    }
}