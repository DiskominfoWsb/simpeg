<?php namespace App\Modules\settings\roles\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\settings\roles\Models\RolesModel;
use Input,View, Request, Form;
/**
 * IndexController
 *
 * Controller to house all the functionality directly
 * related to the ModuleOne.
 */
class RolesController extends Controller {

	/**
	 * Roles Repository
	 *
	 * @var Roles
	 */
	protected $roles;

	public function __construct(RolesModel $roles)
	{
		$this->roles = $roles;
	}

		/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		cekAjax();
		$this->roles->tree('0','0', $roless);
		return View::make('roles::index', compact('roless'));

	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$role_parent = $this->roles->getTreeArray();
		return View::make('roles::create', compact('role_parent'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$input = Input::all();
		$validation = \Validator::make($input, RolesModel::$rules);

		if ($validation->passes()){
			echo ($this->roles->create($input))?1:0;
		}
	}



	//{controller-show}

		/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit()
	{
		$id = \Input::get('id');
		$data['roles'] = $this->roles->find($id);
		//select LEFT(name, LENGTH(name) - locate('-',REVERSE(name))) from permissions group by LEFT(name, LENGTH(name) - locate('-',REVERSE(name))) order by id
		
		$data['permissions_context'] = \PermissionsModel::where('name', 'not like', 'mod-%')
		->get();
		foreach($data['permissions_context'] as $context){
           $data['action']['manage'][$context->id] = $context->id;
		}

		$data['permissions_modules'] = \PermissionsModel::where('name', 'like', 'mod-%')
		->select(\DB::raw("LEFT(name, LENGTH(name) - locate('-',REVERSE(name))) as name"))
		->groupBy(\DB::raw("LEFT(name, LENGTH(name) - locate('-',REVERSE(name)))"))
		->get();

		$permissionMatrix = \PermissionsmatrixModel::where('role_id', $id)->get();
		foreach($permissionMatrix as $pm){
			$data['permissionMatrix'][$pm->permission_id] = $pm->permission_id;	
		}
		$modules = \PermissionsModel::where('name', 'like', 'mod-%')->get();
		$n=0;
		foreach($modules as $module){
            $n++;
            $rpos = strrpos($module->name, '-');
            $name[$n] = substr($module->name, 0, $rpos);
			$data['action'][$name[$n]][substr($module->name, $rpos+1)] = $module->id;
			$data['module_actions'][substr($module->name, $rpos+1)] = substr($module->name, $rpos+1);
		}

		if (is_null($data['roles']))
		{
			return \Redirect::to('settings/roles');
		}
		$data['role_parent'] = $this->roles->getTreeArray();
		return View::make('roles::edit')->with($data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postEdit()
	{
		$id = Input::get('id');
		$input = Input::all();
		$validation = \Validator::make($input, RolesModel::$rules);

		if ($validation->passes())
		{
			$roles = $this->roles->find($id);
			$roles->parent = Input::get('parent');
			$roles->name = Input::get('name');
			$roles->description = Input::get('description');
			$roles->login_destination = Input::get('login_destination');
			$roles->status = Input::get('status');
			$roles->save();
			
			$pm = \PermissionsmatrixModel::where('role_id','=',$id);
			if ($pm) {
				$pm->delete();
			}
			$permissionMatrix = Input::get('permissionmatrix');	

			foreach($permissionMatrix as $key=>$val){
				$permissionsmatrixModel = new \PermissionsmatrixModel;
				$permissionsmatrixModel->role_id = $id;
				$permissionsmatrixModel->role_parent = Input::get('parent');
				$permissionsmatrixModel->permission_id = $val;
				$permissionsmatrixModel->save();
			}			
			//return \Redirect::to('settings/roles');
		}
	}


	
		/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function postDelete(){
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
				$this->roles->find($id)->delete();
			}
        }
        else{
            $this->roles->find($ids)->delete();
        }
    }
}