<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ViewProject extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Load form helper library
		$this->load->helper('form');

		//Load form validation library
		$this->load->library('form_validation');

				//Load table library
		$this->load->library('table');
	}

	public function index() {
		$this->load->view('view_project_view');
	}
}
