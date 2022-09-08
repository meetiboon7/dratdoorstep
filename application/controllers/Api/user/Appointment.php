<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class Appointment extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
         $this->load->model('api/model/response/Cart');
        $this->load->model('api/model/response/AppointmentType');
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
     * @OA\Post(
     *     path="/doctor/add",
     *     tags={"Appointment"},
     *     operationId="postDoctorAppointment",
     *     summary="Add Doctor Appointment",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DoctorRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Doctor Appointment",
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
    public function doctor_api_add_ci_post()
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

                        $patient_id = trim($request['patient_id']);
                        $address_id = trim($request['address_id']);
                        $complain = trim($request['complain']);
                        
                        $doctor_type_id = trim($request['doctor_type_id']);
                        $date = trim($request['date']);
                        $time = trim($request['time']);
                       
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($patient_id) && !empty($address_id) && !empty($doctor_type_id) && !empty($date) && !empty($time)) 
                        {
                                           $this->db->select('city_id');
                                                $this->db->from('member');
                                                $this->db->where('member_id',$patient_id);
                                                
                                                $member_data = $this->db->get()->result_array();
                                                foreach($member_data as $member){
                                        
                                                         $city_id = $member['city_id'];
                                                             
                                                }


        //echo $city_id;
        date_default_timezone_set("Asia/Kolkata");
         
        $date_holiday=date('Y-m-d');
        $this->db->select('holidays.*');
        $this->db->from('holidays');
        $this->db->where('hdate',$date);
        $holiday = $this->db->get()->result_array();
        // echo $this->db->last_query();
       /* echo "<pre>";
        print_r($holiday);*/
        
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
       //  $time= date('H:i:s');
          $time= $time;
       
         //$date=date('Y-m-d');


         // echo $holiday[0][hdate]."==".$post['date'];
         // exit;
         
         $givendate=date('Y-m-d');
        $MyGivenDateIn = strtotime($date);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);
        // echo $ConverDateTomatch;
        // exit;
            // echo $time;
            // exit;
          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$date || ($time >=$start && $time >= $end)) {

                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               // $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                $this->db->where('manage_fees.service_id',1);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_doctor = $this->db->get()->result_array();


                foreach($fees_doctor as $doctor){

                 
                    
                     if($doctor['fees_type_id']==2 || $doctor['fees_type_id']==3 || $doctor['fees_type_id']==4 || $doctor['fees_type_id']==5)
                    {
                         $amount=$doctor['fees_name'];
                     }
                    
                }


          }
          else
          {
                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               // $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                $this->db->where('manage_fees.service_id',1);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_doctor = $this->db->get()->result_array();

                foreach($fees_doctor as $doctor){


                   // $amount=$doctor['fees_name'];

                    // echo "<pre>";
                    // print_r($doctor);
                    //exit;

                    //  $amount = $doctor['fees_name'];
                    
                    if($doctor['fees_type_id']==1)
                    {
                        $amount=$doctor['fees_name'];
                    }
                    
                }
            }
                            $doctorAppointment = array(
                                'patient_id'=>$patient_id,
                                'address'=> $address_id,
                                'complain'=> $complain,
                                'doctor_type_id'=> $doctor_type_id,
                                'date'=>$date,
                                'time'=> $time,
                                'user_id' => $user_id,
                                'user_type_id' => 1,
                                'amount' =>$amount

                            );
                            //print_r($doctorAppointment);
                        if($amount!=""){
                            try
                            {
                                if($this->db->insert('cart', $doctorAppointment))
                                {
                                    $cartId = $this->db->insert_id();

                                   

                                        $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$cartId);

                                        $get_cart = $this->db->get();
                                        

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                        $rows = $get_cart->custom_result_object('Cart');

                                        if(count($rows) > 0)
                                        {
                                            $doctorAppointmentDetail = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Doctor Appointment Inserted Successfully";
                                            $apiResponse->data = $doctorAppointmentDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Doctor Appointment not added", 1);
                                            
                                        }
                                   
                                    
                                }
                                else
                                {
                                    throw new Exception("Doctor Appointment not added", 1);
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
                                 $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = "Please contact to administration";
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
     * @OA\Post(
     *     path="/nurse/add",
     *     tags={"Appointment"},
     *     operationId="postNurseAppointment",
     *     summary="Add Nurse Appointment",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/NurseRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Nurse Appointment",
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
    public function nurse_api_add_ci_post()
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

                        $patient_id = trim($request['patient_id']);
                        $address_id = trim($request['address_id']);
                        $nurse_service_id = trim($request['nurse_service_id']);
                        $complain = trim($request['complain']);
                        $date = trim($request['date']);
                        $time = trim($request['time']);
                        $days = trim($request['days']);
                       
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($patient_id) && !empty($address_id) && !empty($nurse_service_id) && !empty($date) && !empty($time)) 
                        {



                            $this->db->select('city_id');
                            $this->db->from('member');
                            $this->db->where('member_id',$patient_id);
                            
                            $member_data = $this->db->get()->result_array();
                            foreach($member_data as $member){

                                         $city_id = $member['city_id'];
                                         
                            }

                            
                                     date_default_timezone_set("Asia/Kolkata");
         
                                        $date_holiday=date('Y-m-d');
                                        $this->db->select('holidays.*');
                                        $this->db->from('holidays');
                                        $this->db->where('hdate',$date);
                                        $holiday = $this->db->get()->result_array();
                                        
                                            
                                             $start = '08:00:00';
                                             $end   = '20:00:00';
                                             //$time=time();
                                            // $time= date('H:i:s');
                                            $time= $time;
                                           
                
                                            $givendate=date('Y-m-d');
                                            $MyGivenDateIn = strtotime($date);
                                            $ConverDate = date("l", $MyGivenDateIn);
                                            $ConverDateTomatch = strtolower($ConverDate);

                                          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$date || ($time >=$start && $time >= $end)) 
                                          {
                                                    // $this->db->select('*');
                                                    // $this->db->from('manage_fees');
                                                    // //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                    // $this->db->where('manage_fees.submenu_type_id',$nurse_service_id);
                                                    // $this->db->where('manage_fees.service_id',2);
                                                    //  $this->db->where('manage_fees.city_id',$city_id);
                                                    // $fees_nurse = $this->db->get()->result_array();
                
                                                    // foreach($fees_nurse as $nurse){
                
                                                    //      $amount = $nurse['fees_name'];
                                                        
                
                                                    //      $type_name = $nurse['nurse_service_name'];
                                                    // }
                                                   // echo "1";
                                                    if($nurse_service_id==1)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$nurse_service_id);
                                                            $this->db->where('manage_fees.service_id',2);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else if($nurse_service_id==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$nurse_service_id);
                                                            $this->db->where('manage_fees.service_id',2);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'] * $days;
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$nurse_service_id);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            //$this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                        
                                                    }
                                          }
                                          else
                                          {
                                              
                                             // echo "2";
                                                    if($nurse_service_id==1)
                                                    {
                                                        //echo "fdsf";
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$nurse_service_id);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            //echo $this->db->last_query();
                        
                                                            foreach($fees_nurse as $nurse){
                                                                               
                                                                 $amount = $nurse['fees_name'];
                                                              
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else if($nurse_service_id==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$nurse_service_id);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'] * $days;
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else if($nurse_service_id==3)
                                                    {
                                                       // echo "3";
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$nurse_service_id);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                           // echo $this->db->last_query();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                        
                                                    }
                                                    
                                                    
                                          }
                                   
                            //}
                                                         
                           
                            //  if($nurse_service_id== 2){
                                
                            //     $amount= $amount * $days;
                            //  }
                            // exit;
                            
                            $nurseAppointment = array(
                                'user_id'=>$user_id,
                                'patient_id'=>$patient_id,
                                'date'=>$date,
                                'time'=>$time,
                                'nurse_service_id'=>$nurse_service_id,
                                'user_type_id'=>'2',
                                'days'=>$days,
                                'address'=>$address_id,
                                'complain'=>$complain,
                                'amount'=>$amount,
                                'cityId'=>$city_id,
                            );
                            //print_r($nurseAppointment);
                         if($amount!=""){
                            try
                            {
                                if($this->db->insert('cart', $nurseAppointment))
                                {
                                    $cartId = $this->db->insert_id();

                                   

                                        $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$cartId);

                                        $get_cart = $this->db->get();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         $rows = $get_cart->custom_result_object('Cart');

                                        if(count($rows) > 0)
                                        {
                                            $nurseAppointmentDetail = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Nurse Appointment Inserted Successfully";
                                            $apiResponse->data = $nurseAppointmentDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Nurse Appointment not added", 1);
                                            
                                        }
                                   
                                    
                                }
                                else
                                {
                                    throw new Exception("Nurse Appointment not added", 1);
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
                                  $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = "Please contact to administration";
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
     * @OA\Post(
     *     path="/lab/add",
     *     tags={"Appointment"},
     *     operationId="postLabAppointment",
     *     summary="Add Lab Appointment",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/LabRequest"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to insert Lab Appointment",
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
    public function lab_api_add_ci_post()
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
                        /*echo "<pre>";
                        $prescription = trim($request['prescription']);
                        print_r($request);
                        echo "</pre>";*/
                        $patient_id = trim($request['patient_id']);
                        $address_id = trim($request['address_id']);
                        $lab_test_id  = trim($request['lab_test_id']);
                        $date = trim($request['date']);
                        $time = trim($request['time']);
                         $complain = trim($request['complain']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($patient_id) && !empty($address_id) && !empty($lab_test_id) && !empty($date) && !empty($time)) 
                        {

                            $this->db->select('city_id');
                            $this->db->from('member');
                            $this->db->where('member_id',$patient_id);
                            
                            $member_data = $this->db->get()->result_array();
                         //   echo $this->db->last_query();
                            foreach($member_data as $member){

                                         $city_id = $member['city_id'];
                                         
                            }
                            
                                        date_default_timezone_set("Asia/Kolkata");
         
                                        $date_holiday=date('Y-m-d');
                                        $this->db->select('holidays.*');
                                        $this->db->from('holidays');
                                        $this->db->where('hdate',$date);
                                        $holiday = $this->db->get()->result_array();
                                        
                                            
                                             $start = '08:00:00';
                                             $end   = '20:00:00';
                                             //$time=time();
                                            // $time= date('H:i:s');
                                            $time= $time;
                                           
                
                                            $givendate=date('Y-m-d');
                                            $MyGivenDateIn = strtotime($date);
                                            $ConverDate = date("l", $MyGivenDateIn);
                                            $ConverDateTomatch = strtolower($ConverDate);

                                          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$date || ($time >=$start && $time >= $end)) 
                                          {
                                                   
                                                    if($lab_test_id==1)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                           $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                
                                                            }
                                                    }
                                                    else if($lab_test_id==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                           $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                                
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                                                            }
                                                    }
                                                     else if($lab_test_id==3)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 
                                                            }
                                                        
                                                    }
                                                     else if($lab_test_id==4)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                
                                                            }
                                                        
                                                    }
                                          }
                                          else
                                          {
                                              
                                            
                                                   if($lab_test_id==1)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            //echo $this->db->last_query();
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                //   echo "2";
                                                                //  exit;
                                                                
                        
                                                                 
                                                            }
                                                    }
                                                    else if($lab_test_id==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                                
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                 
                                                            }
                                                    }
                                                     else if($lab_test_id==3)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                
                                                            }
                                                        
                                                    }
                                                     else if($lab_test_id==4)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 
                                                            }
                                                        
                                                    }
                                                    
                                                    
                                                }
                            // echo $city_id;
                            // exit;

                                //     $this->db->select('*');
                                //     $this->db->from('manage_fees');
                                //     $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                //     $this->db->where('manage_fees.service_id',3);
                                //      $this->db->where('manage_fees.city_id',$city_id);
                                //     $fees_lab = $this->db->get()->result_array();
                                //   //  echo $this->db->last_query();
                                //     foreach($fees_lab as $lab){

                                //          $amount = $lab['fees_name'];
                                //     }

                            $labAppointment = array(


                                'user_id'=>$user_id,
                                'patient_id'=>$patient_id,
                                'lab_test_id'=>$lab_test_id,
                                'date'=>$date,
                                'user_type_id'=>'3',
                                'time'=>$time,
                                'address'=>$address_id,
                                'amount'=>$amount,
                                'cityId'=>$city_id,
                                'complain'=>$complain
                                
                            );
                            
                           // print_r($labAppointment);
                            //  $labAppointment = array(
                            //     'patient_id'=>$patient_id,
                            //     'address'=>$address_id,
                            //     'lab_test_id'=> $lab_test_id,
                            //     'date'=>$date,
                            //     'time'=> $time,
                            //     'user_id' => $user_id,
                            //     'user_type_id' => 3,
                            //     'amount' =>300

                            // );
                     if($amount!=""){
                            try
                            {
                                if($this->db->insert('cart', $labAppointment))
                                {
                                    $cartId = $this->db->insert_id();

                                    //if( $this->General_model->uploadCartLabImage('./uploads/lab_report/', $cartId,'profile_','prescription', 'cart','prescription'))
                                    //{
                                         // $response['status'] = "0";
                                         // $response['message'] = "Something went wrong";
                                    $this->General_model->uploadCartLabImage('./uploads/lab_report/', $cartId,'profile_','prescription', 'cart','prescription');

                                        $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$cartId);

                                        $get_cart = $this->db->get();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         $rows = $get_cart->custom_result_object('Cart');

                                        if(count($rows) > 0)
                                        {
                                            $labDetail = $rows[0];
                                           // $labDetail->prescription = base_url() . 'uploads/lab_report/' . $labDetail->prescription;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Lab Appointment Inserted Successfully";
                                            $apiResponse->data = $labDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Lab Appointment not added", 1);
                                            
                                        }
                                    // }
                                    // else
                                    // {
                                    //     throw new Exception($this->upload->display_errors(), 1);
                                    // }
                                    
                                }
                                else
                                {
                                    throw new Exception("Lab Appointment not added", 1);
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
                                $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = "Please contact to administration";
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
     * @OA\Post(
     *     path="/pharmacy/add",
     *     tags={"Appointment"},
     *     operationId="postPharmacyAppointment",
     *     summary="Add Pharmacy Appointment",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/PharmacyRequest"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to insert Pharmacy Appointment",
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
    public function pharmacy_api_add_ci_post()
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
                        /*echo "<pre>";
                        $prescription = trim($request['prescription']);
                        print_r($request);
                        echo "</pre>";*/
                        //$patient_id = trim($request['patient_id']);
                        //$address_id  = trim($request['address_id']);
                        $contact_name = trim($request['contact_name']);
                        $contact_no = trim($request['contact_no']);
                        $landline_number = trim($request['landline_number']);
                        $city_id = trim($request['city_id']);
                        $address = trim($request['address']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($contact_name) && !empty($contact_no) && !empty($city_id) && !empty($address)) 
                        {
                            

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

                                if($this->db->insert('book_medicine', $pharmaAppointment))
                                {
                                    date_default_timezone_set("Asia/Calcutta");
                                    $datetime=date('Y-m-d H:i:s');
                                    $dateresult=explode(' ', $datetime);

                                    $message="Hi '".$contact_name."' we have scheduled your appointment today Dt '".$dateresult[0]."' & Time'".$dateresult[1]."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
";
                                    $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$contact_no;
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
                                    $last_book_medicine = $this->db->insert_id();

                                    if( $this->General_model->uploadPharmacyImage('./uploads/pharmacy_document/', $last_book_medicine,'profile_','prescription', 'book_medicine','prescription'))
                                    {
                                         // $response['status'] = "0";
                                         // $response['message'] = "Something went wrong";

                                        $this->db->select('book_medicine.book_medicine_id,book_medicine.user_id,book_medicine.name as contact_name,book_medicine.mobile as contact_no,book_medicine.landline as landline_number,book_medicine.city_id,book_medicine.address,book_medicine.prescription');
                                        $this->db->from('book_medicine');
                                        $this->db->where('book_medicine.book_medicine_id',$last_book_medicine);
                                       // echo $this->db->last_query();


                                        $get_cart = $this->db->get();

                                        $rows = $get_cart->custom_result_object('PharmacyType');

                                       // print_r($rows);

                                        if(count($rows) > 0)
                                        {
                                            $pharmacyDetail = $rows[0];
                                            $pharmacyDetail->prescription = base_url() . 'uploads/pharmacy_document/' . $pharmacyDetail->prescription;

                                            //$pharmacyDetail->prescription = base_url() . 'uploads/pharmacy_document/' . $pharmacyDetail->prescription;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Pharmacy Appointment Inserted Successfully";
                                            $apiResponse->data = $pharmacyDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Pharmacy Appointment not added", 1);
                                            
                                        }
                                    }
                                    else
                                    {
                                        throw new Exception($this->upload->display_errors(), 1);
                                    }
                                    
                                }
                                else
                                {
                                    throw new Exception("Lab Appointment not added", 1);
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
     * @OA\Post(
     *     path="/ambulance/one_way",
     *     tags={"Appointment"},
     *     operationId="postAmbulanceOneWay",
     *     summary="Ambulance OneWay",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AmbulanceOneWay"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Ambulance Appointment",
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
    public function ambulance_api_one_way_ci_post()
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

                        $patient_id = trim($request['patient_id']);
                        $mobile_no = trim($request['mobile_no']);
                        $landline_number = trim($request['landline_number']);
                        $city_id = trim($request['city_id']);
                        $from_address = trim($request['from_address']);
                        $to_address = trim($request['to_address']);
                        $start_date = trim($request['date']);
                        $start_time = trim($request['time']);
                         //$condition = trim($request['condition']);
                       
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($patient_id) && !empty($city_id) && !empty($from_address) && !empty($to_address) && !empty($start_date) && !empty($start_time)) 
                        {
                            if($landline_number=="string")
                            {
                                $landline_number=0;
                            }
                            else
                            {
                                $landline_number=$landline_number." ";
                            }



                            /*$this->db->select('*');
                            $this->db->from('manage_fees');
                            $this->db->where('manage_fees.submenu_type_id',1);
                            $this->db->where('manage_fees.service_id',5);
                             $this->db->where('manage_fees.city_id',$city_id);
                            $fees_oneway = $this->db->get()->result_array();
                          
                            foreach($fees_oneway as $oneway){

                                 $amount = $oneway['fees_name'];
                            }*/
                            date_default_timezone_set("Asia/Kolkata");
         
        $date_holiday=date('Y-m-d');
    $this->db->select('holidays.*');
    $this->db->from('holidays');
    $this->db->where('hdate',$start_date);
    $holiday = $this->db->get()->result_array();
    
        
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
        // $time= date('H:i:s');
        $time= $start_time;
       

        $givendate=date('Y-m-d');
        $MyGivenDateIn = strtotime($date);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);

          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$start_date || ($time >=$start && $time >= $end)) 
          {
              
              
                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               
                $this->db->where('manage_fees.submenu_type_id',1);
                $this->db->where('manage_fees.service_id',5);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_oneway = $this->db->get()->result_array();
         
        
                  foreach($fees_oneway as $oneway){

                       $amount = $oneway['fees_name'];
                  }
          }
          else
          {
                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               $this->db->where('manage_fees.submenu_type_id',1);
                $this->db->where('manage_fees.service_id',5);
                $this->db->where('manage_fees.fees_type_id',1);

              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_oneway = $this->db->get()->result_array();
                
        
                  foreach($fees_oneway as $oneway){

                       $amount = $oneway['fees_name'];
                  }
          }
                       
                            $ambulance_appointment_array = array(
                                'patient_id'=>$patient_id,
                                'user_id'=>$user_id,
                                 'address'=>0,
                                //'contactPerson'=>$post['first_name']." ".$post['last_name'],
                                //'age'=>$post['age'],
                                //'gender'=>$post['gender_type_validate'],
                                'mobileNumber'=>$mobile_no,
                                //'mobile2'=>$post['mobile2'],
                                'landlineNumber'=>$landline_number,
                                'cityId'=>$city_id,
                                'from_address'=>$from_address." ",
                                'to_address'=>$to_address." ",
                                //'condition'=>$condition,
                                'user_type_id'=>'5',
                                'type'=>1,
                                // 'country_id'=>$post['country_id'],
                                // 'state_id'=>$post['state_id'],
                                'date'=>$start_date,
                                'time'=>$start_time,
                                'amount'=>$amount,
                        );
                        if($amount!=""){
                            try
                            {
                                if($this->db->insert('cart', $ambulance_appointment_array))
                                {
                                    $cartId = $this->db->insert_id();

                                   

                                        $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$cartId);

                                        $get_cart = $this->db->get();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         $rows = $get_cart->custom_result_object('Cart');

                                        if(count($rows) > 0)
                                        {
                                            $ambulanceOneWay = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Ambulance One Way Appointment Inserted Successfully";
                                            $apiResponse->data = $ambulanceOneWay;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Ambulance One Way Appointment not added", 1);
                                            
                                        }
                                   
                                    
                                }
                                else
                                {
                                    throw new Exception("Ambulance One Way Appointment not added", 1);
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
                                 $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = "Please contact to administration";
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
     * @OA\Post(
     *     path="/ambulance/round_trip",
     *     tags={"Appointment"},
     *     operationId="postAmbulanceRoundTrip",
     *     summary="Ambulance RoundTrip",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AmbulanceOneWay"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Ambulance Appointment",
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
    public function ambulance_api_round_trip_ci_post()
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

                        $patient_id = trim($request['patient_id']);
                        $mobile_no = trim($request['mobile_no']);
                        $landline_number = trim($request['landline_number']);
                        $city_id = trim($request['city_id']);
                        $from_address = trim($request['from_address']);
                        $to_address = trim($request['to_address']);
                        $start_date = trim($request['date']);
                        $start_time = trim($request['time']);
                         //$condition = trim($request['condition']);
                       
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($patient_id) && !empty($city_id) && !empty($from_address) && !empty($to_address) && !empty($start_date) && !empty($start_time)) 
                        {
                            // $nurseAppointment = array(
                            //     'patient_id'=>$patient_id,
                            //     'address'=> $address_id,
                            //     'nurse_service_id'=> $nurse_service_id,
                            //     'complain'=>$complain,
                            //     'date'=>$date,
                            //     'time'=> $time,
                            //     'user_id' => $user_id,
                            //     'user_type_id' => 2,
                            //     'amount' =>249

                            // );

                            if($landline_number=="string")
                            {
                                $landline_number=0;
                            }
                            else
                            {
                                $landline_number=$landline_number." ";
                            }
                            
                            // $this->db->select('*');
                            // $this->db->from('manage_fees');
                            // $this->db->where('manage_fees.submenu_type_id',2);
                            // $this->db->where('manage_fees.service_id',5);
                            // $this->db->where('manage_fees.city_id',$city_id);
                            // $fees_roundtrip = $this->db->get()->result_array();
                          
                            // foreach($fees_roundtrip as $roundtrip){

                            //      $amount = $roundtrip['fees_name'];
                            // }
    date_default_timezone_set("Asia/Kolkata");
         
        $date_holiday=date('Y-m-d');
    $this->db->select('holidays.*');
    $this->db->from('holidays');
    $this->db->where('hdate',$start_date);
    $holiday = $this->db->get()->result_array();
    
        
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
        // $time= date('H:i:s');
        $time= $start_time;
       

        $givendate=date('Y-m-d');
        $MyGivenDateIn = strtotime($start_date);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);
        
        //echo $ConverDateTomatch;

          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$start_date || ($time >=$start && $time >= $end)) 
          {
            //   echo "11";
            //   exit;
                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               
                $this->db->where('manage_fees.submenu_type_id',2);
                $this->db->where('manage_fees.service_id',5);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_oneway = $this->db->get()->result_array();
         
        
                  foreach($fees_oneway as $oneway){

                       $amount = $oneway['fees_name'];
                  }
                 // echo $amount;
          }
          else
          {
            
                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               $this->db->where('manage_fees.submenu_type_id',2);
                $this->db->where('manage_fees.service_id',5);
                $this->db->where('manage_fees.fees_type_id',1);

              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_oneway = $this->db->get()->result_array();
                
        
                  foreach($fees_oneway as $oneway){

                       $amount = $oneway['fees_name'];
                  }
          }

                            $ambulance_appointment_array = array(
                                'patient_id'=>$patient_id,
                                'user_id'=>$user_id,
                                 'address'=>0,
                                //'contactPerson'=>$post['first_name']." ".$post['last_name'],
                                //'age'=>$post['age'],
                                //'gender'=>$post['gender_type_validate'],
                                'mobileNumber'=>$mobile_no,
                                //'mobile2'=>$post['mobile2'],
                                'landlineNumber'=>$landline_number,
                                'cityId'=>$city_id,
                                'from_address'=>$from_address." ",
                                'to_address'=>$to_address." ",
                               // 'condition'=>$condition,
                                'user_type_id'=>'5',
                                'type'=>2,
                                // 'country_id'=>$post['country_id'],
                                // 'state_id'=>$post['state_id'],
                                'date'=>$start_date,
                                'time'=>$start_time,
                                'amount'=>$amount,
                            );
                        if($amount!=""){
                            try
                            {
                                if($this->db->insert('cart', $ambulance_appointment_array))
                                {
                                    $cartId = $this->db->insert_id();

                                   

                                        $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$cartId);

                                        $get_cart = $this->db->get();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         $rows = $get_cart->custom_result_object('Cart');

                                        if(count($rows) > 0)
                                        {
                                            $ambulanceOneWay = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Ambulance Round Trip Appointment Inserted Successfully";
                                            $apiResponse->data = $ambulanceOneWay;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Ambulance Round Trip Appointment not added", 1);
                                            
                                        }
                                   
                                    
                                }
                                else
                                {
                                    throw new Exception("Ambulance Round Trip Appointment not added", 1);
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
                                 $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = "Please contact to administration";
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
     * @OA\Post(
     *     path="/ambulance/multi_location",
     *     tags={"Appointment"},
     *     operationId="postAmbulanceMultiLocation",
     *     summary="Ambulance MultiLocation",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AmbulanceMultiLocation"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Ambulance Appointment",
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
    public function ambulance_api_multi_location_ci_post()
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
                      //  print_r($request);
                        $patient_id = trim($request['patient_id']);
                        
                        $mobile_no = trim($request['mobile_no']);
                        $landline_number = trim($request['landline_number']);
                        $city_id = trim($request['city_id']);
                        $start_date = trim($request['date']);
                        $start_time = trim($request['time']);
                        $multi_location = $request['multi_location'];
                        // echo "gfdg".$multi_location;
                        // exit;
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($patient_id) && !empty($city_id) && !empty($start_date) && !empty($start_time) && !empty($multi_location)) 
                        {
                           

                             if($landline_number=="string")
                            {
                                $landline_number=0;
                            }
                            else
                            {
                                $landline_number=$landline_number." ";
                            }
                             //echo "gfdg".$multi_location;
                        // exit;
                        
                           /* $this->db->select('*');
                            $this->db->from('manage_fees');
                            $this->db->where('manage_fees.submenu_type_id',3);
                            $this->db->where('manage_fees.service_id',5);
                            $this->db->where('manage_fees.city_id',$city_id);
                            $fees_multi = $this->db->get()->result_array();
                          
                            foreach($fees_multi as $multitrip){

                                 $amount = $multitrip['fees_name'];
                            }*/
                            date_default_timezone_set("Asia/Kolkata");
         
                            $date_holiday=date('Y-m-d');
                        $this->db->select('holidays.*');
                        $this->db->from('holidays');
                        $this->db->where('hdate',$start_date);
                        $holiday = $this->db->get()->result_array();
                        
                            
                             $start = '08:00:00';
                             $end   = '20:00:00';
                             //$time=time();
                            // $time= date('H:i:s');
                            $time= $start_time;
                           

                            $givendate=date('Y-m-d');
                            $MyGivenDateIn = strtotime($start_date);
                            $ConverDate = date("l", $MyGivenDateIn);
                            $ConverDateTomatch = strtolower($ConverDate);

                              if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$start_date || ($time >=$start && $time >= $end)) 
                              {
                                    $this->db->select('manage_fees.*,fees_type.fees_type_name');
                                    $this->db->from('manage_fees');
                                    $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                                   
                                    $this->db->where('manage_fees.submenu_type_id',3);
                                    $this->db->where('manage_fees.service_id',5);
                                  //  $this->db->where('manage_fees.fees_type_id',1);
                                     $this->db->where('manage_fees.city_id',$city_id);
                                    $fees_oneway = $this->db->get()->result_array();
                             
                            
                                      foreach($fees_oneway as $oneway){

                                           $amount = $oneway['fees_name'];
                                      }
                              }
                              else
                              {
                                    $this->db->select('manage_fees.*,fees_type.fees_type_name');
                                    $this->db->from('manage_fees');
                                    $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                                   $this->db->where('manage_fees.submenu_type_id',3);
                                    $this->db->where('manage_fees.service_id',5);
                                    $this->db->where('manage_fees.fees_type_id',1);

                                  //  $this->db->where('manage_fees.fees_type_id',1);
                                     $this->db->where('manage_fees.city_id',$city_id);
                                    $fees_oneway = $this->db->get()->result_array();
                                    
                            
                                      foreach($fees_oneway as $oneway){

                                           $amount = $oneway['fees_name'];
                                      }
                              }
                            $ambulance_appointment_array = array(
                                'patient_id'=>$patient_id,
                                'user_id'=>$user_id,
                                 'address'=>0,
                                'mobileNumber'=>$mobile_no,
                                'user_type_id'=>'5',
                                'landlineNumber'=>$landline_number,
                                'type'=>3,
                                'multi_city'=>$multi_location,
                                'amount'=>$amount,
                                'date'=>$start_date,
                                'time'=>$start_time,
                                'cityId'=>$city_id
                           );

                           
                            if($amount!=""){
                            try
                            {
                                if($this->db->insert('cart', $ambulance_appointment_array))
                                {
                                    $cartId = $this->db->insert_id();

                                   

                                        $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$cartId);

                                        $get_cart = $this->db->get();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         $rows = $get_cart->custom_result_object('Cart');

                                        if(count($rows) > 0)
                                        {
                                            $ambulanceOneWay = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Ambulance Multi Location Appointment Inserted Successfully";
                                            $apiResponse->data = $ambulanceOneWay;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Ambulance Multi Location Appointment not added", 1);
                                            
                                        }
                                   
                                    
                                }
                                else
                                {
                                    throw new Exception("Ambulance Multi Location Appointment not added", 1);
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
                                 $apiResponse = new Api_Response();
                                $apiResponse->status = false;
                                $apiResponse->message = "Please contact to administration";
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
    


}