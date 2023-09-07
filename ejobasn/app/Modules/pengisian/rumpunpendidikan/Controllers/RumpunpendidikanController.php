<?php namespace App\Modules\pengisian\rumpunpendidikan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pengisian\rumpunpendidikan\Models\RumpunpendidikanModel;
use Input,View, Request, Form, File;

class RumpunpendidikanController extends Controller {
    protected $rumpunpendidikan;

    public function __construct(RumpunpendidikanModel $rumpunpendidikan){
        $this->rumpunpendidikan = $rumpunpendidikan;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $rumpunpendidikans = \DB::connection('kepegawaian')->table('a_rumpunpendid')
				->orWhere('rumpunpendid', 'LIKE', '%'.Input::get('search').'%')
				->paginate(@\Session::get('configurations')['list-limit']);
            }else{
                $rumpunpendidikans = $this->rumpunpendidikan->all();
            }
        }else{
            $rumpunpendidikans = $this->rumpunpendidikan->all();
        }
        return View::make('rumpunpendidikan::index', compact('rumpunpendidikans'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('rumpunpendidikan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        unset($input['_token']);
        $validation = \Validator::make($input, RumpunpendidikanModel::$rules);
        if ($validation->passes()){
            if(isset($_POST['idtkpendid']))
            {
                $x  = 0;
                $jenis = '';
                $count = count($input['idtkpendid']);
                foreach($input['idtkpendid'] as $item){
                    $x++;
                    $mark = ($x != $count)?', ':'';
                    $jenis .= $item."".$mark;
                }

                $input['idtkpendid'] = $jenis;
            }else{
                $input['idtkpendid'] = '';
            }

            if(isset($_POST['idjenjurusan']))
            {
                $x  = 0;
                $jenis = '';
                $count = count($input['idjenjurusan']);
                foreach($input['idjenjurusan'] as $item){
                    $x++;
                    $mark = ($x != $count)?', ':'';
                    $jenis .= $item."".$mark;
                }

                $input['idjenjurusan'] = $jenis;
            }else{
                $input['idjenjurusan'] = '';
            }
            
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo (\DB::connection('kepegawaian')->table('a_rumpunpendid')->insert($input))?1:"Gagal Disimpan";
        }else{
            echo 'Input tidak valid';
        }
           
    }

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $rumpunpendidikan = \DB::connection('kepegawaian')->table('a_rumpunpendid')->where('idrumpunpendid','=',$id)->first();
        
        //if (is_null($rumpunpendidikan)){return \Redirect::to('pengisian/rumpunpendidikan/index');}
        return View::make('rumpunpendidikan::edit', compact('rumpunpendidikan'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idrumpunpendid');
        $input = Input::all();
        unset($input['_token']);
        $validation = \Validator::make($input, RumpunpendidikanModel::$rules);
        
        if ($validation->passes()){
            if(isset($_POST['idtkpendid']))
            {
                $x  = 0;
                $jenis = '';
                $count = count($input['idtkpendid']);
                foreach($input['idtkpendid'] as $item){
                    $x++;
                    $mark = ($x != $count)?', ':'';
                    $jenis .= $item."".$mark;
                }

                $input['idtkpendid'] = $jenis;
            }else{
                $input['idtkpendid'] = '';
            }

            if(isset($_POST['idjenjurusan']))
            {
                $x  = 0;
                $jenis = '';
                $count = count($input['idjenjurusan']);
                foreach($input['idjenjurusan'] as $item){
                    $x++;
                    $mark = ($x != $count)?', ':'';
                    $jenis .= $item."".$mark;
                }

                $input['idjenjurusan'] = $jenis;
            }else{
                $input['idjenjurusan'] = '';
            }
            
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo (\DB::connection('kepegawaian')->table('a_rumpunpendid')->where('idrumpunpendid','=',$id)->update($input))?4:"Gagal Disimpan";
        }else{
            echo 'Input tidak valid';
        }
    }


	
        public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                \DB::connection('kepegawaian')->table('a_rumpunpendid')->where('idrumpunpendid','=',$id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo (\DB::connection('kepegawaian')->table('a_rumpunpendid')->where('idrumpunpendid','=',$ids)->delete())?9:'Gagal Dihapus';
        }
    }

}
