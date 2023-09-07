<?php namespace App\Modules\eformasi\petajabatan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\eformasi\petajabatan\Models\PetajabatanModel;
use Input,View, Request, Form, File;

/**
* Petajabatan Controller
* @var Petajabatan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PetajabatanController extends Controller {
    protected $petajabatan;

    public function __construct(PetajabatanModel $petajabatan){
        $this->petajabatan = $petajabatan;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $petajabatans = $this->petajabatan
                			->orWhere('periode_bulan', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('periode_tahun', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('kdunit', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idskpd', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjenjab', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjabjbt', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjabfung', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjabfungum', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjabnonjob', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('namajabatan', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('abk', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idtkpendid', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjenjurusan', 'LIKE', '%'.Input::get('search').'%')

                ->paginate(@\Session::get('configurations')['list-limit']);
            }else{
                $petajabatans = $this->petajabatan->all();
            }
        }else{
            $petajabatans = $this->petajabatan->all();
        }
        return View::make('petajabatan::index', compact('petajabatans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('petajabatan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, PetajabatanModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->petajabatan->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function postPetajabatanprev(){
        cekAjax();
        $arrnot     = array("","periode_bulan","periode_tahun","idskpd","_token");
        $arrindex   = array("","id");
        $keyin		= array("","id");
        $keyout		= array("","id");
        $keydate    = array("");

        $dt['user_id'] = \Session::get('user_id');
        $dt['role_id'] = \Session::get('role_id');
        $dt['created_at'] = sekarang();

        foreach($_POST as $key=>$value){
            if(array_search($key,$arrnot)==""){
                if(array_search($key,$keyin)!=""){
                    $keys =  array_keys($keyin,$key);
                    $key = $keyout[$keys[0]];
                }
                if(!is_array($value)){
                    $dt[$key] = $value;
                    if(array_search($key,$arrindex)!=""){
                        $dti[$key] = $value;
                    }
                }

                if(is_array($value)){
                    foreach($value as $key2=>$value2){
                        $dt[$key2] = $value2;
                        if(array_search($key2,$arrindex)!=""){
                            $dti[$key2] = $value2;
                        }
                        if(array_search($key2,$keydate)!=''){
                            if($value2 != ''){
                                $val = explode("-",$value2);
                                $dt[$key2] = $val[2]."-".$val[1]."-".$val[0];
                            }else{
                                $dt[$key2] = '0000-00-00';
                            }
                        }
                    }
                    
                    $rssimpan = \DB::table('tr_petajab')->insert($dt);
                }
            }
        }
        
        echo ($rssimpan)?1:"Gagal Disimpan";
    }

    /*function simpan jabatan fungsional umum / pelaksana*/
    public function postSavejabfungum(){
        cekAjax();
        $input = Input::all();        
        $input['user_id'] = \Session::get('user_id');
        $input['role_id'] = \Session::get('role_id');

        $jml_array = count($input['idjenjab']);

        for($i=0;$i < $jml_array;$i++){

            $where = "idjenjab = '".$input['idjenjab'][$i]."' and periode_bulan = '".$input['periode_bulan']."' and periode_tahun = '".$input['periode_tahun']."' and kdunit  = '".$input['kdunit']."' and idskpd  = '".$input['idskpd']."'";
            if($input['idjenjab'][$i] == 3){
                $where .= ' and idjabfungum = "'.$input['idjabatan'][$i].'"';
                $data = array(
                    'periode_bulan'  => $input['periode_bulan'],
                    'periode_tahun'  => $input['periode_tahun'],
                    'kdunit'  => $input['kdunit'],
                    'idskpd'  => $input['idskpd'],
                    'idjenjab'  => $input['idjenjab'][$i],
                    'idjabfungum'  => $input['idjabatan'][$i],
                    'abk'  => $input['abk'][$i],
                    'namajabatan'  => PetajabatanModel::getPelakasana($input['idjabatan'][$i]),
                    'idtkpendid'  => $input['idtkpendid'][$i],
                    'idjenjurusan'  => $input['idjenjurusan'][$i]
                );
            } else if ($input['idjenjab'][$i] == 2){
                $where .= ' and idjabfung = "'.$input['idjabatan'][$i].'"';
                $data = array(
                    'periode_bulan'  => $input['periode_bulan'],
                    'periode_tahun'  => $input['periode_tahun'],
                    'kdunit'  => $input['kdunit'],
                    'idskpd'  => $input['idskpd'],
                    'idjenjab'  => $input['idjenjab'][$i],
                    'idjabfung'  => $input['idjabatan'][$i],
                    'abk'  => $input['abk'][$i],
                    'namajabatan'  => PetajabatanModel::getFungsional($input['idjabatan'][$i]),
                    'idtkpendid'  => $input['idtkpendid'][$i],
                    'idjenjurusan'  => $input['idjenjurusan'][$i]
                );
            }
            
            $cek_sdh_ada = \DB::table('tr_petajab')->whereRaw($where)->get();

            if(count($cek_sdh_ada) > 0) {
                \DB::table('tr_petajab')
                ->whereRaw($where)
                ->update($data);

            } else {
                \DB::table('tr_petajab')->insert($data);
            }
            
        }
        echo 1;
    }

    /*function simpan jabatan fungsional umum / pelaksana*/
    public function postSavediklat(){
        cekAjax();
        $input = Input::all();        
        $input['user_id'] = \Session::get('user_id');
        $input['role_id'] = \Session::get('role_id');

        $jml_array = count($input['iddiklat']);

        for($i=0;$i < $jml_array;$i++){
                $data = array(
                    'idpetajab' => $input['idpetajab'],
                    'periode_bulan'  => $input['periode_bulan'],
                    'periode_tahun'  => $input['periode_tahun'],
                    'idskpd'  => $input['idskpd'],
                    'idjenjab'  => $input['idjenjab'],
                    'idjabatan'  => $input['idjabatan'],
                    'iddiklat'  => $input['iddiklat'][$i]
                );
                \DB::table('tr_petajab_detail')->insert($data);
        }
        echo 1;
    }

    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $petajabatan = $this->petajabatan->find($id);
        //if (is_null($petajabatan)){return \Redirect::to('eformasi/petajabatan/index');}
        return View::make('petajabatan::edit', compact('petajabatan'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, PetajabatanModel::$rules);
        
        if ($validation->passes()){
            $petajabatan = $this->petajabatan->find($id);
            echo ($petajabatan->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }


	
    //     public function postDelete(){
    //     cekAjax();
    //     $ids = Input::get('id');
    //     if (is_array($ids)){
    //         foreach($ids as $id){
    //             $cek = $this->petajabatan->find($id);
    //             if($cek){
    //                 $cek->delete();
    //             }
    //         }
    //         echo 'Data berhasil dihapus';
    //     }
    //     else{
    //         echo ($this->petajabatan->find($ids)->delete())?9:0;
    //     }
    // }

    public function postDelete(){
        cekAjax();
        $id = Input::get('id');
        $periode_bulan = Input::get('periode_bulan');
        $periode_tahun = Input::get('periode_tahun');
        $idskpd = Input::get('idskpd');

        echo (\DB::table('tr_petajab')->whereRaw("periode_bulan = \"".$periode_bulan."\" and periode_tahun = \"".$periode_tahun."\" and idskpd = \"".$idskpd."\" and id = \"".$id."\"")->delete())?9:'Gagal Dihapus';
    }

    public function postDeletepetajabatan(){
        cekAjax();
        $id = Input::get('id');
        $periode_bulan = Input::get('periode_bulan');
        $periode_tahun = Input::get('periode_tahun');
        $idskpd = Input::get('idskpd');

        echo (\DB::table('tr_petajab')->whereRaw("periode_bulan = \"".$periode_bulan."\" and periode_tahun = \"".$periode_tahun."\" and idskpd like \"".$idskpd."%\"")->delete())?9:'Gagal Dihapus';
    }

    public function getJabatan(){
        cekAjax();
        $idkompetensi   = Input::get('idkompetensi');
        $nomor          = Input::get('nomor');
        return ComboLevelstandarkompetensi('id_level'.$nomor,'id_level','','',$idkompetensi);
    }

    /*function view data atribut dari link */
    public function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('petajabatan::'.$view.'_data');
    }

    public function postPdf(){
        $view = Request::segment(4);
        $contents = view('petajabatan::'.$view.'_pdf');
        $response = \Response::make($contents);
        $response->header('Content-Type', 'application/pdf');
        return $response;
    }

    public function postExcel(){
        $view = Request::segment(4);
        return View::make('petajabatan::'.$view.'_excel');
    }

    /*function view data atribut dari link */
    function getPrint(){
        $view = Request::segment(4);
        $idskpd = Request::segment(5);
        $periode_bulan = Request::segment(6);
        $periode_tahun = Request::segment(7);

        $contents = view('petajabatan::'.$view.'_print',array('idskpd' => $idskpd, 'periode_bulan' => $periode_bulan, 'periode_tahun' => $periode_tahun));
        $response = \Response::make($contents);
        $response->header('Content-Type', 'application/pdf');
        return $response;
    }

    /*function cari jabatan fungsional*/
    function postJabfung(){
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'))
            ->select('idjabfung', 'jabfung', 'idjabfung as id', 'jabfung as text')
            ->where('jabfung', 'like', '%'.$keyword. '%')
            ->orderBy('jabfung','asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }
    
    /*function cari jabatan fungsional umum*/
    function postJabfungum(){
        cekAjax();
        $keyword 	= Input::get('keyword');
        $parent 	= Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'))
            ->select('idjabfungum', 'jabfungum', 'idjabfungum as id', 'jabfungum as text')
            ->where('jabfungum', 'like', '%'.$keyword. '%')
            ->orderBy('jabfungum','asc');

        $arr['result'] 		= count($rs->get());
        $arr['per_page'] 	= $per_page;
        $arr['page'] 		= (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    // function untuk memanggil tk pendid dan jenjurusan
    function postTkpendidjur(){
        cekAjax();
        $idjab = Input::get('idjab');
        $count = Input::get('count');

        //select tingkat pendidikan
        $rs = \DB::connection('kepegawaian')->table('a_jabfungum')
        ->select('a_jabfungum.*', 'a_tkpendid.tkpendid')        
        ->leftJoin('a_tkpendid', 'a_jabfungum.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->where('idjabfungum', $idjab)
        ->first();
        
        echo "
        <input type='hidden' name='idtkpendid[]' value='".$rs->idtkpendid."'>
        <input type='hidden' name='idjenjurusan[]' value='".$rs->idjenjurusan."'>
        Pendidikan : ".PetajabatanModel::getJenisPendidikan($rs->idtkpendid)."<br> Jurusan ".PetajabatanModel::getJenisjurusan($rs->idjenjurusan);
    }

    function postTkpendidjurfung(){
        cekAjax();
        $idjab = Input::get('idjab');
        $count = Input::get('count');
        // dd($idjab);
        //select tingkat pendidikan
        $rs = \DB::connection('kepegawaian')->table('a_jabfung')
        ->select('a_jabfung.*', 'a_tkpendid.tkpendid')        
        ->leftJoin('a_tkpendid', 'a_jabfung.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->where('idjabfung', $idjab)
        ->first();
        
        echo "
        <input type='hidden' name='idtkpendid[]' value='".$rs->idtkpendid."'>
        <input type='hidden' name='idjenjurusan[]' value='".$rs->idjenjurusan."'>
        Pendidikan : ".PetajabatanModel::getJenisPendidikan($rs->idtkpendid)."<br> Jurusan :".PetajabatanModel::getJenisjurusan($rs->idjenjurusan);
    }

    public function getTahunpetajab(){
        cekAjax();
        $periode_bulan   = Input::get('periode_bulan');
        return comboTahunpetajab('periode_tahun','','',$periode_bulan);
    }

    public function getSkpdpetajab(){
        cekAjax();
        $periode_bulan   = Input::get('periode_bulan');
        $periode_tahun   = Input::get('periode_tahun');
        return comboSkpdpetajab('idskpd','','',Session('idskpd'),'.: Pilihan :.',$periode_bulan,$periode_tahun);
    }

    public function getJenjabpetajab(){
        cekAjax();
        $periode_bulan   = Input::get('periode_bulan');
        $periode_tahun   = Input::get('periode_tahun');
        $idskpd = Input::get('idskpd');
        return comboJenjabpetajab('idjenjab','','',$periode_bulan,$periode_tahun,$idskpd);
    }

    public function getDiklatpetajab(){
        cekAjax();
        $periode_bulan   = Input::get('periode_bulan');
        $periode_tahun   = Input::get('periode_tahun');
        $idskpd = Input::get('idskpd');
        $idjendiklat = Input::get('idjendiklat');
        $idjenjab = Input::get('idjenjab');
        $idjabatan = Input::get('idjabatan');

        return comboDiklatpetajab('iddiklat','','',$periode_bulan,$periode_tahun,$idskpd,$idjendiklat,$idjenjab,$idjabatan);
    }

    public function getJabatanpetajab(){
        cekAjax();
        $periode_bulan   = Input::get('periode_bulan');
        $periode_tahun   = Input::get('periode_tahun');
        $idskpd = Input::get('idskpd');
        $idjenjab = Input::get('idjenjab');

        if($idjenjab==2){
            return comboJabfungpetajab('idjabatan','','',$periode_bulan,$periode_tahun,$idskpd,$idjenjab);
        } else if($idjenjab==3){
            return comboJabfungumpetajab('idjabatan','','',$periode_bulan,$periode_tahun,$idskpd,$idjenjab);
        } else {
            return '<select id="idjabatan" name="idjabatan" style="width: 100%;"" class="form-control"><option value="">.: Nama Jabatan :.</option></select>';
        }
        
    }

    public function postSotkview(){
        $idskpd = Input::get('idskpd');
        return View::make('petajabatan::sotkview', compact('idskpd'));
    }

}
