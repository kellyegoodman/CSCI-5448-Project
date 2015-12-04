<?php

Class Project_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Load form helper library
		$this->load->helper('form');

		//Load form validation library
		$this->load->library('form_validation');

		//Load session library
		$this->load->library('session');

		//Load database
		$this->load->model('project_database');
		
		//Load url helper
		$this->load->helper('url');

	}

	//Show main project list page
	public function index() {
		$this->load->view('project_list_form');
	}

	//Show enter hours form
	public function enter_hours_show() {
		$this->load->view('enter_hours_form');
	}

	//Enter hours in current project for current user
	public function enter_hours(){

		//Check validation for user input in enter hours form
		//Required - form cannot be empty
		//Trim - strip whitespace from beginning/end of string
		//Numeric - 
		$this->form_validation->set_rules('hours', 'Hours', 'trim|numeric|required');
		$this->form_validation->set_rules('project_notes', 'Notes', 'trim');

		if ($this->form_validation->run() == FALSE) 
		{
			$this->load->view('enter_hours_form');
		}
		else 
		{
			$data = array(
				'user_name' => ($this->session->userdata['username']),
				'project_hours' => $this->input->post('hours'),
				'project_note' => $this->input->post('project_notes'),
				);
			$result = $this->project_database->hours_insert($data);
			//Check if succesfully inserted into db
			if ($result == TRUE) 
			{
				$data['message_display'] = 'Hours entered!';
				$this->load->view('project_list_form', $data);
			} 
			else 
			{
				$data['message_display'] = 'Invalid hours.';
				$this->load->view('enter_hours_form', $data);
			}
		}
	}

	public function enter_hours_run(){

		if(isset($this->session->userdata['logged_in']))
			{
				$this->load->view('enter_hours_form');
			}
			else
			{
				$this->load->view('login_form');
			}
	}
}
?>