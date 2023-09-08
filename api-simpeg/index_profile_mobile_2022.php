<?php
	set_time_limit(0);
    // header('Access-Control-Allow-Origin: *');
    ini_set('memory_limit', '10048M');
    
    $mysqli = new mysqli("10.0.1.9","simpeg","P3g4w41asnWSBdb2023","simpeg_v19");

    $host = '10.0.1.9';
	$user = 'simpeg';
	$pass = 'P3g4w41asnWSBdb2023';
    
    

    $nip = isset($_GET['nip']) ? $_GET['nip'] : '';
    
    
   
    $where = " a.nip = '$nip' "; 
    
    
  
    
    $where  = "where $where";


    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
      exit();
    }
    
    $sql  = "SELECT p.skpd as skpd, c.skpd as unit_kerja, a.nip, concat(if(a.gdp='', '',concat(a.gdp,' ')),a.nama,if(a.gdb='', '',concat(', ',a.gdb)))as nama, a.tmlhr as tempat_lahir, date_format(a.tglhr,'%d-%m-%Y') as tanggal_lahir, if(a.idjenkel='1', 'LAKI-LAKI', 'PEREMPUAN') as jenis_kelamin, h.agama , if(a.idstspeg='1', 'CPNS',IF(a.idstspeg='2', 'PNS','PPPK'))as status_pegawai, if(a.idstskawin='1', 'BELUM KAWIN' ,IF(a.idstskawin='2', 'KAWIN',IF(a.idstskawin='3', 'JANDA' ,IF(a.idstskawin='4', 'DUDA', '-')))) as status_kawin, o.jenkedudupeg as kedudukan_asn, a.alm, a.almrt as RT, a.almrw as RW, a.almdesa as desa, a.almkec as kecamatan, a.almkab as kabupaten, a.almprov as provinsi, a.hp, a.nokarpeg as no_karpeg,a.noaskes as no_askes,a.notaspen as no_taspen,a.nokaris as no_karis, a.nonpwp, a.email, a.email_dinas,
    a.noskcpn as no_sk_cpns, date_format (a.tgskcpn,'%d-%m-%Y') as tanggal_sk_cpns, q.pangkat as pangkat_cpns, date_format(a.tmtcpn,'%d-%m-%Y') as tmt_cpns, a.mkthncpn as masa_kerja_tahun_cpns, a.mkblncpn as masa_kerja_bulan_cpns,
    a.noskpns as no_sk_pns, date_format(a.tgskpns,'%d-%m-%Y') as tanggal_sk_pns, r.pangkat as pangkat_pns, date_format(a.tmtpns,'%d-%m-%Y') as tmt_pns,
    a.noskpkt as no_sk_pangkat, date_format(a.tgskpkt,'%d-%m-%Y') as tanggal_sk_pangkat, b.pangkat as pangkat,b.golru as gol, q.golru as golcpn, r.golru as golpn, date_format(a.tmtpkt,'%d-%m-%Y') as tmt_pangkat, a.mkthnpkt as masa_kerja_tahun, a.mkblnpkt as masa_kerja_bulan,
    a.noskkgb as no_sk_kgb, date_format(a.tgskkgb,'%d-%m-%Y') as tanggal_sk_kgb, date_format(a.tmtkgb,'%d-%m-%Y') as tmt_kgb, a.mkthnkgb as masa_tahun_kgb, a.mkblnkgb as masa_bulan_kgb,
    a.gaji, a.noijaz as no_ijasah, a.thijaz as tahun_ijasah, e.jenjurusan as pendidikan, a.namasekolah as sekolah, a.nosttp_dikstru as no_sttp_diklat, a.tgsttp_dikstru as tanggal_sttp_diklat, a.nmdikstru as nama_diklat, a.penyelenggara_dikstru as penyelenggara_diklat, a.tgmul_dikstru as tanggal_mulai_dikstru, a.tgsel_dikstru as tanggal_selesai_dikstru, 
    a.noskjbt as no_sk_jabatan, date_format(a.tgskjbt,'%d-%m-%Y') as tanggal_sk_jabatan, date_format(a.tmtjbt,'%d-%m-%Y') as tmt_jabatan, i.jenjab as jenis_jabatan, COALESCE(g.esl,'-') as eselon, 
    if(a.idjenjab in('20','30','40'), c.jab,if(a.idjenjab='2', j.jabfung,l.jabfungum))as jabatan, m.tugasgurudosen as tugas_guru, b.pangkat,b.golru, k.matkulpel as mapel, a.iskepsek from `tb_01`a
    left join a_golruang b on a.idgolrupkt=b.idgolru

left join a_golruang q on a.idgolrucpn=q.idgolru
left join a_golruang r on a.idgolrupns=r.idgolru



    left join a_skpd c on a.idskpd=c.idskpd
    left join a_stspeg d on a.idstspeg=d.idstspeg
    left join a_jenjurusan e on a.idjenjurusan=e.idjenjurusan
    left join a_dikstru f on a.iddikstru=f.iddikstru
    left join a_esl g on a.idesljbt=g.idesl	
    left join a_agama h on a.idagama=h.idagama
            left join a_jenjab i on a.idjenjab=i.idjenjab
            left join a_jabfung j on a.idjabfung=j.idjabfung
            left join a_matkulpel k on a.idmatkulpel=k. idmatkulpel
            left join a_jabfungum l on a.idjabfungum=l.idjabfungum
    left join a_tugasgurudosen m on a.idtugasgurudosen =m.idtugasgurudosen
    left join a_jenkedudupeg o on a.idjenkedudupeg =o.idjenkedudupeg
    left join a_skpd p on left(a.idskpd,2)=p.idskpd
    $where and a.idjenkedudupeg not in('21','99') order by a.idskpd asc";
    

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

echo json_encode($row);


// Free result set
$result->free_result();
$mysqli->close();

	
?>