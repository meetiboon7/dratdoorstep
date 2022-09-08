<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holidays extends CI_Controller {

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
		
		$this->load->model('admin/Holiday_model');
		$this->load->model('admin/Zone_model');
		$this->load->model('admin/Login_model');	
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}
		
	}

	public function index()
	{
		
		
		


		$all_holiday = $this->Holiday_model->list_holiday();
		

        if($all_holiday)
        {
            $this->viewdata['all_holiday'] = $all_holiday;
        }
        else
        {
            $this->viewdata['all_holiday'] = '';
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
		$this->load->view('admin/holidayList',$this->viewdata);
		$this->load->view(FOOTER);

		
	}
	public function insertHoliday(){
		$post = $this->input->post(NULL, true);
		
		if (!empty($post)) {
			
			$holiday_array = array(
				'city_id'=>implode(',',$post['city_id']),
			
				'hdate' => $post['hdate'],	
				'hday' => $post['hday'],	
							
			);
			$this->Holiday_model->add_holiday($holiday_array);
			
			$this->session->set_flashdata('message','Holiday added successfully.');
			
			redirect(base_url().'adminHolidayList');
		}
	}
	public function editHoliday()
	{

		$post = $this->input->post(NULL, true);
		

		$view_holiday_id = $post['btn_edit_holiday'];
		

		$view_holiday = $this->Holiday_model->view_single_holiday($view_holiday_id);
        if($view_holiday)
        {
            $this->viewdata['view_holiday'] = $view_holiday;
        }
        else
        {
            $this->viewdata['view_holiday'] = '';	
        }

        
        echo json_encode($view_holiday);
	}
	public function updateHoliday(){
		$post = $this->input->post(NULL, true);

		if (!empty($post)) {
			
			$update_holiday_id = $post['btn_update_holiday'];
			/*echo '<pre>';
			print_r($post);*/
			$updateHoliday_array = array(
				'city_id'=>implode(',',$post['city_id']),
				'hdate' => $post['hdate'],	
				'hday' => $post['hday'],
			);
			$this->Holiday_model->update_holiday_info($updateHoliday_array,$update_holiday_id);
			
			$this->session->set_flashdata('message','Holiday updated successfully.');

			redirect(base_url().'adminHolidayList');
		}
		
	}
	public function deleteHoliday(){
    	$post = $this->input->post(NULL, true);
		$delete_holiday_id = $post['btn_delete_holiday'];
		$this->Holiday_model->delete_holiday_info($delete_holiday_id);
        redirect(base_url().'adminHolidayList');
    }

	
	
}
