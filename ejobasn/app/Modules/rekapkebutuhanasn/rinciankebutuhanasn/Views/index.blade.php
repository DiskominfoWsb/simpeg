<section class="content-header">
    <h1>
        Rincian Kebutuhan ASN<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li class="active">Rincian Kebutuhan ASN</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Pilih bulan dan tahun</li>
                        <li>Pilih tombol Lihat Preview untuk melihat Preview Data</li>
                        <li>Pilih tombol Cetak PDF untuk mengunduh Laporan Peta Jabatan dalam format PDF</li>
                        <!-- <li>Pilih tombol Cetak Excel untuk mengunduh Laporan Peta Jabatan dalam format Excel</li> -->
                    </ul>
                </div>
                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-petajabatan', 'target'=>'_blank')) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('periode', 'Periode:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <div class="row">
                                <?php
                                    $periode_akhir = \DB::table('tr_petajab')
                                                    ->orderby('periode_tahun','desc')
                                                    ->orderby('periode_bulan','desc')
                                                    ->first();
                                ?>

                                <div class="col-md-6">{!! comboBulanpetajab("periode_bulan",$periode_akhir->periode_bulan,"") !!}</div>
                                <div class="col-md-6">
                                    <div id="tahunpetajab">
                                        {!! comboTahunpetajab("periode_tahun",$periode_akhir->periode_tahun,"",$periode_akhir->periode_bulan) !!}
                                        <!-- <select class="form-control" style="width:100%;">
                                            <option class="form-control">.: Pilihan :.</option>
                                        </select> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            @if(Session::get('role_id') <= 3)
                            {!!comboSkpd("idskpd","","",Session('idskpd'))!!}
                            @else
                            <input type="hidden" name="idskpd" class="form-control" value="{!!Session('idskpd')!!}">
                            <input type="text" name="skp" class="form-control" value="{!!getSkpd(Session('idskpd'))!!}" disabled>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            <button class="btn btn-primary" type="button" id="prev-rekap"><i class="fa fa-list-ul"></i> Lihat Preview</button>
                            <button class="btn btn-success" type="button" id="cetak-rekap"><i class="fa fa fa-print"></i> Expor</button>
                            <!-- <button class="btn btn-success" type="button" id="cetak-excel"><i class="fa fa-file-excel-o"></i> Cetak Excel</button> -->
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div id="result" class="table-responsive"></div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
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

     $('#prev-rekap').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type: 'post',
                url : '{!!url("rekapkebutuhanasn/rinciankebutuhanasn/data/rekap")!!}',
                data : $('#form-petajabatan').serialize(),
                beforeSend:function(){
                    $('#result').html('<i class="fa fa-spinner"></i> Looading..');
                },
                success:function(response){
                    $('#result').html(response);
                }
            });
        });
    
    
    $(document).ready(function(){
        $('select').select2();
    });
</script>
