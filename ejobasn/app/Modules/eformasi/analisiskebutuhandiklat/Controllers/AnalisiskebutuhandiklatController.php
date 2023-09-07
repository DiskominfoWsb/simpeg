<?php namespace App\Modules\eformasi\analisiskebutuhandiklat\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\eformasi\analisiskebutuhandiklat\Models\AnalisiskebutuhandiklatModel;
use Input,View, Request, Form, File;

/**
* Analisiskebutuhandiklat Controller
* @var Analisiskebutuhandiklat
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class AnalisiskebutuhandiklatController extends Controller {
    protected $analisiskebutuhandiklat;

    public function __construct(AnalisiskebutuhandiklatModel $analisiskebutuhandiklat){
        $this->analisiskebutuhandiklat = $analisiskebutuhandiklat;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $analisiskebutuhandiklats = $this->analisiskebutuhandiklat
                			->orWhere('idpetajab', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('periode_bulan', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('periode_tahun', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idskpd', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjenjab', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('idjabatan', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('iddiklat', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $analisiskebutuhandiklats = $this->analisiskebutuhandiklat->all();
            }
        }else{
            $analisiskebutuhandiklats = $this->analisiskebutuhandiklat->all();
        }
        return View::make('analisiskebutuhandiklat::index', compact('analisiskebutuhandiklats'));
    }

    /*function view data atribut dari link */
    public function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('analisiskebutuhandiklat::'.$view.'_data');
    }
    
    public function postPdf(){
        $view = Request::segment(4);
        $contents = view('analisiskebutuhandiklat::'.$view.'_pdf');
        $response = \Response::make($contents);
        $response->header('Content-Type', 'application/pdf');
        return $response;
    }

    //{controller-show}

    
	
    
}
