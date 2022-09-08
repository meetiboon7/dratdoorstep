<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/stack_web_gateway_paytm_kit/Stack_recharge_gateway_paytm_kit.php';

class Voucher extends CI_Controller {

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
		// $this->db->from('voucher');
		// $this->db->where('voucher.to_date >=',date('Y-m-d'));
		// $this->db->order_by('voucher.voucher_id', 'DESC');
		$this->db->select('voucher.*,GROUP_CONCAT(DISTINCT city.city) as city,GROUP_CONCAT(DISTINCT manage_package.package_name) as package_name, GROUP_CONCAT(DISTINCT user_type.user_type_name) as user_type_name');
                     $this->db->from('voucher');
                     //$this->db->join('city','city.city_id = voucher.city_id');
                     $this->db->join("city","find_in_set(city.city_id,voucher.city_id) <> 0",'LEFT',false);
                     $this->db->join("manage_package","find_in_set(manage_package.package_id,voucher.package_id) <> 0",'LEFT',false);
                     $this->db->join("user_type","find_in_set(user_type.user_type_id,voucher.service_id) <> 0","LEFT",false);
                   // $this->db->where('voucher.from_date <=',date('Y-m-d'));
                    $this->db->where('voucher.to_date >=',date('Y-m-d'));
                     $this->db->where('voucher.visi_and_invisi',1);
                     $this->db->group_by('voucher.voucher_id');
									  
		$data['voucher_list'] = $this->db->get()->result_array();

		
		$this->load->view(USERHEADER);
		$this->load->view('user/listVoucher',$data);
		$this->load->view(USERFOOTER);
	}
	
	
	
	
}
