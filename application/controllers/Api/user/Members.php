<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;   
class Members extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();

       $this->load->database();

        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
        $this->load->model('api/model/response/MemberProfile');
         $this->load->model('General_model');
         $this->load->library('encryption');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function member_data_get()
	{
        $auth = $this->_head_args['Authorization'];
        // print_r($auth);
        // exit;

        if (isset($auth)) {
            $data=array();
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[0]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);
                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));



                    $this->db->select('*');
                     $this->db->from('member');
                     $this->db->where('user_id', $jwtUserData->user_id);
                    $member_Details = $this->db->get()->result_array();;
                   
                 //   $rows = $get_user->custom_result_object('MemberProfile');


                    if (count($member_Details) > 0) {

                        //$user_detail = $rows[0];

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Successfully Listed";
                        $apiResponse->data['member'] = $member_Details;
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
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function member_data_insert_post()
    {
        $auth = $this->_head_args['Authorization'];
        

        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    $jwtToken = $this->encryption->decrypt($bearer[0]);

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
                        $address = trim($request['address']);
                        $city_id = trim($request['city_id']);
                        $gender = trim($request['gender']);
                                
                        $date_of_birth = trim($request['date_of_birth']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($name) && !empty($contact_no) && !empty($address) && !empty($city_id)) 
                        {
                            $memberData = array(
                                'name'=>$name,
                                'contact_no'=> $contact_no,
                                'address'=>$address,
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

                                    if($this->General_model->uploadMemberImage('./uploads/member_profile/',$memberId,'profile_','mem_pic','member','mem_pic'))
                                    {
                                        

                                        $this->db->select('*');
                                        $this->db->from('member');
                                        $this->db->where('member_id', $memberId);

                                        $get_user = $this->db->get();

                                        $rows = $get_user->custom_result_object('MemberProfile');

                                        if(count($rows) > 0)
                                        {
                                            $memberDetail = $rows[0];
                                            $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Member Profile Add Successfully";
                                            $apiResponse->data = $memberDetail;
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
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function member_data_update_post()
    {
       $auth = $this->_head_args['Authorization'];
        
       
        if (isset($auth)) 
        {
            $bearer = preg_split('/\s+/', $auth);
           
            if(count($bearer))
            {
                try
                {
                    // echo "<pre>";
                    // print_r($bearer);
                    // echo "</pre>";
                    $jwtToken = $this->encryption->decrypt($bearer[0]);

                    $jwtData = JWT::decode($jwtToken, $this->config->item('public_key'), ['RS256']);

                    $jwtUserData = json_decode($this->encryption->decrypt($jwtData->data));
                    // echo "hii";
                    // exit;
                    $this->db->select('first_name,last_name,mobile,email,user_type_id,user_id');
                    $this->db->from('user');
                    $this->db->where('user_id', $jwtUserData->user_id);
                    $get_user = $this->db->get();
                   
                    $rows = $get_user->custom_result_object('User');

                    if (count($rows) > 0) {

                        $user_detail = $rows[0];

                   
                        $request = $this->post();
                       
                        $member_id = trim($request['member_id']);
                        $name = trim($request['name']);
                        $contact_no = trim($request['contact_no']);
                        $address = trim($request['address']);
                        $city_id = trim($request['city_id']);
                        $gender = trim($request['gender']);
                                
                        $date_of_birth = trim($request['date_of_birth']);
                        // $mem_pic = trim($request['mem_pic']);
                       $user_id = trim($user_detail->user_id);

                        if (!empty($name) && !empty($contact_no) && !empty($address) && !empty($city_id)) 
                        {
                            $memberData = array(
                                'name'=>$name,
                                'contact_no'=> $contact_no,
                                'address'=>$address,
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
                                    //$memberId = $member_id;

                                    if($this->General_model->uploadMemberImage('./uploads/member_profile/',$member_id,'profile_','mem_pic','member','mem_pic'))
                                    {
                                         // $response['status'] = "0";
                                         // $response['message'] = "Something went wrong";

                                        $this->db->select('*');
                                        $this->db->from('member');
                                        $this->db->where('member_id', $member_id);

                                        $get_user = $this->db->get();

                                        $rows = $get_user->custom_result_object('MemberProfile');

                                        if(count($rows) > 0)
                                        {
                                            $memberDetail = $rows[0];
                                            $memberDetail->mem_pic = base_url() . 'uploads/member_profile/' . $memberDetail->mem_pic;

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Member Profile Add Successfully";
                                            $apiResponse->data = $memberDetail;
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
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('employee_master', array('emp_id'=>$id));
       
        $this->response(['Employee deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}