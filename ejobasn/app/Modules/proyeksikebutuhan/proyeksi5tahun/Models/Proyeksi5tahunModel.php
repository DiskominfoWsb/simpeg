<?php namespace App\Modules\proyeksikebutuhan\proyeksi5tahun\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * Proyeksi5tahun Model
 * @var Proyeksi5tahun
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class Proyeksi5tahunModel extends Model {
    protected $guarded = array();

    protected $table = "tr_petajab";

    public static $rules = array(
        'periode_bulan' => 'required',
        'periode_tahun' => 'required',
        'kdunit' => 'required',
        'idskpd' => 'required',
        'idjenjab' => 'required',
        'idjabjbt' => 'required',

    );

    public static function all($columns = array('*')){
        $instance = new static;
        if (\PermissionsLibrary::hasPermission('mod-proyeksi5tahun-listall')){
            return \DB::table('tr_petajab as a')
                ->select(\DB::raw("
                    a.idskpd, a.namajabatan, b.skpd, a.idjenjab, a.idjabjbt, a.idjabfung, a.idjabfungum,
                    IF(a.idjenjab>4, b.kelas_jabatan, IF(a.idjenjab=2, f.kelas_jabatan, IF(a.idjenjab=3, g.kelas_jabatan, '-'))) AS kelas_jabatan,
                    IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-'))) AS idjabatan,
                    SUM(IF(a.idjenjab > 4 AND a.idjabjbt = c.idjabatan,1,0)) AS struktural,
                    SUM(IF(a.idjenjab = 2 AND a.idjabfung = c.idjabatan AND a.idskpd = c.idskpd,1,0)) AS fungsional,
                    SUM(IF(a.idjenjab = 3 AND a.idjabfungum = c.idjabatan AND a.idskpd = c.idskpd ,1,0)) AS pelaksana,
                    (SUM(IF(a.idjenjab > 4 AND a.idjabjbt = c.idjabatan,1,0)) + SUM(IF(a.idjenjab = 2 AND a.idjabfung = c.idjabatan AND a.idskpd = c.idskpd,1,0)) + SUM(IF(a.idjenjab = 3 AND a.idjabfungum = c.idjabatan AND a.idskpd = c.idskpd ,1,0))) AS jumlahreal,
                    IF(a.idjenjab > 4 AND a.idjabjbt = b.idskpd,a.abk,0) AS akstruktural,
                    IF(a.idjenjab = 2 AND a.idjabfung = f.idjabfung AND a.idskpd = b.idskpd,a.abk,0) AS akfungsional,
                    IF(a.idjenjab = 3 AND a.idjabfungum = g.idjabfungum AND a.idskpd = b.idskpd,a.abk,0) AS akpelaksana,
                    (IF(a.idjenjab > 4 AND a.idjabjbt = b.idskpd,a.abk,0) + IF(a.idjenjab = 2 AND a.idjabfung = f.idjabfung AND a.idskpd = b.idskpd,a.abk,0) + IF(a.idjenjab = 3 AND a.idjabfungum = g.idjabfungum AND a.idskpd = b.idskpd,a.abk,0)) AS jumlahak,
                    SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW()),1,0)) AS pensiun1,
                    SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW())+1,1,0)) AS pensiun2,
                    SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW())+2,1,0)) AS pensiun3,
                    SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW())+3,1,0)) AS pensiun4,
                    SUM(IF((IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, '-')))) = c.idjabatan AND a.idskpd = c.idskpd AND YEAR(c.pensiunnext)=YEAR(NOW())+4,1,0)) AS pensiun5
                "))
                ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), 'a.idskpd', '=', 'b.idskpd')
                ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as f'), 'a.idjabfung', '=', 'f.idjabfung')
                ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as g'), 'a.idjabfungum', '=', 'g.idjabfungum')
                ->leftjoin(\DB::Raw(config('global.kepegawaian').'.v_pegawai c'), function($join){
                    //$join->on('idjabatan', '=', 'c.idjabatan')
                    //->where('a.idskpd', '=', 'c.idskpd');
                    $join->on(\DB::raw('(IF(a.idjenjab>4, a.idjabjbt, IF(a.idjenjab=2, a.idjabfung, IF(a.idjenjab=3, a.idjabfungum, "-"))))'), '=', 'c.idjabatan')
                    //->where(\DB::raw('left(c.idskpd,2)'), '=', '25');
                        ->where('c.idskpd', 'like', '25%');
                })
                ->whereRaw("a.idskpd LIKE '25%'")
            //->orderBy('a.idskpd')->orderBy('a.idjabfung')->orderBy('a.idjabfungum')
                ->orderBy('a.idskpd','asc')
                ->orderBy('a.idjabjbt','desc')
                ->orderBy('f.kelas_jabatan','desc')
                ->orderBy('g.kelas_jabatan','desc')
                ->groupBy('a.idskpd')->groupBy('a.idjabfung')->groupBy('a.idjabfungum')
                ->get();
        }else{
            return $instance->newQuery()
                ->where('role_id', \Session::get('role_id'))
                ->paginate($_ENV['configurations']['list-limit']);

        }
    }

}
