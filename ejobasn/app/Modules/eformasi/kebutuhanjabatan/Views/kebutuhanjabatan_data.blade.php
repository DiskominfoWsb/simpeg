<?php
    $x = 0;
    $idskpd = Input::get('idskpd');
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');

    $rs = \App\Models\Petajab::kebutuhanJabatan($idskpd, $periode_bulan, $periode_tahun);
?>

@if(count($rs) > 0)
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <thead class="bg-primary">
        <tr>
            <th width="3%" class="text-center">No</th>
            <!-- <th class="text-center">Jenis Jabatan</th> -->
            <th class="text-center">Jabatan</th>
            <th class="text-center">Kelas Jabatan</th>
            <th class="text-center">Pendidikan</th>
            <th class="text-center">Jurusan</th>
            <th class="text-center" width="7%">Jumlah ABK</th>
            <th class="text-center" width="13%">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rs as $item)
        <?php $x++;?>
        <tr>
            <td  class="text-center">{!!$x!!}</td>
            <!-- <td>{!!$item->jenjabatan!!}</td> -->
            <td>
                <input type="hidden" name="{!!$x!!}[periode_bulan]" value="{!!$item->periode_bulan!!}">
                <input type="hidden" name="{!!$x!!}[periode_tahun]" value="{!!$item->periode_tahun!!}">
                <input type="hidden" name="{!!$x!!}[kdunit]" value="{!!$item->kdunit!!}">
                <input type="hidden" name="{!!$x!!}[idskpd]" value="{!!$item->idskpd!!}">
                <input type="hidden" name="{!!$x!!}[idjenjab]" value="{!!$item->idjenjab!!}">
                <input type="hidden" name="{!!$x!!}[idjabjbt]" value="{!!$item->idjabjbt!!}">
                <input type="hidden" name="{!!$x!!}[idjabfung]" value="{!!$item->idjabfung!!}">
                <input type="hidden" name="{!!$x!!}[idjabfungum]" value="{!!$item->idjabfungum!!}">
                <input type="hidden" name="{!!$x!!}[idjabnonjob]" value="{!!$item->idjabnonjob!!}">
                <input type="hidden" name="{!!$x!!}[namajabatan]" value="{!!$item->namajabatan!!}">
                @if(substr($item->idjabfung,0,3) == '300')
                <input type="hidden" name="{!!$x!!}[idmatkulpel]" value="{!!$item->idmatkulpel!!}">
                @elseif(substr($item->idjabfung,0,3) == '220')
                <input type="hidden" name="{!!$x!!}[idtugasdokter]" value="{!!$item->idtugasdokter!!}">
                @endif
                <input type="hidden" name="{!!$x!!}[idtkpendid]" value="{!!$item->idtkpendid!!}">
                <input type="hidden" name="{!!$x!!}[idjenjurusan]" value="{!!$item->idjenjurusan!!}">
                
                @if($item->idjenjab == 0)
                    <table>
                        <tr><td>{!!KebutuhanjabatanModel::length($item->idskpd)." ".(($item->idjenjab < 0)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'').'</td><td>'.$item->namajabatan!!}
                            @if(substr($item->idjabfung,0,3) == '300')
                                {!! ' - '.@CFirst($item->matkulpel) !!}
                            @elseif(substr($item->idjabfung,0,3) == '220')
                                {!! ' - '.@CFirst($item->tugasdokter) !!}
                            @endif
                        </td></tr>
                    </table>
                @else
                    <table>
                        <tr><td>{!!KebutuhanjabatanModel::length($item->idskpd)." ".(($item->idjenjab < 20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'').'</td><td>'.$item->namajabatan!!}
                            @if(substr($item->idjabfung,0,3) == '300') 
                                <!-- guru -->
                                {!! ' - '.@CFirst($item->matkulpel) !!}
                            @elseif(substr($item->idjabfung,0,3) == '220')
                                <!-- dokter -->
                                {!! ' - '.@CFirst($item->tugasdokter) !!}
                            @endif
                        </td></tr>
                    </table>
                @endif
            </td>
            <td>{!! $item->kelasjab !!}</td>
            <td>{!!($item->idtkpendidjab!='')? KebutuhanjabatanModel::getJenisPendidikan($item->idtkpendidjab):'-'!!}</td>
            <td>{!!KebutuhanjabatanModel::getJenisjurusan($item->idrumpunpendidjab,$item->idjenjurusanjab)!!}</td>
            <td>
                <input class="form-control abk-edit text-center" recid="{!! $item->id !!}" align="right" type="text" name="{!!$x!!}[abk]" value="{!!$item->abk!!}">
            </td>
            <td class="text-center">
                @if($item->idjenjab == 0 || $item->idjenjab > 4)
                <a href="javascript:void(0)" class="btn btn-primary add-jabatan-pelaksana" title="Tambah Jabatan" actidskpd="{!!$item->idskpd!!}" actperiodebulan="{!!$item->periode_bulan!!}" actperiodetahun="{!!$item->periode_tahun!!}"><i class="glyphicon glyphicon-plus-sign"></i></a>
                @elseif($item->idjenjab <= 4)
                <a href="javascript:void(0)" class="btn btn-danger del-jabatan" title="Hapus Jabatan" actidskpd="{!!$item->idskpd!!}" actperiodebulan="{!!$item->periode_bulan!!}" actperiodetahun="{!!$item->periode_tahun!!}" actid="{!!$item->id!!}"><i class="fa fa-trash"></i></a>
                @endif
                <a href="javascript:void(0)" class="btn btn-warning add-diklat" title="Tambah Diklat" actid="{!!$item->id!!}" actidskpd="{!!$item->idskpd!!}" actperiodebulan="{!!$item->periode_bulan!!}" actperiodetahun="{!!$item->periode_tahun!!}" actidjabjbt="{!!$item->idjabjbt!!}" actidjabfung="{!!$item->idjabfung!!}" actidjabfungum="{!!$item->idjabfungum!!}" actidjenjab="{!!$item->idjenjab!!}"><span class="fa fa-pencil"></span></a>
                <a href="javascript:void(0)" class="btn btn-info detail" title="Lihat Detail" actid="{!!$item->id!!}" actidskpd="{!!$item->idskpd!!}" actperiodebulan="{!!$item->periode_bulan!!}" actperiodetahun="{!!$item->periode_tahun!!}" actidjabjbt="{!!$item->idjabjbt!!}" actidjabfung="{!!$item->idjabfung!!}" actidjabfungum="{!!$item->idjabfungum!!}" actidjenjab="{!!$item->idjenjab!!}"><span class="fa fa-info"></span></a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <?php
        /*kondisi default*/
        $where = "a_skpd.flag = 1 and a_skpd.jab_asn NOT IN ('', 0, 1)";
        $where2 = "tr_petajab.id != '' and tr_petajab.idjenjab > 4";

        $where.= " and a_skpd.idskpd like \"".$idskpd."%\" ";
        $where2.= " and tr_petajab.idskpd like \"".$idskpd."%\" ";


        /*Perbedaan nama jabatan anatara petajabatan dan unitkerja*/
        $rsper2 = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd'))
            ->select(\DB::raw('left(a_skpd.idskpd, 2) as kdunit, a_skpd.idskpd as idskpdunit'), 'a_skpd2.skpd','a_skpd.idskpd', 'a_skpd.jab_asn', 'a_skpd.jab', 'tr_petajab.idskpd as idjab', 'tr_petajab.idjenjab', 'tr_petajab.namajabatan','tr_petajab.periode_tahun','tr_petajab.periode_bulan')
            ->leftjoin('tr_petajab', function($join){
                $join->on('a_skpd.idskpd', '=', 'tr_petajab.idskpd')
                    ->where('tr_petajab.idjenjab','>',4);
            })
            ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd2'), \DB::raw('left(a_skpd.idskpd,2)'), '=', 'a_skpd2.idskpd')
            ->whereRaw($where)
            ->whereRaw('a_skpd.jab!=tr_petajab.namajabatan')
            ->orderBy('a_skpd.idskpd')
            ->get();

        /*Data pada unit kerja belum masuk ke peta jabatan*/
        $rsper3 = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd'))
            ->select(\DB::raw('left(a_skpd.idskpd, 2) as kdunit, a_skpd.idskpd as idskpdunit'), 'a_skpd2.skpd','a_skpd.idskpd', 'a_skpd.jab_asn', 'a_skpd.jab', 'tr_petajab.idskpd as idjab', 'tr_petajab.idjenjab', 'tr_petajab.namajabatan', \DB::raw("'' as periode_bulan, '' as periode_tahun"))
            ->leftjoin('tr_petajab', function($join){
                $join->on('a_skpd.idskpd', '=', 'tr_petajab.idskpd')
                    ->where('tr_petajab.idjenjab','>',4);
            })
            ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as a_skpd2'), \DB::raw('left(a_skpd.idskpd,2)'), '=', 'a_skpd2.idskpd')
            ->whereRaw($where)
            ->whereRaw('tr_petajab.idskpd IS NULL')
            ->orderBy('a_skpd.idskpd')
            ->get();

        /*Data petajabatan yang ngga konek dengan data unit kerja*/
        $rsper4 = \DB::table('tr_petajab')
            ->select(\DB::raw('left(tr_petajab.idskpd, 2) as kdunit, tr_petajab.idskpd as idskpdunit'), 'a_skpd2.skpd','tr_petajab.idskpd as idjab', 'tr_petajab.idjenjab', 'tr_petajab.namajabatan','a_skpd.idskpd', 'a_skpd.jab_asn', 'a_skpd.jab','tr_petajab.periode_tahun','tr_petajab.periode_bulan')
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
    ?>

    @if($rsper2)
    <div class="callout callout-warning" role="alert">
        <strong>Sinkronisasi Perbedaan Unit Kerja!</strong>
        <br>Kebutuhan sinkronisasi meliputi perbedaan nama jabatan pada master data unit kerja dengan nama jabatan pada master data petajabatan.
        <br>Solusi update data petajabatan sesuai dengan master unit kerja.
    </div>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" rowspan="2" width="3%">No</th>
                <th class="text-center" rowspan="2">Kode OPD</th>
                <th class="text-center" rowspan="2">Unit Kerja</th>
                <th class="text-center" colspan="2">Data Unit Kerja</th>
                <th class="text-center" colspan="2">Data Peta Jabatan</th>
                <th class="text-center" rowspan="2" width="7%">Act.</th>
            </tr>
            <tr>
                <th class="text-center">Kode Jabatan</th>
                <th class="text-center">Nama Jabatan</th>
                <th class="text-center">Kode Jabatan</th>
                <th class="text-center">Nama Jabatan</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 0;?>
            @foreach($rsper2 as $item)
            <?php $x++;?>
            <tr>
                <td class="text-center">{!!$x!!}</td>
                <td class="text-center">{!!$item->kdunit!!}</td>
                <td>{!!$item->skpd!!}</td>
                <td>{!!$item->idskpd!!}</td>
                <td>{!!$item->jab!!}</td>
                <td>{!!$item->idjab!!}</td>
                <td>{!!$item->namajabatan!!}</td>
                <td class="text-center">
                    <a href="javascript:void(0)" class="btn btn-warning sinkjabatan" title="Tambah Jabatan" act="2" actidskpd="{!!$item->idskpdunit!!}" actperiodebulan="{!!$periode_bulan!!}" actperiodetahun="{!!$periode_tahun!!}"><i class="fa fa-pencil-square-o"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($rsper3)
    <div class="callout callout-warning" role="alert">
        <strong>Sinkronisasi Selisih Unit Kerja!</strong>
        <br>Kebutuhan sinkronisasi meliputi perbedaan jumlah unit kerja pada master data unit kerja dengan jumlah unit kerja pada master data petajabatan.
        <br>Solusi penambahan data unit kerja sesuai dengan master unit kerja yang belum masuk di master petajabatan.
    </div>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" rowspan="2" width="3%">No</th>
                <th class="text-center" rowspan="2">Kode OPD</th>
                <th class="text-center" rowspan="2">Unit Kerja</th>
                <th class="text-center" colspan="2">Data Unit Kerja</th>
                <th class="text-center" colspan="2">Data Peta Jabatan</th>
                <th class="text-center" rowspan="2" width="7%">Act.</th>
            </tr>
            <tr>
                <th class="text-center">Kode Jabatan</th>
                <th class="text-center">Nama Jabatan</th>
                <th class="text-center">Kode Jabatan</th>
                <th class="text-center">Nama Jabatan</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 0;?>
            @foreach($rsper3 as $item)
            <?php $x++;?>
            <tr>
                <td class="text-center">{!!$x!!}</td>
                <td class="text-center">{!!$item->kdunit!!}</td>
                <td>{!!$item->skpd!!}</td>
                <td>{!!$item->idskpd!!}</td>
                <td>{!!$item->jab!!}</td>
                <td>{!!$item->idjab!!}</td>
                <td>{!!$item->namajabatan!!}</td>
                <td class="text-center">
                    <a href="javascript:void(0)" class="btn btn-success sinkjabatan" title="Hapus Jabatan" act="3" actidskpd="{!!$item->idskpdunit!!}" actperiodebulan="{!!$periode_bulan!!}" actperiodetahun="{!!$periode_tahun!!}"><i class="fa fa-plus-circle"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($rsper4)
    <div class="callout callout-warning" role="alert">
        <strong>Sinkronisasi Selisih Peta Jabatan!</strong>
        <br>Kebutuhan sinkronisasi meliputi perbedaan jumlah unit kerja pada master data petajabatan dengan jumlah unit kerja pada master data unit kerja.
        <br>Solusi penghapusan data petajabatan yang tidak termasuk pada master unit kerja.
    </div>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" rowspan="2" width="3%">No</th>
                <th class="text-center" rowspan="2">Kode OPD</th>
                <th class="text-center" rowspan="2">Unit Kerja</th>
                <th class="text-center" colspan="2">Data Unit Kerja</th>
                <th class="text-center" colspan="2">Data Peta Jabatan</th>
                <th class="text-center" rowspan="2" width="7%">Act.</th>
            </tr>
            <tr>
                <th class="text-center">Kode Jabatan</th>
                <th class="text-center">Nama Jabatan</th>
                <th class="text-center">Kode Jabatan</th>
                <th class="text-center">Nama Jabatan</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 0;?>
            @foreach($rsper4 as $item)
            <?php $x++;?>
            <tr>
                <td class="text-center">{!!$x!!}</td>
                <td class="text-center">{!!$item->kdunit!!}</td>
                <td>{!!$item->skpd!!}</td>
                <td>{!!$item->idskpd!!}</td>
                <td>{!!$item->jab!!}</td>
                <td>{!!$item->idjab!!}</td>
                <td>{!!$item->namajabatan!!}</td>
                <td class="text-center">
                    <a href="javascript:void(0)" class="btn btn-danger sinkjabatan" title="Hapus Jabatan" act="4" actidskpd="{!!$item->idskpdunit!!}" actperiodebulan="{!!$periode_bulan!!}" actperiodetahun="{!!$periode_tahun!!}"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
@else
    <h4><b>Perhatian!</b>Kebutuhan jabatan struktural gagal diproses, Mohon klik tombol lihat jabatan struktural sekali lagi. <br> Atau cek ketersediaan jabatan struktural yang sudah dibuat di menu struktur organisasi.</h4>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('.add-diklat').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('actid');
            var idskpd = $(this).attr('actidskpd');
            var periode_bulan = $(this).attr('actperiodebulan');
            var periode_tahun = $(this).attr('actperiodetahun');
            var idjenjab = $(this).attr('actidjenjab');
            var idjabjbt = $(this).attr('actidjabjbt');
            var idjabfung = $(this).attr('actidjabfung');
            var idjabfungum = $(this).attr('actidjabfungum');

            claravel_modal('Tambah Diklat','Loading...','modal_notif2');
            $.ajax({
                type: 'post',
                url : '{!!url('')!!}/eformasi/kebutuhanjabatan/data/tambahdiklat',
                data: {'id': id, 'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun, 'idjabjbt': idjabjbt, 'idjabfung': idjabfung, 'idjabfungum': idjabfungum, 'idjenjab': idjenjab, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#modal_notif2 .modal-body').html(html);
                }
            });
        })

        $('.detail').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('actid');
            var idskpd = $(this).attr('actidskpd');
            var periode_bulan = $(this).attr('actperiodebulan');
            var periode_tahun = $(this).attr('actperiodetahun');
            var idjenjab = $(this).attr('actidjenjab');
            var idjabjbt = $(this).attr('actidjabjbt');
            var idjabfung = $(this).attr('actidjabfung');
            var idjabfungum = $(this).attr('actidjabfungum');

            claravel_modal('Detail Kebutuhan Jabatan','Loading...','modal_notif2');
            $.ajax({
                type: 'post',
                url : '{!!url('')!!}/eformasi/kebutuhanjabatan/data/detailkebutuhanjabatan',
                data: {'id': id, 'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun, 'idjabjbt': idjabjbt, 'idjabfung': idjabfung, 'idjabfungum': idjabfungum, 'idjenjab': idjenjab, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#modal_notif2 .modal-body').html(html);
                }
            });
        })

        $('.add-jabatan-pelaksana').on('click', function(e){
            e.preventDefault();
            var idskpd = $(this).attr('actidskpd');
            var periode_bulan = $(this).attr('actperiodebulan');
            var periode_tahun = $(this).attr('actperiodetahun');

            claravel_modal('Tambah Jabatan Pelaksana','Loading...','modal_notif2');
            $.ajax({
                type: 'post',
                url : '{!!url('')!!}/eformasi/kebutuhanjabatan/data/tambahjabatan',
                data: {'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun,  '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#modal_notif2 .modal-body').html(html);
                }
            });
        })

        $('.add-jabatan-fungsional').on('click', function(e){
            e.preventDefault();
            var idskpd = $(this).attr('actidskpd');
            var periode_bulan = $(this).attr('actperiodebulan');
            var periode_tahun = $(this).attr('actperiodetahun');

            claravel_modal('Tambah Jabatan Fungsional','Loading...','modal_notif2');
            $.ajax({
                type: 'post',
                url : '{!!url('')!!}/eformasi/kebutuhanjabatan/data/tambahjabatanfungsional',
                data: {'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun,  '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#modal_notif2 .modal-body').html(html);
                }
            });
        })

        $('.del-jabatan').on('click', function(e){
            e.preventDefault();
            var $this =$(this);
            var id = $this.attr('actid');
            var idskpd = $this.attr('actidskpd');
            var periode_bulan = $(this).attr('actperiodebulan');
            var periode_tahun = $(this).attr('actperiodetahun');

            bootbox.confirm('Hapus Jabatan ?',function(a){
                if(a == true){
                    $.ajax({
                        type: 'post',
                        url : '{!!url('')!!}/eformasi/kebutuhanjabatan/delete',
                        data: {'id': id, 'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun,  '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='9'){
                                notification('Berhasil Dihapus','success');
                                $this.closest('tr').fadeOut(300,function(){
                                    $(this).remove();
                                });
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        })

        $('a.sinkjabatan').on('click', function(e){
            e.preventDefault();
            var $this =$(this);
            var id = $this.attr('act');
            var idskpd = $this.attr('actidskpd');
            var periode_bulan = $(this).attr('actperiodebulan');
            var periode_tahun = $(this).attr('actperiodetahun');

            if(id == 2){
                var alert = 'Sinkronisasi Perbedaan Unit Kerja ?';
            }else if(id == 3){
                var alert = 'Sinkronisasi Selisih Unit Kerja ?';
            }else if(id == 4){
                var alert = 'Sinkronisasi Selisih Petajabatan ?';
            }

            bootbox.confirm(alert,function(a){
                if(a == true){
                    $.ajax({
                        type: 'post',
                        url : '{!!url('')!!}/eformasi/kebutuhanjabatan/sinkronisasi',
                        data: {'id': id, 'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun,  '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='4'){
                                notification('Berhasil Sinkronisasi','success');
                                getKebutuhanjabatan();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        })
    });

    $('#tabel').on('change','.abk-edit',function(){
            var id = $(this).attr('recid');
            var abk = $(this).val();

            bootbox.confirm("Simpan Perubahan ABK?",function(a){
                if(a == true){
                    $.ajax({
                        type: 'post',
                        url : '{!!url('')!!}/eformasi/kebutuhanjabatan/updateabk',
                        data: {'id': id, 'abk': abk, '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html.status=='success'){
                                notification(html.pesan,'success');
                            }else{
                                notification(html.pesan,'danger');
                            }
                        }
                    });
                }else{
                    $(this).focus();
                }
            });
        });
</script>