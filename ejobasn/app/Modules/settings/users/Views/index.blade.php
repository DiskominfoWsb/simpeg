<section class="content-header">
    <h1>
        Users<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li class="active">Users</li>
    </ol>
</section>
<section class="content">
  <div class="box box-success">
    <div class="box-header with-border">
      {!! ClaravelHelpers::btnCreate() !!}
      <div class="box-tools pull-right">
        {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
          {!!csrf_field()!!}
        <div class="input-group" style="width: 200px;">
          <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
          </span>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
    {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
    <div class="table-responsive">
    <div class="box-body no-padding">
      <table class="table table-striped table-condensed table-hover table-bordered" id="tabel">
        <thead class="" style="background-color: #00a65a;color:#ffffff">
          <tr>
            <th><input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="Pilih Semua"></th>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>Act.</th>
          </tr>
        </thead>  
        <tbody>
          @foreach ($userss as $users)
          <tr>
            <td><center>{!! ClaravelHelpers::ckDelete($users->id); !!}</center></td>   
            <td>{!!$users->name!!}</td>
            <td>{!!$users->username!!}</td>
            <td>{!!$users->roles->name!!}</td>
            <td>
              {!! ClaravelHelpers::btnEdit($users->id); !!}
              &nbsp;
              {!! ClaravelHelpers::btnDelete($users->id); !!}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    </div>
    <div class="box-footer clearfix">
      <div class="row">
        <div class="col-sm-5">
          {!! ClaravelHelpers::btnDeleteAll(); !!}
        </div>
        <div class="col-sm-7">
          <?php echo $userss->appends(array('search' => Input::get('search')))->render(); ?>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</section>
<script type="text/javascript">
  $(document).ready(function(){

    $('#cari').on('submit',function(e){
      e.preventDefault();
      $.ajax({
        url : $(this).attr('action'),
        data:$(this).serialize(),
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
        bootbox.confirm('Hapus User?',function(a){
            if(a == true){
                $.ajax({
                    url : index_page + '/delete',
                    type : 'post',
                    data:{'id':$this.attr('recid') , '_token' : '{{csrf_token()}}'},
                    beforeSend: function(){
                      preloader.on();
                    },
                    success:function(html){
                        notification('User berhasil dihapus','success');
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
      bootbox.confirm('Hapus beberapa user?',function(r){
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
              notification('User berhasil dihapus','success');
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

