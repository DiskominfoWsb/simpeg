<?php 
Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){
    Route::controller('/settings/users', '\App\Modules\settings\users\Controllers\UsersController');    
});
