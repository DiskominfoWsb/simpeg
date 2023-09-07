<?php 
Route::group(['middleware' => 'auth', 'prefix' => '/'], function()
{
    Route::controller('/developer/context', '\App\Modules\developer\context\Controllers\ContextController');

});


