<?php

namespace App\Libraries;

use Illuminate\Foundation\Composer;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//use PermissionsModel;

class ModulesLibrary {
	
	
	/**
	 * IoC
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;
	
	protected $moduleName="";
	
	protected $modulePath="";

	protected $namespace="";
	
	public function __construct()
	{
		
	}
	
	public static function columnTypes(){
		return array(
		"string",
		"bigInteger",
		"integer",
		"float",
		"tinyInteger",
		"smallInteger",
		"double",
		"decimal",
		"text",
		"longtext",
		"mediumtext",
		"date",
		"dateTime",
		"timestamp",
		"time",
		"boolean",
		"binary"
		);
	}
	
	public static function controllerActions(){
		return array('index', 'create', 'edit', 'delete');
	}
	
	/*
	 * Get Template for created module
	 */ 
	private function getTemplate($name) {
		return \File::get(__DIR__.'/../Templates/'.$name.'.txt');
	}

	/*
	 * Generate Template
	 */ 
	private function makeTemplate($path, $template,$debug=false){
        if($debug){
            echo $template;
            dd($this->modulePath . '/'.$path);
        }
		return \File::put($this->modulePath . '/'.$path, $template);
	}
	
	/*
	 * Generate Template
	 */ 
	public function run($moduleName, $modulePath, $contextName){
		//app_path() . '/Modules/'
		$this->moduleName 	= $moduleName;
		//$this->modulePath 	= base_path().'/'.$modulePath;
		$this->modulePath 	= $modulePath;
		$this->contextName 	= $contextName;
		$indexPath 			= \Input::get('module_path');
		//$workbench 			= \Config::get('claravel::modulesPath'); 
		$workbench 			= array(1 => 'modules'); 
		$this->namespace 	= $workbench[$indexPath];

		
		$this->generateFolder();
		$this->generateRoute();
		//$this->generateServiceProvider();
		
		$this->generateController();
		$this->generateView();
		if (\Input::get('rmodule_table') > 0){
			$this->generateModel();	
			if (\Input::get('rmodule_table') ==1){
				$this->generateMigration();
			}
		}
		
		
//		\Artisan::call('dump-autoload');
//		shell_exec('php ../../../../../artisan dump-autoload');
		if (\Input::get('rmodule_table') == 1){
			\Artisan::call('migrate', array('--force' => true,'--path' => $modulePath.'/Migrations'));
		}
		
		
		return true;
	}

	/*
	*	Generate modules folder
	*/
	public function generateFolder(){
		if ( ! \File::exists($this->modulePath))
		{
			\File::makeDirectory($this->modulePath, 0755);
		}

		// Create some resource directories
		//\File::makeDirectory($this->modulePath . '/Assets', 0755);
		//\File::makeDirectory($this->modulePath . '/Config', 0755);
		\File::makeDirectory($this->modulePath . '/Controllers', 0755);
		//\File::makeDirectory($this->modulePath . '/Lang', 0755);
		\File::makeDirectory($this->modulePath . '/Models', 0755);
		\File::makeDirectory($this->modulePath . '/Migrations', 0755);
		\File::makeDirectory($this->modulePath . '/Views', 0755);
		
	}

	
	
	/*
	 * Generate Routes
	 */  
	
	private function generateRoute(){
		$template = "<?php\n\nRoute::group(['middleware' => 'auth'], function(){\n\nRoute::controller('/" . $this->contextName.'/'.$this->moduleName . "', 'App\\".ucfirst($this->namespace)."\\".($this->contextName)."\\".($this->moduleName)."\\Controllers\\".ucfirst($this->moduleName) . "Controller');\n\n});";
		return $this->makeTemplate('routes.php', $template);
		
	}

	/*
	 * Generate ServiceProvier
	 */  
	
	private function generateServiceProvider(){
		$template = $this->getTemplate('serviceProvider');	
		$template = str_replace('{Namespace}', ucfirst($this->namespace), $template);
		$template = str_replace('{Module}', ucfirst($this->moduleName), $template);
		$template = str_replace('{Context}', ucfirst($this->contextName), $template);
		return $this->makeTemplate(ucfirst($this->moduleName).'ServiceProvider.php', $template);
	}

	/*
	 * Generate Controller from template
	 */

	private function generateController(){
		$controllerActions = \Input::get('controller_actions');
		$tbColumns = \Input::get('tb_name');
		if (\Input::get('rmodule_table') > 0){
			$template = $this->getTemplate('controller');	
			foreach($controllerActions as $key=>$val){
				$controller = $this->getTemplate('controller-'.$val);
				$template = str_replace('{controller-'.$val.'}', $controller, $template);
				if ($val == 'index'){
					$fields="";
					foreach($tbColumns as $key=>$tbColumn){
						$fields.="\t\t\t->orWhere('".$tbColumn."', 'LIKE', '%'.Input::get('search').'%')\r\n";
					}
					$template = str_replace('{fields}', $fields, $template);
				}
			}
			
			foreach($this->controllerActions() as $key=>$val){
				$template = str_replace('{controller-'.$val.'}', '', $template);
			}
		}else{
			$template = $this->getTemplate('controller-empty');	
		}
		$template = str_replace('{Namespace}', 'App\\'.ucfirst($this->namespace), $template);
		$template = str_replace('{Context}', ucfirst($this->contextName), $template);
		$template = str_replace('{Context}', ucfirst($this->contextName), $template);
		$template = str_replace('{context}', $this->contextName, $template);
		$template = str_replace('{Module}', ucfirst($this->moduleName), $template);
		$template = str_replace('{module}', $this->moduleName, $template);
		
		return $this->makeTemplate('Controllers/'.ucfirst($this->moduleName).'Controller.php', $template);
	}
	
	
	/*
	 * Generate Model from template
	 */
	private function generateModel(){
		$tableName = \Input::get('table_name');
		$template = $this->getTemplate('model');	
		$template = str_replace('{Namespace}', 'App\\'.ucfirst($this->namespace), $template);
		$template = str_replace('{Context}', ucfirst($this->contextName), $template);
		$template = str_replace('{context}', ($this->contextName), $template);
		$template = str_replace('{Module}', ucfirst($this->moduleName), $template);
		$template = str_replace('{module}', $this->moduleName, $template);
		$template = str_replace('{table}', $tableName, $template);
		
		$tbColumns = \Input::get('tb_name');
		$rules="";
		foreach($tbColumns as $key=>$tbColumn){
			$rules .="\t\t'".$tbColumn."' => 'required',\r\n";
		}	
		$template = str_replace('{rules}', $rules, $template);
		return $this->makeTemplate('Models/'.ucfirst($this->moduleName).'Model.php', $template);
	}
	
	
	/*
	 * Generate Views from template
	 */
	private function generateView(){
		$views = \Input::get('controller_actions');
		foreach($views as $view){
			//create permission roles
			
			////assing permission
			$permission['name'] = 'mod-'.$this->moduleName.'-'.$view;
			$permission['description'] = 'Allow Access '.\Input::get('name').' '.ucfirst($view);
			\PermissionsLibrary::assignPermission($permission);

			if ($view !='delete'){
				if (\Input::get('rmodule_table') > 0){
					$primaryKey = \Input::get('primary_key');	
					$template = $this->getTemplate('views/'.$view);	
					$template = str_replace('{Context}', ucfirst($this->contextName), $template);
					$template = str_replace('{context}', $this->contextName, $template);
					$template = str_replace('{Module}', ucfirst($this->moduleName), $template);
					$template = str_replace('{module}', $this->moduleName, $template);
						if ($view == 'index'){
							$head = $this->generateViewIndex();
							$body = $this->generateViewIndex(1);
							$template = str_replace('{head}', $head, $template);
							$template = str_replace('{body}', $body, $template);
							
							$permission['name'] = 'mod-'.$this->moduleName.'-listall';
							$permission['description'] = 'Allow Access '.\Input::get('name').' Listall';
							\PermissionsLibrary::assignPermission($permission);

						}
						if ($view == 'create'){
							$fields = $this->generateViewField();
							$template = str_replace('{fields}', $fields, $template);
						}
						if ($view == 'edit'){
							$fields = $this->generateViewField();
							$template = str_replace('{fields}', $fields, $template);
						}
					$template = str_replace('{primaryKey}', $primaryKey, $template);	
				}else{
					$template = $this->getTemplate('views/'.$view.'-empty');	
					$template = str_replace('{Context}', ucfirst($this->contextName), $template);
					$template = str_replace('{context}', $this->contextName, $template);
					$template = str_replace('{Module}', ucfirst($this->moduleName), $template);
					$template = str_replace('{module}', $this->moduleName, $template);
				}	
			$this->makeTemplate('Views/'.$view.'.blade.php', $template);
			}
		}
	}


	private function generateViewField(){
		$tbLabels = \Input::get('tb_label');
		$tbColumns = \Input::get('tb_name');
		$tbIntype = \Input::get('tb_intype');
		$tbDbtype = \Input::get('tb_dbtype');
		$tbMax = \Input::get('tb_max');
		$fields="";
		foreach($tbColumns as $key=>$tbColumn){
			$fields .="\t\t\t\t<div class=\"form-group\">\r\n";
			$fields .="\t\t\t\t\t{!! Form::label('".$tbColumn."', '".$tbLabels[$key].":', array('class' => 'col-sm-3 control-label')) !!}\r\n";
			$fields .="\t\t\t\t\t<div class=\"col-sm-7\">\r\n";
			switch ($tbIntype[$key]) {
				case 'select':
					$fields .="\t\t\t\t\t\t{!! Form::".$tbIntype[$key]."('".$tbColumn."', array('1'=> '1'), '1') !!}\r\n";
					break;
				
				default:
					$fields .="\t\t\t\t\t\t{!! Form::".$tbIntype[$key]."('".$tbColumn."', null, array('class'=> 'form-control')) !!}\r\n";
					break;
			}
			$fields .="\t\t\t\t\t</div>\r\n";	
			$fields .="\t\t\t\t</div>\r\n";
		}	
		return $fields;
	}
	
	private function generateViewIndex($tb=0){
		$tbLabels = \Input::get('tb_label');
		$tbColumns = \Input::get('tb_name');
		$tbIntype = \Input::get('tb_intype');
		$tbDbtype = \Input::get('tb_dbtype');
		$tbMax = \Input::get('tb_max');
		$head="";
		$body="";
		foreach($tbColumns as $key=>$tbColumn){
			$head.="\t\t\t\t\t<th>".$tbLabels[$key]."</th>\r\n";
		}	
		foreach($tbColumns as $key=>$tbColumn){
			$body.="\t\t\t\t\t<td>{!!\$".$this->moduleName."->".$tbColumn."!!}</td>\r\n";
		}	
		if ($tb==1){
			return $body;
		}
		return $head;
	}
	
	
	
	/*
	 * Generate Model from template
	 */
	private function generateMigration(){
		$tableName = \Input::get('table_name');
		$primaryKey = \Input::get('primary_key');
		
		$tbColumns = \Input::get('tb_name');
		$tbDbtype = \Input::get('tb_dbtype');
		$tbMax = \Input::get('tb_max');
		
		$template = $this->getTemplate('migration');	
		$template = str_replace('{Context}', ucfirst($this->contextName), $template);
		$template = str_replace('{context}', ($this->contextName), $template);
		$template = str_replace('{Module}', ucfirst($this->moduleName), $template);
		$template = str_replace('{module}', $this->moduleName, $template);
		$template = str_replace('{table}', $tableName, $template);
		$template = str_replace('{primaryKey}', $primaryKey, $template);
        $fields = '';
            \Schema::create($tableName, function($table)use($fields,$tbColumns,$tbDbtype,$tbMax,$primaryKey) {
                $table->bigIncrements($primaryKey);
                foreach($tbColumns as $key=>$tbColumn){
                    switch($tbDbtype[$key]) {
                        case "double" : 
                            $table->double($tbColumn, $tbMax[$key], 8);
                            break;
                        case "decimal" : 
                            $table->decimal($tbColumn, $tbMax[$key], 2);
                            break;
                        case "string" : 
                            $table->string($tbColumn, $tbMax[$key]);
                            break;
                        case "bigInteger" : 
                            $table->bigInteger($tbColumn);
                            break;
                        default : 
                            @$table->$tbDbtype[$key]($tbColumn);
                            $fields .= "\t\t\t\$table->".$tbDbtype[$key]."('".$tbColumn."');\r\n";break;
                    }
                }
                $table->bigInteger('user_id');
                $table->bigInteger('role_id');
                $table->dateTime('created_at');
                $table->timestamp('updated_at')->useCurrent();
            });      
		
		$fields="";
		
		foreach($tbColumns as $key=>$tbColumn){
			switch($tbDbtype[$key]) {
				case "double" : $fields .= "\t\t\t\$table->".$tbDbtype[$key]."('".$tbColumn."', ".$tbMax[$key].", 8);\r\n";break;
				
				case "decimal" : $fields .= "\t\t\t\$table->".$tbDbtype[$key]."('".$tbColumn."', ".$tbMax[$key].", 2);\r\n";break;
				
				case "string" : $fields .= "\t\t\t\$table->".$tbDbtype[$key]."('".$tbColumn."', ".$tbMax[$key].");\r\n";break;
				
				default : $fields .= "\t\t\t\$table->".$tbDbtype[$key]."('".$tbColumn."');\r\n";break;
			}
		}
		$fields.="\t\t\t\$table->bigInteger('user_id');\r\n";
		$fields.="\t\t\t\$table->bigInteger('role_id');\r\n";
		$template = @str_replace('{fields}', $fields, $template);
		
		return $this->makeTemplate('Migrations/'.date('Y_m_d_His').'_'.$this->moduleName.'.php', $template);
	}
	
	
	
}
