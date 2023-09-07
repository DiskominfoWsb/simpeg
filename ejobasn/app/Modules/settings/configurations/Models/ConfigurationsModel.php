<?php 
namespace App\Modules\settings\configurations\Models;
use Illuminate\Database\Eloquent\Model;
class ConfigurationsModel extends Model{
	protected $guarded = array();	
	protected $table = "configurations";
	public static $rules = array(
		'name' => 'required',
		'value' => 'required',
    );
    
	public static function all($columns = array('*')){
			$instance = new static;
			return $instance->newQuery()->paginate(10);
	}    
}

    
    
    
