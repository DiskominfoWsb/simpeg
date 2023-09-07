<?php namespace App\Modules\pengisian\jabatanfungsionalumum\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Jabatanfungsionalumum Model
* @var Jabatanfungsionalumum
* Generate from Custom Laravel 5.4 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JabatanfungsionalumumModel extends Model {
	// protected $guarded = array();
	
	// protected $table = "a_jabfungum";
    // protected $primaryKey = 'idjabfungum'; // or null

	public static $rules = array(
    	'idjabfungum' => 'required',
		'jabfungum' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-jabatanfungsionalumum-listall')){
            return \DB::connection('kepegawaian')->table('a_jabfungum')
			->leftjoin('a_tkpendid', 'a_jabfungum.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'a_jabfungum.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->select('a_jabfungum.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',\DB::raw('if(isguru=1,"Tenaga Pendidikan",if(isguru=2, "Tenaga Kesehatan",if(isguru=3, "Tenaga Teknis","-"))) as kategori'))
            ->where('flag','=',1)
			->paginate($_ENV['configurations']['list-limit']);
		}else{
			return \DB::connection('kepegawaian')->table('a_jabfungum')
			->leftjoin('a_tkpendid', 'a_jabfungum.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin('a_jenjurusan', 'a_jabfungum.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->select('a_jabfungum.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan', \DB::raw('if(isguru=1,"Tenaga Pendidikan",if(isguru=2, "Tenaga Kesehatan",if(isguru=3, "Tenaga Teknis","-"))) as kategori'))
            ->where('flag','=',1)
			// ->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
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
