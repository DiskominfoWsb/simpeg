<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/proyeksikebutuhan/proyeksi5tahun', 'App\Modules\proyeksikebutuhan\proyeksi5tahun\Controllers\Proyeksi5tahunController');

});