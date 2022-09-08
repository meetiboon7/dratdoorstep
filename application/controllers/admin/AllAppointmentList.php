<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class AllAppointmentList extends GeneralController {

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
		$this->db->select('*');
	   	$this->db->from('city');
	   	$this->db->order_by('city.city_id', 'DESC');

       $data['city'] = $this->db->get()->result_array();
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/AllAppointmentList',$data);
		$this->load->view(FOOTER);
	}
	public function get_details_appointment()
    {
        parent::index();


       $this->db->select('*');
	   $this->db->from('city');
	   $this->db->order_by('city.city_id', 'DESC');

       $data['city'] = $this->db->get()->result_array();

                 

        $post = $this->input->post(NULL, true);
                  
           
	    $city_name = $post['city_id'];
	    $from_date  = date("Y-m-d",strtotime($post['from_date']));
	    $to_date    = date("Y-m-d",strtotime($post['to_date']));

             // $this->db->select('attendence_mst.*, CONCAT(user.first_name,  '.'  , user.last_name) AS name,location_mapping.location,attendence_mst.location_id');
        $this->db->select('extra_invoice.*,member.member_id,member.name');
        $this->db->from('extra_invoice');
        $this->db->join('member','extra_invoice.patient_id = member.member_id',LEFT);
        $this->db->where('member.city_id LIKE "%'.$city_name.'%" and DATE(appmt_date) BETWEEN "'. date('Y-m-d', strtotime($from_date)). '" and "'. date('Y-m-d', strtotime($to_date)).'"');
        $this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
            
        $data['all_appointment_details'] = $this->db->get()->result_array();
		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/AllAppointmentList',$data);
		$this->load->view(FOOTER);

    }
    public function invoice_recipt_appo()
	{
		 
		 
		$post = $this->input->post(NULL, true);
		$this->db->select('extra_invoice.*,member.name,member.address,member.city_id');
		$this->db->from('extra_invoice');
		$this->db->join('member','member.member_id = extra_invoice.patient_id','LEFT');
		
		$this->db->where('extra_invoice.extra_invoice_id',$_POST['extra_invoice_id']);
		$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
		$data['extra_invoice']= $this->db->get()->row_array();


		// echo "<pre>";
		// 	print_r($data['extra_invoice']);
		// 	echo "</pre>";
		// 	exit;
		$extra_invoice_id=$data['extra_invoice'];
		if($extra_invoice_id[appointment_book_id]!=0)
		{
			
			$this->db->select('appointment_book.address_id,add_address.*,additional_payment.amount,additional_payment.note');
			$this->db->from('appointment_book');
			$this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
			$this->db->join('additional_payment','additional_payment.appointment_id = appointment_book.appointment_book_id','LEFT');
			$this->db->where('appointment_book.appointment_book_id',$extra_invoice_id[appointment_book_id]);
			//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$data1['address_data']= $this->db->get()->row_array();
// 			echo $this->db->last_query();
// 			exit;
			
       		
		}
		elseif($extra_invoice_id[book_nurse_id]!=0){
			
			$this->db->select('book_nurse.address_id,add_address.*,additional_payment.amount,additional_payment.note');
			$this->db->from('book_nurse');
			$this->db->join('add_address','add_address.address_id = book_nurse.address_id','LEFT');
			$this->db->join('additional_payment','additional_payment.appointment_id = book_nurse.book_nurse_id','LEFT');
			$this->db->where('book_nurse.book_nurse_id',$extra_invoice_id[book_nurse_id]);
			//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$data1['address_data']= $this->db->get()->row_array();

			

        // redirect(base_url().'adminAllAppointment');

		}
		elseif($extra_invoice_id[book_laboratory_test_id]!=0){

			

			$this->db->select('book_laboratory_test.address_id,add_address.*,additional_payment.amount,additional_payment.note');
			$this->db->from('book_laboratory_test');
			$this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
			$this->db->join('additional_payment','additional_payment.appointment_id = book_laboratory_test.book_laboratory_test_id','LEFT');
			$this->db->where('book_laboratory_test.book_laboratory_test_id',$extra_invoice_id[book_laboratory_test_id]);
			//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$data1['address_data']= $this->db->get()->row_array();
       

		}
		elseif($extra_invoice_id[book_homecare_id]!=0){

			$this->db->select('book_homecare.*');
			$this->db->from('book_homecare');
			$this->db->where('book_homecare.book_homecare_id',$extra_invoice_id[book_homecare_id]);
			$data1['address_data']= $this->db->get()->row_array();
			
		}
		elseif($extra_invoice_id[book_ambulance_id]!=0)
		{
            
			$this->db->select('book_ambulance.from_address,book_ambulance.to_address,additional_payment.amount,additional_payment.note');
			$this->db->from('book_ambulance');
			$this->db->join('additional_payment','additional_payment.appointment_id = book_ambulance.book_ambulance_id','LEFT');
			//$this->db->join('add_address','add_address.address_id = book_ambulance.address_id','LEFT');
			$this->db->where('book_ambulance.book_ambulance_id',$extra_invoice_id[book_ambulance_id]);
			//$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
			$data1['address_data']= $this->db->get()->row_array();

		}
		$data_all = array_merge($data,$data1);
		$this->load->view('admin/invoice_appointment',$data_all);
	}
	public function extra_invoice_edit()
	{
		parent::index();
		$post = $this->input->post(NULL, true);
		$ext_inv_id = $post['extra_invoice_id_edit'];

		
		//$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$data['extra_invoice_data'] = $this->db->get_where('extra_invoice', array('extra_invoice_id'=>$ext_inv_id))->row_array();	

		

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/editAppointmentData',$data);
		$this->load->view(FOOTER);
	}

    public function adminupdateAppointment()
    {
    	$post = $this->input->post(NULL, true);
    	// echo "<pre>";
    	// print_r($post);
    	// exit;
		$edit_inv= $post['btn_update_appointment'];
		
		$appointment_array = array(
			
			'date'=>$post['date'],
			'appmt_date'=>$post['date'],
			'price'=>$post['amount'],
		);
		
		

		$this->db->select('extra_invoice.appointment_book_id,extra_invoice.book_nurse_id,extra_invoice.book_laboratory_test_id,extra_invoice.book_homecare_id,extra_invoice.book_ambulance_id');
		$this->db->from('extra_invoice');
		$this->db->where('extra_invoice.extra_invoice_id',$edit_inv);
		$extra_invoice_id= $this->db->get()->row_array();
		
		$this->db->where(array('extra_invoice_id'=>$edit_inv));
		$this->db->update('extra_invoice',$appointment_array);
		
	
		
		

		if($extra_invoice_id[appointment_book_id]!=0)
		{
			
			$appointment_book_doctor = array(
				'txndate'=>$post['date'],
				'date'=>$post['date'],
			    'total'=>$post['amount'],
			);
			
			$this->db->where(array('appointment_book_id'=>$extra_invoice_id[appointment_book_id]));
			$this->db->update('appointment_book',$appointment_book_doctor);

       		
		}
		elseif($extra_invoice_id[book_nurse_id]!=0){
			
			$appointment_book_nurse = array(
				'txndate'=>$post['date'],
				'date'=>$post['date'],
			    'total'=>$post['amount'],
			);
			
			$this->db->where(array('book_nurse_id'=>$extra_invoice_id[book_nurse_id]));
			$this->db->update('book_nurse',$appointment_book_nurse);

			

        // redirect(base_url().'adminAllAppointment');

		}
		elseif($extra_invoice_id[book_laboratory_test_id]!=0){

			$appointment_book_lab = array(
				'txndate'=>$post['date'],
				'date'=>$post['date'],
			    'total'=>$post['amount'],
			);
			
			$this->db->where(array('book_laboratory_test_id'=>$extra_invoice_id[book_laboratory_test_id]));
			$this->db->update('book_laboratory_test',$appointment_book_lab);
       

		}elseif($extra_invoice_id[book_homecare_id]!=0){

			$appointment_book_home = array(
				'txndate'=>$post['date'],
				'date'=>$post['date'],
			    'total'=>$post['amount'],
			);
			
			$this->db->where(array('book_homecare_id'=>$extra_invoice_id[book_homecare_id]));
			$this->db->update('book_homecare',$appointment_book_home);

			
		}
		elseif($extra_invoice_id[book_ambulance_id]!=0)
		{

			$appointment_book_amb = array(
				'txndate'=>$post['date'],
				'date'=>$post['date'],
			    'amount'=>$post['amount'],
			);
			
			$this->db->where(array('book_ambulance_id'=>$extra_invoice_id[book_ambulance_id]));
			$this->db->update('book_ambulance',$appointment_book_amb);

		}
        
        redirect(base_url().'adminAllAppointment');
       
    }
    public function extra_invoice_delete()
    {
    	$post = $this->input->post(NULL, true);
    	/*echo "<pre>";
    	print_r($post);
    	exit;*/
		$delete_inv= $post['extra_invoice_id_del'];
		
		

		$this->db->select('extra_invoice.appointment_book_id,extra_invoice.book_nurse_id,extra_invoice.book_laboratory_test_id,extra_invoice.book_homecare_id,extra_invoice.book_ambulance_id');
		$this->db->from('extra_invoice');
		$this->db->where('extra_invoice.extra_invoice_id',$delete_inv);
		$extra_invoice_id= $this->db->get()->row_array();
		


		// echo "<pre>";
		// print_r($extra_invoice_id);
		// exit;

		if($extra_invoice_id[appointment_book_id]!=0)
		{
			$this->db->where('appointment_book_id',$extra_invoice_id[appointment_book_id]);
       		$this->db->delete('appointment_book');
       	// 	$this->session->set_flashdata('message','Invoice Record Deleted');

        // redirect(base_url().'adminAllAppointment');
		}
		elseif($extra_invoice_id[book_nurse_id]!=0){
			
			$this->db->where('book_nurse_id',$extra_invoice_id[book_nurse_id]);
       		$this->db->delete('book_nurse');
       	// 	$this->session->set_flashdata('message','Invoice Record Deleted');

        // redirect(base_url().'adminAllAppointment');

		}
		elseif($extra_invoice_id[book_laboratory_test_id]!=0){

			$this->db->where('book_laboratory_test_id',$extra_invoice_id[book_laboratory_test_id]);
       		$this->db->delete('book_laboratory_test');
       	// 	$this->session->set_flashdata('message','Invoice Record Deleted');

        // redirect(base_url().'adminAllAppointment');

		}elseif($extra_invoice_id[book_homecare_id]!=0){
			$this->db->where('book_homecare_id',$extra_invoice_id[book_homecare_id]);
       		$this->db->delete('book_homecare');
       	// 	$this->session->set_flashdata('message','Invoice Record Deleted');

        // redirect(base_url().'adminAllAppointment');
		}
		elseif($extra_invoice_id[book_ambulance_id]!=0)
		{
			$this->db->where('book_ambulance_id',$extra_invoice_id[book_ambulance_id]);
       		$this->db->delete('book_ambulance');
       	// 	$this->session->set_flashdata('message','Invoice Record Deleted');

        // redirect(base_url().'adminAllAppointment');
		}
        
        $this->db->where('extra_invoice_id',$delete_inv);
       	$this->db->delete('extra_invoice');
       	 redirect(base_url().'adminAllAppointment');
       
    }
	
}
