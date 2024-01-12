        <?php
            $rsjenkel = $this->db->query("SELECT IF(idjenkel=1,'Pria',IF(idjenkel=2,'Wanita','-')) AS kategori, COUNT(*) AS pns FROM tb_0823
                  WHERE idjenkedudupeg NOT IN (99,21) GROUP BY idjenkel");

            $rsagama = $this->db->query("SELECT a.idagama, a.agama, SUM(IF(b.idagama!='',1,0)) AS jml FROM a_agama a
                  LEFT JOIN tb_0823 b ON a.idagama = b.idagama AND b.idjenkedudupeg NOT IN (99,21) GROUP BY a.idagama");

            $rsjab = $this->db->query("SELECT a.jenjab, SUM(IF(b.idjenjab!='',1,0)) AS jml FROM a_jenjab a
                  LEFT JOIN tb_0823 b ON a.idjenjab = b.idjenjab AND b.idjenkedudupeg NOT IN (99,21) GROUP BY a.idjenjab");

            $rspendidikan = $this->db->query("SELECT a.tkpendid, COUNT(*) AS jml FROM a_tkpendid a
                  LEFT JOIN tb_0823 b ON a.idtkpendid = b.idtkpendid AND b.idjenkedudupeg NOT IN (99,21) GROUP BY a.idtkpendid;");
        ?>

        <script type="text/javascript">

            $(document).ready(function(){

                var options2 = {
                    chart: {
                        renderTo: 'graph-pns',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Grafik PNS BKD Wonosobo - Agust. 2023'
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
                        text: 'Grafik CPNS BKD Wonosobo - Agust. 2023'
                    },
                    subtitle: {
                        text: 'Source: e-simpeg.bkdwonosobo.go.id'
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
                        text: 'Grafik CPNS BKD Wonosobo - Agust. 2023'
                    },
                    subtitle: {
                        text: 'Source: e-simpeg.bkdwonosobo.go.id'
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
                        text: 'Statistik PNS - Agust. 2023'
                    },
                    subtitle: {
                        text: 'Source: e-simpeg.bkdwonosobo.go.id'
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
                }

                var chart = new Highcharts.Chart(options5);

                var options6 = {
                    chart: {
                        renderTo: 'graph-jabatan',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Statistik PNS - Agust. 2023'
                    },
                    subtitle: {
                        text: 'Source: e-simpeg.bkdwonosobo.go.id'
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
                        text: 'Statistik PNS - Agust. 2023'
                    },
                    subtitle: {
                        text: 'Source: e-simpeg.bkdwonosobo.go.id'
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
                        text: 'Statistik PNS - Agust. 2023'
                    },
                    subtitle: {
                        text: 'Source: e-simpeg.bkdwonosobo.go.id'
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
        </script>

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
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
                                    <div class="huge"><?php echo $this->siemodel->getPns()?></div>
                                    <div>Total Pegawai</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
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
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
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
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-mortar-board fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $this->siemodel->getPensiun()?></div>
                                    <div>Total Pensiun</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
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
                            <i class="fa fa-bar-chart-o fa-fw"></i> Tabel Pegawai Negeri Sipil
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table class="table table-hover table-bordered" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%"><div align="center">No</div></th>
                                    <th><div align="center">Golongan</div></th>
                                    <th width="17%"><div align="center">PNS</div></th>
                                    <th width="17%"><div align="center">CPNS</div></th>
                                    <th width="17%"><div align="center">Pensiun</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $x = 0;
                                    $sumcpsn[$x] = 0;
                                    $sumpsn[$x] = 0;
                                    $sumpensiun[$x] = 0;
                                    foreach ($this->siemodel->getGrafikpegawai()->result() as $item) {
                                        $sumcpns[$x] = $item->pns;
                                        $sumpns[$x] = $item->cpns;
                                        $sumpensiun[$x] = $item->pensiun;
                                        $x++;
                                ?>
                                    <tr>
                                        <td><?php echo $x?></td>
                                        <td><?php echo $item->golru." - ".$item->pangkat?></td>
                                        <td><div align="right"><?php echo number_format($item->pns)?></div></td>
                                        <td><div align="right"><?php echo number_format($item->cpns)?></div></td>
                                        <td><div align="right"><?php echo number_format($item->pensiun)?></div></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="2">Grand Total</td>
                                    <td><div align="right"><?php echo number_format(array_sum($sumcpns))?></div></td>
                                    <td><div align="right"><?php echo number_format(array_sum($sumpns))?></div></td>
                                    <td><div align="right"><?php echo number_format(array_sum($sumpensiun))?></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
				
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Berdasarkan Jenkel
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" align="center">
							<div id="graph-jenkel" style="height:250px;"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Berdasarkan Jabatan
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" align="center">
                            <div id="graph-jabatan" style="height:250px;"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

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
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        
