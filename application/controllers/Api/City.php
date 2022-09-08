<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

use Firebase\JWT\JWT;
use OpenApi\Annotations as OA;

class City extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_model');
        $this->load->model('api/model/response/Api_Response');
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
     *     path="/city",
     *     tags={"City"},
     *     operationId="getCity",
     *     summary="City",
     *     description="",
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
    public function city_api_ci_get()
    {
        $auth = $this->_head_args['Authorization'];
        // print_r($auth);
        // exit;

       

            $bearer = preg_split('/\s+/', $auth);
            $this->db->select('*');
            $this->db->from('city');
            $this->db->where('city_status',1);
            $city_Details = $this->db->get()->result_array();

                    if (count($city_Details) > 0) {

                      //$specific[]=$city_Details;

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "City Listing";
                        $apiResponse->data['city'] = $city_Details;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {
                        //throw new Exception("Invalid Token Data", 1);
                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "City Not Found";
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    
                
                
            
            
        
    }
    
}
