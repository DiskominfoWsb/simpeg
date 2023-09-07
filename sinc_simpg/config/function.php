<?php
function getCharttoMysql($a) {
	$a = trim($a);
	$a = str_replace(array("'"),array("\'"),$a);
	return $a;
}
function getCharttoMysqlReplace($a) {
	$a = trim($a);
	$a = str_replace(array("'"),array("\'"),$a);
	return $a;
}
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
function login_validate() {
	$timeout = 60 * 7200; // 60 detik
	$_SESSION["expires_by"] = time() + $timeout;
}
function login_check() {
	$exp_time = $_SESSION["expires_by"];
	if (time() < $exp_time) {
		login_validate();
		return true; 
	} else {
		unset($_SESSION["expires_by"]);
		return false; 
	} 
}
function getIpAddress() {
	return (empty($_SERVER['HTTP_CLIENT_IP'])?(empty($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['REMOTE_ADDR']:$_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['HTTP_CLIENT_IP']);
}
function getKonversiTime($time) {
	$time = explode(' ',$time);
	$time = $time[1].' '.$time[0];
	return $time;
}
$array_jk = array (
					array('id'=>'LAKI-LAKI','name'=>'LAKI-LAKI'),
					array('id'=>'PEREMPUAN','name'=>'PEREMPUAN'),
			  );
function convdigit($digit) {
	if ($digit < 10) $digit = '0'.$digit; else $digit = $digit;
	return $digit;
}
function getChecking($path,$checking) {
	$path_file = $path;
	$fhx = fopen($path_file, "r");
	$array1 = array();
	$num_rows = 0;
	while(true)
	{
		$linex = fgets($fhx);
		if($linex == null) break;
		$array1[] = trim($linex);
		
	}
    $num_rows = count(array_intersect($array1, $checking));
	return $num_rows; 		
}
function getKonversiTgl($a) {
	$a = trim($a);
	$a = explode("-",$a);
	$a = $a[2].'-'.$a[1].'-'.$a[0];
	return $a;
}
function getKonversiTgl2($a) {
	$a = trim($a);
	$a = explode("-",$a);
	$a = $a[2].'-'.$a[1].'-'.$a[0];
	return $a;
}
function convertdate($dt)
     {
         // 2014-12-14
         $tgl = substr($dt,8,2);
         $tgl = $tgl+0;
         $bln = substr($dt,5,2);
         $thn = substr($dt,0,4);
		 $hari = date("l",mktime (0,0,0,$bulan,$tgl,$tahun));
		 switch ($hari) {
			case 'Sunday' : $hari = 'Minggu';break;
			case 'Monday' : $hari = 'Senin';break;
			case 'Tuesday' : $hari = 'Selasa';break;
			case 'Wednesday' : $hari = 'Rabu';break;
			case 'Thursday' : $hari = 'Kamis';break;
			case 'Friday' : $hari = "Jum' at";break;
			case 'Saturday' : $hari = 'Sabtu';break;
		 }
         switch ($bln)
         {
             case '01' : $nmbln ='Januari';break;
             case '02' : $nmbln ='Februari';break;
             case '03' : $nmbln ='Maret';break;
             case '04' : $nmbln ='April';break;
             case '05' : $nmbln ='Mei';break;
             case '06' : $nmbln ='Juni';break;
             case '07' : $nmbln ='Juli';break;
             case '08' : $nmbln ='Agustus';break;
             case '09' : $nmbln ='September';break;
             case '10' : $nmbln ='Oktober';break;
             case '11' : $nmbln ='November';break;
             case '12' : $nmbln ='Desember';break;
         }

         if (($thn <= 99) and ($thn >70))
         {$awal = '19';}
         else
         {$awal = '20';}
		
         $date = $hari.', '.$tgl.' '.$nmbln.' '.$thn;
         return $date;
     }
	 function getSettingPrevilleges($Previllege, $modul) {
		global $koneksi,$db_proses;
		switch ($modul) {
			case 'master' : {
				$field = "read_previlleges_1 as baca, add_previlleges_1 as tambah, edit_previlleges_1 as ubah, delete_previlleges_1 as hapus, search_previlleges_1 as cari, export_previlleges_1 as export, sts_previlleges_1 as status, $Previllege as previllage, '".$_SESSION['Dept']."' as dept, '".$_SESSION['UnitDept']."' as unitdept";
			} break;
			case 'system_pengguna' : {
				$field = "read_previlleges_2 as baca, add_previlleges_2 as tambah, edit_previlleges_2 as ubah, delete_previlleges_2 as hapus, search_previlleges_2 as cari, export_previlleges_2 as export, sts_previlleges_2 as status, $Previllege as previllage, '".$_SESSION['Dept']."' as dept, '".$_SESSION['UnitDept']."' as unitdept ";
			} break;
			case 'jadwal_kerja' : {
				$field = "read_previlleges_3 as baca, add_previlleges_3 as tambah, edit_previlleges_3 as ubah, delete_previlleges_3 as hapus, search_previlleges_3 as cari, export_previlleges_3 as export, sts_previlleges_3 as status, $Previllege as previllage, '".$_SESSION['Dept']."' as dept, '".$_SESSION['UnitDept']."' as unitdept ";
			} break;
			case 'report' : {
				$field = "read_previlleges_4 as baca, add_previlleges_4 as tambah, edit_previlleges_4 as ubah, delete_previlleges_4 as hapus, search_previlleges_4 as cari, export_previlleges_4 as export, sts_previlleges_4 as status, $Previllege as previllage, '".$_SESSION['Dept']."' as dept, '".$_SESSION['UnitDept']."' as unitdept ";
			} break;
			case 'system_administrator' : {
				$field = "read_previlleges_5 as baca, add_previlleges_5 as tambah, edit_previlleges_5 as ubah, delete_previlleges_5 as hapus, search_previlleges_5 as cari, export_previlleges_5 as export, sts_previlleges_5 as status, $Previllege as previllage, '".$_SESSION['Dept']."' as dept, '".$_SESSION['UnitDept']."' as unitdept ";
			} break;
			case 'semua' : {
				$field = "
							read_previlleges_1 as baca_1, 
							add_previlleges_1 as tambah_1, 
							edit_previlleges_1 as ubah_1, 
							delete_previlleges_1 as hapus_1, 
							search_previlleges_1 as cari_1, 
							export_previlleges_1 as export_1, 
							sts_previlleges_1 as status_1,
							read_previlleges_2 as baca_2, 
							add_previlleges_2 as tambah_2, 
							edit_previlleges_2 as ubah_2, 
							delete_previlleges_2 as hapus_2, 
							search_previlleges_2 as cari_2, 
							export_previlleges_2 as export_2, 
							sts_previlleges_2 as status_2,
							read_previlleges_3 as baca_3, 
							add_previlleges_3 as tambah_3, 
							edit_previlleges_3 as ubah_3, 
							delete_previlleges_3 as hapus_3, 
							search_previlleges_3 as cari_3, 
							export_previlleges_3 as export_3, 
							sts_previlleges_3 as status_3,
							read_previlleges_4 as baca_4, 
							add_previlleges_4 as tambah_4, 
							edit_previlleges_4 as ubah_4, 
							delete_previlleges_4 as hapus_4, 
							search_previlleges_4 as cari_4, 
							export_previlleges_4 as export_4, 
							sts_previlleges_4 as status_4,
							read_previlleges_5 as baca_5, 
							add_previlleges_5 as tambah_5, 
							edit_previlleges_5 as ubah_5, 
							delete_previlleges_5 as hapus_5, 
							search_previlleges_5 as cari_5, 
							export_previlleges_5 as export_5, 
							sts_previlleges_5 as status_5,
							$Previllege as previllage, 
							'".$_SESSION['Dept']."' as dept,
							'".$_SESSION['UnitDept']."' as unitdept
							";
			} break;
		}
		$sql = "select $field from ".$db_proses.".m_previlleges where id='$Previllege' limit 1";
		// echo $sql;
		$data = $koneksi->getDataAssoc($sql);
		return $data;
	 }
	 function get404($modul) {
		switch ($modul) {
			case 'master' : {
				$label = "<div class='get404'>KATEGORI USER INI TIDAK BERHAK MENGAKSES HALAMAN INI, SILAHKAN HUBUNGI ADMINISTRATOR</div>";
			} break;
			case 'system_pengguna' : {
				$label = "<div class='get404'>KATEGORI USER INI TIDAK BERHAK MENGAKSES HALAMAN INI, SILAHKAN HUBUNGI ADMINISTRATOR</div>";
			} break;
			case 'jadwal_kerja' : {
				$label = "<div class='get404'>KATEGORI USER INI TIDAK BERHAK MENGAKSES HALAMAN INI, SILAHKAN HUBUNGI ADMINISTRATOR</div>";
			} break;
			case 'laporan' : {
				$label = "<div class='get404'>KATEGORI USER INI TIDAK BERHAK MENGAKSES HALAMAN INI, SILAHKAN HUBUNGI ADMINISTRATOR</div>";
			} break;
			case 'system_administrator' : {
				$label = "<div class='get404'>KATEGORI USER INI TIDAK BERHAK MENGAKSES HALAMAN INI, SILAHKAN HUBUNGI ADMINISTRATOR</div>";
			} break;
		}
		return $label;
	 }
	 function dateDiff($time1, $time2, $precision = 6) {
		// If not numeric then convert texts to unix timestamps
		if (!is_int($time1)) {
		  $time1 = strtotime($time1);	
		}
		if (!is_int($time2)) {
		  $time2 = strtotime($time2);
		}

		// If time1 is bigger than time2
		// Then swap time1 and time2
		if ($time1 > $time2) {
		  $ttime = $time1;
		  $time1 = $time2;
		  $time2 = $ttime;
		}

		// Set up intervals and diffs arrays
		$intervals = array('year','month','day','hour','minute','second');
		$intervals_replace = array('','','','','','');
		$diffs = array();

		// Loop thru all intervals
		foreach ($intervals as $interval) {
		  // Set default diff to 0
		  $diffs[$interval] = 0;
		  // Create temp time from time1 and interval
		  $ttime = strtotime('+1 ' . $interval, $time1);
		  // Loop until temp time is smaller than time2
		  while ($time2 >= $ttime) {
	 $time1 = $ttime;
	 $diffs[$interval]++;
	 // Create new temp time from time1 and interval
	 $ttime = strtotime('+1 ' . $interval, $time1);
		  }
		}

		$count = 0;
		$times = array();
		// Loop thru all diffs
		foreach ($diffs as $interval => $value) {
		  // Break if we have needed precission
		  if ($count >= $precision) {
	 break;
		  }
		  // Add value and interval 
		  // if value is bigger than 0
		  if ($value > 0) {
	 // Add s if value is not 1
	 if ($value != 1) {
	   $interval .= '';
	 }
	 // Add value and interval to times array
	 $times[] = $value . ' ' . $interval;
	 $count++;
		  }
		}
		// Return string with times
		return str_replace($intervals,$intervals_replace,implode(', ', $times));
  }
  function getHariAktif($tanggal1, $tanggal2,$array_hari_kerja,$data_libur) {
		$array_hari = array(1=>'Senin','Selasa','Rabu','Kamis','Jumat', 'Sabtu','Minggu');
		$explode1 = explode("-",$tanggal1); 
		$explode2 = explode("-",$tanggal2);
		$selisih_bulan = $explode2[1] - $explode1[1];
		$bulan_awal = (int) $explode1[1];
		$bulan_akhir = (int) $explode2[1];
		$tanggal_awal = (int) $explode1[2];
		$tanggal_akhir = (int) $explode2[2];
		$tahun = (int) $explode2[0];
		$array_hari_asli = array();
		if ($selisih_bulan > 0) {
			$jml_bulan =  $selisih_bulan + 1 ;
			$count_bulan = 1;
			for ($a=$bulan_awal;$a<=$bulan_akhir;$a++) {
				$bulan = $a < 10 ? '0'.$a : $a;
				if ($count_bulan==$jml_bulan) {
					$jumlahhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
					for ($d=1;$d<=$tanggal_akhir;$d++) {
						//echo $d.' --> '.$array_hari[date("N",mktime (0,0,0,$bulan,$d,$tahun))];
						//echo "<br />";
						$array_hari_asli[] =  $array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))];
					}
				}
				else if ($count_bulan==1) {
					$jumlahhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
					for ($d=$tanggal_awal;$d<=$jumlahhari;$d++) {
						//echo $d.' --> '.$array_hari[date("N",mktime (0,0,0,$bulan,$d,$tahun))];
						//echo "<br />";
						$array_hari_asli[] =  $array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))];
					}
				} else {
					$jumlahhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
					for ($d=$tanggal_awal;$d<=$jumlahhari;$d++) {
						//echo $d.' --> '.$array_hari[date("N",mktime (0,0,0,$bulan,$d,$tahun))];
						//echo "<br />";
						$array_hari_asli[] =  $array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))];
					}
				}
				$count_bulan++;
			}
		}  
		else {
			for ($d=$tanggal_awal;$d<=$tanggal_akhir;$d++) {
				$array_hari_asli[] =  $array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))];
				//echo "<br />";
			}
		}
		$count_hari_kerja = 0;
		foreach ($array_hari_asli as $hari_asli) {
			foreach ($array_hari_kerja as $hari_kerja) {
				if ($hari_asli==$hari_kerja['hari']) {
					$count_hari_kerja++;
				}
			}
		}
		$count_hari_kerja = $count_hari_kerja - count($data_libur);
		return $count_hari_kerja;
	}
	function getHariTersedia($tanggal1, $tanggal2) {
		//format tanggal masukan adalah yyyy-mm-dd
		$array_hari = array(1=>'Senin','Selasa','Rabu','Kamis','Jumat', 'Sabtu','Minggu');
		$explode1 = explode("-",$tanggal1); 
		$explode2 = explode("-",$tanggal2);
		$selisih_bulan = $explode2[1] - $explode1[1];
		$bulan_awal = (int) $explode1[1];
		$bulan_akhir = (int) $explode2[1];
		$tanggal_awal = (int) $explode1[2];
		$tanggal_akhir = (int) $explode2[2];
		$tahun = (int) $explode2[0];
		$array_hari_asli = array();
		if ($selisih_bulan >= 0) { 
			if ($selisih_bulan > 0) {
				$jml_bulan =  $selisih_bulan + 1 ;
				$count_bulan = 1;
				for ($a=$bulan_awal;$a<=$bulan_akhir;$a++) {
					$bulan = $a < 10 ? '0'.$a : $a;
					if ($count_bulan==$jml_bulan) {
						$jumlahhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
						for ($d=1;$d<=$tanggal_akhir;$d++) {
							//echo $d.'-'.$bulan.'-'.$tahun.' --> '.$array_hari[date("N",mktime (0,0,0,$bulan,$d,$tahun))];
							//echo "<br />";
							// $array_hari_asli[] =  $array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))];
							$tgl = $d < 10 ? '0'.$d : $d;
							$date = $tahun.'-'.$bulan.'-'.$tgl;
							$array_hari_asli[] = array('DATE'=>$date,'HARI'=>$array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))]);
						}
					}
					else if ($count_bulan==1) {
						$jumlahhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
						for ($d=$tanggal_awal;$d<=$jumlahhari;$d++) {
							//echo $d.'-'.$bulan.'-'.$tahun.' --> '.$array_hari[date("N",mktime (0,0,0,$bulan,$d,$tahun))];
							//echo "<br />";
							//$array_hari_asli[] =  $array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))];
							$tgl = $d < 10 ? '0'.$d : $d;
							$date = $tahun.'-'.$bulan.'-'.$tgl;
							$array_hari_asli[] = array('DATE'=>$date,'HARI'=>$array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))]);
						}
					} else {
						$jumlahhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
						for ($d=$tanggal_awal;$d<=$jumlahhari;$d++) {
							//echo $d.'-'.$bulan.'-'.$tahun.' --> '.$array_hari[date("N",mktime (0,0,0,$bulan,$d,$tahun))];
							//echo "<br />";
							//$array_hari_asli[] =  $array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))];
							$tgl = $d < 10 ? '0'.$d : $d;
							$bulan = $bulan_awal < 10 ? '0'.$bulan_awal : $bulan_awal;
							$date = $tahun.'-'.$bulan.'-'.$tgl;
							$array_hari_asli[] = array('DATE'=>$date,'HARI'=>$array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))]);
						}
					}
					$count_bulan++;
				}
			}  
			else {
				for ($d=$tanggal_awal;$d<=$tanggal_akhir;$d++) {
					//$array_hari_asli[] =  $array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))];
					//echo $d.'-'.$bulan_awal.'-'.$tahun.' --> '.$array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))]."<br />";
					$tgl = $d < 10 ? '0'.$d : $d;
					$date = $tahun.'-'.$bulan_awal.'-'.$tgl;
					$array_hari_asli[] = array('DATE'=>$date,'HARI'=>$array_hari[date("N",mktime (0,0,0,$bulan_awal,$d,$tahun))]);
				}
			}
		}
		return $array_hari_asli;
	}
	function getRandomPassword($panjang) {
		$karakter	 = "AaBbCcDdEeFfGgHhIiJjKkLlMnNnOoPpQqRrSsTtUuVvWwXxYyZz1234567890";
		$string 	 = '';
		for ($a=0;$a < $panjang ; $a++) {
			$pos = rand(0,strlen($karakter)-1);
			$string .=$karakter[$pos];
		}
		return $string;
	}
	function getAllDepartemen() {
		global $koneksi, $db_proses; 
		$sql = "select kode as KD , nama as NM  from ".$db_proses.".com_master_departemen order by KD asc";
		$datas = $koneksi->getAllDataAssoc($sql);
		return $datas;
	}
	function getDepartemen($daftar_skpd) {
		global $koneksi, $db_proses; 
		$sql = "select kode as KD , nama as NM  from ".$db_proses.".com_master_departemen where $daftar_skpd order by KD asc";
		$datas = $koneksi->getAllDataAssoc($sql);
		return $datas;
	}
	function getAllUnitDepartemen() {
		global $koneksi, $db_proses; 
		$sql = "select SUBSTR(KOLOK,1,2) as KD , KOLOK as KOLOK, NALOK as NM  from ".$db_proses.".com_master_departemen_unit order by KOLOK asc";
		$datas = $koneksi->getAllDataAssoc($sql);
		return $datas;
	}
	function getUnitDepartemen($daftar_skpd) {
		global $koneksi, $db_proses; 
		$sql = "select SUBSTR(KOLOK,1,2) as KD , KOLOK as KOLOK, NALOK as NM  from ".$db_proses.".com_master_departemen_unit where $daftar_skpd order by KOLOK asc";
		$datas = $koneksi->getAllDataAssoc($sql);
		return $datas;
	}
	function getAllPegawai() {
		global $koneksi, $db_proses; 
		$sql = "select kd_skpd as KD , nip as comNIP, nama as comNama from ".$db_proses.".com_master_pegawai where kd_skpd <> 'ZZ'  and kd_skpd <> '00' order by nip asc";
		$datas = $koneksi->getAllDataAssoc($sql);
		return $datas;
	}
	function getPegawai($daftar_skpd) {
		global $koneksi, $db_proses; 
		$sql = "select kd_skpd as KD , nip as comNIP, nama as comNama from ".$db_proses.".com_master_pegawai where kd_skpd <> 'ZZ'  and kd_skpd <> '00'  and $daftar_skpd order by nip asc";
		$datas = $koneksi->getAllDataAssoc($sql);
		return $datas;
	}
	function getDateTime(){
		$date  = date('Y-m-d H:i:s');
		return $date;
	}
	function getHariBulan($month, $year) {
		$array_hari = array(1=>'senin','selasa','rabu','kamis','jumat', 'sabtu','minggu');
		$jumlahhari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$array_hari_asli = array();
		$field = array();
		for ($d=1;$d<=$jumlahhari;$d++) {
				$field[] = array('date'=>$d,'day'=>$array_hari[date("N",mktime (0,0,0,$month,$d,$year))]);
		}
		return $field;
	}
	function getConfig($field) {
		global $koneksi, $db_proses;
		$sql = "select comValue from ".$db_proses.".com_config where comLabel = '$field' ";
		$data = $koneksi->getData($sql);
		return $data;
	}
	function getHariLibur($month, $year) {
		global $koneksi, $db_proses;
		$sql = "select tanggal, DAY(tanggal) as tgl from ".$db_proses.".com_master_hari_libur where YEAR(tanggal)= '$year' and MONTH(tanggal) = '$month' order by tanggal asc";
		$data = $koneksi->getAllDataAssoc($sql);
		return $data;
	}
	function getIjin($month, $year) {
		global $koneksi, $db_proses;
		$sql = "select *, b.comIjin from ".$db_proses.".com_ijin as a 
				left join ".$db_proses.".com_master_perijinan as b on a.comIDIjin = b.id
				where YEAR(a.comDate)= '$year' and MONTH(a.comDate) = '$month' order by a.comDate asc";
		$data = $koneksi->getAllDataAssoc($sql);
		return $data;
	}
    function getIjinUnitSKPD($skpd, $month, $year, $where_unit) {
		global $koneksi, $db_proses;
        if ($skpd!='00') { 
            $sql = "select a.*, b.comIjin from ".$db_proses.".com_ijin as a 
				left join ".$db_proses.".com_master_perijinan as b on a.comIDIjin = b.id
                left join ".$db_proses.".com_shift_kerja as c on c.nip = a.comNIP and c.bln = '$month' and c.thn = '$year' 
				where YEAR(a.comDate)= '$year' and MONTH(a.comDate) = '$month' and c.kd_skpd = '$skpd' $where_unit order by a.comDate asc";
		}
        else {
            $sql = "select a.*, b.comIjin from ".$db_proses.".com_ijin as a 
				left join ".$db_proses.".com_master_perijinan as b on a.comIDIjin = b.id
                left join ".$db_proses.".com_shift_kerja as c on c.nip = a.comNIP and c.bln = '$month' and c.thn = '$year' 
				where YEAR(a.comDate)= '$year' and MONTH(a.comDate) = '$month' order by a.comDate asc";
        }
        $data = $koneksi->getAllDataAssoc($sql);
		return $data;
	}
    
    
    function getIjinPersonal($month, $year, $nip) {
		global $koneksi, $db_proses;
        $sql = "select a.*, b.comIjin from ".$db_proses.".com_ijin as a 
				left join ".$db_proses.".com_master_perijinan as b on a.comIDIjin = b.id
                left join ".$db_proses.".com_shift_kerja as c on c.nip = a.comNIP and c.bln = '$month' and c.thn = '$year' 
				where YEAR(a.comDate)= '$year' and MONTH(a.comDate) = '$month' and c.nip = '$nip'  order by a.comDate asc";
	
        $data = $koneksi->getAllDataAssoc($sql);
		return $data;
	}
	function getKonversi($bulan) {
		switch ($bulan) {
			case '01' : $bulan = "Januari";break;
			case '02' : $bulan = "Februari";break;
			case '03' : $bulan = "Maret";break;
			case '04' : $bulan = "April";break;
			case '05' : $bulan = "Mei";break;
			case '06' : $bulan = "Juni";break;
			case '07' : $bulan = "Juli";break;
			case '08' : $bulan = "Agustus";break;
			case '09' : $bulan = "September";break;
			case '10' : $bulan = "Oktober";break;
			case '11' : $bulan = "November";break;
			case '12' : $bulan = "Desember";break;
		}
		return $bulan;
	}
	function getStatusAbsensi($a) {
		global $koneksi, $db_proses;
		$sql = "select id, TRIM(keterangan) as keterangan from ".$db_proses.".m_status where id = '$a'";
		$data = $koneksi->getData($sql);
		if ($data['id']=='4')  return $data['keterangan'].' -> Terlambat';
		else return $data['keterangan'];
	}
	function getNow($time){
		date_default_timezone_set("Asia/Bangkok");
		$tanggal = date ("j");
		$array_bulan = array(1=>"Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember");
		$bulan = $array_bulan[date("n")];

		$tahun = date('Y');
		if ($time=='Y') 
		$now = $tanggal.' '.$bulan.' ' .$tahun.' / '.date('H:i:s').' WIB';
		else
		$now = $tanggal.' '.$bulan.' ' .$tahun;
		return $now;
	}
	function getNIP($username) {
		$nip = explode('_', $username);
		return $nip[1];
	}
	function getShiftKeterangan($shift) {
		global $koneksi, $db_proses;
		$sql = "select nama, jam_masuk, jam_keluar from ".$db_proses.".com_master_jam_kerja where id = '$shift' limit 1";
		$data = $koneksi->getData($sql);
		return $data;
	}
	function getsubSunit($kolok) {
		$level1 = substr($kolok,0,2);
		$level2 = substr($kolok,2,2);
		$level3 = substr($kolok,4,2);
		$level4 = substr($kolok,6,2);
		
		
			if ($level1<> '00' and $level2 == '00' and $level3 == '00' and $level4 == '00') {
				if  ($level1=='05') {
					$sql = "a.kolok = '$kolok' ";
					$sql_2 = "kolok = '$kolok' ";
					$sql_3 = "b.kolok = '$kolok' ";
				}
				else {
					$kolok = $level1;
					$sql = "SUBSTR(a.kolok,1,2) = '$kolok' ";
					$sql_2 = "SUBSTR(kolok,1,2) = '$kolok' ";
					$sql_3 = "SUBSTR(b.kolok,1,2) = '$kolok' ";
				}
			} 
			else if ($level1<> '00' and $level2 <> '00' and $level3 == '00' and $level4 == '00') {
				$kolok = $level1.$level2;
				$sql = "SUBSTR(a.kolok,1,4) = '$kolok' ";
				$sql_2 = "SUBSTR(kolok,1,4) = '$kolok' ";
				$sql_3 = "SUBSTR(b.kolok,1,4) = '$kolok' ";
			}
			else if ($level1<> '00' and $level2 <> '00' and $level3 <> '00' and $level4 == '00') {
				$kolok = $level1.$level2.$level3;
				$sql = "SUBSTR(a.kolok,1,6) = '$kolok' ";
				$sql_2 = "SUBSTR(kolok,1,6) = '$kolok' ";
				$sql_3 = "SUBSTR(b.kolok,1,6) = '$kolok' ";
			}
			else if ($level1<> '00' and $level2 <> '00' and $level3 <> '00' and $level4 <> '00') {
				$kolok = $level1.$level2.$level3.$level4;
				$sql = "SUBSTR(a.kolok,1,8) = '$kolok' ";
				$sql_2 = "SUBSTR(kolok,1,8) = '$kolok' ";
				$sql_3 = "SUBSTR(b.kolok,1,8) = '$kolok' ";
			}
			else if ($level3 <> '00' and $level4 <> '00') {
				$kolok = $level1.$level2.$level3.$level4;
				$kolok = $kolok;
				$sql = "SUBSTR(a.kolok,1,8) = '$kolok' ";
				$sql_2 = "SUBSTR(kolok,1,8) = '$kolok' ";
				$sql_3 = "SUBSTR(b.kolok,1,8) = '$kolok' ";
			} 
			else if ($level3 <> '00' and $level4 == '00') {
				$kolok = $level1.$level2.$level3;
				$kolok = $kolok;
				$sql = "SUBSTR(a.kolok,1,6) = '$kolok' ";
				$sql_2 = "SUBSTR(kolok,1,6) = '$kolok' ";
				$sql_3 = "SUBSTR(b.kolok,1,6) = '$kolok' ";
			} 
			
		$result['kolok'] = $kolok;
		$result['sql'] = $sql;
		$result['sql_2'] = $sql_2;
		$result['sql_3'] = $sql_3;
		return $result;
	}
	function getPenguranganTPP($startDate, $endDate) {
		global $koneksi,$db_proses;
		$sql = "select * from ".$db_proses.".tpp_setting as a 
				where ('$startDate' between comDate and comDate2) or ('$endDate' between comDate and comDate2)
				";
		$jml  = $koneksi->getNumRows($sql);
		$data = $koneksi->getData($sql);
		return $data;
	}
	function getNamaGolongan($kd_gol) {
		global $koneksi,$db_proses;
		$sql = "select nama from ".$db_proses.".com_master_golruang where kode = '$kd_gol' limit 1 ";
		$data = $koneksi->getData($sql);
		return $data;
		
	}
	function getNamaEselon($kd_esel) {
		global $koneksi,$db_proses;
		$sql = "select NAMA  as nama from ".$db_proses.".m_eselon where KODE = '$kd_esel' limit 1 ";
		$data = $koneksi->getData($sql);
		return $data;
		
	}
	function getKonversiNilaitoKategoriSKP($a) {
		if ($a >= 78) $a = 'A';
		else if ($a >= 70 and $a < 78) $a = 'B';
		else if ($a >= 60 and $a < 70) $a = 'C';
		else if ($a >= 50 and $a < 60) $a = 'D';
		else $a = 'E';
		return $a;
	}
	function getKonversiKategoriSKPtoPorsi($a) {
		if ($a == 'A') $a = 100;
		else if ($a == 'B') $a = 90;
		else if ($a == 'C') $a = 80;
		else if ($a == 'D') $a = 50;
		else $a = 20;
		return $a;
	}
	function getPenguranganDisiplin($month, $year) {
		global $koneksi,$db_proses;
		$sql = "select a.comIDDisiplin as comIDDisiplin, a.comNIP as comNIP, b.pengurangan as pengurangan from ".$db_proses.".com_disiplin as a 
				left join ".$db_proses.".com_master_disiplin as b on b.id = a.comIDDisiplin
				where (MONTH(a.comDate) = '$month' and YEAR(a.comDate) = '$year') or (MONTH(a.comDate2) = '$month' and YEAR(a.comDate2) = '$year')
				";
		$data = $koneksi->getAllDataAssoc($sql);
		return $data;
	}
	function getPenguranganKewajiban($month, $year) {
		global $koneksi,$db_proses;
		$sql = "select a.comIDKewajiban as comIDKewajiban, a.comNIP as comNIP, b.pengurangan as pengurangan from ".$db_proses.".com_kewajiban as a 
				left join ".$db_proses.".com_master_kewajiban as b on b.id = a.comIDKewajiban
				where (MONTH(a.comDate) = '$month' and YEAR(a.comDate) = '$year') or (MONTH(a.comDate2) = '$month' and YEAR(a.comDate2) = '$year')
				";
		$data = $koneksi->getAllDataAssoc($sql);
		return $data;
	}
    function getPenguranganKewajibanUnitSKPD($skpd, $month, $year, $where_unit) {
		global $koneksi,$db_proses;
        if ($skpd=='00') { 
		$sql = "select a.comIDKewajiban as comIDKewajiban, a.comNIP as comNIP, b.pengurangan as pengurangan from ".$db_proses.".com_kewajiban as a 
				left join ".$db_proses.".com_master_kewajiban as b on b.id = a.comIDKewajiban
                left join ".$db_proses.".com_master_pegawai as c on c.nip = a.comNIP 
				where ((MONTH(a.comDate) = '$month' and YEAR(a.comDate) = '$year') or (MONTH(a.comDate2) = '$month' and YEAR(a.comDate2) = '$year'))
                
				";
        } else {
            $sql = "select a.comIDKewajiban as comIDKewajiban, a.comNIP as comNIP, b.pengurangan as pengurangan from ".$db_proses.".com_kewajiban as a 
				left join ".$db_proses.".com_master_kewajiban as b on b.id = a.comIDKewajiban
                left join ".$db_proses.".com_master_pegawai as c on c.nip = a.comNIP 
				where ((MONTH(a.comDate) = '$month' and YEAR(a.comDate) = '$year') or (MONTH(a.comDate2) = '$month' and YEAR(a.comDate2) = '$year'))
                and c.kd_skpd = '$skpd' $where_unit";
        }
        $data = $koneksi->getAllDataAssoc($sql);
		return $data;
	}
    
    function getPenguranganKewajibanPersonal($month, $year, $nip) {
		global $koneksi,$db_proses;
       
        $sql = "select a.comIDKewajiban as comIDKewajiban, a.comNIP as comNIP, b.pengurangan as pengurangan from ".$db_proses.".com_kewajiban as a 
            left join ".$db_proses.".com_master_kewajiban as b on b.id = a.comIDKewajiban
            left join ".$db_proses.".com_master_pegawai as c on c.nip = a.comNIP 
            where ((MONTH(a.comDate) = '$month' and YEAR(a.comDate) = '$year') or (MONTH(a.comDate2) = '$month' and YEAR(a.comDate2) = '$year'))
            and c.nip  = '$nip' ";
       
        $data = $koneksi->getAllDataAssoc($sql);
		return $data;
	}
	function SelisihWaktu($awal, $akhir)
	{
	$seconds = 0;
	$detik =0;
	$selisih = 0;
	if(strtotime($awal)>strtotime($akhir)){
	$mulai = $akhir;
	$selesai = $awal;
	}else{
	$mulai = $awal;
	$selesai = $akhir;
	}
	list( $g, $i, $s ) = explode( ':', $mulai );
	$seconds += $g * 3600;
	$seconds += $i * 60;
	$seconds += $s;
	$newSeconds = $seconds;

	list( $g, $i, $s ) = explode( ':', $selesai );
	$detik += $g * 3600;
	$detik += $i * 60;
	$detik += $s;
	$detikbaru = $detik;

	$selisih = $detikbaru - $newSeconds;

	$jam = floor( $selisih / 3600 );
	$selisih -= $jam * 3600;
	$menit = floor( $selisih / 60 );
	$selisih -= $menit * 60;

	if($jam<10){ $jam='0'.$jam;}
	if($menit<10){ $menit='0'.$menit;}
	if($selisih<10){ $selisih='0'.$selisih;}
	return ($jam * 60) + $menit;
	}
	function getInsertTLog($username, $jns, $note, $sql_note) {
		global $koneksi,$db_proses;
		$sql_log = "insert into  ".$db_proses.".t_log (username, jns, note, sql_note,ipaddress,createdate)
					values('".$username."','".$jns."','".$note."','".base64_encode($sql_note)."','".getIpAddress()."',now())";
		$koneksi->getInsert($sql_log);
	}
	
	function getIjinSKPD2($month, $year) {
		global $koneksi, $db_proses, $db_cuti;
		$sql = "select if (a.comIDIjin='1','CT',
					   if (a.comIDIjin='2','CS',
					   if (a.comIDIjin='3','CBS',
					   if (a.comIDIjin='4','CB','CKAP')))) as comIjin
						, a.comNIP, a.comDate, a.comDate2, c.id from ".$db_proses.".com_ijin_cuti as a 
						left join ".$db_proses.".com_shift_kerja as c on c.nip = a.comNIP and c.bln = '$month' and c.thn = '$year' 
						where a.validasi = '2' and ((YEAR(a.comDate)= '$year' and MONTH(a.comDate) = '$month') or (YEAR(a.comDate2)= '$year' and MONTH(a.comDate2) = '$month')) order by a.comNIP asc, a.comDate asc"; 
	
		$data = $koneksi->getAllDataAssoc($sql);
		return $data;
	}
    function getKonversiMenit2022($jml_menit) {
        if ($jml_menit<=1750) $rowss['prosentase2022'] = 0;
        else if ($jml_menit>=1751 and $jml_menit<=2250) $rowss['prosentase2022'] = 5;
        else if ($jml_menit>=2251 and $jml_menit<=2750) $rowss['prosentase2022'] = 10;
        else if ($jml_menit>=2751 and $jml_menit<=3250) $rowss['prosentase2022'] = 20;
        else if ($jml_menit>=3251 and $jml_menit<=3750) $rowss['prosentase2022'] = 30;
        else if ($jml_menit>=3751 and $jml_menit<=4250) $rowss['prosentase2022'] = 40;
        else if ($jml_menit>=4251 and $jml_menit<=4750) $rowss['prosentase2022'] = 50;
        else if ($jml_menit>=4751 and $jml_menit<=5250) $rowss['prosentase2022'] = 60;
        else if ($jml_menit>=5251 and $jml_menit<=5750) $rowss['prosentase2022'] = 70;
        else if ($jml_menit>=5751 and $jml_menit<=6250) $rowss['prosentase2022'] = 80;
        else if ($jml_menit>=6251 and $jml_menit<=6750) $rowss['prosentase2022'] = 90;
        else $rowss['prosentase2022'] = 100;
        return $rowss['prosentase2022'];
    }
	
?>