<?php namespace App\Modules\eformasi\analisiskebutuhandiklat\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Analisiskebutuhandiklat Model
* @var Analisiskebutuhandiklat
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class AnalisiskebutuhandiklatModel extends Model {
	protected $guarded = array();
	
	protected $table = "tr_petajab_detail";

	public static $rules = array(
    		'idpetajab' => 'required',
		'periode_bulan' => 'required',
		'periode_tahun' => 'required',
		'idskpd' => 'required',
		'idjenjab' => 'required',
		'idjabatan' => 'required',
		'iddiklat' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-analisiskebutuhandiklat-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
