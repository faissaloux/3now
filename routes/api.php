<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/signup' , 'UserApiController@signup');

Route::post('/auth/facebook', 'Auth\SocialLoginController@facebookViaAPI');
Route::post('/auth/google', 'Auth\SocialLoginController@googleViaAPI');

Route::post('/forgot/password',     'UserApiController@forgot_password');
Route::post('/reset/password',      'UserApiController@reset_password');


Route::group(['middleware' => ['auth:api']], function () {
	
	
	Route::post('/save/android/token' , 'UserApiController@androidToken');
	Route::post('/save/ios/token' , 'UserApiController@iosToken');
	
	Route::post('/currentProdiverLocation' , 'UserApiController@currentProdiverLocation');

	Route::post('/tips' , 'UserApiController@tips');

	Route::post('/coupon/verfiy' , 'UserApiController@coupon');


	Route::post('/request/get' , 'UserApiController@getRequest');

	Route::post('/request/paied' , 'UserApiController@paied');

	
	Route::post('/send/email' , 'UserApiController@contactme');
	
	
	Route::post('/payment/price' , 'UserApiController@calculatePrice');  
	
    Route::post('/review' , 'UserApiController@review');
    Route::post('/getvalidzone' , 'UserApiController@getvalidzone');
    
    Route::get('/notification' , 'UserApiController@notification');
	// user profile
    Route::post('/logout' , 'UserApiController@logout');
    
    Route::post('/match-location' , 'UserApiController@match_location');
    
	Route::post('/change/password' , 'UserApiController@change_password');

	Route::post('/update/location' , 'UserApiController@update_location');

	Route::get('/details' , 'UserApiController@details');

	Route::post('/update/profile' , 'UserApiController@update_profile');
	// services
	Route::get('/services' , 'UserApiController@services');
	// provider
	Route::post('/rate/provider' , 'UserApiController@rate_provider');
	Route::get('check/rate/provider' , 'UserApiController@check_rate_provider');
	
	// request
	//Route::post('/send/request' , 'UserApiController@send_request');
	Route::post('/send/request' , 'RequestsController@send_request');
    
	//Route::get('/estimated/fare' , 'UserApiController@estimated_fare');
	Route::get('/estimated/fare' , 'RequestsController@estimated_fare');
	Route::get('/estimated/fare/all' , 'RequestsController@estimated_fare_all');


	/* Douted , ask ahmed **/ 
	Route::post('/send/request/schedule' , 'UserApiController@save_schedule');
    
    /*  */
    Route::post('/save/request/schedule' , 'UserApiController@save_schedule');

    
	Route::post('/send/payement/schedule' , 'UserApiController@send_schedule_payment');
	Route::post('/cancel/request' , 'UserApiController@cancel_request');
	
	Route::get('/request/check' , 'UserApiController@request_status_check');
	Route::get('/show/providers' , 'UserApiController@show_providers');
	
	// history
	Route::get('/trips' , 'UserApiController@trips');
	Route::get('upcoming/trips' , 'UserApiController@upcoming_trips');
    Route::get('trips/current' , 'UserApiController@getCurrentTrips');
	
	Route::get('/trip/details' , 'UserApiController@trip_details');
	Route::get('upcoming/trip/details' , 'UserApiController@upcoming_trip_details');
	// payment
	Route::post('/payment' , 'PaymentController@paymentStripe');  
	Route::post('/payment/new' , 'PaymentController@paymentStripeNew');  
	
	Route::post('/paymentPaypal' , 'PaymentController@paymentPaypal'); 


		Route::post('/payment/paypal' , 'PaymentController@Paypalpayment'); 




	Route::post('/add/money' , 'PaymentController@add_money');
	// estimated
	Route::get('/estimated/all_fares' , 'UserApiController@estimated_fare_new');
	// help
	Route::get('/help' , 'UserApiController@help_details');
	// promocode
	Route::get('/promocodes' , 'UserApiController@promocodes');
	Route::post('/promocode/add' , 'UserApiController@add_promocode');
	Route::post('/promocode/remove' , 'UserApiController@remove_promocode');
	// card payment
    Route::resource('card', 'Resource\CardResource');
	//Chat
	Route::get('/firebase/getChat' , 'UserApiController@getChat');
    Route::post('/createDefaultLocation' , 'UserApiController@createDefaultLocation');
    Route::post('/createComplaint' , 'UserApiController@create_complaint');
	Route::get('/notification', 'UserApiController@notification');
	Route::get('/payment/now','PaymentController@payment_before_request');
	Route::get('/test', 'UserApiController@test');
});