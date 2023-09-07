<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/rekapkebutuhanasn/rekapkebutuhanglobal', '\App\Modules\rekapkebutuhanasn\rekapkebutuhanglobal\Controllers\RekapkebutuhanglobalController');


Route::post('/rekapkebutuhanasn/rekapkebutuhanglobal/data/{view}', '\App\Modules\rekapkebutuhanasn\rekapkebutuhanglobal\Controllers\RekapkebutuhanglobalController@postData');

Route::post('/rekapkebutuhanasn/rekapkebutuhanglobal/excel/{view}', '\App\Modules\rekapkebutuhanasn\rekapkebutuhanglobal\Controllers\RekapkebutuhanglobalController@postExcel');

});