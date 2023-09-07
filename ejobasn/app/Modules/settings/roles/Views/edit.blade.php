
<section class="content-header">
    <h1>
        Edit Roles<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Roles</a></li>
        <li class="active">Edit Roles</li>
    </ol>
</section>
<section class="content">
	<?php
	    $rpos = strrpos(\Request::path(), '/'); 
	    $uri = substr(\Request::path(), 0, $rpos);
	?>
	{!! Form::model($roles, array('url' => $uri, 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan' )) !!}
	{!! Form::hidden('id') !!}
  	<div class="box box-success">
	  	<div class="box-body">
	  		<div class="row">
	      		<div class="col-md-8">
		          	<div class="form-group">
						{!! Form::label('parent', 'Role Parent:', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-7">
							{!! Form::select('parent', $role_parent) !!}
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('name', 'Name:', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-7">
							{!! Form::text('name', null, array('class'=> 'form-control')) !!}
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('description', 'Description:', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-7">
							{!! Form::text('description', null, array('class'=> 'form-control')) !!}
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('login_destination', 'Login Destination:', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-7">
							{!! Form::text('login_destination', null, array('class'=> 'form-control')) !!}
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('status', 'Status:', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-7">
							{!! Form::select('status', array('In Active' => 'In Active', 'Active' => 'Active')) !!}
						</div>
					</div>        	
	      		</div>
	    	</div>
	  	</div>   
  	</div>

	<div class="box box-primary">
	  	<div class="box-header with-border">
	    	<h3 class="box-title">Context Permissions Matrix</h3>
	    </div>
	  	<div class="box-body no-padding">
	  		<table class="table table-striped table-hover">
              <thead class="bg-primary">
                <tr>
		          <th>Permissions</th>
		          <th><input type="checkbox" class="checkall" data-val="manage" value="1"> Manage</th>
		          </tr>
		      </thead>
		      <tbody>
		      	<?php
		      	error_reporting(null);
		      	?>
                @foreach ($permissions_context as $modules)
                <tr>
                    <td>{!!$modules->name!!}</td>
      				<td><input type="checkbox" class="manage" name="permissionmatrix[]" value="{!!$action['manage'][$modules->id]!!}" <?=($permissionMatrix[$action['manage'][$modules->id]])?"checked":""?> >  </td>
			    </tr>
                @endforeach
              </tbody>
            </table>
	  	</div>
	</div>

	<div class="box box-primary">
	  	<div class="box-header with-border">
	    	<h3 class="box-title">Modules Permissions Matrix</h3>
	    </div>
	  	<div class="box-body no-padding">
	  		<table class="table table-striped table-hover">
	          	<thead class="bg-primary">
	            	<tr>
		          		<th>Permissions</th>
		          		@foreach($module_actions as $val)
		          		<th><input type="checkbox" class="checkall" data-val="{!! $val !!}" value="1"> {!! $val !!}</th>
		          		@endforeach
		          	</tr>
		      	</thead>
		      	<tbody>
		      	@foreach ($permissions_modules as $modules)
	            <tr>
	                <td>{!!$modules->name!!}</td>
	  				@foreach($module_actions as $ma)
	  				@if ($action[$modules->name][$ma])
			        <td><input type="checkbox" class="{!! $ma !!}" name="permissionmatrix[]" value="{!!$action[$modules->name][$ma]!!}" <?=($permissionMatrix[$action[$modules->name][$ma]])?"checked":""?> > </td>
			        @else
			        <td>&nbsp;</td>
			        @endif 	
			        @endforeach
	            </tr>
	            @endforeach
	          </tbody>
	        </table>
	  	</div>
	  	<div class="box-footer">
		    {!! ClaravelHelpers::btnSave(); !!}
	        &nbsp;
	        &nbsp;{!! ClaravelHelpers::btnCancel(); !!}
		</div>
	</div>
	{!! Form::close() !!}
</section>
<script type="text/javascript">
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
  	$('select').addClass('form-control');
    $('.icp-auto').iconpicker();
    $('#batalkan,#back').on('click',function(e){
      e.preventDefault();
      refresh_page();
    });
    $('#simpan').on('submit',function(e){
      var $this = $(this);
      e.preventDefault();
      bootbox.confirm('Simpan Role?',function(a){
        if (a == true){
          $.ajax({
            url : $this.attr('action') + '/edit' ,
            type : 'POST',
            data : $this.serialize(),
            beforeSend: function(){
              preloader.on();
            },
            success:function(html){
              notification('Role berhasil diedit','success');
              refresh_page();
            }
          });
        }
      });
    });
  });
</script>




<script>
$(function(){
	$(document).on("click", ".checkall", function(){ 
      var act = $(this).attr('data-val');
      $('.'+act).prop('checked', this.checked);
   });
});
</script>	

          


