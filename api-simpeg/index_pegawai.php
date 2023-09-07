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
			a.idtkpendid, a.idjenjurusan, i.jenjurusan, 
			updatetime, 
			d.jabfung2, 
			concat(e.jab, ' ', e.skpd) as skpd_jab, 
			g.idesl, 
			j.jabfungum, 
			a.idstspeg
			FROM `tb_01` as a
			left join ".$db_proses.".a_jabfung as d on d.idjabfung = a.idjabfung
			left join ".$db_proses.".skpd as e on e.idskpd = a.idjabjbt
			left join ".$db_proses.".skpd as f on f.idskpd = a.idskpd
			left join ".$db_proses.".a_esl as g on g.idesl = a.idesljbt
			left join ".$db_proses.".a_tkpendid as h on a.idtkpendid = h.idtkpendid
			left join ".$db_proses.".a_jenjurusan as i on a.idjenjurusan = i.idjenjurusan
			left join ".$db_proses.".a_jabfungum as j on a.idjabfungum = j.idjabfungum
			
					
			WHERE $where a.idjenkedudupeg <> '21' and a.idjenkedudupeg <> '99' limit 7000";

	
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
			else if (strlen($row['idskpd'])==8)  $row['idskpd'] =  $row['idskpd'];
			
			$data_kepala_skpd = file_get_contents('http://e-absensi.wonosobokab.go.id/absensi/api/get_kepala_opd_sekda_for_lagi_on.php?kd_skpd='.$row['idskpd']);
			$data_kepala_skpd = json_decode($data_kepala_skpd, true);
						
			
			$row['nip_kpl_opd']    = $data_kepala_skpd['NIP'];
			$row['nama_kpl_opd']   = $data_kepala_skpd['nama'];
			$row['jabatan_kpl_opd'] = $data_kepala_skpd['JABATAN'];
				
				
			$row['nip_kpl_sekda']    = '';
			$row['nama_kpl_sekda']   = '';
			$row['jabatan_kpl_sekda'] = '';
			
			// if ($row['idesl']=='21' or $row['idesl']=='22') {
				$data_kepala_sekda = file_get_contents('http://e-absensi.wonosobokab.go.id/absensi/api/get_kepala_opd_sekda_for_lagi_on.php?kd_skpd=02');
				$data_kepala_sekda = json_decode($data_kepala_sekda, true);
				
				$row['nip_kpl_sekda']    = $data_kepala_sekda['NIP'];
				$row['nama_kpl_sekda']   = $data_kepala_sekda['nama'];
				$row['jabatan_kpl_sekda'] = $data_kepala_sekda['JABATAN'];
			// }
			// proses ambil ke e-absensi untuk mengambil data kepala opd
			
			
			array_push($items, $row);
		}
		$result["rows"] = $items;
		echo json_encode($result);
	}
?>
