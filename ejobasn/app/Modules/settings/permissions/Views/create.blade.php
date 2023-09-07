
<section class="content-header">
    <h1>
        Create New Permissions<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Permissions</a></li>
        <li class="active">Create New Permissions</li>
    </ol>
</section>
<section class="content">
  <div class="box box-success">
    <div class="box-body">
    {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}  	
  	<div class="col-md-5">
		<div class="form-group">
			{!! Form::label('name', 'Name:', array('class' => 'col-sm-3 control-label')) !!}
			<div class="col-sm-7">
				{!! Form::text('name', null, array('class'=> 'form-control')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('description', 'Description:', array('class' => 'col-sm-3 control-label')) !!}
			<div class="col-sm-7">
				{!! Form::text('description', null, array('class'=> 'form-control')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('status', 'Status:', array('class' => 'col-sm-3 control-label')) !!}
			<div class="col-sm-7">
				{!! Form::select('status', array('In Active' => 'In Active', 'Active' => 'Active'), 'Active') !!}
			</div>
		</div>
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
  	$('select').addClass('form-control');
    $('#batalkan,#back').on('click',function(e){
        e.preventDefault();
        refresh_page();
    });
    $('#simpan').on('submit',function(e){
      var $this = $(this);
      e.preventDefault();
      bootbox.confirm('Simpan Permissions?',function(a){
        if (a == true){
          $.ajax({
            url : $this.attr('action'),
            type : 'POST',
            data : $this.serialize(),
            beforeSend: function(){
              preloader.on();
            },
            success:function(){
              notification('Permissions berhasil dibuat','success');
              refresh_page();
            }
          });
        }
      });
    });
  });
</script>
