<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Users_controller extends CI_Controller
{	
    public function __construct() 
	{
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("pagination");
    }
	

	private function isSigned()
	{
		if($this->native_session->userdata('user_id')!==NULL AND !empty($this->native_session->userdata('user_id')))
		{
			return TRUE;
		}
		else
		{
			redirect("login_controller/index");
                }	
	}

	//Link and Unlink Users---------------------------------------------
	private function setCurrentProject($project_id)
	{
            //check project ID allowed
            if($this->Users_model->projectOwned($project_id,$this->native_session->userdata('user_id')))
            {	
                    $this->native_session->set_userdata('project', $project_id);
            }
            else
            {	
                    redirect("login_controller/index");
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
            {$data['msg']=$msg;}
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
    public function profile_show()
	{
            //check for safety user_id not implmented
            $this->isSigned();
            $data['query'] = $this->Users_model->getUser($_SESSION['user_id']);
            $this->load->view('header');
            $this->load->view('pages/my_profile',$data);
	}
	public function profile_update()
	{
		//If validation fails, reload the form
		if ($this->form_validation->run('profile') == FALSE) 
		{
			$this->profile_show();
		}
		else
		{
			$data = array(
				'name' => $this->input->post('name',TRUE),
				'email' => $this->input->post('email',TRUE));
			//update the db
			$result = $this->Users_model->updateProfile($_SESSION['user_id'],$data);
			//render
                        redirect('projects_controller/index/');
			
		}	
	}
}
