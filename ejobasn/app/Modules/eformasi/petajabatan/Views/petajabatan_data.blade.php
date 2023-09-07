<?php
    /*cek sudah ada petajabatan ditahun yang sama atau belum*/
    $total_pns = 0;
    $total_abk = 0;
    $x = 0;
    $pns = [];
    $kebutuhan = [];
    $kelasjab = [];
    $idskpd = Input::get('idskpd');
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');

    $rs = \App\Models\Petajab::petaJabatan($idskpd, $periode_bulan, $periode_tahun);

    $rsbelum = \DB::table(config('global.kepegawaian').'.tb_01 as tb_01')
        ->where('idskpd','like',''.$idskpd.'%')
        ->where('idjenkedudupeg', '!=', 99)
        ->where('idjenkedudupeg', '!=', 21)
        //->where('iskepsek','!=',1)
        ->count();
?>

<br><div align="center">
    <h4>PETA JABATAN</h4>
    <h4>
        {!!((Input::get('idskpd') != '')?strtoupper(getSkpd(Input::get('idskpd'))):'')!!}
    </h4>
    <h4>
        PERIODE {!!strtoupper(formatBulan($periode_bulan)).' '.$periode_tahun!!}
    </h4>
    </div><br>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <thead class="bg-primary">
        <tr>
            <th width="3%" class="text-center">No</th>
            <!-- <th class="text-center">Jenis Jabatan</th> -->
            <th class="text-center">Jabatan</th>
            <th class="text-center">Kelas Jabatan</th>
            <th class="text-center">Riil</th>
            <th class="text-center">Kebutuhan/ABK</th>
            <th class="text-center">Kurang/Lebih</th>
            <th class="text-center">Status</th>
        </tr>
        </thead>
        <tbody>
    @if(count($rs) > 0)
        @foreach($rs as $item)
        <?php
            $x++;
            $banyakorang = (int) @\App\Models\Petajab::banyakOrang($item->id)->banyakorang;
            $jml_keb = $banyakorang-$item->abk;
            $pns[] = $banyakorang;
            $kebutuhan[] = $item->abk;
            $kelasjab[] = $item->kelasjab;
        ?>
        <tr>
            <td class="text-center">{!!$x!!}</td>
            <!-- <td>{!!strtoupper($item->jenjabatan)!!}</td> -->
            <td>
                @if($item->idjenjab == 0)

                    <table>
                        <tr><td>{!!PetajabatanModel::length($item->idskpd)." ".(($item->idjenjab < 0)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'').'</td><td rowspan="2">'.PetajabatanModel::warnajabatan($item->idjenjab).'</td><td style="padding-left: 5px;">'.$item->namajabatan!!}
                            @if(substr($item->idjabfung,0,3) == '300') 
                                {{-- if guru --}}
                                {!! ' - '.@CFirst($item->matkulpel) !!}
                            @elseif(substr($item->idjabfung,0,3) == '220')
                                {!! ' - '.@CFirst($item->tugasdokter) !!}
                            @endif
                        </td></tr>
                    </table>
                @else
                    <table>
                        <tr><td>{!!KebutuhanjabatanModel::length($item->idskpd)." ".(($item->idjenjab < 20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'').'</td><td rowspan="2">'.PetajabatanModel::warnajabatan($item->idjenjab).'</td><td style="padding-left: 5px;">'.$item->namajabatan!!}
                            @if(substr($item->idjabfung,0,3) == '300') 
                                {{-- if guru --}}
                                {!! ' - '.@CFirst($item->matkulpel) !!}
                            @elseif(substr($item->idjabfung,0,3) == '220')
                                {!! ' - '.@CFirst($item->tugasdokter) !!}
                            @endif
                        </td></tr>
                    </table>
                @endif

            </td>
            <td class="text-center">{!! (($item->kelasjab!='')?$item->kelasjab:'-') !!}</td>
            <td class="text-center">
                <a href="javascript:void(0)" class="pemangkujabatan" title="Lihat Detail" actid="{!!$item->id!!}" actidskpd="{!!$item->idskpd!!}" actperiodebulan="{!!$item->periode_bulan!!}" actperiodetahun="{!!$item->periode_tahun!!}" actidjabjbt="{!!$item->idjabjbt!!}" actidjabfung="{!!$item->idjabfung!!}" actidjabfungum="{!!$item->idjabfungum!!}" actidjenjab="{!!$item->idjenjab!!}" actidmatkulpel="{!!$item->idmatkulpel!!}" actidtugasdokter="{!!$item->idtugasdokter!!}">{!!$banyakorang!!}</a>
            </td>
            <td class="text-center"> 
                <a href="javascript:void(0)" class="detail" title="Lihat Detail" actid="{!!$item->id!!}" actidskpd="{!!$item->idskpd!!}" actperiodebulan="{!!$item->periode_bulan!!}" actperiodetahun="{!!$item->periode_tahun!!}" actidjabjbt="{!!$item->idjabjbt!!}" actidjabfung="{!!$item->idjabfung!!}" actidjabfungum="{!!$item->idjabfungum!!}" actidjenjab="{!!$item->idjenjab!!}">{!!(($item->abk!='')?$item->abk:'-')!!}</a>    
            </td>
            <td class="text-center">{!!(($jml_keb!=0)?$jml_keb:0)!!}</td>
            @if($jml_keb<0)
            <td style="background-color:#FFFF00;">
                KURANG
            </td>
            @elseif($jml_keb==0)
            <td>
                SESUAI
            </td>
            @else
            <td style="background-color:#FF0000;">
                LEBIH
            </td>
            @endif
        </tr>
        @endforeach
       @else 
    <tr>
        <td align="center" colspan="8"><h4>DATA TIDAK DITEMUKAN</h4></td>
    </tr>
@endif

        </tbody>
        <tfoot class="breadcrumb">
        <tr>
            <th colspan="2">PNS SESUAI PETA JABATAN</th>
            <th></th>
            <th><div class="text-center"><a href="javascript:void(0)" class="pemangkujabatanopd" title="Lihat Detail" actidskpd="{!!$idskpd!!}" actperiodebulan="{!!$periode_bulan!!}" actperiodetahun="{!!$periode_tahun!!}">{!!array_sum($pns)!!}</a></div></th>
            <th><div class="text-center">{!! array_sum($kebutuhan); !!}</div></th>
            <th><div class="text-center">{!! array_sum($kebutuhan)-array_sum($pns);!!}</div></th>

            <th><div class="text-center"></div></th>
        </tr>
        <tr>
            <th colspan="3">PNS TIDAK SESUAI PETA JABATAN</th>
            <th><div class="text-center"><a href="javascript:void(0)" class="kebutuhanpemangkujabatan" title="Lihat Detail" actidskpd="{!!$idskpd!!}" actperiodebulan="{!!$periode_bulan!!}" actperiodetahun="{!!$periode_tahun!!}">{!!($rsbelum - array_sum($pns))!!}</a></div></th>
            <th><div class="text-center"></div></th>
            <th><div class="text-center"></div></th>
            <th><div class="text-center"></div></th>
            <th><div class="text-center"></div></th>
        </tr>
        <tr>
            <th colspan="3">JUMLAH PNS AKTIF</th>
            <th><div class="text-center"><?php echo array_sum($pns) + ($rsbelum - array_sum($pns))?></div></th>
            <th><div class="text-center"></div></th>
            <th><div class="text-center"></div></th>
            <th><div class="text-center"></div></th>
            <th><div class="text-center"></div></th>
        </tr>
    </tfoot>    
    </table>

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
</script>