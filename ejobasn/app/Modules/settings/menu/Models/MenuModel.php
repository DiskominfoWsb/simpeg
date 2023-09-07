<?php namespace App\Modules\settings\menu\Models;
use Illuminate\Database\Eloquent\Model;


/**
* Menu Model
* @var Menu
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class MenuModel extends Model {
	protected $guarded = array();
	
	protected $table = "mast_setting_jadwal";

	public static $rules = array(
        'periode_tahun' => 'required',
		'periode_bulan' => 'required',
		'id_jenis' => 'required',
		'mulai' => 'required',
		'selesai' => 'required',
		'judul' => 'required',
		'keterangan' => 'required',

    );

    public static $rules_edit = array(
        'mulai' => 'required',
        'selesai' => 'required',
        'judul' => 'required',
        'keterangan' => 'required',

    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-menu-listall')){
			return $instance->newQuery()->paginate(@\Session::get('configurations')['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate(@\Session::get('configurations')['list-limit']);	
			
		}
	}

	public static  function comboTugasJabatan($id="id_jenis",$sel="",$required="required",$holder=".: Pilihan :."){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.='<option value="">'.$holder.'</option>';
        $rs = \DB::table('mast_setting_jadwal_jenis')->where('flag','=',1)->orderBy('id','asc')->get();
        foreach($rs as $item){
            $isSel = (($item->id==$sel)?"selected":"");
            $ret.="<option value=\"".$item->id."\" $isSel>".$item->jenis."</option>";
        }

        $ret.="</select>";
        return $ret;
    }
}
