<?php namespace App\Modules\pengisian\jabatanfungsionalumum\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pengisian\jabatanfungsionalumum\Models\JabatanfungsionalumumModel;
use App\Models\JabFungUm;
use Input,View, Request, Form, File;

class JabatanfungsionalumumController extends Controller {

	protected $jabatanfungsionalumum;

    public function __construct(JabatanfungsionalumumModel $jabatanfungsionalumum){
        $this->jabatanfungsionalumum = $jabatanfungsionalumum;
    }

	public function getIndex()
	{
		cekAjax();
		if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
				$jabatanfungsionalumums = \DB::connection('kepegawaian')->table('a_jabfungum')
				->leftjoin('a_tkpendid', 'a_jabfungum.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            	->leftjoin('a_jenjurusan', 'a_jabfungum.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')

                ->select('a_jabfungum.*', \DB::raw('if(isguru=1,"Tenaga Pendidikan",if(isguru=2, "Tenaga Kesehatan",if(isguru=3, "Tenaga Teknis","-"))) as kategori'),'a_tkpendid.tkpendid','a_jenjurusan.jenjurusan')

				// ->select('a_jabfungum.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan')
                ->orWhere('idjabfungum', 'LIKE', '%'.Input::get('search').'%')
			    ->orWhere('jabfungum', 'LIKE', '%'.Input::get('search').'%')
                ->where('flag',1)
				->paginate(@\Session::get('configurations')['list-limit']);
            }else{
                $jabatanfungsionalumums = $this->jabatanfungsionalumum->all();
            }
        }else{
            $jabatanfungsionalumums = $this->jabatanfungsionalumum->all();
        }
        return View::make('jabatanfungsionalumum::index', compact('jabatanfungsionalumums'));
	}

	public function getCreate()
	{
		return View::make('jabatanfungsionalumum::create');
	}

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        
        unset($input['tgs_jab']);
        /*function untuk list jenis Pendidikan*/
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

        /*function untuk list rumpun Pendidikan*/
        if(isset($_POST['idrumpunpendid']))
        {
            $x  = 0;
            $jenis = '';
            $count = count($input['idrumpunpendid']);
            foreach($input['idrumpunpendid'] as $item){
                $x++;
                $mark = ($x != $count)?', ':'';
                $jenis .= $item."".$mark;
            }

            $input['idrumpunpendid'] = $jenis;
        }else{
            $input['idrumpunpendid'] = '';
        }

        /*function untuk list jenis jurusan*/
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
		
		/*function untuk list diklat*/
        if(isset($_POST['iddiklat']))
        {
            $x  = 0;
            $jenis = '';
            $count = count($input['iddiklat']);
            foreach($input['iddiklat'] as $item){
                $x++;
                $mark = ($x != $count)?', ':'';
                $jenis .= $item."".$mark;
            }

            $input['iddiklat'] = $jenis;
        }else{
            $input['iddiklat'] = '';
        }

        $validation = \Validator::make($input, JabatanfungsionalumumModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            if(\DB::connection('kepegawaian')->table('a_jabfungum')->insert($input)){
                echo JabFungUm::updateProyeksi($input['idjabfungum'],$input['jabfung_id'])==1?1:"Gagal Disimpan!";
            }else{
                echo "Gagal Disimpan";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }

	public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
		$jabatanfungsionalumum = \DB::connection('kepegawaian')->table('a_jabfungum')->where('idjabfungum','=',$id)->first();
		$jabfung = \DB::connection('kepegawaian')->table('a_jabfung')->where('flag',1)->pluck('idjabfung','jabfung');

        return View::make('jabatanfungsionalumum::edit', compact('jabatanfungsionalumum','jabfung'));
	}

    public function postEdit(){
        cekAjax();
        $id = Input::get('idjabfungum');
        $input = Input::all();
        unset($input['_token']);
        
        unset($input['tgs_jab']);

        /*function untuk list jenis Pendidikan*/
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

        /*function untuk list rumpun Pendidikan*/
        if(isset($_POST['idrumpunpendid']))
        {
            $x  = 0;
            $jenis = '';
            $count = count($input['idrumpunpendid']);
            foreach($input['idrumpunpendid'] as $item){
                $x++;
                $mark = ($x != $count)?', ':'';
                $jenis .= $item."".$mark;
            }

            $input['idrumpunpendid'] = $jenis;
        }else{
            $input['idrumpunpendid'] = '';
        }

        /*function untuk list jenis jurusan*/
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
		
		/*function untuk list diklat*/
        if(isset($_POST['iddiklat']))
        {
            $x  = 0;
            $jenis = '';
            $count = count($input['iddiklat']);
            foreach($input['iddiklat'] as $item){
                $x++;
                $mark = ($x != $count)?', ':'';
                $jenis .= $item."".$mark;
            }

            $input['iddiklat'] = $jenis;
        }else{
            $input['iddiklat'] = '';
        }

        $validation = \Validator::make($input, JabatanfungsionalumumModel::$rules);
        
        if ($validation->passes()){
            if(\DB::connection('kepegawaian')->table('a_jabfungum')->where('idjabfungum','=',$id)->update($input)){
                echo JabFungUm::updateProyeksi($input['idjabfungum'],$input['jabfung_id'])?4:"Gagal Disimpan !";
            }else{
                echo "Gagal Disimpan";
            }
            // echo (\DB::connection('kepegawaian')->table('a_jabfungum')->where('idjabfungum','=',$id)->update($input))?4:"Gagal Disimpan";
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
                \DB::connection('kepegawaian')->table('a_jabfungum')->where('idjabfungum','=',$id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo (\DB::connection('kepegawaian')->table('a_jabfungum')->where('idjabfungum','=',$ids)->delete())?9:'Gagal Dihapus';
        }
    }

    /*function cari diklat*/
    function postDiklat(){
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::connection('kepegawaian')->table('a_diktek')->select('a_diktek.*','iddiktek as id','diktek as text')->where('diktek', 'like', '%'.$keyword. '%');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

}
