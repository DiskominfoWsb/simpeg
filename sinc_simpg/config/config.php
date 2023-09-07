<?php

include "mysql_mysqli.inc.php";
include_once  "Mobile_Detect.php";
class koneksiDB {
	function StartConnectServer($hostDB,$userDB,$passDB) {
			$a = @mysql_connect($hostDB,$userDB,$passDB) or die ('Not Connected to Database ');
			return $a; 
	}	
	function startConnectDB($nameDB) {
			$a = @mysql_select_db($nameDB) or die('Not Connect To Database');
			return $a;
	}
	function closeConnectDB($nameDB){
			$a = @mysql_close($namaDB);
	}
	
	function getAllData($query) {
			$a = @mysql_query($query);
			$ay =array();
			if ($this->getNumRows($query) > 0 ) {
				while ($ax = mysql_fetch_array($a)) {
						$ay[] = $ax;
				}
			}
			@mysql_free_result($ax);
			return $ay;
	}	
	function getAllDataAssoc($query) {
			$a = @mysql_query($query);
			$ay =array();
			if ($this->getNumRows($query) > 0 ) {
				while ($ax = mysql_fetch_assoc($a)) {
						$ay[] = $ax;
				}
			}
			@mysql_free_result($ax);
			return $ay;
	}	
	function getNumRows($query){
			$a = @mysql_query($query);
			$a = @mysql_num_rows($a);
			return $a;
	}
	function getData($query) {
			$a = @mysql_query($query);
			$a = @mysql_fetch_array($a);
			return $a;
	}
	function getDataAssoc($query) {
			$a = @mysql_query($query);
			$a = @mysql_fetch_assoc($a);
			return $a;
	}
	
	function getInsert($query) {
			$a = @mysql_query($query);
			return $a; 	
	}
	function getUpdate($query) {
			$a = @mysql_query($query);
			return $a;
	}
	function getDelete($query) {
			$a = @mysql_query($query);
			return $a;
	}
	function getQuery($a) {
			$a = @mysql_query($a);
			if  ($a) return true; else return false;
	}
}

?>