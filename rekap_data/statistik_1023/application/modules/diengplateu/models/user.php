<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');
    class User extends CI_Model {
        function __construct(){
            parent::__construct();
            session_start();
        }

        function getUser($username){
            $rs = $this->db->get_where('userlogin', array('username'=>$username, 'role !=' => '0'));
            return $rs;
        }

        function login(){
            $username = $this->input->post('username');
            $userpass = $this->input->post('userpass');
            $rs = $this->getUser($username);

            if($rs->num_rows() > 0){
                $user = $rs->row();

                if(($username == $user->username) && ($userpass == $user->userpass)){
                    $sessi = array(
                        'username' => $user->username,
                        'iduser' => $user->iduser,
                        'role' => $user->role,
                        'name' => $user->name,
                        'tmstamp'=> gmdate("Y-m-d H:i", time()+60*60*7),
                        'is_log_diengplateu'=>true,
                    );

                    $this->session->set_userdata($sessi);

                    /* session untuk kcfinder */
                    $_SESSION['ses_kcfinder'] = array();
                    $_SESSION['ses_kcfinder']['disabled'] = false;
                    $_SESSION['ses_kcfinder']['uploadURL'] = base_url()."content/image";

                    $data['ip'] = $_SERVER['REMOTE_ADDR'];
                    $data['tmstamp'] = $this->session->userdata('tmstamp');
                    $data['useragent']	= $this->session->userdata('user_agent');
                    $dt['iduser']		= $this->session->userdata('iduser');
                    $this->db->update("userlogin",$data,$dt);

                    $data['username']	= $this->session->userdata('username');
                    $data['ket']		= 'login';
                    $this->db->insert("log_user",$data);
                    $this->session->unset_userdata('login_attempt');
                    return true;
                } else {
                    $this->session->set_userdata('login_attempt', $this->session->userdata('login_attempt') + 1);
                    return false;
                }
            } else {
                $this->session->set_userdata('login_attempt', $this->session->userdata('login_attempt') + 1);
                return false;
            }
        }

        function logout(){
            $data['ip']			= $_SERVER['REMOTE_ADDR'];
            $data['username']	= $this->session->userdata('username');
            $data['useragent']	= $this->session->userdata('user_agent');
            $data['tmstamp']	= $this->session->userdata('tmstamp');
            $data['ket']		= 'logout ';
            $dt['iduser']		= $this->session->userdata('iduser');
            $this->db->insert("log_user",$data);
            $this->db->query("update userlogin set lastlogin = NOW()
	        where iduser = '".$this->session->userdata('iduser')."'");
        }

        function ceklogin(){
            if($this->session->userdata('is_log_diengplateu') != 'true'){
                redirect('diengplateu/auth');
            }
        }

        function ceksuper(){
            if($this->session->userdata('role') != 1){
                redirect('diengplateu');
            }
        }
    }

/* @RendyAmdani*/
/* End of file user.php */
/* Location : ../modules/diengplateu/model/usermodel */