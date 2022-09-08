<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *    http://example.com/index.php/welcome
     *  - or -
     *    http://example.com/index.php/welcome/index
     *  - or -
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
        $this->load->model('user/Login_model');
        $this->load->library('email');

        //$this->load->model('user/member_model');
        $this->load->model('General_model');
        // if(!$this->Login_model->check_admin_login()){
        //  redirect(base_url().'admin');
        // }


    }
    public function index()
    {
        // echo "Fdsf";
        // exit;
        $this->load->view('user/login');
    }


    public function userSignup()
    {

        $data = $userData = array();
        $post = $this->input->post(NULL, true);

        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('mobile', $post['mobile']);
        $check_user_details = $this->db->get()->result_array();

        if (count($check_user_details) < 1) {
            $referal = $this->General_model->genRandomString();
            // If registration request is submitted
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email_address', 'Email', 'callback_email_check');

            if ($this->form_validation->run() == true) {
                $referral = $post['referral_code'];

                if (empty($referral)) {

                    $userData = array(

                        'email' => $post['email_address'],
                        'mobile' => $post['mobile'],
                        'password' => md5($post['password']),
                        'referral_code' => $referal,
                        'used_referral' => 0,
                        'times' => 5,
                        'balance' => 0,
                        'register_date' => date('Y-m-d H:i:s'),
                        'user_type_id' => 99,
                        'city_id' => $post['city_id'],

                    );
                    $insert = $this->db->insert('user', $userData);

                    $user_details = $this->db->get_where('user', array('mobile' => $post['mobile'], 'password' => md5($post['password'])))->row_array();
                    $this->session->set_userdata('user', $user_details);

                    if ($insert) {


                        $message1 = "Refer DR AT DOORSTEP & Earn 30/- on each( max.5 refer). Use referral code $referal. Team Nisarg Wellness Pvt Ltd.";

                        $request = ""; //initialise the request variable
                        $param[method] = "sendMessage";
                        $param[send_to] = "91" . $post['mobile'];
                        $param[msg] = $message1;
                        $param[userid] = "2000197810";
                        $param[password] = "Dr@doorstep2020";
                        $param[v] = "1.1";
                        $param[msg_type] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
                        $param[auth_scheme] = "PLAIN";
                        //Have to URL encode the values
                        foreach ($param as $key => $val) {
                            $request .= $key . "=" . urlencode($val);
                            //we have to urlencode the values
                            $request .= "&";
                            //append the ampersand (&)
                            //sign after each
                            // parameter/value pair
                        }
                        $request = substr($request, 0, strlen($request) - 1);
                        //remove final (&)
                        //sign from the request
                        $url =
                            "https://enterprise.smsgupshup.com/GatewayAPI/rest?" . $request;
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $curl_scraped_page = curl_exec($ch);
                        curl_close($ch);


                        $this->db->select('user.email,user.mobile');
                        $this->db->from('user');
                        $this->db->where('user.user_id', $this->session->userdata('user')['user_id']);
                        $user_data = $this->db->get()->row_array();
                        //print_r($user_data);


                        $data_string = '[{"Attribute":"FirstName","Value":""},{"Attribute":"LastName","Value":""},{"Attribute":"EmailAddress","Value":"' . $post['email_address'] . '"},{"Attribute":"Phone","Value":"' . $post['mobile'] . '"},{"Attribute":"ProspectID","Value":"xxxxxxxx-d168-xxxx-9f8b-xxxx97xxxxxx"},{"Attribute":"Source","Value":"Website"}]';
                        try {
                            $curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
                            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_HEADER, 0);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                "Content-Type:application/json",
                                "Content-Length:" . strlen($data_string)
                            ));
                            $json_response = curl_exec($curl);
                            // echo "1".$json_response;
                            // exit;
                            curl_close($curl);
                        } catch (Exception $ex) {
                            curl_close($curl);
                        }
                        //exit;


                        if ($this->session->userdata('user')['first_name'] != '' && $this->session->userdata('user')['last_name'] != '') {

                            $this->load->view('user/dashboard');
                        } else {
                            redirect(base_url() . 'userProfile/MyProfile');
                        }
                    } else {
                        $data['city'] = $this->db->get_where('city', array('city_status' => 1))->result_array();
                        $data['error'] = 'Some problems occured, please try again.';
                        $this->load->view('user/signUp', $data);
                    }
                } else {
                    //refereall code
                    $user_details = $this->db->get_where('user', array('mobile' => $post['mobile'], 'password' => md5($post['password'])))->row_array();
                    $this->session->set_userdata('user', $user_details);

                    $this->db->select('user.*');
                    $this->db->from('user');
                    $this->db->where('user.referral_code', $referral);
                    $this->db->where('user.times >', 0);
                    $refereall_code_check = $this->db->get()->result_array();

                    if (count($refereall_code_check) == 1) {
                        $referral_user = $refereall_code_check[0][user_id];
                        $referral_bal = $refereall_code_check[0][balance];
                        $referral_times = $refereall_code_check[0][times];

                        $userData = array(

                            'email' => $post['email_address'],
                            'mobile' => $post['mobile'],
                            'password' => md5($post['password']),
                            'referral_code' => $referal,
                            'used_referral' => $referral_user,
                            'times' => 5,
                            'balance' => 30,
                            'register_date' => date('Y-m-d H:i:s'),
                            'user_type_id' => 99,
                            'city_id' => $post['city_id'],

                        );

                        $insert = $this->db->insert('user', $userData);
                        $user_details = $this->db->get_where('user', array('mobile' => $post['mobile'], 'password' => md5($post['password'])))->row_array();
                        $this->session->set_userdata('user', $user_details);

                        if ($insert) {

                            $final_bal   = $referral_bal + 30;
                            $final_times = $referral_times - 1;


                            $this->db->where('user_id', $referral_user);
                            $this->db->update('user', array('balance' => $final_bal, 'times' => $final_times));


                            $message1 = "Refer DR AT DOORSTEP & Earn 30/- on each( max.5 refer). Use referral code $referal. Team Nisarg Wellness Pvt Ltd.";

                            $request = ""; //initialise the request variable
                            $param[method] = "sendMessage";
                            $param[send_to] = "91" . $post['mobile'];
                            $param[msg] = $message1;
                            $param[userid] = "2000197810";
                            $param[password] = "Dr@doorstep2020";
                            $param[v] = "1.1";
                            $param[msg_type] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
                            $param[auth_scheme] = "PLAIN";
                            //Have to URL encode the values
                            foreach ($param as $key => $val) {
                                $request .= $key . "=" . urlencode($val);
                                //we have to urlencode the values
                                $request .= "&";
                                //append the ampersand (&)
                                //sign after each
                                // parameter/value pair
                            }
                            $request = substr($request, 0, strlen($request) - 1);
                            //remove final (&)
                            //sign from the request
                            $url =
                                "https://enterprise.smsgupshup.com/GatewayAPI/rest?" . $request;
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $curl_scraped_page = curl_exec($ch);
                            curl_close($ch);


                            // $this->db->select('user.email,user.mobile');
                            // $this->db->from('user');
                            // $this->db->where('user.user_id', $this->session->userdata('user')['user_id']);
                            // $user_data = $this->db->get()->row_array();
                            // //print_r($user_data);
                            // $curl = curl_init();
                            // curl_setopt_array($curl, array(
                            //     CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress=' . $user_data[email] . '',
                            //     CURLOPT_RETURNTRANSFER => true,
                            //     CURLOPT_ENCODING => "",
                            //     CURLOPT_MAXREDIRS => 10,
                            //     CURLOPT_TIMEOUT => 30,
                            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            //     CURLOPT_CUSTOMREQUEST => "GET",
                            //     CURLOPT_HTTPHEADER => array(
                            //         "cache-control: no-cache",
                            //     ),
                            // ));

                            // $response = curl_exec($curl);
                            // //json convert
                            // $data_st = json_decode($response, TRUE);
                            // //json convert
                            // $err = curl_error($curl);
                            // curl_close($curl);
                            // if ($err) {
                            //     //echo "cURL Error #:" . $err;
                            // } else {
                            //     //    echo $response;
                            // }

                            $data_string = '[{"Attribute":"FirstName","Value":""},{"Attribute":"LastName","Value":""},{"Attribute":"EmailAddress","Value":"' . $post['email_address'] . '"},{"Attribute":"Phone","Value":"' . $post['mobile'] . '"},{"Attribute":"ProspectID","Value":"' . $data_st[0]['ProspectID'] . '"},{"Attribute":"SearchBy","Value":"Web"}]';
                            // echo "<pre>";
                            // print_r($data_string);
                            try {
                                $curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
                                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($curl, CURLOPT_HEADER, 0);
                                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                    "Content-Type:application/json",
                                    "Content-Length:" . strlen($data_string)
                                ));
                                $json_response = curl_exec($curl);
                                // echo "2".$json_response;
                                // exit;
                                curl_close($curl);
                            } catch (Exception $ex) {
                                curl_close($curl);
                            }


                            if ($this->session->userdata('user')['first_name'] != '' && $this->session->userdata('user')['last_name'] != '') {

                                $this->load->view('user/dashboard');
                            } else {
                                //  echo base_url().'userProfile/MyProfile';
                                // exit;
                                redirect(base_url() . 'userProfile/MyProfile');
                            }
                        } else {
                            $data['city'] = $this->db->get_where('city', array('city_status' => 1))->result_array();
                            $data['error'] = 'Some problems occured, please try again.';
                            $this->load->view('user/signUp', $data);
                        }
                    } else {


                        $userData = array(

                            'email' => $post['email_address'],
                            'mobile' => $post['mobile'],
                            'password' => md5($post['password']),
                            'referral_code' => $referal,
                            'used_referral' => 0,
                            'times' => 5,
                            'balance' => 0,
                            'register_date' => date('Y-m-d H:i:s'),
                            'user_type_id' => 99,
                            'city_id' => $post['city_id'],

                        );

                        $insert = $this->db->insert('user', $userData);
                        $user_details = $this->db->get_where('user', array('mobile' => $post['mobile'], 'password' => md5($post['password'])))->row_array();
                        $this->session->set_userdata('user', $user_details);

                        if ($insert) {

                            $message1 = "Refer DR AT DOORSTEP & Earn 30/- on each( max.5 refer). Use referral code $referal. Team Nisarg Wellness Pvt Ltd.";

                            $request = ""; //initialise the request variable
                            $param[method] = "sendMessage";
                            $param[send_to] = "91" . $post['mobile'];
                            $param[msg] = $message1;
                            $param[userid] = "2000197810";
                            $param[password] = "Dr@doorstep2020";
                            $param[v] = "1.1";
                            $param[msg_type] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
                            $param[auth_scheme] = "PLAIN";
                            //Have to URL encode the values
                            foreach ($param as $key => $val) {
                                $request .= $key . "=" . urlencode($val);
                                //we have to urlencode the values
                                $request .= "&";
                                //append the ampersand (&)
                                //sign after each
                                // parameter/value pair
                            }
                            $request = substr($request, 0, strlen($request) - 1);
                            //remove final (&)
                            //sign from the request
                            $url =
                                "https://enterprise.smsgupshup.com/GatewayAPI/rest?" . $request;
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $curl_scraped_page = curl_exec($ch);
                            curl_close($ch);



                            $data_string = '[{"Attribute":"FirstName","Value":""},{"Attribute":"LastName","Value":""},{"Attribute":"EmailAddress","Value":"' . $post['email_address'] . '"},{"Attribute":"Phone","Value":"' . $post['mobile'] . '"},{"Attribute":"ProspectID","Value":"' . $data_st[0]['ProspectID'] . '"},{"Attribute":"SearchBy","Value":"Web"}]';
                            // echo "<pre>";
                            // print_r($data_string);
                            try {
                                $curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
                                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($curl, CURLOPT_HEADER, 0);
                                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                    "Content-Type:application/json",
                                    "Content-Length:" . strlen($data_string)
                                ));
                                $json_response = curl_exec($curl);
                                // echo "2".$json_response;
                                // exit;
                                curl_close($curl);
                            } catch (Exception $ex) {
                                curl_close($curl);
                            }


                            if ($this->session->userdata('user')['first_name'] != '' && $this->session->userdata('user')['last_name'] != '') {
                                $this->load->view('user/dashboard');
                            } else {

                                redirect(base_url() . 'userProfile/MyProfile');
                            }
                        } else {
                            $data['city'] = $this->db->get_where('city', array('city_status' => 1))->result_array();
                            $data['error'] = 'Some problems occured, please try again.';
                            $this->load->view('user/signUp', $data);
                        }
                    }
                }
            } else {
                $data['city'] = $this->db->get_where('city', array('city_status' => 1))->result_array();
                $data['error'] = 'Please fill all the mandatory fields.';
                $this->load->view('user/signUp', $data);
            }
        } else {
            $this->session->set_flashdata('message', 'User Already Registered with Email / Mobile No.');
            redirect(base_url('signUp'));
        }
    }
    public function email_check($str)
    {
        if ($str != '') {
            $con = array(
                'returnType' => 'count',
                'conditions' => array(
                    'email' => $str
                )
            );
            $checkEmail = $this->Login_model->getRows($con);
            if ($checkEmail > 0) {
                $this->form_validation->set_message('email_check', 'The given email already exists.');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
    public function userLogin()
    {


        $post = $this->input->post(NULL, true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login', 'Email', 'required');
        //$this->form_validation->set_rules('mobile', 'Mobile Number ', 'regex_match[/^[0-9]{10}$/]');

        $this->form_validation->set_rules('password', 'Pin Number', 'required|regex_match[/^[0-9]{4}$/]');


        if ($this->form_validation->run() !== FALSE) {


            if ($post['login'] && $post['password']) {

                $this->db->select('user.user_id,user.mobile,user.email,user.password');
                $this->db->from('user');
                $this->db->where("(user.email = '" . $post['login'] . "' OR user.mobile = '" . $post['login'] . "')");
                $this->db->where('password', md5($post['password']));
                $user_exists = $this->db->get();

                // $user_exists = $this->db->or_where('user', array('mobile'=>$post['login'],'email'=>$post['login'],'password'=>md5($post['password'])));



                if ($user_exists->num_rows()) {

                    // $user_details = $this->db->get_where('user', array('mobile'=>$post['login'],'email'=>$post['login'],'password'=>md5($post['password'])))->row_array();
                    //  $this->db->select('*');
                    //            $this->db->from('user');
                    //            $this->db->where("(user.email = '".$post['login']."' OR user.mobile = '".$post['login']."')");
                    //            $this->db->where('password', md5($post['password']));
                    //              $user_details= $this->db->get()->row_array();
                    //07-10-2021 change
                    if (filter_var($post['login'], FILTER_VALIDATE_EMAIL)) {


                        $this->db->select('*');
                        $this->db->from('user');
                        $this->db->where("user.email = '" . $post['login'] . "' ");
                        $this->db->where("(user_type_id = 99 OR user_type_id = 0)");
                        $this->db->where('password', md5($post['password']));
                        $user_details = $this->db->get()->row_array();
                        //echo $this->db->last_query();

                    } else {



                        $this->db->select('*');
                        $this->db->from('user');
                        $this->db->where("user.mobile = '" . $post['login'] . "' ");
                        $this->db->where("(user_type_id = 99 OR user_type_id = 0)");
                        $this->db->where('password', md5($post['password']));
                        $user_details = $this->db->get()->row_array();
                    }
                    //07-10-2021 change
                    // echo $this->db->last_query();;
                    //         exit;
                    //echo "<pre>";
                    //  print_r($user_details);
                    // echo $user_details['user_type_id'];
                    // exit;

                    if ($user_details['user_type_id'] == 99 || $user_details['user_type_id'] == 0) {
                        $this->session->set_userdata('user', $user_details);
                        //$this->session->set_userdata('admin_user',$user_admin_details);
                        //    $curl = curl_init();
                        //                               curl_setopt_array($curl, array(
                        //                                   CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_details[email].'',
                        //                                   CURLOPT_RETURNTRANSFER => true,
                        //                                   CURLOPT_ENCODING => "",
                        //                                   CURLOPT_MAXREDIRS => 10,
                        //                                   CURLOPT_TIMEOUT => 30,
                        //                                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        //                                   CURLOPT_CUSTOMREQUEST => "GET",
                        //                                   CURLOPT_HTTPHEADER => array(
                        //                                       "cache-control: no-cache",
                        //                                   ),
                        //                               ));

                        //  $response = curl_exec($curl);
                        //json convert
                        //   $data = json_decode($response, TRUE);
                        //json convert
                        // $err = curl_error($curl);
                        //   curl_close($curl);
                        //   if ($err) {
                        // echo "cURL Error #:" . $err;
                        //   } else {
                        //  echo $response;
                        //  }
                        // echo "<pre>";
                        // print_r($data);
                        // exit;
                        //  $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":143,"ActivityNote":"User Login","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$post['login'].'"},{"SchemaName":"mx_Custom_2","Value":"'.number_format($post['login']).'"},]}';

                        //    try
                        //    {
                        //      $curl = curl_init('https://api-in21.leadsquared.com/v2/ProspectActivity.svc/Create?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
                        //      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                        //      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        //      curl_setopt($curl, CURLOPT_HEADER, 0);
                        //      curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                        //      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        //      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                        //              "Content-Type:application/json",
                        //              "Content-Length:".strlen($data_string)
                        //              ));
                        //      $json_response = curl_exec($curl);
                        //      //echo $json_response;
                        //          curl_close($curl);
                        //    } catch (Exception $ex) {
                        //         curl_close($curl);
                        //    }





















                        if ($this->session->userdata('user')['first_name'] != '' && $this->session->userdata('user')['last_name'] != '') {

                            redirect(base_url() . 'userdashboard');
                        } else {
                            redirect(base_url() . 'userProfile/MyProfile');
                        }
                        //$this->load->view('user/dashboard');
                        //$this->load->view('admin/dashboard');
                    } else {

                        $this->session->set_flashdata('message', 'Username or Password is invalid. Try again.');
                        redirect(base_url());
                    }
                } else {

                    //$data['error'] = 'Wrong Username/Password';
                    $this->session->set_flashdata('message', 'Username or Password is invalid. Try again.');
                    redirect(base_url());
                    //$this->load->view('user/login', $data);
                    //redirect(base_url()."admin",$data);
                }
            } else {
                $this->session->set_flashdata('message', 'Username or Password is invalid. Try again.');
                redirect(base_url());
            }
        } else {


            $data['error'] = validation_errors();
            //redirect(base_url());
            $this->load->view('user/login', $data);
            //redirect(base_url()."admin",$data);
        }
    }

    public function ForgotPassword()
    {
        $email = $this->input->post('email');
        // print_r($email);
        $findemail = $this->Login_model->ForgotPassword($email);
        if ($findemail) {
            $this->Login_model->sendpassword($findemail);
        } else {
            // echo "<script>alert(' $email not found, please enter correct email id')</script>";
            $this->session->set_flashdata('message', 'Email or mobile is not found.Please correct email or mobile.');
            redirect(base_url() . 'forgotPin');
        }
    }

    public function signUp()
    {
        $data['city'] = $this->db->get_where('city', array('city_status' => 1))->result_array();
        $this->load->view('user/signUp', $data);
    }
    public function forgotPin()
    {
        $this->load->view('user/forgotPin');
    }
    public function userLogout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
