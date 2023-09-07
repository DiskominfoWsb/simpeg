<?php namespace App\Modules\pengisian\jurusanpendidikan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pengisian\jurusanpendidikan\Models\JurusanpendidikanModel;
use Input,View, Request, Form, File;

/**
* Jurusanpendidikan Controller
* @var Jurusanpendidikan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JurusanpendidikanController extends Controller {
    protected $jurusanpendidikan;

    public function __construct(JurusanpendidikanModel $jurusanpendidikan){
        $this->jurusanpendidikan = $jurusanpendidikan;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $jurusanpendidikans = \DB::connection('kepegawaian')->table('a_jenjurusan')
                ->leftjoin('a_rumpunpendid', 'a_jenjurusan.idrumpunpendid', '=', 'a_rumpunpendid.idrumpunpendid')
                ->leftjoin('a_tkpendid', 'a_jenjurusan.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->select('a_jenjurusan.*', 'a_rumpunpendid.rumpunpendid', 'a_tkpendid.tkpendid')
                ->orderBy('a_tkpendid.idtkpendid', 'asc')
                ->orderBy('a_rumpunpendid.idrumpunpendid', 'asc')
                ->orderBy('a_jenjurusan.jenjurusan', 'asc')
                ->orWhere('a_jenjurusan.jenjurusan', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('a_jenjurusan.idtkpendid', 'LIKE', '%'.Input::get('search').'%')
                ->orWhere('a_jenjurusan.idrumpunpendid', 'LIKE', '%'.Input::get('search').'%')
                ->paginate(@\Session::get('configurations')['list-limit']);
            }else{
                $jurusanpendidikans = $this->jurusanpendidikan->all();
            }
        }else{
            $jurusanpendidikans = $this->jurusanpendidikan->all();
        }
        return View::make('jurusanpendidikan::index', compact('jurusanpendidikans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('jurusanpendidikan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        unset($input['_token']);
        $validation = \Validator::make($input, JurusanpendidikanModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo (\DB::connection('kepegawaian')->table('a_jenjurusan')->insert($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $jurusanpendidikan = \DB::connection('kepegawaian')->table('a_jenjurusan')->where('idjenjurusan','=',$id)->first();
        //if (is_null($jurusanpendidikan)){return \Redirect::to('pengisian/jurusanpendidikan/index');}
        return View::make('jurusanpendidikan::edit', compact('jurusanpendidikan'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idjenjurusan');
        $input = Input::all();
        unset($input['_token']);
        $validation = \Validator::make($input, JurusanpendidikanModel::$rules);
        
        if ($validation->passes()){
            echo (\DB::connection('kepegawaian')->table('a_jenjurusan')->where('idjenjurusan','=',$id)->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }


	
        public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                \DB::connection('kepegawaian')->table('a_jenjurusan')->where('idjenjurusan','=',$id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo (\DB::connection('kepegawaian')->table('a_jenjurusan')->where('idjenjurusan','=',$ids)->delete())?9:0;
        }
    }

}
