<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Project_model extends CI_Model {

	const LIMIT=5;
	
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
        
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
			$this->db->insert('project', $data);
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

	function update_entry($data)
    {
    	$condition = "name =" . "'" . $data['name'] . "'";
    	$this->db->where($condition);
    	$this->db->update($data);
    }

    function getProjectDetails() {
    	$this->db->select("name,deadline,status,priority,creation_date,note");
	  	$this->db->from('project');
	  	$query = $this->db->get();
	  	return $query->result();
	}
}