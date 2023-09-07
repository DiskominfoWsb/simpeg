<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/eformasi/petajabatan', '\App\Modules\eformasi\petajabatan\Controllers\PetajabatanController');

Route::post('/eformasi/petajabatan/data/{view}', '\App\Modules\eformasi\petajabatan\Controllers\PetajabatanController@postData');

Route::post('/eformasi/petajabatan/pdf/{view}', '\App\Modules\eformasi\petajabatan\Controllers\PetajabatanController@postPdf');

Route::post('/eformasi/petajabatan/excel/{view}', '\App\Modules\eformasi\petajabatan\Controllers\PetajabatanController@postExcel');

});