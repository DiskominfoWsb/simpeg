<?php 

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class LibrariesServiceProvider extends ServiceProvider {
   public function boot(){
   }

   public function register(){
        foreach (glob(app_path().'/Libraries/*.php') as $filename){
            require_once($filename);
        }
   }
}
