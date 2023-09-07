<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

	Route::controller('/eformasi/kebutuhanjabatan', '\App\Modules\eformasi\kebutuhanjabatan\Controllers\KebutuhanjabatanController');
	
	Route::post('/eformasi/kebutuhanjabatan/data/{view}', '\App\Modules\eformasi\kebutuhanjabatan\Controllers\KebutuhanjabatanController@postData');
	Route::get('/eformasi/kebutuhanjabatan/print/{view}/{idskpd}/{periode_bulan}/{periode_tahun}', '\App\Modules\eformasi\kebutuhanjabatan\Controllers\KebutuhanjabatanController@getPrint');
	Route::get('/eformasi/kebutuhanjabatan/excel/{view}/{idskpd}/{periode_bulan}/{periode_tahun}', '\App\Modules\eformasi\kebutuhanjabatan\Controllers\KebutuhanjabatanController@getExcel');


});

