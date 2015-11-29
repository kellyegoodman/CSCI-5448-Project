<?php

Class Project_Database extends CI_Model {

	//Add new user registration info to database
	public function hours_insert($data) {

		//Query to check whether username already exists or not
		// $condition = "user_name =" . "'" . $data['user_name'] . "'";
		// $this->db->select('*');
		// $this->db->from('user_login');
		// $this->db->where($condition);
		// $this->db->limit(1);
		//$query = $this->db->get();
		
		$this->db->insert('project_data',$data);
		if($this->db->affected_rows() > 0) 
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
}