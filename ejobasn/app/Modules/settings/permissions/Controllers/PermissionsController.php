<?php namespace App\Modules\settings\permissions\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\settings\permissions\Models\PermissionsModel;
use Input,View, Request, Form;
/**
 * IndexController
 *
 * Controller to house all the functionality directly
 * related to the ModuleOne.
 */
class PermissionsController extends Controller {

	/**
	 * Permissions Repository
	 *
	 * @var Permissions
	 */
	protected $permissions;

	public function __construct(PermissionsModel $permissions)
	{
		$this->permissions = $permissions;
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
		    $permissionss = $this->permissions
			->orWhere('name', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('description', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('status', 'LIKE', '%'.Input::get('search').'%')

		    ->paginate(@\Session::get('configurations')['list-limit']);
		}else{
			$permissionss = $this->permissions->all();
		}
		return View::make('permissions::index', compact('permissionss'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('permissions::create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$input = Input::all();
		$validation = \Validator::make($input, PermissionsModel::$rules);

		if ($validation->passes())
		{
			echo ($this->permissions->create($input))?'1':'0';
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
		$permissions = $this->permissions->find($id);

		if (is_null($permissions))
		{
			return \Redirect::to('settings/permissions');
		}

		return View::make('permissions::edit', compact('permissions'));
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
		$input = array_except(Input::all(), '_method');
		$validation = \Validator::make($input, PermissionsModel::$rules);

		if ($validation->passes())
		{
			$permissions = $this->permissions->find($id);
			echo ($permissions->update($input))?'1':'0';
		}
	}


	
		/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postDelete()
	{
		$ids = Input::get('id');
		foreach($ids as $id){
			$this->permissions->find($id)->delete();
		}
		\Session::flash('message', 'Successfully deleted the permissions!');
		return \Redirect::to('settings/permissions');
	}


}
