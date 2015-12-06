<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('include/header');

$this->load->view('include/nav_menu');

$this->load->view($main_content);

$this->load->view('include/footer');

?>