<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Users_controller extends CI_Controller
{	
    public function __construct() 
	{
        parent::__construct();
        $this->load->model("Users_model");
        $this->load->helper("url");
        $this->load->library("pagination");
    }
	

	private function isSigned()
	{
		if($this->session->userdata('user_id')==NULL OR empty($this->session->userdata('user_id')))
		{
			show_error('You are not allowed to access this page.');
			exit();
		}
		return TRUE;
	}

	//Link and Unlink Users---------------------------------------------
	private function setCurrentProject($project_id)
	{
		//check project ID allowed
		if($this->Users_model->projectOwned($project_id,$this->session->user_id))
		{	
			$this->session->set_userdata('project', $project_id);
		}
		else
		{	
			show_error('You are not allowed to access this page.');
			exit();
		}
	}

	//this is similar to render in the class diagram
    public function viewUnlinkedUsers($project_id,$msg='') 
	{
		$this->setCurrentProject($project_id);
        $this->isSigned();
		//do the query
		
        $data['query']=$this->Users_model->get_unlinkedUsers($project_id);
        if(isset($msg))
        {
                $data['msg']=$msg;
        }
        //render
        $this->load->view('header',$data);
        $this->load->view('pages/linkUsers_view',$data);
        $this->load->view('footer',$data);
    }
	
	//this is similar to render in the class diagram
    public function viewLinkedUsers($project_id,$msg='') 
	{
        $this->setCurrentProject($project_id);
		$this->isSigned();
		/**pagination
		$config = array();
        $config["base_url"] = base_url()."";
        $config["total_rows"] = $this->Users_model->record_count($_SESSION['project'],"linked");
        $config["per_page"] = 1;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->Users_model->fetch_users($config["per_page"], $page,$_SESSION['project'],"linked");
        $data["links"] = $this->pagination->create_links();*/
		//do the query
		$data['title']=$this->Users_model->getProjectName($project_id);
        $data['query']=$this->Users_model->get_linkedUsers($project_id);
        if(isset($msg))
        {
                $data['msg']=$msg;
        }
        //render
        $this->load->view('header',$data);
        $this->load->view('pages/unlinkUsers_view',$data);
        $this->load->view('footer',$data);
    }
	
    public function linkUser($project_id, $user_id) {
        $this->isSigned();
        //do the query
        $data['query']=$this->Users_model->linkUser($project_id,$user_id);
        //set the message
        if($data['query']>0)
        {$msg='1The user has been added sucessfully.';}
        else
        {$msg='0Unexpected errors!';}
        //return the same list
        $this->viewUnlinkedUsers($project_id,$msg);
    }
	

	//this is just to get the warning message
	public function confirmUnlink($project_id, $user_id, $confirm='')
	{
		$name=$this->Users_model->getUserName($user_id);
		//Display message
		$msg="0You are about to delete ".$name.". Are you sure? "
		.anchor('users_controller/unlinkUser/'.$project_id.'/'.$user_id,"Yes","class='_menu'")."  "
		.anchor('users_controller/viewLinkedUsers/'.$project_id,"No","class='_menu'");
		//return the same list
        $this->viewLinkedUsers($project_id,$msg);
	}
    public function unlinkUser($project_id, $user_id) {
        //check for safety user_id
        $this->isSigned();
		//load number of hours
		
        //do the query
        $data['query']=$this->Users_model->unlinkUser($project_id,$user_id);
        //set the message
        if($data['query']>0)
        {$msg='1The user has been removed sucessfully.';}
        else
        {$msg='0Unexpected errors!';}
        //return the same list
        $this->viewLinkedUsers($project_id,$msg);
    }
}
