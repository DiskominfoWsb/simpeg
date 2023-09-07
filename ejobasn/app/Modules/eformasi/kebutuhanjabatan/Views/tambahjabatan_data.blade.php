<?php
    $idskpd = Input::get('idskpd');
    $kdunit = substr($idskpd,0,2);
    $periode_bulan = Input::get('periode_bulan');
    $periode_tahun = Input::get('periode_tahun');


    $rs = \DB::table(\DB::Raw(config('global.kepegawaian').'.a_skpd as a'))
        ->select(\DB::raw('a.skpd as subskpd, b.skpd','a.idtkpendid','a.idjenjurusan'))
        ->leftJoin(\DB::Raw(config('global.kepegawaian').'.a_skpd as b'), 'b.idskpd', '=', \DB::raw('left(a.idskpd,2)'))
        ->where('a.idskpd', $idskpd)->first();

    // dd($rs);
?>

@if(!empty($rs))
{!! Form::open(array('url' => url('').'/eformasi/kebutuhanjabatan/savejabfungum', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-jabfungum')) !!}
    <input type="hidden" name="periode_bulan" value="{!!$periode_bulan!!}">
    <input type="hidden" name="periode_tahun" value="{!!$periode_tahun!!}">
    <input type="hidden" name="kdunit" value="{!!$kdunit!!}">
    <input type="hidden" name="idskpd" value="{!!$idskpd!!}">
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
    </table>

    <a href="" class="btn btn-primary" title="tambah" id="add_btn" recid=""><i class="fa fa-plus"></i> Jabatan Fungsional/Pelaksana</a>
    {{-- <button class="btn btn-primary" istype="button"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Jabatan Fungsional/Pelaksana</button> --}}
    <p>
    <table id="tabledata" class="table table-striped table-bordered">
        <thead class="bg-primary">
        <tr>
            <th width="30%">Jenis Jabatan</th>
            <th width="40%">Nama Jabatan</th>
            <th width="10%">Jumlah ABK</th>
            <th width="10%">Aksi</th>
        </tr>
        </thead>

        <tbody id="kontenjabatan"></tbody>
    </table>
    </p>
    <div class="pull-right">
        <button id="" type="submit" class="btn btn-success"><i class="fa fa-forward"></i> Simpan</button>
    </div>
{!! Form::close() !!}
@else
    Jabatan tidak tersedia.
@endif

<script type="text/javascript">
    $(document).ready(function(){

        $('#add_btn').click(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var nomor = $('#kontenjabatan tr').length + 1;
            $('#kontenjabatan').append('<tr>'
                    +'<td><select name="idjenjab[]" class="form-control" id="idjenjab'+nomor+'"><option value="">.: Pilihan :.</option><option value="2">Jabatan Fungsional</option><option value="3">Jabatan Pelaksana</option></select></td>'
                    +'<td><div id="jabatan'+nomor+'">'+
                        '<select id="idjabatan'+nomor+'" name="idjabatan[]" class="form-control">'+
                        '<option class="form-control">.: Pilihan :.</option>'+
                        '</select>'+
                        '</div><div id="xguru'+nomor+'"></div><div id="xdokter'+nomor+'"></div></td>'
                    +'<td><input class="form-control" align="right" type="text" name="abk[]" value="1"></td>'
                    +'<td><a href="" class="btn btn-danger" title="Hapus" id="hapusjabatan" recid=""><i class="fa fa-times"></i></a></td>'
                    +'</tr><tr><td colspan="4"><div id="xtkpendid'+nomor+'"></div></td></tr>'
            );
            $('#idjenjab'+nomor).select2();
            $('#idjabatan'+nomor).select2();
            $('#idjenjab'+nomor).on('change',function(e){
                var $this = $(this);
                e.preventDefault();
                loading('jabatan'+nomor)
                if($this.val() == 2){
                    $('#jabatan'+nomor).html('<select id="idjabatan'+nomor+'" name="idjabatan[]" class="form-control"></select>');
                    autoComplete('#idjabatan'+nomor, '{{url('')}}/eformasi/kebutuhanjabatan/jabfung', '.: Pilihan :.', null, '', '', '');
                } else if ($this.val() == 3){
                    $('#jabatan'+nomor).html('<select id="idjabatan'+nomor+'" name="idjabatan[]" class="form-control"></select>');
                    autoComplete('#idjabatan'+nomor, '{{url('')}}/eformasi/kebutuhanjabatan/jabfungum', '.: Pilihan :.', null, '', '', '');
                } else {
                    $('#jabatan'+nomor).html('<select id="idjabatan'+nomor+'" name="idjabatan[]" class="form-control"><option class="form-control">.: Pilihan :.</option></select>');
                    $('#idjabatan'+nomor).select2();
                }

                $('#idjabatan'+nomor).on('change',function(e){
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    var idjab = $('#idjabatan'+nomor).val();     

                    if($('#idjenjab'+nomor).val() == 3){
                        var urlpendidikan = '{!!url('')!!}/eformasi/kebutuhanjabatan/tkpendidjur';
                    } else if($('#idjenjab'+nomor).val() == 2){
                        var urlpendidikan = '{!!url('')!!}/eformasi/kebutuhanjabatan/tkpendidjurfung';
                    }
                                    
                    $.ajax({
                        url : urlpendidikan,
                        type : 'POST',
                        data : {'idjab': idjab, 'count': nomor, '_token': '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(data){
                            preloader.off();                            
                            $('#xtkpendid'+nomor).html(data);     

                            if(idjab.substr(0, 3) == '300'){
                                // guru dan dosen
                                 $('#xguru'+nomor).html('<select id="idmatkulpel'+nomor+'" name="idmatkulpel[]" class="form-control"></select>');
                                autoComplete('#idmatkulpel'+nomor, '{{url('')}}/eformasi/kebutuhanjabatan/matkulpel', '.: Mata Pelajaran :.', null, '', '', '');
                                $('#xdokter'+nomor).html('');
                            } else if(idjab.substr(0, 3) == '220'){
                                // dokter
                                $('#xdokter'+nomor).html('<select id="idtugasdokter'+nomor+'" name="idtugasdokter[]" class="form-control"></select>');
                                autoComplete('#idtugasdokter'+nomor, '{{url('')}}/eformasi/kebutuhanjabatan/tugasdokter', '.: Tugas Dokter :.', null, '', '', '');
                                $('#xguru'+nomor).html('');
                            } else {
                                $('#xguru'+nomor).html('');
                                $('#xdokter'+nomor).html('');
                            }
                        }
                    });
                });

            });
        });

        $('table#tabledata').on('click','#hapusjabatan',function(e){
            e.preventDefault();
            var $this = $(this);
            $this.closest('tr').remove(); 
        });

        $('#form-jabfungum').on('submit',function(e){
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
                                getKebutuhanjabatan();
                                claravel_modal_close('modal_notif2')
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