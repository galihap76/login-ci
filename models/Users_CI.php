<?php 

class Users_CI extends CI_Model{
	function get_database_table(){
		return $this->db->get('users_ci');
	}
    
    function registration_users($data,$table){
		$this->db->insert($data,$table);
	}
    
    function new_password($data, $table){
        $username = $this->input->post('username', true);
        
        $this->db->where('username', $username);
        $this->db->update($data, $table);
    }
}
