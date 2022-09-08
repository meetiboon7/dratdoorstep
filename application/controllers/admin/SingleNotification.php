<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");

class SingleNotification extends GeneralController {

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
		
		$this->load->model('admin/Login_model');
		$this->load->model('General_model');
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}

	}

	public function index()
	{	
		 parent::index();

		// $this->db->select('manage_fees.*,manage_roles.role_name,city.city,fees_type.fees_type_name');
		// $this->db->from('manage_fees');
		// $this->db->join('manage_roles','manage_roles.role_id = manage_fees.role_id');
		// $this->db->join('city','city.city_id = manage_fees.city_id');
		// $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
		//  $this->db->order_by('manage_fees.fees_id', 'DESC');
									  
		// $data['manage_fees'] = $this->db->get()->result_array();

		//$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		 $this->load->view(HEADER,$this->viewdata);
		 $this->load->view(ADD_SINGLE_NOTIFICATION, $data);
		 $this->load->view(FOOTER);

		
	}
	public function sendSingleNotification(){
		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);
		// exit;
		//$date = date('Y-m-d');
		$name=$post['title'];
		$desc=$post['desc'];
		$token=$post['token'];
		$date = date('Y-m-d');


		$notification_array = array(
			
			
			'title'=>$name,
			'desc'=>$desc,
			'date'=>$date,
		);
		$this->db->insert('notification', $notification_array);
			
			$this->fetchFirebaseTokenUsers($name,$desc,$token); 
		// 	$this->session->set_flashdata('message','Notification Send Successfully.');
		

		// }else{
		// 	$this->session->set_flashdata('message','Try Again. Something went wrong.');
		// }
		// redirect(base_url().'adminNotification');
	}
	function fetchFirebaseTokenUsers($name,$desc,$token) {       
 


      // echo "fdfds";
      // exit;

         $pushStatus = $this->sendPushNotification($token, $name,$desc);
         $this->session->set_flashdata('message','Notification Send Successfully.');
        redirect(base_url().'adminsingleNotification');
     
  
}
	



 function sendPushNotification($registration_ids, $name,$desc) {

   ignore_user_abort();
   ob_start();

   $url = 'https://fcm.googleapis.com/fcm/send';
	$fcmMsg = array(
		'body' => $desc,
		'title' => $name,
	
		'sound' => "default",
	        'color' => "#203E78" 
	);
	// echo "<pre>";
	// print_r($fcmMsg);
	// exit;
   $fields = array(
    // 'to' => "dL3fZGMZT96mc0qIYMYaPk:APA91bHDkiQbCw1wvQRRRB8FsxVUnP5ojhAEsNQUlu46CfS5LOhccqERZtju7D0phLDUARTir049QCkT7O6ApzIGrlmEEua8xolFjZ-iiZU1ztS5TeZu3UjGsB6Rsj0BLlOfZwnR0own",
    'to' =>$registration_ids,
    'priority' => 'high',
	'notification' => $fcmMsg
   );
// echo "<pre>";
// print_r($fields);
// exit;
   define('GOOGLE_API_KEY', 'AAAATEN6GZM:APA91bGlQHNGGc51ea2jOSL7PJdpAawahgJs2l1IsE4g0fuFWf-qPq7Wyr8_8_RyXZXZBdFOlI-wj2TiZQTabne9opttJW1VhVwMyz9GjnBgxiLgBHaZPxhTdlGpHgR4BWkw5lyENlNX');

   $headers = array(
      'Authorization:key='.GOOGLE_API_KEY,
      'Content-Type: application/json'
   );      

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

   $result = curl_exec($ch);
   //if($result === false)
     // die('Curl failed ' . curl_error());

curl_close($ch);
   return $result;
ob_flush();
      

}

}
