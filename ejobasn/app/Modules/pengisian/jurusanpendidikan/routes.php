<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/pengisian/jurusanpendidikan', '\App\Modules\pengisian\jurusanpendidikan\Controllers\JurusanpendidikanController');

});

