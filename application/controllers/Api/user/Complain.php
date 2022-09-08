<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class Complain extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
        $this->load->model('api/model/response/ComplainDetails');
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


    /**
     * @OA\Get(
     *     path="/complain/get",
     *     tags={"Complain & Feedback"},
     *     operationId="getComplainAndFeedback",
     *     summary="get Complain & Feedback Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid/unauthorized token or token not found",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    public function complain_api_get_ci_get()
    {
        $auth = $this->_head_args['Authorization'];
        // print_r($auth);
        // exit;

        if (isset($auth)) {

            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {

                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));
                    
                    $this->db->select('feedback_id,name,email,mobile,type as feedback_services_id,problem,date,user_id,feedback_options_id');
                     $this->db->from('feedback');
                     $this->db->where('user_id', $jwtUserData->user_id);
                    $complain_Details = $this->db->get()->result_array();
                    //print_r($address_Details);
                   // $rows = $get_user->custom_result_object('User');

                    if (count($complain_Details) > 0) {

                        //$member_detail = $rows[0];

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Complain & Feedback Record Listed";
                        $apiResponse->data['complain'] = $complain_Details;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Complain & Feedback Record Not Found";
                         $apiResponse->data = null;
                        $this->response($apiResponse, REST_Controller::HTTP_NOT_FOUND);
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
     *     path="/complain/add",
     *     tags={"Complain & Feedback"},
     *     operationId="postComplain",
     *     summary="Add Complain & Feedback Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ComplainRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to insert Complain",
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
    public function complain_api_add_ci_post()
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

                        $feedback = trim($request['problem']);
                        $feedback_options_id = trim($request['feedback_options_id']);
                        $feedback_services_id = trim($request['feedback_services_id']);
                            
                        
                        $user_id = trim($user_detail->user_id);
                        $name = trim($user_detail->first_name." ".$user_detail->last_name);
                       
                        $email = trim($user_detail->email);
                        $mobile = trim($user_detail->mobile);

                        if (!empty($feedback) && !empty($feedback_options_id) && !empty($feedback_services_id)) 
                        {
                            date_default_timezone_set('Asia/Kolkata');
                            $feedback_array = array(

                                'user_id'=>$user_id,
                                'name'=> $name,
                                'email'=>$email,
                                'mobile'=>$mobile,
                                'problem'=>$feedback,
                                'feedback_options_id'=>$feedback_options_id ,
                                'type'=> $feedback_services_id,
                                'date'=>date("Y-m-d H:i:s"),
                                
                            );
                            try
                            {
                                if($this->db->insert('feedback', $feedback_array))
                                {
                                    $feedback_id = $this->db->insert_id();

                                    
                                         // $response['status'] = "0";
                                         // $response['message'] = "Something went wrong";

                                $this->db->select('feedback_id,name,email,mobile,type as feedback_services_id,problem,date,user_id,feedback_options_id');
                                        $this->db->from('feedback');
                                        $this->db->where('feedback_id', $feedback_id);

                                        $get_feedback = $this->db->get();

                                        $rows = $get_feedback->custom_result_object('ComplainDetails');

                                        if(count($rows) > 0)
                                        {
                                            $feedbackDetail = $rows[0];
                                            
                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Feedback Add Successfully";
                                            $apiResponse->data = $feedbackDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Feedback not added", 1);
                                            
                                        }
                                    
                                    
                                }
                                else
                                {
                                    throw new Exception("Feedback not added", 1);
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

    
   


}