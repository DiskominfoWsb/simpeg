<?php
Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){
    Route::controller('/settings/permissionsmatrix', '\App\Modules\settings\permissionsmatrix\Controllers\PermissionsmatrixController');
});