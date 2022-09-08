<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/stack_web_gateway_paytm_kit/Stack_recharge_gateway_paytm_kit.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class Wallet extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
       // $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
        $this->load->model('api/model/response/WalletDetails');
         $this->load->model('General_model');

        $this->load->library('encryption');
        $this->load->library('stack_web_gateway_paytm_kit/Stack_recharge_gateway_paytm_kit');

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
     *     path="/wallet/get",
     *     tags={"Wallet"},
     *     operationId="getWallet",
     *     summary="get Wallet",
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
    public function wallet_api_get_ci_get()
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
                    
                    $this->db->select('balance');
                     $this->db->from('user');
                     $this->db->where('user_id', $jwtUserData->user_id);
                    $wallet_balance = $this->db->get()->row_array();
                    //print_r($address_Details);
                   // $rows = $get_user->custom_result_object('User');

                    if (count($wallet_balance) > 0) {

                      //  $member_detail = $rows[0];

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Wallet Balance Listed";
                        $apiResponse->data = $wallet_balance;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Wallet Balance Not Found";
                         $apiResponse->data = null;
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
     * @OA\Get(
     *     path="/wallet_deduction/get",
     *     tags={"Wallet"},
     *     operationId="getWalletDeduction",
     *     summary="Wallet Deduction",
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
    public function wallet_deduction_api_get_ci_get()
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
                    



                    

                     $this->db->select_sum('amount');
                     $this->db->from('cart');
                     $this->db->where('user_id', $jwtUserData->user_id);
                     $deduct_wallet_balance = $this->db->get()->row_array();


                      

                    $this->db->select('balance');
                     $this->db->from('user');
                     $this->db->where('user_id', $jwtUserData->user_id);
                    $wallet_balance = $this->db->get()->row_array();

                   
                    // echo $wallet_balance['balance'];
                    // exit;
                    if ($wallet_balance['balance'] == 0) {
                        
                         $final=$deduct_wallet_balance[amount];
                         
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "You dont have enough balance";
                       $apiResponse->data= array(
                                  'amount_deducted' => 0,
                                  'amount' => $final,
                                   
                                );
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                      //  exit;
                    }
                    else if($wallet_balance['balance'] > 75)
                    {
                                $final=$deduct_wallet_balance[amount]-75;
                                $dis=75;

                                $apiResponse = new Api_Response();
                                $apiResponse->status = true;
                                $apiResponse->message = "Wallet amount successfully deducted";
                                $apiResponse->data= array(
                                      'amount_deducted' => $dis,
                                      'amount' => $final,
                                       
                                    );
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {
                            $final=$deduct_wallet_balance[amount]-$wallet_balance['balance'];
                            $dis=$wallet_balance['balance'];

                                $apiResponse = new Api_Response();
                            $apiResponse->status = true;
                            $apiResponse->message = "Wallet amount successfully deducted";
                            $apiResponse->data= array(
                                  'amount_deducted' => $dis,
                                  'amount' => $final,
                                   
                                );
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
     *     path="/wallet/getWalletPaymentToken",
     *     tags={"Wallet"},
     *     operationId="getWalletPaymentToken",
     *     summary="Wallet Amount",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PaymentWalletGetwayRequest"),
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
    public function getWalletPaymentToken_post()
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
                    
                    if (count($rows) > 0) 
                    {

                        $user_detail = $rows[0];

                        $request = $this->post();

                        $amount = trim($request['amount']);
                        $user_id = trim($user_detail->user_id);
                            
                        try
                            {
                                if (!empty($amount)) 
                                {
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


                                        
                                       
                                        
                                    $paytmChecksum = $this->stack_recharge_gateway_paytm_kit->generateSignature(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES),$merchantKey);

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
                                       // Staging Environment: https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=<order_id>
                                        //Production Environment: https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=<order_id>
    
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
                                        $apiResponse->data= array(
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
                                } 
                                else 
                                {
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
     *     path="/wallet/setWalletPaymentRequest",
     *     tags={"Wallet"},
     *     operationId="setWalletPaymentRequest",
     *     summary="Wallet Payment",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SetWalletPaymentRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to insert wallet payment request",
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
    public function setWalletPaymentRequest_post()
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
                    
                    if (count($rows) > 0) 
                    {

                        $user_detail = $rows[0];

                        $request = $this->post();
                       

                        $wallet_payment_request =$request['payment_request'];
                       
                        $user_id = trim($user_detail->user_id);
                        $ORDER_ID=$wallet_payment_request["ORDERID"];
                        $tot=$wallet_payment_request["TXNAMOUNT"];
                        $TXNID=$wallet_payment_request["TXNID"];
                        $TXNDATE=$wallet_payment_request["TXNDATE"];
                        $BANKTXNID=$wallet_payment_request["BANKTXNID"];
                        $RESPCODE=$wallet_payment_request["RESPCODE"];
                        $STATUS=$wallet_payment_request["STATUS"];
                        $BANKNAME=$wallet_payment_request["BANKNAME"];
                        $PAYMENTMODE=$wallet_payment_request["PAYMENTMODE"];
                        $GATEWAYNAME=$wallet_payment_request["GATEWAYNAME"];
                            
                        try
                            {
                                if (isset($request['payment_request']))
                                {

                                    //  $paymentResponse = json_decode(utf8_decode($request['paymentresponse']));
                                      
                                    if ($wallet_payment_request["STATUS"] == "TXN_SUCCESS") 
                                    {

                                        //  $this->db->select('*');
                                        // $this->db->from('recharge');
                                        // $this->db->where('order_id',$wallet_payment_request["ORDERID"]);
                                        // $recharge_details = $this->db->get()->result_array();

                                            

                                            function get_client_ip()
                                            {
                                                $ipaddress = '';
                                                if (getenv('HTTP_CLIENT_IP'))
                                                    $ipaddress = getenv('HTTP_CLIENT_IP');
                                                else if (getenv('HTTP_X_FORWARDED_FOR'))
                                                    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                                                else if (getenv('HTTP_X_FORWARDED'))
                                                    $ipaddress = getenv('HTTP_X_FORWARDED');
                                                else if (getenv('HTTP_FORWARDED_FOR'))
                                                    $ipaddress = getenv('HTTP_FORWARDED_FOR');
                                                else if (getenv('HTTP_FORWARDED'))
                                                    $ipaddress = getenv('HTTP_FORWARDED');
                                                else if (getenv('REMOTE_ADDR'))
                                                    $ipaddress = getenv('REMOTE_ADDR');
                                                else
                                                    $ipaddress = 'UNKNOWN';
                                                return $ipaddress;
                                            }
                                            $ip     = ip2long(get_client_ip());

                                            $recharge_array = array(
                                                'amt'=>$tot,
                                                'order_id' => $ORDER_ID,
                                                'user_id'=>$user_id,
                                                'total'=>$tot,
                                                'txnid'=>$TXNID,
                                                'txndate'=>$TXNDATE,
                                                'banktxnid'=>$BANKTXNID,
                                                'responsecode'=>$RESPCODE,
                                                'responsestatus'=>$STATUS,
                                                'bankname'=>$BANKNAME,
                                                'paymentmade'=>$PAYMENTMODE,
                                                'gatewayname'=>$GATEWAYNAME,
                                                'ipaddress'=>$ip,
                                                
                                                //'e_created_on'=>date('Y-m-d H:i:s')
                                            );
                                            if($this->db->insert('recharge', $recharge_array))
                                            {

                                                    $this->db->select('*');
                                                    $this->db->from('user');
                                                    $this->db->where('user_id',$user_id);
                                                    $user_details = $this->db->get()->result_array();

                                                    foreach($user_details as $user){ 

                                                         $mobile = $user['mobile'];
                                                         $email  = $user['email'];
                                                         $bal  = $user['balance'];
                                                    }

                                                    $final_bal=$bal + $tot ;

                                                     $this->db->where('user_id',$user_id);
                                                     $this->db->update('user', array('balance' => $final_bal));
                                        
                                                    $message1 ="Congratulations Your health wallet has been recharged with Rs $tot in DR AT DOORSTEP. Team Nisarg Wellness Pvt Ltd.";


                                                        $request =""; //initialise the request variable
                                                        $param[method]= "sendMessage";
                                                        $param[send_to] = "91".$mobile;
                                                        $param[msg] = $message1;
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

                                                     /* $message = urlencode("Congratulations Your health wallet has been recharged with Rs $tot.");
                                    
                                                      

                                                        $this->db->select('*');
                                                       $this->db->from('sms_detail');
                                                        $sms_detail = $this->db->get()->result_array();



                                                        $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
                                                        $response = file_get_contents($smsurl);*/
                                    
                                            }
                                               

                                                    $apiResponse = new Api_Response();
                                                    $apiResponse->status = true;
                                                    $apiResponse->message = "Payment Success";
                                                    $apiResponse->data = $wallet_payment_request;
                                                    $this->response($apiResponse, REST_Controller::HTTP_OK);

                                    }
                                    else
                                    {
                                      
                                                    function get_client_ip()
                                                    {
                                                        $ipaddress = '';
                                                        if (getenv('HTTP_CLIENT_IP'))
                                                            $ipaddress = getenv('HTTP_CLIENT_IP');
                                                        else if (getenv('HTTP_X_FORWARDED_FOR'))
                                                            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                                                        else if (getenv('HTTP_X_FORWARDED'))
                                                            $ipaddress = getenv('HTTP_X_FORWARDED');
                                                        else if (getenv('HTTP_FORWARDED_FOR'))
                                                            $ipaddress = getenv('HTTP_FORWARDED_FOR');
                                                        else if (getenv('HTTP_FORWARDED'))
                                                            $ipaddress = getenv('HTTP_FORWARDED');
                                                        else if (getenv('REMOTE_ADDR'))
                                                            $ipaddress = getenv('REMOTE_ADDR');
                                                        else
                                                            $ipaddress = 'UNKNOWN';
                                                        return $ipaddress;
                                                    }
                                                    $ip     = ip2long(get_client_ip());
                                                  

                                                        $recharge_array = array(
                                                            'amt'=>$tot,
                                                            'order_id' => $ORDER_ID,
                                                            'user_id'=>$user_id,
                                                            'total'=>$tot,
                                                            'txnid'=>$TXNID,
                                                            'txndate'=>$TXNDATE,
                                                            'banktxnid'=>$BANKTXNID,
                                                            'responsecode'=>$RESPCODE,
                                                            'responsestatus'=>$STATUS,
                                                            'bankname'=>$BANKNAME,
                                                            'paymentmade'=>$PAYMENTMODE,
                                                            'gatewayname'=>$GATEWAYNAME,
                                                            'ipaddress'=>$ip,
                                                            
                                                            //'e_created_on'=>date('Y-m-d H:i:s')
                                                        );

                                                        $this->db->insert('recharge', $recharge_array);  
                                        
                                                    $apiResponse = new Api_Response();
                                                    $apiResponse->status = true;
                                                    $apiResponse->message = "Payment Failed";
                                                    $apiResponse->data = $wallet_payment_request;
                                                    $this->response($apiResponse, REST_Controller::HTTP_OK);
                                       
                                        //$this->response($apiResponse, REST_Controller::HTTP_OK);
                                       
                                    } 
                               
                        
                            }
                            else 
                            {
                                      
                                        $apiResponse = new Api_Response();
                                        $apiResponse->status = true;
                                        $apiResponse->message = "Please Enter Payment data";
                                        $apiResponse->data = null;
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