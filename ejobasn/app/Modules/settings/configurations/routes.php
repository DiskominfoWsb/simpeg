<?php 
Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){
    Route::controller('/settings/configurations', '\App\Modules\settings\configurations\Controllers\ConfigurationsController');
});