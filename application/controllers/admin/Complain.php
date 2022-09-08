<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");

class Complain extends GeneralController {

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
		//$this->load->model('user/member_model');
		 $this->load->model('General_model');
		// if(!$this->Login_model->check_admin_login()){
		// 	redirect(base_url().'admin');
		// }
				
	}	

	public function index()
	{
		parent::index();
		$this->db->select('feedback.*,feedback_options.name,feedback_services.name as service_name');
		$this->db->from('feedback');
		$this->db->join('feedback_options','feedback_options.feedback_options_id = feedback.feedback_options_id');
		$this->db->join('feedback_services','feedback_services.feedback_services_id = feedback.type');
		//$this->db->where('feedback.user_id',$this->session->userdata('user')['user_id']);
		 $this->db->order_by('feedback.feedback_id', 'DESC');

									  
		$data['user_feedback'] = $this->db->get()->result_array();

		
		$this->load->view(HEADER, $this->viewdata);
		$this->load->view(ADMINCOMPLAIN,$data);
			$this->load->view(FOOTER);
	}



	

	
	
}
