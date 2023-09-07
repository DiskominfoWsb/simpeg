<?php

namespace App\Libraries;


use PermissionsModel;

class PermissionsLibrary {
	
	
	/**
	 * IoC
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;
	
	protected $moduleName="";
	
	protected $modulePath="";
	
	public function __construct()
	{
		
	}

	public static function assignPermission($permission){
		$permissionsModel = new \PermissionsModel;
		$permissionsModel->name    		= $permission['name'];
		$permissionsModel->description  = $permission['description'];
		$permissionsModel->status    	= '1';
		$permissionsModel->save();
		
		$pm = new \PermissionsmatrixModel;
		$pm->role_id = '1';
		$pm->role_parent = '0';
		$pm->permission_id = $permissionsModel->id;
		$pm->save();
	}
	
	public static function hasPermission($route=''){
		$role_id = \Session::get('role_id');
		if ($route ==''){
			$route = \Request::path();
			if (strpos($route, '/') > 0){
				$pos = strpos($route, '/') + 1;
				$route = substr($route, $pos);
				if (strpos($route, 'edit')){
					$rpos = strrpos($route, '/');
					$route = substr($route, 0, $rpos);
				}
				$permission = "mod-".str_replace("/", "-", $route);
			}else{
				$permission = "context-".str_replace("/", "-", $route);
			}
		}else{
			$permission = $route;
		}
//        dd($_ENV);
		$result = @array_filter($_ENV['roles'], function($elem) use($permission) {
		      if (stripos($elem, $permission) !== false) {
		        return true;
		    }
		    return false;
		  });

		if ($result){
			return true;	
		}else{
			return false;
		} 
		
	}
	
	public static function canAdd(){ 
		$role_id = \Session::get('role_id');
		$route = \Request::path();
		$pos = strpos($route, '/') + 1;
		$context = substr($route, 0, strpos($route, '/'));
		$route = substr($route, $pos);
		$permission = "mod-".str_replace(".", "-", $route)."-create";
		$check = PermissionsLibrary::hasPermission($permission);
		if ($check > 0){
			return true;	
		}else{
			return false;
		} 
		
	}

	public static function canEdit(){ 
		$role_id = \Session::get('role_id');
		$route = \Request::path();
		$pos = strpos($route, '/') + 1;
		$context = substr($route, 0, strpos($route, '/'));
		$route = substr($route, $pos);
		$permission = "mod-".str_replace(".", "-", $route)."-edit";
		
		$check = PermissionsLibrary::hasPermission($permission);

		if ($check > 0){
			return true;	
		}else{
			return false;
		} 
		
	}
	
	public static function canDel(){
		$role_id = \Session::get('role_id');
		$route = \Request::path();
		$pos = strpos($route, '/') + 1;
		$context = substr($route, 0, strpos($route, '/'));
		$route = substr($route, $pos);
		$permission = "mod-".str_replace(".", "-", $route)."-delete";
		
		$check = PermissionsLibrary::hasPermission($permission);
		
		if ($check > 0){
			return true;
		}else{
			return false;
		} 
		
	}
	
}
