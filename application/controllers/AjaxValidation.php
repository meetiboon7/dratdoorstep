<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxValidation extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function check_signup_email_id()
	{
		
		$post = $this->input->post(NULL, true);

		
		$get_user = $this->db->get_where('user',array('email'=>$post['email_id']));
		
		if($get_user->num_rows() > 0)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	}

}
