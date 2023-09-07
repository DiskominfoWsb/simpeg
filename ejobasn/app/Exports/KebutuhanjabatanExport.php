<?php

namespace App\Exports;

use App\Modules\eformasi\kebutuhanjabatan\Models\KebutuhanjabatanModel;
use Illuminate\Contracts\View\View;
use DB;
use Maatwebsite\Excel\Concerns\FromView;


class KebutuhanjabatanExport implements FromView
{
    public function view(): View
    {
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
            ->get();;
        return view('kebutuhanjabatan::excel',['kebutuhanjabatan' => $kebutuhanjabatan]);
    }
}
