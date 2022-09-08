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
	public function __construct() {
		parent::__construct();

		$this->load->model('admin/Login_model');
		$this->load->model('General_model');
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}	
			
	}

	public function index()
	{


		$all_permission = $this->General_model->list_menu();
		

        if($all_permission)
        {
            $this->viewdata['all_permission'] = $all_permission;
        }
        else
        {
            $this->viewdata['all_permission'] = '';
        }


        //echo $_POST['activeTab'];
       		 $date = new DateTime("now");
			$curr_date = $date->format('Y-m-d ');

			//echo $this->session->userdata('admin_user')['user_type_id'];

			if($this->session->userdata('admin_user')['user_type_id']==1)
			{
				if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        		{
					$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
					$this->db->from('appointment_book');
					$this->db->join('member','member.member_id = appointment_book.patient_id');
					$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','INNER');
					$this->db->where('appointment_book.date',$curr_date);
  					$this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
					//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
				}
				else
				{
					$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
					$this->db->from('appointment_book');
					$this->db->join('member','member.member_id = appointment_book.patient_id');
					$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','INNER');
					$this->db->where('appointment_book.date',$curr_date);
					 $this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
					$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
				}
			}
			elseif($this->session->userdata('admin_user')['user_type_id']==2)
			{
				if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        		{
					$this->db->distinct();
					$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
					$this->db->from('book_nurse');
					$this->db->join('member','member.member_id = book_nurse.patient_id');
					$this->db->join('add_address','add_address.address_id = book_nurse.address_id');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
					$this->db->where('book_nurse.date',$curr_date);
					$this->db->where("((book_nurse.responsestatus = 'TXN_SUCCESS' OR book_nurse.responsestatus = 'TXN_PENDING'))");
					 //$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
				}
				else
				{
					$this->db->distinct();
					$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
					$this->db->from('book_nurse');
					$this->db->join('member','member.member_id = book_nurse.patient_id');
					$this->db->join('add_address','add_address.address_id = book_nurse.address_id');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
					$this->db->where('book_nurse.date',$curr_date);
					$this->db->where("((book_nurse.responsestatus = 'TXN_SUCCESS' OR book_nurse.responsestatus = 'TXN_PENDING'))");
					 $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
				}
				// echo $this->db->last_query();
				// exit;
			}
       		elseif($this->session->userdata('admin_user')['user_type_id']==3)
       		{
       			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        		{
	       			$this->db->distinct();
	       			$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
					$this->db->from('book_laboratory_test');
					$this->db->join('member','member.member_id = book_laboratory_test.patient_id');
					$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id');
					$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
					$this->db->where('book_laboratory_test.date',$curr_date);
					$this->db->where("((book_laboratory_test.responsestatus = 'TXN_SUCCESS' OR book_laboratory_test.responsestatus = 'TXN_PENDING'))");
					 //$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
				}
				else
				{

					$this->db->distinct();
	       			$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
					$this->db->from('book_laboratory_test');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
					$this->db->join('member','member.member_id = book_laboratory_test.patient_id');
					$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id');
					$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
					$this->db->where('book_laboratory_test.date',$curr_date);
					$this->db->where("((book_laboratory_test.responsestatus = 'TXN_SUCCESS' OR book_laboratory_test.responsestatus = 'TXN_PENDING'))");
					 $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
					// echo $this->db->last_query();
					// exit;
				}

       		}
       		elseif($this->session->userdata('admin_user')['user_type_id']==4)
       		{
       			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        		{
	       			$this->db->distinct();
	       			$this->db->select('book_medicine.*');
					$this->db->from('book_medicine');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_medicine.book_medicine_id','LEFT');
					$this->db->where('book_medicine.created_date',$curr_date);
					// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
				}
				else
				{
					$this->db->distinct();
	       			$this->db->select('book_medicine.*');
					$this->db->from('book_medicine');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_medicine.book_medicine_id','LEFT');
					$this->db->where('book_medicine.created_date',$curr_date);
					$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
				}
       		}
       		elseif($this->session->userdata('admin_user')['user_type_id']==5)
       		{
       			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        		{

	       			$this->db->distinct();
					$this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
					$this->db->from('book_ambulance');
					$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_ambulance.book_ambulance_id','LEFT');
					$this->db->where('book_ambulance.date',$curr_date);
					$this->db->where("((book_ambulance.responsestatus = 'TXN_SUCCESS' OR book_ambulance.responsestatus = 'TXN_PENDING'))");
					$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
					//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
				}
				else
				{
					$this->db->distinct();
					$this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
					$this->db->from('book_ambulance');
					$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_ambulance.book_ambulance_id','LEFT');
					$this->db->where('book_ambulance.date',$curr_date);
					$this->db->where("((book_ambulance.responsestatus = 'TXN_SUCCESS' OR book_ambulance.responsestatus = 'TXN_PENDING'))");
					$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
					$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					$data['appointment_book'] = $this->db->get()->result_array();
				}

       		}

       		elseif($this->session->userdata('admin_user')['user_type_id']==6)
       		{
       			
       			$city_id=$this->session->userdata('admin_user')['city_permission'];
       			$city_permission=explode(',', $city_id);
       			$this->db->select('appointment_book.*,member.contact_no,member.name,member.city_id,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id');
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
				$this->db->where('appointment_book.date',$curr_date);
				$this->db->where_in('member.city_id',$city_permission);
				$this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
				$data['appointment_book'] = $this->db->get()->result_array();

				
				

       		}
       		else
       		{
       			$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id');
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
				$this->db->where('appointment_book.date',$curr_date);
				//$this->db->where('appointment_book.responsestatus',"TXN_SUCCESS");
				  $this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
				//$this->db->or_where('appointment_book.responsestatus',"TXN_PENDING");
				$data['appointment_book'] = $this->db->get()->result_array();

       		}
			

			$this->db->select('package_booking.*,member.contact_no,member.name');
			$this->db->from('package_booking');
			$this->db->join('member','member.member_id = package_booking.patient_id');
			$this->db->where('package_booking.date',$curr_date);
			$data['package_appointment_book'] = $this->db->get()->result_array();
       	
       		$this->db->select('*');
			$this->db->from('holidays');
			$this->db->where('hdate',$curr_date);
			
			$this->db->order_by('hid', 'DESC');
										  
			$data['all_holiday'] = $this->db->get()->result_array();
       

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/dashboard',$data);
		$this->load->view(FOOTER);
	}
	public function todayAppointment()
	{
		extract($_POST);
		

		$all_permission = $this->General_model->list_menu();
		

        if($all_permission)
        {
            $this->viewdata['all_permission'] = $all_permission;
        }
        else
        {
            $this->viewdata['all_permission'] = '';
        }
       
       $date = new DateTime("now");
	   $curr_date = $date->format('Y-m-d');

        if($_POST['id']==1)
        {
   //      	$this->db->distinct();
   //      	$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
			// $this->db->from('appointment_book');
			// $this->db->join('member','member.member_id = appointment_book.patient_id');
			// $this->db->join('add_address','add_address.address_id = appointment_book.address_id');
			// $this->db->where('appointment_book.date',$curr_date);
			//  $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
			// $data['appointment_book_test']= $this->db->get()->result_array();
			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
			{
				$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id');
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','LEFT');
				$this->db->where('appointment_book.date',$curr_date);
				  $this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
				// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();


			}
			elseif($this->session->userdata('admin_user')['user_type_id']==6)
			{
				$city_id=$this->session->userdata('admin_user')['city_permission'];
       			$city_permission=explode(',', $city_id);
       			$this->db->select('appointment_book.*,member.contact_no,member.name,member.city_id,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id');
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
				$this->db->where('appointment_book.date',$curr_date);
				$this->db->where_in('member.city_id',$city_permission);
				$this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
				$data['appointment_book_test'] = $this->db->get()->result_array();


			}
			else
			{
				$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id');
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','LEFT');
				$this->db->where('appointment_book.date',$curr_date);
				  $this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
				 $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();
			}

       			


				
				

       		

				


        }
        elseif ($_POST['id']==2) {

        	if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
			{
				$this->db->distinct();
				$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('book_nurse');
				$this->db->join('member','member.member_id = book_nurse.patient_id');
				$this->db->join('add_address','add_address.address_id = book_nurse.address_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
				$this->db->where('book_nurse.date',$curr_date);
				  $this->db->where("((book_nurse.responsestatus = 'TXN_SUCCESS' OR book_nurse.responsestatus = 'TXN_PENDING'))");
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();
			}
			elseif($this->session->userdata('admin_user')['user_type_id']==6)
			{
				$city_id=$this->session->userdata('admin_user')['city_permission'];
       			$city_permission=explode(',', $city_id);

				$this->db->distinct();
				$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('book_nurse');
				$this->db->join('member','member.member_id = book_nurse.patient_id');
				$this->db->join('add_address','add_address.address_id = book_nurse.address_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
				 $this->db->where_in('member.city_id',$city_permission);
				  $this->db->where('book_nurse.date',$curr_date);
				$this->db->where("((book_nurse.responsestatus = 'TXN_SUCCESS' OR book_nurse.responsestatus = 'TXN_PENDING'))");
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();

				

			}
			else
			{
				$this->db->distinct();
				$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('book_nurse');
				$this->db->join('member','member.member_id = book_nurse.patient_id');
				$this->db->join('add_address','add_address.address_id = book_nurse.address_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
				$this->db->where('book_nurse.date',$curr_date);
				$this->db->where("((book_nurse.responsestatus = 'TXN_SUCCESS' OR book_nurse.responsestatus = 'TXN_PENDING'))");
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();
			}
			// echo $this->db->last_query();
			// 	exit;
        }
        elseif ($_POST['id']==3) {


        	if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
			{
				$this->db->distinct();
				$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
				$this->db->from('book_laboratory_test');
				$this->db->join('member','member.member_id = book_laboratory_test.patient_id');
				$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id');
				$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
				$this->db->where('book_laboratory_test.date',$curr_date);
				$this->db->where("((book_laboratory_test.responsestatus = 'TXN_SUCCESS' OR book_laboratory_test.responsestatus = 'TXN_PENDING'))");
				// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();
			}
			elseif($this->session->userdata('admin_user')['user_type_id']==6)
			{
				$city_id=$this->session->userdata('admin_user')['city_permission'];
       			$city_permission=explode(',', $city_id);

				$this->db->distinct();
				$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
				$this->db->from('book_laboratory_test');
				$this->db->join('member','member.member_id = book_laboratory_test.patient_id');
				$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id');
				$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
				$this->db->where('book_laboratory_test.date',$curr_date);
				 $this->db->where_in('member.city_id',$city_permission);
				$this->db->where("((book_laboratory_test.responsestatus = 'TXN_SUCCESS' OR book_laboratory_test.responsestatus = 'TXN_PENDING'))");
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();
				// echo $this->db->last_query();
				// exit;

				

			}
			else
			{
				$this->db->distinct();
				$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
				$this->db->from('book_laboratory_test');
				$this->db->join('member','member.member_id = book_laboratory_test.patient_id');
				$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id');
				$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
				$this->db->where('book_laboratory_test.date',$curr_date);
				$this->db->where("((book_laboratory_test.responsestatus = 'TXN_SUCCESS' OR book_laboratory_test.responsestatus = 'TXN_PENDING'))");
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();
			}
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
        	if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
			{
					$this->db->distinct();
	       			$this->db->select('book_medicine.*');
					$this->db->from('book_medicine');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_medicine.book_medicine_id','LEFT');
					$this->db->where('book_medicine.created_date',$curr_date);
					// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					 $data['appointment_book_test'] = $this->db->get()->result_array();
				// echo $this->db->last_query();
				// exit;
			}
			else
			{
					$this->db->distinct();
	       			$this->db->select('book_medicine.*');
					$this->db->from('book_medicine');
					$this->db->join('assign_appointment','assign_appointment.appointment_id = book_medicine.book_medicine_id','LEFT');
					$this->db->where('book_medicine.created_date',$curr_date);
					 $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
					 $data['appointment_book_test'] = $this->db->get()->result_array();
			}
			
        }
        elseif($_POST['id']==5)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
   //      	$this->db->select('book_ambulance.*');
			// $this->db->from('book_ambulance');
			// $this->db->where('book_ambulance.date',$curr_date);
			// $data['appointment_book_test'] = $this->db->get()->result_array();

			// $this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
			// $this->db->from('book_ambulance');
			// $this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
			// $this->db->where('book_ambulance.date',$curr_date);
			// $this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
			// $data['appointment_book_test'] = $this->db->get()->result_array();
			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
			{
				$this->db->distinct();
				$this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
				$this->db->from('book_ambulance');
				$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_ambulance.book_ambulance_id','LEFT');

				$this->db->where('book_ambulance.date',$curr_date);
				$this->db->where("((book_ambulance.responsestatus = 'TXN_SUCCESS' OR book_ambulance.responsestatus = 'TXN_PENDING'))");
				// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				
				$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
				$data['appointment_book_test'] = $this->db->get()->result_array();
			}
			elseif($this->session->userdata('admin_user')['user_type_id']==6)
			{
				$city_id=$this->session->userdata('admin_user')['city_permission'];
       			$city_permission=explode(',', $city_id);

				$this->db->distinct();
				$this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
				$this->db->from('book_ambulance');
				$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_ambulance.book_ambulance_id','LEFT');

				$this->db->where('book_ambulance.date',$curr_date);
				$this->db->where("((book_ambulance.responsestatus = 'TXN_SUCCESS' OR book_ambulance.responsestatus = 'TXN_PENDING'))");
				$this->db->where_in('member.city_id',$city_permission);
				// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				
				$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book_test'] = $this->db->get()->result_array();
				

				

			}
			else
			{
				$this->db->distinct();
				$this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
				$this->db->from('book_ambulance');
				$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_ambulance.book_ambulance_id','LEFT');

				$this->db->where('book_ambulance.date',$curr_date);
				$this->db->where("((book_ambulance.responsestatus = 'TXN_SUCCESS' OR book_ambulance.responsestatus = 'TXN_PENDING'))");
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				
				$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
				$data['appointment_book_test'] = $this->db->get()->result_array();

			}



				
			
			
        }

       // $this->load->view('admin/todayAppointment',$data);
		$this->load->view('admin/todayAppointment',$data);

		
		//echo json_encode($data);
		
		
		
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
		$this->load->view('admin/member_address',$data);
		
    }

}
