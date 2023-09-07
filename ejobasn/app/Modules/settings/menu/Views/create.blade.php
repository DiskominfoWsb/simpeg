<section class="content-header">
    <h1>
        Buat Pengaturan Jadwal Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('') !!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Pengaturan Jadwal</a></li>
        <li class="active">Buat Pengaturan Jadwal Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('periode_tahun', 'Reriode Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!!comboTahun("periode_tahun","","required",$holder='.: Pilihan :.')!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('periode_bulan', 'Periode Bulan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!!comboBulan("periode_bulan","","required",".: Pilihan :.")!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('mulai', 'Tanggal Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            <div class='input-group date' id='datepicker1'>
                                <input type='text' name="mulai" class="form-control datetime" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                              <div class="input-group">
                                <input type="text" name="mulai_jam" class="form-control timepicker">
                                <div class="input-group-addon">
                                  <i class="fa fa-clock-o"></i>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('selesai', 'Tanggal Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            <div class='input-group date' id='datepicker2'>
                                <input type='text' name="selesai" class="form-control datetime" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                              <div class="input-group">
                                <input type="text" name="selesai_jam" class="form-control timepicker">
                                <div class="input-group-addon">
                                  <i class="fa fa-clock-o"></i>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('id_jenis', 'Jenis Jadwal:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!!MenuModel::comboTugasJabatan("id_jenis","","required",".: Pilihan :.")!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('judul', 'Judul Jadwal:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!! Form::text('judul', null, array('class'=> 'form-control', 'placeholder'=> 'Judul Jadwal')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('keterangan', 'Keterangan Jadwal:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            <textarea rows="3" cols="160" name="keterangan" class="form-control" placeholder="Keterangan Terkait Buka dan Tutup Jadwal"></textarea>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            {!! ClaravelHelpers::btnSave() !!}
                            &nbsp;
                            &nbsp;
                            {!! ClaravelHelpers::btnCancel() !!}
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
        // $(".datetime").mask("9999-99-99");
        $('#datepicker1').datepicker({
            format:"yyyy-mm-dd",
            orientation: "top"
        });
        $('#datepicker2').datepicker({
            format:"yyyy-mm-dd",
            orientation: "top"
        });
        // alert('sdada');
        // $('.timepicker').timepicker({
        //   showInputs: false
        // });

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
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            $('#loading-state').fadeIn("slow");
                        },
                        success:function(html){
                            $('#loading-state').fadeOut("slow");
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
    });
</script>
