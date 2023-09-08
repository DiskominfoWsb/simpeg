<?php
	set_time_limit(0);
    ini_set('memory_limit', '10048M');
    
    $mysqli = new mysqli("10.0.1.9","simpeg","P3g4w41asnWSBdb2023","simpeg_v19");

    $host = 'localhost';
	$user = 'simpeg';
	$pass = 'P3g4w41asnWSBdb2023';
    
    
    
    $month = isset($_GET['month']) ? $_GET['month'] : '';
    $year = isset($_GET['year']) ? $_GET['year'] : '';
    
    
    
    $kalender   = CAL_GREGORIAN; 
    $jml_hari   = cal_days_in_month($kalender, $month, $year);
    
    $tanggal_awal  = $year.'-'.$month.'-01';
    $tanggal_akhir  = $year.'-'.$month.'-'.$jml_hari;

    
    if (count($where) > 0) {
        $where = join(" and ", $where); 
        $where = " and $where ";
    } else $where = "";
    

    
    

    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
      exit();
    }

    
    $sql  = "select nip, nama, tgl_mulai, tgl_selesai, id_jenis_cuti, alasan, id, nosk_cuti  from tr_ijin_cuti where  (nosk_cuti <> '' and LENGTH(nosk_cuti) > 8 ) and ((year(tgl_mulai)=$year and  month(tgl_mulai) = '$month') or ( year(tgl_selesai) = '$year' and month(tgl_selesai)='$month') or 
        (('".$tanggal_awal."' between tgl_mulai and tgl_selesai) and ('".$tanggal_akhir."' between tgl_mulai and tgl_selesai))) ";
    
    
    // $sql  = "select nip, nama, tgl_mulai, tgl_selesai, id_jenis_cuti, alasan, id, nosk_cuti  from tr_ijin_cuti where  (nosk_cuti <> '' and LENGTH(nosk_cuti) > 8 ) and  (('".$tanggal_awal."' between tgl_mulai and tgl_selesai) and ('".$tanggal_akhir."' between tgl_mulai and tgl_selesai))";

     /*
     
        select nip, nama, tgl_mulai, tgl_selesai, id_jenis_cuti, alasan, id, nosk_cuti  from tr_ijin_cuti where  (nosk_cuti <> '' and LENGTH(nosk_cuti) > 8 ) and 
        ('2022-06-01' between tgl_mulai and tgl_selesai) and ('2022-06-30' between tgl_mulai and tgl_selesai) and 
        id_jenis_cuti  = '4'
     
     */
    
    


$result = $mysqli->query($sql);

$hasil = array(); 
$items = array();


// Associative array
while ($row = $result->fetch_assoc()) {
      array_push($items, $row);
}


$hasil["total"] = count($items);

$hasil["rows"] = $items;
echo json_encode($hasil);

// Free result set
$result->free_result();
$mysqli->close();

	
?>