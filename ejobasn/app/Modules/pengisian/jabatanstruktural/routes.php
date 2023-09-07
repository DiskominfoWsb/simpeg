<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/pengisian/jabatanstruktural', '\App\Modules\pengisian\jabatanstruktural\Controllers\JabatanstrukturalController');

});

