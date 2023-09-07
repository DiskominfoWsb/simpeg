<?php namespace App\Modules;
 
/**
* ServiceProvider
*
*
* @author Kamran Ahmed <kamranahmed.se@gmail.com>
* @edited Wiguna Ahmad <wiguna.ahmad@yahoo.com>
* @package App\Modules
*
* Diubah agar dapat membaca module di Context
*/
class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot(){
        $modules = \DB::table('modules as m')
            ->join('contexts as c','m.id_context','=','c.id')
            ->orderBy('c.order')
            ->orderBy('m.order')
            ->select('m.*','c.name as context')
            ->get();
        /*
        Load Home Module
        */
        if(file_exists(__DIR__.'/home/routes.php')) {
            include __DIR__.'/home/routes.php';
        }
        // Load the views
        if(is_dir(__DIR__.'/home/Views')) {
            //die($outside.'/'.$context);
            $this->loadViewsFrom(__DIR__.'/home/Views', 'home');
        }
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        
        foreach($modules as $module){
            if(file_exists(__DIR__.'/'.(strtolower(str_replace(' ','',$module->context))).'/'.(strtolower(str_replace(' ','',$module->name))).'/routes.php')) {
                include __DIR__.'/'.(strtolower(str_replace(' ','',$module->context))).'/'.(strtolower(str_replace(' ','',$module->name))).'/routes.php';
            }else{
//                echo __DIR__.'/'.(strtolower($module->context)).'/'.(strtolower(str_replace(' ','',$module->name))).'/routes.php<br>';
//                die();
            }
            
            
            // Load the views
            if(is_dir(__DIR__.'/'.(strtolower(str_replace(' ','',$module->context))).'/'.(strtolower(str_replace(' ','',$module->name))).'/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.(strtolower(str_replace(' ','',$module->context))).'/'.(strtolower(str_replace(' ','',$module->name))).'/Views', strtolower(str_replace(' ','',$module->name)));
            }else{
            }
            
            //aliaskan semua model sehingga bisa di-load tanpa namespace dan tanpa composer maneh
            if(is_dir(__DIR__.'/'.(strtolower(str_replace(' ','',$module->context))).'/'.(strtolower(str_replace(' ','',$module->name))).'/Models')) {
                    $c = 'App\Modules\\'.(strtolower(str_replace(' ','',$module->context))).'/'.(strtolower(str_replace(' ','',$module->name))).'/Models/'.ucfirst(strtolower(str_replace(' ','',$module->name))).'Model';
                    $c = str_replace('/','\\',$c);
                    $loader->alias(ucfirst(strtolower(str_replace(' ','',$module->name))).'Model' , $c);
            }else{
//                echo __DIR__.'/'.(strtolower($module->context)).'/'.(strtolower(str_replace(' ','',$module->name))).'/Models<br>';
            }
        }
        
        //Register custom controller disini
        //$loader->alias('AuthController', 'Tugumuda\Claravel\Controllers\AuthController');
        
        /*
        // Jika ambil dari konfigurasi Module di config/module.php
        $modules = config("module.modules");
        foreach($modules as $outside => $module){
            if(is_array($module)){
                // Jika Berupa Context berisi module
                foreach($module as $context){
                    if(file_exists(__DIR__.'/'.$outside.'/'.$context.'/routes.php')) {
                        include __DIR__.'/'.$outside.'/'.$context.'/routes.php';
                    }
                    // Load the views
                    if(is_dir(__DIR__.'/'.$outside.'/'.$context.'/Views')) {
                        //die($outside.'/'.$context);
                        $this->loadViewsFrom(__DIR__.'/'.$outside.'/'.$context.'/Views', $outside.'/'.$context);
                    }                                    
                }
            }else{
                //Jika berupa module tanpa context
                if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                    include __DIR__.'/'.$module.'/routes.php';
                }
                if(is_dir(__DIR__.'/'.$module.'/Views')) {
                    $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
                }                
            }
        }*/
        //$modules = 
    }
    public function register() {
    }
}