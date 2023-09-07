<?php namespace App\Modules\settings\configurations\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\settings\configurations\Models\ConfigurationsModel;
use Input,View, Request, Form;
/**
 * IndexController
 *
 * Controller to house all the functionality directly
 * related to the ModuleOne.
 */
class ConfigurationsController extends Controller{
    private $configurations;
	function __construct( ConfigurationsModel $Model)
	{
		$this->configurations = $Model;
	}
    
	public function getIndex()
	{
		cekAjax();
		if (Input::has('search')) {
		    $configurationss = $this->configurations
			->orWhere('name', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('value', 'LIKE', '%'.Input::get('search').'%')

		    ->paginate(25);
		}else{
			$configurationss = $this->configurations->all();
		}
		return View::make('configurations::index',compact('configurationss'));
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('configurations::create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$input = Input::all();
		$validation = \Validator::make($input, ConfigurationsModel::$rules);

		if ($validation->passes()){
			echo ($this->configurations->create($input))?1:0;
        }else{
            echo '3';
        }
	}

	public function getEdit($id=false){
		$id = ($id==false)?Input::get('id'):$id;
		$configurations = $this->configurations->find($id);
		return View::make('configurations::edit', compact('configurations'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postEdit($id=false)
	{
		$id = ($id==false)?Input::get('id'):$id;
		$input = Input::all();
		$validation = \Validator::make($input, ConfigurationsModel::$rules);

		if ($validation->passes())
		{
			$configurations = $this->configurations->find($id);
			echo ($configurations->update($input))?1:0;
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
			$this->configurations->find($id)->delete();
		}
		\Session::flash('message', 'Successfully deleted the configurations!');
		return \Redirect::to('settings/configurations');
	}    
    
}