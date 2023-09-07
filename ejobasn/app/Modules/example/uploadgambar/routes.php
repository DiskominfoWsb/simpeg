<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/example/uploadgambar', 'App\Modules\example\uploadgambar\Controllers\UploadgambarController');

});