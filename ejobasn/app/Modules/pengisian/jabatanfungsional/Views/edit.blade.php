<section class="content-header">
    <h1>
        Edit Jabatan Fungsional<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Jabatan Fungsional</a></li>
        <li class="active">Edit Jabatan Fungsional</li>
    </ol>
</section>
<section class="content">
  <div class="box box-success">
    <?php
      $rpos = strrpos(\Request::path(), '/'); 
      $uri = substr(\Request::path(), 0, $rpos);
    ?>
    <div class="row">
      <div class="col-md-12">
        {!! Form::model($jabatanfungsional, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax') ,'id'=>'simpan')) !!}
        {!! Form::hidden('idjabfung') !!}
        <div class="box-body">
                <div class="form-group">
                    {!! Form::label('idjabfung', 'Kode Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-2">
                        {!! Form::text('idjabfung', null, array('class'=> 'form-control', 'maxlength'=>5, 'placeholder'=>'Kode Jabatan', 'disabled'=>'disabled')) !!}
                    </div>
                    <div class="col-sm-2">
                        {!! Form::text('tingkat', null, array('class'=> 'form-control', 'maxlength'=>3, 'placeholder'=>'Tingkat', 'readonly'=>'readonly', 'id'=>'tingkat')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('jabfung2', 'Kelompok Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('jabfung2', null, array('class'=> 'form-control', 'placeholder'=>'Nama Jabatan dan Tingkat')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('jabfung', 'Jabatan Fungsional:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('jabfung', null, array('class'=> 'form-control', 'placeholder'=>'Nama Jabatan Fungsional')) !!}
                    </div>
                </div>
                {{-- <div class="form-group">
                    {!! Form::label('jenjang', 'Jenjang:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('jenjang', null, array('class'=> 'form-control', 'placeholder'=>'Jenjang Jabatan')) !!}
                    </div>
                </div> --}}
                <div class="form-group">
                    {!! Form::label('pens', 'Usia Pensiun:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('pens', null, array('class'=> 'form-control num', 'placeholder'=>'Usia Pensiun', 'maxlength'=>2)) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('isguru', 'Kategori Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <label class="radio-inline">
                            <input type="radio" value="1" id="opt1" name="isguru" {{($jabatanfungsional->isguru==1)?'checked':''}}> Tenaga Pendidikan / Guru
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="2" id="opt2" name="isguru" {{($jabatanfungsional->isguru==2)?'checked':''}}> Tenaga Kesehatan
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="3" id="opt3" name="isguru" {{($jabatanfungsional->isguru==3)?'checked':''}}> Tenaga Teknis
                        </label>
                    </div>
                </div>

                <span id="xtugasguru">
                    <div class="form-group">
                        {!! Form::label('idtugasgurudosen', 'Tugas Guru:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! comboTgsgurudosen("idtugasgurudosen",((count($jabatanfungsional) > 0)?$jabatanfungsional->idtugasgurudosen:''),"")!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idmatkulpel', 'Mata Pelajaran:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <select name="idmatkulpel" class="form-control" id="idmatkulpel" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                            {!! Form::hidden('matkulpel', ((count($jabatanfungsional) > 0)?$jabatanfungsional->matkulpel:''), array('class'=> 'form-control', 'id'=> 'matkulpel')) !!}
                        </div>
                    </div>
                </span>
                <span id="xtugasdokter">
                    <div class="form-group">
                        {!! Form::label('idtugasdokter', 'Tugas Dokter:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! comboTgsdokter("idtugasdokter",((count($jabatanfungsional) > 0)?$jabatanfungsional->idtugasdokter:''),"","")!!}
                        </div>
                    </div>
                </span>

                <div class="form-group">
                    {!! Form::label('tkpendid', 'Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-4">
                        {!! comboTkpendidikanMulti($id="idtkpendid[]",$sel=$jabatanfungsional->idtkpendid,$required="multiple") !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rumpunpendid', 'Rumpun Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-4">
                        {!! comboRumpunpendidikanMulti($id="idrumpunpendid[]",$sel=$jabatanfungsional->idrumpunpendid,$required="multiple") !!}
                    </div>
                </div>

                {{-- <div class="form-group">
                {!! Form::label('stspendid', 'Status Pendidikan Minimal:', array('class' => 'col-sm-3 control-label'))!!}
                    <div class="col-sm-7">
                        <label class="checkbox-inline">
                            <input type="checkbox" value="1" id="stspendid1" name="stspendid" {!!$jabatanfungsional->stspendid==1?'checked':''!!}> Minimal
                        </label>
                    </div>
                </div> --}}

                <div class="form-group">
                    {!! Form::label('jenis', 'Jurusan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! comboJenjurusanMulti($id="idjenjurusan[]",$sel=$jabatanfungsional->idjenjurusan,$required="multiple") !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('kelas_jabatan', 'Kelas Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('kelas_jabatan', null, array('class'=> 'form-control num', 'placeholder'=>'Kelas Jabatan', 'maxlength'=>2)) !!}
                    </div>
                </div>

                {{-- <div class="form-group">
                    {!! Form::label('tgs_jab', 'Tugas Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! Form::text('tgs_jab', null, array('class'=> 'form-control', 'placeholder'=>'Tugas Jabatan')) !!}
                    </div>
                </div> --}}

                <div class="form-group">
                    {!! Form::label('iddiklat','Diklat:', array('class'=>'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <table id="tableData2" class="table">
                            <tbody class='container1'>
                                @if($jabatanfungsional->iddiklat!='')
                                    <?php 
                                    $jenis_diklat = explode(", ", $jabatanfungsional->iddiklat); 
                                    $i = 0;

                                    $array=array_map('intval', explode(',', $jabatanfungsional->iddiklat));
                                    $array = implode("','",$array);

                                    $querydiklat = \DB::connection('kepegawaian')->table('diklat_fungsional')->whereRaw("iddikfung IN ('".$array."')")->get();
                                    
                                    ?>
                                    @foreach($jenis_diklat as $diklat)
                                    <?php $i++;?>
                                    <tr class="records">
                                        <td><select name="iddiklat[]" class="form-control iddiklat" id="iddiklat{!!$i!!}" style="width: 100%"></select></td>
                                        <td><button title="Delete" class="remove_item1 btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <button class="btn btn-primary add_btn1" type="button"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
                    </div>
                </div>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-7">
                    {!! ClaravelHelpers::btnSave() !!}
                    &nbsp;
                    &nbsp;
                    {!! ClaravelHelpers::btnCancelEdit() !!}
                </div>
            </div> 
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</section>
	
<script>
    function refresh_page(){
        <?php
        $index_page = explode('/', \Request::path());
        $jum = count($index_page) -1;
        unset ($index_page[$jum]);
        $index = join('/', $index_page);
        echo 'var index_page=laravel_base + "/'.$index.'";';
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
        $('select').select2();
        $("#idrumpunpendid").select2({
            placeholder: ".: Semua Rumpun Pendidikan :."
        });

        $("#idtkpendid").select2({
            placeholder: ".: Semua Tingkat Pendidikan :."
        });

        $("#idjenjurusan").select2({
            placeholder: ".: Semua Jurusan :."
        });

        loadAppend('.add_btn1', '.container1', 'iddiklat', 'count1', 'rows1_', 'remove_item1');
        
        <?php
        
        $i=1; 
        if($jabatanfungsional->iddiklat!=''):
        foreach ($querydiklat as $diklat): ?>
            autoComplete('#simpan #iddiklat{!!$i!!}', '{!!url('')!!}/pengisian/jabatanfungsional/diklat', '.: Pilihan :.', null, '', '', '');

            $("#simpan #iddiklat{!!$i!!}").data('select2').trigger('select', {
                data: {"id":"{!!$diklat->id!!}","text":"{!!$diklat->text!!}"}
            });
        <?php $i++;
        endforeach;
        endif; ?>

        $('.remove_item1').on('click', function (ev)
            {
                if (ev.type == 'click')
                {
                    $(this).parents(".records").fadeOut();
                    $(this).parents(".records").remove();
                }
            });
        


        
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        $('#idjabfung').on('keyup', function(e){
            e.preventDefault();
            if($("#idjabfung").val().length <= 3){
                $('#tingkat').val($('#idjabfung').val());
            }
        });

        $('#simpan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action') + '/edit' ,
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            if(html=='4'){
                                notification('Berhasil Disimpan','success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        autoComplete('#simpan #idjenjurusan', '{!!url('')!!}/pengisian/jabatanfungsional/jenjurusan', '.: Semua Jurusan :.', null, '', '', $('#idtkpendid').val(),$('#idrumpunpendid').val());

        $('#idtkpendid').on('change', function(e){
            e.preventDefault();
            var idjenjurusan = $(this).val();
            var idrumpunpendid = $('#idrumpunpendid').val();

            autoComplete('#simpan #idjenjurusan', '{!!url('')!!}/pengisian/jabatanfungsional/jenjurusan', '.: Semua Jurusan :.', null, '', '', idjenjurusan,idrumpunpendid);
            
        });

        $('#idrumpunpendid').on('change', function(e){
            e.preventDefault();
            if (changeRumpun()) {
                var idrumpunpendid = $(this).val();
                var idtkpendid = $('#idtkpendid').val();
                autoComplete('#simpan #idjenjurusan', '{!!url('')!!}/pengisian/jabatanfungsional/jenjurusan', '.: Semua Jurusan :.', null, '', '', idtkpendid, idrumpunpendid);
            }
        }); 


        if ('{!!$jabatanfungsional->isguru!!}' == '1') {
            $('#xtugasguru').fadeIn();
            $('#xtugasdokter').fadeOut();
        } else if ('{!!$jabatanfungsional->isguru!!}' == '2') {
            $('#xtugasguru').fadeOut();
            $('#xtugasdokter').fadeIn();
        } 
        else {
            $('#xtugasguru, #xtugasdokter').fadeOut();
        }

        autoComplete('#idmatkulpel', '{{url("")}}/pengisian/jabatanfungsional/matkulpel', '.: Pilihan :.', null, '{!!((count($jabatanfungsional) > 0)?$jabatanfungsional->idmatkulpel:'')!!}', '{!!((count($jabatanfungsional) > 0)?$jabatanfungsional->matkulpel:'')!!}', '');

        $('input:radio[name=isguru]').change(function() {
            if (this.value == '1') {
                $('#xtugasguru').fadeIn();
                $('#xtugasdokter').fadeOut();
            }
            else if (this.value == '2') {
                $('#xtugasguru').fadeOut();
                $('#xtugasdokter').fadeIn();
            } 
            else {
                $('#xtugasguru, #xtugasdokter').fadeOut();
            }
        });

        $('#idtugasgurudosen').on('change', function(e){
            e.preventDefault();
            autoComplete('#idmatkulpel', '{{url("")}}/pengisian/jabatanfungsional/matkulpel', '.: Pilihan :.', null, '', '',  $(this).val());
        });

        $('#idmatkulpel').on('change', function(e){
            e.preventDefault();
            $('#matkulpel').val($(this).find(":selected").text());
        });
    });

    function loadAppend(button, container, field, count, row, remove){
        count = 0;

        // DOM untuk data pelatihan kader
        $(button).click(function()
        {
            count++;
            $(container).append(
                '<tr class="records">'
                    +'<td><select name="'+field+'[]" class="form-control '+field+'" id="'+field+''+count+'" style="width: 100%"></select></td>'
                    +'<td><button title="Delete" class="'+remove+' btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button></td>'
                    +'</tr>'
            );

            autoComplete('#simpan #'+field+''+count, '{!!url('')!!}/pengisian/jabatanfungsional/diklat', '.: Pilihan :.', null, '', '', '');

            $('#simpan .'+remove).on('click', function (ev)
            {
                if (ev.type == 'click')
                {
                    $(this).parents(".records").fadeOut();
                    $(this).parents(".records").remove();
                }
            });
        });
    }

    function changeRumpun() {
         $.ajax({
            url: '{!!url('')!!}/pengisian/jabatanfungsional/chagerumpun',
            type: 'post',
            data: { 'rumpun': $('#idrumpunpendid').val(),'_token':'{!!csrf_token()!!}'},
            success:function(response){
                var ret = $.parseJSON(response);
                console.log(ret);
                $('#idjenjurusan').select2('val',ret.idjenjurusan);
                $('#idtkpendid').select2('val',ret.idtkpendid);
                return true;
            }
        });
     } 

</script>