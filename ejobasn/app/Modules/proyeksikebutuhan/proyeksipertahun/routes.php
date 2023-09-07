<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/proyeksikebutuhan/proyeksipertahun', 'App\Modules\proyeksikebutuhan\proyeksipertahun\Controllers\ProyeksipertahunController');

});