<?php


// Route::group(['as' => 'crm.', 'prefix' => 'crm'], function () {
// 	Route::get('/', 'CrmController@index')->name('index');
	
// });

// Route::get('/', 'CrmController@index')->name('index');

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix'=>'provider','as'=>'provider.'],function(){
Route::resource('documents', 'ProviderResources\DocumentController');
Route::resource('document', 'ProviderResources\DocumentController');
Route::resource('provider', 'Resource\ProviderInCrmResource');
Route::get('/disapprove','Resource\ProviderInCrmResource@disapprove')->name('disapprove');
Route::get('/approve','Resource\ProviderInCrmResource@approve')->name('approve');
Route::get('/request','Resource\ProviderInCrmResource@request')->name('request');
Route::get('/statement','Resource\ProviderInCrmResource@statement')->name('statement');
Route::get('provider/{id}/approve', 'Resource\ProviderDocumentCrmResource@approve')->name('approve');
Route::get('{id}/disapprove', 'Resource\ProviderDocumentCrmResource@disapprove')->name('disapprove');
Route::get('{id}/request', 'Resource\ProviderDocumentCrmResource@request')->name('request');
Route::get('{id}/statement', 'Resource\ProviderDocumentCrmResource@statement')->name('statement');
Route::resource('{provider}/document', 'Resource\ProviderDocumentCrmResource');
Route::delete('{provider}/service/{document}', 'Resource\ProviderDocumentCrmResource@service_destroy')->name('document.service');
Route::get('{provider}/document/{document}/upload', 'Resource\ProviderDocumentCrmResource@get_provider_document_upload');
Route::post('{provider}/document/{document}/upload', 'Resource\ProviderDocumentCrmResource@provider_document_upload');
Route::get('{provider}/document/{document}/update', 'Resource\ProviderDocumentCrmResource@edit_provider_document_upload');
Route::post('{provider}/document/{document}/update', 'Resource\ProviderDocumentCrmResource@update_provider_document_upload');
});
// Route::get('/provider', [ 'as' => 'crm.provider.disapprove', 'uses' => 'Resource\ProviderInCrmResource@disapprove']);


Route::get('map', 'CrmController@live');

Route::resource('user', 'Resource\UserInCrmResource');
Route::resource('provider', 'Resource\ProviderInCrmResource');
Route::resource('requests', 'Resource\TripInCrmResource');

Route::get('onGoingTrip', 'Resource\TripInCrmResource@onGoingTrip');
Route::get('cancelTrip', 'Resource\TripInCrmResource@cancelTrip');
Route::get('scheduledTrip', 'Resource\TripInCrmResource@scheduledTrip');
Route::get('completedTrip', 'Resource\TripInCrmResource@completedTrip');

Route::get('user/{id}/request', 'Resource\UserInCrmResource@request')->name('user.request');
Route::get('/', 'CrmController@dashboard')->name('index');
Route::get('/dashboard', 'CrmController@dashboard')->name('dashboard');
Route::get('/contact', 'CrmController@contact')->name('contact');
Route::delete('/destroy/{id}', 'CrmController@destroy')->name('destroy');
 

Route::get('profile', 'CrmController@profile')->name('profile');
Route::post('profile', 'CrmController@profile_update')->name('profile.update');

Route::get('password', 'CrmController@password')->name('password');
Route::post('password', 'CrmController@password_update')->name('password.update');
Route::get('/complaint', 'CrmController@complaint')->name('complaint');
Route::get('/complaint-details/{id}', 'CrmController@complaintDetails')->name('complaintDetails');
Route::patch('/transfer/{id}', 'CrmController@transfer')->name('transfer');
Route::get('/lost-management', 'CrmController@lost_management')->name('lost-management');
Route::delete('/lost-destroy/{id}', 'CrmController@lost_destroy')->name('lost-destroy');


Route::get('get-locations/{type?}', 'LiveTrip@index');
Route::get('get-details/{type}/{id}', 'LiveTrip@getDetails');

