<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends CI_Controller {

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

		// echo "test";
		// exit;

		$this->db->select('manage_package.*,city.city,user_type.user_type_name');
		$this->db->from('manage_package');
		$this->db->join('city','city.city_id = manage_package.city_id');
		$this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
		$this->db->where('manage_package.city_id',$this->session->userdata('user')['city_id']);
		$this->db->where('manage_package.package_status',1);
		$this->db->order_by('manage_package.package_id', 'DESC');
									  
		$data['manage_package'] = $this->db->get()->result_array();

		$date=date('Y-m-d');
		$this->db->select('holidays.*');
		$this->db->from('holidays');
		$this->db->where('hdate',$date);
		$data['holiday'] = $this->db->get()->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/listPackage',$data);
		$this->load->view(USERFOOTER);
	}
	public function viewPackage()
	{

		$post = $this->input->post(NULL, true);
		$package_id = $post['btn_view_package'];

		// $data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		// $data['service'] = $this->db->get_where('user_type', array('status'=>1))->result_array();

		// $data['manage_package'] = $this->db->get_where('manage_package', array('package_id'=>$package_id))->row_array();


		$this->db->select('manage_package.*,city.city,user_type.user_type_name');
		$this->db->from('manage_package');
		$this->db->join('city','city.city_id = manage_package.city_id');
		$this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
		$this->db->where('manage_package.package_status',1);
		$this->db->where('manage_package.package_id',$package_id);
		$this->db->order_by('manage_package.package_id', 'DESC');
									  
		$data['manage_package'] = $this->db->get()->row_array();
		$date=date('Y-m-d');
		$this->db->select('holidays.*');
		$this->db->from('holidays');
		$this->db->where('hdate',$date);
		$data['holiday'] = $this->db->get()->result_array();
		// echo $this->db->last_query();
		// exit;

		$this->load->view(USERHEADER);
		$this->load->view('user/viewPackageDetails',$data);
		$this->load->view(USERFOOTER);

	}
	public function addPackage()
	{
		
		$this->db->select('manage_package.*');
		$this->db->from('manage_package');
		$this->db->order_by('manage_package.package_id','DESC');

									  
		$data['purchase_package'] = $this->db->get()->result_array();

		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();


		$post = $this->input->post(NULL, true);

		if($this->uri->segment(2) == 'viewPackage')
		{
			$package_id = $post['btn_view_package'];
			$this->db->select('manage_package.*,city.city,user_type.user_type_name');
			$this->db->from('manage_package');
			$this->db->join('city','city.city_id = manage_package.city_id');
			$this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
			$this->db->where('manage_package.package_status',1);
			$this->db->where('manage_package.package_id',$package_id);
			$this->db->order_by('manage_package.package_id', 'DESC');
										  
			$data['manage_package'] = $this->db->get()->row_array();
		}
		else
		{

			$package_id = $post['btn_add_package'];
			$this->db->select('manage_package.*,city.city,user_type.user_type_name');
			$this->db->from('manage_package');
			$this->db->join('city','city.city_id = manage_package.city_id');
			$this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
			$this->db->where('manage_package.package_status',1);
			$this->db->where('manage_package.package_id',$package_id);
			$this->db->order_by('manage_package.package_id', 'DESC');
										  
			$data['manage_package'] = $this->db->get()->row_array();
		}
		
	
		
		
			
		

		
			// $this->db->select('manage_package.*,city.city,user_type.user_type_name');
			// $this->db->from('manage_package');
			// $this->db->join('city','city.city_id = manage_package.city_id');
			// $this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
			// $this->db->where('manage_package.package_status',1);
			// $this->db->where('manage_package.package_id',$package_add_id);
			// $this->db->order_by('manage_package.package_id', 'DESC');
										  
			// $data['manage_package'] = $this->db->get()->row_array();
				




		$this->load->view(USERHEADER);
		$this->load->view('user/addPackagePurchase',$data);
		$this->load->view(USERFOOTER);

	}
	public function addPackageCart()
	{

		date_default_timezone_set("Asia/Kolkata");

		$curr_timestamp = date("Y-m-d H:i:s");
		$splitTimeStamp = explode(" ",$curr_timestamp);
		$date = $splitTimeStamp[0];
		$time = $splitTimeStamp[1];

        $post = $this->input->post(NULL, true);
		$add_package_array = array(
			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['member'],
			'user_type_id'=>$post['user_type_id'],
			'amount'=>$post['amount'],
			'address'=>$post['address'],
			'package_id'=>$post['package_id'],
			'date'=>$date,
			'time'=>$time
			
		);
		
		if($this->db->insert('cart', $add_package_array))
		{
			// $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Package is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		//redirect(base_url().'AppointmentList');

	}
	
	
	public function member_address_display($user_id="")
    {
    	
     	extract($_POST);

    	$this->db->select('*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$user_id);
         $this->db->where('add_address.status',1);
         $this->db->order_by('add_address.address_id', 'DESC');
		$data['select_address'] = $this->db->get()->result();
		$this->load->view('user/member_address',$data);
		
    }
	
}
