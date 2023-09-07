<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/pengisian/jabatanfungsional', '\App\Modules\pengisian\jabatanfungsional\Controllers\JabatanfungsionalController');

});

