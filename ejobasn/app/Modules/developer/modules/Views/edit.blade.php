@extends(Request::ajax() ? 'ajax' : 'index')

@section('content')

<?php
$uri = Request::path();
?>		
		  <h2 class="sub-header">Create New Context</h2>
          
          @if($errors->all())
          <div class="alert alert-danger">
          {{ HTML::ul($errors->all()) }}
          </div>
          @endif
          
          <div class="table-responsive">
          	{{ Form::model($context, array('route' => array('developer.context.update', $context->id), 'method' => 'PUT', 'class'=>'form-horizontal')) }}
          	
          		<div class="col-md-5">
                <div class="form-group">
                  <label for="f_name" class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-7">
                  	{{ Form::text('f_name', null, array('class' => 'form-control', 'id' => 'f_name')) }}
                  </div>
                </div>
                <div class="form-group">
                  <label for="f_path" class="col-sm-3 control-label">Path</label>
                  <div class="col-sm-7">
                  	{{ Form::text('f_path', null, array('class' => 'form-control', 'id' => 'f_path')) }}
                  </div>
                </div>
                 <div class="form-group">
                  <label for="f_uses" class="col-sm-3 control-label">Controller</label>
                  <div class="col-sm-7">
                    {{ Form::text('f_uses', null, array('class' => 'form-control', 'id' => 'f_uses')) }}
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Is Active?</label>
                  <div class="col-sm-3">
                  <div class="checkbox">
                      <label>
                        {{ Form::checkbox('f_flag', '1', false) }} Yes
                      </label>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Show in Nav Bar?</label>
                  <div class=" col-sm-3">
                  <div class="checkbox">
                      <label>
                        {{ Form::checkbox('f_is_nav_bar', '1', false) }} Yes
                      </label>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                  <label for="f_icons" class="col-sm-3 control-label">Icon</label>
                  <div class="col-sm-7">
                    {{ Form::text('f_icons', null, array('class' => 'form-control icon-picker', 'id' => 'f_icons')) }}
                  </div>
                </div>
                <div class="form-group">
                  <label for="f_order" class="col-sm-3 control-label">Order Number</label>
                  <div class="col-sm-2">
                    {{ Form::text('f_order', null, array('class' => 'form-control', 'id' => 'f_order')) }}
                  </div>
                </div>
                </div>
                <div class="clearfix">
                </div>	
              	<hr>
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-plus-sign"></span> Save</button>
                    &nbsp;
                    &nbsp;<button type="button" class="btn btn-warning ajaxin" onclick="location.href='{{URL::to('developer/context') }}'"><span class="glyphicon glyphicon-remove-circle"></span> Cancel</button>
                  </div>
              {{ Form::close() }}
          	 
          </div>



@stop
