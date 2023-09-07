<?php namespace App\Modules\rekapkebutuhanasn\rekapkebutuhanglobal\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\eformasi\petajabatan\Models\PetajabatanModel;
use Input,View, Request, Form, File;

class RekapkebutuhanglobalController extends Controller {
    protected $rekapkebutuhanglobal;

    //menampilkan halaman index
    public function getIndex(){
        cekAjax();
       
        return View::make('rekapkebutuhanglobal::index');
    }

    //menampilkan data rekap kebutuhan global
    public function postData(){
        cekAjax();
        $view = Request::segment(4);
        return View::make('rekapkebutuhanglobal::'.$view.'_data');
    }
}
