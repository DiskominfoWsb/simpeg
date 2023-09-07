<?php namespace App\Modules\developer\context\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\developer\context\Models\ContextModel;
use Input,View, Request, Form, File;
class ContextController extends Controller {

	protected $context;

	public function __construct(ContextModel $context)
	{
		$this->context = $context;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		cekAjax();
		$contexts = ContextModel::with('modules')->get();
		$data['contexts'] = $contexts;
		return View::make('context::index')->with($data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		cekAjax();
		$data['modulePath'] = array(1 => 'modules');
		arsort($data['modulePath']);

		$data['lastContext'] = \ContextModel::orderBy('order', 'desc')->first();

		return View::make('context::create')->with($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$context = new \App\Modules\developer\context\Models\ContextModel;
		$context->module_path       = Input::get('module_path');
		$context->name       = Input::get('name');
		$context->path      = Input::get('path');
		$context->uses = Input::get('uses');
		$context->flag = Input::get('flag');
		$context->is_nav_bar = Input::get('is_nav_bar');
		$context->icons = Input::get('icons');
		$context->order = Input::get('order');
		$context->save();

		$contextName = Input::get('name');
		$contextName = str_replace(" ", "", $contextName);
		$contextName = strtolower($contextName);
		//$moduleBasePath = \Config::get('claravel::modulesPath');
		if (!\File::isDirectory(app_path().'/Modules/'.$contextName)){
				\File::makeDirectory(app_path().'/Modules/'.$contextName, 0755);
		}

		$permission['name'] = 'context-'.$contextName;
		$permission['description'] = 'Allow Access '.$contextName;
		\PermissionsLibrary::assignPermission($permission);

		// \Session::flash('message', 'Successfully created context!');

		// return \Redirect::to('developer/contexts');
		//exit();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit()
	{
		$id = \Input::get('id');

		$data['modulePath'] = array(1 => 'modules');
		arsort($data['modulePath']);

		$data['context'] = \App\Modules\developer\context\Models\ContextModel::find($id);
		return View::make('context::edit')
		->with($data);
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
		$context = \App\Modules\developer\context\Models\ContextModel::find($id);

		$oldContextName = $context->name;
		$oldContextName = str_replace(" ", "", $oldContextName);
		$oldContextName = strtolower($oldContextName);

		$contextName = Input::get('name');
		$contextName = str_replace(" ", "", $contextName);
		$contextName = strtolower($contextName);

		//$moduleBasePath = \Config::get('claravel::modulesPath');
		$oldDir = app_path() . '/Modules/'.$oldContextName;
		$newDir = app_path() . '/Modules/'.$contextName;
		if (\File::isDirectory($oldDir) && $oldDir != $newDir){
				\File::makeDirectory($newDir, 0755);
				\File::copyDirectory($oldDir, $newDir);
				\File::deleteDirectory($oldDir, false);
			$permissionsModel = \PermissionsModel::where('name', '=', 'context-'.$newDir)->first();
			$permissionsModel->name = 'context-'.$newDir;
			$permissionsModel->save();
		}

		$context->name       = Input::get('name');
		$context->path      = Input::get('path');
		$context->uses = Input::get('uses');
		$context->flag = Input::get('flag');
		$context->is_nav_bar = Input::get('is_nav_bar');
		$context->icons = Input::get('icons');
		$context->order = Input::get('order');
		$context->save();

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
				$data = \App\Modules\developer\context\Models\ContextModel::find($id);
				$contextName = str_replace(" ", "", $data->name);
				$contextName = strtolower($contextName);

				$moduleBasePath = '';//\Config::get('claravel::modulesPath');
				if (\File::isDirectory(app_path() . '/Modules/'.$contextName)){
					\File::deleteDirectory(app_path() . '/Modules/'.$contextName);
				}

				$permissionsModel = \PermissionsModel::where('name', '=', 'context-'.$contextName)->first();
				if ($permissionsModel){
					\PermissionsmatrixModel::where('permission_id','=',$permissionsModel->id)->delete();
					\PermissionsModel::find($permissionsModel->id)->delete();
				}
				$data->delete();
			}
        }
        else{
            $data = \App\Modules\developer\context\Models\ContextModel::find($ids);
			$contextName = str_replace(" ", "", $data->name);
			$contextName = strtolower($contextName);

			$moduleBasePath = '';//\Config::get('claravel::modulesPath');
			if (\File::isDirectory(app_path() . '/Modules/'.$contextName)){
				\File::deleteDirectory(app_path() . '/Modules/'.$contextName);
			}

			$permissionsModel = \PermissionsModel::where('name', '=', 'context-'.$contextName)->first();
			if ($permissionsModel){
				\PermissionsmatrixModel::where('permission_id','=',$permissionsModel->id)->delete();
				\PermissionsModel::find($permissionsModel->id)->delete();
			}
			$data->delete();
        }
    }

}
