<style>
    .warning-tabel{
        background-color: gold !important;
    }
</style>
<br>
<?php
    /*cek sudah ada petajabatan ditahun yang sama atau belum*/
    $x = 0;
    $idskpd = Input::get('idskpd');
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');
    
    $abk_fung = 0;
    $cpns_fung = 0;
    $pns_fung = 0;
    $pppk_fung = 0;
    $jml_fung = 0;
    $cpns_fung2 = 0;
    $pppk_fung2 = 0;
    $jml_fung2 = 0;
    $kur_fung = 0;
    
    $abk_pel = 0;
    $cpns_pel = 0;
    $pns_pel = 0;
    $pppk_pel = 0;
    $jml_pel = 0;
    $cpns_pel2 = 0;
    $pppk_pel2 = 0;
    $jml_pel2 = 0;
    $kur_pel = 0;

    $rs = \DB::table('tr_petajab')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'), 'tr_petajab.idskpd', '=', 'skpd.idskpd')
            ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), 'tr_petajab.idskpd', '=' ,'b.idskpd')
            // ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), \DB::raw('left(tr_petajab.idskpd,2)'), '=' ,'b.idskpd')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as a_jabfung'), 'tr_petajab.idjabfung', '=', 'a_jabfung.idjabfung')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as a_jabfungum'), 'tr_petajab.idjabfungum', '=', 'a_jabfungum.idjabfungum')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjab as a_jenjab'), 'tr_petajab.idjenjab','=','a_jenjab.idjenjab')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabasn as a_jabasn'), 'tr_petajab.idjenjab','=','a_jabasn.idjabasn')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_matkulpel as a_matkulpel'), 'tr_petajab.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tugasdokter as a_tugasdokter'), 'tr_petajab.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
            ->select(\DB::raw('tr_petajab.*, a_matkulpel.matkulpel, a_tugasdokter.tugasdokter,a_jabfung.isguru as fungisguru,a_jabfungum.isguru as pelisguru, skpd.skpd as subskpd, b.skpd as mskpd'),
            \DB::raw('IF(tr_petajab.idjenjab>4,skpd.kelas_jabatan,IF(tr_petajab.idjenjab=2,a_jabfung.kelas_jabatan,IF(tr_petajab.idjenjab=3,a_jabfungum.kelas_jabatan,"-"))) as kelasjab'),
             \DB::raw('IF(tr_petajab.idjenjab>4,skpd.idjenjurusan,IF(tr_petajab.idjenjab=2,a_jabfung.idjenjurusan,IF(tr_petajab.idjenjab=3,a_jabfungum.idjenjurusan,"-"))) as syarat_idjenjurusan'),
            \DB::raw('IF(tr_petajab.idjenjab>4,a_jabasn.jabasn,IF(tr_petajab.idjenjab=2,a_jenjab.jenjab,IF(tr_petajab.idjenjab=3,a_jenjab.jenjab,"-"))) as jenjabatan'))
            ->where('periode_bulan', '=', $periode_bulan)
            ->where('periode_tahun', '=', $periode_tahun)
            ->where('tr_petajab.idskpd','like',''.$idskpd.'%')
            ->orderBy('tr_petajab.idskpd','asc')
            ->orderBy('tr_petajab.idjabjbt','desc')
            ->orderBy('a_jabfung.kelas_jabatan','desc')
            ->orderBy('a_jabfungum.kelas_jabatan','desc')
            ->get();

    $rsbelum = \DB::table(config('global.kepegawaian').'.tb_01 as tb_01')->where('idskpd','like',''.$idskpd.'%')->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();
?>

<div align="center">
    <h4>Input Kebutuhan ASN</h4>
    <h4>
        PERIODE {!!strtoupper(formatBulan($periode_bulan)).' '.$periode_tahun!!}
    </h4>
    </div><br>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <thead class="bg-primary">
        <tr>
            <th width="3%" rowspan="2" class="text-center">No</th>
            <th rowspan="2" colspan="2" class="text-center">Jabatan</th>
            <!-- <th rowspan="2" class="text-center">Kategori</th> -->
            <th rowspan="2" class="text-center">Pendidikan</th>
            <th class="text-center">Unit Kerja</th>
            <th rowspan="2" class="text-center">ABK</th>
            <th colspan="4" class="text-center">Bezzeting</th>
            <th colspan="3" class="text-center">Usulan</th>
            <th rowspan="2" class="text-center">Kurang/Lebih</th>
        </tr>
        <tr>
            <th class="text-center">(Kasi/Kasubbag/Kabid)</th>
            {{-- <th class="text-center">OPD</th> --}}
            <th class="text-center">CPNS</th>
            <th class="text-center">PNS</th>
            <th class="text-center">PPPK</th>
            <th class="text-center">JML</th>
            <th class="text-center" width="50px">CPNS</th>
            <th class="text-center" width="50px">PPPK</th>
            <th class="text-center" width="50px">JML</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">I</td>
                <td colspan="14">Jabatan Fungsional</td>
            </tr>
        @if(count($rs) > 0)
        
        <?php 
            $index = 0;
         ?>
        
        @for($ii=0;$ii<2;$ii++)
            @if($ii==1)
                {{-- <tr style="font-weight: bold;">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Jumlah</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">{!! $abk_fung !!}</td>
                    <td class="text-center">{!! $cpns_fung !!}</td>
                    <td class="text-center">{!! $pns_fung !!}</td>
                    <td class="text-center">{!! $pppk_fung !!}</td>
                    <td class="text-center">{!! $jml_fung !!}</td>
                    <td class="text-center">{!! $cpns_fung2 !!}</td>
                    <td class="text-center">{!! $pppk_fung2 !!}</td>
                    <td class="text-center">{!! $jml_fung2 !!}</td>
                    <td class="text-center">{!! $kur_fung !!}</td>
                </tr>
                <tr><td colspan="16">&nbsp;</td></tr> --}}
                <tr>
                    <td class="text-center">II</td>
                    <td colspan="15">Jabatan Pelaksana</td>
                </tr>
            @endif

            @foreach($rs as $item)
                @if(($ii == 0 && $item->idjenjab == 2) || ($ii == 1 && $item->idjenjab == 3))
                    <?php
                    $kategori_jabatan = "-";
                    if($item->idjenjab >= 20){
                        $banyakorang = PetajabatanModel::comboExisting($item->idjenjab,$item->idskpd,$item->idjabjbt);
                    } else if($item->idjenjab == 2){
                        $banyakorang = PetajabatanModel::comboExisting($item->idjenjab,$item->idskpd,$item->idjabfung,@$item->idmatkulpel,@$item->idtugasdokter);
                        if(!is_null($item->fungisguru)){
                            $kategori_jabatan = $item->fungisguru==1?"Guru":($item->fungisguru==2?"Kesehatan":($item->fungisguru==3?"teknis":"-"));
                        }
                    } else if($item->idjenjab == 3){
                        $banyakorang = PetajabatanModel::comboExisting($item->idjenjab,$item->idskpd,$item->idjabfungum);
                        if(!is_null($item->pelisguru)){
                            $kategori_jabatan = $item->pelisguru==1?"Guru":($item->pelisguru==2?"Kesehatan":($item->pelisguru==3?"teknis":"-"));
                        }
                    } else if($item->idjenjab == 0){
                        $banyakorang = PetajabatanModel::comboExisting($item->idjenjab,$item->idskpd);
                    }


                        $x++;
                        $jml_keb = $banyakorang-$item->abk;
                        $pns[] = $banyakorang;
                        $kebutuhan[] = $item->abk;
                    ?>
                        <tr>
                            <td>&nbsp;
                                <input type="hidden" name="datas[{!! $index !!}][kdunit]" value="{!!$item->kdunit!!}">
                                <input type="hidden" name="datas[{!! $index !!}][idjenjab]" value="{!!$item->idjenjab!!}">
                                <input type="hidden" name="datas[{!! $index !!}][idjabjbt]" value="{!!$item->idjabjbt!!}">
                                <input type="hidden" name="datas[{!! $index !!}][idjabfung]" value="{!!$item->idjabfung!!}">
                                <input type="hidden" name="datas[{!! $index !!}][idjabfungum]" value="{!!$item->idjabfungum!!}">
                                <input type="hidden" name="datas[{!! $index !!}][idjabnonjob]" value="{!!$item->idjabnonjob!!}">
                                <input type="hidden" name="datas[{!! $index !!}][namajabatan]" value="{!!$item->namajabatan!!}">
                            </td>
                            <td class="text-center">{!!$x!!}</td>
                            <!-- <td>{!!strtoupper($item->jenjabatan)!!}</td> -->
                            <!-- <td>{!! $item->namajabatan !!}</td> -->
							<td>{!!KebutuhanjabatanModel::length($item->idskpd)." ".(($item->idjenjab < 0)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'').'</td><td>'.$item->namajabatan!!}
                            @if(substr($item->idjabfung,0,3) == '300')
                                {!! ' - '.@CFirst($item->matkulpel) !!}
                            @elseif(substr($item->idjabfung,0,3) == '220')
                                {!! ' - '.@CFirst($item->tugasdokter) !!}
                            @endif
			
							</td>
                            <!-- <td align="center">{!! $kategori_jabatan !!}</td> -->
                             <td class="text-center">{!! ($item->syarat_idjenjurusan!='')? KebutuhanjabatanModel::getJenisjurusan($item->syarat_idjenjurusan):'-' !!}</td>
                            <!-- <td>{!! $item->subskpd !!}</td> -->
                            <td>{!! $item->mskpd !!}</td>
                            <td class="text-center abk">{!!(($item->abk!='')?$item->abk:'0')!!}</td>
                            <td class="text-center">-</td>
                            <td class="text-center">{!! $banyakorang !!}</td>
                            <td class="text-center">-</td>
                            <td class="text-center">{!! $banyakorang !!}</td>
                            <td class="text-center"><input class="form-control hitung dt_cpns" type="text" name="datas[{!! $index !!}][cpns]"/></td>
                            <td class="text-center"><input class="form-control hitung dt_pppk" type="text" name="datas[{!! $index !!}][pppk]"/></td>
                            <td class="text-center"><input class="form-control sub_total" type="text" readonly /></td>
                            <td class="text-center kurleb">0</td>
                        </tr>
                    <?php
                        if($ii==0){
                            $abk_fung += ($item->abk=='')?0:$item->abk;
                            $cpns_fung += 0;
                            $pns_fung += $banyakorang;
                            $pppk_fung += 0;
                            $jml_fung += $banyakorang;
                            $cpns_fung2 += ($item->abk=='')?0:$item->abk;
                            $pppk_fung2 += 0;
                            $jml_fung2 += ($item->abk=='')?0:$item->abk;;
                            $kur_fung += $jml_keb;
                        }else if($ii=1){
                            $abk_pel += ($item->abk=='')?0:$item->abk;
                            $cpns_pel += 0;
                            $pns_pel += $banyakorang;
                            $pppk_pel += 0;
                            $jml_pel += $banyakorang;
                            $cpns_pel2 += ($item->abk=='')?0:$item->abk;
                            $pppk_pel2 += 0;
                            $jml_pel2 += ($item->abk=='')?0:$item->abk;;
                            $kur_pel += $jml_keb;
                        }
                    ?>
                @endif
                <?php
                    $index++;
                ?>
            @endforeach
        @endfor
            {{-- <tr style="font-weight: bold;">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Jumlah</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center">{!! $abk_pel !!}</td>
                <td class="text-center">{!! $cpns_pel !!}</td>
                <td class="text-center">{!! $pns_pel !!}</td>
                <td class="text-center">{!! $pppk_pel !!}</td>
                <td class="text-center">{!! $jml_pel !!}</td>
                <td class="text-center">{!! $cpns_pel2 !!}</td>
                <td class="text-center">{!! $pppk_pel2 !!}</td>
                <td class="text-center">{!! $jml_pel2 !!}</td>
                <td class="text-center">{!! $kur_pel !!}</td>
            </tr> --}}
            {{-- <tr><td colspan="16">&nbsp;</td></tr>
            <tr style="font-weight: bold;">
                <td class="text-center"></td>
                <td colspan="2">Total Kebutuhan</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center">{!! $abk_pel+$abk_fung !!}</td>
                <td class="text-center">{!! $cpns_pel+$cpns_fung !!}</td>
                <td class="text-center">{!! $pns_pel+$pns_fung !!}</td>
                <td class="text-center">{!! $pppk_pel+$pppk_fung !!}</td>
                <td class="text-center">{!! $jml_pel+$jml_fung !!}</td>
                <td class="text-center">{!! $cpns_pel2+$cpns_fung2 !!}</td>
                <td class="text-center">{!! $pppk_pel2+$pppk_fung2 !!}</td>
                <td class="text-center">{!! $jml_pel2+$jml_fung2 !!}</td>
                <td class="text-center">{!! $kur_pel+$kur_fung !!}</td>
            </tr> --}}
       @else 
    <tr>
        <td align="center" colspan="8"><h4>DATA TIDAK DITEMUKAN</h4></td>
    </tr>
@endif

        </tbody>
    </table>

<script type="text/javascript">
    $('.hitung').on('keyup', function(){
        var sub_total = 0;
        var tr = $(this).closest('tr');
        // if(isNaN($(this).val()) || $(this).val() <= 0){
            // notification('Jumlah harus berupa angka positif!','danger');
        // }else{
            var dt_cpns = tr.find('input.dt_cpns').val();
            var dt_pppk = tr.find('input.dt_pppk').val();
            
            dt_cpns= (isNaN(dt_cpns) || dt_cpns <= 0)?0:dt_cpns;
            dt_pppk= (isNaN(dt_pppk) || dt_pppk <= 0)?0:dt_pppk;
            
            sub_total = parseInt(dt_cpns)+parseInt(dt_pppk);
        // }

        var abk = tr.find('td.abk').html();
        abk = parseInt((isNaN(abk) || abk <= 0)?0:abk);
        if (sub_total-abk>0){
            $(this).parents('tr').addClass('warning-tabel');
        }else{
            $(this).parents('tr').removeClass('warning-tabel');
        }
        tr.find('input.sub_total').val(sub_total);
        tr.find('td.kurleb').html(sub_total-abk)
    });

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
                url : '{!!url('')!!}/eformasi/petajabatan/data/tambahdiklat',
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

            claravel_modal('Detail Peta Jabatan','Loading...','modal_notif2');
            $.ajax({
                type: 'post',
                url : '{!!url('')!!}/eformasi/petajabatan/data/detailpetajabatan',
                data: {'id': id, 'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun, 'idjabjbt': idjabjbt, 'idjabfung': idjabfung, 'idjabfungum': idjabfungum, 'idjenjab': idjenjab, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#modal_notif2 .modal-body').html(html);
                }
            });
        })

        $('.pemangkujabatan').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('actid');
            var idskpd = $(this).attr('actidskpd');
            var periode_bulan = $(this).attr('actperiodebulan');
            var periode_tahun = $(this).attr('actperiodetahun');
            var idjenjab = $(this).attr('actidjenjab');
            var idjabjbt = $(this).attr('actidjabjbt');
            var idjabfung = $(this).attr('actidjabfung');
            var idjabfungum = $(this).attr('actidjabfungum');
            var idmatkulpel = $(this).attr('actidmatkulpel');
            var idtugasdokter = $(this).attr('actidtugasdokter');

            claravel_modal('Daftar Pemangku Jabatan','Loading...','modal_notif');
            $.ajax({
                type: 'post',
                url : '{!!url('')!!}/eformasi/petajabatan/data/pemangkujabatan',
                data: {'id': id, 'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun, 'idjabjbt': idjabjbt, 'idjabfung': idjabfung, 'idjabfungum': idjabfungum, 'idjenjab': idjenjab, 'idmatkulpel': idmatkulpel, 'idtugasdokter': idtugasdokter, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#modal_notif .modal-body').html(html);
                }
            });
        })

        $('.pemangkujabatanopd').on('click', function(e){
            e.preventDefault();
            var idskpd = $(this).attr('actidskpd');
            var periode_bulan = $(this).attr('actperiodebulan');
            var periode_tahun = $(this).attr('actperiodetahun');

            claravel_modal('Daftar Pemangku Jabatan','Loading...','modal_notif');
            $.ajax({
                type: 'post',
                url : '{!!url('')!!}/eformasi/petajabatan/data/pemangkujabatanopd',
                data: {'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#modal_notif .modal-body').html(html);
                }
            });
        })

        $('.kebutuhanpemangkujabatan').on('click', function(e){
            e.preventDefault();
            var idskpd = $(this).attr('actidskpd');
            var periode_bulan = $(this).attr('actperiodebulan');
            var periode_tahun = $(this).attr('actperiodetahun');

            claravel_modal('Daftar Pemangku Belum Masuk Peta Jabatan','Loading...','modal_notif');
            $.ajax({
                type: 'post',
                url : '{!!url('')!!}/eformasi/petajabatan/data/kebutuhanpemangkujabatan',
                data: {'idskpd': idskpd, 'periode_bulan': periode_bulan,'periode_tahun': periode_tahun, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#modal_notif .modal-body').html(html);
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
                url : '{!!url('')!!}/eformasi/petajabatan/data/tambahjabatan',
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
                url : '{!!url('')!!}/eformasi/petajabatan/data/tambahjabatanfungsional',
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
                        url : '{!!url('')!!}/eformasi/petajabatan/delete',
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
    });

    $('#simpan').on('click', function(){
        $.ajax({
            type: 'post',
            url : '{!!url("eformasi/inputkebutuhancpnsdanpppk/simpan")!!}',
            data : $('#form-inputcpns').serialize(),
            success:function(response){
                if (response == 1) {
                    notification('sukses');
                }else{
                    notification('Gagal Simpan','error');
                }
            }
        });
    });


</script>