<?php
    $x  = 0;
	$id = Input::get('id');
	$idx = Input::get('idx');
	$search = Input::get('search');

    /*kondisi default*/
    $where = "a_skpd.flag = 1 and a_skpd.jab_asn NOT IN ('', 0, 1)";
    $where2 = "tr_petajab.id != '' and tr_petajab.idjenjab > 4";
    if(session('role_id') == '4'){
        $where.= " and a_skpd.idskpd like \"".session('idskpd')."%\" ";
        $where2.= " and tr_petajab.idskpd like \"".session('idskpd')."%\" ";
    }

    if($search != ''){
        $where.= " and (a_skpd.jab like \"%".$search."%\" or a_skpd2.skpd like \"%".$search."%\")";
        $where2.= " and (tr_petajab.namajabatan like \"%".$search."%\" or a_skpd2.skpd like \"%".$search."%\")";
    }

    switch ($id){
        /*Perbedaan nama jabatan anatara petajabatan dan unitkerja*/
        case 2 :
            $title = '
                <strong><i class="fa fa-info-circle"></i> Sinkronisasi Perbedaan Unit Kerja!</strong>
                <br>Kebutuhan sinkronisasi meliputi perbedaan nama jabatan pada master data unit kerja dengan nama jabatan pada master data petajabatan.
                Solusi update data petajabatan sesuai dengan master unit kerja.
            ';
            $rs = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd'))
                ->select(\DB::raw('left(a_skpd.idskpd, 2) as kdunit'), 'a_skpd2.skpd','a_skpd.idskpd', 'a_skpd.jab_asn', 'a_skpd.jab', 'tr_petajab.idskpd as idjab', 'tr_petajab.idjenjab', 'tr_petajab.namajabatan','tr_petajab.periode_tahun','tr_petajab.periode_bulan')
                ->leftjoin('tr_petajab', function($join){
                    $join->on('a_skpd.idskpd', '=', 'tr_petajab.idskpd')
                        ->where('tr_petajab.idjenjab','>',4);
                })
                ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd2'), \DB::raw('left(a_skpd.idskpd,2)'), '=', 'a_skpd2.idskpd')
                ->whereRaw($where)
                ->whereRaw('a_skpd.jab!=tr_petajab.namajabatan')
                ->orderBy('a_skpd.idskpd')
                ->get();
        break;
        /*Data pada unit kerja belum masuk ke peta jabatan*/
        case 3 :
            $title = '
                <strong><i class="fa fa-info-circle"></i> Sinkronisasi Selisih Unit Kerja!</strong>
                <br>Kebutuhan sinkronisasi meliputi perbedaan jumlah unit kerja pada master data unit kerja dengan jumlah unit kerja pada master data petajabatan.
                Solusi penambahan data unit kerja sesuai dengan master unit kerja yang belum masuk di master petajabatan.
            ';
            $rs = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd'))
                ->select(\DB::raw('left(a_skpd.idskpd, 2) as kdunit'), 'a_skpd2.skpd','a_skpd.idskpd', 'a_skpd.jab_asn', 'a_skpd.jab', 'tr_petajab.idskpd as idjab', 'tr_petajab.idjenjab', 'tr_petajab.namajabatan', \DB::raw("'' as periode_bulan, '' as periode_tahun"))
                ->leftjoin('tr_petajab', function($join){
                    $join->on('a_skpd.idskpd', '=', 'tr_petajab.idskpd')
                        ->where('tr_petajab.idjenjab','>',4);
                })
                ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd2'), \DB::raw('left(a_skpd.idskpd,2)'), '=', 'a_skpd2.idskpd')
                ->whereRaw($where)
                ->whereRaw('tr_petajab.idskpd IS NULL')
                ->orderBy('a_skpd.idskpd')
                ->get();
        break;
        /*Data petajabatan yang ngga konek dengan data unit kerja*/
        case 4 :
            $title = '
                <strong><i class="fa fa-info-circle"></i> Sinkronisasi Selisih Peta Jabatan!</strong>
                <br>Kebutuhan sinkronisasi meliputi perbedaan jumlah unit kerja pada master data petajabatan dengan jumlah unit kerja pada master data unit kerja.
                Solusi penghapusan data petajabatan yang tidak termasuk pada master unit kerja.
            ';
            $rs = \DB::table('tr_petajab')
                ->select(\DB::raw('left(tr_petajab.idskpd, 2) as kdunit'), 'a_skpd2.skpd','tr_petajab.idskpd as idjab', 'tr_petajab.idjenjab', 'tr_petajab.namajabatan','a_skpd.idskpd', 'a_skpd.jab_asn', 'a_skpd.jab','tr_petajab.periode_tahun','tr_petajab.periode_bulan')
                ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd'), function($join){
                    $join->on('tr_petajab.idskpd', '=', 'a_skpd.idskpd')
                        ->where('a_skpd.flag','=',1)
                        ->whereNotIn('a_skpd.jab_asn', ['','0','1']);
                })
                ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd2'), \DB::raw('left(tr_petajab.idskpd,2)'), '=', 'a_skpd2.idskpd')
                ->whereRaw($where2)
                ->whereRaw('a_skpd.idskpd IS NULL')
                ->orderBy('tr_petajab.idskpd')
                ->get();
        break;
        default :
            $rs = array();
        break;
    }
?>

<tr>
    <td colspan="8">{!!$title!!}</td>
</tr>
@if($rs)
    @foreach($rs as $item)
    <?php $x++; ?>
    <tr>
        <td class="text-center">{!!$x!!}</td>
        <td class="text-center">{!!$item->kdunit!!}</td>
        <td>{!!$item->skpd!!}</td>
        <td>{!!$item->idskpd!!}</td>
        <td>{!!$item->jab!!}</td>
        <td>{!!$item->idjab!!}</td>
        <td>{!!$item->namajabatan!!}</td>
        <td class="text-center"><button type="button" class="btn btn-success" id="preview" actidskpd="{!!$item->kdunit!!}" actperiodebulan="{!!$item->periode_bulan!!}" actperiodetahun="{!!$item->periode_tahun!!}"><i class="fa fa-search"></i> Preview</button></td>
    </tr>
    @endforeach
@else
<tr>
    <td colspan="8">Perubahan data tidak tersedia.</td>
</tr>
@endif