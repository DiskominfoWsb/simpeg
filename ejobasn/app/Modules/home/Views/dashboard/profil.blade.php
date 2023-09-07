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
        $('#form_profila').validationEngine();
        $('#form_profila').validationEngine('validate');
        
        $('#form_profila').on('submit',function(e){
            var $this = $(this);
			var formData = new FormData(this);
            e.preventDefault();
            if($this.validationEngine('validate')){
                bootbox.confirm('Simpan data?',function(a){
                    if (a == true){
                        $.ajax({
                            url : $this.attr('action'),
                            type : 'POST',
                            data:formData,												
                            cache:false,												
                            contentType: false,												
                            processData: false,	
                            
                            success:function(html){
                                if(html=='1'){
                                    notification('Berhasil Disimpan','success');
									 claravel_modal_close('main_modal');
                                    refresh_page();
                                }else{
                                    notification(html,'danger');
                                }
                            }
                        });
                    }
                });

            }
        });
		
		$('#image').fileinput({					
            showUpload:false,					
            previewFileType:'image',					
            allowedFileExtensions: ["png", "jpg", "jpeg", "PNG", "JPG", "JPEG"],					
            maxFileSize: 1024 * 1 * 1 ,					
            browseLabel: "",					
            browseIcon: '<i class="fa fa-folder-open"></i>',					
            removeLabel: " Hapus",					
            removeIcon: '<i class="fa fa-times"></i>',					
            layoutTemplates: {					
                main1: "{preview}\n" +					
                "<div class=\'input-group {class}\'>\n" +					
                "   <div class=\'input-group-btn\'>\n" +					
                "       {browse}\n" +					
                "       {upload}\n" +					
                "       {remove}\n" +					
                "   </div>\n" +					
                "   {caption}\n" +					
                "</div>"					
            }		
        });
		/* $('#form_profila').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            e.stopImmediatePropagation(); 
            var formData = new FormData(this);                
            $.ajax({
				url : $this.attr('action'),
                type : 'POST',
                data : formData,
                contentType: false,
                processData: false,    
                success:function(html){
                    if(html == '4'){
                        notification('Berhasil Ubah Profil, pergantian foto akan berpengaruh setelah login berikutnya','success');
                        $('.modal-close').trigger('click');
                        claravel_modal_close('main_modal');
                    }
                }
            });

        });    */     
    });
</script>
<div class="alert alert-info">
    Mohon Isikan Nama Tanpa Tanda Baca
</div>		
<div class="table-responsive">
    <?php
    $user = \UsersModel::find(\Session::get('user_id'));
    ?>
    {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form_profila')) !!}
    <div class="col-md-10" style="padding-top: 40px">
        {!!Form::hidden('id',$user->id)!!}
        <div class="form-group">
                {!! Form::label('name', 'Nama Baru:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                        {!! Form::text('name', $user->name, array('class'=> 'validate[required] form-control')) !!}
                </div>
        </div>
        <div class="form-group">
                {!! Form::label('email', 'Email:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                        {!! Form::text('email', $user->email, array('class'=> 'validate[required,custom[email]] form-control')) !!}
                </div>
        </div>
        <div class="form-group">
                {!! Form::label('foto', 'Foto:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
					<input type="file" name="foto" id="image" title=".jpg .jpeg .png" accept="image/*" >
                       
                </div>
        </div>

    </div>
    <div class="clearfix">
    </div>
    <hr>
    <div class="col-sm-offset-2 col-sm-10">
    {!! ClaravelHelpers::btnSave() !!}
</div>
  {!! Form::close() !!}
          	 
</div>
