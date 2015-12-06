<?php 
//the code adapted from 
//https://www.moreofless.co.uk/using-native-php-sessions-with-codeigniter/
//the main used to run the old session PHP
//edited by Mohammad Alasmary
if ( ! defined('BASEPATH') ) exit( 'No direct script access allowed' );

class Native_session
{
    public function __construct()
    {
        session_start();
    }

    public function set( $key, $value )
    {
        $_SESSION[$key] = $value;
        echo 's='.$_SESSION[$key];
    }
    public function setarr($arr)
    {
		foreach ($arr as $key => $value)
		{
			$this->set( $key, $value );
		}
    }

    //just to match codeigniter
    public function __call($method, $arguments) 
    {
      if($method == 'set_userdata') {
          if(count($arguments) == 2) {
             return call_user_func_array(array($this,'set'), $arguments);
          }
          else if(count($arguments) == 1) {
             return call_user_func_array(array($this,'setarr'), $arguments);
          }
      }
    }  
    
    public function get( $key )
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : NULL;
    }
	public function userdata( $key )
    {
        return $this->get($key);
    }
    public function regenerateId($delOld = false)
    {
        session_regenerate_id( $delOld );
    }

	public function unset_userdata($arr)
	{
		$this->delete($arr);
	}
    public function delete($keys)
    {
    	if(is_array($keys))
    	{
			foreach ($keys as $key => $value)
			{
				unset($_SESSION[$key]);
			}
		}
		else
        {
        	unset( $_SESSION[$keys] );
        }
    }
}