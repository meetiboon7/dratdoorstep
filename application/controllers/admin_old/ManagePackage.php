<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManagePackage extends CI_Controller {

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

		$this->db->select('manage_package.*,city.city');
		$this->db->from('manage_package');
		$this->db->join('city','city.city_id = manage_package.city_id');
		$this->db->order_by('manage_package.package_id', 'DESC');
									  
		$data['manage_package'] = $this->db->get()->result_array();

		
		$this->load->view(HEADER);
		$this->load->view(PACKAGE, $data);
		$this->load->view(FOOTER);
	}

	public function addManagePackage()
	{
		
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$this->load->view(HEADER);
		$this->load->view(ADD_PACKAGE, $data);
		$this->load->view(FOOTER);

	}

	

	public function insertManagePackage(){
		$post = $this->input->post(NULL, true);
		
		$manage_package_array = array(
			'city_id'=>$post['city_id'],
			'service_name'=>$post['service_name'],
			'package_name'=>$post['package_name'],
			'description'=>$post['description'],
			'fees_name'=>$post['fees_name'],
			'no_visit'=>$post['no_visit'],
			'validate_month'=>$post['validate_month'],
			'package_status'=>$post['package_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'e_created_on'=>date('Y-m-d H:i:s')
		);
		
		if($this->db->insert('manage_package', $manage_package_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Package is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminManagePackage');
	}


	public function editManagePackage()
	{
		$post = $this->input->post(NULL, true);
		$package_id = $post['btn_edit_manage_package'];

		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['manage_package'] = $this->db->get_where('manage_package', array('package_id'=>$package_id))->row_array();
			

		$this->load->view(HEADER);
		$this->load->view(EDIT_PACKAGE, $data);
		$this->load->view(FOOTER);
	}

	public function updateManagePackage(){
		$post = $this->input->post(NULL, true);

		//$date = date('Y-m-d');
		$manage_package_array = array(
			'city_id'=>$post['city_id'],
			'service_name'=>$post['service_name'],
			'package_name'=>$post['package_name'],
			'description'=>$post['description'],
			'fees_name'=>$post['fees_name'],
			'no_visit'=>$post['no_visit'],
			'validate_month'=>$post['validate_month'],
			'package_status'=>$post['package_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
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
        redirect(base_url().'adminManagePackage');
    }
}
