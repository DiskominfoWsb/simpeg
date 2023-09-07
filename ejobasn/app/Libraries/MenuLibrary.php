<?php
namespace App\Libraries;

use Illuminate\Support\Facades\Cache;

use App\Modules\developer\context\Models\ContextModel;

class MenuLibrary
{

    //protected $open_menu ="<ul class=\"nav nav-sidebar\">";
    //protected $open_submenu ="<ul class=\"dropdown-menu first-menu\">";

    protected $open_menu ="<ul class='sidebar-menu'>";
    protected $open_submenu = '<ul class="treeview-menu">';

    protected $use_cache = true;

    protected $CACHE_SIDEBAR_NAME = "cache-sidebar-menu";
    protected $CACHE_AGE = 1440;


    public function __construct()
    {
        $this->CACHE_SIDEBAR_NAME .= "-".session('role_id');
    }

    public function clearCache()
    {
        Cache::store('file')->forget($this->CACHE_SIDEBAR_NAME);
    }

    public function flushCache()
    {
        Cache::store('file')->flush();
    }


     public function createMenu(){
        $str_menu = $this->open_menu;
        $contexts = \ContextModel::where('is_nav_bar', 1)
        ->where('flag', 1)
        ->orderBy('order')->get();
        foreach($contexts as &$context ){
            $contextName = strtolower(str_replace(" ", "", $context->name));
            if (\PermissionsLibrary::hasPermission('context-'.$contextName)){
                $route = \Request::path();
                //$active=(strpos($route, $contextName)!==false)?"open":"";
                if ($context->path !='') {
                    if (strtolower($context->name) == 'dashboard'){
                        $str_menu.="<li>";
                        $str_menu.="<a href='".url('')."/dashboard'><i class='fa fa-dashboard'></i><span>".$context->name."</span> <span class='".strtolower($contextName)."'></span></a>";
                        $str_menu.="</li>";                    
                    }else{
                        $str_menu.="<li class='treeview'>";
                        $str_menu.="<i class='fa ".$context->icons."'></i><span>".$context->name."</span> <span class='".strtolower($contextName)."'></span><i class='fa fa-angle-left pull-right'></i>";
                        $str_menu.="</li>";
                    }
                }else{
                    if(strtolower($context->name) == 'pengisian'){
                        $str_menu.="<li class='treeview ".((session('role_id')>3)?'active':'')."'>";
                        $str_menu.="<a href='#'><i class='fa ".$context->icons."'></i><span>Master Data</span> <span class='".strtolower($contextName)."'></span><i class='fa fa-angle-left pull-right'></i></a>";
                        $str_menu.=$this->createSubMenu($context->name, $context->id);
                        $str_menu.="</li>";
                    }else if(strtolower($context->name) == 'eformasi'){
                        $set_active = null;
                        $modules = ContextModel::find($context->id)->modules()
                        ->where('id_parent', '0')
                        ->where('flag', 1)
                        ->orderBy('order')->get();
                        foreach ($modules as &$module) {
                            $module_name = str_replace(" ", "", $module->name);
                            if (\PermissionsLibrary::hasPermission('mod-'.strtolower($module_name).'-index')) {
                                $have_child = \ModulesModel::where('id_parent', $module->id)->count();
                
                                if ($module->icons == '') {
                                    $icon = 'fa-dot-circle-o';
                                } else {
                                    $icon = $module->icons;
                                }
                
                                $class_active = '';
                                if ($module->path == $set_active) {
                                    $class_active = 'active';
                                }
                
                                $str_menu.="<li class='".$class_active."'>
                                    <a id='menu-akhir' href='".url('').$module->path."' data-path='".url('beranda?tab=').urlencode($module->path)."'>
                                        <i class='fa ".$icon."'></i>".(($module->alias!=null)?$module->alias:$module->name)."
                                    </a>
                                </li>";
                            }
                            if($module->name=="Kebutuhan Jabatan" && substr(session('idskpd'),0,2) == '04'){
                                if ($module->icons == '') {
                                    $icon = 'fa-dot-circle-o';
                                } else {
                                    $icon = $module->icons;
                                }
                
                                $class_active = '';
                                if ($module->path == $set_active) {
                                    $class_active = 'active';
                                }

                                $str_menu.="<li class='".$class_active."'>
                                    <a id='menu-akhir' href='".url('').$module->path."' data-path='".url('beranda?tab=').urlencode($module->path)."'>
                                        <i class='fa ".$icon."'></i>".(($module->alias!=null)?$module->alias:$module->name)."
                                    </a>
                                </li>";
                            }
                        }
                    }else{
                        $str_menu.="<li class='treeview ".((session('role_id')>3)?'active':'')."'>";
                        $str_menu.="<a href='#'><i class='fa ".$context->icons."'></i><span>".$context->name."</span> <span class='".strtolower($contextName)."'></span><i class='fa fa-angle-left pull-right'></i></a>";
                        $str_menu.=$this->createSubMenu($context->name, $context->id);
                        $str_menu.="</li>";
                    }
                }
            }            
        }
        $str_menu.="</ul>";
        return $str_menu;        
    }
    

    // public function createMenu($set_active = null)
    // {
    //     if ($this->use_cache) {
    //         $minutes = $this->CACHE_AGE;
    //         return Cache::store('file')->remember($this->CACHE_SIDEBAR_NAME, $minutes, function () use ($set_active) {
    //             return $this->buildMenu($set_active);
    //         });
    //     }

    //     return $this->buildMenu($set_active);
    // }

    public function createMenuMhs()
    {
        $str_menu = $this->open_menu;
        $contexts = \MenumahasiswaModel::
            //                where('is_nav_bar', 1)
            //        ->where('flag', 1)
            orderBy('id')->get();
        foreach ($contexts as &$context) {
            $contextName = strtolower(str_replace(" ", "", $context->judul));
            $route = \Request::path();
            //$active=(strpos($route, $contextName)!==false)?"open":"";
            if ($context->path !='') {
                $str_menu.="<li class='treeview'>";
                $str_menu.="<i class='fa ".@$context->icons."'></i><span>".$context->judul."</span><i class='fa fa-angle-left pull-right'></i>";
                $str_menu.="</li>";
            } else {
                $str_menu.="<li class='treeview'>";
                $str_menu.="<a href='#'><i class='fa ".$context->icons."'></i><span>".$context->name."</span><i class='fa fa-angle-left pull-right'></i></a>";
                $str_menu.=$this->createSubMenu($context->name, $context->id);
                $str_menu.="</li>";
            }
        }
        $str_menu.="</ul>";
        return $str_menu;
    }

    private function createSubMenu($context, $context_id){
        $str_submenu = $this->open_submenu;
        $modules = \ContextModel::find($context_id)->modules()
            ->where('id_parent', '0')
            ->where('flag', 1)
            ->orderBy('order')->get();
        foreach($modules as &$module ){
            $module_name = str_replace(" ", "", $module->name);
            if (\PermissionsLibrary::hasPermission('mod-'.strtolower($module_name).'-index')){
                $have_child = \ModulesModel::where('id_parent',$module->id)->orderBy('order')->get();

                if (count($have_child) > 0){
                    $str_submenu.="<li class='".((session('role_id')==5)?'active':'')."'><a href='".url('').$module->path."'><i class='fa ".$module->icons."'></i> ".$module->name." <span class='".strtolower($module_name)."'></span><i class='fa fa-angle-left pull-right'></i></a><ul class='treeview-menu'>";
                    foreach($have_child as &$module ){
                        $module_name2 = str_replace(" ", "", $module->name);
                        if(session('role_id') == 3){
                            if($module->name === 'Biodata'){
                                $str_submenu.="<li><a id='menu-akhir' href='".url('').$module->path."'><i class='fa ".$module->icons."'></i> ".$module->name."<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                            }else{
                                $str_submenu.="<li style='display: none'><a id='menu-akhir' href='".url('').$module->path."'><i class='fa ".$module->icons."'></i> ".$module->name."<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                            }
                        }else{
                            if($module->name == 'Biodata'){
                                $str_submenu.="<li><a id='menu-akhir' href='".url('').$module->path."'><i class='fa ".$module->icons."'></i> Data Pegawai<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                            }else if($module->name == 'Data Pegawai'){
                                if(session('role_id') != 5){
                                    $str_submenu.="<li><a id='menu-akhir' href='".url('')."/epersonal/biodata/edit'><i class='fa ".$module->icons."'></i> Biodata<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                                }
                            }else {
                                $str_submenu.="<li><a id='menu-akhir' href='".url('').$module->path."'><i class='fa ".$module->icons."'></i> ".$module->name."<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                            }
                        }
                    }
                    $str_submenu.="</ul></li>";
                }else{
                    $str_submenu.="<li><a id='menu-akhir' href='".url('').$module->path."'><i class='fa ".$module->icons."'></i>".$module->name."<span class='".strtolower($module_name)." pull-right'></span></a></li>";
                }
            }
        }
        $str_submenu.="</ul>";
        return $str_submenu;
    }
    // private function createSubMenu($context, $context_id, $set_active)
    // {
    //     $str_submenu = $this->open_submenu;
    //     $modules = ContextModel::find($context_id)->modules()
    //             ->where('id_parent', '0')
    //             ->where('flag', 1)
    //             ->orderBy('order')->get();
    //     foreach ($modules as &$module) {
    //         $module_name = str_replace(" ", "", $module->name);
    //         if (\PermissionsLibrary::hasPermission('mod-'.strtolower($module_name).'-index')) {
    //             $have_child = \ModulesModel::where('id_parent', $module->id)->count();

    //             if ($module->icons == '') {
    //                 $icon = 'fa-dot-circle-o';
    //             } else {
    //                 $icon = $module->icons;
    //             }

    //             $class_active = '';
    //             if ($module->path == $set_active) {
    //                 $class_active = 'active';
    //             }

    //             $str_submenu.="<li class='".$class_active."'>
    //                 <a id='menu-akhir' href='".url('').$module->path."' data-path='".url('beranda?tab=').urlencode($module->path)."'>
    //                     <i class='fa ".$icon."'></i>".(($module->alias==null)?$module->name:$module->alias)."
    //                 </a>
    //             </li>";
    //         }
    //     }
    //     $str_submenu.="</ul>";
    //     return $str_submenu;
    // }

    private function createSubSubMenu($parent_id)
    {
        $str_subsubmenu="<ul class=\"dropdown-menu\">";
        $str_subsubmenu .="<li role=\"presentation\" class=\"dropdown-header\">Sub Menu</li>";
        $modules = ModulesModel::where('id_parent', $parent_id)
        ->where('flag', 1)
        ->orderBy('order')->get();
        foreach ($modules as $module) {
            $module_name = str_replace(" ", "", $module->name);
            if (\PermissionsLibrary::hasPermission('mod-'.strtolower($module_name).'-index')) {
                $have_child = ModulesModel::where('id_parent', $module->id)->count();
                if ($have_child > 0) {
                    $str_subsubmenu.="<li  class=\"dropdown-submenu\"><a href=\"". $module->path ."\">";
                    $str_subsubmenu.="<span class=\"glyphicon ". $module->icons ."\"></span> ". $module->name  ." </a>";

                    $str_subsubmenu.=$this->createSubSubMenu($module->id);
                } else {
                    $str_subsubmenu.="<li><a href=\"". $module->path ."\" class=\"".\Config::get('claravel::ajax')."\">";
                    $str_subsubmenu.="<span class=\"glyphicon ". $module->icons ."\"></span> ". $module->name  ." </a>";
                }
                $str_subsubmenu.="</li>";
            }
        }
        $str_subsubmenu.="</ul>";
        return $str_subsubmenu;
    }


    private function buildMenu($set_active = null)
    {
        $str_menu = $this->open_menu;
        $contexts = ContextModel::where('is_nav_bar', 1)
                    ->where('flag', 1)
                    ->orderBy('order')
                    ->get();
        foreach ($contexts as &$context) {
            $contextName = strtolower(str_replace(" ", "", $context->name));
            if (\PermissionsLibrary::hasPermission('context-'.$contextName)) {
                $route = \Request::path();
                //$active=(strpos($route, $contextName)!==false)?"open":"";
                if ($context->path !='') {
                    if (strtolower($context->name) == 'dashboard') {
                        $str_menu.="<li>";
                        $str_menu.="<a href='".url('')."/dashboard'><i class='fa fa-dashboard'></i><span>".$context->name."</span></a>";
                        $str_menu.="</li>";
                    } else {
                        $str_menu.="<li class='treeview'>";
                        $str_menu.="<i class='fa ".$context->icons."'></i><span>".$context->name."</span><i class='fa fa-angle-left pull-right'></i>";
                        $str_menu.="</li>";
                    }
                } else {
                    if (strtolower($context->name) == 'pengisian') {
                        $str_menu.="<li class='treeview'>";
                        $str_menu.="<a href='#'><i class='fa ".$context->icons."'></i><span>Master Data</span><i class='fa fa-angle-left pull-right'></i></a>";
                        $str_menu.=$this->createSubMenu($context->name, $context->id, $set_active);
                        $str_menu.="</li>";
                    } else if (strtolower($context->name) == 'eformasi') {
                        $modules = ContextModel::find($context->id)->modules()
                        ->where('id_parent', '0')
                        ->where('flag', 1)
                        ->orderBy('order')->get();
                        foreach ($modules as &$module) {
                            $module_name = str_replace(" ", "", $module->name);
                            if (\PermissionsLibrary::hasPermission('mod-'.strtolower($module_name).'-index')) {
                                $have_child = \ModulesModel::where('id_parent', $module->id)->count();
                
                                if ($module->icons == '') {
                                    $icon = 'fa-dot-circle-o';
                                } else {
                                    $icon = $module->icons;
                                }
                
                                $class_active = '';
                                if ($module->path == $set_active) {
                                    $class_active = 'active';
                                }
                
                                $str_menu.="<li class='".$class_active."'>
                                    <a id='menu-akhir' href='".url('').$module->path."' data-path='".url('beranda?tab=').urlencode($module->path)."'>
                                        <i class='fa ".$icon."'></i>".$module->name."
                                    </a>
                                </li>";
                            }
                        }
                    } else {
                        $str_menu.="<li class='treeview'>";
                        $str_menu.="<a href='#'><i class='fa ".$context->icons."'></i><span>".$context->name."</span><i class='fa fa-angle-left pull-right'></i></a>";
                        $str_menu.=$this->createSubMenu($context->name, $context->id, $set_active);
                        $str_menu.="</li>";
                    }
                }
            }
        }
        $str_menu.="</ul>";
        return $str_menu;
    }
}
