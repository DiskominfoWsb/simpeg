<?php
    $idskpd = Input::get('idskpd');
    $kdunit = substr($idskpd,0,2);
    $idpetajab = Input::get('id');
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');

    $rs = \DB::table('tr_petajab')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'), 'tr_petajab.idskpd', '=', 'skpd.idskpd')
            ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), \DB::raw('left(tr_petajab.idskpd,2)'), '=' ,'b.idskpd')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabasn as a_jabasn'), 'tr_petajab.idjenjab','=','a_jabasn.idjabasn')
            ->select(\DB::raw('tr_petajab.*, b.skpd, skpd.skpd as subskpd'),
            \DB::raw('IF(tr_petajab.idjenjab>4,tr_petajab.namajabatan,IF(tr_petajab.idjenjab=2,a_jabfung.jabfung,IF(tr_petajab.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jab'),
            \DB::raw('IF(tr_petajab.idjenjab>4,skpd.kelas_jabatan,IF(tr_petajab.idjenjab=2,a_jabfung.kelas_jabatan,IF(tr_petajab.idjenjab=3,a_jabfungum.kelas_jabatan,"-"))) as kelasjab'),
            \DB::raw('IF(tr_petajab.idjenjab>4,skpd.idtkpendid,IF(tr_petajab.idjenjab=2,a_jabfung.idtkpendid,IF(tr_petajab.idjenjab=3,a_jabfungum.idtkpendid,"-"))) as syarat_idtkpendid'),
            \DB::raw('IF(tr_petajab.idjenjab>4,skpd.idjenjurusan,IF(tr_petajab.idjenjab=2,a_jabfung.idjenjurusan,IF(tr_petajab.idjenjab=3,a_jabfungum.idjenjurusan,"-"))) as syarat_idjenjurusan'),
            \DB::raw('IF(tr_petajab.idjenjab>4,skpd.iddiklat,IF(tr_petajab.idjenjab=2,a_jabfung.iddiklat,IF(tr_petajab.idjenjab=3,a_jabfungum.iddiklat,"-"))) as syarat_iddiklat'),
        	\DB::raw('IF(tr_petajab.idjenjab>4,skpd.idrumpunpendid,IF(tr_petajab.idjenjab=2,a_jabfung.idrumpunpendid,IF(tr_petajab.idjenjab=3,a_jabfungum.idrumpunpendid,"-"))) as syarat_idrumpun'))
            ->where('periode_bulan', '=', $periode_bulan)
            ->where('periode_tahun', '=', $periode_tahun)
            ->where('tr_petajab.idskpd','=',$idskpd)
            ->where('tr_petajab.id','=',$idpetajab)
            ->first();
?>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <tr>
            <td width="35%">Unit Kerja</td>
            <td>:</td>
            <td>{!!$rs->skpd!!}</td>
        </tr>
        <tr>
            <td>Sub Unit Kerja</td>
            <td>:</td>
            <td>{!!$rs->subskpd!!}</td>
        </tr>
        <tr>
            <td>Nama Jabatan</td>
            <td>:</td>
            <td>{!!$rs->jab!!}</td>
        </tr>
        <tr>
            <td>Kelas Jabatan</td>
            <td>:</td>
            <td>{!! $rs->kelasjab !!}</td>
        </tr>
        <tr>
            <td colspan="3">Syarat Jabatan</td>
        </tr>
        <tr>
            <td style="padding-left:26px;">- Tingkat Pendidikan</td>
            <td>:</td>
            <td>{!!($rs->syarat_idtkpendid!='')? KebutuhanjabatanModel::getJenisPendidikan($rs->syarat_idtkpendid):'-'!!}</td>
            
        </tr>
        <tr>
            <td style="padding-left:26px;">- Jurusan</td>
            <td>:</td>
            <td>{!!KebutuhanjabatanModel::getJenisjurusan($rs->syarat_idrumpun,$rs->syarat_idjenjurusan)!!}</td>
        </tr>
        <tr>
            <td style="padding-left:26px;">- Diklat</td>
            <td>:</td>
            <td>{!!($rs->syarat_iddiklat!='')? KebutuhanjabatanModel::getSyaratdiklat($rs->syarat_iddiklat,$rs->idjenjab):'-'!!}</td>
        </tr>
        <tr>
            <td>Jumlah Kebutuhan Jabatan</td>
            <td>:</td>
            <td>{!!$rs->abk!!}</td>
        </tr>
        <tr>
            <td>Kebutuhan Diklat</td>
            <td>:</td>
            <td>{!!($rs->id!='')? KebutuhanjabatanModel::getKebutuhandiklat($rs->id):'-'!!}</td>
        </tr>
            
    </table>