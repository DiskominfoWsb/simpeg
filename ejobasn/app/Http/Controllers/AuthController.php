<?php

namespace App\Http\Controllers;

use View, Validator, Input, Session, Redirect, Auth;

class AuthController extends Controller {
	
	public function getIndex(){
		return View::make("claravel::portal.index");
	}

	public function getTest(){
		die('Sukses Bro');
	}


	public function getPass(){
            cekAjax();
            return View::make("home::dashboard.pass");                
	}
	public function postPass(){
            cekAjax();
            $input = Input::all();
            unset($input['_token']);
            $a = \UsersModel::find($input['id']);
            $cek = \Hash::check($input['password'], $a->password);
            if(!$cek){
                die('Password Lama Anda Salah');
            }else{
                if($input['password_baru1'] === $input['password_baru2']){
                    if(!ctype_alnum($input['password_baru1'])){
                        die('Hanya Boleh Huruf dan Angka');
                    }
                    $ubah = $a->update(array('password' => \Hash::make($input['password_baru1'])));
                    echo ($ubah)?4:0;                    
                }else{
                    die('Konfirmasi Password Tidak Cocok');
                }
                
            }
	}
        
	public function getProfil(){
            cekAjax();
            return View::make("home::dashboard.profil");                
	}

	public function postProfil(){
            cekAjax();
            $input = Input::all();
            unset($input['_token']);
	        if (Input::hasFile('foto')){
	            $destinationPath = base_path().'/packages/upload/photo/'.\Session::get('user_id');
	            $mode = 0777;
	            $recursive = false;
	            $f = Input::file('foto');
	                if($f != ''){
	                    $destinationPath = str_replace("\\", '/', $destinationPath);
	                    if(!is_dir($destinationPath)){
	                        mkdir($destinationPath, $mode, $recursive);
	                    }
	    //                die($destinationPath);
	                    $tipefile = $f->getClientOriginalExtension();
	                    $filename = str_replace(' ', '-', $f->getClientOriginalName());
	                    @unlink($destinationPath.'/'.$filename);
	                    $f->move($destinationPath, $filename);
	                    $input['foto'] = $filename;                    
	                }
	        }else{
	        }
            $ubah = \UsersModel::find($input['id'])->update($input);
            echo ($ubah)?4:0;
	}



	public function postLogin(){
		// validate the info, create rules for the inputs
		$rules = array(
			'username'    => 'required', // make sure the email is an actual email
			'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(\Input::all(), $rules);
		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			\Session::put('msgerr', 'Harap isi username dan password');
			return Redirect::to('/')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {

			// create our user data for the authentication
			$userdata = array(
				'username' 	=> Input::get('username'),
				'password' 	=> Input::get('password')
			);

			// attempt to do the login
			if (Auth::attempt($userdata)) {
				$role = \DB::table('roles')
				->where('id','=',Auth::user()->role_id)
				->first()->name;
				$rolesModel = \RolesModel::find(Auth::user()->role_id);
				\Session::put('role_id', Auth::user()->role_id);
				\Session::put('role', $role);                                    
				\Session::put('user_id', Auth::user()->id);
				\Session::put('user_name', Auth::user()->username);
				\Session::put('name', Auth::user()->name);
				\Session::put('foto', Auth::user()->foto);
				\Session::put('idskpd', Auth::user()->idskpd);

				
				$pms = \PermissionsmatrixModel::with(array('permissions'=> function($q){
					$q->where('name' ,'=', 'site-login');
				}))->where('role_id', \Session::get('role_id'))->get();
				
				if ($pms->count() > 0){
					return Redirect::to('/'.$rolesModel->login_destination);
				}else{
					Auth::logout();
					\Session::flush();
					\Session::put('msgerr', 'You don\'t have permission to sign in into this applications.');
					return Redirect::to('/'); 
				}
				
				

			} else {	 	
				\Session::put('msgerr', 'Kombinasi username dan password salah');
				return Redirect::to('/');
				//return Redirect::to('/login');

			}

		}
	}

    /*function untuk mendapatkan graph jabatan struktural*/
    public function getGraphstruktural(){
    	if(session('role_id') <= 3){
    	$rs = \DB::connection('kepegawaian')->table('tb_01')->where('idstspeg', 2)
					->where('idjenjab', '>', 4)
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();

        $kebutuhan = \DB::table('tr_petajab')
                    ->select(\DB::raw("SUM(abk) as count"))
					->where('idjenjab','>', 4)
                    ->first();
        $kekurangan = $rs - $kebutuhan->count;
        } else {
        	$rs = \DB::connection('kepegawaian')->table('tb_01')->where('idstspeg', 2)
					->where('idjenjab', '>', 4)
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();

        	$kebutuhan = \DB::table('tr_petajab')
                    ->select(\DB::raw("SUM(abk) as count"))
					->where('idjenjab','>', 4)->where('idskpd','like',''.session("idskpd"). '%')
                    ->first();
            $kekurangan = $rs - $kebutuhan->count;
        }

        // $categories = "ketersediaan,Jumlah PNS";
        // echo $categories."\r\n";
        // echo "Ketersediaan,".$rs."\r\n";
        // echo "Kebutuhan,".$kebutuhan->count."\r\n";
        // if($kekurangan <= 0){
        // 	echo "Kekurangan,".$kekurangan."\r\n";
        // } else {
        // 	echo "Kelebihan,".$kekurangan."\r\n";
		// }
		
		$ret['ketersediaan'] = $rs;
        $ret['kebutuhan'] = (int)$kebutuhan->count;
        $ret['kekurangan'] = $kekurangan;

        return $ret;
    }

    /*function untuk mendapatkan graph pns*/
    public function getGraphpns(){

    	if(session('role_id') <= 3){
			$rs = \DB::connection('kepegawaian')->table('tb_01')->where('idstspeg', 2)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();
	               
	        $kebutuhan = \DB::table('tr_petajab')
	                    ->select(\DB::raw("SUM(abk) as count"))
	                    ->first();

	        $kekurangan = $rs - $kebutuhan->count;
    	} else {
    		$rs = \DB::connection('kepegawaian')->table('tb_01')->where('idstspeg', 2)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();
	               
	        $kebutuhan = \DB::table('tr_petajab')
	                    ->select(\DB::raw("SUM(abk) as count"))->where('idskpd','like',''.session("idskpd"). '%')
	                    ->first();

	        $kekurangan = $rs - $kebutuhan->count;
    	}
        $ret['ketersediaan'] = $rs;
        $ret['kebutuhan'] = (int)$kebutuhan->count;
        $ret['kekurangan'] = $kekurangan;

        return $ret;
    }

    /*function untuk mendapatkan graph jabatan fungsional*/
    public function getGraphfungsional(){
    	if(session('role_id') <= 3){

	    	$rs = \DB::connection('kepegawaian')->table('tb_01')->where('idstspeg', 2)
						->where('idjenjab', 2)
	                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();

	        $kebutuhan = \DB::table('tr_petajab')
	                    ->select(\DB::raw("SUM(abk) as count"))
						->where('idjenjab','=', 2)
	                    ->first();

	        $kekurangan = $rs - $kebutuhan->count;
	    } else {
		   	$rs = \DB::connection('kepegawaian')->table('tb_01')->where('idstspeg', 2)
						->where('idjenjab', 2)
	                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();

	        $kebutuhan = \DB::table('tr_petajab')
	                    ->select(\DB::raw("SUM(abk) as count"))
						->where('idjenjab','=', 2)->where('idskpd','like',''.session("idskpd"). '%')
	                    ->first();

	        $kekurangan = $rs - $kebutuhan->count;
	    }
        
        $ret['ketersediaan'] = $rs;
        $ret['kebutuhan'] = (int)$kebutuhan->count;
        $ret['kekurangan'] = $kekurangan;

        return $ret;
    }

    /*function untuk mendapatkan graph jabatan pelaksana*/
    public function getGraphpelaksana(){

    	if(session('role_id') <= 3){
	    	$rs = \DB::connection('kepegawaian')->table('tb_01')->where('idstspeg', 2)
						->where('idjenjab', 3)
	                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();

	        $kebutuhan = \DB::table('tr_petajab')
	                    ->select(\DB::raw("SUM(abk) as count"))
						->where('idjenjab','=', 3)
	                    ->first();

	        $kekurangan = $rs - $kebutuhan->count;
	    } else {
	    	$rs = \DB::connection('kepegawaian')->table('tb_01')->where('idstspeg', 2)
					->where('idjenjab', 3)
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();

	        $kebutuhan = \DB::table('tr_petajab')
	                    ->select(\DB::raw("SUM(abk) as count"))
						->where('idjenjab','=', 3)->where('idskpd','like',''.session("idskpd"). '%')
	                    ->first();

	        $kekurangan = $rs - $kebutuhan->count;
	    }

        
        $ret['ketersediaan'] = $rs;
        $ret['kebutuhan'] = (int)$kebutuhan->count;
        $ret['kekurangan'] = $kekurangan;

        return $ret;
    }

	public function getLogout(){
		Auth::logout();
		\Session::flush();

        return 1;
	}

	public function getLoginfsimpegadm(){
        // validate the info, create rules for the inputs
        $rules = array(
            'username' => 'required', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('/login')
                            ->withErrors($validator) // send back all errors to the login form
                            ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            // create our user data for the authentication
            $userdata = array(
                'username' => Input::get('username'),
                'password' => Input::get('password')
            );
            // attempt to do the login
            if (Auth::attempt($userdata)) {
                $role = \DB::table('roles')
                ->where('id','=',Auth::user()->role_id)
                ->first()->name;
                $rolesModel = \RolesModel::find(Auth::user()->role_id);
                \Session::put('role_id', Auth::user()->role_id);
                \Session::put('role', $role);                                    
                \Session::put('user_id', Auth::user()->id);
                \Session::put('user_name', Auth::user()->username);
                \Session::put('name', Auth::user()->name);
                \Session::put('foto', Auth::user()->foto);
                \Session::put('idskpd', Auth::user()->idskpd);
                \Session::put('key', Input::get('password'));
                $data = array(
                    'id_user' => Auth::user()->id,
                    'login_time' => date('Y-m-d H:i:s'),
                    'ip' => \Request::ip(),
                    'browser' => $_SERVER['HTTP_USER_AGENT']
                );

                $pms = \PermissionsmatrixModel::with(array('permissions' => function($q) {
                                $q->where('name', '=', 'site-login');
                            }))->where('role_id', \Session::get('role_id'))->get();

                if ($pms->count() > 0) {
                    return Redirect::to('/' . $rolesModel->login_destination);
                } else {
                    Auth::logout();
                    \Session::flash('message', 'You don\'t have permission to sign in into this applications.');
                    return Redirect::to('/login');
                }
            } else {
                // return Redirect::to('/logindev');
                return Redirect::to('/login');
            }
        }
    }
}
