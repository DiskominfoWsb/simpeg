<?php 
Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){
    Route::controller('/settings/permissions', '\App\Modules\settings\permissions\Controllers\PermissionsController');
});