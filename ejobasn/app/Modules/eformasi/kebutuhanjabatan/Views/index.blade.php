<style>
    th{
        text-align: center;
    }
</style>
<section class="content-header">
        <h1>
            Kebutuhan Jabatan<small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!!url('')!!}"> Dashboard</a></li>
            <li class="active">Kebutuhan Jabatan</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border row" style="min-height: 43px;">
                <div class="col-sm-3 pull-left">
                    {!! ClaravelHelpers::btnCreate() !!}
                </div>
                <div class="box-tools pull-right col-sm-9">
                    {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                    {!!csrf_field()!!}
                    <div class="pull-right col-md-12">
                        <table border="0" width="100%">
                            <tr>
                                <td width="15%">{!! comboBulanjab("periode_bulan",((Input::get('periode_bulan')!='')?Input::get('periode_bulan'):date('m')),"") !!}</td>
                                <td width="15%">{!! comboTahunjab("periode_tahun",((Input::get('periode_tahun')!='')?Input::get('periode_tahun'):date('Y')),"") !!}</td>
                                <td>
                                    @if(Session::get('role_id') <= 3)
                                    {!!comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'), '.: Unit Kerja :.')!!}
                                    @else
                                    <input type="hidden" name="idskpd" class="form-control" value="{!!Session('idskpd')!!}">
                                    <input type="text" name="skp" class="form-control" value="{!!getSkpd(Session('idskpd'))!!}" disabled>
                                    @endif
                                </td>
                                <td width="10%"><button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button></td>
                            </tr>
                        </table>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
            {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
            <div class="table-responsive">
                <div class="box-body no-padding" style="min-height: 70vh">
                    <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                        <thead class="bg-primary">
                        <tr>
                            <th rowspan="2" width="3%">No</th>
                            <!--<th colspan="2">Periode</th>-->
                            <th rowspan="2">Kode OPD</th>
                            <th rowspan="2">Unit Kerja</th>
                            <th colspan="3">Jumlah Jabatan</th>
                            <th rowspan="2" width="7%">Act.</th>
                        </tr>
                        <tr>
                            <!--<th>Bulan</th>
                            <th>Tahun</th>-->
                            <th>Struktural</th>
                            <th>Fungsional</th>
                            <th>Pelaksana</th>
                        </tr>
                        </thead>
    
                        <tbody>
                        <?php $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0; ?>
                        @foreach ($kebutuhanjabatans as $kebutuhanjabatan)
                        <?php $x++; ?>
                        <tr>
                            <td class="text-center">{!!$x!!}</td>
                            <!--<td>{!!@formatBulan($kebutuhanjabatan->periode_bulan)!!}</td>
                            <td>{!!$kebutuhanjabatan->periode_tahun!!}</td>-->
                            <td class="text-center">{!!$kebutuhanjabatan->kdunit!!}</td>
                            <td>{!!$kebutuhanjabatan->skpd!!}</td>
                            <td class="text-center">{!!$kebutuhanjabatan->jmlstruktural!!}</td>
                            <td class="text-center">{!!$kebutuhanjabatan->jmlfungsional!!}</td>
                            <td class="text-center">{!!$kebutuhanjabatan->jmlpelaksana!!}</td>
    
                            <td>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                        <span class="caret"></span> Aksi
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <!-- or idskpd == disdik -->
                                        @if(Session::get('role_id') <= 3 || substr(session('idskpd'),0,2) == '04')
                                            <li><a href="javascript:void(0)" actidskpd="{!!$kebutuhanjabatan->idskpd!!}" actperiodebulan="{!!$kebutuhanjabatan->periode_bulan!!}" actperiodetahun="{!!$kebutuhanjabatan->periode_tahun!!}" class="text-info edit-kebutuhanjabatan"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                                        @endif
                                        @if(Session::get('role_id') <= 3)
                                            {{-- <li><a href="javascript:void(0)" actidskpd="{!!$kebutuhanjabatan->idskpd!!}" actperiodebulan="{!!$kebutuhanjabatan->periode_bulan!!}" actperiodetahun="{!!$kebutuhanjabatan->periode_tahun!!}" class="text-danger hapus-kebutuhanjabatan"><i class="fa fa-times-circle"></i> Hapus</a></li> --}}
                                        @endif
                                        <li><a href="{!!url('')!!}/eformasi/kebutuhanjabatan/print/kebutuhanjabatan/{!!$kebutuhanjabatan->idskpd!!}/{!!$kebutuhanjabatan->periode_bulan!!}/{!!$kebutuhanjabatan->periode_tahun!!}" class="text-info" target="_blank"><i class="fa fa-print"></i> Cetak Kebutuhan Jabatan</a></li>
                                        <li><a href="{!!url('')!!}/eformasi/kebutuhanjabatan/excel/kebutuhanjabatan/{!!$kebutuhanjabatan->idskpd!!}/{!!$kebutuhanjabatan->periode_bulan!!}/{!!$kebutuhanjabatan->periode_tahun!!}" class="text-info" target="_blank"><i class="fa fa-file-excel-o"></i> Export Excel</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="height: 75px"></div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <div class="row">
                    <div class="col-sm-6">
                        {!! ClaravelHelpers::btnDeleteAll() !!}
                    </div>
                    <div class="col-sm-6">
                        <?php echo $kebutuhanjabatans->appends(array('idskpd'=>Input::get('idskpd'), 'periode_bulan' => Input::get('periode_bulan'), 'periode_tahun' => Input::get('periode_tahun'), 'search' => Input::get('search')))->render(); ?>
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
    
            $('.hapus-kebutuhanjabatan').on('click',function(e){
                e.preventDefault();
                var $this =$(this);
                bootbox.confirm('Hapus Peta Jabatan?',function(a){
                    if(a == true){
                        $.ajax({
                            url : index_page + '/deletekebutuhanjabatan',
                            type : 'post',
                            data : {'periode_bulan' : $this.attr('actperiodebulan'), 'periode_tahun' : $this.attr('actperiodetahun'), 'idskpd' : $this.attr('actidskpd'), '_token' : '{!!csrf_token()!!}'},
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
            });
    
            $('.edit-kebutuhanjabatan').on('click',function(e){
                e.preventDefault();
                var $this =$(this);
                bootbox.confirm('Edit?',function(a){
                    if(a == true){
                        $.ajax({
                            url : index_page + '/edit',
                            type : 'get',
                            data : {'periode_bulan' : $this.attr('actperiodebulan'), 'periode_tahun' : $this.attr('actperiodetahun'), 'idskpd' : $this.attr('actidskpd'), '_token' : '{!!csrf_token()!!}'},
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
        });
    </script>