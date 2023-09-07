<?php
    $idpetajab = Input::get('id');
    $idskpd = Input::get('idskpd');
    $idjabfungum = Input::get('idjabfungum');
    $idjabfung = Input::get('idjabfung');
    $idjenjab = Input::get('idjenjab');
    $kdunit = substr($idskpd,0,2);
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');
    $idmatkulpel = Input::get('idmatkulpel');
    $idtugasdokter = Input::get('idtugasdokter');

    if($idjenjab == 2){
        $title = \DB::table('tr_petajab as a')
        ->select(\DB::raw('c.skpd as subskpd, b.skpd, a.namajabatan'))
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), 'b.idskpd', '=', 'a.kdunit')
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as c'), 'c.idskpd', '=', 'a.idskpd')
        ->where('a.idskpd', $idskpd)
        ->where('a.idjabfung', $idjabfung)
        ->where('a.periode_bulan', $periode_bulan)
        ->where('a.periode_tahun', $periode_tahun)
        ->first();
    }else if($idjenjab == 3){
        $title = \DB::table('tr_petajab as a')
        ->select(\DB::raw('c.skpd as subskpd, b.skpd, a.namajabatan'))
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), 'b.idskpd', '=', 'a.kdunit')
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as c'), 'c.idskpd', '=', 'a.idskpd')
        ->where('a.idskpd', $idskpd)
        ->where('a.idjabfungum', $idjabfungum)
        ->where('a.periode_bulan', $periode_bulan)
        ->where('a.periode_tahun', $periode_tahun)
        ->first();
    }else{
        $title = \DB::table('tr_petajab as a')
        ->select(\DB::raw('c.skpd as subskpd, b.skpd, a.namajabatan'))
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), 'b.idskpd', '=', 'a.kdunit')
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as c'), 'c.idskpd', '=', 'a.idskpd')
        ->where('a.idskpd', $idskpd)
        ->where('a.periode_bulan', $periode_bulan)
        ->where('a.periode_tahun', $periode_tahun)
        ->first();
    }
    $where = ' tb_01.idjenkedudupeg not in ("99","21") and tb_01.kdunit = "'.$kdunit.'"';


    if($idjenjab !=0){ 
        // yang sudah di kepala sekolah, tidak dihitung lagi
        $where .= " and iskepsek != 1";
    }


    if($idjenjab >= 20){
        $where .= " and tb_01.idjenjab > '4' and tb_01.idjabjbt = '".$idskpd."' and tb_01.idskpd = '".$idskpd."' and tb_01.idskpd != ''";
    } else if($idjenjab == 2){
        if(substr($idjabfung, 0,3) == '300'){ //004
            $where .= " and ((tb_01.idjenjab = '".$idjenjab."' and tb_01.idjabfung = '".$idjabfung."') or (tb_01.idjenjab = '3' and tb_01.idjabproyeksi = '".$idjabfung."')) and tb_01.idskpd = '".$idskpd."' and tb_01.idmatkulpel = '".$idmatkulpel."'";
        } else if(substr($idjabfung, 0,3) == '220'){ //005
            $where .= " and ((tb_01.idjenjab = '".$idjenjab."' and tb_01.idjabfung = '".$idjabfung."') or (tb_01.idjenjab = '3' and tb_01.idjabproyeksi = '".$idjabfung."')) and tb_01.idskpd = '".$idskpd."' and tb_01.idtugasdokter = '".$idtugasdokter."'";
        } else {
            $where .= " and ((tb_01.idjenjab = '".$idjenjab."' and tb_01.idjabfung = '".$idjabfung."') or (tb_01.idjenjab = '3' and tb_01.idjabproyeksi = '".$idjabfung."')) and tb_01.idskpd = '".$idskpd."'";
        }            
    } else if($idjenjab == 3){
        $where .= " and tb_01.idjenjab = '".$idjenjab."' and tb_01.idjabfungum = '".$idjabfungum."' and tb_01.idjabfungum != '' and tb_01.idskpd = '".$idskpd."'";
    } else if($idjenjab == 0){
        // $where .= " and tb_01.idskpd = '".$idskpd."' and tb_01.idskpd != '' and tb_01.idtugasgurudosen = '1'" ;
        $where .= " and tb_01.idskpd = '".$idskpd."' and tb_01.idskpd != '' and iskepsek = '1'" ;
    }


    // if($idjenjab == '2'){
    //     $where .= " and tb_01.idjabfung = '".$idjabfung."' and tb_01.idjabfung != '' and tb_01.idjenjab = '".$idjenjab."' and tb_01.idskpd = '".$idskpd."'";
    // } else if($idjenjab == '3'){
    //     $where .= " and tb_01.idjabfungum = '".$idjabfungum."' and tb_01.idjabfungum != '' and tb_01.idjenjab = '".$idjenjab."' and tb_01.idskpd = '".$idskpd."'";
    // } else {
    //     $where .= " and tb_01.idskpd = '".$idskpd."' and tb_01.idskpd != '' and tb_01.idjenjab > '4'";
    // }

    $rs = \DB::connection('kepegawaian')->table('tb_01')
        ->select('tb_01.*','a_golruang.golru','a_skpd.path','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
        \DB::raw("
                CONCAT(
                    IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                            -
                            (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                            IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                        ),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                            + tb_01.mkthncpn
                        )
                    ),
                    RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
            "),
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
        )
        ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
        ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->whereRaw($where)
        ->orderBy('tb_01.idjenjab', 'asc')
        ->orderBy('tb_01.idgolrupkt', 'desc')
        ->orderBy('tb_01.tmtpkt', 'asc');
?>


<div align="center">
        <h3>DAFTAR PEGAWAI PADA {!!$title->subskpd!!} {!!$title->skpd!!}</h3>
        <h3>BERDASARKAN JABATAN {!!strtoupper($title->namajabatan)!!}</h3>
    </div><br>

<table id="tableData2" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th rowspan="2">
                <div class="text-center">NO.</div>
            </th>
            <th rowspan="2">
                <div class="text-left">NAMA</div>
                <div class="text-left">TEMPAT, TGL LAHIR</div>
            </th>
            <th rowspan="2">
                <div class="text-center">NIP</div>
                <div class="text-center">KARPEG</div>
            </th>
            <th rowspan="2">
                <div class="text-center">GOL.</div>
                <div class="text-center">TMT</div>
            </th>
            <th rowspan="2">
                <div class="text-center">ESELON</div>
                <div class="text-center">TMT</div>
            </th>
            <th rowspan="2">
                <div class="text-center">JABATAN</div>
                <div class="text-center">UNIT KERJA</div>
                <div class="text-center">TMT</div>
            </th>
            <th colspan="2">
                <div class="text-center">MASA KERJA</div>
            </th>
            <th colspan="2">
                <div class="text-center">s/d SEKARANG</div>
            </th>
            <th rowspan="2">
                <div class="text-center">PENDIDIKAN TERAKHIR</div>
                <div class="text-center">TAHUN</div>
            </th>
            <th rowspan="2">
                <div class="text-center">AGAMA</div>
                <div class="text-center">USIA</div>
            </th>
        </tr>
        <tr>
            <th>
                <div class="text-center">THN</div>
            </th>
            <th>
                <div class="text-center">BLN</div>
            </th>
            <th>
                <div class="text-center">THN</div>
            </th>
            <th>
                <div class="text-center">BLN</div>
            </th>
        </tr>
    </thead>
    <tbody>
            @if(count($rs->get()) > 0)
            <?php $n = 0; ?>
            @foreach($rs->get() as $item)
            <?php $n++; ?>
            <tr>
                <td align="center">{!!$n!!}.</td>
                <td>
                    <div class="text-left">{!!$item->namalengkap!!}</div>
                    <small><div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div></small>
                </td>
                <td align="center">
                    <div class="text-center">{!!fnip($item->nip)!!}</div>
                    <div class="text-center">{!!$item->nokarpeg!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!$item->golru!!}</div>
                    <div class="text-center">{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!($item->esl!='')?$item->esl:'-'!!}</div>
                </td>
                <td>
                    <small>
                        <div class="text-left">{!!$item->jabatan!!}</div>
                        <div class="text-left"><i>Pada</i></div>
                        <div class="text-left">{!!$item->path!!}</div> <!--$item->path_short-->
                        <div class="text-left">TMT : {!!($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):''!!}</div>
                    </small>
                </td>
                <td align="center">
                    <div class="text-center">{!!$item->mkthnpkt!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!$item->mkblnpkt!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!substr($item->mkskr,0,-2)!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!substr($item->mkskr,-2)!!}</div>
                </td>
                <td>
                    <div class="text-left">{!!ucwords(strtolower($item->jenjurusan))!!}</div>
                    <div class="text-left">{!!$item->thijaz!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!$item->agama!!}</div>
                    <div class="text-center">{!!substr($item->usia,0,2)!!} thn {!!substr($item->usia,2,2)!!} bln</div>
                </td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="12">Daftar Pegawai tidak tersedia.</td></tr>
            @endif
            </tbody>
</table>