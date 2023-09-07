<?php namespace App\Modules\pengisian\jabatanstruktural\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pengisian\jabatanstruktural\Models\JabatanstrukturalModel;
use Input,View, Request, Form, File;

class JabatanstrukturalController extends Controller {

	/**
	 * Jabatanstruktural Repository
	 *
	 * @var Jabatanstruktural
	 */
	protected $jabatanstruktural;

    public function __construct(JabatanstrukturalModel $jabatanstruktural){
        $this->jabatanstruktural = $jabatanstruktural;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex(){
		cekAjax();
		if (Input::has('search')) {
			if(strlen(Input::has('search')) > 0){
				$jabatanstrukturals = \DB::connection('kepegawaian')->table('a_skpd')
					->leftjoin('a_esl', 'a_skpd.idesl', '=', 'a_esl.idesl')
					->leftjoin('a_tkpendid', 'a_skpd.idtkpendid', '=', 'a_tkpendid.idtkpendid')
					->leftjoin('a_jenjurusan', 'a_skpd.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
					->select('a_skpd.*', 'a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan')
					->orWhere('a_skpd.idparent', 'LIKE', '%'.Input::get('search').'%')
					->orWhere('a_skpd.skpd', 'LIKE', '%'.Input::get('search').'%')
					->orWhere('a_skpd.path', 'LIKE', '%'.Input::get('search').'%')
					->orWhere('a_skpd.jab', 'LIKE', '%'.Input::get('search').'%')
					->orWhere('a_skpd.idesl', 'LIKE', '%'.Input::get('search').'%')
				->paginate(@\Session::get('configurations')['list-limit']);
			}else{
				$jabatanstrukturals = $this->jabatanstruktural->all();
			}
		}else{
			$jabatanstrukturals = $this->jabatanstruktural->all();
		}
		return View::make('jabatanstruktural::index', compact('jabatanstrukturals'));
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('jabatanstruktural::create');
	}

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, JabatanstrukturalModel::$rules);
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

        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo (\DB::connection('kepegawaian')->table('a_skpd')->insert($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

	public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
		$jabatanstruktural = \DB::connection('kepegawaian')->table('a_skpd')->where('idskpd','=',$id)->first();
        //if (is_null($unitkerja)){return \Redirect::to('administrator/unitkerja/index');}
        return View::make('jabatanstruktural::edit', compact('jabatanstruktural'));
	}
	
    public function postEdit(){
        cekAjax();
        $id = Input::get('idskpd');
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

        $validation = \Validator::make($input, JabatanstrukturalModel::$rules);
        
        if ($validation->passes()){
            echo (\DB::connection('kepegawaian')->table('a_skpd')->where('idskpd','=',$id)->update($input))?4:"Gagal Disimpan";
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
                \DB::connection('kepegawaian')->table('a_skpd')->where('idskpd','=',$id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo (\DB::connection('kepegawaian')->table('a_skpd')->where('idskpd','=',$ids)->delete())?9:'Gagal Dihapus';
        }
    }

	/*function outo idskpd*/
    public function postAutoidskpd(){
        $idparent = Input::get('idparent');
        $rs = \DB::connection('kepegawaian')->table('a_skpd')
                ->select(\DB::raw('idskpd, idparent, skpd, RIGHT(idskpd, 2) as rights, (RIGHT(idskpd, 2) + 1) AS idbaru, tmstamp'))
                ->where('idskpd', 'like', ''.$idparent.'%')
                ->where('idparent', '=', $idparent)
                ->orderBy('idskpd', 'desc')
                ->orderBy('tmstamp', 'desc')
                ->take('1');

        $row = $rs->first();
        if($rs->count() > 0 ){
            $ret['idparent'] = $idparent;
            $ret['lastid'] = $row->idskpd;
            if (is_numeric($row->rights)) {
                $ret['idbaru'] = $row->idparent.".".((strlen($row->idbaru) == 1)?"0".$row->idbaru:$row->idbaru);
            } else {
                $x = substr($row->rights,0,1);
                $y = substr($row->rights,1,1) + 1;
                if($y > 9){
                    $ret['idbaru'] = $row->idparent.".??";
                }else{
                    $ret['idbaru'] = $row->idparent.".".$x."".$y;
                }
            }
        }else{
            $ret['idparent'] = $idparent;
            $ret['lastid'] = $idparent.".00";
            $ret['idbaru'] = $idparent.".01";
        }
        $ret['path'] = isset($row->skpd)?$row->skpd:'';

        echo json_encode($ret);
    }

    /*function cari diklat*/
    function postDiklat(){
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::connection('kepegawaian')->table('diklat_struktural')->where('dikstru', 'like', '%'.$keyword. '%');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }
}
