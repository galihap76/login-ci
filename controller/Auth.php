<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
     public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_m/Users_CI');
    }
    
	public function index(){
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if($this->form_validation->run() == false){
        	$this->load->view('auth_v/signin');
            
        }else{
        $username = $this->input->post('username');
        $password = $this->input->post('password');
            
        $user = $this->db->get_where('users_ci', ['username' => $username])->row_array();
        if($user){
            if(password_verify($password, $user['password'])){
               $this->load->view('user/index');
            }else{
            echo 'Failed!';
        }
            
        }
        
      }
  }

    
    public function signup(){
        $this->form_validation->set_rules('username','Username', 'required');
		$this->form_validation->set_rules('password','Password', 'required');
        
        if($this->form_validation->run()==false){
            $this->load->view('auth_v/signup');
		}else{
            
           $data = [
                'username' => htmlentities($this->input->post('username', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
               ];
            
           $this->Users_CI->registration_users('users_ci', $data);
		   redirect('auth');
        }
        
    }
}
?>
