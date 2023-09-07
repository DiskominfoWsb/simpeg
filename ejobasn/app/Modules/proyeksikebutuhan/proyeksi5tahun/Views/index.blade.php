<section class="content-header">
    <h1>
        Proyeksi 5 Tahun<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Proyeksi 5 Tahun</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! ClaravelHelpers::btnCreate() !!} &nbsp;
            <div class="box-toolsx pull-right col-sm-9">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'proyeksi-rekap' )) !!}
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
                            <td width="10%"><button class="btn btn-success" type="button" id="prev-proyeksi"><i class="fa fa-search"></i> Lihat Rekap</button></td>
                            <td width="10%"><button class="btn btn-success" type="button" id="excel-proyeksi"><i class="fa fa-file-excel-o"></i> Download Excel</button></td>
                        </tr>
                    </table>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div align="center">
            <h3>PROYEKSI KEBUTUHAN PEGAWAI 5 (LIMA) TAHUN KE DEPAN</h3>
        </div>
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center" rowspan="3">No</th>
                        <th class="text-center" rowspan="3" colspan="6">Nama Unit Organisasi dan Nama Jabatan </th>
                        <th width="10%" class="text-center" rowspan="3">Bezetting Pegawai Saat Ini</th>
                        <th width="10%" class="text-center" rowspan="3">Kebutuhan Pegawai Berdasarkan ABK</th>
                        <th width="45%" class="text-center" colspan="10">Proyeksi</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="5">Jumlah yang akan Pensiun</th>
                        <th class="text-center" colspan="5">Pegawai yang Dibutuhkan</th>
                    </tr>
                    <tr>
                        <th class="text-center">{!!date('Y')!!}</th>
                        <th class="text-center">{!!date('Y') + 1!!}</th>
                        <th class="text-center">{!!date('Y') + 2!!}</th>
                        <th class="text-center">{!!date('Y') + 4!!}</th>
                        <th class="text-center">{!!date('Y') + 5!!}</th>
                        <th class="text-center">{!!date('Y')!!}</th>
                        <th class="text-center">{!!date('Y') + 1!!}</th>
                        <th class="text-center">{!!date('Y') + 2!!}</th>
                        <th class="text-center">{!!date('Y') + 4!!}</th>
                        <th class="text-center">{!!date('Y') + 5!!}</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $x = 0;?>
                    @foreach ($proyeksi5tahuns as $proyeksi5tahun)
                    <?php
                        $x++;
                        $len = strlen($proyeksi5tahun->idskpd);

                        $pensiun1[$x] = $proyeksi5tahun->pensiun1;
                        $pensiun2[$x] = $proyeksi5tahun->pensiun2;
                        $pensiun3[$x] = $proyeksi5tahun->pensiun3;
                        $pensiun4[$x] = $proyeksi5tahun->pensiun4;
                        $pensiun5[$x] = $proyeksi5tahun->pensiun5;

                        $kurang1[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun1;
                        $kurang2[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun2 + $proyeksi5tahun->pensiun1;
                        $kurang3[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun3 + $proyeksi5tahun->pensiun2 + $proyeksi5tahun->pensiun1;
                        $kurang4[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun4 + $proyeksi5tahun->pensiun3 + $proyeksi5tahun->pensiun2 + $proyeksi5tahun->pensiun1;
                        $kurang5[$x] = $proyeksi5tahun->jumlahak - $proyeksi5tahun->jumlahreal + $proyeksi5tahun->pensiun5 + $proyeksi5tahun->pensiun4 + $proyeksi5tahun->pensiun3 + $proyeksi5tahun->pensiun2 + $proyeksi5tahun->pensiun1;

                        $jumlahreal[$x] = $proyeksi5tahun->jumlahreal;
                        $jumlahak[$x] = $proyeksi5tahun->jumlahak;
                        ?>
                    <tr>
                        <td class="text-center">{!!$x!!}</td>
                        @if($len == 2)
                            @if($proyeksi5tahun->idjenjab > 4)
                            <td colspan="6">{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @else
                            <td>&nbsp;</td>
                            <td colspan="5">{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @endif
                        @elseif($len == 5)
                            @if($proyeksi5tahun->idjenjab > 4)
                            <td>&nbsp;</td>
                            <td colspan="5">{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @else
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="4">{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @endif
                        @elseif($len == 8)
                            @if($proyeksi5tahun->idjenjab > 4)
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="4">{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @else
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="3">{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @endif
                        @elseif($len == 11)
                            @if($proyeksi5tahun->idjenjab > 4)
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="3">{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @else
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="2">{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @endif
                        @elseif($len == 14)
                            @if($proyeksi5tahun->idjenjab > 4)
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="2">{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @else
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>{!!$proyeksi5tahun->namajabatan!!}
                                @if(substr($proyeksi5tahun->idjabfung,0,3) == '300')
                                    {!! ' - '.@CFirst($proyeksi5tahun->matkulpel) !!}
                                @elseif(substr($proyeksi5tahun->idjabfung,0,3) == '220')
                                    {!! ' - '.@CFirst($proyeksi5tahun->tugasdokter) !!}
                                @endif
                            </td>
                            @endif
                        @endif
                        <td class="text-right">{!!$proyeksi5tahun->jumlahreal!!}</td>
                        <td class="text-right">{!!$proyeksi5tahun->jumlahak!!}</td>
                        <td class="text-right">{!!$proyeksi5tahun->pensiun1!!}</td>
                        <td class="text-right">{!!$proyeksi5tahun->pensiun2!!}</td>
                        <td class="text-right">{!!$proyeksi5tahun->pensiun3!!}</td>
                        <td class="text-right">{!!$proyeksi5tahun->pensiun4!!}</td>
                        <td class="text-right">{!!$proyeksi5tahun->pensiun5!!}</td>
                        <td class="text-right">{!!$kurang1[$x]!!}</td>
                        <td class="text-right">{!!$kurang2[$x]!!}</td>
                        <td class="text-right">{!!$kurang3[$x]!!}</td>
                        <td class="text-right">{!!$kurang4[$x]!!}</td>
                        <td class="text-right">{!!$kurang5[$x]!!}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tr>
                        <td colspan="7">Total</td>
                        <td class="text-right">{!!array_sum($jumlahreal)!!}</td>
                        <td class="text-right">{!!array_sum($jumlahak)!!}</td>
                        <td class="text-right">{!!array_sum($pensiun1)!!}</td>
                        <td class="text-right">{!!array_sum($pensiun2)!!}</td>
                        <td class="text-right">{!!array_sum($pensiun3)!!}</td>
                        <td class="text-right">{!!array_sum($pensiun4)!!}</td>
                        <td class="text-right">{!!array_sum($pensiun5)!!}</td>
                        <td class="text-right">{!!array_sum($kurang1)!!}</td>
                        <td class="text-right">{!!array_sum($kurang2)!!}</td>
                        <td class="text-right">{!!array_sum($kurang3)!!}</td>
                        <td class="text-right">{!!array_sum($kurang4)!!}</td>
                        <td class="text-right">{!!array_sum($kurang5)!!}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-6">
                    {!! ClaravelHelpers::btnDeleteAll() !!}
                </div>
                <div class="col-sm-6">
                    <?php //echo $proyeksi5tahuns->appends(array('search' => Input::get('search')))->render(); ?>
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

        $('#prev-proyeksi').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url : '{!!url()!!}/proyeksikebutuhan/proyeksi5tahun',
                type : 'get',
                data : $('#proyeksi-rekap').serialize(),
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        $('#excel-proyeksi').on('click', function(e){
            e.preventDefault();
            if($('#idskpd').val() != ''){
                $('#proyeksi-rekap').attr("action", "{!!url()!!}/proyeksikebutuhan/proyeksi5tahun/excel/rekap");
                $('#proyeksi-rekap').submit();
            }else {
                bootbox.alert('Unit Kerja harus diisi !');
            }
        });
    });
</script>
