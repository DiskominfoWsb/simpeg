<?php

namespace App\Helpers;


/**
* ClaravelHelpers class
*/



class ClaravelHelpers {
	public static function btnPrint($id = false,$caption='',$lokasi = ""){
            return "<a target='_blank' id='".$id."' type='submit' class='btn btn-success' href=".$lokasi."><span class='glyphicon glyphicon-print'></span>"
                    .$caption
                    ."</a>";
	}
        
        public static function getBojo($bojo_name = ''){
            
        }

        public static function btnCreate($caption = 'Buat Baru'){
		if (\PermissionsLibrary::canAdd()){
			//return "<a id='".$id."' href=\"/".\Request::path().'/create'."\" class=\"btn btn-primary ".\Config::get('claravel::ajax')."\"><span class=\"glyphicon glyphicon-plus-sign\"></span>$caption</a>";
			return "<a id='buat' href='".url().'/'.\Request::path().'/create'."' class='btn btn-primary".\Config::get('claravel::ajax')."'><i class='fa fa-plus-square'></i> $caption</a>";
		}
	}
        
	public static function btnCancel($caption = 'Batalkan'){
		$route = pathinfo(\Request::path(), PATHINFO_BASENAME);
		$uri  = str_replace($route, '', \Request::path());
		//return "<a id='".$id."'href=\"/".$uri."\" class=\"btn btn-warning ".\Config::get('claravel::ajax')."\"><span class=\"glyphicon glyphicon-remove-circle\"></span>$caption</a>";
		return "<a id='batalkan' href='".url().'/'.substr($uri, 0,strlen($uri)-1)."' class='btn btn-warning ".\Config::get('claravel::ajax')."'><i class='fa fa-times-circle-o'></i> $caption</a>";
	}

	public static function btnCancelEdit(){
		$route1 = pathinfo(\Request::path(), PATHINFO_BASENAME);
		$route1  = str_replace($route1, '', \Request::path());
		$route2 = pathinfo($route1, PATHINFO_BASENAME);
		$uri  = str_replace($route2.'/', '', $route1);
		return "<a id='batalkan' href=\"/".$uri."\" class=\"btn btn-warning ".\Config::get('claravel::ajax')."\"><i class='fa fa-times-circle-o'></i> Batalkan Edit</a>";
	}

	public static function btnSave($id = false, $caption = 'Simpan'){
			return "<button id='".$id."' type=\"submit\" class=\"btn btn-success\"><i class='fa fa-floppy-o'></i> $caption</button>";
	} 

	public static function btnDeleteAll($caption = 'Hapus yang ditandai'){
		if (\PermissionsLibrary::canDel()){
			return "<button class='btn btn-warning btn-sm' style='display:none' id='deleteall' type='submit'><i class='fa fa-times'></i> ".$caption."</button>";
		}
	} 

	public static function btnDelete($recid = ''){
		if (\PermissionsLibrary::canDel()){
			return "<a id='hapus' href=\"".url()."/".\Request::path().'/delete'."\" recid='".$recid."' class='text-danger'><i class='fa fa-times-circle'></i> Hapus</a>";
		}
	}
        
	public static function btnEdit($recid=''){
		if (\PermissionsLibrary::canEdit()){
			return "<a id='edit' href=\"".url()."/".\Request::path().'/edit'."\" recid='".$recid."' class='text-info'><i class='fa fa-pencil-square-o'></i> Edit</a>";
		}
	}
        
        public static function btnReset($id=false,$class=''){
		if (\PermissionsLibrary::canEdit()){
			return "<a id='".$id."' href=\"".url()."/".\Request::path().'/edit/'.$id."\" class='".$class."'><span class=\"glyphicon glyphicon-edit\"></span>Reset</a>";
		}
	}
        
	public static function btnDownloadPDF($url=false){
            return "<a target='_blank' "
            . "href='".$url."' "
                    . "class='btn btn-info'><span class='glyphicon glyphicon-print'></span>Cetak</a>";
	}

	public static function ckDelete($id){
		if (\PermissionsLibrary::canDel()){
			return "<input type=\"checkbox\" class=\"checkme\" name=\"id[]\" value=\"".$id."\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Pilih untuk dihapus\">";
		}
	}

public static function satuan($inp){
    switch ($inp){
        case 1 : return 'satu'; break;
        case 2 : return 'dua'; break;
        case 3 : return 'tiga'; break;
        case 4 : return 'empat'; break;
        case 5 : return 'lima'; break;
        case 6 : return 'enam'; break;
        case 7 : return 'tujuh'; break;
        case 8 : return 'delapan'; break;
        case 9 : return 'sembilan'; break;
        default : return ''; break;
    }

}


public static function belasan($inp){
    $proses = $inp; //substr($inp, -1);
    if ($proses == '11'){
        return "sebelas ";        
    }else{
        $proses = substr($proses,1,1);
        return ClaravelHelpers::satuan($proses)."belas ";
        
    }
}



public static function puluhan($inp){
    $proses = $inp; //substr($inp, 0, -1);
    if ($proses == 1){
        return "sepuluh ";        
    }
    else if ($proses == 0){
        return '';        
    }
    else{
        return ClaravelHelpers::satuan($proses)."puluh ";        
    }
}


public static function ratusan($inp){
    $proses = $inp; //substr($inp, 0, -2);
    if ($proses == 1){
        return "seratus ";        
    }
    else if ($proses == 0){
        return '';        
    }
    else{
        return ClaravelHelpers::satuan($proses)." ratus ";   
    }
}


public static function ribuan($inp, $tunggal = false){
    $proses = $inp; //substr($inp, 0, -3);
    if($tunggal == false){
        if ($proses == 1){
            return "seribu ";        
        }
        else if ($proses == 0){
            return '';        
        }
        else{
            return ClaravelHelpers::satuan($proses)." ribu ";

        }        
    }
    else{
        if ($proses == 1){
            return "satu ribu ";        
        }
        else if ($proses == 0){
            return '';        
        }
        else{
            return ClaravelHelpers::satuan($proses)." ribu ";

        }        
        
    }
}


public static function jutaan($inp){
    $proses = $inp;
    if ($proses == 0){
        return '';        
    }
    else{
        return ClaravelHelpers::satuan($proses)." juta ";        
    }
}


public static function milyaran($inp){
    $proses = $inp; //substr($inp, 0, -9);
    if ($proses == 0){
        return '';        
    }
    else{
        return ClaravelHelpers::satuan($proses)."milyar ";
        
    }
}


public static function terbilang($rp){
    $kata = "";
    $rp = trim($rp);
    if (strlen($rp) >= 10){
        $angka = substr($rp, strlen($rp)-10, -9);
        $kata = $kata.ClaravelHelpers::milyaran($angka);        
    }
    $tambahan = "";
    if (strlen($rp) >= 9){
        $angka = substr($rp, strlen($rp)-9, -8);
        $kata = $kata.ClaravelHelpers::ratusan($angka);
        if ($angka > 0) { 
            $tambahan = "juta ";             
        }        
    }
    if (strlen($rp) >= 8){
        $angka = substr($rp, strlen($rp)-8, -7);
        $angka1 = substr($rp, strlen($rp)-7, -6);
        if (($angka == 1) && ($angka1 > 0)){
            $angka = substr($rp, strlen($rp)-8, -6);
            $kata = $kata.ClaravelHelpers::belasan($angka)." juta ";            
        }else{
            $angka = substr($rp, strlen($rp)-8, -7);
            $kata = $kata.ClaravelHelpers::puluhan($angka);
            if ($angka > 0) { 
                $tambahan = " juta ";                 
            }
            $angka = substr($rp, strlen($rp)-7, -6);
            $kata = $kata.ClaravelHelpers::jutaan($angka); //awalnya ribuan, dirubah jadi jutaan
            if ($angka == 0) { 
                $kata = $kata.$tambahan; 
            }            
        }        
    }
    if (strlen($rp) == 7){
        $angka = substr($rp, strlen($rp)-7, -6);
        $kata = $kata.ClaravelHelpers::jutaan($angka);
        if ($angka == 0) { 
            $kata = $kata.$tambahan;             
        }        
    }
    $tambahan = "";
    if (strlen($rp) >= 6){
        $angka = substr($rp, strlen($rp)-6, -5);
        $kata = $kata.ClaravelHelpers::ratusan($angka);
        if ($angka > 0) { 
            $tambahan = " ribu ";             
        }        
    }
    if (strlen($rp) >= 5){
        $angka = substr($rp, strlen($rp)-5, -4);
        $angka1 = substr($rp, strlen($rp)-4, -3);
        if (($angka == 1) && ($angka1 > 0)){
            $angka = substr($rp, strlen($rp)-5, -3);
            $kata = $kata.ClaravelHelpers::belasan($angka)." ribu ";
        }else{
            $angka = substr($rp, strlen($rp)-5, -4);
            $kata = $kata.ClaravelHelpers::puluhan($angka);
            if ($angka > 0) { 
                $tambahan = " ribu ";             
            }
            $angka = substr($rp, strlen($rp)-4, -3);
            $tunggal = ((substr($rp, strlen($rp)-5, -4) > 0) && $angka==1)?true:false;
            $kata = $kata.ClaravelHelpers::ribuan($angka,$tunggal);
            if ($angka == 0) { 
                $kata = $kata.$tambahan;             
            }        
        }
    }
    if (strlen($rp) == 4){
        $angka = substr($rp, strlen($rp)-4, -3);
        $kata = $kata.ClaravelHelpers::ribuan($angka);
        if ($angka == 0) { 
            $kata = $kata.$tambahan;             
        }        
    }
    if (strlen($rp) >= 3){
        $angka = substr($rp, strlen($rp)-3, -2);
        $kata = $kata.ClaravelHelpers::ratusan($angka);        
    }
    if (strlen($rp) >= 2){
        $angka = substr($rp, strlen($rp)-2, -1);
        $angka1 = substr($rp, strlen($rp)-1);
if (($angka == 1) && ($angka1 > 0))
{
$angka = substr($rp, strlen($rp)-2);
//echo " belasan".($angka)." ";
$kata = $kata.ClaravelHelpers::belasan($angka);
}
else
{
//echo " puluhan".($angka)." ";
$kata = $kata.ClaravelHelpers::puluhan($angka);

$angka = substr($rp, strlen($rp)-1);
//echo " satuan".($angka)." ";
$kata = $kata.ClaravelHelpers::satuan($angka);
}
}
if (strlen($rp) == 1 && is_integer($rp)){
    $angka = substr($rp, strlen($rp)-1);
    $kata = $kata.ClaravelHelpers::satuan($angka);
}
if (strlen($rp) == 1 && !is_integer($rp)){
    $kata = 'Nol';
}
if (strlen($rp) == 0){
$kata = 'Nol';
}
return $kata;
}

        

	public static function terbilang2($x)
    {
      $abil = array("Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
      if ($x < 12)
        return " " . $abil[$x];
      elseif ($x < 20)
        return ClaravelHelpers::terbilang($x - 10) . " Belas";
      elseif ($x < 100)
        return ClaravelHelpers::terbilang($x / 10) . " Puluh" . ClaravelHelpers::terbilang($x % 10);
      elseif ($x < 200)
        return " Seratus" . ClaravelHelpers::terbilang($x - 100);
      elseif ($x < 1000)
        return ClaravelHelpers::terbilang($x / 100) . " Ratus" . ClaravelHelpers::terbilang($x % 100);
      elseif ($x < 2000)
        return " Seribu" . ClaravelHelpers::terbilang($x - 1000);
      elseif ($x < 1000000)
        return ClaravelHelpers::terbilang($x / 1000) . " Ribu" . ClaravelHelpers::terbilang($x % 1000);
      elseif ($x < 1000000000)
        return ClaravelHelpers::terbilang($x / 1000000) . " Juta" . ClaravelHelpers::terbilang($x % 1000000);
	  elseif ($x < 1000000000000)
        return ClaravelHelpers::terbilang($x / 1000000000) . " Milyar" . ClaravelHelpers::terbilang($x % 1000000000);
	  elseif ($x < 1000000000000000)
        return ClaravelHelpers::terbilang($x / 1000000000000) . " Triliyun" . ClaravelHelpers::terbilang($x % 1000000000000);
	  
    }
		
    public function PAPN(){
        return 'Pen Apple - Pinneaple Pen';
    }

}
