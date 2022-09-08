<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package		Payment Gateway PayTM 
 * @author		Chandan Sharma
 * @copyright	Copyright (c) 2008 - 2011, StackOfCodes.in.
 * @link		http://www.chandansharma.co.in/
 * @since		Version 1.0.0
 * @filesource
 */

// ------------------------------------------------------------------------

class Stack_additional_gateway_paytm_kit{

	var $CI;
	public function __construct($config = array())
	{
		$this->CI =& get_instance();

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

			 define('PAYTM_ENVIRONMENT', 'PROD'); 
        
		// For LIVE
		if (PAYTM_ENVIRONMENT == 'PROD') {
		   
			//===================================================
			//	For Production or LIVE Credentials
			//===================================================
			$PAYTM_STATUS_QUERY_NEW_URL='https://secure.paytm.in/oltp/HANDLER_INTERNAL/TXNSTATUS';
			$PAYTM_TXN_URL='https://secure.paytm.in/theia/processTransaction';
			$PAYTM_DOMAIN = 'secure.paytm.in';


		}else{
		    

			$PAYTM_STATUS_QUERY_NEW_URL='https://pguat.paytm.com/oltp/HANDLER_INTERNAL/TXNSTATUS';
			$PAYTM_TXN_URL='https://pguat.paytm.com/theia/processTransaction';
			$PAYTM_DOMAIN = "pguat.paytm.com";

			
			//$PAYTM_CALLBACK_URL 	= require APPPATH . 'views/user/payby_paytm.php';
			
		}

		//Change this constant's value with Merchant key received from Paytm.
		$PAYTM_MERCHANT_MID 		= "Nisarg88193412726992";
		$PAYTM_MERCHANT_KEY 		= "pfAsGexeEaxl2!Y@";

		$PAYTM_CHANNEL_ID 		= "WEB";
		$PAYTM_INDUSTRY_TYPE_ID = "Retail109";
		$PAYTM_MERCHANT_WEBSITE = "DEFAULT";
		
		$PAYTM_CALLBACK_URL 	= base_url()."successAdditionalPayment";
		define('PAYTM_MERCHANT_KEY', $PAYTM_MERCHANT_KEY); 

		
		define('PAYTM_MERCHANT_MID', $PAYTM_MERCHANT_MID);

		define("PAYTM_MERCHANT_WEBSITE", $PAYTM_MERCHANT_WEBSITE);
		define("PAYTM_CHANNEL_ID", $PAYTM_CHANNEL_ID);
		define("PAYTM_INDUSTRY_TYPE_ID", $PAYTM_INDUSTRY_TYPE_ID);
		define("PAYTM_CALLBACK_URL", $PAYTM_CALLBACK_URL);


		define('PAYTM_REFUND_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/REFUND');
		define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		define('PAYTM_TXN_URL', $PAYTM_TXN_URL);



		//===================================================
	}


	public function encrypt_e($input, $ky) {
		$key   = html_entity_decode($ky);
		$iv = "@@@@&&&&####$$$$";
		$data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
		return $data;
	}

	public function decrypt_e($crypt, $ky) {
		$key   = html_entity_decode($ky);
		$iv = "@@@@&&&&####$$$$";
		$data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
		return $data;
	}

	public function generateSalt_e($length) {
		$random = "";
		srand((double) microtime() * 1000000);

		$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
		$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
		$data .= "0FGH45OP89";

		for ($i = 0; $i < $length; $i++) {
			$random .= substr($data, (rand() % (strlen($data))), 1);
		}

		return $random;
	}

	public function checkString_e($value) {
		if ($value == 'null')
			$value = '';
		return $value;
	}

	public function getChecksumFromArray($arrayList, $key, $sort=1) {
		if ($sort != 0) {
			ksort($arrayList);
		}
		//alert("tets");
		$str = $this->getArray2Str($arrayList);
		$salt = $this->generateSalt_e(4);
		$finalString = $str . "|" . $salt;
		$hash = hash("sha256", $finalString);
		$hashString = $hash . $salt;
		$checksum = $this->encrypt_e($hashString, $key);
		return $checksum;
	}
	public function getChecksumFromString($str, $key) {
		
		$salt = $this->generateSalt_e(4);
		$finalString = $str . "|" . $salt;
		$hash = hash("sha256", $finalString);
		$hashString = $hash . $salt;
		$checksum = $this->encrypt_e($hashString, $key);
		return $checksum;
	}

	public function verifychecksum_e($arrayList, $key, $checksumvalue) {
		$arrayList = $this->removeCheckSumParam($arrayList);
		ksort($arrayList);
		$str = $this->getArray2StrForVerify($arrayList);
		$paytm_hash = $this->decrypt_e($checksumvalue, $key);
		$salt = substr($paytm_hash, -4);

		$finalString = $str . "|" . $salt;

		$website_hash = hash("sha256", $finalString);
		$website_hash .= $salt;

		$validFlag = "FALSE";
		if ($website_hash == $paytm_hash) {
			$validFlag = "TRUE";
		} else {
			$validFlag = "FALSE";
		}
		return $validFlag;
	}

	public function verifychecksum_eFromStr($str, $key, $checksumvalue) {
		$paytm_hash = $this->decrypt_e($checksumvalue, $key);
		$salt = substr($paytm_hash, -4);

		$finalString = $str . "|" . $salt;

		$website_hash = hash("sha256", $finalString);
		$website_hash .= $salt;

		$validFlag = "FALSE";
		if ($website_hash == $paytm_hash) {
			$validFlag = "TRUE";
		} else {
			$validFlag = "FALSE";
		}
		return $validFlag;
	}

	public function getArray2Str($arrayList) {
		$findme   = 'REFUND';
		$findmepipe = '|';
		$paramStr = "";
		$flag = 1;	
		foreach ($arrayList as $key => $value) {
			$pos = strpos($value, $findme);
			$pospipe = strpos($value, $findmepipe);
			if ($pos !== false || $pospipe !== false) 
			{
				continue;
			}
			
			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}

	public function getArray2StrForVerify($arrayList) {
		$paramStr = "";
		$flag = 1;
		foreach ($arrayList as $key => $value) {
			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}

	public function redirect2PG($paramList, $key) {
		$hashString = $this->getchecksumFromArray($paramList);
		$checksum = $this->encrypt_e($hashString, $key);
	}


	// public function removeCheckSumParam($arrayList) {
	// 	if (isset($arrayList["CHECKSU
	function removeCheckSumParam($arrayList) {
		if (isset($arrayList["CHECKSUMHASH"])) {
			unset($arrayList["CHECKSUMHASH"]);
		}
		return $arrayList;
	}
	//Api Use for this function

	 function generateSignature($params, $key) {
		if(!is_array($params) && !is_string($params)){
			throw new Exception("string or array expected, ".gettype($params)." given");			
		}
		if(is_array($params)){
			$params = $this->getStringByParams($params);			
		}
		return $this->generateSignatureByString($params, $key);
	}

	public function getStringByParams($params) {
		ksort($params);		
		$params = array_map(function ($value){
			return ($value !== null && strtolower($value) !== "null") ? $value : "";
	  	}, $params);
		return implode("|", $params);
	}

	public function generateSignatureByString($params, $key){
		$salt = $this->generateRandomString(4);
		return $this->calculateChecksum($params, $key, $salt);
	}

	public function generateRandomString($length) {
		$random = "";
		srand((double) microtime() * 1000000);

		$data = "9876543210ZYXWVUTSRQPONMLKJIHGFEDCBAabcdefghijklmnopqrstuvwxyz!@#$&_";	

		for ($i = 0; $i < $length; $i++) {
			$random .= substr($data, (rand() % (strlen($data))), 1);
		}

		return $random;
	}
	public function calculateChecksum($params, $key, $salt){
		$hashString = $this->calculateHash($params, $salt);
		return $this->encrypt_e($hashString, $key);
	}

	public function calculateHash($params, $salt){
		$finalString = $params . "|" . $salt;
		$hash = hash("sha256", $finalString);
		return $hash . $salt;
	}

}