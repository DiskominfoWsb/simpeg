<?php namespace App\Modules\developer\modules\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\developer\modules\Models\ModulesModel;
use Input,View, Request, Form, File;
class ModulesController extends Controller {

	public function __construct()
	{	

		//$this->coba = $coba;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		cekAjax();
		//$modules = ModulesModel::where('module_path', '!=', 0)->orderBy('order')->get();
		$modules = ModulesModel::with('context')
		->where('module_path', '!=', 0)
		->orderBy('id_context')
		->orderBy('order')
		->get();
		$data['modules'] = $modules;
		return View::make('modules::index')->with($data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		cekAjax();
		$data['contexts'] =  \ContextModel::where('flag', 1)->orderBy('order')->get();
		$data['modules'] = ModulesModel::where('flag', 1)->where('module_path', '!=', '0')->get();
		$data['modulePath'] = array(1=>app_path().'/Modules');
		$data['controllerActions'] = \ModulesLibrary::controllerActions();
//		arsort(array('' => 'modules'));
		$data['columnTypes'] = \ModulesLibrary::columnTypes();
        return View::make('modules::create',$data);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{

		$moduleName  = strtolower(Input::get('name'));
		$moduleName = str_replace(" ", "", $moduleName);
		//$modulePath = \Config::get('claravel::modulesPath');
		$contextName = \App\Modules\developer\context\Models\ContextModel::find(Input::get('id_context'));
		$contextName = str_replace(" ", "", $contextName->name);
		$contextName = strtolower($contextName);
		$modulePath = app_path() . '/Modules'.'/'.$contextName.'/'.$moduleName;

		$module = new ModulesModel;
		$module->module_path    = Input::get('module_path');
		$module->id_context    = Input::get('id_context');
		$module->id_parent     = Input::get('id_parent');
		$module->name       	= Input::get('name');

		$module->path      	= "/".$contextName.'/'.$moduleName;

		$module->uses 		= ucfirst($moduleName)."Controller";
		$module->flag 		= Input::get('flag');
		$module->is_nav_bar 	= 1;
		$module->icons 		= Input::get('icons');
		$module->order 		= Input::get('order');
		$module->table_name 		= Input::get('table_name');

		if (Input::get('controller') == '1'){

			$modulesLibrary = new \ModulesLibrary;
			$createModules = $modulesLibrary->run($moduleName, $modulePath, $contextName);
			if ($createModules){
				$module->save();
                echo '1';
            }else{
                echo '0';
            }
		}else{
			$modulesLibrary = new \ModulesLibrary;
			$createModules = $modulesLibrary->run($moduleName, $modulePath, $contextName);
			if ($createModules){
				$module->save();
                echo '1';
            }else{
                echo '0';
            }

			$permission['name'] = 'mod-'.$moduleName.'-index';
			$permission['description'] = 'Allow Access '.\Input::get('name').' Index';
			\PermissionsLibrary::assignPermission($permission);
		}
//		\Session::flash('message', 'Successfully created module!');
//		return \Redirect::to('developer/modules');


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('modules::show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('modules::edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
				$data = ModulesModel::with('context')->find($id);
				$moduleName = strtolower($data->name);
				$moduleName = str_replace(" ", "", $moduleName);
				$moduleBasePath = array(1=>app_path().'/Modules');

				$contextName = str_replace(" ", "", $data->context->name);
				$contextName = strtolower($contextName);

				if (\File::isDirectory(app_path().'/Modules'.'/'.$contextName.'/'.$moduleName)){
					\File::deleteDirectory(app_path().'/Modules'.'/'.$contextName.'/'.$moduleName);
					if ($data->table_name !=""){
						\Schema::drop($data->table_name);
					}
				}

				$permissionsModel = \PermissionsModel::where('name', 'LIKE', 'mod-'.$moduleName.'%')->get();
				foreach ($permissionsModel as $pm) {
					\PermissionsmatrixModel::where('permission_id','=',$pm->id)->delete();
					\PermissionsModel::find($pm->id)->delete();
				}

				$data->delete();
			}
        }
        else{
            $data = ModulesModel::with('context')->find($ids);
			$moduleName = strtolower($data->name);
			$moduleName = str_replace(" ", "", $moduleName);
			$moduleBasePath = array(1=>app_path().'/Modules');

			$contextName = str_replace(" ", "", $data->context->name);
			$contextName = strtolower($contextName);
			if (\File::isDirectory(app_path().'/Modules'.'/'.$contextName.'/'.$moduleName)){
				\File::deleteDirectory(app_path().'/Modules'.'/'.$contextName.'/'.$moduleName);
				if ($data->table_name !=""){
					\Schema::drop($data->table_name);
				}
			}

			$permissionsModel = \PermissionsModel::where('name', 'LIKE', 'mod-'.$moduleName.'%')->get();
			foreach ($permissionsModel as $pm) {
				\PermissionsmatrixModel::where('permission_id','=',$pm->id)->delete();
				\PermissionsModel::find($pm->id)->delete();
			}

			$data->delete();
        }
    }


	/**
	* Get al field for existing table
	*
	* @return json
	*/
	public function postTablefields(){
		$table = \Input::get('table');

		$selects = array(
        'column_name as Field',
        'column_type as Type',
        'is_nullable as Null',
        'column_key as Key',
        'column_default as Default',
        'extra as Extra',
        'data_type as Data_Type'
    	);

		$connection = \DB::connection();
    	$connection->getSchemaBuilder();


		$schema =  \DB::table('information_schema.columns')
            ->where('table_schema', '=', $connection->getDatabaseName())
            ->where('table_name', '=', $table)
            ->get($selects);
        return \Response::json($schema);

	}

}
