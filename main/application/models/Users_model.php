<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // add a new user to the database
        function add_user() {
        	$data = array(
        			'username'=>$this->input->post('username'),
        			'password'=>md5($this->input->post('password')),
        			'email'=>$this->input->post('email'),
        			'name'=>$this->input->post('name'),
        	);
        	return $this->db->insert('user_account',$data);
        }
        
        // change user data
        function change_user($id) {
        	$data = array(
        			'email'=>$this->input->post('email'),
        			'name'=>$this->input->post('name'),
        	);
        	
        	$this->db->where('id', $id);
        	return $this->db->update('user_account', $data);
        }
        
        // change user password
        function verify_password($id, $password) {

        	$this -> db -> select('username');
        	$this -> db -> from('user_account');
        	$this -> db -> where('id', $id);
        	$this -> db -> where('password', MD5($password));
        	$this -> db -> limit(1);
        	
        	$query = $this -> db -> get();
            if($query -> num_rows() == 1) {
        		return TRUE;
        	}
        	return FALSE;
        	
        }
        
        // change user password
        function change_password($id) {
	        $data['password']=md5($this->input->post('password_new'));
	        $this->db->where('id', $id);
	        $this->db->where('password', md5($this->input->post('password')));
	        return $this->db->update('user_account', $data);
        }
        
        // return user data given username and password
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
        
        // return some user data given user_id
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
		private function getUser($id)
		{
			$query=$this->db->query("SELECT `name` FROM `user_account` WHERE `id` = ".$id);
			return $query;
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
		
		//pagination not included in the class diagram
		/**public function record_count($project_id,$user_kind) 
		{
			if($user_kind="unlinked")
				return $this->get_unlinkedUsers($project_id)->num_rows();
			else
				return $this->get_linkedUsers($project_id)->num_rows();
		}

		public function fetch_users($limit, $start,$project_id, $user_kind) {
			$this->db->limit($limit, $start);
			if($user_kind="unlinked")
				$query = $this->get_unlinkedUsers($project_id);
			elseif($user_kind="linked")
				$query = $this->get_linkedUsers($project_id);
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
				return $data;
			}
			return false;
	   }*/

}