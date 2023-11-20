<?php
	// setting koneksi dengan database mysql 
	$db_master = "simpeg_v19";
	$db_proses = "simpeg_v19";
	$db_gammu  = "simpeg_v19";
	
	$sts_online = '0'; // 0 nonaktif - ofline 1 aktif - online / hosting
	
	$msg_404 = 'Anda Tidak Berhak mengakses Ini';
	$msg_query = 'Some errors occured.';
	$msg_no_data = 'Data Tidak Ada';
	$title  = 'Absensi -  ';
	$footer = '&copy;  '; 
	$sim_card = 'tree'; // {tree, simpati, xls, indosat}
	$host = '10.0.1.9';
	$user = 'simpeg';
	$pass = 'P3g4w41asnWSBdb2023';

	$koneksi = new koneksiDB();
	$koneksi->StartConnectServer($host,$user,$pass);
	$koneksi->startConnectDB($db_proses);
?>
