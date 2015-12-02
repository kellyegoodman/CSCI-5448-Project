<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class CreateProject extends CI_Controller
{
	
    public function __construct() 
	{
        parent::__construct();
		
        //$this->initilize();
		//temporary delete after logging controller
		$this->isSigned();
        //$this->getNextListIndex();
		$this->load->model('Project_model');
		$this->load->library('form_validation');
	}
	
	
	//just an example please delete or call 
	//authentication controller after plugging the
	//other files
	private function isSigned()
	{
		//$this->session->set_userdata('user_name', 'Mohammad Alasmary');
		//$this->session->set_userdata('user_id', '1');
		//$this->session->set_userdata('user_last', date('m/d/Y h:i:s a', time()));
		return TRUE;
	}
	
	//only first time
 //    private function initilize()
	// {
	// 	if($this->session->userdata('project_page')===NULL)
	// 	{
	// 		$this->load->model('Projects_model');
	// 		$this->load->helper('form');
	// 		$this->load->library('form_validation');
	// 	}
	// }
	
	
	
	//--Elizabeth--------------------------------------------
	// shows the create project page
	public function index()
	{
		//$this->load->view('header');
		$this->load->view('create_project_view');
		//$this->load->view('footer');
	}
	public function new_project() 
	{
		//I'm not sure it is working
		$this->form_validation->set_rules('name', 'Project Name', 'trim|required');
		//$this->form_validation->set_rules('owner', 'Owner', 'trim|required|integer');
		$this->form_validation->set_rules('deadline', 'Deadline', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('hours', 'Hours', 'trim|required');
		$this->form_validation->set_rules('priority', 'Priority', 'trim|required');
		$this->form_validation->set_rules('time', 'Date Created', 'trim|required');

		//deleted from checking
		$data = array(
			'name' => $this->input->post('name'),
			'owner_id' => $this->input->post('owner'),
			'deadline' => $this->input->post('deadline'),
			'status' => $this->input->post('status'),
			//'hours' => $this->input->post('hours'), needs seprate query
			'priority' => $this->input->post('priority'),
			'creation_date' => $this->input->post('time'),
			'note' => $this->input->post('note'),
			);
		$result = $this->Project_model->create_project_insert($data);
		//Check if succesfully inserted into db
		if ($result == TRUE) 
		{
			$data['message_display'] = 'Successfully registered!';
			echo "inserted!"; exit();
			//$this->load->view('view_project_view', $data);
		} 
		else 
		{
			echo "Not inserted!"; exit();
			echo "Errors";
			//$data['message_display'] = '';
			//$this->load->view('create_project_view', $data);
		}
		// $this->load->view('formsuccess');
	}
}