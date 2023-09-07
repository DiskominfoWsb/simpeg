<section class="content-header">
    <h1>
        Buat Modul<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Modules</a></li>
        <li class="active">Buat Modul</li>
    </ol>
</section>
{!! Form::open(array('id'=>'simpan','url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'))) !!}
<section class="content">
    <div class="box box-success">
      <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('module_path', 'Module Path:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-6">
              {!! Form::select('module_path', $modulePath) !!}
            </div>
          </div>
          <div class="form-group">
            <label for="id_context" class="col-sm-4 control-label">Context</label>
            <div class="col-sm-6">
            @foreach ($contexts as $context)
            <div class="checkbox">
                <label>
                  <input type="checkbox" class='validate[required]' id="id_context" name="id_context" value="{!!$context->id!!}"> {!!$context->name!!}
                </label>
              </div>
              @endforeach
              </div>
          </div>
          <div class="form-group">
            <label for="id_parent" class="col-sm-4 control-label">Parent</label>
            <div class="col-sm-6">
              <select name="id_parent" id="id_parent">
                <option value="0">-</option>
                @foreach ($modules as $module)
                <option value="{!!$module->id!!}">{!! $module->name !!}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('name', 'Name:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-6">
              {!! Form::text('name', null, array('class'=> 'validate[required] form-control')) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('flag', 'Is Active ?:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-6">
              {!! Form::checkbox('flag', '1', true) !!} Yes
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('controller', 'Use Controller ?:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-6">
              {!! Form::checkbox('controller', '1', true, array('id'=>'controller')) !!} Yes
            </div>
          </div>
        </div>
        <div class="col-md-6">   
          <div class="form-group">
            {!! Form::label('icons', 'Icons:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-6">
              <div class="input-group iconpicker-container">
                <input data-placement="bottomRight" class="form-control icp icp-auto iconpicker-element iconpicker-input" value="fa-archive" type="text" id="icons" name="icons">
                <span class="input-group-addon"><i class="fa fa-archive"></i></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('order', 'Order:', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-2">
              {!! Form::text('order', null, array('class'=> 'form-control')) !!}
            </div>
          </div>
          <div id="divcontoller">
            <div class="form-group">
              <label for="controller_actions" class="col-sm-4 control-label">Controller Actions</label>
              <div class="col-sm-3">
              @foreach ($controllerActions as $key=>$val)
              <div class="checkbox">
                <label>
                  <input type="checkbox" class="validate[required]" id="controller_actions" name="controller_actions[]" value="{!!$val!!}" checked="checked"> {!!ucfirst($val)!!}
                </label>
              </div>
              @endforeach
              </div>
            </div>
            <div class="form-group">
              <label for="rmodule_table" class="col-sm-4 control-label">Module Table</label>
              <div class="col-sm-6">
                <div class="radio">
                  <label>
                    <input type="radio" id="rmodule_table" class="rmodule_table" name="rmodule_table" value="0" checked="checked"> No
                  </label>
                </div>
                <div class="radio">  
                  <label>
                    <input type="radio" id="rmodule_table" class="rmodule_table" name="rmodule_table" value="1"> Create New Table
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" id="rmodule_table" class="rmodule_table" name="rmodule_table" value="2"> Build from Existing Table
                  </label>
                </div>
              </div>
            </div>
          </div> 
        </div>
      </div>
      
      </div>
      <div class="box-footer clearfix">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-6">
                {!! ClaravelHelpers::btnSave() !!}
                &nbsp;
                &nbsp;{!! ClaravelHelpers::btnCancel() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="module_table" class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Table Properties</h3>
        <div class="box-tools pull-right">
          
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-7">
              <div class="form-group">
                <label for="table_name" class="col-sm-3 control-label">Table name</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="table_name" name="table_name" required placeholder="Lowercase, no spaces">
                </div>
                <div class="col-sm-4">
                   <button type="button" class="btn btn-info" id="get_field">Get Field</button>
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label for="primary_key" class="col-sm-3 control-label">Primary Key</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="primary_key" name="primary_key" value="id">
                </div>
              </div>
            </div>
             <div class="clearfix">
            </div>
            <fieldset>
              <a href="#" class="add_column"><i class="fa fa-plus-circle"></i> Add Column</a>
              <table id="table_column" class="table table-striped table-hover table-bordered table-primary">
                <thead class="bg-primary">
                  <tr>
                    <th>Label</th>
                    <th>Name (no space)</th>
                    <th>Input Type</th>
                    <th>Database Type</th>
                    <th>Maximum Length</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="form-group">
                    
                </tbody>
              </table>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
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
    $('#simpan').validationEngine();
    $('#simpan').on('submit',function(e){
        var $this = $(this);
        e.preventDefault();
        if($this.validationEngine('validate')){
            bootbox.confirm('Generate Module?',function(a){
            if (a == true){
              $.ajax({
                url : $this.attr('action'),
                type : 'POST',
                data : $this.serialize(),
                success:function(html){
                    if(html=='1'){
                      notification('Modul berhasil dibuat','success');
                      refresh_page();
                    }else{
                      notification('Gagal','danger');
                    }
                }
              });
            }
            });            
        }
    });  
})    
$(function () {
  $('#batalkan,#back').on('click',function(e){
      e.preventDefault();
      refresh_page();
  });
  
    
  $('select').addClass("form-control");
  $('.icp-auto').iconpicker();  
  $('#module_table').hide();
   
   $('#controller').click(function(){
   		if ($(this).is(':checked')){
   			$('#divcontoller').show();	
   		}else{
   			$('#divcontoller').hide();	
   		}
   });
   
   $('.rmodule_table').click(function(){
   		if ($(this).val() > 0){
   			$('#module_table').show();
   			var table_name  = $('#name').val();
        table_name = table_name.replace(/ /g,"_");
   			$('#table_name').val(table_name.toLowerCase());
        if ($(this).val() ==1 ){
          $('#get_field').hide();
          $('#table_column > tbody').empty();
        }else{
          $('#get_field').show();
        }
   		}else{
   			$('#module_table').hide();
   		}
   });
   $(document).on("click", "a.add_column", function(e){
       e.preventDefault();
       e.stopImmediatePropagation();
   		var str="<tr>";
   		str+="<td><input type=\"text\" class=\"col-sm-10 form-control\" name=\"tb_label[]\" placeholder=\"The name that will be used on webpages\"></td>";
   		str+="<td><input type=\"text\" class=\"col-sm-10 form-control\" name=\"tb_name[]\" placeholder=\"The field name for the database. Lowercase is best.\"></td>";
   		
   		str+="<td><select name=\"tb_intype[]\">";
   		str+="<option value=\"text\">INPUT</option>";
  		str+="<option value=\"checkbox\">CHECKBOX</option>";
  		str+="<option value=\"password\">PASSWORD</option>";
  		str+="<option value=\"radio\">RADIO</option>";
  		str+="<option value=\"select\">SELECT</option>";
  		str+="<option value=\"textarea\">TEXTAREA</option>";
   		str+="</select></td>";
   		
   		str+="<td><select name=\"tb_dbtype[]\">";
   		@foreach($columnTypes as $key=>$val)
   		str+="<option value=\"{!!$val!!}\">{!!$val!!}</option>";
   		@endforeach
   		str+="</select></td>";
   		
   		str+="<td><input type=\"text\" class=\"col-sm-10 form-control\" name=\"tb_max[]\" placeholder=\"30, 255, 1000, etc...\"></td>";
   		str+="<td><a href=\"#\" class=\"rem_column\"><span class=\"glyphicon glyphicon-minus-sign\"></span></a></td>";
   		str +="</tr>";
   		$('#table_column > tbody').append(str);
   		$('select').select2({
   			width: 200
   		});
   		return false;
   });
   
   $(document).on("click", "a.rem_column", function(){ 
   		$(this).parent().parent().remove()
   		return false;
   });

   $(document).on("click", "#get_field", function(e){ 
       e.preventDefault();
       e.stopImmediatePropagation();
      $.ajax({
          type: "POST",
          url : "{!!url('').str_replace("/create","/tablefields", "/".\Request::path()) !!}",
          data : {
            'table' : $('#table_name').val(),
            '_token' : '{{csrf_token()}}'
          },
          success: function(data) {
             
             $.each(data,function(key, val){
                  var str="";
                  if (val.Key !="PRI"){
                    str+="<tr>";
                    str+="<td><input type=\"text\" class=\"col-sm-10 form-control\" name=\"tb_label[]\"  value=\""+val.Field+"\"  placeholder=\"The name that will be used on webpages\"></td>";
                    str+="<td><input type=\"text\" class=\"col-sm-10 form-control\" name=\"tb_name[]\" value=\""+val.Field+"\" placeholder=\"The field name for the database. Lowercase is best.\"></td>";
                    
                    str+="<td><select name=\"tb_intype[]\">";
                    str+="<option value=\"text\">INPUT</option>";
                    str+="<option value=\"checkbox\">CHECKBOX</option>";
                    str+="<option value=\"password\">PASSWORD</option>";
                    str+="<option value=\"radio\">RADIO</option>";
                    str+="<option value=\"select\">SELECT</option>";
                    str+="<option value=\"textarea\">TEXTAREA</option>";
                    str+="</select></td>";
                    
                    str+="<td><select name=\"tb_dbtype[]\" id=\"cmb_"+key+"\">";
                    @foreach($columnTypes as $key=>$val)
                    str+="<option value=\"{!!$val!!}\">{!!$val!!}</option>";
                    @endforeach
                    str+="</select></td>";
                    var tb_max ="";
                    if (val.Type.indexOf('varchar') >= 0){
                        tb_max = val.Type.replace('varchar', '');
                        tb_max = tb_max.replace('(','');
                          tb_max = tb_max.replace(')','');
                    }
                    str+="<td><input type=\"text\" class=\"col-sm-10 form-control\" name=\"tb_max[]\" value=\""+tb_max+"\" placeholder=\"30, 255, 1000, etc...\"></td>";
                    str+="<td><a href=\"#\" class=\"rem_column\"><span class=\"glyphicon glyphicon-minus-sign\"></span></a></td>";
                    str +="</tr>";
                    $('#table_column > tbody').append(str);
                    var data_type="";
                    switch(val.Data_Type){
                        case "varchar": data_type="string";break;
                        case "int": data_type="integer";break;
                        case "bigint": data_type="bigInteger";break;
                        default : data_type = val.Data_Type;break;
                    };
                    $('#cmb_'+key).val(data_type);
                  }else{
                     $('#primary_key').val(val.Field);
                  }    
             });
              
              
              $('select').select2({
                width: 200
              });
          }
      });
      return false;
   });
});
</script>