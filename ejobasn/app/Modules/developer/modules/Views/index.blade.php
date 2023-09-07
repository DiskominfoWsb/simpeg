<section class="content-header">
    <h1>
        Modules<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li class="active">Modules</li>
    </ol>
</section>
<section class="content">
    <div class="box box-success">
      <div class="box-header with-border">
        {!! ClaravelHelpers::btnCreate() !!}
        <div class="box-tools pull-right">
        </div>
      </div>
      {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
      <div class="table-responsive">
      <div class="box-body no-padding">
        <table class="table table-striped table-hover table-bordered table-condensed" id="tabel">
          <thead class="" style="background-color: #00a65a;color:#ffffff">
            <tr>
              <th><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="Pilih Semua"></th>
              <th>Name</th>
              <th>Path</th>
              <th>Controller</th>
              <th>Act.</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($modules as $module)
            <tr>
              <th>
                <center>
                @if ($module->module_path != 0) 
                {!! ClaravelHelpers::ckDelete($module->id); !!}
                @endif
                </center>
              </th>   
              <td>{!!$module->context->name!!} / {!!$module->name!!}</td>
              <td>{!!$module->path!!}</td>
              <td>{!!$module->uses!!}</td>
              <td>
                @if ($module->module_path != 0) 
                {!! ClaravelHelpers::btnDelete($module->id); !!}
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      </div>
      <div class="box-footer">
        {!! ClaravelHelpers::btnDeleteAll() !!}
      </div>
      {!! Form::close() !!}
    </div>
</section>
<script type="text/javascript">
  $(document).ready(function(){

    $('.checkme,.checkall').on('change',function(){
      if($(this).is(':checked'))
        $('#deleteall').fadeIn(300);
      else
        $('#deleteall').fadeOut(300);
    });

    $('#buat').on('click',function(e){
      e.preventDefault();
      $.ajax({
        url : $(this).attr('href'),
        type : 'get',
        beforeSend: function(){
          preloader.on();
        },
        success:function(html){
          preloader.off();
          $('#utama').html(html);
        }
      });
    });

    <?php
    echo 'var index_page=laravel_base + "/'.\Request::path().'";';
    ?>

    $('#tabel').on('click','#hapus',function(e){
        e.preventDefault();
        var $this =$(this);
        bootbox.confirm('Hapus Modul?',function(a){
            if(a == true){
                $.ajax({
                    url : index_page + '/delete',
                    type : 'post',
                    data: {'id' : $this.attr('recid'), '_token' : '{{csrf_token()}}'},
                    beforeSend: function(){
                      preloader.on();
                    },
                    success:function(html){
                      preloader.off();
                      notification('Modul berhasil dihapus','success');
                      $this.closest('tr').fadeOut(300,function(){
                          $(this).remove();
                      });
                    }
                });
            }
        });
    });

    $('#tabel').on('click','#edit',function(e){
        e.preventDefault();
        var $this =$(this);
        $.ajax({
            url : index_page + '/edit',
            type : 'get',
            data:'id=' + $this.attr('recid'),
            beforeSend: function(){
              preloader.on();
            },
            success:function(html){
              preloader.off();
              $('#utama').html(html);
            }
        });
    });

    $('#data').on('submit',function(e){
      e.preventDefault();
      var iki = $(this);
      bootbox.confirm('Hapus beberapa modul?',function(r){
        if(r){
          $.ajax({
            url : iki.attr('action') + '/delete',
            type : 'post',
            data:iki.serialize(),
            beforeSend: function(){
              preloader.on();
            },
            success:function(html){
              preloader.off();
              notification('Modul berhasil dihapus','success');
              iki.find('input[type=checkbox]').each(function (t){
                if($(this).is(':checked')){
                  $(this).closest('tr').fadeOut(100)                                        
                }
              });
              $('#deleteall').fadeOut(300);
            }
          });
        }
      });            
    });

  });
</script>
