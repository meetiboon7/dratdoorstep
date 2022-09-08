<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class Package extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
         $this->load->model('api/model/response/Cart');
        $this->load->model('api/model/response/PackageResponse');
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
     *     path="/package/get",
     *     tags={"Package"},
     *     operationId="getPackageDetails",
     *     summary="Package Record",
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
    
    public function package_api_get_ci_get()
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
                    
                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id,city_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');
                     $user_detail = $rows[0];
                    
                    $this->db->select('manage_package.package_id,manage_package.package_code,manage_package.city_id,manage_package.service_id,manage_package.package_name,manage_package.description,manage_package.fees_name as fees,manage_package.no_visit,manage_package.validate_month as validate_day,manage_package.purchase_date');
                     $this->db->from('manage_package');
                     $this->db->where('manage_package.city_id',$user_detail->city_id);
                    $package_Details = $this->db->get()->result_array();
                  // echo $this->db->last_query();
                    $packageList = array();
                                                        foreach($package_Details as $package){ 


                                                             $date = $package['purchase_date'];
                        
                                                                        $date = strtotime($date);
                                                                        $expired_date = strtotime("+".$package['validate_day']."day", $date);
                                                                        $expired_date = date('Y-m-d', $expired_date);
                                                                        $today=date('Y-m-d');
                                               // echo $today."<br>";
                                              //  echo $expired_date."<br>";
                                               // exit;
                                                    if ($today < $expired_date) {
                                                        array_push($packageList, $package);
                                                    }

                                             }
                                             
                                             //24-6-2021 start
                                              /*if (count($package_Details) > 0) {
                                                $apiResponse = new Api_Response();
                                                $apiResponse->status = true;
                                                $apiResponse->message = "Package Record Listed";
                                                $apiResponse->data['package'] = $package_Details;
                                                $this->response($apiResponse, REST_Controller::HTTP_OK);
                                            }
                                             */
                                             
                                             ///24-6-2021 end
                                               
                                               if (count($package_Details) > 0) {
                                                $apiResponse = new Api_Response();
                                                $apiResponse->status = true;
                                                $apiResponse->message = "Package Record Listed";
                                                $apiResponse->data['package'] = $package_Details;
                                                $this->response($apiResponse, REST_Controller::HTTP_OK);
                                            }
                                            else
                                            {
                                                $apiResponse = new Api_Response();
                                                $apiResponse->status = true;
                                                $apiResponse->message = "Package record not found";
                                                $apiResponse->data =null;
                                                $this->response($apiResponse, REST_Controller::HTTP_OK);
                                            }
                    
                   // $rows = $get_user->custom_result_object('User');


                                                   

                   
                    
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
     *     path="/package/book",
     *     tags={"Package"},
     *     operationId="postPackageBook",
     *     summary="Package Book",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PackageRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Package Book",
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
    public function book_package_api_ci_post()
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
                        $user_type_id = trim($request['service_id']);
                        $amount = trim($request['fees']);
                        $package_id = trim($request['package_id']);
                        
                        date_default_timezone_set("Asia/Kolkata");

                        $curr_timestamp = date("Y-m-d H:i:s");
                        $splitTimeStamp = explode(" ",$curr_timestamp);
                        $date = $splitTimeStamp[0];
                        $time = $splitTimeStamp[1];
                       
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);
                       
                       
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($patient_id) && !empty($address_id) && !empty($user_type_id) && !empty($amount)  && !empty($package_id)) 
                        {
                            $add_package_array = array(
                                'user_id'=> $user_id,
                                'patient_id'=>$patient_id,
                                'user_type_id'=>$user_type_id,
                                'amount'=>$amount,
                                'address'=>$address_id,
                                'package_id'=>$package_id,
                                'date'=>$date,
                                'time'=>$time
            
                             );
                            try
                            {
                                if($this->db->insert('cart', $add_package_array))
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
                                            $book_package = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Book Package Successfully";
                                            $apiResponse->data = $book_package;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Book Package not added", 1);
                                            
                                        }
                                   
                                    
                                }
                                else
                                {
                                    throw new Exception("Book Package not added", 1);
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