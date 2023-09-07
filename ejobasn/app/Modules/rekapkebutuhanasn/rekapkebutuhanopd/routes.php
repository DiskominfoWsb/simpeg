<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/rekapkebutuhanasn/rekapkebutuhanopd', '\App\Modules\rekapkebutuhanasn\rekapkebutuhanopd\Controllers\RekapkebutuhanopdController');

Route::post('/rekapkebutuhanasn/rekapkebutuhanopd/data/{view}', '\App\Modules\rekapkebutuhanasn\rekapkebutuhanopd\Controllers\RekapkebutuhanopdController@postData');

Route::post('/rekapkebutuhanasn/rekapkebutuhanopd/excel/{view}', '\App\Modules\rekapkebutuhanasn\rekapkebutuhanopd\Controllers\RekapkebutuhanopdController@postExcel');

});