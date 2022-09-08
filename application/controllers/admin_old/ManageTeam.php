<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManageTeam extends CI_Controller {

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

		// $this->db->select('manage_team.*,city.city,zone_master.zone_name,employee_master.first_name,employee_master.last_name');
		// $this->db->from('manage_team');
		// $this->db->join('city','city.city_id = manage_team.city_id');
		// $this->db->join('zone_master','zone_master.zone_id = manage_team.zone_id');
		// $this->db->join('employee_master','employee_master.emp_id = manage_team.emp_id');
		// $this->db->order_by('manage_team.team_id', 'DESC');


		$this->db->select('manage_team.*,city.city,zone_master.zone_name');
		$this->db->from('manage_team');
		$this->db->join('city','city.city_id = manage_team.city_id');
		$this->db->join('zone_master','zone_master.zone_id = manage_team.zone_id');
		//$this->db->join('employee_master','employee_master.emp_id = manage_team.emp_id');
		$this->db->order_by('manage_team.team_id', 'DESC');
									  
		$data['manage_team'] = $this->db->get()->result_array();

		
		$this->load->view(HEADER);
		$this->load->view(TEAM, $data);
		$this->load->view(FOOTER);
	}

	public function addManageTeam()
	{
		
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['zone_master'] = $this->db->get_where('zone_master', array('zone_status'=>1))->result_array();
		$data['employee_master'] = $this->db->get_where('employee_master', array('emp_status'=>1))->result_array();
		$this->load->view(HEADER);
		$this->load->view(ADD_TEAM, $data);
		$this->load->view(FOOTER);

	}

	

	public function insertManageTeam(){
		$post = $this->input->post(NULL, true);
		
		$manage_team_array = array(
			'city_id'=>$post['city_id'],
			'zone_id'=>$post['zone_id'],
			'team_name'=>$post['team_name'],
			'emp_id'=>implode(",",$post['emp_id']),
			'team_status'=>$post['team_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'e_created_on'=>date('Y-m-d H:i:s')
		);
		
		if($this->db->insert('manage_team', $manage_team_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Team is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminManageTeam');
	}


	public function editManageTeam()
	{
		$post = $this->input->post(NULL, true);
		$team_id = $post['btn_edit_manage_team'];

		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['zone_master'] = $this->db->get_where('zone_master', array('zone_status'=>1))->result_array();
		$data['employee_master'] = $this->db->get_where('employee_master', array('emp_status'=>1))->result_array();

		$data['manage_team'] = $this->db->get_where('manage_team', array('team_id'=>$team_id))->row_array();
			

		$this->load->view(HEADER);
		$this->load->view(EDIT_TEAM, $data);
		$this->load->view(FOOTER);
	}

	public function updateManageTeam(){
		$post = $this->input->post(NULL, true);

		//$date = date('Y-m-d');
		$manage_team_array = array(
			'city_id'=>$post['city_id'],
			'zone_id'=>$post['zone_id'],
			'team_name'=>$post['team_name'],
			//'emp_id'=>$post['emp_id'],
			'emp_id'=>implode(',',$post['emp_id']),
			'team_status'=>$post['team_status'],
			'user_id'=>$this->session->userdata('admin_user')['user_id'],
			//'e_created_on'=>date('Y-m-d H:i:s')
		);

		$this->db->where(array('team_id'=>$post['btn_update_manage_team']));	
		if($this->db->update('manage_team', $manage_team_array))
		{

			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $post['btn_update_employee'],'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Team Details is updated.');
		}else{
			$this->session->set_flashdata('message','Something went wrong.');
		}


		redirect(base_url().'adminManageTeam');	
	}
	public function deleteManageTeam(){
    	$post = $this->input->post(NULL, true);
		$delete_team_id = $post['btn_delete_manage_team'];
		$this->db->where('team_id',$delete_team_id);
        $this->db->delete('manage_team');
        redirect(base_url().'adminManageTeam');
    }
}
