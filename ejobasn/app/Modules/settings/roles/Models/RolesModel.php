<?php 
namespace App\Modules\settings\roles\Models;
use Illuminate\Database\Eloquent\Model;
class RolesModel extends Model{
	protected $guarded = array();	
    
	protected $table = "roles";

	public static $rules = array(
		'name' => 'required',
		'description' => 'required',
		'login_destination' => 'required',
		'status' => 'required',
    );
    
    
	public function permissionMatrix()
    {
     	return $this->hasMany('PermissionsmatrixModel', 'role_id');   	
    }

	public static function all($columns = array('*')){
			$instance = new static;
			return $instance->newQuery()->paginate(10);
	}

	public function tree($parent_id, $level, &$items) {
        $rs = $this->where('parent', $parent_id)->get();
        if ($rs) {
            foreach ($rs as $item) {
                $items['data'][] = $item;
                $items['level'][] = $level;
                $this->tree($item->id,$level+1, $items);    
            }
        } else {
            return false;
        }
    }
	
	public function getTreeArray(){
		$this->tree('0', '0', $roless);
		$role_parent['0']='-';
		foreach($roless['data'] as $key=>$roles){
			if ($roless['level'][$key] > 0){
				$role_parent[$roles->id]= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$roless['level'][$key])." ".$roles->name;
			}else{
				$role_parent[$roles->id]=$roles->name;	
			}	
		}
		return $role_parent;
	}    
}

    
    
    
