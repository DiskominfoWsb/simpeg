<?php

Route::group(['middleware' => 'auth', 'prefix' => '/'], function(){

Route::controller('/pengisian/jabatanfungsionalumum', '\App\Modules\pengisian\jabatanfungsionalumum\Controllers\JabatanfungsionalumumController');

});

