@include('home::dashboard.header') 
@include('home::dashboard.sidebar-left') 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id='utama'>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <!-- <small>Version 2.0</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">

        <!-- awalnya != 3 -->
        {{-- @if(session('role_id') < 3 )  --}}
         <!--  <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">
                 
              </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
                tabel
            </div>
        </div> -->  
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">
                  @if(session('role_id') <=3)
                    E-Job ASN :: Kabupaten Wonosobo
                  @else
                    <?php
                    $nama = \DB::connection('kepegawaian')
                        ->table('a_skpd as a')
                        ->leftJoin('a_skpd as b', \DB::raw('left(a.idparent,2)'), '=', 'b.idskpd')
                        ->select(\DB::raw('CONCAT(a.skpd, " " ,b.skpd) AS skpd'))
                        ->where('a.idskpd', session('idskpd'))
                        ->first();
                    ?>
                    
                    E-PETA JABATAN {{$nama->skpd}}
                  @endif
              </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <?php
                $nip = Input::get('nip');
                    // $rs3 = \DB::connection('kepegawaian')->table('tb_01')->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();
                    // $rs2 = \DB::connection('kepegawaian')->table('tb_01')->where('idstspeg', 1)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();



                if(session('role_id') <= 3){
                    $rs1 = \DB::connection('kepegawaian')->table('tb_01')->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();
                    $rs2 = \DB::connection('kepegawaian')->table('tb_01')
					->where('idjenjab', '>', 4)
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();

                    $rs2_kebutuhan = \DB::table('tr_petajab')
                    ->select(\DB::raw("SUM(abk) as count"))
					->where('idjenjab','>', 4)
                    ->first();

                    $rs2_kekurangan = $rs2 - $rs2_kebutuhan->count;

                    $rs3 = \DB::connection('kepegawaian')->table('tb_01')
                    ->where('idjenjab', 2)
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();

                    $rs3_kebutuhan = \DB::table('tr_petajab')
                    ->select(\DB::raw("SUM(abk) as count"))
					->where('idjenjab','=', 2)
                    ->first();

                    $rs3_kekurangan = $rs3 - $rs3_kebutuhan->count;

                    $rs4 = \DB::connection('kepegawaian')->table('tb_01')
					->where('idjenjab', 3)
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();

                    $rs4_kebutuhan = \DB::table('tr_petajab')
                    ->select(\DB::raw("SUM(abk) as count"))
					->where('idjenjab','=', 3)
                    ->first();

                    $rs4_kekurangan = $rs4 - $rs4_kebutuhan->count;
                } else {
                    $rs1 = \DB::connection('kepegawaian')->table('tb_01')->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();
                    $rs2 = \DB::connection('kepegawaian')->table('tb_01')
					->where('idjenjab', '>', 4)
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();

                    $rs2_kebutuhan = \DB::table('tr_petajab')
                    ->select(\DB::raw("SUM(abk) as count"))
                    ->where('idjenjab','>', 4)->where('idskpd','like',''.session("idskpd"). '%')
                    ->first();

                    $rs2_kekurangan = $rs2 - $rs2_kebutuhan->count;

                    $rs3 = \DB::connection('kepegawaian')->table('tb_01')
                    ->where('idjenjab', 2)
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();

                    $rs3_kebutuhan = \DB::table('tr_petajab')
                    ->select(\DB::raw("SUM(abk) as count"))
                    ->where('idjenjab','=', 2)->where('idskpd','like',''.session("idskpd"). '%')
                    ->first();

                    $rs3_kekurangan = $rs3 - $rs3_kebutuhan->count;

                    $rs4 = \DB::connection('kepegawaian')->table('tb_01')
                    ->where('idjenjab', 3)
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();

                    $rs4_kebutuhan = \DB::table('tr_petajab')
                    ->select(\DB::raw("SUM(abk) as count"))
                    ->where('idjenjab','=', 3)->where('idskpd','like',''.session("idskpd"). '%')
                    ->first();

                    $rs4_kekurangan = $rs4 - $rs4_kebutuhan->count;
                }
            ?>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <div class="row">
                    	<div class="col-md-3">
				          <!-- Widget: user widget style 1 -->
				          <div class="box box-widget widget-user-2">
				            <!-- Add the bg color to the header using any of the bg-* classes -->
				            <div class="info-box bg-aqua" style="margin-bottom: 0px;">
				              <span class="info-box-icon"><i class="fa fa-sliders"></i></span>
				              <div class="info-box-content">
				                <span class="info-box-text">JUMLAH PNS AKTIF</span>
				                <span class="info-box-number">{{$rs1}}</span>
				              </div>
				            </div>
				            <div class="box-footer no-padding">
				              <ul class="nav nav-stacked">
				                <li><a href="#">Struktural <span class="pull-right badges bg-greens">{{$rs2}}</span></a></li>
				                <li><a href="#">Fungsional <span class="pull-right badges bg-grays">{{$rs3}}</span></a></li>
				                <li><a href="#">Pelaksana <span class="pull-right badges bg-yellows">{{$rs4}}</span></a></li>
				              </ul>
				            </div>
				          </div>
				          <!-- /.widget-user -->
				        </div>

				        <div class="col-md-3">
				          <!-- Widget: user widget style 1 -->
				          <div class="box box-widget widget-user-2">
				            <!-- Add the bg color to the header using any of the bg-* classes -->
				            <div class="info-box bg-red" style="margin-bottom: 0px;">
				              <span class="info-box-icon"><i class="fa fa-sliders"></i></span>
				              <div class="info-box-content">
				                <span class="info-box-text">JUMLAH STRUKTURAL</span>
				                <span class="info-box-number">{{$rs2}}</span>
				              </div>
				            </div>
				            <div class="box-footer no-padding">
				              <ul class="nav nav-stacked">
				                <li><a href="#">Kebutuhan <span class="pull-right badges bg-greens">{{$rs2_kebutuhan->count}}</span></a></li>
				                @if($rs2_kekurangan <= 0)
				                <li><a href="#">Kekurangan <span class="pull-right badges bg-reds">{{$rs2_kekurangan}}</span></a></li>
				                @else
				                <li><a href="#">Kelebihan <span class="pull-right badges bg-blues">{{$rs2_kekurangan}}</span></a></li>
				                @endif
                                <li><a href="#">&nbsp;<span class="pull-right badges bg-blues">&nbsp;</span></a></li>
				              </ul>
				            </div>
				          </div>
				          <!-- /.widget-user -->
				        </div>

				        <div class="col-md-3">
				          <!-- Widget: user widget style 1 -->
				          <div class="box box-widget widget-user-2">
				            <!-- Add the bg color to the header using any of the bg-* classes -->
				            <div class="info-box bg-green" style="margin-bottom: 0px;">
				              <span class="info-box-icon"><i class="fa fa-sliders"></i></span>
				              <div class="info-box-content">
				                <span class="info-box-text">JUMLAH FUNGSIONAL</span>
				                <span class="info-box-number">{{$rs3}}</span>
				              </div>
				            </div>
				            <div class="box-footer no-padding">
				              <ul class="nav nav-stacked">
				                <li><a href="#">Kebutuhan <span class="pull-right badges bg-greens">{{$rs3_kebutuhan->count}}</span></a></li>
				                @if($rs3_kekurangan <= 0)
				                <li><a href="#">Kekurangan <span class="pull-right badges bg-reds">{{$rs3_kekurangan}}</span></a></li>
				                @else
				                <li><a href="#">Kelebihan <span class="pull-right badges bg-blues">{{$rs3_kekurangan}}</span></a></li>
				                @endif
                                <li><a href="#">&nbsp;<span class="pull-right badges bg-blues">&nbsp;</span></a></li>
				              </ul>
				            </div>
				          </div>
				          <!-- /.widget-user -->
				        </div>

				        <div class="col-md-3">
				          <!-- Widget: user widget style 1 -->
				          <div class="box box-widget widget-user-2">
				            <!-- Add the bg color to the header using any of the bg-* classes -->
				            <div class="info-box bg-yellow" style="margin-bottom: 0px;">
				              <span class="info-box-icon"><i class="fa fa-sliders"></i></span>
				              <div class="info-box-content">
				                <span class="info-box-text">JUMLAH PELAKSANA</span>
				                <span class="info-box-number">{{$rs4}}</span>
				              </div>
				            </div>
				            <div class="box-footer no-padding">
				              <ul class="nav nav-stacked">
				                <li><a href="#">Kebutuhan <span class="pull-right badges bg-greens">{{$rs4_kebutuhan->count}}</span></a></li>
				                @if($rs4_kekurangan <= 0)
				                <li><a href="#">Kekurangan <span class="pull-right badges bg-reds">{{$rs4_kekurangan}}</span></a></li>
				                @else
				                <li><a href="#">Kelebihan <span class="pull-right badges bg-blues">{{$rs4_kekurangan}}</span></a></li>
				                @endif
                                <li><a href="#">&nbsp;<span class="pull-right badges bg-blues">&nbsp;</span></a></li>
				              </ul>
				            </div>
				          </div>
				          <!-- /.widget-user -->
				        </div>

                    </div>
                   


                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab_1" aria-expanded="true"><i class="fa fa-list"></i> Grafik Semua PNS</a></li>
                        <li class=""><a data-toggle="tab" href="#tab_2" aria-expanded="false"><i class="fa fa-list"></i> Grafik Struktural</a></li>
                        <li class=""><a data-toggle="tab" href="#tab_3" aria-expanded="true"><i class="fa fa-list"></i> Grafik Fungsional</a></li>
                        <li class=""><a data-toggle="tab" href="#tab_4" aria-expanded="false"><i class="fa fa-list"></i> Grafik Pelaksana</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1" class="tab-pane active">
                            <div id="graph-pns" style="width:100%;"></div>
                        </div>
                        <!-- /.tab-pane -->
                        <div id="tab_2" class="tab-pane">
                            <div id="graph-struktural" style="width:100%;"></div>
                        </div>
                        <div id="tab_3" class="tab-pane">
                            <div id="graph-fungsional" style="width:100%;"></div>
                        </div>
                        <div id="tab_4" class="tab-pane">
                            <div id="graph-pelaksana" style="width:100%;"></div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->

          </div>
          <!-- /.box -->
            {{-- @endif --}}
        </div>
        <!-- /.col -->
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script type="text/javascript">
    var xhr = $.ajax();

    $(document).ready(function(){
        $('.links').on('click',function(e){
            e.preventDefault();
            e.preventDefault();
            e.stopImmediatePropagation();
            preloader = new $.materialPreloader({
                position: 'top',
                height: '5px',
                col_1: '#159756',
                col_2: '#da4733',
                col_3: '#3b78e7',
                col_4: '#fdba2c',
                fadeIn: 200,
                fadeOut: 200
            });

            $.ajax({
                url : $(this).attr('href'),
                type : 'get',
                success:function(html){
                    $('#utama').html(html);
                }
            });
        });

        
        var graphWidth = $('.tab-content').width();


//  Graph Struktural -----------------------------------------------------------------------
        var options = {
            chart: {
                renderTo: 'graph-struktural',
                defaultSeriesType: 'column',
                spacingLeft: 0,
                spacingRight: 0,
                width: graphWidth
            },
            title: {
                text: 'Grafik Perbandingan Kebutuhan Dan Ketersediaan PNS'
            },
            subtitle: {
                text: 'Source: dinustek.com'
            },
            xAxis: {
                categories: ['Jumlah PNS','Jumlah PNS']
            },
            yAxis: {
                min: 0,
                title: {
                  text: 'Jumlah'
                },
                stackLabels: {
                  enabled: true,
                  style: {
                    fontWeight: 'bold',
                    color: 'gray'
                  }
                }
            },
            plotOptions: {
                column: {
                  stacking: 'normal',
                  dataLabels: {
                    enabled: false
                  },
                },
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 70,
                y: 70,
                floating: true,
                shadow: true
            },
            series: []
        };

        $.get('{{url('')}}/graphstruktural', function(data) {
            options.series = [{
                name: 'Kekurangan',
                data: [data['kekurangan'], 0],
                color: "#f72424"
            },{
                name: 'Ketersediaan',
                data: [data['ketersediaan'], 0],
                color: "#7cb5ec"
            },{
                name: 'Kebutuhan',
                data: [0, data['kebutuhan']],
                color: "#434348"
            }]

            var chart2 = new Highcharts.Chart(options);
        });
//  End Graph Struktural -----------------------------------------------------------------------
//  Graph PNS -----------------------------------------------------------------------
        var options2 = {
            chart: {
                renderTo: 'graph-pns',
                defaultSeriesType: 'column',
                spacingLeft: 0,
                spacingRight: 0,
                width: graphWidth
            },
            title: {
                text: 'Grafik Perbandingan Kebutuhan Dan Ketersediaan PNS'
            },
            subtitle: {
                text: 'Source: dinustek.com'
            },
            xAxis: {
                categories: ['Jumlah PNS','Jumlah PNS']
            },
            yAxis: {
                min: 0,
                title: {
                  text: 'Jumlah'
                },
                stackLabels: {
                  enabled: true,
                  style: {
                    fontWeight: 'bold',
                    color: 'gray'
                  }
                }
            },
            plotOptions: {
                column: {
                  stacking: 'normal',
                  dataLabels: {
                    enabled: false
                  },
                },
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 70,
                y: 70,
                floating: true,
                shadow: true
            },
            series: []
        };

        $.get('{{url('')}}/graphpns', function(data) {
            options2.series = [{
                name: 'Kekurangan',
                data: [data['kekurangan'], 0],
                color: "#f72424"
            },{
                name: 'Ketersediaan',
                data: [data['ketersediaan'], 0],
                color: "#7cb5ec"
            },{
                name: 'Kebutuhan',
                data: [0, data['kebutuhan']],
                color: "#434348"
            }]

            var chart2 = new Highcharts.Chart(options2);
        });

//  End Graph PNS -----------------------------------------------------------------------

//  Graph Fungsional -----------------------------------------------------------------------
    var options3 = {
            chart: {
                renderTo: 'graph-fungsional',
                defaultSeriesType: 'column',
                spacingLeft: 0,
                spacingRight: 0,
                width: graphWidth
            },
            title: {
                text: 'Grafik Perbandingan Kebutuhan Dan Ketersediaan Fungsional'
            },
            subtitle: {
                text: 'Source: dinustek.com'
            },
            xAxis: {
                categories: ['Jumlah PNS','Jumlah PNS']
            },
            yAxis: {
                min: 0,
                title: {
                  text: 'Jumlah'
                },
                stackLabels: {
                  enabled: true,
                  style: {
                    fontWeight: 'bold',
                    color: 'gray'
                  }
                }
            },
            plotOptions: {
                column: {
                  stacking: 'normal',
                  dataLabels: {
                    enabled: false
                  },
                },
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 70,
                y: 70,
                floating: true,
                shadow: true
            },
            series: []
        };

        $.get('{{url('')}}/graphfungsional', function(data) {
            options3.series = [{
                name: 'Kekurangan',
                data: [data['kekurangan'], 0],
                color: "#f72424"
            },{
                name: 'Ketersediaan',
                data: [data['ketersediaan'], 0],
                color: "#7cb5ec"
            },{
                name: 'Kebutuhan',
                data: [0, data['kebutuhan']],
                color: "#434348"
            }]

            var chart2 = new Highcharts.Chart(options3);
        });

//  End Graph Fungsional -----------------------------------------------------------------------
//   Graph Pelaksana -----------------------------------------------------------------------
var options4 = {
            chart: {
                renderTo: 'graph-pelaksana',
                defaultSeriesType: 'column',
                spacingLeft: 0,
                spacingRight: 0,
                width: graphWidth
            },
            title: {
                text: 'Grafik Perbandingan Kebutuhan Dan Ketersediaan Fungsional'
            },
            subtitle: {
                text: 'Source: dinustek.com'
            },
            xAxis: {
                categories: ['Jumlah PNS','Jumlah PNS']
            },
            yAxis: {
                min: 0,
                title: {
                  text: 'Jumlah'
                },
                stackLabels: {
                  enabled: true,
                  style: {
                    fontWeight: 'bold',
                    color: 'gray'
                  }
                }
            },
            plotOptions: {
                column: {
                  stacking: 'normal',
                  dataLabels: {
                    enabled: false
                  },
                },
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 70,
                y: 70,
                floating: true,
                shadow: true
            },
            series: []
        };

        $.get('{{url('')}}/graphpelaksana', function(data) {
            options4.series = [{
                name: 'Kekurangan',
                data: [data['kekurangan'], 0],
                color: "#f72424"
            },{
                name: 'Ketersediaan',
                data: [data['ketersediaan'], 0],
                color: "#7cb5ec"
            },{
                name: 'Kebutuhan',
                data: [0, data['kebutuhan']],
                color: "#434348"
            }]

            var chart2 = new Highcharts.Chart(options4);
        });

//  End Graph Pelaksana -----------------------------------------------------------------------
});
</script>

@include('home::dashboard.footer')