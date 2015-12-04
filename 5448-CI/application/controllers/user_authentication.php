<?php

Class User_Authentication extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Load form helper library
		$this->load->helper('form');

		//Load form validation library
		$this->load->library('form_validation');

		//Load session library
		$this->load->library('session');

		//Load database
		$this->load->model('login_database');
		
		//Load url helper
		$this->load->helper('url');
	}

	//Show login page
	public function index() {
		$this->load->view('login_form');
	}

	//Show registration page
	public function user_registration_show() {
		$this->load->view('registration_form');
	}

	//Validate and store registration data in database
	public function new_user_registration() {

		//Check validation for user input in registration form
		//Required - form cannot be empty
		//Trim - strip whitespace from beginning/end of string
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('email_value', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		//If validation fails, reload the form
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('registration_form');
		} 
		else 
		{
			$data = array(
				'user_name' => $this->input->post('username'),
				'user_email' => $this->input->post('email_value'),
				'user_password' => md5($this->input->post('password')) //md5 encryption
				);
			$result = $this->login_database->registration_insert($data);
			//Check if succesfully inserted into db
			if ($result == TRUE) 
			{
				$data['message_display'] = 'Successfully registered!';
				$this->load->view('login_form', $data);
			} 
			else 
			{
				$data['message_display'] = 'Username already exists!';
				$this->load->view('registration_form', $data);
			}
		}
	}

	//Run user login
	public function user_login_process() {

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			//Validate user is logged in
			if(isset($this->session->userdata['logged_in']))
			{
				$this->load->view('project_list_form');
			}
			else
			{
				$this->load->view('login_form');
			}
		} 
		else 
		{
			$data = array(
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password'))
				);
			//Send entered information to compare against db
			$result = $this->login_database->login($data);
			if ($result == TRUE) 
			{
				$username = $this->input->post('username');
				$result = $this->login_database->read_user_information($username);
				if ($result != false) 
				{
					$session_data = array(
						'username' => $result[0]->user_name,
						'email' => $result[0]->user_email,
						'logged_in' => TRUE
						);
					//Add user data to the session
					$this->session->set_userdata($session_data);
					$this->load->view('project_list_form');
				}
			} 
			else 
			{
				$data = array(
					'error_message' => 'Invalid Username or Password'
					);
				$this->load->view('login_form', $data);
			}
		}
	}

	//Logout from user page
	public function logout() {

		//Remove session data
		$sess_array = array(
			'username' => '',
			'email' => '',
			);
		$this->session->unset_userdata('logged_in',$sess_array);
		$data['message_display'] = 'Successfully logged out';
		$this->load->view('login_form', $data);
	}

}

?>