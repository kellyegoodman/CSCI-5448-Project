<?php

Class Login_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Load database
		$this->load->model('Users_model');
	}
	
	function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_verify_password');
	
		if($this->form_validation->run() == FALSE) {
			//Field validation failed.  User redirected to login page
			$this->login_show();
		} else {
			//Go to private area
			redirect(base_url().'index.php/Welcome');
		}
	}
	
	// display login_form
	function login_show() {
		$this->load->view('include/header');
		$this->load->view('login_form');
		$this->load->view('include/footer');
	}
	
	// if password is correct, user is logged in
	function verify_password($password) {
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');
	
		//query the database
		$result = $this->Users_model->login_user($username, $password);
	
		if($result) {
			$sess_array = array();
			foreach($result as $row) {
				$sess_array = array(
						'id' => $row->id,
						'username' => $row->username
				);
				$this->session->set_userdata('user_id', $sess_array);
			}
			return TRUE;
		} else {
			$this->form_validation->set_message('verify_password', 'Invalid username or password');
			return false;
		}
	}
	
	
	// logout user
	function logout() {
		$this->session->unset_userdata('user_id');
		session_destroy();
		redirect(base_url().'index.php/Welcome');
	}



}

?>