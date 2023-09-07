<?php namespace App\Modules\pengisian\jabatanstruktural\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Jabatanstruktural Model
* @var JabatanStruktural
* Generate from Custom Laravel 5.4 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JabatanStrukturalModel extends Model {
	// protected $guarded = array();
	
	// protected $table = "a_skpd";
    // protected $primaryKey = 'idskpd'; // or null

	public static $rules = array(
    	// 'idskpd' => 'required',
		// 'skpd' => 'required',
		// 'path' => 'required',
		// 'jab' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-jabatanstruktural-listall')){
			return \DB::connection('kepegawaian')->table('a_skpd')
                ->leftjoin('a_esl', 'a_skpd.idesl', '=', 'a_esl.idesl')
                ->leftjoin('a_tkpendid', 'a_skpd.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                ->leftjoin('a_jenjurusan', 'a_skpd.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                ->select('a_skpd.*', 'a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan')
                ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return \DB::connection('kepegawaian')->table('a_skpd')
            ->leftjoin('a_esl', 'a_skpd.idesl', '=', 'a_esl.idesl')
            ->leftjoin('a_tkpendid', 'a_skpd.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'a_skpd.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->select('a_skpd.*', 'a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan')
			// ->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);

		}
	}

    public static function getLastidskpd(){
        $rs = \DB::connection('kepegawaian')->table('a_skpd')
            ->select(\DB::raw('IF(idskpd=99,(idskpd + 2), (idskpd + 1)) AS idskpd'))
            ->where('idskpd','<',99)
            ->groupBy(\DB::raw('LEFT(idskpd, 2)'))
            ->orderBy('idskpd','desc')
            ->take(1)
            ->first();
        ;

        return $rs->idskpd;
    }

    /*function combo jenis jurusan*/
    public static function comboJenisjurusan($id="idjenjurusan",$sel="",$required=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"$id form-control\" data-placeholder=\".: Pilihan :.\">";
        $jenis = explode(", ", $sel);
        // dd($jenis);
        $rs = \DB::table('a_jenjurusan')->orderBy('idjenjurusan','asc')->get();
        if($required != 'multiple'){
            $ret.="<option value=''>.: Pilihan :.</option>";
        }
        foreach($rs as $item){
            if (in_array($item->idjenjurusan, $jenis)) {
                $isSel = "selected";
            }else{
                $isSel = "";
            }
            $ret.="<option value=\"".$item->idjenjurusan."\" $isSel >".$item->jenjurusan."</option>";
        }
        $ret.="</select>";
        return $ret;
    }

	/*function untuk mendapatkan jenis jurusan by Fadhlul Ilmi K*/
    public static function getJenisjurusan($idrumpunpendid='1,2,3,4',$idjenjurusan='1,2,3,4'){
        if($idjenjurusan!=''){
            $rs = \DB::connection('kepegawaian')->table('a_jenjurusan')->whereRaw("idjenjurusan in ($idjenjurusan)")->orderBy('idjenjurusan','asc')->get();
            $n = count($rs); $ret = ''; $x = 0;
            if($n > 0){
                foreach ($rs as $item) {
                    $x++;
                    $ret .= $item->jenjurusan.(($x<$n)?', ':'.');
                }
            }
        } else if ($idrumpunpendid != ''){
            $rs = \DB::connection('kepegawaian')->table('a_rumpunpendid')->whereRaw("idrumpunpendid in ($idrumpunpendid)")->orderBy('idrumpunpendid','asc')->get();
            $n = count($rs); $ret = ''; $x = 0;
            if($n > 0){
                foreach ($rs as $item) {
                    $x++;
                    $ret .= $item->rumpunpendid.(($x<$n)?', ':'.');
                }
            }
        } else {
            $ret = 'Semua Jurusan';
        }
        return $ret;
    }

    /*function untuk mendapatkan jenis Pendidikan*/
    public static function getJenisPendidikan($id='1,2,3,4'){
        if($id!=''){
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

}