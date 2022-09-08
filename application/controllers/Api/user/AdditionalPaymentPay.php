<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/stack_web_gateway_paytm_kit/Stack_web_gateway_paytm_kit.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class AdditionalPaymentPay extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
       // $this->load->model('api/model/response/AddressDetails');
         $this->load->model('General_model');

        $this->load->library('encryption');
         $this->load->library('stack_web_gateway_paytm_kit/Stack_web_gateway_paytm_kit');

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
     *          name="id",
     *          parameter="additonal_payment_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/payment/additional_payment_pay/{id}",
     *     tags={"Additional Payment Pay"},
     *     operationId="putAdditionalPayment",
     *     summary="Additional Payment",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/additonal_payment_id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to add Additional Payment Details",
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
    public function payment_pay_api_ci_post()
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
                        // echo "<pre>";
                        // print_r($user_detail);
                        // exit;
                        $request = $this->post();
                        // echo $user_detail['user_id'];
                        // exit;
                        // print_r($request);

                        $id = trim($this->uri->segments['4']);
                       

                        if (!empty($id)) 
                        {
                           
                            try
                            {
                                $this->db->select('additional_payment.id,additional_payment.user_id,additional_payment.appointment_id,additional_payment.amount,additional_payment.note,additional_payment.pay_flag');
                                 $this->db->from('additional_payment');
                                
                                $this->db->where('additional_payment.user_id', $jwtUserData->user_id);
                               $this->db->where('additional_payment.appointment_id',$id);
                                $paymentPay_Details = $this->db->get()->result_array();
                              
                                    

                                if (count($paymentPay_Details) > 0) {

                                    //$member_detail = $rows[0];

                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Additional Payment Details Listed";
                                    $apiResponse->data['additional_payment'] = $paymentPay_Details;
                                    $this->response($apiResponse, REST_Controller::HTTP_OK);
                                }
                                else
                                {

                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Additional Payment Details Not Found";
                                    $apiResponse->data['additional_payment'] = null;
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
     * @OA\Post(
     *     path="/additional_payment_pay/getAddditionalPaymentToken",
     *     tags={"Additional Payment Pay"},
     *     operationId="getAdditionalPaymentToken",
     *     summary="Additional Amount",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AdditionalPaymentGetwayRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to insert amount",
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
    public function getAdditionalPaymentToken_post()
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

                        $amount = trim($request['amount']);
                        $user_id = trim($user_detail->user_id);

                        try {
                            if (!empty($amount)) {
                                // $ORDER_ID = "ORDS" . rand(10000, 99999999);
                                // $paytmParams = array();
                                // $merchantKey = 'QCevEvDvMb8Iz8Th';
                                // $merchantId = 'DITVVn99850572775009';
                                // $paytmParams['body'] = array(
                                //     'mid' => $merchantId,
                                //     'websiteName' => 'WEBSTAGING',
                                //     'chanelId' => 'WAP',
                                //     'requestType' => 'Payment',
                                //     'orderId' => $ORDER_ID,
                                //     "callbackUrl"   => "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=$ORDER_ID",
                                //     "txnAmount"     => array(
                                //         "value"     => $amount,
                                //         "currency"  => "INR",
                                //     ),
                                //     "userInfo"      => array(
                                //         "custId"    => $user_id,
                                //     ),
                                // );

                                     $ORDER_ID="ORDS" . rand(10000,99999999);
                                        $paytmParams = array();
                                        $merchantKey = 'pfAsGexeEaxl2!Y@';
                                        $merchantId = 'Nisarg88193412726992';
                                        $paytmParams['body'] = array(
                                            'mid' => $merchantId,
                                            'websiteName' => 'DEFAULT',
                                            'chanelId' => 'WAP',
                                            'requestType' => 'Payment',
                                            'orderId' => $ORDER_ID,
                                            "callbackUrl"   => "https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=$ORDER_ID",
                                            "txnAmount"     => array(
                                                "value"     => $amount,
                                                "currency"  => "INR",
                                            ),
                                            "userInfo"      => array(
                                                "custId"    => $user_id,
                                            ),
                                        );



                                $paytmChecksum = $this->stack_web_gateway_paytm_kit->generateSignature(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), $merchantKey);

                                //  $paytmChecksum = PaytmChecksum::generateSignature(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), $merchantKey);



                                // echo "<pre>";
                                // print_r($paytmChecksum);
                                //$paytmChecksum = $this->stack_web_gateway_paytm_kit->getChecksumFromArray($paytmParams, PAYTM_MERCHANT_KEY);
                                // $paytmParams["CHECKSUMHASH"] = $paytmChecksum;

                                $paytmParams['head'] = array(
                                    'signature' => $paytmChecksum,
                                );
                                // print_r()
                                $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
                                // print_r($post_data);

                                /* for Staging */
                               // $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$merchantId&orderId=$ORDER_ID";
                                 /* for Production */
                                $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=$merchantId&orderId=$ORDER_ID";

                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                                $response = json_decode(curl_exec($ch));


                                $apiResponse = new Api_Response();
                                $apiResponse->status = true;
                                $apiResponse->message = "Payment Response Data Listed";
                                //$apiResponse->data['transaction_detail'] = $address_Details;
                                $apiResponse->data = array(
                                    // 'transaction_detail' => array(
                                    'txn_token' => $response->body->txnToken,
                                    'order_id' => $ORDER_ID,
                                    // ),
                                );
                                $this->response($apiResponse, REST_Controller::HTTP_OK);
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
                                $apiResponse->message = "Please Enter Amount";
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
    /**
     * @OA\Post(
     *     path="/additional_payment_pay/setAdditionalPaymentResponse",
     *     tags={"Additional Payment Pay"},
     *     operationId="AdditionalsetPaymentResponse",
     *     summary="Additional Payment Response",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AdditionalSetPaymentResponse"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to insert payment response",
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
    public function setAdditionalPaymentResponse_post()
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
                        // echo "<pre>";
                        // print_r($request);
                        $payment_request = $request['payment_request'];
                        $user_type_id = $request['user_type_id'];
                         $id = $request['id'];
                          $appointment_id = $request['appointment_id'];
                        
                        
                        $user_id = trim($user_detail->user_id);

                        try {
                            if (isset($request['payment_request'])) {

                                //  $paymentResponse = json_decode(utf8_decode($request['paymentresponse']));

                                if ($payment_request["STATUS"] == "TXN_SUCCESS") {


                                    if($user_type_id==1)
                                    {
                                        
                                        $this->db->select('appointment_book.*');
                                        $this->db->from('appointment_book');
                                        $this->db->where('appointment_book.appointment_book_id', $appointment_id);
                                        $this->db->where('appointment_book.user_id',$user_id);
                                        $doctor_appointment= $this->db->get()->result_array();

                                         $extra_invoice = array(
                                                'list'=>"Doctor visit",
                                                'price'=>$payment_request['TXNAMOUNT'],
                                                'patient_id'=>$doctor_appointment[0]['patient_id'],
                                                'user_id'=>$user_id,
                                                'doctor_id'=>60,
                                                'appointment_book_id'=>$appointment_id,
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$doctor_appointment[0]['txnid'],
                                                'devicetype'=> '',
                                                'appmt_date'=>$doctor_appointment[0]['date'],
                                                'order_id'=>$payment_request['ORDERID'],
                                                'no_of_days'=>0,
                                                'time'=>$doctor_appointment[0]['time'],
                                                'reference_id'=>'',
                                         );
                                          if( $this->db->insert("extra_invoice",$extra_invoice))
                                          {

                                             $this->db->where('id',$id);
                                             $this->db->update('additional_payment', array('pay_flag' =>'0'));
                                         }

                                        
                                    }
                                    else if($user_type_id==2)
                                    {
                                        $this->db->select('book_nurse.*');
                                        $this->db->from('book_nurse');
                                        $this->db->where('book_nurse.book_nurse_id',$appointment_id);
                                        $this->db->where('book_nurse.user_id',$user_id);
                                        //$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                        
                                        $book_nurse_appointment= $this->db->get()->result_array();
                                        $extra_invoice = array(
                                                'list'=>"Nurse visit",
                                                'price'=>$payment_request['TXNAMOUNT'],
                                                'patient_id'=>$book_nurse_appointment[0]['patient_id'],
                                                'user_id'=>$user_id,
                                                'doctor_id'=>0,
                                                'book_nurse_id'=>$appointment_id,
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$book_nurse_appointment[0]['txnid'],
                                                'devicetype'=> '',
                                                'appmt_date'=>$book_nurse_appointment[0]['date'],
                                                'order_id'=>$payment_request['ORDERID'],
                                                'no_of_days'=>0,
                                                'time'=>$book_nurse_appointment[0]['time'],
                                                'reference_id'=>'',
                                         );
                                         if( $this->db->insert("extra_invoice",$extra_invoice))
                                          {

                                             $this->db->where('id',$id);
                                             $this->db->update('additional_payment', array('pay_flag' =>'0'));
                                         }

                                        
                                    }
                                    else if($user_type_id==3)
                                    {
                                        $this->db->select('book_laboratory_test.*');
                                        $this->db->from('book_laboratory_test');
                                        $this->db->where('book_laboratory_test.book_laboratory_test_id',$appointment_id);
                                        $this->db->where('book_laboratory_test.user_id',$user_id);
                                         $book_lab_appointment= $this->db->get()->result_array();
                                          $extra_invoice = array(
                                                'list'=>"Lab visit",
                                                'price'=>$payment_request['TXNAMOUNT'],
                                                'patient_id'=>$book_lab_appointment[0]['patient_id'],
                                                'user_id'=>$user_id,
                                                'doctor_id'=>0,
                                                'book_laboratory_test_id'=>$appointment_id,
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$book_lab_appointment[0]['txnid'],
                                                'devicetype'=> '',
                                                'appmt_date'=>$book_lab_appointment[0]['date'],
                                                'order_id'=>$payment_request['ORDERID'],
                                                'no_of_days'=>0,
                                                'time'=>$book_lab_appointment[0]['time'],
                                                'reference_id'=>'',
                                         );
                                         if( $this->db->insert("extra_invoice",$extra_invoice))
                                          {

                                             $this->db->where('id',$id);
                                             $this->db->update('additional_payment', array('pay_flag' =>'0'));
                                         }
                                        //$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                        
                                       
                                    } 
                                    else if($user_type_id==5)
                                    {
                                        $this->db->select('book_ambulance.*');
                                        $this->db->from('book_ambulance');
                                        $this->db->where('book_ambulance.book_ambulance_id',$appointment_id);
                                        $this->db->where('book_ambulance.user_id',$user_id);
                                         $book_ambulance_appointment= $this->db->get()->result_array();



                                          $extra_invoice = array(
                                                'list'=>"Ambulance visit",
                                                'price'=>$payment_request['TXNAMOUNT'],
                                                'patient_id'=>$book_ambulance_appointment[0]['patient_id'],
                                                'user_id'=>$user_id,
                                                'doctor_id'=>0,
                                                'book_ambulance_id'=>$appointment_id,
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$book_ambulance_appointment[0]['txnid'],
                                                'devicetype'=> '',
                                                'appmt_date'=>$book_ambulance_appointment[0]['date'],
                                                'order_id'=>$payment_request['ORDERID'],
                                                'no_of_days'=>0,
                                                'time'=>$book_ambulance_appointment[0]['time'],
                                                'reference_id'=>'',
                                         );
                                         if( $this->db->insert("extra_invoice",$extra_invoice))
                                          {

                                             $this->db->where('id',$id);
                                             $this->db->update('additional_payment', array('pay_flag' =>'0'));
                                         }
                                        //$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                        
                                       
                                    }
                                   
                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Additional Payment Success";
                                    $apiResponse->data = $payment_request;
                                    $this->response($apiResponse, REST_Controller::HTTP_OK);
                                } else {

                                    
                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Additional Payment Failed";
                                    $apiResponse->data = $payment_request;
                                    $this->response($apiResponse, REST_Controller::HTTP_OK);

                                    //$this->response($apiResponse, REST_Controller::HTTP_OK);

                                }
                            } else {

                                $apiResponse = new Api_Response();
                                $apiResponse->status = true;
                                $apiResponse->message = "Please Enter Payment Response";
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