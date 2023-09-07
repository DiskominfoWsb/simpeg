<?php
	//script php
	
	$nomors = array('081394233029','081394233029');
	foreach ($nomors as $nomor) {
		$data = [
		'api_key' => 'GudqEZyRNtJg7WstYxYsDSDO4iE6BO', // isi api key di menu profile -> setting
		'sender' => '6281646844790', // isi no device yang telah di scan
		'number' => $nomor, // isi no pengirim
		'message' => 'Antrian Update SIMPEG 5 Data, berikut adalah nama pegawai : Ir. AGUS PRIYATNO, M.Pd.( 2023-02-13 01:04:00) ,EKO SURYANTORO, S.Sos., M.Si.( 2022-07-01 06:16:44) ,ZULFICKAR ASSAD LAZUARDI( 2023-07-14 10:07:06) ,ZAENAL MUFLICH, S.Tr.P( 2023-07-14 10:07:06) ,YULIANA KHOIRUNNISA, A.Md.T.( 2023-07-18 06:20:00) dikirim by SIMPEG BKD Wonosobo'
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
	  }
	  echo $response;
?>