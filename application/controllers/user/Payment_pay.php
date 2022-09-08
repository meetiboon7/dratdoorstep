<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/stack_web_gateway_paytm_kit/Stack_web_payment_pay.php';

class Payment_pay extends CI_Controller {
    public function __construct() {
        parent::__construct();
        @session_start();

        //===================================================
        // Loads Paytm Authorized Files
        //===================================================
	// header("Pragma: no-cache");
	// header("Cache-Control: no-cache");
	// header("Expires: 0");

        $this->load->library('stack_web_gateway_paytm_kit/Stack_web_payment_pay');

       //logout releted code add 10-12-2020
           $this->load->model('user/Login_model');
        // // $this->load->model('General_model');
        // if(!$this->Login_model->check_user_login()){
        //     redirect(base_url());
        // }
        //logout releted code add 10-12-2020
       
    }
    public function index()
    {
        //$this->load->view('user/payby_paytm',$data);
        // $this->db->select('balance');
        // $this->db->from('user');
        // $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
        // $data['user_balance'] = $this->db->get()->row_array();

        // $this->db->select('book_package.*,user_type.user_type_name,member.name,manage_package.package_name');
        // $this->db->from('book_package');
        // $this->db->join('manage_package','book_package.package_id = manage_package.package_id');
        // $this->db->join('user_type','user_type.user_type_id = book_package.service_id');
        // $this->db->join('member','member.member_id = book_package.patient_id');
        // $this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
        // //$this->db->group_by('package_booking.package_id'); 
        // $this->db->order_by('book_package.package_id', 'DESC');

                                      
        // $data['manage_package'] = $this->db->get()->result_array();


        // $this->db->select('manage_package.*,city.city,user_type.user_type_name');
        // $this->db->from('manage_package');
        // $this->db->join('city','city.city_id = manage_package.city_id');
        // $this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
        // $this->db->where('manage_package.package_status',1);
        // $this->db->order_by('manage_package.package_id', 'DESC');
                                      
        // $data['book_package'] = $this->db->get()->result_array();

        // $this->load->view('user/dashboard',$data);
    }
    public function payment_pay_paid()
    {
       extract($_POST);
      // echo "<pre>";
      // print_r($_POST);
     // echo $_POST['total_price']."<br>";
      
     //  echo $deduct_amount;
      //exit;

      if (!empty($_POST['amount'])) 
      {
    		

    		$posted = $_POST;
            
            
    		//exit;
            $paytmParams = array();
    		$paytmParams['ORDER_ID'] 		= $posted['ORDER_ID'];
    		$paytmParams['TXN_AMOUNT'] 		= $amount;
    		$paytmParams["CUST_ID"] 		= $posted['user_id'];
    		$paytmParams["MID"] 			= PAYTM_MERCHANT_MID;
		    $paytmParams["CHANNEL_ID"] 		= PAYTM_CHANNEL_ID;
		    $paytmParams["WEBSITE"] 		= PAYTM_MERCHANT_WEBSITE;
		    $paytmParams["CALLBACK_URL"] 	= PAYTM_CALLBACK_URL;
		    $paytmParams["INDUSTRY_TYPE_ID"]= PAYTM_INDUSTRY_TYPE_ID;
            $paytmParams["MERC_UNQ_REF"]=$posted['user_id'].",".$posted['user_type_id'].",".$posted['appointment_id'];

           
    		
		    $paytmChecksum = $this->stack_web_payment_pay->getChecksumFromArray($paytmParams, PAYTM_MERCHANT_KEY);
		    $paytmParams["CHECKSUMHASH"] = $paytmChecksum;
		   
		    $transactionURL = PAYTM_TXN_URL;
    		

    		$data = array();
    		$data['paytmParams'] 	= $paytmParams;
    		$data['transactionURL'] = $transactionURL;
    		
    		
    		$this->load->view('user/payby_paytm',$data);
    	}
    }

    public function payment_pay_response(){


    	$paytmChecksum 	= "";
		$paramList 		= array();
		$isValidChecksum= "FALSE";

		$paramList = $_POST;
       

       $MERC_UNQ_REF= explode(',', $_POST['MERC_UNQ_REF']);
      

      
     
      
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
		

         
		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = $this->stack_web_payment_pay->verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


		if($isValidChecksum == "TRUE") 
        {
			//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
			
		              

			if ($_POST["STATUS"] == "TXN_SUCCESS") {

                        $responsestatus=$_POST["STATUS"];
                         $responsecode=$_POST["RESPCODE"];
                         $txnid=$_POST['TXNID'];
                         $paymentmade=$_POST['PAYMENTMODE'];
                         $txndate=$_POST['TXNDATE'];
                         $gatewayname=$_POST['GATEWAYNAME'];
                         $banktxnid=$_POST['BANKTXNID'];
                         $bankname=$_POST['BANKNAME'];
                   
                        
                        if($MERC_UNQ_REF[1]==1)
                        {
                           
                            $this->db->where('appointment_book_id',$MERC_UNQ_REF[2]);
                            $this->db->update('appointment_book', array('paid_flag' => 1,'responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                         
                            
                        }
                        if($MERC_UNQ_REF[1]==2)
                        {
                           
                            $this->db->where('book_nurse_id',$MERC_UNQ_REF[2]);
                            $this->db->update('book_nurse', array('paid_flag' => 1,'responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                            
                        }
                        if($MERC_UNQ_REF[1]==3)
                        {
                                
                            $this->db->where('book_laboratory_test_id',$MERC_UNQ_REF[2]);
                            $this->db->update('book_laboratory_test', array('paid_flag' => 1,'responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                        }
                       
                        if($MERC_UNQ_REF[1]==5)
                        {
                            $this->db->where('book_ambulance_id',$MERC_UNQ_REF[2]);
                            $this->db->update('book_ambulance', array('paid_flag' => 1,'responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                        }

                      // redirect(base_url()."user/dashboard",'refresh');
                        redirect(base_url()."successPaymentPage",'refresh');
                    //redirect(base_url()."user/successPaymentPage",'refresh');
				
			}
			else {

                         $responsestatus=$_POST["STATUS"];
                         $responsecode=$_POST["RESPCODE"];
                         $txnid=$_POST['TXNID'];
                         $paymentmade=$_POST['PAYMENTMODE'];
                         $txndate=$_POST['TXNDATE'];
                         $gatewayname=$_POST['GATEWAYNAME'];
                         $banktxnid=$_POST['BANKTXNID'];
                         $bankname=$_POST['BANKNAME'];
                        if($MERC_UNQ_REF[1]==1)
                        {
                           
                            $this->db->where('appointment_book_id',$MERC_UNQ_REF[2]);
                            $this->db->update('appointment_book', array('paid_flag' => '0','responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                            
                        }
                        if($MERC_UNQ_REF[1]==2)
                        {
                           
                                 $this->db->where('book_nurse_id',$MERC_UNQ_REF[2]);
                            $this->db->update('book_nurse', array('paid_flag' => '0','responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                            
                        }
                        if($MERC_UNQ_REF[1]==3)
                        {
                                
                             $this->db->where('book_laboratory_test_id',$MERC_UNQ_REF[2]);
                            $this->db->update('book_laboratory_test', array('paid_flag' => '0','responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                        }
                       
                        if($MERC_UNQ_REF[1]==5)
                        {
                            $this->db->where('book_ambulance_id',$MERC_UNQ_REF[2]);
                            $this->db->update('book_ambulance', array('paid_flag' => '0','responsestatus'=>$responsestatus,'responsecode'=> $responsecode,'txnid'=>$txnid,'paymentmade'=>$paymentmade,'txndate'=>$txndate,'gatewayname'=> $gatewayname,'banktxnid'=>$banktxnid,'bankname'=>$bankname));
                        }

                 

				 redirect(base_url()."FailPaymentPage",'refresh');
				//redirect(base_url().'payment_fail');
               // redirect(base_url()."FailPaymentPage",'refresh');
			}

			if (isset($_POST) && count($_POST)>0 )
			{ 
				foreach($_POST as $paramName => $paramValue) {
						echo "<br/>" . $paramName . " = " . $paramValue;
				}
			}
			

		}
		else {
			echo "<b>Checksum mismatched.</b>";
			//Process transaction as suspicious.
		}
    }
}
