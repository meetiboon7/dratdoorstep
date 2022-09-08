<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complain extends CI_Controller {

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
		//$this->load->model('admin/City_model');
		//$this->load->model('user/member_model');
		 $this->load->model('General_model');
		// if(!$this->Login_model->check_admin_login()){
		// 	redirect(base_url().'admin');
		// }
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

		$this->db->select('feedback.*,feedback_options.name,feedback_services.name as service_name');
		$this->db->from('feedback');
		$this->db->join('feedback_options','feedback_options.feedback_options_id = feedback.feedback_options_id');
		$this->db->join('feedback_services','feedback_services.feedback_services_id = feedback.type');
		$this->db->where('feedback.user_id',$this->session->userdata('user')['user_id']);
		 $this->db->order_by('feedback.feedback_id', 'DESC');

									  
		$data['user_feedback'] = $this->db->get()->result_array();

		
		$this->load->view(USERHEADER);
		$this->load->view(COMPLAIN,$data);
		$this->load->view(USERFOOTER);
	}

	public function addComplain()
	{
		
		$data['feedback_options'] = $this->db->get_where('feedback_options')->result_array();
		$data['feedback_services'] = $this->db->get_where('feedback_services')->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view(ADD_COMPLAIN, $data);
		$this->load->view(USERFOOTER);

	}

	

	public function insertComplain(){
		date_default_timezone_set('Asia/Kolkata');
        //echo date('d-m-Y H:i');
		$post = $this->input->post(NULL, true);
		$feedback_array = array(
			
			'user_id'=>$this->session->userdata('user')['user_id'],
			'name'=>$this->session->userdata('user')['first_name']." ".$this->session->userdata('user')['last_name'],
			'email'=>$this->session->userdata('user')['email'],
			'mobile'=>$this->session->userdata('user')['mobile'],
			'problem'=>$post['problem'],
			'feedback_options_id'=>$post['feedback_options_id'],
			'type'=>$post['type'],
			'date'=>date("Y-m-d H:i:s"),
			
		);
		
		if($this->db->insert('feedback', $feedback_array))
		{
			$this->session->set_flashdata('message','Feedback is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'addComplain');
	}


	
}
