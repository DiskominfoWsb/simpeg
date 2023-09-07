<section class="content-header">
    <h1>
        Configurations<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li class="active">Configurations</li>
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
      <table class="table table-striped table-condensed table-hover table-bordered" id="tabel">
        <thead class="" style="background-color: #00a65a;color:#ffffff">
          <tr>
            <th><input type="checkbox" name="checkall" id="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="Pilih Semua"></th>
            <th>Name</th>
            <th>Value</th>
            <th>Act.</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th colspan="5">
              {!! ClaravelHelpers::btnDeleteAll()!!}
            </th>
          </tr>
        </tfoot>  
        <tbody>
          @foreach ($configurationss as $configurations)
          <tr>
            <td><center>{!! ClaravelHelpers::ckDelete($configurations->id)!!}</center></td>    
            <td>{!!$configurations->name!!}</td>
            <td>{!!$configurations->value!!}</td>
            <td>
            {!! ClaravelHelpers::btnEdit($configurations->id)!!}
            &nbsp;
            {!! ClaravelHelpers::btnDelete($configurations->id)!!}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
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
        bootbox.confirm('Hapus Konfigurasi?',function(a){
            if(a == true){
                $.ajax({
                    url : index_page + '/delete',
                    type : 'post',
                    data:'id=' + $this.attr('recid'),
                    beforeSend: function(){
                      preloader.on();
                    },
                    success:function(html){
                      preloader.off();
                      notification('Konfigurasi berhasil dihapus','success');
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
      bootbox.confirm('Hapus beberapa Konfigurasi?',function(r){
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
              notification('Konfigurasi berhasil dihapus','success');
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
