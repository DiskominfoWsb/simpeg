<?php namespace App\Modules\pengisian\jurusanpendidikan\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Jurusanpendidikan Model
* @var Jurusanpendidikan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class JurusanpendidikanModel extends Model {
	// protected $guarded = array();
	
	// protected $table = "a_jenjurusan";
	protected $primaryKey = 'idjenjurusan';

	public static $rules = array(
    	// 	'jenjurusan' => 'required',
		// 'idtkpendid' => 'required',
		// 'idrumpunpendid' => 'required',
		// 'idgolru' => 'required',
		// 'idfungsional' => 'required',
		// 'idkeljurusan' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-jurusanpendidikan-listall')){
			return \DB::connection('kepegawaian')->table('a_jenjurusan')
					->leftjoin('a_rumpunpendid', 'a_jenjurusan.idrumpunpendid', '=', 'a_rumpunpendid.idrumpunpendid')
					->leftjoin('a_tkpendid', 'a_jenjurusan.idtkpendid', '=', 'a_tkpendid.idtkpendid')
					->select('a_jenjurusan.*', 'a_rumpunpendid.rumpunpendid', 'a_tkpendid.tkpendid')
					->orderBy('a_tkpendid.idtkpendid', 'asc')
					->orderBy('a_rumpunpendid.idrumpunpendid', 'asc')
                	->orderBy('a_jenjurusan.jenjurusan', 'asc')
                    ->paginate($_ENV['configurations']['list-limit']);
		}else{
			return \DB::connection('kepegawaian')->table('a_jenjurusan')
					->leftjoin('a_rumpunpendid', 'a_jenjurusan.idrumpunpendid', '=', 'a_rumpunpendid.idrumpunpendid')
					->leftjoin('a_tkpendid', 'a_jenjurusan.idtkpendid', '=', 'a_tkpendid.idtkpendid')
					->select('a_jenjurusan.*', 'a_rumpunpendid.rumpunpendid', 'a_tkpendid.tkpendid')
					->orderBy('a_tkpendid.idtkpendid', 'asc')
					->orderBy('a_rumpunpendid.idrumpunpendid', 'asc')
					->orderBy('a_jenjurusan.jenjurusan', 'asc')
					// ->where('role_id', \Session::get('role_id'))
                    ->paginate($_ENV['configurations']['list-limit']);
		}



		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-jurusanpendidikan-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
