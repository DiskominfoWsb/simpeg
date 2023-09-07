<section class="content-header">
    <h1>
        Analisis Kebutuhan Diklat<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li class="active">Analisis Kebutuhan Diklat</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Pilih bulan dan tahun</li>
                        @if(Session::get('role_id') <= 3)
                        <li>Pilih unit kerja</li>
                        @endif
                        <li>Pilih Jenis dan Nama Diklat</li>
                        <li>Pilih Status Diklat (Sudah/Belum)</li>
                        <li>Pilih Jenis dan Nama Jabatan (opsional)</li>
                        <li>Pilih tombol Lihat Preview untuk melihat Preview Laporan Analisis Kebutuhan Diklat</li>
                        <li>Pilih tombol Cetak PDF untuk mengunduh Laporan Analisis Kebutuhan Diklat dalam format PDF</li>
                        <!-- <li>Pilih tombol Cetak Excel untuk mengunduh Laporan Peta Jabatan dalam format Excel</li> -->
                    </ul>
                </div>
                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-kebutuhandiklat', 'target'=>'_blank')) !!}


                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('periode', 'Periode:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <div class="row">
                                <?php
                                    $periode_akhir = \DB::table('tr_petajab')
                                                    ->orderby('periode_tahun','desc')
                                                    ->orderby('periode_bulan','desc')
                                                    ->first();
                                ?>

                                <div class="col-md-6">{!! comboBulanpetajab("periode_bulan",$periode_akhir->periode_bulan,"") !!}</div>
                                <div class="col-md-6">
                                    <div id="tahunpetajab">
                                        {!! comboTahunpetajab("periode_tahun",$periode_akhir->periode_tahun,"",$periode_akhir->periode_bulan) !!}
                                        <!-- <select class="form-control" style="width:100%;">
                                            <option class="form-control">.: Pilihan :.</option>
                                        </select> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            @if(Session::get('role_id') <= 3)
                            <div id="skpdpetajab">
                                {!! comboSkpdpetajab("idskpd","","",Session('idskpd'),".: Pilihan :.",$periode_akhir->periode_bulan,$periode_akhir->periode_tahun) !!}
                            </div>
                            @else
                            <input type="hidden" name="idskpd" class="form-control" value="{!!Session('idskpd')!!}">
                            <input type="text" name="skp" class="form-control" value="{!!getSkpd(Session('idskpd'))!!}" disabled>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('Diklat', 'Diklat:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! comboJendiklat("idjendiklat") !!}
                                </div>
                                <div class="col-md-8">
                                    <div id="diklatpetajab">
                                        <select id="iddiklat" name="iddiklat" style='width: 100%;' class="form-control">
                                            <option value="">.: Nama Diklat :.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('idstatusdiklat', 'Status Diklat:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!!comboStatusdiklat("idstatusdiklat")!!}
                        </div>
                    </div>


                    <div class="form-group">
                        {!! Form::label('jabatan', 'Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! comboJenjabpetajab("idjenjab") !!}
                                </div>
                                <div class="col-md-8">
                                    <div id="jabatanpetajab">
                                        <select id="idjabatan" name="idjabatan" style='width: 100%;' class="form-control">
                                            <option value="">.: Nama Jabatan :.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            <button class="btn btn-primary" type="button" id="prev-kebutuhandiklat"><i class="fa fa-list-ul"></i> Lihat Preview</button>
                            <button class="btn btn-danger" type="button" id="cetak-pdf"><i class="fa fa-file-pdf-o"></i> Cetak PDF</button>
                            <!-- <button class="btn btn-success" type="button" id="cetak-excel"><i class="fa fa-file-excel-o"></i> Cetak Excel</button> -->
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div id="result" class="table-responsive"></div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
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

        $('#periode_bulan').on('change',function(e){
            var $this = $(this);
            e.preventDefault();
            $.ajax({
                url : '{!!url('')!!}/eformasi/petajabatan/tahunpetajab',
                type : 'GET',
                data : {'periode_bulan' : $this.val(),'_token' : '{{csrf_token()}}'},
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#tahunpetajab').html(html);
                    $('select').select2();    

                    $('#periode_tahun').on('change',function(e){
                        e.preventDefault();
                        $.ajax({
                            url : '{!!url('')!!}/eformasi/petajabatan/skpdpetajab',
                            type : 'GET',
                            data : {'periode_bulan' : $('#periode_bulan').val(),'periode_tahun' : $('#periode_tahun').val(),'_token' : '{{csrf_token()}}'},
                            beforeSend: function(){
                                preloader.on();
                            },
                            success:function(html){
                                preloader.off();
                                $('#skpdpetajab').html(html);
                                $('select').select2(); 

                                $('#idjendiklat').on('change',function(e){
                                    e.preventDefault();
                                    $.ajax({
                                        url : '{!!url('')!!}/eformasi/petajabatan/diklatpetajab',
                                        type : 'GET',
                                        data : {'idjenjab' : $('#idjenjab').val(),'idjabatan' : $('#idjabatan').val(),'idjendiklat' : $('#idjendiklat').val(),'idskpd' : $('#idskpd').val(),'periode_bulan' : $('#periode_bulan').val(),'periode_tahun' : $('#periode_tahun').val(),'_token' : '{{csrf_token()}}'},
                                        beforeSend: function(){
                                            preloader.on();
                                        },
                                        success:function(html){
                                            preloader.off();
                                            $('#diklatpetajab').html(html);
                                            $('select').select2();    
                                        }
                                    });
                                });   

                                $('#idjenjab').on('change',function(e){
                                    e.preventDefault();
                                    $.ajax({
                                        url : '{!!url('')!!}/eformasi/petajabatan/jabatanpetajab',
                                        type : 'GET',
                                        data : {'idjenjab' : $('#idjenjab').val(),'idskpd' : $('#idskpd').val(),'periode_bulan' : $('#periode_bulan').val(),'periode_tahun' : $('#periode_tahun').val(),'_token' : '{{csrf_token()}}'},
                                        beforeSend: function(){
                                            preloader.on();
                                        },
                                        success:function(html){
                                            preloader.off();
                                            $('#jabatanpetajab').html(html);
                                            $('select').select2();   

                                            $('#idjendiklat').on('change',function(e){
                                                e.preventDefault();
                                                $.ajax({
                                                    url : '{!!url('')!!}/eformasi/petajabatan/diklatpetajab',
                                                    type : 'GET',
                                                    data : {'idjenjab' : $('#idjenjab').val(),'idjabatan' : $('#idjabatan').val(),'idjendiklat' : $('#idjendiklat').val(),'idskpd' : $('#idskpd').val(),'periode_bulan' : $('#periode_bulan').val(),'periode_tahun' : $('#periode_tahun').val(),'_token' : '{{csrf_token()}}'},
                                                    beforeSend: function(){
                                                        preloader.on();
                                                    },
                                                    success:function(html){
                                                        preloader.off();
                                                        $('#diklatpetajab').html(html);
                                                        $('select').select2();    
                                                    }
                                                });
                                            });    
                                        }
                                    });
                                });   
                            }
                        });
                    });
                }
            });
        });

        $('#idjendiklat').on('change',function(e){
            e.preventDefault();
            $.ajax({
                url : '{!!url('')!!}/eformasi/petajabatan/diklatpetajab',
                type : 'GET',
                data : {'idjenjab' : $('#idjenjab').val(),'idjabatan' : $('#idjabatan').val(),'idjendiklat' : $('#idjendiklat').val(),'idskpd' : $('#idskpd').val(),'periode_bulan' : $('#periode_bulan').val(),'periode_tahun' : $('#periode_tahun').val(),'_token' : '{{csrf_token()}}'},
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#diklatpetajab').html(html);
                    $('select').select2();    
                }
            });
        });   

        $('#idjenjab').on('change',function(e){
            e.preventDefault();
            $.ajax({
                url : '{!!url('')!!}/eformasi/petajabatan/jabatanpetajab',
                type : 'GET',
                data : {'idjenjab' : $('#idjenjab').val(),'idskpd' : $('#idskpd').val(),'periode_bulan' : $('#periode_bulan').val(),'periode_tahun' : $('#periode_tahun').val(),'_token' : '{{csrf_token()}}'},
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#jabatanpetajab').html(html);
                    $('select').select2();   

                    $('#idjendiklat').on('change',function(e){
                        e.preventDefault();
                        $.ajax({
                            url : '{!!url('')!!}/eformasi/petajabatan/diklatpetajab',
                            type : 'GET',
                            data : {'idjenjab' : $('#idjenjab').val(),'idjabatan' : $('#idjabatan').val(),'idjendiklat' : $('#idjendiklat').val(),'idskpd' : $('#idskpd').val(),'periode_bulan' : $('#periode_bulan').val(),'periode_tahun' : $('#periode_tahun').val(),'_token' : '{{csrf_token()}}'},
                            beforeSend: function(){
                                preloader.on();
                            },
                            success:function(html){
                                preloader.off();
                                $('#diklatpetajab').html(html);
                                $('select').select2();    
                            }
                        });
                    });    
                }
            });
        });   

        $('#prev-kebutuhandiklat').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type: 'post',
                url : '{!!url('')!!}/eformasi/analisiskebutuhandiklat/data/kebutuhandiklat',
                data : $('#form-kebutuhandiklat').serialize(),
                beforeSend:function(){
                    if($('#idskpd').val() != ''){
                        if($('#idjendiklat').val() != ''){
                            if($('#iddiklat').val() != ''){
                                $('#result').html('<i class="fa fa-spinner"></i> Loading...');    
                            } else{
                                bootbox.alert('Nama Diklat harus diisi !');
                            }
                        } else{
                            bootbox.alert('Jenis Diklat harus diisi !');
                        }
                    } else {
                        bootbox.alert('Unit Kerja harus diisi !');
                    }
                    
                },
                success:function(response){
                    $('#result').html(response);
                }
            });
        });

        $('#cetak-pdf').on('click', function(e){
            e.preventDefault();
            $('#form-kebutuhandiklat').attr("action", "{!!url('')!!}/eformasi/analisiskebutuhandiklat/pdf/kebutuhandiklat");
            $('#form-kebutuhandiklat').submit();
        });

        $('#cetak-excel').on('click', function(e){
            e.preventDefault();
            $('#form-kebutuhandiklat').attr("action", "{!!url('')!!}/eformasi/analisiskebutuhandiklat/excel/kebutuhandiklat");
            $('#form-kebutuhandiklat').submit();
            /*cetak_excel('result');*/
        });

        $('ul#myTab').on('click','a',function(e){
            var str = $(this).attr('href');
            var n = str.search("dashboard");
            loading('utama');
            if(n > 0){
            }
            else{
                e.preventDefault();
                e.stopImmediatePropagation();
                preloader = new $.materialPreloader({
                    position: 'top',
                    height: '5px',
                    col_1: '#159756',
                    col_2: '#da4733',
                    col_3: '#3b78e7',
                    col_4: '#fdba2c',
                    fadeIn: 200,
                    fadeOut: 200
                });

                $.ajax({
                    type: 'get',
                    url : $(this).attr('href'),
                    beforeSend: function(){
                        preloader.on();
                    },
                    success: function(data) {
                        preloader.off();
                        $('#utama').html(data);
                    }
                });
            }
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
    });
</script>
