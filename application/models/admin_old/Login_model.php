<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
	
	
	public function check_admin_login()
	{
		
		if($this->session->has_userdata('admin_user')){
			return true;
		}else{
			return false;
		}
	}
	
	

}