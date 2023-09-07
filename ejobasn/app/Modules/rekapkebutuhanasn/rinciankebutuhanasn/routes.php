<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/rekapkebutuhanasn/rinciankebutuhanasn', '\App\Modules\rekapkebutuhanasn\rinciankebutuhanasn\Controllers\RinciankebutuhanasnController');

Route::post('/rekapkebutuhanasn/rinciankebutuhanasn/data/{view}', '\App\Modules\rekapkebutuhanasn\rinciankebutuhanasn\Controllers\RinciankebutuhanasnController@postData');

Route::post('/rekapkebutuhanasn/rinciankebutuhanasn/excel/{view}', '\App\Modules\rekapkebutuhanasn\rinciankebutuhanasn\Controllers\RinciankebutuhanasnController@postExcel');
});