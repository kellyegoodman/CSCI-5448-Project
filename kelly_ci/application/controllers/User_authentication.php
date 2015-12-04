<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_authentication extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_user_account','',TRUE);
	}

	function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

		if($this->form_validation->run() == FALSE)
		{
			//Field validation failed.  User redirected to login page
			$this->login();
		}
		else
		{
			//Go to private area
			redirect(base_url().'index.php/Welcome');
		}

	}

	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		//query the database
		$result = $this->Model_user_account->login_user($username, $password);

		if($result) {
			$sess_array = array();
			foreach($result as $row) {
				$sess_array = array(
						'id' => $row->id,
						'username' => $row->username
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		} else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
	
	function login() {
		$this->load->view('include/header');
		$this->load->view('login_form');
		$this->load->view('include/footer');
	}
}
?>