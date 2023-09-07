<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/pengisian/rumpunpendidikan', '\App\Modules\pengisian\rumpunpendidikan\Controllers\RumpunpendidikanController');

});

