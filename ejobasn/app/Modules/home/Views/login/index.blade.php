{!!View::make('home::login.header')!!}

<body class="hold-transition">
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="login-box">
              <div class="login-logo animated fadeInDown fw" >
                <a href="{!!url('')!!}" style="color: white;">
                  <img src="https://simpeg.wonosobokab.go.id/v19/packages/login/img/wonosobo.png" alt="Logo" height="107">
                  <b>e-Job ASN</b><br>Kabupaten Wonosobo
                </a>
              </div>
              <!-- /.login-logo -->
              <div class="login-box-body animated zoomIn" style="border-radius:10px;">
                <p class="login-box-msg"></p>
                {!!Form::open(array('url' => url('').'/login','id'=>'tampil', 'method' => 'POST'))!!}
                  @if(\Session::get('msgerr') != '')
                  <div class='alert alert-danger'>{{\Session::get('msgerr')}}</div>
                  @endif
                  <div class="form-group has-feedback animated zoomIn">
                    <input type="text" name='username' class="form-control" required placeholder="Username">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback animated zoomIn">
                    <input type="password" name='password' class="form-control" required placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row animated zoomIn">
                    <div class="col-xs-4">&nbsp;</div>
                    <div class="col-xs-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                    </div>
                      <div class="col-xs-4">
                          <button type="reset" class="btn btn-default btn-block btn-flat">Reset</button>
                      </div>
                    <!-- /.col -->
                  </div>
                {!!Form::close()!!}

              </div>
              <p class="text-center animated fadeInUp fw" style="color: white;">&copy; Dinustek</p>
              <!-- /.login-box-body -->
            </div>
            <!-- /.login-box -->
          </div>
        </div>
    </div>

<!-- jQuery 2.2.0 -->
<script src="{!!asset('packages/static/plugins/jQuery/jQuery-2.2.0.min.js')!!}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{!!asset('packages/static/js/bootstrap.min.js')!!}"></script>
<!-- iCheck -->
</body>
</html>
