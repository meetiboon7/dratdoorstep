<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class NurseAppointment_old extends GeneralController {

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
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}

	}

	public function index()
	{
		parent::index();
		$this->db->select('appointment_book.*,member.contact_no,member.name,nurse_service_type.nurse_service_name');
		$this->db->from('appointment_book');
		$this->db->join('member','member.member_id = appointment_book.patient_id');
		$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = appointment_book.nurse_service_id');
		$this->db->order_by('appointment_book.appointment_book_id', 'DESC');
		$data['appointment_book'] = $this->db->get()->result_array();


		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/appointmentList',$data);
		$this->load->view(FOOTER);
	}
	
   


	
}
