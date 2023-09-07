<?php namespace App\Modules\rekapkebutuhanasn\rekapkebutuhanopd\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\eformasi\petajabatan\Models\PetajabatanModel;
use Input,View, Request, Form, File;

/**
* Rekapkebutuhanopd Controller
* @var Rekapkebutuhanopd
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RekapkebutuhanopdController extends Controller {
    protected $rekapkebutuhanopd;

    public function getIndex(){
        cekAjax();
       
        return View::make('rekapkebutuhanopd::index');
    }

    public function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('rekapkebutuhanopd::'.$view.'_data');
    }   
    
}
