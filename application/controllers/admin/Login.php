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
				// echo $this->db->last_query();
				// exit;
				if($user_exists->num_rows()){
				    
				
				//	$user_admin_details = $this->db->get_where('user', array('mobile'=>$post['mobile'], 'password'=>md5($post['password'])))->row_array();
					    $this->db->from('user');
                        $this->db->where("mobile",$post['mobile']);
                        $this->db->where("password",md5($post['password']));
                       // $this->db->where('user_type_id !=', 99);
                        $this->db->where("(user_type_id != '99' OR user_type_id != '0')");
                         $this->db->where("(role_id != '0')");
                        $user_admin_details = $this->db->get()->row_array();
                        // echo "<pre>";
                        // echo $this->db->last_query();
                        // exit;
                        // print_r($user_admin_deatails);
                        // exit;
						
							if($user_admin_details['user_type_id'] == 999 || $user_admin_details['user_type_id'] == 1 || $user_admin_details['user_type_id'] == 2 || $user_admin_details['user_type_id'] == 3 || $user_admin_details['user_type_id'] == 4 || $user_admin_details['user_type_id'] == 5 || $user_admin_details['user_type_id'] == 6 || $user_admin_details['user_type_id'] == 7 || $user_admin_details['user_type_id'] == 8){
							

							$this->session->set_userdata('admin_user',$user_admin_details);

							if($this->session->userdata('admin_user')['emp_id']=="-1")
							{
								redirect(base_url().'adminDashboard');
							}
							else
							{
								$this->db->select('employee_master.*');
		                    	$this->db->from('employee_master');
		                    	$this->db->where('employee_master.emp_id',$this->session->userdata('admin_user')['emp_id']);
		 						$this->db->where('employee_master.emp_status',1);
		 						$employees = $this->db->get()->row_array();
		 						if($employees['emp_status']==1)
								{
									redirect(base_url().'adminDashboard');
								}
								else
								{
									$this->session->set_flashdata('message', 'This user in inactive Please Contact admin.');
								    $this->load->view('admin/login', $data);
								}

							}
							
			//                 echo $this->db->last_query();

			// echo "<pre>";
			// echo $employees['emp_status'];
			// print_r($employees);
			// echo "</pre>";
			// exit;			
							

							
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
	public function ForgotPassword()
	{
	    $email = $this->input->post('email');
	    $findemail = $this->Login_model->ForgotPasswordUser($email);
	    if ($findemail) {
	        $this->Login_model->sendpasswordUser($findemail);
	    } else {
	       // echo "<script>alert(' $email not found, please enter correct email id')</script>";
	       $this->session->set_flashdata('message', $email.' not found, please enter correct email id');
	        redirect(base_url().'forgotPinAdmin');
	    }
	}
	public function signUp()
	{
		$this->load->view('signUp');
	}
	public function forgotPin()
	{
		$this->load->view('admin/forgotPin');
	}
	public function userLogout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'admin');
	}

	
	
}
