<?php
use App\Modules\settings\configurations\Models\ConfigurationsModel;
use App\Modules\settings\permissionsmatrix\Models\PermissionsmatrixModel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function() {
    Route::get('/auth/login', function () {
        return view('home::login.index');
    });
    Route::get('/', function () {
    //     //mainkan Portal Disini
    //     //Remark line di bawah ini jika ada portal
        return view('home::login.index');
    });
    // Route::get('/auth/login', function () {
    //     return view('home::login.index');
    // });
    Route::post('/login', array('as' => 'dologin', 'uses'=>'AuthController@postLogin'));

    Route::get('/loginfsimpeg_adm', array('as' => 'loginfsimpeg_adm', 'uses' => 'AuthController@getLoginfsimpegadm'));

});
Route::group(['middleware' => ['auth']], function() {
    Route::get('/getnotifikasi', 'NotifikasiController@getIndex');
    Route::get('/test_pdf', function(){
        $contents = view('home::dashboard.test_pdf');
        $response = \Response::make($contents);
        $response->header('Content-Type', 'application/pdf');
        return $response;
    });    
    
    // Route::get('/login', function () {
    //     return view('home::login.index');
    // })->name('auth/login')->middleware('auth');



    // Route::get('/login', function () {
    //     return view('home::login.index');
    // })->name('auth/login')->middleware('auth');
    

    Route::get('/dashboard', function () {
        //set permission matrix
        $cms = \App\Modules\settings\configurations\Models\ConfigurationsModel::get();
        $configurations = array();
        foreach($cms as $cm){
            $configurations[$cm->name] = $cm->value;
        }
        $_ENV['configurations'] = $configurations;
        \Session::put('configurations', $configurations);
        $pms = \App\Modules\settings\permissionsmatrix\Models\PermissionsmatrixModel::with('permissions')->where('role_id', \Session::get('role_id'))->get();
        $roles = array();
        foreach($pms as $pm){
            @$roles[$pm->permission_id] = @$pm->permissions->name;
        }

        $_ENV['roles'] = $roles;
        \Session::put('roles', $roles);            
        return view('home::dashboard.index');
    });    

    Route::get('/profil', array('uses'=>'AuthController@getProfil'))->middleware('auth');
    Route::post('/profil', array('uses'=>'AuthController@postProfil'))->middleware('auth');
    Route::get('/pass', array('uses'=>'AuthController@getPass'))->middleware('auth');
    Route::post('/pass', array('uses'=>'AuthController@postPass'))->middleware('auth');

    Route::get('/graphpns', array('uses'=>'AuthController@getGraphpns'));
    Route::get('/graphstruktural', array('uses'=>'AuthController@getGraphstruktural'));
    Route::get('/graphfungsional', array('uses'=>'AuthController@getGraphfungsional'));
    Route::get('/graphpelaksana', array('uses'=>'AuthController@getGraphpelaksana'));

    Route::get('/beranda', function() {
        if(\Input::has('tab')) {
            //set permission matrix
            $cms = \App\Modules\settings\configurations\Models\ConfigurationsModel::get();
            $configurations = array();
            foreach($cms as $cm){
                $configurations[$cm->name] = $cm->value;
            }
            $_ENV['configurations'] = $configurations;
            \Session::put('configurations', $configurations);
            $pms = \App\Modules\settings\permissionsmatrix\Models\PermissionsmatrixModel::with('permissions')->where('role_id', \Session::get('role_id'))->get();
            $roles = array();
            foreach($pms as $pm){
                @$roles[$pm->permission_id] = @$pm->permissions->name;
            }

            $_ENV['roles'] = $roles;
            \Session::put('roles', $roles);            

            return view('home::dashboard.index-redirect', [
                'redirect_url' => url(urldecode(\Input::get('tab'))),
                'query_string_url' => http_build_query(\Request::except('tab')),
            ]);
        } else {
            return redirect('/dashboard');
        }
    });
});


//Untuk menangani route ketika ke-logout atau session habis
// Route::get('/login', function () {
//     return view('home::login.index');
// })->name('auth/login')->middleware('guest');

// Route::get('/login', function () {
//     return view('home::login.index');
// })->name('login')->middleware('guest');

//Unremark di bawah ini jika ada Portal
/*
Route::get('/', function () {
    die('Portal hehe');
});    
*/

Route::get('test_excel', function(){
//        $contents = view('home::dashboard.test_pdf');
//        $response = \Response::make($contents);
//        $response->header('Content-Type', 'application/pdf');
//        return $response;
    return view('home::dashboard.test_excel');
})->middleware('auth');

Route::get('/logout', array('as' => 'logout', 'uses'=>'AuthController@getLogout'));

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
});
// Clear View cache
Route::get('/clear-view', function() {
    $exitCode = Artisan::call('view:clear');
});
// Clear Config cache
Route::get('/clear-config', function() {
    $exitCode = Artisan::call('config:clear');
});