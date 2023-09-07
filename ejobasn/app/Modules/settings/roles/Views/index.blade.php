
<section class="content-header">
    <h1>
        Roles<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li class="active">Roles</li>
    </ol>
</section>
<section class="content">
  <div class="box box-success">
    <div class="box-header with-border">
      {!! ClaravelHelpers::btnCreate(); !!}
      <div class="box-tools pull-right">
        
      </div>
    </div>
    {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
      {!!csrf_field()!!}
    <div class="table-responsive">
    <div class="box-body no-padding">
      <table class="table table-striped table-condensed table-hover" id="tabel">
        <thead class="" style="background-color: #00a65a;color:#ffffff">
          <tr>
            <th><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="right" title="Pilih Semua"></th>
            <th>Name</th>
            <th>Description</th>
            <th>Login Destination</th>
            <th>Status</th>
            <th>Act.</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($roless['data'] as $key => $roles)
          <?php 
          $name="";
          if ($roless['level'][$key] > 0) :
             $name= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$roless['level'][$key])." ".$roles->name; 
          else :
            $name=$roles->name;
          endif; 
          ?>  
          <tr>
            <td><center>{!! ClaravelHelpers::ckDelete($roles->id); !!}</center></td>   
            <td>{!!$name!!}</td>
            <td>{!!$roles->description!!}</td>
            <td>{!!$roles->login_destination!!}</td>
            <td>{!!$roles->status!!}</td>
            <td>
            {!! ClaravelHelpers::btnEdit($roles->id); !!}
            &nbsp;
            {!! ClaravelHelpers::btnDelete($roles->id); !!}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    </div>
    <div class="box-footer clearfix">
      <div class="row">
        <div class="col-sm-6">
          {!! ClaravelHelpers::btnDeleteAll(); !!}
        </div>
        <div class="col-sm-6">

        </div>
      </div>
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
        bootbox.confirm('Hapus Context?',function(a){
            if(a == true){
                $.ajax({
                    url : index_page + '/delete',
                    type : 'post',
                    data:{'id':$this.attr('recid') , '_token' : '{{csrf_token()}}'},
                    beforeSend: function(){
                      preloader.on();
                    },
                    success:function(html){
                        notification('Context berhasil dihapus','success');
                        preloader.off();
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
      bootbox.confirm('Hapus beberapa permission?',function(r){
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
              notification('Context berhasil dihapus','success');
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

