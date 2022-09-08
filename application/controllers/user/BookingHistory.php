<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class BookingHistory extends CI_Controller {

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
		 $this->load->model('General_model');
		
		  $this->load->model('user/Login_model');
		// $this->load->model('General_model');
		if(!$this->Login_model->check_user_login()){
			redirect(base_url());
		}

	}

	public function index()
	{
		 
		 
		
		 $date = new DateTime("now");
	     $curr_date = $date->format('Y-m-d');

		    $this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
			$this->db->from('appointment_book');
			$this->db->join('member','member.member_id = appointment_book.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
			$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
			//$this->db->where('appointment_book.confirm',1);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
			$this->db->order_by('appointment_book.date', 'DESC');
			$data['appointment_book']= $this->db->get()->result_array();
			// echo $this->db->last_query();
			// exit;
			$this->load->view(USERHEADER);
			$this->load->view(BOOKINGHISTORY,$data);
		    $this->load->view(USERFOOTER);
	}
	public function allBookingHistory()
	{
		extract($_POST);

		
       
       $date = new DateTime("now");
	   $curr_date = $date->format('Y-m-d');

        if($_POST['id']==1)
        {
        	 $this->db->select('appointment_book.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
			$this->db->from('appointment_book');
			$this->db->join('member','member.member_id = appointment_book.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
			$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
			//$this->db->where('appointment_book.confirm',1);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
			$this->db->order_by('appointment_book.date', 'DESC');
			// $this->db->where('member.status','1');
			// $this->db->or_where('member.status','0');
			// $this->db->where('add_address.status','1');
			// $this->db->or_where('add_address.status','0');
			$data['appointment_book']= $this->db->get()->result_array();

        }
        elseif ($_POST['id']==2) {

			
			$this->db->select('book_nurse.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
			$this->db->from('book_nurse');
			$this->db->join('member','member.member_id = book_nurse.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = book_nurse.address_id','LEFT');
			//$this->db->where('book_nurse.date >=',$curr_date);
			$this->db->where('book_nurse.user_id',$this->session->userdata('user')['user_id']);
			//$this->db->where('book_nurse.confirm',1);
			//$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
			//$this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
			$this->db->order_by('book_nurse.date', 'DESC');
			// $this->db->where('member.status','1');
			// $this->db->or_where('member.status','0');
			// $this->db->where('add_address.status','1');
			// $this->db->or_where('add_address.status','0');
			$data['appointment_book'] = $this->db->get()->result_array();
        }
        elseif ($_POST['id']==3) {
			
			$this->db->select('book_laboratory_test.*,member.contact_no,member.name,add_address.address_1,add_address.address_2');
			$this->db->from('book_laboratory_test');
			$this->db->join('member','member.member_id = book_laboratory_test.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
			//$this->db->where('book_laboratory_test.date >=',$curr_date);
			$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
			//$this->db->where('book_laboratory_test.confirm',1);

			//$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
			//$this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
			$this->db->order_by('book_laboratory_test.date', 'DESC');
			// $this->db->where('member.status','1');
			// $this->db->or_where('member.status','0');
			// $this->db->where('add_address.status','1');
			// $this->db->or_where('add_address.status','0');
			$data['appointment_book'] = $this->db->get()->result_array();
        }
        elseif($_POST['id']==4)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
        	$this->db->select('book_medicine.*');
			$this->db->from('book_medicine');
			//$this->db->where('book_medicine.created_date >=',$curr_date);
			$this->db->where('book_medicine.user_id',$this->session->userdata('user')['user_id']);
			$this->db->order_by('book_medicine.created_date', 'DESC');
			// $this->db->where('member.status','1');
			// $this->db->or_where('member.status','0');
			// $this->db->where('add_address.status','1');
			// $this->db->or_where('add_address.status','0');
			$data['appointment_book'] = $this->db->get()->result_array();
			
			
        }
        elseif($_POST['id']==5)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
        	$this->db->select('book_ambulance.*,member.name as patient_name,member.contact_no');
			$this->db->from('book_ambulance');
			$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
			//$this->db->where('book_ambulance.date >=',$curr_date);
			$this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
			$this->db->order_by('book_ambulance.date', 'DESC');

			
			// $this->db->where('member.status','1');
			// $this->db->or_where('member.status','0');
			// $this->db->where('add_address.status','1');
			// $this->db->or_where('add_address.status','0');
			$data['appointment_book'] = $this->db->get()->result_array();
			//echo $this->db->last_query();
			//exit;
			
			
        }
        $data['service_id']=$_POST['id'];
       // $this->load->view('admin/todayAppointment',$data);
		$this->load->view('user/listBookingHistory',$data);

		
		//echo json_encode($data);
		
		
		
	}
	public function viewBookingHistory()
	{
		
		//$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		

		//$appointment_id=$_POST['btn_view_package'];
		extract($_POST);
       $service_type=explode(',',$_POST[btn_appointment_assign]);
       // echo "<pre>";
       // print_r($service_type);
       // exit;

      // $date = new DateTime("now");
	   //$curr_date = $date->format('Y-m-d');

        if($service_type[1]==1)
        {
        	
        	$this->db->select('appointment_book.*,member.contact_no,member.patient_code,member.name,add_address.address_1,add_address.address_2');
			$this->db->from('appointment_book');
			$this->db->join('member','member.member_id = appointment_book.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
			$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
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
			$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();

			$this->db->select('additional_payment.*');
			$this->db->from('additional_payment');
			//$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = additional_payment.nurse_service_id','LEFT');
			//$this->db->join('lab_test_type','lab_test_type.lab_test_id = additional_payment.lab_test_id','LEFT');
			
			$this->db->where('additional_payment.appointment_id',$service_type[0]);
			$this->db->where('additional_payment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('additional_payment.pay_flag','1');
			
			$data['additional_payment']= $this->db->get()->result_array();
			// echo $this->db->last_query();
			// exit;
			
			

        }
        elseif ($service_type[1]==2) {

			
			$this->db->select('book_nurse.*,member.contact_no,member.name,member.patient_code,add_address.address_1,add_address.address_2');
			$this->db->from('book_nurse');
			$this->db->join('member','member.member_id = book_nurse.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = book_nurse.address_id','LEFT');
			$this->db->where('book_nurse.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
			$this->db->where('book_nurse.book_nurse_id',$service_type[0]);
			$this->db->order_by('book_nurse.book_nurse_id', 'DESC');
			$data['visit_book_history'] = $this->db->get()->result_array();
			//echo $this->db->last_query();

			$this->db->select('assign_appointment.*,member.contact_no,member.name,member.patient_code,manage_team.team_name,employee_master.first_name,employee_master.last_name');
			$this->db->from('assign_appointment');
			$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
			$this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
			$this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
			$this->db->where('assign_appointment.appointment_id',$service_type[0]);
			$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();

			$this->db->select('additional_payment.*,nurse_service_type.nurse_service_name,lab_test_type.lab_test_type_name');
			$this->db->from('additional_payment');
			$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = additional_payment.nurse_service_id','LEFT');
			$this->db->join('lab_test_type','lab_test_type.lab_test_id = additional_payment.lab_test_id','LEFT');
			
			$this->db->where('additional_payment.appointment_id',$service_type[0]);
			$this->db->where('additional_payment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('additional_payment.pay_flag','1');
			
			$data['additional_payment']= $this->db->get()->result_array();



        }
        elseif ($service_type[1]==3) {
			
			$this->db->select('book_laboratory_test.*,member.contact_no,member.name,member.patient_code,add_address.address_1,add_address.address_2');
			$this->db->from('book_laboratory_test');
			$this->db->join('member','member.member_id = book_laboratory_test.patient_id','LEFT');
			$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
			$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
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
			$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();

			$this->db->select('additional_payment.*,nurse_service_type.nurse_service_name,lab_test_type.lab_test_type_name');
			$this->db->from('additional_payment');
			$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = additional_payment.nurse_service_id','LEFT');
			$this->db->join('lab_test_type','lab_test_type.lab_test_id = additional_payment.lab_test_id','LEFT');
			
			$this->db->where('additional_payment.appointment_id',$service_type[0]);
			$this->db->where('additional_payment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('additional_payment.pay_flag','1');
			
			$data['additional_payment']= $this->db->get()->result_array();
			// echo $this->db->last_query();
			// exit;


        }
        elseif($service_type[1]==4)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
        	$this->db->select('book_medicine.*');
			$this->db->from('book_medicine');
			//$this->db->where('book_medicine.created_date >=',$curr_date);
			$this->db->where('book_medicine.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('book_medicine.book_medicine_id',$service_type[0]);
			$this->db->order_by('book_medicine.book_medicine_id', 'DESC');
			// $this->db->where('member.status','1');
			// $this->db->or_where('member.status','0');
			// $this->db->where('add_address.status','1');
			// $this->db->or_where('add_address.status','0');
			 $data['visit_book_history'] = $this->db->get()->result_array();

			/*$this->db->select('assign_appointment.*,member.contact_no,member.name,manage_team.team_name,employee_master.first_name,employee_master.last_name');
			$this->db->from('assign_appointment');
			$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
			$this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
			$this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
			$this->db->where('assign_appointment.appointment_id',$service_type[0]);
			$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();*/

			$this->db->select('assign_appointment.*,manage_team.team_name,employee_master.first_name,employee_master.last_name');
			$this->db->from('assign_appointment');
			//$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
			$this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
			$this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
			$this->db->where('assign_appointment.appointment_id',$service_type[0]);
			$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			//$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();


			// echo $this->db->last_query();
			// exit;
			
			
        }
        elseif($service_type[1]==5)
        {
        	

	   	//	echo $curr_date_book_medicine;
	   		//$date = date('Y-m-d H:i:s');
        	$this->db->select('book_ambulance.*,book_ambulance.amount as total,,member.patient_code,member.name,member.contact_no');
			$this->db->from('book_ambulance');
			$this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
			$this->db->where('book_ambulance.book_ambulance_id',$service_type[0]);
			//$this->db->where('book_ambulance.date >=',$curr_date);
			$this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
			$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
			$data['visit_book_history'] = $this->db->get()->result_array();


			$this->db->select('assign_appointment.*,member.contact_no,member.name,manage_team.team_name,employee_master.first_name,employee_master.last_name');
			$this->db->from('assign_appointment');
			$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
			$this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
			$this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
			$this->db->where('assign_appointment.appointment_id',$service_type[0]);
			$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where("((member.status = '0' OR member.status = '1'))");
			$this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
			$data['assign_appointment_list']= $this->db->get()->result_array();

			$this->db->select('additional_payment.*,nurse_service_type.nurse_service_name,lab_test_type.lab_test_type_name');
			$this->db->from('additional_payment');
			$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = additional_payment.nurse_service_id','LEFT');
			$this->db->join('lab_test_type','lab_test_type.lab_test_id = additional_payment.lab_test_id','LEFT');
			
			$this->db->where('additional_payment.appointment_id',$service_type[0]);
			$this->db->where('additional_payment.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('additional_payment.pay_flag','1');
			
			$data['additional_payment']= $this->db->get()->result_array();
			// echo $this->db->last_query();
			// exit;
			
			
        }
		$this->load->view(USERHEADER);
		$this->load->view('user/viewHistory',$data);
		$this->load->view(USERFOOTER);

	}

	
	/*public function addVisitNotes(){
		$post = $this->input->post(NULL, true);

		// echo "<pre>";
		// print_r($post);
		// echo "</pre>";

		$assign_appointment_id=$_POST['assign_appointment_id'];
		$visit_history_text=$_POST['visit_history_text'];
		// echo $assign_appointment_id;
		// exit;
		

		$this->db->where('assign_appointment_id',$assign_appointment_id);
    	if($this->db->update('assign_appointment', array('visit_history_text' =>$visit_history_text)))
		{
			echo "Assing Visit History added.";
			//$this->session->set_flashdata('message','Assing Visit History added');
		}else{
			echo "Something went wrong.";
			//$this->session->set_flashdata('message','Something went wrong.');
		}


		//redirect(base_url().'viewBookingHistory');	
	}*/
	public function invoice()
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
			$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('appointment_book.appointment_book_id',$_POST['appointment_book_id']);
			$this->db->order_by('appointment_book.appointment_book_id', 'DESC');
			$appointment_book= $this->db->get()->result_array();
			 

			foreach ($appointment_book as $value) {
					 $data['appointment_book_id']=$value['appointment_book_id'];
					 $data['patient_id']=$value['patient_id'];
					 $data['tot']=$value['total'];
					 $data['dis']=$value['discount'];
					 $data['list']=$value['list_id'];
					 $data['date']=$value['date'];
					 $data['doctor']=$value['doctor_id'];
					  $data['address_1']=$value['address_1'];
					   $data['address_2']=$value['address_2'];
				    # code...
			}
			// echo $data['appointment_book_id'];
			// exit;
			$this->db->select('member.*');
			$this->db->from('member');
			$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
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


			$this->db->select('extra_invoice.*,additional_payment.amount,additional_payment.note');
			$this->db->from('extra_invoice');
			$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.appointment_book_id','LEFT');
			$this->db->where('extra_invoice.user_id',$this->session->userdata('user')['user_id']);
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
			$this->db->where('book_nurse.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('book_nurse.book_nurse_id',$_POST['book_nurse_id']);
			$this->db->order_by('book_nurse.book_nurse_id', 'DESC');
			$nurse_appointment_book= $this->db->get()->result_array();
			 

			foreach ($nurse_appointment_book as $value) {
					 $data['book_nurse_id']=$value['book_nurse_id'];
					 $data['patient_id']=$value['patient_id'];
					 $data['tot']=$value['total'];
					 $data['dis']=$value['discount'];
					 $data['list']=$value['list_id'];
					 $data['date']=$value['date'];
					 $data['doctor']=$value['doctor_id'];
					  $data['address_1']=$value['address_1'];
					   $data['address_2']=$value['address_2'];
				    # code...
			}

			$this->db->select('member.*');
			$this->db->from('member');
			$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
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


			$this->db->select('extra_invoice.*,additional_payment.amount,additional_payment.note');
			$this->db->from('extra_invoice');
			$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.book_nurse_id','LEFT');
			$this->db->where('extra_invoice.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('extra_invoice.book_nurse_id',$_POST['book_nurse_id']);
			$this->db->group_by('additional_payment.id'); 
			$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$extra_invoice= $this->db->get()->result_array();
			

			foreach ($extra_invoice as $value) {

					 $data2['extra_invoice_id']=$value['extra_invoice_id'];
					  $data2['list_data']=$value['list'];
					// $data2['amount']=$value['amount'];
					  $data2['amount'] +=$value['amount'];
					   $data2['note'] = $value['note'];
					 
			}
		}
		elseif($_POST['book_laboratory_test_id']!='')
		{

			$this->db->select('book_laboratory_test.*,add_address.address_1,add_address.address_2');
			$this->db->from('book_laboratory_test');
			$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
			$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('book_laboratory_test.book_laboratory_test_id',$_POST['book_laboratory_test_id']);
			$this->db->order_by('book_laboratory_test.book_laboratory_test_id', 'DESC');
			$lab_appointment_book= $this->db->get()->result_array();
			
			foreach ($lab_appointment_book as $value) {
					$data['book_laboratory_test_id']=$value['book_laboratory_test_id'];
					 $data['patient_id']=$value['patient_id'];
					 $data['tot']=$value['total'];
					 $data['dis']=$value['discount'];
					 $data['list']=$value['list_id'];
					 $data['date']=$value['date'];
					 $data['doctor']=$value['doctor_id'];
					 $data['address_1']=$value['address_1'];
					 $data['address_2']=$value['address_2'];
				    # code...
			}

			$this->db->select('member.*');
			$this->db->from('member');
			$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
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


			$this->db->select('extra_invoice.*,additional_payment.amount,additional_payment.note');
			$this->db->from('extra_invoice');
			$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.book_laboratory_test_id','LEFT');
			$this->db->where('extra_invoice.user_id',$this->session->userdata('user')['user_id']);
			$this->db->where('extra_invoice.book_laboratory_test_id',$_POST['book_laboratory_test_id']);
			$this->db->group_by('additional_payment.id');
			$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$extra_invoice= $this->db->get()->result_array();
			

			foreach ($extra_invoice as $value) {

					 $data2['extra_invoice_id']=$value['extra_invoice_id'];
					  $data2['list_data']=$value['list'];
					 //$data2['amount']=$value['amount'];
					  $data2['amount'] +=$value['amount'];
					   $data2['note'] = $value['note'];
					 
			}
		}   

			

				

			
			$data_all = array_merge($data,$data1,$data2);

// 			echo "<pre>";
// print_r($data_all);
// exit;
			
			//exit;
			$this->load->view('user/invoice',$data_all);
		    //$this->load->view(USERFOOTER);
	}


	public function cancle_appointment()
	{
		 

		$post = $this->input->post(NULL, true);
		
		
			if($post['appointment_book_id']!='')
			{
					$this->db->select('appointment_book.*');
					$this->db->from('appointment_book');
					$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
					$this->db->where('appointment_book.appointment_book_id',$_POST['appointment_book_id']);
					$this->db->order_by('appointment_book.appointment_book_id', 'DESC');
					$appointment_book= $this->db->get()->result_array();
					foreach ($appointment_book as $value) {

							 $confirm=$value['confirm'];
							 $total=$value['total'];
							 $paymentmode=$value['paymentmode'];
							 $discount=$value['discount'];
							 //for lead api
							 $patient_id=$value['patient_id'];
							 $address_id=$value['address_id'];
							 $doctor_type_id=$value['doctor_type_id'];
							 $appointment_date=$value['date'];
							 $appointment_time=$value['time'];
							 
							 //for lead api
							 
							
						    # code...
					}
				if($total == 0){
				if($paymentmode == 'credit')
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
	                    $this->db->where('user_id',$this->session->userdata('user')['user_id']);
	                    $user_details = $this->db->get()->result_array();
	                    
	                    foreach ($user_details as $value) {

							 $bal=$value['balance'];
							 $mobile=$value['mobile'];
							 $email=$value['email'];
						
					  
						}
					    
					    $cur=$bal+$total;
					    $this->db->where('user_id',$this->session->userdata('user')['user_id']);
					   // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
					  //  echo $this->db->last_query();
					   // exit;
	                    if($this->db->update('user',array('balance'=>$cur)))
			            {		


			            		$this->db->select('user.email,user.mobile');
					            $this->db->from('user');
					            $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
					            $user_data = $this->db->get()->row_array();

					             $curl = curl_init();
					              curl_setopt_array($curl, array(
					                  CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_data[email].'',
					                  CURLOPT_RETURNTRANSFER => true,
					                  CURLOPT_ENCODING => "",
					                  CURLOPT_MAXREDIRS => 10,
					                  CURLOPT_TIMEOUT => 30,
					                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					                  CURLOPT_CUSTOMREQUEST => "GET",
					                  CURLOPT_HTTPHEADER => array(
					                      "cache-control: no-cache",
					                  ),
					              ));

					              $response = curl_exec($curl);
					              //json convert
					              $data = json_decode($response, TRUE);
					              //json convert
					              $err = curl_error($curl);
					              curl_close($curl);
					              if ($err) {
					                 // echo "cURL Error #:" . $err;
					              } else {
					                   //   echo $response;
					              }

					            $date=date($appointment_date.' H:i:s');
					            $time=date($appointment_date.' '.$appointment_time);
					             
					            $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":149,"ActivityNote":"Cancle Doctor Appoinment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":""},{"SchemaName":"mx_Custom_4","Value":"'.$doctor_type_id.'"},{"SchemaName":"mx_Custom_5","Value":"'.$date.'"},{"SchemaName":"mx_Custom_6","Value":"'.$time.'"},]}';
					          
					           
					            try
					            {
					                $curl = curl_init('https://api-in21.leadsquared.com/v2/ProspectActivity.svc/Create?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
					                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
					                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					                curl_setopt($curl, CURLOPT_HEADER, 0);
					                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
					                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					                        "Content-Type:application/json",
					                        "Content-Length:".strlen($data_string)
					                        ));
					                $json_response = curl_exec($curl);
					                 //$data1 = json_decode($json_response, TRUE);
					                
					              //  echo $json_response;
					                    curl_close($curl);
					            } catch (Exception $ex) 
					            { 
					                curl_close($curl);
					            }

					             $this->db->select('member.*');
                                 $this->db->from('member');
                                $this->db->where('member.member_id',$patient_id);
                                $patient_details = $this->db->get()->row_array();
			            		/*$message = urlencode("We are sad that you cancelled your booking with id '".$_POST['appointment_book_id']."'. Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
	                    		
	                    		$this->db->select('*');
			                    $this->db->from('sms_detail');
			                    $sms_detail = $this->db->get()->result_array();

	                            $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
	                                    $response = file_get_contents($smsurl);*/
	                             $date_appointment=date("d-m-Y",strtotime($appointment_date)); 
	                           $message ="HI ".$patient_details['name'].", We have canceled your appointment for Doctor ".$date_appointment." ". $appointment_time." at DR AT DOORSTEP. If you want to reschedule, Call 7069073088. Team NWPL";
	                            $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
                                    $param[msg] = $message;
                                    $param[userid] = "2000197810";
                                    $param[password] = "Dr@doorstep2020";
                                    $param[v] = "1.1";
                                    $param[msg_type] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
                                    $param[auth_scheme] = "PLAIN";
                                    //Have to URL encode the values
                                    foreach($param as $key=>$val) {
                                    $request.= $key."=".urlencode($val);
                                    //we have to urlencode the values
                                    $request.= "&";
                                    //append the ampersand (&)
                                        //sign after each
                                   // parameter/value pair
                                    }
                                    $request = substr($request, 0, strlen($request)-1);
                                    //remove final (&)
                                            //sign from the request
                                    $url =
                                    "https://enterprise.smsgupshup.com/GatewayAPI/rest?".$request;
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $curl_scraped_page = curl_exec($ch);
                                    curl_close($ch);



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
	                                   redirect(base_url().'BookingHistory');	
	                            }
	                            else 
	                            {
	                                    $this->session->set_flashdata('message','Something went wrong.');
	                                    redirect(base_url().'BookingHistory');	
	                            }
	                                       // redirect(base_url());
			            }
			            else
			            {
							$this->session->set_flashdata('message','Address is updated.');
	                        redirect(base_url().'BookingHistory');

			            }
			         }
			         else
			         {
			         		$this->session->set_flashdata('message','This appointment has already been cancelled!!.');
	                        redirect(base_url().'BookingHistory');
			         }


				  }
		    }
		    elseif($post['book_nurse_id']!='')
			{
					$this->db->select('book_nurse.*');
					$this->db->from('book_nurse');
					$this->db->where('book_nurse.user_id',$this->session->userdata('user')['user_id']);
					$this->db->where('book_nurse.book_nurse_id',$post['book_nurse_id']);
					$this->db->order_by('book_nurse.book_nurse_id', 'DESC');
					$appointment_book= $this->db->get()->result_array();
					foreach ($appointment_book as $value) {

							 $confirm=$value['confirm'];
							 $total=$value['total'];
							 $paymentmode=$value['paymentmode'];
							 $discount=$value['discount'];
							  //for lead api
							 $patient_id=$value['patient_id'];
							 $address_id=$value['address_id'];
							 $nurse_type_id=$value['type'];
							  $days=$value['days'];
							 $appointment_date=$value['date'];
							 $appointment_time=$value['time'];
							 
							 //for lead api
							
						    # code...
					}
				if($total == 0){
				if($paymentmode == 'credit')
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
	                    $this->db->where('user_id',$this->session->userdata('user')['user_id']);
	                    $user_details = $this->db->get()->result_array();
	                    
	                    foreach ($user_details as $value) {

							 $bal=$value['balance'];
							 $mobile=$value['mobile'];
							 $email=$value['email'];
						
					  
						}
					    
					    $cur=$bal+$total;
					    $this->db->where('user_id',$this->session->userdata('user')['user_id']);
					   // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
					  //  echo $this->db->last_query();
					   // exit;
	                    if($this->db->update('user',array('balance'=>$cur)))
			            {

			            		$this->db->select('user.email,user.mobile');
					            $this->db->from('user');
					            $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
					            $user_data = $this->db->get()->row_array();

					             $curl = curl_init();
					              curl_setopt_array($curl, array(
					                  CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_data[email].'',
					                  CURLOPT_RETURNTRANSFER => true,
					                  CURLOPT_ENCODING => "",
					                  CURLOPT_MAXREDIRS => 10,
					                  CURLOPT_TIMEOUT => 30,
					                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					                  CURLOPT_CUSTOMREQUEST => "GET",
					                  CURLOPT_HTTPHEADER => array(
					                      "cache-control: no-cache",
					                  ),
					              ));

					              $response = curl_exec($curl);
					              //json convert
					              $data = json_decode($response, TRUE);
					              //json convert
					              $err = curl_error($curl);
					              curl_close($curl);
					              if ($err) {
					                 // echo "cURL Error #:" . $err;
					              } else {
					                   //   echo $response;
					              }

					            $date=date($appointment_date.' H:i:s');
					            $time=date($appointment_date.' '.$appointment_time);
					             
					            $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":152,"ActivityNote":"Cancle Nurse Appoinment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":""},{"SchemaName":"mx_Custom_4","Value":"'.$nurse_type_id.'"},{"SchemaName":"mx_Custom_5","Value":"'.$date.'"},{"SchemaName":"mx_Custom_6","Value":"'.$time.'"},{"SchemaName":"mx_Custom_7","Value":"'.$days.'"},]}';
					        //  echo $data_string;
					           
					            try
					            {
					                $curl = curl_init('https://api-in21.leadsquared.com/v2/ProspectActivity.svc/Create?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
					                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
					                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					                curl_setopt($curl, CURLOPT_HEADER, 0);
					                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
					                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					                        "Content-Type:application/json",
					                        "Content-Length:".strlen($data_string)
					                        ));
					                $json_response = curl_exec($curl);
					                 //$data1 = json_decode($json_response, TRUE);
					                
					              //  echo $json_response;
					                    curl_close($curl);
					            } catch (Exception $ex) 
					            { 
					                curl_close($curl);
					            }
					          //  exit;

			            		/*$message = urlencode("We are sad that you cancelled your booking with id ".$post['book_nurse_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
	                    		
	                    		$this->db->select('*');
			                    $this->db->from('sms_detail');
			                    $sms_detail = $this->db->get()->result_array();

	                            $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
	                                    $response = file_get_contents($smsurl);*/

	                            $this->db->select('member.*');
                                $this->db->from('member');
                                $this->db->where('member.member_id',$patient_id);
                                $patient_details = $this->db->get()->row_array();

	                           $date_appointment=date("d-m-Y",strtotime($appointment_date)); 
	                           $message ="HI ".$patient_details['name'].", We have canceled your appointment for Nurse ".$date_appointment." ". $appointment_time." at DR AT DOORSTEP. If you want to reschedule, Call 7069073088. Team NWPL";
	                            $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
                                    $param[msg] = $message;
                                    $param[userid] = "2000197810";
                                    $param[password] = "Dr@doorstep2020";
                                    $param[v] = "1.1";
                                    $param[msg_type] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
                                    $param[auth_scheme] = "PLAIN";
                                    //Have to URL encode the values
                                    foreach($param as $key=>$val) {
                                    $request.= $key."=".urlencode($val);
                                    //we have to urlencode the values
                                    $request.= "&";
                                    //append the ampersand (&)
                                        //sign after each
                                   // parameter/value pair
                                    }
                                    $request = substr($request, 0, strlen($request)-1);
                                    //remove final (&)
                                            //sign from the request
                                    $url =
                                    "https://enterprise.smsgupshup.com/GatewayAPI/rest?".$request;
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $curl_scraped_page = curl_exec($ch);
                                    curl_close($ch);

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
	                                   redirect(base_url().'BookingHistory');	
	                            }
	                            else 
	                            {
	                                    $this->session->set_flashdata('message','Something went wrong.');
	                                    redirect(base_url().'BookingHistory');	
	                            }
	                                       // redirect(base_url());
			            }
			            else
			            {
							$this->session->set_flashdata('message','Address is updated.');
	                        redirect(base_url().'BookingHistory');

			            }
			         }
			         else
			         {
			         		$this->session->set_flashdata('message','This appointment has already been cancelled!!.');
	                        redirect(base_url().'BookingHistory');
			         }


				  }
		    }
		    elseif($post['book_laboratory_test_id']!='')
			{
					$this->db->select('book_laboratory_test.*');
					$this->db->from('book_laboratory_test');
					$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
					$this->db->where('book_laboratory_test.book_laboratory_test_id',$post['book_laboratory_test_id']);
					$this->db->order_by('book_laboratory_test.book_laboratory_test_id', 'DESC');
					$appointment_book= $this->db->get()->result_array();
					foreach ($appointment_book as $value) {

							 $confirm=$value['confirm'];
							 $total=$value['total'];
							 $paymentmode=$value['paymentmode'];
							 $discount=$value['discount'];
							  //for lead api
							 $patient_id=$value['patient_id'];
							 $address_id=$value['address_id'];
							 $lab_test_id=$value['lab_test_id'];
							 $appointment_date=$value['date'];
							 $appointment_time=$value['time'];
							 $complain=$value['complain'];
							 $prescription=$value['prescription'];
							 
							 //for lead api
							
						    # code...
					}
				if($total == 0){
				if($paymentmode == 'credit')
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
	                    $this->db->where('user_id',$this->session->userdata('user')['user_id']);
	                    $user_details = $this->db->get()->result_array();
	                    
	                    foreach ($user_details as $value) {

							 $bal=$value['balance'];
							 $mobile=$value['mobile'];
							 $email=$value['email'];
						
					  
						}
					    
					    $cur=$bal+$total;
					    $this->db->where('user_id',$this->session->userdata('user')['user_id']);
					   // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
					  //  echo $this->db->last_query();
					   // exit;
	                    if($this->db->update('user',array('balance'=>$cur)))
			            {
			            		$this->db->select('user.email,user.mobile');
					            $this->db->from('user');
					            $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
					            $user_data = $this->db->get()->row_array();

					             $curl = curl_init();
					              curl_setopt_array($curl, array(
					                  CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_data[email].'',
					                  CURLOPT_RETURNTRANSFER => true,
					                  CURLOPT_ENCODING => "",
					                  CURLOPT_MAXREDIRS => 10,
					                  CURLOPT_TIMEOUT => 30,
					                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					                  CURLOPT_CUSTOMREQUEST => "GET",
					                  CURLOPT_HTTPHEADER => array(
					                      "cache-control: no-cache",
					                  ),
					              ));

					              $response = curl_exec($curl);
					              //json convert
					              $data = json_decode($response, TRUE);
					              //json convert
					              $err = curl_error($curl);
					              curl_close($curl);
					              if ($err) {
					                 // echo "cURL Error #:" . $err;
					              } else {
					                   //   echo $response;
					              }

					            $date=date($appointment_date.' H:i:s');
					            $time=date($appointment_date.' '.$appointment_time);
					             
					            $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":158,"ActivityNote":"Cancle Lab Appoinment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":"'.$lab_test_id.'"},{"SchemaName":"mx_Custom_4","Value":"'.$date.'"},{"SchemaName":"mx_Custom_5","Value":"'.$time.'"},{"SchemaName":"mx_Custom_6","Value":"'.$complain.'"},{"SchemaName":"mx_Custom_7","Value":"'.$prescription.'"},]}';
					        //  echo $data_string;
					           
					            try
					            {
					                $curl = curl_init('https://api-in21.leadsquared.com/v2/ProspectActivity.svc/Create?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
					                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
					                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					                curl_setopt($curl, CURLOPT_HEADER, 0);
					                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
					                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					                        "Content-Type:application/json",
					                        "Content-Length:".strlen($data_string)
					                        ));
					                $json_response = curl_exec($curl);
					                 //$data1 = json_decode($json_response, TRUE);
					                
					              //  echo $json_response;
					                    curl_close($curl);
					            } catch (Exception $ex) 
					            { 
					                curl_close($curl);
					            }

			            		/*$message = urlencode("We are sad that you cancelled your booking with id ".$post['book_laboratory_test_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
	                    		
	                    		$this->db->select('*');
			                    $this->db->from('sms_detail');
			                    $sms_detail = $this->db->get()->result_array();

	                            $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
	                                    $response = file_get_contents($smsurl);*/
	                            $this->db->select('member.*');
                                $this->db->from('member');
                                $this->db->where('member.member_id',$patient_id);
                                $patient_details = $this->db->get()->row_array();

	                           $date_appointment=date("d-m-Y",strtotime($appointment_date)); 
	                           $message ="HI ".$patient_details['name'].", We have canceled your appointment for Lab ".$date_appointment." ". $appointment_time." at DR AT DOORSTEP. If you want to reschedule, Call 7069073088. Team NWPL";
	                            $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
                                    $param[msg] = $message;
                                    $param[userid] = "2000197810";
                                    $param[password] = "Dr@doorstep2020";
                                    $param[v] = "1.1";
                                    $param[msg_type] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
                                    $param[auth_scheme] = "PLAIN";
                                    //Have to URL encode the values
                                    foreach($param as $key=>$val) {
                                    $request.= $key."=".urlencode($val);
                                    //we have to urlencode the values
                                    $request.= "&";
                                    //append the ampersand (&)
                                        //sign after each
                                   // parameter/value pair
                                    }
                                    $request = substr($request, 0, strlen($request)-1);
                                    //remove final (&)
                                            //sign from the request
                                    $url =
                                    "https://enterprise.smsgupshup.com/GatewayAPI/rest?".$request;
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $curl_scraped_page = curl_exec($ch);
                                    curl_close($ch);

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
	                                   redirect(base_url().'BookingHistory');	
	                            }
	                            else 
	                            {
	                                    $this->session->set_flashdata('message','Something went wrong.');
	                                    redirect(base_url().'BookingHistory');	
	                            }
	                                       // redirect(base_url());
			            }
			            else
			            {
							$this->session->set_flashdata('message','Address is updated.');
	                        redirect(base_url().'BookingHistory');

			            }
			         }
			         else
			         {
			         		$this->session->set_flashdata('message','This appointment has already been cancelled!!.');
	                        redirect(base_url().'BookingHistory');
			         }


				  }
		    }
		}
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

	public function editBookDoctorAppointment()
	{
		$post = $this->input->post(NULL, true);
		$appointment_book_id = $post['btn_edit_appointment'];
		// echo "<pre>";
		// print_r($post);
		// exit;

		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$data['appointment_book'] = $this->db->get_where('appointment_book', array('appointment_book_id'=>$appointment_book_id))->row_array();

		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		$data['doctor_type'] = $this->db->get_where('doctor_type', array('d_status'=>1))->result_array();
		$this->load->view(USERHEADER);
		$this->load->view('user/editBookDoctorAppointment',$data);
		$this->load->view(USERFOOTER);
	}
	public function updateDoctorBooking(){
		$post = $this->input->post(NULL, true);
		

		$update_doctor_appointment_array = array(
			
			'date'=>$post['date'],
			'time'=>$post['time'],
		);

		$this->db->where(array('appointment_book_id'=>$post['appointment_book_id']));	
		if($this->db->update('appointment_book',$update_doctor_appointment_array))
		{
			//echo $this->db->last_query();

			$this->session->set_flashdata('message','Doctor Appoinment is updated.');
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		redirect(base_url().'BookingHistory');	
	}

	

	public function editBookNurseAppointment()
	{
		$post = $this->input->post(NULL, true);
		$book_nurse_id = $post['btn_edit_appointment'];
		// echo "<pre>";
		// print_r($post);
		// exit;

		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$data['appointment_book'] = $this->db->get_where('book_nurse', array('book_nurse_id'=>$book_nurse_id))->row_array();

		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		$data['nurse_service_type'] = $this->db->get_where('nurse_service_type', array('n_status'=>1))->result_array();
		$this->load->view(USERHEADER);
		$this->load->view('user/editBookNurseAppointment',$data);
		$this->load->view(USERFOOTER);
	}
	public function updateNurseBooking(){
		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);
		// exit;
		$update_nurse_appointment_array = array(
			
			'date'=>$post['date'],
			'time'=>$post['time'],
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


		redirect(base_url().'BookingHistory');	
	}
	
	public function editBookLabAppointment()
	{
		$post = $this->input->post(NULL, true);
		$book_laboratory_test_id = $post['btn_edit_appointment'];
		// echo "<pre>";
		// print_r($post);
		// exit;

		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$data['appointment_book'] = $this->db->get_where('book_laboratory_test', array('book_laboratory_test_id'=>$book_laboratory_test_id))->row_array();

		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		$data['lab_test_type'] = $this->db->get_where('lab_test_type', array('l_status'=>1))->result_array();
		$this->load->view(USERHEADER);
		$this->load->view('user/editBookLabAppointment',$data);
		$this->load->view(USERFOOTER);
	}
	public function updateLabBooking(){
		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);
		// exit;
		$update_lab_appointment_array = array(
			
			'date'=>$post['date'],
			'time'=>$post['time'],
			'complain'=>$post['complain'],
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


		redirect(base_url().'BookingHistory');	
	}
	public function editBookPharmacyAppointment()
	{
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

		$this->load->view(USERHEADER);
		$this->load->view('user/editBookPharmacyAppointment',$data);
		$this->load->view(USERFOOTER);
	}
	public function updatePharmacyBooking(){
		$post = $this->input->post(NULL, true);
// 		echo "<pre>";
// 		print_r($post);
// 		// print_r($_FILES);
// exit;
		 $image=$_FILES['img_profile']['name'];
		//exit;
		$pharmacy_appointment_array = array(


			'user_id'=>$this->session->userdata('user')['user_id'],
			'name'=>$post['name'],
			'mobile'=>$post['mobile'],
			'landline'=>$post['landline']." ",
			'address'=>$post['address']." ",
			'city_id'=>$post['city_id'],
			'booked_by'=>$this->session->userdata('user')['user_id'],
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


		redirect(base_url().'BookingHistory');	
	}
	public function editBookAmbulanceAppointment()
	{
		$post = $this->input->post(NULL, true);

		$book_ambulance_id = $post['btn_edit_appointment'];
		//echo $book_medicine_id;
		// exit;
		// echo "<pre>";
		// print_r($post);
		// exit;
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();

		$data['appointment_book'] = $this->db->get_where('book_ambulance', array('book_ambulance_id'=>$book_ambulance_id))->row_array();
		/*echo $this->db->last_query();
		exit;*/

		$this->load->view(USERHEADER);
		$this->load->view('user/editBookAmbulanceAppointment',$data);
		$this->load->view(USERFOOTER);
	}
	public function updateAmbulanceBooking(){
		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);
		// exit;
		$update_ambulance_appointment_array = array(
			
			'date'=>$post['date'],
			'time'=>$post['time'],
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


		redirect(base_url().'BookingHistory');	
	}
	public function download_pharmacy_report($filename = NULL) {

    
    	$this->load->helper('download');
  		$data = file_get_contents(base_url('/uploads/pharmacy_document/'.$filename));
    	force_download($filename, $data);
    	
      
	}

	
}
