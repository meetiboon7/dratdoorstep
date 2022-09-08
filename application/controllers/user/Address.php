<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Address extends CI_Controller {

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

		$this->db->select('add_address.*,city.city');
		$this->db->from('add_address');
		$this->db->join('city','city.city_id = add_address.city_id');	
		$this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
		$this->db->where('add_address.status','1');
		$this->db->order_by('add_address.address_id', 'DESC');

									  
		$data['address_member'] = $this->db->get()->result_array();

		

		
		$this->load->view(USERHEADER);
		$this->load->view(ADDRESS,$data);
		$this->load->view(USERFOOTER);
	}

	public function addAddress()
	{
		
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view(ADD_ADDRESS, $data);
		$this->load->view(USERFOOTER);

	}

	

	public function insertAddress(){
		$post = $this->input->post(NULL, true);
		$address_array = array(
			
			'user_id'=>$this->session->userdata('user')['user_id'],
			'address_1'=>$post['address_1']." ",
			'address_2'=>$post['address_2']." ",
			'city_id'=>$post['city_id'],
			'state_id'=>$post['state_id'],
			'country_id'=>$post['country_id'],
			'pincode'=>$post['pincode'],
			'status'=>$post['status'],
			
			
			//'e_created_on'=>date('Y-m-d H:i:s')
		);
		
		if($this->db->insert('add_address', $address_array))
		{
			$this->session->set_flashdata('message','Address is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'userAddress');
	}


	public function editAddress()
	{
		$post = $this->input->post(NULL, true);
		$address_id = $post['btn_edit_address'];

		
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['address_member'] = $this->db->get_where('add_address', array('address_id'=>$address_id))->row_array();	

		$this->load->view(USERHEADER);
		$this->load->view(EDIT_ADDRESS, $data);
		$this->load->view(USERFOOTER);
	}

	public function updateAddress(){
		$post = $this->input->post(NULL, true);
		

		$address_array = array(
			
			'user_id'=>$this->session->userdata('user')['user_id'],
			'address_1'=>$post['address_1']." ",
			'address_2'=>$post['address_2']." ",
			'city_id'=>$post['city_id'],
			'state_id'=>$post['state_id'],
			'country_id'=>$post['country_id'],
			'pincode'=>$post['pincode'],
			'status'=>$post['status'],
			
			
			//'e_created_on'=>date('Y-m-d H:i:s')
		);

		$this->db->where(array('address_id'=>$post['btn_update_address']));	
		if($this->db->update('add_address',$address_array))
		{
			$this->session->set_flashdata('message','Address is updated.');
		}else{
			$this->session->set_flashdata('message','Something went wrong.');
		}


		redirect(base_url().'userAddress');	
	}
	public function deleteAddress(){
    	
    	$post = $this->input->post(NULL, true);
		$delete_address_id = $post['btn_delete_address'];
		// $this->db->where('address_id',$delete_address_id);
  //       $this->db->delete('add_address');

        $this->db->where('address_id',$delete_address_id);
    	$this->db->update('add_address', array('status' => '0'));

    	$this->db->where(array('address'=>$delete_address_id));
        $this->db->delete('cart');
         $this->session->set_flashdata('message','Address is Deleted.');

        redirect(base_url().'userAddress');
    }
}
