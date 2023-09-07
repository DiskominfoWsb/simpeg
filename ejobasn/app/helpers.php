<?php

function attachServiceWorker() {
    // {{-- Service Worker --}}
    // {{-- aktifkan service worker hanya jika aplikasi punya secure connections (untuk menghindari MITM Attack) --}}
    $sw_whitelist = array(
        'localhost',
        '127.0.0.1',
        '::1'
    ); 

    if(\Request::secure() || in_array($_SERVER['REMOTE_ADDR'], $sw_whitelist)){
        return '
            <script>
                window.__ROOT__ = "'.url('').'";
            </script>
            <script type="text/javascript" src="'.url('/sw.js').'"></script>
        ';
    }
    
    return "";
}

function timediff($firstTime,$lastTime) {
    //selisih waktu/jam dalam detik
    $firstTime=strtotime($firstTime);
    $lastTime=strtotime($lastTime);
    $timeDiff=$lastTime-$firstTime;
    return $timeDiff;
}

function clearWhitespaces($string) {
    return trim(preg_replace('/\s+/s', " ", $string));
}


function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function htmlValue($string) {
    return
        str_replace('"', "&quot;",
        str_replace("'", '&#39;',
        str_replace('<', '&lt;',
        str_replace('&', "&amp;",
    $string))));
}

function jsValue($string) {
    return
        preg_replace('/\r?\n/', "\\n",
        str_replace('"', "\\\"",
        str_replace("'", "\\'",
        str_replace("\\", "\\\\",
    $string))));
}

function xmlData($string, $cdata=false) {
    $string = str_replace("]]>", "]]]]><![CDATA[>", $string);
    if (!$cdata)
        $string = "<![CDATA[$string]]>";
    return $string;
}


// function compressCSS($code) {
//     $code = self::clearWhitespaces($code);
//     $code = preg_replace('/ ?\{ ?/', "{", $code);
//     $code = preg_replace('/ ?\} ?/', "}", $code);
//     $code = preg_replace('/ ?\; ?/', ";", $code);
//     $code = preg_replace('/ ?\> ?/', ">", $code);
//     $code = preg_replace('/ ?\, ?/', ",", $code);
//     $code = preg_replace('/ ?\: ?/', ":", $code);
//     $code = str_replace(";}", "}", $code);
//     return $code;
// }

function uang($nominal = ''){
    if ($nominal == ''){
        return '';
    }
    else{
        return '&nbsp;'.@number_format($nominal,0,',','.');        
    }
}

function get_duplicate_array( $array ) {
    return array_unique( array_diff_assoc( $array, array_unique( $array ) ) );
}

function remove_letter($str =''){
    return preg_replace("/[^0-9,.]/", "", $str);    
}

function debug($s='',$die=true){
    echo '<pre>';
    print_r($s);
    echo '</pre>';
    if($die == true){
        die();
    }
}


function jam_tabrakan($s1='',$e1='',$s2='',$e2=''){
    if(
            ($s1 == $s2 || $e1 == $e2) ||
            ($s1 <= $s2 && $e1 <= $e2 && $e1 >= $s2) ||
//            ($s1 >= $s2 && $e1 >= $e2 && $s1 <= $e2) ||
            ($s1 >= $s2 && $e1 >= $e2 && $s1 < $e2) ||
            ($s1>=$s2 && $e1<=$e2) ||
            ($s1<=$s2 && $e1>=$e2)
            ){
//        if(($s1 == $s2 || $e1 == $e2)){
//            echo 'Kondisi 1<br>';
//        }
//        if($s1 <= $s2 && $e1 <= $e2 && $e1 >= $s2){
//            echo 'Kondisi 2<br>';
//        }
//        if($s1 >= $s2 && $e1 >= $e2 && $s1 < $e2){
//            echo 'Mulai 1 = '.$s1.'<br>';
//            echo 'Selesai 1 = '.$e1.'<br>';
//            echo 'Mulai 2 = '.$s2.'<br>';
//            echo 'Selesai 2 = '.$e2.'<br>';
//            echo 'Kondisi 3<br>';
//        }
//        if($s1>=$s2 && $e1<=$e2){
//            echo 'Kondisi 4<br>';
//        }
//        if($s1<=$s2 && $e1>=$e2){
//            echo 'Kondisi 5<br>';
//        }
        return true;
            }else{
        return false;
            }
//    if(
//            ($s1 == $s2 || $e1 == $e2) ||
//            ($s1 <= $s2 && $e1 <= $e2 && $e1 >= $s2) ||
//            ($s1 >= $s2 && $e1 >= $e2 && $s1 <= $e2) ||
//            ($s1>=$s2 && $e1<=$e2) ||
//            ($s1<=$s2 && $e1>=$e2)
//            ){
//        return true;
//            }else{
//        return false;
//            }
}



function rangesNotOverlapClosed($start_time1,$end_time1,$start_time2,$end_time2){
  $utc = new DateTimeZone('UTC');

  $start1 = new DateTime($start_time1,$utc);
  $end1 = new DateTime($end_time1,$utc);
  if($end1 < $start1)
    throw new Exception('Range is negative.');

  $start2 = new DateTime($start_time2,$utc);
  $end2 = new DateTime($end_time2,$utc);
  if($end2 < $start2)
    throw new Exception('Range is negative.');
  return ($end1 < $start2) || ($end2 < $start1);
}

function rangesNotOverlapOpen($start_time1,$end_time1,$start_time2,$end_time2)
{
  $utc = new DateTimeZone('UTC');

  $start1 = new DateTime($start_time1,$utc);
  $end1 = new DateTime($end_time1,$utc);
  if($end1 < $start1)
    throw new Exception('Range is negative.');

  $start2 = new DateTime($start_time2,$utc);
  $end2 = new DateTime($end_time2,$utc);
  if($end2 < $start2)
    throw new Exception('Range is negative.');

  return ($end1 <= $start2) || ($end2 <= $start1);
}



function spasi($rekursive = 1){
    for($a=1 ; $a <= $rekursive ; $a++){
        echo '&nbsp;';
    }
}

function get_client_ip() {
    $ipaddress = '';
        if($_SERVER['REMOTE_ADDR']){
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        }else{
        $ipaddress = 'UNKNOWN';
        }

    return $ipaddress;
}

    function formatTanggalPanjang($tanggal) {
       if(substr($tanggal, 0,9) != '00-00-000' || substr($tanggal, 0,9) != ''){
            $aBulan = array(1=> "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            list($thn,$bln,$tgl)=explode("-",$tanggal);
            $bln = (($bln >0 ) && ($bln < 10))? substr($bln,1,1): $bln ;
            return $tgl." ".$aBulan[$bln]." ".$thn;
        }else{
            return '';
        }
    }

    function formatBulanTahun($tanggal) {
        $aBulan = array(1=> "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        list($thn,$bln,$tgl)=explode("-",$tanggal);
        $bln = (($bln >0 ) && ($bln < 10))? substr($bln,1,1): $bln ;
        return $aBulan[$bln]." ".$thn;
    }
  /*function untuk mendapatkan nama bulan*/
    function formatBulan($bln){
        $bln = (($bln >0 ) && ($bln < 10))? substr($bln,1,1): $bln ;
        $aBulan = array(1=> "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $date = $aBulan[$bln];
        return $date;
    }

function tanggal($date = 1){
    if(substr($date, 0,9) != '00-00-000' || substr($date, 0,9) != '00/00/000' || substr($date, 0,9) != '' || substr($date, 0,9) != NULL ){
        date_default_timezone_set('Asia/Jakarta'); // your reference timezone here
    //    $date = date('Y-m-d', strtotime($date)); // ubah sesuai format penanggalan standart
        $date = date('Y-m-j', strtotime($date)); // ubah sesuai format penanggalan standart
        if($date != '1970-01-01' && $date != '1970-01-1'){
//            echo $date.'<br>';
            $bulan = array ('01'=>'Januari', // array bulan konversi
                    '02'=>'Februari',
                    '03'=>'Maret',
                    '04'=>'April',
                    '05'=>'Mei',
                    '06'=>'Juni',
                    '07'=>'Juli',
                    '08'=>'Agustus',
                    '09'=>'September',
                    '10'=>'Oktober',
                    '11'=>'November',
                    '12'=>'Desember'
            );
            $date = explode ('-',$date); // ubah string menjadi array dengan paramere '-'

            return @$date[2] . ' ' . @$bulan[$date[1]] . ' ' . @$date[0]; // hasil yang di kembalikan}
        }else{
            return '';
        }

    }else{
        return '';
    }
}

function romawi($n = '1'){
    $hasil = '';
    $iromawi = array('','I','II','III','IV','V','VI','VII','VIII','IX','X',
        20=>'XX',30=>'XXX',40=>'XL',50=>'L',60=>'LX',70=>'LXX',80=>'LXXX',
        90=>'XC',100=>'C',200=>'CC',300=>'CCC',400=>'CD',500=>'D',
        600=>'DC',700=>'DCC',800=>'DCCC',900=>'CM',1000=>'M',
        2000=>'MM',3000=>'MMM');

    if(array_key_exists($n,$iromawi)){
        $hasil = $iromawi[$n];
    }elseif($n >= 11 && $n <= 99){
        $i = $n % 10;
        $hasil = $iromawi[$n-$i] . Romawi($n % 10);
    }elseif($n >= 101 && $n <= 999){
        $i = $n % 100;
        $hasil = $iromawi[$n-$i] . Romawi($n % 100);
    }else{
        $i = $n % 1000;
        $hasil = $iromawi[$n-$i] . Romawi($n % 1000);
    }
    return $hasil;
}

/*function untuk mendapatkan nama skpd*/
function getSkpd($idskpd){
    $rs = \DB::connection('kepegawaian')->table('a_skpd')->where('idskpd', $idskpd)->first();
    if(! empty($rs)){
        if(strlen($idskpd) == 2){
            return $rs->skpd;
        }else{
            return $rs->path;
        }
    }else{
        return 'Semua Unit Kerja';
    }
}

/*combo list bulan*/
function comboBulanpetajab($id="bulan",$sel="",$required=""){

    $rs = \DB::table('tr_petajab')->select('periode_bulan')->groupby('periode_bulan')->get();

    $month2['01'] = "Januari";
    $month2['02'] = "Februari";
    $month2['03'] = "Maret";
    $month2['04'] = "April";
    $month2['05'] = "Mei";
    $month2['06'] = "Juni";
    $month2['07'] = "Juli";
    $month2['08'] = "Agustus";
    $month2['09'] = "September";
    $month2['10'] = "Oktober";
    $month2['11'] = "November";
    $month2['12'] = "Desember";
    $html = "<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    
    $html .= "<option value=''>.: Pilihan :.</option>";

    foreach($rs as $i){
        $bulan = $month2[$i->periode_bulan];
        if ($i->periode_bulan == $sel) {
            $html .= "<option value='$i->periode_bulan' selected>$i->periode_bulan | $bulan</option>";
        } else {
            $html .= "<option value='$i->periode_bulan'>$i->periode_bulan | $bulan</option>";
        }
    }
    $html .= "</select>";
    return $html;
}

/*combo list bulan*/
function comboBulan($id="bulan",$sel="",$required=""){
    $month2[1] = "Januari";
    $month2[2] = "Februari";
    $month2[3] = "Maret";
    $month2[4] = "April";
    $month2[5] = "Mei";
    $month2[6] = "Juni";
    $month2[7] = "Juli";
    $month2[8] = "Agustus";
    $month2[9] = "September";
    $month2[10] = "Oktober";
    $month2[11] = "November";
    $month2[12] = "Desember";
    $html = "<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $now = '';
    $html .= "<option value=''>.: Pilihan :.</option>";
    for ($i = 1; $i <= 12; $i++) {
        $bulan = $month2[$i];
        if (strlen($i) == 1) {
            $i = "0" . $i;
        }
        if ($i == $sel) {
            $html .= "<option value='$i' selected>$i | $bulan</option>";
        } else {
            $html .= "<option value='$i'>$i | $bulan</option>";
        }
        $now = 1;
        $now = $now + $i;
    }
    $html .= "</select>";
    return $html;
}

/*combo list tahun*/
function comboTahunpetajab($id="tahun",$sel="",$required="",$periode_bulan=""){
    $rs = \DB::table('tr_petajab')->select('periode_tahun')->where('periode_bulan','=',$periode_bulan)->groupby('periode_tahun')->get();


    $html="<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $html .= "<option value=''>.: Pilihan :.</option>";
    foreach($rs as $i){
        $html.="<option value='$i->periode_tahun' ".(($i->periode_tahun==$sel)?"selected":"").">$i->periode_tahun</option>";
    }
    $html.="</select>";
    return $html;
}

/*cobo list skpd*/
function comboSkpdpetajab($id="idskpd",$sel="",$required="",$where="",$holder=".: Pilihan :.",$periode_bulan="",$periode_tahun=""){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    if(session('role_id') < 4){
        $ret.="<option value=\"\">".$holder."</option>";
    }else{
        $ret.="<option value=".session('idskpd').">".$holder."</option>";
    }

    if($where != ''){
        $rs = \DB::table('tr_petajab as a')
            ->rightjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'),'a.idskpd','=','b.idskpd')
            ->select('b.idskpd','b.skpd')
            ->where('a.periode_bulan','=',$periode_bulan)
            ->where('a.periode_tahun','=',$periode_tahun)
            ->where('b.idskpd','like',''.$where. '%')
            ->groupby('b.idskpd')
            ->orderBy('b.idskpd','asc')
            ->get();
    }else{
        $rs = \DB::table('tr_petajab as a')
            ->rightjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'),'a.idskpd','=','b.idskpd')
            ->select('b.idskpd','b.skpd')
            ->where('a.periode_bulan','=',$periode_bulan)
            ->where('a.periode_tahun','=',$periode_tahun)
            ->groupby('b.idskpd')
            ->orderBy('b.idskpd','asc')
            ->get();
    }

    foreach($rs as $item){
        $nbsp = '';
        $char = strlen($item->idskpd);
        $index = substr($item->idskpd,0,2);
        for($x=0; $x<=$char; $x++){
            if($char > 2){
                $nbsp.='&nbsp;&nbsp;';
            }
        }

        $isSel = (($item->idskpd==$sel)?"selected":"");
        $ret.=($char==2)?"<optgroup label='".$item->skpd."'>":"";
        $ret.="<option value=\"".$item->idskpd."\" $isSel >".$nbsp."".$item->skpd."</option>";
        $ret.=($index != substr($item->idskpd,0,2))?"</optgroup>":"";
    }
    $ret.="</select>";
    return $ret;
}

function comboJenjabpetajab($id="idjenjab",$sel="",$required=""){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"$id form-control\">";
    $ret.="<option value=\"\">.: Jenis Jabatan :.</option>";

    $rs = \DB::connection('kepegawaian')->table('a_jenjab')->where('idjenjab', '<', 4)->where('idjenjab','>',1)->get();
    foreach($rs as $item){
        $isSel = (($item->idjenjab==$sel)?"selected":"");
        $ret.="<option value=\"".$item->idjenjab."\" $isSel >".$item->jenjab."</option>";
    }
    $ret.="</select>";
    return $ret;
}

// /*cobo list jenis jabatan*/
// function comboJenjabpetajab($id="idjenjab",$sel="",$required="",$periode_bulan="",$periode_tahun="",$idskpd=""){
//     $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
//     $ret.="<option value=\"\">.: Pilihan :.</option>";

//     $rs = \DB::table('tr_petajab as a')
//             ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjab as b'),\DB::raw('IF(a.idjenjab>4,1,IF(a.idjenjab=2,2,IF(a.idjenjab=3,3,"-")))'),'=','b.idjenjab')
//             ->select('b.idjenjab','b.jenjab')
//             ->where('a.periode_bulan','=',$periode_bulan)
//             ->where('a.periode_tahun','=',$periode_tahun)
//             ->where('idskpd','like',$idskpd.'%')
//             ->groupby('b.idjenjab')
//             ->get();
//     foreach($rs as $item){
//         $isSel = (($item->idjenjab==$sel)?"selected":"");
//         $ret.="<option value=\"".$item->idjenjab."\" $isSel >".$item->jenjab."</option>";
//     }
//     $ret.="</select>";
//     return $ret;
// }


    /*combo list sudah atau belum */
    function comboStatusdiklat($id="idstatus",$sel="",$required=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $ret.="<option value=\"0\" ".(($sel == 0)?"selected":"").">.: Pilihan :.</option>";
        $ret.="<option value=\"1\" ".(($sel == 1)?"selected":"").">Sudah</option>";
        $ret.="<option value=\"2\" ".(($sel == 2)?"selected":"").">Belum</option>";
        $ret.="</select>";
        return $ret;
    }

    /*fungtion untuk mendapatkan jabatan*/
    function comboJabfungpetajab($id="idjabfung",$sel="",$required="",$periode_bulan="",$periode_tahun="",$idskpd="",$idjenjab=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"$id form-control\">";
        $ret.="<option value=\"\">.: Nama Jabatan :.</option>";

        $rs = \DB::table('tr_petajab')
                ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'),'a_jabfung.idjabfung','=','tr_petajab.idjabfung')
                ->select('tr_petajab.idjabfung','a_jabfung.jabfung')
                ->where('tr_petajab.periode_bulan','=',$periode_bulan)
                ->where('tr_petajab.periode_tahun','=',$periode_tahun)
                ->where('tr_petajab.idskpd','like',$idskpd.'%')
                ->where('tr_petajab.idjenjab','=',$idjenjab)
                ->get();

        foreach($rs as $item){
            $isSel = (($item->idjabfung==$sel)?"selected":"");
            $ret.="<option value=\"".$item->idjabfung."\" $isSel >".$item->jabfung."</option>";
        }
        $ret.="</select>";
        return $ret;
    }

        /*fungtion untuk mendapatkan jabatan*/
    function comboJabfungumpetajab($id="idjabfungum",$sel="",$required="",$periode_bulan="",$periode_tahun="",$idskpd="",$idjenjab=""){
        $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"$id form-control\">";
        $ret.="<option value=\"\">.: Nama Jabatan :.</option>";

        $rs = \DB::table('tr_petajab')
                ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'),'a_jabfungum.idjabfungum','=','tr_petajab.idjabfungum')
                ->select('tr_petajab.idjabfungum','a_jabfungum.jabfungum')
                ->where('tr_petajab.periode_bulan','=',$periode_bulan)
                ->where('tr_petajab.periode_tahun','=',$periode_tahun)
                ->where('tr_petajab.idskpd','like',$idskpd.'%')
                ->where('tr_petajab.idjenjab','=',$idjenjab)
                ->get();

        foreach($rs as $item){
            $isSel = (($item->idjabfungum==$sel)?"selected":"");
            $ret.="<option value=\"".$item->idjabfungum."\" $isSel >".$item->jabfungum."</option>";
        }
        $ret.="</select>";
        return $ret;
    }

    function comboJendiklat($id ='',$selected=""){
        $h = "<select id='$id' name='$id' style='width:100%'>";
        $h .= '<option value="">.: Jenis Diklat :.</option>';
        $h .= '<option '.(($selected == '1')?'selected':'').' value="1">Struktural</option>';
        $h .= '<option '.(($selected == '2')?'selected':'').' value="2">Fungsional</option>';
        $h .= '<option '.(($selected == '3')?'selected':'').' value="3">Teknis</option>';
        $h .= '</select>';
        return $h;
    }


/*cobo list diklat struktural*/
function comboDiklatpetajab($id="iddiklat",$sel="",$required="",$periode_bulan="",$periode_tahun="",$idskpd="",$idjendiklat="",$idjenjab="",$idjabatan=""){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Nama Diklat :.</option>";

    $where = "tr_petajab_detail.periode_bulan = '".$periode_bulan."' AND tr_petajab_detail.periode_tahun = '".$periode_tahun."' AND tr_petajab_detail.idskpd like '".$idskpd."%'";

    if($idjenjab != ''){
        $where .= " AND tr_petajab_detail.idjenjab = '".$idjenjab."'";
    }

    if($idjabatan != ''){
        $where .= " AND tr_petajab_detail.idjabatan = '".$idjabatan."'";
    }

    if($idjendiklat == 1){
        $rs = \DB::table('tr_petajab_detail')
            ->leftjoin('tr_petajab','tr_petajab.id','=','tr_petajab_detail.idpetajab')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_dikstru as a_dikstru'),'a_dikstru.iddikstru','=','tr_petajab_detail.iddiklat')
            ->select('tr_petajab_detail.iddiklat','a_dikstru.dikstru as diklat')
            ->whereRaw($where)
            ->where('tr_petajab_detail.idjendiklat','=',$idjendiklat)
            ->orderBy('tr_petajab_detail.iddiklat','asc')
            ->groupBy('tr_petajab_detail.iddiklat')
            ->get();
    } else if($idjendiklat == 2){
        $rs = \DB::table('tr_petajab_detail')
            ->leftjoin('tr_petajab','tr_petajab.id','=','tr_petajab_detail.idpetajab')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_dikfung as a_dikfung'),'a_dikfung.iddikfung','=','tr_petajab_detail.iddiklat')
            ->select('tr_petajab_detail.iddiklat','a_dikfung.dikfung as diklat')
            ->whereRaw($where)
            ->where('tr_petajab_detail.idjendiklat','=',$idjendiklat)
            ->orderBy('tr_petajab_detail.iddiklat','asc')
            ->groupBy('tr_petajab_detail.iddiklat')
            ->get();
    } else {
        $rs = \DB::table('tr_petajab_detail')
            ->leftjoin('tr_petajab','tr_petajab.id','=','tr_petajab_detail.idpetajab')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_diktek as a_diktek'),'a_diktek.iddiktek','=','tr_petajab_detail.iddiklat')
            ->select('tr_petajab_detail.iddiklat','a_diktek.diktek as diklat')
            ->whereRaw($where)
            ->where('tr_petajab_detail.idjendiklat','=',$idjendiklat)
            ->orderBy('tr_petajab_detail.iddiklat','asc')
            ->groupBy('tr_petajab_detail.iddiklat')
            ->get();
    }

    foreach($rs as $item){
        $isSel = (($item->iddiklat==$sel)?"selected":"");
        $ret.="<option value=\"".$item->iddiklat."\" $isSel >".$item->diklat."</option>";
    }
    $ret.="</select>";
    return $ret;

}

/*combo list tahun*/
function comboTahun($id="tahun",$sel="",$required=""){
    $html="<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $html .= "<option value=''>.: Pilihan :.</option>";
    for($i=date('Y')-5;$i<=date('Y')+1;$i++){
        $html.="<option value='$i' ".(($i==$sel)?"selected":"").">$i</option>";
    }
    $html.="</select>";
    return $html;
}

// function combo_jnskelamin($id ='',$selected=""){
//     $h = "<select id='$id' name='$id' style='width:100%'>";
//     $h .= '<option value="">Pilih Jenis Kelamin</option>';
//     $h .= '<option '.(($selected == '1')?'selected':'').' value="1">Laki-laki</option>';
//     $h .= '<option '.(($selected == '2')?'selected':'').' value="2">Perempuan</option>';
//     $h .= '</select>';
//     return $h;
// }

// function comboDiklat($id='',$name='',$selected='',$req='',$idjenjab='',$idjabatan=''){
//     $html = '<select id="'.$id.'" name="'.$name.'" '.$req.' style="width:100%">';
//     $where = ' kelompok_kompetensi != "" ';

//     if($idjenjab > 4){
//         $data = \DB::connection('kepegawaian')->table('a_skpd')->select('iddiklat')->where('idskpd','=',$idjabatan)->first();
//     } else if($idjenjab == 2){
//         $data = \DB::connection('kepegawaian')->table('a_jabfung')->select('iddiklat')->where('idjabfung','=',$idjabatan)->first();
//     } else if($idjenjab == 3){
//         $data = \DB::connection('kepegawaian')->table('a_jabfungum')->select('iddiklat')->where('idjabfungum','=',$idjabatan)->first();
//     }

//     $array=array_map('intval', explode(',', $data->iddiklat));
//     $array = implode("','",$array);

//     $query = \DB::connection('kepegawaian')->table('alldiklat')->whereRaw("iddiklat IN ('".$array."')")->get();

//     $html .= '<option>.: Pilihan :.</option>';

//     foreach ($query as $row){
//         $s = $row->id==$selected?'selected="selected"':'';
//         $html .= '<option '.$s.' value="'.$row->id.'">'.$row->text.'</option>';
//     }
//     $html .= '</select>';
//     return $html;
// }

function comboDiklat($id='',$name='',$selected='',$req='',$idjenjab=''){
    $html = '<select id="'.$id.'" name="'.$name.'" '.$req.' style="width:100%">';

    if($idjenjab > 4){
        $query = \DB::connection('kepegawaian')->table('diklat_struktural')->get();
    } else if($idjenjab == 2){
        $query = \DB::connection('kepegawaian')->table('diklat_fungsional')->get();
    } else if($idjenjab == 3){
        $query = \DB::connection('kepegawaian')->table('a_diktek')->select('a_diktek.*','iddiktek as id','diktek as text')->get();
    }

    $html .= '<option>.: Pilihan :.</option>';

    foreach ($query as $row){
        $s = $row->id==$selected?'selected="selected"':'';
        $html .= '<option '.$s.' value="'.$row->id.'">'.$row->text.'</option>';
    }
    $html .= '</select>';
    return $html;
}

function comboJenjurusanMulti($id="idjenjurusan[]",$sel="",$required=""){
    $ret = "<select id=\"idjenjurusan\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Pilihan :.</option>";

    $jenis = explode(', ', $sel);

    $rs = \Cache::remember('combojenjurusan_all', 10, function () {
        $rs = \DB::connection('kepegawaian')->table('a_jenjurusan')->orderBy('jenjurusan','asc')->get();
        return $rs;
    });

    if($required != 'multiple'){
        $ret.="<option value=''>.: Pilihan :.</option>";
    }
    foreach($rs as $item){
        if(in_array($item->idjenjurusan, $jenis)){
            $isSel = 'selected';
        } else {
            $isSel = '';
        }

        $ret.="<option value=\"".$item->idjenjurusan."\" $isSel >".$item->jenjurusan."</option>";
    }
    $ret.="</select>";
    return $ret;
}

function comboTkpendidikanMulti($id="idtkpendid",$sel="",$required=""){
    $ret = "<select id=\"idtkpendid\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Pilihan :.</option>";
    $jenis = explode(', ', $sel);

    $rs = \Cache::remember('combotkpendid_all', 10, function () {
        $rs = \DB::connection('kepegawaian')->table('a_tkpendid')->orderBy('tkpendid','asc')->get();
        return $rs;
    });

    if($required != 'multiple'){
        $ret.="<option value=''>.: Pilihan :.</option>";
    }
    foreach($rs as $item){
        if(in_array($item->idtkpendid, $jenis)){
            $isSel = 'selected';
        } else {
            $isSel = '';
        }

        $ret.="<option value=\"".$item->idtkpendid."\" $isSel >".$item->tkpendid."</option>";
    }
    $ret.="</select>";
    return $ret;
}

function comboRumpunpendidikanMulti($id="idrumpunpendid",$sel="",$required=""){
    $ret = "<select id=\"idrumpunpendid\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Pilihan :.</option>";
    $jenis = explode(', ', $sel);

    $rs = \Cache::remember('comborumpunpendid_all', 10, function () {
        $rs = \DB::connection('kepegawaian')->table('a_rumpunpendid')->orderBy('rumpunpendid','asc')->get();
        return $rs;
    });

    if($required != 'multiple'){
        $ret.="<option value=''>.: Pilihan :.</option>";
    }
    foreach($rs as $item){
        if(in_array($item->idrumpunpendid, $jenis)){
            $isSel = 'selected';
        } else {
            $isSel = '';
        }

        $ret.="<option value=\"".$item->idrumpunpendid."\" $isSel >".$item->rumpunpendid."</option>";
    }
    $ret.="</select>";
    return $ret;
}

/*cobo list tingkat pendidikan*/
function comboTkpendidikan($id="idtkpendid",$sel="",$required=""){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::connection('kepegawaian')->table('a_tkpendid')->orderBy('idtkpendid','asc')->get();
    foreach($rs as $item){
        $isSel = (($item->idtkpendid==$sel)?"selected":"");
        $ret.="<option value=\"".$item->idtkpendid."\" $isSel >".$item->tkpendid."</option>";
    }
    $ret.="</select>";
    return $ret;
}

/*cobo list tingkat pendidikan*/
function comboRumpunpendidikan($id="idrumpunpendid",$sel="",$required=""){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::connection('kepegawaian')->table('a_rumpunpendid')->orderBy('idrumpunpendid','asc')->get();
    foreach($rs as $item){
        $isSel = (($item->idrumpunpendid==$sel)?"selected":"");
        $ret.="<option value=\"".$item->idrumpunpendid."\" $isSel >".$item->rumpunpendid."</option>";
    }
    $ret.="</select>";
    return $ret;
}

/*cobo list tugas guru dosen*/
function comboTgsgurudosen($id="idtugasgurudosen",$sel="",$required=""){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::connection('kepegawaian')->table('a_tugasgurudosen')->orderBy('idtugasgurudosen','asc')->get();
    foreach($rs as $item){
        $isSel = (($item->idtugasgurudosen==$sel)?"selected":"");
        $ret.="<option value=\"".$item->idtugasgurudosen."\" $isSel >".$item->tugasgurudosen."</option>";
    }
    $ret.="</select>";
    return $ret;
}

/*cobo list tugas dokter*/
function comboTgsdokter($id="idtugasdokter",$sel="",$required="", $jnsdokter=""){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::connection('kepegawaian')->table('a_tugasdokter')->orderBy('idtugasdokter','asc')->get();

    foreach($rs as $item){
        $isSel = (($item->idtugasdokter==$sel)?"selected":"");
        $ret.="<option value=\"".$item->idtugasdokter."\" $isSel >".$item->tugasdokter."</option>";
    }
    $ret.="</select>";
    return $ret;
}

/*function format nip*/
function fnip($nip, $batas = " ") {
    $nip = trim($nip," ");
    $panjang = strlen($nip);

    if($panjang == 18) {
        $sub[] = substr($nip, 0, 8); // tanggal lahir
        $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
        $sub[] = substr($nip, 14, 1); // jenis kelamin
        $sub[] = substr($nip, 15, 3); // nomor urut

        return $sub[0].$batas.$sub[1].$batas.$sub[2].$batas.$sub[3];
    } elseif($panjang == 15) {
        $sub[] = substr($nip, 0, 8); // tanggal lahir
        $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
        $sub[] = substr($nip, 14, 1); // jenis kelamin

        return $sub[0].$batas.$sub[1].$batas.$sub[2];
    } elseif($panjang == 9) {
        $sub = str_split($nip,3);

        return $sub[0].$batas.$sub[1].$batas.$sub[2];
    } else {
        return $nip;
    }
}

/*cobo list skpd*/
function comboSkpd($id="idskpd",$sel="",$required="",$where="",$holder=".: Pilihan :."){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    if(session('role_id') < 4){
        $ret.="<option value=\"\">".$holder."</option>";
    }else{
        $ret.="<option value=".session('idskpd').">".$holder."</option>";
    }

    if($where != ''){
        // $rs = \Cache::remember('comboSkpd_where'.clean($where), 10, function () {
            $rs = \DB::connection('kepegawaian')->table('a_skpd')->where('flag', 1)->where('idskpd','like',''.$where.'%')->orderBy('idskpd','asc')->get();
              // return $rs;
        // });
    }else{
        $rs = \Cache::remember('comboSkpd_all', 10, function () {
            $rs = \DB::connection('kepegawaian')->table('a_skpd')->where('flag', 1)->orderBy('idskpd','asc')->get();
            return $rs;
        });
    }

    foreach($rs as $item){
        $nbsp = '';
        $char = strlen($item->idskpd);
        $index = substr($item->idskpd,0,2);
        for($x=0; $x<=$char; $x++){
            if($char > 2){
                $nbsp.='&nbsp;&nbsp;';
            }
        }

        $isSel = (($item->idskpd==$sel)?"selected":"");
        $ret.=($char==2)?"<optgroup label='".$item->skpd."'>":"";
        $ret.="<option value=\"".$item->idskpd."\" $isSel >".$nbsp."".$item->skpd."</option>";
        $ret.=($index != substr($item->idskpd,0,2))?"</optgroup>":"";
    }
    $ret.="</select>";
    return $ret;
}

/*cobo list eselon*/
function comboEselon($id="idesl",$sel="",$required=""){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::connection('kepegawaian')->table('a_esl')->orderBy('idesl','asc')->get();
    foreach($rs as $item){
        $isSel = (($item->idesl==$sel)?"selected":"");
        $ret.="<option value=\"".$item->idesl."\" $isSel >".$item->esl."</option>";
    }
    $ret.="</select>";
    return $ret;
}

/*cobo list eselon*/
function comboJabfung($id="jabfung",$sel="",$required=""){
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret.="<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::connection('kepegawaian')->table('a_jabfung')->where('flag',1)->select('idjabfung','jabfung')->get();
    foreach($rs as $item){
        $isSel = (($item->idjabfung==$sel)?"selected":"");
        $ret.="<option value=\"".$item->idjabfung."\" $isSel >".$item->jabfung."</option>";
    }
    $ret.="</select>";
    return $ret;
}

/*function familithree sotk*/
function familytree($id=0,$periode_tahun='',$periode_bulan='',$x=0){
    $data['idparent'] = $id;
    $data['periode_tahun'] = $periode_tahun;
    $data['periode_bulan'] = $periode_bulan;
    $x++;
    if(strlen($id)==2){
        

        $rs = \DB::table('tr_petajab as a')
                ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as c'), 'a.idskpd', '=', 'c.idskpd')
                ->select('a.periode_tahun','a.periode_bulan',
                'c.idesl','a.idskpd','c.skpd','c.jab','c.path','b.nip','b.niplama','b.photo',
                    \DB::raw("concat(if(length(b.gdp)>0,concat(b.gdp,' '),''),b.nama,if(length(b.gdb)>0,concat(',',b.gdb),'')) as namalengkap"),'c.kelas_jabatan as kelasjab'
                )
                ->leftjoin(\DB::Raw(config('global.kepegawaian').'.tb_01 as b'), function($join){
                    $join->on('a.idskpd','=','b.idjabjbt')
                        ->where('b.idjenkedudupeg','!=',99)
                        ->where('b.idjenkedudupeg','!=',21);
                })
                ->where('c.idparent',$id)
                ->where('a.periode_tahun','=',$periode_tahun)
                ->where('a.periode_bulan','=',$periode_bulan)
                ->whereBetween('c.idesl', array(21, 52))
                ->groupby('a.idskpd')
                ->orderBy('a.idskpd');
    }else{
        $rs = \DB::table('tr_petajab as a')
                ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as c'), 'a.idskpd', '=', 'c.idskpd')
                ->select('a.periode_tahun','a.periode_bulan',
                'c.idesl','a.idskpd','c.skpd','c.jab','c.path','b.nip','b.niplama','b.photo',
                    \DB::raw("concat(if(length(b.gdp)>0,concat(b.gdp,' '),''),b.nama,if(length(b.gdb)>0,concat(',',b.gdb),'')) as namalengkap"),'c.kelas_jabatan as kelasjab'
                )
                ->leftjoin(\DB::Raw(config('global.kepegawaian').'.tb_01 as b'), function($join){
                    $join->on('a.idskpd','=','b.idjabjbt')
                        ->where('b.idjenkedudupeg','!=',99)
                        ->where('b.idjenkedudupeg','!=',21);
                })
                ->where('c.idparent',$id)
                ->whereBetween('c.idesl', array(21, 52))
                ->groupby('a.idskpd')
                ->orderBy('a.idskpd');
    }

    foreach($rs->get() as $item){
        $rs2 = \DB::connection('kepegawaian')->table('a_skpd')->where('idparent', $item->idskpd);
        $fungsional = \DB::table('tr_petajab')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.tb_01 as tb_01'), 'tr_petajab.kdunit', '=', 'tb_01.kdunit')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'), 'tr_petajab.idskpd', '=', 'skpd.idskpd')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjab as a_jenjab'), 'tr_petajab.idjenjab','=','a_jenjab.idjenjab')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabasn as a_jabasn'), 'tr_petajab.idjenjab','=','a_jabasn.idjabasn')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_matkulpel as a_matkulpel'), 'tr_petajab.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
                  ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'), 'tr_petajab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                  
            ->select(\DB::raw('tr_petajab.*, a_jabfungum.kelas_jabatan as kelasfungum,a_jabfung.kelas_jabatan as kelasfung'),
            \DB::raw('SUM(IF(tr_petajab.idjabjbt = tb_01.idjabjbt AND tb_01.idjabjbt != "" AND tb_01.idjenjab > 4,1,IF(tr_petajab.idjabfung = tb_01.idjabfung AND tb_01.idjabfung != "" AND tb_01.idjenjab = 2 AND tr_petajab.idskpd = tb_01.idskpd,1,
IF(tr_petajab.idjabfungum = tb_01.idjabfungum AND tb_01.idjabfungum != "" AND tb_01.idjenjab = 3 AND tr_petajab.idskpd = tb_01.idskpd,1,0)))) AS banyakorang'),

            \DB::raw('
                group_concat(
                    IF(tr_petajab.idjabjbt = tb_01.idjabjbt AND tb_01.idjabjbt != "" AND tb_01.idjenjab > 4,concat(IF(length(tb_01.gdp)>0, concat(tb_01.gdp," "),""),tb_01.nama,IF(length(tb_01.gdb)>0, concat(", ",tb_01.gdb),"")),
                        IF(tr_petajab.idjabfung = tb_01.idjabfung AND tb_01.idjabfung != "" AND tb_01.idjenjab = 2 AND tr_petajab.idskpd = tb_01.idskpd,concat(IF(length(tb_01.gdp)>0, concat(tb_01.gdp," "),""),tb_01.nama,IF(length(tb_01.gdb)>0, concat(", ",tb_01.gdb),"")),
                            IF(tr_petajab.idjabfungum = tb_01.idjabfungum AND tb_01.idjabfungum != "" AND tb_01.idjenjab = 3 AND tr_petajab.idskpd = tb_01.idskpd,concat(IF(length(tb_01.gdp)>0, concat(tb_01.gdp," "),""),tb_01.nama,IF(length(tb_01.gdb)>0, concat(", ",tb_01.gdb),"")),NULL)
                        )
                    )
                SEPARATOR "<br>- ") AS orangnya'
            ),
            \DB::raw('IF(tr_petajab.idjenjab>4,skpd.jab,IF(tr_petajab.idjenjab=2,a_jabfung.jabfung,IF(tr_petajab.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jab'),
            \DB::raw('IF(tr_petajab.idjenjab>4,skpd.kelas_jabatan,IF(tr_petajab.idjenjab=2,a_jabfung.kelas_jabatan,IF(tr_petajab.idjenjab=3,a_jabfungum.kelas_jabatan,"-"))) as kelasjab'),
            \DB::raw('IF(tr_petajab.idjenjab>4,a_jabasn.jabasn,IF(tr_petajab.idjenjab=2,a_jenjab.jenjab,IF(tr_petajab.idjenjab=3,a_jenjab.jenjab,"-"))) as jenjabatan'))
            ->whereNotIn('tb_01.idjenkedudupeg', ['99','21'])
            ->where('tr_petajab.periode_bulan', '=', $item->periode_bulan)
            ->where('tr_petajab.periode_tahun', '=', $item->periode_tahun)
            ->where('tr_petajab.idskpd','=',$item->idskpd)
            ->where('tr_petajab.idjabjbt','=','')
            ->orderBy('tr_petajab.idskpd','asc')
            ->orderBy('tr_petajab.idjabjbt','desc')
            ->orderBy('a_tugasdokter.tugasdokter','desc')
            ->orderBy('a_matkulpel.matkulpel','desc')
            ->orderBy('a_jabfung.kelas_jabatan','desc')
            ->orderBy('a_jabfungum.kelas_jabatan','desc')
            ->orderBy('kelasjab','desc')
            ->groupBy('tr_petajab.id')
            ->get();

        if(count($rs2->get()) > 0){
            // Biru
            echo "<li class=\"up-".$item->idesl."\">
                    <a>
                        <span class=\"sotk-title\">&nbsp;</span>
                        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                            <tr>
                                <th align=\"center\" class=".\PetajabatanModel::warnajabatanesl($item->idesl)." colspan=\"5\">".$item->jab."</th>
                            </tr>
                            <tr>
                                <td align=\"center\" class=".\PetajabatanModel::warnajabatanesl($item->idesl)." colspan=\"5\">(Kelas ".$item->kelasjab.")</td>
                            </tr>";
                            if(@$item->namalengkap !=""){
                                echo "<tr><td colspan='5' style='font-size:8pt'>- ".@$item->namalengkap."</td></tr>";
                            }
                            if(count($fungsional)>0){
                                echo "<tr>
                                        <td align=\"center\" width=\"50%\">Jabatan</td>
                                        <td align=\"center\" width=\"12.5%\">Kls</td>
                                        <td align=\"center\" width=\"12.5%\">B</td>
                                        <td align=\"center\" width=\"12.5%\">K</td>
                                        <td align=\"center\" width=\"12.5%\">-/+</td>
                                    </tr>";
                            }

                            foreach ($fungsional as $f) {
                                //ubah warna Revisi 25 Januari 2021
                                $sts_style = ($f->banyakorang > $f->abk)?'red':(($f->banyakorang < $f->abk)?'yellow':'');
                                // -- start if guru or dokter
                                    if(substr($f->idjabfung,0,3) == '300'){
                                        $guru_or_dokter= " - ".@CFirst($item->tugasdokter);
                                    }else if(substr($f->idjabfung,0,3) == '220'){
                                        $guru_or_dokter= " - ".@CFirst($item->tugasdokter);
                                    }else{
                                        $guru_or_dokter= "";
                                    }
                                // -- end if guru or dokter
                                echo "<tr>
                                        <td class=".$sts_style.">".$f->jab."</td>
                                        <td align=\"center\" class=".$sts_style.">".$f->kelasjab.$guru_or_dokter."</td>
                                        <td align=\"center\" class=".$sts_style.">".$f->banyakorang."</td>
                                        <td align=\"center\" class=".$sts_style.">".$f->abk."</td>
                                        <td align=\"center\" class=".$sts_style.">".($f->banyakorang - $f->abk)."</td>
                                    </tr>";
                                 if($f->orangnya!=''){
                                    echo "<tr><td colspan='5' style='font-size:8pt'>- ";
                                        echo $f->orangnya;
                                    echo "</td></tr>";
                                }
                            }
                        echo "</table>
                    </a>";
            echo "\n<ul>";
            familytree($item->idskpd,$x);
            echo "</ul>\n";
        }else{
            // menampilkan yang hijau
            echo "<li>
                <a>
                <span class=\"sotk-title\">&nbsp;</span>
                <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                    <tr>
                        <th align=\"center\" class=".\PetajabatanModel::warnajabatanesl($item->idesl)." colspan=\"5\">".$item->jab."</th>
                    </tr>
                    <tr>
                        <td align=\"center\" class=".\PetajabatanModel::warnajabatanesl($item->idesl)." colspan=\"5\">(Kelas ".$item->kelasjab.")</td>
                    </tr>";
                    if(@$item->namalengkap !=""){
                        echo "<tr><td colspan='5' style='font-size:8pt'>- ".@$item->namalengkap."</td></tr>";
                    }
                    if(count($fungsional)>0){
                        echo "<tr>
                                <td align=\"center\" width=\"50%\">Jabatan</td>
                                <td align=\"center\" width=\"12.5%\">Kls</td>
                                <td align=\"center\" width=\"12.5%\">B</td>
                                <td align=\"center\" width=\"12.5%\">K</td>
                                <td align=\"center\" width=\"12.5%\">-/+</td>
                            </tr>";
                    }
                    foreach ($fungsional as $f) {
                        //ubah warna Revisi 25 Januari 2021
                        $sts_style = ($f->banyakorang > $f->abk)?'red':(($f->banyakorang < $f->abk)?'yellow':'');
                        // -- start if guru or dokter
                                    if(substr($f->idjabfung,0,3) == '300'){
                                        $guru_or_dokter= " - ".@CFirst($item->tugasdokter);
                                    }else if(substr($f->idjabfung,0,3) == '220'){
                                        $guru_or_dokter= " - ".@CFirst($item->tugasdokter);
                                    }else{
                                        $guru_or_dokter= "";
                                    }
                                // -- end if guru or dokter


                           echo "<tr>
                                    <td class=".$sts_style.">".$f->jab."</td>
                                    <td align=\"center\" class=".$sts_style.">".$f->kelasjab.$guru_or_dokter."</td>
                                    <td align=\"center\" class=".$sts_style.">".$f->banyakorang."</td>
                                    <td align=\"center\" class=".$sts_style.">".$f->abk."</td>
                                    <td align=\"center\" class=".$sts_style.">".($f->banyakorang - $f->abk)."</td>
                                </tr>";
                            if($f->orangnya != ""){
                                echo "<tr><td colspan='5' style='font-size:8pt'>- ";
                                    echo $f->orangnya;
                                echo "</td></tr>";
                            }
                    }
                    // echo "<tr><td colspan='5' style='font-size:8pt'>- ";
                    // $x=1;
                    // foreach ($fungsional as $f) {
                    //         if(!empty($f->orangnya)){
                    //             if($x!=1){
                    //                 echo '<br>- ';
                    //             }
                    //             echo $f->orangnya;
                    //             $x++;
                    //         }
                    // }
                    // echo "</td></tr>";   
            echo "</table>
            </a>";
        }
        echo "</li>\n";
    }
}


function select_hari($id = 0,$selected=''){
    $hari = array("-", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu","All Day");
    return Form::select($id,$hari,$selected,array('style' => 'width:100%'));
}

function array_hari($id = 0,$selected=''){
    $hari = array("-", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu","All Day");
    return $hari;
}

function date_picker($id = 'asa',$value=""){
    echo '<script>'
    .'$(document).ready(function(){'
    .'$(".tgl").datetimepicker({format: "YYYY-MM-DD"});'
    .'})</script>'
    .'<input type="text" class="form-control tgl" value="'.$value.'" id="'.$id.'" name="'.$id.'"  placeholder="Masukkan Tanggal">';
}

function tanggal_indonesia(){
    $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"); 
    $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"); 
//    $cetak_date = $hari[(int)date("w")] .', '. date("j ") . $bulan[(int)date('m')] . date(" Y"); 
    $cetak_date = date("j ") . $bulan[(int)date('m')] . date(" Y"); 
    return $cetak_date ;
}

function sekarang(){
    return date("Y-m-d H:i:s");
}


function modal($sempit = false,$name = 'modal2',$body = 'Modal2',$minus=false){
    $class = ($sempit == false)?'modal-dialog-wide':'modal-dialog';
    $js = '<script>var duplicateChk = {};'
            .'$("div#modal2[class]").each (function (a) {'
            .'if (duplicateChk.hasOwnProperty(this.class)) {'
            .'alert("kembar");$(this).remove();'
            .'} else { duplicateChk[this.class] = "true";}});</script>';
    
    $min = ($minus == true)?'':'';
    $html =  '<div class="modal fade" id="'.$name.'" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="'.$class.'">
        <div class="modal-content" id="wadah_modal">
        <div class="modal-header bg-primary">
        <button onclick="claravel_modal_close('."'$name'".')" type="button" aria-hidden="true" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-remove" ></i></button>
            '.$min.'
        <h4 class="modal-title"><b id="judulmodal"></b></h4>
      </div>
      <div class="modal-body">
        <div id="konten'.$body.'"></div>
      </div>
      <div class="modal-footer">
        <div id="footermodal"></div>
      </div>
    </div>
  </div>
</div>';
    return $html;
}

function catat_log($aksi = '',$modul=''){
    $simpan = array(
        'aksi' => $aksi,
        'module' => $modul,
        'user' => \Session::get('user_id'),
        'url' => \Request::url(),
        'waktu' => date("Y-m-d H:i:s")
    );
    $save = \DB::table('application_log')->insert($simpan);
}

function header_dokumen(){
    return '<link rel="stylesheet" href="'.getBaseURL(true).'/packages/tugumuda/claravel/assets/css/bootstrap.css" />'.
            '<link rel="stylesheet" href="'.getBaseURL(true).'/packages/tugumuda/claravel/assets/css/bootstrap-theme.css" />'.
            '<link rel="stylesheet" href="'.getBaseURL(true).'/packages/tugumuda/claravel/assets/css/bootstrap-icons.css" />';
}

function hari($hari){
    switch ($hari){
        case '0' :
            return '';
            break;
        case '1' :
            return 'Senin';
            break;
        case '2' :
            return 'Selasa';
            break;
        case '3' :
            return 'Rabu';
            break;
        case '4' :
            return 'Kamis';
            break;
        case '5' :
            return "Jum'at";
            break;
        case '6' :
            return 'Sabtu';
            break;
        case '7' :
            return 'Minggu';
            break;
    }
}

function konversi_hari($hari){
    $hari = date("l", strtotime($hari));
        switch ($hari){
        case 'Monday' :
            return 'Senin';
            break;
        case 'Thuesday' :
            return 'Selasa';
            break;
        case 'Wednesday' :
            return 'Rabu';
            break;
        case 'Thursday' :
            return 'Kamis';
            break;
        case 'Friday' :
            return "Jum'at";
            break;
        case 'Saturday' :
            return 'Sabtu';
            break;
        case 'Sunday' :
            return 'Minggu';
            break;
    }
};  

function cekLogin(){
    $user = \Session::get('user_id');
    $role = \Session::get('role_id');
    return (!$user || !$role)?false:TRUE;
    //if (!$user || !$role){die('Invalid Access :: You must sign in first !!<br><br><i>With Love :: Developer</i>');}
}

function cekAjax(){
    if (!\Request::ajax()){die('Invalid URL Request<br><br><i>With Love :: Developer</i>');}
}

function get_role(){
    return \Session::get('role_id');
}

function user_id(){
    return \Session::get('user_id');
}

//START CREATED BY WIGUNA ON 16 MARET

function inputWarna($id='',$selected=""){
    $a1 = ($selected == 'bg-color-blue')?' selected ':' ';
    $a2 = ($selected == 'bg-color-blueDark')?' selected ':' ';
    $a3 = ($selected == 'bg-color-darken')?' selected ':' ';
    $a4 = ($selected == 'bg-color-green')?' selected ':' ';
    $a5 = ($selected == 'bg-color-greenDark')?' selected ':' ';
    $a6 = ($selected == 'bg-color-orange')?' selected ':' ';
    $a7 = ($selected == 'bg-color-pink')?' selected ':' ';
    $a8 = ($selected == 'bg-color-purple')?' selected ':' ';
    $a9 = ($selected == 'bg-color-yellow')?' selected ':' ';
    $a10 = ($selected == 'bg-color-red')?' selected ':' ';
    $html = '<select id="'.$id.'" name="'.$id.'">
            <option '.$a1.'value="bg-color-blue">Biru</option>
            <option '.$a2.'value="bg-color-blueDark">Biru Gelap</option>
            <option '.$a3.'value="bg-color-darken">Gelap</option>
            <option '.$a4.'value="bg-color-green">Hijau</option>
            <option '.$a5.'value="bg-color-greenDark">Hijau Gelap</option>
            <option '.$a6.'value="bg-color-orange">Jingga</option>
            <option '.$a7.'value="bg-color-pink">Merah Muda</option>
            <option '.$a8.'value="bg-color-purple">Ungu</option>
            <option '.$a9.'value="bg-color-red">Merah</option>
            <option '.$a10.'value="bg-color-yellow">Kuning</option>
            </select>';
    return $html;
}


function isSecure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}

function getBaseURL($with_http = false){
    /*
    $url = \Request::url();
    //    $url = str_replace('http://')
    $arrurl = explode('/',$url);
    if ($with_http == false){
        return $arrurl[2];
    }
    else{
        return (isSecure())?'https://'.$arrurl[2].'/':'http://'.$arrurl[2].'/';
        //return 'https://'.$arrurl[2].'/';
    }
    */
    return url();
}

function ambil_angka($a){
    return preg_replace('/[^\p{L}\p{N}\s]/u', '', $a);    
}

function getBrowser() { 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'shortname'      => $ub,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 


function uang_akhir($nominal = ''){
    if ($nominal == ''){
        return 0;
    }
    else{
        if($nominal < 0){
            return '('.@number_format( ($nominal) * (-1) ,0,',','.').')';
        }else{
            return @number_format($nominal,0,',','.');                    
        }
    }
}

function number_format_persen($nominal,$desimal = 0){
    $desimal = (is_integer($nominal))?0:2;
    if(false === $nominal){
        return 100;
    }
    if ($nominal == ''){
        return 0;
    }
    else{
        if($nominal < 0){
            return '('.  @number_format($nominal * (-1),$desimal, "," , ".").')';
//            return '('.  number_format($nominal * (-1),2, "," , ".").')';
        }else{
//            return number_format($nominal,2, "," , ".");
            return @number_format($nominal,$desimal, "," , ".");
        }
    }
}


function td($array=array(),$tr = false){
    $t = ($tr)?'<tr>':'';
    foreach($array as $a){
        $t .= '<td>'.$a.'</td>';
    }
    $t .= ($tr)?'</tr>':'';
    return $t;
}

function th($array=array(),$tr = false){
    $t = ($tr)?'<tr>':'';
    foreach($array as $a){
        $t .= '<th>'.$a.'</th>';
    }
    $t .= ($tr)?'</tr>':'';
    return $t;
}

function array_msort($array, $cols)
{
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

}



function fix_view_css(){
    return "<style>table td{padding : 0.5px!important;}.form-group{margin-bottom : 5px!important;}</style>";    
}

/*helper sownload*/
function force_download($filename = '', $data = '')
{
    if ($filename == '' OR $data == '')
    {
        return FALSE;
    }

        // Try to determine if the filename includes a file extension.
        // We need it in order to set the MIME type
    if (FALSE === strpos($filename, '.'))
    {
        return FALSE;
    }

        // Grab the file extension
    $x = explode('.', $filename);
    $extension = end($x);

        // Load the mime types
    if (defined('ENVIRONMENT') AND is_file('app/'.ENVIRONMENT.'/mimes.php'))
    {
        include('app/'.ENVIRONMENT.'/mimes.php');
    }
    elseif (is_file('app/mimes.php'))
    {
        include('app/mimes.php');
    }

        // Set a default mime if we can't find it
    if ( ! isset($mimes[$extension]))
    {
        $mime = 'application/octet-stream';
    }
    else
    {
        $mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
    }

        // Generate the server headers
    if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== FALSE)
    {
        header('Content-Type: "'.$mime.'"');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Content-Transfer-Encoding: binary");
        header('Pragma: public');
        header("Content-Length: ".strlen($data));
    }
    else
    {
        header('Content-Type: "'.$mime.'"');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: no-cache');
        header("Content-Length: ".strlen($data));
    }

    exit($data);
}

function namabulan($bulan){
    switch ($bulan){
         case '0' :
            return '';
            break;
         case '01' :
            return 'Januari';
            break;
         case '02' :
            return 'Februari';
            break;
         case '03' :
            return 'Maret';
            break;
         case '04' :
            return 'April';
            break;
         case '05' :
            return "Mei";
            break;
         case '06' :
            return 'Juni';
            break;
         case '07' :
            return 'Juli';
            break;
         case '08' :
             return 'Agustus';
             break;
         case '09' :
             return 'September';
             break;
         case '10' :
             return 'Oktober';
             break;
         case '11' :
              return 'November';
              break;
         case '12' :
               return 'Desember';
               break;

    }
}

function getNotif($tahun = 0, $bulan = 0)
{
    if($tahun == 0){
        $tahun =  date('Y');
    }

    if($bulan == 0){
        $bulan = date('m');
    }

    $c_kepegawaian = \DB::connection('kepegawaian')->table('a_skpd')->where('idskpd','like', "01%")->count();
    
    $c_petajab = \PetajabatanModel::where('idskpd','like', "01%")
                ->where('idjenjab','>',4)
                ->where('periode_tahun', $tahun)
                ->where('periode_bulan', $bulan)
                ->count();

    return ($c_petajab==$c_kepegawaian)?0:1;
}

/*combo list bulan static petajabatan*/
function comboBulanjab($id="bulan",$sel="",$required=""){
    $month2[1] = "Januari";
    $month2[2] = "Februari";
    $month2[3] = "Maret";
    $month2[4] = "April";
    $month2[5] = "Mei";
    $month2[6] = "Juni";
    $month2[7] = "Juli";
    $month2[8] = "Agustus";
    $month2[9] = "September";
    $month2[10] = "Oktober";
    $month2[11] = "November";
    $month2[12] = "Desember";
    $html = "<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $now = '';
    $html .= "<option value=''>.: Pilihan :.</option>";
    for ($i = 1; $i <= 1; $i++) { //12
        $bulan = $month2[$i];
        if (strlen($i) == 1) {
            $i = "0" . $i;
        }
        if ($i == $sel) {
            $html .= "<option value='$i' selected>$i | $bulan</option>";
        } else {
            $html .= "<option value='$i'>$i | $bulan</option>";
        }
        $now = 1;
        $now = $now + $i;
    }
    $html .= "</select>";
    return $html;
}

/*combo list tahun petajabatan*/
function comboTahunjab($id="tahun",$sel="",$required=""){
    $html="<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $html .= "<option value=''>.: Pilihan :.</option>";
    /*for($i=date('Y')-5;$i<=date('Y')+30;$i++){*/
    for($i=2021;$i<=2021;$i++){
        $html.="<option value='$i' ".(($i==$sel)?"selected":"").">$i</option>";
    }
    $html.="</select>";
    return $html;
}

function CFirst($word){
     return  ucwords(strtolower($word));
}