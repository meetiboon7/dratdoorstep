<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");

class ManagePermission extends GeneralController {

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
		$this->db->select('role_permission.*,manage_roles.role_name');
		$this->db->from('role_permission');
		$this->db->join('manage_roles','manage_roles.role_id = role_permission.role_id');
		$this->db->where('manage_roles.role_status',1);
		//$this->db->join('employee_master','employee_master.emp_id = user_manage.emp_id');
		$this->db->group_by('manage_roles.role_id');
		$this->db->order_by('role_permission.id', 'DESC');
		
									  
		$data['manage_role_permission'] = $this->db->get()->result_array();

		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(ROLE_PERMISSION, $data);
		$this->load->view(FOOTER);
	}

	public function addManagePermission()
	{
		parent::index();
		//$data['employee_master'] = $this->db->get_where('employee_master', array('emp_status'=>1))->result_array();
		$data['manage_roles'] = $this->db->get_where('manage_roles', array('role_status'=>1))->result_array();
		$data['menu'] = $this->db->get_where('menu', array('status'=>1))->result_array();
		//$data['user_type'] = $this->db->get_where('user_type', array('status'=>1))->result_array();
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(ADD_ROLE_PERMISSION, $data);
		$this->load->view(FOOTER);

	}

	

	public function insertManagePermission(){
		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);
		// echo "</pre>";
		// exit;
		$menu_id=$_POST['menu_id'];
		$add=$_POST['add'];
		$edit=$_POST['edit'];
		$delete=$_POST['delete'];
		$view=$_POST['view'];

		foreach($menu_id as $key=>$menu_ids){
		
					$manage_role_array = array(
						//'id'=>$menu_ids,
						// 'id'=>$this->input->post('id', TRUE),
						'role_id'=>$post['role_id'],
						'menu_id'=>$menu_ids,
						'add_permission'=>$add[$key] == "on" ? '1' :  '0',
						'edit_permission'=>$edit[$key] == "on" ? '1' : '0',
						'delete_permission'=>$delete[$key] == "on" ? '1' : '0',
						'view_permission'=>$view[$key] == "on" ? '1' : '0',
					);
					// echo "<pre>";
					// print_r($manage_role_array);
					// echo "</pre>";
					$this->db->select('role_permission.*');
					$this->db->from('role_permission');
					$this->db->where('role_id',$post['role_id']);
					$this->db->where('menu_id',$menu_ids);
					$menuResult = $this->db->get()->result_array();
					
					if(count($menuResult) > 0)
					{
						$club_role_array = $menuResult[0];
						$club_role_array['add_permission'] = $add[$key] == "on" ? '1' : $club_role_array['add_permission'];
						$club_role_array['edit_permission'] = $edit[$key] == "on" ? '1' : $club_role_array['edit_permission'];
						$club_role_array['delete_permission'] = $delete[$key] == "on" ? '1' : $club_role_array['delete_permission'];
						$club_role_array['view_permission'] = $view[$key] == "on" ? '1' : $club_role_array['view_permission'];

						$this->db->where('id',$menuResult[0]['id']);
						$this->db->update('role_permission',$club_role_array);
					}
					else
					{
						$this->db->insert('role_permission',$manage_role_array);		
					}
		//$this->db->join('employee_master','employee_master.emp_id = user_manage.emp_id');
		
		
		 		
		
	}
	// exit;
		
		// if($this->db->insert('role_permission', $manage_role_array))
		// {
		// 	// $insert_id = $this->db->insert_id();
		// 	$this->session->set_flashdata('message','Manage User is added.');
		// }else{
		// 	$this->session->set_flashdata('message','Try Again. Something went wrong.');
		// }	
		 $this->session->set_flashdata('message','Permission insert successfully.');
		redirect(base_url().'adminManagePermission');
	}


	public function editManagePermission()
	{
		parent::index();
		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);
		// echo "</pre>";

		$role_id	= $post['btn_edit_manage_permission'];
		// echo $role_id;
		// exit;
		

		$data['role_permission_master'] = $this->db->get_where('role_permission', array('role_id'=>$role_id))->result_array();
		$data['menu_data'] = $this->db->get_where('menu', array('status'=>1))->result_array();	
		$data['manage_roles'] = $this->db->get_where('manage_roles', array('role_status'=>1))->result_array();

		
     	



		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(EDIT_ROLE_PERMISSION, $data);
		$this->load->view(FOOTER);
	}

	public function updateManagePermission(){
		$post = $this->input->post(NULL, true);
		 
		$menu_id=$_POST['menu_id'];
		$add=$_POST['add'];
		$edit=$_POST['edit'];
		$delete=$_POST['delete'];
		$view=$_POST['view'];
		// echo "<pre>";
		//  print_r($add);
		//  echo "</pre>";
		//  exit;

				foreach($menu_id as $key=>$menu_ids){
				

							$manage_role_array_data = array(
								//'id'=>$menu_ids,
								// 'id'=>$this->input->post('id', TRUE),
								'role_id'=>$post['role_id'],
								'menu_id'=>$menu_ids,
								'add_permission'=>$add[$key] == "on" ? '1' :  '0',
								'edit_permission'=>$edit[$key] == "on" ? '1' : '0',
								'delete_permission'=>$delete[$key] == "on" ? '1' : '0',
								'view_permission'=>$view[$key] == "on" ? '1' : '0',
							);
							
							$this->db->where('role_id',$post['role_id']);
							$this->db->where('menu_id',$menu_ids);
							$this->db->update('role_permission',$manage_role_array_data);
							
				
			}
			 $this->session->set_flashdata('message','Permission Updated successfully.');
			redirect(base_url().'adminManagePermission');
	}
	public function deleteManagePermission(){
    	$post = $this->input->post(NULL, true);
		$delete_role_id = $post['btn_delete_manage_permission'];
		$this->db->where('role_id',$delete_role_id);
        $this->db->delete('role_permission');
         $this->session->set_flashdata('message','Permission Deleted successfully.');
       redirect(base_url().'adminManagePermission');
    }
}
