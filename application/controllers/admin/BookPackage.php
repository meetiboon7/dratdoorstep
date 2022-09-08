<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");


class BookPackage extends GeneralController {

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
        
        $admin = $this->session->userdata('admin_user')['role_id'];
        $login_user_id = $this->session->userdata('admin_user')['user_type_id'];
        $front_office = $this->session->userdata('admin_user')['user_type_id'];
        $manager = $this->session->userdata('admin_user')['user_type_id'];
        $dr_admin = $this->session->userdata('admin_user')['user_type_id'];
        $ambulance = $this->session->userdata('admin_user')['user_type_id'];
        
        if($admin == '-1' || $dr_admin == '6' ||$front_office == '7' || $manager == '8')
        {
        	$this->db->select('package_booking.*,manage_package.package_name,user_type.user_type_name,member.name');
		    $this->db->from('package_booking');
		    $this->db->join('manage_package','manage_package.package_id = package_booking.package_id');
		    $this->db->join('user_type','user_type.user_type_id = package_booking.service_id');
		    $this->db->join('member','member.member_id = package_booking.patient_id');
		    //$this->db->where('package_booking.service_id',$login_user_id);
		    $this->db->order_by('package_booking.id', 'DESC');						  
		    $data['book_package'] = $this->db->get()->result_array();

            
        }
        else
        {
        	// echo "Hello";
        	// exit;
        	$this->db->select('package_booking.*,manage_package.package_name,user_type.user_type_name,member.name');
		    $this->db->from('package_booking');
		    $this->db->join('manage_package','manage_package.package_id = package_booking.package_id');
		    $this->db->join('user_type','user_type.user_type_id = package_booking.service_id');
		    $this->db->join('member','member.member_id = package_booking.patient_id');
		    $this->db->where('package_booking.service_id',$login_user_id);
		    $this->db->order_by('package_booking.id', 'DESC');						  
		    $data['book_package'] = $this->db->get()->result_array();
        }
        
        
        // 		$this->db->select('package_booking.*,manage_package.package_name,user_type.user_type_name,member.name');
        // 		$this->db->from('package_booking');
        // 		$this->db->join('manage_package','manage_package.package_id = package_booking.package_id');
        // 		$this->db->join('user_type','user_type.user_type_id = package_booking.service_id');
        // 		$this->db->join('member','member.member_id = package_booking.patient_id');
        // 		$this->db->order_by('package_booking.id', 'DESC');
        // 		$data['book_package'] = $this->db->get()->result_array();

		
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(BOOK_PACKAGE, $data);
		$this->load->view(FOOTER);
	}

	public function editBookPackage()
	{
		parent::index();
		$post = $this->input->post(NULL, true);
		$book_id = $post['btn_edit_book_package'];

		$data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
		$data['service'] = $this->db->get_where('user_type', array('status'=>1))->result_array();
		$data['manage_package'] = $this->db->get_where('manage_package', array('package_status'=>1))->result_array();

		$data['book_package'] = $this->db->get_where('package_booking', array('id'=>$book_id))->row_array();
			

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(EDIT_BOOK_PACKAGE, $data);
		$this->load->view(FOOTER);
	}

	public function updateBookPackage(){
		$post = $this->input->post(NULL, true);
		
		$book_package_array = array(
			'package_id'=>$post['package_id'],
			'service_id'=>$post['service_id'],
			'patient_id'=>$post['patient_id'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			//'user_id'=>$this->session->userdata('admin_user')['user_id'],
			
		);
		
		$this->db->where(array('id'=>$post['btn_update_book_package']));	
		if($this->db->update('package_booking', $book_package_array))
		{
			$this->session->set_flashdata('message','Book Package Details is updated.');
		}else{
			$this->session->set_flashdata('message','Something went wrong.');
		}


		redirect(base_url().'adminPackageBook');	
	}
		public function book_package_list()
	{
		parent::index();
		
// 		$this->db->select('book_package.*,member.name,manage_package.package_name');
// 		$this->db->from('book_package');
// 		$this->db->join('manage_package','book_package.package_id = manage_package.package_id');
// 		$this->db->join('member','member.member_id = book_package.patient_id');
// 		$this->db->where("((member.status = '0' OR member.status = '1'))");
// 		$this->db->order_by('book_package.package_id', 'DESC');
// 		$data['manage_package'] = $this->db->get()->result_array();

        $this->db->select('package_booking.*,book_package.*,member.member_id,member.name,manage_package.package_name,user_type.user_type_name');
		$this->db->from('package_booking');
        $this->db->join('book_package','book_package.book_package_id = package_booking.book_package_id');
		$this->db->join('manage_package','book_package.package_id = manage_package.package_id');
		$this->db->join('user_type','user_type.user_type_id = book_package.service_id');
		$this->db->join('member','member.member_id = book_package.patient_id');
		//$this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
		 $this->db->where("((member.status = '0' OR member.status = '1'))");
		//$this->db->where('member.status','1');
		//$this->db->or_where('member.status','0'); 
		$this->db->order_by('book_package.book_package_id', 'DESC');							
		$data['manage_package'] = $this->db->get()->result_array();

		$this->db->select('employee_master.*,user_type.user_type_name');
        $this->db->from('employee_master');
        $this->db->join('user_type', 'user_type.user_type_id = employee_master.user_type_id', 'LEFT');
        $this->db->where('employee_master.emp_status', 1);
        $data['manage_employee_assign'] = $this->db->get()->result_array();

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/list_book_package', $data);
		$this->load->view(FOOTER);
	}

	public function package_invoice()
	{
		parent::index();
		$this->db->select('book_package.*,member.name,manage_package.package_name');
		$this->db->from('book_package');
		$this->db->join('manage_package','book_package.package_id = manage_package.package_id');
		//$this->db->join('user_type','user_type.user_type_id = book_package.service_id');
		$this->db->join('member','member.member_id = book_package.patient_id');
		//$this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
		 $this->db->where("((member.status = '0' OR member.status = '1'))");
		 $this->db->where('book_package.book_package_id',$_POST['book_package_id']);
		//$this->db->where('member.status','1');
		//$this->db->or_where('member.status','0'); 
		$this->db->order_by('book_package.package_id', 'DESC');

									  
		$data['book_recipt'] = $this->db->get()->row_array();

		//$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/package_invoice_recipt', $data);
		//$this->load->view(FOOTER);
	}
	// public function deleteBookPackage(){
             //    	$post = $this->input->post(NULL, true);
             // 	$delete_book_package_id = $post['btn_delete_book_package'];
             // 	$this->db->where('id',$delete_book_package_id);
             //        $this->db->delete('package_booking');
             //        redirect(base_url().'adminPackageBook');
    // }
    
    public function assingPackageAppointment()
    {

        extract($_POST);

        $service_type = explode(',', $_POST['btn_appointment_assign']);
        // echo "<pre>";
        // print_r($service_type);
        // exit;
        // echo "</pre>";
        // echo $service_type[1];
        // exit;
        // echo "HII";
        if ($service_type[1] == 1) {
            // echo "HII2";
            // $this->db->select('*');
            // $this->db->from('book_package');
            // $this->db->where('book_package_id', $_POST['btn_appointment_assign']);
            // $manage_assign_appointment = $this->db->get()->row_array();
            $this->db->select('package_booking.*,book_package.address_id');
            $this->db->from('package_booking');
            $this->db->join('book_package','book_package.book_package_id = package_booking.book_package_id');
            $this->db->where('package_booking.id', $_POST['btn_appointment_assign']);
           
            $manage_assign_appointment = $this->db->get()->row_array();
            // echo $this->db->last_query();
            // exit;
            // echo "<pre>";
            // print_r($manage_assign_appointment);
            // exit;

            $book_package_id = $_POST['btn_appointment_assign'];
            $patient_id = $manage_assign_appointment['patient_id'];
            $user_id = $manage_assign_appointment['user_id'];
            $address_id = $manage_assign_appointment['address_id'];
            $purchase_date = $manage_assign_appointment['purchase_date'];
            $time = $manage_assign_appointment['time'];
            $todate = date("Y-m-d H:i:s");
            $assing_appointment_array = array(

                'user_id' => $user_id,
                'appointment_id' => $book_package_id,
                'patient_id' => $patient_id,
                'team_id' => $_POST['team_id'],
                'emp_id' => $_POST['employee_id'],
                'service_id' => 1,
                'date_time' => $purchase_date,
                'date_time' => $todate,
            );
            // $this->db->insert('assign_appointment', $assing_appointment_array);
            // echo $this->db->last_query();
            // exit;
            if ($this->db->insert('assign_appointment', $assing_appointment_array)) {

                $this->db->select('*');
                $this->db->from('employee_master');
                //$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
                $this->db->where('emp_id', $_POST['employee_id']);
                $send_employee_email = $this->db->get()->row_array();

                $this->db->select('member.*');
                $this->db->from('member');
                $this->db->where('member_id', $patient_id);
                $send_patient_details = $this->db->get()->row_array();
                $appointment_book_id_send = explode(',', $appointment_id);

                $this->db->select('appointment_book.address_id,add_address.*');
                $this->db->from('appointment_book');
                $this->db->join('add_address', 'add_address.address_id = appointment_book.address_id', 'LEFT');
                $this->db->where('appointment_book.appointment_book_id', $appointment_book_id_send[0]);
                //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                $patient_address = $this->db->get()->row_array();

                $this->load->library('email');
                if ($send_patient_details[address] != '') {

                    $patient_address = $send_patient_details[address];

                } else {
                    $patient_address = $patient_address[address_1] . ' ' . $patient_address[address_2];
                }
                $mail_message =
                "<p>Dear " . $send_employee_email[first_name] . ' ' . $send_employee_email[last_name] . "</p>
                <p>An Appointment is assigned to you with following Details</p>
                <p>Date of Appointment date " . $date . " and time " . $time . "</p>
                <p>Doctor Service</p>
                <p>Patient Name  " . $send_patient_details[name] . "</p>
                <p>Patient contact No  " . $send_patient_details[contact_no] . "</p>
                <p>Patient Address  " . $patient_address . "</p>
                <br><br>
                <p> Regards,</p>
                <p><b> Dratdoorstep</b></p>
                ";
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';

                $config['mailtype'] = 'html'; // or html
                //  $this->load->library('email');
                //  $this->email->from('no-reply@example.com');
                $this->email->initialize($config);

                //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
                $this->email->from('info@dratdoorstep.com', 'Dratdoorstep');
                $this->email->to($send_employee_email['email']);
                $this->email->subject('DratDoorStep');
                $this->email->message($mail_message);
                $this->email->send();
                $this->session->set_flashdata('message', 'Package Appointment Assign.');
            } else {
                $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
            }
        } else if ($service_type[1] == 2) {

            $this->db->select('*');
            $this->db->from('book_nurse');
            $this->db->where('book_nurse_id', $_POST[btn_appointment_assign]);
            $manage_assign_appointment = $this->db->get()->row_array();

            $appointment_id = $_POST[btn_appointment_assign];
            $patient_id = $manage_assign_appointment['patient_id'];
            $user_id = $manage_assign_appointment['user_id'];
            $address_id = $manage_assign_appointment['address_id'];
            $date = $manage_assign_appointment['date'];
            $time = $manage_assign_appointment['time'];

            $assing_appointment_array = array(

                'user_id' => $user_id,
                'appointment_id' => $appointment_id,
                'patient_id' => $patient_id,
                'team_id' => $_POST['team_id'],
                'emp_id' => $_POST['employee_id'],
                'service_id' => 2,
                'date_time' => $date . " " . $time,
                'address_id' => $address_id,
            );

            if ($this->db->insert('assign_appointment', $assing_appointment_array)) {

                $this->db->select('*');
                $this->db->from('employee_master');
                //$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
                $this->db->where('emp_id', $_POST[employee_id]);
                $send_employee_email = $this->db->get()->row_array();

                $this->db->select('member.*');
                $this->db->from('member');
                $this->db->where('member_id', $patient_id);
                $send_patient_details = $this->db->get()->row_array();
                $appointment_book_id_send = explode(',', $appointment_id);

                $this->db->select('appointment_book.address_id,add_address.*');
                $this->db->from('appointment_book');
                $this->db->join('add_address', 'add_address.address_id = appointment_book.address_id', 'LEFT');
                $this->db->where('appointment_book.appointment_book_id', $appointment_book_id_send[0]);
                //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                $patient_address = $this->db->get()->row_array();

                $this->load->library('email');

                if ($send_patient_details[address] != '') {

                    $patient_address = $send_patient_details[address];

                } else {
                    $patient_address = $patient_address[address_1] . ' ' . $patient_address[address_2];
                }

                $mail_message =
                "<p>Dear " . $send_employee_email[first_name] . ' ' . $send_employee_email[last_name] . "</p>
                <p>An Appointment is assigned to you with following Details</p>
                <p>Date of Appointment date " . $date . " and time " . $time . "</p>
                <p>Nurse Service</p>
                <p>Patient Name  " . $send_patient_details[name] . "</p>
                <p>Patient contact No  " . $send_patient_details[contact_no] . "</p>
                <p>Patient Address  " . $patient_address . "</p>
                <br><br>
                <p> Regards,</p>
                <p><b> Dratdoorstep</b></p>
                ";
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';

                $config['mailtype'] = 'html'; // or html
                //  $this->load->library('email');
                //  $this->email->from('no-reply@example.com');
                $this->email->initialize($config);

                //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
                $this->email->from('info@dratdoorstep.com', 'Dratdoorstep');
                $this->email->to($send_employee_email['email']);
                $this->email->subject('DratDoorStep');
                $this->email->message($mail_message);
                $this->email->send();
                $this->session->set_flashdata('message', 'Appointment Assign.');
            } else {
                $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
            }

        } elseif ($service_type[1] == 3) {

            $this->db->select('*');
            $this->db->from('book_laboratory_test');
            $this->db->where('book_laboratory_test_id', $_POST[btn_appointment_assign]);
            $manage_assign_appointment = $this->db->get()->row_array();

            $appointment_id = $_POST[btn_appointment_assign];
            $patient_id = $manage_assign_appointment['patient_id'];
            $user_id = $manage_assign_appointment['user_id'];
            $address_id = $manage_assign_appointment['address_id'];
            $date = $manage_assign_appointment['date'];
            $time = $manage_assign_appointment['time'];

            $assing_appointment_array = array(

                'user_id' => $user_id,
                'appointment_id' => $appointment_id,
                'patient_id' => $patient_id,
                'team_id' => $_POST['team_id'],
                'emp_id' => $_POST['employee_id'],
                'service_id' => 3,
                'date_time' => $date . " " . $time,
                'address_id' => $address_id,
            );

            if ($this->db->insert('assign_appointment', $assing_appointment_array)) {
                $this->db->select('*');
                $this->db->from('employee_master');
                //$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
                $this->db->where('emp_id', $_POST[employee_id]);
                $send_employee_email = $this->db->get()->row_array();

                $this->db->select('member.*');
                $this->db->from('member');
                $this->db->where('member_id', $patient_id);
                $send_patient_details = $this->db->get()->row_array();
                $appointment_book_id_send = explode(',', $appointment_id);

                $this->db->select('appointment_book.address_id,add_address.*');
                $this->db->from('appointment_book');
                $this->db->join('add_address', 'add_address.address_id = appointment_book.address_id', 'LEFT');
                $this->db->where('appointment_book.appointment_book_id', $appointment_book_id_send[0]);
                //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                $patient_address = $this->db->get()->row_array();

                $this->load->library('email');

                if ($send_patient_details[address] != '') {

                    $patient_address = $send_patient_details[address];

                } else {
                    $patient_address = $patient_address[address_1] . ' ' . $patient_address[address_2];
                }

                $mail_message =
                "<p>Dear " . $send_employee_email[first_name] . ' ' . $send_employee_email[last_name] . "</p>
                <p>An Appointment is assigned to you with following Details</p>
                <p>Date of Appointment date " . $date . " and time " . $time . "</p>
                <p>Lab Service</p>
                <p>Patient Name  " . $send_patient_details[name] . "</p>
                <p>Patient contact No  " . $send_patient_details[contact_no] . "</p>
                <p>Patient Address  " . $patient_address . "</p>
                <br><br>
                <p> Regards,</p>
                <p><b> Dratdoorstep</b></p>
                ";
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';

                $config['mailtype'] = 'html'; // or html
                //  $this->load->library('email');
                //  $this->email->from('no-reply@example.com');
                $this->email->initialize($config);

                //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
                $this->email->from('info@dratdoorstep.com', 'Dratdoorstep');
                $this->email->to($send_employee_email['email']);
                $this->email->subject('DratDoorStep');
                $this->email->message($mail_message);
                $this->email->send();
                $this->session->set_flashdata('message', 'Appointment Assign.');
            } else {
                $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
            }
        } elseif ($service_type[1] == 4) {

            $this->db->select('*');
            $this->db->from('book_medicine');
            $this->db->where('book_medicine_id', $_POST[btn_appointment_assign]);
            $manage_assign_appointment = $this->db->get()->row_array();

            $appointment_id = $_POST[btn_appointment_assign];
            $patient_id = $manage_assign_appointment['patient_id'];
            $user_id = $manage_assign_appointment['user_id'];
            $address_id = $manage_assign_appointment['address'];
            $date = $manage_assign_appointment['created_date'];
            //$time=$manage_assign_appointment['time'];

            $assing_appointment_array = array(

                'user_id' => $user_id,
                'appointment_id' => $appointment_id,
                'patient_id' => $patient_id,
                'team_id' => $_POST['team_id'],
                'emp_id' => $_POST['employee_id'],
                'service_id' => 4,
                'date_time' => $date,
                'address_id' => $address_id,
            );

            if ($this->db->insert('assign_appointment', $assing_appointment_array)) {
                // $this->db->select('*');
                // $this->db->from('employee_master');
                // //$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
                // $this->db->where('emp_id',$_POST[employee_id]);
                // $send_employee_email= $this->db->get()->row_array();

                // $this->db->select('member.*');
                // $this->db->from('member');
                // $this->db->where('member_id',$patient_id);
                // $send_patient_details= $this->db->get()->row_array();
                // $appointment_book_id_send=explode(',',$appointment_id);

                // $this->db->select('appointment_book.address_id,add_address.*');
                // $this->db->from('appointment_book');
                // $this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
                // $this->db->where('appointment_book.appointment_book_id',$appointment_book_id_send[0]);
                // //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                // $patient_address= $this->db->get()->row_array();

                //                      $this->load->library('email');

                //                       $mail_message = "
                // <p>Dear ".$send_employee_email[first_name]." ".$send_employee_email[last_name]"</p><br>
                // <p>An Appointment is assigned to you with following Details</p><br>
                // <p>Date of Appointment date ".$date." and time ".$time."</p><br>
                // <p>Doctor Service</p><br>
                // <p>Patient Name  ".$send_patient_details[name]."</p><br>
                // <p>Patient contact No  ".$send_patient_details[contact_no]."</p><br>";
                // if($send_patient_details[address]!='')
                // {

                //     echo "<p>Patient Address  ".$send_patient_details[address]."</p><br>";

                // }
                // else
                // {
                //     echo "<p>Patient Address  ".$patient_address[address_1]." ".$patient_address[address_2]."</p><br>";
                // }
                // "<br><br>
                // <p> Regards,</p>
                // <p><b> Dratdoorstep</b></p>
                // ";
                //                      $config['protocol'] = 'sendmail';
                //                      $config['mailpath'] = '/usr/sbin/sendmail';

                //                      $config['mailtype'] = 'html'; // or html
                //                //  $this->load->library('email');
                //                //  $this->email->from('no-reply@example.com');
                //                      $this->email->initialize($config);

                //                      //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
                //                      $this->email->from('info@dratdoorstep.com','Dratdoorstep');
                //                      $this->email->to($send_employee_email['email']);
                //                      $this->email->subject('DratDoorStep');
                //                      $this->email->message($mail_message);
                //                      $this->email->send();
                $this->session->set_flashdata('message', 'Appointment Assign.');

            } else {
                $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
            }
        } else if ($service_type[1] == 5) {

            //                 $this->db->select('*');
            //     $this->db->from('appointment_book');
            //     $this->db->where('appointment_book_id',$_POST[btn_appointment_assign]);
            //     $manage_assign_appointment= $this->db->get()->row_array();

            $this->db->select('*');
            $this->db->from('book_ambulance');
            $this->db->where('book_ambulance_id', $_POST[btn_appointment_assign]);
            $manage_assign_appointment = $this->db->get()->row_array();

            $appointment_id = $_POST[btn_appointment_assign];
            $patient_id = $manage_assign_appointment['patient_id'];
            $user_id = $manage_assign_appointment['user_id'];
            $address_id = $manage_assign_appointment['address_id'];
            $date = $manage_assign_appointment['date'];
            $time = $manage_assign_appointment['time'];

            $assing_appointment_array = array(

                'user_id' => $user_id,
                'appointment_id' => $appointment_id,
                'patient_id' => $patient_id,
                'team_id' => $_POST['team_id'],
                'emp_id' => $_POST['employee_id'],
                'service_id' => 5,
                'date_time' => $date . " " . $time,
                'address_id' => 0,
            );

            if ($this->db->insert('assign_appointment', $assing_appointment_array)) {

                $this->db->select('*');
                $this->db->from('employee_master');
                //$this->db->join('doctor_type','doctor_type.d_type_id = employee_master.d_type_id','LEFT');
                $this->db->where('emp_id', $_POST[employee_id]);
                $send_employee_email = $this->db->get()->row_array();
                // echo "<pre>";
                // print_r($send_employee_email);
                // exit;

                $this->db->select('member.*');
                $this->db->from('member');
                $this->db->where('member_id', $patient_id);
                $send_patient_details = $this->db->get()->row_array();
                $appointment_book_id_send = explode(',', $appointment_id);

                if ($send_employee_email[user_type_id] == "1") {
                    $this->db->select('appointment_book.address_id,add_address.*');
                    $this->db->from('appointment_book');
                    $this->db->join('add_address', 'add_address.address_id = appointment_book.address_id', 'LEFT');
                    $this->db->where('appointment_book.appointment_book_id', $appointment_book_id_send[0]);
                    //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                    $patient_address = $this->db->get()->row_array();
                } elseif ($send_employee_email[user_type_id] == "2") {
                    $this->db->select('book_nurse.address_id,add_address.*');
                    $this->db->from('book_nurse');
                    $this->db->join('add_address', 'add_address.address_id = book_nurse.address_id', 'LEFT');
                    $this->db->where('book_nurse.book_nurse_id', $appointment_book_id_send[0]);
                    //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                    $patient_address = $this->db->get()->row_array();
                } elseif ($send_employee_email[user_type_id] == "3") {
                    $this->db->select('book_laboratory_test.address_id,add_address.*');
                    $this->db->from('book_laboratory_test');
                    $this->db->join('add_address', 'add_address.address_id = book_laboratory_test.address_id', 'LEFT');
                    $this->db->where('book_laboratory_test.book_laboratory_test_id', $appointment_book_id_send[0]);
                    //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                    $patient_address = $this->db->get()->row_array();
                } elseif ($send_employee_email[user_type_id] == "5") {
                    $this->db->select('book_ambulance.*');
                    $this->db->from('book_ambulance');
                    $this->db->where('book_ambulance.book_ambulance_id', $appointment_book_id_send[0]);
                    //$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                    $patient_address = $this->db->get()->row_array();
                }

                $this->load->library('email');
                // echo $send_employee_email[user_type_id];
                //exit;
                if ($send_employee_email[user_type_id] == "1" || $send_employee_email[user_type_id] == "2" || $send_employee_email[user_type_id] == "3") {
                    if ($send_patient_details[address] != '') {

                        $patient_address = $send_patient_details[address];

                    } else {
                        $patient_address = $patient_address[address_1] . ' ' . $patient_address[address_2];
                    }

                    $mail_message =
                    "<p>Dear " . $send_employee_email[first_name] . ' ' . $send_employee_email[last_name] . "</p>
                    <p>An Appointment is assigned to you with following Details</p>
                    <p>Date of Appointment date " . $date . " and time " . $time . "</p>
                    <p>Doctor Service</p>
                    <p>Patient Name  " . $send_patient_details[name] . "</p>
                    <p>Patient contact No  " . $send_patient_details[contact_no] . "</p>
                    <p>Patient Address  " . $patient_address . "</p>
                    <br><br>
                    <p> Regards,</p>
                    <p><b> Dratdoorstep</b></p>
                    ";
                    //exit;
                } else {

                    // echo "<pre>";
                    // print_r($patient_address);
                    // exit;
                    $from_patient_address = $patient_address[from_address];
                    $to_patient_address = $patient_address[to_address];
                    $patient_contact = $patient_address[mobile1];

                    $mail_message =
                    "<p>Dear " . $send_employee_email[first_name] . ' ' . $send_employee_email[last_name] . "</p>
                    <p>An Appointment is assigned to you with following Details</p>
                    <p>Date of Appointment date " . $date . " and time " . $time . "</p>
                    <p>Doctor Service</p>
                    <p>Patient Name  " . $send_patient_details[name] . "</p>
                    <p>Patient contact No  " . $patient_contact . "</p>
                    <p>Patient From Address  " . $from_patient_address . "</p>
                    <p>Patient To Address  " . $to_patient_address . "</p>
                    <br><br>
                    <p> Regards,</p>
                    <p><b> Dratdoorstep</b></p>
                    ";

                }
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';

                $config['mailtype'] = 'html'; // or html
                //  $this->load->library('email');
                //  $this->email->from('no-reply@example.com');
                $this->email->initialize($config);

                //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
                $this->email->from('info@dratdoorstep.com', 'Dratdoorstep');
                $this->email->to($send_employee_email['email']);
                $this->email->subject('DratDoorStep');
                $this->email->message($mail_message);
                $this->email->send();
                $this->session->set_flashdata('message', 'Appointment Assign.');
            } else {
                $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
            }
        }

        redirect(base_url() . 'adminPackagePurchase');
    }
}
