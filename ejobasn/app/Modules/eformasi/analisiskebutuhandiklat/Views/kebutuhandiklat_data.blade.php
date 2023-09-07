<?php
    /*cek sudah ada petajabatan ditahun yang sama atau belum*/
    $x = 0;
    $idskpd = Input::get('idskpd');
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');
    $idjenjab = Input::get('idjenjab');
    $idjabatan = Input::get('idjabatan');
    $idjendiklat = Input::get('idjendiklat');
    $iddiklat = Input::get('iddiklat');
    $kdunit = substr($idskpd,0,2);

    $idstatusdiklat = Input::get('idstatusdiklat');

    $where = ' tb_01.idjenkedudupeg not in ("99","21") and tb_01.kdunit = "'.$kdunit.'"';
    if($idjenjab == '2'){
        // $where .= " and tb_01.idjabfung = '".$idjabatan."' and tb_01.idjabfung != '' and tb_01.idjenjab = '".$idjenjab."' and tb_01.idskpd like '".$idskpd."%'";
        $where .= " and tb_01.idjabfung = '".$idjabatan."' and tb_01.idjabfung != '' and tb_01.idskpd like '".$idskpd."%'";
    } else if($idjenjab == '3'){
        // $where .= " and tb_01.idjabfungum = '".$idjabatan."' and tb_01.idjabfungum != '' and tb_01.idjenjab = '".$idjenjab."' and tb_01.idskpd like '".$idskpd."%'";
        $where .= " and tb_01.idjabfungum = '".$idjabatan."' and tb_01.idjabfungum != '' and tb_01.idskpd like '".$idskpd."%'";
    } else {
        //$where .= " and tb_01.idskpd like '".$idskpd."%' and tb_01.idskpd != '' and tb_01.idjenjab > '4'";
        $where .= " and tb_01.idskpd like '".$idskpd."%' and tb_01.idskpd != ''";
    }


    if($idjendiklat == 1){

        $diklat = \DB::connection('kepegawaian')->table('a_dikstru')->where('iddikstru','=',$iddiklat)->first();

        if($idstatusdiklat==1){
            $where .= " and r_dikstru.iddikstru = '".$iddiklat."' AND tb_01.nip IN (SELECT nip FROM r_dikstru WHERE iddikstru = '".$iddiklat."') group by tb_01.nip";
        } else {
            $where .= " and r_dikstru.iddikstru != '".$iddiklat."' AND tb_01.nip NOT IN (SELECT nip FROM r_dikstru WHERE iddikstru = '".$iddiklat."') AND tb_01.idjenjab > '4' group by tb_01.nip";
        }

        $rs = \DB::connection('kepegawaian')->table('r_dikstru')
        ->join('tb_01','tb_01.nip','=','r_dikstru.nip')
        ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftJoin('a_skpd as b', \DB::raw('left(tb_01.idskpd,2)'), '=' ,'b.idskpd')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->select('tb_01.*','a_golruang.golru','b.skpd', 'a_skpd.skpd as subskpd',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan')
        )
        ->whereRaw($where)
        ->orderBy('tb_01.idjenjab', 'asc')
        ->orderBy('tb_01.idgolrupkt', 'desc')

        // ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
        // ->orderBy('tr_petajab.idskpd','asc')
        // ->orderBy('tr_petajab.idjabjbt','desc')
        // ->orderBy('a_jabfung.kelas_jabatan','desc')
        // ->orderBy('a_jabfungum.kelas_jabatan','desc')
        // ->orderBy('tr_petajab.idjabfungum','asc')
        // ->orderBy('tr_petajab.idjabfung','asc')
        // ->groupBy('tr_petajab.id')
        ->get();
    } else if($idjendiklat == 2){
        $diklat = \DB::connection('kepegawaian')->table('a_dikfung')->where('iddikfung','=',$iddiklat)->first();

        if($idstatusdiklat==1){
            $where .= " and r_dikfung.iddikfung = '".$iddiklat."' AND tb_01.nip IN (SELECT nip FROM r_dikfung WHERE iddikfung = '".$iddiklat."') group by tb_01.nip";
        } else {
            $where .= " and r_dikfung.iddikfung != '".$iddiklat."' AND tb_01.nip NOT IN (SELECT nip FROM r_dikfung WHERE iddikfung = '".$iddiklat."') AND tb_01.idjenjab = '2' group by tb_01.nip";
        }

        $rs = \DB::connection('kepegawaian')->table('r_dikfung')
        ->join('tb_01','tb_01.nip','=','r_dikfung.nip')
        ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftJoin('a_skpd as b', \DB::raw('left(tb_01.idskpd,2)'), '=' ,'b.idskpd')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->select('tb_01.*','a_golruang.golru','b.skpd', 'a_skpd.skpd as subskpd',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan')
        )
        ->whereRaw($where)
        ->orderBy('tb_01.idjenjab', 'asc')
        ->orderBy('tb_01.idgolrupkt', 'desc')

        // ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
        // ->orderBy('tr_petajab.idskpd','asc')
        // ->orderBy('tr_petajab.idjabjbt','desc')
        // ->orderBy('a_jabfung.kelas_jabatan','desc')
        // ->orderBy('a_jabfungum.kelas_jabatan','desc')
        // ->orderBy('tr_petajab.idjabfungum','asc')
        // ->orderBy('tr_petajab.idjabfung','asc')
        // ->groupBy('tr_petajab.id')
        ->get();
    } else if($idjendiklat == 3){
        $diklat = \DB::connection('kepegawaian')->table('a_diktek')->where('iddiktek','=',$iddiklat)->first();

        if($idstatusdiklat==1){
            $where .= " and r_diktek.iddiktek = '".$iddiklat."' AND tb_01.nip IN (SELECT nip FROM r_diktek WHERE iddiktek = '".$iddiklat."') group by tb_01.nip";
        } else {
            $where .= " and r_diktek.iddiktek != '".$iddiklat."' AND tb_01.nip NOT IN (SELECT nip FROM r_diktek WHERE iddiktek = '".$iddiklat."') group by tb_01.nip";
        }

        $rs = \DB::connection('kepegawaian')->table('r_diktek')
        ->join('tb_01','tb_01.nip','=','r_diktek.nip')
        ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftJoin('a_skpd as b', \DB::raw('left(tb_01.idskpd,2)'), '=' ,'b.idskpd')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->select('tb_01.*','a_golruang.golru','b.skpd', 'a_skpd.skpd as subskpd',
                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan')
        )
        ->whereRaw($where)
        ->orderBy('tb_01.idjenjab', 'asc')
        ->orderBy('tb_01.idgolrupkt', 'desc')

        // ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
        // ->orderBy('tr_petajab.idskpd','asc')
        // ->orderBy('tr_petajab.idjabjbt','desc')
        // ->orderBy('a_jabfung.kelas_jabatan','desc')
        // ->orderBy('a_jabfungum.kelas_jabatan','desc')
        // ->orderBy('tr_petajab.idjabfungum','asc')
        // ->orderBy('tr_petajab.idjabfung','asc')
        // ->groupBy('tr_petajab.id')
        ->get();
    }

?>

<br><div align="center">
    <h4>ANALISIS KEBUTUHAN DIKLAT</h4>
    <h4>
            @if($idjendiklat==1)
                {!! strtoupper($diklat->dikstru) !!}
            @elseif($idjendiklat==2)
                {!! strtoupper($diklat->dikfung) !!}
            @else
                {!! strtoupper($diklat->diktek) !!}
            @endif
    <h4>
        PADA {!!((Input::get('idskpd') != '')?strtoupper(getSkpd(Input::get('idskpd'))):'')!!}
    </h4>
    
    </div><br>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <thead class="bg-primary">
        <tr>
            <th width="3%" class="text-center">NO</th>
            <th class="text-center">NIP</th>
            <th class="text-center">NAMA</th>
            <th class="text-center">GOLONGAN</th>
            <th class="text-center">JABATAN</th>
            <th class="text-center">SUB UNIT KERJA</th>
            <th class="text-center">UNIT KERJA</th>
        </tr>
        </thead>
        <tbody>
        @if(count($rs) > 0)
        @foreach($rs as $item)
        <?php $x++; ?>
        <tr>
            <td class="text-center">{!!$x!!}</td>
            <td><div class="text-center">{!!fnip($item->nip)!!}</div></td>
            <td><div class="text-left">{!!$item->namalengkap!!}</div></td>
            <td><div class="text-center">{!!$item->golru!!}</div></td>
            <td><div class="text-left">{!!$item->jabatan!!}</div></td>
            <td><div class="text-left">{!!$item->subskpd!!}</div></td>
            <td><div class="text-left">{!!$item->skpd!!}</td>
        </tr>
        @endforeach
       @else 
    <tr>
        <td align="center" colspan="8"><h4>DATA TIDAK DITEMUKAN</h4></td>
    </tr>
@endif

        </tbody>
    </table>
    