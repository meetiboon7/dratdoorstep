<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyPackage extends CI_Controller {

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

		$this->db->select('book_package.*,user_type.user_type_name,member.name,manage_package.package_name');
		$this->db->from('book_package');
		$this->db->join('manage_package','book_package.package_id = manage_package.package_id');
		$this->db->join('user_type','user_type.user_type_id = book_package.service_id');
		$this->db->join('member','member.member_id = book_package.patient_id');
		$this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
		 $this->db->where("((member.status = '0' OR member.status = '1'))");
		//$this->db->where('member.status','1');
		//$this->db->or_where('member.status','0'); 
		$this->db->order_by('book_package.package_id', 'DESC');

									  
		$data['manage_package'] = $this->db->get()->result_array();

		// echo $this->db->last_query();
		// exit;

		$this->load->view(USERHEADER);
		$this->load->view('user/listMyPackage',$data);
		$this->load->view(USERFOOTER);
	}
	
	public function userViewMyPackage()
	{

		$post = $this->input->post(NULL, true);
		
		$package_id = $post['btn_view_mypackage'];

		
		
		// exit;
	//	echo $this->session->userdata('package_data')['package_id'];
		if(isset($post['btn_view_mypackage']))
		{
		
			$this->db->select('book_package.*,user_type.user_type_name,member.name,manage_package.package_name,manage_package.description,city.city');
		    $this->db->from('book_package');
		    $this->db->join('manage_package','book_package.package_id = manage_package.package_id');
		    $this->db->join('user_type','user_type.user_type_id = book_package.service_id');
		    $this->db->join('city','city.city_id = manage_package.city_id');
		    $this->db->join('member','member.member_id = book_package.patient_id');
		    $this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
		    $this->db->where('book_package.book_package_id',$package_id);
		 	$this->db->order_by('book_package.package_id', 'DESC');
			$data['manage_package'] = $this->db->get()->result_array();

			$this->db->select('package_booking.*');
			$this->db->from('package_booking');
			$this->db->where('package_booking.book_package_id',$package_id);
			$data['book_package'] = $this->db->get()->result_array();
			

		}
		else
		{
				$this->db->select('book_package.*,user_type.user_type_name,member.name,manage_package.package_name,manage_package.description,city.city');
			    $this->db->from('book_package');
			    $this->db->join('manage_package','book_package.package_id = manage_package.package_id');
			    $this->db->join('user_type','user_type.user_type_id = book_package.service_id');
			    $this->db->join('city','city.city_id = manage_package.city_id');
			    $this->db->join('member','member.member_id = book_package.patient_id');
			    $this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
			    $this->db->where('book_package.book_package_id',$this->session->userdata('package_data')['book_package_id']);
				$this->db->order_by('book_package.package_id', 'DESC');
				$data['manage_package'] = $this->db->get()->result_array();

				$this->db->select('package_booking.*');
				$this->db->from('package_booking');
				$this->db->where('package_booking.book_package_id',$this->session->userdata('package_data')['book_package_id']);
				$data['book_package'] = $this->db->get()->result_array();

		}
		

		$this->load->view(USERHEADER);
		$this->load->view('user/viewMyPackage',$data);
		$this->load->view(USERFOOTER);

	}
	public function updatePackageBook()
	{
		$post = $this->input->post(NULL, true);
		// print_r($post);
		// exit;
		$package_book = array(
			
			'user_id'=>$this->session->userdata('user')['user_id'],
			'package_id'=>$post['package_id'],
			'service_id'=>$post['user_type_id'],
			'book_package_id'=>$post['book_package_id'],
			'patient_id'=>$post['patient_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			
		);
		
		if($this->db->insert('package_booking',$package_book))
		{
			$datapackege=$this->session->set_userdata('package_data',$package_book);
			
			$available_visit=$post['available_visit']-1;
			
			$this->db->where('book_package_id',$post['book_package_id']);
    		$this->db->update('book_package', array('available_visit' => $available_visit));

	    	 $this->db->select('manage_package.*,city.city,user_type.user_type_name,cart.cart_id,cart.patient_id');
			$this->db->from('manage_package');
			$this->db->join('city','city.city_id = manage_package.city_id');
			$this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
			$this->db->join('cart','cart.package_id = manage_package.package_id');
			$this->db->where('manage_package.package_status',1);
			$this->db->where('manage_package.package_id',$post['package_id']);
			$this->db->order_by('manage_package.package_id', 'DESC');
										  
			$data['manage_package'] = $this->db->get()->row_array();
		
			$this->session->set_flashdata('message','Package is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}
		redirect(base_url().'userViewMyPackage');
		
	}
	
}
