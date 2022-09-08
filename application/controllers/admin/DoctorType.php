<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class DoctorType extends GeneralController {

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
		$this->load->model('admin/DoctorType_model');	
		$this->load->model('admin/Login_model');
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}

	}

	public function index()
	{
		
		
		parent::index();

        $all_doctor_type = $this->DoctorType_model->list_doctor_type();
		

        if($all_doctor_type)
        {
            $this->viewdata['all_doctor_type'] = $all_doctor_type;
        }
        else
        {
            $this->viewdata['all_doctor_type'] = '';
        }
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/doctorTypeList',$this->viewdata);
		$this->load->view(FOOTER);

		
	}
	public function insertDoctorType(){


		$post = $this->input->post(NULL, true);
		
		if (!empty($post)) {
			
			$doctor_type_array = array(
				
				'doctor_type_name' => $post['doctor_type_name'],	
				'd_status' => $post['d_status'],	
				
							
			);
			$this->DoctorType_model->add_doctor_type($doctor_type_array);
			
			$this->session->set_flashdata('message','Doctor Type added successfully.');
			
			redirect(base_url()."adminDoctorTypeList",'refresh');
			//return redirect()->to(base_url()."adminCityList"); 
			//redirect("/contacts/afficher", 'refresh');

			//redirect('login/'.$username);

		}
	}
	public function editDoctorType()
	{

		$post = $this->input->post(NULL, true);
		$view_doctor_type_id = $post['btn_edit_doctor_type'];
		
		$view_doctor_type = $this->DoctorType_model->view_single_doctor_type($view_doctor_type_id);
        if($view_doctor_type)
        {
            $this->viewdata['view_doctor_type'] = $view_doctor_type;
        }
        else
        {
            $this->viewdata['view_doctor_type'] = '';	
        }

        
        echo json_encode($view_doctor_type);
	}
	public function updateDoctorType(){
		$post = $this->input->post(NULL, true);

		if (!empty($post)) {
			
			$update_doctor_type_id = $post['btn_update_doctor_type'];
			/*echo '<pre>';
			print_r($post);*/
			$doctor_type_array = array(
				
				'doctor_type_name' => $post['doctor_type_name'],	
				'd_status' => $post['d_status'],	
				
							
			);
			$this->DoctorType_model->update_doctor_type_info($doctor_type_array,$update_doctor_type_id);
			
			$this->session->set_flashdata('message','Doctor Type updated successfully.');

			redirect(base_url().'adminDoctorTypeList');
		}

		
		
	}
	public function deleteDoctorType(){
    	
    	$post = $this->input->post(NULL, true);
		$delete_doctor_type_id = $post['btn_delete_doctor_type'];
		$this->DoctorType_model->delete_doctor_type_info($delete_doctor_type_id);
		$this->session->set_flashdata('message','Doctor Type Deleted successfully.');
        redirect(base_url().'adminDoctorTypeList');
    }

	
	
}
