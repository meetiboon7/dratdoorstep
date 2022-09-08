<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class Profile extends GeneralController {

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
	public function __construct() {
		parent::__construct();

		$this->load->model('admin/Profile_model');
		$this->load->model('General_model');
		$this->load->model('admin/Login_model');	
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}
          
	}

	public function index()
	{
		parent::index();
		$user_id = $this->session->userdata('admin_user')['user_id'];
		$view_user_profile = $this->General_model->view_single_user_profile($user_id);
	    if($view_user_profile)
	    {
	            $this->viewdata['view_user_profile'] = $view_user_profile;
	    }
	    else
	    {
	            $this->viewdata['view_user_profile'] = '';	
	    }
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(ADMIN_PROFILE,$this->viewdata);
		$this->load->view(FOOTER);
	}
	public function updateMyProfile()
	{
		$post = $this->input->post(NULL, true);
		$update_user_id = $post['btn_update_user_myprofile'];
		
		$this->General_model->uploadImage('./uploads/user_profile/', $update_user_id,'profile_','img_profile', 'user','profile_pic');

		$data = array(
					
					'first_name'=>$post['first_name'],
					'last_name'=>$post['last_name'],
					'email'=>$post['email'],
					'mobile'=>$post['mobile'],
					
					// 'u_lastname'=>$post['u_lastname'],
			 	// 	'u_updated_on'=>date('Y-m-d H:i:s')
				);

		$this->db->where('user_id',$update_user_id);
		$this->db->update('user',$data);	
		
		redirect(base_url().'admin/dashboard');	
	}
	
	public function changePassword()
	{

		

		
		
        $this->form_validation->set_rules('oldpass', 'old password', 'callback_password_check');
        $this->form_validation->set_rules('newpass', 'new password', 'required');
        $this->form_validation->set_rules('passconf', 'confirm password', 'required|matches[newpass]');

        // $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if($this->form_validation->run() == false) {
        	$this->session->set_flashdata('msg', 'Please Enter Correct information.');

        	redirect($_SERVER['HTTP_REFERER']);
        }
        else {

        	 $user_id = $this->session->userdata('admin_user')['user_id'];
           
        	 
            $newpass = $this->input->post('newpass');

            $this->Profile_model->update_user($user_id, array('password' => md5($newpass)));

           	// redirect(base_url().'PharmacistProfile/Reset');
           	redirect(base_url().'admin'); 
        }
	}
	public function password_check($oldpass)
    {
        $user_id = $this->session->userdata('admin_user')['user_id'];
        
        $user = $this->Profile_model->get_user($user_id);

        if($user->password !== md5($oldpass)) {
            $this->form_validation->set_message('password_check', 'The {field} does not match');
            return false;
        }

        return true;
    }
}
