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
// Authentication
Route::post('/register' , 'ProviderAuth\TokenController@register');
Route::post('/check-email' , 'ProviderAuth\TokenController@checkEmail');
Route::post('/check-mobile' , 'ProviderAuth\TokenController@checkMobile');
Route::post('/oauth/token' , 'ProviderAuth\TokenController@authenticate');
Route::post('/logout' , 'ProviderAuth\TokenController@logout');

Route::post('/auth/facebook', 'ProviderAuth\TokenController@facebookViaAPI');
Route::post('/auth/google', 'ProviderAuth\TokenController@googleViaAPI');

Route::post('/forgot/password',     'ProviderAuth\TokenController@forgot_password');
Route::post('/reset/password',      'ProviderAuth\TokenController@reset_password');
Route::post('document/upload', 'ProviderResources\DocumentController@updateDocuments');


Route::group(['middleware' => ['provider.api']], function () {


    Route::post('/save/android/token' , 'ProviderResources\TripController@androidToken');
    Route::post('/save/ios/token' , 'ProviderResources\TripController@iosToken');



    Route::get('/finished/current/month', 'ProviderResources\TripController@TotalFinishedcurrentMonth');
    Route::get('/finished/current/week', 'ProviderResources\TripController@TotalFinishedcurrentWeek');



    Route::post('/review' , 'ProviderResources\TripController@review');
    //Get Notification
    Route::post('/addNotification' , 'ProviderResources\TripController@addNotification');
    Route::get('/notification' , 'ProviderResources\TripController@notification');
    Route::get('document/checkDocument', 'ProviderResources\DocumentController@checkDocument');
    Route::get('document/status', 'ProviderResources\DocumentController@document_status');

    Route::post('/refresh/token' , 'ProviderAuth\TokenController@refresh_token');

    Route::group(['prefix' => 'profile'], function () {

        Route::get ('/' , 'ProviderResources\ProfileController@index');
        Route::post('/' , 'ProviderResources\ProfileController@update');
        Route::post('/password' , 'ProviderResources\ProfileController@password');
        Route::post('/location' , 'ProviderResources\ProfileController@location');
        Route::post('/available' , 'ProviderResources\ProfileController@available');

    });

    Route::get('/target' , 'ProviderResources\ProfileController@target');
    Route::resource('trip', 'ProviderResources\TripController');
    Route::post('cancel', 'ProviderResources\TripController@cancel');
    Route::post('summary', 'ProviderResources\TripController@summary');
    Route::get('help', 'ProviderResources\TripController@help_details');
    Route::post('verifyotp' , 'ProviderResources\TripController@verifyOtp');

    Route::group(['prefix' => 'trip'], function () {

        Route::post('{id}', 'ProviderResources\TripController@accept');
        Route::post('{id}/rate', 'ProviderResources\TripController@rate');
        Route::post('{id}/message' , 'ProviderResources\TripController@message');

    });

    Route::group(['prefix' => 'requests'], function () {

        Route::get('/upcoming' , 'ProviderResources\TripController@scheduled');
        Route::get('/history', 'ProviderResources\TripController@history');
        Route::get('/history/details', 'ProviderResources\TripController@history_details');
        Route::get('/upcoming/details', 'ProviderResources\TripController@upcoming_details');

    });
    Route::get('/addBank' , 'PaymentController@addBankAccount');
    Route::get('/withdrawaList' , 'ProviderResources\TripController@withdrawRequestList');
    Route::get('/withdrawalRequest' , 'ProviderResources\TripController@withdrawalRequest');
    Route::get('/BankList' , 'PaymentController@BankList');
    //chat
    Route::get('/firebase/getChat' , 'ProviderResources\TripController@getChat');
    Route::get('/firebase/chatHistory' , 'FirebaseController@chatHistoryProvider');
    Route::get('/firebase/dumy-notify' , 'ProviderResources\TripController@dummyNotify');
    Route::get('document/status', 'ProviderResources\DocumentController@document_status');
    Route::get('document/types', 'ProviderResources\DocumentController@getDocumentTypes');
	Route::get('/test', 'ProviderResources\TripController@test');
	
});