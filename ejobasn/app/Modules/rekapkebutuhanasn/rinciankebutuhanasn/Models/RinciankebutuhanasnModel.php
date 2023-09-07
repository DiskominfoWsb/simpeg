<?php namespace App\Modules\rekapkebutuhanasn\rinciankebutuhanasn\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Rinciankebutuhanasn Model
* @var Rinciankebutuhanasn
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RinciankebutuhanasnModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_petajab";

	public static $rules = array(
    		'periode_tahun' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-rinciankebutuhanasn-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
