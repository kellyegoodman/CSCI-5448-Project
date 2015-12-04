<?php
class Model_user_account extends CI_Model {

	function __construct()	{
		parent::__construct();
		$this->load->database();
	}
	
	function add_user() {
		$data = array(
			'username'=>$this->input->post('username'),
			'password'=>md5($this->input->post('password')),
			'email'=>$this->input->post('email'),
			'name'=>$this->input->post('name'),
		);
		return $this->db->insert('user_account',$data);
	}


	function login_user($username, $password) {
   		$this -> db -> select('id, username, password');
   		$this -> db -> from('user_account');
   		$this -> db -> where('username', $username);
   		$this -> db -> where('password', MD5($password));
   		$this -> db -> limit(1);
 
   		$query = $this -> db -> get();
 
   		if($query -> num_rows() == 1) {
     		return $query->result();
   		} else {
     		return false;
   		}
 	}
 	
 	function get_user_info($id) {
 		$this -> db -> select('username, name, email');
 		$this -> db -> from('user_account');
 		$this -> db -> where('id', $id);
 		$this -> db -> limit(1);
 		
 		$query = $this -> db -> get();
 		
 		if($query -> num_rows() == 1) {
 			return $query->result();
 		} 
 		return FALSE;
 	}
	
	function getNames() {
		$query = $this->db->query('SELECT name FROM user_account');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return NULL;
		}
	}
	
	function get_usernames() {
		$query = $this->db->query('SELECT username FROM user_account');
	
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return NULL;
		}
	}
	
	
	



}