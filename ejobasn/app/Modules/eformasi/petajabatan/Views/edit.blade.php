<section class="content-header">
    <h1>
        Edit Peta Jabatan<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Peta Jabatan</a></li>
        <li class="active">Edit Peta Jabatan</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <?php
        $rpos = strrpos(\Request::path(), '/');
        $uri = substr(\Request::path(), 0, $rpos);
        $periode_bulan = \Input::get('periode_bulan');
        $periode_tahun = \Input::get('periode_tahun');
        $idskpd = \Input::get('idskpd');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Pilih tahun Peta Jabatan</li>
                        @if(Session::get('role_id') <= 3)
                        <li>Pilih unit kerja yang akan dibuatkan Peta Jabatannya</li>
                        @endif
                        <li>Pilih tombol Preview untuk melihat Peta Jabatan sementara</li>
                        <li>Untuk menyimpan Peta Jabatan pilih tombol simpan</li>
                    </ul>
                </div>
                {!! Form::model($petajabatan, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'form-petajabatan')) !!}
                <input type="hidden" name="periode_bulan" value="{!!$periode_bulan!!}">
                <input type="hidden" name="periode_tahun" value="{!!$periode_tahun!!}">
                <input type="hidden" name="idskpd" value="{!!$idskpd!!}">
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('periode', 'Periode:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-sm-6">
                                    {!! comboBulan("periode_bulan",$periode_bulan,"disabled") !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! comboTahun("periode_tahun",$periode_tahun,"disabled") !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            @if(Session::get('role_id') <= 3)
                            {!!comboSkpd("idskpd",$idskpd,"disabled",$idskpd)!!}
                            @else
                            <input type="hidden" name="idskpd" class="form-control" value="{!!$idskpd!!}">
                            <input type="text" name="skp" class="form-control" value="{!!getSkpd($idskpd)!!}" disabled>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div id="result" class="table-responsive"></div>
                </div>

                <div class="form-button-custom">
                    <ul class="breadcrumb pull-right">
                        <li><a href="{!!url('')!!}"> Dashboard</a></li>
                        <li><a href="javascript:void(0)" id="back"> Peta Jabatan</a></li>
                        <li>
                            <a id="back-simpan" href="{!!url('')!!}/eformasi/petajabatan" class="btn btn-success "><i class="fa fa-floppy-o"></i> Simpan</a>
                            <a id="batalkan" href="{!!url('')!!}/eformasi/petajabatan" class="btn btn-warning "><i class="fa fa-times-circle-o"></i> Batalkan</a>
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
        getPetajabatan();
        $('#batalkan,#back,#back-simpan').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
        $('#simpan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action') + '/edit' ,
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='4'){
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
    });

    function getPetajabatan(){
        $.ajax({
            url : '{!!url('')!!}/eformasi/petajabatan/data/petajabatan',
            type : 'post',
            data : $('#form-petajabatan').serialize(),
            beforeSend:function(){
                $('#result').html('<i class="fa fa-spinner"></i> Loading...');
            },
            success:function(response){
                $('#result').html(response);
            }
        });
    }
</script>