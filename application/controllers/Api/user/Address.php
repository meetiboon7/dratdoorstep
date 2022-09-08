<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class Address extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
        $this->load->model('api/model/response/User');
        $this->load->model('api/model/response/AddressDetails');
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
     *     path="/address/get",
     *     tags={"Address"},
     *     operationId="getAddressDetails",
     *     summary="get Address Details",
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
    public function address_api_get_ci_get()
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
                    
                    $this->db->select('add_address.address_id,add_address.city_id,add_address.address_1,add_address.user_id,add_address.address_2,add_address.state_id,add_address.state_id,add_address.country_id,add_address.status,add_address.pincode,city.city,state.state,country.country_name');
                     $this->db->from('add_address');
                     $this->db->join('city','city.city_id = add_address.city_id','LEFT');
                     $this->db->join('state','state.state_id = add_address.state_id','LEFT');
                      $this->db->join('country','country.country_id = add_address.country_id');
                     $this->db->where('add_address.user_id', $jwtUserData->user_id);
                     $this->db->where('add_address.status',1);
                    $address_Details = $this->db->get()->result_array();
                  
                    // $this->db->select('add_address.*,city.city,state.state,country.country_name');
                    // $this->db->from('add_address');
                    // $this->db->join('city','city.city_id = add_address.city_id');   
                    // $this->db->join('state','state.state_id = add_address.state_id');  
                    // $this->db->join('country','country.country_id = add_address.country_id');  
                    // $this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
                    // $this->db->where('add_address.status','1');
                    // $this->db->order_by('add_address.address_id', 'DESC');
                    // $address_Details = $this->db->get()->result_array();

                    // echo $this->db->last_query();
                    // exit;
                    //print_r($address_Details);
                   // $rows = $get_user->custom_result_object('User');

                    if (count($address_Details) > 0) {

                        //$member_detail = $rows[0];
                         foreach ($address_Details as $key => $value) {
                            $value['pincode'] = !empty($value['pincode']) ? $value['pincode'] : null;
                            //$value['date_of_birth']=date("d-m-Y",strtotime($value['date_of_birth']));
                            $address_Details[$key] = $value;
                        }

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Address Record Listed";
                        $apiResponse->data['address'] = $address_Details;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Address Not Found";
                        $apiResponse->data['address'] = null;
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
    // code for Address *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/address/add",
     *     tags={"Address"},
     *     operationId="postAddress",
     *     summary="Add Address Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AddressRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to insert Address profile",
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
    public function address_api_add_ci_post()
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

                        $address_1 = trim($request['address_1']);
                        $address_2 = trim($request['address_2']);
                        $city_id = trim($request['city_id']);
                        $state_id = trim($request['state_id']);
                        $country_id = trim($request['country_id']);
                        $pincode=trim($request['pincode']);       
                        
                        $user_id = trim($user_detail->user_id);

                        if (!empty($address_1) && !empty($address_2) && !empty($city_id) && !empty($state_id) && !empty($country_id) && !empty($pincode)) 
                        {
                            $addressData = array(
                                'address_1'=>$address_1." ",
                                'address_2'=> $address_2." ",
                                'city_id'=>$city_id,
                                'state_id'=> $state_id,
                                'country_id'=> $country_id,
                                'pincode'=>$pincode,
                                'user_id' => $user_id
                            );
                            try
                            {
                                if($this->db->insert('add_address', $addressData))
                                {
                                    $address_id = $this->db->insert_id();

                                    
                                         // $response['status'] = "0";
                                         // $response['message'] = "Something went wrong";

                                        $this->db->select('*');
                                        $this->db->from('add_address');
                                        $this->db->where('address_id', $address_id);

                                        $get_address = $this->db->get();

                                        $rows = $get_address->custom_result_object('AddressDetails');

                                        if(count($rows) > 0)
                                        {
                                            $addressDetail = $rows[0];
                                            
                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Address Add Successfully";
                                            $apiResponse->data = $addressDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else{
                                            throw new Exception("Address not added", 1);
                                            
                                        }
                                    
                                    
                                }
                                else
                                {
                                    throw new Exception("Address not added", 1);
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
     *          name="address_id",
     *          parameter="address_id",
     *          required=true
     * )
     *
     * @OA\Post(
     *     path="/address/update/{address_id}",
     *     tags={"Address"},
     *     operationId="putAddress",
     *     summary="Update Address Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/address_id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AddressRequestUpdate"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Update Address Details",
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
    public function address_api_update_ci_post()
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

                        //print_r($input);

                        $address_id = trim($this->uri->segments['4']);

                        $address_1 = trim($request['address_1']);
                        $address_2 = trim($request['address_2']);
                        $city_id = trim($request['city_id']);
                        $state_id = trim($request['state_id']);
                        $country_id = trim($request['country_id']);
                        $pincode=trim($request['pincode']);
                                
                        $date_of_birth = trim($request['date_of_birth']);
                        // $mem_pic = trim($request['mem_pic']);
                        $user_id = trim($user_detail->user_id);

                        if (!empty($address_1) && !empty($address_2) && !empty($city_id) && !empty($state_id) && !empty($country_id) && !empty($pincode)) 
                        {
                            $addressData = array(
                                'address_1'=>$address_1." ",
                                'address_2'=> $address_2." ",
                                'city_id'=>$city_id,
                                'state_id'=> $state_id,
                                'country_id'=> $country_id,
                                'pincode'=>$pincode,
                                'user_id' => $user_id
                            );
                            try
                            {
                                $this->db->where(array('address_id'=>$address_id));
                                if($this->db->update('add_address',$addressData))
                                {
                                    

                                        $this->db->select('*');
                                        $this->db->from('add_address');
                                        $this->db->where('address_id', $address_id);

                                        $get_address = $this->db->get();

                                        $rows = $get_address->custom_result_object('AddressDetails');

                                        if(count($rows) > 0)
                                        {
                                            $addressDetails = $rows[0];
                                           

                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Address Details Updated Successfully";
                                            $apiResponse->data = $addressDetails;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        }
                                        else
                                        {
                                            throw new Exception("Address not Updated", 1);
                                        }
                                        
                                    }
                                    else
                                    {
                                       throw new Exception("Address not Updated", 1);
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
     *     path="/address/delete/{address_id}",
     *     tags={"Address"},
     *     operationId="deleteAddress",
     *     summary="Delete Address Details",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\Parameter(
     *        ref="#/components/parameters/address_id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Api_Response"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unable to Delete Address Details",
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
     public function address_api_delete_ci_delete()
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

                        $address_id = trim($this->uri->segments['4']);
                       
                        //echo $address_id;
                        // if (!empty($name) && !empty($contact_no) && !empty($address) && !empty($city_id)) 
                        // {
                            
                            try
                            {

                                // $this->db->where(array('address'=>$address_id));    
                                // $this->db->update('add_address',array('status' => '0'));
                                // echo $this->db->last_query();
                                // exit;
                               


                                $this->db->where(array('address_id'=>$address_id));
                                if($this->db->update('add_address', array('status' => '0')))
                                {

                                    
                                            
                                            $this->db->where(array('address'=>$address_id));
                                            $this->db->delete('cart');
                                            $apiResponse = new Api_Response();
                                            $apiResponse->status = true;
                                            $apiResponse->message = "Address Details Deleted Successfully";
                                            //$apiResponse->data = $memberDetail;
                                            $this->response($apiResponse, REST_Controller::HTTP_OK);
                                        
                                    
                                    
                                }
                                else
                                {
                                    throw new Exception("Address Details not Deleted", 1);
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