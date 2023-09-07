<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/eformasi/inputkebutuhancpnsdanpppk', '\App\Modules\eformasi\inputkebutuhancpnsdanpppk\Controllers\InputkebutuhancpnsdanpppkController');
	
Route::post('/eformasi/inputkebutuhancpnsdanpppk/data', '\App\Modules\eformasi\inputkebutuhancpnsdanpppk\Controllers\InputkebutuhancpnsdanpppkController@postData');

});

