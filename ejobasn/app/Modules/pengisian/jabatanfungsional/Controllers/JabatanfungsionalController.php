<?php namespace App\Modules\pengisian\jabatanfungsional\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pengisian\jabatanfungsional\Models\JabatanfungsionalModel;
use Input,View, Request, Form, File;

class JabatanfungsionalController extends Controller {

	/**
	 * Jabatanfungsional Repository
	 *
	 * @var Jabatanfungsional
	 */
	protected $jabatanfungsional;

    public function __construct(JabatanfungsionalModel $jabatanfungsional){
        $this->jabatanfungsional = $jabatanfungsional;
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
				$jabatanfungsionals = \DB::connection('kepegawaian')->table('a_jabfung')
				->leftjoin('a_tkpendid','a_jabfung.idtkpendid','=','a_tkpendid.idtkpendid')
				->leftjoin('a_jenjurusan','a_jabfung.idjenjurusan','=','a_jenjurusan.idjenjurusan')
				->select('a_jabfung.*', \DB::raw('if(isguru=1,"Tenaga Pendidikan",if(isguru=2, "Tenaga Kesehatan",if(isguru=3, "Tenaga Teknis","-"))) as kategori'),'a_tkpendid.tkpendid','a_jenjurusan.jenjurusan')
                ->where(function($q) {
                      $q->orWhere('jabfung', 'LIKE', '%'.Input::get('search').'%')
                        ->orWhere('jabfung2', 'LIKE', '%'.Input::get('search').'%');
                  })
                ->where('a_jabfung.flag',1)
				->paginate(@\Session::get('configurations')['list-limit']);
            }else{
                $jabatanfungsionals = $this->jabatanfungsional->all();
            }
        }else{
            $jabatanfungsionals = $this->jabatanfungsional->all();
        }
        return View::make('jabatanfungsional::index', compact('jabatanfungsionals'));
    }

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('jabatanfungsional::create');
    }
    
    public function postCreate(){
        cekAjax();
        $input = Input::all();
        unset($input['jenjang']);
        unset($input['tgs_jab']);

        $validation = \Validator::make($input, JabatanfungsionalModel::$rules);

        if($input['isguru'] == '1'){
            $input['idtugasdokter'] = '';
            // $input['idtugasgurudosen'] = '';
            // $input['idmatkulpel'] = '';
            // $input['matkulpel'] = '';
        } else if($input['isguru'] == '2'){
            // $input['idtugasdokter'] = '';
            $input['idtugasgurudosen'] = '';
            $input['idmatkulpel'] = '';
            $input['matkulpel'] = '';
        } else {
            $input['idtugasdokter'] = '';
            $input['idtugasgurudosen'] = '';
            $input['idmatkulpel'] = '';
            $input['matkulpel'] = '';
        }

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

        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo (\DB::connection('kepegawaian')->table('a_jabfung')->insert($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

	public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
		$jabatanfungsional = \DB::connection('kepegawaian')->table('a_jabfung')->where('idjabfung','=',$id)->first();
		
        //if (is_null($jabatanfungsional)){return \Redirect::to('administrator/jabatanfungsional/index');}
        return View::make('jabatanfungsional::edit', compact('jabatanfungsional'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('idjabfung');
        $input = Input::all();
        $isguru = Input::get('isguru');
        $input['isguru'] = ($isguru != '')?$isguru:0;
        unset($input['_token']);
        unset($input['jenjang']);
        unset($input['tgs_jab']);

        if($input['isguru'] == '1'){
            $input['idtugasdokter'] = '';
            // $input['idtugasgurudosen'] = '';
            // $input['idmatkulpel'] = '';
            // $input['matkulpel'] = '';
        } else if($input['isguru'] == '2'){
            // $input['idtugasdokter'] = '';
            $input['idtugasgurudosen'] = '';
            $input['idmatkulpel'] = '';
            $input['matkulpel'] = '';
        } else {
            $input['idtugasdokter'] = '';
            $input['idtugasgurudosen'] = '';
            $input['idmatkulpel'] = '';
            $input['matkulpel'] = '';
        }
        
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

        $validation = \Validator::make($input, JabatanfungsionalModel::$rules);
        
        if ($validation->passes()){
            echo (\DB::connection('kepegawaian')->table('a_jabfung')->where('idjabfung','=',$id)->update($input))?4:"Gagal Disimpan";
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
                \DB::connection('kepegawaian')->table('a_jabfung')->where('idjabfung','=',$id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo (\DB::connection('kepegawaian')->table('a_jabfung')->where('idjabfung','=',$ids)->delete())?9:'Gagal Dihapus';
        }
    }
	
    /*function cari jurusan*/
    function postJenjurusan(){
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $parent2 	= Input::get('parent2');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $where = 'jenjurusan like "%'.$keyword.'%"';

        if($parent != null){
            $where  .= " and idtkpendid IN ('". implode("', '", $parent). "')";
        }

        if($parent2 != null){
            $where  .= " and idrumpunpendid IN ('". implode("', '", $parent2). "')";
        }
        
        $rs = \DB::connection('kepegawaian')->table('a_jenjurusan')
            ->select('idjenjurusan', 'jenjurusan', 'idjenjurusan as id', 'jenjurusan as text')
            ->whereRaw($where)
            ->orderBy('jenjurusan','asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    function postChagerumpun(){
        cekAjax();
        $rumpun    = Input::get('rumpun');

        $where  = "idrumpunpendid IN ('". implode("', '", $rumpun). "')";
        
        $rs = \DB::connection('kepegawaian')->table('a_rumpunpendid')
            ->select('idtkpendid', 'idjenjurusan')
            ->whereRaw($where)->get();
            // ->orderBy('jenjurusan','asc');
        $idjenjurusan = [];
        $idtkpendid = [];
        foreach ($rs as $key => $value) {
            if ($value->idjenjurusan != "") {
                $idjenjurusan = array_merge($idjenjurusan, explode(', ',$value->idjenjurusan));
            }

            if ($value->idtkpendid != "") {
                $idtkpendid = array_merge($idtkpendid, explode(', ',$value->idtkpendid));
            }
        }
        $arr['idjenjurusan'] = $idjenjurusan;
        $arr['idtkpendid'] = $idtkpendid;
        return json_encode($arr);
    }

    /*function cari diklat*/
    function postDiklat(){
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::connection('kepegawaian')->table('diklat_fungsional')->where('dikfung', 'like', '%'.$keyword. '%');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari matkulpel*/
    function postMatkulpel(){
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::connection('kepegawaian')->table('a_matkulpel')
            ->select('idmatkulpel', 'matkulpel', 'idmatkulpel as id', 'matkulpel as text')
            ->where('idtugasgurudosen', '=', $parent)
            ->where('matkulpel', 'like', '%'.$keyword. '%')
            ->orderBy('matkulpel','asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    function getGeneratepass(){
        $rs = \DB::table('users')->where('id', '>=', 6)->get();
        foreach ($rs as $item) {
            if(\DB::table('users')->where('id', $item->id)->update(array('password'=>\Hash::make($item->password)))){
                echo $item->username." Berhasil generate"."<br>";
            }
        }

    }
}
