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
                success:function(html){
                    $('#utama').html(html);
                }
            });
             
    }
    $(document).ready(function(){
        $('#batalkan').on('click',function(e){
            e.preventDefault();
            $('.pull-right').trigger('click');
        });
        $('#form_profilb').validationEngine();
        $('#form_profilb').validationEngine('validate');
        $('#form_profilb').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            if($this.validationEngine('validate')){
                bootbox.confirm('Ganti Password?',function(a){
                    if (a == true){
                        $.ajax({
                            url : $this.attr('action'),
                            type : 'POST',
                            data : $this.serialize(),
                            success:function(html){
                                if(html == '4'){
                                    notification('Sukses Ganti Password');
                                    $('.pull-right').trigger('click');
                                    claravel_modal_close('main_modal');
                                }
                            }
                        });
                    }
                });
                
            }
        });
    });
</script>
<div class="alert alert-info">
    Isikan Tanpa Tanda Baca
</div>		
<div class="table-responsive">
    <?php
    $user = \UsersModel::find(\Session::get('user_id'));
    ?>
    {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form_profilb')) !!}
    <div class="col-md-10" style="padding-top: 40px">
        {!!Form::hidden('id',$user->id)!!}
        <div class="form-group">
                {!! Form::label('name', 'Password Lama:', array('class' => 'col-sm-5 control-label')) !!}
                <div class="col-sm-7">
                        {!! Form::password('password',array('class'=> 'validate[required] form-control')) !!}
                </div>
        </div>
        <div class="form-group">
                {!! Form::label('name', 'Password Baru:', array('class' => 'col-sm-5 control-label')) !!}
                <div class="col-sm-7">
                        {!! Form::password('password_baru1',array('id'=>'password_baru1','class'=> 'validate[required,minSize[5]] form-control')) !!}
                </div>
        </div>
        <div class="form-group">
                {!! Form::label('name', 'Konfirmasi Password Baru:', array('class' => 'col-sm-5 control-label')) !!}
                <div class="col-sm-7">
                        {!! Form::password('password_baru2',array('class'=> 'validate[required,minSize[5],equals[password_baru1]] form-control')) !!}
                </div>
        </div>

    </div>
    <div class="clearfix">
    </div>
    <hr>
    <div class="col-sm-offset-2 col-sm-10">
    {!! ClaravelHelpers::btnSave() !!}
    &nbsp;
</div>
  {!! Form::close() !!}
          	 
</div>
