<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
	// public function __construct() {
	// 	parent::__construct();

	// 	if(!$this->Login_model->check_admin_login()){
	// 		redirect(base_url().'admin');
	// 	}	
	// 	$this->load->model('admin/Admindashboard_model');	
	// }
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


		// echo "hii".$this->session->userdata('user')['user_id'];
		// exit;
		
		$this->db->select('balance');
		$this->db->from('user');
		$this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
		$data['user_balance'] = $this->db->get()->row_array();

		$this->db->select('book_package.*,user_type.user_type_name,member.name,manage_package.package_name');
		$this->db->from('book_package');
		$this->db->join('manage_package','book_package.package_id = manage_package.package_id');
		$this->db->join('user_type','user_type.user_type_id = book_package.service_id');
		$this->db->join('member','member.member_id = book_package.patient_id');
		$this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
		//$this->db->where('member.status','1');
		//$this->db->or_where('member.status','0');
		//$this->db->group_by('package_booking.package_id'); 
		$this->db->order_by('book_package.package_id', 'DESC');

									  
		$data['manage_package'] = $this->db->get()->result_array();


		$this->db->select('manage_package.*,city.city,user_type.user_type_name');
		$this->db->from('manage_package');
		$this->db->join('city','city.city_id = manage_package.city_id');
		$this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
		$this->db->where('manage_package.package_status',1);
		$this->db->order_by('manage_package.package_id', 'DESC');
									  
		$data['book_package'] = $this->db->get()->result_array();

		 $date = new DateTime("now");
			$curr_date = $date->format('Y-m-d ');

		$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
		$this->db->from('appointment_book');
		$this->db->join('member','member.member_id = appointment_book.patient_id');
		$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
		//$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','INNER');
		$this->db->where('appointment_book.date',$curr_date);
		$this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
		$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
		//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
		$data['appointment_book'] = $this->db->get()->result_array();





		$this->load->view('user/dashboard',$data);


		//$this->load->view(FOOTER);
	}
	public function todayUserAppointment()
	{
		extract($_POST);
		
		
		// $all_permission = $this->General_model->list_menu();
		

  //       if($all_permission)
  //       {
  //           $this->viewdata['all_permission'] = $all_permission;
  //       }
  //       else
  //       {
  //           $this->viewdata['all_permission'] = '';
  //       }
       
       $date = new DateTime("now");
	   $curr_date = $date->format('Y-m-d');

        if($_POST['id']==1)
        {
  

			$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id');
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
				//$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','INNER');
				$this->db->where('appointment_book.date',$curr_date);
				$this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
				$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
				// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();


        }
        elseif ($_POST['id']==2) {
			$this->db->distinct();
			$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
			$this->db->from('book_nurse');
			$this->db->join('member','member.member_id = book_nurse.patient_id');
			$this->db->join('add_address','add_address.address_id = book_nurse.address_id');
			//$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
			$this->db->where('book_nurse.date',$curr_date);
			$this->db->where('book_nurse.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((book_nurse.responsestatus = 'TXN_SUCCESS' OR book_nurse.responsestatus = 'TXN_PENDING'))");
			//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
			$data['appointment_book_test'] = $this->db->get()->result_array();
        }
        elseif ($_POST['id']==3) {
			$this->db->distinct();
			$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
			$this->db->from('book_laboratory_test');
			$this->db->join('member','member.member_id = book_laboratory_test.patient_id');
			$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id');
			//$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
			$this->db->where('book_laboratory_test.date',$curr_date);
			$this->db->where("((book_laboratory_test.responsestatus = 'TXN_SUCCESS' OR book_laboratory_test.responsestatus = 'TXN_PENDING'))");
			$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);

			// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
			$data['appointment_book_test'] = $this->db->get()->result_array();
        }
        elseif($_POST['id']==4)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
	  //  		$this->db->distinct();
   //      	$this->db->select('book_medicine.*');
			// $this->db->from('book_medicine');
			// $this->db->where('book_medicine.created_date',$curr_date);
			// $data['appointment_book_test'] = $this->db->get()->result_array();

			$this->db->distinct();
       			$this->db->select('book_medicine.*');
				$this->db->from('book_medicine');
				//$this->db->join('assign_appointment','assign_appointment.appointment_id = book_medicine.book_medicine_id','LEFT');
				$this->db->where('book_medicine.created_date',$curr_date);
				$this->db->where('book_medicine.user_id',$this->session->userdata('user')['user_id']);
				// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();
			
			
        }
        elseif($_POST['id']==5)
        {
        	

			$this->db->distinct();
				$this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
				$this->db->from('book_ambulance');
				$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
				//$this->db->join('assign_appointment','assign_appointment.appointment_id = book_ambulance.book_ambulance_id','LEFT');

				$this->db->where('book_ambulance.date',$curr_date);
				$this->db->where("((book_ambulance.responsestatus = 'TXN_SUCCESS' OR book_ambulance.responsestatus = 'TXN_PENDING'))");
				$this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);

				// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				
				$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
				$data['appointment_book_test'] = $this->db->get()->result_array();
			
			
        }
       // $this->load->view('admin/todayAppointment',$data);
		$this->load->view('user/todayUserAppointment',$data);

		
		//echo json_encode($data);
		
		
		
	}
	public function payment_fail()
	{
		$this->load->view('user/error.php');
		//$this->load->view(FOOTER);
	}
}
