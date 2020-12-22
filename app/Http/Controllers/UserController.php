<?php
namespace App\Http\Controllers;

class UserController extends Controller {
    public function saveAndroidToken() {
        $user = \Auth::user();
        $user->android_token = $_POST['android_token'];
        $user->save();
    }
    public function saveIosToken() {
        $user = \Auth::user();
        $user->ios_token = $_POST['ios_token'];
        $user->save();
    }
}