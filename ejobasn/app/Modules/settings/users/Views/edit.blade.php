
<section class="content-header">
    <h1>
        Edit Users<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Users</a></li>
        <li class="active">Edit Users</li>
    </ol>
</section>
<section class="content">
  <div class="box box-success">
    <?php
      $rpos = strrpos(\Request::path(), '/'); 
      $uri = substr(\Request::path(), 0, $rpos);
    ?>
    <div class="row">
      <div class="col-md-12">
        {!! Form::model($users, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('id') !!}
        <div class="box-body">
          	<div class="form-group">
				{!! Form::label('name', 'Name:', array('class' => 'col-sm-2 control-label')) !!}
				<div class="col-sm-6">
					{!! Form::text('name', null, array('class'=> 'form-control')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('username', 'Username:', array('class' => 'col-sm-2 control-label')) !!}
				<div class="col-sm-6">
					{!! Form::text('username', null, array('class'=> 'form-control')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('email', 'Email:', array('class' => 'col-sm-2 control-label')) !!}
				<div class="col-sm-6">
					{!! Form::email('email', null, array('class'=> 'form-control')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('password', 'Password:', array('class' => 'col-sm-2 control-label')) !!}
				<div class="col-sm-6">
					{!! Form::password('password', array('class'=> 'form-control')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('role_id', 'Role:', array('class' => 'col-sm-2 control-label')) !!}
				<div class="col-sm-6">
					{!! Form::select('role_id', $roles) !!}
				</div>
			</div>         
        </div>
        <div class="box-footer">
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
              {!! ClaravelHelpers::btnSave(); !!}
              &nbsp;
              &nbsp;{!! ClaravelHelpers::btnCancelEdit(); !!}
            </div>
          </div> 
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
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
    $('.icp-auto').iconpicker();
    $('#batalkan,#back').on('click',function(e){
      e.preventDefault();
      refresh_page();
    });
    $('#simpan').on('submit',function(e){
      var $this = $(this);
      e.preventDefault();
      bootbox.confirm('Simpan User?',function(a){
        if (a == true){
          $.ajax({
            url : $this.attr('action') + '/edit' ,
            type : 'POST',
            data : $this.serialize(),
            beforeSend: function(){
              preloader.on();
            },
            success:function(html){
              notification('User berhasil diedit','success');
              refresh_page();
            }
          });
        }
      });
    });
  });
</script>
