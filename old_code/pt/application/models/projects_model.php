<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects_model extends CI_Model {

		const LIMIT=5;
		
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }
		
	/**
         * load all created and participated projects 
         * using pagination infomration from the session 
         */
        public function get_projects($all= FALSE)
        {
                       $query='';
					   $order='';
					   $asc='';
					   $where='';
					   $offset='';
					   $limit='';
							//if the user chose the column order else nothing
							if(($this->native_session->userdata('project_order_by'))!==NULL)
							{
								$asc=($this->native_session->userdata('project_asc')!==NULL)?$this->native_session->userdata('project_asc'):'ASC';
								$asc=' '.$asc.' ';
								$order= ' ORDER BY '.$this->native_session->userdata('project_order_by').$asc;
							}
							//read search criteria
							if(($this->native_session->userdata('search'))!==NULL)
							{
								$where=' AND '.$this->native_session->userdata('search_column').' LIKE "%'.$this->native_session->userdata('search').'%" ';
							}else{$where='';}
							//if all no need to limit
							if($all == FALSE)
							{
								//defined start or 0
								if(($this->native_session->userdata('project_start'))==NULL){$offset=0;}
								$offset=' LIMIT '.$this->native_session->userdata('project_start');
								//defined limit or constant LIMIT=5
								if(($this->native_session->userdata('project_page_size'))==NULL){$limit=Projects_model::LIMIT;}
								else{$limit=', '.$this->native_session->userdata('project_page_size');}
							}
							//only participated and created projects using joint query
							$specific_project=' WHERE `id` IN (SELECT `project_id` FROM `user_project` WHERE `user_account_id`='.$this->native_session->userdata('user_id').') ';
                            //Final query
							$q='SELECT * FROM project'.$specific_project.$where.$order.$offset.$limit;
							//print it
							//echo "Query:".$q;
                            $query =$this->db->query($q);
                            //$query = $this->db->get();
                        return $query;
        }
		
		
	//Add new project info to database
	public function create_project_insert($data) {
			//Query to insert data in database
			$this->db->insert('project', $data);
			if ($this->db->affected_rows() > 0) 
			{
				$this->db->query('INSERT INTO `user_project` (`user_account_id`, `project_id`, `hours`) VALUES '
				.'('.$this->native_session->userdata('user_id').', '.$this->db->insert_id().', 0)');
				//you could also check again!
				return TRUE;
			}
			else
			{
				return FALSE;
			}
	}
	
        //update prject information
        public function update_entry($id,$data)
        {
            $this->db->where('id',$id);
            $this->db->update('project',$data);
                    if ($this->db->affected_rows() > 0) 
                            {
                                    return TRUE;
                            }
                    else
                    {
                            return FALSE;
                    }
        }
        
        
        public function getProjectDetails($id) 
	{
	  	$query = $this->db->query("SELECT * FROM `project` WHERE `id`=".$id);
	  	if($query->num_rows()>0)
			return $query;
		else
			return FALSE;
	}
	
        //get project work hours
	public function getHours($data)
	{
		$condition = ' `user_account_id` = '.$data['user_id'].' AND `project_id` = '.$data['project_id'];
		$query = $this->db->query("SELECT * FROM `user_project` WHERE".$condition);
	  	if($query->num_rows()>0)
			return $query->first_row();
		else
			return FALSE;
	}
        
        //update project work hours
	public function hours_insert($id, $data)
	{
		$condition = ' `user_account_id` = '.$data['user_account_id'].' AND `project_id` = '.$id;
		$this->db->set('hours', $data['hours']);
		$this->db->where($condition);
		$this->db->update('user_project');
		if ($this->db->affected_rows() > 0) 
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}

}