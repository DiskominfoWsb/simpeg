<?php if(! defined('BASEPATH')) exit('No direct script acess allowed.');
	class Ajax extends MX_Controller {
		function __construct(){
			parent::__construct();
            $this->load->model('diengplateu/user');
            $this->load->model('diengplateu/siemodel');
            $this->user->ceklogin();
		}

        function xkdunit(){
            $idskpd = $this->input->post('idskpd');

            $rs = $this->db->get_where('skpd', array('idskpd'=>$idskpd))->row();

            echo "<select id='idskpd' name='idskpd' class='form-controls' style='width:230px'>
                <option value='$rs->idskpd'>".$rs->skpd."</option>";

            $this->siemodel->get_all($idskpd,0, $records);
            $n = 0;
            foreach($records['data'] as $key=>$item){
                $n++;
                $rp = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$records['level'][$key]);
                echo "<option value=".$item->idskpd.">".$rp."".$item->skpd."</option>";
            }

            echo "</select>";
        }
	}
	
/* @RendyAmdani */
/* End of file auth.php */
/* Location : ../modules/balaiprovinsi/controllers/auth.php */
