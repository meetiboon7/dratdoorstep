<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppointmentList extends CI_Controller {

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
		//$this->load->model('user/Login_model');
		$this->load->model('General_model');
		// if(!$this->Login_model->check_admin_login()){
		// 	redirect(base_url().'user');
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

		// $this->db->select('appointment_book.*,member.contact_no,member.name,doctor_type.doctor_type_name');
		// $this->db->from('appointment_book');
		// $this->db->join('member','member.member_id = appointment_book.patient_id');
		// $this->db->join('doctor_type','doctor_type.d_type_id = appointment_book.doctor_type_id');
		// $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
		// $this->db->order_by('appointment_book.appointment_book_id', 'DESC');
		// $data['appointment_book'] = $this->db->get()->result_array();

		$this->load->view(USERHEADER);
		$this->load->view('user/appointmentList',$data);
		$this->load->view(USERFOOTER);
	}
	public function DoctorAppointmentList()
	{

		$this->db->select('appointment_book.*,member.contact_no,member.name,doctor_type.doctor_type_name');
		$this->db->from('appointment_book');
		$this->db->join('member','member.member_id = appointment_book.patient_id');
		$this->db->join('doctor_type','doctor_type.d_type_id = appointment_book.doctor_type_id');
		$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
		$this->db->order_by('appointment_book.appointment_book_id', 'DESC');
		$data['appointment_book'] = $this->db->get()->result_array();

		$this->load->view(USERHEADER);
		$this->load->view('user/doctorAppointmentList',$data);
		$this->load->view(USERFOOTER);
	}
	
	public function addDoctorAppointment()
	{
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();


		$data['doctor_type'] = $this->db->get_where('doctor_type', array('d_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/addDoctorAppointment',$data);
		$this->load->view(USERFOOTER);
	}
	
	
    public function insertDoctorAppointment()
    {

    	$post = $this->input->post(NULL, true);
		$doctor_appointment_array = array(
			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['patient_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'doctor_type_id'=>$post['d_type_id'],
			
			
		);
		
		if($this->db->insert('appointment_book', $doctor_appointment_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Doctor Appointment is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'AppointmentList');
    }

    //Nurse
    public function NurseAppointmentList()
	{

		$this->db->select('appointment_book.*,member.contact_no,member.name');
		$this->db->from('appointment_book');
		$this->db->join('member','member.member_id = appointment_book.patient_id');
		$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
		$this->db->order_by('appointment_book.appointment_book_id', 'DESC');
		$data['nurse_appointment_book'] = $this->db->get()->result_array();
		// echo $this->db->last_query();
		// exit;
		$this->load->view(USERHEADER);
		$this->load->view('user/nurseAppointmentList',$data);
		$this->load->view(USERFOOTER);
	}
    public function addNurseAppointment()
	{
		

		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$data['nurse_service_type'] = $this->db->get_where('nurse_service_type', array('n_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/addNurseAppointment',$data);
		$this->load->view(USERFOOTER);
	}

	public function insertNurseAppointment()
    {

    	$post = $this->input->post(NULL, true);
		$nurse_appointment_array = array(
			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['member_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'days'=>$post['days'],
			// 'doctor_type_id'=>$post['doctor_type_id'],
			'nurse_service_id'=>$post['nurse_service_id'],
			
			
		);
		
		if($this->db->insert('book_nurse', $nurse_appointment_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Nurse Appointment is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'NurseAppointmentList');
    }

    //Ambulance
     public function AmbulanceAppointmentList()
	{

		$this->db->select('book_ambulance.*');
		$this->db->from('book_ambulance');
		$this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
		$this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
		$data['book_ambulance'] = $this->db->get()->result_array();
// echo $this->db->last_query();
// exit;
		$this->load->view(USERHEADER);
		$this->load->view('user/ambulanceAppointmentList',$data);
		$this->load->view(USERFOOTER);
	}
    public function addAmbulanceAppointment()
	{
		

		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
		$this->db->from('user');
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();

		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/addAmbulanceAppointment',$data);
		$this->load->view(USERFOOTER);
	}

	public function insertAmbulanceAppointment()
    {

    	$post = $this->input->post(NULL, true);

    	// echo $post['type'];
    	// exit;
    	if($post['type_valid']=="ONEWAY")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			'name'=>$post['first_name']." ".$post['last_name'],
			'age'=>$post['age'],
			'gender'=>$post['gender'],
			'mobile1'=>$post['mobile1'],
			'mobile2'=>$post['mobile2'],
			'landline'=>$post['landline']." ",
			'city_id'=>$post['city_id'],
			'from_address'=>$post['from_address'],
			'to_address'=>$post['to_address'],
			'condition'=>$post['condition'],
			'type_id'=>1,
			// 'country_id'=>$post['country_id'],
			// 'state_id'=>$post['state_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			);
    	}
    	if($post['type_valid']=="ROUND TRIP")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			'name'=>$post['first_name']." ".$post['last_name'],
			'age'=>$post['age'],
			'gender'=>$post['gender'],
			'mobile1'=>$post['mobile1'],
			'mobile2'=>$post['mobile2'],
			'landline'=>$post['landline']." ",
			'from_address'=>$post['from_address'],
			'to_address'=>$post['to_address'],
			'type_id'=>2,
			//'country_id'=>$post['country_id'],
			//'state_id'=>$post['state_id'],
			'city_id'=>$post['city_id'],
			'condition'=>$post['condition'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			//'return_date'=>$post['return_date'],
			//'return_time'=>$post['return_time'],
			
			);
    	}

    	if($post['type_valid']=="MULTI CITY")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			'name'=>$post['first_name']." ".$post['last_name'],
			'age'=>$post['age'],
			'gender'=>$post['gender'],
			'mobile1'=>$post['mobile1'],
			'mobile2'=>$post['mobile2'],
			'landline'=>$post['landline']." ",
			'type_id'=>3,
			//'city_id'=>$post['city_id'],
			'multi_city'=>implode('@#4$,',$post['multi_city'])

			
			);
    	}
		
		
		if($this->db->insert('book_ambulance', $ambulance_appointment_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Ambulance Appointment is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'AmbulanceAppointmentList');
    }


    //Lab Test
     public function LabAppointmentList()
	{

		$this->db->select('book_laboratory_test.*,member.*,lab_test_type.lab_test_type_name');
		$this->db->from('book_laboratory_test');
		$this->db->join('member','member.member_id = book_laboratory_test.patient_id');
		$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
		$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
		$this->db->order_by('book_laboratory_test.book_laboratory_test_id', 'DESC');
		$data['lab_appointment_book'] = $this->db->get()->result_array();
// echo $this->db->last_query();
// exit;
		$this->load->view(USERHEADER);
		$this->load->view('user/labAppointmentList',$data);
		$this->load->view(USERFOOTER);
	}
    public function addLabAppointment()
	{
		

		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		
		$data['lab_test_type'] = $this->db->get_where('lab_test_type', array('l_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/addLabAppointment',$data);
		$this->load->view(USERFOOTER);
	}

	public function insertLabAppointment()
    {

    	$post = $this->input->post(NULL, true);
		$lab_appointment_array = array(


			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['member_id'],
			'lab_test_id'=>$post['lab_test_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			
		);
		
		if($this->db->insert('book_laboratory_test', $lab_appointment_array))
		{
			 $insert_id = $this->db->insert_id();

			
			$this->General_model->uploadLabImage('./uploads/lab_report/', $insert_id,'profile_','img_profile', 'book_laboratory_test','prescription');
			// echo $error;
			// print_r($error);
			// exit;
			$this->session->set_flashdata('message','Lab Appointment is added.');
			

		}else{
			
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'LabAppointmentList');
    }

    function download($filename = NULL) {

    
    	$this->load->helper('download');
  		$data = file_get_contents(base_url('/uploads/lab_report/'.$filename));
    	force_download($filename, $data);
    	
      
	}

    //Pharmacy
     public function PharmacyAppointmentList()
	{

		$this->db->select('book_medicine.*');
		$this->db->from('book_medicine');
		//$this->db->join('member','member.member_id = book_laboratory_test.patient_id');
		//$this->db->join('lab_test_type','lab_test_type.lab_test_id = book_laboratory_test.lab_test_id');
		$this->db->where('book_medicine.user_id',$this->session->userdata('user')['user_id']);
		$this->db->order_by('book_medicine.book_medicine_id', 'DESC');
		$data['pharmacy_appointment_book'] = $this->db->get()->result_array();
// echo $this->db->last_query();
// exit;
		$this->load->view(USERHEADER);
		$this->load->view('user/pharmacyAppointmentList',$data);
		$this->load->view(USERFOOTER);
	}
     public function addPharmacyAppointment()
	{
		
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();
		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/addPharmacyAppointment',$data);
		$this->load->view(USERFOOTER);
	}

	public function insertPharmacyAppointment()
    {

    	$post = $this->input->post(NULL, true);
		$pharmacy_appointment_array = array(

			'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			'name'=>$post['name'],
			'mobile'=>$post['mobile'],
			'landline'=>$post['landline']." ",
			'address'=>$post['address'],
			'city_id'=>$post['city_id'],
		);
		
		if($this->db->insert('book_medicine', $pharmacy_appointment_array))
		{
			 $insert_id = $this->db->insert_id();
			
			$this->General_model->uploadPharmacyImage('./uploads/pharmacy_document/', $insert_id,'profile_','img_profile', 'book_medicine','prescription');
			$this->session->set_flashdata('message','Pharmacy Details is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'PharmacyAppointmentList');
    }
    function downloadPharmacyDocument($filename = NULL) {

    
    	$this->load->helper('download');
  		$data = file_get_contents(base_url('/uploads/pharmacy_document/'.$filename));
    	force_download($filename, $data);
    	
      
	}
	
	
	
	
}
