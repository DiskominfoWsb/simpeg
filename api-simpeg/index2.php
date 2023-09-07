<?php
	set_time_limit(0);
	include "config/config.php";
	include "config/function.php";
	include "config/koneksi.php";
	
	$nip = isset($_GET['nip']) ? mysql_real_escape_string($_GET['nip']) : '';
	$where = "";
	if ($nip <> '') $where = "a.nip = '$nip' and "; 
	$sql = "select a.idtkpendid, a.idjenjurusan, a.nip, a.nama, a.gdp, a.gdb, a.tmlhr, a.tglhr, a.alm, a.idgolrupkt, a.tmtcpn, concat(golru,' ', pangkat) as golru , d.jabfung2, concat(e.jab, ' ',e.path_short) jabstruk, 
	f.skpd, a.idesljbt ,g.esl, h.tkpendid, a.idstspeg
	from tb_01 as a 
	left join ".$db_proses.".a_jenjab as b on a.idjenjab = b.idjenjab
	left join ".$db_proses.".a_golruang as c on c.idgolru = a.idgolrupkt
	left join ".$db_proses.".a_jabfung as d on d.idjabfung = a.idjabfung
	left join ".$db_proses.".skpd as e on e.idskpd = a.idjabjbt
	left join ".$db_proses.".skpd as f on f.idskpd = a.idskpd
	left join ".$db_proses.".a_esl as g on g.idesl = a.idesljbt
        left join ".$db_proses.".a_tkpendid as h on a.idtkpendid = h.idtkpendid
	
	where $where (a.idjenkedudupeg <> '21' and  a.idjenkedudupeg <> '99')";

	
	$result = array(); 
	$hasil  = $koneksi->getAllDataAssoc($sql);
	$result['jml']    = $koneksi->getNumRows($sql);
	$items = array();
	if ($result['jml'] > 0) {
		foreach ($hasil as $row) {
			array_push($items, $row);
		}
		$result["rows"] = $items;
		echo json_encode($result);
	}
?>