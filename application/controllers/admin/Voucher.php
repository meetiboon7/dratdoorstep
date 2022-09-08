<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class Voucher extends GeneralController {

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
		//$this->load->model('admin/ManageFees_model');
		$this->load->model('General_model');
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}
				
	}	

	public function index()
	{
		parent::index();

		$query_date = '2010-02-04';

// First day of the month.
// echo date('Y-m-01', strtotime($query_date));

// // Last day of the month.
// echo date('Y-m-t', strtotime($query_date));

		// echo date('l',strtotime(date('Y-01-01')));
		$yearstart = date('Y-m-d', strtotime('01/01'));
		$yearEnd = date('Y-m-d', strtotime('12/31'));
		

//,city.city
		$this->db->select('voucher.*');
		$this->db->from('voucher');
		//$this->db->join('manage_roles','manage_roles.role_id = manage_fees.role_id');
		//$this->db->join('city','city.city_id = voucher.city_id');
		//$this->db->where('voucher.from_date BETWEEN "'. $yearstart. '" and "'.$yearEnd.'"');
		$this->db->where('voucher.from_date >=', $yearstart);
			$this->db->where('voucher.to_date <=', $yearEnd);
		 // $this->db->where('voucher.from_date >=', $yearstart);
		 //  $this->db->where('voucher.to_date <=', $yearEnd);
		 //$this->db->where('YEAR(paid_date)', date('Y'));
		//$this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
		 $this->db->order_by('voucher.voucher_id', 'DESC');

		 
									  
		$data['voucher'] = $this->db->get()->result_array();

		// echo $this->db->last_query();
		// exit;

		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(VOUCHER, $data);
		$this->load->view(FOOTER);
	}

	public function addVoucher()
	{
		parent::index();
		//$data['fees_type'] = $this->db->get_where('fees_type', array('status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();

		$data['service_type'] = $this->db->get_where('user_type', array('status'=>1))->result_array();

		$data['packages'] = $this->db->get_where('manage_package', array('package_status'=>1))->result_array();
		//$data['manage_roles'] = $this->db->get_where('manage_roles', array('role_status'=>1))->result_array();

		
		

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(ADD_VOUCHER, $data);
		$this->load->view(FOOTER);

	}

	public function voucherSearch()
	{
		parent::index();
		$post = $this->input->post(NULL, true);
		//$data['fees_type'] = $this->db->get_where('fees_type', array('status'=>1))->result_array();
		$this->db->select('voucher.*');
		$this->db->from('voucher');
		$this->db->where('voucher.from_date >=', $post['from_date']);
		$this->db->where('voucher.to_date <=', $post['to_date']);
		$this->db->order_by('voucher.voucher_id', 'DESC');
		$data['voucher'] = $this->db->get()->result_array();

		// echo $this->db->last_query();
		// exit;
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(VOUCHER, $data);
		$this->load->view(FOOTER);

	}

	

	public function insertVoucher(){
		$post = $this->input->post(NULL, true);

	    if($post['visi_and_invisi']=="on")
		{
			$visi_and_invisi=1;
		}
		else
		{
			$visi_and_invisi=0;
		}

		if($post['serivce_radio']=='Services')
		{
				$voucher_array = array(
				'title'=>$post['title'],
				'service_id'=>$post['service_id'],
				'code'=>$post['code'],
				'from_date'=>$post['from_date'],
				'to_date'=>$post['to_date'],
				'desc'=>$post['desc'],
				'amount'=>$post['amount'],
				'type'=>$post['type'],
				'city_id'=>implode(',',$post['city_id']),
				'visi_and_invisi'=>$visi_and_invisi,

				//'user_id'=>$this->session->userdata('admin_user')['user_id'],
				
			);
		}
		elseif ($post['serivce_radio']=='Package') {

			$voucher_array = array(
				'title'=>$post['title'],
				'package_id'=>$post['package_id'],
				'code'=>$post['code'],
				'from_date'=>$post['from_date'],
				'to_date'=>$post['to_date'],
				'desc'=>$post['desc'],
				'amount'=>$post['amount'],
				'type'=>$post['type'],
				'city_id'=>implode(',',$post['city_id']),
				'visi_and_invisi'=>$visi_and_invisi,
			);
		}elseif ($post['serivce_radio']=='All') {

			$voucher_array = array(
				'title'=>$post['title'],
				'all_service'=>-1,
				'code'=>$post['code'],
				'from_date'=>$post['from_date'],
				'to_date'=>$post['to_date'],
				'desc'=>$post['desc'],
				'amount'=>$post['amount'],
				'type'=>$post['type'],
				'city_id'=>implode(',',$post['city_id']),
				'visi_and_invisi'=>$visi_and_invisi,
			);
		}

		
		
		
		if($this->db->insert('voucher', $voucher_array))
		{
			 $insert_id = $this->db->insert_id();
			
			
			$this->session->set_flashdata('message','Voucher is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'adminVoucher');
	}


	public function editVoucher()
	{
		
		parent::index();
		$post = $this->input->post(NULL, true);
		$voucher_id = $post['btn_edit_voucher'];

		//$data['fees_type'] = $this->db->get_where('fees_type', array('status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['service_type'] = $this->db->get_where('user_type', array('status'=>1))->result_array();
		$data['packages'] = $this->db->get_where('manage_package', array('package_status'=>1))->result_array();
		//$data['manage_roles'] = $this->db->get_where('manage_roles', array('role_status'=>1))->result_array();
		$data['voucher'] = $this->db->get_where('voucher', array('voucher_id'=>$voucher_id))->row_array();	

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(EDIT_VOUCHER, $data);
		$this->load->view(FOOTER);
	}

	public function updateVoucher(){
		$post = $this->input->post(NULL, true);
		
// 		echo "<pre>";
// 		print_r($post);
// 		exit;

		if(!empty($post['visi_and_invisi']))
		{
			$visi_and_invisi=1;
		}
		else
		{
			$visi_and_invisi=0;
		}
		

		if($post['serivce_radio']=='Services')
		{
				$voucher_array = array(
				'title'=>$post['title'],
				'service_id'=>$post['service_id'],
				'code'=>$post['code'],
				'from_date'=>$post['from_date'],
				'to_date'=>$post['to_date'],
				'desc'=>$post['desc'],
				'amount'=>$post['amount'],
				'type'=>$post['type'],
				'city_id'=>implode(',',$post['city_id']),
				'visi_and_invisi'=>$visi_and_invisi,

				//'user_id'=>$this->session->userdata('admin_user')['user_id'],
				
			);
			$this->db->where(array('voucher_id'=>$post['btn_update_voucher']));	
			if($this->db->update('voucher', $voucher_array))
			{
				
				 $this->db->where('voucher_id',$post['btn_update_voucher']);
    			$this->db->update('voucher', array('package_id' =>''));

    			$this->db->where('voucher_id',$post['btn_update_voucher']);
    			$this->db->update('voucher', array('all_service' =>'0'));
    			
				$this->session->set_flashdata('message','Voucher Details is updated.');
			}else{
				$this->session->set_flashdata('message','Something went wrong.');
			}


		}
		elseif ($post['serivce_radio']=='Package') {

			$voucher_array = array(
				'title'=>$post['title'],
				'package_id'=>$post['package_id'],
				'code'=>$post['code'],
				'from_date'=>$post['from_date'],
				'to_date'=>$post['to_date'],
				'desc'=>$post['desc'],
				'amount'=>$post['amount'],
				'type'=>$post['type'],
				'city_id'=>implode(',',$post['city_id']),
				'visi_and_invisi'=>$visi_and_invisi,
			);
			$this->db->where(array('voucher_id'=>$post['btn_update_voucher']));	
			if($this->db->update('voucher', $voucher_array))
			{
				 $this->db->where('voucher_id',$post['btn_update_voucher']);
    			$this->db->update('voucher', array('service_id' =>''));

    			$this->db->where('voucher_id',$post['btn_update_voucher']);
    			$this->db->update('voucher', array('all_service' =>'0'));

				$this->session->set_flashdata('message','Voucher Details is updated.');
			}else{
				$this->session->set_flashdata('message','Something went wrong.');
			}
		}elseif ($post['serivce_radio']=='All') {

			$voucher_array = array(
				'title'=>$post['title'],
				'all_service'=>-1,
				'code'=>$post['code'],
				'from_date'=>$post['from_date'],
				'to_date'=>$post['to_date'],
				'desc'=>$post['desc'],
				'amount'=>$post['amount'],
				'type'=>$post['type'],
				'city_id'=>implode(',',$post['city_id']),
				'visi_and_invisi'=>$visi_and_invisi,
			);
			$this->db->where(array('voucher_id'=>$post['btn_update_voucher']));	
			if($this->db->update('voucher', $voucher_array))
			{
				$this->db->where('voucher_id',$post['btn_update_voucher']);
    			$this->db->update('voucher', array('package_id' =>''));

    			$this->db->where('voucher_id',$post['btn_update_voucher']);
    			$this->db->update('voucher', array('service_id' =>''));

				$this->session->set_flashdata('message','Voucher Details is updated.');
			}else{
				$this->session->set_flashdata('message','Something went wrong.');
			}
		}

		


		redirect(base_url().'adminVoucher');	
	}
	public function deleteVoucher(){
    	$post = $this->input->post(NULL, true);
		$delete_voucher_id = $post['btn_delete_voucher'];
		$this->db->where('voucher_id',$delete_voucher_id);
        $this->db->delete('voucher');
         $this->session->set_flashdata('message','Voucher Deleted successfully.');
        redirect(base_url().'adminVoucher');
    }
}
