<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class AppointmentList extends GeneralController {

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
		$this->load->model('admin/City_model');	
		$this->load->model('admin/Login_model');
		$this->load->model('General_model');
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}

	}

	public function index()
	{
		parent::index();

		
		 $date = new DateTime("now");
	     $curr_date = $date->format('Y-m-d');

	    if($this->session->userdata('admin_user')['user_type_id']==1)
		{
			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        	{
			    $this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id','LEFT');
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id',"LEFT");
				$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','LEFT');
				$this->db->where('appointment_book.date >=',$curr_date);
				$this->db->order_by('appointment_book.date', 'DESC');
					$this->db->limit(500);  
				//$this->db->where('assign_appointment.emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book']= $this->db->get()->result_array();
			}
			else
			{
				$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id','LEFT');
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id',"LEFT");
				$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','LEFT');
				//$this->db->where('appointment_book.date >=',$curr_date);
				$this->db->where('assign_appointment.emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('appointment_book.date', 'DESC');
					$this->db->limit(500); 
				$data['appointment_book']= $this->db->get()->result_array();
			}
			//$this->db->where('appointment_book.confirm',1);
			//$this->db->where('appointment_book.user_id',$this->session->userdata('admin_user')['user_id']);
		}
		elseif($this->session->userdata('admin_user')['user_type_id']==2)
		{
			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        	{
				$this->db->distinct();
				$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('book_nurse');
				$this->db->join('member','member.member_id = book_nurse.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = book_nurse.address_id',"LEFT");
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
				//$this->db->where('book_nurse.date >=',$curr_date);
				$this->db->order_by('book_nurse.date', 'DESC');
				//$this->db->where('book_nurse.confirm',1);
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book'] = $this->db->get()->result_array();
			}
			else
			{
				$this->db->distinct();
				$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('book_nurse');
				$this->db->join('member','member.member_id = book_nurse.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = book_nurse.address_id',"LEFT");
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
				//$this->db->where('book_nurse.date >=',$curr_date);
				//$this->db->where('book_nurse.confirm',1);
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('book_nurse.date', 'DESC');
				$data['appointment_book'] = $this->db->get()->result_array();
			}
		}
		elseif($this->session->userdata('admin_user')['user_type_id']==3)
		{
			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        	{

				$this->db->distinct();
				$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
				$this->db->from('book_laboratory_test');
				$this->db->join('member','member.member_id = book_laboratory_test.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id',"LEFT");
				$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
				//$this->db->where('book_laboratory_test.date >=',$curr_date);
				$this->db->order_by('book_laboratory_test.date', 'DESC');
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				//$this->db->where('book_laboratory_test.confirm',1);

				$data['appointment_book'] = $this->db->get()->result_array();
			}
			else
			{
				
				$this->db->distinct();
				$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
				$this->db->from('book_laboratory_test');
				$this->db->join('member','member.member_id = book_laboratory_test.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id',"LEFT");
				$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
				//$this->db->where('book_laboratory_test.date >=',$curr_date);
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('book_laboratory_test.date', 'DESC');
				//$this->db->where('book_laboratory_test.confirm',1);

				$data['appointment_book'] = $this->db->get()->result_array();
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
				//$this->db->where('book_medicine.created_date >=',$curr_date);
				$this->db->order_by('book_medicine.created_date', 'DESC');
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book'] = $this->db->get()->result_array();
			}
			else
			{
				$this->db->distinct();
				$this->db->select('book_medicine.*');
				$this->db->from('book_medicine');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_medicine.book_medicine_id','LEFT');
				//$this->db->where('book_medicine.created_date >=',$curr_date);
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
				//$this->db->where('book_ambulance.date >=',$curr_date);
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('book_ambulance.date', 'DESC');
				$data['appointment_book'] = $this->db->get()->result_array();
			}
			else
			{
				$this->db->distinct();
				$this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
				$this->db->from('book_ambulance');
				$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_ambulance.book_ambulance_id','LEFT');
				//$this->db->where('book_ambulance.date >=',$curr_date);
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('book_ambulance.date', 'DESC');
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
				//$this->db->where('appointment_book.date',$curr_date);
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
				//$this->db->where('appointment_book.date >=',$curr_date);
				$this->db->order_by('appointment_book.date', 'DESC');
				$this->db->limit(500); 
				$data['appointment_book'] = $this->db->get()->result_array();
   		}
			// echo $this->db->last_query();
			// exit;

			$this->db->select('*');
			$this->db->from('manage_team');
			$this->db->where('team_status',1);
			$data['manage_team_assign']= $this->db->get()->result_array();

			$this->db->select('employee_master.*,user_type.user_type_name');
			$this->db->from('employee_master');
			$this->db->join('user_type','user_type.user_type_id = employee_master.user_type_id','LEFT');
			$this->db->where('employee_master.emp_status',1);
			$data['manage_employee_assign']= $this->db->get()->result_array();

		   $this->load->view(HEADER,$this->viewdata);
	       $this->load->view('admin/appointmentList',$data);
		   $this->load->view(FOOTER);
	}
	public function allAppointment()
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
	    
	    $admin = $this->session->userdata('admin_user')['role_id'];

        $login_user_id = $this->session->userdata('admin_user')['user_type_id'];
        $front_office = $this->session->userdata('admin_user')['user_type_id'];
        $manager = $this->session->userdata('admin_user')['user_type_id'];
        $dr_admin = $this->session->userdata('admin_user')['user_type_id'];
        $ambulance = $this->session->userdata('admin_user')['user_type_id'];

        if($_POST['id']==1)
        {
        	if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        	{
        		$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id',"LEFT");
				$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','LEFT');
				//$this->db->where('appointment_book.date >=',$curr_date);
				$this->db->order_by('appointment_book.date', 'DESC');
				$this->db->limit(500);  

				//$this->db->where('appointment_book.confirm',1);
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book']= $this->db->get()->result_array();
        	}
        	elseif($this->session->userdata('admin_user')['user_type_id']==6)
			{
				$city_id=$this->session->userdata('admin_user')['city_permission'];
       			$city_permission=explode(',', $city_id);
       			$this->db->select('appointment_book.*,member.contact_no,member.name,member.city_id,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id');
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id');
				//$this->db->where('appointment_book.date >=',$curr_date);
				$this->db->where_in('member.city_id',$city_permission);
				$this->db->where("((appointment_book.responsestatus = 'TXN_SUCCESS' OR appointment_book.responsestatus = 'TXN_PENDING'))");
				$this->db->limit(500);
				$data['appointment_book'] = $this->db->get()->result_array();
				

				

			}
        	else
        	{
        		$this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('appointment_book');
				$this->db->join('member','member.member_id = appointment_book.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = appointment_book.address_id',"LEFT");
				$this->db->join('assign_appointment','assign_appointment.appointment_id = appointment_book.appointment_book_id','LEFT');
				//$this->db->where('appointment_book.date >=',$curr_date);

				//$this->db->where('appointment_book.confirm',1);
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('appointment_book.date', 'DESC');
				$this->db->limit(500);
				$data['appointment_book']= $this->db->get()->result_array();

        	}
        	

		
			$this->db->select('*');
			$this->db->from('manage_team');
			$this->db->where('team_status',1);
			$data['manage_team_assign']= $this->db->get()->result_array();



			$this->db->select('employee_master.*,user_type.user_type_name');
			$this->db->from('employee_master');
			$this->db->join('user_type','user_type.user_type_id = employee_master.user_type_id','LEFT');
			$this->db->where('employee_master.emp_status',1);
			$data['manage_employee_assign']= $this->db->get()->result_array();

        }
        elseif ($_POST['id']==2) {

        	if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
        	{
        	   // echo "Hii";
        		
				/*$this->db->distinct();
				$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('book_nurse');
				$this->db->join('member','member.member_id = book_nurse.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = book_nurse.address_id',"LEFT");
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
				//$this->db->where('book_nurse.date >=',$curr_date);
				$this->db->order_by('book_nurse.date', 'DESC');
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				//$this->db->where('book_nurse.confirm',1);
				$data['appointment_book'] = $this->db->get()->result_array();*/
				
					$this->db->distinct();
				$this->db->select('book_nurse.book_nurse_id,book_nurse.date,book_nurse.time,book_nurse.responsestatus,book_nurse.cancel,book_nurse.confirm,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('book_nurse');
				$this->db->join('member','member.member_id = book_nurse.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = book_nurse.address_id',"LEFT");
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
				//$this->db->where('book_nurse.date >=',$curr_date);
				$this->db->order_by('book_nurse.date', 'DESC');
				$this->db->limit(500);
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				//$this->db->where('book_nurse.confirm',1);
				$data['appointment_book'] = $this->db->get()->result_array();
			//	echo $this->db->last_query();
        	}
        	elseif($this->session->userdata('admin_user')['user_type_id']==6)
			{
			    
			   // echo "Hii123";
				$city_id=$this->session->userdata('admin_user')['city_permission'];
       			$city_permission=explode(',', $city_id);

				$this->db->distinct();
				$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('book_nurse');
				$this->db->join('member','member.member_id = book_nurse.patient_id');
				$this->db->join('add_address','add_address.address_id = book_nurse.address_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
				 $this->db->where_in('member.city_id',$city_permission);
				  //$this->db->where('book_nurse.date>=',$curr_date);
				$this->db->where("((book_nurse.responsestatus = 'TXN_SUCCESS' OR book_nurse.responsestatus = 'TXN_PENDING'))");
				$this->db->limit(500);
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book'] = $this->db->get()->result_array();
				// echo $this->db->last_query();
				// exit;

				

			}
        	else
        	{
        	   // echo "12232323";
        		$this->db->distinct();
				$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
				$this->db->from('book_nurse');
				$this->db->join('member','member.member_id = book_nurse.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = book_nurse.address_id',"LEFT");
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_nurse.book_nurse_id','LEFT');
				//$this->db->where('book_nurse.date >=',$curr_date);
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('book_nurse.date', 'DESC');
                $this->db->limit(500);
				//$this->db->where('book_nurse.confirm',1);
				$data['appointment_book'] = $this->db->get()->result_array();
				echo $this->db->last_query();

        	}

			

			$this->db->select('*');
			$this->db->from('manage_team');
			$this->db->where('team_status',1);
			$data['manage_team_assign']= $this->db->get()->result_array();



			$this->db->select('employee_master.*,user_type.user_type_name');
			$this->db->from('employee_master');
			$this->db->join('user_type','user_type.user_type_id = employee_master.user_type_id','LEFT');
			$this->db->where('employee_master.emp_status',1);
			$data['manage_employee_assign']= $this->db->get()->result_array();

        }
        elseif ($_POST['id']==3) {


			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
			{
			
			$this->db->distinct();
		//	$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
			$this->db->select('book_laboratory_test.book_laboratory_test_id,book_laboratory_test.date,book_laboratory_test.time,book_laboratory_test.responsestatus,book_laboratory_test.cancel,book_laboratory_test.confirm,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
			$this->db->from('book_laboratory_test');
			$this->db->join('member','member.member_id = book_laboratory_test.patient_id',"LEFT");
			$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id',"LEFT");
			$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
			$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
			//$this->db->where('book_laboratory_test.date >=',$curr_date);
			$this->db->order_by('book_laboratory_test.date', 'DESC');
			$this->db->limit(500);

			//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
			//$this->db->where('book_laboratory_test.confirm',1);

			$data['appointment_book'] = $this->db->get()->result_array();
			}
			elseif($this->session->userdata('admin_user')['user_type_id']==6)
			{
				$city_id=$this->session->userdata('admin_user')['city_permission'];
       			$city_permission=explode(',', $city_id);

				$this->db->distinct();
			//	$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
			    $this->db->select('book_laboratory_test.book_laboratory_test_id,book_laboratory_test.date,book_laboratory_test.time,book_laboratory_test.responsestatus,book_laboratory_test.cancel,book_laboratory_test.confirm,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
				$this->db->from('book_laboratory_test');
				$this->db->join('member','member.member_id = book_laboratory_test.patient_id');
				$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id');
				$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
				//$this->db->where('book_laboratory_test.date>=',$curr_date);
				 $this->db->where_in('member.city_id',$city_permission);
				$this->db->where("((book_laboratory_test.responsestatus = 'TXN_SUCCESS' OR book_laboratory_test.responsestatus = 'TXN_PENDING'))");
				$this->db->limit(500);
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book'] = $this->db->get()->result_array();
				// echo $this->db->last_query();
				// exit;

				

			}
			else
			{
				$this->db->distinct();
			//	$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
			$this->db->select('book_laboratory_test.book_laboratory_test_id,book_laboratory_test.date,book_laboratory_test.time,book_laboratory_test.responsestatus,book_laboratory_test.cancel,book_laboratory_test.confirm,member.contact_no,member.name,add_address.address_1,add_address.address_2,lab_test_type.lab_test_type_name');
				$this->db->from('book_laboratory_test');
				$this->db->join('member','member.member_id = book_laboratory_test.patient_id',"LEFT");
				$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id',"LEFT");
				$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
				//$this->db->where('book_laboratory_test.date >=',$curr_date);
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('book_laboratory_test.date', 'DESC');
				$this->db->limit(500);

				//$this->db->where('book_laboratory_test.confirm',1);

				$data['appointment_book'] = $this->db->get()->result_array();
			}
			

			$this->db->select('*');
			$this->db->from('manage_team');
			$this->db->where('team_status',1);
			$data['manage_team_assign']= $this->db->get()->result_array();



			$this->db->select('employee_master.*,user_type.user_type_name');
			$this->db->from('employee_master');
			$this->db->join('user_type','user_type.user_type_id = employee_master.user_type_id','LEFT');
			$this->db->where('employee_master.emp_status',1);
			$data['manage_employee_assign']= $this->db->get()->result_array();

        }
        elseif($_POST['id']==4)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
	   		if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
			{
		   		$this->db->distinct();
	        	$this->db->select('book_medicine.*');
				$this->db->from('book_medicine');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_medicine.book_medicine_id','LEFT');
				//$this->db->where('book_medicine.created_date >=',$curr_date);
				$this->db->order_by('book_medicine.created_date', 'DESC');
				//$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$data['appointment_book'] = $this->db->get()->result_array();
			}
			else
			{
				$this->db->distinct();
	        	$this->db->select('book_medicine.*');
				$this->db->from('book_medicine');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_medicine.book_medicine_id','LEFT');
				//$this->db->where('book_medicine.created_date >=',$curr_date);
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('book_medicine.created_date', 'DESC');
				$data['appointment_book'] = $this->db->get()->result_array();
			}

			
			$this->db->select('*');
			$this->db->from('manage_team');
			$this->db->where('team_status',1);
			$data['manage_team_assign']= $this->db->get()->result_array();



			$this->db->select('employee_master.*,user_type.user_type_name');
			$this->db->from('employee_master');
			$this->db->join('user_type','user_type.user_type_id = employee_master.user_type_id','LEFT');
			$this->db->where('employee_master.emp_status',1);
			$data['manage_employee_assign']= $this->db->get()->result_array();

			
        }
        elseif($_POST['id']==5)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
   //      	$this->db->select('book_ambulance.*');
			// $this->db->from('book_ambulance');
			// $this->db->where('book_ambulance.date >=',$curr_date);
			if($this->session->userdata('admin_user')['emp_id']==-1 || $this->session->userdata('admin_user')['user_type_id']==8 || $this->session->userdata('admin_user')['user_type_id']==7)
			{
				$this->db->distinct();
				$this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
				$this->db->from('book_ambulance');
				$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
				$this->db->join('assign_appointment','assign_appointment.appointment_id = book_ambulance.book_ambulance_id','LEFT');
			//	$this->db->where('book_ambulance.date >=',$curr_date);
				// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('book_ambulance.date', 'DESC');
				$this->db->limit(500);
				$data['appointment_book'] = $this->db->get()->result_array();
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

				//$this->db->where('book_ambulance.date',$curr_date);
				$this->db->where("((book_ambulance.responsestatus = 'TXN_SUCCESS' OR book_ambulance.responsestatus = 'TXN_PENDING'))");
				$this->db->where_in('member.city_id',$city_permission);
				// $this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				
				$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
				$this->db->limit(500);
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
				//$this->db->where('book_ambulance.date >=',$curr_date);
				$this->db->where('emp_id',$this->session->userdata('admin_user')['emp_id']);
				$this->db->order_by('book_ambulance.date', 'DESC');
				$this->db->limit(500);
				$data['appointment_book'] = $this->db->get()->result_array();
			}
        	

			$this->db->select('*');
			$this->db->from('manage_team');
			$this->db->where('team_status',1);
			$data['manage_team_assign']= $this->db->get()->result_array();



            $this->db->select('employee_master.*,user_type.user_type_name');
			$this->db->from('employee_master');
			$this->db->join('user_type','user_type.user_type_id = employee_master.user_type_id','LEFT');
			$this->db->where('employee_master.emp_status',1);
			$data['manage_employee_assign']= $this->db->get()->result_array();

			
			
        }
        elseif($_POST['id'] == 6){

             if($admin == '-1' || $dr_admin == '6' ||$front_office == '7' || $manager == '8')
            {
                $this->db->select('package_booking.*,manage_package.package_name,user_type.user_type_name,member.name, book_package.confirm, book_package.responsestatus, book_package.book_package_id,book_package.address_id,add_address.address_id,add_address.address_1,add_address.address_2,book_package.responsestatus');
                $this->db->from('package_booking');
                $this->db->join('book_package','book_package.book_package_id = package_booking.book_package_id');
                $this->db->join('manage_package','manage_package.package_id = package_booking.package_id');
                $this->db->join('user_type','user_type.user_type_id = package_booking.service_id');
                $this->db->join('member','member.member_id = package_booking.patient_id');
                $this->db->join('add_address','add_address.address_id = book_package.address_id');
                //$this->db->where('package_booking.service_id',$login_user_id);
                $this->db->order_by('package_booking.id', 'DESC');                        
                $data['appointment_book'] = $this->db->get()->result_array();

                // echo $this->db->last_query();
                // exit;
            }
            else
            {
                // echo "Hello";
                // exit;
                $this->db->select('package_booking.*,manage_package.package_name,user_type.user_type_name,member.name');
                $this->db->from('package_booking');
                $this->db->join('manage_package','manage_package.package_id = package_booking.package_id');
                $this->db->join('user_type','user_type.user_type_id = package_booking.service_id');
                $this->db->join('member','member.member_id = package_booking.patient_id');
                $this->db->where('package_booking.service_id',$login_user_id);
                $this->db->order_by('package_booking.id', 'DESC');                        
                $data['appointment_book'] = $this->db->get()->result_array();
            }

            $this->db->select('*');
            $this->db->from('manage_team');
            $this->db->where('team_status', 1);
            $data['manage_team_assign'] = $this->db->get()->result_array();

            $this->db->select('employee_master.*,user_type.user_type_name');
            $this->db->from('employee_master');
            $this->db->join('user_type', 'user_type.user_type_id = employee_master.user_type_id', 'LEFT');
            $this->db->where('employee_master.emp_status', 1);
            $data['manage_employee_assign'] = $this->db->get()->result_array();

            

        }
         $data['service_id']=$_POST['id'];
       // $this->load->view('admin/todayAppointment',$data);
		$this->load->view('admin/listAppointment',$data);

		
		//echo json_encode($data);
		
		
		
	}
	public function addDoctorAppointment()
	{
		parent::index();
		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id,user_type_id');
		$this->db->from('user');
		$this->db->where('user_type_id',99);
		$this->db->or_where('user_type_id',0);
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();
		
	//	echo $this->db->last_query();exit;

		$data['doctor_type'] = $this->db->get_where('doctor_type', array('d_status'=>1))->result_array();
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/addDoctorAppointment',$data);
		$this->load->view(FOOTER);
	}
	 public function member_list_display($user_id="")
    {
    	
    	extract($_POST);

    	$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$user_id);
         $this->db->where('member.status',1);
        
        $this->db->order_by('member.user_id', 'DESC');
		$data['select_member'] = $this->db->get()->result();
		$this->load->view('admin/member_display',$data);
		
    }
    public function insertDoctorAppointment()
    {

    	$post = $this->input->post(NULL, true);
    	$payment_type        = $post['payment_type'];
    	if($payment_type == 'card')
    	{
    		$transdatetime='';
    		$responsestatus='TXN_PENDING';
    		$paid_flag='0';
		 
		}
		else if($payment_type == 'Cash')
		{
		  
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';
		  
		}
		else if($payment_type == 'Cheque')
		{
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';

		}
		else if($payment_type == 'NEFT')
		{
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';

		}
		else if($payment_type == 'UPI')
		{
		   $transdatetime='';
		   $responsestatus='TXN_PENDING';
		   $paid_flag='0';

		}
		else if($payment_type == 'Paytm')
		{
		   $transdatetime='';
		   $responsestatus='TXN_PENDING';
		   $paid_flag='0';

		}

		if($post['bank_name']!=''){

			$bank_name       = $_POST['bank_name'];
		}
		else{
			$bank_name="";
		}
		
		$doctor_appointment_array = array(
			'user_id'=>$post['user_id'],
			'patient_id'=>$post['patient_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'doctor_type_id'=>$post['d_type_id'],
			'city_name' => $post['city_name'],
			'address_id'=>$post['address_id'],
			'total'=>$post['amount'],
			'confirm'=>1,
			'responsestatus'=>$responsestatus,
			'txndate'=>$transdatetime,
			'gatewayname'=>$payment_type,
			'booked_by'=>$this->session->userdata('admin_user')['user_id'],
			'paid_flag'=>$paid_flag,
			'bankname'=>$bank_name,
			//'responsestatus'=>TXN_SUCCESS
			'type_of_teleconsulting' => $post['type_of_teleconsulting'],
			
			
		);
		
		if($this->db->insert('appointment_book', $doctor_appointment_array))
		{
			 $insert_id = $this->db->insert_id();

			 								// $this->db->select('*');
            //                             $this->db->from('appointment_book');
            //                             $this->db->where('order_id',$_POST['ORDERID']);
            //                             $this->db->where('user_id',$MERC_UNQ_REF[0]);
            //                             $this->db->where('patient_id',$patient_id);
            //                             $this->db->where('date',$date);
            //                             $appointment_data = $this->db->get()->result_array();
            //                             foreach($appointment_data as $appointment){

            //                                  $docapmt_id = $appointment['appointment_book_id'];
            //                             }



                                        $this->db->select('*');
                                        $this->db->from('doctor_type');
                                        $this->db->where('doctor_type.d_type_id',$post['d_type_id']);
                                        $doctor_type = $this->db->get()->result_array();
                                        foreach($doctor_type as $doctor){

                                             $typedoc = $doctor['doctor_type_name'];
                                        }

                                        $extra_invoice = array(
                                                'list'=>$typedoc." Doctor visit",
                                                'price'=>$post['amount'],
                                                'patient_id'=>$post['patient_id'],
                                                'user_id'=>$post['user_id'],
                                                'doctor_id'=>60,
                                                'appointment_book_id'=>$insert_id ,
                                                'date'=>date('Y-m-d H:i:s'),
                                                //'discount'=>0,
                                                //'voucher'=>'',
                                                //'credit'=>0,
                                                'type'=>$payment_type,
                                               // 'txnid'=>0.00,
                                                //'devicetype'=> '',
                                                'appmt_date'=>$post['date'],
                                                //'order_id'=>$_POST['ORDERID'],
                                                //'no_of_days'=>0,
                                                'time'=>$post['date'],
                                                //'reference_id'=>'',
                                            );
                                            $this->db->insert("extra_invoice",$extra_invoice);

                                            


			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Doctor Appointment is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminDashboard');
    }

    //Nurse

    public function addNurseAppointment()
	{
		
		parent::index();
		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('admin_user')['user_id']);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

// 		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
// 		$this->db->from('user');
// 		$this->db->order_by('user.user_id', 'DESC');
// 		$data['user'] = $this->db->get()->result_array();
        $this->db->select('user.first_name,user.last_name,user.mobile,user.user_id,user_type_id');
		$this->db->from('user');
		$this->db->where('user_type_id',99);
		$this->db->or_where('user_type_id',0);
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();
		

		$data['nurse_service_type'] = $this->db->get_where('nurse_service_type', array('n_status'=>1))->result_array();
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/addNurseAppointment',$data);
		$this->load->view(FOOTER);
	}

	public function insertNurseAppointment()
    {
    	
    	$post = $this->input->post(NULL, true);

		// $this->db->select('city_id');
  //       $this->db->from('member');
  //       $this->db->where('member_id',$post['patient_id']);
        
  //       $member_data = $this->db->get()->result_array();
  //       foreach($member_data as $member){

  //                    $city_id = $member['city_id'];
                     
  //       }

       
  //       $this->db->select('*');
  //       $this->db->from('manage_fees');
      
  //       $this->db->where('manage_fees.submenu_type_id',$post['nurse_service_id']);
  //       $this->db->where('manage_fees.service_id',2);
  //        $this->db->where('manage_fees.city_id',$city_id);
  //       $fees_nurse = $this->db->get()->result_array();

  //       foreach($fees_nurse as $nurse){

  //            $amount = $nurse['fees_name'];
            

  //            $type_name = $nurse['nurse_service_name'];
		// }
                                
       
	     if($post['nurse_service_id']== 2){
	     	
	        $amount= $post['amount'] * $post['days'];
	     }
	     else
	     {
	     	$amount=$post['amount'];
	     }

	     if($post['bank_name']!=''){

			$bank_name       = $_POST['bank_name'];
		}
		else{
			$bank_name="";
		}

    	$payment_type        = $post['payment_type'];
    	if($payment_type == 'card')
    	{
    		$transdatetime='';
    		$responsestatus='TXN_PENDING';
    		$paid_flag='0';
		 
		}
		else if($payment_type == 'Cash')
		{
		  
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';
		  
		}
		else if($payment_type == 'Cheque')
		{
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';

		}
		else if($payment_type == 'NEFT')
		{
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';

		}
		else if($payment_type == 'UPI')
		{
		   $transdatetime='';
		   $responsestatus='TXN_PENDING';
		   $paid_flag='0';

		}
		else if($payment_type == 'Paytm')
		{
		   $transdatetime='';
		   $responsestatus='TXN_PENDING';
		   $paid_flag='0';

		}

		$nurse_appointment_array = array(
			'user_id'=>$post['user_id'],
			'patient_id'=>$post['patient_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'type'=>$post['nurse_service_id'],
			'address_id'=>$post['address_id'],
			'total'=>$amount,
			'confirm'=>1,
			'days'=>$post['days'],
			'responsestatus'=>$responsestatus,
			'txndate'=>$transdatetime,
			'booked_by'=>$this->session->userdata('admin_user')['user_id'],
			'paid_flag'=>$paid_flag,
			'bankname'=>$bank_name,
			'gatewayname'=>$payment_type,
			
			
		);
		
		if($this->db->insert('book_nurse', $nurse_appointment_array))
		{
			 $insert_id = $this->db->insert_id();




                                            $this->db->select('*');
                                            $this->db->from('nurse_service_type');
                                            $this->db->where('nurse_service_type.nurse_service_id',$post['nurse_service_id']);
                                            $nurse_type = $this->db->get()->result_array();
                                            foreach($nurse_type as $nurse){

                                                 $typenurse = $doctor['nurse_service_name'];
                                            }
                                       
                                        

                                         


                                         //working progress 30/1/2021
                                            $nurse_extra_invoice = array(
                                                'list'=>"Nurse ".$typenurse,
                                                'price'=>$amount,
                                                'patient_id'=>$post['patient_id'],
                                                'user_id'=>$post['user_id'],
                                                //'doctor_id'=>60,
                                                'book_nurse_id'=>$insert_id,
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0.00,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>$payment_type,
                                                'txnid'=>0.00,
                                                'devicetype'=> '',
                                                'appmt_date'=>$post['date'],
                                                'order_id'=>'',
                                                'no_of_days'=>$post['days'],
                                                'time'=>$post['time'],
                                                'reference_id'=>'',
                                            );
                                            $this->db->insert("extra_invoice",$nurse_extra_invoice);  
											$this->session->set_flashdata('message','Nurse Appointment is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminDashboard');
    }

    //Ambulance

    public function addAmbulanceAppointment()
	{
		
		parent::index();
		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
// 		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
// 		$this->db->from('user');
// 		$this->db->order_by('user.user_id', 'DESC');
// 		$data['user'] = $this->db->get()->result_array();
        $this->db->select('user.first_name,user.last_name,user.mobile,user.user_id,user_type_id');
		$this->db->from('user');
		$this->db->where('user_type_id',99);
		$this->db->or_where('user_type_id',0);
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();

		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/addAmbulanceAppointment',$data);
		$this->load->view(FOOTER);
	}

	public function insertAmbulanceAppointment()
    {

    	$post = $this->input->post(NULL, true);
    	

    	// if($post['type']=="ONEWAY")
    	// {
    	// 	$this->db->select('*');
	    //     $this->db->from('manage_fees');
	    //     $this->db->where('manage_fees.submenu_type_id',1);
	    //     $this->db->where('manage_fees.service_id',5);
	    //      $this->db->where('manage_fees.city_id',$post['city_id']);
	    //     $fees_oneway = $this->db->get()->result_array();
	      
	    //     foreach($fees_oneway as $oneway){

	    //          $amount = $oneway['fees_name'];
	    //     }
    	// }
    	// elseif($post['type']=="ROUND TRIP")
    	// {
    	// 	$this->db->select('*');
	    //     $this->db->from('manage_fees');
	    //     $this->db->where('manage_fees.submenu_type_id',2);
	    //     $this->db->where('manage_fees.service_id',5);
	    //      $this->db->where('manage_fees.city_id',$post['city_id']);
	    //     $fees_roundtrip = $this->db->get()->result_array();
	      
	    //     foreach($fees_roundtrip as $roundtrip){

	    //          $amount = $roundtrip['fees_name'];
	    //     }
    	// }

    	$payment_type        = $post['payment_type'];
    	if($payment_type == 'card')
    	{
    		$transdatetime='';
    		$responsestatus='TXN_PENDING';
    		$paid_flag='0';
		 
		}
		else if($payment_type == 'Cash')
		{
		  
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';
		  
		}
		else if($payment_type == 'Cheque')
		{
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';

		}
		else if($payment_type == 'NEFT')
		{
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';

		}
		else if($payment_type == 'UPI')
		{
		   $transdatetime='';
		   $responsestatus='TXN_PENDING';
		   $paid_flag='0';

		}
		else if($payment_type == 'Paytm')
		{
		   $transdatetime='';
		   $responsestatus='TXN_PENDING';
		   $paid_flag='0';

		}
    	
    	 if($post['bank_name']!=''){

			$bank_name       = $_POST['bank_name'];
		}
		else{
			$bank_name="";
		}

    	if($post['type']=="ONEWAY")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['patient_id'],
			'user_id'=>$post['user_id'],
			'mobile1'=>$post['mobile1'],
			'landline'=>$post['landline']." ",
			'city_id'=>$post['city_id'],
			'from_address'=>$post['from_address']." ",
			'to_address'=>$post['to_address']." ",
			'type_id'=>1,
			'responsestatus'=>$responsestatus,
			'txndate'=>$transdatetime,
			'date'=>$post['date'],
			'time'=>$post['time'],
			'amount'=>$post['amount'],
			'booked_by'=>$this->session->userdata('admin_user')['user_id'],
			'paid_flag'=>$paid_flag,
			'bankname'=>$bank_name,
			'gatewayname'=>$payment_type,
			);
    	}
    	if($post['type']=="ROUND TRIP")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['patient_id'],
			'user_id'=>$post['user_id'],
			'mobile1'=>$post['mobile1'],
			'landline'=>$post['landline']." ",
			'from_address'=>$post['from_address']." ",
			'to_address'=>$post['to_address'],
			'type_id'=>2,
			'city_id'=>$post['city_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'amount'=>$post['amount'],
			'responsestatus'=>$responsestatus,
			'txndate'=>$transdatetime,
			'booked_by'=>$this->session->userdata('admin_user')['user_id'],
			'paid_flag'=>$paid_flag,
			'bankname'=>$bank_name,
			'gatewayname'=>$payment_type,
			
			);
    	}

    	if($post['type']=="MULTI CITY")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['patient_id'],
			'user_id'=>$post['user_id'],
			'type_id'=>3,
			'mobile1'=>$post['mobile1'],
			'city_id'=>$post['city_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'landline'=>$post['landline']." ",
			'multi_city'=>implode(',@#-0,',$post['multi_city']),
			'date'=>date('Y-m-d'),
			'amount'=>$post['amount'],
			'responsestatus'=>$responsestatus,
			'txndate'=>$transdatetime,
			'booked_by'=>$this->session->userdata('admin_user')['user_id'],
			'paid_flag'=>$paid_flag,
			'bankname'=>$bank_name,
			'gatewayname'=>$payment_type,

			
			);
    	}
		
		if($this->db->insert('book_ambulance', $ambulance_appointment_array))
		{


			 $insert_id = $this->db->insert_id();

									    $this->db->select('type_id');
                                        $this->db->from('book_ambulance');
                                        
                                        $this->db->where('book_ambulance_id',$insert_id);
                                        $amb_type = $this->db->get()->result_array();
                                        // echo $this->db->last_query();
                                        // exit;
                                        foreach($amb_type as $appointment){

                                             $amb_type_id = $appointment['type_id'];
                                        }

			  						if($amb_type_id==1)
                                     {
                                        $book_ambulance_type="ONEWAY";
                                     }
                                     elseif($amb_type_id==2)
                                     {
                                         $book_ambulance_type="Round trip";
                                     }
                                     else
                                     {
                                         $book_ambulance_type="Multi Location";
                                     }
                                    
                                      $ambulance_extra_invoice = array(
                                                'list'=>$book_ambulance_type." Ambulance Appointment",
                                                'price'=>$post['amount'],
                                                'patient_id'=>$post['patient_id'],
                                                'user_id'=>$post['user_id'],
                                                //'doctor_id'=>60,
                                                'book_ambulance_id'=>$insert_id,
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                'type'=>$payment_type,
                                                'txnid'=>0,
                                                'devicetype'=> '',
                                                'appmt_date'=>$post['date'],
                                                'order_id'=>'',
                                                'no_of_days'=>0,
                                                'time'=>$post['time'],
                                                'reference_id'=>'',
                                            );
                                            $this->db->insert("extra_invoice",$ambulance_extra_invoice);
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Ambulance Appointment is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminDashboard');
    }


    //Lab Test

    public function addLabAppointment()
	{
		
		parent::index();
		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('admin_user')['user_id']);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

// 		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
// 		$this->db->from('user');
// 		$this->db->order_by('user.user_id', 'DESC');
// 		$data['user'] = $this->db->get()->result_array();

        $this->db->select('user.first_name,user.last_name,user.mobile,user.user_id,user_type_id');
		$this->db->from('user');
		$this->db->where('user_type_id',99);
		$this->db->or_where('user_type_id',0);
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();
		
		$data['lab_test_type'] = $this->db->get_where('lab_test_type', array('l_status'=>1))->result_array();
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/addLabAppointment',$data);
		$this->load->view(FOOTER);
	}

	public function insertLabAppointment()
    {

    	$post = $this->input->post(NULL, true);
		
		// $this->db->select('city_id');
  //       $this->db->from('member');
  //       $this->db->where('member_id',$post['patient_id']);
  //       $member_data = $this->db->get()->result_array();
  //   	foreach($member_data as $member){

  //                    $city_id = $member['city_id'];
                     
  //       }
  //       $this->db->select('*');
  //       $this->db->from('manage_fees');
  //       $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
  //       $this->db->where('manage_fees.service_id',3);
  //       $this->db->where('manage_fees.city_id',$city_id);
  //       $fees_lab = $this->db->get()->result_array();
        
  //   	if($city_id==1)
  //   	{
  //   		$amount=0;
  //   	}
  //   	else
  //   	{
  //   		foreach($fees_lab as $lab){

  //            $amount = $lab['fees_name'];
  //       	}
  //   	}

					


    	 if($post['bank_name']!=''){

			$bank_name       = $_POST['bank_name'];
		}
		else{
			$bank_name="";
		}

       $payment_type        = $post['payment_type'];
    	if($payment_type == 'card')
    	{
    		$transdatetime='';
    		$responsestatus='TXN_PENDING';
    		$paid_flag='0';
		 
		}
		else if($payment_type == 'Cash')
		{
		  
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';
		  
		}
		else if($payment_type == 'Cheque')
		{
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';

		}
		else if($payment_type == 'NEFT')
		{
		  $transdatetime=date('Y-m-d H:i:s');
		  $responsestatus='TXN_SUCCESS';
		  $paid_flag='1';

		}
		else if($payment_type == 'UPI')
		{
		   $transdatetime='';
		   $responsestatus='TXN_PENDING';
		   $paid_flag='0';

		}
		else if($payment_type == 'Paytm')
		{
		   $transdatetime='';
		   $responsestatus='TXN_PENDING';
		   $paid_flag='0';

		}         	



    	
		$lab_appointment_array = array(


			'user_id'=>$post['user_id'],
			'patient_id'=>$post['patient_id'],
			'lab_test_id'=>$post['lab_test_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'address_id'=>$post['address_id'],
			'total'=>$post['amount'],
			'confirm'=>1,
			'responsestatus'=>$responsestatus,
			'txndate'=>$transdatetime,
			'complain'=>$post['complain'],
			'booked_by'=>$this->session->userdata('admin_user')['user_id'],
			'paid_flag'=>$paid_flag,
			'bankname'=>$bank_name,
			'gatewayname'=>$payment_type,
		);
		
		if($this->db->insert('book_laboratory_test', $lab_appointment_array))
		{
			 $insert_id = $this->db->insert_id();
			  // $this->db->select('*');
     //                                    $this->db->from('book_laboratory_test');
     //                                    $this->db->where('order_id',$_POST['ORDERID']);
     //                                    $this->db->where('user_id',$MERC_UNQ_REF[0]);
     //                                    $this->db->where('patient_id',$patient_id);
     //                                    $this->db->where('date',$date);
     //                                    $lab_appointment = $this->db->get()->result_array();
     //                                    foreach($lab_appointment as $appointment){

     //                                         $labapmt_id = $appointment['book_laboratory_test_id'];
     //                                    }
                                            $this->db->select('*');
                                            $this->db->from('lab_test_type');
                                            $this->db->where('lab_test_type.lab_test_id',$post['lab_test_id']);
                                            $lab_test_type = $this->db->get()->result_array();
                                            foreach($lab_test_type as $lab){

                                                 $typelab = $lab['lab_test_type_name'];
                                            }
                                       
                                            //working progress 30/1/2021
                                            
                                              $lab_extra_invoice = array(
                                                'list'=>$typelab." Appointment",
                                                'price'=>$post['amount'],
                                                'patient_id'=>$post['patient_id'],
                                                'user_id'=>$post['user_id'],
                                                //'doctor_id'=>60,
                                                'book_laboratory_test_id'=>$insert_id,
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0.00,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>$payment_type,
                                                'txnid'=>0.00,
                                                'devicetype'=> '',
                                                'appmt_date'=>$post['date'],
                                                'order_id'=>'',
                                                'no_of_days'=>0,
                                                'time'=>$post['time'],
                                                'reference_id'=>'',
                                            );
                                           
                                            $this->db->insert("extra_invoice",$lab_extra_invoice);

			
			$this->General_model->uploadLabImage('./uploads/lab_report/', $insert_id,'profile_','img_profile', 'book_laboratory_test','prescription');
			// echo $error;
			// print_r($error);
			// exit;
			$this->session->set_flashdata('message','Lab Appointment is added.');
			

		}else{
			
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminDashboard');
    }

    //Pharmacy
     public function addPharmacyAppointment()
	{
		
		parent::index();
		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/addPharmacyAppointment',$data);
		$this->load->view(FOOTER);
	}

	public function insertPharmacyAppointment()
    {

    	$post = $this->input->post(NULL, true);
		$pharmacy_appointment_array = array(


			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			'name'=>$post['name'],
			'mobile'=>$post['mobile'],
			'landline'=>$post['landline'],
			'address'=>$post['address']." ",
			'city_id'=>$post['city_id'],
			'booked_by'=>$this->session->userdata('admin_user')['user_id'],
			'created_date'=>date('Y-m-d'),
			
			
			
			
		);
		
		if($this->db->insert('book_medicine', $pharmacy_appointment_array))
		{
			 $insert_id = $this->db->insert_id();
			
			$this->General_model->uploadPharmacyImage('./uploads/pharmacy_document/', $insert_id,'profile_','img_profile', 'book_medicine','prescription');
			$this->session->set_flashdata('message','Pharmacy Details is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminDashboard');
    }
  //   public function assingAppointment()
  //   {
    	
  //   		extract($_POST);
  //   		$this->db->select('*');
		// 	$this->db->from('appointment_book');
		// 	$this->db->where('appointment_book_id',$_POST[btn_appointment_assign]);
		// 	$manage_assign_appointment= $this->db->get()->row_array();

		// 	$appointment_id=$_POST[btn_appointment_assign];
		// 	$patient_id=$manage_assign_appointment['patient_id'];
		// 	$user_id=$manage_assign_appointment['user_id'];
		// 	$address_id=$manage_assign_appointment['address_id'];
		// 	$date=$manage_assign_appointment['date'];
		// 	$time=$manage_assign_appointment['time'];
			
		// 	$assing_appointment_array = array(
			
		// 	'user_id'=>$user_id,
		// 	'appointment_id'=>$appointment_id,
		// 	'patient_id'=>$patient_id,
		// 	'team_id'=>$_POST['team_id'],
		// 	'emp_id'=>$_POST['employee_id'],
		// 	'service_id'=>1,
		// 	'date_time'=>$date." ".$time,
		// 	'address_id'=>$address_id,
		//   );
		
		// if($this->db->insert('assign_appointment', $assing_appointment_array))
		// {
			 
		// 	$this->session->set_flashdata('message','Appointment Assign.');
		// }else{
		// 	$this->session->set_flashdata('message','Try Again. Something went wrong.');
		// }	

		//  redirect(base_url().'adminDashboard');
  //   }
    public function download_prescription($filename = NULL) {

    
    	$this->load->helper('download');
  		$data = file_get_contents(base_url('/uploads/appointment/prescription/'.$filename));
    	force_download($filename, $data);
    	
      
	}
	 public function download_lab($filename = NULL) {

    
    	$this->load->helper('download');
  		$data = file_get_contents(base_url('/uploads/appointment/lab_report/'.$filename));
    	force_download($filename, $data);
    	
      
	}
	 public function download_lab_report($filename = NULL) {

    
    	$this->load->helper('download');
  		$data = file_get_contents(base_url('/uploads/lab_report/'.$filename));
    	force_download($filename, $data);
    	
      
	}
    public function assingAppointment()
    {
    	
    		extract($_POST);
    		
    		$service_type=explode(',',$_POST[btn_appointment_assign]);
    		// echo "<pre>";
    		// print_r($service_type);
    		// echo "</pre>";exit;
    		// echo $service_type[1];
    		// exit;
    		if($service_type[1]==1)
    		{
    			
    				$this->db->select('*');
					$this->db->from('appointment_book');
					$this->db->where('appointment_book_id',$_POST[btn_appointment_assign]);
					$manage_assign_appointment= $this->db->get()->row_array();

					$appointment_id=$_POST[btn_appointment_assign];
					$patient_id=$manage_assign_appointment['patient_id'];
					$user_id=$manage_assign_appointment['user_id'];
					$address_id=$manage_assign_appointment['address_id'];
					$date=$manage_assign_appointment['date'];
					$time=$manage_assign_appointment['time'];
					
					$assing_appointment_array = array(
					
					'user_id'=>$user_id,
					'appointment_id'=>$appointment_id,
					'patient_id'=>$patient_id,
					'team_id'=>$_POST['team_id'],
					'emp_id'=>$_POST['employee_id'],
					'service_id'=>1,
					'date_time'=>$date." ".$time,
					'address_id'=>$address_id,
				  );
				
					if($this->db->insert('assign_appointment', $assing_appointment_array))
					{
						 
							
							// $message = urlencode("We are sad that you cancelled your booking with id '".$_POST['appointment_book_id']."'. Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
	                    		
	      //               		$this->db->select('*');
			    //                 $this->db->from('sms_detail');
			    //                 $sms_detail = $this->db->get()->result_array();

	      //                       $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
	      //                               $response = file_get_contents($smsurl);


								$this->db->select('*');
								$this->db->from('employee_master');
								//$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
								$this->db->where('emp_id',$_POST[employee_id]);
								$send_employee_email= $this->db->get()->row_array();

								$this->db->select('member.*');
								$this->db->from('member');
								$this->db->where('member_id',$patient_id);
								$send_patient_details= $this->db->get()->row_array();
								$appointment_book_id_send=explode(',',$appointment_id);

								$this->db->select('appointment_book.address_id,add_address.*');
								$this->db->from('appointment_book');
								$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
								$this->db->where('appointment_book.appointment_book_id',$appointment_book_id_send[0]);
								//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
								$patient_address= $this->db->get()->row_array();





	                            $this->load->library('email');
								if($send_patient_details[address]!='')
								{
									
									 $patient_address=  $send_patient_details[address];
									
								}
								else
								{
							          $patient_address = $patient_address[address_1].' '.$patient_address[address_2];
								}
								$mail_message = 
	                            "<p>Dear ".$send_employee_email[first_name].' '.$send_employee_email[last_name]."</p>
								<p>An Appointment is assigned to you with following Details</p>
								<p>Date of Appointment date ".$date." and time ".$time."</p>
								<p>Doctor Service</p>
								<p>Patient Name  ".$send_patient_details[name]."</p>
								<p>Patient contact No  ".$send_patient_details[contact_no]."</p>
								<p>Patient Address  ".$patient_address."</p>
							    <br><br>
								<p> Regards,</p>
								<p><b> Dratdoorstep</b></p>
								";
	                            $config['protocol'] = 'sendmail';
	                            $config['mailpath'] = '/usr/sbin/sendmail';

	                            $config['mailtype'] = 'html'; // or html
	                      //  $this->load->library('email');
	                      //  $this->email->from('no-reply@example.com');
	                            $this->email->initialize($config);

	                            //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
	                            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
	                            $this->email->to($send_employee_email['email']);
	                            $this->email->subject('DratDoorStep');
	                            $this->email->message($mail_message);
	                            $this->email->send();
								$this->session->set_flashdata('message','Appointment Assign.');
					}
					else
					{
						$this->session->set_flashdata('message','Try Again. Something went wrong.');
					}
    		}
    		else if ($service_type[1]==2) {
    				
    				$this->db->select('*');
					$this->db->from('book_nurse');
					$this->db->where('book_nurse_id',$_POST[btn_appointment_assign]);
					$manage_assign_appointment= $this->db->get()->row_array();

					$appointment_id=$_POST[btn_appointment_assign];
					$patient_id=$manage_assign_appointment['patient_id'];
					$user_id=$manage_assign_appointment['user_id'];
					$address_id=$manage_assign_appointment['address_id'];
					$date=$manage_assign_appointment['date'];
					$time=$manage_assign_appointment['time'];
					
					$assing_appointment_array = array(
					
					'user_id'=>$user_id,
					'appointment_id'=>$appointment_id,
					'patient_id'=>$patient_id,
					'team_id'=>$_POST['team_id'],
					'emp_id'=>$_POST['employee_id'],
					'service_id'=>2,
					'date_time'=>$date." ".$time,
					'address_id'=>$address_id,
				  );
				
					if($this->db->insert('assign_appointment', $assing_appointment_array))
					{
								

								$this->db->select('*');
								$this->db->from('employee_master');
								//$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
								$this->db->where('emp_id',$_POST[employee_id]);
								$send_employee_email= $this->db->get()->row_array();

								$this->db->select('member.*');
								$this->db->from('member');
								$this->db->where('member_id',$patient_id);
								$send_patient_details= $this->db->get()->row_array();
								$appointment_book_id_send=explode(',',$appointment_id);

								$this->db->select('appointment_book.address_id,add_address.*');
								$this->db->from('appointment_book');
								$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
								$this->db->where('appointment_book.appointment_book_id',$appointment_book_id_send[0]);
								//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
								$patient_address= $this->db->get()->row_array();





	                            $this->load->library('email');

	                          	if($send_patient_details[address]!='')
								{
									
									 $patient_address=  $send_patient_details[address];
									
								}
								else
								{
							          $patient_address = $patient_address[address_1].' '.$patient_address[address_2];
								}

	                            $mail_message = 
	                            "<p>Dear ".$send_employee_email[first_name].' '.$send_employee_email[last_name]."</p>
								<p>An Appointment is assigned to you with following Details</p>
								<p>Date of Appointment date ".$date." and time ".$time."</p>
								<p>Nurse Service</p>
								<p>Patient Name  ".$send_patient_details[name]."</p>
								<p>Patient contact No  ".$send_patient_details[contact_no]."</p>
								<p>Patient Address  ".$patient_address."</p>
							    <br><br>
								<p> Regards,</p>
								<p><b> Dratdoorstep</b></p>
								";
	                            $config['protocol'] = 'sendmail';
	                            $config['mailpath'] = '/usr/sbin/sendmail';

	                            $config['mailtype'] = 'html'; // or html
	                      //  $this->load->library('email');
	                      //  $this->email->from('no-reply@example.com');
	                            $this->email->initialize($config);

	                            //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
	                            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
	                            $this->email->to($send_employee_email['email']);
	                            $this->email->subject('DratDoorStep');
	                            $this->email->message($mail_message);
	                            $this->email->send();
						$this->session->set_flashdata('message','Appointment Assign.');
					}else{
						$this->session->set_flashdata('message','Try Again. Something went wrong.');
					}
    			
    		}
    		elseif ($service_type[1]==3) {

    		
					
					$this->db->select('*');
					$this->db->from('book_laboratory_test');
					$this->db->where('book_laboratory_test_id',$_POST[btn_appointment_assign]);
					$manage_assign_appointment= $this->db->get()->row_array();

					$appointment_id=$_POST[btn_appointment_assign];
					$patient_id=$manage_assign_appointment['patient_id'];
					$user_id=$manage_assign_appointment['user_id'];
					$address_id=$manage_assign_appointment['address_id'];
					$date=$manage_assign_appointment['date'];
					$time=$manage_assign_appointment['time'];
					
					$assing_appointment_array = array(
					
					'user_id'=>$user_id,
					'appointment_id'=>$appointment_id,
					'patient_id'=>$patient_id,
					'team_id'=>$_POST['team_id'],
					'emp_id'=>$_POST['employee_id'],
					'service_id'=>3,
					'date_time'=>$date." ".$time,
					'address_id'=>$address_id,
				  );
				
					if($this->db->insert('assign_appointment', $assing_appointment_array))
					{
								$this->db->select('*');
								$this->db->from('employee_master');
								//$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
								$this->db->where('emp_id',$_POST[employee_id]);
								$send_employee_email= $this->db->get()->row_array();

								$this->db->select('member.*');
								$this->db->from('member');
								$this->db->where('member_id',$patient_id);
								$send_patient_details= $this->db->get()->row_array();
								$appointment_book_id_send=explode(',',$appointment_id);

								$this->db->select('appointment_book.address_id,add_address.*');
								$this->db->from('appointment_book');
								$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
								$this->db->where('appointment_book.appointment_book_id',$appointment_book_id_send[0]);
								//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
								$patient_address= $this->db->get()->row_array();





	                            $this->load->library('email');

	                          	if($send_patient_details[address]!='')
								{
									
									 $patient_address=  $send_patient_details[address];
									
								}
								else
								{
							          $patient_address = $patient_address[address_1].' '.$patient_address[address_2];
								}

	                            $mail_message = 
	                            "<p>Dear ".$send_employee_email[first_name].' '.$send_employee_email[last_name]."</p>
								<p>An Appointment is assigned to you with following Details</p>
								<p>Date of Appointment date ".$date." and time ".$time."</p>
								<p>Lab Service</p>
								<p>Patient Name  ".$send_patient_details[name]."</p>
								<p>Patient contact No  ".$send_patient_details[contact_no]."</p>
								<p>Patient Address  ".$patient_address."</p>
							    <br><br>
								<p> Regards,</p>
								<p><b> Dratdoorstep</b></p>
								";
	                            $config['protocol'] = 'sendmail';
	                            $config['mailpath'] = '/usr/sbin/sendmail';

	                            $config['mailtype'] = 'html'; // or html
	                      //  $this->load->library('email');
	                      //  $this->email->from('no-reply@example.com');
	                            $this->email->initialize($config);

	                            //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
	                            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
	                            $this->email->to($send_employee_email['email']);
	                            $this->email->subject('DratDoorStep');
	                            $this->email->message($mail_message);
	                            $this->email->send();
						$this->session->set_flashdata('message','Appointment Assign.');
					}else{
						$this->session->set_flashdata('message','Try Again. Something went wrong.');
					}
    		}
    		elseif ($service_type[1]==4) {
    			
    			$this->db->select('*');
					$this->db->from('book_medicine');
					$this->db->where('book_medicine_id',$_POST[btn_appointment_assign]);
					$manage_assign_appointment= $this->db->get()->row_array();

					$appointment_id=$_POST[btn_appointment_assign];
					$patient_id=$manage_assign_appointment['patient_id'];
					$user_id=$manage_assign_appointment['user_id'];
					$address_id=$manage_assign_appointment['address'];
					$date=$manage_assign_appointment['created_date'];
					//$time=$manage_assign_appointment['time'];
					
					$assing_appointment_array = array(
					
					'user_id'=>$user_id,
					'appointment_id'=>$appointment_id,
					'patient_id'=>$patient_id,
					'team_id'=>$_POST['team_id'],
					'emp_id'=>$_POST['employee_id'],
					'service_id'=>4,
					'date_time'=>$date,
					'address_id'=>$address_id,
				  );
				
					if($this->db->insert('assign_appointment', $assing_appointment_array))
					{
								// $this->db->select('*');
								// $this->db->from('employee_master');
								// //$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
								// $this->db->where('emp_id',$_POST[employee_id]);
								// $send_employee_email= $this->db->get()->row_array();

								// $this->db->select('member.*');
								// $this->db->from('member');
								// $this->db->where('member_id',$patient_id);
								// $send_patient_details= $this->db->get()->row_array();
								// $appointment_book_id_send=explode(',',$appointment_id);

								// $this->db->select('appointment_book.address_id,add_address.*');
								// $this->db->from('appointment_book');
								// $this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
								// $this->db->where('appointment_book.appointment_book_id',$appointment_book_id_send[0]);
								// //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
								// $patient_address= $this->db->get()->row_array();





	       //                      $this->load->library('email');

	                          

	       //                       $mail_message = "
								// <p>Dear ".$send_employee_email[first_name]." ".$send_employee_email[last_name]"</p><br>
								// <p>An Appointment is assigned to you with following Details</p><br>
								// <p>Date of Appointment date ".$date." and time ".$time."</p><br>
								// <p>Doctor Service</p><br>
								// <p>Patient Name  ".$send_patient_details[name]."</p><br>
								// <p>Patient contact No  ".$send_patient_details[contact_no]."</p><br>";
								// if($send_patient_details[address]!='')
								// {
									
								// 	echo "<p>Patient Address  ".$send_patient_details[address]."</p><br>";
									
								// }
								// else
								// {
								// 	echo "<p>Patient Address  ".$patient_address[address_1]." ".$patient_address[address_2]."</p><br>";
								// }
								// "<br><br>
								// <p> Regards,</p>
								// <p><b> Dratdoorstep</b></p>
								// ";
	       //                      $config['protocol'] = 'sendmail';
	       //                      $config['mailpath'] = '/usr/sbin/sendmail';

	       //                      $config['mailtype'] = 'html'; // or html
	       //                //  $this->load->library('email');
	       //                //  $this->email->from('no-reply@example.com');
	       //                      $this->email->initialize($config);

	       //                      //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
	       //                      $this->email->from('info@dratdoorstep.com','Dratdoorstep');
	       //                      $this->email->to($send_employee_email['email']);
	       //                      $this->email->subject('DratDoorStep');
	       //                      $this->email->message($mail_message);
	       //                      $this->email->send();
								$this->session->set_flashdata('message','Appointment Assign.');

					}else{
						$this->session->set_flashdata('message','Try Again. Something went wrong.');
					}
    		}
    		else if($service_type[1]==5)
    		{
    			
    // 				$this->db->select('*');
				// 	$this->db->from('appointment_book');
				// 	$this->db->where('appointment_book_id',$_POST[btn_appointment_assign]);
				// 	$manage_assign_appointment= $this->db->get()->row_array();
				
				    $this->db->select('*');
					$this->db->from('book_ambulance');
					$this->db->where('book_ambulance_id',$_POST[btn_appointment_assign]);
					$manage_assign_appointment= $this->db->get()->row_array();

					$appointment_id=$_POST[btn_appointment_assign];
					$patient_id=$manage_assign_appointment['patient_id'];
					$user_id=$manage_assign_appointment['user_id'];
					$address_id=$manage_assign_appointment['address_id'];
					$date=$manage_assign_appointment['date'];
					$time=$manage_assign_appointment['time'];
					
					$assing_appointment_array = array(
					
					'user_id'=>$user_id,
					'appointment_id'=>$appointment_id,
					'patient_id'=>$patient_id,
					'team_id'=>$_POST['team_id'],
					'emp_id'=>$_POST['employee_id'],
					'service_id'=>5,
					'date_time'=>$date." ".$time,
					'address_id'=>0,
				  );
				
					if($this->db->insert('assign_appointment', $assing_appointment_array))
					{
						 
							
								
								$this->db->select('*');
								$this->db->from('employee_master');
								//$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
								$this->db->where('emp_id',$_POST[employee_id]);
								$send_employee_email= $this->db->get()->row_array();
								// echo "<pre>";
								// print_r($send_employee_email);
								// exit;




								$this->db->select('member.*');
								$this->db->from('member');
								$this->db->where('member_id',$patient_id);
								$send_patient_details= $this->db->get()->row_array();
								$appointment_book_id_send=explode(',',$appointment_id);


								if($send_employee_email[user_type_id]=="1")
								{
									$this->db->select('appointment_book.address_id,add_address.*');
									$this->db->from('appointment_book');
									$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
									$this->db->where('appointment_book.appointment_book_id',$appointment_book_id_send[0]);
									//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
									$patient_address= $this->db->get()->row_array();
								}
								elseif($send_employee_email[user_type_id]=="2")
								{
									$this->db->select('book_nurse.address_id,add_address.*');
									$this->db->from('book_nurse');
									$this->db->join('add_address','add_address.address_id = book_nurse.address_id','LEFT');
									$this->db->where('book_nurse.book_nurse_id',$appointment_book_id_send[0]);
									//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
									$patient_address= $this->db->get()->row_array();
								}
								elseif($send_employee_email[user_type_id]=="3")
								{
										$this->db->select('book_laboratory_test.address_id,add_address.*');
									$this->db->from('book_laboratory_test');
									$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
									$this->db->where('book_laboratory_test.book_laboratory_test_id',$appointment_book_id_send[0]);
									//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
									$patient_address= $this->db->get()->row_array();
								}
								elseif($send_employee_email[user_type_id]=="5")
								{
									$this->db->select('book_ambulance.*');
									$this->db->from('book_ambulance');
									$this->db->where('book_ambulance.book_ambulance_id',$appointment_book_id_send[0]);
									//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
									$patient_address= $this->db->get()->row_array();
								}
								





	                            $this->load->library('email');
	                          // echo $send_employee_email[user_type_id];
	                           //exit;
	                        if($send_employee_email[user_type_id]=="1" || $send_employee_email[user_type_id]=="2" || $send_employee_email[user_type_id]=="3")
							{
								if($send_patient_details[address]!='')
								{
									
									 $patient_address=  $send_patient_details[address];
									
								}
								else
								{
							          $patient_address = $patient_address[address_1].' '.$patient_address[address_2];
								}

								 $mail_message = 
	                            "<p>Dear ".$send_employee_email[first_name].' '.$send_employee_email[last_name]."</p>
								<p>An Appointment is assigned to you with following Details</p>
								<p>Date of Appointment date ".$date." and time ".$time."</p>
								<p>Doctor Service</p>
								<p>Patient Name  ".$send_patient_details[name]."</p>
								<p>Patient contact No  ".$send_patient_details[contact_no]."</p>
								<p>Patient Address  ".$patient_address."</p>
							    <br><br>
								<p> Regards,</p>
								<p><b> Dratdoorstep</b></p>
								";
								//exit;
							}
							else
							{

									// echo "<pre>";
									// print_r($patient_address);
									// exit;
							          $from_patient_address = $patient_address[from_address];
							          $to_patient_address = $patient_address[to_address];
							          $patient_contact = $patient_address[mobile1];
							          
								

								 $mail_message = 
	                            "<p>Dear ".$send_employee_email[first_name].' '.$send_employee_email[last_name]."</p>
								<p>An Appointment is assigned to you with following Details</p>
								<p>Date of Appointment date ".$date." and time ".$time."</p>
								<p>Doctor Service</p>
								<p>Patient Name  ".$send_patient_details[name]."</p>
								<p>Patient contact No  ".$patient_contact."</p>
								<p>Patient From Address  ".$from_patient_address."</p>
								<p>Patient To Address  ".$to_patient_address."</p>
							    <br><br>
								<p> Regards,</p>
								<p><b> Dratdoorstep</b></p>
								";
								
							}
	                            $config['protocol'] = 'sendmail';
	                            $config['mailpath'] = '/usr/sbin/sendmail';

	                            $config['mailtype'] = 'html'; // or html
	                      //  $this->load->library('email');
	                      //  $this->email->from('no-reply@example.com');
	                            $this->email->initialize($config);

	                            //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
	                            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
	                            $this->email->to($send_employee_email['email']);
	                            $this->email->subject('DratDoorStep');
	                            $this->email->message($mail_message);
	                            $this->email->send();
								$this->session->set_flashdata('message','Appointment Assign.');
					}
					else
					{
						$this->session->set_flashdata('message','Try Again. Something went wrong.');
					}
    		}
    		
    		else if($service_type[1] == 6){

            $this->db->select('package_booking.*,book_package.address_id');
            $this->db->from('package_booking');
            $this->db->join('book_package','book_package.book_package_id = package_booking.book_package_id');
            $this->db->where('id', $_POST[btn_appointment_assign]);
            $manage_assign_appointment = $this->db->get()->row_array();

            $appointment_id = $_POST[btn_appointment_assign];
            $patient_id = $manage_assign_appointment['patient_id'];
            $user_id = $manage_assign_appointment['user_id'];
            $address_id = $manage_assign_appointment['address_id'];
            $date = $manage_assign_appointment['date'];
            $time = $manage_assign_appointment['time'];
            
            $assing_appointment_array = array(

                'user_id' => $user_id,
                'appointment_id' => $appointment_id,
                'patient_id' => $patient_id,
                'team_id' => $_POST['team_id'],
                'emp_id' => $_POST['employee_id'],
                'service_id' => 6,
                'date_time' => $date . " " . $time,
                'address_id' => $address_id,
            );

            // echo "<pre>";
            // print_r($assing_appointment_array);
            // exit;

            if ($this->db->insert('assign_appointment', $assing_appointment_array)) {

                $this->db->select('*');
                $this->db->from('employee_master');
                //$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
                $this->db->where('emp_id', $_POST[employee_id]);
                $send_employee_email = $this->db->get()->row_array();
                // echo "<pre>";
                // print_r($send_employee_email);
                // exit;

                $this->db->select('member.*');
                $this->db->from('member');
                $this->db->where('member_id', $patient_id);
                $send_patient_details = $this->db->get()->row_array();
                $appointment_book_id_send = explode(',', $appointment_id);

                if ($send_employee_email[user_type_id] == "1") {
                    $this->db->select('appointment_book.address_id,add_address.*');
                    $this->db->from('appointment_book');
                    $this->db->join('add_address', 'add_address.address_id = appointment_book.address_id', 'LEFT');
                    $this->db->where('appointment_book.appointment_book_id', $appointment_book_id_send[0]);
                    //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                    $patient_address = $this->db->get()->row_array();
                } elseif ($send_employee_email[user_type_id] == "2") {
                    $this->db->select('book_nurse.address_id,add_address.*');
                    $this->db->from('book_nurse');
                    $this->db->join('add_address', 'add_address.address_id = book_nurse.address_id', 'LEFT');
                    $this->db->where('book_nurse.book_nurse_id', $appointment_book_id_send[0]);
                    //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                    $patient_address = $this->db->get()->row_array();
                } elseif ($send_employee_email[user_type_id] == "3") {
                    $this->db->select('book_laboratory_test.address_id,add_address.*');
                    $this->db->from('book_laboratory_test');
                    $this->db->join('add_address', 'add_address.address_id = book_laboratory_test.address_id', 'LEFT');
                    $this->db->where('book_laboratory_test.book_laboratory_test_id', $appointment_book_id_send[0]);
                    //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                    $patient_address = $this->db->get()->row_array();
                } elseif ($send_employee_email[user_type_id] == "5") {
                    $this->db->select('book_ambulance.*');
                    $this->db->from('book_ambulance');
                    $this->db->where('book_ambulance.book_ambulance_id', $appointment_book_id_send[0]);
                    //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                    $patient_address = $this->db->get()->row_array();
                }

                $this->load->library('email');
                // echo $send_employee_email[user_type_id];
                //exit;
                if ($send_employee_email[user_type_id] == "1" || $send_employee_email[user_type_id] == "2" || $send_employee_email[user_type_id] == "3") {
                    if ($send_patient_details[address] != '') {

                        $patient_address = $send_patient_details[address];

                    } else {
                        $patient_address = $patient_address[address_1] . ' ' . $patient_address[address_2];
                    }

                    $mail_message =
                    "<p>Dear " . $send_employee_email[first_name] . ' ' . $send_employee_email[last_name] . "</p>
                    <p>An Appointment is assigned to you with following Details</p>
                    <p>Date of Appointment date " . $date . " and time " . $time . "</p>
                    <p>Doctor Service</p>
                    <p>Patient Name  " . $send_patient_details[name] . "</p>
                    <p>Patient contact No  " . $send_patient_details[contact_no] . "</p>
                    <p>Patient Address  " . $patient_address . "</p>
                    <br><br>
                    <p> Regards,</p>
                    <p><b> Dratdoorstep</b></p>
                    ";
                    //exit;
                } else {

                    // echo "<pre>";
                    // print_r($patient_address);
                    // exit;
                    $from_patient_address = $patient_address[from_address];
                    $to_patient_address = $patient_address[to_address];
                    $patient_contact = $patient_address[mobile1];

                    $mail_message =
                    "<p>Dear " . $send_employee_email[first_name] . ' ' . $send_employee_email[last_name] . "</p>
                    <p>An Appointment is assigned to you with following Details</p>
                    <p>Date of Appointment date " . $date . " and time " . $time . "</p>
                    <p>Doctor Service</p>
                    <p>Patient Name  " . $send_patient_details[name] . "</p>
                    <p>Patient contact No  " . $patient_contact . "</p>
                    <p>Patient From Address  " . $from_patient_address . "</p>
                    <p>Patient To Address  " . $to_patient_address . "</p>
                    <br><br>
                    <p> Regards,</p>
                    <p><b> Dratdoorstep</b></p>
                    ";

                }
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';

                $config['mailtype'] = 'html'; // or html
                //  $this->load->library('email');
                //  $this->email->from('no-reply@example.com');
                $this->email->initialize($config);

                //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
                $this->email->from('info@dratdoorstep.com', 'Dratdoorstep');
                $this->email->to($send_employee_email['email']);
                $this->email->subject('DratDoorStep');
                $this->email->message($mail_message);
                $this->email->send();
                $this->session->set_flashdata('message', 'Appointment Assign.');
            } else {
                $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
            }

        }
    		
    		 redirect(base_url().'adminAppointmentList');
    }
    public function addVisitNotes(){

    	parent::index();
		$post = $this->input->post(NULL, true);

		// echo "<pre>";
		// print_r($post);
		// echo "</pre>";

		$assign_appointment_id=$_POST['assign_appointment_id'];
		$visit_history_text=$_POST['visit_history_text'];
		//echo $assign_appointment_id;
		// exit;
		

		$this->db->where('assign_appointment_id',$assign_appointment_id);
    	if($this->db->update('assign_appointment', array('visit_history_text' =>$visit_history_text)))
		{	
			if($visit_history_text=='')
			{
				echo "<font color='red'>Please enter Visit History.</font>";
			}
			else
			{
				echo "Assing Visit History added.";
			}
			
			//$this->session->set_flashdata('message','Assing Visit History added');
		}else{
			echo "Something went wrong.";
			//$this->session->set_flashdata('message','Something went wrong.');
		}


		//redirect(base_url().'viewBookingHistory');	
	}
	public function addEcgXrayNotes(){

    	parent::index();
		$post = $this->input->post(NULL, true);



		$assign_appointment_id=$_POST['assign_appointment_id'];
		$ecg_and_xray_text=$_POST['ecg_and_xray_text'];
		// echo $assign_appointment_id;
		// exit;
		

		$this->db->where('assign_appointment_id',$assign_appointment_id);
    	if($this->db->update('assign_appointment', array('ecg_xray_note' =>$ecg_and_xray_text)))
		{	
			if($ecg_and_xray_text=='')
			{
				echo "<font color='red'>Please enter ECG and XRAY Notes.</font>";
			}
			else
			{
				echo "ECG and XRAY Notes added.";
			}
			
			//$this->session->set_flashdata('message','Assing Visit History added');
		}else{
			echo "Something went wrong.";
			//$this->session->set_flashdata('message','Something went wrong.');
		}


		//redirect(base_url().'viewBookingHistory');	
	}
	public function uploadPrescription(){


		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);
		// echo "</pre>";
		// exit;
			 $F = array();
			 $fileData = array();
//echo $_FILES['prescription']['name'];
    $count_uploaded_files = count($_FILES['prescription']['name']);
   // echo $count_uploaded_files;
    $files = $_FILES;

 	$prescription_data_list = [];
    for( $i = 0; $i < $count_uploaded_files; $i++ )
    {
        $_FILES['userfile'] = [
            'name'     => "prescription".time().str_replace(' ', '', $files['prescription']['name'][$i]),
            'type'     => $files['prescription']['type'][$i],
            'tmp_name' => $files['prescription']['tmp_name'][$i],
            'error'    => $files['prescription']['error'][$i],
            'size'     => $files['prescription']['size'][$i]
        ];
       
       
          $F[] = $_FILES['userfile'];
          
         $prescription_data = explode(",", $F[$i]['name']);
         // echo "<pre>";
         //  print_r($prescription_data);
        //  exit;
        
      
        $uploadPath = './uploads/appointment/prescription/'; 

        $config['upload_path'] = $uploadPath; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 
       $config['max_size'] = 20000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if($this->upload->do_upload('userfile'))
        {

        	$image_prescription = implode(",",$prescription_data);
        	//echo $image_prescription;
        	array_push($prescription_data_list, $image_prescription);
			//echo $this->db->last_query();
		}
      
	      
    }
    	

    	$image_prescription_update = implode(",",$prescription_data_list);
    	// echo $image_prescription_update;
    	// exit;
        $this->db->where('assign_appointment_id',$post[assign_appointment_id]);
	    //$this->db->update('assign_appointment',array(prescription=>$image_prescription_update));
	    if($this->db->update('assign_appointment',array(prescription=>$image_prescription_update)))
		{	
			//echo "fdfs";
			if($image_prescription_update=='')
			{
				echo json_encode(array(
						"message"=>"<font color='red'>Please Select image.</font>",
					));
				//echo "<font color='red'>Please Select image.</font>";
			}
			else
			{
				echo json_encode(array(
						"message"=>"Image upload Successfully.",
					));
				
			}
		}
       
     	//echo $this->db->last_query();
     
    //echo json_encode($F);
	}
	public function uploadLabReport(){


		$post = $this->input->post(NULL, true);
		
			 $F = array();
			 $fileData = array();
//echo $_FILES['prescription']['name'];
    $count_uploaded_files = count($_FILES['lab_report']['name']);
   // echo $count_uploaded_files;
    $files = $_FILES;

 	$prescription_data_list = [];
    for( $i = 0; $i < $count_uploaded_files; $i++ )
    {
        $_FILES['userfile'] = [
            'name'     => "lab_report".time().str_replace(' ', '', $files['lab_report']['name'][$i]),
            'type'     => $files['lab_report']['type'][$i],
            'tmp_name' => $files['lab_report']['tmp_name'][$i],
            'error'    => $files['lab_report']['error'][$i],
            'size'     => $files['lab_report']['size'][$i]
        ];
       
       
          $F[] = $_FILES['userfile'];
          
         $prescription_data = explode(",", $F[$i]['name']);
         // echo "<pre>";
         //  print_r($prescription_data);
        //  exit;
        
      
        $uploadPath = './uploads/appointment/lab_report/'; 

        $config['upload_path'] = $uploadPath; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if($this->upload->do_upload('userfile'))
        {

        	$image_prescription = implode(",",$prescription_data);
        	//echo $image_prescription;
        	array_push($prescription_data_list, $image_prescription);
			//echo $this->db->last_query();
		}
      
	      
    }
    	

    	$image_lab_update = implode(",",$prescription_data_list);
    	// echo $image_prescription_update;
    	// exit;
        $this->db->where('assign_appointment_id',$post[assign_appointment_id]);
	    //$this->db->update('assign_appointment',array(prescription=>$image_prescription_update));
	    if($this->db->update('assign_appointment',array(lab_report=>$image_lab_update)))
		{	
			//echo "fdfs";
			if($image_lab_update=='')
			{
				echo json_encode(array(
						"message"=>"<font color='red'>Please Select image.</font>",
					));
				//echo "<font color='red'>Please Select image.</font>";
			}
			else
			{
				echo json_encode(array(
						"message"=>"Image upload Successfully.",
					));
				
			}
		}
       
     	//echo $this->db->last_query();
     
    //echo json_encode($F);
	}
    public function viewAdminBookingHistory()
	{
		
		//$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
      parent::index();
		//$appointment_id=$_POST['btn_view_package'];
	   extract($_POST);
       $service_type=explode(',',$_POST[btn_appointment_assign]);
       // echo "<pre>";
       // print_r($_POST);
       //  exit;

      // $date = new DateTime("now");
	   //$curr_date = $date->format('Y-m-d');

        if($service_type[1]==1)
        {
        	
        	$this->db->select('appointment_book.*,member.contact_no,member.name,member.patient_code,add_address.address_1,add_address.address_2');
			$this->db->from('appointment_book');
			$this->db->join('member','member.member_id = appointment_book.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
			//$this->db->where('appointment_book.user_id',$this->session->userdata('admin')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
			$this->db->where('appointment_book.appointment_book_id',$service_type[0]);
			//$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
			$this->db->order_by('appointment_book.appointment_book_id', 'DESC');
			$data['visit_book_history']= $this->db->get()->result_array();


			$this->db->select('assign_appointment.*,member.contact_no,member.name,member.patient_code,manage_team.team_name,employee_master.first_name,employee_master.last_name');
			$this->db->from('assign_appointment');
			$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
			$this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
			$this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
			$this->db->where('assign_appointment.appointment_id',$service_type[0]);
			//$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();
			

        }
        elseif ($service_type[1]==2) {

			
			$this->db->select('book_nurse.*,member.contact_no,member.name,member.patient_code,add_address.address_1,add_address.address_2');
			$this->db->from('book_nurse');
			$this->db->join('member','member.member_id = book_nurse.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = book_nurse.address_id','LEFT');
			//$this->db->where('book_nurse.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
			$this->db->where('book_nurse.book_nurse_id',$service_type[0]);
			$this->db->order_by('book_nurse.book_nurse_id', 'DESC');
			$data['visit_book_history'] = $this->db->get()->result_array();

			$this->db->select('assign_appointment.*,member.contact_no,member.patient_code,member.name,manage_team.team_name,employee_master.first_name,employee_master.last_name');
			$this->db->from('assign_appointment');
			$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
			$this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
			$this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
			$this->db->where('assign_appointment.appointment_id',$service_type[0]);
			//$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();

			$data['nurse_service_type'] = $this->db->get_where('nurse_service_type', array('n_status'=>1))->result_array();




        }
        elseif ($service_type[1]==3) {
			
			$this->db->select('book_laboratory_test.*,member.contact_no,member.patient_code,member.name,add_address.address_1,add_address.address_2');
			$this->db->from('book_laboratory_test');
			$this->db->join('member','member.member_id = book_laboratory_test.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
			//$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
			$this->db->where('book_laboratory_test.book_laboratory_test_id',$service_type[0]);
			$this->db->order_by('book_laboratory_test.book_laboratory_test_id', 'DESC');
			// $this->db->where('member.status','1');
			// $this->db->or_where('member.status','0');
			// $this->db->where('add_address.status','1');
			// $this->db->or_where('add_address.status','0');
			$data['visit_book_history'] = $this->db->get()->result_array();

			$this->db->select('assign_appointment.*,member.contact_no,member.name,member.patient_code,manage_team.team_name,employee_master.first_name,employee_master.last_name');
			$this->db->from('assign_appointment');
			$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
			$this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
			$this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
			$this->db->where('assign_appointment.appointment_id',$service_type[0]);
			//$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();

			$data['lab_test_type'] = $this->db->get_where('lab_test_type', array('l_status'=>1))->result_array();
			//echo $this->db->last_query();


        }
        elseif($service_type[1]==4)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
        	$this->db->select('book_medicine.*');
			$this->db->from('book_medicine');
			//$this->db->where('book_medicine.created_date >=',$curr_date);
			//$this->db->where('book_medicine.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('book_medicine.book_medicine_id',$service_type[0]);
			$this->db->order_by('book_medicine.book_medicine_id', 'DESC');
			// $this->db->where('member.status','1');
			// $this->db->or_where('member.status','0');
			// $this->db->where('add_address.status','1');
			// $this->db->or_where('add_address.status','0');
			 $data['visit_book_history'] = $this->db->get()->result_array();

			$this->db->select('assign_appointment.*,manage_team.team_name,employee_master.first_name,employee_master.last_name');
			$this->db->from('assign_appointment');
			//$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
			$this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
			$this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
			$this->db->where('assign_appointment.appointment_id',$service_type[0]);
			//$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			//$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();
			
			
        }
        elseif($service_type[1]==5)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
        	$this->db->select('book_ambulance.*,book_ambulance.amount as total,member.name,member.contact_no,member.patient_code');
			$this->db->from('book_ambulance');
			$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
			$this->db->where('book_ambulance.book_ambulance_id',$service_type[0]);
			//$this->db->where('book_ambulance.date >=',$curr_date);
			//$this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
			$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
			$data['visit_book_history'] = $this->db->get()->result_array();


			$this->db->select('assign_appointment.*,member.contact_no,member.patient_code,member.name,manage_team.team_name,employee_master.first_name,employee_master.last_name');
			$this->db->from('assign_appointment');
			$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
			$this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
			$this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
			$this->db->where('assign_appointment.appointment_id',$service_type[0]);
			//$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();
			// echo $this->db->last_query();
			// exit;
        }
        elseif($service_type[1] == 6)
        {
            $this->db->select('package_booking.*,book_package.*,member.name,member.contact_no,member.patient_code,add_address.address_1,add_address.address_2');
            $this->db->from('package_booking');
            $this->db->join('member', 'member.member_id = package_booking.patient_id', 'LEFT');
            $this->db->join('book_package','book_package.book_package_id = package_booking.book_package_id');
            $this->db->join('add_address','add_address.address_id = book_package.address_id');
            $this->db->where('package_booking.id', $service_type[0]);
            //$this->db->where('book_ambulance.date >=',$curr_date);
            //$this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
            $this->db->order_by('package_booking.id', 'DESC');
            $data['visit_book_history'] = $this->db->get()->result_array();


            $this->db->select('assign_appointment.*,member.contact_no,member.patient_code,member.name,manage_team.team_name,employee_master.first_name,employee_master.last_name');
            $this->db->from('assign_appointment');
            $this->db->join('member', 'member.member_id = assign_appointment.patient_id', 'LEFT');
            $this->db->join('manage_team', 'manage_team.team_id = assign_appointment.team_id', 'LEFT');
            $this->db->join('employee_master', 'employee_master.emp_id = assign_appointment.emp_id', 'LEFT');
            $this->db->where('assign_appointment.appointment_id', $service_type[0]);
            //$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
            $this->db->where("((member.status = '0' OR member.status = '1'))");
            $this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
            $data['assign_appointment_list'] = $this->db->get()->result_array();

            // echo $this->db->last_query();
            // exit;
        }
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/viewAdminHistory',$data);
		$this->load->view(FOOTER);

	}
	public function addAdditonalPayment(){

    	parent::index();
		$post = $this->input->post(NULL, true);

		// echo "<pre>";
		// print_r($post);
		// exit;
		$appointment_book_id=$_POST['assign_appointment_id'];
		$additional_payment=$_POST['additional_payment'];
		$additional_note=$_POST['message'];
		$additional_payment_type=$_POST['additional_payment_type'];
		// echo $assign_appointment_id;
		// exit;
		$user_id=$_POST['user_id'];
		$user_type_id=$_POST['user_type_id'];
		$nurse_service_id=$_POST['nurse_type_validate'];
		$lab_test_id=$_POST['lab_test_validate'];
		if($user_type_id==1)
		{
				$additional_payment_array = array(
				'appointment_id'=>$appointment_book_id,
				'amount'=>$additional_payment,
				'note'=>$additional_note,
				'additional_payment_type'=>$additional_payment_type,
				'user_id'=>$user_id,
				'created_by'=>$this->session->userdata('admin_user')['first_name']." ".$this->session->userdata('admin_user')['last_name']
				
			);
		}
		else if($user_type_id==2)
		{
			$additional_payment_array = array(
				'appointment_id'=>$appointment_book_id,
				'amount'=>$additional_payment,
				'note'=>$additional_note,
				'additional_payment_type'=>$additional_payment_type,
				'nurse_service_id'=>$nurse_service_id,
				'user_id'=>$user_id,
				'created_by'=>$this->session->userdata('admin_user')['first_name']." ".$this->session->userdata('admin_user')['last_name']
				
			);
		}
		elseif ($user_type_id==3) {
			$additional_payment_array = array(
				'appointment_id'=>$appointment_book_id,
				'amount'=>$additional_payment,
				'additional_payment_type'=>$additional_payment_type,
				'note'=>$additional_note,
				'lab_test_id'=>$lab_test_id,
				'user_id'=>$user_id,
				'created_by'=>$this->session->userdata('admin_user')['first_name']." ".$this->session->userdata('admin_user')['last_name']
				
			);
		}
		elseif ($user_type_id==5) {
			$additional_payment_array = array(
				'appointment_id'=>$appointment_book_id,
				'amount'=>$additional_payment,
				'note'=>$additional_note,
				'additional_payment_type'=>$additional_payment_type,
				'user_id'=>$user_id,
				'created_by'=>$this->session->userdata('admin_user')['first_name']." ".$this->session->userdata('admin_user')['last_name']
				
			);
		}
// 		else
// 		{
// 			$additional_payment_array = array(
// 				'appointment_id'=>$appointment_book_id,
// 				'amount'=>$additional_payment,
// 				'note'=>$additional_note,
// 				'additional_payment_type'=>$additional_payment_type,
// 				'user_id'=>$user_id,
// 				'created_by'=>$this->session->userdata('admin_user')['first_name']." ".$this->session->userdata('admin_user')['last_name']
				
// 			);
// 		}
		
		
		if($this->db->insert('additional_payment', $additional_payment_array))
		{
			 $insert_id = $this->db->insert_id();
			
			
			if($additional_payment=='' || $additional_note=='' || $additional_payment_type=='')
			{
				echo "<font color='red'>Please enter details.</font>";
			}
			else
			{
				echo "Additional Payment Details added.";
			}
		}else{
			echo "Something went wrong.";
		}



		// $this->db->where('appointment_book_id',$appointment_book_id);
  //   	if($this->db->update('appointment_book', array('additional_payment' =>$additional_payment,'additional_note' =>$additional_note)))
		// {	
			
		// 	if($additional_payment=='' || $additional_note=='')
		// 	{
		// 		echo "<font color='red'>Please enter details.</font>";
		// 	}
		// 	else
		// 	{
		// 		echo "Additional Payment Details added.";
		// 	}
			
		// 	//$this->session->set_flashdata('message','Assing Visit History added');
		// }else{
		// 	echo "Something went wrong.";
		// 	//$this->session->set_flashdata('message','Something went wrong.');
		// }


		//redirect(base_url().'viewBookingHistory');	
	}
	public function invoice_recipt()
	{
		 
		 
		$post = $this->input->post(NULL, true);

		// echo "<pre>";
		// print_r($post);
		// exit;
		if($_POST['appointment_book_id']!='')
		{
			$this->db->select('appointment_book.*,add_address.address_1,add_address.address_2');
			$this->db->from('appointment_book');
			$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
			//$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('appointment_book.appointment_book_id',$_POST['appointment_book_id']);
			$this->db->order_by('appointment_book.appointment_book_id', 'DESC');
			$appointment_book= $this->db->get()->result_array();
			 // echo $this->db->last_query();
			 // exit;

			foreach ($appointment_book as $value) {
					 $data['appointment_book_id']=$value['appointment_book_id'];
					 $data['patient_id']=$value['patient_id'];
					 $data['tot']=$value['total']+$value['discount'];
					 $data['dis']=$value['discount'];
					 $data['list']=$value['list_id'];
					 $data['date']=$value['date'];
					 $data['doctor']=$value['doctor_id'];
					  $data['address_1']=$value['address_1'];
					   $data['address_2']=$value['address_2'];
					    $data['user_id']=$value['user_id'];
				    # code...
			}
			// echo $data['appointment_book_id'];
			// exit;
			$this->db->select('member.*');
			$this->db->from('member');
			$this->db->where('member.user_id',$data['user_id']);
			$this->db->where('member.member_id', $data['patient_id']);
			$this->db->order_by('member.member_id', 'DESC');
			$member= $this->db->get()->result_array();

			foreach ($member as $value) {

					 $data1['name']=$value['name'];
					  $data1['patient_code']=$value['patient_code'];
					  $data1['address']=$data['address_1']." ".$data['address_2'];
					  $data1['city_id']=$value['city_id'];
					 // $data['list']=$value['list_id'];
					 // $data['date']=$value['date'];
					 // $data['doctor']=$value['doctor_id'];
				    # code...
			}


			/*$this->db->select('extra_invoice.*');
			$this->db->from('extra_invoice');
			$this->db->where('extra_invoice.user_id',$data['user_id']);
			$this->db->where('extra_invoice.appointment_book_id',$_POST['appointment_book_id']);
			$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$extra_invoice= $this->db->get()->result_array();*/

			$this->db->select('extra_invoice.*,additional_payment.amount,additional_payment.note');
			$this->db->from('extra_invoice');
			$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.appointment_book_id','LEFT');
			$this->db->where('extra_invoice.user_id',$data['user_id']);
			$this->db->where('extra_invoice.appointment_book_id',$_POST['appointment_book_id']);
			$this->db->group_by('additional_payment.id'); 

			$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$extra_invoice= $this->db->get()->result_array();

			

			foreach ($extra_invoice as $value) {

					 $data2['extra_invoice_id']=$value['extra_invoice_id'];
					  $data2['list_data']=$value['list'];
					  $data2['amount'] +=$value['amount'];
					  $data2['note'] = $value['note'];
					 
			}
		}
		elseif($_POST['book_nurse_id']!='')
		{



			$this->db->select('book_nurse.*,add_address.address_1,add_address.address_2');
			$this->db->from('book_nurse');
			$this->db->join('add_address','add_address.address_id = book_nurse.address_id','LEFT');
			//$this->db->where('book_nurse.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('book_nurse.book_nurse_id',$_POST['book_nurse_id']);
			$this->db->order_by('book_nurse.book_nurse_id', 'DESC');
			$nurse_appointment_book= $this->db->get()->result_array();
			 

			foreach ($nurse_appointment_book as $value) {
					 $data['book_nurse_id']=$value['book_nurse_id'];
					 $data['patient_id']=$value['patient_id'];
					 $data['tot']=$value['total']+$value['discount'];
					 $data['dis']=$value['discount'];
					 $data['list']=$value['list_id'];
					 $data['date']=$value['date'];
					 $data['doctor']=$value['doctor_id'];
					  $data['address_1']=$value['address_1'];
					   $data['address_2']=$value['address_2'];
					    $data['user_id']=$value['user_id'];
				    # code...
			}

			$this->db->select('member.*');
			$this->db->from('member');
			$this->db->where('member.user_id',$data['user_id']);
			$this->db->where('member.member_id', $data['patient_id']);
			$this->db->order_by('member.member_id', 'DESC');
			$member= $this->db->get()->result_array();

			foreach ($member as $value) {

					 $data1['name']=$value['name'];
					 $data1['patient_code']=$value['patient_code'];
					  $data1['address']=$data['address_1']." ".$data['address_2'];
					  $data1['city_id']=$value['city_id'];
					 // $data['list']=$value['list_id'];
					 // $data['date']=$value['date'];
					 // $data['doctor']=$value['doctor_id'];
				    # code...
			}


			// $this->db->select('extra_invoice.*');
			// $this->db->from('extra_invoice');
			// $this->db->where('extra_invoice.user_id',$data['user_id']);
			// $this->db->where('extra_invoice.book_nurse_id',$_POST['book_nurse_id']);
			// $this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			// $extra_invoice= $this->db->get()->result_array();

			$this->db->select('extra_invoice.*,additional_payment.amount,additional_payment.note');
			$this->db->from('extra_invoice');
			$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.book_nurse_id','LEFT');
			$this->db->where('extra_invoice.user_id',$data['user_id']);
			$this->db->where('extra_invoice.book_nurse_id',$_POST['book_nurse_id']);
			$this->db->group_by('additional_payment.id'); 

			$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$extra_invoice= $this->db->get()->result_array();
			

			foreach ($extra_invoice as $value) {

					 $data2['extra_invoice_id']=$value['extra_invoice_id'];
					  $data2['list_data']=$value['list'];
					 $data2['amount'] +=$value['amount'];
					  $data2['note'] = $value['note'];
					 
			}
		}
		elseif($_POST['book_laboratory_test_id']!='')
		{

			$this->db->select('book_laboratory_test.*,add_address.address_1,add_address.address_2');
			$this->db->from('book_laboratory_test');
			$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
			//$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('book_laboratory_test.book_laboratory_test_id',$_POST['book_laboratory_test_id']);
			$this->db->order_by('book_laboratory_test.book_laboratory_test_id', 'DESC');
			$lab_appointment_book= $this->db->get()->result_array();
			
			foreach ($lab_appointment_book as $value) {
					$data['book_laboratory_test_id']=$value['book_laboratory_test_id'];
					 $data['patient_id']=$value['patient_id'];
					 $data['tot']=$value['total']+$value['discount'];
					 $data['dis']=$value['discount'];
					 $data['list']=$value['list_id'];
					 $data['date']=$value['date'];
					 $data['doctor']=$value['doctor_id'];
					 $data['address_1']=$value['address_1'];
					 $data['address_2']=$value['address_2'];
					  $data['user_id']=$value['user_id'];
				    # code...
			}

			$this->db->select('member.*');
			$this->db->from('member');
			$this->db->where('member.user_id',$data['user_id']);
			$this->db->where('member.member_id', $data['patient_id']);
			$this->db->order_by('member.member_id', 'DESC');
			$member= $this->db->get()->result_array();

			foreach ($member as $value) {

					 $data1['name']=$value['name'];
					  $data1['patient_code']=$value['patient_code'];
					  $data1['address']=$data['address_1']." ".$data['address_2'];
					  $data1['city_id']=$value['city_id'];
					 // $data['list']=$value['list_id'];
					 // $data['date']=$value['date'];
					 // $data['doctor']=$value['doctor_id'];
				    # code...
			}


			// $this->db->select('extra_invoice.*');
			// $this->db->from('extra_invoice');
			// $this->db->where('extra_invoice.user_id',$data['user_id']);
			// $this->db->where('extra_invoice.book_laboratory_test_id',$_POST['book_laboratory_test_id']);
			// $this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			// $extra_invoice= $this->db->get()->result_array();
			$this->db->select('extra_invoice.*,additional_payment.amount,additional_payment.note');
			$this->db->from('extra_invoice');
			$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.book_laboratory_test_id','LEFT');
			$this->db->where('extra_invoice.user_id',$data['user_id']);
			$this->db->where('extra_invoice.book_laboratory_test_id',$_POST['book_laboratory_test_id']);
			$this->db->group_by('additional_payment.id'); 

			$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$extra_invoice= $this->db->get()->result_array();
			

			foreach ($extra_invoice as $value) {

					 $data2['extra_invoice_id']=$value['extra_invoice_id'];
					  $data2['list_data']=$value['list'];
					  $data2['amount'] +=$value['amount'];
					  $data2['note'] = $value['note'];
					 
			}
		}   

			

				

			
			$data_all = array_merge($data,$data1,$data2);

// 			echo "<pre>";
// print_r($data_all);
// exit;
			
			//exit;
			$this->load->view('admin/invoice',$data_all);
	}
	public function cancle_appointment()
	{
		 

		$post = $this->input->post(NULL, true);
		
		
			if($post['appointment_book_id']!='')
			{
					$this->db->select('appointment_book.*');
					$this->db->from('appointment_book');
					//$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
					$this->db->where('appointment_book.appointment_book_id',$_POST['appointment_book_id']);
					$this->db->order_by('appointment_book.appointment_book_id', 'DESC');
					$appointment_book= $this->db->get()->result_array();
					// echo $this->db->last_query();
					// exit;
					foreach ($appointment_book as $value) {

							 $confirm=$value['confirm'];
							 $total=$value['total'];
							 $paymentmade=$value['paymentmade'];
							 $discount=$value['discount'];
							  $user_id=$value['user_id'];
							
						    # code...
					}

				if($total == 0){
				if($paymentmade == 'credit')
				     $total=$discount;
				}
				if($confirm == 1)
				{

					 $this->db->where('appointment_book_id',$_POST['appointment_book_id']);
	                // $this->db->update('appointment_book', array('confirm' => 0));
					 
	                 if($this->db->update('appointment_book',array('cancel' =>date('Y-m-d'),'confirm' => 0,'responsestatus' => 'TXN_CANCELLED')))
			        {
		                $this->db->select('*');
	                    $this->db->from('user');
	                    $this->db->where('user_id',$user_id);
	                    $user_details = $this->db->get()->result_array();
	                    
	                    foreach ($user_details as $value) {

							 $bal=$value['balance'];
							 $mobile=$value['mobile'];
							 $email=$value['email'];
						
					  
						}
					    
					    $cur=$bal+$total;
					    $this->db->where('user_id',$user_id);
					   // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
					  //  echo $this->db->last_query();
					   // exit;
	                    if($this->db->update('user',array('balance'=>$cur)))
			            {

			            		$message = urlencode("We are sad that you cancelled your booking with id '".$_POST['appointment_book_id']."'. Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
	                    		
	                    		$this->db->select('*');
			                    $this->db->from('sms_detail');
			                    $sms_detail = $this->db->get()->result_array();

	                            $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
	                                    $response = file_get_contents($smsurl);

	                            $this->load->library('email');

	                             $mail_message = "
								<p>Dear User, </p>
								<p>We are sad that you cancelled your booking with id ".$_POST['appointment_book_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again! </p>
								<br><br><br><br><br><br>
								<p> Regards,</p>
								<p><b> Dratdoorstep</b></p>
								";
	                            $config['protocol'] = 'sendmail';
	                            $config['mailpath'] = '/usr/sbin/sendmail';

	                            $config['mailtype'] = 'html'; // or html
	                      //  $this->load->library('email');
	                      //  $this->email->from('no-reply@example.com');
	                            $this->email->initialize($config);

	                            //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
	                            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
	                            $this->email->to($email);
	                            $this->email->subject('DratDoorStep');
	                            $this->email->message($mail_message);
	                              
	                            if ($this->email->send()) 
	                            {

	                                   //redirect(BookingHistory)
	                            	$this->session->set_flashdata('message','Your appointment has been cancelled successfully!!');
	                                   redirect(base_url().'adminAppointmentList');	
	                            }
	                            else 
	                            {
	                                    $this->session->set_flashdata('message','Something went wrong.');
	                                    redirect(base_url().'adminAppointmentList');	
	                            }
	                                       // redirect(base_url());
			            }
			            else
			            {
							$this->session->set_flashdata('message','Address is updated.');
	                        redirect(base_url().'adminAppointmentList');

			            }
			         }
			         else
			         {
			         		$this->session->set_flashdata('message','This appointment has already been cancelled!!.');
	                        redirect(base_url().'adminAppointmentList');
			         }


				}
		    }
		    elseif($post['book_nurse_id']!='')
			{
					$this->db->select('book_nurse.*');
					$this->db->from('book_nurse');
					//$this->db->where('book_nurse.user_id',$this->session->userdata('user')['user_id']);
					$this->db->where('book_nurse.book_nurse_id',$post['book_nurse_id']);
					$this->db->order_by('book_nurse.book_nurse_id', 'DESC');
					$appointment_book= $this->db->get()->result_array();
					foreach ($appointment_book as $value) {

							 $confirm=$value['confirm'];
							 $total=$value['total'];
							 $paymentmade=$value['paymentmade'];
							 $discount=$value['discount'];
							  $user_id=$value['user_id'];
							
						    # code...
					}
				if($total == 0){
				if($paymentmade == 'credit')
				     $total=$discount;
				}
				if($confirm == 1)
				{

					 $this->db->where('book_nurse_id',$post['book_nurse_id']);
	                // $this->db->update('appointment_book', array('confirm' => 0));
					 
	                 if($this->db->update('book_nurse',array('cancel' =>date('Y-m-d'),'confirm' => 0,'responsestatus' => 'TXN_CANCELLED')))
			        {
		                $this->db->select('*');
	                    $this->db->from('user');
	                    $this->db->where('user_id',$user_id);
	                    $user_details = $this->db->get()->result_array();
	                    
	                    foreach ($user_details as $value) {

							 $bal=$value['balance'];
							 $mobile=$value['mobile'];
							 $email=$value['email'];
						
					  
						}
					    
					    $cur=$bal+$total;
					    $this->db->where('user_id',$user_id);
					   // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
					  //  echo $this->db->last_query();
					   // exit;
	                    if($this->db->update('user',array('balance'=>$cur)))
			            {

			            		$message = urlencode("We are sad that you cancelled your booking with id ".$post['book_nurse_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
	                    		
	                    		$this->db->select('*');
			                    $this->db->from('sms_detail');
			                    $sms_detail = $this->db->get()->result_array();

	                            $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
	                                    $response = file_get_contents($smsurl);

	                            $this->load->library('email');

	                             $mail_message = "
								<p>Dear User, </p>
								<p>We are sad that you cancelled your booking with id ".$post['book_nurse_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again! </p>
								<br><br><br><br><br><br>
								<p> Regards,</p>
								<p><b> Dratdoorstep</b></p>
								";
	                            $config['protocol'] = 'sendmail';
	                            $config['mailpath'] = '/usr/sbin/sendmail';

	                            $config['mailtype'] = 'html'; // or html
	                      //  $this->load->library('email');
	                      //  $this->email->from('no-reply@example.com');
	                            $this->email->initialize($config);

	                            //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
	                            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
	                            $this->email->to($email);
	                            $this->email->subject('DratDoorStep');
	                            $this->email->message($mail_message);
	                              
	                            if ($this->email->send()) 
	                            {

	                                   //redirect(BookingHistory)
	                            	$this->session->set_flashdata('message','Your appointment has been cancelled successfully!!');
	                                   redirect(base_url().'adminAppointmentList');
	                            }
	                            else 
	                            {
	                                    $this->session->set_flashdata('message','Something went wrong.');
	                                    redirect(base_url().'adminAppointmentList');
	                            }
	                                       // redirect(base_url());
			            }
			            else
			            {
							$this->session->set_flashdata('message','Address is updated.');
	                        redirect(base_url().'adminAppointmentList');

			            }
			         }
			         else
			         {
			         		$this->session->set_flashdata('message','This appointment has already been cancelled!!.');
	                        redirect(base_url().'adminAppointmentList');
			         }


				  }
		    }
		    elseif($post['book_laboratory_test_id']!='')
			{
					$this->db->select('book_laboratory_test.*');
					$this->db->from('book_laboratory_test');
					//$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
					$this->db->where('book_laboratory_test.book_laboratory_test_id',$post['book_laboratory_test_id']);
					$this->db->order_by('book_laboratory_test.book_laboratory_test_id', 'DESC');
					$appointment_book= $this->db->get()->result_array();
					foreach ($appointment_book as $value) {

							 $confirm=$value['confirm'];
							 $total=$value['total'];
							 $paymentmade=$value['paymentmade'];
							 $discount=$value['discount'];
							  $user_id=$value['user_id'];
							
						    # code...
					}
				if($total == 0){
				if($paymentmade == 'credit')
				     $total=$discount;
				}
				if($confirm == 1)
				{

					 $this->db->where('book_laboratory_test_id',$post['book_laboratory_test_id']);
	                // $this->db->update('appointment_book', array('confirm' => 0));
					 
	                 if($this->db->update('book_laboratory_test',array('cancel' =>date('Y-m-d'),'confirm' => 0,'responsestatus' => 'TXN_CANCELLED')))
			        {
		                $this->db->select('*');
	                    $this->db->from('user');
	                    $this->db->where('user_id',$user_id);
	                    $user_details = $this->db->get()->result_array();
	                    
	                    foreach ($user_details as $value) {

							 $bal=$value['balance'];
							 $mobile=$value['mobile'];
							 $email=$value['email'];
						
					  
						}
					    
					    $cur=$bal+$total;
					    $this->db->where('user_id',$user_id);
					   // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
					  //  echo $this->db->last_query();
					   // exit;
	                    if($this->db->update('user',array('balance'=>$cur)))
			            {

			            		$message = urlencode("We are sad that you cancelled your booking with id ".$post['book_laboratory_test_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
	                    		
	                    		$this->db->select('*');
			                    $this->db->from('sms_detail');
			                    $sms_detail = $this->db->get()->result_array();

	                            $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
	                                    $response = file_get_contents($smsurl);

	                            $this->load->library('email');

	                             $mail_message = "
								<p>Dear User, </p>
								<p>We are sad that you cancelled your booking with id ".$post['book_laboratory_test_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again! </p>
								<br><br><br><br><br><br>
								<p> Regards,</p>
								<p><b> Dratdoorstep</b></p>
								";
	                            $config['protocol'] = 'sendmail';
	                            $config['mailpath'] = '/usr/sbin/sendmail';

	                            $config['mailtype'] = 'html'; // or html
	                      //  $this->load->library('email');
	                      //  $this->email->from('no-reply@example.com');
	                            $this->email->initialize($config);

	                            //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
	                            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
	                            $this->email->to($email);
	                            $this->email->subject('DratDoorStep');
	                            $this->email->message($mail_message);
	                              
	                            if ($this->email->send()) 
	                            {

	                                   //redirect(BookingHistory)
	                            	$this->session->set_flashdata('message','Your appointment has been cancelled successfully!!');
	                                   redirect(base_url().'adminAppointmentList');
	                            }
	                            else 
	                            {
	                                    $this->session->set_flashdata('message','Something went wrong.');
	                                    redirect(base_url().'adminAppointmentList');
	                            }
	                                       // redirect(base_url());
			            }
			            else
			            {
							$this->session->set_flashdata('message','Address is updated.');
	                        redirect(base_url().'adminAppointmentList');

			            }
			         }
			         else
			         {
			         		$this->session->set_flashdata('message','This appointment has already been cancelled!!.');
	                        redirect(base_url().'adminAppointmentList');
			         }


				  }
		    }
			elseif($post['id']!='')
			{
					$this->db->select('package_booking.*, book_package.*');
					$this->db->from('package_booking');
					$this->db->join('book_package','book_package.book_package_id = package_booking.book_package_id');
					$this->db->where('id',$post['id']);
					$this->db->order_by('id', 'DESC');
					$appointment_book= $this->db->get()->result_array();
					// echo $this->db->last_query();
					// exit;
					foreach ($appointment_book as $value) {

							 $confirm=$value['confirm'];
							 $total=$value['total'];
							 $paymentmade=$value['paymentmade'];
							 $discount=$value['discount'];
							  $user_id=$value['user_id'];
							
						    # code...
					}
				if($total == 0){
				if($paymentmade == 'credit')
				     $total=$discount;
				}
				if($confirm == 1)
				{

					 $this->db->where('book_package_id',$value['book_package_id']);
					 
	                 if($this->db->update('book_package',array('cancel' =>date('Y-m-d'),'confirm' => 0,'responsestatus' => 'TXN_CANCELLED')))
			        {
		                $this->db->select('*');
	                    $this->db->from('user');
	                    $this->db->where('user_id',$user_id);
	                    $user_details = $this->db->get()->result_array();
	                    
	                    foreach ($user_details as $value) {

							 $bal=$value['balance'];
							 $mobile=$value['mobile'];
							 $email=$value['email'];
						
					  
						}
					    
					    $cur=$bal+$total;
					    $this->db->where('user_id',$user_id);
					   // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
					  //  echo $this->db->last_query();
					   // exit;
	                    if($this->db->update('user',array('balance'=>$cur)))
			            {
			            		$message = urlencode("We are sad that you cancelled your booking with id ".$value['book_package_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
	                    		
	                    		$this->db->select('*');
			                    $this->db->from('sms_detail');
			                    $sms_detail = $this->db->get()->result_array();

	                            $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
	                                    $response = file_get_contents($smsurl);

	                            $this->load->library('email');

	                             $mail_message = "
								<p>Dear User, </p>
								<p>We are sad that you cancelled your booking with id ".$value['book_package_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again! </p>
								<br><br><br><br><br><br>
								<p> Regards,</p>
								<p><b> Dratdoorstep</b></p>
								";
	                            $config['protocol'] = 'sendmail';
	                            $config['mailpath'] = '/usr/sbin/sendmail';

	                            $config['mailtype'] = 'html'; // or html
	                      //  $this->load->library('email');
	                      //  $this->email->from('no-reply@example.com');
	                            $this->email->initialize($config);

	                            //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
	                            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
	                            $this->email->to($email);
	                            $this->email->subject('DratDoorStep');
	                            $this->email->message($mail_message);
	                              
	                            if ($this->email->send()) 
	                            {

	                                   //redirect(BookingHistory)
	                            	$this->session->set_flashdata('message','Your appointment has been cancelled successfully!!');
	                                   redirect(base_url().'adminAppointmentList');
	                            }
	                            else 
	                            {
	                                    $this->session->set_flashdata('message','Something went wrong.');
	                                    redirect(base_url().'adminAppointmentList');
	                            }
	                                       // redirect(base_url());
			            }
			            else
			            {
							$this->session->set_flashdata('message','Address is updated.');
	                        redirect(base_url().'adminAppointmentList');

			            }
			         }
			         else
			         {
			         		$this->session->set_flashdata('message','This appointment has already been cancelled!!.');
	                        redirect(base_url().'adminAppointmentList');
			         }


				  }
		    }
		}
		public function adminEditDoctorAppointment()
		{
		parent::index();
		$post = $this->input->post(NULL, true);
		$appointment_book_id = $post['btn_edit_appointment'];
		

		

		$data['appointment_book'] = $this->db->get_where('appointment_book', array('appointment_book_id'=>$appointment_book_id))->row_array();
		
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$data['appointment_book']['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
		$this->db->from('user');
		 $this->db->where('user.user_id',$data['appointment_book']['user_id']);
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();
		// echo "<pre>";
		// print_r($data['member']);
		// exit;
		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$data['appointment_book']['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		$data['doctor_type'] = $this->db->get_where('doctor_type', array('d_status'=>1))->result_array();
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/editBookDoctorAppointment',$data);
		$this->load->view(FOOTER);
	}
	public function updateDoctorAppointment(){
		$post = $this->input->post(NULL, true);
		

		$update_doctor_appointment_array = array(
			
			'date'=>$post['date'],
			'time'=>$post['time'],
			'gatewayname'=>$post['payment_type'],
		);

		$this->db->where(array('appointment_book_id'=>$post['appointment_book_id']));	
		if($this->db->update('appointment_book',$update_doctor_appointment_array))
		{
// 			echo $this->db->last_query();
// 			exit;

			$this->session->set_flashdata('message','Doctor Appoinment is updated.');
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		redirect(base_url().'adminAppointmentList');	
	}
	public function adminEditNurseAppointment()
		{
		parent::index();
		$post = $this->input->post(NULL, true);
		$book_nurse_id = $post['btn_edit_appointment'];
		

		

		//$data['appointment_book'] = $this->db->get_where('appointment_book', array('appointment_book_id'=>$book_nurse_id))->row_array();
		$data['appointment_book'] = $this->db->get_where('book_nurse', array('book_nurse_id'=>$book_nurse_id))->row_array();
		
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$data['appointment_book']['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
		$this->db->from('user');
		 $this->db->where('user.user_id',$data['appointment_book']['user_id']);
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();
		// echo "<pre>";
		// print_r($data['member']);
		// exit;
		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$data['appointment_book']['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		//$data['doctor_type'] = $this->db->get_where('doctor_type', array('d_status'=>1))->result_array();
		$data['nurse_service_type'] = $this->db->get_where('nurse_service_type', array('n_status'=>1))->result_array();
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/editBookNurseAppointment',$data);
		$this->load->view(FOOTER);
	}
	public function updateNurseAppointment(){
		$post = $this->input->post(NULL, true);
		

		$update_nurse_appointment_array = array(
			
			'date'=>$post['date'],
			'time'=>$post['time'],
			'gatewayname'=>$post['payment_type'],
		);

		$this->db->where(array('book_nurse_id'=>$post['book_nurse_id']));	
		if($this->db->update('book_nurse',$update_nurse_appointment_array))
		{
			//echo $this->db->last_query();

			$this->session->set_flashdata('message','Nurse Appoinment is updated.');
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		redirect(base_url().'adminAppointmentList');	
	}
	public function adminEditLabAppointment()
	{
		parent::index();
		$post = $this->input->post(NULL, true);
		$book_laboratory_test_id = $post['btn_edit_appointment'];
		// echo "<pre>";
		// print_r($post);
		// exit;

		

		$data['appointment_book'] = $this->db->get_where('book_laboratory_test', array('book_laboratory_test_id'=>$book_laboratory_test_id))->row_array();

		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$data['appointment_book']['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
		$this->db->from('user');
		 $this->db->where('user.user_id',$data['appointment_book']['user_id']);
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();
		// echo "<pre>";
		// print_r($data['member']);
		// exit;
		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$data['appointment_book']['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		$data['lab_test_type'] = $this->db->get_where('lab_test_type', array('l_status'=>1))->result_array();
		// $this->load->view(USERHEADER);
		// $this->load->view('user/editBookLabAppointment',$data);
		// $this->load->view(USERFOOTER);
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/editBookLabAppointment',$data);
		$this->load->view(FOOTER);
	}
	public function updateLabAppointment(){
		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);
		// exit;
		$update_lab_appointment_array = array(
			
			'date'=>$post['date'],
			'time'=>$post['time'],
			'complain'=>$post['complain'],
			'gatewayname'=>$post['payment_type'],
		);

		$this->db->where(array('book_laboratory_test_id'=>$post['book_laboratory_test_id']));	
		if($this->db->update('book_laboratory_test',$update_lab_appointment_array))
		{
			//echo $this->db->last_query();

			$this->session->set_flashdata('message','Lab Appoinment is updated.');
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		redirect(base_url().'adminAppointmentList');	
	}
	public function adminEditPharmacyAppointment()
	{
		parent::index();
		$post = $this->input->post(NULL, true);
		$book_medicine_id = $post['btn_edit_appointment'];
		// echo $book_medicine_id;
		// exit;
		// echo "<pre>";
		// print_r($post);
		// exit;

		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();

		$data['appointment_book'] = $this->db->get_where('book_medicine', array('book_medicine_id'=>$book_medicine_id))->row_array();
		// echo $this->db->last_query();
		// exit;

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/editBookPharmacyAppointment',$data);
		$this->load->view(FOOTER);
	}
	public function updatePharmacyAppointment(){
		$post = $this->input->post(NULL, true);
// 		echo "<pre>";
// 		print_r($post);
// 		// print_r($_FILES);
// exit;
		 $image=$_FILES['img_profile']['name'];
		//exit;
		$pharmacy_appointment_array = array(


			'user_id'=>$post['user_id'],
			'name'=>$post['name'],
			'mobile'=>$post['mobile'],
			'landline'=>$post['landline'],
			'address'=>$post['address']." ",
			'city_id'=>$post['city_id'],
			'booked_by'=>$this->session->userdata('admin_user')['user_id'],
			'created_date'=>date('Y-m-d'),
			
			
			
			
		);

		$this->db->where(array('book_medicine_id'=>$post['book_medicine_id']));	
		if($this->db->update('book_medicine',$pharmacy_appointment_array))
		{
			//echo $this->db->last_query();
			if($_FILES['img_profile']['name']!=''){
				// echo "test";
				// exit;
				//echo "fdfd".$post['book_medicine_id'];
				 $this->General_model->uploadPharmacyImage('./uploads/pharmacy_document/', $post['book_medicine_id'],'profile_','img_profile', 'book_medicine','prescription');
				//exit;
			}
			

			$this->session->set_flashdata('message','Lab Appoinment is updated.');
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		redirect(base_url().'adminAppointmentList');	
	}
	public function adminEditAmbulanceAppointment()
	{
		parent::index();
		$post = $this->input->post(NULL, true);

		$book_ambulance_id = $post['btn_edit_appointment'];
		

		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();

		$data['appointment_book'] = $this->db->get_where('book_ambulance', array('book_ambulance_id'=>$book_ambulance_id))->row_array();


		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$data['appointment_book']['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
		$this->db->from('user');
		 $this->db->where('user.user_id',$data['appointment_book']['user_id']);
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();

		/*echo $this->db->last_query();
		exit;*/

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/editBookAmbulanceAppointment',$data);
		$this->load->view(FOOTER);
	}
	public function updateAmbulanceAppointment(){
		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);
		// exit;
		$update_ambulance_appointment_array = array(
			
			'date'=>$post['date'],
			'time'=>$post['time'],
			'gatewayname'=>$post['payment_type'],
		);

		$this->db->where(array('book_ambulance_id'=>$post['book_ambulance_id']));	
		if($this->db->update('book_ambulance',$update_ambulance_appointment_array))
		{
			//echo $this->db->last_query();

			$this->session->set_flashdata('message','Ambulance Appoinment is updated.');
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		redirect(base_url().'adminAppointmentList');	
	}
	
	public function tele_consulting_list()
    {
        $super_admin = $this->session->userdata('admin_user')['emp_id'];
        $doctor = $this->session->userdata('admin_user')['user_type_id'];
        $admin = $this->session->userdata('admin_user')['user_type_id'];
        $front_office = $this->session->userdata('admin_user')['user_type_id'];
        $manager = $this->session->userdata('admin_user')['user_type_id'];
        
        if($super_admin == -1 || $doctor == 1 || $admin == 6 || $manager == 8 || $front_office == 7) 
        {
            // echo "Hi";
            // exit;
            $this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2,user.first_name,user.last_name');
            $this->db->from('appointment_book');
            $this->db->join('member', 'member.member_id = appointment_book.patient_id', 'LEFT');
            $this->db->join('user','user.user_id = appointment_book.user_id');
            $this->db->join('add_address', 'add_address.address_id = appointment_book.address_id', "LEFT");
            $this->db->join('assign_appointment', 'assign_appointment.appointment_id = appointment_book.appointment_book_id', 'LEFT');
            $this->db->where('appointment_book.doctor_type_id', 9);
            $this->db->order_by('appointment_book.appointment_book_id', 'DESC');
            $data['tele_list'] = $this->db->get()->result_array();

            $this->db->select('*');
            $this->db->from('manage_team');
            $this->db->where('team_status', 1);
            $data['manage_team_assign'] = $this->db->get()->result_array();  

            $this->db->select('employee_master.*,user_type.user_type_name');
            $this->db->from('employee_master');
            $this->db->join('user_type', 'user_type.user_type_id = employee_master.user_type_id', 'LEFT');
            $this->db->where('employee_master.emp_status', 1);
            $data['manage_employee_assign'] = $this->db->get()->result_array();  
        }
            $this->load->view(HEADER,$this->viewdata);
            $this->load->view('admin/TeleConsultingList.php', $data);
            $this->load->view(FOOTER);
    }
}
