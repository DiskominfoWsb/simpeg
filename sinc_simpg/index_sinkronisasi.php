<?php
	include "config/config.php";
	include "config/function.php";
	include "config/koneksi.php";
	
	$reset_ulang = 'T'; // Y = Ya, T = Tidak
	$whatsapp = true; 
	
	$sinc = isset($_GET['sinc']) ? trim($_GET['sinc']) : '';
	
	if ($sinc!='sinkron') {
		echo json_encode(array('messages'=>false));
		exit();
	}		
	
	if ($reset_ulang=='Y') {
		$sql = "truncate tr_sinkronisasi";
		$koneksi->getUpdate($sql);
	}
	
	$sql = "select 	
			nip, nama, gdp, gdb, idskpd, idgolrupns, idesljbt, idjenjab, idjabfung, idjabfungum, created_at, updated_at, kelas_jabatan,idjenkedudupeg
			from tb_01 as a 
			where a.idjenkedudupeg not in('21','99') order by a.idskpd asc
			";
	$datas = $koneksi->getAllDataAssoc($sql);
	
	foreach ($datas as $data) {
		$sql = "insert into tr_sinkronisasi(nip, nama, gdp, gdb, idskpd, idgolrupns, idesljbt, idjenjab, idjabfung, idjabfungum, kelas_jabatan, idjenkedudupeg, created_at, updated_at,created_sinc)
				values ('".getCharttoMysqlReplace($data['nip'])."',
						'".getCharttoMysqlReplace($data['nama'])."',
						'".getCharttoMysqlReplace($data['gdp'])."',
						'".getCharttoMysqlReplace($data['gdb'])."', 
						'".getCharttoMysqlReplace($data['idskpd'])."',
						'".getCharttoMysqlReplace($data['idgolrupns'])."', 
						'".getCharttoMysqlReplace($data['idesljbt'])."', 
						'".getCharttoMysqlReplace($data['idjenjab'])."', 
						'".getCharttoMysqlReplace($data['idjabfung'])."', 
						'".getCharttoMysqlReplace($data['idjabfungum'])."',
						'".getCharttoMysqlReplace($data['kelas_jabatan'])."',
						'".getCharttoMysqlReplace($data['idjenkedudupeg'])."',
						'".getCharttoMysqlReplace($data['created_at'])."',
						'".getCharttoMysqlReplace($data['updated_at'])."', 
						now()) 
				";
		// echo $sql."<hr />";
		if ($reset_ulang=='Y') { 
			if(!$koneksi->getInsert($sql)) {
				echo $sql."<hr />";
			}
		}
	}
	
	// check apakah tb_01 dan tr_sinkronisasi kolom Created_at dan Updated_at
	$sql = "select group_concat(a.nip) as nip  from tb_01 as a 
			left join tr_sinkronisasi as b on a.nip = b.nip 
			WHERE a.updated_at <> b.updated_at or a.created_at <> b.created_at
			";
	
	$data = $koneksi->getDataAssoc($sql);
	// jika terdapat data yang update maka lakukan proses query  ke table tb_01 dan tr_sinkronisasi
	if ($data['nip'] <> ""){
		$where = "a.nip in($data[nip])  and ";
		$sql  = "SELECT 
					a.idgolrupns, 
					a.idesljbt,
					a.idjenjab, 
					a.idjabfung, 
					a.idjabfungum, 
					a.kelas_jabatan, 
					a.idjenkedudupeg,
					a.created_at, 
					a.updated_at,
					a.gdp, 
					a.gdb,
					a.nama as nama_saja, 
					a.idskpd, p.skpd as skpd, c.skpd as unit_kerja, a.nip, concat(if(a.gdp='', '',concat(a.gdp,' ')),a.nama,if(a.gdb='', '',concat(', ',a.gdb)))as nama, a.tmlhr as tempat_lahir, date_format(a.tglhr,'%d-%m-%Y') as tanggal_lahir, if(a.idjenkel='1', 'LAKI-LAKI', 'PEREMPUAN') as jenis_kelamin, h.agama , if(a.idstspeg='1', 'CPNS',IF(a.idstspeg='2', 'PNS','PPPK'))as status_pegawai, if(a.idstskawin='1', 'BELUM KAWIN' ,IF(a.idstskawin='2', 'KAWIN',IF(a.idstskawin='3', 'JANDA' ,IF(a.idstskawin='4', 'DUDA', '-')))) as status_kawin, o.jenkedudupeg as kedudukan_asn, a.alm, a.almrt as RT, a.almrw as RW, a.almdesa as desa, a.almkec as kecamatan, a.almkab as kabupaten, a.almprov as provinsi, a.hp, a.nokarpeg as no_karpeg,a.noaskes as no_askes,a.notaspen as no_taspen,a.nokaris as no_karis, a.nonpwp, a.email, a.email_dinas,
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
					where $where  a.idjenkedudupeg not in('21','99') order by a.idskpd asc";
			$datas = $koneksi->getAllDataAssoc($sql);
			$wa_nama  = array();
			foreach ($datas as $data) {
				$wa_nama[] = $data['nama_saja'].' ( '.$data['updated_at'].' )';
				$sql = "insert into tr_sinkronisasi_detail(nip,nama, idskpd,idgolrupns, idesljbt, idjenjab, idjabfung, idjabfungum, kelas_jabatan, idjenkedudupeg, skpd, unit_kerja, jabatan, jenis_kelamin, status_pegawai, kedudukan_asn, gaji, createdate, createdate_app_1,createdate_app_2, createdate_app_3)
				values ( 
						'".getCharttoMysqlReplace($data['nip'])."',
						'".getCharttoMysqlReplace($data['nama'])."',
						'".getCharttoMysqlReplace($data['idskpd'])."',
						'".getCharttoMysqlReplace($data['idgolrupns'])."',
						'".getCharttoMysqlReplace($data['idesljbt'])."',
						'".getCharttoMysqlReplace($data['idjenjab'])."',
						'".getCharttoMysqlReplace($data['idjabfung'])."',
						'".getCharttoMysqlReplace($data['idjabfungum'])."',
						'".getCharttoMysqlReplace($data['kelas_jabatan'])."',
						'".getCharttoMysqlReplace($data['idjenkedudupeg'])."',
						'".getCharttoMysqlReplace($data['skpd'])."',
						'".getCharttoMysqlReplace($data['unit_kerja'])."',
						'".getCharttoMysqlReplace($data['jabatan'])."',
						'".getCharttoMysqlReplace($data['jenis_kelamin'])."',
						'".getCharttoMysqlReplace($data['status_pegawai'])."',
						'".getCharttoMysqlReplace($data['kedudukan_asn'])."',
						'".getCharttoMysqlReplace($data['gaji'])."',
						now(),
						'',
						'',
						''
				)";
				if($koneksi->getInsert($sql)) {
					// jika berhasil dimasukan ke table tr_sinkronisasi_detail maka update table tr_sinkronisasi
						$sql = "replace into tr_sinkronisasi(nip, nama, gdp, gdb, idskpd, idgolrupns, idesljbt, idjenjab, idjabfung, idjabfungum, kelas_jabatan, idjenkedudupeg, created_at, updated_at,created_sinc)
					values ('".getCharttoMysqlReplace($data['nip'])."',
							'".getCharttoMysqlReplace($data['nama_saja'])."',
							'".getCharttoMysqlReplace($data['gdp'])."',
							'".getCharttoMysqlReplace($data['gdb'])."', 
							'".getCharttoMysqlReplace($data['idskpd'])."',
							'".getCharttoMysqlReplace($data['idgolrupns'])."', 
							'".getCharttoMysqlReplace($data['idesljbt'])."', 
							'".getCharttoMysqlReplace($data['idjenjab'])."', 
							'".getCharttoMysqlReplace($data['idjabfung'])."', 
							'".getCharttoMysqlReplace($data['idjabfungum'])."',
							'".getCharttoMysqlReplace($data['kelas_jabatan'])."',
							'".getCharttoMysqlReplace($data['idjenkedudupeg'])."',
							'".getCharttoMysqlReplace($data['created_at'])."',
							'".getCharttoMysqlReplace($data['updated_at'])."', 
							now()) 
					";
					$koneksi->getInsert($sql);
				}
			}
			// jika whatssapp diaktifkan 
			if ($whatsapp) {
				//script php kirim wa 
				if (count($wa_nama) > 0) { 
				$nm_update = join(", ",$wa_nama);
				$message = 'Antrian Update SIMPEG '.count($datas).' Data, berikut adalah nama pegawai : '.$nm_update.' dikirim by SIMPEG BKD Wonosobo';
				$nomors = array('081394233029','085228679944','081328237656');
				echo $message; 
				foreach ($nomors as $nomor) {
					$data = [
							'api_key' => 'GudqEZyRNtJg7WstYxYsDSDO4iE6BO', // isi api key di menu profile -> setting
							'sender' => '6281646844790', // isi no device yang telah di scan
							'number' => $nomor, // isi no pengirim
							'message' => $message
						  ];
						$curl = curl_init();										
						  curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://wa.srv4.wapanels.com/send-message',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS => json_encode($data),
						  CURLOPT_HTTPHEADER => array(
						  'Content-Type: application/json'
						  ),
					  ));		
					  $response = curl_exec($curl);						
					  curl_close($curl);
					  sleep(5);
				  }
				}
			}				
	}
	
	
	// proses input ke log history akses tr_sinkronisasi_log
	$ipaddres = getIpAddress();
	$sql = "insert into tr_sinkronisasi_log(ip_server_akses, createdate) 
			values ('$ipaddres',now()) 
			";
	$koneksi->getInsert($sql);
	echo json_encode(array('messages'=>true));
?>