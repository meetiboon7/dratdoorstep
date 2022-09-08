<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class Member extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
        $this->load->model('api/model/response/MemberProfile');
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
     *     path="/member/get",
     *     tags={"Members"},
     *     operationId="getMemberDetails",
     *     summary="Member Record",
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
    
    public function member_api_get_ci_get()
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

                    $this->db->select('member.member_id,member.user_id,member.name,member.contact_no,member.city_id,member.gender,member.date_of_birth,member.mem_pic,member.patient_code,city.city');
                     $this->db->from('member');
                     $this->db->join('city','city.city_id = member.city_id');  
                     $this->db->where('user_id', $jwtUserData->user_id);
                     $this->db->where('member.status',1);
                    $member_Details = $this->db->get()->result_array();


                   
                    
                   // $rows = $get_user->custom_result_object('User');

                    if (count($member_Details) > 0) {

                        //$member_detail = $rows[0];
                        foreach ($member_Details as $key => $value) {
                            $value['mem_pic'] = !empty($value['mem_pic']) ? base_url() . 'uploads/member_profile/' . $value['mem_pic'] : null;
                            $value['date_of_birth']=date("d-m-Y",strtotime($value['date_of_birth']));
                            $member_Details[$key] = $value;
                        }
                        
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Member Record Listed";
                        $apiResponse->data['member'] = $member_Details;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Member record not found";
                        $apiResponse->data['member'] =null;
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
    // code for login *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/member/add",
     *     tags={"Members"},
     *     operationId="postMemberProfile",
     *     summary="Add Member Profile",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/MemberRequest"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to insert member profile",
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
    public function member_api_add_ci_post()
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

                        $name = trim($request['name']);
                        $contact_no = trim($request['contact_no']);
                        //$address = trim($request['address']);
                        $city_id = trim($request['city_id']);
                        $gender = trim($request['gender']);
                                
                        $date_of_birth = trim($request['date_of_birth']);

                        $city = $this->db->get_where('city', array('city_id'=>$city_id))->row_array();
                        // echo "<pre>";
                        // print_r($city);
                        // echo "</pre>";
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($name) && !empty($contact_no)  && !empty($city_id)) 
                        {
                            $memberData = array(
                                'name'=>$name,
                                'contact_no'=> $contact_no,
                                //'address'=>$address,
                                'city_id'=> $city_id,
                                'gender'=> $gender,
                                'date_of_birth'=>$date_of_birth,
                                'user_id' => $user_id
                            );
                            try
                            {
                                if($this->db->insert('member', $memberData))
                                {
                                    $memberId = $this->db->insert_id();

                                    $patient_code=$city['city_code'].date("y").$memberId;
        
                                    $this->db->where('member_id', $memberId);
                                   


                                    if($this->db->update('member', array('patient_code' => $patient_code)))
                                    {
                                         // $response['status'] = "0";
                                         // $response['message'] = "Something went wrong";


                                        $this->General_model->uploadMemberImage('./uploads/member_profile/',$memberId,'profile_','mem_pic','member','mem_pic');

                                   

                                        $this->db->select('member.member_id,member.user_id,member.name,member.contact_no,member.city_id,member.gender,member.date_of_birth,member.mem_pic,member.patient_code');
                                        $this->db->from('member');
                                        $this->db->where('member.member_id', $memberId);

                                        $get_user = $this->db->get();
                                       
                                        $rows = $get_user->custom_result_object('MemberProfile');

                                        if(count($rows) > 0)
                                        {

                                          //  $memberDetail = $rows[0];
                                          //  $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $memberDetail = $rows[0];
                                           /*echo "<pre>";
                                           print_r($memberDetail);*/
                                            $memberDetail->mem_pic = isset($memberDetail->mem_pic) ? base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic : null;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Member Profile Add Successfully";
                                            $apiResponse->data['member'] = $memberDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Member Profile not added", 1);
                                            
                                        }
                                    }
                                    else
                                    {
                                        throw new Exception($this->upload->display_errors(), 1);
                                    }
                                    
                                }
                                else
                                {
                                    throw new Exception("Member Profile not added", 1);
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
     *          name="member_id",
     *          parameter="member_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/member/update/{member_id}",
     *     tags={"Members"},
     *     operationId="putMemberProfile",
     *     summary="Update Member Profile",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/member_id"
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/MemberRequestUpdate")
     *         )
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
    public function member_api_update_ci_post()
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

                        $member_id = trim($this->uri->segments['4']);
                        $name = trim($request['name']);
                        $contact_no = trim($request['contact_no']);
                      //  $address = trim($request['address']);
                        $city_id = trim($request['city_id']);
                        $gender = trim($request['gender']);
                                
                        $date_of_birth = trim($request['date_of_birth']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($name) && !empty($contact_no)  && !empty($city_id)) 
                        {
                            $memberData = array(
                                'name'=>$name,
                                'contact_no'=> $contact_no,
                               // 'address'=>$address,
                                'city_id'=> $city_id,
                                'gender'=> $gender,
                                'date_of_birth'=>$date_of_birth,
                                'user_id' => $user_id
                            );
                            try
                            {
                                $this->db->where(array('member_id'=>$member_id));
                                if($this->db->update('member',$memberData))
                                {

                                    $this->General_model->uploadMemberImage('./uploads/member_profile/',$member_id,'profile_','mem_pic','member','mem_pic');

                                    $this->db->select('member.member_id,member.user_id,member.name,member.contact_no,member.city_id,member.gender,member.date_of_birth,member.mem_pic,member.patient_code');
                                    $this->db->from('member');
                                    $this->db->where('member.member_id', $member_id);

                                    $get_user = $this->db->get();

                                    $rows = $get_user->custom_result_object('MemberProfile');

                                    if(count($rows) > 0)
                                    {
                                        $memberDetail = $rows[0];
                                        $memberDetail->mem_pic = isset($memberDetail->mem_pic) ? base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic : null;

                                        $apiResponse = new Api_Response();
                                        $apiResponse->status = true;
                                        $apiResponse->message = "Member Profile Updated Successfully";
                                        $apiResponse->data['member'] = $memberDetail;
                                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                                    }
                                    else{
                                        throw new Exception("Member profile not found", 1);
                                        
                                    }
                                }
                                else{
                                    throw new Exception("Member profile not found", 1);
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
     * @OA\Delete(
     *     path="/member/delete/{member_id}",
     *     tags={"Members"},
     *     operationId="deleteMemberProfile",
     *     summary="Delete Member Profile",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/member_id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Delete member profile",
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
     public function member_api_delete_ci_delete()
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

                        $member_id = trim($this->uri->segments['4']);
                       

                        // if (!empty($name) && !empty($contact_no) && !empty($address) && !empty($city_id)) 
                        // {
                            
                            try
                            {
                                $this->db->where(array('member_id'=>$member_id));
                                if($this->db->update('member', array('status' => '0')))
                                {
                                        
                                          
                                            $this->db->where(array('patient_id'=>$member_id));
                                            $this->db->delete('cart');
                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Member Profile Deleted Successfully";
                                            //$apiResponse->data = $memberDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        
                                    
                                    
                                }
                                else
                                {
                                    throw new Exception("Member Profile not Deleted", 1);
                                }
                            }
                            catch (\Exception $ex)
                            {
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