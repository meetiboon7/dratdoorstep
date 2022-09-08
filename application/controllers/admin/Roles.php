<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class Roles extends GeneralController {

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
		//$this->load->model('admin/City_model');
		$this->load->model('admin/Roles_model');
		$this->load->model('admin/Login_model');	
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}
		//$this->load->model('admin/Zone_model');	
	}

	public function index()
	{
		parent::index();
		$all_roles = $this->Roles_model->list_managerole();
		

        if($all_roles)
        {
            $this->viewdata['all_roles'] = $all_roles;
        }
        else
        {
            $this->viewdata['all_roles'] = '';
        }

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/manageRoleList',$this->viewdata);
		$this->load->view(FOOTER);

		
	}
	public function insertmanagerole(){
		$post = $this->input->post(NULL, true);
		
		if (!empty($post)) {
			
			$manageRole_array = array(
				
				'role_name' => $post['role_name'],
				'role_status' => $post['role_status'],	
				
							
			);
			$this->Roles_model->add_managerole($manageRole_array);

			$this->session->set_flashdata('role_id',$manageRole_array);
			
			$this->session->set_flashdata('message','Roles added successfully.');
			
			redirect(base_url().'adminManageRole');
		}
	}
	public function editmanagerole()
	{

		$post = $this->input->post(NULL, true);
		

		$view_role_id = $post['btn_edit_managerole'];
		

		$view_managerole = $this->Roles_model->view_single_managerole($view_role_id);
        if($view_managerole)
        {
            $this->viewdata['view_managerole'] = $view_managerole;
        }
        else
        {
            $this->viewdata['view_managerole'] = '';	
        }

        
        echo json_encode($view_managerole);
        
	}
	public function updatemanagerole(){
		$post = $this->input->post(NULL, true);

		if (!empty($post)) {
			
			$update_role_id = $post['btn_update_managerole'];
			/*echo '<pre>';
			print_r($post);*/
			
			$updatemanagerole_array = array(
				
				
				'role_name' => $post['role_name'],
				'role_status' => $post['role_status'],	
				
							
			);
			$this->Roles_model->update_managerole_info($updatemanagerole_array,$update_role_id);
			
			$this->session->set_flashdata('message','Role updated successfully.');

			redirect(base_url().'adminManageRole');
		}
		
	}
	public function deletemanagerole(){
    	$post = $this->input->post(NULL, true);
		$delete_role_id = $post['btn_delete_managerole'];
		$this->Roles_model->delete_managerole_info($delete_role_id);
		 $this->session->set_flashdata('message','Roles Deleted successfully.');
        redirect(base_url().'adminManageRole');
    }

	
	
}
