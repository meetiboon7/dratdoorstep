<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuccessPaymentPage extends CI_Controller {

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
		 //logout releted code add 10-12-2020
		  $this->load->model('user/Login_model');
		// $this->load->model('General_model');
		if(!$this->Login_model->check_user_login()){
			redirect(base_url());
		}
		//logout releted code add 10-12-2020
				
	}		


	public function index()
	{

		// echo "test";
		// exit;

		// $this->db->select('*');
		// $this->db->from('recharge');
		// $this->db->where('recharge.user_id',$this->session->userdata('user')['user_id']);
		// $this->db->order_by('recharge.recharge_id', 'DESC');
									  
		// $data['manage_wallet'] = $this->db->get()->result_array();
		
		//$this->load->view(USERHEADER);
		$this->load->view('user/successPayment');
		//$this->load->view(USERFOOTER);
	}
	public function FailPaymentPage()
	{

		
		//$this->load->view(USERHEADER);
		$this->load->view('user/FailPaymentPage');
		//$this->load->view(USERFOOTER);
	}
	
	
	
}
