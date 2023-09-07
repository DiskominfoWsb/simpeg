<?php namespace App\Modules\settings\menu\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\settings\menu\Models\MenuModel;
use Input,View, Request, Form, File;

/**
* Menu Controller
* @var Menu
* Generate from Custom Laravel 5.1 by Aa Gun. 
*
* Developed by Divisi Software Development - Dinustek. 
* Please write log when you do some modification, don't change anything unless you know what you do
* Semarang, 2016
*/

class MenuController extends Controller {
    protected $menu;

    public function __construct(MenuModel $menu){
        $this->menu = $menu;
    }

    public function getIndex(){
        
        cekAjax();
        $where = " mast_setting_jadwal.id != ''";

        if ((strlen(Input::has('search')) > 0) or (Input::get('id_jenis') != '') or (Input::get('bulan') != '') or (Input::get('tahun') != ''))
        {
            (Input::get('tahun')!='')?$where.=" and mast_setting_jadwal.periode_tahun = '".Input::get('tahun')."'":"";
            (Input::get('bulan')!='')?$where.=" and mast_setting_jadwal.periode_bulan = '".Input::get('bulan')."'":"";
            (Input::get('id_jenis')!='')?$where.=" and mast_setting_jadwal.id_jenis = '".Input::get('id_jenis')."'":"";
            (Input::get('search')!='')?$where.=" and (mast_setting_jadwal.judul LIKE '%".Input::get('search')."%' or mast_setting_jadwal.keterangan LIKE '%".Input::get('search')."%')":"";

            $menus = \DB::table('mast_setting_jadwal')
                ->select('mast_setting_jadwal.*','mast_setting_jadwal_jenis.jenis')
                ->leftJoin('mast_setting_jadwal_jenis', 'mast_setting_jadwal.id_jenis', '=', 'mast_setting_jadwal_jenis.id')
                ->whereRaw($where)
                ->orderbyraw("mast_setting_jadwal.periode_tahun DESC, mast_setting_jadwal.periode_bulan DESC")
                ->paginate($_ENV['configurations']['list-limit']);
        }else{
            $menus = $this->menu->all();
        }
        return View::make('menu::index', compact('menus'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('menu::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::except('mulai_jam', 'selesai_jam');

        $dt['periode_tahun'] = $input['periode_tahun'];
        $dt['periode_bulan'] = $input['periode_bulan'];
        $dt['id_jenis'] = $input['id_jenis'];

        /*cek sudah ada atau belum*/
        $cek = \DB::table('mast_setting_jadwal')->where($dt)->count();
        $validation = \Validator::make($input, MenuModel::$rules);
        if ($validation->passes()){
            if($cek == 0){
                $input['user_id'] = \Session::get('user_id');
                $input['role_id'] = \Session::get('role_id');
                echo ($this->menu->create($input))?1:"Gagal Disimpan";
            }else{
                echo "Jadwal dengan periode dan jenis jadwal sudah pernah dibuat, Apabila ada perubahan silahkan edit melalui menu edit.";
            }
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

        public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $menu = $this->menu->find($id);
        //if (is_null($menu)){return \Redirect::to('settings/menu/index');}
        return View::make('menu::edit', compact('menu'));
    }
    
    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, MenuModel::$rules_edit);

        if ($validation->passes()){
            $menu = $this->menu->find($id);
            echo ($menu->update($input))?4:"Gagal Disimpan";
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
                $cek = $this->menu->find($id);
                if($cek){
                    $cek->delete();
                }
            }
            echo 'Data berhasil dihapus';
        }
        else{
            echo ($this->menu->find($ids)->delete())?9:0;
        }
    }

}
