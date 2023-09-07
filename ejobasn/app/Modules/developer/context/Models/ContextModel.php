<?php 
namespace App\Modules\developer\context\Models;
use Illuminate\Database\Eloquent\Model;
class ContextModel extends Model{
	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contexts';


	public function modules()
    {
        return $this->hasMany('ModulesModel', 'id_context');
    }
}

    
    
    
