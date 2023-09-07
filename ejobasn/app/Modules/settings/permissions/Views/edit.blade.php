
<section class="content-header">
    <h1>
        Edit Permissions<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Permissions</a></li>
        <li class="active">Edit Permissions</li>
    </ol>
</section>
<section class="content">
  <div class="box box-success">
    <div class="box-body">
    <?php
      $rpos = strrpos(\Request::path(), '/'); 
      $uri = substr(\Request::path(), 0, $rpos);
    ?>
    {!! Form::model($permissions, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan' )) !!}
    {!! Form::hidden('id') !!} 
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
          {!! Form::select('status', array('In Active' => 'In Active', 'Active' => 'Active')) !!}
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
            url : $this.attr('action') + '/edit' ,
            type : 'POST',
            data : $this.serialize(),
            beforeSend: function(){
              preloader.on();
            },
            success:function(html){
              notification('Permissions berhasil diedit','success');
              refresh_page();
            }
          });
        }
      });
    });
  });
</script>

