<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use Firebase\JWT\JWT;
use OpenApi\Annotations as OA;

class Profile extends REST_Controller
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
    

    /**
     * @OA\Get(
     *     path="/profile",
     *     tags={"User"},
     *     operationId="getMyProfile",
     *     summary="User Profile",
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
    public function profile_api_ci_get()
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

                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id,profile_pic');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();

                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];
                        $user_detail->profile_pic = $user_detail->profile_pic != null ? base_url() . 'uploads/user_profile/' . $user_detail->profile_pic : null;
                        $user_detail->first_name = $user_detail->first_name != null ?  $user_detail->first_name : "";
                         $user_detail->last_name = $user_detail->last_name != null ?  $user_detail->last_name : "";
                         
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Successfully login";
                        $apiResponse->data['profile'] = $user_detail;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
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
     *          name="user_id",
     *          parameter="user_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/profile/update",
     *     tags={"User"},
     *     operationId="putUserProfile",
     *     summary="Update User Profile",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/ProfileRequestUpdate")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update user profile",
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
    public function profile_api_update_ci_post()
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

                        $request = $this->post();

                        $first_name = trim($request['first_name']);
                        $last_name = trim($request['last_name']);
                        $email = trim($request['email']);
                        $mobile = trim($request['mobile']);
                        $profile_pic = $_FILES['profile_pic'];
                        try {
                            if (!empty($first_name)) 
                            {
                                $profileData = array(
                                    'first_name'=>$first_name,
                                    'user_id' => $jwtUserData->user_id
                                );
                            } else if (!empty($last_name)) {
                                $profileData = array(
                                    'last_name' => $last_name,
                                    'user_id' => $jwtUserData->user_id
                                );
                            }
                            else if (!empty($email)) {
                                $profileData = array(
                                    'email' => $email,
                                    'user_id' => $jwtUserData->user_id
                                );
                            }
                            else if (!empty($mobile)) {
                                $profileData = array(
                                    'mobile' => $mobile,
                                    'user_id' => $jwtUserData->user_id
                                );
                            } else if ($profile_pic != null) {
                                
                                if ($this->General_model->uploadImage('./uploads/user_profile/', $jwtUserData->user_id, 'profile_', 'profile_pic', 'user', 'profile_pic')) {
                                } else {
                                    throw new Exception($this->upload->display_errors(), 1);
                                }
                            } 
                            if($profile_pic == null)
                            {
                                $this->db->where('user_id', $jwtUserData->user_id);
                                if ($this->db->update('user', $profileData)) {
                                } else {
                                    throw new Exception("Profile not Updated", 1);
                                }
                            }

                            $this->db->select('user_id,user_type_id,first_name,last_name,profile_pic,mobile,email');
                            $this->db->from('user');
                            $this->db->where('user_id', $jwtUserData->user_id);

                            $get_profile = $this->db->get();


                            $rows = $get_profile->custom_result_object('User');
                            
                            if (count($rows) > 0) {
                                $user_details = $rows[0];
                                $user_details->profile_pic = base_url() . 'uploads/user_profile/' . $user_details->profile_pic;

                                $apiResponse = new Api_Response();
                                $apiResponse->status = true;
                                $apiResponse->message = "Profile Updated Successfully";
                                $apiResponse->data["profile"] = $user_details;
                                $this->response($apiResponse, REST_Controller::HTTP_OK);
                            } else {
                                throw new Exception("Profile not Updated", 1);
                            } 
                            
                        } catch (\Exception $ex) {
                            $apiResponse = new Api_Response();
                            $apiResponse->status = false;
                            $apiResponse->message = $ex->getMessage();
                            $this->response($apiResponse, REST_Controller::HTTP_BAD_REQUEST);
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
