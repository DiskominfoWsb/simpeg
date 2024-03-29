        <?php
		   $rsjenkel = $this->db->query("SELECT IF(idjenkel=1,'Pria',IF(idjenkel=2,'Wanita','-')) AS kategori, COUNT(*) AS pns FROM tb_0623
                  WHERE idjenkedudupeg NOT IN (99,21) GROUP BY idjenkel");
				 
            $rsagama = $this->db->query("SELECT a.idagama, a.agama, SUM(IF(b.idagama!='',1,0)) AS jml FROM a_agama a
                  LEFT JOIN tb_0623 b ON a.idagama = b.idagama AND b.idjenkedudupeg NOT IN (99,21) GROUP BY a.idagama");

            $rsjab = $this->db->query("SELECT a.jenjab, SUM(IF(b.idjenjab!='',1,0)) AS jml FROM a_jenjab a
                  LEFT JOIN tb_0623 b ON a.idjenjab = b.idjenjab AND b.idjenkedudupeg NOT IN (99,21) GROUP BY a.idjenjab");

            $rspendidikan = $this->db->query("SELECT a.tkpendid, COUNT(*) AS jml FROM a_tkpendid a
                  LEFT JOIN tb_0623 b ON a.idtkpendid = b.idtkpendid AND b.idjenkedudupeg NOT IN (99,21) GROUP BY a.idtkpendid;");
        ?>

        <script type="text/javascript">

            $(document).ready(function(){

                var options2 = {
                    chart: {
                        renderTo: 'graph-pns',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Grafik PNS BKD Wonosobo - Juni 2023'
                    },
                    subtitle: {
                        text: 'Source: e-simpegwonosobo'
                    },
                    xAxis: {
                        categories: []
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        backgroundColor: '#FFFFFF',
                        align: 'left',
                        verticalAlign: 'top',
                        x: 100,
                        y: 70,
                        floating: true,
                        shadow: true
                    },
                    series: []
                };

                $.get('<?=base_url()?>diengplateu/graphPNS', function(data) {
                    var lines = data.split('\n');
                    $.each(lines, function(lineNo, line) {
                        var items = line.split(',');
                        if(line!=''){
                            if (lineNo == 0) {
                                $.each(items, function(itemNo, item) {
                                    if (itemNo > 0) options2.xAxis.categories.push(item);
                                });
                            }else {
                                var series = {
                                    data: []
                                };
                                $.each(items, function(itemNo, item) {
                                    if (itemNo == 0) {
                                        series.name = item;
                                    } else {
                                        series.data.push(parseFloat(item));
                                    }
                                });
                                options2.series.push(series);
                            }
                        }
                    });

                    var chart2 = new Highcharts.Chart(options2);
                });

                var options3 = {
                    chart: {
                        renderTo: 'graph-cpns',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Grafik CPNS BKD Wonosobo - Juni 2023'
                    },
                    subtitle: {
                        text: 'Source: simpeg.wonosobokab.go.id'
                    },
                    xAxis: {
                        categories: []
                    },
                    yAxis: {
                        min:0,
                        title: {
                            text: 'Jumlah'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        backgroundColor: '#FFFFFF',
                        align: 'left',
                        verticalAlign: 'top',
                        x: 100,
                        y: 70,
                        floating: true,
                        shadow: true
                    },
                    series: []
                };

                $.get('<?=base_url()?>diengplateu/graphCPNS', function(data) {
                    var lines = data.split('\n');
                    $.each(lines, function(lineNo, line) {
                        var items = line.split(',');
                        if(line!=''){
                            if (lineNo == 0) {
                                $.each(items, function(itemNo, item) {
                                    if (itemNo > 0) options3.xAxis.categories.push(item);
                                });
                            }else {
                                var series = {
                                    data: []
                                };
                                $.each(items, function(itemNo, item) {
                                    if (itemNo == 0) {
                                        series.name = item;
                                    } else {
                                        series.data.push(parseFloat(item));
                                    }
                                });
                                options3.series.push(series);
                            }
                        }
                    });

                    var chart = new Highcharts.Chart(options3);
                });

                var options4 = {
                    chart: {
                        renderTo: 'graph-pensiun',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Grafik CPNS BKD Wonosobo - Juni 2023'
                    },
                    subtitle: {
                        text: 'Source: simpeg.wonosobokab.go.id'
                    },
                    xAxis: {
                        categories: []
                    },
                    yAxis: {
                        min:0,
                        title: {
                            text: 'Jumlah'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        backgroundColor: '#FFFFFF',
                        align: 'left',
                        verticalAlign: 'top',
                        x: 100,
                        y: 70,
                        floating: true,
                        shadow: true
                    },
                    series: []
                };

                $.get('<?=base_url()?>diengplateu/graphPensiun', function(data) {
                    var lines = data.split('\n');
                    $.each(lines, function(lineNo, line) {
                        var items = line.split(',');
                        if(line!=''){
                            if (lineNo == 0) {
                                $.each(items, function(itemNo, item) {
                                    if (itemNo > 0) options4.xAxis.categories.push(item);
                                });
                            }else {
                                var series = {
                                    data: []
                                };
                                $.each(items, function(itemNo, item) {
                                    if (itemNo == 0) {
                                        series.name = item;
                                    } else {
                                        series.data.push(parseFloat(item));
                                    }
                                });
                                options4.series.push(series);
                            }
                        }
                    });

                    var chart = new Highcharts.Chart(options4);
                });

                var options5 = {
                    chart: {
                        renderTo: 'graph-jenkel',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Statistik PNS - Juni 2023'
                    },
                    subtitle: {
                        text: 'Source: simpeg.wonosobokab.go.id'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y:.2f}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },

                    series: [{
                        type: 'pie',
                        name: 'PNS',
                        data: [
                        <?php foreach($rsjenkel->result() as $row) {?>
                            ['<?php echo $row->kategori?>',   <?php echo $row->pns?>],
                            <?php } ?>
                        ]
                    }]
                };

                var chart = new Highcharts.Chart(options5);

                var options6 = {
                    chart: {
                        renderTo: 'graph-jabatan',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Statistik PNS - Juni 2023'
                    },
                    subtitle: {
                        text: 'Source: simpeg.wonosobokab.go.id'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y:.2f}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },

                    series: [{
                        type: 'pie',
                        name: 'PNS',
                        data: [
                        <?php foreach($rsjab->result() as $row) {?>
                            ['<?php echo $row->jenjab?>',   <?php echo $row->jml?>],
                            <?php } ?>
                        ]
                    }]
                }

                var chart = new Highcharts.Chart(options6);

                var options7 = {
                    chart: {
                        renderTo: 'graph-agama',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Statistik PNS - Juni 2023'
                    },
                    subtitle: {
                        text: 'Source: simpeg.wonosobokab.go.id'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y:.2f}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },

                    series: [{
                        type: 'pie',
                        name: 'PNS',
                        data: [
                        <?php foreach($rsagama->result() as $row) {?>
                            ['<?php echo $row->agama?>',   <?php echo $row->jml?>],
                            <?php } ?>
                        ]
                    }]
                }

                var chart = new Highcharts.Chart(options7);

                var options8 = {
                    chart: {
                        renderTo: 'graph-pendidikan',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Statistik PNS - Juni 2023'
                    },
                    subtitle: {
                        text: 'Source: simpeg.wonosobokab.go.id'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y:.2f}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },

                    series: [{
                        type: 'pie',
                        name: 'PNS',
                        data: [
                        <?php foreach($rspendidikan->result() as $row) {?>
                            ['<?php echo $row->tkpendid?>',   <?php echo $row->jml?>],
                            <?php } ?>
                        ]
                    }]
                }

                var chart = new Highcharts.Chart(options8);
            });

        <!--gol-->
        var options = {
        chart: {
            renderTo: 'graph-golongan',
            defaultSeriesType: 'column'
        },
        title: {
            text: 'Grafik PNS Berdasarkan Golongan - Juni 2023'
        },
        subtitle: {
            text: 'Source: simpeg.wonosobokab.go.id'
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            min:0,
            title: {
                text: 'Jumlah'
            }
        },
        legend: {
            /*layout: 'vertical',
            backgroundColor: '#FFFFFF',
            align: 'left',
            verticalAlign: 'top',
            x: 100,
            y: 70,
            floating: true,
            shadow: true*/

            layout: 'horizontal',
            backgroundColor: '#FFFFFF',
            align: 'center',
            verticalAlign: 'bottom',
            /*x: 100,*/
            y: 5,
            floating: false,
            shadow: true,
            enabled: true
        },
        series: []
    };

    $.ajax({
        url:'<?=base_url()?>diengplateu/graphGolongan',
        type:'post',
        data:{'idkategori': $('#idkategori').val(), 'idskpd': $('#idskpd').val()},
        beforeSend:function(){},
        success:function(data){
            var lines = data.split('\n');
            $.each(lines, function(lineNo, line) {
                var items = line.split(',');
                if(line!=''){
                    if (lineNo == 0) {
                        $.each(items, function(itemNo, item) {
                            if (itemNo > 0) options.xAxis.categories.push(item);
                        });
                    }else {
                        var series = {
                            data: []
                        };
                        $.each(items, function(itemNo, item) {
                            if (itemNo == 0) {
                                series.name = item;
                            } else {
                                series.data.push(parseFloat(item));
                            }
                        });
                        options.series.push(series);
                    }
                }
            });

            var chart = new Highcharts.Chart(options);
        }
    });
<!--eselon-->
      var options12 = {
        chart: {
            renderTo: 'graph-eselon',
            defaultSeriesType: 'column'
        },
        title: {
            text: 'Grafik PNS Berdasarkan Eselon - Juni 2023'
        },
        subtitle: {
            text: 'Source: simpeg.wonosobokab.go.id'
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            min:0,
            title: {
                text: 'Jumlah'
            }
        },
        legend: {
            /*layout: 'vertical',
            backgroundColor: '#FFFFFF',
            align: 'left',
            verticalAlign: 'top',
            x: 100,
            y: 70,
            floating: true,
            shadow: true*/

            layout: 'horizontal',
            backgroundColor: '#FFFFFF',
            align: 'center',
            verticalAlign: 'bottom',
            /*x: 100,*/
            y: 5,
            floating: false,
            shadow: true,
            enabled: true
        },
        series: []
    };

    $.ajax({
        url:'<?=base_url()?>diengplateu/graphEselon',
        type:'post',
        data:{'idkategori': $('#idkategori').val(), 'idskpd': $('#idskpd').val()},
        beforeSend:function(){},
        success:function(data){
            var lines = data.split('\n');
            $.each(lines, function(lineNo, line) {
                var items = line.split(',');
                if(line!=''){
                    if (lineNo == 0) {
                        $.each(items, function(itemNo, item) {
                            if (itemNo > 0) options12.xAxis.categories.push(item);
                        });
                    }else {
                        var series = {
                            data: []
                        };
                        $.each(items, function(itemNo, item) {
                            if (itemNo == 0) {
                                series.name = item;
                            } else {
                                series.data.push(parseFloat(item));
                            }
                        });
                        options12.series.push(series);
                    }
                }
            });

            var chart = new Highcharts.Chart(options12);
        }
    });  
        </script>
        

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Data Bulan Juni 2023</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-signal fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->siemodel->getPegawai()?></div>
                                    <div>Total ASN</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->siemodel->getPns()?></div>
                                    <div>Total PNS</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-compress fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->siemodel->getCpns()?></div>
                                    <div>Total CPNS</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-institution fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->siemodel->getPppk()?></div>
                                    <div>Total PPPK</div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                

                 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-home fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->siemodel->getStruktural()?></div>
                                    <div>Total Struktural</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>


<div class="col-lg-3 col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-photo fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->siemodel->getFungsional()?></div>
                                    <div>Total Fungsional</div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>


                 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bookmark-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->siemodel->getPelaksana()?></div>
                                    <div>Total Pelaksana</div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>

<div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-square-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->siemodel->getPensiun()?></div>
                                    <div>Pensiun Bulan ini</div>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>





            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Grafik Pegawai Negeri Sipil                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#pns" data-toggle="tab">PNS</a></li>
                                <li><a href="#cpns" data-toggle="tab">CPNS</a></li>
                                <li><a href="#pensiun" data-toggle="tab">Pensiun</a></li>                                
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content" align="center">
                                <div class="tab-pane fade in active" id="pns">
                                    <h4>Grafik PNS</h4>
                                    <div id="graph-pns"></div>
                                </div>
                                <div class="tab-pane fade" id="cpns">
                                    <h4>Grafik CPNS</h4>
                                    <div id="graph-cpns"></div>
                                </div>
                                <div class="tab-pane fade" id="pensiun">
                                    <h4>Grafik Pensiun</h4>
                                    <div id="graph-pensiun"></div>
                                </div>                                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Grafik Golongan PNS                           
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="graph-golongan" style="width:100%; height: 500px;"></div>
                    </div> 
                    </div> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Grafik Struktural                   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                             <div id="graph-eselon" style="width:100%; height: 500px;"></div>
                    </div> 
                    </div> 

                                   
                    
                    <!-- /.panel--> 
                </div>
                <!--/.col-lg-8 -->
				
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Berdasarkan Jenis Kelamin
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" align="center">
							                             
                                <div class="panel-body" align="center">
                                    <div id="graph-jenkel" style="height:250px;"></div>
                                </div>
                                                        
                           							
                        </div>
                        <!-- /.panel-body -->
                    </div>
					 <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Berdasarkan Agama
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" align="center">
                            <div id="graph-agama" style="height:250px;"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Berdasarkan Pendidikan
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" align="center">
                            <div id="graph-pendidikan" style="height:250px;"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <!-- /.panel -->

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Berdasarkan Jenis Jabatan
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" align="center">
                            <div id="graph-jabatan" style="height:250px;"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
     

                    
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        
