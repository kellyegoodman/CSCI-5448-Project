<?php

Class Project_Database extends CI_Model {

	//Add new user registration info to database
	public function hours_insert($data) {
		
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
