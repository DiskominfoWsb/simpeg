<section class="content-header">
    <h1>
        Sinkronisasi Data <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}/dashboard"> Dashboard</a></li>
        <li class="active">Sinkronisasi Data</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="col-lg-3 pull-left" style="margin-bottom: 5px;">
                <div class="btn-group">&nbsp;</div>
            </div>
            <div class="box-tools pull-right col-lg-9 pull-right">
                {!! Form::open(array('url' => url().'/eformasi/kebutuhanjabatan/data/notifikasi_detail', 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables">
                    <tr>
                        <td style="padding: 5px;"><input type="hidden" name="id" id="id" value=""></td>
                        <td style="padding: 5px;" width="55%">
                            @if(session('role_id') <= 3)
                                <input type="hidden" name="idskpd" id="idskpd" value="">
                            @else
                                <input type="hidden" name="idskpd" id="idskpd" value="{!!session('idskpd')!!}">
                            @endif
                        </td>
                        <td style="padding: 5px;" width="35%">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}
            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">

                <div id="xsinkronisasi" class="tab-pane">
                    <p>
                    <div class="nav-tabs-custom" style="box-shadow:none;">
                        <ul class="nav nav-tabs tab2" id="myTab">
                            <li id="acv2" class="{!!(Request::segment(5)=='perbedaanopd')?'active':''!!}"><a data-toggle="tab" href="{!!url()!!}/eformasi/kebutuhanjabatan/data/notifikasi_detail" reced="2"><i class="fa fa-fw fa-dot-circle-o"></i> PERBEDAAN UNIT KERJA</a></li>
                            <li id="acv3" class="{!!(Request::segment(5)=='selisihopd')?'active':''!!}"><a data-toggle="tab" href="{!!url()!!}/eformasi/kebutuhanjabatan/data/notifikasi_detail" reced="3"><i class="fa fa-fw fa-dot-circle-o"></i> SELISIH UNIT KERJA</a></li>
                            <li id="acv4" class="{!!(Request::segment(5)=='selisihpetajab')?'active':''!!}"><a data-toggle="tab" href="{!!url()!!}/eformasi/kebutuhanjabatan/data/notifikasi_detail" reced="4"><i class="fa fa-fw fa-dot-circle-o"></i> SELISIH PETAJABATAN</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="rpangkat" class="tab-pane active">
                                <p>
                                <table class="table table-striped table-hover table-condensed table-bordered" id="table" role='grid' id="tb-rpangkat">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center" rowspan="2" width="3%">No</th>
                                            <th class="text-center" rowspan="2">Kode OPD</th>
                                            <th class="text-center" rowspan="2">Unit Kerja</th>
                                            <th class="text-center" colspan="2">Data Unit Kerja</th>
                                            <th class="text-center" colspan="2">Data Peta Jabatan</th>
                                            <th class="text-center" rowspan="2" width="7%">Act.</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Kode Jabatan</th>
                                            <th class="text-center">Nama Jabatan</th>
                                            <th class="text-center">Kode Jabatan</th>
                                            <th class="text-center">Nama Jabatan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="xresult"></tbody>
                                </table>
                                </p>
                            </div>

                                <!-- /.tab-pane -->
                        </div>
                    </div>
                    </p>
                </div>
            <!-- /.tab-pane -->

            </div>
        </div>

        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-6">
                    &nbsp;
                </div>
                <div class="col-sm-6">
                    &nbsp;
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>

<script>

    $(document).ready(function(){
        $('select').select2();
        $('ul#myTab').on('click','a',function(e){
            var str = $(this).attr('href');
            var n = str.search("dashboard");
            var id = $(this).attr('reced');
            loading('xresult');
            if(n > 0){

            }else{
                e.preventDefault();
                e.stopImmediatePropagation();
                preloader = new $.materialPreloader({
                    position: 'top',
                    height: '5px',
                    col_1: '#159756',
                    col_2: '#da4733',
                    col_3: '#3b78e7',
                    col_4: '#fdba2c',
                    fadeIn: 200,
                    fadeOut: 200
                });

                $.ajax({
                    type: 'post',
                    url : $(this).attr('href'),
                    data: {'id': id, '_token' : '{!!csrf_token()!!}'},
                    beforeSend: function(){
                        preloader.on();
                        $('ul#myTab li').removeClass('active');
                    },
                    success: function(data) {
                        preloader.off();
                        $('ul#myTab li#acv'+id).addClass('active');
                        $('#id').val(id);
                        $('#xresult').html(data);
                    }
                });
            }
        });

        $('ul#myTab li.active a').trigger('click');

        $('#table').on('click','#preview',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Preview Perubahan Data ?',function(a){
                if(a == true){
                    $.ajax({
                        url  : '{!!url()!!}/eformasi/kebutuhanjabatan/edit',
                        type : 'get',
                        data : {'periode_bulan' : $this.attr('actperiodebulan'), 'periode_tahun' : $this.attr('actperiodetahun'), 'idskpd' : $this.attr('actidskpd'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            claravel_modal_close('modal_notif');
                            $('#utama').html(html);
                        }
                    });
                }
            });
        });

        $('#cari').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url  : $(this).attr('action'),
                data : $(this).serialize(),
                type : 'post',
                beforeSend: function(){
                    loading('xresult');
                },
                success:function(html){
                    $('#xresult').html(html);
                }
            });
        });
    });
</script>
