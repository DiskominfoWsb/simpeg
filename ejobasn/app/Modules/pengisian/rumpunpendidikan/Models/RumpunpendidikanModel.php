<?php namespace App\Modules\pengisian\rumpunpendidikan\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Rumpunpendidikan Model
* @var Rumpunpendidikan
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RumpunpendidikanModel extends Model {
	// protected $guarded = array();
	
	// protected $table = "a_rumpunpendid";

	public static $rules = array(
    		// 'rumpunpendid' => 'required',

    );

	public static function all($columns = array('*')){
		
		if (\PermissionsLibrary::hasPermission('mod-jabatanfungsional-listall')){
            return \DB::connection('kepegawaian')->table('a_rumpunpendid')
                    ->paginate($_ENV['configurations']['list-limit']);
		}else{
            return \DB::connection('kepegawaian')->table('a_rumpunpendid')
                    // ->where('a_rumpunpendid.role_id', \Session::get('role_id'))
                    ->paginate($_ENV['configurations']['list-limit']);	
		}
    }

}
