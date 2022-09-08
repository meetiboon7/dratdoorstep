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
		$this->load->model('admin/Login_model');
		$this->load->model('General_model');
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}

	}

	public function index()
	{

		$this->db->select('appointment_book.*,member.contact_no,member.name,doctor_type.doctor_type_name');
		$this->db->from('appointment_book');
		$this->db->join('member','member.member_id = appointment_book.patient_id');
		$this->db->join('doctor_type','doctor_type.d_type_id = appointment_book.doctor_type_id');
		$this->db->order_by('appointment_book.appointment_book_id', 'DESC');
		$data['appointment_book'] = $this->db->get()->result_array();

		$this->load->view(HEADER);
		$this->load->view('admin/appointmentList',$data);
		$this->load->view(FOOTER);
	}
	public function addDoctorAppointment()
	{
		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
		$this->db->from('user');
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();

		$data['doctor_type'] = $this->db->get_where('doctor_type', array('d_status'=>1))->result_array();
		
		$this->load->view(HEADER);
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
		$doctor_appointment_array = array(
			'user_id'=>$post['user_id'],
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

		redirect(base_url().'adminAppointmentList');
    }

    //Nurse

    public function addNurseAppointment()
	{
		

		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('admin_user')['user_id']);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
		$this->db->from('user');
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();
		

		$data['nurse_service_type'] = $this->db->get_where('nurse_service_type', array('n_status'=>1))->result_array();
		
		$this->load->view(HEADER);
		$this->load->view('admin/addNurseAppointment',$data);
		$this->load->view(FOOTER);
	}

	public function insertNurseAppointment()
    {

    	$post = $this->input->post(NULL, true);
		$nurse_appointment_array = array(
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			'patient_id'=>$post['member_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'doctor_type_id'=>$post['doctor_type_id'],
			'nurse_service_id'=>$post['nurse_service_id'],
			
			
		);
		
		if($this->db->insert('appointment_book', $nurse_appointment_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Nurse Appointment is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminAppointmentList');
    }

    //Ambulance

    public function addAmbulanceAppointment()
	{
		

		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$this->db->select('user.first_name,user.last_name,user.mobile,user.user_id');
		$this->db->from('user');
		$this->db->order_by('user.user_id', 'DESC');
		$data['user'] = $this->db->get()->result_array();

		
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$this->load->view(HEADER);
		$this->load->view('admin/addAmbulanceAppointment',$data);
		$this->load->view(FOOTER);
	}

	public function insertAmbulanceAppointment()
    {

    	$post = $this->input->post(NULL, true);
		$ambulance_appointment_array = array(


			'user_id'=>$post['user_id'],
			'name'=>$post['first_name']." ".$post['last_name'],
			'age'=>$post['age'],
			'gender'=>$post['gender'],
			'mobile1'=>$post['mobile1'],
			'mobile2'=>$post['mobile2'],
			'landline'=>$post['landline'],
			'from_address'=>$post['from_address'],
			'to_address'=>$post['to_address'],
			'country_id'=>$post['country_id'],
			'state_id'=>$post['state_id'],
			'city_id'=>$post['city_id'],
			'condition'=>$post['condition'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			
			
			
		);
		
		if($this->db->insert('book_ambulance', $ambulance_appointment_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Ambulance Appointment is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminAppointmentList');
    }


    //Lab Test

    public function addLabAppointment()
	{
		

		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('admin_user')['user_id']);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		
		$data['lab_test_type'] = $this->db->get_where('lab_test_type', array('l_status'=>1))->result_array();
		
		$this->load->view(HEADER);
		$this->load->view('admin/addLabAppointment',$data);
		$this->load->view(FOOTER);
	}

	public function insertLabAppointment()
    {

    	$post = $this->input->post(NULL, true);
		$lab_appointment_array = array(


			'user_id'=>$this->session->userdata('admin_user')['user_id'],
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

		redirect(base_url().'adminAppointmentList');
    }

    //Pharmacy
     public function addPharmacyAppointment()
	{
		

		//$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$this->load->view(HEADER);
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

		redirect(base_url().'adminAppointmentList');
    }
	
	
	
}
