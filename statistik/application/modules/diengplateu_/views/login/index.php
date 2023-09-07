<!DOCTYPE html>
<html dir="ltr">
  <head>
    <title>Login | S . I . E Kab. Wonosobo</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" href="dinustek">
    <link rel="shortcut icon" href="<?=$def_img?>favicon.png">

    <link rel="stylesheet" type="text/css" href="<?=$def_css?>font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$def_css?>main.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?=$def_css?>theming.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?=$def_css?>outdatedBrowser.min.css"> 

    <script type="text/javascript" src="<?=$def_js?>jquery-1.11.0.js"></script>
    <script type="text/javascript" src="<?=$def_js?>bootstrap.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="<?=$def_js?>jquery.dataTables.js"></script>
    <script src="<?=$def_js?>dataTables.bootstrap.js"></script>
    <script src="<?=$def_js?>outdatedBrowser.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <style>
        html, body, #login{
            height: 100%;
        }
    </style>
  </head>
  <body>
    <div id="login" class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <img src="<?php echo $def_img?>Lambang_Kabupaten_Wonosobo.png" alt="Kabupaten Wonosobo" width="100">
                    <h1 id="judulapp">S . I . EKSEKUTIF</h1>
                    <form class="form-inline" role="form" action="<?=base_url()?>diengplateu/auth/login" enctype="multipart/formdata" method="post">
                      <div class="form-group">
                        <label class="sr-only" for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                      </div>
                      <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="userpass" placeholder="Password">
                      </div>
                      
                      <button type="submit" name="login" id="blogin" class="btn btn-link" title="Login"><i class="fa fa-arrow-circle-o-right"></i></button>
                    </form>
                    <h3>Login ke S.I.Eksekutif</h3>
                    <p>Sistem Informasi Eksekutif Pemerintah Kabupaten Wonosobo</p>
                    <hr>
                    <p class="copyright">&copy;2014 Pemerintah Kabupaten Wonosobo. Dikembangkan oleh <a href="http://dinustek.com/">dinustek.</a></p>
                </div>
            </div>
        </div>
    </div>      
  </body>
</html>