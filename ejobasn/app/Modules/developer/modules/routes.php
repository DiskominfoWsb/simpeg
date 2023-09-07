<?php 
Route::group(['middleware' => 'auth', 'prefix' => '/'], function()
{
	Route::controller('/developer/modules', '\App\Modules\developer\modules\Controllers\ModulesController');			
});



