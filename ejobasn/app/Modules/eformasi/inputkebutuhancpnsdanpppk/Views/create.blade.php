<section class="content-header">
    <h1>
        Buat Inputkebutuhancpnsdanpppk Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Inputkebutuhancpnsdanpppk</a></li>
        <li class="active">Buat Inputkebutuhancpnsdanpppk Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-success">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                				<div class="form-group">
					{!! Form::label('periode_bulan', 'periode_bulan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('periode_bulan', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('periode_tahun', 'periode_tahun:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('periode_tahun', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kdunit', 'kdunit:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kdunit', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idskpd', 'idskpd:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idskpd', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenjab', 'idjenjab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenjab', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabjbt', 'idjabjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabjbt', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabfung', 'idjabfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabfung', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabfungum', 'idjabfungum:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabfungum', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabnonjob', 'idjabnonjob:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabnonjob', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('namajabatan', 'namajabatan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('namajabatan', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('abk', 'abk:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('abk', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idmatkulpel', 'idmatkulpel:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idmatkulpel', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idtugasdokter', 'idtugasdokter:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idtugasdokter', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idtkpendid', 'idtkpendid:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idtkpendid', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenjurusan', 'idjenjurusan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenjurusan', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('user_id', 'user_id:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('user_id', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('role_id', 'role_id:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('role_id', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('created_at', 'created_at:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('created_at', null, array('class'=> 'form-control')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('updated_at', 'updated_at:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('updated_at', null, array('class'=> 'form-control')) !!}
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
