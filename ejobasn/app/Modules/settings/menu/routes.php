<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/settings/menu', '\App\Modules\settings\menu\Controllers\MenuController');

});

