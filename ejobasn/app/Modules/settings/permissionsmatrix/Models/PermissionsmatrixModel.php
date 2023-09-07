<?php 
namespace App\Modules\settings\permissionsmatrix\Models;
use Illuminate\Database\Eloquent\Model;
class PermissionsmatrixModel extends Model{
	protected $guarded = array();	
    
	protected $table = "role_permission";

	public function permissions()
    {
        return $this->belongsTo('PermissionsModel', 'permission_id');
    }

}

    
    
    
