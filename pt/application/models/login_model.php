<?php

Class Login_Model extends CI_Model {

	//Add new user registration info to database
	public function registration_insert($data) 
        {
		//Query to check whether username already exists or not
		$condition = "username =" . "'" . $data['username'] . "'";
		$this->db->select('*');
		$this->db->from('user_account');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		//If no duplicate username, insert, otherwise return false
		if ($query->num_rows() == 0) 
		{
			//Query to insert data in database
			$this->db->insert('user_account', $data);

			if ($this->db->affected_rows() > 0) 
			{
				return TRUE;
			}
		} 
		else 
		{
			return FALSE;
		}
	}

	//Read data using username and password
	public function login($data) 
	{
		//plz check thatnot entire table changed
		$condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";
		$this->db->select('*');
		$this->db->from('user_account');
		$this->db->where($condition);
		$query = $this->db->get();
		if ($query->num_rows() == 1) 
		{
			$this->db->set('last_login',$data['last_login']);
			$this->db->update('user_account');
			return $query->result();
		} 
		else 
		{
			return FALSE;
		}	
	}
}