<?php namespace App\Modules\eformasi\inputkebutuhancpnsdanpppk\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\eformasi\inputkebutuhancpnsdanpppk\Models\InputkebutuhancpnsdanpppkModel;
use Input,View, Request, Form, File, DB;

class InputkebutuhancpnsdanpppkController extends Controller {

    public function getIndex(){
        cekAjax();
        return View::make('inputkebutuhancpnsdanpppk::index');
    }

    public function postData()
    {
        cekAjax();
        return View::make('inputkebutuhancpnsdanpppk::data_inputcpns');
    }

    public function postSimpan()
    {
        cekAjax();
        $periode_bulan = Input::get('periode_bulan');
        $periode_tahun = Input::get('periode_tahun');
        $idskpd = Input::get('idskpd');

        DB::beginTransaction();
        try {
            InputkebutuhancpnsdanpppkModel::whereRaw("periode_bulan = \"".$periode_bulan."\" and periode_tahun = \"".$periode_tahun."\" and idskpd like \"".$idskpd."%\"")->delete();
            foreach (Input::get('datas') as $key => $data) {
                $cpns = new InputkebutuhancpnsdanpppkModel;
                
                $cpns->periode_bulan = $periode_bulan;
                $cpns->periode_tahun = $periode_tahun;
                $cpns->kdunit = $data['kdunit'];
                $cpns->idskpd = $idskpd;
                $cpns->idjenjab = $data['idjenjab'];
                $cpns->idjabjbt = $data['idjabjbt'];
                $cpns->idjabfung = $data['idjabfung'];
                $cpns->idjabfungum = $data['idjabfungum'];
                $cpns->idjabnonjob = $data['idjabnonjob'];
                $cpns->namajabatan = $data['namajabatan'];
                $cpns->cpns = $data['cpns']; 
                $cpns->pppk = $data['pppk'];

                $cpns->save();
            }

           DB::commit();
        } catch (Exception $e) {
           DB::rollback();
           return 'Gagal Disimpan';
        }

    	return 1;
    }

    public function postEdit(){
        cekAjax();
        $periode_bulan = Input::get('periode_bulan');
        $periode_tahun = Input::get('periode_tahun');
        $idskpd = Input::get('idskpd');

        if(\DB::table('tr_petajab')->whereRaw("periode_bulan = \"".$periode_bulan."\" and periode_tahun = \"".$periode_tahun."\" and idskpd like \"".$idskpd."%\"")->delete()){
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
}
