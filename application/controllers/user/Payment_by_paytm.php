<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/stack_web_gateway_paytm_kit/Stack_web_gateway_paytm_kit.php';

class Payment_by_paytm extends CI_Controller {
 //    public function __construct() {
 //        parent::__construct();
 //        @session_start();

 //        //===================================================
 //        // Loads Paytm Authorized Files
 //        //===================================================
	// // header("Pragma: no-cache");
	// // header("Cache-Control: no-cache");
	// // header("Expires: 0");

 //        $this->load->library('stack_web_gateway_paytm_kit/Stack_web_gateway_paytm_kit');

 //       //logout releted code add 10-12-2020
 //           $this->load->model('user/Login_model');
 //        // // $this->load->model('General_model');
 //        // if(!$this->Login_model->check_user_login()){
 //        //     redirect(base_url());
 //        // }
 //        //logout releted code add 10-12-2020
       
 //    }
    public function __construct() {
        parent::__construct();
        //$this->load->model('admin/City_model');
        //$this->load->model('user/member_model');
         $this->load->model('General_model');
        // if(!$this->Login_model->check_admin_login()){
        //  redirect(base_url().'admin');
        // }
        //   //logout releted code add 10-12-2020
    //     $this->load->model('user/Login_model');
        // // // $this->load->model('General_model');
        // if(!$this->Login_model->check_user_login()){
        //  redirect(base_url());
        // }

        // header("Pragma: no-cache");
        // header("Cache-Control: no-cache");
        // header("Expires: 0");

        $this->load->library('stack_web_gateway_paytm_kit/Stack_web_gateway_paytm_kit');
         //logout releted code add 10-12-2020
        
                
    }
    public function index()
    {
        //$this->load->view('user/payby_paytm',$data);
        $this->db->select('balance');
        $this->db->from('user');
        $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
        $data['user_balance'] = $this->db->get()->row_array();

        $this->db->select('book_package.*,user_type.user_type_name,member.name,manage_package.package_name');
        $this->db->from('book_package');
        $this->db->join('manage_package','book_package.package_id = manage_package.package_id');
        $this->db->join('user_type','user_type.user_type_id = book_package.service_id');
        $this->db->join('member','member.member_id = book_package.patient_id');
        $this->db->where('book_package.user_id',$this->session->userdata('user')['user_id']);
        //$this->db->group_by('package_booking.package_id'); 
        $this->db->order_by('book_package.package_id', 'DESC');

                                      
        $data['manage_package'] = $this->db->get()->result_array();


        $this->db->select('manage_package.*,city.city,user_type.user_type_name');
        $this->db->from('manage_package');
        $this->db->join('city','city.city_id = manage_package.city_id');
        $this->db->join('user_type','user_type.user_type_id = manage_package.service_id');
        $this->db->where('manage_package.package_status',1);
        $this->db->order_by('manage_package.package_id', 'DESC');
                                      
        $data['book_package'] = $this->db->get()->result_array();

        $this->load->view('user/dashboard',$data);
    }
    public function payby_paytm()
    {
       extract($_POST);
     // echo "<pre>";
     // print_r($_POST);
     //echo $_POST['total_price']."<br>";
      
   //   echo $deduct_amount;
     // exit;

      if (!empty($_POST['grand_total']) || !empty($_POST['total_price'])) 
      {
    		

    		$posted = $_POST;
            
            if($_POST['grand_total'] !='')
    		{
    			$grand_total= explode(' ',$posted['grand_total']);
    			
                $voucher= explode(' ',$posted['voucher_discount']);

                $discount=$voucher[1];
                $amount=$posted['total_price']-$posted['wallet_deduction']-$discount;
               // echo $amount;

            }
    		else
    		{

    			$amount=$posted['total_price'];
                $discount=0;

    			
    		}	
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
            $paytmParams["MERC_UNQ_REF"]=$posted['user_id'].",".$discount.",".$_POST['wallet_deduction'].",".$_POST['coupon_code'].",".$_POST['voucher_id'];

           
    		
		    $paytmChecksum = $this->stack_web_gateway_paytm_kit->getChecksumFromArray($paytmParams, PAYTM_MERCHANT_KEY);
		    $paytmParams["CHECKSUMHASH"] = $paytmChecksum;
		   
		    $transactionURL = PAYTM_TXN_URL;
    		

    		$data = array();
    		$data['paytmParams'] 	= $paytmParams;
    		$data['transactionURL'] = $transactionURL;
    		
    		
    		$this->load->view('user/payby_paytm',$data);
    	}
    }

    public function paytm_response(){


    	$paytmChecksum 	= "";
		$paramList 		= array();
		$isValidChecksum= "FALSE";

		$paramList = $_POST;
       

       $MERC_UNQ_REF= explode(',', $_POST['MERC_UNQ_REF']);
      


     
      
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
		// print_r($paytmChecksum);
		// exit;
		// header("Pragma: no-cache");
		// header("Cache-Control: no-cache");
		// header("Expires: 0");
       
         $wallet_deduction=$MERC_UNQ_REF[2];
          $voucher_id=$MERC_UNQ_REF[4];

           
		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = $this->stack_web_gateway_paytm_kit->verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


		if($isValidChecksum == "TRUE") 
        {
			//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
			
		              

			if ($_POST["STATUS"] == "TXN_SUCCESS") {

                 
                    $this->db->select('*');
                    $this->db->from('cart');
                    $this->db->where('user_id',$MERC_UNQ_REF[0]);
                    $cart_details = $this->db->get()->result_array();

                    $total_cart_count=count($cart_details);

                     

                    $i = 0;
                    foreach($cart_details as $carts){

                       
                       

                        $user_type_id_fetch=$carts['user_type_id'];
                        $cart_id=$carts['cart_id'];
                        $package_id=$carts['package_id'];
                        $user_id = $carts['user_id'];
                        $patient_id = $carts['patient_id'];
                        $date = $carts['date'];
                        $time = $carts['time'];
                        $days=$carts['days'];
                        $doctor_type_id = $carts['doctor_type_id'];
                        $nurse_service_id = $carts['nurse_service_id'];
                        $lab_test_id=$carts['lab_test_id'];
                        $address_id = $carts['address'];
                        $contactPerson = $carts['contactPerson'];
                        $mobileNumber=$carts['mobileNumber'];
                        $landlineNumber=$carts['landlineNumber'];
                        $addressPatient=$carts['addressPatient'];
                        $cityId=$carts['cityId'];
                        $type=$carts['type'];
                        $age=$carts['age'];
                        $gender=$carts['gender'];
                        $amount=$carts['amount'];
                         $complain=$carts['complain'];

                        $from_address=$carts['from_address'];
                        $to_address=$carts['to_address'];
                        $condition=$carts['condition'];
                         $multi_city=$carts['multi_city'];
                         $prescription=$carts['prescription'];
                        

                         $responsestatus=$_POST["STATUS"];
                         $responsecode=$_POST["RESPCODE"];
                         $txnid=$_POST['TXNID'];
                         $paymentmade=$_POST['PAYMENTMODE'];
                         $txndate=$_POST['TXNDATE'];
                         $gatewayname=$_POST['GATEWAYNAME'];
                         $banktxnid=$_POST['BANKTXNID'];
                         $bankname=$_POST['BANKNAME'];
                       // doctor_type_id

                                    if($MERC_UNQ_REF[2]!='')
                                    {
                                         $this->db->select('balance');
                                         $this->db->from('user');
                                        $this->db->where('user_id',$MERC_UNQ_REF[0]);
                                        $wallet_balance = $this->db->get()->row_array();  

                                        

                                         if ($wallet_balance['balance'] == 0) 
                                         {
                                           
                                               
                                                 $final=$wallet_balance['balance']-0;
                                                  $this->db->where('user_id',$MERC_UNQ_REF[0]);
                                                  $this->db->update('user', array('balance' => $final));

                                                
                      
                                        }
                                        else if($wallet_balance['balance'] > 50)
                                        {

                                            
                                                    $final=$wallet_balance['balance']-50;
                                                   

                                                    $this->db->where('user_id',$MERC_UNQ_REF[0]);
                                                    $this->db->update('user', array('balance' => $final));
                                        }
                                        else
                                        {

                                           
                                                $final=$wallet_balance['balance']-$wallet_balance['balance'];
                                               

                                             $this->db->where('user_id',$MERC_UNQ_REF[0]);
                                            $this->db->update('user', array('balance' => $final));
                                        }

                                    }
                        
                        if($user_type_id_fetch==1 && $package_id==0)
                        {

                                 $this->db->select('voucher.*');
                                 $this->db->from('voucher');
                                $this->db->where('voucher.service_id',$user_type_id_fetch);
                                 $this->db->where('voucher.code',$MERC_UNQ_REF[3]);
                                $this->db->or_where('voucher.all_service',1);
                                $voucher_data = $this->db->get()->result_array();
                                 $record_count= count($voucher_data);
                                 if($record_count > 0)
                                 {
                                    $discount=$MERC_UNQ_REF[1];
                                 }
                                 else
                                 {
                                     $discount=0;
                                 }
                                // echo count($voucher_data);
                                // exit;
                                $doctor_appointment_array = array(
                                'user_id'=>$user_id,
                                'patient_id'=>$patient_id,
                                'date'=>$date ,
                                'time'=>$time,
                                'doctor_type_id'=>$doctor_type_id,
                                'address_id'=>$address_id,
                                'confirm'=>1,
                                'order_id'=>$_POST['ORDERID'],
                                'total'=>$amount,
                                'discount'=>$discount,
                                'responsestatus'=>$responsestatus,
                                'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname,
                                'paid_flag' => 1
                             );
                             //;
                              if($this->db->insert("appointment_book",$doctor_appointment_array))
                              {
                                        $this->db->select('member.*');
                                 $this->db->from('member');
                                $this->db->where('member.member_id',$patient_id);
                                $patient_details = $this->db->get()->row_array();
                               // echo $this->db->last_query();
                                //exit;

                                $message="Hi '".$patient_details['name']."' we have scheduled your appointment today Dt '".$date."' & Time'".$time."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
";
                                    $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
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
                                    
                                    
                                    $this->db->select('user.email,user.mobile');
                                    $this->db->from('user');
                                    $this->db->where('user.user_id',$user_id);
                                    $user_data = $this->db->get()->row_array();

                                     if ($user_data[email] != '') {
                                $curl = curl_init();

                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress=' . $user_data[email] . '',
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
                                $err = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    // echo "cURL Error #:" . $err;
                                } else {
                                    //   echo $response;
                                }
                            } elseif ($user_data[mobile] != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/RetrieveLeadByPhoneNumber?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&phone=' . $user_data[mobile] . '',
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
                                $err = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    // echo "cURL Error #:" . $err;
                                } else {
                                    //   echo $response;
                                }
                            }

                                      $appointment_date = date($date.' H:i:s');
                                       $appointment_time = date($date.' '.$time);
                                     
                                    $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":147,"ActivityNote":"Book Doctor Appoinment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":"'.$complain.'"},{"SchemaName":"mx_Custom_4","Value":"'.$doctor_type_id.'"},{"SchemaName":"mx_Custom_5","Value":"'.$appointment_date.'"},{"SchemaName":"mx_Custom_6","Value":"'.$appointment_time.'"},]}';
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
                                      //  echo $json_response;
                                            curl_close($curl);
                                    } catch (Exception $ex) 
                                    { 
                                        curl_close($curl);
                                    }
                                    
                                        $this->db->select('*');
                                        $this->db->from('appointment_book');
                                        $this->db->where('order_id',$_POST['ORDERID']);
                                        $this->db->where('user_id',$MERC_UNQ_REF[0]);
                                        $this->db->where('patient_id',$patient_id);
                                        $this->db->where('date',$date);
                                        $appointment_data = $this->db->get()->result_array();
                                        foreach($appointment_data as $appointment){

                                             $docapmt_id = $appointment['appointment_book_id'];
                                        }



                                        $this->db->select('*');
                                        $this->db->from('doctor_type');
                                        $this->db->where('doctor_type.d_type_id',$doctor_type_id);
                                        $doctor_type = $this->db->get()->result_array();
                                        foreach($doctor_type as $doctor){

                                             $typedoc = $doctor['doctor_type_name'];
                                        }

                                        $extra_invoice = array(
                                                'list'=>$typedoc." Doctor visit",
                                                'price'=>$amount,
                                                'patient_id'=>$patient_id,
                                                'user_id'=>$user_id,
                                                'doctor_id'=>60,
                                                'appointment_book_id'=>$docapmt_id ,
                                                'date'=>$txndate,
                                                'discount'=>$MERC_UNQ_REF[1],
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$txnid,
                                                'devicetype'=> '',
                                                'appmt_date'=>$date,
                                                'order_id'=>$_POST['ORDERID'],
                                                'no_of_days'=>0,
                                                'time'=>$time,
                                                'reference_id'=>'',
                                            );
                                            $this->db->insert("extra_invoice",$extra_invoice);
                                 }

                                 
                              // echo $this->db->last_query()."<br>";
                                $i++;
                                
                                //exit;
                            
                        }
                        if($user_type_id_fetch==2 && $package_id==0)
                        {
                                $this->db->select('voucher.*');
                                 $this->db->from('voucher');
                                $this->db->where('voucher.service_id',$user_type_id_fetch);
                                 $this->db->where('voucher.code',$MERC_UNQ_REF[3]);
                                $this->db->or_where('voucher.all_service',1);
                                $voucher_data = $this->db->get()->result_array();
                                $record_count= count($voucher_data);
                                if($record_count > 0)
                                 {
                                    $discount=$MERC_UNQ_REF[1];
                                 }
                                 else
                                 {
                                     $discount=0;
                                 }
                               // exit;
                                // echo $this->db->last_query();
                                // //echo count($voucher_data);
                                // exit;
                           if($amount!=0)
                           {
                                $nurse_appointment_array = array(
                                'user_id'=>$user_id,
                                'patient_id'=>$patient_id,
                                'date'=>$date,
                                'time'=>$time,
                                'confirm'=>1,
                                'type'=>$nurse_service_id,
                                'address_id'=>$address_id,
                                'order_id'=>$_POST['ORDERID'],
                                'total'=>$amount,
                                 'discount'=>$discount,
                                'responsestatus'=>$responsestatus,
                                'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname,
                                'paid_flag' => 1
                             );
                               if($this->db->insert("book_nurse",$nurse_appointment_array))
                               {
                                   
                                        $this->db->select('member.*');
                                     $this->db->from('member');
                                     $this->db->where('member.member_id',$patient_id);
                                    $patient_details = $this->db->get()->row_array();

                                    $message="Hi '".$patient_details['name']."' we have scheduled your appointment today Dt '".$date."' & Time'".$time."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
";
                                    $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
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
                                    
                                    $this->db->select('user.email,user.mobile');
                                    $this->db->from('user');
                                    $this->db->where('user.user_id',$user_id);
                                    $user_data = $this->db->get()->row_array();

                                    if ($user_data[email] != '') {
                                $curl = curl_init();

                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress=' . $user_data[email] . '',
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
                                $err = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    // echo "cURL Error #:" . $err;
                                } else {
                                    //   echo $response;
                                }
                            } elseif ($user_data[mobile] != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/RetrieveLeadByPhoneNumber?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&phone=' . $user_data[mobile] . '',
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
                                $err = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    // echo "cURL Error #:" . $err;
                                } else {
                                    //   echo $response;
                                }
                            }


                                       $appointment_date = date($date.' H:i:s');
                                        $appointment_time = date($date.' '.$time);

                                      $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":150,"ActivityNote":"Your Activity Note","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":"'.$complain.'"},{"SchemaName":"mx_Custom_4","Value":"'.$nurse_service_id.'"},{"SchemaName":"mx_Custom_5","Value":"'.$appointment_date.'"},{"SchemaName":"mx_Custom_6","Value":"'.$appointment_time.'"},{"SchemaName":"mx_Custom_7","Value":"'.$days.'"},]}';
                                      
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
                                          //  echo $json_response;
                                                curl_close($curl);
                                        } catch (Exception $ex) 
                                        { 
                                            curl_close($curl);
                                        }
                                    
                                        $this->db->select('*');
                                        $this->db->from('book_nurse');
                                        $this->db->where('order_id',$_POST['ORDERID']);
                                        $this->db->where('user_id',$MERC_UNQ_REF[0]);
                                        $this->db->where('patient_id',$patient_id);
                                        $this->db->where('date',$date);
                                        $nurse_appointment = $this->db->get()->result_array();
                                        foreach($nurse_appointment as $appointment){

                                             $nurseapmt_id = $appointment['book_nurse_id'];
                                        }


                                               $this->db->select('*');
                                            $this->db->from('nurse_service_type');
                                            $this->db->where('nurse_service_type.nurse_service_id',$nurse_service_id);
                                            $nurse_type = $this->db->get()->result_array();
                                            foreach($nurse_type as $nurse){

                                                 $typenurse = $nurse['nurse_service_name'];
                                            }
                                       
                                        

                                         


                                         //working progress 30/1/2021
                                            $nurse_extra_invoice = array(
                                                'list'=>"Nurse ".$typenurse,
                                                'price'=>$amount-$discount,
                                                'patient_id'=>$patient_id,
                                                'user_id'=>$user_id,
                                                //'doctor_id'=>60,
                                                'book_nurse_id'=>$nurseapmt_id ,
                                                'date'=>$txndate,
                                                'discount'=>$MERC_UNQ_REF[1],
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$txnid,
                                                'devicetype'=> '',
                                                'appmt_date'=>$date,
                                                'order_id'=>$_POST['ORDERID'],
                                                'no_of_days'=>$days,
                                                'time'=>$time,
                                                'reference_id'=>'',
                                            );
                                            $this->db->insert("extra_invoice",$nurse_extra_invoice);  
                                }
                            
                                $i++;
                           }
                                
                            
                        }
                        if($user_type_id_fetch==3 && $package_id==0)
                        {
                                $this->db->select('voucher.*');
                                 $this->db->from('voucher');
                                $this->db->where('voucher.service_id',$user_type_id_fetch);
                                 $this->db->where('voucher.code',$MERC_UNQ_REF[3]);
                                $this->db->or_where('voucher.all_service',1);
                                $voucher_data = $this->db->get()->result_array();
                                $record_count= count($voucher_data);
                                if($record_count > 0)
                                 {
                                    $discount=$MERC_UNQ_REF[1];
                                 }
                                 else
                                 {
                                     $discount=0;
                                 }

                                 if($complain!='')
                                {
                                    $complain_add=$complain;
                                }
                                else
                                {
                                    $complain_add="";
                                }
                                $lab_appointment_array = array(


                                    'user_id'=>$user_id,
                                    'patient_id'=>$patient_id,
                                    'lab_test_id'=>$lab_test_id,
                                    'date'=>$date,
                                    'time'=>$time,
                                    'confirm'=>1,
                                    'complain'=>$complain_add,
                                    'address_id'=>$address_id,
                                     'order_id'=>$_POST['ORDERID'],
                                    'total'=>$amount,
                                     'discount'=>$discount,
                                    'prescription'=>$prescription,
                                    'responsestatus'=>$responsestatus,
                                    'responsecode'=> $responsecode,
                                    'txnid'=>$txnid,
                                    'paymentmade'=>$paymentmade,
                                    'txndate'=>$txndate,
                                    'gatewayname'=>$gatewayname,
                                    'banktxnid'=>$banktxnid,
                                    'bankname'=>$bankname,
                                    'paid_flag' => 1
                                    
                                );
                              if($this->db->insert("book_laboratory_test",$lab_appointment_array))
                              {
                                        $this->db->select('member.*');
                                     $this->db->from('member');
                                     $this->db->where('member.member_id',$patient_id);
                                    $patient_details = $this->db->get()->row_array();

                                    $message="Hi '".$patient_details['name']."' we have scheduled your appointment today Dt '".$date."' & Time'".$time."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
";
                                    $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
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
                                    
                                    
                                    $this->db->select('user.email,user.mobile');
                                    $this->db->from('user');
                                    $this->db->where('user.user_id',$user_id);
                                    $user_data = $this->db->get()->row_array();

                                    if ($user_data[email] != '') {
                                $curl = curl_init();

                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress=' . $user_data[email] . '',
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
                                $err = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    // echo "cURL Error #:" . $err;
                                } else {
                                    //   echo $response;
                                }
                            } elseif ($user_data[mobile] != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/RetrieveLeadByPhoneNumber?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&phone=' . $user_data[mobile] . '',
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
                                $err = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    // echo "cURL Error #:" . $err;
                                } else {
                                    //   echo $response;
                                }
                            }

                                     
                                    $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":156,"ActivityNote":"Your Activity Note","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$address_id.'"},{"SchemaName":"mx_Custom_3","Value":"'.$lab_test_id.'"},{"SchemaName":"mx_Custom_4","Value":"'.date('Y-m-d H:i:s').'"},{"SchemaName":"mx_Custom_5","Value":"'.date('Y-m-d H:i:s').'"},{"SchemaName":"mx_Custom_6","Value":"'.$complain_add.'"},{"SchemaName":"mx_Custom_7","Value":"'.$prescription.'"},]}';
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
                                      //  echo $json_response;
                                            curl_close($curl);
                                    } catch (Exception $ex) 
                                    { 
                                        curl_close($curl);
                                    }
                                        $this->db->select('*');
                                        $this->db->from('book_laboratory_test');
                                        $this->db->where('order_id',$_POST['ORDERID']);
                                        $this->db->where('user_id',$MERC_UNQ_REF[0]);
                                        $this->db->where('patient_id',$patient_id);
                                        $this->db->where('date',$date);
                                        $lab_appointment = $this->db->get()->result_array();
                                        foreach($lab_appointment as $appointment){

                                             $labapmt_id = $appointment['book_laboratory_test_id'];
                                        }
                                            $this->db->select('*');
                                            $this->db->from('lab_test_type');
                                            $this->db->where('lab_test_type.lab_test_id',$lab_test_id);
                                            $lab_test_type = $this->db->get()->result_array();
                                            foreach($lab_test_type as $lab){

                                                 $typelab = $lab['lab_test_type_name'];
                                            }
                                       
                                            //working progress 30/1/2021
                                            $lab_extra_invoice = array(
                                                'list'=>$typelab." Appointment",
                                                'price'=>$amount-$discount,
                                                'patient_id'=>$patient_id,
                                                'user_id'=>$user_id,
                                                //'doctor_id'=>60,
                                                'book_laboratory_test_id'=>$labapmt_id,
                                                'date'=>$txndate,
                                                'discount'=>$MERC_UNQ_REF[1],
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$txnid,
                                                'devicetype'=> '',
                                                'appmt_date'=>$date,
                                                'order_id'=>$_POST['ORDERID'],
                                                'no_of_days'=>$days,
                                                'time'=>$time,
                                                'reference_id'=>'',
                                            );
                                            $this->db->insert("extra_invoice",$lab_extra_invoice);
                              }
                               
                                $i++;
                            
                        }
                       
                        if($user_type_id_fetch==5 && $package_id==0)
                        {
                           

                                $this->db->select('voucher.*');
                                 $this->db->from('voucher');
                                $this->db->where('voucher.service_id',$user_type_id_fetch);
                                 $this->db->where('voucher.code',$MERC_UNQ_REF[3]);
                                $this->db->or_where('voucher.all_service',1);
                                $voucher_data = $this->db->get()->result_array();
                                $record_count= count($voucher_data);
                                if($record_count > 0)
                                 {
                                    $discount=$MERC_UNQ_REF[1];
                                 }
                                 else
                                 {
                                     $discount=0;
                                 }
                                if($type==1)
                                {
                                        $ambulance_appointment_array = array(
                                        'patient_id'=>$patient_id,
                                        'user_id'=>$user_id,
                                        //'name'=>$contactPerson,
                                       // 'age'=>$age,
                                       // 'gender'=>$gender,
                                        'mobile1'=>$mobileNumber,
                                       // 'mobile2'=>$mobileNumber,
                                        'landline'=>$landlineNumber." ",
                                        'city_id'=>$cityId,
                                        'from_address'=>$from_address,
                                        'to_address'=>$to_address,
                                        'condition'=>$condition,
                                        'date'=>$date,
                                        'time'=>$time,
                                        'type_id'=>$type,
                                         'order_id'=>$_POST['ORDERID'],
                                    'amount'=>$amount, 

                                     'discount'=>$discount,  
                                         'responsestatus'=>$responsestatus,
                                         'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname,
                                'paid_flag' => 1
                                        
                                        );
                                }
                                if($type==2)
                                {
                                     $ambulance_appointment_array = array(
                                        'patient_id'=>$patient_id,
                                        'user_id'=>$user_id,
                                       // 'name'=>$contactPerson,
                                       // 'age'=>$age,
                                       // 'gender'=>$gender,
                                        'mobile1'=>$mobileNumber,
                                       // 'mobile2'=>$mobileNumber,
                                        'landline'=>$landlineNumber." ",
                                        'city_id'=>$cityId,
                                        'from_address'=>$from_address,
                                        'to_address'=>$to_address,
                                        'condition'=>$condition,
                                        'date'=>$date,
                                        'time'=>$time,
                                        'type_id'=>$type,
                                         'order_id'=>$_POST['ORDERID'],
                                   'amount'=>$amount, 
                                    
                                     'discount'=>$discount, 
                                         'responsestatus'=>$responsestatus,
                                         'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname,
                                'paid_flag' => 1
                                        
                                        );
                                }
                                if($type==3)
                                {
                                    $ambulance_appointment_array = array(
                                    'patient_id'=>$patient_id,
                                    'user_id'=>$user_id,
                                    'city_id'=>$cityId,
                                   // 'name'=>$contactPerson,
                                  //  'age'=>$age,
                                   // 'gender'=>$gender,
                                    'mobile1'=>$mobileNumber,
                                   // 'mobile2'=>$mobileNumber,
                                    'landline'=>$landlineNumber." ",
                                    //'city_id'=>$post['city_id'],
                                    'multi_city'=>$multi_city,
                                    'date'=>date('Y-m-d'),
                                    'type_id'=>$type,
                                     'order_id'=>$_POST['ORDERID'],
                                    'amount'=>$amount, 
                                    
                                     'discount'=>$discount, 
                                    'responsestatus'=>$responsestatus,
                                    'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname,
                                'paid_flag' => 1
                                    

                                    
                                    );
                                }
                                if($this->db->insert('book_ambulance', $ambulance_appointment_array)){
                                    $this->db->select('member.*');
                                     $this->db->from('member');
                                     $this->db->where('member.member_id',$patient_id);
                                    $patient_details = $this->db->get()->row_array();

                                    $message="Hi '".$patient_details['name']."' we have scheduled your appointment today Dt '".$date."' & Time'".$time."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
";
                                    $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$patient_details['contact_no'];
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
                                     $book_ambulance_id = $this->db->insert_id();
                                     if($type==1)
                                     {
                                        $book_ambulance_type="ONEWAY";
                                     }
                                     elseif($type==2)
                                     {
                                         $book_ambulance_type="Round trip";
                                     }
                                     else
                                     {
                                         $book_ambulance_type="Multi Location";
                                     }
                                        
                                        
                                    $this->db->select('user.email,user.mobile');
                                    $this->db->from('user');
                                    $this->db->where('user.user_id',$user_id);
                                    $user_data = $this->db->get()->row_array();

                                    if ($user_data[email] != '') {
                                $curl = curl_init();

                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress=' . $user_data[email] . '',
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
                                $err = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    // echo "cURL Error #:" . $err;
                                } else {
                                    //   echo $response;
                                }
                            } elseif ($user_data[mobile] != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/RetrieveLeadByPhoneNumber?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&phone=' . $user_data[mobile] . '',
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
                                $err = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    // echo "cURL Error #:" . $err;
                                } else {
                                    //   echo $response;
                                }
                            }

                                     $date_of_time=date($date.' H:i:s');
                                    $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":153,"ActivityNote":"Your Activity Note","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$patient_id.'"},{"SchemaName":"mx_Custom_2","Value":"'.$mobileNumber.'"},{"SchemaName":"mx_Custom_3","Value":"'.$landlineNumber.'"},{"SchemaName":"mx_Custom_4","Value":"'.$cityId.'"},{"SchemaName":"mx_Custom_5","Value":"'.$date.'"},{"SchemaName":"mx_Custom_6","Value":"'.$date_of_time.'"},{"SchemaName":"mx_Custom_7","Value":"'.$multi_city.'"},]}';
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
                                      //  echo $json_response;
                                            curl_close($curl);
                                    } catch (Exception $ex) 
                                    { 
                                        curl_close($curl);
                                    }

                                      $ambulance_extra_invoice = array(
                                                'list'=>$book_ambulance_type." Ambulance Appointment",
                                                'price'=>$amount-$discount,
                                                'patient_id'=>$patient_id,
                                                'user_id'=>$user_id,
                                                //'doctor_id'=>60,
                                                'book_ambulance_id'=>$book_ambulance_id,
                                                'date'=>$txndate,
                                                'discount'=>$MERC_UNQ_REF[1],
                                                'voucher'=>'',
                                                'credit'=>0,
                                                 'type'=>'Paytmonline',
                                                'txnid'=>$txnid,
                                                'devicetype'=> '',
                                                'appmt_date'=>$date,
                                                'order_id'=>$_POST['ORDERID'],
                                                'no_of_days'=>$days,
                                                'time'=>$time,
                                                'reference_id'=>'',
                                            );
                                            $this->db->insert("extra_invoice",$ambulance_extra_invoice);

                                }

                                 $i++;
                                
                            
                        }

                        if($package_id!=0)
                        {

                              $this->db->select('*');
                              $this->db->from('manage_package');
                              $this->db->where('package_id',$package_id);
                              $package_data_result = $this->db->get()->result_array();




                            //$packageList = array();
                            foreach($package_data_result as $package){ 

                                $date = date('Y-m-d H:i:s');

                                $date = strtotime($date);
                                 $expired_date = strtotime("+".$package['validate_month']."day", $date);
                                $expired_date = date('Y-m-d', $expired_date);

                                 $book_package = array(
            
                                'user_id'=>$user_id,
                                'package_id'=>$package['package_id'],
                                'service_id'=>$user_type_id_fetch,
                                'purchase_date'=>date('Y-m-d'),
                                'no_visit'=>$package['no_visit'],
                                'available_visit'=>$package['no_visit'],
                                'no_days'=>$package['validate_month'],
                                'expire_date'=> $expired_date,
                                'patient_id'=>$patient_id,
                                'order_id'=>$_POST['ORDERID'],
                                'total'=>$amount, 
                                'responsestatus'=>$responsestatus,
                                'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname

                               
                                
                                 );
                                $this->db->insert('book_package',$book_package);
                                     

                            }
                            $i++;
                        }





                        if($cart_id!='')
                        {
                            $this->db->where('cart_id',$cart_id);
                             $this->db->delete('cart');
                              $i++;
                        }
                        
                        
                        if($voucher_id!='')
                        {

                           $use_promo = array(
            
                                'user_id'=>$user_id,
                                'voucher_id'=>$voucher_id
                               );
                                $this->db->insert('user_promocode_rel',$use_promo);

                        }

                         
                    }

				//  echo "<b>Transaction status is success</b>" . "<br/>";
				 // redirect(base_url().'user/dashboard');
                  //redirect(base_url()."user/dashboard",'refresh');
                    //redirect(base_url()."user/successPaymentPage",'refresh');
                    redirect(base_url()."successPaymentPage",'refresh');
				
			}
			else {


                    $this->db->select('*');
                    $this->db->from('cart');
                    $this->db->where('user_id',$MERC_UNQ_REF[0]);
                    $cart_details = $this->db->get()->result_array();
                 

                    $i = 0;
                    foreach($cart_details as $carts){

                        $user_type_id_fetch=$carts['user_type_id'];
                        $cart_id=$carts['cart_id'];
                        $package_id=$carts['package_id'];
                        $user_id = $carts['user_id'];
                        $patient_id = $carts['patient_id'];
                        $date = $carts['date'];
                        $time = $carts['time'];
                        $doctor_type_id = $carts['doctor_type_id'];
                        $nurse_service_id = $carts['nurse_service_id'];
                        $lab_test_id=$carts['lab_test_id'];
                        $address_id = $carts['address'];
                        $contactPerson = $carts['contactPerson'];
                        $mobileNumber=$carts['mobileNumber'];
                        $landlineNumber=$carts['landlineNumber'];
                        $addressPatient=$carts['addressPatient'];
                        $cityId=$carts['cityId'];
                        $type=$carts['type'];
                        $age=$carts['age'];
                        $gender=$carts['gender'];

                        $from_address=$carts['from_address'];
                        $to_address=$carts['to_address'];
                        $condition=$carts['condition'];
                         $multi_city=$carts['multi_city'];
                         $prescription=$carts['prescription'];
                        

                         $responsestatus=$_POST["STATUS"];
                         $responsecode=$_POST["RESPCODE"];
                         $txnid=$_POST['TXNID'];
                         $paymentmade=$_POST['PAYMENTMODE'];
                         $txndate=$_POST['TXNDATE'];
                         $gatewayname=$_POST['GATEWAYNAME'];
                         $banktxnid=$_POST['BANKTXNID'];
                         $bankname=$_POST['BANKNAME'];
                       // doctor_type_id
                        
                        if($user_type_id_fetch==1 && $package_id==0)
                        {
                           
                                $doctor_appointment_array = array(
                                'user_id'=>$user_id,
                                'patient_id'=>$patient_id,
                                'date'=>$date ,
                                'time'=>$time,
                                'confirm'=>1,
                                'doctor_type_id'=>$doctor_type_id,
                                'address_id'=>$address_id,
                                'order_id'=>$_POST['ORDERID'],
                                'total'=>$_POST['TXNAMOUNT'],
                                'responsestatus'=>$responsestatus,
                                'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname
                             );
                              $this->db->insert("appointment_book",$doctor_appointment_array);
                               //echo $this->db->last_query()."<br>";
                                $i++;
                            
                        }
                        if($user_type_id_fetch==2 && $package_id==0)
                        {
                           
                                $nurse_appointment_array = array(
                                'user_id'=>$user_id,
                                'patient_id'=>$patient_id,
                                'date'=>$date,
                                'time'=>$time,
                                'confirm'=>1,
                                'type'=>$nurse_service_id,
                                'address_id'=>$address_id,
                                'order_id'=>$_POST['ORDERID'],
                                'total'=>$_POST['TXNAMOUNT'],
                                'responsestatus'=>$responsestatus,
                                'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname
                             );
                               $this->db->insert("book_nurse",$nurse_appointment_array);
                            //    echo $this->db->last_query()."<br>";
                                $i++;
                            
                        }
                        if($user_type_id_fetch==3 && $package_id==0)
                        {
                           
                                if($complain!='')
                                {
                                    $complain_add=$complain;
                                }
                                else
                                {
                                    $complain_add="";
                                }
                                $lab_appointment_array = array(


                                    'user_id'=>$user_id,
                                    'patient_id'=>$patient_id,
                                    'lab_test_id'=>$lab_test_id,
                                    'date'=>$date,
                                    'time'=>$time,
                                    'complain'=>$complain_add,
                                    'confirm'=>1,
                                    'address_id'=>$address_id,
                                     'order_id'=>$_POST['ORDERID'],
                                    'total'=>$_POST['TXNAMOUNT'],
                                    'prescription'=>$prescription,
                                    'responsestatus'=>$responsestatus,
                                    'responsecode'=> $responsecode,
                                    'txnid'=>$txnid,
                                    'paymentmade'=>$paymentmade,
                                    'txndate'=>$txndate,
                                    'gatewayname'=>$gatewayname,
                                    'banktxnid'=>$banktxnid,
                                    'bankname'=>$bankname
                                    
                                );
                              $this->db->insert("book_laboratory_test",$lab_appointment_array);
                               
                                $i++;
                            
                        }
                        // if($user_type_id_fetch==4 && $package_id==0)
                        // {
                           
                        //        $pharmacy_appointment_array = array(


                        //             'user_id'=>$user_id,
                        //             'name'=>$contactPerson,
                        //             'mobile'=>$mobileNumber,
                        //             'landline'=>$landlineNumber,
                        //             'address'=>$addressPatient,
                        //             'city_id'=>$cityId,
                        //             'created_date'=>date('Y-m-d H:i:s'),
                        //             'prescription'=>$prescription

                        //         );
                        //        $this->db->insert("book_medicine",$pharmacy_appointment_array);
                        //     //    echo $this->db->last_query()."<br>";
                        //         $i++;
                            
                        // }
                        if($user_type_id_fetch==5 && $package_id==0)
                        {
                           


                                if($type==1)
                                {
                                        $ambulance_appointment_array = array(
                                        'patient_id'=>$patient_id,
                                        'user_id'=>$user_id,
                                        'name'=>$contactPerson,
                                        'age'=>$age,
                                        'gender'=>$gender,
                                        'mobile1'=>$mobileNumber,
                                        'mobile2'=>$mobileNumber,
                                        'landline'=>$landlineNumber,
                                        'city_id'=>$cityId,
                                        'from_address'=>$from_address,
                                        'to_address'=>$to_address,
                                        'condition'=>$condition,
                                        'date'=>$date,
                                        'time'=>$time,
                                        'type_id'=>$type,
                                         'order_id'=>$_POST['ORDERID'],
                                    'amount'=>$_POST['TXNAMOUNT'],   
                                         'responsestatus'=>$responsestatus,
                                         'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname
                                        
                                        );
                                }
                                if($type==2)
                                {
                                     $ambulance_appointment_array = array(
                                        'patient_id'=>$patient_id,
                                        'user_id'=>$user_id,
                                        'name'=>$contactPerson,
                                        'age'=>$age,
                                        'gender'=>$gender,
                                        'mobile1'=>$mobileNumber,
                                        'mobile2'=>$mobileNumber,
                                        'landline'=>$landlineNumber,
                                        'city_id'=>$cityId,
                                        'from_address'=>$from_address,
                                        'to_address'=>$to_address,
                                        'condition'=>$condition,
                                        'date'=>$date,
                                        'time'=>$time,
                                        'type_id'=>$type,
                                         'order_id'=>$_POST['ORDERID'],
                                    'amount'=>$_POST['TXNAMOUNT'],
                                         'responsestatus'=>$responsestatus,
                                         'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname
                                        
                                        );
                                }
                                if($type==3)
                                {
                                    $ambulance_appointment_array = array(
                                    'patient_id'=>$patient_id,
                                    'user_id'=>$user_id,
                                    'city_id'=>$cityId,
                                    'name'=>$contactPerson,
                                    'age'=>$age,
                                    'gender'=>$gender,
                                    'mobile1'=>$mobileNumber,
                                    'mobile2'=>$mobileNumber,
                                    'landline'=>$landlineNumber,
                                    'date'=>$date,
                                    'time'=>$time,
                                    //'city_id'=>$post['city_id'],
                                    'multi_city'=>$multi_city,
                                    'date'=>date('Y-m-d'),
                                    'type_id'=>$type,
                                     'order_id'=>$_POST['ORDERID'],
                                    'amount'=>$_POST['TXNAMOUNT'],
                                    'responsestatus'=>$responsestatus,
                                    'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname
                                    

                                    
                                    );
                                }
                                $this->db->insert('book_ambulance', $ambulance_appointment_array);
                                 $i++;
                                
                            
                        }

                        if($package_id!=0)
                        {

                              $this->db->select('*');
                              $this->db->from('manage_package');
                              $this->db->where('package_id',$package_id);
                              $package_data_result = $this->db->get()->result_array();




                            //$packageList = array();
                            foreach($package_data_result as $package){ 

                                $date = date('Y-m-d H:i:s');

                                $date = strtotime($date);
                                 $expired_date = strtotime("+".$package['validate_month']."day", $date);
                                $expired_date = date('Y-m-d', $expired_date);

                                 $book_package = array(
            
                                'user_id'=>$user_id,
                                'package_id'=>$package['package_id'],
                                'service_id'=>$user_type_id_fetch,
                                'purchase_date'=>date('Y-m-d'),
                                'no_visit'=>$package['no_visit'],
                                'available_visit'=>$package['no_visit'],
                                'no_days'=>$package['validate_month'],
                                'expire_date'=> $expired_date,
                                'patient_id'=>$patient_id,
                                'order_id'=>$_POST['ORDERID'],
                                'total'=>$_POST['TXNAMOUNT'],
                                'responsestatus'=>$responsestatus,
                                'responsecode'=> $responsecode,
                                'txnid'=>$txnid,
                                'paymentmade'=>$paymentmade,
                                'txndate'=>$txndate,
                                'gatewayname'=>$gatewayname,
                                'banktxnid'=>$banktxnid,
                                'bankname'=>$bankname

                               
                                
                                 );
                                $this->db->insert('book_package',$book_package);
                                     

                            }
                            $i++;
                        }





                        // if($cart_id!='')
                        // {
                        //     $this->db->where('cart_id',$cart_id);
                        //      $this->db->delete('cart');
                        //       $i++;
                        // }
                        


                         
                }

				//echo "<b>Transaction status is failure</b>" . "<br/>";
				//redirect(base_url().'payment_fail');
                redirect(base_url()."FailPaymentPage",'refresh');
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
