<section class="content-header">
    <h1>
        Menu<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li class="active">Menu</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-md-1 pull-left" style="margin-bottom: 5px;"><p>&nbsp;</p></div>
            <div class="box-tools col-md-12 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables" border="0">
                    <tr>
                        <td width="1%">&nbsp;</td>
                        <td style="padding: 5px;" width="25%">
                            {!! ClaravelHelpers::btnCreate() !!}&nbsp;
                            <!-- <a id="generate" href="javascript:void(0)" class="btn btn-success"><i class="fa fa-fire"></i> Jadwal Bulanan</a> -->
                        </td>
                        <!-- <td style="padding: 5px;" width="25%">
                            {!!MenuModel::comboTugasJabatan("id_jenis",\Input::get('id_jenis'),"",".: Pilihan Jenis Jadwal :.")!!}
                        </td>
                        <td style="padding-right: 5px;" width="10%">
                            {!!comboBulan("bulan",\Input::get('bulan'),"",".: Bulan :.")!!}
                        </td>
                        <td width="10%">
                            {!!comboTahun("tahun",\Input::get('tahun'),"",$holder='.: Tahun :.')!!}
                        </td>
                        <td style="padding: 5px;" width="30%">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}" placeholder="Searching..">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                                </span>
                            </div>
                        </td> -->
                    </tr>
                </table>
                {!! Form::close() !!}
            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center" rowspan="2" width="3%">NO</th>
                        <th class="text-center" colspan="2">PERIODE</th>
                        <th class="text-center" rowspan="2" >JENIS JADWAL</th>
                        <th class="text-center" colspan="2">PENJADWALAN</th>
                        <th class="text-center" rowspan="2" >JUDUL</th>
                        <th class="text-center" rowspan="2" >KETERANGAN</th>
                        <th class="text-center" rowspan="2"  width="7%">ACT.</th>
                    </tr>
                    <tr>
                        <th class="text-center">TAHUN</th>
                        <th class="text-center">BULAN</th>
                        <th class="text-center">MULAI</th>
                        <th class="text-center">SELESAI</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                        $arr[0]= ""; $n = 0;
                        $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                    ?>
                    @foreach ($menus as $menu)
                    <?php
                        $x++;
                        $n++;
                        $arr[$n] = $menu->periode_tahun."_".$menu->periode_bulan;
                        if($arr[$n]!=$arr[$n-1]){
                        $x = 1;
                    ?>
                        <tr style="background-color:#E8E8E8">
                            <th style="position:relative;" colspan="7">
                                {!!strtoupper(namabulan($menu->periode_bulan))!!} {!!$menu->periode_tahun!!}
                            </th>
                            <th style="position:relative;" colspan="5">
                                {{-- <div class="text-right">
                                    &nbsp;<a href="#" class="text-primary editall" recperiodetahun="{!! $menu->periode_tahun !!}" recperiodebulan="{!! $menu->periode_bulan !!}"><i class="fa fa-pencil-square"></i>&nbsp;Edit All</a>
                                </div> --}}
                            </th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="text-center">{!!$x!!}</td>
                        <td class="text-center">{!!$menu->periode_tahun!!}</td>
                        <td class="text-center">{!!$menu->periode_bulan!!}</td>
                        <td>{!!$menu->jenis!!}</td>
                        <td>{!!$menu->mulai!!}</td>
                        <td>{!!$menu->selesai!!}</td>
                        <td>{!!$menu->judul!!}</td>
                        <td>{!!$menu->keterangan!!}</td>

                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>{!! ClaravelHelpers::btnEdit($menu->id) !!}</li>
                                    <li>{!! ClaravelHelpers::btnDelete($menu->id) !!}</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <p style="height: 50px;">&nbsp;</p>
        </div>
        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-6">
                    {!! ClaravelHelpers::btnDeleteAll() !!}
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
                            preloader.off();
                            notification(html,'success');
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
