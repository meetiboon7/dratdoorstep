<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserProfile extends CI_Controller {

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

		$this->load->model('user/UserProfile_model');
		$this->load->model('General_model');
		//logout releted code add 10-12-2020
		 $this->load->model('user/Login_model');
		// $this->load->model('General_model');
		 
		if(!$this->Login_model->check_user_login()){
			redirect(base_url());
		}
		//logout releted code add 10-12-2020
          
	}

	public function index()
	{
		$user_id = $this->session->userdata('user')['user_id'];
		$view_user_profile = $this->General_model->view_single_user_profile($user_id);
	    if($view_user_profile)
	    {
	            $this->viewdata['view_user_profile'] = $view_user_profile;
	    }
	    else
	    {
	            $this->viewdata['view_user_profile'] = '';	
	    }
		$this->load->view(USERHEADER);
		$this->load->view(USER_PROFILE,$this->viewdata);
		$this->load->view(USERFOOTER);
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

		// 	$memberdata = array(
					
		// 			'name'=>$post['first_name']." ".$post['last_name'],
		// 			'city_id'=>0,
					
		// 			// 'u_lastname'=>$post['u_lastname'],
		// 	 	// 	'u_updated_on'=>date('Y-m-d H:i:s')
		// 		);
		// 	 $insert_id = $this->db->insert_id();
		// 	 echo $insert_id;
		// 	 exit;

		// $this->db->where('member_id',$insert_id);
		// $this->db->update('member',$memberdata);
		// if($this->session->userdata('user')['user_id']!='')
		// {
		// 	$memberdata = array(
					
		// 			'name'=>$this->session->userdata('user')['first_name']." ".$this->session->userdata('user')['last_name'],
		// 			'contact_no'=>$this->session->userdata('user')['mobile'],
		// 			'user_id'=>$this->session->userdata('user')['user_id'],
					
		// 		);
		//  	//$this->db->insert('member', $memberdata);
		//  	$this->db->select('member.*');
		// 	$this->db->from('member');
		// 	$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
		// 	$member_details= $this->db->get()->row_array();
		// 	if($member_details['user_type_id'] != 1){
		// 		$this->db->insert('member', $memberdata);
		// 	}
		// }
		
		//redirect(base_url().'user/dashboard');	
		$this->load->view('user/dashboard'); 
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

        	 $user_id = $this->session->userdata('user')['user_id'];
           

            $oldpass = $this->input->post('oldpass');
            $newpass = $this->input->post('newpass');
            $passconf = $this->input->post('passconf');

		     if($oldpass == $newpass)
		     {
		     	$this->session->set_flashdata('msg', 'Old Pin and New Pin can not be same.');
		     	redirect(base_url().'userProfile/MyProfile');
		     }
		     elseif($newpass==$passconf)
		     {
		     	 $this->UserProfile_model->update_user($user_id, array('password' => md5($newpass)));
		     	 $this->session->set_flashdata('msg', 'Pin updated successfully.');
			 	redirect(base_url().'userProfile/MyProfile');
		     }
		     else
		     {
		     	$this->session->set_flashdata('msg', 'New Pin and Confirm Pin not matched.');
		     	redirect(base_url().'userProfile/MyProfile');
		     }
            
        }
	}
	public function password_check($oldpass)
    {
        $user_id = $this->session->userdata('user')['user_id'];
        
        $user = $this->UserProfile_model->get_user($user_id);

        if($user->password !== md5($oldpass)) {
            $this->form_validation->set_message('password_check', 'The {field} does not match');
            return false;
        }

        return true;
    }
}
