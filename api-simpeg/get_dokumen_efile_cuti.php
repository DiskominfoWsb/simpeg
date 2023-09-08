<?php
	set_time_limit(0);
    ini_set('memory_limit', '10048M');
    
    $mysqli = new mysqli("10.0.1.9","simpeg","P3g4w41asnWSBdb2023","simpeg_v19");

    $host = 'localhost';
	$user = 'simpeg';
	$pass = 'P3g4w41asnWSBdb2023';
    
    
    
    $nosu = isset($_GET['nosu']) ? $_GET['nosu'] : '';
    $nip = isset($_GET['nip']) ? $_GET['nip'] : '';
    



    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
      exit();
    }

    
    $sql  = "select id from  simpeg_v19.r_cuti where nosurat = '$nosu' and nip = '$nip' ";
    
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    if ($row['id'] > 0) {
           $sql = "select filename as id from simpeg_efile.files where subjenis = '".$row['id']."' and jenis = 34 ";
           $result = $mysqli->query($sql);
           $row = $result->fetch_assoc();
           $link  = "https://simpeg.wonosobokab.go.id/v19/efile/packages/upload/files/".$nip_4karakter."/".$nip."/".$datas['id'];
           $return  = remote_file_exists($link);    
           if (!$return)  $link = "";
                
    } 
    else {
        $row['id'] = "";
    }        
    
    echo json_encode($row);

    // Free result set
    $result->free_result();
    $mysqli->close();
    
    function remote_file_exists($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if( $httpCode == 200 ){return true;}
        return false;
    }
	
?>