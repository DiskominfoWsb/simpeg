<!DOCTYPE html>
<html>
<head>
    <title>Kebutuhan Jabatan</title>
    <style type="text/css">
        .tabel {
            border: 1px solid #000000;
        }
    </style>
</head>
<body>
<?php
$rs = \DB::table('tr_petajab')
        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'), 'tr_petajab.idskpd', '=', 'skpd.idskpd')
        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjab as a_jenjab'), 'tr_petajab.idjenjab','=','a_jenjab.idjenjab')
        ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabasn as a_jabasn'), 'tr_petajab.idjenjab','=','a_jabasn.idjabasn')
        ->select(\DB::raw('tr_petajab.*, tr_petajab.idjenjab, skpd.skpd as subskpd'),
        \DB::raw('IF(tr_petajab.idjenjab>4,skpd.jab,IF(tr_petajab.idjenjab=2,a_jabfung.jabfung,IF(tr_petajab.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jab'),
        \DB::raw('IF(tr_petajab.idjenjab>4,skpd.kelas_jabatan,IF(tr_petajab.idjenjab=2,a_jabfung.kelas_jabatan,IF(tr_petajab.idjenjab=3,a_jabfungum.kelas_jabatan,"-"))) as kelasjab'),
        \DB::raw('IF(tr_petajab.idjenjab>4,a_jabasn.jabasn,IF(tr_petajab.idjenjab=2,a_jenjab.jenjab,IF(tr_petajab.idjenjab=3,a_jenjab.jenjab,"-"))) as jenjabatan'),
        \DB::raw('IF(tr_petajab.idjenjab>4,skpd.idjenjurusan,IF(tr_petajab.idjenjab=2,a_jabfung.idjenjurusan,IF(tr_petajab.idjenjab=3,a_jabfungum.idjenjurusan,"-"))) as syarat_idjenjurusan'),
        \DB::raw('IF(tr_petajab.idjenjab>4,skpd.iddiklat,IF(tr_petajab.idjenjab=2,a_jabfung.iddiklat,IF(tr_petajab.idjenjab=3,a_jabfungum.iddiklat,"-"))) as syarat_iddiklat'))
        ->where('periode_bulan', '=', $periode_bulan)
        ->where('periode_tahun', '=', $periode_tahun)
        ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
        ->orderBy('tr_petajab.idskpd','asc')
        ->orderBy('idjabfungum','asc')
        ->orderBy('idjabfung','asc')
        ->get();
?>
<table>
    <tr><td colspan="7" style="text-align: center; font-weight: bold;">DAFTAR KEBUTUHAN JABATAN</td></tr>
    <tr><td colspan="7" style="text-align: center; font-weight: bold;">{{ strtoupper(getSkpd($idskpd))  }}</td></tr>
    <tr><td colspan="7" style="text-align: center; font-weight: bold;">PEMERINTAH KABUPATEN KENDAL</td></tr>
    <tr><td colspan="7" style="text-align: center; font-weight: bold;">PERIODE {{ strtoupper(formatBulan($periode_bulan)).' '.$periode_tahun }}</td></tr>
    
    <tr></tr>
    
    <tr>
        <td class="tabel" style="font-weight: bold;">NO</td>
        <td class="tabel" style="font-weight: bold;">NAMA JABATAN</td>
        <td class="tabel" style="font-weight: bold;">NAMA UNIT KERJA</td>
        <td class="tabel" style="font-weight: bold;">KUALIFIKASI PENDIDIKAN</td>
        <td class="tabel" style="font-weight: bold;">ABK</td>
        <td class="tabel" style="font-weight: bold;">RIIL</td>
        <td class="tabel" style="font-weight: bold;">STATUS</td>
        <td class="tabel" style="font-weight: bold;">+/-</td>
    </tr>
    <?php 
        $no = 0;
        $total = 0;
        foreach($rs as $item){
            $no++;
            $banyakorang = '-';
            if($item->idjenjab >= 20){
                $banyakorang = PetajabatanModel::comboExisting($item->idjenjab,$item->idskpd,$item->idjabjbt);
            } else if($item->idjenjab == 2){
                $banyakorang = PetajabatanModel::comboExisting($item->idjenjab,$item->idskpd,$item->idjabfung,@$item->idmatkulpel,@$item->idtugasdokter);
            } else if($item->idjenjab == 3){
                $banyakorang = PetajabatanModel::comboExisting($item->idjenjab,$item->idskpd,$item->idjabfungum);
            } else if($item->idjenjab == 0){
                $banyakorang = PetajabatanModel::comboExisting($item->idjenjab,$item->idskpd);
            }


            if($banyakorang>$item->abk){
                $status_selisih = 'Lebih';
            }
            else if($banyakorang<$item->abk){
                $status_selisih = 'Kurang';
                $total = $total+abs($banyakorang-$item->abk);
            }else{
                $status_selisih = 'OK';
            }
    ?>      
            <tr>
                <td class="tabel">{!! $no !!}</td>
                <td class="tabel">{!! KebutuhanjabatanModel::lengthspace($item->idskpd)." ".(($item->idjenjab < 20)?'     ':'').$item->jab !!}</td>
                <td class="tabel">{!! ($item->subskpd!='')? $item->subskpd:'-' !!}</td>
                <td class="tabel">{!! ($item->syarat_idjenjurusan!='')? KebutuhanjabatanModel::getJenisjurusan($item->syarat_idjenjurusan):'-' !!}</td>
                <td class="tabel">{!! ($item->abk!='')?$item->abk:'-' !!}</td>
                <td class="tabel">{!! $banyakorang !!}</td>
                <td class="tabel">{!! $status_selisih !!}</td>
                <td class="tabel">{!! $banyakorang-$item->abk !!}</td>
            </tr>
    <?php
        }
     ?>

    <tr>
       <td colspan="7" class="tabel" style="text-align: right; font-weight: bold">Total Kebutuhan</td> 
       <td class="tabel">{!!  $total; !!}</td>
    </tr>
</table>


</body>
</html>