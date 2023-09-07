<?php namespace App\Modules\example\uploadgambar\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\example\uploadgambar\Models\UploadgambarModel;
use Input,View, Request, Form, File;

/**
* Uploadgambar Controller
* @var Uploadgambar
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class UploadgambarController extends Controller {
    protected $uploadgambar;

    public function __construct(UploadgambarModel $uploadgambar){
        $this->uploadgambar = $uploadgambar;
    }

        public function getIndex(){
        cekAjax();
        if (Input::has('search')) {
            if(strlen(Input::has('search')) > 0){
                $uploadgambars = $this->uploadgambar
                			->orWhere('nama', 'LIKE', '%'.Input::get('search').'%')
			->orWhere('gambar', 'LIKE', '%'.Input::get('search').'%')

                ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $uploadgambars = $this->uploadgambar->all();
            }
        }else{
            $uploadgambars = $this->uploadgambar->all();
        }
        return View::make('uploadgambar::index', compact('uploadgambars'));
    }


        public function getCreate(){
        cekAjax();
        return View::make('uploadgambar::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
		$destinationPath = base_path().'/packages/upload/gambar/';    
        if(\Input::hasFile('gambar')){			
            @unlink($destinationPath.$gambar->logo);			
			$gambars = \Input::file('gambar');						
			$tipefile = $gambars->getClientOriginalExtension();			
			$filename = str_random(7).'.'.$tipefile;			
			$file = $gambars;			
			//debug($destinationPath);		
			$uploadSuccess  = $file->move($destinationPath, $filename);			
			$input['gambar'] = $filename;
		}
		
        $validation = \Validator::make($input, UploadgambarModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->uploadgambar->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $uploadgambar = $this->uploadgambar->find($id);
        //if (is_null($uploadgambar)){return \Redirect::to('example/uploadgambar/index');}
        return View::make('uploadgambar::edit', compact('uploadgambar'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
		$gambar = $this->uploadgambar->where('id', '=', $id)->first();		
        $destinationPath = base_path().'/packages/upload/gambar/';        				
        if(\Input::hasFile('logo')){			
            @unlink($destinationPath.$gambar->logo);			
			$gambars = \Input::file('gambar');						
			$tipefile = $gambars->getClientOriginalExtension();			
			$filename = str_random(7).'.'.$tipefile;			
			$file = $gambars;			
			$uploadSuccess  = $file->move($destinationPath, $filename);			
			$input['gambar'] = $filename;
		}
		
        $validation = \Validator::make($input, UploadgambarModel::$rules);
        if ($validation->passes()){
            $uploadgambar = $this->uploadgambar->find($id);
            echo ($uploadgambar->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }


	
        public function postDelete(){
        cekAjax();
        $ids = Input::get('id');
        if (is_array($ids)){
            foreach($ids as $id){
                $this->uploadgambar->find($id)->delete();
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->uploadgambar->find($ids)->delete())?9:0;
        }
    }

}
