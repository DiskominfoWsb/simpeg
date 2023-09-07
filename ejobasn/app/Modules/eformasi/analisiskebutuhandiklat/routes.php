<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/eformasi/analisiskebutuhandiklat', '\App\Modules\eformasi\analisiskebutuhandiklat\Controllers\AnalisiskebutuhandiklatController');

Route::post('/eformasi/analisiskebutuhandiklat/data/{view}', '\App\Modules\eformasi\analisiskebutuhandiklat\Controllers\AnalisiskebutuhandiklatController@postData');

Route::post('/eformasi/analisiskebutuhandiklat/pdf/{view}', '\App\Modules\eformasi\analisiskebutuhandiklat\Controllers\AnalisiskebutuhandiklatController@postPdf');
});

