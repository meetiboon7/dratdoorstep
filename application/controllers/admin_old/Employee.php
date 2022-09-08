<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");

class Employee extends GeneralController {

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
		// $this->load->model('admin/Login_model');
		$this->load->model('admin/Employee_model');
		// $this->load->model('General_model');
		// if(!$this->Login_model->check_admin_login()){
		// 	redirect(base_url().'admin');
		// }
				
	}	

	public function index()
	{
		parent::index();

		$this->db->select('employee_master.*,user_type.user_type_name,city.city');
		$this->db->from('employee_master');
		$this->db->join('user_type','user_type.user_type_id = employee_master.user_type_id');
		$this->db->join('city','city.city_id = employee_master.city_id');
		 $this->db->order_by('employee_master.emp_id', 'DESC');
									  
		$data['employees'] = $this->db->get()->result_array();

		$this->load->view(HEADER, $this->viewdata);
		$this->load->view(EMPLOYEES, $data);
		$this->load->view(FOOTER);
	}

	public function addEmployee()
	{
		$data['user_type'] = $this->db->get_where('user_type', array('status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$data['state'] = $this->db->get_where('state', array('state_status'=>1))->result_array();
		$data['country'] = $this->db->get_where('country', array('country_status'=>1))->result_array();
		$data['doctor_type'] = $this->db->get_where('doctor_type', array('d_status'=>1))->result_array();

		
		

		$this->load->view(HEADER);
		$this->load->view(ADD_EMPLOYEE, $data);
		$this->load->view(FOOTER);

	}

	

	public function insertEmployee(){
		$post = $this->input->post(NULL, true);
		$employee_array = array(
			'user_type_id'=>$post['user_type_id'],
			'first_name'=>$post['first_name'],
			'last_name'=>$post['last_name'],
			'email'=>$post['email'],
			'mobile_no'=>$post['mobile_no'],
			'date_of_birth'=>$post['date_of_birth'],
			'gender'=>$post['gender'],
			'address_1'=>$post['address_1'],
			'address_2'=>$post['address_2'],
			'city_id'=>$post['city_id'],
			'state_id'=>$post['state_id'],
			'country_id'=>$post['country_id'],
			'degree'=>$post['degree'],
			'license_no'=>$post['license_no'],
			'area_pincode'=>$post['area_pincode'],
			'd_type_id'=>$post['d_type_id'],
			'registration_no'=>$post['registration_no'],
			'emp_status'=>$post['emp_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'e_created_on'=>date('Y-m-d H:i:s')
		);
		
		if($this->db->insert('employee_master', $employee_array))
		{
			 $insert_id = $this->db->insert_id();
			
			$this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Employee is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminEmployee');
	}


	public function editEmployee()
	{
		$post = $this->input->post(NULL, true);
		$emp_id = $post['btn_edit_employee'];

		$data['user_type'] = $this->db->get_where('user_type', array('status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$data['state'] = $this->db->get_where('state', array('state_status'=>1))->result_array();
		$data['country'] = $this->db->get_where('country', array('country_status'=>1))->result_array();
		$data['doctor_type'] = $this->db->get_where('doctor_type', array('d_status'=>1))->result_array();

		$data['emp_master'] = $this->db->get_where('employee_master', array('emp_id'=>$emp_id))->row_array();	

		$this->load->view(HEADER);
		$this->load->view(EDIT_EMPLOYEE, $data);
		$this->load->view(FOOTER);
	}

	public function updateEmployee(){
		$post = $this->input->post(NULL, true);

		$employee_array = array(
			'user_type_id'=>$post['user_type_id'],
			'first_name'=>$post['first_name'],
			'last_name'=>$post['last_name'],
			'email'=>$post['email'],
			'mobile_no'=>$post['mobile_no'],
			'date_of_birth'=>$post['date_of_birth'],
			'gender'=>$post['gender'],
			'address_1'=>$post['address_1'],
			'address_2'=>$post['address_2'],
			'city_id'=>$post['city_id'],
			'state_id'=>$post['state_id'],
			'country_id'=>$post['country_id'],
			'degree'=>$post['degree'],
			'license_no'=>$post['license_no'],
			'area_pincode'=>$post['area_pincode'],
			'd_type_id'=>$post['d_type_id'],
			'registration_no'=>$post['registration_no'],
			'emp_status'=>$post['emp_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'e_created_on'=>date('Y-m-d H:i:s')
		);

		$this->db->where(array('emp_id'=>$post['btn_update_employee']));	
		if($this->db->update('employee_master', $employee_array))
		{

			$this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $post['btn_update_employee'],'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Employee is updated.');
		}else{
			$this->session->set_flashdata('message','Something went wrong.');
		}


		redirect(base_url().'adminEmployee');	
	}
	public function deleteEmployee(){
		
    	$post = $this->input->post(NULL, true);
		$delete_emp_id = $post['btn_delete_employee'];
		$this->db->where('emp_id',$delete_emp_id);
        $this->db->delete('employee_master');
        redirect(base_url().'adminEmployee');
    }
}
