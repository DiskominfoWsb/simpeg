<?php
    $idskpd = Input::get('idskpd');
    $kdunit = substr($idskpd,0,2);
    $idpetajab = Input::get('id');
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');
    $idjenjab = Input::get('idjenjab');

    $where = "a.idskpd = '".$idskpd."'";

    if($idjenjab > 4){
        $idjabatan = Input::get('idjabjbt');
        $where .= " and a.idjabjbt = '".$idjabatan."'";
    } else if ($idjenjab == 2){
        $idjabatan = Input::get('idjabfung');
        $where .= " and a.idjabfung = '".$idjabatan."'";
    } else if ($idjenjab == 3){
        $idjabatan = Input::get('idjabfungum');
        $where .= " and a.idjabfungum = '".$idjabatan."'";
    } else if ($idjenjab == 0){ //kepala sekolah
        
    }



    $rs = \DB::table('tr_petajab as a')
    		->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), 'b.idskpd', '=', \DB::raw('left(a.idskpd,2)'))
    		->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as c'), 'a.idskpd', '=', 'c.idskpd')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfung as d'), 'a.idjabfung', '=', 'd.idjabfung')
            ->leftjoin(\DB::Raw(config('global.kepegawaian').'.a_jabfungum as e'), 'a.idjabfungum', '=', 'e.idjabfungum')
    		->select(
    			\DB::raw('c.skpd as subskpd, b.skpd','c.idtkpendid','c.idjenjurusan'),
    			\DB::raw('IF(a.idjenjab>4,c.jab,IF(a.idjenjab=2,d.jabfung,IF(a.idjenjab=3,e.jabfungum,"-"))) as jab')
    		)
        	->whereRaw($where)->first();

    // dd($rs);
?>

@if(count($rs) > 0)
{!! Form::open(array('url' => url('').'/eformasi/kebutuhanjabatan/savediklat', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-diklat')) !!}
    <input type="hidden" name="idpetajab" value="{!!$idpetajab!!}">
    <input type="hidden" name="periode_bulan" value="{!!$periode_bulan!!}">
    <input type="hidden" name="periode_tahun" value="{!!$periode_tahun!!}">
    <input type="hidden" name="kdunit" value="{!!$kdunit!!}">
    <input type="hidden" name="idskpd" value="{!!$idskpd!!}">
    <input type="hidden" name="idjenjab" value="{!!$idjenjab!!}">
    <input type="hidden" name="idjabatan" value="{!!$idjabatan!!}">
    <table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
        <tr>
            <td>Unit Kerja</td>
            <td>:</td>
            <td>{!!$rs->skpd!!}</td>
        </tr>
        <tr>
            <td>Sub Unit Kerja</td>
            <td>:</td>
            <td>{!!$rs->subskpd!!}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{!!strtoupper($rs->jab)!!}</td>
        </tr>
    </table>

    <a href="" class="btn btn-primary" title="tambah" id="add_btn" recid=""><i class="fa fa-plus"></i> Diklat</a>
    {{-- <button class="btn btn-primary" istype="button"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Jabatan Fungsional/Pelaksana</button> --}}
    <p>
    <table id="tabledata" class="table table-striped table-bordered">
        <thead class="bg-primary">
        <tr>
            <th width="70%">Nama Diklat</th>
            <th width="10%">Aksi</th>
        </tr>
        </thead>

        <tbody id="kontendiklat">
            <?php
                $diklat = \DB::table('tr_petajab_detail')
                            ->where('idpetajab','=',$idpetajab)
                            ->where('periode_bulan','=',$periode_bulan)
                            ->where('periode_tahun','=',$periode_tahun)
                            ->where('idskpd','=',$idskpd)
                            ->where('idjenjab','=',$idjenjab)
                            ->where('idjabatan','=',$idjabatan)
                            ->get();
                $no = 1
            ?>
            @if(count($diklat)>0)
                @foreach($diklat as $d)
                    <tr>
                        <td>{!! comboDiklat("iddiklat".$no,"iddiklat[]",$d->iddiklat,"",$idjenjab) !!}</td>
                        <td><a href="" class="btn btn-danger" title="Hapus" id="hapusdiklat" recid=""><i class="fa fa-times"></i></a></td>
                    </tr>
                    <?php $no++;?>
                @endforeach
            @endif
        </tbody>
    </table>
    </p>
    <div class="pull-right">
        <button id="" type="submit" class="btn btn-success"><i class="fa fa-forward"></i> Simpan</button>
    </div>
{!! Form::close() !!}
@else
    Diklat tidak tersedia.
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('select').select2();

        $('table#tabledata').on('click','#hapusdiklat',function(e){
            e.preventDefault();
            var $this = $(this);
            $this.closest('tr').remove(); 
        });

        $('#form-diklat').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan Jabatan ?',function(a){
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
                                notification('Berhasil Disimpan','success');
                                getKebutuhanjabatan();
                                claravel_modal_close('modal_notif2');
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#form-diklat').on('click','#add_btn',function(e){
		    e.preventDefault();
		    e.stopImmediatePropagation();
		    var nomor = $('#kontendiklat tr').length + 1;
		    $('#kontendiklat').append(`<tr>
		    		<td>{!! comboDiklat("iddiklat`+nomor+`","iddiklat[]","","",$idjenjab) !!}</td>
		            <td><a href="" class="btn btn-danger" title="Hapus" id="hapusdiklat" recid=""><i class="fa fa-times"></i></a></td>
		            </tr>`
		    );
		    $('select').select2();
		});
		
    });
</script>