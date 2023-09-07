<section class="content-header">
    <h1>
        Buat Jurusan Pendidikan Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Jurusan Pendidikan</a></li>
        <li class="active">Buat Jurusan Pendidikan Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-success">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('idjenjurusan', 'Kode Jurusan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-2">
                        {!! Form::text('idjenjurusan', null, array('class'=> 'form-control','placeholder'=>'Kode Jurusan')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('jenjurusan', ' Nama Jurusan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('jenjurusan', null, array('class'=> 'form-control','placeholder'=>'Nama Jurusan')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('idrumpunpendid', 'Rumpun Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-3">
                        {!! comboRumpunpendidikan("idrumpunpendid","","") !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('idtkpendid', 'Tingkat Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-3">
                        {!! comboTkpendidikan("idtkpendid","","") !!}
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
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        }); 
    }
    $(document).ready(function(){
        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
        $('#simpan').validationEngine();
        $('#simpan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            if($this.validationEngine('validate')){
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

            }
        });
    });
</script>
