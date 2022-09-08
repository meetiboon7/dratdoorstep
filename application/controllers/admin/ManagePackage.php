<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class ManagePackage extends GeneralController {

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
		//$this->load->model('admin/ManageFees_model');
		$this->load->model('General_model');
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}
				
	}	

	public function index()
	{
		parent::index();
		$this->db->select('manage_package.*,city.city,user_type.user_type_name');
		$this->db->from('manage_package');
		$this->db->join('city','city.city_id = manage_package.city_id');
		$this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
		$this->db->where('manage_package.package_status',1);
		$this->db->order_by('manage_package.package_id', 'DESC');
									  
		$data['manage_package'] = $this->db->get()->result_array();

		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(PACKAGE, $data);
		$this->load->view(FOOTER);
	}

	public function addManagePackage()
	{
		parent::index();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['service'] = $this->db->get_where('user_type', array('status'=>1))->result_array();
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(ADD_PACKAGE, $data);
		$this->load->view(FOOTER);

	}

	

	public function insertManagePackage(){
		$post = $this->input->post(NULL, true);
		
		$city = $this->db->get_where('city', array('city_id'=>$post['city_id']))->row_array();
		$service = $this->db->get_where('user_type', array('user_type_id'=>$post['service_id']))->row_array();
		$service_name=ucwords($service['user_type_name']);
		$words = explode(" ",$service_name);
        $service_first_letter = "";
		
		foreach ($words as $w) {
         $service_first_letter .= $w[0];
        }
	
		
		$manage_package_array = array(
			'city_id'=>$post['city_id'],
			'service_id'=>$post['service_id'],
			'package_name'=>$post['package_name'],
			'description'=>$post['description'],
			'fees_name'=>$post['fees_name'],
			'no_visit'=>$post['no_visit'],
			'validate_month'=>$post['validate_month'],
			'package_status'=>$post['package_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			'created_by'=>$this->session->userdata('admin_user')['first_name']." ".$this->session->userdata('admin_user')['last_name'],
			'purchase_date'=>date('Y-m-d H:i:s')
		);
		
		if($this->db->insert('manage_package', $manage_package_array))
		{
			 $insert_id = $this->db->insert_id();

			 $package_code=$city['city_code'].date("y").$service_first_letter.$post['validate_month']."0".$insert_id;
		
			 $this->db->where('package_id', $insert_id);
    		$this->db->update('manage_package', array('package_code' =>$package_code));

			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Package is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminManagePackage');
	}


	public function editManagePackage()
	{
		parent::index();
		$post = $this->input->post(NULL, true);
		$package_id = $post['btn_edit_manage_package'];

		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['service'] = $this->db->get_where('user_type', array('status'=>1))->result_array();

		$data['manage_package'] = $this->db->get_where('manage_package', array('package_id'=>$package_id))->row_array();
			

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(EDIT_PACKAGE, $data);
		$this->load->view(FOOTER);
	}

	public function updateManagePackage(){
		$post = $this->input->post(NULL, true);

		$city = $this->db->get_where('city', array('city_id'=>$post['city_id']))->row_array();
		$service = $this->db->get_where('user_type', array('user_type_id'=>$post['service_id']))->row_array();
		$service_name=ucwords($service['user_type_name']);
		$words = explode(" ",$service_name);
        $service_first_letter = "";
		
		foreach ($words as $w) {
         $service_first_letter .= $w[0];
        }


         $package_code=$city['city_code'].date("y").$service_first_letter.$post['validate_month']."0".$post['btn_update_manage_package'];
		//$date = date('Y-m-d');
		$manage_package_array = array(
			'city_id'=>$post['city_id'],
			'package_code'=>$package_code,
			'service_id'=>$post['service_id'],
			'package_name'=>$post['package_name'],
			'description'=>$post['description'],
			'fees_name'=>$post['fees_name'],
			'no_visit'=>$post['no_visit'],
			'validate_month'=>$post['validate_month'],
			'package_status'=>$post['package_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'updated_date'=>date('Y-m-d'),
			'updated_by'=>$this->session->userdata('admin_user')['first_name']." ".$this->session->userdata('admin_user')['last_name'],
			'purchase_date'=>date('Y-m-d H:i:s')
			//'e_created_on'=>date('Y-m-d H:i:s')
		);

		$this->db->where(array('package_id'=>$post['btn_update_manage_package']));	
		if($this->db->update('manage_package', $manage_package_array))
		{

			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $post['btn_update_employee'],'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Package Details is updated.');
		}else{
			$this->session->set_flashdata('message','Something went wrong.');
		}


		redirect(base_url().'adminManagePackage');	
	}
	public function deleteManagePackage(){
    	$post = $this->input->post(NULL, true);
		$delete_package_id = $post['btn_delete_manage_package'];
		$this->db->where('package_id',$delete_package_id);
        $this->db->delete('manage_package');
        $this->session->set_flashdata('message','Package Deleted successfully.');
        redirect(base_url().'adminManagePackage');
    }
}
