<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SignInControlller extends Controller {
    //
    public function index() {
        return view('provider.auth.login');        
    }
    public function passengerSignin(Request $request) {
        session(['s_address' => $request->s_address, 'd_address' => $request->d_address, 's_latitude' => $request->s_latitude, 's_longitude' => $request->s_longitude, 'd_latitude' => $request->d_latitude, 'd_longitude' => $request->d_longitude, 'service_type' => $request->service_type]);
        return view('pages.passengersignin');
    }
}