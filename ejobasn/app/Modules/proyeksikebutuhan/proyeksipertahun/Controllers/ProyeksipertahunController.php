<?php namespace App\Modules\proyeksikebutuhan\proyeksipertahun\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\proyeksikebutuhan\proyeksipertahun\Models\ProyeksipertahunModel;
use App\Models\Petajab;
use Input,View, Request, Form, File, Session;

class ProyeksipertahunController extends Controller {
    protected $proyeksipertahun;

    public function __construct(ProyeksipertahunModel $proyeksipertahun){
        $this->proyeksipertahun = $proyeksipertahun;
    }

    public function getIndex(){
        cekAjax();
        if(Session::get('role_id') <= 3){
            $idskpd = Input::get('idskpd')==''?'25':Input::get('idskpd');            
        }else{
            $idskpd = Session::get('idskpd');
        }

        $proyeksipertahuns = Petajab::proyeksiPertahun($idskpd);

        return View::make('proyeksipertahun::index', compact('proyeksipertahuns'));
    }

    function getExcel(){
        if(Session::get('role_id') <= 3){
            $idskpd = ((Input::get('idskpd') != '')?Input::get('idskpd'):'');
        }else{
            $idskpd = Session::get('idskpd');
        }        

        $proyeksipertahuns = Petajab::proyeksiPertahun($idskpd);
        $view = Request::segment(4);

        return View::make('proyeksipertahun::'.$view.'_excel', compact('idskpd','proyeksipertahuns'));
    }
   //{controller-show}
}