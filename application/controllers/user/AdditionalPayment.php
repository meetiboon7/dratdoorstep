<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/stack_web_gateway_paytm_kit/Stack_additional_gateway_paytm_kit.php';

class AdditionalPayment extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
		//$this->load->model('admin/City_model');
		//$this->load->model('user/member_model');
		 $this->load->model('General_model');
		// if(!$this->Login_model->check_admin_login()){
		// 	redirect(base_url().'admin');
		// }
		//   //logout releted code add 10-12-2020
	//	   $this->load->model('user/Login_model');
		// // // $this->load->model('General_model');
		// if(!$this->Login_model->check_user_login()){
		// 	redirect(base_url());
		// }

		// header("Pragma: no-cache");
		// header("Cache-Control: no-cache");
		// header("Expires: 0");

        $this->load->library('stack_web_gateway_paytm_kit/stack_additional_gateway_paytm_kit');
		 //logout releted code add 10-12-2020
		
				
	}	


	public function index()
	{

		// echo "test";
		// exit;

		// $this->db->select('*');
		// $this->db->from('recharge');
		// $this->db->where('recharge.user_id',$this->session->userdata('user')['user_id']);
		// $this->db->order_by('recharge.recharge_id', 'DESC');
									  
		// $data['manage_wallet'] = $this->db->get()->result_array();
		
		// $this->load->view(USERHEADER);
		// $this->load->view('user/listWallet',$data);
		// $this->load->view(USERFOOTER);
	}
	public function addAdditionalPayment()
	{
			$posted = $_POST;
           
           // echo "<pre>";
           // print_r($posted);
           
			if($posted['user_type_id']==1)
			{
				$this->db->select('appointment_book.*');
				$this->db->from('appointment_book');
				$this->db->where('appointment_book.appointment_book_id',$posted[assign_appointment_id]);
				//$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
				
				$doctor_appointment= $this->db->get()->result_array();

				 $paytmParams = array();
	    		$paytmParams['ORDER_ID'] 		= $posted['ORDER_ID'];
	    		$paytmParams['TXN_AMOUNT'] 		= $posted['amount'];
	    		$paytmParams["CUST_ID"] 		= $doctor_appointment[0]['user_id'];
	    		//$paytmParams["EMAIL"] 			= (!empty($email)) ? $email : "" ;

			    $paytmParams["MID"] 			= PAYTM_MERCHANT_MID;
			    $paytmParams["CHANNEL_ID"] 		= PAYTM_CHANNEL_ID;
			    $paytmParams["WEBSITE"] 		= PAYTM_MERCHANT_WEBSITE;
			    $paytmParams["CALLBACK_URL"] 	= PAYTM_CALLBACK_URL;
			    $paytmParams["INDUSTRY_TYPE_ID"]= PAYTM_INDUSTRY_TYPE_ID;
	            $paytmParams["MERC_UNQ_REF"]=$doctor_appointment[0]['user_id'].",".$doctor_appointment[0]['patient_id'].",".$doctor_appointment[0]['txnid'].",".$doctor_appointment[0]['time'].",".$doctor_appointment[0]['date'].",".$doctor_appointment[0]['appointment_book_id'].",".$posted['user_type_id'].",".$posted['id'];
				
			}
			else if($posted['user_type_id']==2)
			{
				$this->db->select('book_nurse.*');
				$this->db->from('book_nurse');
				$this->db->where('book_nurse.book_nurse_id',$posted[assign_appointment_id]);
				//$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
				
				$book_nurse_appointment= $this->db->get()->result_array();

				 $paytmParams = array();
	    		$paytmParams['ORDER_ID'] 		= $posted['ORDER_ID'];
	    		$paytmParams['TXN_AMOUNT'] 		= $posted['amount'];
	    		$paytmParams["CUST_ID"] 		= $book_nurse_appointment[0]['user_id'];
	    		//$paytmParams["EMAIL"] 			= (!empty($email)) ? $email : "" ;

			    $paytmParams["MID"] 			= PAYTM_MERCHANT_MID;
			    $paytmParams["CHANNEL_ID"] 		= PAYTM_CHANNEL_ID;
			    $paytmParams["WEBSITE"] 		= PAYTM_MERCHANT_WEBSITE;
			    $paytmParams["CALLBACK_URL"] 	= PAYTM_CALLBACK_URL;
			    $paytmParams["INDUSTRY_TYPE_ID"]= PAYTM_INDUSTRY_TYPE_ID;
	            $paytmParams["MERC_UNQ_REF"]=$book_nurse_appointment[0]['user_id'].",".$book_nurse_appointment[0]['patient_id'].",".$book_nurse_appointment[0]['txnid'].",".$book_nurse_appointment[0]['time'].",".$book_nurse_appointment[0]['date'].",".$book_nurse_appointment[0]['book_nurse_id'].",".$posted['user_type_id'].",".$posted['id'];
			}
			else if($posted['user_type_id']==3)
			{
				$this->db->select('book_laboratory_test.*');
				$this->db->from('book_laboratory_test');
				$this->db->where('book_laboratory_test.book_laboratory_test_id',$posted[assign_appointment_id]);
				//$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
				
				$book_lab_appointment= $this->db->get()->result_array();

				 $paytmParams = array();
	    		$paytmParams['ORDER_ID'] 		= $posted['ORDER_ID'];
	    		$paytmParams['TXN_AMOUNT'] 		= $posted['amount'];
	    		$paytmParams["CUST_ID"] 		= $book_lab_appointment[0]['user_id'];
	    		//$paytmParams["EMAIL"] 			= (!empty($email)) ? $email : "" ;

			    $paytmParams["MID"] 			= PAYTM_MERCHANT_MID;
			    $paytmParams["CHANNEL_ID"] 		= PAYTM_CHANNEL_ID;
			    $paytmParams["WEBSITE"] 		= PAYTM_MERCHANT_WEBSITE;
			    $paytmParams["CALLBACK_URL"] 	= PAYTM_CALLBACK_URL;
			    $paytmParams["INDUSTRY_TYPE_ID"]= PAYTM_INDUSTRY_TYPE_ID;
	            $paytmParams["MERC_UNQ_REF"]=$book_lab_appointment[0]['user_id'].",".$book_lab_appointment[0]['patient_id'].",".$book_lab_appointment[0]['txnid'].",".$book_lab_appointment[0]['time'].",".$book_lab_appointment[0]['date'].",".$book_lab_appointment[0]['book_laboratory_test_id'].",".$posted['user_type_id'].",".$posted['id'];
			}
			else if($posted['user_type_id']==5)
			{
				$this->db->select('book_ambulance.*');
				$this->db->from('book_ambulance');
				$this->db->where('book_ambulance.book_ambulance_id',$posted[assign_appointment_id]);
				//$this->db->where("((add_address.status = '0' OR add_address.status = '1'))");
				
				$book_ambulance_appointment= $this->db->get()->result_array();

				 $paytmParams = array();
	    		$paytmParams['ORDER_ID'] 		= $posted['ORDER_ID'];
	    		$paytmParams['TXN_AMOUNT'] 		= $posted['amount'];
	    		$paytmParams["CUST_ID"] 		= $book_ambulance_appointment[0]['user_id'];
	    		//$paytmParams["EMAIL"] 			= (!empty($email)) ? $email : "" ;

			    $paytmParams["MID"] 			= PAYTM_MERCHANT_MID;
			    $paytmParams["CHANNEL_ID"] 		= PAYTM_CHANNEL_ID;
			    $paytmParams["WEBSITE"] 		= PAYTM_MERCHANT_WEBSITE;
			    $paytmParams["CALLBACK_URL"] 	= PAYTM_CALLBACK_URL;
			    $paytmParams["INDUSTRY_TYPE_ID"]= PAYTM_INDUSTRY_TYPE_ID;
	            $paytmParams["MERC_UNQ_REF"]=$book_ambulance_appointment[0]['user_id'].",".$book_ambulance_appointment[0]['patient_id'].",".$book_ambulance_appointment[0]['txnid'].",".$book_ambulance_appointment[0]['time'].",".$book_ambulance_appointment[0]['date'].",".$book_ambulance_appointment[0]['book_ambulance_id'].",".$posted['user_type_id'].",".$posted['id'];
			}
    		
    		//exit;
    		
           

           
    		
		    $paytmChecksum = $this->stack_additional_gateway_paytm_kit->getChecksumFromArray($paytmParams, PAYTM_MERCHANT_KEY);
		    $paytmParams["CHECKSUMHASH"] = $paytmChecksum;
		   
		    $transactionURL = PAYTM_TXN_URL;
    		// p($posted);
    		// p($paytmParams,1);

    		$data = array();
    		$data['paytmParams'] 	= $paytmParams;
    		$data['transactionURL'] = $transactionURL;
    		
    		//$this->load->view('payby_paytm', $data);
    		$this->load->view('user/recharge_paytm',$data);
	}
	public function paytm_additional_response(){


    	$paytmChecksum 	= "";
		$paramList 		= array();
		$isValidChecksum= "FALSE";

		$paramList = $_POST;
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
		// print_r($paytmChecksum);
		// exit;
		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");

		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = $this->stack_additional_gateway_paytm_kit->verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
// echo "<pre>";
//         print_r($paramList);
//         exit;
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		// exit;
		// exit;
		if($isValidChecksum == "TRUE") {
			//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
			
		              
			$ORDER_ID     = $_POST["ORDERID"];
	        $tot          = $_POST["TXNAMOUNT"];
	        $TXNID        = $_POST["TXNID"];
	        $BANKNAME     = $_POST["BANKNAME"];
			if($BANKNAME == 'WALLET'){
			$BANKTXNID    = 0;
			}
			else{
			        $BANKTXNID    = $_POST["BANKTXNID"];
			}
	        $STATUS       = $_POST["STATUS"];
	        $RESPCODE     = $_POST["RESPCODE"];
	        $TXNDATE      = $_POST["TXNDATE"];
	        $GATEWAYNAME  = $_POST["GATEWAYNAME"];
	        
	        $PAYMENTMODE  = $_POST["PAYMENTMODE"];
	        $MERC_UNQ_REF = explode(',',$_POST["MERC_UNQ_REF"]);
	       
			if ($_POST["STATUS"] == "TXN_SUCCESS") {

                 		if($MERC_UNQ_REF[6]==1)
                 		{
                 			$extra_invoice = array(
                                                'list'=>"Doctor visit",
                                                'price'=>$tot,
                                                'patient_id'=>$MERC_UNQ_REF[1],
                                                'user_id'=>$MERC_UNQ_REF[0],
                                                'doctor_id'=>60,
                                                'appointment_book_id'=>$MERC_UNQ_REF[5],
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$MERC_UNQ_REF[2],
                                                'devicetype'=> '',
                                                'appmt_date'=>$MERC_UNQ_REF[4],
                                                'order_id'=>$_POST['ORDERID'],
                                                'no_of_days'=>0,
                                                'time'=>$MERC_UNQ_REF[3],
                                                'reference_id'=>'',
                        	);
                 		}
                 		else if($MERC_UNQ_REF[6]==2)
                 		{
                 				$extra_invoice = array(
                                                'list'=>"Nurse visit",
                                                'price'=>$tot,
                                                'patient_id'=>$MERC_UNQ_REF[1],
                                                'user_id'=>$MERC_UNQ_REF[0],
                                                'doctor_id'=>0,
                                                'book_nurse_id'=>$MERC_UNQ_REF[5],
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$MERC_UNQ_REF[2],
                                                'devicetype'=> '',
                                                'appmt_date'=>$MERC_UNQ_REF[4],
                                                'order_id'=>$_POST['ORDERID'],
                                                'no_of_days'=>0,
                                                'time'=>$MERC_UNQ_REF[3],
                                                'reference_id'=>'',
                        	);	
                 		}
                 		else if($MERC_UNQ_REF[6]==3)
                 		{
                 				$extra_invoice = array(
                                                'list'=>"Lab visit",
                                                'price'=>$tot,
                                                'patient_id'=>$MERC_UNQ_REF[1],
                                                'user_id'=>$MERC_UNQ_REF[0],
                                                'doctor_id'=>0,
                                                'book_laboratory_test_id'=>$MERC_UNQ_REF[5],
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$MERC_UNQ_REF[2],
                                                'devicetype'=> '',
                                                'appmt_date'=>$MERC_UNQ_REF[4],
                                                'order_id'=>$_POST['ORDERID'],
                                                'no_of_days'=>0,
                                                'time'=>$MERC_UNQ_REF[3],
                                                'reference_id'=>'',
                        	);	
                 		}
                 		else if($MERC_UNQ_REF[6]==5)
                 		{
                 				$extra_invoice = array(
                                                'list'=>"Ambulance visit",
                                                'price'=>$tot,
                                                'patient_id'=>$MERC_UNQ_REF[1],
                                                'user_id'=>$MERC_UNQ_REF[0],
                                                'doctor_id'=>0,
                                                'book_ambulance_id'=>$MERC_UNQ_REF[5],
                                                'date'=>date('Y-m-d H:i:s'),
                                                'discount'=>0,
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$MERC_UNQ_REF[2],
                                                'devicetype'=> '',
                                                'appmt_date'=>$MERC_UNQ_REF[4],
                                                'order_id'=>$_POST['ORDERID'],
                                                'no_of_days'=>0,
                                                'time'=>$MERC_UNQ_REF[3],
                                                'reference_id'=>'',
                        	);	
                 		}

                 		
                       

						if( $this->db->insert("extra_invoice",$extra_invoice))
						{

								 $this->db->where('id',$MERC_UNQ_REF[7]);
    							 $this->db->update('additional_payment', array('pay_flag' =>'0'));
    							 // echo $this->db->last_query();
    							 // exit;
								/*$this->db->select('*');
                   				$this->db->from('user');
                    			$this->db->where('user_id',$CUST_ID);
                    			$user_details = $this->db->get()->result_array();

                    			foreach($user_details as $user){ 

                    				 $mobile = $user['mobile'];
				                     $email  = $user['email'];
				                     $bal  = $user['balance'];
                    			}

                    			$final_bal=$bal + $tot ;

                    			 $this->db->where('user_id',$CUST_ID);
    							 $this->db->update('user', array('balance' => $final_bal));


    							  $message = urlencode("Congratulations Your health wallet has been recharged with Rs $tot.");
                
					              

					                $this->db->select('*');
                   				   $this->db->from('sms_detail');
                    				$sms_detail = $this->db->get()->result_array();



					                $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$mobile."&text=".$message."&output=json";
					                $response = file_get_contents($smsurl);*/
                
				             

                    			



						}
						

						// echo $this->db->last_query();
                    	// exit;
						

                 
                         
                    

				//echo "<b>Transaction status is success</b>" . "<br/>";


			//$this->load->view(USERHEADER);
			//	$this->load->view('user/payment_response');
			//$this->load->view(USERFOOTER);
				//redirect(base_url()."userdashboard",'refresh');
				// redirect('login/form', 'refresh');
				//redirect(base_url()."userWallet/".$in);
						redirect(base_url()."successPaymentPage",'refresh');
				//Process your transaction here as success transaction.
				//Verify amount & order id received from Payment gateway with your application's order id and amount.
			}
			else {


      //               $this->db->select('*');
      //               $this->db->from('recharge');
      //               $this->db->where('order_id',$ORDER_ID);
      //               $recharge_details = $this->db->get()->result_array();

      //               	// echo $this->db->last_query();
      //               	// exit;
                  
      //               function get_client_ip()
			   //      {
			   //          $ipaddress = '';
			   //          if (getenv('HTTP_CLIENT_IP'))
			   //              $ipaddress = getenv('HTTP_CLIENT_IP');
			   //          else if (getenv('HTTP_X_FORWARDED_FOR'))
			   //              $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			   //          else if (getenv('HTTP_X_FORWARDED'))
			   //              $ipaddress = getenv('HTTP_X_FORWARDED');
			   //          else if (getenv('HTTP_FORWARDED_FOR'))
			   //              $ipaddress = getenv('HTTP_FORWARDED_FOR');
			   //          else if (getenv('HTTP_FORWARDED'))
			   //              $ipaddress = getenv('HTTP_FORWARDED');
			   //          else if (getenv('REMOTE_ADDR'))
			   //              $ipaddress = getenv('REMOTE_ADDR');
			   //          else
			   //              $ipaddress = 'UNKNOWN';
			   //          return $ipaddress;
			   //      }
			   //      $ip     = ip2long(get_client_ip());
                  

      //             		$recharge_array = array(
						// 	'amt'=>$tot,
						// 	'order_id' => $ORDER_ID,
						// 	'user_id'=>$CUST_ID,
						// 	'total'=>$tot,
						// 	'txnid'=>$TXNID,
						// 	'txndate'=>$TXNDATE,
						// 	'banktxnid'=>$BANKTXNID,
						// 	'responsecode'=>$RESPCODE,
						// 	'responsestatus'=>$STATUS,
						// 	'bankname'=>$BANKNAME,
						// 	'paymentmade'=>$PAYMENTMODE,
						// 	'gatewayname'=>$GATEWAYNAME,
						// 	'ipaddress'=>$ip,
							
						// 	//'e_created_on'=>date('Y-m-d H:i:s')
						// );

						// $this->db->insert('recharge', $recharge_array);
						

						//echo "<b>Transaction status is failure</b>" . "<br/>";
						//redirect(base_url().'payment_fail');
						 redirect(base_url()."FailPaymentPage",'refresh');
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
