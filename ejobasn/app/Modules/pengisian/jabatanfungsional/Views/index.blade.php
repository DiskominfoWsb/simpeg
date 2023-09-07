<section class="content-header">
    <h1>
        Jabatan Fungsional<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li class="active">Jabatan Fungsional</li>
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
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="" style="background-color: #00a65a;color:#ffffff">
                    <tr>
                        <th style="width:60pt">No.</th>
                    <th>Kode Jabatan</th>
                    <th>Jabatan Fungsional</th>
                    <th>Kode Tingkat</th>
                    <th>Kelompok Jabatan</th>
                    <th>Kelas Jabatan</th>
                    <th>Jenjang</th>
                    <th>Usia Pensiun</th>
                    <th>Kategori Jabatan</th>
                    <th>Pendidikan</th>
                    <th>Jurusan</th>
                    <th width="7%">Act.</th>
                    </tr>
                    </thead>   
                    
                    <tbody>
                         <?php $i = ($jabatanfungsionals->currentPage() - 1) * $jabatanfungsionals->perPage() + 1;  ?>
                    @foreach ($jabatanfungsionals as $jabatanfungsional)
                    <tr>
                        <td><center>{!! $i++ !!}</center></td>
                    <td>{!!$jabatanfungsional->idjabfung!!}</td>
                    <td>{!!$jabatanfungsional->jabfung!!}</td>
                    <td>{!!$jabatanfungsional->tingkat!!}</td>
                    <td>{!!$jabatanfungsional->jabfung2!!}</td>
                    <td>{!!$jabatanfungsional->kelas_jabatan!!}</td>
                    <td>{!!$jabatanfungsional->tkpendid!!}</td>
                    <td>{!!$jabatanfungsional->pens!!}</td>
                    <td>{!!$jabatanfungsional->kategori!!}</td>
                    {{-- <!-- <td>{!!$jabatanfungsional->tkpendid!!}</td> --> --}}
                    <td>{!!JabatanfungsionalModel::getJenisPendidikan($jabatanfungsional->idtkpendid)!!}</td>
                    <td>{!!JabatanfungsionalModel::getJenisjurusan($jabatanfungsional->idrumpunpendid,$jabatanfungsional->idjenjurusan)!!}</td>

                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>{!! ClaravelHelpers::btnEdit($jabatanfungsional->idjabfung) !!}</li>
                                    <li>{!! ClaravelHelpers::btnDelete($jabatanfungsional->idjabfung) !!}</li>
                                </ul>
                            </div>
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
                {!! ClaravelHelpers::btnDeleteAll() !!}
            </div>
            <div class="col-sm-6">
                <?php echo $jabatanfungsionals->appends(array('search' => Input::get('search')))->render(); ?>
            </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>         

<script>
    function refresh_page(){
        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
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
        $('.pagination').addClass('pagination-sm no-margin pull-right');
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
                //url : laravel_base + '/' + $(this).attr('href'),
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
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/delete',
                        type : 'post',
                        data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            if(html=='9'){
                                notification('Berhasil Dihapus','success');
                                preloader.off();
                                $this.closest('tr').fadeOut(300,function(){
                                    $(this).remove();
                                });
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
        $('#tabel').on('click','#edit',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Edit?',function(a){
                if(a == true){
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
                }
            });
        });
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
        $('#data').on('submit',function(e){
            e.preventDefault();
            var iki = $(this);
            bootbox.confirm('Hapus?',function(r){
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
                            notification(html,'success');
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