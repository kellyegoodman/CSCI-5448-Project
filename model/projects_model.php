<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Projects_model extends CI_Model {

		const LIMIT=5;
		
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }
		
		
        public function get_projects($all=FALSE)
        {
                       $query='';
					   $order='';
					   $asc='';
					   $where='';
					   $offset='';
					   $limit='';
							//if the user chose the column order else nothing
							if(($this->session->userdata('project_order_by'))!==NULL)
							{
								$asc=($this->session->userdata('project_asc')!==NULL)?$this->session->userdata('project_asc'):'ASC';
								$asc=' '.$asc.' ';
								$order= ' ORDER BY '.$this->session->userdata('project_order_by').$asc;
							}
							//read search criteria
							if(($this->session->userdata('search'))!==NULL)
							{
								$where=' AND '.$this->session->userdata('search_column').' LIKE "%'.$this->session->userdata('search').'%" ';
							}else{$where='';}
							//if all no need to limit
							if($all == FALSE)
							{
								//defined start or 0
								if(($this->session->userdata('project_start'))==NULL){$offset=0;}
								$offset=' LIMIT '.$this->session->userdata('project_start');
								//defined limit or constant LIMIT=5
								if(($this->session->userdata('project_page_size'))==NULL){$limit=Projects_model::LIMIT;}
								else{$limit=', '.$this->session->userdata('project_page_size');}
							}
							//only participated and created projects using joint query
							$specific_project=' WHERE `id` IN (SELECT `project_id` FROM `user_project` WHERE `user_account_id`='.$this->session->user_id.') ';
                            //Final query
							$q='SELECT * FROM project'.$specific_project.$where.$order.$offset.$limit;
							//print it
							//echo "Query:".$q;
                            $query =$this->db->query($q);
                            //$query = $this->db->get();
                        return $query;
        }
		
		public function get_linkedUsers($project_id) {
            
            $query =$this->db->query('SELECT * FROM `user_account` WHERE `id` '
                    . 'IN '
                    . '(SELECT `user_account_id` FROM `user_project` WHERE `project_id`='.$project_id.')');
            return $query;
        }
		
        public function get_unlinkedUsers($project_id) {
            
            $query =$this->db->query('SELECT * FROM `user_account` WHERE `id` '
                    . 'NOT IN '
                    . '(SELECT `user_account_id` FROM `user_project` WHERE `project_id`='.$project_id.')');
            return $query;
        }
        public function linkUser($project_id,$user_id) {
            
			
            $query =$this->db->query('INSERT INTO `user_project` (`user_account_id`, `project_id`, `hours`) '
                    . 'VALUES ('.$user_id.', '.$project_id.', 0)');
            return $query;
        }
        public function unlinkUser($project_id,$user_id) {
            
            $query =$this->db->query('DELETE FROM `user_project` WHERE `user_account_id`='.$user_id.' AND `project_id`='.$project_id);
            return $query;
        }


}