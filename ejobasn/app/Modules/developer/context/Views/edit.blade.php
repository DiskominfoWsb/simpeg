<section class="content-header">
    <h1>
        Edit Context<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Context</a></li>
        <li class="active">Edit Context</li>
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
        {!! Form::model($context, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('id') !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('module_path', 'Module Path:', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-6">
              <select id="module_path" name="module_path" class="form-control" readonly>
                <option value="1">modules</option>
              </select>
            </div>
          </div> 

          <div class="form-group">
            {!! Form::label('name', 'Name:', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-6">
              {!! Form::text('name', null, array('class'=> 'form-control', 'readonly' => 'true')) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('path', 'Path:', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-6">
              {!! Form::text('path', null, array('class'=> 'form-control')) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('uses', 'Controller:', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-6">
              {!! Form::text('uses', null, array('class'=> 'form-control')) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('icons', 'Icons:', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-3">
              <div class="input-group iconpicker-container">
                <input data-placement="bottomRight" class="form-control icp icp-auto iconpicker-element iconpicker-input" value="{!!$context->icons!!}" type="text" id="icons" name="icons">
                <span class="input-group-addon"><i class="fa fa-archive"></i></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
              <div class="checkbox">
                <label>
                  <input checked="checked" name="flag" type="checkbox" value="1" id="flag"> Aktif?
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
              <div class="checkbox">
                <label>
                  <input checked="checked" name="is_nav_bar" type="checkbox" value="1" id="is_nav_bar"> Is nav bar?
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('order', 'Order:', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-1">
              {!! Form::text('order', null, array('class'=> 'form-control')) !!}
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
    $('.icp-auto').iconpicker();
    $('#batalkan,#back').on('click',function(e){
      e.preventDefault();
      refresh_page();
    });
    $('#simpan').on('submit',function(e){
      var $this = $(this);
      e.preventDefault();
      bootbox.confirm('Simpan Context?',function(a){
        if (a == true){
          $.ajax({
            url : $this.attr('action') + '/edit' ,
            type : 'POST',
            data : $this.serialize(),
            beforeSend: function(){
              preloader.on();
            },
            success:function(html){
              notification('Context berhasil diedit','success');
              refresh_page();
            }
          });
        }
      });
    });
  });
</script>
