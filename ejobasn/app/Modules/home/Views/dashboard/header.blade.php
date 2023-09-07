<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>E-Job ASN :: Kab. Wonosobo</title>

    {{-- Service Worker --}}
    {!! attachServiceWorker() !!}

    <link href="https://simpeg.wonosobokab.go.id/v19/packages/login/img/wonosobo.png" rel='icon' type='image/x-icon'/>

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{!!asset('packages/static/css/bootstrap.min.css')!!}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!!asset('packages/static/css/font-awesome.min.css')!!}">
    <!-- Ionicons -->
    {{-- <link rel="stylesheet" href="{!!asset('packages/static/css/ionicons.min.css')!!}"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{!!asset('packages/static/css/AdminLTE.min.css')!!}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{!!asset('packages/static/css/_all-skins.min.css')!!}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.2.0 -->
    <script src="{!!asset('packages/static/plugins/jQuery/jquery-1.11.0.min.js')!!}"></script>
    <script src="{!!asset('packages/static/plugins/jQueryUI/jquery-ui.min.js')!!}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{!!asset('packages/static/js/bootstrap.min.js')!!}"></script>
    <!-- AdminLTE App -->
    <script src="{!!asset('packages/static/js/app.min.js')!!}"></script>
    <!-- Sparkline -->
    <!-- SlimScroll 1.3.0 -->
    <script src="{!!asset('packages/static/plugins/slimScroll/jquery.slimscroll.min.js')!!}"></script>

    <!--Legacy Framework Mbiyen-->
    {{-- <script type="text/javascript" src="{{asset('packages/static/js/moment.js')}}"></script> --}}
    {{-- <link rel="stylesheet" href="{{asset('packages/static/css/bootstrap-datetimepicker.min.css')}}" /> --}}
    {{-- <script type="text/javascript" src="{{asset('packages/static/js/bootstrap-datetimepicker.min.js')}}"></script> --}}

    <!--NOTINY-->
    <script type="text/javascript" src="{!!asset('packages/static/plugins/notiny/notiny.min.js')!!}"></script>
    <link rel="stylesheet" href="{!!asset('packages/static/plugins/notiny/notiny.min.css')!!}">
    <!--NOTINY-->

    <!--datetime-->
    <script type="text/javascript" src="{!!asset('packages/static/plugins/datepicker/bootstrap-datepicker.js')!!}"></script>
    <link rel="stylesheet" href="{!!asset('packages/static/plugins/datepicker/datepicker3.css')!!}">
    <link rel="stylesheet" href="{!!asset('packages/static/plugins/timepicker/bootstrap-timepicker.min.css')!!}">
    <!--datetime-->

    <!--CKEDITOR-->
    {{-- <script type="text/javascript" src="{{asset('packages/static/plugins/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('packages/static/plugins/ckeditor/adapters/jquery.js')}}"></script> --}}
    <!--CKEDITOR-->

    <!--chart-->
    <script type="text/javascript" src="{{asset('packages/static/plugins/chart/highcharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('packages/static/plugins/chart/data.js')}}"></script>
    <script type="text/javascript" src="{{asset('packages/static/plugins/chart/exporting.js')}}"></script>
    <!--chart-->

    <!-- fileinput -->
      {{-- <link rel="stylesheet" href="{{ asset('packages/static/css/fileinput.min.css') }}" />
      <script type="text/javascript" src="{{ asset('packages/static/js/fileinput.min_optimized.js') }}"></script> --}}
    <!-- fileinput -->

    <script type="text/javascript" src="{{asset('packages/static/plugins/Material-Preloader/js/materialPreloader.min.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('packages/static/plugins/Material-Preloader/css/materialPreloader.min.css')}}">


    <!--    TABS  -->
    {{-- <script type="text/javascript" src="{{asset('packages/static/js/bootstrap-tab.min.js')}}"></script> --}}
    <!--    TABS  -->


    <!--    VALIDATION-->
    <link rel="stylesheet" href="{{ asset('packages/static/plugins/validation-engine/css/validationEngine.jquery.css') }}" type="text/css"/>
    <script src="{{ asset('packages/static/plugins/validation-engine/js/jquery.validationEngine-id.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('packages/static/plugins/validation-engine/js/jquery.validationEngine.js') }}" type="text/javascript" charset="utf-8"></script>
    <!--    VALIDATION-->

    <!--    TABLE-->
    {{-- <link rel="stylesheet" href="{{ asset('packages/static/plugins/tablefix/tablefix.css') }}" type="text/css"/>
    <script src="{{ asset('packages/static/plugins/tablefix/tablefix.js') }}" type="text/javascript" charset="utf-8"></script> --}}
        <!--    TABLE-->


    <script src="{{ asset('packages/static/plugins/font-awesome/fontawesome-iconpicker.js') }}" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="{{ asset('packages/static/plugins/font-awesome/fontawesome-iconpicker.min.css') }}" type="text/css"/>


    <script type="text/javascript" src="{{ asset('packages/static/plugins/AmaranJS/js/jquery.amaran.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('packages/static/plugins/select2/select2.min.css') }}" />
    <script type="text/javascript" src="{{ asset('packages/static/plugins/bootbox/bootbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/static/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/static/plugins/mask/jquery.maskedinput.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/static/plugins/maskMoney/jquery.maskMoney.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('packages/tugumuda/js/claravel.js') }}"></script>

    <style type="text/css">
      .header-gradient-custom {
          /* fallback for old browsers */
          background: #6a11cb;

          /* Chrome 10-25, Safari 5.1-6 */
          background: -webkit-linear-gradient(to left, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

          /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
          background: linear-gradient(to left, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>

    {{-- <script src="{{ asset('packages/static/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{ asset('packages/static/plugins/chartjs/Chart.min.js')}}"></script> --}}

    <script>
      var xhr = $.ajax();
      $(document).ready(function(){
          $('#profil_user').on('click',function(e){
              e.preventDefault();
              claravel_modal('Profil Pengguna','Loading...','main_modal');
              $.ajax({
                  url : '{{url('')}}/profil',
                  type : 'get',
                  success:function(html){
                    $('#main_modal .modal-body').html(html);
                  }
              });

          });
          $('#profil_user2').on('click',function(e){
              e.preventDefault();
              claravel_modal('Ganti Password','Loading...','main_modal');
              $.ajax({
                  url : '{{url('')}}/pass',
                  type : 'get',
                  success:function(html){
                    $('#main_modal .modal-body').html(html);
                  }
              });

          });

          notifikasi();
      });

      // CKEDITOR.disableAutoInline = true;
      $(document).ready(function(){
          /*Untuk mengatasi select2 yang tidak bekerja di modal*/
          $.fn.modal.Constructor.prototype.enforceFocus = function() {
              $('select').select2();
          }
      });

      var laravel_base = <?php echo "'".url('')."'"; ?>;
      function only_numeric(e){
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // ijinkan: backspace dan delete
              (e.keyCode == 8) || (e.keyCode == 46) ||
                // ijinkan: Enter
              (e.keyCode == 13) ||
                // ijinkan: Ctrl+A
              (e.keyCode == 65 && e.ctrlKey === true) ||
                // ijinkan: home, end, left, right
              (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
                    // let it happen, don't do anything
          }
          // Ensure that it is a number and stop the keypress
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
      }

      function cetak_a4_landscape(html,panjang,lebar){
          var divContents = $("#dvContainer").html();
          var printWindow = window.open('', '', 'height=' + lebar + ',width=' + panjang + ',scrollbars=1');
          printWindow.document.write('<!DOCTYPE html><html><head><title>Cetak</title>');
          printWindow.document.write('<style>html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:8pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: a4 landscape;margin-left: 0.4in;margin-right: 0.4in;margin-top: 0.4in;margin-bottom: 0.6in;counter-increment: page;@bottom-right {padding-right:20px;content: "Page " counter(page);}}  .page-break{ display:block; page-break-before:always; }}p{font-size:8pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:8pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>');
          printWindow.document.write(html);
          printWindow.document.write('</html>');
          printWindow.document.close();
          printWindow.print();
      }

      function cetak_a4_portrait(html,panjang,lebar){
          var divContents = $("#dvContainer").html();
          var printWindow = window.open('', '', 'height=' + lebar + ',width=' + panjang + ',scrollbars=1');
          printWindow.document.write('<!DOCTYPE html><html><head><title>Cetak</title>');
          printWindow.document.write('<style>html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:8pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: a4 portrait;margin-left: 0.4in;margin-right: 0.4in;margin-top: 0.4in;margin-bottom: 0.6in;counter-increment: page;@bottom-right {padding-right:20px;content: "Page " counter(page);}}  .page-break{ display:block; page-break-before:always; }}p{font-size:8pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:8pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>');
          printWindow.document.write(html);
          printWindow.document.write('</html>');
          printWindow.document.close();
          printWindow.print();
      }

      function cetak_legal_landscape(html,panjang,lebar){
          var divContents = $("#dvContainer").html();
          var printWindow = window.open('', '', 'height=' + lebar + ',width=' + panjang + ',scrollbars=1');
          printWindow.document.write('<!DOCTYPE html><html><head><title>Cetak</title>');
          printWindow.document.write('<style>html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:8pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: legal landscape;margin-left: 0.4in;margin-right: 0.4in;margin-top: 0.4in;margin-bottom: 0.6in;counter-increment: page;@bottom-right {padding-right:20px;content: "Page " counter(page);}}  .page-break{ display:block; page-break-before:always; }}p{font-size:8pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:8pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>');
          printWindow.document.write(html);
          printWindow.document.write('</html>');
          printWindow.document.close();
          printWindow.print();
      }

      function cetak_legal_portrait(html,panjang,lebar){
          var divContents = $("#dvContainer").html();
          var printWindow = window.open('', '', 'height=' + lebar + ',width=' + panjang + ',scrollbars=1');
          printWindow.document.write('<!DOCTYPE html><html><head><title>Cetak</title>');
          printWindow.document.write('<style>html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:8pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: legal portrait;margin-left: 0.4in;margin-right: 0.4in;margin-top: 0.4in;margin-bottom: 0.6in;counter-increment: page;@bottom-right {padding-right:20px;content: "Page " counter(page);}}  .page-break{ display:block; page-break-before:always; }}p{font-size:8pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:8pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>');
          printWindow.document.write(html);
          printWindow.document.write('</html>');
          printWindow.document.close();
          printWindow.print();
      }

      function autoComplete(element, url, ph, dataPost, id, text, parent, parent2){
          $(element).select2({
              /*initSelection: function(element, callback) {
                  callback({id: id, text: text });
              },*/
              placeholder: ph,
              /*minimumInputLength: 3,*/
              closeOnSelect: true,
              allowClear: true,
              quietMillis: 250,
              ajax: {
                  url: url,
                  dataType: 'json',
                  delay: 750,
                  type:'post',
                  data: function (params) {
                      return {
                          keyword: params.term, //search term
                          per_page: 10, // page size
                          page: params.page, // page number
                          parent : parent,
                          parent2 : parent2,
                          _token : '{!!csrf_token()!!}'
                      };
                  },
                  processResults: function (data, params) {
                      // parse the results into the format expected by Select2
                      // since we are using custom formatting functions we do not need to
                      // alter the remote JSON data, except to indicate that infinite
                      // scrolling can be used

                      params.page = params.page || 1;

                      return {
                          results: data.rows,
                          pagination: {
                              more: (params.page * 5) < data.result
                          }
                      };
                  },
                  cache: true
              },
              escapeMarkup: function (markup) { return markup; },
              // tags: true
              //  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
              /*formatResult: FormatResult,
              formatSelection: FormatSelection*/
          });

          if(id != '' && id != null){
              $(element).data('select2').trigger('select', {
                  data: {"id":id,"text":text}
              });
          }
      }

      // function autoComplete(element, url, ph, dataPost){
      //   element.select2({
      //     ajax: {
      //         url: url,
      //         dataType: 'json',
      //         delay: 250,
      //         data: function (params) {
      //           return {
      //                 keyword: params.term, //search term
      //                 per_page: 5, // page size
      //                 page: params.page // page number
      //           };
      //         },
      //         processResults: function (data, params) {
      //           // parse the results into the format expected by Select2
      //           // since we are using custom formatting functions we do not need to
      //           // alter the remote JSON data, except to indicate that infinite
      //           // scrolling can be used
      //           params.page = params.page || 1;
      //           return {
      //             results: data.rows,
      //           };
      //         },
      //         cache: true
      //       },
      //     //  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
      //       minimumInputLength: 3,
      //     //      formatResult: tmlhrFormatResult,
      //     //      formatSelection: tmlhrFormatSelection
      //   });
      // }

      function loading(elemen){
          $('#' + elemen + '').html("<center><img src='<?=asset('packages/static/images/loading.gif')?>'></center>");
      }
      function loading_kecil(elemen){
          elemen.html("<center><img src='<?=asset('packages/static/img/loading_kecil.gif')?>'></center>");
      }

      function only_numeric(e){
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
          // ijinkan: backspace dan delete
          (e.keyCode == 8) || (e.keyCode == 46) ||
            // ijinkan: Enter
          (e.keyCode == 13) ||
            // ijinkan: Ctrl+A
          (e.keyCode == 65 && e.ctrlKey === true) ||
            // ijinkan: home, end, left, right
          (e.keyCode >= 35 && e.keyCode <= 39)) {
              return;
              // let it happen, don't do anything
          }
          // Ensure that it is a number and stop the keypress
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
      }

      function notification(pesan, jenis){
        if(jenis == 'success'){
          var bgcolor = '#00a65a';
          var color = '#fff';
            var jenis = jenis;
        }else if(jenis == 'danger'){
          var bgcolor = '#dd4b39';
          var color = '#fff';
            var jenis = jenis;
        }else if(jenis == 'warning'){
          var bgcolor = '#f39c12';
          var color = '#fff';
            var jenis = jenis;
        }else if(jenis == 'info'){
          var bgcolor = '#3c8dbc';
          var color = '#fff';
            var jenis = jenis;
        }else{
          var bgcolor = '#d2d6de';
          var color = '#000';
            var jenis = 'success';
        }
        $.notify(pesan, {align:"right", verticalAlign:"top", type : jenis});
        console.log(pesan);
      }

      function cetak_excel(elemen){
          uriContent = "data:application/vnd.ms-excel," + encodeURIComponent( format_html($('#' + elemen + '').html()) );
          window.open(uriContent, 'myDocument');
      }

      function cetak_word(elemen){
          uriContent = "data:application/msword," + encodeURIComponent( format_html($('#' + elemen + '').html()) );
          window.open(uriContent, 'myDocument');
      }
      function cetak_word2012(elemen){
          uriContent = "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document," + encodeURIComponent( format_html($('#' + elemen + '').html()) );
          window.open(uriContent, 'myDocument');
      }

      function format_html(html){
          var konten;
          konten = '<!DOCTYPE html><html><head><title>Cetak</title>';
          konten += '<style>.fake>th{padding: 0;border-bottom: none;border-top: none;}html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:12pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: legal landscape;margin-left: 2cm;margin-right: 2cm;margin-top: 2cm;margin-bottom: 2cm;counter-increment: page;@top-center {content: "Halaman " counter(page);}}   .page-break{ display:block; page-break-before:always; }}p{font-size:12pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:12pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>';
          konten += html;
          konten += '</html>';
          return konten;
      }

      function claravel_modal_close(elemen){
          $('#' + elemen + '').modal('hide');
          $('body').removeClass('modal-open');
          $('.modal-backdrop').remove();
      }

      function claravel_modal_close_2(elemen){
          $('#' + elemen + '').modal('hide');
      }

      function claravel_modal(judul,isi,elemen){
          elemen = (elemen == '')?'modal2':elemen;
          $('#' + elemen + '').modal({ keyboard: true });
          $('#' + elemen + ' .modal-title').html(judul);
          $('#' + elemen + ' .modal-body').html(isi);
      }

      function notifikasi(){
          xhr.abort();
          xhr = $.ajax({
              url: '{{url()}}/getnotifikasi',
              cache: false,
              success: function(response){
                  var ret = $.parseJSON(response);
                  $('.vnotifikasi').text('Anda tidak memiliki pemberitahuan terkini');
                  for(attrname in ret){
                      if(ret[attrname] > 0){
                          if(attrname.substr(0, 6) != 'jumlah'){
                              $('.'+attrname).html('<span class="label bg-red">'+ret[attrname]+ '</span>');
                          }else{
                              $('.'+attrname).html(ret[attrname]);
                          }
                          $('.vnotifikasi').text('Anda memiliki '+ret.vperubahan+' pemberitahuan terkini');
                      }else{
                          if(attrname.substr(0, 6) != 'jumlah'){
                              $('.'+attrname).html('');
                          }else{
                              $('.'+attrname).html('0');
                          }
                      }
                  }
              }
          });

          var waktu = setTimeout("notifikasi()",30000);
      }

      function notification(pesan, jenis){
          if(jenis == 'success'){
            var bgcolor = '#00a65a';
            var color = '#fff';
              var jenis = jenis;
          }else
          if(jenis == 'danger'){
            var bgcolor = '#dd4b39';
            var color = '#fff';
              var jenis = jenis;
          }else
          if(jenis == 'warning'){
            var bgcolor = '#f39c12';
            var color = '#fff';
              var jenis = jenis;
          }else
          if(jenis == 'info'){
            var bgcolor = '#3c8dbc';
            var color = '#fff';
              var jenis = jenis;
          }else{
            var bgcolor = '#d2d6de';
            var color = '#000';
              var jenis = 'success';
          }
            $.notify(pesan, {align:"right", verticalAlign:"top", type : jenis});
        }
    </script>
</head>

<body class="hold-transition fixed sidebar-mini skin-blue">
  <div class="wrapper">
    <header class="main-header">

    <!-- Logo -->
    <a href="{!!url('')!!}/dashboard" class="logo"  style="background-color: rgba(37, 117, 252, 1);">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>EJB</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">E-Job ASN</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top header-gradient-custom"">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="background-color: #2871fa;">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-danger"><span class="vperubahan"></span></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header"><span class="vnotifikasi">&nbsp;</span></li>
                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                            <li><a href="{!!url()!!}/eformasi/kebutuhanjabatan/data/notifikasi/perbedaanopd" class="linkmod"><i class="fa fa-arrow-circle-right text-aqua"></i> Perbedaan Unit Kerja <span class="cperubahan"></span></a></li>
                            <li><a href="{!!url()!!}/eformasi/kebutuhanjabatan/data/notifikasi/selisihopd" class="linkmod"><i class="fa fa-arrow-circle-right text-aqua"></i> Selisih Unit Kerja <span class="cselisih"></span></a></li>
                            <li><a href="{!!url()!!}/eformasi/kebutuhanjabatan/data/notifikasi/selisihpetajab" class="linkmod"><i class="fa fa-arrow-circle-right text-aqua"></i> Selisih Petajabatan <span class="clebih"></span></a></li>
                        </ul>
                    </li>
                </ul>
            </li>

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="user-image fa fa-user" alt="User Image"></i>
              <span class="hidden-xs">{{session('name')}}</span>
            </a>

            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header" style="background-color: #5e10b7;">
                <img src="{!!asset('packages/upload/photo/'.session('user_id').'/'.session('foto'))!!}" class="img-circle" alt="User Image">

                <p>
                  {{session('name')}}
                  <small>{{session('role')}}</small>
                    <?php
                    $nama = \DB::connection('kepegawaian')
                        ->table('a_skpd as a')
                        ->leftJoin('a_skpd as b', \DB::raw('left(a.idparent,2)'), '=', 'b.idskpd')
                        ->select(\DB::raw('CONCAT(a.skpd, " " ,b.skpd) AS skpd'))
                        ->where('a.idskpd', session('idskpd'))
                        ->first();

                    if(!empty($nama) > 0){
                        echo "<small>".$nama->skpd."</small>";
                    }
                    ?>
                </p>
              </li>
              <!-- Menu Footer-->
                    <li><a id="profil_user" href="" class='btn btn-default'>Lihat/Edit Profil</a></li>
                    <li><a id='profil_user2' href="" class='btn btn-default'>Ubah Password</a></li>

              <li class="user-footer">
                <div class="pull-right">
                  <a href="#" id="singot" class="btn btn-danger btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

{!!modal(true,'main_modal')!!}
<script>
  $('#singot').on('click',function(e){
      e.preventDefault();
      $.ajax({
          url : '{!!url('')!!}/logout',
          type : 'get',
          success:function(html){
            if(html == 1){
              window.location.replace("{!! env('URL_SIMPEG'); !!}/logout");              
            }
          }
      });

  });
</script>
