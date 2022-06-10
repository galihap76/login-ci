<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
     public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user_m/Users_CI');
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
               redirect('Home');
            }else if(!password_verify($password, $user['password'])){
             echo 'Password not valid!';
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
    
    public function forgot_password(){
        $this->form_validation->set_rules('username','Username', 'required');
		$this->form_validation->set_rules('password','Password', 'required');
        
        if($this->form_validation->run()==false){
            $this->load->view('auth_v/forgot-password');
		}else{
            
          $data = [
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
          ];
            
          $this->Users_CI->new_password('users_ci', $data);
		  redirect('auth');
        }
        
    }
}        
