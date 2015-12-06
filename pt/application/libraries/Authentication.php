<?php 
//edited by Mohammad Alasmary
if ( ! defined('BASEPATH') ) exit( 'No direct script access allowed' );

class Authentication
{
    public function __construct()
    {
    }
    public function isSigned()
    {
        if($_SESSION['user_id']!==NULL AND !empty($_SESSION['user_id']))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
?>