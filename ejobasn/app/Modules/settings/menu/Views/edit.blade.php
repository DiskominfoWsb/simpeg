<section class="content-header">
    <h1>
        Edit Pengaturan Jadwal<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Pengaturan Jadwal</a></li>
        <li class="active">Edit Pengaturan Jadwal</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <?php
        $rpos = strrpos(\Request::path(), '/');
        $uri = substr(\Request::path(), 0, $rpos);
        ?>
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($menu, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
                {!! Form::hidden('id') !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('periode_tahun', 'Reriode Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!!comboTahun("periode_tahun",$menu->periode_tahun,"disabled",$holder='.: Pilihan :.')!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('periode_bulan', 'Periode Bulan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!!comboBulan("periode_bulan",$menu->periode_bulan,"disabled",".: Pilihan :.")!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('mulai', 'Tanggal Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            <div class='input-group date' id='datepicker1'>
                                <input type='text' name="mulai" class="form-control datetime" value="{!!$menu->mulai!!}"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('selesai', 'Tanggal Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            <div class='input-group date' id='datepicker2'>
                                <input type='text' name="selesai" class="form-control datetime" value="{!!$menu->selesai!!}"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('id_jenis', 'Jenis Jadwal:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!!MenuModel::comboTugasJabatan("id_jenis",$menu->id_jenis,"disabled",".: Pilihan :.")!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('judul', 'Judul Jadwal:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! Form::text('judul', null, array('class'=> 'form-control', 'placeholder'=> 'Judul Jadwal')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('keterangan', 'Keterangan Jadwal:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            <textarea rows="3" cols="160" name="keterangan" class="form-control" placeholder="Keterangan Terkait Buka dan Tutup Jadwal">{!!$menu->keterangan!!}</textarea>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            {!! ClaravelHelpers::btnSave() !!}
                            &nbsp;
                            &nbsp;
                            {!! ClaravelHelpers::btnCancelEdit() !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

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
                $('#loading-state').fadeIn("slow");
            },
            success:function(html){
                $('#loading-state').fadeOut("slow");
                $('#utama').html(html);
            }
        });

    }
    $(document).ready(function(){
        $('select').select2();

        $('#datepicker1').datepicker({
            format:"yyyy-mm-dd",
            orientation: "top"
        });
        $('#datepicker2').datepicker({
            format:"yyyy-mm-dd",
            orientation: "top"
        });

        $('#batalkan,#back').on('click',function(e){
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
                            $('#loading-state').fadeIn("slow");
                        },
                        success:function(html){
                            $('#loading-state').fadeOut("slow");
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
</script>
