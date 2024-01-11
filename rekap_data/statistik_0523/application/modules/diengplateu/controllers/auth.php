<?php if(! defined('BASEPATH')) exit('No direct script acess allowed.');
	class Auth extends MX_Controller {
		function __construct(){
			parent::__construct();
            $this->load->model('diengplateu/user');
		}
		
		function index(){
            if($this->session->userdata('is_log_diengplateu') != 1){
                $data = $this->config->item('data');
                $this->load->view('diengplateu/login/index', $data);
            }else{
                redirect('diengplateu');
            }
		}

        function login(){
            $this->user->login();
            redirect('diengplateu');
        }


        function logout(){
            $this->user->logout();
            session_destroy();
            $this->session->sess_destroy();
            redirect('diengplateu/auth');
        }
	}
	
/* @RendyAmdani. */
/* End of file auth.php */
/* Location : ../modules/diengplateu/controllers/auth.php */
