<section class="content-header">
    <h1>
        Permissions Matrix<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url('')!!}"> Dashboard</a></li>
        <li class="active">Permissions Matrix</li>
    </ol>
</section>
<section class="content">
  <div class="box box-success">
    <div class="box-header with-border">
      {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
        {!!csrf_field()!!}
      <div class="input-group col-md-3">
        <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
        </span>
      </div>
      {!! Form::close() !!}
    </div>
    <div class="box-body no-padding">
    {!! Form::open(array('url' => 'settings/permissionsmatrix/setpermissionsmatrix', 'class'=>'form-horizontal', 'id' =>'form-permissionsmatrix')) !!}
      <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered">
        <thead class="" style="background-color: #00a65a;color:#ffffff">
          <tr>
            <th>Permissions</th>
            <th>Descriptions</th>
            @foreach ($roles as $role)
            <th><!-- <input type="checkbox" value="{!!$role->id!!}" class="checkallpermission" >-->{!!$role->name!!}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($permissions as $permission)
          <tr>
              <td>{!!$permission->name!!}</td>
              <td>{!!$permission->description!!}</td>
              @foreach ($roles as $role)
              <?php
              $pm = RolesModel::find($role->id)->permissionMatrix()->where('permission_id', $permission->id)->first();
              $check ="";
              if ($pm){
                $check ="checked";  
              }
              ?>
              <td><center><input type="checkbox" value="{!!$permission->id!!}" data-role="{!!$role->id!!}" data-permission="{!!$permission->id!!}" name="permissions[{!!$permission->id!!}][{!!$role->id!!}]" class="checkme checkme_{!!$role->id!!}" {!!$check!!} ></center></td>
              @endforeach
          </tr>
          @endforeach
        </tbody>
      </table>
      </div>
    {!! Form::close() !!}
    </div>
  </div>
</section>

<script>
$(function () {

  $('#cari').on('submit',function(e){
    e.preventDefault();
    $.ajax({
      url : $(this).attr('action'),
      data:$(this).serialize(),
      type : 'get',
      beforeSend: function(){
        preloader.on();
      },
      success:function(html){
        preloader.off();
        $('#utama').html(html);
      }
    });
  });

  function saveMatrix(role, permission, flag){
    $.post(
      $( '#form-permissionsmatrix' ).prop( 'action' ),
      {
        "_token": $( '#form-permissionsmatrix' ).find( 'input[name=_token]' ).val(),
        "role_id": role,
        "permission_id": permission,
        'flag':flag
      },
      function( data ) {
        $('#msg_content').html(data.msg);
        notification('Permission Matrix berhasil diubah','success');
      },
      'json'
    );
  } 
    
   $(document).on("click", ".checkallpermission", function(){ 
      var role_id = $(this).val();
      $('.checkme_'+role_id).prop('checked', this.checked);
      if (this.checked){
        //$('#form-permissionsmatrix').submit();
      }
   });
   
   $(document).on("click", ".checkme", function(e){
      e.stopImmediatePropagation();
      //$('#form-permissionsmatrix').submit();
      var role = $(this).attr('data-role');
      var permission = $(this).attr('data-permission');
      if (this.checked){
        saveMatrix(role, permission, '1');
      }else{
        saveMatrix(role, permission, '0');
      }
   });
});
</script>