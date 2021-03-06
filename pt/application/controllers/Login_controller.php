<?php

Class Login_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	//Show login page
	public function index($data='') 
	{
            //if the user alreday signed go back to homepage
            $this->isSigned();
            $this->load->view('header');
            $this->load->view('pages/login_form',$data);
            $this->load->view('footer');
	}
        
        private function isSigned()
        {
            if($this->native_session->userdata('user_id')!=NULL)
            {
                redirect("Projects_controller/index");
            }
            else
            {
                return FALSE;
            }
        }

	//Validate and store registration data in database
	public function createUserAccount() 
        {
            //If validation fails, reload the form
            if ($this->form_validation->run('signup') == FALSE) 
            {
                //Show registration page
                $this->load->view('header');
		$this->load->view('pages/registration_form');
            } 
            else 
            {
                    $data = array(
                            'username' => $this->input->post('username',TRUE),
                            'email' => $this->input->post('email_value',TRUE),
                            'password' => md5($this->input->post('password',TRUE)), //md5 encryption
                            'name' => $this->input->post('name',TRUE),
                            'creation_date' => date('Y-m-d'),
                            'last_login' => date('Y-m-d')
                            );
                    $result = $this->login_model->registration_insert($data);
                    //Check if succesfully inserted into db
                    if ($result == TRUE) 
                    {
                            $data['message_display'] = 'Successfully registered!';
                            $this->index($data);
                    } 
                    else 
                    {
                            $data['message_display'] = 'Username already exists!';
                            $this->load->view('header');
                            $this->load->view('pages/registration_form', $data);
                    }
            }
	}

	//Run user login
	public function login() 
	{
		//if the user alreday signed go back to homepage
		$this->isSigned();
                $data = array(
                        'username' => $this->input->post('username',TRUE),
                        'password' => md5($this->input->post('password',TRUE)),
                        'last_login' => date('Y/m/d'));
                //compare against db
                $result = $this->login_model->login($data);
                if ($result != FALSE) 
                {
                    $session_data = array(
                            'user_name' => $result[0]->username,
                            'user_id' => $result[0]->id,
                            'user_last' => date('Y/m/d'));	
                    //Add user data to the session
                    $this->native_session->set_userdata($session_data);
                    //render
                    $this->isSigned();
                }
                else 
                {
                        $data = array('error_message' => 'Invalid Username or Password');
                        $this->index($data);
                }	
	}
	

	//Logout from user page
	public function logout() 
	{
		//Remove session data
		$sess_array = array(
			'user_name' => '',
			'user_id' => '',
			'user_last' => '',
			);
		$this->native_session->delete($sess_array);
		session_destroy();
		$this->index();
	}


}

?>
