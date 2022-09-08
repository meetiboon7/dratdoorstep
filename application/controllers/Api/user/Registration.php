<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class Registration extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/Registration_Response');
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

    

    // code for login *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/registration",
     *     tags={"Authentication"},
     *     operationId="Registration",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegistrationRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Either email or password incorrect",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    
    public function registration_api_ci_post()
    {
        // $email =   $this->input->post('email');
        // $pass =    md5($this->input->post('password'));
        // $query = $this->Login_model->login_api($email,$pass);
        // echo json_encode($query);

        $request = $this->request->body;
        $referal = $this->General_model->genRandomString();

        $device_token = "";

        $email = trim($request['email']);
        $mobile = trim($request['mobile']);
        $pin = trim($request['pin']);
        $confirm_pin = trim($request['confirm_pin']);
        $referral_code = trim($request['referral_code']);
        $city_id = trim($request['city_id']);
        
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('mobile',$mobile);
        $check_user_details = $this->db->get()->result_array();
    if(count($check_user_details) < 1) 
    {
        
        if (!empty($email) && $mobile != null && $pin != null && $confirm_pin != null && !empty($city_id)) 
        {
            $mobilePattern = "/^[6-9][0-9]{9}$/";
            $pinPattern = "/^[0-9]{4}$/";
            if(filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match($mobilePattern, $mobile) && preg_match($pinPattern, $pin))
            {
                if($this->General_model->check_unique_data('user','email',$email) && $this->General_model->check_unique_data('user','mobile',$mobile))
            {
                    if($pin != $confirm_pin){
                        // echo "fdsg";
                        // exit;
                         $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Pin and Confirm pin doesn't match";
                       // $apiResponse->data['change_pin'] = null;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {




                    if (empty($referral_code)) {
                       
                        $userData = array(
                        'email'=>$email,
                        'mobile'=> $mobile ,
                        'password'=>md5($pin),
                        'referral_code'=>$referal,
                        'used_referral'=>0,
                        'times'=>5,
                        'balance'=>0,
                        'register_date'=>date('Y-m-d H:i:s'),
                        'user_type_id'=>99,
                        'city_id'=>$city_id,
                        );
                         
                        if($this->db->insert('user', $userData))
                        {     

                             $this->db->select('email,user_type_id,user_id,mobile');
                            $this->db->from('user');
                            $this->db->where('user_id', $this->db->insert_id());
                            $get_user = $this->db->get();
                            $rows = $get_user->custom_result_object('User');


                           /* $message1 = urlencode("Your referral code is $referal. Share it with your friends & relatives! If they register with it they will get Rs.125 in Health Wallet.");

                            $this->db->select('*');
                            $this->db->from('sms_detail');
                            $sms_detail = $this->db->get()->result_array();

                            $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message1."&output=json";
                            $response = file_get_contents($smsurl);*/


                            $message1 ="Refer DR AT DOORSTEP & Earn 30/- on each( max.5 refer). Use referral code $referal. Team Nisarg Wellness Pvt Ltd.";

                                $request =""; //initialise the request variable
                                $param[method]= "sendMessage";
                                $param[send_to] = "91".$post['mobile'];
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


                           

                          
                    //  $get_user = $this->db->get_where('r_users', array('id'=>$this->db->insert_id(), 'u_status'=>3));

                        $user_detail = array();
                        
                        if(count($rows) > 0)
                        {
                            try
                            {
                                $user_detail = $rows[0];
                            
                                $jwtData =  $this->encryption->encrypt(json_encode(['user_id' => $user_detail->user_id ]));

                                $payload = array(
                                    "iss" => "DADS",
                                    "aud" => "DADS",
                                    "iat" => time(),
                                    "exp" => time() + $this->config->item('jwt_exp'),
                                    'data' => $jwtData,
                                );
                        
                                $jwtToken = JWT::encode($payload, $this->config->item('private_key'), 'RS256');

                                $registrationResponse = new Registration_Response();
                                $registrationResponse->user_token = $this->encryption->encrypt($jwtToken);
                                $registrationResponse->user = $user_detail;

                                $this->db->where('user_id', $user_detail->user_id);
                                $this->db->update('user', array('device_token' => $registrationResponse->userToken));

                                          

/*$data_string = '[{"Attribute":"FirstName","Value":""},{Attribute": "Source", "Value": "Mobile"},{"Attribute":"LastName","Value":""},{"Attribute":"EmailAddress","Value":"'.$email.'"},{"Attribute":"Phone","Value":"'.$mobile.'"},{"Attribute":"ProspectID","Value":""},{"Attribute":"SearchBy","Value":"Mobile"}]';
// echo "<pre>";
// print_r($data_string);
try
{
$curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
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
// echo $json_response;
// exit;
    curl_close($curl);
} catch (Exception $ex) { 
    curl_close($curl);
}*/


$data_string = '[{"Attribute":"FirstName","Value":""},{"Attribute":"LastName","Value":""},{"Attribute":"EmailAddress","Value":"'.$email.'"},{"Attribute":"Phone","Value":"'.$mobile.'"},{"Attribute":"ProspectID","Value":"xxxxxxxx-d168-xxxx-9f8b-xxxx97xxxxxx"},{"Attribute":"Source","Value":"Mobile"}]';
try
{
$curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
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
//echo $json_response;
    curl_close($curl);
} catch (Exception $ex) { 
    curl_close($curl);
}



                                $apiResponse = new Api_Response();
                                $apiResponse->status = true;
                                $apiResponse->message = "Successfully Registration";
                    
                                $apiResponse->data =  $registrationResponse;
                                $this->response($apiResponse, REST_Controller::HTTP_OK);
                            }
                            catch (\Exception $ex)
                            {
                                $apiError = new Api_Response();
                                $apiError->status = false;
                                $apiError->message = $ex->getMessage();
                                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                            }
                        }
                        else
                        {
                            
                            $apiError = new Api_Response();
                            $apiError->status = false;
                            $apiError->message = "Something went wrong";
                            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
                        }
                      }
                    }
                    else
                    {
                        //refereall
                            $this->db->select('user.*');
                            $this->db->from('user');
                            $this->db->where('user.referral_code',$referral_code);
                            $this->db->where('user.times >',0);
                            $refereall_code_check = $this->db->get()->result_array();
                            // echo $this->db->last_query();
                            // exit;
                            if(count($refereall_code_check) == 1) 
                            {
                                $referral_user=$refereall_code_check[0][user_id];
                                $referral_bal=$refereall_code_check[0][balance];
                                $referral_times=$refereall_code_check[0][times];

                                
                                 $userData = array(
                                    'email'=>$email,
                                    'mobile'=> $mobile ,
                                    'password'=>md5($pin),
                                    'referral_code'=>$referal,
                                    'used_referral'=>$referral_user,
                                    'times'=>5,
                                    'balance'=>30,
                                    'register_date'=>date('Y-m-d H:i:s'),
                                    'user_type_id'=>99,
                                    'city_id'=>$city_id,
                                );

                               // $insert =$this->db->insert('user', $userData);
                                if($this->db->insert('user', $userData))
                                {     

                                     $this->db->select('email,user_type_id,user_id,mobile');
                                    $this->db->from('user');
                                    $this->db->where('user_id', $this->db->insert_id());
                                    $get_user = $this->db->get();
                                    $rows = $get_user->custom_result_object('User');

                                     $final_bal   = $referral_bal + 30;
                                     $final_times = $referral_times - 1;
                                     $this->db->where('user_id',$referral_user);
                                     $this->db->update('user', array('balance' =>$final_bal,'times' =>$final_times));

                                   /* $message1 = urlencode("Your referral code is $referal. Share it with your friends & relatives! If they register with it they will get Rs.125 in Health Wallet.");

                                    $this->db->select('*');
                                    $this->db->from('sms_detail');
                                    $sms_detail = $this->db->get()->result_array();

                                    $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message1."&output=json";
                                    $response = file_get_contents($smsurl);*/

                                    $message1 ="Refer DR AT DOORSTEP & Earn 50/- on each( max.5 refer). Use referral code $referal. Team Nisarg Wellness Pvt Ltd.";

                                    $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$post['mobile'];
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


                                   


                   

                                    $user_detail = array();
                                    
                                    if(count($rows) > 0)
                                    {
                                        try
                                        {
                                            $user_detail = $rows[0];
                                        
                                            $jwtData =  $this->encryption->encrypt(json_encode(['user_id' => $user_detail->user_id ]));

                                            $payload = array(
                                                "iss" => "DADS",
                                                "aud" => "DADS",
                                                "iat" => time(),
                                                "exp" => time() + $this->config->item('jwt_exp'),
                                                'data' => $jwtData,
                                            );
                                    
                                            $jwtToken = JWT::encode($payload, $this->config->item('private_key'), 'RS256');

                                            $registrationResponse = new Registration_Response();
                                            $registrationResponse->user_token = $this->encryption->encrypt($jwtToken);
                                            $registrationResponse->user = $user_detail;

                                            $this->db->where('user_id', $user_detail->user_id);
                                            $this->db->update('user', array('device_token' => $registrationResponse->userToken));

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
              $data_st = json_decode($response, TRUE);
              //json convert
              $err = curl_error($curl);
              curl_close($curl);
              if ($err) {
                  //echo "cURL Error #:" . $err;
              } else {
                  //    echo $response;
              }

$data_string = '[{"Attribute":"FirstName","Value":""},{"Attribute":"LastName","Value":""},{"Attribute":"EmailAddress","Value":"'.$email.'"},{"Attribute":"Phone","Value":"'.$mobile.'"},{"Attribute":"ProspectID","Value":"'.$data_st[0]['ProspectID'].'"},{"Attribute":"SearchBy","Value":"Mobile"}]';
// echo "<pre>";
// print_r($data_string);
try
{
$curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
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
// echo $json_response;
// exit;
    curl_close($curl);
} catch (Exception $ex) { 
    curl_close($curl);
}
                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Successfully Registration";
                                
                                            $apiResponse->data =  $registrationResponse;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        catch (\Exception $ex)
                                        {
                                            $apiError = new Api_Response();
                                            $apiError->status = false;
                                            $apiError->message = $ex->getMessage();
                                            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                                        }
                                    }
                                    else
                                    {
                                        
                                        $apiError = new Api_Response();
                                        $apiError->status = false;
                                        $apiError->message = "Something went wrong";
                                        $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
                                    }
                                }
                        } 
                        else 
                        {


                           
                             $userData = array(
                                    'email'=>$email,
                                    'mobile'=> $mobile ,
                                    'password'=>md5($pin),
                                    'referral_code'=>$referal,
                                    'used_referral'=>0,
                                    'times'=>0,
                                    'balance'=>0,
                                    'register_date'=>date('Y-m-d H:i:s'),
                                    'user_type_id'=>99,
                                    'city_id'=>$city_id,
                                );
                             if($this->db->insert('user', $userData))
                                {     
                                    $this->db->select('email,user_type_id,user_id,mobile');
                                    $this->db->from('user');
                                    $this->db->where('user_id', $this->db->insert_id());
                                    $get_user = $this->db->get();
                                    $rows = $get_user->custom_result_object('User');

                                    //  $message1 = urlencode("Your referral code is $referal. Share it with your friends & relatives! If they register with it you both will get Rs.50 in Health Wallet.");
                    
                                    // $this->db->select('*');
                                    // $this->db->from('sms_detail');
                                    // $sms_detail = $this->db->get()->result_array();

                                    // $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message1."&output=json";
                                    // $response = file_get_contents($smsurl);
                                     $message1 ="Refer DR AT DOORSTEP & Earn 50/- on each( max.5 refer). Use referral code $referal. Team Nisarg Wellness Pvt Ltd.";

                                        $request =""; //initialise the request variable
                                        $param[method]= "sendMessage";
                                        $param[send_to] = "91".$post['mobile'];
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

                                    


                   

                                    $user_detail = array();
                                    
                                    if(count($rows) > 0)
                                    {
                                        try
                                        {
                                            $user_detail = $rows[0];
                                        
                                            $jwtData =  $this->encryption->encrypt(json_encode(['user_id' => $user_detail->user_id ]));

                                            $payload = array(
                                                "iss" => "DADS",
                                                "aud" => "DADS",
                                                "iat" => time(),
                                                "exp" => time() + $this->config->item('jwt_exp'),
                                                'data' => $jwtData,
                                            );
                                    
                                            $jwtToken = JWT::encode($payload, $this->config->item('private_key'), 'RS256');

                                            $registrationResponse = new Registration_Response();
                                            $registrationResponse->user_token = $this->encryption->encrypt($jwtToken);
                                            $registrationResponse->user = $user_detail;

                                            $this->db->where('user_id', $user_detail->user_id);
                                            $this->db->update('user', array('device_token' => $registrationResponse->userToken));

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
                                              $data_st = json_decode($response, TRUE);
                                              //json convert
                                              $err = curl_error($curl);
                                              curl_close($curl);
                                              if ($err) {
                                                  //echo "cURL Error #:" . $err;
                                              } else {
                                                  //    echo $response;
                                              }

                                            $data_string = '[{"Attribute":"FirstName","Value":""},{"Attribute":"LastName","Value":""},{"Attribute":"EmailAddress","Value":"'.$email.'"},{"Attribute":"Phone","Value":"'.$mobile.'"},{"Attribute":"ProspectID","Value":"'.$data_st[0]['ProspectID'].'"},{"Attribute":"SearchBy","Value":"Mobile"}]';
                                            // echo "<pre>";
                                            // print_r($data_string);
                                            try
                                            {
                                            $curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
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
                                            // echo $json_response;
                                            // exit;
                                                curl_close($curl);
                                            } catch (Exception $ex) { 
                                                curl_close($curl);
                                            }
                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Successfully Registration";
                                
                                            $apiResponse->data =  $registrationResponse;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        catch (\Exception $ex)
                                        {
                                            $apiError = new Api_Response();
                                            $apiError->status = false;
                                            $apiError->message = $ex->getMessage();
                                            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                                        }
                                    }
                                    else
                                    {
                                        
                                        $apiError = new Api_Response();
                                        $apiError->status = false;
                                        $apiError->message = "Something went wrong";
                                        $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
                                    }
                                }
                         
                            
                        }
                    }
                }
                   
            }
                else
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "User Already Registered with Email / Mobile No";
                    $this->response($apiError, REST_Controller::HTTP_CONFLICT);
                }
            }
            else
            {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Please enter valid email-id";
                    $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                }
                else if(!preg_match($mobilePattern, $mobile))
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Please enter valid mobile";
                    $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                }
                else if(!preg_match($pinPattern, $pin))
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Please enter valid 4 digit pin";
                    $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                }
            }
        }
        else
        {
            if(!empty($email))
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "email Parameters missing";
                $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            }
            else if($mobile != null)
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "mobile Parameters missing";
                $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            }
            else if($pin != null)
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "pin Parameters missing";
                $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            }
        }
    }
    else
    {
        $apiError = new Api_Response();
        $apiError->status = false;
        $apiError->message = "User Already Registered with Email / Mobile No";
        $this->response($apiError, REST_Controller::HTTP_CONFLICT);
    }

    }
    // code for login *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/social_registration",
     *     tags={"Authentication"},
     *     operationId="Social Registration",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SocialRegistrationRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Either email or password incorrect",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Parameters missing",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     * )
     */
    
    public function social_registration_api_ci_post()
    {
        // $email =   $this->input->post('email');
        // $pass =    md5($this->input->post('password'));
        // $query = $this->Login_model->login_api($email,$pass);
        // echo json_encode($query);

        $request = $this->request->body;

        $device_token = "";

        $email = trim($request['email']);
        $mobile = trim($request['mobile']);
        $referral_code = trim($request['referral_code']);
        $city_id = trim($request['city_id']);

        $device_type = trim($request['device_type']);
        $social_id = trim($request['social_id']);
        $social_type = trim($request['social_type']);
        
        if (!empty($email) && $mobile != null &&  !empty($city_id) && !empty($device_type) && !empty($social_id) && !empty($social_type)) 
        {
            $mobilePattern = "/^[6-9][0-9]{9}$/";
            $pinPattern = "/^[0-9]{4}$/";
            if(filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match($mobilePattern, $mobile))
            {
                if($this->General_model->check_unique_data('user','email',$email) && $this->General_model->check_unique_data('user','mobile',$mobile))
                {
                    // if($pin != $confirm_pin){
                       
                    //      $apiResponse = new Api_Response();
                    //     $apiResponse->status = true;
                    //     $apiResponse->message = "Pin and Confirm pin doesn't match";
                       
                    //     $this->response($apiResponse, REST_Controller::HTTP_OK);
                    // }
                    // else
                    // {
                        $userData = array(
                        'email'=>$email,
                        'mobile'=> $mobile ,
                        'password'=>"",
                        'referral_code'=>$referral_code,
                        'user_type_id'=>99,
                        'city_id'=>$city_id,
                        'device_type'=> $device_type,
                        'social_id'=> $social_id,
                        'social_type' =>$social_type,

                        );
                        
                        if($this->db->insert('user', $userData))
                        {                   
                            $this->db->select('email,user_type_id,user_id,mobile');
                            $this->db->from('user');
                            $this->db->where('user_id', $this->db->insert_id());
                            $get_user = $this->db->get();
                            $rows = $get_user->custom_result_object('User');


                    //  $get_user = $this->db->get_where('r_users', array('id'=>$this->db->insert_id(), 'u_status'=>3));

                        $user_detail = array();
                        
                        if(count($rows) > 0)
                        {
                            try
                            {
                                $user_detail = $rows[0];
                            
                                $jwtData =  $this->encryption->encrypt(json_encode(['user_id' => $user_detail->user_id ]));

                                $payload = array(
                                    "iss" => "DADS",
                                    "aud" => "DADS",
                                    "iat" => time(),
                                    "exp" => time() + $this->config->item('jwt_exp'),
                                    'data' => $jwtData,
                                );
                        
                                $jwtToken = JWT::encode($payload, $this->config->item('private_key'), 'RS256');

                                $registrationResponse = new Registration_Response();
                                $registrationResponse->user_token = $this->encryption->encrypt($jwtToken);
                                $registrationResponse->user = $user_detail;

                                $this->db->where('user_id', $user_detail->user_id);
                                $this->db->update('user', array('device_token' => $registrationResponse->userToken));
                                
                                
                                 $data_string = '[{"Attribute":"FirstName","Value":""},{"Attribute":"LastName","Value":""},{"Attribute":"EmailAddress","Value":"' . $email . '"},{"Attribute":"Phone","Value":"' . $mobile . '"},{"Attribute":"ProspectID","Value":"xxxxxxxx-d168-xxxx-9f8b-xxxx97xxxxxx"},{"Attribute":"Source","Value":"Mobile"}]';
                                try {
                                    $curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28');
                                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($curl, CURLOPT_HEADER, 0);
                                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                        "Content-Type:application/json",
                                        "Content-Length:" . strlen($data_string)
                                    ));
                                    $json_response = curl_exec($curl);
                                    //echo $json_response;
                                    curl_close($curl);
                                } catch (Exception $ex) {
                                    curl_close($curl);
                                }


                                $apiResponse = new Api_Response();
                                $apiResponse->status = true;
                                $apiResponse->message = "Successfully Registration";
                    
                                $apiResponse->data =  $registrationResponse;
                                $this->response($apiResponse, REST_Controller::HTTP_OK);
                            }
                            catch (\Exception $ex)
                            {
                                $apiError = new Api_Response();
                                $apiError->status = false;
                                $apiError->message = $ex->getMessage();
                                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);   
                            }
                        }
                        else
                        {
                            
                            $apiError = new Api_Response();
                            $apiError->status = false;
                            $apiError->message = "Something went wrong";
                            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
                        }
                      }
                    //}
                   
                    

                    
                }
                else
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "User Already Registered with Email / Mobile No";
                    $this->response($apiError, REST_Controller::HTTP_CONFLICT);
                }
            }
            else
            {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Please enter valid email-id";
                    $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                }
                else if(!preg_match($mobilePattern, $mobile))
                {
                    $apiError = new Api_Response();
                    $apiError->status = false;
                    $apiError->message = "Please enter valid mobile";
                    $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                }
                
            }
        }
        else
        {
            if(!empty($email))
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "email Parameters missing";
                $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            }
            else if($mobile != null)
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "mobile Parameters missing";
                $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            }
            else if(!empty($city_id))
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "city Parameters missing";
                $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            }
            else if($device_type != null)
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Device Type Parameters missing";
                $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            }
            else if($social_id != null)
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Social Id Parameters missing";
                $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            }
            else if($social_type != null)
            {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Social Type Parameters missing";
                $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            }
            // else if($pin != null)
            // {
            //     $apiError = new Api_Response();
            //     $apiError->status = false;
            //     $apiError->message = "pin Parameters missing";
            //     $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
            // }
        }

    }
}