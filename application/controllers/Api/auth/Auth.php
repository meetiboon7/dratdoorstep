<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class Auth extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/LoginResponse');
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
     *     path="/login",
     *     tags={"Authentication"},
     *     operationId="Login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest"),
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
    public function login_api_ci_post()
    {
        // $email =   $this->input->post('email');
        // $pass =    md5($this->input->post('password'));
        // $query = $this->Login_model->login_api($email,$pass);
        // echo json_encode($query);

        $request = $this->request->body;

        $device_token = "";

        $emailOrMobile = trim($request['email_or_mobile']);
        $pin = trim($request['pin']);
        
        if (!empty($emailOrMobile) && $pin != null) {

            $this->db->select('email,user_type_id,user_id,mobile');
            $this->db->from('user');
            $this->db->where("((email = '".$emailOrMobile."' OR mobile = '".$emailOrMobile."') And password = '" . md5($pin). "')");
            $this->db->where("(user_type_id = 99 OR user_type_id = 0)");
            //Add this line
             $this->db->where("mobile!=0");
            //Add this line
            $get_user = $this->db->get();
            //echo $this->db->last_query();


            
            $rows = $get_user->custom_result_object('User');

            $user_detail = array();
            $device_token = "";

           
            
            if(filter_var($emailOrMobile, FILTER_VALIDATE_EMAIL))
            {
                     $this->db->select('email,mobile,social_id,social_type');
                    $this->db->from('user');
                    $this->db->where('email',$emailOrMobile);
                    $this->db->where("(user_type_id = 99 OR user_type_id = 0)");
                    //Add this line
                     $this->db->where("mobile!=0");
                     //Add this line
                    $social_login_details =$this->db->get()->row_array();
                    
                     //echo $this->db->last_query();
                        
            }
            else
            {
               
                     $this->db->select('email,mobile,social_id,social_type');
                    $this->db->from('user');
                    $this->db->where('mobile',$emailOrMobile);
                    $this->db->where("(user_type_id = 99 OR user_type_id = 0)");
                    $social_login_details =$this->db->get()->row_array();
            }
            
            // echo $this->db->last_query();
            // echo "<pre>";
            // print_r($social_login_details);
            // exit;
           
            if($social_login_details['social_id']!=null && $social_login_details['social_type'] != '')
            {
                         $apiError = new Api_Response();
                        $apiError->status = false;
                       
                         $apiError->message = "This email_address is used in login with social account.Please Try Login with social account";
                        $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
            else
            {
                    if (count($rows) > 0) {

                        $user_detail = $rows[0];
                        // $user_detail = $get_user->row(0);
                        $jwtData =  $this->encryption->encrypt(json_encode(['user_id' => $user_detail->user_id ]));

                        $payload = array(
                            "iss" => "DADS",
                            "aud" => "DADS",
                            "iat" => time(),
                            "exp" => time() + $this->config->item('jwt_exp'),
                            'data' => $jwtData,
                        );
                       
                        $jwtToken = JWT::encode($payload, $this->config->item('private_key'), 'RS256');

                        $loginResponse = new LoginResponse();
                        $loginResponse->user_token = $this->encryption->encrypt($jwtToken);
                        $loginResponse->user = $user_detail;

                        $this->db->where('user_id', $user_detail->user_id);
                        $this->db->update('user', array('device_token' => $device_token));


                                     $curl = curl_init();
                                      curl_setopt_array($curl, array(
                                          CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_detail->email.'',
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
                                     // $err = curl_error($curl);
                                      curl_close($curl);
                                      if ($err) {
                                         // echo "cURL Error #:" . $err;
                                      } else {
                                            //  echo $response;
                                      }
                                        // echo "<pre>";
                                        // print_r($data);
                                        // exit;
                                        $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":143,"ActivityNote":"User Login","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$emailOrMobile.'"},{"SchemaName":"mx_Custom_2","Value":"'.number_format($emailOrMobile).'"},]}';

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
                                            //echo $json_response;
                                                curl_close($curl);
                                        } catch (Exception $ex) { 
                                             curl_close($curl);
                                        }


                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Successfully login";
                        // $data = new Data();
                        // $data->login_response = $loginResponse;
                        $apiResponse->data =  $loginResponse;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    } else {
                        $apiError = new Api_Response();
                        $apiError->status = false;
                        $apiError->message = "Either email/mobile or pin incorrect";
                        $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
                    }
            }
            // if ($get_user->num_rows()) {
            
        } else {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Parameters missing";
            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
        }
    }
    // code for login *api*-------------------------------
    /**
     * @OA\Get(
     *     path="/refresh_token",
     *     tags={"Authentication"},
     *     operationId="Refresh Token",
     *     security={{"dads_auth":{}}},
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
    public function refresh_token_ci_get()
    {
       
         $auth = $this->_head_args['Authorization'];

        if (isset($auth)) {

            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[1]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id,profile_pic');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

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

                        $loginResponse = new LoginResponse();
                        $loginResponse->user_token = $this->encryption->encrypt($jwtToken);
                         
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Token Refresh Successfully";
                        $apiResponse->data = $loginResponse;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {
                        throw new Exception("Invalid Token Data", 1);
                    }
                }
                catch (\Firebase\JWT\ExpiredException $ex)
                {
                    try{
                        JWT::$leeway = 300;
                        $jwtToken = $this->encryption->decrypt($bearer[1]);                    
                        $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                        $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));
                       
                        $jwtData =  $this->encryption->encrypt(json_encode(['user_id' => $jwtUserData->user_id ]));
                        
                        $payload = array(
                            "iss" => "DADS",
                            "aud" => "DADS",
                            "iat" => time(),
                            "exp" => time() + $this->config->item('jwt_exp'),
                            'data' => $jwtData,
                        );

                        $jwtToken = JWT::encode($payload, $this->config->item('private_key'), 'RS256');
                        JWT::$leeway = 0;

                        $loginResponse = new LoginResponse();
                        $loginResponse->user_token = $this->encryption->encrypt($jwtToken);
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "New Token Refresh Successfully";
                        $apiResponse->data = $loginResponse;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    catch (\Firebase\JWT\ExpiredException $ex){
                        $apiError = new Api_Response();
                        $apiError->status = false;
                        $apiError->message = "Invalid/unauthorized token";
                        $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED); 
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
     *     path="/social_login",
     *     tags={"Authentication"},
     *     operationId="Social Media",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SocialLoginRequest"),
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
    public function social_login_api_ci_post()
    {
        // $email =   $this->input->post('email');
        // $pass =    md5($this->input->post('password'));
        // $query = $this->Login_model->login_api($email,$pass);
        // echo json_encode($query);

                $request = $this->request->body;

                $device_token = "";

                $emailOrMobile = trim($request['email_or_mobile']);
                $device_type = trim($request['device_type']);
                $social_id = trim($request['social_id']);
                $social_type = trim($request['social_type']);
               // $pin = trim($request['pin']);
                
        if (!empty($emailOrMobile) && !empty($device_type) && !empty($social_id) && !empty($social_type)) 
        {
            // if($this->General_model->check_unique_data('user','email',$emailOrMobile) && $this->General_model->check_unique_data('user','mobile',$emailOrMobile))
            // {
                $mobilePattern = "/^[6-9][0-9]{9}$/";
                if(filter_var($emailOrMobile, FILTER_VALIDATE_EMAIL)){
                    $this->db->select('email,user_type_id,user_id,mobile,social_id');
                    $this->db->from('user');
                    $this->db->where('email',$emailOrMobile);
                    $this->db->where('social_id',$social_id);
                    $this->db->where('social_type',$social_type);
                    
                    $get_user = $this->db->get();
                        
                }
                else
                {
                    $this->db->select('email,user_type_id,user_id,mobile,social_id');
                    $this->db->from('user');
                    $this->db->where('mobile', $emailOrMobile);
                    $this->db->where('social_id',$social_id);
                     $this->db->where('social_type',$social_type);
                    $get_user = $this->db->get();
                }
                
                    $rows = $get_user->custom_result_object('User');
                    
                    $user_detail = array();
                    $device_token = "";
                    
                    if (count($rows) == 0) 
                    {
                        $apiResponse = new Api_Response();
                         $apiResponse->status = false;
                         $apiResponse->message = "Your email or mobile not found. Please register your account to sign in.";
                         $apiResponse->data =  null;
                         $this->response($apiResponse, REST_Controller::HTTP_OK);

                    }
                    else
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
    
                        $loginResponse = new LoginResponse();
                        $loginResponse->user_token = $this->encryption->encrypt($jwtToken);
                        $loginResponse->user = $user_detail;
    
                       
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Successfully login";
                        $apiResponse->data =  $loginResponse;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                
            // }
            // else
            // {
            //     $apiError = new Api_Response();
            //     $apiError->status = false;
            //     $apiError->message = "Your email or mobile is already register with us. Please use other account to login.";
            //     $apiResponse->data =  null;
            //     $this->response($apiError, REST_Controller::HTTP_CONFLICT);
            // }       
                    
        } 
        else 
        {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Parameters missing";
            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
        }
    }
    // code for login *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/forgot_api",
     *     tags={"Authentication"},
     *     operationId="Forgot Api",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ForgotRequest"),
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
    public function forgot_api_ci_post()
    {
        // $email =   $this->input->post('email');
        // $pass =    md5($this->input->post('password'));
        // $query = $this->Login_model->login_api($email,$pass);
        // echo json_encode($query);

        $request = $this->request->body;

        $device_token = "";

        $emailOrMobile = trim($request['email_or_mobile']);
        //echo $emailOrMobile;
       // $pin = trim($request['pin']);
        
        if (!empty($emailOrMobile)) {

            
            
             //$mobilePattern = "/^[6-9][0-9]{9}$/";
            if(filter_var($emailOrMobile, FILTER_VALIDATE_EMAIL)){
                $this->db->select('email,user_type_id,user_id,mobile,social_id,social_type');
            $this->db->from('user');
            $this->db->where("((email = '".$emailOrMobile."'))");
            $this->db->where("(user_type_id = 99 OR user_type_id = 0)");
            $get_user = $this->db->get();
                    
            }
            else
            {
               $this->db->select('email,user_type_id,user_id,mobile,social_id,social_type');
                $this->db->from('user');
                $this->db->where("((mobile = '".$emailOrMobile."'))");
                $this->db->where("(user_type_id = 99 OR user_type_id = 0)");
                $get_user = $this->db->get();
            }

           // echo $this->db->last_query();

            
            $rows = $get_user->custom_result_object('User');

            $user_detail = array();
            $device_token = "";
           // echo count($rows);
            // if ($get_user->num_rows()) {
            if (count($rows) > 0) {
               // eecho

                $user_detail = $rows[0];
            //      echo $user_detail->social_id;
            // echo $user_detail->social_type;
            // exit;
                // $user_detail = $get_user->row(0);
                if($user_detail->social_id != null && $user_detail->social_type!='')
                {
                     $apiError = new Api_Response();
                     $apiError->status = false;
                     $apiError->message = "This email_address is used in login with social account.Please Try Login with social account";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
                }
                else
                {
                    // echo "tete";
                    // exit;
                    $jwtData =  $this->encryption->encrypt(json_encode(['user_id' => $user_detail->user_id ]));

                    $payload = array(
                        "iss" => "DADS",
                        "aud" => "DADS",
                        "iat" => time(),
                        "exp" => time() + $this->config->item('jwt_exp'),
                        'data' => $jwtData,
                    );
                   
                    $jwtToken = JWT::encode($payload, $this->config->item('private_key'), 'RS256');

                    $loginResponse = new LoginResponse();
                    $loginResponse->user_token = $this->encryption->encrypt($jwtToken);
                    $loginResponse->user = $user_detail;

                    $this->db->where('user_id', $user_detail->user_id);
                    $this->db->update('user', array('device_token' => $device_token));


                    $rand     = rand(1000,9999);
                    $hashedPW = hash('md5', $rand);
                //echo $rand;
                // echo "<pre>";
                // print_r($user_detail);
                // echo "</pre>";
                // echo  $email=$user_detail->email;
                // exit;

                        $this->db->where('user_id', $user_detail->user_id);
                        //$this->db->update('user', array('password' => $hashedPW));
                        // echo $this->db->last_query();
                        // exit;
                        if($this->db->update('user', array('password' => $hashedPW)))
                        {
                            
                            
                            $email=$user_detail->email;
                            $mobile=$user_detail->mobile;
                            
                            $message = "Your OTP for login to DR AT DOORSTEP account is $rand . Please do not share this OTP.  
Regards Team
NISARG WELLNESS PVT LTD";


                    
                        $request =""; //initialise the request variable
                        $param[method]= "sendMessage";
                        $param[send_to] = "91".$mobile;
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
                            
                                    $this->load->library('email');


                                    // $passwordplain = "";
                                    // $passwordplain  = rand(1000,9999);
                                    // $newpass['password'] = md5($passwordplain);
                                    // $this->db->where('email', $email);
                                    // $this->db->update('user', $newpass);
                                   // $mail_message='Dear '.$user_detail->first_name.' '.$user_detail->last_name.','. "\r\n";
                                   // $mail_message.='Your new password is $rand'."\r\n";
                                    $mail_message.='Thanks for contacting regarding to forgot pin,<br> Your <b>Pin</b> is <b>'.$rand.'</b>'."\r\n";
                                    $mail_message.='<br>Please Update your password.';
                                    $mail_message.='<br>Thanks & Regards';
                                    $mail_message.='<br>Dratdoorstep';
                                    
                                    $config['protocol'] = 'sendmail';
                                    $config['mailpath'] = '/usr/sbin/sendmail';

                                    $config['mailtype'] = 'html'; // or html
                              //  $this->load->library('email');
                              //  $this->email->from('no-reply@example.com');
                                    $this->email->initialize($config);

                                    $this->email->from('info@dratdoorstep.com','Dratdoorstep');
                                    $this->email->to($email);
                                    $this->email->subject('Forgot Pin');
                                    $this->email->message($mail_message);
                                    $this->email->send();
                                      
                                    if (!empty($emailOrMobile)) 
                                    {

                                           $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Password information successfully sent to you";
                                            // $data = new Data();
                                            // $data->login_response = $loginResponse;
                                            $apiResponse->data =  $loginResponse;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else 
                                    {
                                            $apiError = new Api_Response();
                                            $apiError->status = false;
                                            $apiError->message = "Please try again";
                                            $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
                                    }
                                               // redirect(base_url());
                                            

                            }
                }
                



                


                // $apiResponse = new Api_Response();
                // $apiResponse->status = true;
                // $apiResponse->message = "Password information successfully sent to you";
                // // $data = new Data();
                // // $data->login_response = $loginResponse;
                // $apiResponse->data =  $loginResponse;
                // $this->response($apiResponse, REST_Controller::HTTP_OK);
            } else {
                $apiError = new Api_Response();
                $apiError->status = false;
                $apiError->message = "Please try again";
                $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $apiError = new Api_Response();
            $apiError->status = false;
            $apiError->message = "Parameters missing";
            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
        }
    }

     // code for login *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/change_password",
     *     tags={"Authentication"},
     *     operationId="Change Password",
      *    security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ChangePasswordRequest"),
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
    
    public function change_password_api_post()
    {
       

        $auth = $this->_head_args['Authorization'];

      //  echo $auth;


        if(isset($auth)) 
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
                           
                            
                            $user_id = trim($user_detail->user_id);
                            $request = $this->request->body;

                                $device_token = "";

                                $old_pin = trim($request['old_pin']);
                                $new_pin = trim($request['new_pin']);
                                $confirm_pin = trim($request['confirm_pin']);
                                 

                                if ($old_pin != null && $new_pin != null && $confirm_pin != null) 
                                {
                                    //$mobilePattern = "/^[6-9][0-9]{9}$/";
                                    $pinPattern = "/^[0-9]{4}$/";
                                    if(preg_match($pinPattern, $old_pin) && preg_match($pinPattern, $new_pin) && preg_match($pinPattern, $confirm_pin)) 
                                    {
                                        
                                            

                                             $this->db->select('*');
                                             $this->db->from('user');
                                             $this->db->where('user_id',$user_id);
                                             $this->db->where('password',md5($old_pin));
                                             $user_details = $this->db->get()->result_array();


                    
                                            if (count($user_details) > 0)
                                            {    

                                                 if($old_pin == $new_pin)
                                                 {
                                                        $apiResponse = new Api_Response();
                                                        $apiResponse->status = false;
                                                        $apiResponse->message = "Old Pin and New Pin can not be same.";
                                                       // $apiResponse->data['change_pin'] = null;
                                                        $this->response($apiResponse, REST_Controller::HTTP_OK); 
                                                 }
                                                 else if($new_pin==$confirm_pin) 
                                                 {

                                                        $this->db->where('user_id',$user_id);   
                                                        $this->db->update('user', array('password'=>md5($new_pin)));
                                                    
                                                            $apiResponse = new Api_Response();
                                                            $apiResponse->status = true;
                                                            $apiResponse->message = "Pin updated successfully";
                                                           // $apiResponse->data['change_pin'] = $user_details;
                                                            $this->response($apiResponse, REST_Controller::HTTP_OK);   


                                                 } 
                                                 else
                                                 {
                                                         $apiResponse = new Api_Response();
                                                        $apiResponse->status = false;
                                                        $apiResponse->message = "New Pin and Confirm Pin not matched.";
                                                       // $apiResponse->data['change_pin'] = null;
                                                        $this->response($apiResponse, REST_Controller::HTTP_OK); 
                                                 }        
                                                    
                                            }else
                                            {
                                                $apiResponse = new Api_Response();
                                                $apiResponse->status = false;
                                                $apiResponse->message = "Your old Pin is incorrect";
                                                //$apiResponse->data['change_pin'] = null;
                                                $this->response($apiResponse, REST_Controller::HTTP_OK);
                                            }
                                        
                                    }
                                    else
                                    {
                                       
                                        if(!preg_match($pinPattern,$old_pin))
                                        {
                                            $apiError = new Api_Response();
                                            $apiError->status = false;
                                            $apiError->message = "Please enter valid 4 digit Old pin";
                                            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                                        }
                                        elseif(!preg_match($pinPattern, $new_pin))
                                        {
                                            $apiError = new Api_Response();
                                            $apiError->status = false;
                                            $apiError->message = "Please enter valid 4 digit New pin";
                                            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                                        }
                                        elseif(!preg_match($pinPattern, $confirm_pin))
                                        {
                                            $apiError = new Api_Response();
                                            $apiError->status = false;
                                            $apiError->message = "Please enter valid 4 digit Confirm pin";
                                            $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                                        }
                                    }
                                }
                                else
                                {
                                    if($old_pin != null)
                                    {
                                        $apiError = new Api_Response();
                                        $apiError->status = false;
                                        $apiError->message = "Old pin Parameters missing";
                                        $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                                    }
                                   elseif($new_pin != null)
                                    {
                                        $apiError = new Api_Response();
                                        $apiError->status = false;
                                        $apiError->message = "New pin Parameters missing";
                                        $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                                    }
                                    else if($confirm_pin != null)
                                    {
                                        $apiError = new Api_Response();
                                        $apiError->status = false;
                                        $apiError->message = "Confirm pin Parameters missing";
                                        $this->response($apiError, REST_Controller::HTTP_PRECONDITION_FAILED);
                                    }

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
                    $apiError->message = "Token not found";
                    $this->response($apiError, REST_Controller::HTTP_UNAUTHORIZED);
           } 
     }

  }
}