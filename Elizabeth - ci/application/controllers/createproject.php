<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateProject extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Load form helper library
		$this->load->helper('form');

		//Load form validation library
		$this->load->library('form_validation');
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
			$this->load->view('formsuccess');
		}
	}
}