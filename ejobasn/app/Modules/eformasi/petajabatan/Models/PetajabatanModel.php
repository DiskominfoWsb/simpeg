<?php namespace App\Modules\eformasi\petajabatan\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Petajabatan Model
* @var Petajabatan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class PetajabatanModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_petajab";

	public static $rules = array(
    	'periode' => 'required',
		'idskpd' => 'required',
	);
	
	public static function all($columns = array('*')){
		$instance = new static;
        if(session('role_id') > 3){
            $where= " tr_petajab.idskpd like \"".session('idskpd')."%\" ";
        }else{
            $where= " tr_petajab.idskpd != ''";
		}

		if (\PermissionsLibrary::hasPermission('mod-petajabatan-listall')){
			return $instance->newQuery()
                ->select('tr_petajab.*', 'skpd.skpd', \DB::raw('sum(if(tr_petajab.idjenjab>4,1,0)) as jmlstruktural, sum(if(tr_petajab.idjenjab=2,1,0)) as jmlfungsional, sum(if(tr_petajab.idjenjab=3,1,0)) as jmlpelaksana'))
				->join(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'),'tr_petajab.idskpd', '=', 'skpd.idskpd')
                ->whereRaw($where)
                ->groupBy(\DB::raw('tr_petajab.periode_tahun, left(tr_petajab.idskpd,2)'))
                ->orderBy('tr_petajab.idskpd')
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
            ->select('tr_petajab.*', 'skpd.skpd', \DB::raw('sum(if(tr_petajab.idjenjab>4,1,0)) as jmlstruktural, sum(if(tr_petajab.idjenjab=2,1,0)) as jmlfungsional, sum(if(tr_petajab.idjenjab=3,1,0)) as jmlpelaksana'))
			->join(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'),'tr_petajab.idskpd', '=', 'skpd.idskpd')
            ->whereRaw($where)
            ->groupBy(\DB::raw('tr_petajab.periode_tahun, left(tr_petajab.idskpd,2)'))
            ->orderBy('tr_petajab.idskpd')
			->where('tr_petajab.role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    public static function comboExisting($idjenjab="",$idskpd="",$idjabatan="",$idmatkulpel="",$idtugasdokter=""){
        
        $where = "idskpd = '".$idskpd."' and idjenkedudupeg NOT IN ('99','21')";

        if($idjenjab >= 20){
            $where .= " and idjenjab > '4' and idjabjbt = '".$idjabatan."'";
        } else if($idjenjab == 2){
            if(substr($idjabatan, 0,3) == '300'){ //004
                $where .= ' and idjenjab = "'.$idjenjab.'" and idjabfung = "'.$idjabatan.'" and idmatkulpel = "'.$idmatkulpel.'"';
            } else if(substr($idjabatan, 0,3) == '220'){ //005
                $where .= ' and idjenjab = "'.$idjenjab.'" and idjabfung = "'.$idjabatan.'" and idtugasdokter = "'.$idtugasdokter.'"';
            } else {
                $where .= " and idjenjab = '".$idjenjab."' and idjabfung = '".$idjabatan."'";
            }            
        } else if($idjenjab == 3){
            $where .= " and idjenjab = '".$idjenjab."' and idjabfungum = '".$idjabatan."'";
        } else if($idjenjab == 0){
            // $where .= " and idtugasgurudosen = '1'" ;
            $where .= " and iskepsek = '1'" ;
        }


        $rs = \DB::connection('kepegawaian')->table('tb_01')->select(\DB::raw('count(nip) as banyakorang'))->whereRaw($where)->first();
        if(!empty($rs)){
            if($rs->banyakorang > 0){
                return $rs->banyakorang;
            } else {
               //  if($idjenjab >= 20){
               //     $where2 = "idskpd = '".$idskpd."' and idjenkedudupeg NOT IN ('99','21')"; //is kepela sekolah
               //     $rs2 = \DB::connection('kepegawaian')->table('tb_01')->select(\DB::raw('count(nip) as banyakorang'))->whereRaw($where2)->first();
               //     if(!empty($rs2)){
               //         return $rs2->banyakorang;
               //     }
               // } else {
                    return $rs->banyakorang;
               // }
            }    
        }
    }

    /*combo list tahun*/
    public static function comboTahun($id="tahun",$sel="",$required="",$holder='.: Pilihan :.'){
        $html="<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $html .= "<option value=''>".$holder."</option>";
        for($i=date('Y')-2;$i<=date('Y');$i++){
            $html.="<option value='$i' ".(($i==$sel)?"selected":"").">$i</option>";
        }
        $html.="</select>";
        return $html;
    }

	public static function warnajabatan($idjenjab=""){
        if($idjenjab == 20){
             $color = '<span style="background-color:#FF3333;">&emsp;</span>';
        }else if($idjenjab == 30){
             $color = '<span style="background-color:#0080FF;">&emsp;</span>';
        }else if($idjenjab == 40){
             $color = '<span style="background-color:#00FF80;">&emsp;</span>';
        }else if($idjenjab == 2){
                $color = '<span style="background-color:#ECECEC;">&emsp;</span>';
        }else if($idjenjab == 3){
                $color = '<span style="background-color:#FFA500;">&emsp;</span>';
        }else{
                $color = '<span style="background-color:#FFFF66;">&emsp;</span>';
        }
        return $color;
   }

   public static function warnajabatanesl($idesljbt){
        $idesl = substr($idesljbt, 0, 1);
        if($idesl == 2){
            $color = 'red';
        }else if($idesl == 3){
            $color = 'blue';
        }else if($idesl == 4){
            $color = 'green';
        }else{
            $color = 'yellow';
        }

        return $color;
    }

    public static function warnajabatanjenjab($idjenjab){
        if($idjenjab == 20){
            $color = 'red';
        }else if($idjenjab == 30){
            $color = 'blue';
        }else if($idjenjab == 40){
            $color = 'green';
        }else if($idjenjab == 2){
            $color = 'gray';
        }else{
            $color = 'yellow';
        }

        return $color;
    }

    /*function untuk length*/
    public static function length($idskpd){
        $count = strlen($idskpd);
        switch($count){
            case 5  : $padding = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; break;
            case 8  : $padding = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; break;
            case 11 : $padding = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; break;
            case 14 : $padding = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; break;
            default : $padding = '';
        }
        return $padding;
    }

    /*function untuk length fpdf*/
    public static function lengthspace($idskpd){
        $count = strlen($idskpd);
        switch($count){
            case 5  : $padding = '     '; break;
            case 8  : $padding = '          '; break;
            case 11 : $padding = '               '; break;
            case 14 : $padding = '                    '; break;
            default : $padding = '';
        }
        return $padding;
    }

    /*function untuk mengambil nama jabatan pelaksanan*/
    public static function getPelakasana($idjabfungum){
        $rs = \DB::connection('kepegawaian')->table('a_jabfungum')->where('idjabfungum', $idjabfungum)->first();
        if(count($rs) > 0){
            return $rs->jabfungum;
        }
    }

    /*function untuk mengambil nama jabatan fungsional*/
    public static function getFungsional($idjabfung){
        $rs = \DB::connection('kepegawaian')->table('a_jabfung')->where('idjabfung', $idjabfung)->first();
        if(count($rs) > 0){
            return $rs->jabfung;
        }
    }

    /*function untuk mendapatkan jenis jurusan by Job Bradi Sibarani*/
    public static function getJenisjurusan($id='1,2,3,4'){
        if($id!='' && $id!=0){
            $rs = \DB::connection('kepegawaian')->table('a_jenjurusan')->whereRaw("idjenjurusan in ($id)")->orderBy('idjenjurusan','asc')->get();
            $n = count($rs); $ret = ''; $x = 0;
            if($n > 0){
                foreach ($rs as $item) {
                    $x++;
                    $ret .= $item->jenjurusan.(($x<$n)?', ':'.');
                }
            }
        }
        else
        {
            $ret = '-';
        }
        return $ret;
    }

    /*function untuk mendapatkan jenis Pendidikan*/
    public static function getJenisPendidikan($id='1,2,3,4'){
        if($id!='' && $id!=0){
            $rs = \DB::connection('kepegawaian')->table('a_tkpendid')->whereRaw("idtkpendid in ($id)")->orderBy('idtkpendid','asc')->get();
            $n = count($rs); $ret = ''; $x = 0;
            if($n > 0){
                foreach ($rs as $item) {
                    $x++;
                    $ret .= $item->tkpendid.(($x<$n)?', ':'.');
                }
            }
        }
        else
        {
            $ret = '-';
        }
        return $ret;
    }

    /*function untuk mendapatkan jenis jurusan by Job Bradi Sibarani*/
    public static function getSyaratdiklat($id='1,2,3,4',$idjenjab){
        if($id!='' && $id!=0){
            if($idjenjab > 4){
                $rs = \DB::connection('kepegawaian')->table('diklat_struktural')->whereRaw("id in ($id)")->orderBy('id','asc')->get();
            } else if($idjenjab == 2){
                $rs = \DB::connection('kepegawaian')->table('diklat_fungsional')->whereRaw("id in ($id)")->orderBy('id','asc')->get();
            } else if($idjenjab == 3){
                $rs = \DB::connection('kepegawaian')->table('a_diktek')->select('a_diktek.*','diktek as text','iddiktek as id')->whereRaw("iddiktek in ($id)")->orderBy('iddiktek','asc')->get();
            }

            $n = count($rs); $ret = '<ul style="margin-left:-26px;">'; $x = 0;
            if($n > 0){
                foreach ($rs as $item) {
                    $x++;
                    $ret .= '<li>'.$item->text.'</li>';
                }
                $ret .='</ul>';
            }
        }
        else
        {
            $ret = '-';
        }
        return $ret;
    }

    /*function untuk mendapatkan jenis jurusan by Job Bradi Sibarani*/
    public static function getKebutuhandiklat($id){
        if($id!='' && $id!=0){
            $rs = \DB::table('tr_petajab_detail as a')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.diklat_struktural as b'),'a.iddiklat', '=', 'b.iddikstru')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.diklat_fungsional as c'),'a.iddiklat', '=', 'c.iddikfung')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_diktek as d'),'a.iddiklat', '=', 'd.iddiktek')
            ->select('a.*',
            \DB::raw('IF(a.idjenjab>4,b.text,IF(a.idjenjab=2,c.text,IF(a.idjenjab=3,d.diktek,"-"))) as diklat'))
            ->where('a.idpetajab','=',$id)
            ->get();

            $n = count($rs); $ret = '<ul style="margin-left:-26px;">'; $x = 0;
            if($n > 0){
                foreach ($rs as $item) {
                    $x++;
                    $ret .= '<li>'.$item->diklat.'</li>';
                }
                $ret .='</ul>';
            }
        }
        else
        {
            $ret = '-';
        }
        return $ret;
    }

    //tkpendid by Job Bradi Sibarani
    public static function getIdtkpendid($idtkpendid,$idpetajab){
        if($idtkpendid!=0 || $idtkpendid!=''){
			$rs = \DB::table('tr_petajab AS a')->select("b.tkpendid")
			->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tkpendid as b'),'a.idtkpendid', '=', 'b.idtkpendid')
            ->where('a.id', $idpetajab)
            ->first();
        }else {
            $rs = '-'; 
        }
        if(count($rs) > 0){
            return $rs->tkpendid;
        }
    }

    //tkpendid by Job Bradi Sibarani SKPD
    public static function getIdtkpendidskpd($idtkpendid,$idskpd){
        if($idtkpendid!=''){
			$rs = \DB::table('a_skpd AS a')->select("b.tkpendid")
			->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tkpendid as b'),'a.idtkpendid', '=', 'b.idtkpendid')
            ->where('a.idskpd', $idskpd)
            ->first();
        }else {
            $rs = '-'; 
        }
        if(count($rs) > 0){
            return $rs->tkpendid;
        }
    }

    // //tkpendid by Job Bradi Sibarani PETAJABATAN
    // public static function getIdtkpendid($idtkpendid,$idpetajab){
    //     $rs = \DB::table('tr_formasi_peta AS a')->select("b.tkpendid")
    //     ->leftJoin('a_tkpendid AS b','a.idtkpendid','=','b.idtkpendid')
    //     ->where('a.id', $idpetajab)
    //     ->first();
    //     if(count($rs) > 0){
    //         return $rs->tkpendid;
    //     }
    // }

    //idjenjurusan by Job Bradi Sibarani PETAJABATAN
    public static function getIdjenjurusan($idtkpendid,$idpetajab){
		$rs = \DB::table('tr_formasi_peta AS a')->select("b.jenjurusan")
		->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjurusan as b'),'a.idjenjurusan', '=', 'b.idjenjurusan')
        ->where('a.id', $idpetajab)
        ->first();
        if(count($rs) > 0){
            return $rs->jenjurusan;
        }
    }

}
