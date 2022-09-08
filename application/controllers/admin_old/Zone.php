<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zone extends CI_Controller {

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
		$this->load->model('admin/Zone_model');	
		$this->load->model('admin/Login_model');	
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}
	}

	public function index()
	{
		
		
		


		$all_zone = $this->Zone_model->list_zone();
		

        if($all_zone)
        {
            $this->viewdata['all_zone'] = $all_zone;
        }
        else
        {
            $this->viewdata['all_zone'] = '';
        }


        $all_city = $this->Zone_model->list_city();
		

        if($all_city)
        {
            $this->viewdata['all_city'] = $all_city;
        }
        else
        {
            $this->viewdata['all_city'] = '';
        }
		
		$this->load->view(HEADER);
		$this->load->view('admin/zoneList',$this->viewdata);
		$this->load->view(FOOTER);

		
	}
	public function insertzone(){
		$post = $this->input->post(NULL, true);
		
		if (!empty($post)) {
			
			$zone_array = array(
				'city_id'=>$post['city_id'],
				'zone_name' => $post['zone_name'],	
				'zone_status' => $post['zone_status'],	
							
			);
			$this->Zone_model->add_zone($zone_array);
			
			$this->session->set_flashdata('message','Zone added successfully.');
			
			redirect(base_url().'adminZoneList');
		}
	}
	public function editZone()
	{

		$post = $this->input->post(NULL, true);
		

		$view_zone_id = $post['btn_edit_zone'];
		

		$view_zone = $this->Zone_model->view_single_zone($view_zone_id);
        if($view_zone)
        {
            $this->viewdata['view_zone'] = $view_zone;
        }
        else
        {
            $this->viewdata['view_zone'] = '';	
        }

        
        echo json_encode($view_zone);
	}
	public function updateZone(){
		$post = $this->input->post(NULL, true);

		if (!empty($post)) {
			
			$update_zone_id = $post['btn_update_zone'];
			/*echo '<pre>';
			print_r($post);*/
			$updateZone_array = array(
				'city_id'=>$post['city_id'],
				'zone_name' => $post['zone_name'],	
				'zone_status' => $post['zone_status'],
			);
			$this->Zone_model->update_zone_info($updateZone_array,$update_zone_id);
			
			$this->session->set_flashdata('message','Zone updated successfully.');

			redirect(base_url().'adminZoneList');
		}
		
	}
	public function deleteZone(){
    	$post = $this->input->post(NULL, true);
		$delete_zone_id = $post['btn_delete_zone'];
		$this->Zone_model->delete_zone_info($delete_zone_id);
        redirect(base_url().'adminZoneList');
    }

	
	
}
