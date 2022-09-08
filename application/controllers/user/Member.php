<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

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

		$this->db->select('member.*');
		$this->db->from('member');
		//$this->db->join('city','city.city_id = member.city_id');	
		
		$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
		$this->db->where('member.status','1');
		$this->db->order_by('member.member_id', 'DESC');

									  
		$data['member'] = $this->db->get()->result_array();

		
		$this->load->view(USERHEADER);
		$this->load->view(MEMBER,$data);
		$this->load->view(USERFOOTER);
	}

	public function addMember()
	{
		
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$this->load->view(USERHEADER);
		$this->load->view(ADD_MEMBER, $data);
		$this->load->view(USERFOOTER);

	}

	

	public function insertMember(){
		$post = $this->input->post(NULL, true);
		
		$city = $this->db->get_where('city', array('city_id'=>$post['city_id']))->row_array();
		
		
		$member_array = array(
			
			'user_id'=>$this->session->userdata('user')['user_id'],
			'name'=>$post['name'],
			'contact_no'=>$post['contact_no'],
			//'address'=>$post['address'],
			'city_id'=>$post['city_id'],
			'gender'=>$post['gender'],
			'date_of_birth'=>$post['date_of_birth'],
			'status'=>$post['status'],
			
			
			//'e_created_on'=>date('Y-m-d H:i:s')
		);
		
		if($this->db->insert('member', $member_array))
		{
			 $insert_id = $this->db->insert_id();
			$patient_code=$city['city_code'].date("y").$insert_id;
		
			 $this->db->where('member_id', $insert_id);
    		$this->db->update('member', array('patient_code' => $patient_code));

			


			 $this->General_model->uploadMemberImage('./uploads/member_profile/', $insert_id,'profile_','img_profile', 'member','mem_pic');
			$this->session->set_flashdata('message','Member is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'userMember');
	}


	public function editMember()
	{
		$post = $this->input->post(NULL, true);
		$member_id = $post['btn_edit_member'];

		
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['member'] = $this->db->get_where('member', array('member_id'=>$member_id))->row_array();	

		$this->load->view(USERHEADER);
		$this->load->view(EDIT_MEMBER, $data);
		$this->load->view(USERFOOTER);
	}

	public function updateMember(){
		$post = $this->input->post(NULL, true);
		$city = $this->db->get_where('city', array('city_id'=>$post['city_id']))->row_array();
		
		$patient_code=$city['city_code'].date("y").$post['btn_update_member'];
		$member_array = array(
			
			'user_id'=>$this->session->userdata('user')['user_id'],
			'name'=>$post['name'],
			'contact_no'=>$post['contact_no'],
			'patient_code'=>$patient_code,
			'city_id'=>$post['city_id'],
			'gender'=>$post['gender'],
			'date_of_birth'=>$post['date_of_birth'],
			'status'=>$post['status'],
			
			//'e_created_on'=>date('Y-m-d H:i:s')
		);

		$this->db->where(array('member_id'=>$post['btn_update_member']));	
		if($this->db->update('member',$member_array))
		{

			$this->General_model->uploadMemberImage('./uploads/member_profile/', $post['btn_update_member'],'profile_','img_profile', 'member','mem_pic');
			$this->session->set_flashdata('message','Member is updated.');
		}else{
			$this->session->set_flashdata('message','Something went wrong.');
		}


		redirect(base_url().'userMember');	
	}
	public function deleteMember(){
    	$post = $this->input->post(NULL, true);
		$delete_member_id = $post['btn_delete_member'];
		
		$this->db->where('member_id',$delete_member_id);
    	$this->db->update('member', array('status' => '0'));
        // echo $this->db->last_query();
        // exit;

         $this->db->where(array('patient_id'=>$delete_member_id));
         $this->db->delete('cart');
         $this->session->set_flashdata('message','Member is Deleted.');
        redirect(base_url().'userMember');
    }
}
