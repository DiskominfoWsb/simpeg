<?php namespace App\Modules\settings\users\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\settings\users\Models\UsersModel;
use Input,View, Request, Form;
/**
 * IndexController
 *
 * Controller to house all the functionality directly
 * related to the ModuleOne.
 */
class UsersController extends Controller {

	protected $users;

	public function __construct(UsersModel $users)
	{
		$this->users = $users;
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
		    $userss = $this->users
			->orWhere('name', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('username', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('email', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('password', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('role_id', 'LIKE', '%'.Input::get('search').'%')

		    ->paginate(@\Session::get('configurations')['list-limit']);
		}else{
			$userss = $this->users->with('roles')->paginate(@\Session::get('configurations')['list-limit']);
		}
		return View::make('users::index', compact('userss'));
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$rolesModel = new \RolesModel;
		$data['roles'] = $rolesModel->getTreeArray();
		return View::make('users::create')->with($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$input = Input::all();
		$validation = \Validator::make($input, UsersModel::$rules);

		if ($validation->passes())
		{
			$this->users->name = Input::get('name');
			$this->users->username = Input::get('username');
			$this->users->email = Input::get('email');
			$this->users->password = \Hash::make(Input::get('password'));
			$this->users->role_id = Input::get('role_id');
			$this->users->save();
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
		$data['users'] = $this->users->find($id);
		$rolesModel = new \RolesModel;
		$data['roles'] = $rolesModel->getTreeArray();
		if (is_null($data['users']))
		{
			return \Redirect::to('settings/users/index');
		}

		return View::make('users::edit')->with($data);
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
		$validation = \Validator::make($input, UsersModel::$rules);

		if ($validation->passes())
		{
			$users = $this->users->find($id);
			$users->name = Input::get('name');
			$users->username = Input::get('username');
			$users->email = Input::get('email');
			$users->password = \Hash::make(Input::get('password'));
			$users->role_id = Input::get('role_id');
			$users->save();
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
				$this->users->find($id)->delete();
			}
        }
        else{
            $this->users->find($ids)->delete();
        }
    }
}