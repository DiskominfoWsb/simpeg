<?php namespace App\Modules\example\uploadgambar\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Uploadgambar Model
* @var Uploadgambar
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class UploadgambarModel extends Model {
	protected $guarded = array();
	
	protected $table = "upload_gambar";

	public static $rules = array(
    		'nama' => 'required',
		'gambar' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-uploadgambar-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

}
