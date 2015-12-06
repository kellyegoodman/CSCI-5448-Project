<?php

Class Register_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Load database
		$this->load->model('Users_model');
	}


	// validates information and adds user to database
	function register_user() { 
		$data['page_header'] = 'Create an Account';
	
		//validation rules
		$this->form_validation->set_rules('username','Username','required|trim|min_length[4]|max_length[30]|is_unique[user_account.username]');
		$this->form_validation->set_rules('email','E-mail address','required|trim|valid_email');
		$this->form_validation->set_rules('name','First and Last Name','required|trim');
		$this->form_validation->set_rules('password','Password','required|trim|min_length[4]');
		$this->form_validation->set_rules('password_confirm','Confirm Password','required|trim|matches[password]');
	
		if ($this->form_validation->run($this) == FALSE) { //didn't validate
			$this->register_show();
		} else {
			$this->load->model('Users_model');
				
			if ($query = $this->Users_model->add_user()) {
				// redirect to login page (with a success message)
				$content['msg'] = 'New user created! You can now log in.';
				$this->load->view('include/header');
				$this->load->view('login_form',$content);
				$this->load->view('include/footer');
			} else {
				echo 'Something went wrong with our database. Please try again.';
				$this->register_show();
			}
		}
	}
	
	// display register_form
	function register_show() {
		$this->load->view('include/header');
		$this->load->view('register_form');
		$this->load->view('include/footer');
	}
	
	function get_user_settings() {
		$sess = $this->session->userdata('user_id');
		$result = $this->Users_model->get_user_info($sess['id']);
		$data = array();
		foreach($result as $row) {
			$data = array(
					'username' => $row->username,
					'name' => $row->name,
					'email' => $row->email
			);
		}
		return $data;
	}
	
	function profile_show() {
		$data = $this->get_user_settings();
		$data['main_content'] = 'user_profile';
		$this->load->view('include/page_layout',$data);
	}
	
	function edit_profile_show() {
		$data = $this->get_user_settings();
		$data['main_content'] = 'edit_settings_form';
		$this->load->view('include/page_layout',$data);
	}
	
	function change_password_view() {
		$data['main_content'] = 'change_password_form';
		$this->load->view('include/page_layout',$data);
	}
	
	function verify_password($password) {
		$sess = $this->session->userdata('user_id');
		//query the database
		$result = $this->Users_model->verify_password($sess['id'], $password);
	
		if($result) {
			return TRUE;
		} 
		$this->form_validation->set_message('verify_password', 'Invalid username or password');
		return FALSE;
	}
	
	// validates password and updates user password
	function change_password() {
		$data['page_header'] = 'Change password';
		$sess = $this->session->userdata('user_id');
	
		//validation rules
		$this->form_validation->set_rules('password','Password','required|trim|callback_verify_password');
		$this->form_validation->set_rules('password_new','Password','required|trim|min_length[4]');
		$this->form_validation->set_rules('password_new_confirm','Confirm Password','required|trim|matches[password_new]');
	
		if ($this->form_validation->run($this) == FALSE) { //didn't validate
			$this->change_password_view();
		} else {
	
			if ($query = $this->Users_model->change_password($sess['id'])) {
				// redirect to login page (with a success message)
				$content['msg'] = 'Your password has been updated. Please re-login.';
				$this->load->view('include/header');
				$this->load->view('login_form',$content);
				$this->load->view('include/footer');
			} else {
				echo 'Something went wrong with our database. Please try again.';
				$this->change_password_view();
			}
		}
	}
	
	function edit_user() { // updates user information in database
		$data['page_header'] = 'Edit settings';
		$sess = $this->session->userdata('user_id');
		
		//validation rules
		$this->form_validation->set_rules('email','E-mail address','required|trim|valid_email');
		$this->form_validation->set_rules('name','First and Last Name','required|trim');
		
		if ($this->form_validation->run($this) == FALSE) { //didn't validate
			$this->edit_profile_show();
		} else {
			
			if ($query = $this->Users_model->change_user($sess['id'])) {
				// redirect to login page (with a success message)
				$content['msg'] = 'Your changes have been made. Please re-login.';
				$this->load->view('include/header');
				$this->load->view('login_form',$content);
				$this->load->view('include/footer');
			} else {
				echo 'Something went wrong with our database. Please try again.';
				$this->edit_profile_show();
			}
		}
	}
	
}