<?php if(! defined('BASEPATH')) exit('No direct script acess allowed.');
	class Diengplateu extends MX_Controller {
		function __construct(){
			parent::__construct();
            $this->load->model('diengplateu/user');
            $this->load->model('diengplateu/siemodel');
//            $this->load->library('cetak_pdf');
			$this->user->ceklogin();
		}
		
		function index(){
            $data = $this->config->item('data');
            if($this->session->userdata('is_log_diengplateu')){
                $this->template->load($data['themes'].'index',$data['themes'].'index',$data);
            }else{
                redirect('diengplateu/');
            }
		}        		
		
        function data(){            
            $page = $this->uri->segment(3);
			$this->load->view('diengplateu/statistik/'.$page.'_data');
        }

        function page(){                        
            $page = $this->uri->segment(3);
            $this->load->view('diengplateu/statistik/'.$page);
        }

        function graphCPNS(){
            $this->load->dbutil();
            $rs = $this->db->query("SELECT b.golru
                ,SUM(IF(a.idstspeg='1',1,0)) AS 'cpns'
                FROM tb_0423 a
                INNER JOIN a_golruang b ON a.idgolrupkt=b.idgolru
                where a.idjenkedudupeg not in('21','99')
                GROUP BY a.idgolrupkt");

            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->golru.",".$item->cpns."\r\n";
            }
        }

        function graphPNS(){
            $this->load->dbutil();
            $rs = $this->db->query("SELECT b.golru
                ,SUM(IF(a.idstspeg='2',1,0)) AS 'pns'
                FROM tb_0423 a
                INNER JOIN a_golruang b ON a.idgolrupkt=b.idgolru
                where a.idjenkedudupeg not in('21','99')
                GROUP BY a.idgolrupkt");

            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){

                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->golru.",".$item->pns."\r\n";
            }
        }

        function graphPensiun(){
            $this->load->dbutil();
            $rs = $this->db->query("SELECT b.golru, COUNT(*) AS 'pensiun'
                FROM tb_0423 a
                INNER JOIN a_golruang b ON a.idgolrupkt=b.idgolru
                WHERE a.idjenkedudupeg IN('21','99')
                GROUP BY a.idgolrupkt");

            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){

                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->golru.",".$item->pensiun."\r\n";
            }
        }

        /*function graph kelamin*/
        function graphKelamin(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("
                SELECT IF(idjenkel=1,'Pria',IF(idjenkel=2,'Wanita','-')) AS kategori, COUNT(*) AS pns FROM tb_0423
                WHERE idjenkedudupeg NOT IN (99,21) $where GROUP BY idjenkel
            ");

            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->pns."\r\n";
            }
        }

        /*function graph agama*/
        function graphAgama(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.agama as kategori, SUM(IF(b.idagama!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idagama!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_agama a
              LEFT JOIN tb_0423 b ON a.idagama = b.idagama AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idagama");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"AGAMA":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "AGAMA,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        /*function graph golongan*/
        function graphGolongan(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.golru as kategori, SUM(IF(b.idgolrupkt!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idgolrupkt!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_golruang a
              LEFT JOIN tb_0423 b ON a.idgolru = b.idgolrupkt AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idgolru");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"GOLONGAN":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "GOLONGAN,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        /*function graph tingkat pendidikan*/
        function graphTkpendid(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.tkpendid as kategori, SUM(IF(b.idtkpendid!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idtkpendid!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_tkpendid a
              LEFT JOIN tb_0423 b ON a.idtkpendid = b.idtkpendid AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idtkpendid");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"PENDIDIKAN":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "PENDIDIKAN,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        /*function graph jenis jabatan*/
        function graphJenjab(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.jenjab as kategori, SUM(IF(b.idjenjab!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idjenjab!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_jenjab a
              LEFT JOIN tb_0423 b ON a.idjenjab = b.idjenjab AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idjenjab");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"JENIS JABATAN":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "JENIS JABATAN,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        /*function graph eselon*/
        function graphEselon(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.esl as kategori, SUM(IF(b.idesljbt!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idesljbt!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_esl a
                  LEFT JOIN tb_0423 b ON a.idesl = b.idesljbt AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idesl");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"ESELON":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "ESELON,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        /*function graph dikstru*/
        function graphDikstru(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.dikstru as kategori, SUM(IF(b.iddikstru!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.iddikstru!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_dikstru a
              inner JOIN tb_0423 b ON a.iddikstru = b.iddikstru AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.iddikstru");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"DIKLAT STRUKTURAL":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "DIKLAT STRUKTURAL,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        /*functin graph jabfung*/
        function graphJabfung(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.jabfung as kategori, SUM(IF(b.idjabfung!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idjabfung!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_jabfung a
              LEFT JOIN tb_0423 b ON a.idjabfung = b.idjabfung AND b.idjenkedudupeg NOT IN (99,21) and b.idjenjab = '2' $where GROUP BY a.jabfung ORDER BY a.jabfung");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"JABATAN FUNGSIONAL":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "JABATAN FUNGSIONAL,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        /*functin graph jabfungum*/
        function graphJabfungum(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND b.idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.jabfungum as kategori, SUM(IF(b.idjabfungum!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idjabfungum!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_jabfungum a
              LEFT JOIN tb_0423 b ON a.idjabfungum = b.idjabfungum AND b.idjenkedudupeg NOT IN (99,21) and b.idjenjab = '3' $where GROUP BY a.jabfungum ORDER BY a.jabfungum");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"JABATAN FUNGSIONAL UMUM":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "JABATAN FUNGSIONAL UM,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        /*function graph skpd*/
        function graphSkpd(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND a.idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT replace(b.skpd,',',' ') as kategori, SUM(IF(a.idskpd!='' AND a.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(a.idskpd!='' AND a.idjenkel = 2,1,0)) AS jmlwanita FROM tb_0423 a
                INNER JOIN skpd b ON LEFT(a.idskpd,2) = b.idskpd WHERE a.idjenkedudupeg NOT IN (99,21) $where GROUP BY LEFT(a.idskpd,2)");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"SKPD":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "SKPD,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        /*function graph guru*/
        function graphGuru(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND b.idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.idjenkel, SUM(IF(MID(b.idjabfung, 5, 1)=4,1,0)) AS guru, SUM(IF(MID(b.idjabfung, 5, 1)!=4,1,0)) AS nonguru  FROM a_jenkel a
              LEFT JOIN tb_0423 b ON a.idjenkel = b.idjenkel WHERE b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idjenkel ORDER BY a.idjenkel");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"STATUS GURU":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "STATUS GURU,Guru,Non Guru";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
                echo $jnskl.",".$item->guru.",".$item->nonguru."\r\n";
            }
        }

        /*function statistik martial*/
        function graphMarital(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND b.idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.stskawin AS kategori, SUM(IF(b.idstskawin!='' AND b.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(b.idstskawin!='' AND b.idjenkel = 2,1,0)) AS jmlwanita FROM a_stskawin a
              LEFT JOIN tb_0423 b ON a.idstskawin = b.idstskawin AND b.idjenkedudupeg NOT IN (99,21) $where GROUP BY a.idstskawin");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"SKPD":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "SKPD,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }

        function graphKartu(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND b.idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.idjenkel, SUM(IF(b.nokarpeg!='',1,0)) AS nokarpeg, SUM(IF(b.nokarpeg='',1,0)) AS nonnokarpeg,
              SUM(IF(b.nokaris!='',1,0)) AS nokaris, SUM(IF(b.nokaris='',1,0)) AS nonnokaris
              FROM a_jenkel a LEFT JOIN tb_0423 b ON a.idjenkel = b.idjenkel $where GROUP BY a.idjenkel ORDER BY a.idjenkel");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"KEPEMILIKAN KARTU":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "KEPEMILIKAN KARTU,Karpeg, Non Karpeg, Karis/Karsu, Non Karis/Karsu";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                $jnskl = ($item->idjenkel=='1')?'Laki-laki':'Perempuan';
                echo $jnskl.",".$item->nokarpeg.",".$item->nonnokarpeg.",".$item->nokaris.",".$item->nonnokaris."\r\n";
            }
        }

        /*function graph Sekdes*/
        function graphSekdes(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("
                SELECT IF(a.idjenkel=1,'Pria',IF(a.idjenkel=2,'Wanita','-')) AS kategori, COUNT(*) AS pns FROM tb_0423 a
                LEFT JOIN a_jabfungum b ON a.idjabfungum = b.idjabfungum
                WHERE a.idjenkedudupeg NOT IN (99,21) $where AND (a.niplama LIKE '%sekdes%' OR b.jabfungum = 'sekdes') GROUP BY a.idjenkel;
            ");

            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->pns."\r\n";
            }
        }

        /*function graph dikfung*/
        function graphDikfung(){
            $this->load->dbutil();
            $idskpd = $this->input->post('idskpd');
            if($idskpd != "") $where = ($idskpd == "")?"":"AND idskpd LIKE '$idskpd%'";
            $rs = $this->db->query("SELECT a.dikfung AS kategori, SUM(IF(c.idjenkel = 1,1,0)) AS jmlpria, SUM(IF(c.idjenkel = 2,1,0)) AS jmlwanita FROM a_dikfung a
                    INNER JOIN r_dikfung b ON a.iddikfung = b.iddikfung
                    INNER JOIN tb_0423 c ON b.nip = c.nip WHERE c.idjenkedudupeg NOT IN (99,21) $where GROUP BY c.idjenkel");
            $delimiter = ",";
            $newline = "\n";
            $categories = "";
            foreach ($rs->list_fields() as $field){
                $field = (($field=='jenkel')?"DIKLAT FUNGSIONAL":$field);
                $categories.=$field.",";
            }
            $categories = substr($categories,0,-1);
            $categories = "DIKLAT FUNGSIONAL,Pria,Wanita";
            echo $categories."\r\n";
            foreach($rs->result() as $item){
                echo $item->kategori.",".$item->jmlpria.",".$item->jmlwanita."\r\n";
            }
        }
	}
	
/* @RendyAmdani */
/* End of file diengplateu.php */
/* Location : ../modules/diengplateu/controllers/diengplateu.php */
