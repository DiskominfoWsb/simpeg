<?php
	set_time_limit(0);
	include "config/config.php";
	include "config/function.php";
	include "config/koneksi.php";
	
	$nip = isset($_GET['nip']) ? mysql_real_escape_string($_GET['nip']) : '';
	$where = "";
	if ($nip <> '' ) $where = " a.nip = '$nip' and ";
	$sql = "SELECT 
			`nip`, 
			if(gdp <> '' and gdb <> '' , concat(gdp,' ',nama,', ',gdb), 
			if(gdp <> '' and gdb = '' , concat(gdp,' ', nama), 
			if(gdp = '' and gdb <> '' , concat(nama,', ',gdb), nama
			))) as nama , 
			`tglhr`, 
			`tmlhr`, 
			`idagama`, 
			a.`alm`, 
			almkdpos, 
			a.idskpd, 
			`tmtcpn`, 
			a.`idjenjab`,
			a.idjenkel,
			a.`idjabfung`,
			a.`idjabfungum`,
			a.`idjabjbt`, 
			a.idgolrupkt, 
			a.idtkpendid, a.idjenjurusan,
			updatetime,  
			idesljbt
			FROM `tb_01` as a
			left join ".$db_proses.".skpd as f on f.idskpd = a.idskpd
			WHERE $where a.idjenkedudupeg <> '21' and a.idjenkedudupeg <> '99' and nama <> '' ";
	
	// echo $sql;
	
	$result = array(); 
	$hasil  = $koneksi->getAllDataAssoc($sql);
	$result['jml']    = $koneksi->getNumRows($sql);
	$items = array();
	if ($result['jml'] > 0) {
		foreach ($hasil as $row) {
			$row['idskpd'] = str_replace(".","",$row['idskpd']);
			if (strlen($row['idskpd'])==2)  $row['idskpd'] =  $row['idskpd'].'000000';
			else if (strlen($row['idskpd'])==4)  $row['idskpd'] =  $row['idskpd'].'0000';
			else if (strlen($row['idskpd'])==6)  $row['idskpd'] =  $row['idskpd'].'00';
			else if (strlen($row['idskpd'])==8)  $row['idskpd'] =  $row['idskpd'].'';
			array_push($items, $row);
		}
		$result["rows"] = $items;
		echo json_encode($result);
	}
?>
