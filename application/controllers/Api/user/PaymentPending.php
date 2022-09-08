<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/stack_web_gateway_paytm_kit/Stack_web_gateway_paytm_kit.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class PaymentPending extends REST_Controller
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

   


     /**
     * @OA\Post(
     *     path="/get_payment_pending/getPaymentPendingToken",
     *     tags={"Payment Pending"},
     *     operationId="getPaymentPendingToken",
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
    public function getPaymentPendingToken_post()
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
     *     path="/set_payment_pending/setPaymentPendingResponse",
     *     tags={"Payment Pending"},
     *     operationId="setPendingPaymentResponse",
     *     summary="Pending Payment Response",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SetPendingPaymentResponse"),
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
    public function setPaymentPendingResponse_post()
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
                        
                          $appointment_id = $request['appointment_id'];
                        
                        
                        $user_id = trim($user_detail->user_id);

                        try {
                            if (isset($request['payment_request'])) {

                                //  $paymentResponse = json_decode(utf8_decode($request['paymentresponse']));

                                if ($payment_request["STATUS"] == "TXN_SUCCESS") {

                                    $responsestatus=$payment_request["STATUS"];
                                     $responsecode=$payment_request["RESPCODE"];
                                     $txnid=$payment_request['TXNID'];
                                     $paymentmade=$payment_request['PAYMENTMODE'];
                                     $txndate=$payment_request['TXNDATE'];
                                     $gatewayname=$payment_request['GATEWAYNAME'];
                                     $banktxnid=$payment_request['BANKTXNID'];
                                     $bankname=$payment_request['BANKNAME'];
                                    if($user_type_id==1)
                                    {
                                        
                                       $this->db->where('appointment_book_id',$appointment_id);
                                       $this->db->update('appointment_book', array('paid_flag' => 1,'responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));

                                        
                                    }
                                    else if($user_type_id==2)
                                    {
                                         $this->db->where('book_nurse_id',$appointment_id);
                                         $this->db->update('book_nurse', array('paid_flag' => 1,'responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));

                                        
                                    }
                                    else if($user_type_id==3)
                                    {
                                       $this->db->where('book_laboratory_test_id',$appointment_id);
                                        $this->db->update('book_laboratory_test', array('paid_flag' => 1,'responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                                        
                                       
                                    } 
                                    else if($user_type_id==5)
                                    {
                                        $this->db->where('book_ambulance_id',$appointment_id);
                                        $this->db->update('book_ambulance', array('paid_flag' => 1,'responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                                        //$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                        
                                       
                                    }
                                   
                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Pending Payment Success";
                                    $apiResponse->data = $payment_request;
                                    $this->response($apiResponse, REST_Controller::HTTP_OK);
                                } else {

                                        $responsestatus=$payment_request["STATUS"];
                                     $responsecode=$payment_request["RESPCODE"];
                                     $txnid=$payment_request['TXNID'];
                                     $paymentmade=$payment_request['PAYMENTMODE'];
                                     $txndate=$payment_request['TXNDATE'];
                                     $gatewayname=$payment_request['GATEWAYNAME'];
                                     $banktxnid=$payment_request['BANKTXNID'];
                                     $bankname=$payment_request['BANKNAME'];
                                    if($user_type_id==1)
                                    {
                                        
                                       $this->db->where('appointment_book_id',$appointment_id);
                                       $this->db->update('appointment_book', array('paid_flag' => '0','responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));

                                        
                                    }
                                    else if($user_type_id==2)
                                    {
                                         $this->db->where('book_nurse_id',$appointment_id);
                                         $this->db->update('book_nurse', array('paid_flag' => '0','responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));

                                        
                                    }
                                    else if($user_type_id==3)
                                    {
                                       $this->db->where('book_laboratory_test_id',$appointment_id);
                                        $this->db->update('book_laboratory_test', array('paid_flag' => '0','responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                                        
                                       
                                    } 
                                    else if($user_type_id==5)
                                    {
                                        $this->db->where('book_ambulance_id',$appointment_id);
                                        $this->db->update('book_ambulance', array('paid_flag' => '0','responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                                        //$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
                                        
                                       
                                    }
                                    
                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Pending Payment Failed";
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