<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class AllPatient extends GeneralController {

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
		$cityy=explode(',', $this->session->userdata('admin_user')['city_permission']);
		// echo $this->session->userdata('admin_user')['city_permission']."==".$cityy[1];
		// echo $this->session->userdata('admin_user')['city_permission']."==".'163,139';
		//  exit;
		if($this->session->userdata('admin_user')['role_id']==-1)
		{
			
			$this->db->select('member.name,member.member_id,member.user_id');
		   	$this->db->from('member');
		   	$this->db->where('member.status',1);
		   	$this->db->order_by('member.member_id', 'DESC');
		   //	$this->db->limit(20,0);
			$data['member'] = $this->db->get()->result_array();
		}
		elseif($this->session->userdata('admin_user')['city_permission']=='163')
		{
			// echo "1";
			// exit;
			$this->db->select('member.name,member.member_id,member.user_id');
		   	$this->db->from('member');
		   	$this->db->where('member.city_id',163);
		   	$this->db->where('member.status',1);
		   	$this->db->order_by('member.member_id', 'DESC');
		   //	$this->db->limit(20,0);
			$data['member'] = $this->db->get()->result_array();
		}
		elseif($this->session->userdata('admin_user')['city_permission']=='139')
		{
			// echo "2";
			// exit;
			$this->db->select('member.name,member.member_id,member.user_id');
		   	$this->db->from('member');
		   	$this->db->where('member.city_id',139);
		   	$this->db->where('member.status',1);
		   	$this->db->order_by('member.member_id', 'DESC');
		   //	$this->db->limit(20,0);
			$data['member'] = $this->db->get()->result_array();
		}
		elseif($this->session->userdata('admin_user')['city_permission']=='163,139')
		{
			// echo "3";
			// exit;
			$this->db->select('member.name,member.member_id,member.user_id');
		   	$this->db->from('member');
		   	$this->db->where('member.status',1);
		   	$this->db->order_by('member.member_id', 'DESC');
		   //	$this->db->limit(20,0);
			$data['member'] = $this->db->get()->result_array();
		}
		
		// echo $this->db->last_query();
		// exit;
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/memberList',$data);
		$this->load->view(FOOTER);
	}
	public function editMember()
	{
		parent::index();
		$post = $this->input->post(NULL, true);
		$member_id = $post['btn_edit_member'];

		
		//$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['member'] = $this->db->get_where('member', array('member_id'=>$member_id))->row_array();	

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/editMemberData',$data);
		$this->load->view(FOOTER);
	}

	public function adminupdateMember(){
		$post = $this->input->post(NULL, true);
		
		$member_array = array(
			
			
			'name'=>$post['name'],
			
			
			//'e_created_on'=>date('Y-m-d H:i:s')
		);

		$this->db->where(array('member_id'=>$post['btn_update_member']));	
		if($this->db->update('member',$member_array))
		{

			
			$this->session->set_flashdata('message','Member is updated.');
		}else{
			$this->session->set_flashdata('message','Something went wrong.');
		}


		redirect(base_url().'adminAllPatient');	
	}
	
}
