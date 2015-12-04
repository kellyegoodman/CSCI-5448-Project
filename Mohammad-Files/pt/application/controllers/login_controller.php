<?php

Class Login_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Load form helper library
		$this->load->helper('form');

		//Load form validation library
		$this->load->library('form_validation');

		//Load session library
		$this->load->library('session');

		//Load database
		$this->load->model('login_model');
		$this->load->model('Projects_model');
		
		//Load url helper
		$this->load->helper('url');
	}

	//Show login page
	public function index() {
		$this->load->view('header');
		$this->load->view('pages/login_form');
		$this->load->view('footer');
	}

	//Show registration page
	public function user_registration_show() {
		$this->load->view('header');
		$this->load->view('pages/registration_form');
		$this->load->view('footer');
	}

	public function login_form_show() {
		//redirect('login_controller/index');
		$this->load->view('header');
		$this->load->view('pages/login_form');
		$this->load->view('footer');
	}

	//Validate and store registration data in database
	public function new_user_registration() {

		//Check validation for user input in registration form
		//Required - form cannot be empty
		//Trim - strip whitespace from beginning/end of string
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('email_value', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');		

		//If validation fails, reload the form
		if ($this->form_validation->run() == FALSE) {
			$this->user_registration_show();
			//redirect('login_controller/user_registration_show');
			//$this->load->view('pages/registration_form');
			// $this->load->view('header');
			// $this->load->view('pages/registration_form');
			// $this->load->view('footer');
		} 
		else 
		{
			$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email_value'),
				'password' => md5($this->input->post('password')), //md5 encryption
				'name' => $this->input->post('name'),
				'creation_date' => date('Y-m-d H:i:s'),
				'last_login' => date('Y-m-d H:i:s')
				);
			$result = $this->login_model->registration_insert($data);
			//Check if succesfully inserted into db
			if ($result == TRUE) 
			{
				$data['message_display'] = 'Successfully registered!';
				$this->login_form_show();
				//redirect('pages/login_form');
				//$this->load->view('pages/login_form', $data);
				// $this->load->view('header');
				// $this->load->view('pages/login_form');
				// $this->load->view('footer');
			} 
			else 
			{
				$data['message_display'] = 'Username already exists!';
				//$this->user_registration_show($data);
				//redirect('login_controller/user_registration_show', $data);
				//$this->load->view('pages/registration_form', $data);
				$this->load->view('header');
				$this->load->view('pages/registration_form', $data);
				$this->load->view('footer');
			}
		}
	}

	//Run user login
	public function user_login_process() {

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			//Validate user is logged in
			if(isset($this->session->userdata))
			{
				
				redirect('projects_controller/index');
				//$this->load->view('pages/projects_view');
				//echo form_open('project_controller/initilize');
			}
			else
			{
				$this->login_form_show();
				// $this->load->view('header');
				// $this->load->view('pages/login_form');
				// $this->load->view('footer');
			}
		} 
		else 
		{
			$data = array(
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'last_login' => date('Y-m-d H:i:s')
				);
			//Send entered information to compare against db
			$result = $this->login_model->login($data);
			if ($result == TRUE) 
			{
				$username = $this->input->post('username');
				$result = $this->login_model->read_user_information($username);
				if ($result != false) 
				{
					$session_data = array(
						'user_name' => $result[0]->username,
						'user_id' => $result[0]->id,
						'user_last' => date('m/d/Y h:i:s a', time()),
						);
					//Add user data to the session
					$this->session->set_userdata($session_data);
					
					redirect('projects_controller/index');
				}
			} 
			else 
			{
				$data = array(
					'error_message' => 'Invalid Username or Password'
					);
				//$this->login_form_show($data);
				$this->load->view('header');
				$this->load->view('pages/login_form', $data);
				$this->load->view('footer');
			}
		}
	}

	//Logout from user page
	public function logout() {

		//Remove session data
		$sess_array = array(
			'user_name' => '',
			'user_id' => '',
			'user_last' => ''
			);
		$this->session->unset_userdata($sess_array);
		$data['message_display'] = 'Successfully logged out';
		//$this->login_form_show($data);

		$this->load->view('header');
		$this->load->view('pages/login_form', $data);
		$this->load->view('footer');
	}

}

?>