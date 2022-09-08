<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class Notification extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
        
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


    
    // code for Address *api*-------------------------------
    /**
     * @OA\get(
     *     path="/Notification/get",
     *     tags={"Notification"},
     *     operationId="getNotification",
     *     summary="Notification",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to send Notification",
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
    public function notification_api_send_ci_get()
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
                       $last_month_first_day=date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
                       $current_day=date("Y-m-d");
                        
                        $this->db->distinct();
                        $this->db->select('notification.notification_id,notification.title,notification.date,notification.user_id,notification.desc,notification.time');
                         $this->db->from('notification');
                        //  $this->db->where("notification.date>=",$last_month_first_day);
                        //  $this->db->where("notification.date<=",$current_day);
                        $this->db->where('notification.date BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()');
                        $this->db->group_by('notification.title');


                         //$this->db->where('notification.user_id', $jwtUserData->user_id);
                         
                         
                        $notification = $this->db->get()->result_array();
                        //  $this->db->last_query();
                        // exit;
                        
                         if (count($notification) > 0) {

                        //$member_detail = $rows[0];
                        
                        foreach ($notification as $key => $value) {
                         
                        
                         $value['date']=date("d-m-Y",strtotime($value['date']));

                        

                          $notification[$key] = $value;

                           
                        }

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Notification Record Listed";
                        $apiResponse->data['notification'] = $notification;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                        }
                        else
                        {

                            $apiResponse = new Api_Response();
                            $apiResponse->status = true;
                            $apiResponse->message = "Notification Record Not Found";
                            $apiResponse->data['notification'] = null;
                            $this->response($apiResponse, REST_Controller::HTTP_OK);
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
     * @OA\Post(
     *     path="/Notification/getPushNotificationToken",
     *     tags={"Notification"},
     *     operationId="pushNotificationtoken",
     *     summary="Token",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PushNotificationRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to insert token",
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
    public function getPushNotificationToken_post()
    {
        $auth = $this->_head_args['Authorization'];


        if (isset($auth)) {
            $bearer = preg_split('/\s+/', $auth);

            if (count($bearer)) {

                try {
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

                        $token = trim($request['token']);
                        $device_id = trim($request['device_id']);
                        $device_type = trim($request['device_type']);
                        $user_id = trim($user_detail->user_id);

                        try {


                    //         $this->db->select('member.member_id,member.user_id,member.name,member.contact_no,member.city_id,member.gender,member.date_of_birth,member.mem_pic,member.patient_code,city.city');
                    //          $this->db->from('member');
                    //          $this->db->join('city','city.city_id = member.city_id');  
                    //          $this->db->where('user_id', $jwtUserData->user_id);
                    //         $this->db->where('member.status',1);
                    // $member_Details = $this->db->get()->result_array();
                            
                            if (!empty($token)) {

                               
                                date_default_timezone_set('Asia/Kolkata');
                                $script_tz = date_default_timezone_get();
                                $date       = date('Y-m-d H:i:s');
                                $tokenData = array(
                                'token'=>$token,
                                'user_id'=> $user_id,
                                'deviceid'=> $device_id,
                                'device_type'=> $device_type,
                                'date'=>$date,
                                
                                  );
                                try
                            {
                                if($this->db->insert('token', $tokenData))
                                {
                                   
                                         $this->db->where('user_id',$user_id);   
                                        $this->db->update('user', array('device_type'=> $device_type,'device_token'=>$token));
                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Firebase token Inserted Successfully";
                                            //$apiResponse->data['transaction_detail'] = $address_Details;
                                            $apiResponse->data = null;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                       
                                    
                                }
                                else
                                {
                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Something went Wrong";
                                    $apiResponse->data =null;
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
                                


                                
                                // $data = array(
                                //     'status' => 'true',
                                //     'transaction_detail' => array(
                                //         'txn_token' => $jwtToken,
                                //         'order_id' =>$ORDER_ID,
                                //     ),
                                //     //'save_response' => 'User Chat List',
                                //     //'errorCode' => '200'
                                // );
                                // return $data;
                            } else {
                                // $data = array(
                                //     'status' => 'false',
                                //     'save_response' => 'Please enter amount',
                                //     'errorCode' => '412'
                                // );
                                $apiResponse = new Api_Response();
                                $apiResponse->status = true;
                                $apiResponse->message = "Please Enter Token";
                                $apiResponse->data = null;
                                $this->response($apiResponse, REST_Controller::HTTP_OK);
                            }
                        } catch (\Exception $ex) {
                            $apiResponse = new Api_Response();
                            $apiResponse->status = false;
                            $apiResponse->message = $ex->getMessage();
                            $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $apiError = new Api_Response();
                        $apiError->status = false;
                        $apiError->message = "Parameters missing";
                        $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                    }
                } catch (\Exception $ex) {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Invalid/unauthorized token";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
                }
            } else {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Invalid token";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Token not found";
            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    
    
   


}