<style>
    .tebal{
        font-weight: bold;
    }
</style>
<section class="content-header">
    <h1>
        Proyeksi Pertahun<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Proyeksi Pertahun</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! ClaravelHelpers::btnCreate() !!} &nbsp;
            <div class="box-toolsx col-sm-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'nominatif-rekap' )) !!}
                {!!csrf_field()!!}
                <div class="pull-right col-md-12">
                    <table border="0" width="70%" align="right">
                        <tr>
                            <td width="50%">
                                @if(Session::get('role_id') <= 3)
                                {!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'), '.: Unit Kerja :.')!!}
                                @else
                                <input type="hidden" name="idskpd" class="form-control" value="{!!Session('idskpd')!!}">
                                <input type="text" name="skp" class="form-control" value="{!!getSkpd(Session('idskpd'))!!}" disabled>
                                @endif
                            </td>
                            <td width="10%"><button class="btn btn-success" type="button" id="prev-rekap"><i class="fa fa-search"></i> Lihat Rekap</button></td>
                            <td width="10%"><button class="btn btn-success" type="button" id="excel-rekap"><i class="fa fa-file-excel-o"></i> Download Excel</button></td>
                        </tr>
                    </table>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="text-center">
            <h3>REKAPITULASI DATA KELEMBAGAAN DAN DATA KEPEGAWAIAN TH. {!!date('Y')!!}</h3>
        </div>
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center" rowspan="4">NO</th>
                        <th class="text-center" rowspan="4" colspan="6"><div style="width: 300px">UNIT ORGANISASI DAN NAMA JABATAN</div></th>
                        <th class="text-center" rowspan="4">TIPE OPD</th>
                        <th class="text-center" rowspan="4">KELAS JABATAN</th>
                        <th class="text-center" colspan="15">JUMLAH PNS KEADAAN SAMPAI DENGAN JANUARI {!!date('Y')!!} / RIIL</th>
                        <th class="text-center" colspan="15">JUMLAH KEBUTUHAN PNS BERDASARKAN ANALISIS BEBAN KERJA/ ABK</th>
                        <th class="text-center" rowspan="4">BUP TH. {!!date('Y') + 1!!}</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="2">JABATAN PIMPINAN TINGGI</th>
                        <th class="text-center" colspan="3">JABATAN ADMINISTRASI</th>
                        <th class="text-center" colspan="8">JABATAN FUNGSIONAL</th>
                        <th class="text-center" rowspan="3">JABATAN PELAKSANA (JFU)</th>
                        <th class="text-center" rowspan="3">JUMLAH </th>
                        <th class="text-center" colspan="2">JABATAN PIMPINAN TINGGI</th>
                        <th class="text-center" colspan="3">JABATAN ADMINISTRASI</th>
                        <th class="text-center" colspan="8">JABATAN FUNGSIONAL</th>
                        <th class="text-center" rowspan="3">JABATAN PELAKSANA (JFU)</th>
                        <th class="text-center" rowspan="3">JUMLAH</th>
                    </tr>
                    <tr>
                        <th class="text-center">Madya</th>
                        <th class="text-center">Pratama</th>
                        <th class="text-center">Adminis-trator</th>
                        <th class="text-center">Pengawas</th>
                        <th class="text-center">Pelaksana</th>
                        <th class="text-center" colspan="4">Terampil</th>
                        <th class="text-center" colspan="4">Ahli</th>
                        <th class="text-center">Madya</th>
                        <th class="text-center">Pratama</th>
                        <th class="text-center">Adminis-trator</th>
                        <th class="text-center">Pengawas</th>
                        <th class="text-center">Pelaksana</th>
                        <th class="text-center" colspan="4">Terampil</th>
                        <th class="text-center" colspan="4">Ahli</th>
                    </tr>
                    <tr>
                        <th class="text-center">Es. I</th>
                        <th class="text-center">Es. II</th>
                        <th class="text-center">Es. III</th>
                        <th class="text-center">Es. IV</th>
                        <th class="text-center">Es. V</th>
                        <th class="text-center">Pemula</th>
                        <th class="text-center">Terampil</th>
                        <th class="text-center">Mahir</th>
                        <th class="text-center">Penyelia</th>
                        <th class="text-center">Pertama</th>
                        <th class="text-center">Muda</th>
                        <th class="text-center">Madya</th>
                        <th class="text-center">Utama</th>
                        <th class="text-center">Es. I</th>
                        <th class="text-center">Es. II</th>
                        <th class="text-center">Es. III</th>
                        <th class="text-center">Es. IV</th>
                        <th class="text-center">Es. V</th>
                        <th class="text-center">Pemula</th>
                        <th class="text-center">Terampil</th>
                        <th class="text-center">Mahir</th>
                        <th class="text-center">Penyelia</th>
                        <th class="text-center">Pertama</th>
                        <th class="text-center">Muda</th>
                        <th class="text-center">Madya</th>
                        <th class="text-center">Utama</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php 
                        $x = 0;
                        $total_pns =0;
                        $total_abk =0;
                    ?>
                    @foreach ($proyeksipertahuns as $proyeksipertahun)
                    <?php
                        $x++;
                        $total_pns += $proyeksipertahun->jumlahreal;
                        $total_abk += $proyeksipertahun->abk;
                        $len = strlen($proyeksipertahun->idskpd);
                        $eselon1[] = $proyeksipertahun->eselon1;
                        $eselon2[] = $proyeksipertahun->eselon2;
                        $eselon3[] = $proyeksipertahun->eselon3;
                        $eselon4[] = $proyeksipertahun->eselon4;
                        $eselon5[] = $proyeksipertahun->eselon5;
                        $pemula[] = $proyeksipertahun->pemula;
                        $terampil[] = $proyeksipertahun->terampil;
                        $mahir[] = $proyeksipertahun->mahir;
                        $penyelia[] = $proyeksipertahun->penyelia;
                        $pertama[] = $proyeksipertahun->pertama;
                        $muda[] = $proyeksipertahun->muda;
                        $madya[] = $proyeksipertahun->madya;
                        $utama[] = $proyeksipertahun->utama;
                        $pelaksana[] = $proyeksipertahun->pelaksana;
                        $jumlahreal[] = $proyeksipertahun->jumlahreal;
                        $abkeselon1[] = $proyeksipertahun->abkeselon1;
                        $abkeselon2[] = $proyeksipertahun->abkeselon2;
                        $abkeselon3[] = $proyeksipertahun->abkeselon3;
                        $abkeselon4[] = $proyeksipertahun->abkeselon4;
                        $abkeselon5[] = $proyeksipertahun->abkeselon5;
                        $abkpemula[] = $proyeksipertahun->abkpemula;
                        $abkterampil[] = $proyeksipertahun->abkterampil;
                        $abkmahir[] = $proyeksipertahun->abkmahir;
                        $abkpenyelia[] = $proyeksipertahun->abkpenyelia;
                        $abkpertama[] = $proyeksipertahun->abkpertama;
                        $abkmuda[] = $proyeksipertahun->abkmuda;
                        $abkmadya[] = $proyeksipertahun->abkmadya;
                        $abkutama[] = $proyeksipertahun->abkutama;
                        $akpelaksana[] = $proyeksipertahun->akpelaksana;
                        //$jumlahak[] = $proyeksipertahun->jumlahak;
                        $pensiun[] = $proyeksipertahun->pensiun;
                    ?>
                    <tr>
                        <td class="text-center">{!!$x!!}</td>
                        @if($len == 2)
                            @if($proyeksipertahun->idjenjab > 4)
                                <td colspan="6">{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @else
                                <td>&nbsp;</td>
                                <td colspan="5">{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @endif
                        @elseif($len == 5)
                            @if($proyeksipertahun->idjenjab > 4)
                                <td>&nbsp;</td>
                                <td colspan="5">{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @else
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="4">{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @endif
                        @elseif($len == 8)
                            @if($proyeksipertahun->idjenjab > 4)
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="4">{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @else
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="3">{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @endif
                        @elseif($len == 11)
                            @if($proyeksipertahun->idjenjab > 4)
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="3">{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @else
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @endif
                        @elseif($len == 14)
                            @if($proyeksipertahun->idjenjab > 4)
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @else
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>{!!$proyeksipertahun->namajabatan!!}
                                    @if(substr($proyeksipertahun->idjabfung,0,3) == '300')
                                        {!! ' - '.@CFirst($proyeksipertahun->matkulpel) !!}
                                    @elseif(substr($proyeksipertahun->idjabfung,0,3) == '220')
                                        {!! ' - '.@CFirst($proyeksipertahun->tugasdokter) !!}
                                    @endif
                                </td>
                            @endif
                        @endif

                        <td></td>
                        <td class="text-right">{!!$proyeksipertahun->kelas_jabatan!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->eselon1!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->eselon2!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->eselon3!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->eselon4!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->eselon5!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->pemula!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->terampil!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->mahir!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->penyelia!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->pertama!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->muda!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->madya!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->utama!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->pelaksana!!}</td>
                        <td class="text-right tebal">{!!$proyeksipertahun->jumlahreal!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkeselon1!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkeselon2!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkeselon3!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkeselon4!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkeselon5!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkpemula!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkterampil!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkmahir!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkpenyelia!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkpertama!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkmuda!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkmadya!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->abkutama!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->akpelaksana!!}</td>
                        <td class="text-right tebal">{!!$proyeksipertahun->abk!!}</td>
                        <td class="text-right">{!!$proyeksipertahun->pensiun!!}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">TOTAL</td>
                        <td></td>
                        <td class="text-right">{!!array_sum($eselon1)!!}</td>
                        <td class="text-right">{!!array_sum($eselon2)!!}</td>
                        <td class="text-right">{!!array_sum($eselon3)!!}</td>
                        <td class="text-right">{!!array_sum($eselon4)!!}</td>
                        <td class="text-right">{!!array_sum($eselon5)!!}</td>
                        <td class="text-right">{!!array_sum($pemula)!!}</td>
                        <td class="text-right">{!!array_sum($terampil)!!}</td>
                        <td class="text-right">{!!array_sum($mahir)!!}</td>
                        <td class="text-right">{!!array_sum($penyelia)!!}</td>
                        <td class="text-right">{!!array_sum($pertama)!!}</td>
                        <td class="text-right">{!!array_sum($muda)!!}</td>
                        <td class="text-right">{!!array_sum($madya)!!}</td>
                        <td class="text-right">{!!array_sum($utama)!!}</td>
                        <td class="text-right">{!!array_sum($pelaksana)!!}</td>
                        <td class="text-right"style="font-weight: bold;">{!!array_sum($jumlahreal)!!}</td>
                        <td class="text-right">{!!array_sum($abkeselon1)!!}</td>
                        <td class="text-right">{!!array_sum($abkeselon2)!!}</td>
                        <td class="text-right">{!!array_sum($abkeselon3)!!}</td>
                        <td class="text-right">{!!array_sum($abkeselon4)!!}</td>
                        <td class="text-right">{!!array_sum($abkeselon5)!!}</td>
                        <td class="text-right">{!!array_sum($abkpemula)!!}</td>
                        <td class="text-right">{!!array_sum($abkterampil)!!}</td>
                        <td class="text-right">{!!array_sum($abkmahir)!!}</td>
                        <td class="text-right">{!!array_sum($abkpenyelia)!!}</td>
                        <td class="text-right">{!!array_sum($abkpertama)!!}</td>
                        <td class="text-right">{!!array_sum($abkmuda)!!}</td>
                        <td class="text-right">{!!array_sum($abkmadya)!!}</td>
                        <td class="text-right">{!!array_sum($abkutama)!!}</td>
                        <td class="text-right">{!!array_sum($akpelaksana)!!}</td>
                        <td class="text-right tebal">{!! $total_abk !!}</td>
                        <td class="text-right">{!!array_sum($pensiun)!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-6">
                    {!! ClaravelHelpers::btnDeleteAll() !!}
                </div>
                <div class="col-sm-6">
                    <?php //echo $proyeksipertahuns->appends(array('search' => Input::get('search')))->render(); ?>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>

<script>
    function refresh_page(){
    <?php
    echo 'var index_page=laravel_base + "/'.\Request::path().'";';
    ?>
        $.ajax({
            url : index_page,
            type : 'GET',
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        });
    }

    $(document).ready(function(){
        $('select').select2();
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        $('#buat').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('href'),
                //url : laravel_base + '/' + $(this).attr('href'),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

    <?php
    echo 'var index_page=laravel_base + "/'.\Request::path().'";';
    ?>

        $('#tabel').on('click','#hapus',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/delete',
                        type : 'post',
                        data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            notification(html,'success');
                            $this.closest('tr').fadeOut(300,function(){
                                $(this).remove();
                            });
                        }
                    });
                }
            });
        });
        $('#tabel').on('click','#edit',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Edit?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/edit',
                        type : 'get',
                        data:'id=' + $this.attr('recid'),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            $('#utama').html(html);
                        }
                    });
                }
            });
        });
        $('#cari').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                data:$(this).serialize(),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });
        $('#data').on('submit',function(e){
            e.preventDefault();
            var iki = $(this);
            bootbox.confirm('Hapus?',function(r){
                if(r){
                    $.ajax({
                        url : iki.attr('action') + '/delete',
                        type : 'post',
                        data:iki.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            notification(html,'success');
                            iki.find('input[type=checkbox]').each(function (t){
                                if($(this).is(':checked')){
                                    $(this).closest('tr').fadeOut(100)
                                }
                            });
                            $('#deleteall').fadeOut(300);
                        }
                    });
                }
            });
        });

        $('#prev-rekap').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url : '{!!url()!!}/proyeksikebutuhan/proyeksipertahun',
                type : 'get',
                data : $('#nominatif-rekap').serialize(),
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        $('#excel-rekap').on('click', function(e){
            e.preventDefault();
            if($('#idskpd').val() != ''){
                $('#nominatif-rekap').attr("action", "{!!url()!!}/proyeksikebutuhan/proyeksipertahun/excel/rekap");
                $('#nominatif-rekap').submit();
            }else {
                bootbox.alert('Unit Kerja harus diisi !');
            }
        });

    });
</script>
