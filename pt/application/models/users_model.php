<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        //check if the project owned by the user I added it
        // to prevent injecting any info via the browser
        //not included in the class diagram
        public function projectOwned($project_id,$user_id)
        {
                $query = $this->db->query('SELECT * FROM `user_project` WHERE `user_account_id` = '.$user_id.' AND `project_id` = '.$project_id);

                return ($query->num_rows()>0);
        }

        //represented under get() in user model
        public function get_linkedUsers($project_id) {
            
            $query =$this->db->query('SELECT * FROM `user_account` WHERE `id` '
                    . 'IN '
                    . '(SELECT `user_account_id` FROM `user_project` WHERE `project_id`='.$project_id.')');
            return $query;
        }
		
	//represented under get() in user model
        public function get_unlinkedUsers($project_id) {
            
            $query =$this->db->query('SELECT * FROM `user_account` WHERE `id` '
                    . 'NOT IN '
                    . '(SELECT `user_account_id` FROM `user_project` WHERE `project_id`='.$project_id.')');
            return $query;
        }
        
	//represented under write/save() in user model
        public function linkUser($project_id,$user_id) {
            
            $query =$this->db->query('INSERT INTO `user_project` (`user_account_id`, `project_id`, `hours`) '
                    . 'VALUES ('.$user_id.', '.$project_id.', 0)');
            return $query;
        }
		
	//represented under write/save() in user model
        public function unlinkUser($project_id,$user_id) {
            
            $query =$this->db->query('DELETE FROM `user_project` WHERE `user_account_id`='.$user_id.' AND `project_id`='.$project_id);
            return $query;
        }

        //for warning message not in class diagram
        public function getUser($id)
        {
                $query=$this->db->query("SELECT * FROM `user_account` WHERE `id` = ".$id);
                if ($query->num_rows() == 1) 
		{
			return $query;
		} 
		else 
		{
			return FALSE;
		}
        }
		
        public function getUserName($id)
        {
                $query=$this->getUser($id);
                if ($query->num_rows() > 0) {
                        foreach ($query->result() as $row) 
                        {
                                return $row->name;
                        }
                }
        }
        
        public function getProjectName($id)
        {
                $query=$this->db->query("SELECT `name` FROM `project` WHERE `id` = ".$id);;
                if ($query->num_rows() > 0) {
                        foreach ($query->result() as $row) 
                        {
                                return $row->name;
                        }
                }
        }
		
	public function updateProfile($id,$data)
        {
            $this->db->where('id',$id);
            $this->db->update('user_account',$data);
                    if ($this->db->affected_rows() > 0) {return TRUE;}
                    else {return FALSE;}
        }

}