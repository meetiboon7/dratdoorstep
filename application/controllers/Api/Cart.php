<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/stack_web_gateway_paytm_kit/Stack_web_gateway_paytm_kit.php';

use Firebase\JWT\JWT;
use OpenApi\Annotations as OA;

class Cart extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('General_model');
        $this->load->model('api/model/response/User');

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
     * @OA\Get(
     *     path="/cart",
     *     tags={"Cart"},
     *     operationId="getCart",
     *     summary="Cart Details",
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
    public function cart_api_ci_get()
    {
        $auth = $this->_head_args['Authorization'];
        // print_r($auth);
        // exit;

        if (isset($auth)) {

            $bearer = preg_split('/\s+/', $auth);

            if (count($bearer)) {
                try {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('cart.cart_id,cart.package_id,cart.user_id,cart.patient_id,cart.doctor_type_id,cart.nurse_service_id,cart.lab_test_id,cart.user_type_id,cart.appmt_type,cart.isForBook as is_for_book,cart.complain,cart.date,cart.time,cart.typeid as type_id,cart.address,cart.days,cart.timeslot as time_slot,cart.devicetype as device_type,cart.doctor_id,cart.amount,cart.prescription,cart.contactPerson as contact_person,cart.age,cart.gender,cart.mobileNumber as mobile_number,cart.landlineNumber as landline_number,cart.addressPatient as address_patient,cart.cityId as city_id,cart.type,cart.from_address,cart.to_address,cart.multi_city,member.name,user_type.user_type_name,manage_package.package_name,lab_test_type.lab_test_type_name');
                    $this->db->from('cart');
                    $this->db->join('member', 'member.member_id = cart.patient_id');
                    $this->db->join('user_type', 'user_type.user_type_id = cart.user_type_id', 'LEFT');
                    $this->db->join('manage_package', 'manage_package.package_id = cart.package_id', 'LEFT');
                     $this->db->join('lab_test_type', 'lab_test_type.lab_test_id = cart.lab_test_id', 'LEFT');
                    $this->db->where('member.user_id', $jwtUserData->user_id);
                    $this->db->where('cart.user_id', $jwtUserData->user_id);
                    //$this->db->order_by('cart.cart_id','DESC');
                    $this->db->order_by("cart.cart_id desc");

                    $cart_details = $this->db->get()->result_array();



                    //             $this->db->select('cart.*,member.name,user_type.user_type_name,manage_package.package_name');
                    // $this->db->from('cart');
                    // $this->db->join('member','member.member_id = cart.patient_id');
                    // $this->db->join('user_type','user_type.user_type_id = cart.user_type_id','LEFT');
                    // $this->db->join('manage_package','manage_package.package_id = cart.package_id','LEFT');
                    // $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
                    // //$this->db->order_by('cart.cart_id','DESC');
                    // $this->db->order_by("cart.cart_id desc");




                if (count($cart_details) > 0) {


                        foreach ($cart_details as $key => $value) {
                            $value['package_name'] = !empty($value['package_name']) ?  $value['package_name'] : "";
                             $value['lab_test_type_name'] = !empty($value['lab_test_type_name']) ?  $value['lab_test_type_name'] : "";
                            $value['date'] = !empty($value['date']) ?  date('d-m-Y',strtotime($value['date'])) : "";
                            
                             $value['prescription'] = !empty($value['prescription']) ? base_url() . 'uploads/lab_report/' . $value['prescription'] : null;
                               
                            $cart_details[$key] = $value;
                        }

                        // echo "<pre>";
                        // print_r($cart_details);
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Cart details received successfully";
                        $apiResponse->data['cart'] = $cart_details;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    } else {
                        //throw new Exception("Invalid Token Data", 1);
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Cart is empty";
                        //$apiResponse->data =null;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
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
     * @OA\Parameter(
     *      @OA\Schema(type="integer"),
     *          in="path",
     *          name="cart_id",
     *          parameter="cart_id",
     *          required=true
     * )
     *
     * @OA\Delete(
     *     path="/cart/delete/{cart_id}",
     *     tags={"Cart"},
     *     operationId="deleteCartDetails",
     *     summary="Delete Cart Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/cart_id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Delete Cart Details",
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
    public function cart_api_deleted_ci_delete()
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

                        $cart_id = trim($this->uri->segments['4']);


                        // if (!empty($name) && !empty($contact_no) && !empty($address) && !empty($city_id)) 
                        // {

                        try {
                            $this->db->where(array('cart_id' => $cart_id));
                            if ($this->db->delete('cart')) {

                                $apiResponse = new Api_Response();
                                $apiResponse->status = true;
                                $apiResponse->message = "Cart item Deleted";
                                //$apiResponse->data = $memberDetail;
                                $this->response($apiResponse, REST_Controller::HTTP_OK);
                            } else {
                                throw new Exception("Cart item not Deleted", 1);
                            }
                        } catch (\Exception $ex) {
                            $apiResponse = new Api_Response();
                            $apiResponse->status = false;
                            $apiResponse->message = $ex->getMessage();
                            $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
                        }

                        // }
                        // else
                        // {
                        //    $apiError = new Api_Response();
                        //    $apiError->status = false;
                        //    $apiError->message = "Parameters missing";
                        //    $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                        // }                        

                    } else {
                        throw new Exception("Invalid Token Data", 1);
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
     *     path="/cart/getPaymentToken",
     *     tags={"Cart"},
     *     operationId="getPaymentToken",
     *     summary="Amount",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PaymentGetwayRequest"),
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
    public function getPaymentToken_post()
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
                                //$url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$merchantId&orderId=$ORDER_ID";
                                
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
     *     path="/cart/setPaymentResponse",
     *     tags={"Cart"},
     *     operationId="setPaymentResponse",
     *     summary="Payment Response",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SetPaymentResponse"),
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
    public function setPaymentResponse_post()
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
                        $is_wallet_selected = $request['is_wallet_selected'];
                         $discount = $request['discount'];
                          $voucher_id = $request['voucher_id'];
                        
                        $user_id = trim($user_detail->user_id);

                        try {
                            if (isset($request['payment_request'])) {

                                //  $paymentResponse = json_decode(utf8_decode($request['paymentresponse']));

                                if ($payment_request["STATUS"] == "TXN_SUCCESS") {


                                     if($is_wallet_selected)
                                    {
                                         $this->db->select('balance');
                                         $this->db->from('user');
                                        $this->db->where('user_id',$user_id);
                                        $wallet_balance = $this->db->get()->row_array();  

                                        // echo "<pre>";
                                        // print_r($wallet_balance);

                                         if ($wallet_balance['balance'] == 0) 
                                         {
                                           
                                               
                                                 $final=$wallet_balance['balance']-0;
                                                  $this->db->where('user_id',$user_id);
                                                  $this->db->update('user', array('balance' => $final));

                                                
                      
                                        }
                                        else if($wallet_balance['balance'] > 50)
                                        {

                                            
                                                    $final=$wallet_balance['balance']-50;
                                                   

                                                    $this->db->where('user_id',$user_id);
                                                    $this->db->update('user', array('balance' => $final));
                                        }
                                        else
                                        {

                                           
                                                $final=$wallet_balance['balance']-$wallet_balance['balance'];
                                               

                                             $this->db->where('user_id',$user_id);
                                            $this->db->update('user', array('balance' => $final));
                                        }

                                    }
                                    
                                    if($voucher_id > 0)
                                        {

                                               $use_promo = array(
                                
                                                    'user_id'=>$user_id,
                                                    'voucher_id'=>$voucher_id
                                                   );
                                                    $this->db->insert('user_promocode_rel',$use_promo);

                                        }

                                    $this->db->select('*');
                                    $this->db->from('cart');
                                    $this->db->where('user_id', $user_id);
                                    $cart_details = $this->db->get()->result_array();
                                    // echo $this->db->last_query();

                                    $i = 0;
                                    foreach ($cart_details as $carts) {

                                        $user_type_id_fetch = $carts['user_type_id'];
                                        $cart_id = $carts['cart_id'];
                                        $package_id = $carts['package_id'];
                                        $user_id = $carts['user_id'];
                                        $patient_id = $carts['patient_id'];
                                        $date = $carts['date'];
                                        $time = $carts['time'];
                                        $doctor_type_id = $carts['doctor_type_id'];
                                        $nurse_service_id = $carts['nurse_service_id'];
                                        $lab_test_id = $carts['lab_test_id'];
                                        $address_id = $carts['address'];
                                        $contactPerson = $carts['contactPerson'];
                                        $mobileNumber = $carts['mobileNumber'];
                                        $landlineNumber = $carts['landlineNumber'];
                                        $addressPatient = $carts['addressPatient'];
                                        $cityId = $carts['cityId'];
                                        $type = $carts['type'];
                                        $age = $carts['age'];
                                        $gender = $carts['gender'];
                                        $days=$carts['days'];
                                        $amount=$carts['amount'];

                                        $from_address = $carts['from_address'];
                                        $to_address = $carts['to_address'];
                                        $condition = $carts['condition'];
                                        $multi_city = $carts['multi_city'];
                                        $prescription = $carts['prescription'];
                                        
                                        $responsestatus = $payment_request["STATUS"];
                                        $responsecode = $payment_request["RESPCODE"];
                                        $txnid = $payment_request['TXNID'];
                                        $paymentmade = $payment_request['PAYMENTMODE'];
                                        $txndate = $payment_request['TXNDATE'];
                                        $gatewayname = $payment_request['GATEWAYNAME'];
                                        $banktxnid = $payment_request['BANKTXNID'];
                                        $bankname = $payment_request['BANKNAME'];
                                        // doctor_type_id

                                        if ($user_type_id_fetch == 1 && $package_id == 0) {

                                            $doctor_appointment_array = array(
                                                'user_id' => $user_id,
                                                'patient_id' => $patient_id,
                                                'date' => $date,
                                                'time' => $time,
                                                'confirm'=>1,
                                                'discount'=>$discount,
                                                'doctor_type_id' => $doctor_type_id,
                                                'address_id' => $address_id,
                                                'order_id' => $payment_request['ORDERID'],
                                                'total' =>$amount,

                                                'responsestatus' => $responsestatus,
                                                'responsecode' => $responsecode,
                                                'txnid' => $txnid,
                                                'paymentmade' => $paymentmade,
                                                'txndate' => $txndate,
                                                'gatewayname' => $gatewayname,
                                                'banktxnid' => $banktxnid,
                                                'bankname' => $bankname,
                                                'paid_flag' => 1
                                            );
                                           // $this->db->insert("appointment_book", $doctor_appointment_array);
                                            if($this->db->insert("appointment_book",$doctor_appointment_array))
                                            {
                                                
                                                
                                                $this->db->select('member.*');
                                                     $this->db->from('member');
                                                     $this->db->where('member.member_id',$patient_id);
                                                    $patient_details = $this->db->get()->row_array();

                                    $message="Hi '".$patient_details['name']."' we have scheduled your appointment today Dt '".$date."' & Time'".$time."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
";
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
                                    
                                     $this->db->select('user.email,user.mobile');
                                                $this->db->from('user');
                                                $this->db->where('user.user_id',$user_id);
                                                $user_data = $this->db->get()->row_array();

                                         if ($user_data[email] != '') {
                                                    $curl = curl_init();

                                                    curl_setopt_array($curl, array(
                                                        CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress=' . $user_data[email] . '',
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
                                        } elseif ($user_data[mobile] != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/RetrieveLeadByPhoneNumber?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&phone=' . $user_data[mobile] . '',
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
                            }
                                       $appointment_date = date($date.' H:i:s');
                                       $appointment_time = date($date.' '.$time);
                                     
                                    $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":147,"ActivityNote":"Your Activity Note","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":"'.$complain.'"},{"SchemaName":"mx_Custom_4","Value":"'.$doctor_type_id.'"},{"SchemaName":"mx_Custom_5","Value":"'.$appointment_date.'"},{"SchemaName":"mx_Custom_6","Value":"'.date('Y-m-d H:i:s').'"},]}';
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
                                      //  echo $json_response;
                                            curl_close($curl);
                                    } catch (Exception $ex) 
                                    { 
                                        curl_close($curl);
                                    }
                                    
                                                $this->db->select('*');
                                                $this->db->from('appointment_book');
                                                $this->db->where('order_id',$payment_request['ORDERID']);
                                                $this->db->where('user_id',$user_id);
                                                $this->db->where('patient_id',$patient_id);
                                                $this->db->where('date',$date);
                                                $appointment_data = $this->db->get()->result_array();
                                                foreach($appointment_data as $appointment){

                                                     $docapmt_id = $appointment['appointment_book_id'];
                                                     // if($appointment['discount']=='')
                                                     // {
                                                     //    $amount=$payment_request['TXNAMOUNT'];
                                                     //    $discount = 0;
                                                     // }
                                                     // else
                                                     // {
                                                     //    $amount=$payment_request['TXNAMOUNT']
                                                     //    $discount = $appointment['discount'];
                                                        
                                                     // }
                                                     
                                                }



                                                $this->db->select('*');
                                                $this->db->from('doctor_type');
                                                $this->db->where('doctor_type.d_type_id',$doctor_type_id);
                                                $doctor_type = $this->db->get()->result_array();
                                                foreach($doctor_type as $doctor){

                                                     $typedoc = $doctor['doctor_type_name'];
                                                }

                                                $extra_invoice = array(
                                                        'list'=>$typedoc." Doctor visit",
                                                        'price'=>$payment_request['TXNAMOUNT'],
                                                        'patient_id'=>$patient_id,
                                                        'user_id'=>$user_id,
                                                        'doctor_id'=>60,
                                                        'appointment_book_id'=>$docapmt_id ,
                                                        'date'=>$txndate,
                                                        'discount'=>$discount,
                                                        'voucher'=>'',
                                                        'credit'=>0,
                                                         'type'=>'Paytmonline',
                                                        'txnid'=>$txnid,
                                                        'devicetype'=> '',
                                                        'appmt_date'=>$date,
                                                        'order_id'=>$payment_request['ORDERID'],
                                                        'no_of_days'=>0,
                                                        'time'=>$time,
                                                        'reference_id'=>'',
                                                    );
                                                    $this->db->insert("extra_invoice",$extra_invoice);
                                            }

                                            // echo $this->db->last_query()."<br>";
                                            // exit;
                                            $i++;
                                        }
                                        if ($user_type_id_fetch == 2 && $package_id == 0) {

                                            $nurse_appointment_array = array(
                                                'user_id' => $user_id,
                                                'patient_id' => $patient_id,
                                                'date' => $date,
                                                'time' => $time,
                                                'confirm'=>1,
                                                'discount'=>$discount,
                                                'type' => $nurse_service_id,
                                                'address_id' => $address_id,
                                                'order_id' => $payment_request['ORDERID'],
                                                'total' => $amount,
                                                'responsestatus' => $responsestatus,
                                                'responsecode' => $responsecode,
                                                'txnid' => $txnid,
                                                'paymentmade' => $paymentmade,
                                                'txndate' => $txndate,
                                                'gatewayname' => $gatewayname,
                                                'banktxnid' => $banktxnid,
                                                'bankname' => $bankname,
                                                'paid_flag' => 1
                                            );
                                            //$this->db->insert("book_nurse", $nurse_appointment_array);
                                            if($this->db->insert("book_nurse",$nurse_appointment_array))
                                            {
                                                
                                                     $this->db->select('member.*');
                                                     $this->db->from('member');
                                                     $this->db->where('member.member_id',$patient_id);
                                                    $patient_details = $this->db->get()->row_array();

                                                $message="Hi '".$patient_details['name']."' we have scheduled your appointment today Dt '".$date."' & Time'".$time."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
            ";
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
                                                
                                                        $this->db->select('user.email,user.mobile');
                                                $this->db->from('user');
                                                $this->db->where('user.user_id',$user_id);
                                                $user_data = $this->db->get()->row_array();

                                     if ($user_data[email] != '') {
                                                    $curl = curl_init();

                                                    curl_setopt_array($curl, array(
                                                        CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress=' . $user_data[email] . '',
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
                                        } elseif ($user_data[mobile] != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/RetrieveLeadByPhoneNumber?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&phone=' . $user_data[mobile] . '',
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
                            }


                                      $appointment_date = date($date.' H:i:s');
                                      $appointment_time = date($date.' '.$time);

                                      $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":150,"ActivityNote":"Nurse Appointment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":"'.$complain.'"},{"SchemaName":"mx_Custom_4","Value":"'.$nurse_service_id.'"},{"SchemaName":"mx_Custom_5","Value":"'.$appointment_date.'"},{"SchemaName":"mx_Custom_6","Value":"'.$appointment_time.'"},{"SchemaName":"mx_Custom_7","Value":"'.$days.'"},]}';
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
                                          //  echo $json_response;
                                                curl_close($curl);
                                        } catch (Exception $ex) 
                                        { 
                                            curl_close($curl);
                                        }
                                    
                                                $this->db->select('*');
                                                $this->db->from('book_nurse');
                                                $this->db->where('order_id',$payment_request['ORDERID']);
                                                $this->db->where('user_id',$user_id);
                                                $this->db->where('patient_id',$patient_id);
                                                $this->db->where('date',$date);
                                                $nurse_appointment = $this->db->get()->result_array();
                                                foreach($nurse_appointment as $appointment){

                                                     $nurseapmt_id = $appointment['book_nurse_id'];
                                                }


                                                       $this->db->select('*');
                                                    $this->db->from('nurse_service_type');
                                                    $this->db->where('nurse_service_type.nurse_service_id',$nurse_service_id);
                                                    $nurse_type = $this->db->get()->result_array();
                                                    foreach($nurse_type as $nurse){

                                                         $typenurse = $nurse['nurse_service_name'];
                                                    }
                                               
                                                

                                                 


                                                 //working progress 30/1/2021
                                                    $nurse_extra_invoice = array(
                                                        'list'=>"Nurse ".$typenurse,
                                                        'price'=>$payment_request['TXNAMOUNT'],
                                                        'patient_id'=>$patient_id,
                                                        'user_id'=>$user_id,
                                                        //'doctor_id'=>60,
                                                        'book_nurse_id'=>$nurseapmt_id ,
                                                        'date'=>$txndate,
                                                        'discount'=>$discount,
                                                        'voucher'=>'',
                                                        'credit'=>0,
                                                         'type'=>'Paytmonline',
                                                        'txnid'=>$txnid,
                                                        'devicetype'=> '',
                                                        'appmt_date'=>$date,
                                                        'order_id'=>$payment_request['ORDERID'],
                                                        'no_of_days'=>$days,
                                                        'time'=>$time,
                                                        'reference_id'=>'',
                                                    );
                                                    $this->db->insert("extra_invoice",$nurse_extra_invoice);  
                                             }
                                            //    echo $this->db->last_query()."<br>";
                                            $i++;
                                        }
                                        if ($user_type_id_fetch == 3 && $package_id == 0) {

                                            $lab_appointment_array = array(


                                                'user_id' => $user_id,
                                                'patient_id' => $patient_id,
                                                'lab_test_id' => $lab_test_id,
                                                'date' => $date,
                                                'time' => $time,
                                                'confirm'=>1,
                                                'discount'=>$discount,
                                                
                                                // 'user_type_id'=>3,
                                                // 'type'=>'',
                                                //  'confirm'=>0,
                                                //  'ipaddress'=>0,
                                                //  'cancel'=>'0000-00-00',
                                                //  'cheque_no'=>0,
                                                //  'cheque_date'=>'0000-00-00',
                                                //  'shared_address'=>'',
                                                //  'discount'=>0.00,
                                                //  'credit'=>0,

                                                 'address_id' => $address_id,
                                                 //'booked_by'=>$user_id,


                                                'order_id' => $payment_request['ORDERID'],
                                                'total' => $amount,
                                                'prescription' => $prescription,
                                                'responsestatus' => $responsestatus,
                                                'responsecode' => $responsecode,
                                                'txnid' => $txnid,
                                                'paymentmade' => $paymentmade,
                                                'txndate' => $txndate,
                                                'gatewayname' => $gatewayname,
                                                'banktxnid' => $banktxnid,
                                                'bankname' => $bankname,
                                                'paid_flag' => 1

                                            );
                                            //$this->db->insert("book_laboratory_test", $lab_appointment_array);
                                            if($this->db->insert("book_laboratory_test",$lab_appointment_array))
                                            {
                                                
                                                $this->db->select('member.*');
                                                     $this->db->from('member');
                                                     $this->db->where('member.member_id',$patient_id);
                                                    $patient_details = $this->db->get()->row_array();

                                                    $message="Hi '".$patient_details['name']."' we have scheduled your appointment today Dt '".$date."' & Time'".$time."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
                ";
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
                                                    
                                         $this->db->select('user.email,user.mobile');
                                                $this->db->from('user');
                                                $this->db->where('user.user_id',$user_id);
                                                $user_data = $this->db->get()->row_array();

                                    if ($user_data[email] != '') {
                                                    $curl = curl_init();

                                                    curl_setopt_array($curl, array(
                                                        CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress=' . $user_data[email] . '',
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
                                        } elseif ($user_data[mobile] != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/RetrieveLeadByPhoneNumber?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&phone=' . $user_data[mobile] . '',
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
                            }

                                      $appointment_date = date($date.' H:i:s');
                                      $appointment_time = date($date.' '.$time);
                                    $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":156,"ActivityNote":"Lab Book Appointment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":"'.$lab_test_id.'"},{"SchemaName":"mx_Custom_4","Value":"'.$appointment_date.'"},{"SchemaName":"mx_Custom_5","Value":"'.$appointment_time.'"},{"SchemaName":"mx_Custom_6","Value":"'.$complain_add.'"},{"SchemaName":"mx_Custom_7","Value":"'.$prescription.'"},]}';
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
                                      //  echo $json_response;
                                            curl_close($curl);
                                    } catch (Exception $ex) 
                                    { 
                                        curl_close($curl);
                                    }

                                                            $this->db->select('*');
                                                            $this->db->from('book_laboratory_test');
                                                            $this->db->where('order_id',$payment_request['ORDERID']);
                                                            $this->db->where('user_id',$user_id);
                                                            $this->db->where('patient_id',$patient_id);
                                                            $this->db->where('date',$date);
                                                            $lab_appointment = $this->db->get()->result_array();
                                                            foreach($lab_appointment as $appointment){

                                                                 $labapmt_id = $appointment['book_laboratory_test_id'];
                                                            }
                                                                $this->db->select('*');
                                                                $this->db->from('lab_test_type');
                                                                $this->db->where('lab_test_type.lab_test_id',$lab_test_id);
                                                                $lab_test_type = $this->db->get()->result_array();
                                                                foreach($lab_test_type as $lab){

                                                                     $typelab = $lab['lab_test_type_name'];
                                                                }
                                                           
                                                                //working progress 30/1/2021
                                                                $lab_extra_invoice = array(
                                                                    'list'=>$typelab." Appointment",
                                                                    'price'=>$payment_request['TXNAMOUNT'],
                                                                    'patient_id'=>$patient_id,
                                                                    'user_id'=>$user_id,
                                                                    //'doctor_id'=>60,
                                                                    'book_laboratory_test_id'=>$labapmt_id,
                                                                    'date'=>$txndate,
                                                                    'discount'=>$discount,
                                                                    'voucher'=>'',
                                                                    'credit'=>0,
                                                                     'type'=>'Paytmonline',
                                                                    'txnid'=>$txnid,
                                                                    'devicetype'=> '',
                                                                    'appmt_date'=>$date,
                                                                    'order_id'=>$payment_request['ORDERID'],
                                                                    'no_of_days'=>$days,
                                                                    'time'=>$time,
                                                                    'reference_id'=>'',
                                                                );
                                                                $this->db->insert("extra_invoice",$lab_extra_invoice);
                                            }
                                            //    echo $this->db->last_query();
                                            //    exit;
                                            $i++;
                                        }

                                        if ($user_type_id_fetch == 5 && $package_id == 0) {



                                            if ($type == 1) {
                                                $ambulance_appointment_array = array(
                                                    'patient_id' => $patient_id,
                                                    'user_id' => $user_id,
                                                    //'name'=>$contactPerson,
                                                    // 'age'=>$age,
                                                    // 'gender'=>$gender,
                                                    'mobile1' => $mobileNumber,
                                                    // 'mobile2'=>$mobileNumber,
                                                    'landline' => $landlineNumber,
                                                    'city_id' => $cityId,
                                                    'from_address' => $from_address,
                                                    'to_address' => $to_address,
                                                    //'condition' => $condition,
                                                    'date' => $date,
                                                    'time' => $time,
                                                    'type_id' => $type,
                                                    'order_id' => $payment_request['ORDERID'],
                                                    'amount' => $amount,
                                                    'discount'=>$discount,
                                                    'responsestatus' => $responsestatus,
                                                    'responsecode' => $responsecode,
                                                    'txnid' => $txnid,
                                                    'paymentmade' => $paymentmade,
                                                    'txndate' => $txndate,
                                                    'gatewayname' => $gatewayname,
                                                    'banktxnid' => $banktxnid,
                                                    'bankname' => $bankname,
                                                    'paid_flag' => 1

                                                );
                                            }
                                            if ($type == 2) {
                                                $ambulance_appointment_array = array(
                                                    'patient_id' => $patient_id,
                                                    'user_id' => $user_id,
                                                    // 'name'=>$contactPerson,
                                                    // 'age'=>$age,
                                                    // 'gender'=>$gender,
                                                    'mobile1' => $mobileNumber,
                                                    // 'mobile2'=>$mobileNumber,
                                                    'landline' => $landlineNumber,
                                                    'city_id' => $cityId,
                                                    'from_address' => $from_address,
                                                    'to_address' => $to_address,
                                                  //  'condition' => $condition,
                                                    'date' => $date,
                                                    'time' => $time,
                                                    'type_id' => $type,
                                                    'order_id' => $payment_request['ORDERID'],
                                                    'amount' =>  $amount,
                                                     'discount'=>$discount,
                                                    'responsestatus' => $responsestatus,
                                                    'responsecode' => $responsecode,
                                                    'txnid' => $txnid,
                                                    'paymentmade' => $paymentmade,
                                                    'txndate' => $txndate,
                                                    'gatewayname' => $gatewayname,
                                                    'banktxnid' => $banktxnid,
                                                    'bankname' => $bankname,
                                                    'paid_flag' => 1

                                                );
                                            }
                                            if ($type == 3) {
                                                $ambulance_appointment_array = array(
                                                    'patient_id' => $patient_id,
                                                    'user_id' => $user_id,
                                                    // 'name'=>$contactPerson,
                                                    //  'age'=>$age,
                                                    // 'gender'=>$gender,
                                                    'mobile1' => $mobileNumber,
                                                    // 'mobile2'=>$mobileNumber,
                                                    'landline' => $landlineNumber,
                                                    //'city_id'=>$post['city_id'],
                                                    'multi_city' => $multi_city,
                                                    //'date' => date('Y-m-d'),
                                                    'date' => $date,
                                                    'time' => $time,
                                                    'type_id' => $type,
                                                    'order_id' => $payment_request['ORDERID'],
                                                    'amount' =>  $amount,
                                                     'discount'=>$discount,
                                                    'responsestatus' => $responsestatus,
                                                    'responsecode' => $responsecode,
                                                    'txnid' => $txnid,
                                                    'paymentmade' => $paymentmade,
                                                    'txndate' => $txndate,
                                                    'gatewayname' => $gatewayname,
                                                    'banktxnid' => $banktxnid,
                                                    'bankname' => $bankname,
                                                    'paid_flag' => 1



                                                );
                                            }
                                           // $this->db->insert('book_ambulance', $ambulance_appointment_array);
                                            if($this->db->insert('book_ambulance', $ambulance_appointment_array)){
                                                
                                                 $this->db->select('member.*');
                                                     $this->db->from('member');
                                                     $this->db->where('member.member_id',$patient_id);
                                                    $patient_details = $this->db->get()->row_array();

                                    $message="Hi '".$patient_details['name']."' we have scheduled your appointment today Dt '".$date."' & Time'".$time."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
";
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
                                                 $book_ambulance_id = $this->db->insert_id();
                                                 if($type==1)
                                                 {
                                                    $book_ambulance_type="ONEWAY";
                                                    $date_set=$date;
                                                    $time_set=$time;
                                                 }
                                                 elseif($type==2)
                                                 {
                                                     $book_ambulance_type="Round trip";
                                                      $date_set=$date;
                                                     $time_set=$time;
                                                 }
                                                 else
                                                 {
                                                     $book_ambulance_type="Multi Location";
                                                      $date_set=date('Y-m-d');
                                                     $time_set=date($date_set.' H:i:s');
                                                 }
                                                 
                                                 
                                                  $this->db->select('user.email,user.mobile');
                                                   $this->db->from('user');
                                                   $this->db->where('user.user_id',$user_id);
                                                    $user_data = $this->db->get()->row_array();

                                     if ($user_data[email] != '') {
                                                    $curl = curl_init();

                                                    curl_setopt_array($curl, array(
                                                        CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress=' . $user_data[email] . '',
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
                                        } elseif ($user_data[mobile] != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/RetrieveLeadByPhoneNumber?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&phone=' . $user_data[mobile] . '',
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
                            }

                                    
                                    $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":153,"ActivityNote":"Book Ambulance Appointment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$mobileNumber.'"},{"SchemaName":"mx_Custom_3","Value":"'.$landlineNumber.'"},{"SchemaName":"mx_Custom_4","Value":"'.$cityId.'"},{"SchemaName":"mx_Custom_5","Value":"'.$date_set.'"},{"SchemaName":"mx_Custom_6","Value":"'.$time_set.'"},{"SchemaName":"mx_Custom_7","Value":"'.$multi_city.'"},]}';
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
                                      //  echo $json_response;
                                            curl_close($curl);
                                    } catch (Exception $ex) 
                                    { 
                                        curl_close($curl);
                                    }  
                                                 $this->db->select('user.email,user.mobile');
                                    $this->db->from('user');
                                    $this->db->where('user.user_id',$user_id);
                                    $user_data = $this->db->get()->row_array();

                                     $curl = curl_init();
                                      curl_setopt_array($curl, array(
                                          CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_data[email].'',
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

                                     $date_of_time=date($date.' H:i:s');
                                    $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":153,"ActivityNote":"Your Activity Note","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$mobileNumber.'"},{"SchemaName":"mx_Custom_3","Value":"'.$landlineNumber.'"},{"SchemaName":"mx_Custom_4","Value":"'.$cityId.'"},{"SchemaName":"mx_Custom_5","Value":"'.$date.'"},{"SchemaName":"mx_Custom_6","Value":"'.$date_of_time.'"},{"SchemaName":"mx_Custom_7","Value":"'.$multi_city.'"},]}';
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
                                      //  echo $json_response;
                                            curl_close($curl);
                                    } catch (Exception $ex) 
                                    { 
                                        curl_close($curl);
                                    }
                                                 
                                                
                                                  $ambulance_extra_invoice = array(
                                                            'list'=>$book_ambulance_type." Ambulance Appointment",
                                                            'price'=>$payment_request['TXNAMOUNT'],
                                                            'patient_id'=>$patient_id,
                                                            'user_id'=>$user_id,
                                                            //'doctor_id'=>60,
                                                            'book_ambulance_id'=>$book_ambulance_id,
                                                            'date'=>$txndate,
                                                            'discount'=>$discount,
                                                            'voucher'=>'',
                                                            'credit'=>0,
                                                             'type'=>'Paytmonline',
                                                            'txnid'=>$txnid,
                                                            'devicetype'=> '',
                                                            'appmt_date'=>$date,
                                                            'order_id'=>$payment_request['ORDERID'],
                                                            'no_of_days'=>$days,
                                                            'time'=>$time,
                                                            'reference_id'=>'',
                                                        );
                                                        $this->db->insert("extra_invoice",$ambulance_extra_invoice);

                                            }
                                            $i++;
                                        }

                                        if ($package_id != 0) {

                                            $this->db->select('*');
                                            $this->db->from('manage_package');
                                            $this->db->where('package_id', $package_id);
                                            $package_data_result = $this->db->get()->result_array();




                                            //$packageList = array();
                                            foreach ($package_data_result as $package) {

                                                $date = date('Y-m-d H:i:s');

                                                $date = strtotime($date);
                                                $expired_date = strtotime("+" . $package['validate_month'] . "day", $date);
                                                $expired_date = date('Y-m-d', $expired_date);

                                                $book_package = array(

                                                    'user_id' => $user_id,
                                                    'package_id' => $package['package_id'],
                                                    'service_id' => $user_type_id_fetch,
                                                    'purchase_date' => date('Y-m-d'),
                                                    'no_visit' => $package['no_visit'],
                                                    'available_visit' => $package['no_visit'],
                                                    'no_days' => $package['validate_month'],
                                                    'expire_date' => $expired_date,
                                                    'patient_id' => $patient_id,
                                                    'order_id' => $payment_request['ORDERID'],
                                                    'total' =>  $amount,
                                                    'responsestatus' => $responsestatus,
                                                    'responsecode' => $responsecode,
                                                    'txnid' => $txnid,
                                                    'paymentmade' => $paymentmade,
                                                    'txndate' => $txndate,
                                                    'gatewayname' => $gatewayname,
                                                    'banktxnid' => $banktxnid,
                                                    'bankname' => $bankname



                                                );
                                                $this->db->insert('book_package', $book_package);
                                            }
                                            $i++;
                                        }

                                        if ($cart_id != '') {
                                            $this->db->where('cart_id', $cart_id);
                                            $this->db->delete('cart');
                                            $i++;
                                        }







                                        // $this->db->select('*');
                                        // $this->db->from('member_id');
                                        // $this->db->where('member_id', $patient_id);
                                        // $member_details_get = $this->db->get()->result_array();

                                        // foreach ($member_details_get as $member_detail) {
                                        //     $pat_name = $p3[1];
                                        // }



                                        // $message = urlencode("You have one new appointment today! $pat_name have booked you on $date  & $time");


                                        // $this->db->select('*');
                                        // $this->db->from('sms_detail');
                                        // $sms_detail = $this->db->get()->result_array();



                                        // $smsurl = "http://" . $sms_detail[0]['host'] . "/api/pushsms?user=" . $sms_detail[0]['user_name'] . "&authkey=" . $sms_detail[0]['authkey'] . "&sender=" . $sms_detail[0]['sender_id'] . "&mobile=" . $mobile . "&text=" . $message . "&output=json";
                                        // $response = file_get_contents($smsurl);
                                    }

                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Payment Success";
                                    $apiResponse->data = $payment_request;
                                    $this->response($apiResponse, REST_Controller::HTTP_OK);
                                } else {

                                    $this->db->select('*');
                                    $this->db->from('cart');
                                    $this->db->where('user_id', $user_id);
                                    $cart_details = $this->db->get()->result_array();

                                     //echo $this->db->last_query()."<br>";
                                    $i = 0;
                                    foreach ($cart_details as $carts) {

                                        $user_type_id_fetch = $carts['user_type_id'];
                                        $cart_id = $carts['cart_id'];
                                        $package_id = $carts['package_id'];
                                        $user_id = $carts['user_id'];
                                        $patient_id = $carts['patient_id'];
                                        $date = $carts['date'];
                                        $time = $carts['time'];
                                        $doctor_type_id = $carts['doctor_type_id'];
                                        $nurse_service_id = $carts['nurse_service_id'];
                                        $lab_test_id = $carts['lab_test_id'];
                                        $address_id = $carts['address'];
                                        $contactPerson = $carts['contactPerson'];
                                        $mobileNumber = $carts['mobileNumber'];
                                        $landlineNumber = $carts['landlineNumber'];
                                        $addressPatient = $carts['addressPatient'];
                                        $cityId = $carts['cityId'];
                                        $type = $carts['type'];
                                        $age = $carts['age'];
                                        $gender = $carts['gender'];
                                        $amount=$carts['amount'];
                                        $from_address = $carts['from_address'];
                                        $to_address = $carts['to_address'];
                                        $condition = $carts['condition'];
                                        $multi_city = $carts['multi_city'];
                                        $prescription = $carts['prescription'];


                                        // $responsestatus = $_POST["STATUS"];
                                        // $responsecode = $_POST["RESPCODE"];
                                        // $txnid = $_POST['TXNID'];
                                        // $paymentmade = $_POST['PAYMENTMODE'];
                                        // $txndate = $_POST['TXNDATE'];
                                        // $gatewayname = $_POST['GATEWAYNAME'];
                                        // $banktxnid = $_POST['BANKTXNID'];
                                        // $bankname = $_POST['BANKNAME'];
                                         $responsestatus = $payment_request["STATUS"];
                                        $responsecode = $payment_request["RESPCODE"];
                                        $txnid = $payment_request['TXNID'];
                                        $paymentmade = $payment_request['PAYMENTMODE'];
                                        $txndate = $payment_request['TXNDATE'];
                                        $gatewayname = $payment_request['GATEWAYNAME'];
                                        $banktxnid = $payment_request['BANKTXNID'];
                                        $bankname = $payment_request['BANKNAME'];
                                        // doctor_type_id

                                        if ($user_type_id_fetch == 1 && $package_id == 0) {

                                            $doctor_appointment_array = array(
                                                'user_id' => $user_id,
                                                'patient_id' => $patient_id,
                                                'date' => $date,
                                                'time' => $time,
                                                'confirm'=>1,
                                                'doctor_type_id' => $doctor_type_id,
                                                'address_id' => $address_id,
                                                'order_id' => $payment_request['ORDERID'],
                                                'total' => $amount,
                                                'responsestatus' => $responsestatus,
                                                'responsecode' => $responsecode,
                                                'txnid' => $txnid,
                                                'paymentmade' => $paymentmade,
                                                'txndate' => $txndate,
                                                'gatewayname' => $gatewayname,
                                                'banktxnid' => $banktxnid,
                                                'bankname' => $bankname
                                            );
                                            $this->db->insert("appointment_book", $doctor_appointment_array);
                                            //echo $this->db->last_query()."<br>";
                                            $i++;
                                        }
                                        if ($user_type_id_fetch == 2 && $package_id == 0) {

                                            $nurse_appointment_array = array(
                                                'user_id' => $user_id,
                                                'patient_id' => $patient_id,
                                                'date' => $date,
                                                'time' => $time,
                                                'confirm'=>1,
                                                'type' => $nurse_service_id,
                                                'address_id' => $address_id,
                                                'order_id' =>  $payment_request['ORDERID'],
                                                'total' => $amount,
                                                'responsestatus' => $responsestatus,
                                                'responsecode' => $responsecode,
                                                'txnid' => $txnid,
                                                'paymentmade' => $paymentmade,
                                                'txndate' => $txndate,
                                                'gatewayname' => $gatewayname,
                                                'banktxnid' => $banktxnid,
                                                'bankname' => $bankname
                                            );
                                            $this->db->insert("book_nurse", $nurse_appointment_array);
                                            //    echo $this->db->last_query()."<br>";
                                            $i++;
                                        }
                                        if ($user_type_id_fetch == 3 && $package_id == 0) {

                                            $lab_appointment_array = array(


                                                'user_id' => $user_id,
                                                'patient_id' => $patient_id,
                                                'lab_test_id' => $lab_test_id,
                                                'date' => $date,
                                                'time' => $time,
                                                'confirm'=>1,
                                                'address_id' => $address_id,
                                                'order_id' =>  $payment_request['ORDERID'],
                                                'total' =>  $amount,
                                                'prescription' => $prescription,
                                                'responsestatus' => $responsestatus,
                                                'responsecode' => $responsecode,
                                                'txnid' => $txnid,
                                                'paymentmade' => $paymentmade,
                                                'txndate' => $txndate,
                                                'gatewayname' => $gatewayname,
                                                'banktxnid' => $banktxnid,
                                                'bankname' => $bankname

                                            );
                                            $this->db->insert("book_laboratory_test", $lab_appointment_array);

                                            $i++;
                                        }

                                        if ($user_type_id_fetch == 5 && $package_id == 0) {



                                            if ($type == 1) {
                                                $ambulance_appointment_array = array(
                                                    'patient_id' => $patient_id,
                                                    'user_id' => $user_id,
                                                    'name' => $contactPerson,
                                                    'age' => $age,
                                                    'gender' => $gender,
                                                    'mobile1' => $mobileNumber,
                                                    'mobile2' => $mobileNumber,
                                                    'landline' => $landlineNumber,
                                                    'city_id' => $cityId,
                                                    'from_address' => $from_address,
                                                    'to_address' => $to_address,
                                                    //'condition' => $condition,
                                                    'date' => $date,
                                                    'time' => $time,
                                                    'type_id' => $type,
                                                    'order_id' => $payment_request['ORDERID'],
                                                    'amount' => $amount,
                                                    'responsestatus' => $responsestatus,
                                                    'responsecode' => $responsecode,
                                                    'txnid' => $txnid,
                                                    'paymentmade' => $paymentmade,
                                                    'txndate' => $txndate,
                                                    'gatewayname' => $gatewayname,
                                                    'banktxnid' => $banktxnid,
                                                    'bankname' => $bankname

                                                );
                                            }
                                            if ($type == 2) {
                                                $ambulance_appointment_array = array(
                                                    'patient_id' => $patient_id,
                                                    'user_id' => $user_id,
                                                    'name' => $contactPerson,
                                                    'age' => $age,
                                                    'gender' => $gender,
                                                    'mobile1' => $mobileNumber,
                                                    'mobile2' => $mobileNumber,
                                                    'landline' => $landlineNumber,
                                                    'city_id' => $cityId,
                                                    'from_address' => $from_address,
                                                    'to_address' => $to_address,
                                                    //'condition' => $condition,
                                                    'date' => $date,
                                                    'time' => $time,
                                                    'type_id' => $type,
                                                    'order_id' =>$payment_request['ORDERID'],
                                                    'amount' =>  $amount,
                                                    'responsestatus' => $responsestatus,
                                                    'responsecode' => $responsecode,
                                                    'txnid' => $txnid,
                                                    'paymentmade' => $paymentmade,
                                                    'txndate' => $txndate,
                                                    'gatewayname' => $gatewayname,
                                                    'banktxnid' => $banktxnid,
                                                    'bankname' => $bankname

                                                );
                                            }
                                            if ($type == 3) {
                                                $ambulance_appointment_array = array(
                                                    'patient_id' => $patient_id,
                                                    'user_id' => $user_id,
                                                    'name' => $contactPerson,
                                                    'age' => $age,
                                                    'gender' => $gender,
                                                    'mobile1' => $mobileNumber,
                                                    'mobile2' => $mobileNumber,
                                                    'landline' => $landlineNumber,
                                                    //'city_id'=>$post['city_id'],
                                                    'multi_city' => $multi_city,
                                                    'date' => date('Y-m-d'),
                                                    'type_id' => $type,
                                                    'order_id' => $payment_request['ORDERID'],
                                                    'amount' =>$amount,
                                                    'responsestatus' => $responsestatus,
                                                    'responsecode' => $responsecode,
                                                    'txnid' => $txnid,
                                                    'paymentmade' => $paymentmade,
                                                    'txndate' => $txndate,
                                                    'gatewayname' => $gatewayname,
                                                    'banktxnid' => $banktxnid,
                                                    'bankname' => $bankname



                                                );
                                            }
                                            $this->db->insert('book_ambulance', $ambulance_appointment_array);
                                            $i++;
                                        }

                                        if ($package_id != 0) {

                                            $this->db->select('*');
                                            $this->db->from('manage_package');
                                            $this->db->where('package_id', $package_id);
                                            $package_data_result = $this->db->get()->result_array();

                                            foreach ($package_data_result as $package) {

                                                $date = date('Y-m-d H:i:s');

                                                $date = strtotime($date);
                                                $expired_date = strtotime("+" . $package['validate_month'] . "day", $date);
                                                $expired_date = date('Y-m-d', $expired_date);

                                                $book_package = array(

                                                    'user_id' => $user_id,
                                                    'package_id' => $package['package_id'],
                                                    'service_id' => $user_type_id_fetch,
                                                    'purchase_date' => date('Y-m-d'),
                                                    'no_visit' => $package['no_visit'],
                                                    'available_visit' => $package['no_visit'],
                                                    'no_days' => $package['validate_month'],
                                                    'expire_date' => $expired_date,
                                                    'patient_id' => $patient_id,
                                                    'order_id' => $payment_request['ORDERID'],
                                                    'total' =>  $amount,
                                                    'responsestatus' => $responsestatus,
                                                    'responsecode' => $responsecode,
                                                    'txnid' => $txnid,
                                                    'paymentmade' => $paymentmade,
                                                    'txndate' => $txndate,
                                                    'gatewayname' => $gatewayname,
                                                    'banktxnid' => $banktxnid,
                                                    'bankname' => $bankname



                                                );
                                                $this->db->insert('book_package', $book_package);
                                            }
                                            $i++;
                                        }
                                    }
                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Payment Failed";
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
    // code for login *api*-------------------------------
    /**
     * @OA\Parameter(
     *      @OA\Schema(type="integer"),
     *          in="path",
     *          name="id",
     *          parameter="id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/cart/doc_update/{id}",
     *     tags={"Cart"},
     *     operationId="putCart",
     *     summary="Update Doctor Cart Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DoctorCartRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Appointment Details",
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
    public function cart_doctor_api_update_ci_post()
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
                        $patient_id = trim($request['patient_id']);
                        $address_id = trim($request['address_id']);
                      //  $address = trim($request['address']);
                        $complain = trim($request['complain']);
                        $doctor_type_id = trim($request['doctor_type_id']);
                                
                        $date = trim($request['date']);
                         $time = trim($request['time']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                            
                            $this->db->select('city_id');
                            $this->db->from('member');
                            $this->db->where('member_id',$patient_id);
                            
                            $member_data = $this->db->get()->result_array();
                            foreach($member_data as $member){

                                     $city_id = $member['city_id'];
                                         
                            }
                          //  echo $city_id;

                            date_default_timezone_set("Asia/Kolkata");
         
                            $date_holiday=date('Y-m-d');
                            $this->db->select('holidays.*');
                            $this->db->from('holidays');
                            $this->db->where('hdate',$date);
                            $holiday = $this->db->get()->result_array();
        // echo $this->db->last_query();
        // echo "<pre>";
        // print_r($holiday);
        
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
         //$time= date('H:i:s');
          $time= $time;
       
         //$date=date('Y-m-d');


        //   echo $holiday[0][hdate]."==".$date;
        //   exit;
        
        
            $givendate=date('Y-m-d');
        $MyGivenDateIn = strtotime($date);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);
          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$date || ($time >=$start && $time >= $end)) {
                //echo "123";
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


                    //$amount=$doctor['fees_name'];

                    // echo "<pre>";
                    // print_r($doctor);
                    // exit;

                    //  $amount = $doctor['fees_name'];
                    //echo $doctor['fees_type_id'];
                    if($doctor['fees_type_id']==1)
                    {
                        //echo "fdsf";
                        $amount=$doctor['fees_name'];
                       // echo $amount;
                    }
                    //echo "fsfsd".$amount;
                    
                }
            }
                            $cartData = array(
                                'patient_id'=>$patient_id,
                                'address'=> $address_id,
                               // 'address'=>$address,
                                'complain'=> $complain,
                                'doctor_type_id'=> $doctor_type_id,
                                'date'=>$date,
                                'time'=>$time,
                                'amount'=>$amount,
                                'user_id' => $user_id
                            );
                            try
                            {
                                $this->db->where(array('cart_id'=>$id));
                                if($this->db->update('cart',$cartData))
                                {

                                   

                                    

                                      $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$id);

                                        $rows = $this->db->get()->result_array();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         //$rows = $get_cart->custom_result_object('Cart');
                                        // echo "<pre>";
                                        // print_r($rows);
                                        // exit;

                                    if(count($rows) > 0)
                                    {
                                       // echo "fdgsg";
                                            $doctorAppointmentDetail = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Doctor Appointment Updated Successfully";
                                            $apiResponse->data = $doctorAppointmentDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else{
                                        throw new Exception("Doctor Appointment not found", 1);
                                        
                                    }
                                }
                                else{
                                    throw new Exception("Doctor Appointment not found", 1);
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
     *          parameter="nur_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/cart/nur_update/{id}",
     *     tags={"Cart"},
     *     operationId="putCartNurse",
     *     summary="Update Nurse Cart Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/NurseCartRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Appointment Details",
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
    public function cart_nurse_api_update_ci_post()
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
                        $patient_id = trim($request['patient_id']);
                        $address_id = trim($request['address_id']);
                      //  $address = trim($request['address']);
                        $complain = trim($request['complain']);
                        $nurse_service_id = trim($request['nurse_service_id']);
                                
                        $date = trim($request['date']);
                         $time = trim($request['time']);
                         
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);
                        // echo $days;
                        // exit;
                        if (!empty($id)) 
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
                                                            $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
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
                                                            
                                                        //     echo "3";
                                                        // exit;
                                                        
                                                    }
                                                    
                                                    
                                          }
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            // $cartData = array(
                            //     'patient_id'=>$patient_id,
                            //     'address'=> $address_id,
                            //   // 'address'=>$address,
                            //     'complain'=> $complain,
                            //     'nurse_service_id'=> $nurse_service_id,
                            //     'date'=>$date,
                            //     'time'=>$time,
                            //     'user_id' => $user_id
                            // );
                            $cartData = array(
                                
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
                            try
                            {
                                $this->db->where(array('cart_id'=>$id));
                                if($this->db->update('cart',$cartData))
                                {

                                   

                                    

                                      $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$id);

                                        $rows = $this->db->get()->result_array();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         //$rows = $get_cart->custom_result_object('Cart');
                                        // echo "<pre>";
                                        // print_r($rows);
                                        // exit;

                                    if(count($rows) > 0)
                                    {
                                       // echo "fdgsg";
                                            $nurseAppointmentDetail = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Nurse Appointment Updated Successfully";
                                            $apiResponse->data = $nurseAppointmentDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else{
                                        throw new Exception("Nurse Appointment not found", 1);
                                        
                                    }
                                }
                                else{
                                    throw new Exception("Nurse Appointment not found", 1);
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
     *          parameter="lab_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/cart/lab_update/{id}",
     *     tags={"Cart"},
     *     operationId="putCartLab",
     *     summary="Update Lab Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/lab_id"
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/LabCartRequestUpdate")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Lab Details",
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
    public function cart_lab_api_update_ci_post()
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
                        $patient_id = trim($request['patient_id']);
                        $address_id = trim($request['address_id']);
                        $lab_test_id  = trim($request['lab_test_id']);
                        $date = trim($request['date']);
                        $time = trim($request['time']);
                         $complain = trim($request['complain']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);
                        //$user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                            $this->db->select('city_id');
                            $this->db->from('member');
                            $this->db->where('member_id',$patient_id);
                            
                            $member_data = $this->db->get()->result_array();
                         //   echo $this->db->last_query();
                            foreach($member_data as $member){

                                         $city_id = $member['city_id'];
                                         
                            }
                            // echo $city_id;
                            // exit;

                                   /* $this->db->select('*');
                                    $this->db->from('manage_fees');
                                    $this->db->where('manage_fees.submenu_type_id',$lab_test_id);
                                    $this->db->where('manage_fees.service_id',3);
                                     $this->db->where('manage_fees.city_id',$city_id);
                                    $fees_lab = $this->db->get()->result_array();
                                  //  echo $this->db->last_query();
                                    foreach($fees_lab as $lab){

                                         $amount = $lab['fees_name'];
                                    }*/
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
                            try
                            {
                                $this->db->where(array('cart_id'=>$id));
                                if($this->db->update('cart',$labAppointment))
                                {
                                     $this->General_model->uploadCartLabImage('./uploads/lab_report/', $id,'profile_','prescription', 'cart','prescription');
                                    // $this->General_model->uploadMemberImage('./uploads/member_profile/',$member_id,'profile_','mem_pic','member','mem_pic');

                                        $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$id);
                                        $rows = $this->db->get()->result_array();

                                    if(count($rows) > 0)
                                    {
                                        $labDetail = $rows[0];
                                        // $labDetail->prescription = isset($labDetail->prescription) ? base_url() . 'uploads/lab_report/' . $labDetail->prescription : null;

                                        $apiResponse = new Api_Response();
                                        $apiResponse->status = true;
                                        $apiResponse->message = "Lab Appointment Updated Successfully";
                                        $apiResponse->data = $labDetail;
                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else{
                                        throw new Exception("Lab Appointment not found", 1);
                                        
                                    }
                                }
                                else{
                                    throw new Exception("Lab Appointment not found", 1);
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
     *          parameter="one_way_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/cart/one_way_update/{id}",
     *     tags={"Cart"},
     *     operationId="putCartOneWay",
     *     summary="Update OneWay Cart Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/one_way_id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OneWayCartRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Appointment Details",
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
    public function cart_oneway_api_update_ci_post()
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
                       $patient_id = trim($request['patient_id']);
                        $mobile_no = trim($request['mobile_no']);
                        $landline_number = trim($request['landline_number']);
                        $city_id = trim($request['city_id']);
                        $from_address = trim($request['from_address']);
                        $to_address = trim($request['to_address']);
                        $start_date = trim($request['date']);
                        $start_time = trim($request['time']);   
                        $user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                             if($landline_number=="string")
                            {
                                $landline_number=0;
                            }
                            else
                            {
                                $landline_number=$landline_number;
                            }

                            /* $this->db->select('*');
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
        $MyGivenDateIn = strtotime($start_date);
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
                            try
                            {
                                $this->db->where(array('cart_id'=>$id));
                                if($this->db->update('cart',$ambulance_appointment_array))
                                {

                                   

                                    

                                      $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$id);

                                        $rows = $this->db->get()->result_array();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         //$rows = $get_cart->custom_result_object('Cart');
                                        // echo "<pre>";
                                        // print_r($rows);
                                        // exit;

                                    if(count($rows) > 0)
                                    {
                                       // echo "fdgsg";
                                            $oneWayAppointmentDetail = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "OneWay Appointment Updated Successfully";
                                            $apiResponse->data = $oneWayAppointmentDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else{
                                        throw new Exception("OneWay Appointment not found", 1);
                                        
                                    }
                                }
                                else{
                                    throw new Exception("OneWay Appointment not found", 1);
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
     *          parameter="round_trip_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/cart/round_trip_update/{id}",
     *     tags={"Cart"},
     *     operationId="putCartRoundTrip",
     *     summary="Update Round Trip Cart Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/round_trip_id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OneWayCartRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Appointment Details",
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
    public function cart_round_trip_api_update_ci_post()
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
                        $patient_id = trim($request['patient_id']);
                        $mobile_no = trim($request['mobile_no']);
                        $landline_number = trim($request['landline_number']);
                        $city_id = trim($request['city_id']);
                        $from_address = trim($request['from_address']);
                        $to_address = trim($request['to_address']);
                        $start_date = trim($request['date']);
                        $start_time = trim($request['time']);   
                        $user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                            if($landline_number=="string")
                            {
                                $landline_number=0;
                            }
                            else
                            {
                                $landline_number=$landline_number;
                            }
                           /* $this->db->select('*');
                            $this->db->from('manage_fees');
                            $this->db->where('manage_fees.submenu_type_id',2);
                            $this->db->where('manage_fees.service_id',5);
                            $this->db->where('manage_fees.city_id',$city_id);
                            $fees_roundtrip = $this->db->get()->result_array();
                          
                            foreach($fees_roundtrip as $roundtrip){

                                 $amount = $roundtrip['fees_name'];
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
               
                $this->db->where('manage_fees.submenu_type_id',2);
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
                            try
                            {
                                $this->db->where(array('cart_id'=>$id));
                                if($this->db->update('cart',$ambulance_appointment_array))
                                {

                                   

                                    

                                      $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$id);

                                        $rows = $this->db->get()->result_array();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         //$rows = $get_cart->custom_result_object('Cart');
                                        // echo "<pre>";
                                        // print_r($rows);
                                        // exit;

                                    if(count($rows) > 0)
                                    {
                                       // echo "fdgsg";
                                            $roundTripAppointmentDetail = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Round Trip Appointment Updated Successfully";
                                            $apiResponse->data = $roundTripAppointmentDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else{
                                        throw new Exception("Round Trip Appointment not found", 1);
                                        
                                    }
                                }
                                else{
                                    throw new Exception("Round Trip Appointment not found", 1);
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
     *          parameter="multi_location_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/cart/multi_location_update/{id}",
     *     tags={"Cart"},
     *     operationId="putCartMultiLocation",
     *     summary="Update Multi Location Cart Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/multi_location_id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MultiLocationCartRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Appointment Details",
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
    public function cart_multi_location_api_update_ci_post()
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
                        $patient_id = trim($request['patient_id']);
                       // $multi_location = trim($request['multi_location']);
                        $mobile_no = trim($request['mobile_no']);
                        $landline_number = trim($request['landline_number']);
                        $city_id = trim($request['city_id']);
                        $start_date = trim($request['date']);
                        $start_time = trim($request['time']);
                        $multi_location = trim($request['multi_location']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($id)) 
                        {
                            if($landline_number=="string")
                            {
                                $landline_number=0;
                            }
                            else
                            {
                                $landline_number=$landline_number;
                            }
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
                            try
                            {
                                $this->db->where(array('cart_id'=>$id));
                                if($this->db->update('cart',$ambulance_appointment_array))
                                {

                                   

                                    

                                      $this->db->select('cart_id');
                                        $this->db->from('cart');
                                        $this->db->where('cart_id',$id);

                                        $rows = $this->db->get()->result_array();

                                        //$rows = $get_cart->custom_result_object('AppointmentType');
                                         //$rows = $get_cart->custom_result_object('Cart');
                                        // echo "<pre>";
                                        // print_r($rows);
                                        // exit;

                                    if(count($rows) > 0)
                                    {
                                       // echo "fdgsg";
                                            $roundTripAppointmentDetail = $rows[0];
                                           // $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Multi Location Appointment Updated Successfully";
                                            $apiResponse->data = $roundTripAppointmentDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else{
                                        throw new Exception("Multi Location Appointment not found", 1);
                                        
                                    }
                                }
                                else{
                                    throw new Exception("Multi Location Appointment not found", 1);
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
