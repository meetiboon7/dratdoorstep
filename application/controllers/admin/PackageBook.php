<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . "controllers/admin/GeneralController.php";

class PackageBook extends GeneralController
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('admin/City_model');
        //$this->load->model('user/member_model');
        $this->load->model('General_model');
        // if(!$this->Login_model->check_admin_login()){
        //     redirect(base_url().'admin');
        // }

    }

    public function index()
    {
        $this->db->select('package_book_admin.package_book_id,package_book_admin.fees,DATE_FORMAT(package_book_admin.start_date,"%d-%m-%Y") as date ,DATE_FORMAT(package_book_admin.end_date,"%d-%m-%Y") as date_end,package_book_admin.start_date,user.first_name,user.last_name,package_service_type.service_type_id,package_service_type.service_type,add_address.address_id,add_address.address_1,add_address.address_2');
        $this->db->from("package_book_admin");
        $this->db->join('user', 'user.user_id = package_book_admin.user_id');
        $this->db->join('package_service_type', 'package_service_type.service_type_id = package_book_admin.service_type_id');
        $this->db->join('add_address', 'add_address.address_id=package_book_admin.address_id');

        $data['package_data'] = $this->db->get()->result_array();
        // echo $this->db->last_query();
        // exit;
        $this->load->view(HEADER, $this->viewdata);
        $this->load->view('admin/BookPackageList', $data);
        $this->load->view(FOOTER);
    }

    public function book_package()
    {
        parent::index();
        $this->db->select('user.first_name,user.last_name,user.mobile,user.user_id,user_type_id');
        $this->db->from('user');
        $this->db->where('user_type_id', 99);
        $this->db->or_where('user_type_id', 0);
        $this->db->order_by('user.user_id', 'DESC');
        $data['user'] = $this->db->get()->result_array();

        $data['city'] = $this->db->get_where('city', array('city_status' => 1))->result_array();
        //$data['service_type'] = $this->db->get_where('package_service_type', array('status' => 1))->result_array();

        $this->load->view(HEADER, $this->viewdata);
        $this->load->view('admin/AddPackage.php', $data);
        $this->load->view(FOOTER);
    }
    public function service_package_display($city_id = "")
    {

        extract($_POST);

        $this->db->select('manage_package.package_id,manage_package.package_name,manage_package.city_id,manage_package.fees_name');
        $this->db->from('manage_package');
        $this->db->where('manage_package.city_id', $city_id);

        //echo $this->db->last_query();

        $data['select_package_service'] = $this->db->get()->result();
        $this->load->view('admin/service_package_list', $data);

    }

    public function insert_package()
    {
        $post = $this->input->post(null, true);
        $payment_type = $post['payment_type'];

        if ($payment_type == 'card') {
            $transdatetime = '';
            $responsestatus = 'TXN_PENDING';
            $paid_flag = '0';

        } else if ($payment_type == 'Cash') {

            $transdatetime = date('Y-m-d H:i:s');
            $responsestatus = 'TXN_SUCCESS';
            $paid_flag = '1';

        } else if ($payment_type == 'Cheque') {
            $transdatetime = date('Y-m-d H:i:s');
            $responsestatus = 'TXN_SUCCESS';
            $paid_flag = '1';

        } else if ($payment_type == 'NEFT') {
            $transdatetime = date('Y-m-d H:i:s');
            $responsestatus = 'TXN_SUCCESS';
            $paid_flag = '1';

        } else if ($payment_type == 'UPI') {
            $transdatetime = '';
            $responsestatus = 'TXN_PENDING';
            $paid_flag = '0';

        } else if ($payment_type == 'Paytm') {
            $transdatetime = '';
            $responsestatus = 'TXN_PENDING';
            $paid_flag = '0';

        }

        if ($post['bank_name'] != '') {

            $bank_name = $_POST['bank_name'];
        } else {
            $bank_name = $post['bank_name'];
        }

        date_default_timezone_set("Asia/Calcutta");
        $tdatetime = date("Y-m-d H:i:s");

        $package_array = array(
            'user_id' => $post['user_id'],
            'patient_id' => $post['patient_id'],
            'address_id' => $post['address_id'],
            'city_id' => $post['city_id'],
            'purchase_date' => $post['start_date'],
            'expire_date' => $post['end_date'],
            'package_id' => $post['service_type_id'],
            //'confirm'=>1,
            'responsestatus' => $responsestatus,
            'txndate' => $transdatetime,
            'gatewayname' => $payment_type,
            'created_by' => $this->session->userdata('admin_user')['user_id'],
            'paid_flag' => $paid_flag,
            //'bankname'=>$bank_name,
            'other_details' => $post['bank_name'],
            'created_date' => $tdatetime,
            //'responsestatus'=>TXN_SUCCESS

        );
        // echo "<pre>";
        // print_r($package_array);
        // exit;
        if ($this->db->insert('book_package', $package_array)) {
            $insert_id = $this->db->insert_id();

            $this->db->select('book_package.*,manage_package.package_id,manage_package.no_visit,
			manage_package.fees_name,manage_package.service_id');
            $this->db->from('book_package');
            $this->db->join('manage_package', 'manage_package.package_id = book_package.package_id');
            $this->db->where('book_package.book_package_id', $insert_id);

            $package_data = $this->db->get()->row_array();

            $no_visit = $package_data['no_visit'];
            $available_visit = $package_data['no_visit'];
            $fees = $package_data['fees_name'];
            $service_id = $package_data['service_id'];

            $this->db->where('book_package_id', $insert_id);
            if ($this->db->update('book_package', array('service_id' => $service_id, 'no_visit' => $no_visit, 'available_visit' => $available_visit, 'total' => $fees))) {
                $this->session->set_flashdata('message', 'Package book successfully.');
            } else {
                $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
            }
        } else {
            $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
        }
        redirect(base_url() . 'book_package');
    }

    public function invoice_package()
    {
        // echo "Hi";
        // exit;
        $post = $this->input->post(null, true);
        $invoice_id = $post['invoice_id'];

        $this->db->select('package_book_admin.package_book_id,package_book_admin.fees,DATE_FORMAT(package_book_admin.start_date,"%d-%m-%Y") as date ,DATE_FORMAT(package_book_admin.end_date,"%d-%m-%Y") as date_end,package_book_admin.created_date,package_book_admin.start_date,user.first_name,user.last_name,package_service_type.service_type_id,package_service_type.service_type,add_address.address_id,add_address.address_1,add_address.address_2');
        $this->db->from("package_book_admin");
        $this->db->join('user', 'user.user_id = package_book_admin.user_id');
        $this->db->join('package_service_type', 'package_service_type.service_type_id = package_book_admin.service_type_id');
        $this->db->join('add_address', 'add_address.address_id=package_book_admin.address_id');
        $this->db->where('package_book_admin.package_book_id', $invoice_id);
        $data['invoice_data'] = $this->db->get()->row_array();

        // echo $this->db->last_query();
        // exit;

        $this->load->view('admin/package_invoice.php', $data);

    }

    public function admin_view_package()
    {

        $post = $this->input->post(null, true);
        $package_id = $post['btn_view_mypackage'];

        if (isset($post['btn_view_mypackage'])) {
            // echo "Hii";
            // exit;
            // $this->db->select('package_booking.*,book_package.*,member.name,member.contact_no,member.patient_code,add_address.address_1,add_address.address_2');
            // $this->db->from('package_booking');
            // $this->db->join('member', 'member.member_id = package_booking.patient_id', 'LEFT');
            // $this->db->join('book_package','book_package.book_package_id = package_booking.book_package_id');
            // $this->db->join('add_address','add_address.address_id = book_package.address_id');
            // $this->db->where('package_booking.id', $package_id);
            // //$this->db->where('book_ambulance.date >=',$curr_date);
            // //$this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
            // $this->db->order_by('package_booking.id', 'DESC');
            // $data['manage_package'] = $this->db->get()->result_array();


            // $this->db->select('assign_appointment.*,member.contact_no,member.patient_code,member.name,manage_team.team_name,employee_master.first_name,employee_master.last_name');
            // $this->db->from('assign_appointment');
            // $this->db->join('member', 'member.member_id = assign_appointment.patient_id', 'LEFT');
            // $this->db->join('manage_team', 'manage_team.team_id = assign_appointment.team_id', 'LEFT');
            // $this->db->join('employee_master', 'employee_master.emp_id = assign_appointment.emp_id', 'LEFT');
            // $this->db->where('assign_appointment.appointment_id', $package_id);
            // //$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
            // $this->db->where("((member.status = '0' OR member.status = '1'))");
            // $this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
            // $data['assign_employee'] = $this->db->get()->result_array();
           
           
           
            $this->db->select('package_booking.*,book_package.*,user_type.user_type_name,member.name,manage_package.package_name,manage_package.description,city.city');
            $this->db->from('package_booking');
            $this->db->join('book_package','book_package.book_package_id = package_booking.book_package_id');
            $this->db->join('manage_package', 'book_package.package_id = manage_package.package_id');
            $this->db->join('user_type', 'user_type.user_type_id = book_package.service_id');
            $this->db->join('city', 'city.city_id = manage_package.city_id');
            $this->db->join('member', 'member.member_id = book_package.patient_id');
            //$this->db->join('employee_master','employee_master.emp_id = book_package.emp_id');
            //$this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
            $this->db->where('package_booking.id', $package_id);
            $this->db->order_by('package_booking.id', 'DESC');
            $data['manage_package'] = $this->db->get()->result_array();


            $this->db->select('assign_appointment.*,employee_master.emp_id,employee_master.first_name,employee_master.last_name');
            $this->db->from('assign_appointment');
            // $this->db->join('book_package','book_package.book_package_id = package_booking.book_package_id');
            $this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
            $this->db->where('assign_appointment.appointment_id', $package_id);
            $this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
            $data['assign_employee'] = $this->db->get()->result_array();
            // echo $this->db->last_query();
            // exit;

            $this->db->select('package_booking.*');
            $this->db->from('package_booking');
            $this->db->where('package_booking.id', $package_id);
            $data['book_package'] = $this->db->get()->result_array();
            
            // $this->db->select('book_package.*,user_type.user_type_name,member.name,manage_package.package_name,manage_package.description,city.city');
            // $this->db->from('book_package');
            // $this->db->join('manage_package', 'book_package.package_id = manage_package.package_id');
            // $this->db->join('user_type', 'user_type.user_type_id = book_package.service_id');
            // $this->db->join('city', 'city.city_id = manage_package.city_id');
            // $this->db->join('member', 'member.member_id = book_package.patient_id');
            // //$this->db->join('employee_master','employee_master.emp_id = book_package.emp_id');
            // //$this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
            // $this->db->where('book_package.book_package_id', $package_id);
            // $this->db->order_by('book_package.package_id', 'DESC');
            // $data['manage_package'] = $this->db->get()->result_array();


            // $this->db->select('book_package.*,employee_master.emp_id,employee_master.first_name,employee_master.last_name');
            // $this->db->from('book_package');
            // $this->db->join('employee_master','employee_master.emp_id = book_package.emp_id');
            // $this->db->where('book_package.book_package_id', $package_id);
            // $this->db->order_by('book_package.package_id', 'DESC');
            // $data['assign_employee'] = $this->db->get()->result_array();

            // $this->db->select('package_booking.*');
            // $this->db->from('package_booking');
            // $this->db->where('package_booking.book_package_id', $package_id);
            // $data['book_package'] = $this->db->get()->result_array();

           

        } else {
             
            $this->db->select('book_package.*,user_type.user_type_name,member.name,manage_package.package_name,manage_package.description,city.city');
            $this->db->from('book_package');
            $this->db->join('manage_package', 'book_package.package_id = manage_package.package_id');
            $this->db->join('user_type', 'user_type.user_type_id = book_package.service_id');
            $this->db->join('city', 'city.city_id = manage_package.city_id');
            $this->db->join('member', 'member.member_id = book_package.patient_id');
            //$this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
            //$this->db->join('employee_master','employee_master.emp_id = book_package.emp_id');
            $this->db->where('book_package.book_package_id', $this->session->userdata('package_data')['book_package_id']);
            $this->db->order_by('book_package.package_id', 'DESC');

            $data['manage_package'] = $this->db->get()->result_array();
            // echo $this->db->last_query();
            // exit;

            $this->db->select('book_package.*,employee_master.emp_id,employee_master.first_name,employee_master.last_name');
            $this->db->from('book_package');
            $this->db->join('employee_master','employee_master.emp_id = book_package.emp_id');
            $this->db->where('book_package.book_package_id', $this->session->userdata('package_data')['book_package_id']);
            $this->db->order_by('book_package.package_id', 'DESC');
            $data['assign_employee'] = $this->db->get()->result_array();

            $this->db->select('package_booking.*');
            $this->db->from('package_booking');
            $this->db->where('package_booking.book_package_id', $this->session->userdata('package_data')['book_package_id']);
            $data['book_package'] = $this->db->get()->result_array();

        }

        $this->load->view(HEADER);
        $this->load->view('admin/view_package_details', $data);
        $this->load->view(FOOTER);
    }

    public function package_update()
    {
        $post = $this->input->post(null, true);

        $package_book = array(
            'user_id' => $post['user_id'],
            'package_id' => $post['package_id'],
            'service_id' => $post['user_type_id'],
            'book_package_id' => $post['book_package_id'],
            'patient_id' => $post['patient_id'],
            'date' => $post['date'],
            'time' => $post['time'],
            'created_by' => $this->session->userdata('admin_user')['user_id'],

        );

        // echo "<pre>";
        // print_r($package_book);
        // exit;

        if ($this->db->insert('package_booking', $package_book)) {
            $datapackege = $this->session->set_userdata('package_data', $package_book);

            $available_visit = $post['available_visit'] - 1;

            $this->db->where('book_package_id', $post['book_package_id']);
            $this->db->update('book_package', array('available_visit' => $available_visit));

            $this->db->select('manage_package.*,city.city,user_type.user_type_name,cart.cart_id,cart.patient_id');
            $this->db->from('manage_package');
            $this->db->join('city', 'city.city_id = manage_package.city_id');
            $this->db->join('user_type', 'user_type.user_type_id = manage_package.service_id');
            $this->db->join('cart', 'cart.package_id = manage_package.package_id');
            $this->db->where('manage_package.package_status', 1);
            $this->db->where('manage_package.package_id', $post['package_id']);
            $this->db->order_by('manage_package.package_id', 'DESC');

            $data['manage_package'] = $this->db->get()->row_array();

            $this->session->set_flashdata('message', 'Package is added.');
        } else {
            $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
        }
        redirect(base_url() . 'view_package');
    }

    public function update_single_appointment()
    {
        parent::index();
        $post = $this->input->post(NULL, true);
        $book_appointment_id = $post['btn_edit_appointment'];

        $data['member'] = $this->db->get_where('member', array('status'=>1))->result_array();
        $data['service'] = $this->db->get_where('user_type', array('status'=>1))->result_array();
        $data['manage_package'] = $this->db->get_where('manage_package', array('package_status'=>1))->result_array();

        $data['book_package'] = $this->db->get_where('package_booking', array('id'=>$book_appointment_id))->row_array();
            

        $this->load->view(HEADER,$this->viewdata);
        $this->load->view(EDIT_BOOK_PACKAGE, $data);
        $this->load->view(FOOTER);
    }

    public function edit_book_package()
    {
        parent::index();
        $post = $this->input->post(NULL, true);
        $edit_package = $post['btn_edit_package'];

         $data['update_package'] = $this->db->get_where('book_package', array('book_package_id'=>$edit_package))->row_array();

        $this->db->select('user.first_name,user.last_name,user.mobile,user.user_id,user_type_id');
        $this->db->from('user');
        $this->db->where('user_type_id', 99);
        $this->db->or_where('user_type_id', 0);
        $this->db->order_by('user.user_id', 'DESC');
        $data['user'] = $this->db->get()->result_array();   

        $data['city'] = $this->db->get_where('city', array('city_status' => 1))->result_array();
    
        $this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id', $data['update_package']['user_id']);
        $this->db->where('member.status', 1);
        $this->db->order_by('member.user_id', 'DESC');
        $data['member'] = $this->db->get()->result_array();
        
        $this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id', $data['update_package']['user_id']);
        $this->db->where('add_address.status', 1);
        $this->db->order_by('add_address.user_id', 'DESC');
        $data['address'] = $this->db->get()->result_array();

        $this->db->select('manage_package.package_id,city.*,manage_package.package_name,manage_package.fees_name');
        $this->db->from('manage_package');
        $this->db->join('city','city.city_id = manage_package.city_id');
        $data['select_package_service'] = $this->db->get()->result_array();
        // echo $this->db->last_query();
        // exit;

        $this->db->select('city.*');
        $this->db->from('city');
        $data['city_fetch'] = $this->db->get()->result_array();



        $this->load->view(HEADER,$this->viewdata);
        $this->load->view('admin/editPackageUpdate',$data);
        $this->load->view(FOOTER);
    }

    public function update_book_package()
    {
        $post = $this->input->post(null, true);
        $payment_type = $post['payment_type'];

        if ($payment_type == 'card') {
            $transdatetime = '';
            $responsestatus = 'TXN_PENDING';
            $paid_flag = '0';

        } else if ($payment_type == 'Cash') {

            $transdatetime = date('Y-m-d H:i:s');
            $responsestatus = 'TXN_SUCCESS';
            $paid_flag = '1';

        } else if ($payment_type == 'Cheque') {
            $transdatetime = date('Y-m-d H:i:s');
            $responsestatus = 'TXN_SUCCESS';
            $paid_flag = '1';

        } else if ($payment_type == 'NEFT') {
            $transdatetime = date('Y-m-d H:i:s');
            $responsestatus = 'TXN_SUCCESS';
            $paid_flag = '1';

        } else if ($payment_type == 'UPI') {
            $transdatetime = '';
            $responsestatus = 'TXN_PENDING';
            $paid_flag = '0';

        } else if ($payment_type == 'Paytm') {
            $transdatetime = '';
            $responsestatus = 'TXN_PENDING';
            $paid_flag = '0';

        }

        if ($post['bank_name'] != '') {

            $bank_name = $_POST['bank_name'];
        } else {
            $bank_name = $post['bank_name'];
        }

        date_default_timezone_set("Asia/Calcutta");
        $tdatetime = date("Y-m-d H:i:s");


        $package_update_array = array(
            'user_id' => $post['user_id'],
            'patient_id' => $post['patient_id'],
            'address_id' => $post['address_id'],
            'purchase_date' => $post['start_date'],
            'expire_date' => $post['end_date'],
            'package_id' => $post['service_type_id'],
            //'confirm'=>1,
            'responsestatus' => $responsestatus,
            'txndate' => $transdatetime,
            'gatewayname' => $payment_type,
            'created_by' => $this->session->userdata('admin_user')['user_id'],
            'paid_flag' => $paid_flag,
            //'bankname'=>$bank_name,
            'other_details' => $post['bank_name'],
            'created_date' => $tdatetime,
            //'responsestatus'=>TXN_SUCCESS

        );
        $this->db->where(array('book_package_id' => $post['book_package_id']));
       if ($this->db->update('book_package', $package_update_array)) {

            $this->db->select('package_booking.*');
            $this->db->from('package_booking');
            $this->db->where('package_booking.book_package_id',$post['book_package_id']);
            $package_data1 = $this->db->get()->row_array();

            if($package_data1['book_package_id'] == '')
            {
                // echo "HIiii";
                // exit;
                $this->db->select('book_package.*,manage_package.package_id,manage_package.no_visit,
                manage_package.fees_name,manage_package.service_id');
                $this->db->from('book_package');
                $this->db->join('manage_package', 'manage_package.package_id = book_package.package_id');
                $this->db->where('book_package.book_package_id', $post['book_package_id']);

                $package_data = $this->db->get()->row_array();

                $no_visit = $package_data['no_visit'];
                $available_visit = $package_data['no_visit'];
                $fees = $package_data['fees_name'];
                $service_id = $package_data['service_id'];

                $this->db->where(array('book_package_id' => $post['book_package_id']));
                if ($this->db->update('book_package', array('service_id' => $service_id, 'no_visit' => $no_visit, 'available_visit' => $available_visit, 'total' => $fees))) {

                    $this->session->set_flashdata('message', 'Package update successfully.');
                    
                } else {

                    $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
                }
            }else if($package_data1['book_package_id'] != '' && $package_data1['package_id'] != ''){

                // echo "Heeelloo";
                // exit;

                 $this->db->select('book_package.*,manage_package.package_id,manage_package.no_visit,
                manage_package.fees_name,manage_package.service_id');
                $this->db->from('book_package');
                $this->db->join('manage_package', 'manage_package.package_id = book_package.package_id');
                $this->db->where('book_package.book_package_id', $post['book_package_id']);

                $package_data = $this->db->get()->row_array();

                $no_visit = $package_data['no_visit'];
                $available_visit = $package_data['no_visit'];
                $fees = $package_data['fees_name'];
                $service_id = $package_data['service_id'];

                $this->db->where(array('book_package_id' => $post['book_package_id']));
                if ($this->db->update('book_package', array('service_id' => $service_id, 'no_visit' => $no_visit, 'available_visit' => $available_visit, 'total' => $fees))) {

                    // $this->db->where('book_package_id',$post['book_package_id']);
                    // $this->db->delete('package_booking');

                    $this->session->set_flashdata('message', 'Package update successfully.');
                    
                } else {

                    $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
                }
                  
            }else{
                $this->session->set_flashdata('message', 'Package update successfully.');
            }    

            // $this->session->set_flashdata('message', 'Package is updated.');
        } else {
            $this->session->set_flashdata('message', 'Try Again. Something went wrong.');
        }

        redirect(base_url() . 'adminPackagePurchase');

    }
}
