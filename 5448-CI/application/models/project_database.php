<?php

Class Project_Database extends CI_Model {

	//Add new user registration info to database
	public function hours_insert($data) {

		//Get the foreign key
		$condition = "user_name =" . "'" . $data['user_name'] . "'";
		$this->db->select('*');
		$this->db->from('user_login');
		$this->db->where($condition);

		$query = $this->db->get();
		$result = $query->result();

		//Select project from FK
		$this->db->select('*');
	    $this->db->from('project_data');
	    $this->db->join('user_login', 'user_login.id = project_data.owner_id');
	    $this->db->where('user_login.id', $result[0]->id);

	    $query = $this->db->get();

	    $data_to_insert = array(
	    	'owner_id' => $result[0]->id,
	    	'project_hours' => $data['project_hours'],
			'project_note' => $data['project_note']
			);

	    //Insert into project
		$this->db->insert('project_data',$data_to_insert);
		$this->db->set('creation_time','NOW()',FALSE);
		if($this->db->affected_rows() > 0) 
		{
			return true;
		}
		else 
		{
			return false;
		}
	}

	public function read_project_info($project_id)
	{

	}
}