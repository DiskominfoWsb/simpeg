<?php
	set_time_limit(0);
    // header('Access-Control-Allow-Origin: *')tamabahi;
    ini_set('memory_limit', '10048M');
    
    $mysqli = new mysqli("10.0.1.9","simpeg","P3g4w41asnWSBdb2023","simpeg_v19");

    $host = 'localhost';
	$user = 'simpeg';
	$pass = 'P3g4w41asnWSBdb2023';
    
    

    $nip = isset($_GET['nip']) ? $_GET['nip'] : '';
    
    
   
    $where[] = " a.nip = '$nip' "; 
    
    
    if (count($where) > 0) {
        $where = join(" and ", $where); 
        $where = " and $where ";
    } else $where = "";
    



    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
      exit();
    }
    
    $sql  = "SELECT concat(if(a.gdp='','',concat(a.gdp,' ')),a.nama,if(a.gdb='','',concat(', ',a.gdb)))as nama,  nip, if(idjenkel='1','L', 'P') as idjenkel, if(idstspeg='1', 'CPNS',IF(idstspeg='2', 'PNS','PPPK')) as idstspeg, a.idskpd as idskpd, 
    b.pangkat,b.golru,idgolrupkt, a.idesljbt, if(a.idjenjab in('20','30','40'), e.jab,if(a.idjenjab='2',j.jabfung, o.jabfungum)) as jabatan, a.kelas_jabatan, a.idstspeg as jenis_pegawai
    from tb_01 as a
    left join a_golruang b on a.idgolrupkt=b.idgolru
    left join a_skpd e on a.idskpd = e.idskpd
    left join a_jabfung j on a.idjabfung=j.idjabfung
    left join a_jabfungum o on a.idjabfungum=o.idjabfungum
    where a.idjenkedudupeg not in('21','99')  $where order by a.idskpd asc";
    
    

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();


echo json_encode($row);

// Free result set
$result->free_result();
$mysqli->close();

	
?>