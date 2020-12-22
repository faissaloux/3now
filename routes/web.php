<?php
/*
|--------------------------------------------------------------------------
| User Authentication Routes
|--------------------------------------------------------------------------
*/



Auth::routes();




/*  Statique Pages */
Route::get('/','StatiquePagesController@home');
Route::get('/page/about','StatiquePagesController@about');
Route::get('/page/impressum','StatiquePagesController@impressum');
Route::get('/page/how-it-works','StatiquePagesController@howitworks');
Route::get('/page/privacy-policy','StatiquePagesController@privacypolicy');
Route::get('/page/agb','StatiquePagesController@agb');
Route::get('/page/terms-and-conditions','StatiquePagesController@termsandconditions');
Route::get('/page/datenschutz','StatiquePagesController@datenschutz');
Route::get('/clear-cache','StatiquePagesController@clear');
Route::get('/info','StatiquePagesController@info');
Route::get('/usage','StatiquePagesController@usage');


Route::get('/enable/debug/mode','StatiquePagesController@enableDebug');
Route::get('/disable/debug/mode','StatiquePagesController@disableDebug');



Route::get('/ok1', 'DevController@ok1');
Route::get('/delete/log', 'DevController@deleteLog');
Route::get('/test/notification', 'DevController@testNotification');
Route::get('/google/api/check', 'DevController@checkGoogleApi');
Route::get('/web/google-keys', 'DevController@googleKeys');


Route::post('/assignRequestToProvider','WebOrderController@assignRequestToProvider');
Route::post('/sendEmail','WebOrderController@SendEmail');



Route::post('/save/android/token', 'UserController@saveAndroidToken');
Route::post('/save/ios/token', 'UserController@saveIosToken');

Route::post('/changeProvider/by/admin', 'AdminController@changeProvider');

/* website order */
Route::post('/save/scheduled/order', 'WebOrderController@save_order');
Route::get('/web/order/saveOrder', 'WebOrderController@saveOrder');
Route::post('/web/order/getPrices', 'WebOrderController@getPrices');
Route::any('/web/payment', 'WebOrderController@payment');
Route::get('/web/payment/paypal/success', 'WebOrderController@success')->name('paypal.success');
Route::get('/web/payment/paypal/faild', 'WebOrderController@faild')->name('paypal.faild');
Route::get('/thankyou', 'WebOrderController@thankyou')->name('paypal.thankyou');
Route::get('stripe', 'WebOrderController@stripe');
Route::post('stripe', 'WebOrderController@stripePost')->name('stripe.post');


Route::post('payWithStripe', 'WebOrderController@payWithStripe');
Route::get('get/order/{id}', 'WebOrderController@getOrder');



// paypal for ios
Route::get('web/paypal', 'WebOrderController@iospaypal');
Route::get('ios/web/paypal/success/', 'WebOrderController@iospaypalSuccess')->name('ios.paypal.success');
Route::get('ios/web/paypal/failed', 'WebOrderController@iospaypalFailed')->name('ios.paypal.faild');



/* Email verifaction emails */
Route::post('/check/user/email','WebOrderController@user_check_email');
Route::post('/check/provider/email','WebOrderController@provider_check_email');


Route::post('/update/user/password','WebOrderController@user_update_password');
Route::post('/update/provider/password','WebOrderController@provider_update_password');



Route::get('auth/facebook', 'Auth\SocialLoginController@redirectToFaceBook');
Route::get('auth/facebook/callback', 'Auth\SocialLoginController@handleFacebookCallback');
Route::get('auth/google', 'Auth\SocialLoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\SocialLoginController@handleGoogleCallback');
Route::post('account/kit', 'Auth\SocialLoginController@account_kit')->name('account.kit');



//Route::get('/searchingajax', 'AdminController@searchingajax');
/*
|--------------------------------------------------------------------------
| Provider Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'provider'], function () {

    Route::get('auth/facebook', 'Auth\SocialLoginController@providerToFaceBook');
    Route::get('auth/google', 'Auth\SocialLoginController@providerToGoogle');

    Route::get('/login', 'ProviderAuth\LoginController@showLoginForm')->middleware('accesspage');
    Route::post('/login', 'ProviderAuth\LoginController@login');
    Route::post('/logout', 'ProviderAuth\LoginController@logout');

    Route::get('/register', 'ProviderAuth\RegisterController@showRegistrationForm')->middleware('accesspage');
    Route::post('/register', 'ProviderAuth\RegisterController@register');

    Route::post('/password/email', 'ProviderAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ProviderAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'ProviderAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'ProviderAuth\ResetPasswordController@showResetForm');
    Route::post('/password/update', 'CommonController@provider_password_update');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/




Route::group(['prefix' => 'admin'], function () {
    Route::get('/searchingajax', 'CommonController@searchingajax');
    Route::get ('/offnotificationtoprovider' , 'SendPushNotification@offnotificationtoprovider');
    
    Route::get ('/provider-document-expiry-notification' , 'CommonController@providerDocumentExpiryNotification');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->middleware('accesspage');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Dispatcher Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'dispatcher'], function () {
    
  Route::get('/login', 'DispatcherAuth\LoginController@showLoginForm')->middleware('accesspage');
  Route::post('/login', 'DispatcherAuth\LoginController@login');
  Route::post('/logout', 'DispatcherAuth\LoginController@logout');

  Route::post('/password/email', 'DispatcherAuth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'DispatcherAuth\ResetPasswordController@reset');
  Route::get('/password/reset', 'DispatcherAuth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'DispatcherAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Fleet Authentication Routes
|--------------------------------------------------------------------------
*/


Route::group(['prefix' => 'fleet'], function () {
  Route::get('/login', 'FleetAuth\LoginController@showLoginForm')->middleware('accesspage');
  Route::post('/login', 'FleetAuth\LoginController@login');
  Route::post('/logout', 'FleetAuth\LoginController@logout');

  Route::post('/password/email', 'FleetAuth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'FleetAuth\ResetPasswordController@reset');
  Route::get('/password/reset', 'FleetAuth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'FleetAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



Route::post('/get_fare', 'AjaxHandlerController@estimated_fare')->name('getfare');
Route::post('/saveLocationTemp', 'AjaxHandlerController@saveLocationTemp');

Route::post('/locale', 'CommonController@locale' );
Route::get('/fare_estimate', 'CommonController@fare_estimate');
Route::get('/helppage', 'CommonController@helpPage');


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| My Files
|--------------------------------------------------------------------------
*/
//User sign in

Route::get('/PassengerSignin', 'SignInControlller@passengerSignin')->middleware('accesspage');

Route::get('/faq', 'HomeController@faqs');
Route::get('/terms', 'HomeController@terms');
Route::get('/help', 'HomeController@helps');

Route::get('/dashboard', 'HomeController@index');
Route::get('/mytrips', 'HomeController@mytrips');
Route::get('/mytrips/detail', 'HomeController@mytrips_details');

// user profiles
Route::get('/profile', 'HomeController@profile');
Route::get('/edit/profile', 'HomeController@edit_profile');
Route::post('/profile', 'HomeController@update_profile');

// update password
Route::get('/change/password', 'HomeController@change_password');
Route::post('/change/password', 'HomeController@update_password');
Route::post('/password/update', 'CommonController@password_update'); 


// ride 
Route::get('/confirm/ride', 'RideController@confirm_ride');
Route::post('/create/ride', 'RideController@create_ride');
Route::post('/cancel/ride', 'RideController@cancel_ride');
Route::get('/onride', 'RideController@onride');
Route::post('/payment', 'PaymentController@payment');
Route::post('/rate', 'RideController@rate');


// PromoCodes
Route::post('/apply_promo_code', 'AjaxHandlerController@applyPromoCodeOnEstimatedFare');

Route::get('/service_types', 'Resource\ServiceResource@index');
Route::post('/get_fare', 'AjaxHandlerController@estimated_fare');

// status check
Route::get('/status', 'RideController@status');

// trips 
Route::get('/trips', 'HomeController@trips');
Route::get('/upcoming/trips', 'HomeController@upcoming_trips');
Route::get('/upcoming/trips/detail', 'HomeController@upcoming_trips_details');

// wallet
Route::get('/wallet', 'HomeController@wallet');
Route::post('/add/money', 'PaymentController@add_money');

// payment
Route::get('/payment', 'HomeController@payment');

// card
Route::resource('card', 'Resource\CardResource');

// promotions
Route::get('/promotions', 'HomeController@promotions_index')->name('promocodes.index');
Route::post('/promotions', 'HomeController@promotions_store')->name('promocodes.store');




Route::group(['prefix' => 'account'], function () {
  Route::get('/login', 'AccountAuth\LoginController@showLoginForm');
    Route::post('/login', 'AccountAuth\LoginController@login');
    Route::post('/logout', 'AccountAuth\LoginController@logout');

    Route::get('/register', 'AccountAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'AccountAuth\RegisterController@register');

    Route::post('/password/email', 'AccountAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AccountAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AccountAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AccountAuth\ResetPasswordController@showResetForm');
});


//common pages
Route::get('/support/complaint', 'CommonController@complaint')->name('complaints');
Route::post('/contact-us', 'CommonController@contact')->name('contact.us');
Route::post('/ajax-handler/contact', 'CommonController@sendMessage')->name('contact');
Route::post('/ajax-handler/complaint', 'CommonController@complaint_form')->name('complaint');
Route::get('/contact_us', 'CommonController@contact_us')->name('contact_us');
Route::get('/blogs', 'CommonController@blogs')->name('blog.all');
Route::get('/blog/{id}','CommonController@blog_detail')->name('blogdetail');
Route::get('/lost-item', 'CommonController@lost_item')->name('lost_item');
Route::post('/ajax-handler/lost-item', 'CommonController@lostItemForm')->name('lost_item_form');

Route::get('/user', 'CommonController@user');
Route::get('/driver', 'CommonController@driver');
Route::get('/cities', 'CommonController@cities');

Route::get('/how_it_works', 'CommonController@how_it_works');

Route::get('/help', 'CommonController@help');
Route::get('/login', 'SignInControlller@passengerSignin');
Route::get('/driver_story', 'CommonController@driver_story');
Route::get('/calculate_price', 'CommonController@calculate_price');
Route::get('/download_page', 'CommonController@download_page');
Route::get('/stories', 'CommonController@stories');
Route::get('/ride_overview', 'CommonController@ride_overview');
Route::get('/ride_safety', 'CommonController@ride_safety');
Route::get('/airports', 'CommonController@airports');
Route::get('/drive_overview', 'CommonController@drive_overview');
Route::get('/requirements', 'CommonController@requirements');
Route::get('/driver_app', 'CommonController@driver_app');
Route::get('/vehicle_solutions', 'CommonController@vehicle_solutions');
Route::get('/drive_safety', 'CommonController@drive_safety');
Route::get('/local', 'CommonController@local');
Route::get('/myliftx', 'CommonController@myliftx');
Route::get('/myliftxl', 'CommonController@myliftxl');
Route::get('/myliftxxl', 'CommonController@myliftxxl');
Route::get('/about-us', 'CommonController@about_us');
Route::get('/why-us', 'CommonController@why_us');
Route::get('/privacy-policy', 'CommonController@privacy');
Route::get('/refund-policy', 'CommonController@refund_policy');
Route::get('/terms-conditions', 'CommonController@terms_condition');

Route::group(['prefix' => 'cms'], function () { 
    Route::get('/login', 'CmsAuth\LoginController@showLoginForm');
    Route::post('/login', 'CmsAuth\LoginController@login');
    Route::post('/logout', 'CmsAuth\LoginController@logout');

    Route::post('/password/email', 'CmsAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'CmsAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'CmsAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'CmsAuth\ResetPasswordController@showResetForm');
});
/*
|--------------------------------------------------------------------------
| Crm Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'crm'], function () {
    Route::get('/login', 'CrmAuth\LoginController@showLoginForm');
    Route::post('/login', 'CrmAuth\LoginController@login');
    Route::post('/logout', 'CrmAuth\LoginController@logout');

    Route::post('/password/email', 'CrmAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'CrmAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'CrmAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'CrmAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'support'], function () {
    Route::get('/login', 'SupportAuth\LoginController@showLoginForm');
    Route::post('/login', 'SupportAuth\LoginController@login');
    Route::post('/logout', 'SupportAuth\LoginController@logout');

    Route::post('/password/email', 'SupportAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'SupportAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'SupportAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'SupportAuth\ResetPasswordController@showResetForm');
});