<div id="wrapper">
      <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#sidebar-menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bars"></span>
                </button>
                <img src="<?php echo $def_img?>Lambang_Kabupaten_Wonosobo.png" alt="Kabupaten Wonosobo" class="logo" width="39">
                <a class="navbar-brand" href="<?php echo base_url()?>diengplateu">EKSEKUTIF</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-nav hidden-sm hidden-xs">
                <li><a href="#"><div id="sidebar-toggle" class="fa fa-bars" title="collapse sidebar"></div></a></li>
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <!-- <div id="sidebar-toggle" class="fa fa-angle-double-left" title="collapse sidebar"></div> -->
                <div id="sidebar-menu" class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="user-status">
                               <!-- <p class="username">
                                    <strong><?=$this->session->userdata('username')?></strong> <br> <?=$this->session->userdata('name')?> <small><em>(Super Admin)</em></small>
                                </p> -->								
                                <a href="#" class="btn btn-sm btn-primary btn-sidebar"><i class="fa fa-gears"></i> &nbsp; Settings</a>  <a href="<?=base_url()?>diengplateu/auth/logout" class="btn btn-sm btn-danger btn-sidebar"><i class="fa fa-sign-out"></i> &nbsp; Logout</a>                            </div>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>diengplateu" class="external-link"><i class="fa fa-dashboard fa-fw"></i> &nbsp; Dashboard</a>
                        </li>
                       <!-- <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; Data umum<span class="fa plus-minus"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statjenkel">Jenis Kelamin</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statagama">Agama</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statgol">Golongan</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statpendid">Pendidikan</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statjenjab">Jenis Jabatan</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/stateselon">Eselon / Struktural</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statdikstru">Diklat Struktural</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statfungsional">Jabatan Fungsional</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statdikfung">Diklat Fungsional</a></li>
                                <!--<li><a href="<?php echo base_url()?>diengplateu/page/statistik/statfungsekdes">Fungsional Umum Sekdes Perkecamatan</a></li>-->
                                <!--<li><a href="<?php echo base_url()?>diengplateu/page/statistik/statskpd">SKPD</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statguru">Guru Non Guru</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statmarital">Status Pernikahan</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statkartu">Kepemilikan Kartu</a></li>
                                <li><a href="<?php echo base_url()?>diengplateu/page/statistik/statumum">Rekapitulasi</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
						
						
						
                        <li>
                            <a href="<?php echo base_url()?>diengplateu/page/statistik/statumum"><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; Data Statistik Kepegawaian</a>
                            
							
							
							
							
							
							
                            <!-- /.nav-second-level -->
                        </li>
						
						
						
						
						
<!--
                       <li class="sidebar-search"><strong>Data Khusus</strong></li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; Tenaga Kependidikan<span class="fa plus-minus"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Statistik Global</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Guru TK</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Guru SD</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Guru Mapel SMP</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Guru Mapel SMA</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Guru Mapel SMK</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Kepala Sekolah</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
							<!--
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; Tenaga Kesehatan<span class="fa plus-minus"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Statistik Global</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Dokter</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Bidan</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Perawat</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Apoteker</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Sanitarian</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Fisioterapis</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Nutrisionis</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Radiografer</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Perekam Medis</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
							<!--
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; Tenaga Pertanian<span class="fa plus-minus"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Statistik Global</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Penyuluh Pertanian</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Penyuluh Peternakan</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Dokter Hewan</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
							<!--
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; Tenaga Kehutanan<span class="fa plus-minus"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Statistik Global</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Penyuluh Kehutanan</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
							<!--
                        </li>
                        <li>
                            <a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php"><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; Data Relasi</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; Pemberhentian PNS<span class="fa plus-minus"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Pensiun per Bulan</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Pemberhentian per Jenis Kelamin</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Pemberhentian per Jenis Jabatan</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Pemberhentian per Golongan</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Pemberhentian per Eselon</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Pemberhentian per Jabatan Fungsional</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
							<!--
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; Kegiatan PNS<span class="fa plus-minus"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Ijin Penggunaan Gelar</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Tugas Belajar / Ijin Belajar</a></li>
                                <li><a href="<?php /*echo base_url()*/?>diengplateu/page/morris.php">Berdasarkan Diklat</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li class="sidebar-search">
                            <footer>
                                &copy;2014 Kab. Wonosobo.<br>
                                Dikembangkan oleh BKD</a>.
                            </footer>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>