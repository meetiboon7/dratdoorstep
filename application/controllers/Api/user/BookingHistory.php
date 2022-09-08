<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class BookingHistory extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
        //$this->load->model('api/model/response/MemberProfile');
         $this->load->model('General_model');

        $this->load->library('encryption');

        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, PUT,DELETE, OPTIONS");
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            exit(0);
        }
    }


    

    // code for login *api*-------------------------------
    /**
     * @OA\Parameter(
     *      @OA\Schema(type="integer"),
     *          in="path",
     *          name="service_id",
     *          parameter="service_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/appointment_booking_history/booking_history/{service_id}",
     *     tags={"Booking History"},
     *     operationId="postAppointmentBookingHistory",
     *     summary="Appointment Booking History",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/service_id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to List Booking History",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function booking_history_ci_post()
    {
        $auth = $this->_head_args['Authorization'];
        
        
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                      
                        $request = $this->post();

                        // print_r($request);
                            try
                            {
                                

                                    $service_id = trim($this->uri->segments['4']);
                                 //   echo $service_id;

                                    if($service_id==1)
                                    {
                                       
                                         $this->db->select('appointment_book.appointment_book_id as appointment_id,appointment_book.user_id,appointment_book.patient_id,appointment_book.date,appointment_book.time,member.contact_no,member.name as patient_name,CONCAT(add_address.address_1 ,add_address.address_2) as address,appointment_book.confirm,appointment_book.responsestatus as response_status');
                                            $this->db->from('appointment_book');
                                            $this->db->join('member','member.member_id = appointment_book.patient_id','LEFT');
                                            $this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
                                            //$this->db->where('appointment_book.user_id',$this->session->userdata('user')['user_id']);
                                             $this->db->where('appointment_book.user_id', $jwtUserData->user_id);
                                            $this->db->where("((member.status = '0' OR member.status = '1'))");
                                            $this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                            $this->db->order_by('appointment_book.date', 'DESC');
                                            $appointment_book= $this->db->get()->result_array();
                                             
                                            foreach ($appointment_book as $key => $value) {
                                                
                                                $cancel = $value['date'];
                                                $value['date']= date("d-m-Y",strtotime($value['date']));
                                                $appointment_book[$key] = $value;
                                            
                                                date_default_timezone_set('Asia/Kolkata');
                                                $script_tz = date_default_timezone_get();
                                                $todayDate = date('Y-m-d');
                                                                   
                                                // $cancel = date("d-m-Y",strtotime($value['date'])); 
                                                // $new = date("d-m-Y",strtotime($cur)); 
                                                
                                                
                                                if($todayDate < $cancel && $value['confirm']==1 && $value['response_status']!="TXN_FAILURE" && $value['response_status']!="TXN_CANCELLED" && $value['response_status']!=""){

                                                     $value['is_cancel_possible'] =  true ;
                                                     $appointment_book[$key] = $value;

                                                }
                                                else
                                                {
                                                    $value['is_cancel_possible'] =  false ;
                                                     $appointment_book[$key] = $value;
                                                }
                                                
                                                 if($todayDate < $cancel && $value['response_status']!="TXN_FAILURE" && $value['response_status']!="TXN_CANCELLED" && $value['response_status']!=""){

                                                     $value['is_edit_possible'] =  true ;
                                                     $appointment_book[$key] = $value;

                                                }
                                                else
                                                {
                                                     $value['is_edit_possible'] =  false ;
                                                     $appointment_book[$key] = $value;
                                                }
                                           
                                         }
                                           
                                    }
                                    elseif ($service_id==2) 
                                    {
                                       
                                        $this->db->select('book_nurse.book_nurse_id as appointment_id,book_nurse.user_id,book_nurse.patient_id,book_nurse.date,book_nurse.time,member.contact_no,member.name as patient_name,CONCAT(add_address.address_1 ,add_address.address_2) as address,book_nurse.confirm,book_nurse.responsestatus as response_status');
                                        $this->db->from('book_nurse');
                                        $this->db->join('member','member.member_id = book_nurse.patient_id','LEFT');
                                        $this->db->join('add_address','add_address.address_id = book_nurse.address_id','LEFT');
                                        //$this->db->where('book_nurse.date >=',$curr_date);
                                       // $this->db->where('book_nurse.user_id',$this->session->userdata('user')['user_id']);
                                         $this->db->where('book_nurse.user_id', $jwtUserData->user_id);
                                        //$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
                                        //$this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
                                        $this->db->where("((member.status = '0' OR member.status = '1'))");
                                        $this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                        $this->db->order_by('book_nurse.date', 'DESC');
                                        // $this->db->where('member.status','1');
                                        // $this->db->or_where('member.status','0');
                                        // $this->db->where('add_address.status','1');
                                        // $this->db->or_where('add_address.status','0');
                                        $appointment_book = $this->db->get()->result_array();

                                         foreach ($appointment_book as $key => $value) {

                                            $cancel = $value['date'];
                                            $value['date']=date("d-m-Y",strtotime($value['date']));
                                                  $appointment_book[$key] = $value;
                                            
                                                 date_default_timezone_set('Asia/Kolkata');
                                                $script_tz = date_default_timezone_get();
                                                $todayDate = date('Y-m-d'); 
                                                                                   // echo $cancel."<br>";
                                                                                   // echo $new;
                                                                                   // exit;

                                                if($todayDate < $cancel && $value['confirm']==1 && $value['response_status']!="TXN_FAILURE" && $value['response_status']!="TXN_CANCELLED" && $$value['response_status']!=""){

                                                     $value['is_cancel_possible'] =  true ;
                                                     $appointment_book[$key] = $value;

                                                }
                                                else
                                                {
                                                    $value['is_cancel_possible'] =  false ;
                                                     $appointment_book[$key] = $value;
                                                }

                                                if($todayDate < $cancel && $value['response_status']!="TXN_FAILURE" && $value['response_status']!="TXN_CANCELLED" && $value['response_status']!=""){

                                                     $value['is_edit_possible'] =  true ;
                                                     $appointment_book[$key] = $value;

                                                }
                                                else
                                                {
                                                     $value['is_edit_possible'] =  false ;
                                                     $appointment_book[$key] = $value;
                                                }
                                           
                                         }
                                        // echo $this->db->last_query();
                                        // exit;
                                    }
                                    elseif ($service_id==3) 
                                    {
                                        
                                       $this->db->select('book_laboratory_test.book_laboratory_test_id as appointment_id,book_laboratory_test.user_id,book_laboratory_test.patient_id,book_laboratory_test.date,book_laboratory_test.time,member.contact_no,member.name as patient_name,CONCAT(add_address.address_1 ,add_address.address_2) as address,book_laboratory_test.confirm,book_laboratory_test.responsestatus as response_status');
                                        $this->db->from('book_laboratory_test');
                                        $this->db->join('member','member.member_id = book_laboratory_test.patient_id','LEFT');
                                        $this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
                                        //$this->db->where('book_laboratory_test.date >=',$curr_date);
                                       // $this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
                                        $this->db->where('book_laboratory_test.user_id', $jwtUserData->user_id);

                                        //$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
                                        //$this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
                                        $this->db->where("((member.status = '0' OR member.status = '1'))");
                                        $this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                        $this->db->order_by('book_laboratory_test.date', 'DESC');
                                        // $this->db->where('member.status','1');
                                        // $this->db->or_where('member.status','0');
                                        // $this->db->where('add_address.status','1');
                                        // $this->db->or_where('add_address.status','0');
                                        $appointment_book = $this->db->get()->result_array();
                                        foreach ($appointment_book as $key => $value) {

                                                 $cancel = $value['date'];
                                                 $value['date']=date("d-m-Y",strtotime($value['date']));
                                                 $appointment_book[$key] = $value;
                                            
                                                date_default_timezone_set('Asia/Kolkata');
                                                $script_tz = date_default_timezone_get();
                                                $todayDate = date('Y-m-d');
                                                                                   // echo $cancel."<br>";
                                                                                   // echo $new;
                                                                                   // exit;

                                                if($todayDate < $cancel && $value['confirm']==1 && $value['response_status']!="TXN_FAILURE" && $value['response_status']!="TXN_CANCELLED" && $$value['response_status']!=""){

                                                     $value['is_cancel_possible'] =  true ;
                                                     $appointment_book[$key] = $value;

                                                }
                                                else
                                                {
                                                    $value['is_cancel_possible'] =  false ;
                                                     $appointment_book[$key] = $value;
                                                }

                                                 if($todayDate < $cancel &&  $value['response_status']!="TXN_FAILURE" && $value['response_status']!="TXN_CANCELLED" && $value['response_status']!=""){

                                                     $value['is_edit_possible'] =  true ;
                                                     $appointment_book[$key] = $value;

                                                }
                                                else
                                                {
                                                     $value['is_edit_possible'] =  false ;
                                                     $appointment_book[$key] = $value;
                                                }

                                               
                                           
                                         }
                                    }
                                    elseif ($service_id==4) {
                                        
                                        //   echo $curr_date_book_medicine;
                                        //$date = date('Y-m-d H:i:s');
                                        $this->db->select('book_medicine.book_medicine_id as appointment_id,book_medicine.name as patient_name,book_medicine.mobile as contact_no,book_medicine.created_date as date,book_medicine.address,book_medicine.landline as landline_number,city.city as city_name,book_medicine.city_id,book_medicine.prescription');
                                        $this->db->from('book_medicine');
                                        $this->db->join('city','city.city_id = book_medicine.city_id','LEFT');
                                        //$this->db->where('book_medicine.created_date >=',$curr_date);
                                      //  $this->db->where('book_medicine.user_id',$this->session->userdata('user')['user_id']);
                                        $this->db->where('book_medicine.user_id', $jwtUserData->user_id);
                                        $this->db->order_by('book_medicine.date', 'DESC');
                                        // $this->db->where('member.status','1');
                                        // $this->db->or_where('member.status','0');
                                        // $this->db->where('add_address.status','1');
                                        // $this->db->or_where('add_address.status','0');
                                        $appointment_book = $this->db->get()->result_array();



                                          foreach ($appointment_book as $key => $value) {

                                                $value['date']=date("d-m-Y",strtotime($value['date']));
                                                  $appointment_book[$key] = $value;

                                                 date_default_timezone_set('Asia/Kolkata');
                                                 $script_tz = date_default_timezone_get();
                                                 $cur       = date('Y-m-d');
                                                 $cancel = $value['date']; 
                                                 $new = date("d-m-Y",strtotime($cur)); 
                                            // echo "<pre>";
                                            // print_r($value);
                                            $value['prescription'] = !empty($value['prescription']) ? base_url() . 'uploads/pharmacy_document/' . $value['prescription'] : null;
                                            $appointment_book[$key] = $value;

                                                if($new == $cancel){

                                                     $value['is_edit_possible'] =  true ;
                                                     $appointment_book[$key] = $value;

                                                }
                                                else
                                                {
                                                     $value['is_edit_possible'] =  false ;
                                                     $appointment_book[$key] = $value;
                                                }

                                         }
                                    }
                                    elseif($service_id==5)
                                    {


                                        $this->db->select('book_ambulance.book_ambulance_id as appointment_id,book_ambulance.user_id,book_ambulance.patient_id,book_ambulance.date,book_ambulance.time,book_ambulance.from_address,book_ambulance.to_address,book_ambulance.multi_city as multi_location,book_ambulance.type_id,member.name as patient_name,member.contact_no,book_ambulance.amount as price');
                                        $this->db->from('book_ambulance');
                                        $this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
                                        $this->db->where('book_ambulance.user_id',$jwtUserData->user_id);
                                        $this->db->where('book_ambulance.type_id !=',0);
                                        $this->db->where("((member.status = '0' OR member.status = '1'))");
                                        $this->db->order_by('book_ambulance.date', 'DESC');
                                        $appointment_book = $this->db->get()->result_array();

                                        
                                         foreach ($appointment_book as $key => $value) {

                                                $cancel = $value['date'];
                                                $value['date']=date("d-m-Y",strtotime($value['date']));
                                                $appointment_book[$key] = $value;

                                                date_default_timezone_set('Asia/Kolkata');
                                                $script_tz = date_default_timezone_get();
                                                $todayDate = date('Y-m-d'); 
                                            // echo "<pre>";
                                            // print_r($value);
                                           

                                                if($new < $cancel && $value['response_status']!="TXN_FAILURE" && $value['response_status']!="TXN_CANCELLED" && $value['response_status']!=""){

                                                     $value['is_edit_possible'] =  true;
                                                     $appointment_book[$key] = $value;

                                                }
                                                else
                                                {
                                                     $value['is_edit_possible'] =  false ;
                                                     $appointment_book[$key] = $value;
                                                }

                                         }
                                       //  // echo $curr_date_book_medicine;
                                       //  $date = date('Y-m-d H:i:s');
                                       //  $this->db->select('book_ambulance.book_ambulance_id,book_ambulance.patient_id,book_ambulance.date,book_ambulance.time,book_ambulance.from_address,book_ambulance.to_address,book_ambulance.type,member.name as patient_name,member.contact_no');
                                       //  $this->db->from('book_ambulance');
                                       //  $this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
                                       //  $this->db->where("((member.status = '0' OR member.status = '1'))");
                                       //  //$this->db->where('book_ambulance.date >=',$curr_date);
                                       //  //$this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
                                       //   $this->db->where('book_ambulance.user_id', $jwtUserData->user_id);
                                       //  $this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
                                       //  $appointment_book_ambulance = $this->db->get()->result_array();
                                       // // $appointment_book_ambulance=array();
                                       //  foreach($appointment_book_ambulance as $key=>$value)
                                       //  {
                                       //           $type_value= $value['type'];
                                       //            if($type_value==1)
                                       //          {
                                       //              //echo "one";
                                       //              $this->db->select('book_ambulance.book_ambulance_id,book_ambulance.patient_id,book_ambulance.date,book_ambulance.time,book_ambulance.from_address,book_ambulance.to_address,book_ambulance.multi_city as multi_location,book_ambulance.type,member.name as patient_name,member.contact_no');
                                       //              $this->db->from('book_ambulance');
                                       //              $this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
                                       //              $this->db->where("((member.status = '0' OR member.status = '1'))");
                                       //              //$this->db->where('book_ambulance.date >=',$curr_date);
                                       //            //  $this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
                                       //              $this->db->where('book_ambulance.user_id', $jwtUserData->user_id);
                                       //              $this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
                                       //              $appointment_book = $this->db->get()->result_array();         
                                       //          }
                                       //          elseif($type_value==2) {
                                       //              // echo "round";
                                       //              // exit;
                                       //               $this->db->select('book_ambulance.book_ambulance_id,book_ambulance.patient_id,book_ambulance.date,book_ambulance.time,book_ambulance.from_address,book_ambulance.to_address,book_ambulance.multi_city as multi_location,book_ambulance.type,member.name as patient_name,member.contact_no');
                                       //              $this->db->from('book_ambulance');
                                       //              $this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
                                       //              $this->db->where("((member.status = '0' OR member.status = '1'))");
                                       //              //$this->db->where('book_ambulance.date >=',$curr_date);
                                       //             // $this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
                                       //              $this->db->where('book_ambulance.user_id', $jwtUserData->user_id);
                                       //              $this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
                                       //              $appointment_book = $this->db->get()->result_array();
                                       //          }
                                       //          elseif($type_value==3)
                                       //          {
                                                    
                                       //               $this->db->select('book_ambulance.book_ambulance_id,book_ambulance.patient_id,book_ambulance.date,book_ambulance.time,book_ambulance.multi_city as multi_location,book_ambulance.type,member.name as patient_name,member.contact_no');
                                       //              $this->db->from('book_ambulance');
                                       //              $this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
                                       //              $this->db->where("((member.status = '0' OR member.status = '1'))");
                                       //              //$this->db->where('book_ambulance.date >=',$curr_date);
                                       //             // $this->db->where('book_ambulance.user_id',$this->session->userdata('user')['user_id']);
                                       //              $this->db->where('book_ambulance.user_id', $jwtUserData->user_id);
                                       //              $this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
                                       //              $appointment_book = $this->db->get()->result_array();
                                       //             // echo $this->db->last_query();
                                       //              // echo "<pre>";
                                       //              // print_r($appointment_book);

                                       //          }
                                       //  }


                                      
                                    }
                                    //echo count($appointment_book);
                                    if(count($appointment_book) > 0)
                                    {
                                        
                                        //echo "1";


                                        $apiResponse = new Api_Response();
                                        $apiResponse->status = true;
                                        $apiResponse->message = "Booking History Listing Successfully";
                                        $apiResponse->data['booking_history'] = $appointment_book;
                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else{
                                        throw new Exception("Booking History not found", 1);
                                        
                                    }
                                
                                
                            }
                            catch (\Exception $ex)
                            {
                                $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = $ex->getMessage();
                                $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                            }
                            
                                                 

                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                    
                }
                catch (\Exception $ex)
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                }                
            }
            else
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    // code for Address *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/visit_history/appoinment",
     *     tags={"Booking History"},
     *     operationId="postAppointmentHistory",
     *     summary="Appoinment Visit Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VisitAppointmentRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to show Appointment Details profile",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function appointment_visit_history_ci_post()
    {
        $auth = $this->_head_args['Authorization'];
        
        
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                      
                        $request = $this->post();

                         // print_r($request);
                         // exit;
                            try
                            {
                                
                              //  echo $request['service_id'];
                              //  exit;
                                  //  $appointment_book_id = trim($this->uri->segments['4']);
                                  //   $service_id=1;

                                    if($request['service_id'] > 0  &&  $request['appointment_id'] > 0)
                                    {
                                        // echo "ds";
                                        // exit;
                                        if($request['service_id']==1)
                                        {
                                           

                                                $this->db->select('appointment_book.appointment_book_id as appointment_id,appointment_book.total as price,appointment_book.date,appointment_book.time,member.name as patient_name,concat(add_address.address_1,add_address.address_2) as address,appointment_book.responsestatus as response_status');
                                                $this->db->from('appointment_book');
                                                $this->db->join('member','member.member_id = appointment_book.patient_id','LEFT');
                                                $this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
                                                $this->db->where('appointment_book.user_id',$jwtUserData->user_id);
                                                $this->db->where("((member.status = '0' OR member.status = '1'))");
                                                $this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                                $this->db->where('appointment_book.appointment_book_id',$request['appointment_id']);
                                                //$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                                $this->db->order_by('appointment_book.appointment_book_id', 'DESC');
                                                $appointment_visit_history= $this->db->get()->row_array();

                                                

                                                foreach ($appointment_visit_history as $key => $value) {

                                                   
                                                    if($key == "date")
                                                        $appointment_visit_history[$key]= date("d-m-Y",strtotime($value));
                                                          

                                                }

                                                $this->db->select('assign_appointment.*,manage_team.team_name,employee_master.first_name,employee_master.last_name');
                                                $this->db->from('assign_appointment');
                                                $this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
                                                $this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
                                                $this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
                                                $this->db->where('assign_appointment.appointment_id',$request['appointment_id']);
                                                $this->db->where('assign_appointment.user_id',$jwtUserData->user_id);
                                                $this->db->where("((member.status = '0' OR member.status = '1'))");
                                                $this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
                                                $assign_appointment= $this->db->get()->result_array();
                                                // echo "<pre>";
                                                // print_r($assign_appointment);
                                               // echo count($assign_appointment);
                                                if(count($assign_appointment) > 0)
                                                {
                                                    $assign_appointment_list = array();
                                        
                                        foreach($assign_appointment as $appointment_list){ 

                                                $datetime=$appointment_list['date_time'];
                                                $date = date('Y-m-d', strtotime($datetime));
                                                $time = date('H:i:s', strtotime($datetime));

                                                $assign_appointment_list['assign_date'] =   $date;
                                                $assign_appointment_list['assign_time'] =   $time;
                                                // $assign_appointment_list['prescription'] =   base_url() . 'uploads/appointment/prescription/'.$appointment_list['prescription'];

                                                     $values = explode(',',$appointment_list['prescription']);
                                                    $prescription_list = [];
                                                    foreach ($values as $key => $value) {



                                                        array_push($prescription_list, base_url() . 'uploads/appointment/prescription/'.$value);
                                                    }

                                                    // echo "<pre>";
                                                     //echo count($appointment_list['prescription']);
                                                    //echo $appointment_list['prescription'];
                                                    if($appointment_list['prescription']!='')
                                                    {
                                                         $assign_appointment_list['prescription'] = $prescription_list;
                                                    }
                                                    else
                                                    {
                                                        $assign_appointment_list['prescription'] = null;
                                                    }
                                                   

                                                     $values_lab = explode(',',$appointment_list['lab_report']);
                                                    $lab_report_list = [];
                                                    foreach ($values_lab as $key => $value) {
                                                        array_push($lab_report_list, base_url() . 'uploads/appointment/lab_report/'.$value);
                                                    }
                                                    
                                                     if($appointment_list['lab_report']!='')
                                                    {
                                                         $assign_appointment_list['lab_report'] = $lab_report_list;
                                                    }
                                                    else
                                                    {
                                                        $assign_appointment_list['lab_report'] = null;
                                                    }

                                                    
                                                    
                                                      

                                                         $assign_appointment_list['emp_id'] = $appointment_list['emp_id'] != null ?  $appointment_list['emp_id'] : 0;
                                                         $assign_appointment_list['employee_name'] = $appointment_list['first_name'] != null ?  $appointment_list['first_name']." ".$appointment_list['last_name'] : "";
                                                       
                                                        $assign_appointment_list['team_id'] = $appointment_list['team_id'] != null ?  $appointment_list['team_id'] : 0;
                                                         $assign_appointment_list['team_name'] = $appointment_list['team_name'] != null ?  $appointment_list['team_name'] : "";
                                                    

                                                    $assign_appointment_list['visit_history_text'] =  $appointment_list['visit_history_text'];
                                                    $assign_appointment_list['ecg_xray_note'] =   $appointment_list['ecg_xray_note'];
                                                }
                                                
                                                        
                                        }
                                      }
                                        else if($request['service_id']==2)
                                        {
                                                $this->db->select('book_nurse.book_nurse_id as appointment_id,book_nurse.total as price,book_nurse.date,book_nurse.time,member.name as patient_name,concat(add_address.address_1,add_address.address_2) as address,book_nurse.responsestatus as response_status');
                                                $this->db->from('book_nurse');
                                                $this->db->join('member','member.member_id = book_nurse.patient_id','LEFT');
                                                $this->db->join('add_address','add_address.address_id = book_nurse.address_id','LEFT');
                                                $this->db->where('book_nurse.user_id',$jwtUserData->user_id);
                                                $this->db->where("((member.status = '0' OR member.status = '1'))");
                                                $this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                                $this->db->where('book_nurse.book_nurse_id',$request['appointment_id']);
                                                //$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                                $this->db->order_by('book_nurse.book_nurse_id', 'DESC');
                                                $appointment_visit_history= $this->db->get()->row_array();

                                                foreach ($appointment_visit_history as $key => $value) {

                                                   
                                                    if($key == "date")
                                                        $appointment_visit_history[$key]= date("d-m-Y",strtotime($value));
                                                          

                                                }

                                                $this->db->select('assign_appointment.*,manage_team.team_name,employee_master.first_name,employee_master.last_name');
                                                $this->db->from('assign_appointment');
                                                $this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
                                                $this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
                                                $this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
                                                $this->db->where('assign_appointment.appointment_id',$request['appointment_id']);
                                                $this->db->where('assign_appointment.user_id',$jwtUserData->user_id);
                                                $this->db->where("((member.status = '0' OR member.status = '1'))");
                                                $this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
                                                $assign_appointment= $this->db->get()->result_array();
                                                // echo "<pre>";
                                                // print_r($assign_appointment);

                                                 if(count($assign_appointment) > 0)
                                                {

                                                $assign_appointment_list = array();
                                        
                                                foreach($assign_appointment as $appointment_list){ 

                                                $datetime=$appointment_list['date_time'];
                                                $date = date('Y-m-d', strtotime($datetime));
                                                $time = date('H:i:s', strtotime($datetime));

                                                $assign_appointment_list['assign_date'] =   $date;
                                                $assign_appointment_list['assign_time'] =   $time;
                                                // $assign_appointment_list['prescription'] =   base_url() . 'uploads/appointment/prescription/'.$appointment_list['prescription'];

                                                     $values = explode(',',$appointment_list['prescription']);
                                                    $prescription_list = [];
                                                    foreach ($values as $key => $value) {



                                                        array_push($prescription_list, base_url() . 'uploads/appointment/prescription/'.$value);
                                                    }

                                                    // echo "<pre>";
                                                     //echo count($appointment_list['prescription']);
                                                    //echo $appointment_list['prescription'];
                                                    if($appointment_list['prescription']!='')
                                                    {
                                                         $assign_appointment_list['prescription'] = $prescription_list;
                                                    }
                                                    else
                                                    {
                                                        $assign_appointment_list['prescription'] = null;
                                                    }
                                                   

                                                     $values_lab = explode(',',$appointment_list['lab_report']);
                                                    $lab_report_list = [];
                                                    foreach ($values_lab as $key => $value) {
                                                        array_push($lab_report_list, base_url() . 'uploads/appointment/lab_report/'.$value);
                                                    }
                                                    
                                                     if($appointment_list['lab_report']!='')
                                                    {
                                                         $assign_appointment_list['lab_report'] = $lab_report_list;
                                                    }
                                                    else
                                                    {
                                                        $assign_appointment_list['lab_report'] = null;
                                                    }

                                                    
                                                    $assign_appointment_list['emp_id'] = $appointment_list['emp_id'] != null ?  $appointment_list['emp_id'] : 0;
                                                         $assign_appointment_list['employee_name'] = $appointment_list['first_name'] != null ?  $appointment_list['first_name']." ".$appointment_list['last_name'] : "";
                                                       
                                                        $assign_appointment_list['team_id'] = $appointment_list['team_id'] != null ?  $appointment_list['team_id'] : 0;
                                                         $assign_appointment_list['team_name'] = $appointment_list['team_name'] != null ?  $appointment_list['team_name'] : "";

                                                    $assign_appointment_list['visit_history_text'] =  strip_tags(html_entity_decode($appointment_list['visit_history_text']));
                                                    $assign_appointment_list['ecg_xray_note'] =   $appointment_list['ecg_xray_note'];
                                               
                                        }
                                      }
                                    }
                                    elseif($request['service_id']==3)
                                    {
                                            
                                                
                                               $this->db->select('book_laboratory_test.book_laboratory_test_id as appointment_id,book_laboratory_test.total as price,book_laboratory_test.date,book_laboratory_test.time,member.name as patient_name,concat(add_address.address_1,add_address.address_2) as address,book_laboratory_test.responsestatus as response_status');
                                                $this->db->from('book_laboratory_test');
                                                $this->db->join('member','member.member_id = book_laboratory_test.patient_id','LEFT');
                                                $this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
                                                //$this->db->where('book_laboratory_test.user_id',$this->session->userdata('user')['user_id']);
                                                $this->db->where("((member.status = '0' OR member.status = '1'))");
                                                $this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                                 $this->db->where('book_laboratory_test.user_id',$jwtUserData->user_id);
                                                $this->db->where('book_laboratory_test.book_laboratory_test_id',$request['appointment_id']);
                                                $this->db->order_by('book_laboratory_test.book_laboratory_test_id', 'DESC');
                                                $appointment_visit_history= $this->db->get()->row_array();

                                                foreach ($appointment_visit_history as $key => $value) {

                                                   
                                                    if($key == "date")
                                                        $appointment_visit_history[$key]= date("d-m-Y",strtotime($value));
                                                          

                                                }


                                               
                                                $this->db->select('assign_appointment.*,manage_team.team_name,employee_master.first_name,employee_master.last_name');
                                                $this->db->from('assign_appointment');
                                                $this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
                                                $this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
                                                $this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
                                                $this->db->where('assign_appointment.appointment_id',$request['appointment_id']);
                                                $this->db->where('assign_appointment.user_id',$jwtUserData->user_id);
                                                $this->db->where("((member.status = '0' OR member.status = '1'))");
                                                $this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
                                                $assign_appointment= $this->db->get()->result_array();
                                                // echo "<pre>";
                                                // print_r($assign_appointment);
                                                 if(count($assign_appointment) > 0)
                                                {

                                                $assign_appointment_list = array();
                                        
                                                foreach($assign_appointment as $appointment_list){ 

                                                $datetime=$appointment_list['date_time'];
                                                $date = date('Y-m-d', strtotime($datetime));
                                                $time = date('H:i:s', strtotime($datetime));

                                                $assign_appointment_list['assign_date'] =   $date;
                                                $assign_appointment_list['assign_time'] =   $time;
                                                // $assign_appointment_list['prescription'] =   base_url() . 'uploads/appointment/prescription/'.$appointment_list['prescription'];

                                                     $values = explode(',',$appointment_list['prescription']);
                                                    $prescription_list = [];
                                                    foreach ($values as $key => $value) {



                                                        array_push($prescription_list, base_url() . 'uploads/appointment/prescription/'.$value);
                                                    }

                                                    // echo "<pre>";
                                                     //echo count($appointment_list['prescription']);
                                                    //echo $appointment_list['prescription'];
                                                    if($appointment_list['prescription']!='')
                                                    {
                                                         $assign_appointment_list['prescription'] = $prescription_list;
                                                    }
                                                    else
                                                    {
                                                        $assign_appointment_list['prescription'] = null;
                                                    }
                                                   

                                                     $values_lab = explode(',',$appointment_list['lab_report']);
                                                    $lab_report_list = [];
                                                    foreach ($values_lab as $key => $value) {
                                                        array_push($lab_report_list, base_url() . 'uploads/appointment/lab_report/'.$value);
                                                    }
                                                    
                                                     if($appointment_list['lab_report']!='')
                                                    {
                                                         $assign_appointment_list['lab_report'] = $lab_report_list;
                                                    }
                                                    else
                                                    {
                                                        $assign_appointment_list['lab_report'] = null;
                                                    }

                                                    
                                                    $assign_appointment_list['emp_id'] = $appointment_list['emp_id'] != null ?  $appointment_list['emp_id'] : 0;
                                                         $assign_appointment_list['employee_name'] = $appointment_list['first_name'] != null ?  $appointment_list['first_name']." ".$appointment_list['last_name'] : "";
                                                       
                                                        $assign_appointment_list['team_id'] = $appointment_list['team_id'] != null ?  $appointment_list['team_id'] : 0;
                                                         $assign_appointment_list['team_name'] = $appointment_list['team_name'] != null ?  $appointment_list['team_name'] : "";

                                                    $assign_appointment_list['visit_history_text'] =  strip_tags(html_entity_decode($appointment_list['visit_history_text']));
                                                    $assign_appointment_list['ecg_xray_note'] =   $appointment_list['ecg_xray_note'];
                                               
                                        }
                                        }
                                       
                                            
                                    }
                                     elseif($request['service_id']==4)
                                    {
                                            
                                                
                                              $this->db->select('book_medicine.book_medicine_id as appointment_id,book_medicine.name as patient_name,book_medicine.mobile,book_medicine.address,book_medicine.created_date as date');
                                                $this->db->from('book_medicine');
                                                $this->db->where('book_medicine.user_id',$jwtUserData->user_id);
                                                $this->db->where('book_medicine.book_medicine_id',$request['appointment_id']);
                                                $this->db->order_by('book_medicine.book_medicine_id', 'DESC');
                                                $appointment_visit_history= $this->db->get()->row_array();

                                                foreach ($appointment_visit_history as $key => $value) {

                                                   
                                                    if($key == "date")
                                                        $appointment_visit_history[$key]= date("d-m-Y",strtotime($value));
                                                          

                                                }


                                                $this->db->select('assign_appointment.*,manage_team.team_name,employee_master.first_name,employee_master.last_name');
                                                $this->db->from('assign_appointment');
                                                //$this->db->join('member','member.member_id = assign_appointment.patient_id','LEFT');
                                                $this->db->join('manage_team','manage_team.team_id = assign_appointment.team_id','LEFT');
                                                $this->db->join('employee_master','employee_master.emp_id = assign_appointment.emp_id','LEFT');
                                                $this->db->where('assign_appointment.appointment_id',$request['appointment_id']);
                                                //$this->db->where('assign_appointment.user_id',$this->session->userdata('user')['user_id']);
                                                //$this->db->where("((member.status = '0' OR member.status = '1'))");
                                                $this->db->order_by('assign_appointment.assign_appointment_id', 'DESC');
                                                $assign_appointment= $this->db->get()->result_array();
                                               // echo $this->db->last_query();
                                                // echo "<pre>";
                                                // print_r($assign_appointment);
                                                 if(count($assign_appointment) > 0)
                                                {
                                                $assign_appointment_list = array();
                                        
                                                foreach($assign_appointment as $appointment_list){ 

                                                $datetime=$appointment_list['date_time'];
                                                $date = date('Y-m-d', strtotime($datetime));
                                                $time = date('H:i:s', strtotime($datetime));

                                                $assign_appointment_list['assign_date'] =   $date;
                                                $assign_appointment_list['assign_time'] =   $time;
                                                // $assign_appointment_list['prescription'] =   base_url() . 'uploads/appointment/prescription/'.$appointment_list['prescription'];

                                                     $values = explode(',',$appointment_list['prescription']);
                                                    $prescription_list = [];
                                                    foreach ($values as $key => $value) {



                                                        array_push($prescription_list, base_url() . 'uploads/appointment/prescription/'.$value);
                                                    }

                                                    // echo "<pre>";
                                                     //echo count($appointment_list['prescription']);
                                                    //echo $appointment_list['prescription'];
                                                    if($appointment_list['prescription']!='')
                                                    {
                                                         $assign_appointment_list['prescription'] = $prescription_list;
                                                    }
                                                    else
                                                    {
                                                        $assign_appointment_list['prescription'] = null;
                                                    }
                                                   

                                                     $values_lab = explode(',',$appointment_list['lab_report']);
                                                    $lab_report_list = [];
                                                    foreach ($values_lab as $key => $value) {
                                                        array_push($lab_report_list, base_url() . 'uploads/appointment/lab_report/'.$value);
                                                    }
                                                    
                                                     if($appointment_list['lab_report']!='')
                                                    {
                                                         $assign_appointment_list['lab_report'] = $lab_report_list;
                                                    }
                                                    else
                                                    {
                                                        $assign_appointment_list['lab_report'] = null;
                                                    }

                                                    
                                                    $assign_appointment_list['emp_id'] = $appointment_list['emp_id'] != null ?  $appointment_list['emp_id'] : 0;
                                                         $assign_appointment_list['employee_name'] = $appointment_list['first_name'] != null ?  $appointment_list['first_name']." ".$appointment_list['last_name'] : "";
                                                       
                                                        $assign_appointment_list['team_id'] = $appointment_list['team_id'] != null ?  $appointment_list['team_id'] : 0;
                                                         $assign_appointment_list['team_name'] = $appointment_list['team_name'] != null ?  $appointment_list['team_name'] : "";

                                                    $assign_appointment_list['visit_history_text'] =  strip_tags(html_entity_decode($appointment_list['visit_history_text']));
                                                    $assign_appointment_list['ecg_xray_note'] =   $appointment_list['ecg_xray_note'];
                                               
                                        }
                                        }
                                       
                                            
                                    }
                                    elseif ($request['service_id']==5) {

                                         $this->db->select('book_ambulance.book_ambulance_id as appointment_id,book_ambulance.user_id,book_ambulance.patient_id,book_ambulance.date,book_ambulance.time,book_ambulance.from_address,book_ambulance.to_address,book_ambulance.multi_city as multi_location,book_ambulance.type_id,member.name as patient_name,member.contact_no,book_ambulance.responsestatus as response_status,book_ambulance.amount as price');
                                        $this->db->from('book_ambulance');
                                        $this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
                                        $this->db->where('book_ambulance.user_id',$jwtUserData->user_id);
                                        $this->db->where('book_ambulance.book_ambulance_id',$request['appointment_id']);
                                        $this->db->where('book_ambulance.type_id !=',0);
                                        $this->db->where("((member.status = '0' OR member.status = '1'))");
                                        $this->db->order_by('book_ambulance.book_ambulance_id', 'DESC');
                                        $appointment_visit_history = $this->db->get()->row_array();

                                        foreach ($appointment_visit_history as $key => $value) {

                                                   
                                                    if($key == "date")
                                                        $appointment_visit_history[$key]= date("d-m-Y",strtotime($value));
                                                          

                                                }
                                        # code...
                                    }
                                    
                                    if(count($appointment_visit_history) > 0)
                                    {
                                        
                                        //echo "1";

                                        
                                        $apiResponse = new Api_Response();
                                        $apiResponse->status = true;
                                        $apiResponse->message = "Appointment Visit History Listing Successfully";
                                        // $apiResponse->data= $appointment_visit_history;
                                        $apiResponse->data= array(
                                                  'visit_history' =>$appointment_visit_history,
                                                  'assign_appointment'=>$assign_appointment_list,
                               
                                        );
                                       
                                       
                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else{
                                        throw new Exception("Appointment History not found", 1);
                                        
                                    }
                                
                                
                            }
                        }
                        catch (\Exception $ex)
                        {
                            $apiResponse = new Api_Response();
                            $apiResponse->status = false;
                            $apiResponse->message = $ex->getMessage();
                            $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                        }
                            
                                                 

                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                    
                }
                catch (\Exception $ex)
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                }                
            }
            else
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
  
    // code for login *api*-------------------------------
    /**
     * @OA\Parameter(
     *      @OA\Schema(type="integer"),
     *          in="path",
     *          name="id",
     *          parameter="doc_book_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/booking_history/doc_booking_update/{id}",
     *     tags={"Booking History"},
     *     operationId="putDoctorBooking History",
     *     summary="Update Doctor Book Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/doc_book_id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookAppointRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Booking Appointment Details",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function doctor_booking_update_api_ci_post()
    {
        $auth = $this->_head_args['Authorization'];
        
        
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                      
                        $request = $this->post();

                        // print_r($request);

                        $id = trim($this->uri->segments['4']);
                      
                       
                                
                        $date = trim($request['date']);
                         $time = trim($request['time']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                            $UpdatedoctorData = array(
                               
                                'date'=>$date,
                                'time'=>$time,
                                
                            );
                            try
                            {
                                $this->db->where(array('appointment_book_id'=>$id));
                                if($this->db->update('appointment_book',$UpdatedoctorData))
                                {
                                             $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Booking Doctor Appointment Updated Successfully";
                                            $apiResponse->data = null;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                   
                                }
                                else{
                                    throw new Exception("Booking Doctor Appointment not found", 1);
                                }
                                
                            }
                            catch (\Exception $ex)
                            {
                                $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = $ex->getMessage();
                                $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                            }
                            
                         }
                         else
                         {
                            $apiError = new Api_Response();
                            $apiError->status = false;
                            $apiError->message = "Parameters missing";
                            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                         }                        

                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                    
                }
                catch (\Exception $ex)
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                }                
            }
            else
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    // code for login *api*-------------------------------
    /**
     * @OA\Parameter(
     *      @OA\Schema(type="integer"),
     *          in="path",
     *          name="id",
     *          parameter="nurse_book_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/booking_history/nur_booking_update/{id}",
     *     tags={"Booking History"},
     *     operationId="putNurseBooking History",
     *     summary="Update Nurse Book Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/nurse_book_id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookAppointRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Booking Appointment Details",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function nurse_booking_update_api_ci_post()
    {
        $auth = $this->_head_args['Authorization'];
        
        
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                      
                        $request = $this->post();

                        // print_r($request);

                        $id = trim($this->uri->segments['4']);
                      
                       
                                
                        $date = trim($request['date']);
                         $time = trim($request['time']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                            $UpdateNurseData = array(
                               
                                'date'=>$date,
                                'time'=>$time,
                                
                            );
                            try
                            {
                                $this->db->where(array('book_nurse_id'=>$id));
                                if($this->db->update('book_nurse',$UpdateNurseData))
                                {
                                             $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Booking Nurse Appointment Updated Successfully";
                                            $apiResponse->data = null;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                   
                                }
                                else{
                                    throw new Exception("Booking Nurse Appointment not found", 1);
                                }
                                
                            }
                            catch (\Exception $ex)
                            {
                                $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = $ex->getMessage();
                                $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                            }
                            
                         }
                         else
                         {
                            $apiError = new Api_Response();
                            $apiError->status = false;
                            $apiError->message = "Parameters missing";
                            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                         }                        

                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                    
                }
                catch (\Exception $ex)
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                }                
            }
            else
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    // code for login *api*-------------------------------
    /**
     * @OA\Parameter(
     *      @OA\Schema(type="integer"),
     *          in="path",
     *          name="id",
     *          parameter="lab_book_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/booking_history/lab_booking_update/{id}",
     *     tags={"Booking History"},
     *     operationId="putLabBooking History",
     *     summary="Update Lab Book Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/lab_book_id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookAppointRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Booking Appointment Details",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function lab_booking_update_api_ci_post()
    {
        $auth = $this->_head_args['Authorization'];
        
        
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                      
                        $request = $this->post();

                        // print_r($request);

                        $id = trim($this->uri->segments['4']);
                      
                       
                                
                        $date = trim($request['date']);
                         $time = trim($request['time']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                            $UpdateLabData = array(
                               
                                'date'=>$date,
                                'time'=>$time,
                                
                            );
                            try
                            {
                                $this->db->where(array('book_laboratory_test_id'=>$id));
                                if($this->db->update('book_laboratory_test',$UpdateLabData))
                                {
                                             $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Booking Lab Appointment Updated Successfully";
                                            $apiResponse->data = null;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                   
                                }
                                else{
                                    throw new Exception("Booking Lab Appointment not found", 1);
                                }
                                
                            }
                            catch (\Exception $ex)
                            {
                                $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = $ex->getMessage();
                                $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                            }
                            
                         }
                         else
                         {
                            $apiError = new Api_Response();
                            $apiError->status = false;
                            $apiError->message = "Parameters missing";
                            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                         }                        

                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                    
                }
                catch (\Exception $ex)
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                }                
            }
            else
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
      // code for login *api*-------------------------------
    /**
     * @OA\Parameter(
     *      @OA\Schema(type="integer"),
     *          in="path",
     *          name="id",
     *          parameter="ambulance_book_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/booking_history/ambulance_booking_update/{id}",
     *     tags={"Booking History"},
     *     operationId="putAmbulanceBooking History",
     *     summary="Update Ambulance Book Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/ambulance_book_id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookAppointRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Booking Appointment Details",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function ambulance_booking_update_api_ci_post()
    {
        $auth = $this->_head_args['Authorization'];
        
        
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                      
                        $request = $this->post();

                        // print_r($request);

                        $id = trim($this->uri->segments['4']);
                      
                       
                                
                        $date = trim($request['date']);
                         $time = trim($request['time']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                            $UpdateAmbulanceData = array(
                               
                                'date'=>$date,
                                'time'=>$time,
                                
                            );
                            try
                            {
                                $this->db->where(array('book_ambulance_id'=>$id));
                                if($this->db->update('book_ambulance',$UpdateAmbulanceData))
                                {
                                             $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Booking Ambulance Appointment Updated Successfully";
                                            $apiResponse->data = null;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                   
                                }
                                else{
                                    throw new Exception("Booking Ambulance Appointment not found", 1);
                                }
                                
                            }
                            catch (\Exception $ex)
                            {
                                $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = $ex->getMessage();
                                $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                            }
                            
                         }
                         else
                         {
                            $apiError = new Api_Response();
                            $apiError->status = false;
                            $apiError->message = "Parameters missing";
                            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                         }                        

                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                    
                }
                catch (\Exception $ex)
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                }                
            }
            else
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
     /**
     * @OA\Parameter(
     *      @OA\Schema(type="integer"),
     *          in="path",
     *          name="id",
     *          parameter="book_pharmacy_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/booking_history/pharmacy_booking_update/{id}",
     *     tags={"Booking History"},
     *     operationId="putBookingPharmacy",
     *     summary="Update Book Pharmacy Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/book_pharmacy_id"
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/BookPharmacyAppointmentRequestUpdate")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Pharmacy Details",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function pharmacy_booking_update_api_ci_post()
    {
        $auth = $this->_head_args['Authorization'];
        
        
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                      
                        $request = $this->post();

                        

                        $id = trim($this->uri->segments['4']);
                        $contact_name = trim($request['contact_name']);
                        $contact_no = trim($request['contact_no']);
                        $landline_number = trim($request['landline_number']);
                        $city_id = trim($request['city_id']);
                        $address = trim($request['address']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);
                        //$user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                           
                            // echo $city_id;
                            // exit;

                                    

                            $pharmaAppointment = array(


                                    'user_id'=>$user_id,
                                    //'patient_id'=>$post['member_id'],
                                    'name'=>$contact_name,
                                    'mobile'=>$contact_no,
                                    'landline'=>$landline_number,
                                    'address'=>$address." ",
                                    'city_id'=> $city_id,
                                    //'user_type_id'=>'4',
                                    'booked_by'=> $user_id,
                                    'created_date'=>date('Y-m-d'),
                                   
                             );
                            try
                            {
                                $this->db->where(array('book_medicine_id'=>$id));
                                if($this->db->update('book_medicine',$pharmaAppointment))
                                {
                                     // $this->General_model->uploadCartLabImage('./uploads/lab_report/', $id,'profile_','prescription', 'cart','prescription');
                                     $this->General_model->uploadPharmacyImage('./uploads/pharmacy_document/', $id,'profile_','prescription', 'book_medicine','prescription');
                                   

                                   
                                       

                                        $apiResponse = new Api_Response();
                                        $apiResponse->status = true;
                                        $apiResponse->message = "Pharmacy Booking Appointment Updated Successfully";
                                        $apiResponse->data =null;
                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    
                                    
                                }
                                else{
                                    throw new Exception("Pharmacy Booking Appointment not found", 1);
                                }
                                
                            }
                            catch (\Exception $ex)
                            {
                                $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = $ex->getMessage();
                                $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                            }
                            
                         }
                         else
                         {
                            $apiError = new Api_Response();
                            $apiError->status = false;
                            $apiError->message = "Parameters missing";
                            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                         }                        

                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                    
                }
                catch (\Exception $ex)
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                }                
            }
            else
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    // code for Address *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/cancle/appoinment",
     *     tags={"Booking History"},
     *     operationId="postCancleAppointment",
     *     summary="Cancle Appointment",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CancleAppointmentRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to show cancle Appointment profile",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function cancle_appointment_ci_post()
    {
        $auth = $this->_head_args['Authorization'];
        
        
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                      
                        $request = $this->post();

                         // print_r($request);
                         // exit;
                            try
                            {
                                
                             

                                    if($request['service_id'] > 0  &&  $request['appointment_id'] > 0)
                                    {
                                        // echo "ds";
                                        // exit;
                                        if($request['service_id']==1)
                                        {
                                           
                                            $this->db->select('appointment_book.*');
                                            $this->db->from('appointment_book');
                                            $this->db->where('appointment_book.user_id',$jwtUserData->user_id);
                                            $this->db->where('appointment_book.appointment_book_id',$request['appointment_id']);
                                            $this->db->order_by('appointment_book.appointment_book_id', 'DESC');
                                            $appointment_book= $this->db->get()->result_array();
                                            foreach ($appointment_book as $value) {

                                                     $confirm=$value['confirm'];
                                                     $total=$value['total'];
                                                     $paymentmode=$value['paymentmode'];
                                                     $discount=$value['discount'];

                                                      //for lead api
                                                             $patient_id=$value['patient_id'];
                                                             $address_id=$value['address_id'];
                                                             $doctor_type_id=$value['doctor_type_id'];
                                                             $appointment_date=$value['date'];
                                                             $appointment_time=$value['time'];
                             
                                                    //for lead api
                                                    
                                                    # code...
                                            }
                                        if($total == 0){
                                        if($paymentmode == 'credit')
                                             $total=$discount;
                                        }
                                        if($confirm == 1)
                                        {

                                             $this->db->where('appointment_book_id',$request['appointment_id']);
                                            // $this->db->update('appointment_book', array('confirm' => 0));
                                             
                                             if($this->db->update('appointment_book',array('cancel' =>date('Y-m-d'),'confirm' => 0,'responsestatus' => 'TXN_CANCELLED')))
                                            {
                                                $this->db->select('*');
                                                $this->db->from('user');
                                                $this->db->where('user_id',$jwtUserData->user_id);
                                                $user_details = $this->db->get()->result_array();
                                                
                                                foreach ($user_details as $value) {

                                                     $bal=$value['balance'];
                                                     $mobile=$value['mobile'];
                                                     $email=$value['email'];
                                                
                                              
                                                }
                                                
                                                $cur=$bal+$total;
                                                $this->db->where('user_id',$jwtUserData->user_id);
                                               // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
                                              //  echo $this->db->last_query();
                                               // exit;
                                                if($this->db->update('user',array('balance'=>$cur)))
                                                {

                                               // echo $email;


                                      $curl = curl_init();
                                       curl_setopt_array($curl, array(
                                      CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$email.'',
                                      CURLOPT_RETURNTRANSFER => true,
                                      CURLOPT_ENCODING => "",
                                      CURLOPT_MAXREDIRS => 10,
                                      CURLOPT_TIMEOUT => 30,
                                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                      CURLOPT_CUSTOMREQUEST => "GET",
                                      CURLOPT_HTTPHEADER => array(
                                          "cache-control: no-cache",
                                      ),
                                  ));

                                  $response = curl_exec($curl);
                                  //json convert
                                  $data = json_decode($response, TRUE);
                                  //json convert
                                  $err = curl_error($curl);
                                  curl_close($curl);
                                  if ($err) {
                                     // echo "cURL Error #:" . $err;
                                  } else {
                                       //   echo $response;
                                  }

                                $date=date($appointment_date.' H:i:s');
                                $time=date($appointment_date.' '.$appointment_time);
                                 
                                $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":149,"ActivityNote":"Cancle Doctor Appoinment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":""},{"SchemaName":"mx_Custom_4","Value":"'.$doctor_type_id.'"},{"SchemaName":"mx_Custom_5","Value":"'.$date.'"},{"SchemaName":"mx_Custom_6","Value":"'.$time.'"},]}';
                              
                               // echo $data_string;
                               // exit;
                                try
                                {
                                    $curl = curl_init('https://api-in21.leadsquared.com/v2/ProspectActivity.svc/Create?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
                                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($curl, CURLOPT_HEADER, 0);
                                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                            "Content-Type:application/json",
                                            "Content-Length:".strlen($data_string)
                                            ));
                                    $json_response = curl_exec($curl);
                                     //$data1 = json_decode($json_response, TRUE);
                                    
                                  //  echo $json_response;
                                        curl_close($curl);
                                } catch (Exception $ex) 
                                { 
                                    curl_close($curl);
                                }
                                                        /*$message = urlencode("We are sad that you cancelled your booking with id '".$request['appointment_id']."'. Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
                                                        
                                                        $this->db->select('*');
                                                        $this->db->from('sms_detail');
                                                        $sms_detail = $this->db->get()->result_array();

                                                        $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
                                                                $response = file_get_contents($smsurl);*/
                                $this->db->select('member.*');
                                $this->db->from('member');
                                $this->db->where('member.member_id',$patient_id);
                                $patient_details = $this->db->get()->row_array();

                               $date_appointment=date("d-m-Y",strtotime($appointment_date)); 
                               $message ="HI ".$patient_details['name'].", We have canceled your appointment for Doctor ".$date_appointment." ". $appointment_time." at DR AT DOORSTEP. If you want to reschedule, Call 7069073088. Team NWPL";
                                $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
                                    $param[msg] = $message;
                                    $param[userid] = "2000197810";
                                    $param[password] = "Dr@doorstep2020";
                                    $param[v] = "1.1";
                                    $param[msg_type] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
                                    $param[auth_scheme] = "PLAIN";
                                    //Have to URL encode the values
                                    foreach($param as $key=>$val) {
                                    $request.= $key."=".urlencode($val);
                                    //we have to urlencode the values
                                    $request.= "&";
                                    //append the ampersand (&)
                                        //sign after each
                                   // parameter/value pair
                                    }
                                    $request = substr($request, 0, strlen($request)-1);
                                    //remove final (&)
                                            //sign from the request
                                    $url =
                                    "https://enterprise.smsgupshup.com/GatewayAPI/rest?".$request;
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $curl_scraped_page = curl_exec($ch);
                                    curl_close($ch);

                                                        $this->load->library('email');

                                                         $mail_message = "
                                                        <p>Dear User, </p>
                                                        <p>We are sad that you cancelled your booking with id ".$request['appointment_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again! </p>
                                                        <br><br><br><br><br><br>
                                                        <p> Regards,</p>
                                                        <p><b> Dratdoorstep</b></p>
                                                        ";
                                                        $config['protocol'] = 'sendmail';
                                                        $config['mailpath'] = '/usr/sbin/sendmail';

                                                        $config['mailtype'] = 'html'; // or html
                                                  
                                                        $this->email->initialize($config);

                                                        //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
                                                        $this->email->from('info@dratdoorstep.com','Dratdoorstep');
                                                        $this->email->to($email);
                                                        $this->email->subject('DratDoorStep');
                                                        $this->email->message($mail_message);
                                                        $this->email->send();

                                                        
                                                       
                                                                   // redirect(base_url());
                                                }
                                                       $apiResponse = new Api_Response();
                                                        $apiResponse->status = true;
                                                        $apiResponse->message = "Appointment Cancle Successfully";
                                                        // $apiResponse->data= $appointment_visit_history;
                                                        $apiResponse->data=null;
                                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                               
                                             }
                                             else
                                             {
                                                        $apiResponse = new Api_Response();
                                                        $apiResponse->status = true;
                                                        $apiResponse->message = "Appointment Cancle UnSuccessfully";
                                                        // $apiResponse->data= $appointment_visit_history;
                                                        $apiResponse->data=null;
                                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                             }
                                            


                                          }
                                           else
                                           {
                                                     throw new Exception("Appointment cancle data not found", 1);
                                        
                                            }
                                                
                                        }
                                        else if($request['service_id']==2)
                                        {
                                                    $this->db->select('book_nurse.*');
                                                    $this->db->from('book_nurse');
                                                    $this->db->where('book_nurse.user_id',$jwtUserData->user_id);
                                                    $this->db->where('book_nurse.book_nurse_id',$request['appointment_id']);
                                                    $this->db->order_by('book_nurse.book_nurse_id', 'DESC');
                                                    $appointment_book= $this->db->get()->result_array();
                                                    foreach ($appointment_book as $value) {

                                                             $confirm=$value['confirm'];
                                                             $total=$value['total'];
                                                             $paymentmode=$value['paymentmode'];
                                                             $discount=$value['discount'];
                                                              //for lead api
                                                                     $patient_id=$value['patient_id'];
                                                                     $address_id=$value['address_id'];
                                                                     $nurse_type_id=$value['type'];
                                                                      $days=$value['days'];
                                                                     $appointment_date=$value['date'];
                                                                     $appointment_time=$value['time'];
                             
                                                                //for lead api
                                                            
                                                            # code...
                                                    }
                                                if($total == 0){
                                                if($paymentmode == 'credit')
                                                     $total=$discount;
                                                }
                                        if($confirm == 1)
                                        {

                                             $this->db->where('book_nurse_id',$request['appointment_id']);
                                            // $this->db->update('appointment_book', array('confirm' => 0));
                                             
                                             if($this->db->update('book_nurse',array('cancel' =>date('Y-m-d'),'confirm' => 0,'responsestatus' => 'TXN_CANCELLED')))
                                            {
                                                $this->db->select('*');
                                                $this->db->from('user');
                                                $this->db->where('user_id',$jwtUserData->user_id);
                                                $user_details = $this->db->get()->result_array();
                                                
                                                foreach ($user_details as $value) {

                                                     $bal=$value['balance'];
                                                     $mobile=$value['mobile'];
                                                     $email=$value['email'];
                                                
                                              
                                                }
                                                
                                                $cur=$bal+$total;
                                                $this->db->where('user_id',$jwtUserData->user_id);
                                               // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
                                              //  echo $this->db->last_query();
                                               // exit;
                                                if($this->db->update('user',array('balance'=>$cur)))
                                                {
                                                        $curl = curl_init();
                                  curl_setopt_array($curl, array(
                                      CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$email.'',
                                      CURLOPT_RETURNTRANSFER => true,
                                      CURLOPT_ENCODING => "",
                                      CURLOPT_MAXREDIRS => 10,
                                      CURLOPT_TIMEOUT => 30,
                                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                      CURLOPT_CUSTOMREQUEST => "GET",
                                      CURLOPT_HTTPHEADER => array(
                                          "cache-control: no-cache",
                                      ),
                                  ));

                                  $response = curl_exec($curl);
                                  //json convert
                                  $data = json_decode($response, TRUE);
                                  //json convert
                                  $err = curl_error($curl);
                                  curl_close($curl);
                                  if ($err) {
                                     // echo "cURL Error #:" . $err;
                                  } else {
                                       //   echo $response;
                                  }

                                $date=date($appointment_date.' H:i:s');
                                $time=date($appointment_date.' '.$appointment_time);
                                 
                                $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":152,"ActivityNote":"Cancle Nurse Appoinment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":""},{"SchemaName":"mx_Custom_4","Value":"'.$nurse_type_id.'"},{"SchemaName":"mx_Custom_5","Value":"'.$date.'"},{"SchemaName":"mx_Custom_6","Value":"'.$time.'"},{"SchemaName":"mx_Custom_7","Value":"'.$days.'"},]}';

                                // echo $data_string;
                                // exit;
                            //  echo $data_string;
                               
                                try
                                {
                                    $curl = curl_init('https://api-in21.leadsquared.com/v2/ProspectActivity.svc/Create?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
                                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($curl, CURLOPT_HEADER, 0);
                                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                            "Content-Type:application/json",
                                            "Content-Length:".strlen($data_string)
                                            ));
                                    $json_response = curl_exec($curl);
                                     //$data1 = json_decode($json_response, TRUE);
                                    
                                  //  echo $json_response;
                                        curl_close($curl);
                                } catch (Exception $ex) 
                                { 
                                    curl_close($curl);
                                }







                                                        /*$message = urlencode("We are sad that you cancelled your booking with id '".$request['appointment_id']."'. Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
                                                        
                                                        $this->db->select('*');
                                                        $this->db->from('sms_detail');
                                                        $sms_detail = $this->db->get()->result_array();

                                                        $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
                                                                $response = file_get_contents($smsurl);*/
                                                $this->db->select('member.*');
                                $this->db->from('member');
                                $this->db->where('member.member_id',$patient_id);
                                $patient_details = $this->db->get()->row_array();

                               $date_appointment=date("d-m-Y",strtotime($appointment_date)); 
                               $message ="HI ".$patient_details['name'].", We have canceled your appointment for Nurse ".$date_appointment." ". $appointment_time." at DR AT DOORSTEP. If you want to reschedule, Call 7069073088. Team NWPL";
                                $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
                                    $param[msg] = $message;
                                    $param[userid] = "2000197810";
                                    $param[password] = "Dr@doorstep2020";
                                    $param[v] = "1.1";
                                    $param[msg_type] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
                                    $param[auth_scheme] = "PLAIN";
                                    //Have to URL encode the values
                                    foreach($param as $key=>$val) {
                                    $request.= $key."=".urlencode($val);
                                    //we have to urlencode the values
                                    $request.= "&";
                                    //append the ampersand (&)
                                        //sign after each
                                   // parameter/value pair
                                    }
                                    $request = substr($request, 0, strlen($request)-1);
                                    //remove final (&)
                                            //sign from the request
                                    $url =
                                    "https://enterprise.smsgupshup.com/GatewayAPI/rest?".$request;
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $curl_scraped_page = curl_exec($ch);
                                    curl_close($ch);

                                                        $this->load->library('email');

                                                         $mail_message = "
                                                        <p>Dear User, </p>
                                                        <p>We are sad that you cancelled your booking with id ".$request['appointment_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again! </p>
                                                        <br><br><br><br><br><br>
                                                        <p> Regards,</p>
                                                        <p><b> Dratdoorstep</b></p>
                                                        ";
                                                        $config['protocol'] = 'sendmail';
                                                        $config['mailpath'] = '/usr/sbin/sendmail';

                                                        $config['mailtype'] = 'html'; // or html
                                                  
                                                        $this->email->initialize($config);

                                                        //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
                                                        $this->email->from('info@dratdoorstep.com','Dratdoorstep');
                                                        $this->email->to($email);
                                                        $this->email->subject('DratDoorStep');
                                                        $this->email->message($mail_message);
                                                        $this->email->send();

                                                        
                                                       
                                                                   // redirect(base_url());
                                                }
                                                       $apiResponse = new Api_Response();
                                                        $apiResponse->status = true;
                                                        $apiResponse->message = "Appointment Cancle Successfully";
                                                        // $apiResponse->data= $appointment_visit_history;
                                                        $apiResponse->data=null;
                                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                               
                                             }
                                             else
                                             {
                                                        $apiResponse = new Api_Response();
                                                        $apiResponse->status = true;
                                                        $apiResponse->message = "Appointment Cancle UnSuccessfully";
                                                        // $apiResponse->data= $appointment_visit_history;
                                                        $apiResponse->data=null;
                                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                             }
                                            


                                          }
                                           else
                                           {
                                                     throw new Exception("Appointment cancle data not found", 1);
                                        
                                            }
                                    }
                                    elseif($request['service_id']==3)
                                    {
                                            
                                                
                                                   $this->db->select('book_laboratory_test.*');
                                                    $this->db->from('book_laboratory_test');
                                                    $this->db->where('book_laboratory_test.user_id',$jwtUserData->user_id);
                                                    $this->db->where('book_laboratory_test.book_laboratory_test_id',$request['appointment_id']);
                                                    $this->db->order_by('book_laboratory_test.book_laboratory_test_id', 'DESC');
                                                    $appointment_book= $this->db->get()->result_array();
                                                    foreach ($appointment_book as $value) {

                                                             $confirm=$value['confirm'];
                                                             $total=$value['total'];
                                                             $paymentmode=$value['paymentmode'];
                                                             $discount=$value['discount'];
                                                              //for lead api
                                                                 $patient_id=$value['patient_id'];
                                                                 $address_id=$value['address_id'];
                                                                 $lab_test_id=$value['lab_test_id'];
                                                                 $appointment_date=$value['date'];
                                                                 $appointment_time=$value['time'];
                                                                 $complain=$value['complain'];
                                                                 $prescription=$value['prescription'];
                             
                                                                //for lead api
                            
                                                            
                                                            # code...
                                                    }
                                                if($total == 0){
                                                if($paymentmode == 'credit')
                                                     $total=$discount;
                                                }
                                        if($confirm == 1)
                                        {

                                             //$this->db->where('appointment_book_id',$request['appointment_id']);
                                              $this->db->where('book_laboratory_test_id',$request['appointment_id']);
                                            // $this->db->update('appointment_book', array('confirm' => 0));
                                             
                                             if($this->db->update('book_laboratory_test',array('cancel' =>date('Y-m-d'),'confirm' => 0,'responsestatus' => 'TXN_CANCELLED')))
                                            {
                                                $this->db->select('*');
                                                $this->db->from('user');
                                                $this->db->where('user_id',$jwtUserData->user_id);
                                                $user_details = $this->db->get()->result_array();
                                                
                                                foreach ($user_details as $value) {

                                                     $bal=$value['balance'];
                                                     $mobile=$value['mobile'];
                                                     $email=$value['email'];
                                                
                                              
                                                }
                                                
                                                $cur=$bal+$total;
                                                $this->db->where('user_id',$jwtUserData->user_id);
                                               // $this->db->update('user',array('cancel'=>date('Y-m-d'),'balance'=>$cur));
                                              //  echo $this->db->last_query();
                                               // exit;
                                                if($this->db->update('user',array('balance'=>$cur)))
                                                {
                                                    $curl = curl_init();
                                  curl_setopt_array($curl, array(
                                      CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$email.'',
                                      CURLOPT_RETURNTRANSFER => true,
                                      CURLOPT_ENCODING => "",
                                      CURLOPT_MAXREDIRS => 10,
                                      CURLOPT_TIMEOUT => 30,
                                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                      CURLOPT_CUSTOMREQUEST => "GET",
                                      CURLOPT_HTTPHEADER => array(
                                          "cache-control: no-cache",
                                      ),
                                  ));

                                  $response = curl_exec($curl);
                                  //json convert
                                  $data = json_decode($response, TRUE);
                                  //json convert
                                  $err = curl_error($curl);
                                  curl_close($curl);
                                  if ($err) {
                                     // echo "cURL Error #:" . $err;
                                  } else {
                                       //   echo $response;
                                  }

                                $date=date($appointment_date.' H:i:s');
                                $time=date($appointment_date.' '.$appointment_time);
                                 
                                $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":158,"ActivityNote":"Cancle Lab Appoinment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":"'.$lab_test_id.'"},{"SchemaName":"mx_Custom_4","Value":"'.$date.'"},{"SchemaName":"mx_Custom_5","Value":"'.$time.'"},{"SchemaName":"mx_Custom_6","Value":"'.$complain.'"},{"SchemaName":"mx_Custom_7","Value":"'.$prescription.'"},]}';
                            //  echo $data_string;
                               
                                try
                                {
                                    $curl = curl_init('https://api-in21.leadsquared.com/v2/ProspectActivity.svc/Create?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
                                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($curl, CURLOPT_HEADER, 0);
                                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                            "Content-Type:application/json",
                                            "Content-Length:".strlen($data_string)
                                            ));
                                    $json_response = curl_exec($curl);
                                     //$data1 = json_decode($json_response, TRUE);
                                    
                                  //  echo $json_response;
                                        curl_close($curl);
                                } catch (Exception $ex) 
                                { 
                                    curl_close($curl);
                                }
                                                       /* $message = urlencode("We are sad that you cancelled your booking with id '".$request['appointment_id']."'. Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again!");
                                                        
                                                        $this->db->select('*');
                                                        $this->db->from('sms_detail');
                                                        $sms_detail = $this->db->get()->result_array();

                                                        $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
                                                                $response = file_get_contents($smsurl);*/

                                 $this->db->select('member.*');
                                $this->db->from('member');
                                $this->db->where('member.member_id',$patient_id);
                                $patient_details = $this->db->get()->row_array();

                               $date_appointment=date("d-m-Y",strtotime($appointment_date)); 
                               $message ="HI ".$patient_details['name'].", We have canceled your appointment for Lab ".$date_appointment." ". $appointment_time." at DR AT DOORSTEP. If you want to reschedule, Call 7069073088. Team NWPL";
                                $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
                                    $param[msg] = $message;
                                    $param[userid] = "2000197810";
                                    $param[password] = "Dr@doorstep2020";
                                    $param[v] = "1.1";
                                    $param[msg_type] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
                                    $param[auth_scheme] = "PLAIN";
                                    //Have to URL encode the values
                                    foreach($param as $key=>$val) {
                                    $request.= $key."=".urlencode($val);
                                    //we have to urlencode the values
                                    $request.= "&";
                                    //append the ampersand (&)
                                        //sign after each
                                   // parameter/value pair
                                    }
                                    $request = substr($request, 0, strlen($request)-1);
                                    //remove final (&)
                                            //sign from the request
                                    $url =
                                    "https://enterprise.smsgupshup.com/GatewayAPI/rest?".$request;
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $curl_scraped_page = curl_exec($ch);
                                    curl_close($ch);

                                                        $this->load->library('email');

                                                         $mail_message = "
                                                        <p>Dear User, </p>
                                                        <p>We are sad that you cancelled your booking with id ".$request['appointment_id'].". Refund for the same is now updated in your DrAtDoorstep account. Hope to see you again! </p>
                                                        <br><br><br><br><br><br>
                                                        <p> Regards,</p>
                                                        <p><b> Dratdoorstep</b></p>
                                                        ";
                                                        $config['protocol'] = 'sendmail';
                                                        $config['mailpath'] = '/usr/sbin/sendmail';

                                                        $config['mailtype'] = 'html'; // or html
                                                  
                                                        $this->email->initialize($config);

                                                        //$this->email->from('no-reply@portal.dratdoorstep.com','Dratdoorstep');
                                                        $this->email->from('info@dratdoorstep.com','Dratdoorstep');
                                                        $this->email->to($email);
                                                        $this->email->subject('DratDoorStep');
                                                        $this->email->message($mail_message);
                                                        $this->email->send();

                                                        
                                                       
                                                                   // redirect(base_url());
                                                }
                                                       $apiResponse = new Api_Response();
                                                        $apiResponse->status = true;
                                                        $apiResponse->message = "Appointment Cancle Successfully";
                                                        // $apiResponse->data= $appointment_visit_history;
                                                        $apiResponse->data=null;
                                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                               
                                             }
                                             else
                                             {
                                                        $apiResponse = new Api_Response();
                                                        $apiResponse->status = true;
                                                        $apiResponse->message = "Appointment Cancle UnSuccessfully";
                                                        // $apiResponse->data= $appointment_visit_history;
                                                        $apiResponse->data=null;
                                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                             }
                                            


                                          }
                                           else
                                           {
                                                     throw new Exception("Appointment cancle data not found", 1);
                                        
                                            }
                                       
                                            
                                    }
                                    
                             }
                        }
                        catch (\Exception $ex)
                        {
                            $apiResponse = new Api_Response();
                            $apiResponse->status = false;
                            $apiResponse->message = $ex->getMessage();
                            $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                        }
                            
                                                 

                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                    
                }
                catch (\Exception $ex)
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                }                
            }
            else
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
     // code for Address *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/invoice/appoinment",
     *     tags={"Booking History"},
     *     operationId="postInvoiceAppointment",
     *     summary="Invoice Appointment",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CancleAppointmentRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to show cancle Appointment profile",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function invoice_appointment_ci_post()
    {
        $auth = $this->_head_args['Authorization'];
        
        
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                      
                        $request = $this->post();

                         // print_r($request);
                         // exit;
                            try
                            {
                                
                             

                                    if($request['service_id'] > 0  &&  $request['appointment_id'] > 0)
                                    {
                                        // echo "ds";
                                        // exit;
                                        if($request['service_id']==1)
                                        {
                                           
                                           $this->db->select('appointment_book.*,add_address.address_1,add_address.address_2');
                                            $this->db->from('appointment_book');
                                            $this->db->join('add_address','add_address.address_id = appointment_book.address_id','LEFT');
                                            $this->db->where('appointment_book.user_id',$jwtUserData->user_id);
                                            $this->db->where('appointment_book.appointment_book_id',$request['appointment_id']);
                                            $this->db->order_by('appointment_book.appointment_book_id', 'DESC');
                                            $appointment_book= $this->db->get()->result_array();
                                             

                                            foreach ($appointment_book as $value) {
                                                     $data['appointment_book_id']=$value['appointment_book_id'];
                                                     $data['patient_id']=$value['patient_id'];
                                                     $data['tot']=$value['total'];
                                                     $data['dis']=$value['discount'];
                                                    // $data['list']=$value['list_id'];
                                                    // $data['date']=$value['date'];
                                                      $data['date']=date("d-m-Y",strtotime($value['date']));
                                                    // $data['doctor']=$value['doctor_id'];
                                                      $data['address_1']=$value['address_1'];
                                                       $data['address_2']=$value['address_2'];
                                                    # code...
                                            }
                                            // echo $data['appointment_book_id'];
                                            // exit;
                                            $this->db->select('member.*');
                                            $this->db->from('member');
                                            $this->db->where('member.user_id',$jwtUserData->user_id);
                                            $this->db->where('member.member_id', $data['patient_id']);
                                            $this->db->order_by('member.member_id', 'DESC');
                                            $member= $this->db->get()->result_array();

                                            foreach ($member as $value) {

                                                     $data1['name']=$value['name'];
                                                      $data1['patient_code']=$value['patient_code'];
                                                      $data1['address']=$data['address_1']." ".$data['address_2'];
                                                      $data1['city_id']=$value['city_id'];
                                                     // $data['list']=$value['list_id'];
                                                     // $data['date']=$value['date'];
                                                     // $data['doctor']=$value['doctor_id'];
                                                    # code...
                                            }


                                            $this->db->select('extra_invoice.*,additional_payment.amount');
                                            $this->db->from('extra_invoice');
                                            $this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.appointment_book_id','LEFT');
                                            $this->db->where('extra_invoice.user_id',$jwtUserData->user_id);
                                            $this->db->where('extra_invoice.appointment_book_id',$request['appointment_id']);
                                            $this->db->group_by('additional_payment.id'); 

                                            $this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                                            $extra_invoice= $this->db->get()->result_array();
                                            
                                            
                                            foreach ($extra_invoice as $value) {

                                                     $data2['extra_invoice_id']=$value['extra_invoice_id'];
                                                      $data2['list_data']=$value['list'];
                                                     // $data2['price'] =$value['price'];
                                                      $data2['extra_amount'] +=$value['amount'];
                                                       $data2['grand_total'] = $data['tot'] - $data['dis'] + $data2['extra_amount'];
                                                     
                                            }

                                           
                                                
                                        }
                                        else if($request['service_id']==2)
                                        {
                                                $this->db->select('book_nurse.*,add_address.address_1,add_address.address_2');
                                                $this->db->from('book_nurse');
                                                $this->db->join('add_address','add_address.address_id = book_nurse.address_id','LEFT');
                                                $this->db->where('book_nurse.user_id',$jwtUserData->user_id);
                                                $this->db->where('book_nurse.book_nurse_id',$request['appointment_id']);
                                                $this->db->order_by('book_nurse.book_nurse_id', 'DESC');
                                                $nurse_appointment_book= $this->db->get()->result_array();
                                                 

                                                foreach ($nurse_appointment_book as $value) {
                                                         $data['book_nurse_id']=$value['book_nurse_id'];
                                                         $data['patient_id']=$value['patient_id'];
                                                         $data['tot']=$value['total'];
                                                         $data['dis']=$value['discount'];
                                                         $data['list']=$value['list_id'];
                                                         //$data['date']=$value['date'];
                                                         $data['date']=date("d-m-Y",strtotime($value['date']));
                                                         $data['doctor']=$value['doctor_id'];
                                                          $data['address_1']=$value['address_1'];
                                                           $data['address_2']=$value['address_2'];
                                                        # code...
                                                }

                                                $this->db->select('member.*');
                                                $this->db->from('member');
                                                $this->db->where('member.user_id',$jwtUserData->user_id);
                                                $this->db->where('member.member_id', $data['patient_id']);
                                                $this->db->order_by('member.member_id', 'DESC');
                                                $member= $this->db->get()->result_array();

                                                foreach ($member as $value) {

                                                         $data1['name']=$value['name'];
                                                          $data1['patient_code']=$value['patient_code'];
                                                          $data1['address']=$data['address_1']." ".$data['address_2'];
                                                          $data1['city_id']=$value['city_id'];
                                                         // $data['list']=$value['list_id'];
                                                         // $data['date']=$value['date'];
                                                         // $data['doctor']=$value['doctor_id'];
                                                        # code...
                                                }


                                                $this->db->select('extra_invoice.*,additional_payment.amount');
                                                $this->db->from('extra_invoice');
                                                $this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.book_nurse_id','LEFT');
                                                $this->db->where('extra_invoice.user_id',$jwtUserData->user_id);
                                                $this->db->where('extra_invoice.book_nurse_id',$request['appointment_id']);
                                                $this->db->group_by('additional_payment.id'); 
                                                $this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                                                $extra_invoice= $this->db->get()->result_array();
                                                

                                                foreach ($extra_invoice as $value) {

                                                         $data2['extra_invoice_id']=$value['extra_invoice_id'];
                                                          $data2['list_data']=$value['list'];
                                                     // $data2['price'] =$value['price'];
                                                      $data2['extra_amount'] +=$value['amount'];
                                                       $data2['grand_total'] = $data['tot'] - $data['dis'] + $data2['extra_amount'];
                                                         
                                                }
                                    }
                                    elseif($request['service_id']==3)
                                    {
                                            
                                                
                                            $this->db->select('book_laboratory_test.*,add_address.address_1,add_address.address_2');
                                            $this->db->from('book_laboratory_test');
                                            $this->db->join('add_address','add_address.address_id = book_laboratory_test.address_id','LEFT');
                                            $this->db->where('book_laboratory_test.user_id',$jwtUserData->user_id);
                                            $this->db->where('book_laboratory_test.book_laboratory_test_id',$request['appointment_id']);
                                            $this->db->order_by('book_laboratory_test.book_laboratory_test_id', 'DESC');
                                            $lab_appointment_book= $this->db->get()->result_array();
                                            
                                            foreach ($lab_appointment_book as $value) {
                                                    $data['book_laboratory_test_id']=$value['book_laboratory_test_id'];
                                                     $data['patient_id']=$value['patient_id'];
                                                     $data['tot']=$value['total'];
                                                     $data['dis']=$value['discount'];
                                                     $data['list']=$value['list_id'];
                                                    // $data['date']=$value['date'];
                                                     $data['date']=date("d-m-Y",strtotime($value['date']));
                                                     $data['doctor']=$value['doctor_id'];
                                                     $data['address_1']=$value['address_1'];
                                                     $data['address_2']=$value['address_2'];
                                                    # code...
                                            }

                                            $this->db->select('member.*');
                                            $this->db->from('member');
                                            $this->db->where('member.user_id',$jwtUserData->user_id);
                                            $this->db->where('member.member_id', $data['patient_id']);
                                            $this->db->order_by('member.member_id', 'DESC');
                                            $member= $this->db->get()->result_array();

                                            foreach ($member as $value) {

                                                     $data1['name']=$value['name'];
                                                      $data1['patient_code']=$value['patient_code'];
                                                      $data1['address']=$data['address_1']." ".$data['address_2'];
                                                      $data1['city_id']=$value['city_id'];
                                                     // $data['list']=$value['list_id'];
                                                     // $data['date']=$value['date'];
                                                     // $data['doctor']=$value['doctor_id'];
                                                    # code...
                                            }


                                            $this->db->select('extra_invoice.*,additional_payment.amount');
                                            $this->db->from('extra_invoice');
                                            $this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.book_laboratory_test_id','LEFT');
                                            $this->db->where('extra_invoice.user_id',$jwtUserData->user_id);
                                            $this->db->where('extra_invoice.book_laboratory_test_id',$request['appointment_id']);
                                            $this->db->group_by('additional_payment.id');
                                            $this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                                            $extra_invoice= $this->db->get()->result_array();
                                            

                                            foreach ($extra_invoice as $value) {

                                                     $data2['extra_invoice_id']=$value['extra_invoice_id'];
                                                      $data2['list_data']=$value['list'];
                                                     // $data2['price'] =$value['price'];
                                                      $data2['extra_amount'] +=$value['amount'];
                                                       $data2['grand_total'] = $data['tot'] - $data['dis'] + $data2['extra_amount'];
                                                     
                                            }
                                       
                                            
                                    }
                                     $data3['address']="Nisarg Wellness Pvt. Ltd, 11 - Dipavali Society, Nr. Amrapali Complex, Karelibaug, Vadodara-390018, Mo- 8000126666, CIN : U74999GJ2016PTC09489";
                                    $data3['image_url'] =base_url()."assets/media/photo.png";
                                     $apiResponse = new Api_Response();
                                     $apiResponse->status = true;
                                     $apiResponse->message = "Invoice Details Listing";
                            

                                    $apiResponse->data= array(
                                      'appointment_data' => $data,
                                      'member_data' => $data1,
                                       'invoice_data' => $data2,
                                       'address_data' => $data3,
                                       
                                    );
                                    $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    
                             }
                             else
                             {
                                 $apiResponse = new Api_Response();
                                     $apiResponse->status = true;
                                     $apiResponse->message = "Invoice Details Not Found";
                            

                                    $apiResponse->data= array(
                                      'appointment_data' => null,
                                      'member_data' => null,
                                       'invoice_data' => null,
                                        'address_data' => null,
                                    );
                                    $this->response($apiResponse, REST_Controller::HTTP_OK);
                             }
                        }
                        catch (\Exception $ex)
                        {
                            $apiResponse = new Api_Response();
                            $apiResponse->status = false;
                            $apiResponse->message = $ex->getMessage();
                            $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                        }
                            
                                                 

                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                    
                }
                catch (\Exception $ex)
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                }                
            }
            else
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }


}