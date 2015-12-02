<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	function register() { // display register_form
		$this->load->view('include/header');
		$this->load->view('register_form');
		$this->load->view('include/footer');
	}
	
	function login() { // display login_form
		$this->load->view('include/header');
		$this->load->view('login_form');
		$this->load->view('include/footer');
	}
	
	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect(base_url().'index.php/Welcome');
	}
	
	function profile_show()
	{
		$this->load->model('Model_user_account');
		$sess = $this->session->userdata('logged_in');
		
		$result = $this->Model_user_account->get_user_info($sess['id']);
		$data = array();
		foreach($result as $row) {
			$data = array(
					'username' => $row->username,
					'name' => $row->name,
					'email' => $row->email
			);
		}
		$data['main_content'] = 'user_profile';
		$this->load->view('include/page_layout',$data);
	}

	function create_user() { // validates information and adds user to database
		$data['page_header'] = 'Create an Account';
		
		//validation rules
		$this->form_validation->set_rules('username','Username','required|trim|min_length[4]|max_length[30]|is_unique[user_account.username]');
		$this->form_validation->set_rules('email','E-mail address','required|trim|valid_email');
		$this->form_validation->set_rules('name','First and Last Name','required|trim');
		$this->form_validation->set_rules('password','Password','required|trim|min_length[4]');
		$this->form_validation->set_rules('password_confirm','Confirm Password','required|trim|matches[password]');
		
		if ($this->form_validation->run($this) == FALSE) { //didn't validate
			$this->register();
		} else {
			$this->load->model('Model_user_account');
			
			if ($query = $this->Model_user_account->add_user()) {
				// redirect to home page (add a success message?)
				redirect(base_url().'index.php/Welcome');
			} else {
				echo 'Something went wrong with our database. Please try again.';
				$this->register();
			}
		}
	}
	
	

}	
