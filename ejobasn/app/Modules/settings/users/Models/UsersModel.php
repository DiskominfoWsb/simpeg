<?php 
namespace App\Modules\settings\users\Models;
use Illuminate\Database\Eloquent\Model;
class UsersModel extends Model{
	protected $guarded = array();	
    
	protected $table = "users";

	public static $rules = array(
		'name' => 'required',
		'username' => 'required',
		'email' => 'required',
		'password' => 'required',
		'role_id' => 'required',
);

	public function roles(){
		return $this->belongsTo('RolesModel', 'role_id');
	}

	public static function all($columns = array('*')){
		//if (\PermissionsLibrary::hasPermission('context-users-listall')){
			$instance = new static;
			return $instance->newQuery()
			->paginate($_ENV['configurations']['list-limit']);	
			
		//}else{
		//	$instance = new static;
		//	return $instance->newQuery()
		//	->where('role_id', \Session::get('role_id'))
		//	->paginate($_ENV['configurations']['list-limit']);	
		//	
		//}
	}
}

    
    
    
