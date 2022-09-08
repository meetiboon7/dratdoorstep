<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;

class PromoCode extends REST_Controller
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
     *     path="/PromoCode/get",
     *     tags={"Promo Code"},
     *     operationId="getPromoCode",
     *     summary="get Promo Code Details",
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
    public function promocode_api_get_ci_get()
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
                    
                   
                    


                    $this->db->select('voucher.*,GROUP_CONCAT(DISTINCT city.city) as city,GROUP_CONCAT(DISTINCT manage_package.package_name) as package_name, GROUP_CONCAT(DISTINCT user_type.user_type_name) as user_type_name');
                     $this->db->from('voucher');
                     //$this->db->join('city','city.city_id = voucher.city_id');
                     $this->db->join("city","find_in_set(city.city_id,voucher.city_id) <> 0",'LEFT',false);
                     $this->db->join("manage_package","find_in_set(manage_package.package_id,voucher.package_id) <> 0",'LEFT',false);
                     $this->db->join("user_type","find_in_set(user_type.user_type_id,voucher.service_id) <> 0","LEFT",false);
                   // $this->db->where('voucher.from_date <=',date('Y-m-d'));
                    $this->db->where('voucher.to_date >=',date('Y-m-d'));
                     $this->db->where('voucher.visi_and_invisi',1);
                     $this->db->group_by('voucher.voucher_id');
                    $voucher_Details = $this->db->get()->result_array();

                   foreach ($voucher_Details as $key => $value) {

                         $value['from_date']=date("d-m-Y",strtotime($value['from_date']));
                         $value['to_date']=date("d-m-Y",strtotime($value['to_date']));
                         

                          $voucher_Details[$key] = $value;

                           
                        }
                           

                    if (count($voucher_Details) > 0) {


                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Voucher Record Listed";
                        $apiResponse->data['voucher_code'] = $voucher_Details;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "No offers available";
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
    
    // code for Address *api*-------------------------------
    /**
     * @OA\Post(
     *     path="/PromoCode/add",
     *     tags={"Promo Code"},
     *     operationId="postPromoCode",
     *     summary="Validate Promo Code",
     *     description="",
     *     security={{"dads_auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PromoCodeRequest"),
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
    public function promocode_api_add_ci_post()
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

                        $promo_code = trim($request['promo_code']);
                        $cart_id = $request['cart_id'];

                        // $cart_id=explode(',',$cart_id);

                        $user_id = trim($user_detail->user_id);

                        // echo "<pre>";
                        // print_r($cart_id);
                        // echo "</pre>";
                        // exit;

                        if (!empty($promo_code) && count($cart_id) > 0) 
                        {


                            try
                            {


                                $user_type_id=array();
                                $package_id=array();

                                foreach($cart_id as $id) {

                                    $this->db->select('*');
                                $this->db->from('cart');
                                $this->db->where('cart_id', $id);

                                
                                 $cart_details = $this->db->get()->result_array();

                                 if($cart_details[0]["package_id"] > 0)
                                    array_push($package_id,$cart_details[0]["package_id"]); 
                                 elseif($cart_details[0]["user_type_id"] > 0)
                                    array_push($user_type_id,$cart_details[0]["user_type_id"]);


                                
                                    # code...
                                }
                                // echo "<pre>";
                                // print_r($package_id);
                                // echo "</pre>";
                                // echo "<pre>";
                                // print_r($cart_item_type);
                                // echo "</pre>";

                               // $cart_item_type

                                    

                                   
                                    $voucherQuery = "Select * from voucher where code = '$promo_code' and from_date <= '". date('Y-m-d') . "' and to_date >= '". date('Y-m-d') ."'";
                                    $this->db->select('*');
                                    $this->db->from('voucher');
                                    $this->db->where('code', $promo_code);
                                    $this->db->where('all_service',0);
                                    $get_voucher = $this->db->get()->row_array();
                                    
                                    if(count($get_voucher))
                                    {
                                       
                                       if(count($user_type_id) > 0 || count($package_id) > 0)
                                       {
                                            if(count($user_type_id) > 0)
                                            {
                                                $voucherQuery = $voucherQuery . " and ( service_id in (". implode(',', $user_type_id) . ")";
                                                // $this->db->where('package_id', $item_type["package_id"]);
                                            }else
                                            {
                                                $voucherQuery = $voucherQuery . "and ( ";
                                            }
                                            if (count($package_id)> 0) {
                                                if(count($user_type_id) > 0)
                                                    $voucherQuery = $voucherQuery . " or ";

                                                $voucherQuery = $voucherQuery . " package_id in (". implode(',', $package_id) . "))";
                                                // $this->db->where('user_type_id', $item_type["user_type_id"]);  
                                            }else
                                            {
                                                $voucherQuery = $voucherQuery . ")";
                                            }
                                            $get_voucher = $this->db->query($voucherQuery)->row_array();
                                           
                                       }
                                       else
                                       {
                                            $get_voucher = array();
                                            
                                       }
                                        
                                    }
                                    else
                                    {
                                        $this->db->select('*');
                                        $this->db->from('voucher');
                                        $this->db->where('code', $promo_code);
                                        $this->db->where('from_date <=',date('Y-m-d'));
                                        $this->db->where('to_date >=',date('Y-m-d'));
                                        $get_voucher = $this->db->get()->row_array();
                                    }
                                       
                                    
                                 // $get_voucher = $this->db->get()->row_array();
                              //  $this->db->where('service_id >=',date('Y-m-d'));

                               
                                
                                //$get_voucher = $this->db->get();


                                 
                  

                              //  $rows = $get_voucher->custom_result_object('PromoCodeDetails');

                                // echo "<pre>";
                                //  print_r($get_voucher);
                                //  echo "</pre>";
                                 $this->db->select('*');
                                $this->db->from('user_promocode_rel');
                                $this->db->where('user_promocode_rel.voucher_id',$get_voucher['voucher_id']);
                                $this->db->where('user_promocode_rel.user_id',$user_id);
                               $use_voucher = $this->db->get()->result_array();
                                

                                //if(count($get_voucher) > 0)
                                if($get_voucher['voucher_id']!=$use_voucher[0]['voucher_id'] && $use_voucher[0]['user_id']!=$user_id)
                                {
                                    //$promoDetail = $rows[0];
                                    
                                    $get_voucher["service_id"] = empty($get_voucher["service_id"]) ? null : $get_voucher["service_id"];
                                    $get_voucher["package_id"] = empty($get_voucher["package_id"]) ? null : $get_voucher["package_id"];
                                    
                                    $apiResponse = new Api_Response();
                                    $apiResponse->status = true;
                                    $apiResponse->message = "Promo code has applied successfully";
                                    $apiResponse->data = $get_voucher;
                                    $this->response($apiResponse, REST_Controller::HTTP_OK);
                                }
                                else{
                                        $apiResponse = new Api_Response();
                                        $apiResponse->status = false;
                                        $apiResponse->message = "This Promo code has not Valid";
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