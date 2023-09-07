<?php

namespace App\Http\Controllers;

use View, Validator, Input, Session, Redirect, Auth;

class NotifikasiController extends Controller {

    public function getIndex() {
        $where = "a_skpd.flag = 1 and a_skpd.jab_asn NOT IN ('', 0, 1)";
        $where2 = "tr_petajab.id != '' and tr_petajab.idjenjab > 4";
        if(session('role_id') == '4'){
            $where.= " and a_skpd.idskpd like \"".session('idskpd')."%\" ";
            $where2.= " and tr_petajab.idskpd like \"".session('idskpd')."%\" ";
        }

        $rs['cperubahan'] = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd'))
                            ->select('a_skpd.idskpd', 'a_skpd.jab_asn', 'a_skpd.jab', 'tr_petajab.idskpd', 'tr_petajab.idjenjab', 'tr_petajab.namajabatan')
                            ->leftjoin('tr_petajab', function($join){
                                $join->on('a_skpd.idskpd', '=', 'tr_petajab.idskpd')
                                ->where('tr_petajab.idjenjab','>',4);
                            })
                            ->whereRaw($where)
                            ->whereRaw('a_skpd.jab!=tr_petajab.namajabatan')
                            ->count();
        $rs['cselisih']  = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd'))
                            ->select('a_skpd.idskpd', 'a_skpd.jab_asn', 'a_skpd.jab', 'tr_petajab.idskpd', 'tr_petajab.idjenjab', 'tr_petajab.namajabatan')
                            ->leftjoin('tr_petajab', function($join){
                                $join->on('a_skpd.idskpd', '=', 'tr_petajab.idskpd')
                                ->where('tr_petajab.idjenjab','>',4);
                            })
                            ->whereRaw($where)
                            ->whereRaw('tr_petajab.idskpd IS NULL')
                            ->count();

        $rs['clebih']  = \DB::table('tr_petajab')
                            ->select('tr_petajab.idskpd', 'tr_petajab.idjenjab', 'tr_petajab.namajabatan','a_skpd.idskpd', 'a_skpd.jab_asn', 'a_skpd.jab')
                            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd'), function($join){
                                $join->on('tr_petajab.idskpd', '=', 'a_skpd.idskpd')
                                    ->where('a_skpd.flag','=',1)
                                    ->whereNotIn('a_skpd.jab_asn', ['','0','1']);
                            })
                            ->whereRaw($where2)
                            ->whereRaw('a_skpd.idskpd IS NULL')
                            ->count();

        if(array_sum($rs)){
            $rs['cperubahan'] = $rs['cperubahan'];
            $rs['cselisih'] = $rs['cselisih'];
            $rs['clebih'] = $rs['clebih'];
            $rs['vnotifikasi'] = $rs['cperubahan'] + $rs['cselisih'] + $rs['clebih'];
            $rs['vperubahan'] = $rs['vnotifikasi'];
        }else{
            $rs['cperubahan'] = 0;
            $rs['cselisih'] = 0;
            $rs['clebih'] = 0;
            $rs['vnotifikasi'] = 0;
            $rs['vperubahan'] = 0;
        }

        echo json_encode($rs);
    }
}
