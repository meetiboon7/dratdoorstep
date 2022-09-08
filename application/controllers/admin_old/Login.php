<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->load->model('admin/Login_model');
		
	}

	public function index()
	{
		if($this->Login_model->check_admin_login()){
			redirect(base_url().'adminDashboard');
		}
		else
		{
			$this->load->view('admin/login');	
		}
		
		 //$this->session->userdata('user')['user_type'];		
	}

	public function userLogin(){

		
		$post = $this->input->post(NULL, true);
		 $this->load->library('form_validation');
		$this->form_validation->set_rules('mobile', 'Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]');
		
		$this->form_validation->set_rules('password', 'Pin Number ', 'required|regex_match[/^[0-9]{4}$/]');
		

		if($this->form_validation->run() !== FALSE)
    	{
    		
			if(isset($post['mobile']) && isset($post['password']) )
			{
				 //{10} for 10 digits number

				$user_exists = $this->db->get_where('user', array('mobile'=>$post['mobile'], 'password'=>md5($post['password'])));
				
				if($user_exists->num_rows()){
					
					$user_admin_details = $this->db->get_where('user', array('mobile'=>$post['mobile'], 'password'=>md5($post['password'])))->row_array();
						
						if($user_admin_details['user_type_id'] == 1){
							
							$this->session->set_userdata('admin_user',$user_admin_details);
							redirect(base_url().'adminDashboard');
						}
						else
						{
							$this->session->set_flashdata('message', 'Username or Password is invalid. Try again.');
							$this->load->view('admin/login', $data);
						}
					}
					
				else{
					
					$data['error'] = 'Wrong Username/Password';
					$this->load->view('admin/login', $data);
					//$this->load->view('admin/login', $data); 
					//redirect(base_url()."admin",$data);
				}
			}else{

				  $data['error'] = 'Wrong Username/Password';
				  $this->load->view('admin/login', $data);
				//$this->load->view('admin/login', $data); 
				//redirect(base_url()."admin",$data);
			}
		}
		else
		{			
			$data['error'] = validation_errors();
			$this->load->view('admin/login', $data); 			
		}
			
	}
	
	public function signUp()
	{
		$this->load->view('signUp');
	}

	public function userLogout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'admin');
	}

	
	
}