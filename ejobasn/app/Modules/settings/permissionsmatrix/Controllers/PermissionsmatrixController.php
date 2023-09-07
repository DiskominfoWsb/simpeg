<?php namespace App\Modules\settings\permissionsmatrix\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\settings\permissionsmatrix\Models\PermissionsmatrixModel;
use Input,View, Request, Form;
/**
 * IndexController
 *
 * Controller to house all the functionality directly
 * related to the ModuleOne.
 */
class PermissionsmatrixController extends Controller {

	protected $permissionsmatrix;

	public function __construct(PermissionsmatrixModel $permissionsmatrix)
	{
		$this->permissionsmatrix = $permissionsmatrix;
	}

		/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		cekAjax();
		if (Input::has('search')) {
		    $data['permissions'] = \PermissionsModel::orWhere('name', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('description', 'LIKE', '%'.Input::get('search').'%')
			->orderBy('name')
		    ->get();
		}else{
			$data['permissions'] = \PermissionsModel::orderBy('name')->get();
		}
		$data['roles'] = \RolesModel::where('parent', '0')->get();
		return View::make('permissionsmatrix::index')->with($data);
	}

	

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postSetpermissionsmatrix()
	{
		$input = Input::all();
		$json = array();
		if (Input::get('flag') == 1){
			$pm = new PermissionsmatrixModel;
			$pm->role_id = Input::get('role_id');
			$pm->permission_id = Input::get('permission_id');
			$pm->save();
			
			$roles = \RolesModel::where('parent', Input::get('role_id'))->get();
			foreach($roles as $role){
				$pm = new PermissionsmatrixModel;
				$pm->role_id = $role->id;
				$pm->role_parent = Input::get('role_id');
				$pm->permission_id = Input::get('permission_id');
				$pm->save();
			}
					
			$json['msg'] ="Permission matrix updated.";	
		}else{
			PermissionsmatrixModel::where('role_id',  Input::get('role_id')) 
					->where('permission_id',  Input::get('permission_id'))->delete();
			PermissionsmatrixModel::where('role_parent',  Input::get('role_id')) 
					->where('permission_id',  Input::get('permission_id'))->delete();				
			$json['msg'] ="Permission matrix deleted.";
		}
		
		return \Response::json($json);
	}
	
}