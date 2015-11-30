<?php

Class Project_Database extends CI_Model {

	//Add new project info to database
	public function create_project_insert($data) {

		//Query to check whether project already exists or not
		$condition = "name =" . "'" . $data['name'] . "'";
		$this->db->select('*');
		$this->db->from('projects');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		//If no duplicate project, insert, otherwise return false
		if ($query->num_rows() == 0) 
		{
			//Query to insert data in database
			$this->db->insert('projects', $data);
			if ($this->db->affected_rows() > 0) 
			{
				return true;
			}
		} 
		else 
		{
			return false;
		}
	}

	//Read data using project name
	public function project($data) {

		$condition = "name =" . "'" . $data['name'] . "'";
		$this->db->select('*');
		$this->db->from('projects');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	//Read data from database to show data in modify page
	public function read_project_information($name) {

		$condition = "name =" . "'" . $name . "'";
		$this->db->select('*');
		$this->db->from('projects');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) 
		{
			return $query->result();
		} 
		else 
		{
			return false;
		}
	}

}

?>