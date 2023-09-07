<section class="content-header">
        <h1>
            Buat Kebutuhan Jabatan Baru<small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!!url('')!!}"> Dashboard</a></li>
            <li><a href="#" id="back"> Kebutuhan Jabatan</a></li>
            <li class="active">Buat Kebutuhan Jabatan Baru</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="row">
                <div class="col-md-12">
                    <div class="callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Pilih tahun Kebutuhan Jabatan</li>
                            @if(Session::get('role_id') <= 3)
                            <li>Pilih unit kerja yang akan dibuatkan Kebutuhan Jabatannya</li>
                            @endif
                            <li>Pilih tombol Preview untuk melihat Kebutuhan Jabatan sementara</li>
                            <li>Untuk menyimpan Kebutuhan Jabatan pilih tombol simpan</li>
                        </ul>
                    </div>
    
                    {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-kebutuhanjabatan')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('periode', 'Periode:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-md-6">{!! comboBulanjab("periode_bulan",date('m'),"") !!}</div>
                                    <div class="col-md-6">{!! comboTahunjab("periode_tahun",date('Y'),"") !!}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                @if(Session::get('role_id') <= 3)
                                {!!comboSkpd("idskpd","","",Session('idskpd'))!!}
                                @else
                                <input type="hidden" name="idskpd" class="form-control" value="{!!Session('idskpd')!!}">
                                <input type="text" name="skp" class="form-control" value="{!!getSkpd(Session('idskpd'))!!}" disabled>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-7">
                                <button class="btn btn-success" type="button" id="prev-kebutuhanjabatan"><i class="fa fa-list-ul"></i> Lihat Jabatan Struktural Sementara</button>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div id="result" class="table-responsive"></div>
                    </div>
    
                    <div class="form-button-custom">
                        <ul class="breadcrumb pull-right">
                            <li><a href="{!!url('')!!}"> Dashboard</a></li>
                            <li><a href="javascript:void(0)" id="back"> Kebutuhan Jabatan</a></li>
                            <li>
                                <a id="back-simpan" href="{!!url('')!!}/eformasi/kebutuhanjabatan" class="btn btn-success "><i class="fa fa-floppy-o"></i> Simpan</a>
                                <a id="batalkan" href="{!!url('')!!}/eformasi/kebutuhanjabatan" class="btn btn-warning "><i class="fa fa-times-circle-o"></i> Batalkan</a>
                            </li>
                        </ul>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    
    <style type="text/css">
        .form-button-custom {
            float: right;
            position: fixed;
            right: 0px;
            top: 155px;
            z-index : 2;
        }
    
        header, table, p {
            position : relative;
            z-index : 1;
        }
    </style>
    
    <script>
        function refresh_page(){
            <?php
            $index_page = explode('/', \Request::path());
            $jum = count($index_page) -1;
            unset ($index_page[$jum]);
            $index = join('/', $index_page);
            echo 'var index_page=laravel_base + "/'.$index.'";';
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
            $('#batalkan,#back,#back-simpan').on('click',function(e){
                e.preventDefault();
                refresh_page();
            });
    
            $('#form-kebutuhanjabatan').on('submit',function(e){
                var $this = $(this);
                e.preventDefault();
                bootbox.confirm('Simpan data?',function(a){
                    if (a == true){
                        $.ajax({
                            url : $this.attr('action'),
                            type : 'POST',
                            data : $this.serialize(),
                            beforeSend: function(){
                                preloader.on();
                            },
                            success:function(html){
                                preloader.off();
                                if(html=='1'){
                                    notification('Berhasil Disimpan','success');
                                    refresh_page();
                                }else{
                                    notification(html,'danger');
                                }
                            }
                        });
                    }
                });
            });
    
            $('#prev-kebutuhanjabatan').on('click', function(e){
                e.preventDefault();
                claravel_modal('Preview Jabatan Struktural','Loading...','modal_notif');
                $.ajax({
                    type: 'post',
                    url : '{!!url('')!!}/eformasi/kebutuhanjabatan/data/kebutuhanjabatanprev',
                    data : $('#form-kebutuhanjabatan').serialize(),
                    success:function(html){
                        $('#modal_notif .modal-body').html(html);
                    }
                });
            });
        });
    
        function getKebutuhanjabatan(){
            $.ajax({
                url : '{!!url('')!!}/eformasi/kebutuhanjabatan/data/kebutuhanjabatan',
                type : 'post',
                data : $('#form-kebutuhanjabatan').serialize(),
                beforeSend:function(){
                    $('#result').html('<i class="fa fa-spinner"></i> Loading...');
                },
                success:function(response){
                    $('#result').html(response);
                }
            });
        }
    </script>
