<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateProject extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Load form helper library
		$this->load->helper('form');

		//Load form validation library
		$this->load->library('form_validation');

		$this->load->model('Project_Database');
	}

	// shows the create project page
	public function index()
	{
		$this->load->view('create_project_view');
	}

	// validate and store project information in database
	public function new_project() {
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('owner', 'Owner', 'trim|required');
		$this->form_validation->set_rules('num_users', 'Number of Users', 'trim|required|integer');
		$this->form_validation->set_rules('deadline', 'Deadline', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('hours', 'Hours', 'trim|required');
		$this->form_validation->set_rules('priority', 'Priority', 'trim|required');
		$this->form_validation->set_rules('time', 'Time', 'trim|required');
		$this->form_validation->set_rules('note', 'Note', 'trim|required');

		//If validation fails, reload the form
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('create_project_view');
		}
		else
		{
			$data = array(
				'email' => $this->input->post('email'),
				'name' => $this->input->post('name'),
				'owner' => $this->input->post('owner'),
				'num_users' => $this->input->post('num_users'),
				'deadline' => $this->input->post('deadline'),
				'status' => $this->input->post('status'),
				'hours' => $this->input->post('hours'),
				'priority' => $this->input->post('priority'),
				'time' => $this->input->post('time'),
				'note' => $this->input->post('note'),
				);
			$result = $this->Project_Database->create_project_insert($data);
			//Check if succesfully inserted into db
			if ($result == TRUE) 
			{
				$data['message_display'] = 'Successfully registered!';
				$this->load->view('view_project_view', $data);
			} 
			else 
			{
				$data['message_display'] = '';
				$this->load->view('create_project_view', $data);
			}
			// $this->load->view('formsuccess');
		}
	}
}
