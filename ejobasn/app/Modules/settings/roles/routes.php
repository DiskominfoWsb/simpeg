<?php
Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){
    Route::controller('/settings/roles', '\App\Modules\settings\roles\Controllers\RolesController');
});