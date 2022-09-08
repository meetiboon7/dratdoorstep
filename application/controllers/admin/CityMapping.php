<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");
class CityMapping extends GeneralController {

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
		$this->load->model('admin/City_model');
		$this->load->model('admin/Employee_model');
		$this->load->model('admin/CityMapping_model');
		$this->load->model('General_model');
		$this->load->model('admin/Zone_model');	
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}
		
	}

	public function index()
	{
		
		
		parent::index();

        $all_city = $this->Zone_model->list_city();
		

        if($all_city)
        {
            $this->viewdata['all_city'] = $all_city;
        }
        else
        {
            $this->viewdata['all_city'] = '';
        }
		$all_zone = $this->General_model->list_zone();
		

        if($all_zone)
        {
            $this->viewdata['all_zone'] = $all_zone;
        }
        else
        {
            $this->viewdata['all_zone'] = '';
        }

        $all_employee = $this->CityMapping_model->list_employee();
		

        if($all_employee)
        {
            $this->viewdata['all_employee'] = $all_employee;
        }
        else
        {
            $this->viewdata['all_employee'] = '';
        }
        
        $all_city_mapping = $this->CityMapping_model->list_CityMapping();

	

        if($all_city_mapping)
        {
            $this->viewdata['all_city_mapping'] = $all_city_mapping;
        }
        else
        {
            $this->viewdata['all_city_mapping'] = '';
        }

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/manageCityMappingList',$this->viewdata);
		$this->load->view(FOOTER);

		
	}
	public function insertCityMapping(){
		$post = $this->input->post(NULL, true);
		
		
		if (!empty($post)) {
			
			$cityMapping_array = array(
				
				'emp_id' => $post['emp_id'],	
				'city_id' => $post['city_id'],	
				
				'zone_id'=>implode(',',$post['zone_id']),
				'city_map_status' => $post['city_map_status'],	
				
							
			);
			$this->CityMapping_model->add_CityMapping($cityMapping_array);
			
			$this->session->set_flashdata('message','Added Successfully.');
			
			redirect(base_url().'adminManageCityMapping');
		}
	}
	public function editCityMapping()
	{

		$post = $this->input->post(NULL, true);
		//print_r($post);

		$view_map_id = $post['btn_edit_CityMapping'];
		//$city_id = $post['city_id'];
		

		$view_CityMapping = $this->CityMapping_model->view_single_CityMapping($view_map_id);
		
        if($view_CityMapping)
        {
            $this->viewdata['view_CityMapping'] = $view_CityMapping;
        }
        else
        {
            $this->viewdata['view_CityMapping'] = '';	
        }
        /*$view_City_zone = $this->CityMapping_model->view_city_zone($city_id);
        if($view_City_zone)
        {
            $this->viewdata['view_City_zone'] = $view_City_zone;
        }
        else
        {
            $this->viewdata['view_City_zone'] = '';	
        }
      
        $dataArray = array(
    'view_CityMapping' => $view_CityMapping,
    'view_City_zone' => $view_City_zone
);*/

//echo json_encode($dataArray);
        echo json_encode($view_CityMapping);
	}
	public function updateCityMapping(){
		$post = $this->input->post(NULL, true);

		if (!empty($post)) {
			
			$update_map_id = $post['btn_update_CityMapping'];
			/*echo '<pre>';
			print_r($post);*/
			
			$update_cityMapping_array = array(
				
				'emp_id' => $post['emp_id'],	
				'city_id' => $post['city_id'],	
				'zone_id'=>implode(',',$post['zone_id']),
				'city_map_status' => $post['city_map_status'],	
				
							
			);
			$this->CityMapping_model->update_CityMapping_info($update_cityMapping_array,$update_map_id);
			
			$this->session->set_flashdata('message','Updated Successfully.');

			redirect(base_url().'adminManageCityMapping');
		}
		
	}
	public function deleteCityMapping(){
    	$post = $this->input->post(NULL, true);
		$delete_city_map_id = $post['btn_delete_CityMapping'];
		$this->CityMapping_model->delete_CityMapping_info($delete_city_map_id);
        redirect(base_url().'adminManageCityMapping');
    }
    public function zone_list_display($city_id="")
    {
    	
    	extract($_POST);

    	$this->db->select('zone_master.*');
        $this->db->from('zone_master');
        $this->db->where('zone_master.city_id',$city_id);
         $this->db->where('zone_master.zone_status',1);
        
        $this->db->order_by('zone_master.zone_id', 'DESC');
		$data['select_zone'] = $this->db->get()->result();
		$this->load->view('admin/zoneDisplay',$data);
		
    }
	
	
}
