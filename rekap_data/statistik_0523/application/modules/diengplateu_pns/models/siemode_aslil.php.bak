<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');
    class Siemodel extends CI_Model {
        function __construct(){
            parent::__construct();
        }

        function getPegawai(){
			$rs = $this->db->query("select count(*) as jml from tb_0523 where idjenkedudupeg not in (99,21)")->row();
			return $rs->jml;
		}
		
		function getPns(){
			$rs = $this->db->query("select count(*) as jml from tb_0523 where idjenkedudupeg not in (99,21) and idstspeg = 2")->row();
			return $rs->jml;
		}
		
		function getCpns(){
			$rs = $this->db->query("select count(*) as jml from tb_0523 where idjenkedudupeg not in (99,21) and idstspeg = 1")->row();
			return $rs->jml;
		}
		
		function getPppk(){
			$rs = $this->db->query("select count(*) as jml from tb_0523 where idjenkedudupeg not in (99,21) and idstspeg = 3")->row();
			return $rs->jml;
		}
		
		function getPensiun(){
		    $y=date('Y');
			$m=date('m');
			$d='01';
			$gab=$y."-".$m."-".$d;
			$rs = $this->db->query("select count(*) as jml from tb_0523 where idjenkedudupeg in (99,21) AND tmtpens like '%$gab%'")->row();
			return $rs->jml;
		}

        function getGrafikpegawai(){
            $rs = $this->db->query("SELECT b.golru, b.pangkat
                ,SUM(IF(a.idstspeg='2' AND a.idjenkedudupeg NOT IN('21','99'),1,0)) AS 'pns'
                ,SUM(IF(a.idstspeg='1' AND a.idjenkedudupeg NOT IN('21','99'),1,0)) AS 'cpns'
                ,SUM(IF(a.idjenkedudupeg IN('21','99'),1,0)) AS 'pensiun'
                FROM tb_0523 a INNER JOIN a_golruang b ON a.idgolrupkt=b.idgolru
                GROUP BY a.idgolrupkt");
            return $rs;
        }

        function fnip($nip, $batas = " ") {
            $nip = trim($nip," ");
            $panjang = strlen($nip);

            if($panjang == 18) {
                $sub[] = substr($nip, 0, 8); // tanggal lahir
                $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
                $sub[] = substr($nip, 14, 1); // jenis kelamin
                $sub[] = substr($nip, 15, 3); // nomor urut

                return $sub[0].$batas.$sub[1].$batas.$sub[2].$batas.$sub[3];
            } elseif($panjang == 15) {
                $sub[] = substr($nip, 0, 8); // tanggal lahir
                $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
                $sub[] = substr($nip, 14, 1); // jenis kelamin

                return $sub[0].$batas.$sub[1].$batas.$sub[2];
            } elseif($panjang == 9) {
                $sub = str_split($nip,3);

                return $sub[0].$batas.$sub[1].$batas.$sub[2];
            } else {
                return $nip;
            }
        }

        function listKategori($id="idkategori",$sel="",$required=""){
            $ret = "<select id=\"$id\" name=\"$id\" class=\"form-controls\" $required style=\"width:200px\">";
            $ret.="<option value=''>.: Pilihan Kategori :.</option>";
            $ret.="<option value='statjenkel' ".(($sel=='statjenkel')?'selected':'').">Jenis Kelamin</option>";
            $ret.="<option value='statagama' ".(($sel=='statagama')?'selected':'').">Agama</option>";
            $ret.="<option value='statgol' ".(($sel=='statgol')?'selected':'').">Golongan</option>";
            $ret.="<option value='statpendid' ".(($sel=='statpendid')?'selected':'').">Pendidikan</option>";
            $ret.="<option value='statjenjab' ".(($sel=='statjenjab')?'selected':'').">Jenis Jabatan</option>";
            $ret.="<option value='stateselon' ".(($sel=='stateselon')?'selected':'').">Eselon / Struktural</option>";
            $ret.="<option value='statdikstru' ".(($sel=='statdikstru')?'selected':'').">Diklat Struktural</option>";
            $ret.="<option value='statfungsional' ".(($sel=='statfungsional')?'selected':'').">Fungsional</option>";
            $ret.="<option value='statdikfung' ".(($sel=='statdikfung')?'selected':'').">Diklat Fungsional</option>";
            $ret.="<option value='statdikfungjenjab' ".(($sel=='statdikfungjenjab')?'selected':'').">Fungsional Umum Per Jenis Jabatan</option>";
            $ret.="<option value='statfungsekdes' ".(($sel=='statfungsekdes')?'selected':'').">Fungsional Umum Sekdes Perkecamatan</option>";
            $ret.="<option value='statskpd' ".(($sel=='statskpd')?'selected':'').">SKPD</option>";
            $ret.="<option value='statguru' ".(($sel=='statguru')?'selected':'').">Guru Non Guru</option>";
            $ret.="<option value='statmarital' ".(($sel=='statmarital')?'selected':'').">Status Pernikahan</option>";
            $ret.="<option value='statkartu' ".(($sel=='statkartu')?'selected':'').">Kepemilikan Kartu</option>";
			$ret.="<option value='statumum' ".(($sel=='statumum')?'selected':'').">Data Umum</option>";
            $ret.="</select>";
            return $ret;
        }

        function listSkpd($id="idskpd",$sel="",$required=""){
            $ret = "<select id=\"$id\" name=\"$id\" class=\"form-controls\" $required style=\"width:auto\">";
            $ret.="<option value=\"\">-</option>";
            $this->db->order_by("idskpd");
            $rs = $this->db->get("skpd");
            foreach($rs->result() as $item){
                $isSel = (($item->idskpd==$sel)?"selected":"");
                $ret.="<option value=\"".$item->idskpd."\" $isSel >".$item->skpd."</option>";
            }
            $ret.="</select>";
            return $ret;
        }

        function listSkpd2($id="idskpd",$sel="",$required=""){
            $ret = "<select id=\"$id\" name=\"$id\" class=\"form-controls\" $required style=\"width:230px\">";
            $ret.="<option value=\"all\">.: Pilihan SKPD :.</option>";
            $rs = $this->db->query("select * from skpd where length(idskpd)=2");
            foreach($rs->result() as $item){
                $isSel = (($item->idskpd==$sel)?"selected":"");
                $ret.="<option value=\"".$item->idskpd."\" $isSel >".$item->skpd."</option>";
            }
            $ret.="</select>";
            return $ret;
        }

        function get_all($parent_id, $level, &$items){
            $rs = $this->db->query('select idskpd,skpd from skpd where idparent=\''.$parent_id.'\' ')->result();
            if ($rs){
                foreach($rs as $item){
                    $items['data'][] = $item;
                    $items['level'][] = $level;
                    $this->get_all($item->idskpd, $level+1, $items);
                }
            }else{
                return false;
            }
        }

        /*function get data epersonal */
        function getAttrdata($table,$id,$idagama,$name){
            $rs = $this->db->get_where($table, array($id=>$idagama))->row();
            return $rs->$name;
        }
    }

/* @RendyAmdani*/
/* End of file user.php */
/* Location : ../modules/diengplateu/model/siemodel */