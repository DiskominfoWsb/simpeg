<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/pengisian/analisajabatan', '\App\Modules\pengisian\analisajabatan\Controllers\AnalisajabatanController');

});

