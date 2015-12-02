<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModifyProject extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Load form helper library
		$this->load->helper('form');

		//Load form validation library
		$this->load->library('form_validation');

		//Load database
		$this->load->model('Project_model');
	}

	public function index()
	{
		$this->data['data'] = $this->Project_model->getProjectDetails();
		$this->load->view('modify_project_view', $this->data);
	}

	// validate and store project information in database
	public function new_project() {
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
		$result = $this->Project_model->update_entry($data);
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
