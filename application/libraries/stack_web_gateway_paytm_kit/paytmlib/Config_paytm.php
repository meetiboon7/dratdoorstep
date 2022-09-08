<?php

/*
*|======================================================================|
*|	PayTM Payment Gateway Integration Kit (Stack Version : 1.0.0.0)		|
*|	@Author : Chandan Sharma 											|
*|	@Email: <devchandansh@gmail.com>									|
*|	@Website: <www.chandansharma.co.in>									|
*|	@Authorized Member: <www.stackofcodes.in>							|
*|======================================================================|
*/


/*
- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.
*/

// define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
// define('PAYTM_MERCHANT_KEY', 'O0zUdI1&G%OQViK_'); //Change this constant's value with Merchant key received from Paytm.
// define('PAYTM_MERCHANT_MID', 'dZlzzF17647713571019'); //Change this constant's value with MID (Merchant ID) received from Paytm.
// define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm.


//=================================================
//	For PayTM Settings::
//=================================================

$PAYTM_ENVIRONMENT = "PROD";	// For Production /LIVE
$PAYTM_ENVIRONMENT = "TEST";	// For Staging / TEST

if(!defined("PAYTM_ENVIRONMENT") ){
	define('PAYTM_ENVIRONMENT', $PAYTM_ENVIRONMENT); 
}

// For LIVE
if (PAYTM_ENVIRONMENT == 'PROD') {
	//===================================================
	//	For Production or LIVE Credentials
	//===================================================
	// $PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	// $PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/order/status';
	$PAYTM_TXN_URL='https://securegw-stage.paytm.in/order/process';


}else{
	//===================================================
	//	For Staging or TEST Credentials
	//===================================================
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/order/status';
	$PAYTM_TXN_URL='https://securegw-stage.paytm.in/order/process';

	//Change this constant's value with Merchant key received from Paytm.
	$PAYTM_MERCHANT_MID 		= "DITVVn99850572775009";
	$PAYTM_MERCHANT_KEY 		= "QCevEvDvMb8Iz8Th";

	$PAYTM_CHANNEL_ID 		= "WEB";
	$PAYTM_INDUSTRY_TYPE_ID = "Retail";
	$PAYTM_MERCHANT_WEBSITE = "WEBSTAGING";

	//$PAYTM_CALLBACK_URL 	= require APPPATH . 'views/user/pgResponse.php';
	$PAYTM_CALLBACK_URL 	=require APPPATH."successPayment";
	//echo $PAYTM_CALLBACK_URL;
	// exit;
	
}

define('PAYTM_MERCHANT_KEY', $PAYTM_MERCHANT_KEY); 
define('PAYTM_MERCHANT_MID', $PAYTM_MERCHANT_MID);

define("PAYTM_MERCHANT_WEBSITE", $PAYTM_MERCHANT_WEBSITE);
define("PAYTM_CHANNEL_ID", $PAYTM_CHANNEL_ID);
define("PAYTM_INDUSTRY_TYPE_ID", $PAYTM_INDUSTRY_TYPE_ID);
define("PAYTM_CALLBACK_URL", $PAYTM_CALLBACK_URL);


define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);



// include('encode_paytm.php');
