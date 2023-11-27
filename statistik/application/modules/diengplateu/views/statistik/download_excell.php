<!DOCTYPE html>
<html dir="ltr">
  <head>
    <title>Statistik Data PNS Pemkab. Wonosobo</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" href="dinustek">
    <link rel="shortcut icon" href="<?php echo $def_img?>favicon.png">

    <link rel="stylesheet" type="text/css" href="<?php echo $def_css?>font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $def_css?>main.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo $def_css?>theming.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo $def_css?>outdatedbrowser.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $def_css?>select2.css" rel="stylesheet">

    <script type="text/javascript" src="<?php echo $def_js?>jquery-1.11.0.js"></script>
    <script type="text/javascript" src="<?php echo $def_js?>bootstrap.min.js"></script>
	<script src="<?php echo $def_js?>highcharts.js"></script>
	<script src="<?php echo $def_js?>modules/exporting.js"></script>
    <!-- DataTables JavaScript -->
    <script src="<?php echo $def_js?>jquery.dataTables.js"></script>
    <script src="<?php echo $def_js?>dataTables.bootstrap.js"></script>
    <script src="<?php echo $def_js?>outdatedbrowser.min.js"></script>
    <script src="<?php echo $def_js?>select2.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Kepala OPD.xls");
?>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Daftar Kepala OPD Persen <?php echo date('d F Y')?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="row">
    <div class="span5">
        <table class="table table-hover table-bordered" width="100%" id="tb-statistik">
            <thead>
                <tr>
                    <th width="5%"><div align="center">No. </div></th>
                    <th><div align="center">Perangkat Daerah</div></th>
                    <th><div align="center">Nama Pejabat</div></th>
                    <th><div align="center">Pangkat/Gol. Ruang</div></th>
                    <th><div align="center">Eselon</div></th>
                    <th><div align="center">Pendidikan</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $x = 0;

                $rs = $this->db->query("SELECT a.skpd,concat(if(b.gdp='','',concat(b.gdp,' ')),b.nama,if(b.gdb='','',concat(', ',b.gdb)))as nama, c.pangkat, c.golru, d.esl as eselon, e.jenjurusan from a_skpd a
                left join tb_01 b on a.idskpd=b.idskpd
                left join a_golruang c on b.idgolrupkt=c.idgolru
                left join a_esl d on b.idesljbt=d.idesl
                left join a_jenjurusan e on b.idjenjurusan=e.idjenjurusan
                WHERE  length(a.idskpd)='2' and a.flag='1' and b.idjenkedudupeg not in('21','99') and b.idesljbt in('21','22','31') or (a.idskpd like'01.%' and b.idjenkedudupeg not in('21','99'))
                or (a.idskpd like'02.%' and b.idjenkedudupeg not in('21','99') and b.idesljbt='31')");
                foreach ($rs->result() as $item) {
                    $x++;
                    ?>
                <tr>
                    <td align="center"><?php echo $x?></td>
                    <td><?php echo $item->skpd?></td>
                    <td><?php echo $item->nama?></td>
                    <td align="center"><?php echo $item->pangkat."<br>".$item->golru?></td>
                    <td align="center"><?php echo $item->eselon?></td>
                    <td align="center"><?php echo $item->jenjurusan?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
                </body>
