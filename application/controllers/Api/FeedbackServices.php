<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
// require_once(APPPATH.'controllers/Api/auth/Auth.php');
//require APPPATH . 'controllers/Api/auth/Auth.php';

use Firebase\JWT\JWT;
use OpenApi\Annotations as OA;

class FeedbackServices extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->load->model('api/Login_model');
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
     *     path="/feedback_services",
     *     tags={"Feeback Services"},
     *     operationId="getFeedbackServices",
     *     summary="Feedback Services",
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
    public function feedbackservices_api_ci_get()
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

                    $this->db->select('*');
                    $this->db->from('feedback_services');
                    $feedback_services_Details = $this->db->get()->result_array();

                    if (count($feedback_services_Details) > 0) {

                      //$specific[]=$city_Details;

                        $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Feedback Services Listing";
                        $apiResponse->data['feedback_services'] = $feedback_services_Details;
                        $this->response($apiResponse, REST_Controller::HTTP_OK);
                    }
                    else
                    {
                         $apiResponse = new Api_Response();
                        $apiResponse->status = true;
                        $apiResponse->message = "Feedback Services Not Listing";
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
    
}
