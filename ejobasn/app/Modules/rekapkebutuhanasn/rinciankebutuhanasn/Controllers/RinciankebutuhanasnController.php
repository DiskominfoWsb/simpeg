<?php namespace App\Modules\rekapkebutuhanasn\rinciankebutuhanasn\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\rekapkebutuhanasn\rinciankebutuhanasn\Models\RinciankebutuhanasnModel;
use Input,View, Request, Form, File;

/**
* Rinciankebutuhanasn Controller
* @var Rinciankebutuhanasn
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class RinciankebutuhanasnController extends Controller {
    protected $rinciankebutuhanasn;

    public function getIndex(){
        cekAjax();
        
        return View::make('rinciankebutuhanasn::index');
    }

    public function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('rinciankebutuhanasn::'.$view.'_data');
    }   
    
}
