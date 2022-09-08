<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManageUser extends CI_Controller {

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

		$this->db->select('user_manage.*,manage_roles.role_name,employee_master.first_name,employee_master.last_name');
		$this->db->from('user_manage');
		$this->db->join('manage_roles','manage_roles.role_id = user_manage.role_id');
		$this->db->join('employee_master','employee_master.emp_id = user_manage.emp_id');
		$this->db->order_by('user_manage.user_m_id', 'DESC');
									  
		$data['manage_user'] = $this->db->get()->result_array();

		
		$this->load->view(HEADER);
		$this->load->view(USER_MANAGE, $data);
		$this->load->view(FOOTER);
	}

	public function addManageUser()
	{
		$data['employee_master'] = $this->db->get_where('employee_master', array('emp_status'=>1))->result_array();
		$data['manage_roles'] = $this->db->get_where('manage_roles', array('role_status'=>1))->result_array();

		$this->load->view(HEADER);
		$this->load->view(ADD_USER_MANAGE, $data);
		$this->load->view(FOOTER);

	}

	

	public function insertManageUser(){
		$post = $this->input->post(NULL, true);
		
		$manage_user_array = array(
			'emp_id'=>$post['emp_id'],
			'role_id'=>$post['role_id'],
			'status'=>$post['status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'e_created_on'=>date('Y-m-d H:i:s')
		);
		
		if($this->db->insert('user_manage', $manage_user_array))
		{
			 $insert_id = $this->db->insert_id();
			$this->session->set_flashdata('message','Manage User is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminManageUser');
	}


	public function editManageUser()
	{
		$post = $this->input->post(NULL, true);
		$user_m_id	= $post['btn_edit_manage_user'];

		$data['user_manage'] = $this->db->get_where('user_manage', array('user_m_id'=>$user_m_id))->row_array();
		$data['manage_roles'] = $this->db->get_where('manage_roles', array('role_status'=>1))->result_array();
		$data['employee_master'] = $this->db->get_where('employee_master', array('emp_status'=>1))->result_array();	

		$this->load->view(HEADER);
		$this->load->view(EDIT_USER_MANAGE, $data);
		$this->load->view(FOOTER);
	}

	public function updateManageUser(){
		$post = $this->input->post(NULL, true);

		//$date = date('Y-m-d');
		$manage_user_array = array(
			'emp_id'=>$post['emp_id'],
			'role_id'=>$post['role_id'],
			'status'=>$post['status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'e_created_on'=>date('Y-m-d H:i:s')
		);

		$this->db->where(array('user_m_id'=>$post['btn_update_manage_user']));	
		if($this->db->update('user_manage', $manage_user_array))
		{
			$this->session->set_flashdata('message','Manage User Details is updated.');
		}else{
			$this->session->set_flashdata('message','Something went wrong.');
		}


		redirect(base_url().'adminManageUser');	
	}
	public function deleteManageUser(){
    	$post = $this->input->post(NULL, true);
		$delete_user_m_id = $post['btn_delete_manage_user'];
		$this->db->where('user_m_id',$delete_user_m_id);
        $this->db->delete('user_manage');
        redirect(base_url().'adminManageUser');
    }
}
