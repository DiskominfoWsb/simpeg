<?php 
/*
|--------------------------------------------------------------------------
| Modul User
|--------------------------------------------------------------------------
|
| All the routes related to the ModuleOne module have to go in here. Make sure
| to change the namespace in case you decide to change the 
| namespace/structure of controllers.
|
*/
Route::group(['prefix' => '/home', 'namespace' => 'App\Modules\home\Controllers'], function () {
	Route::get('/', ['as' => 'users.index', 'uses' => 'HomeController@index']);
	Route::get('users-test', ['as' => 'users.usersTest', 'uses' => 'HomeController@usersTest']);
});