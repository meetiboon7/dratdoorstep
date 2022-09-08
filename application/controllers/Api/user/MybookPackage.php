<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class MybookPackage extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
        // $this->load->model('api/model/response/Cart');
        //$this->load->model('api/model/response/PackageResponse');
        $this->load->model('api/model/response/BookVisitResponse');
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
     *     path="/mybook_package/get",
     *     tags={"My Book Package"},
     *     operationId="getMyBookPackageDetails",
     *     summary="My Book Package Record",
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
    
    public function my_book_package_api_get_ci_get()
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

                    // $this->db->select('manage_package.package_id,manage_package.package_code,manage_package.city_id,manage_package.service_id,manage_package.package_name,manage_package.description,manage_package.fees_name as fees,manage_package.no_visit,manage_package.validate_month as validate_day,manage_package.purchase_date');
                    //  $this->db->from('manage_package');
                     
                    // $package_Details = $this->db->get()->result_array();


                    //  $this->db->select('book_package.book_package_id,book_package.package_id,book_package.user_id,book_package.service_id,book_package.purchase_date,book_package.no_visit,book_package.available_visit,book_package.no_days,book_package.expire_date,book_package.patient_id,book_package.order_id,book_package.total as fees,book_package.responsestatus as response_status,book_package.responsecode as response_code,book_package.txnid as txn_id,book_package.paymentmade as payment_made,book_package.txndate as txn_date,book_package.gatewayname as gateway_name,book_package.banktxnid as bank_txn_id,book_package.bankname as bank_name');
                    //  $this->db->from('book_package');
                    //  $this->db->where('book_package.user_id', $jwtUserData->user_id);
                    // $mybook_package = $this->db->get()->result_array();


                    $this->db->select('book_package.book_package_id,book_package.package_id,book_package.user_id,book_package.service_id,book_package.purchase_date,book_package.no_visit,book_package.available_visit,book_package.no_days,book_package.expire_date,book_package.patient_id,book_package.order_id,book_package.total as fees,book_package.responsestatus as response_status,book_package.responsecode as response_code,book_package.txnid as txn_id,book_package.paymentmade as payment_made,book_package.txndate as txn_date,book_package.gatewayname as gateway_name,book_package.banktxnid as bank_txn_id,book_package.bankname as bank_name,user_type.user_type_name,member.name,manage_package.package_name');
                    $this->db->from('book_package');
                    $this->db->join('manage_package','book_package.package_id = manage_package.package_id');
                    $this->db->join('user_type','user_type.user_type_id = book_package.service_id');
                    $this->db->join('member','member.member_id = book_package.patient_id');
                    $this->db->where('book_package.user_id',$jwtUserData->user_id);
                    //$this->db->where('book_package.purchase_date <=',date('Y-m-d'));
                    //$this->db->where('book_package.expire_date >=',date('Y-m-d'));
                    $this->db->where("((member.status = '0' OR member.status = '1'))");
                    $this->db->order_by('book_package.book_package_id', 'DESC');
                    $mybook_package = $this->db->get()->result_array();


                     foreach ($mybook_package as $key => $value) {
                         $expire_date=$value['expire_date'];
                         $today_date=date('Y-m-d');
                         $value['expire_date']=date("d-m-Y",strtotime($value['expire_date']));

                         $value['package_expire'] = ($expire_date >= $today_date) ? true : false;

                          $mybook_package[$key] = $value;

                           
                        }
                   

                    if (count($mybook_package) > 0)
                    {
                            $apiResponse = new Api_Response();
                            $apiResponse->status = true;
                            $apiResponse->message = "My Book Package Record Listed";
                            $apiResponse->data['my_book_package'] = $mybook_package;
                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "My Book Package record not found";
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
     * @OA\Parameter(
     *      @OA\Schema(type="integer"),
     *          in="path",
     *          name="book_package_id",
     *          parameter="book_package_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/mybook_package/visit_history/{book_package_id}",
     *     tags={"My Book Package"},
     *     operationId="putVisitHistory",
     *     summary="Visit History",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/book_package_id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update member profile",
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
     public function mybook_package_visti_history_ci_post()
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

                    // $this->db->select('manage_package.package_id,manage_package.package_code,manage_package.city_id,manage_package.service_id,manage_package.package_name,manage_package.description,manage_package.fees_name as fees,manage_package.no_visit,manage_package.validate_month as validate_day,manage_package.purchase_date');
                    //  $this->db->from('manage_package');
                     
                    // $package_Details = $this->db->get()->result_array();


                   

                     $book_package_id = trim($this->uri->segments['4']);

                    $this->db->select('package_booking.*');
                    $this->db->from('package_booking');
                    $this->db->where('package_booking.user_id',$jwtUserData->user_id);
                     $this->db->where('package_booking.book_package_id',$book_package_id);
                     $mybook_package_history = $this->db->get()->result_array();

                     //echo $this->db->last_query();

                    if(count($mybook_package_history) > 0)
                    {

                             $this->db->select('book_package.book_package_id,book_package.package_id,book_package.user_id,book_package.service_id,book_package.purchase_date,book_package.no_visit,book_package.available_visit,book_package.no_days,book_package.expire_date,book_package.patient_id,book_package.order_id,book_package.total as fees,book_package.responsestatus as response_status,book_package.responsecode as response_code,book_package.txnid as txn_id,book_package.paymentmade as payment_made,book_package.txndate as txn_date,book_package.gatewayname as gateway_name,book_package.banktxnid as bank_txn_id,book_package.bankname as bank_name,manage_package.package_name');
                            $this->db->from('book_package');
                            $this->db->join('manage_package','book_package.package_id = manage_package.package_id');
                            $this->db->where('book_package.user_id',$jwtUserData->user_id);
                             $this->db->where('book_package.book_package_id',$book_package_id);
                            $this->db->order_by('book_package.package_id', 'DESC');
                            $mybook_package = $this->db->get()->row_array();


                            foreach ($mybook_package_history as $key => $value) {

                         $value['date']=date("d-m-Y",strtotime($value['date']));
                         

                          $mybook_package_history[$key] = $value;

                           
                        }

                            // echo "<pre>";
                            // print_r($mybook_package);
                             
                              $package_name = $mybook_package['package_name'];
                             // $expire_date = $mybook_package['expire_date'];

                              $expire_date =date("d-m-Y",strtotime($mybook_package['expire_date']));

                              $available_visit = $mybook_package['available_visit'];
                              $total_visit = $mybook_package['no_visit'];

                              $package_expire = ($mybook_package['expire_date'] >= date('Y-m-d')) ? true : false;
                             // echo $package_expire;

                                            

                            $apiResponse = new Api_Response();
                            $apiResponse->status = true;
                            $apiResponse->message = "My Book Package Record Listed";
                            // $apiResponse->package_name = $package_name;
                            //  $apiResponse->expire_date = $expire_date;
                            //   $apiResponse->available_visit = $available_visit;
                            //    $apiResponse->total_visit = $total_visit;

                            $apiResponse->data= array(
                              'visit_history' => $mybook_package_history,
                              'package_name' => $package_name,
                               'expire_date' => $expire_date,
                                'package_expire' => $package_expire,
                                'available_visit' => $available_visit,
                                 'total_visit' => $total_visit
                            );
                           // $apiResponse->data['visit_history'=array('package_name'=>$package_name)] = $mybook_package_history;
                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {

                        $this->db->select('book_package.book_package_id,book_package.package_id,book_package.user_id,book_package.service_id,book_package.purchase_date,book_package.no_visit,book_package.available_visit,book_package.no_days,book_package.expire_date,book_package.patient_id,book_package.order_id,book_package.total as fees,book_package.responsestatus as response_status,book_package.responsecode as response_code,book_package.txnid as txn_id,book_package.paymentmade as payment_made,book_package.txndate as txn_date,book_package.gatewayname as gateway_name,book_package.banktxnid as bank_txn_id,book_package.bankname as bank_name,manage_package.package_name');
                            $this->db->from('book_package');
                            $this->db->join('manage_package','book_package.package_id = manage_package.package_id');
                            $this->db->where('book_package.user_id',$jwtUserData->user_id);
                             $this->db->where('book_package.book_package_id',$book_package_id);
                            $this->db->order_by('book_package.package_id', 'DESC');
                            $mybook_package = $this->db->get()->row_array();


//echo $this->db->last_query();
                          
                             
                              $package_name = $mybook_package['package_name'];
                              //$expire_date = $mybook_package['expire_date'];
                               $expire_date =date("d-m-Y",strtotime($mybook_package['expire_date']));
                              $available_visit = $mybook_package['available_visit'];
                              $total_visit = $mybook_package['no_visit'];
                              $package_expire = ($mybook_package['expire_date'] >= date('Y-m-d')) ? true : false;

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "My Book Package record not found";
                      //  $apiResponse->data =null;
                         $apiResponse->data= array(
                              'visit_history' => null,
                              'package_name' => $package_name,
                               'expire_date' => $expire_date,
                               'package_expire' => $package_expire,
                                'available_visit' => $available_visit,
                                 'total_visit' => $total_visit
                            );
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
     *     path="/mybook_package/book_visit",
     *     tags={"My Book Package"},
     *     operationId="postBook_visit",
     *     summary="Book Visit",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookVisitRequest"),
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
    public function book_visit_api_ci_post()
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
                       
                       
                      //  $package_id = trim($request['package_id']);
                        $book_package_id = trim($request['book_package_id']);
                       // $service_id = trim($request['service_id']);
                       // $patient_id = trim($request['patient_id']);
                        $date = trim($request['date']);
                        $time = trim($request['time']);
                       
                        
                        $user_id = trim($user_detail->user_id);

                        if (!empty($book_package_id)) 
                        {
                             $this->db->select('*');
                            $this->db->from('book_package');
                            $this->db->where('book_package_id', $book_package_id);
                             $this->db->where('user_id', $jwtUserData->user_id);
                             $mybook_package = $this->db->get()->result_array();


                          

                            $package_book = array(
            
                                'user_id'=>$user_id,
                                'package_id'=>$mybook_package[0]['package_id'],
                                'service_id'=>$mybook_package[0]['service_id'],
                                'book_package_id'=>$book_package_id,
                                'patient_id'=>$mybook_package[0]['patient_id'],
                                'date'=>$date,
                                'time'=>$time,
                                
                            );
                            // echo "<pre>";
                            // print_r($package_book);
                            // echo "</pre>";

                            try
                            {
                                if($this->db->insert('package_booking', $package_book))
                                {
                                    $Id = $this->db->insert_id();

                                        $available_visit=$mybook_package[0]['available_visit']-1;
            
                                     $this->db->where('book_package_id',$book_package_id);
                                     $this->db->update('book_package', array('available_visit' => $available_visit));

                                        $this->db->select('*');
                                        $this->db->from('package_booking');
                                        $this->db->where('id',$Id);

                                        $get_book_visit = $this->db->get();

                                        $rows = $get_book_visit->custom_result_object('BookVisitResponse');
                                        //$rows = $get_book_visit->custom_result_object('Cart');

                                        if(count($rows) > 0)
                                        {
                                            $book_visit = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Book Visit Inserted Successfully";
                                            $apiResponse->data = $book_visit;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Book Package not added", 1);
                                            
                                        }
                                   
                                    
                                }
                                else
                                {
                                    throw new Exception("Book Visit not added", 1);
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