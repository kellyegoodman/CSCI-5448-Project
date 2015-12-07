<?php
		
$config = array(
        'signup' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'trim|required|xss_clean'
                ),
                array(
                        'field' => 'username',
                        'label' => 'Username',
                        'rules' => 'trim|required|xss_clean|is_unique[user_account.username]'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required|min_length[3]|xss_clean'
                ),
                array(
                        'field' => 'passwordconf',
                        'label' => 'Password Confirmation',
                        'rules' => 'trim|required|matches[password]|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|xss_clean'
                )
        ),
        'profile' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'trim|required|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|xss_clean'
                )
        ),
        'updateProject' => array(
                array(
                        'field' => 'name',
                        'label' => 'Porject name',
                        'rules' => 'trim|required|xss_clean'
                ),
                array(
                        'field' => 'deadline',
                        'label' => 'Deadline',
                        'rules' => 'trim|required|exact_length[10]|xss_clean'
                )
        ),
        'createProject' => array(
                array(
                        'field' => 'name',
                        'label' => 'Porject name',
                        'rules' => 'trim|required|xss_clean'
                ),
                array(
                        'field' => 'deadline',
                        'label' => 'Deadline',
                        'rules' => 'trim|required|exact_length[10]|xss_clean'
                ),
                array(
                        'field' => 'description',
                        'label' => 'Dsecription',
                        'rules' => 'xss_clean'
                ),
                array(
                        'field' => 'note',
                        'label' => 'Note',
                        'rules' => 'xss_clean'
                )
        ),
);