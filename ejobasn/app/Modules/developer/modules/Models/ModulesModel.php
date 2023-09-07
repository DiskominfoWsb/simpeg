<?php 
namespace App\Modules\developer\modules\Models;
use Illuminate\Database\Eloquent\Model;
class ModulesModel extends Model{
	protected $guarded = array();

	protected $table = 'modules';
	
	public static $rules = array();
	
	public function context()
    {
        return $this->belongsTo('ContextModel', 'id_context');
    }
	
	//public function children()
    //{
     //   return $this->belongs_to('ModuleModel', 'id_parent');
    //}
	
	public function getDescendants ( $parent= false ) {
	    $parent = $parent ?: $this;
	    $children = $parent->children()->get();
	
	    foreach ( $children as $child ) {
	        $child->setRelation(
	            'children', 
	            getDescendants( $child )
	        );
	    }
	
	    return $children;
	}
}

    
    
    
