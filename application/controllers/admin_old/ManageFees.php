<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManageFees extends CI_Controller {

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

		$this->db->select('manage_fees.*,manage_roles.role_name,city.city,fees_type.fees_type_name');
		$this->db->from('manage_fees');
		$this->db->join('manage_roles','manage_roles.role_id = manage_fees.role_id');
		$this->db->join('city','city.city_id = manage_fees.city_id');
		$this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
		 $this->db->order_by('manage_fees.fees_id', 'DESC');
									  
		$data['manage_fees'] = $this->db->get()->result_array();

		
		$this->load->view(HEADER);
		$this->load->view(FEES, $data);
		$this->load->view(FOOTER);
	}

	public function addManageFees()
	{
		$data['fees_type'] = $this->db->get_where('fees_type', array('status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['manage_roles'] = $this->db->get_where('manage_roles', array('role_status'=>1))->result_array();

		
		

		$this->load->view(HEADER);
		$this->load->view(ADD_FEES, $data);
		$this->load->view(FOOTER);

	}

	

	public function insertManageFees(){
		$post = $this->input->post(NULL, true);
		//$date = date('Y-m-d');
		$manage_fees_array = array(
			'city_id'=>$post['city_id'],
			'fees_type_id'=>$post['fees_type_id'],
			'role_id'=>$post['role_id'],
			// 'from_time'=>$post['from_time'],
			// 'to_time'=>$post['to_time'],
			'from_time'=>$post['from_time'],
			'to_time'=>$post['to_time'],
			'fees_name'=>$post['fees_name'],
			'fees_status'=>$post['fees_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'e_created_on'=>date('Y-m-d H:i:s')
		);
		
		if($this->db->insert('manage_fees', $manage_fees_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Fees is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminManageFees');
	}


	public function editManageFees()
	{
		$post = $this->input->post(NULL, true);
		$fees_id = $post['btn_edit_manage_fees'];

		$data['fees_type'] = $this->db->get_where('fees_type', array('status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['manage_roles'] = $this->db->get_where('manage_roles', array('role_status'=>1))->result_array();
		$data['manage_fees'] = $this->db->get_where('manage_fees', array('fees_id'=>$fees_id))->row_array();	

		$this->load->view(HEADER);
		$this->load->view(EDIT_FEES, $data);
		$this->load->view(FOOTER);
	}

	public function updateManageFees(){
		$post = $this->input->post(NULL, true);

		//$date = date('Y-m-d');
		$manage_fees_array = array(
			'city_id'=>$post['city_id'],
			'fees_type_id'=>$post['fees_type_id'],
			'role_id'=>$post['role_id'],
			// 'from_time'=>$post['from_time'],
			// 'to_time'=>$post['to_time'],
			'from_time'=>$post['from_time'],
			'to_time'=>$post['to_time'],
			'fees_name'=>$post['fees_name'],
			'fees_status'=>$post['fees_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'e_created_on'=>date('Y-m-d H:i:s')
		);

		$this->db->where(array('fees_id'=>$post['btn_update_manage_fees']));	
		if($this->db->update('manage_fees', $manage_fees_array))
		{

			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $post['btn_update_employee'],'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Fees Details is updated.');
		}else{
			$this->session->set_flashdata('message','Something went wrong.');
		}


		redirect(base_url().'adminManageFees');	
	}
	public function deleteManageFees(){
    	$post = $this->input->post(NULL, true);
		$delete_fees_id = $post['btn_delete_manage_fees'];
		$this->db->where('fees_id',$delete_fees_id);
        $this->db->delete('manage_fees');
        redirect(base_url().'adminManageFees');
    }
}
