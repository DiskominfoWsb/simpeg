<?php
    /*cek sudah ada petajabatan ditahun yang sama atau belum*/
    $x = 0;
    $idskpd = Input::get('idskpd');
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');
    $rscek = \DB::table('tr_petajab')
                ->where('periode_bulan', '=', $periode_bulan)
                ->where('periode_tahun', '=', $periode_tahun)
                ->where('idskpd','=',$idskpd)->count();

    $rs = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_skpd as skpd'))
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_tkpendid as a_tkpendid'),'skpd.idtkpendid', '=', 'a_tkpendid.idtkpendid')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jenjurusan as a_jenjurusan'), 'skpd.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
            ->leftJoin('tr_petajab', 'skpd.idskpd', '=', 'tr_petajab.idskpd')
            ->select('skpd.*','tr_petajab.id as idpet')
            ->where('skpd.idskpd','like',''.$idskpd.'%')->orderBy('skpd.idskpd','asc')->get();
            // dd($rs);
?>

@if($rscek > 0)
    <h4><b>Perhatian!</b> <br>Peta Jabatan pada bulan {!! $periode_bulan !!} {!!$periode_tahun!!} sudah pernah dibuat.<br>Silahkan lakukan edit Peta Jabatan melalui menu aksi edit & lanjutkan.</h4><br>
    <a href="javascript:void(0)" title="Edit & Lanjutkan" id="edit-lanjutkan" class="btn btn-success"><i class="fa fa-forward"></i> Edit & Lanjutkan</a>
@else
    {!! Form::open(array('url' => url('').'/eformasi/petajabatan/petajabatanprev', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-petajabatanprev')) !!}
    <div class="callout callout-success">
        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
        <ul style="padding-left: 15px">
            <li>Susunan jabatan struktural merupakan dasar pembuatan Peta Jabatan, data ini tergenerate otomatis dari E-Personal.</li>
            <li>Apabila terjadi kesalahan atau ditemukan susunan yang kurang tepat silahkan laporkan ke admin BKPP untuk dilakukan perubahan susunan.</li>
            <li>Untuk melanjutkan proses input Peta Jabatan pilih tombol simpan & lanjutkan, untuk membatalkan proses pilih tombol batalkan.</li>
        </ul>
    </div>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <thead class="bg-primary">
            <tr>
                <th width="5%">No</th>
                <th>Jabatan</th>
                <th>Pendidikan</th>
                <th>Jurusan</th>
                <th width="7%">Jumlah ABK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rs as $item)
            <?php $x++;?>
            <tr>
                <td>{!!$x!!}</td>
                <td>
                    <input type="hidden" name="{!!$x!!}[periode_bulan]" value="{!!$periode_bulan!!}">
                    <input type="hidden" name="{!!$x!!}[periode_tahun]" value="{!!$periode_tahun!!}">
                    <input type="hidden" name="{!!$x!!}[kdunit]" value="{!!substr($item->idskpd,0,2)!!}">
                    <input type="hidden" name="{!!$x!!}[idskpd]" value="{!!$item->idskpd!!}">
                    <input type="hidden" name="{!!$x!!}[idjenjab]" value="{!!$item->jab_asn!!}">
                    <input type="hidden" name="{!!$x!!}[idjabjbt]" value="{!!$item->idskpd!!}">
                    <input type="hidden" name="{!!$x!!}[namajabatan]" value="{!!$item->jab!!}">
                    <input type="hidden" name="{!!$x!!}[idtkpendid]" value="{!!$item->idtkpendid!!}">
                    <input type="hidden" name="{!!$x!!}[idjenjurusan]" value="{!!$item->idjenjurusan!!}">
                    <input type="hidden" name="{!!$x!!}[abk]" value="1">
                    {!!PetajabatanModel::length($item->idskpd)." ".$item->jab!!}
                </td>
                <td align="center">{!!($item->idtkpendid!='')? PetajabatanModel::getIdtkpendidskpd($item->idtkpendid,$item->idskpd):'-'!!}</td>
                <td>{!!PetajabatanModel::getJenisjurusan($item->idjenjurusan)!!}</td>
                <td>
                    <input class="form-control" align="right" type="text" name="abk" value="1">
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        <button id="" type="submit" class="btn btn-success"><i class="fa fa-forward"></i> Simpan & Lanjutkan</button>
        <a id="batalkan" href="javascript:void(0)" class="btn btn-warning " onclick="claravel_modal_close('modal_notif')"><i class="fa fa-times-circle-o"></i> Batalkan</a>
    </div>
    {!! Form::close() !!}
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('#edit-lanjutkan').on('click', function(e){
            e.preventDefault();
            getPetajabatan();
            claravel_modal_close('modal_notif');
        })
        $('#form-petajabatanprev').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan dan Lanjutkan ?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='1'){
                                getPetajabatan();
                                claravel_modal_close('modal_notif');
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
    });
</script>