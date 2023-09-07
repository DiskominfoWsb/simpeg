<?php namespace App\Modules\rekapkebutuhanasn\rekapkebutuhanglobal\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Rekapkebutuhanglobal Model
* @var Rekapkebutuhanglobal
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RekapkebutuhanglobalModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_petajab";

	public static $rules = array(
    		'updated_at' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-rekapkebutuhanglobal-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
