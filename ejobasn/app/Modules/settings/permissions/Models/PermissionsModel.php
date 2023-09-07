<?php 
namespace App\Modules\settings\permissions\Models;
use Illuminate\Database\Eloquent\Model;
class PermissionsModel extends Model{
	protected $guarded = array();	
    
	protected $table = "permissions";

	public static $rules = array(
			'name' => 'required',
			'description' => 'required',
			'status' => 'required',
	);

    
	public static function all($columns = array('*')){
			$instance = new static;
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
	}    
}

    
    
    
