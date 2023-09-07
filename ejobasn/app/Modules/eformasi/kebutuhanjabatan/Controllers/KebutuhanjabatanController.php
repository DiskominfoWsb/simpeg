<?php namespace App\Modules\eformasi\kebutuhanjabatan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\eformasi\kebutuhanjabatan\Models\KebutuhanjabatanModel;
use App\Exports\KebutuhanjabatanExport;
use Input,View, Request, Form, File, Excel;

use App\Modules\eformasi\petajabatan\Models\PetajabatanModel;


class KebutuhanjabatanController extends Controller {
    protected $kebutuhanjabatan;

    public function __construct(KebutuhanjabatanModel $kebutuhanjabatan){
        $this->kebutuhanjabatan = $kebutuhanjabatan;
    }

    public function getIndex(){
        cekAjax();
        $where = "tr_petajab.kdunit != 0";
        if(session('role_id') > 3){
            $where .= " and tr_petajab.idskpd like \"".session('idskpd')."%\" ";
        }

        /*if ((strlen(Input::has('search')) > 0) or (Input::get('idskpd') != '')) {*/
        if ((strlen(Input::has('search')) > 0) or (Input::get('periode_bulan') != '') or (Input::get('periode_tahun') != '') or (Input::get('idskpd') != '')) {
            if(Input::get('periode_bulan') != ''){
                $where .= " and periode_bulan = \"".Input::get('periode_bulan')."\"";
            }

            if(Input::get('periode_tahun') != ''){
                $where .= " and periode_tahun = \"".Input::get('periode_tahun')."\"";
            }

            if(Input::get('idskpd') != ''){
                $idskpd = Input::get('idskpd');
                $where .= " and tr_petajab.idskpd like '$idskpd%'";
            }

            if(strlen(Input::has('search')) > 0) {
                $where .=" and (skpd.skpd like '%".Input::get('search')."%')";
            }

            $kebutuhanjabatans = $this->kebutuhanjabatan
                ->select('tr_petajab.*', 'skpd.skpd', \DB::raw('sum(if(tr_petajab.idjenjab>4,1,0)) as jmlstruktural, sum(if(tr_petajab.idjenjab=2,1,0)) as jmlfungsional, sum(if(tr_petajab.idjenjab=3,1,0)) as jmlpelaksana'))
                ->join(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'),'tr_petajab.idskpd', '=', 'skpd.idskpd')
                ->whereRaw($where)
                ->groupBy(\DB::raw('tr_petajab.periode_bulan, tr_petajab.periode_tahun, left(tr_petajab.idskpd,2)'))
                ->orderBy('tr_petajab.periode_bulan', 'tr_petajab.periode_tahun','tr_petajab.idskpd')
                    ->paginate(@\Session::get('configurations')['list-limit']);

        }else{
            $kebutuhanjabatans = $this->kebutuhanjabatan->all();
        }
        return View::make('kebutuhanjabatan::index', compact('kebutuhanjabatans'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('kebutuhanjabatan::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, KebutuhanjabatanModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->kebutuhanjabatan->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }

    public function postKebutuhanjabatanprev(){
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
                    'namajabatan'  => KebutuhanjabatanModel::getPelakasana($input['idjabatan'][$i]),
                    'idtkpendid'  => $input['idtkpendid'][$i],
                    'idjenjurusan'  => $input['idjenjurusan'][$i]
                );
            } else if ($input['idjenjab'][$i] == 2){
                $where .= ' and idjabfung = "'.$input['idjabatan'][$i].'"';


                if(substr($input['idjabatan'][$i], 0,3) == '300'){
                    $where .= ' and idmatkulpel = "'.$input['idmatkulpel'][$i].'"';

                    $data = array(
                        'periode_bulan'  => $input['periode_bulan'],
                        'periode_tahun'  => $input['periode_tahun'],
                        'kdunit'  => $input['kdunit'],
                        'idskpd'  => $input['idskpd'],
                        'idjenjab'  => $input['idjenjab'][$i],
                        'idjabfung'  => $input['idjabatan'][$i],
                        'abk'  => $input['abk'][$i],
                        'idmatkulpel'=> $input['idmatkulpel'][$i],
                        'namajabatan'  => KebutuhanjabatanModel::getFungsional($input['idjabatan'][$i]),
                        'idtkpendid'  => $input['idtkpendid'][$i],
                        'idjenjurusan'  => $input['idjenjurusan'][$i]
                    );
                } else if(substr($input['idjabatan'][$i], 0,3) == '220'){
                    $where .= ' and idtugasdokter = "'.$input['idtugasdokter'][$i].'"';
                    $data = array(
                        'periode_bulan'  => $input['periode_bulan'],
                        'periode_tahun'  => $input['periode_tahun'],
                        'kdunit'  => $input['kdunit'],
                        'idskpd'  => $input['idskpd'],
                        'idjenjab'  => $input['idjenjab'][$i],
                        'idjabfung'  => $input['idjabatan'][$i],
                        'abk'  => $input['abk'][$i],
                        'idtugasdokter'=> $input['idtugasdokter'][$i],
                        'namajabatan'  => KebutuhanjabatanModel::getFungsional($input['idjabatan'][$i]),
                        'idtkpendid'  => $input['idtkpendid'][$i],
                        'idjenjurusan'  => $input['idjenjurusan'][$i]
                    );
                } else {
                    $data = array(
                        'periode_bulan'  => $input['periode_bulan'],
                        'periode_tahun'  => $input['periode_tahun'],
                        'kdunit'  => $input['kdunit'],
                        'idskpd'  => $input['idskpd'],
                        'idjenjab'  => $input['idjenjab'][$i],
                        'idjabfung'  => $input['idjabatan'][$i],
                        'abk'  => $input['abk'][$i],
                        'namajabatan'  => KebutuhanjabatanModel::getFungsional($input['idjabatan'][$i]),
                        'idtkpendid'  => $input['idtkpendid'][$i],
                        'idjenjurusan'  => $input['idjenjurusan'][$i]
                    );
                }
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

        $hapus = \DB::table('tr_petajab_detail')
                ->where('idpetajab','=',$input['idpetajab'])
                ->where('periode_bulan','=',$input['periode_bulan'])
                ->where('periode_tahun','=',$input['periode_tahun'])
                ->where('idskpd','=',$input['idskpd'])
                ->where('idjenjab','=',$input['idjenjab'])
                ->where('idjabatan','=',$input['idjabatan'])
                ->delete();
        if(!empty($input['iddiklat'])){
            $jml_array = count($input['iddiklat']);
            for($i=0;$i < $jml_array;$i++){
                if($input['idjenjab'] == 2){
                    $jendiklat = \DB::connection('kepegawaian')->table('diklat_fungsional')->where('iddikfung','=',$input['iddiklat'][$i])->first()->idjendiklat;
                } else if($input['idjenjab'] == 3){
                    $jendiklat = 3;
                } else {
                    $jendiklat = \DB::connection('kepegawaian')->table('diklat_struktural')->where('iddikstru','=',$input['iddiklat'][$i])->first()->idjendiklat;
                }
                
                $data = array(
                    'idpetajab' => $input['idpetajab'],
                    'periode_bulan'  => $input['periode_bulan'],
                    'periode_tahun'  => $input['periode_tahun'],
                    'idskpd'  => $input['idskpd'],
                    'idjenjab'  => $input['idjenjab'],
                    'idjabatan'  => $input['idjabatan'],
                    'idjendiklat' => $jendiklat,
                    'iddiklat'  => $input['iddiklat'][$i]
                );
                \DB::table('tr_petajab_detail')->insert($data);
            }
        }

        echo 1;
    }

    //{controller-show}
    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $kebutuhanjabatan = $this->kebutuhanjabatan->find($id);
        //if (is_null($kebutuhanjabatan)){return \Redirect::to('eformasi/kebutuhanjabatan/index');}
        return View::make('kebutuhanjabatan::edit', compact('kebutuhanjabatan'));
    }
    
    public function postEdit(){
        cekAjax();
        /*$periode_bulan = Input::get('periode_bulan');
        $periode_tahun = Input::get('periode_tahun');*/
        $idskpd = Input::get('idskpd');

        /*if(\DB::table('tr_petajab')->whereRaw("periode_bulan = \"".$periode_bulan."\" and periode_tahun = \"".$periode_tahun."\" and idskpd like \"".$idskpd."%\"")->delete()){*/
        if(\DB::table('tr_petajab')->whereRaw("idskpd like \"".$idskpd."%\"")->delete()){
            $arrnot     = array("","periode_bulan","periode_tahun","idskpd","_token");
            $arrindex   = array("","id");
            $keyin      = array("","id");
            $keyout     = array("","id");
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
            
            echo ($rssimpan)?4:"Gagal Disimpan";
        } else {
            echo "Gagal Disimpan";
        }
    }


	
    //     public function postDelete(){
    //     cekAjax();
    //     $ids = Input::get('id');
    //     if (is_array($ids)){
    //         foreach($ids as $id){
    //             $cek = $this->kebutuhanjabatan->find($id);
    //             if($cek){
    //                 $cek->delete();
    //             }
    //         }
    //         echo 'Data berhasil dihapus';
    //     }
    //     else{
    //         echo ($this->kebutuhanjabatan->find($ids)->delete())?9:0;
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

    public function postDeletekebutuhanjabatan(){
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
        return View::make('kebutuhanjabatan::'.$view.'_data');
    }

    /*function view data atribut dari link */
    function getPrint(){
        $view = Request::segment(4);
        $idskpd = Request::segment(5);
        $periode_bulan = Request::segment(6);
        $periode_tahun = Request::segment(7);

        $contents = view('kebutuhanjabatan::'.$view.'_print',array('idskpd' => $idskpd, 'periode_bulan' => $periode_bulan, 'periode_tahun' => $periode_tahun));
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
            ->where('flag','=',1)
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

    /*function cari jabatan fungsional*/
    function postMatkulpel(){
        cekAjax();
        $keyword    = Input::get('keyword');
        $parent     = Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_matkulpel as a_matkulpel'))
            ->select('idmatkulpel', 'matkulpel', 'idmatkulpel as id', 'matkulpel as text')
            ->where('matkulpel', 'like', '%'.$keyword. '%')
            ->orderBy('matkulpel','asc');

        $arr['result']      = count($rs->get());
        $arr['per_page']    = $per_page;
        $arr['page']        = (($page>0)?$page:1);
        $arr['rows']        = $rs->skip($start)->take($per_page)->get();
        echo json_encode($arr);
    }

    /*function cari jabatan fungsional*/
    function postTugasdokter(){
        cekAjax();
        $keyword    = Input::get('keyword');
        $parent     = Input::get('parent');
        $per_page   = intval(Input::get('per_page'));
        $start      = (intval(Input::get('page'))-1)*$per_page;
        $page       = intval(Input::get('page'));

        $rs = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'))
            ->select('idtugasdokter', 'tugasdokter', 'idtugasdokter as id', 'tugasdokter as text')
            ->where('tugasdokter', 'like', '%'.$keyword. '%')
            ->orderBy('tugasdokter','asc');

        $arr['result']      = count($rs->get());
        $arr['per_page']    = $per_page;
        $arr['page']        = (($page>0)?$page:1);
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
        Pendidikan : ".KebutuhanjabatanModel::getJenisPendidikan($rs->idtkpendid)."<br> Jurusan ".KebutuhanjabatanModel::getJenisjurusan($rs->idjenjurusan);
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
        Pendidikan : ".KebutuhanjabatanModel::getJenisPendidikan($rs->idtkpendid)."<br> Jurusan :".KebutuhanjabatanModel::getJenisjurusan($rs->idjenjurusan);
    }

    /*funcition sinkronisasi data*/
    function postSinkronisasi(){
        $id = Input::get('id');
        $periode_bulan = Input::get('periode_bulan');
        $periode_tahun = Input::get('periode_tahun');
        $idskpd = Input::get('idskpd');
        $user_id = \Session::get('user_id');
        $role_id = \Session::get('role_id');

        switch ($id){
            case 2 :
                /*Perbedaan nama jabatan anatara petajabatan dan unitkerja*/
                $sinkron = \DB::statement("
                                update tr_petajab inner join ".config('global.kepegawaian').".a_skpd as a_skpd on tr_petajab.idskpd = a_skpd.idskpd
                                set tr_petajab.namajabatan = a_skpd.jab where tr_petajab.idskpd = \"".$idskpd."\" and tr_petajab.periode_bulan = \"".$periode_bulan."\" and tr_petajab.periode_tahun = \"".$periode_tahun."\"
                            ");
            break;
            case 3 :
                /*Data pada unit kerja belum masuk ke peta jabatan*/
                $sinkron = \DB::statement("
                                insert into tr_petajab (periode_bulan, periode_tahun, kdunit, idskpd, idjenjab, idjabjbt, namajabatan, abk, user_id, role_id, created_at, updated_at)
                                select \"".$periode_bulan."\", $periode_tahun, LEFT(idskpd,2), idskpd, jab_asn, idskpd, jab, 1, $user_id, $role_id, NOW(), NOW() from ".config('global.kepegawaian').".a_skpd as a_skpd where idskpd = \"".$idskpd."\"
                            ");
            break;
            case 4 :
                /*Data petajabatan yang ngga konek dengan data unit kerja*/
                $sinkron = \DB::table('tr_petajab')->where(array('periode_bulan'=>$periode_bulan, 'periode_tahun'=>$periode_tahun, 'idskpd'=>$idskpd))->delete();
            break;
        }

        echo ($sinkron)?4:'Sinkronisasi Gagal';
    }

    // Method untuk export excel kebutuhan jabtan
    function getExcel()
    {
        $view = Request::segment(4);
        $idskpd = Request::segment(5);
        $periode_bulan = Request::segment(6);
        $periode_tahun = Request::segment(7);

        $excel = Excel::create('Kebutuhan Jabatan', function ($excel)
        {
            $excel->sheet('New sheet', function($sheet) {
                   $view = Request::segment(4);
                $idskpd = Request::segment(5);
                $periode_bulan = Request::segment(6);
                $periode_tahun = Request::segment(7);   

                $sheet->loadView('kebutuhanjabatan::'.$view.'_excel',array('idskpd' => $idskpd, 'periode_bulan' => $periode_bulan, 'periode_tahun' => $periode_tahun));

            });
        });

        return $excel->export('xlsx');;
    }

    function postUpdateabk(){
        $id = Input::get('id');
        $abk = (int) Input::get('abk');

        $petajabatan =  PetajabatanModel::find($id);
        if(!empty($petajabatan) && is_int($abk)){
            $petajabatan->abk = $abk;
            $petajabatan->save();
            if($petajabatan->save()){
                $status = "success";
                $pesan = "Berhasil disimpan!";
            }else{
                $status = "error";
                $pesan = "Berhasil disimpan!";
            }
        }else{
            $status = "error";
            $pesan = "Data tidak ditemukan!";
        }

        return response()->json(['status' => $status,'pesan' => $pesan]);
    }
}
