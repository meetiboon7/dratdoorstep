<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");

class City extends GeneralController {

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
		parent::index();
        $all_city = $this->City_model->list_city();
		

        if($all_city)
        {
            $this->viewdata['all_city'] = $all_city;
        }
        else
        {
            $this->viewdata['all_city'] = '';
        }

        // $all_permission = $this->General_model->list_menu();
		

        // if($all_permission)
        // {
        //     $this->viewdata['all_permission'] = $all_permission;
        // }
        // else
        // {
        //     $this->viewdata['all_permission'] = '';
        // }
		
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/cityList',$this->viewdata);
		$this->load->view(FOOTER);

		
	}
	public function insertcity(){


		$post = $this->input->post(NULL, true);
		
		if (!empty($post)) {
			
			$city_array = array(
				
				'city' => $post['city'],	
				'city_status' => $post['city_status'],	
				'created_by' =>'admin',
							
			);

			$city_data=$this->City_model->add_city($city_array);
			redirect(base_url()."adminCityList",'refresh');
			//return redirect()->to(base_url()."adminCityList"); 
			//redirect("/contacts/afficher", 'refresh');

			//redirect('login/'.$username);

		}
	}
	public function editCity()
	{

		$post = $this->input->post(NULL, true);
		

		$view_city_id = $post['btn_edit_city'];
		

		$view_city = $this->City_model->view_single_city($view_city_id);
        if($view_city)
        {
            $this->viewdata['view_city'] = $view_city;
        }
        else
        {
            $this->viewdata['view_city'] = '';	
        }

        
        echo json_encode($view_city);
	}
	public function updateCity(){
		$post = $this->input->post(NULL, true);

		if (!empty($post)) {
			
			$update_city_id = $post['btn_update_city'];
			/*echo '<pre>';
			print_r($post);*/
			$updatecity_array = array(
				
				'city' => $post['city'],	
				'city_status' => $post['city_status'],
				'updated_by' =>'admin',
			);
			$this->City_model->update_city_info($updatecity_array,$update_city_id);
			
			$this->session->set_flashdata('message','City updated successfully.');

			redirect(base_url().'adminCityList');
		}

		redirect(base_url().'adminCityList');
		
	}
	public function deleteCity(){
    	$post = $this->input->post(NULL, true);
		$delete_city_id = $post['btn_delete_city'];
		$this->City_model->delete_city_info($delete_city_id);
		$this->session->set_flashdata('message','City Deleted successfully.');
        redirect(base_url().'adminCityList');
    }

	
	
}
