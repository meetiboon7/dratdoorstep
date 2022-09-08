 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

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
		  //logout releted code add 10-12-2020
		  $this->load->model('user/Login_model');
		// $this->load->model('General_model');
		if(!$this->Login_model->check_user_login()){
			redirect(base_url());
		}
		 //logout releted code add 10-12-2020
		
				
	}	


	public function index()
	{

		// $cart_data_list = $this->General_model->list_pharmacy();
  //       if($cart_data_list)
  //       {
  //           $this->viewdata['cart_data_list'] = $cart_data_list;
  //       }
  //       else
  //       {
  //           $this->viewdata['cart_data_list'] = '';
  //       }


        $cart_data_list = $this->General_model->list_cart();
        // echo "<pre>";
															// print_r($cart_data_list);
															// echo "</pre>";
        if($cart_data_list)
        {
            $this->viewdata['cart_data_list'] = $cart_data_list;
        }
        else
        {
            $this->viewdata['cart_data_list'] = array();
        }

        // print_r($this->viewdata['cart_data_list']);
        // exit;
        // $list_pharmacy = $this->General_model->list_pharmacy();
        // if($list_pharmacy)
        // {
        //     $this->viewdata['list_pharmacy'] = $list_pharmacy;
        // }
        // else
        // {
        //     $this->viewdata['list_pharmacy'] = '';
        // }

		// $this->db->select('cart.*,member.name,user_type.user_type_name');
		// $this->db->from('cart');
		// $this->db->join('member','member.member_id = cart.patient_id');
		// $this->db->join('user_type','user_type.user_type_id = cart.user_type_id');
		// $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
		// $this->db->order_by('cart.cart_id', 'DESC');
		// $data['cart_data_list'] = $this->db->get()->result_array();
		// echo $this->db->last_query();
		// exit;
		$this->load->view(USERHEADER);
		$this->load->view('user/cartList',$this->viewdata);
		$this->load->view(USERFOOTER);
	}
	public function addDoctorCartDetails()
	{
		$post = $this->input->post(NULL, true);


		$this->db->select('city_id');
        $this->db->from('member');
        $this->db->where('member_id',$post['member']);
        
        $member_data = $this->db->get()->result_array();
        foreach($member_data as $member){

                 $city_id = $member['city_id'];
                     
        }


        //echo $city_id;
		date_default_timezone_set("Asia/Kolkata");
         
        $date_holiday=date('Y-m-d');
		$this->db->select('holidays.*');
		$this->db->from('holidays');
		$this->db->where('hdate',$post['date']);
		$holiday = $this->db->get()->result_array();
		// echo $this->db->last_query();
		// echo "<pre>";
		// print_r($holiday);
        
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
        // $time= date('H:i:s');
        $time= $time;
         //$date=date('Y-m-d');


         // echo $holiday[0][hdate]."==".$post['date'];
         // exit;

        $givendate=date('Y-m-d');
        $MyGivenDateIn = strtotime($post['date']);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);

          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$post['date'] || ($time >=$start && $time >= $end)) {

          		$this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
               	$this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               // $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                $this->db->where('manage_fees.service_id',1);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_doctor = $this->db->get()->result_array();


                foreach($fees_doctor as $doctor){

                 
                    
                     if($doctor['fees_type_id']==2 || $doctor['fees_type_id']==3 || $doctor['fees_type_id']==4 || $doctor['fees_type_id']==5)
                    {
                     	 $amount=$doctor['fees_name'];
                     }
                    
                }


          }
          else
          {
          		$this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
               	$this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               // $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                $this->db->where('manage_fees.service_id',1);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_doctor = $this->db->get()->result_array();

                foreach($fees_doctor as $doctor){


                	//$amount=$doctor['fees_name'];

                 	// echo "<pre>";
                 	// print_r($doctor);
                 	//exit;

                    //  $amount = $doctor['fees_name'];
                    
                    if($doctor['fees_type_id']==1)
                    {
                     	$amount=$doctor['fees_name'];
                    }
                    
        		}
         	}
       
                







		$add_cart_array = array(
			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['member'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'doctor_type_id'=>$post['doctor_type_validate'],
			'user_type_id'=>'1',
			'address'=>$post['address'],
			'complain'=>$post['complain'],
			'amount'=>$amount,
		);
		
		if($this->db->insert('cart', $add_cart_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Cart is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'AppointmentList');

	}
	public function editCartDetails()
	{
		// echo "<pre>";
		// print_r($_POST);
		// exit;

		$post = $this->input->post(NULL, true);
		$cart_id = $post['btn_edit_cart'];


		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$data['cart'] = $this->db->get_where('cart', array('cart_id'=>$cart_id))->row_array();

		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		$data['doctor_type'] = $this->db->get_where('doctor_type', array('d_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/editDoctorAppointment',$data);
		$this->load->view(USERFOOTER);
	}
	public function updateDoctorCart(){
		$post = $this->input->post(NULL, true);
			
			// echo "<pre>";
			// print_r($post);
		// );


		$this->db->select('city_id');
        $this->db->from('member');
        $this->db->where('member_id',$post['member']);
        
        $member_data = $this->db->get()->result_array();
        foreach($member_data as $member){

                 $city_id = $member['city_id'];
                     
        }


        //echo $city_id;
		date_default_timezone_set("Asia/Kolkata");
         
        $date_holiday=date('Y-m-d');
		$this->db->select('holidays.*');
		$this->db->from('holidays');
		$this->db->where('hdate',$post['date']);
		$holiday = $this->db->get()->result_array();
		// echo $this->db->last_query();
		// echo "<pre>";
		// print_r($holiday);
        
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
       //  $time= date('H:i:s');
          $time= $time;
       
         //$date=date('Y-m-d');

         $givendate=date('Y-m-d');
        $MyGivenDateIn = strtotime($date);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);
         // echo $holiday[0][hdate]."==".$post['date'];
         // exit;

          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$post['date'] || ($time >=$start && $time >= $end)) {

          		$this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
               	$this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               // $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                $this->db->where('manage_fees.service_id',1);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_doctor = $this->db->get()->result_array();


                foreach($fees_doctor as $doctor){

                 
                    
                     if($doctor['fees_type_id']==2 || $doctor['fees_type_id']==3 || $doctor['fees_type_id']==4 || $doctor['fees_type_id']==5)
                    {
                     	 $amount=$doctor['fees_name'];
                     }
                    
                }


          }
          else
          {
          		$this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
               	$this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               // $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                $this->db->where('manage_fees.service_id',1);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_doctor = $this->db->get()->result_array();

                foreach($fees_doctor as $doctor){


                	$amount=$doctor['fees_name'];

                 	// echo "<pre>";
                 	// print_r($doctor);
                 	//exit;

                    //  $amount = $doctor['fees_name'];
                    
                    if($doctor['fees_type_id']==1)
                    {
                     	$amount=$doctor['fees_name'];
                    }
                    
        		}
         	}

		$update_cart_array = array(
			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['member'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'doctor_type_id'=>$post['doctor_type_validate'],
			'user_type_id'=>'1',
			'address'=>$post['address'],
			'complain'=>$post['complain'],
			'amount'=>$amount,
		);

		$this->db->where(array('cart_id'=>$post['cart_id']));	
		if($this->db->update('cart',$update_cart_array))
		{
			//echo $this->db->last_query();
			 						$this->db->select('user.email,user.mobile');
                                    $this->db->from('user');
                                    $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
                                    $user_data = $this->db->get()->row_array();

                                     $curl = curl_init();
                                      curl_setopt_array($curl, array(
                                          CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_data[email].'',
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

                                     $date_of_time=date($post['date'].' H:i:s');
                                      $time=date($post['date'].' '.$post['time']);
                                   $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":148,"ActivityNote":"Edit Doctor Appointment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$post['member'].'"},{"SchemaName":"mx_Custom_2","Value":"'.$post['address'].'"},{"SchemaName":"mx_Custom_3","Value":"'.$post['complain'].'"},{"SchemaName":"mx_Custom_4","Value":"'.$post['doctor_type_validate'].'"},{"SchemaName":"mx_Custom_5","Value":"'.$date_of_time.'"},{"SchemaName":"mx_Custom_6","Value":"'.$time.'"},]}';
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

									$this->session->set_flashdata('message','Cart is added.');
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		//redirect(base_url().'userAddress');	
	}
	public function addNurseCartDetails()
	{
		$post = $this->input->post(NULL, true);
		// echo "<pre>";
		// print_r($post);

		$this->db->select('city_id');
        $this->db->from('member');
        $this->db->where('member_id',$post['member']);
        
        $member_data = $this->db->get()->result_array();
        foreach($member_data as $member){

                     $city_id = $member['city_id'];
                     
        }

       
                /*$this->db->select('*');
                $this->db->from('manage_fees');
                //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                $this->db->where('manage_fees.service_id',2);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_nurse = $this->db->get()->result_array();

                foreach($fees_nurse as $nurse){

                     $amount = $nurse['fees_name'];
                    

                     $type_name = $nurse['nurse_service_name'];
        		}
        //}
                                     
       
	     if($post['type_validate']== 2){
	     	
	        $amount= $amount * $post['days'];
	     }*/

       date_default_timezone_set("Asia/Kolkata");
         
                                        $date_holiday=date('Y-m-d');
                                        $this->db->select('holidays.*');
                                        $this->db->from('holidays');
                                        $this->db->where('hdate',$post['date']);
                                        $holiday = $this->db->get()->result_array();
                                        
                                            
                                             $start = '08:00:00';
                                             $end   = '20:00:00';
                                             //$time=time();
                                            // $time= date('H:i:s');
                                            $time= $post['time'];
                                           
                
                                            $givendate=date('Y-m-d');
                                            $MyGivenDateIn = strtotime($post['date']);
                                            $ConverDate = date("l", $MyGivenDateIn);
                                            $ConverDateTomatch = strtolower($ConverDate);

                                          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$post['date'] || ($time >=$start && $time >= $end)) 
                                          {
                                                    // $this->db->select('*');
                                                    // $this->db->from('manage_fees');
                                                    // //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                    // $this->db->where('manage_fees.submenu_type_id',$nurse_service_id);
                                                    // $this->db->where('manage_fees.service_id',2);
                                                    //  $this->db->where('manage_fees.city_id',$city_id);
                                                    // $fees_nurse = $this->db->get()->result_array();
                
                                                    // foreach($fees_nurse as $nurse){
                
                                                    //      $amount = $nurse['fees_name'];
                                                        
                
                                                    //      $type_name = $nurse['nurse_service_name'];
                                                    // }
                                                   // echo "1";
                                                    if($post['type_validate']==1)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else if($post['type_validate']==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'] * $days;
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            //$this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                        
                                                    }
                                          }
                                          else
                                          {
                                              
                                             // echo "2";
                                                    if($post['type_validate']==1)
                                                    {
                                                        //echo "fdsf";
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            //echo $this->db->last_query();
                        
                                                            foreach($fees_nurse as $nurse){
                                                                               
                                                                 $amount = $nurse['fees_name'];
                                                              
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else if($post['type_validate']==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'] * $days;
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else if($post['type_validate']==3)
                                                    {
                                                       // echo "3";
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                           // echo $this->db->last_query();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                        
                                                    }
                                                    
                                                    
                                          }
	     
	    
		$add_cart_array = array(
			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['member'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'nurse_service_id'=>$post['type_validate'],
			'user_type_id'=>'2',
			'days'=>$post['days'],
			'address'=>$post['address'],
			'complain'=>$post['complain'],
			'amount'=>$amount,
			'cityId'=>$city_id,
		);
		
		if($this->db->insert('cart', $add_cart_array))
		{
			 $insert_id = $this->db->insert_id();
			
			// $this->General_model->uploadEmployeeImage('./uploads/emp_profile/', $insert_id,'profile_','img_profile', 'employee_master','proof_pic');
			$this->session->set_flashdata('message','Cart  is added.');
		}else{
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		redirect(base_url().'AppointmentList');

	}
	public function editNurseCartDetails()
	{
		// echo "<pre>";
		// print_r($_POST);
		// exit;

		$post = $this->input->post(NULL, true);
		$cart_id = $post['btn_edit_cart'];


		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$data['cart'] = $this->db->get_where('cart', array('cart_id'=>$cart_id))->row_array();

		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		$data['nurse_service_type'] = $this->db->get_where('nurse_service_type', array('n_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/editNurseAppointment',$data);
		$this->load->view(USERFOOTER);
	}
	public function updateNurseCart(){
		$post = $this->input->post(NULL, true);
			
			// echo "<pre>";
			// print_r($post);
		//);
		$this->db->select('city_id');
        $this->db->from('member');
        $this->db->where('member_id',$post['member']);
        
        $member_data = $this->db->get()->result_array();
        foreach($member_data as $member){

                     $city_id = $member['city_id'];
                     
        }

        // if($post['type_validate']==4)
        // {
        //       $amount=50;
        // }
        // else
        // {
        		//echo "11";
                /*$this->db->select('*');
                $this->db->from('manage_fees');
                //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                $this->db->where('manage_fees.service_id',2);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_nurse = $this->db->get()->result_array();

                foreach($fees_nurse as $nurse){

                     $amount = $nurse['fees_name'];
                    

                     $type_name = $nurse['nurse_service_name'];
        		}*/
        //}
        date_default_timezone_set("Asia/Kolkata");
         
                                        $date_holiday=date('Y-m-d');
                                        $this->db->select('holidays.*');
                                        $this->db->from('holidays');
                                        $this->db->where('hdate',$post['date']);
                                        $holiday = $this->db->get()->result_array();
                                        
                                            
                                             $start = '08:00:00';
                                             $end   = '20:00:00';
                                             //$time=time();
                                            // $time= date('H:i:s');
                                            $time= $post['time'];
                                           
                
                                            $givendate=date('Y-m-d');
                                            $MyGivenDateIn = strtotime($post['date']);
                                            $ConverDate = date("l", $MyGivenDateIn);
                                            $ConverDateTomatch = strtolower($ConverDate);

                                          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$post['date'] || ($time >=$start && $time >= $end)) 
                                          {
                                                    // $this->db->select('*');
                                                    // $this->db->from('manage_fees');
                                                    // //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                    // $this->db->where('manage_fees.submenu_type_id',$nurse_service_id);
                                                    // $this->db->where('manage_fees.service_id',2);
                                                    //  $this->db->where('manage_fees.city_id',$city_id);
                                                    // $fees_nurse = $this->db->get()->result_array();
                
                                                    // foreach($fees_nurse as $nurse){
                
                                                    //      $amount = $nurse['fees_name'];
                                                        
                
                                                    //      $type_name = $nurse['nurse_service_name'];
                                                    // }
                                                   // echo "1";
                                                    if($post['type_validate']==1)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else if($post['type_validate']==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'] * $days;
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            //$this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                        
                                                    }
                                          }
                                          else
                                          {
                                              
                                             // echo "2";
                                                    if($post['type_validate']==1)
                                                    {
                                                        //echo "fdsf";
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            //echo $this->db->last_query();
                        
                                                            foreach($fees_nurse as $nurse){
                                                                               
                                                                 $amount = $nurse['fees_name'];
                                                              
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else if($post['type_validate']==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'] * $days;
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                    }
                                                    else if($post['type_validate']==3)
                                                    {
                                                       // echo "3";
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['type_validate']);
                                                            $this->db->where('manage_fees.service_id',2);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                           // echo $this->db->last_query();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 $type_name = $nurse['nurse_service_name'];
                                                            }
                                                        
                                                    }
                                                    
                                                    
                                          }                         
       
	     if($post['type_validate']== 2){
	     	
	        $amount= $amount * $post['days'];
	        $days=$post['days'];
	     }
	     else
	     {
	     	$days=0;
	     }
	     
	    
		$update_cart_array = array(
			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['member'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'nurse_service_id'=>$post['type_validate'],
			'user_type_id'=>'2',
			'days'=>$days,
			'address'=>$post['address'],
			'complain'=>$post['complain'],
			'amount'=>$amount,
			'cityId'=>$city_id,
		);

		$this->db->where(array('cart_id'=>$post['cart_id']));	
		if($this->db->update('cart',$update_cart_array))
		{
			//echo $this->db->last_query();
									$this->db->select('user.email,user.mobile');
                                    $this->db->from('user');
                                    $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
                                    $user_data = $this->db->get()->row_array();

                                     $curl = curl_init();
                                      curl_setopt_array($curl, array(
                                          CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_data[email].'',
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
                                       $date_of_time=date($post['date'].' H:i:s');
                                   $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":151,"ActivityNote":"Edit Nurse Appointment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$post['member'].'"},{"SchemaName":"mx_Custom_2","Value":"'.$post['address'].'"},{"SchemaName":"mx_Custom_3","Value":"'.$post['complain'].'"},{"SchemaName":"mx_Custom_4","Value":"'.$post['type_validate'].'"},{"SchemaName":"mx_Custom_5","Value":"'.$date_of_time.'"},{"SchemaName":"mx_Custom_6","Value":"'.$date_of_time.'"},{"SchemaName":"mx_Custom_7","Value":"'.$days.'"},]}';
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

			$this->session->set_flashdata('message','Cart is added.');
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		//redirect(base_url().'userAddress');	
	}
	public function addLabCartDetails()
    {

    	$post = $this->input->post(NULL, true);
    	
    	$btnValue = $post['btn'];


    	$this->db->select('city_id');
        $this->db->from('member');
        $this->db->where('member_id',$post['member_id']);
        
        $member_data = $this->db->get()->result_array();
     //   echo $this->db->last_query();
        foreach($member_data as $member){

                     $city_id = $member['city_id'];
                     
        }
        // echo $city_id;
        // exit;

        		      /*$this->db->select('*');
                $this->db->from('manage_fees');
                $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                $this->db->where('manage_fees.service_id',3);
                 $this->db->where('manage_fees.city_id',$city_id);
                $fees_lab = $this->db->get()->result_array();

             
                	if($city_id==1)
                	{
                		$amount=0;
                	}
                	else
                	{
                		foreach($fees_lab as $lab){

	                     $amount = $lab['fees_name'];
	                	}
                	}*/

                                      date_default_timezone_set("Asia/Kolkata");
         
                                        $date_holiday=date('Y-m-d');
                                        $this->db->select('holidays.*');
                                        $this->db->from('holidays');
                                        $this->db->where('hdate',$post['date']);
                                        $holiday = $this->db->get()->result_array();
                                        
                                            
                                             $start = '08:00:00';
                                             $end   = '20:00:00';
                                             //$time=time();
                                            // $time= date('H:i:s');
                                            $time= $time;
                                           
                
                                            $givendate=date('Y-m-d');
                                            $MyGivenDateIn = strtotime($post['date']);
                                            $ConverDate = date("l", $MyGivenDateIn);
                                            $ConverDateTomatch = strtolower($ConverDate);

                                          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$post['date'] || ($time >=$start && $time >= $end)) 
                                          {
                                                   
                                                    if($post['lab_test_id']==1)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                           $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                
                                                            }
                                                    }
                                                    else if($post['lab_test_id']==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                           $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                                
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                                                            }
                                                    }
                                                     else if($post['lab_test_id']==3)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 
                                                            }
                                                        
                                                    }
                                                     else if($post['lab_test_id']==4)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                
                                                            }
                                                        
                                                    }
                                          }
                                          else
                                          {
                                              
                                            
                                                   if($post['lab_test_id']==1)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            //echo $this->db->last_query();
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                //   echo "2";
                                                                //  exit;
                                                                
                        
                                                                 
                                                            }
                                                    }
                                                    else if($post['lab_test_id']==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                                
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                 
                                                            }
                                                    }
                                                     else if($post['lab_test_id']==3)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                
                                                            }
                                                        
                                                    }
                                                     else if($post['lab_test_id']==4)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 
                                                            }
                                                        
                                                    }
                                                    
                                                    
                                                }
                	
                	 
                //}
               

		$lab_appointment_array = array(


			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['member_id'],
			'lab_test_id'=>$post['lab_test_id'],
			'date'=>$post['date'],
			'user_type_id'=>'3',
			'time'=>$post['time'],
			'address'=>$post['address'],
			'complain'=>$post['complain'],
			'amount'=>$amount,
			'cityId'=>$city_id,
			
		);
		// print_r($lab_appointment_array);
		// exit;
		if($this->db->insert('cart', $lab_appointment_array))
		{
			 $insert_id = $this->db->insert_id();

			
			 $this->General_model->uploadCartLabImage('./uploads/lab_report/', $insert_id,'profile_','img_profile', 'cart','prescription');
			
			
			$this->session->set_flashdata('message','Lab Appointment is added.');
			echo json_encode(array(
						"btn"=>$btnValue,
					));

			// $response[ = array();
			// echo json_encode($response);
			

		}else{
			
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		 // redirect(base_url().'AppointmentList');
    }
    public function editLabCartDetails()
	{
		// echo "<pre>";
		// print_r($_POST);
		// exit;

		$post = $this->input->post(NULL, true);
		$cart_id = $post['btn_edit_cart'];


		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$data['cart'] = $this->db->get_where('cart', array('cart_id'=>$cart_id))->row_array();

		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		$data['lab_test_type'] = $this->db->get_where('lab_test_type', array('l_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/editLabAppointment',$data);
		$this->load->view(USERFOOTER);
	}
	public function updateLabCart(){

		$get_img_profile=$_FILES['img_profile'];
		$post = $this->input->post(NULL, true);
			
		$btnValue = $post['btn'];


    	$this->db->select('city_id');
        $this->db->from('member');
        $this->db->where('member_id',$post['member_id']);
        
        $member_data = $this->db->get()->result_array();
     //   echo $this->db->last_query();
        foreach($member_data as $member){

                     $city_id = $member['city_id'];
                     
        }
        

	/*	$this->db->select('*');
		$this->db->from('manage_fees');
		$this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
		$this->db->where('manage_fees.service_id',3);
		 $this->db->where('manage_fees.city_id',$city_id);
		$fees_lab = $this->db->get()->result_array();


			if($city_id==1)
			{
				$amount=0;
			}
			else
			{
				foreach($fees_lab as $lab){

		         $amount = $lab['fees_name'];
		    	}
			}*/
   date_default_timezone_set("Asia/Kolkata");
         
                                        $date_holiday=date('Y-m-d');
                                        $this->db->select('holidays.*');
                                        $this->db->from('holidays');
                                        $this->db->where('hdate',$post['date']);
                                        $holiday = $this->db->get()->result_array();
                                        
                                            
                                             $start = '08:00:00';
                                             $end   = '20:00:00';
                                             //$time=time();
                                            // $time= date('H:i:s');
                                            $time= $time;
                                           
                
                                            $givendate=date('Y-m-d');
                                            $MyGivenDateIn = strtotime($post['date']);
                                            $ConverDate = date("l", $MyGivenDateIn);
                                            $ConverDateTomatch = strtolower($ConverDate);

                                          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$post['date'] || ($time >=$start && $time >= $end)) 
                                          {
                                                   
                                                    if($post['lab_test_id']==1)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                           $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                        
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                
                                                            }
                                                    }
                                                    else if($post['lab_test_id']==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           // $this->db->where('manage_fees.fees_type_id',1);
                                                           $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                                
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                                                            }
                                                    }
                                                     else if($post['lab_test_id']==3)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 
                                                            }
                                                        
                                                    }
                                                     else if($post['lab_test_id']==4)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           $this->db->where('manage_fees.fees_type_id!=',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                
                                                            }
                                                        
                                                    }
                                          }
                                          else
                                          {
                                              
                                            
                                                   if($post['lab_test_id']==1)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                           $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            //echo $this->db->last_query();
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                //   echo "2";
                                                                //  exit;
                                                                
                        
                                                                 
                                                            }
                                                    }
                                                    else if($post['lab_test_id']==2)
                                                    {
                                                        
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                                
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                 
                                                            }
                                                    }
                                                     else if($post['lab_test_id']==3)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                
                                                            }
                                                        
                                                    }
                                                     else if($post['lab_test_id']==4)
                                                    {
                                                            $this->db->select('*');
                                                            $this->db->from('manage_fees');
                                                            //$this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = manage_fees.submenu_type_id');
                                                            $this->db->where('manage_fees.submenu_type_id',$post['lab_test_id']);
                                                            $this->db->where('manage_fees.service_id',3);
                                                            $this->db->where('manage_fees.fees_type_id',1);
                                                             $this->db->where('manage_fees.city_id',$city_id);
                                                            $fees_nurse = $this->db->get()->result_array();
                                                            // echo $this->db->last_query();
                                                            // exit;
                                                            foreach($fees_nurse as $nurse){
                        
                                                                 $amount = $nurse['fees_name'];
                                                                
                        
                                                                 
                                                            }
                                                        
                                                    }
                                                    
                                                    
                                                }
         
	     
	    
		$lab_appointment_array = array(


			'user_id'=>$this->session->userdata('user')['user_id'],
			'patient_id'=>$post['member_id'],
			'lab_test_id'=>$post['lab_test_id'],
			'date'=>$post['date'],
			'user_type_id'=>'3',
			'time'=>$post['time'],
			'address'=>$post['address'],
			'complain'=>$post['complain'],
			'amount'=>$amount,
			'cityId'=>$city_id,
			
		);

		$this->db->where(array('cart_id'=>$post['cart_id']));	
		if($this->db->update('cart',$lab_appointment_array))
		{
			///echo $this->db->last_query();

									$this->db->select('user.email,user.mobile');
                                    $this->db->from('user');
                                    $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
                                    $user_data = $this->db->get()->row_array();

                                     $curl = curl_init();
                                      curl_setopt_array($curl, array(
                                          CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_data[email].'',
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
                                      $date_of_time=date($post['date'].' H:i:s');

                                   $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":157,"ActivityNote":"Edit Lab Appointment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$post['member_id'].'"},{"SchemaName":"mx_Custom_2","Value":"'.$post['address'].'"},{"SchemaName":"mx_Custom_3","Value":"'.$post['lab_test_id'].'"},{"SchemaName":"mx_Custom_4","Value":"'.$date_of_time.'"},{"SchemaName":"mx_Custom_5","Value":"'.$date_of_time.'"},{"SchemaName":"mx_Custom_6","Value":"'.$post['complain'].'"},{"SchemaName":"mx_Custom_7","Value":"'.$get_img_profile[name].'"},]}';
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

			 $this->General_model->uploadCartLabImage('./uploads/lab_report/', $post['cart_id'],'profile_','img_profile', 'cart','prescription');
			
			
			$this->session->set_flashdata('message','Lab Appointment is added.');
			echo json_encode(array(
						"btn"=>$btnValue,
					));
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		//redirect(base_url().'userAddress');	
	}
	public function editAmbulanceCartDetails()
	{
		// echo "<pre>";
		// print_r($_POST);
		// exit;

		$post = $this->input->post(NULL, true);
		$cart_id = $post['btn_edit_cart'];


		$this->db->select('member.*');
        $this->db->from('member');
        $this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('member.status',1);
        $this->db->order_by('member.user_id', 'DESC');
		$data['member'] = $this->db->get()->result_array();

		$data['cart'] = $this->db->get_where('cart', array('cart_id'=>$cart_id))->row_array();

		$this->db->select('add_address.*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$this->session->userdata('user')['user_id']);
         $this->db->where('add_address.status',1);
        $this->db->order_by('add_address.user_id', 'DESC');
		$data['address'] = $this->db->get()->result_array();
		
		$data['lab_test_type'] = $this->db->get_where('lab_test_type', array('l_status'=>1))->result_array();
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		
		$this->load->view(USERHEADER);
		$this->load->view('user/editAmbulanceAppointmentList',$data);
		$this->load->view(USERFOOTER);
	}
	public function updateAmbulanceCart(){
		$post = $this->input->post(NULL, true);
			
		//$post = $this->input->post(NULL, true);


    	/*if($post['type_valid']=="ONEWAY")
    	{
    		$this->db->select('*');
	        $this->db->from('manage_fees');
	        $this->db->where('manage_fees.submenu_type_id',1);
	        $this->db->where('manage_fees.service_id',5);
	         $this->db->where('manage_fees.city_id',$post['city_valid']);
	        $fees_oneway = $this->db->get()->result_array();
	      
	        foreach($fees_oneway as $oneway){

	             $amount = $oneway['fees_name'];
	        }
    	}
    	elseif($post['type_valid']=="ROUND TRIP")
    	{
    		$this->db->select('*');
	        $this->db->from('manage_fees');
	        $this->db->where('manage_fees.submenu_type_id',2);
	        $this->db->where('manage_fees.service_id',5);
	         $this->db->where('manage_fees.city_id',$post['city_valid']);
	        $fees_roundtrip = $this->db->get()->result_array();
	      
	        foreach($fees_roundtrip as $roundtrip){

	             $amount = $roundtrip['fees_name'];
	        }
    	}
      else
      {
          $this->db->select('*');
          $this->db->from('manage_fees');
          $this->db->where('manage_fees.submenu_type_id',3);
          $this->db->where('manage_fees.service_id',5);
           $this->db->where('manage_fees.city_id',$post['city_valid']);
          $multi_roundtrip = $this->db->get()->result_array();
        
          foreach($multi_roundtrip as $multitrip){

               $amount = $multitrip['fees_name'];
          }
      }*/

       date_default_timezone_set("Asia/Kolkata");
         
        $date_holiday=date('Y-m-d');
    $this->db->select('holidays.*');
    $this->db->from('holidays');
    $this->db->where('hdate',$post['date']);
    $holiday = $this->db->get()->result_array();
    
        
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
        // $time= date('H:i:s');
        $time= $post['time'];
       

        $givendate=date('Y-m-d');
        $MyGivenDateIn = strtotime($post['date']);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);

          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$post['date'] || ($time >=$start && $time >= $end)) {

              

              if($post['type_valid']=="ONEWAY")
              {
         

               
                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               
                $this->db->where('manage_fees.submenu_type_id',1);
                $this->db->where('manage_fees.service_id',5);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$post['city_valid']);
                $fees_oneway = $this->db->get()->result_array();
         
        
                  foreach($fees_oneway as $oneway){

                       $amount = $oneway['fees_name'];
                  }
      }
              elseif($post['type_valid']=="ROUND TRIP")
              {
               

                        $this->db->select('manage_fees.*,fees_type.fees_type_name');
                        $this->db->from('manage_fees');
                        $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                       
                        $this->db->where('manage_fees.submenu_type_id',2);
                        $this->db->where('manage_fees.service_id',5);
                      //  $this->db->where('manage_fees.fees_type_id',1);
                         $this->db->where('manage_fees.city_id',$post['city_valid']);
                        $fees_roundtrip = $this->db->get()->result_array();
                
                        foreach($fees_roundtrip as $roundtrip){

                             $amount = $roundtrip['fees_name'];
                        }
              }
              else
              {
               
                      $this->db->select('manage_fees.*,fees_type.fees_type_name');
                        $this->db->from('manage_fees');
                        $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                       
                        $this->db->where('manage_fees.submenu_type_id',3);
                        $this->db->where('manage_fees.service_id',5);
                      //  $this->db->where('manage_fees.fees_type_id',1);
                         $this->db->where('manage_fees.city_id',$post['city_valid']);
                        $fees_multitrip = $this->db->get()->result_array();
                
                  foreach($fees_multitrip as $multitrip){

                       $amount = $multitrip['fees_name'];
                  }
            }
        }
          else
          {
              if($post['type_valid']=="ONEWAY")
              {
         
                
                

                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               
                $this->db->where('manage_fees.submenu_type_id',1);
                $this->db->where('manage_fees.service_id',5);
                $this->db->where('manage_fees.fees_type_id',1);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$post['city_valid']);
                $fees_oneway = $this->db->get()->result_array();
                
        
                  foreach($fees_oneway as $oneway){

                       $amount = $oneway['fees_name'];
                  }
               }
              elseif($post['type_valid']=="ROUND TRIP")
              {
               

                        $this->db->select('manage_fees.*,fees_type.fees_type_name');
                        $this->db->from('manage_fees');
                        $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                       
                        $this->db->where('manage_fees.submenu_type_id',2);
                        $this->db->where('manage_fees.service_id',5);
                        $this->db->where('manage_fees.fees_type_id',1);
                      //  $this->db->where('manage_fees.fees_type_id',1);
                         $this->db->where('manage_fees.city_id',$post['city_valid']);
                        $fees_roundtrip = $this->db->get()->result_array();
                
                        foreach($fees_roundtrip as $roundtrip){

                             $amount = $roundtrip['fees_name'];
                        }
              }
              else
              {
               
                      $this->db->select('manage_fees.*,fees_type.fees_type_name');
                        $this->db->from('manage_fees');
                        $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                       
                        $this->db->where('manage_fees.submenu_type_id',3);
                        $this->db->where('manage_fees.service_id',5);
                        $this->db->where('manage_fees.fees_type_id',1);
                      //  $this->db->where('manage_fees.fees_type_id',1);
                         $this->db->where('manage_fees.city_id',$post['city_valid']);
                        $fees_multitrip = $this->db->get()->result_array();
                
                  foreach($fees_multitrip as $multitrip){

                       $amount = $multitrip['fees_name'];
                  }
            }
      }
    	
    	
    	if($post['type_valid']=="ONEWAY")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			'address'=>0,
			'mobileNumber'=>$post['mobile2'],
			'landlineNumber'=>$post['landline']." ",
			'cityId'=>$post['city_valid'],
			'from_address'=>$post['from_address']." ",
			'to_address'=>$post['to_address']." ",
			//'condition'=>$post['condition'],
			'user_type_id'=>'5',
			'type'=>1,
			'date'=>$post['date'],
			'time'=>$post['time'],
			'amount'=>$amount,
			'multi_city'=>''
			);
    	}
    	if($post['type_valid']=="ROUND TRIP")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			//'contactPerson'=>$post['first_name']." ".$post['last_name'],
			//'age'=>$post['age'],
			//'gender'=>$post['gender_type_validate'],
			'address'=>0,
			'mobileNumber'=>$post['mobile2'],
			//'mobile2'=>$post['mobile2'],
			'landlineNumber'=>$post['landline']." ",
			'from_address'=>$post['from_address']." ",
			'to_address'=>$post['to_address']." ",
			'user_type_id'=>'5',
			'type'=>2,

			//'country_id'=>$post['country_id'],
			//'state_id'=>$post['state_id'],
			'cityId'=>$post['city_valid'],
			//'condition'=>$post['condition'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'amount'=>$amount,
			'multi_city'=>''
			//'return_date'=>$post['return_date'],
			//'return_time'=>$post['return_time'],
			
			);
    	}

    	if($post['type_valid']=="MULTI CITY")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			//'contactPerson'=>$post['first_name']." ".$post['last_name'],
			//'age'=>$post['age'],
			//'gender'=>$post['gender_type_validate'],
			'address'=>0,
			'cityId'=>$post['city_valid'],
			'mobileNumber'=>$post['mobile2'],
			'user_type_id'=>'5',
			'type'=>3,
			'date'=>$post['date'],
			'time'=>$post['time'],
			//'mobile2'=>$post['mobile2'],
			'landlineNumber'=>$post['landline']." ",
			'amount'=>$amount,
			//'city_id'=>$post['city_id'],
			'multi_city'=>implode(',@#-0,',$post['multi_city_data'])

			
			);
    	}


		$this->db->where(array('cart_id'=>$post['cart_id']));	
		if($this->db->update('cart',$ambulance_appointment_array))
		{
			///echo $this->db->last_query();
				$this->db->select('user.email,user.mobile');
                $this->db->from('user');
                $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
                $user_data = $this->db->get()->row_array();
                // echo "<pre>";
                // print_r($user_data);
                // exit;
                 $curl = curl_init();
                  curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_data[email].'',
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
                  // echo "<pre>";
                  // print_r($data);
                  // exit;
                 $date_of_time=date($post['date'].' H:i:s');
                $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":154,"ActivityNote":"Edit Ambulance Appointment","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$post['member_id'].'"},{"SchemaName":"mx_Custom_2","Value":"'.$post['mobile2'].'"},{"SchemaName":"mx_Custom_3","Value":"'.$post['landline'].'"},{"SchemaName":"mx_Custom_4","Value":"'.$post['city_valid'].'"},{"SchemaName":"mx_Custom_5","Value":"'.$date_of_time.'"},{"SchemaName":"mx_Custom_6","Value":"'.$date_of_time.'"},{"SchemaName":"mx_Custom_7","Value":"'.$post['multi_city_data'].'"},]}';
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

			 $this->session->set_flashdata('message','Ambulance Appointment is added.');
			//$this->session->set_flashdata('message','Address is updated.');
		}else{
			//$this->session->set_flashdata('message','Something went wrong.');
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}


		//redirect(base_url().'userAddress');	
	}
    public function addPharmacyCartDetails()
    {
    	
    	$get_img_profile=$_FILES['img_profile'];
    	//echo $img_profile[name];
    	
    	$post = $this->input->post(NULL, true);

    	$pharmacy_appointment_array = array(


			'user_id'=>$this->session->userdata('user')['user_id'],
			//'patient_id'=>$post['member_id'],
			'name'=>$post['name'],
			'mobile'=>$post['mobile'],
			'landline'=>$post['landline']." ",
			'address'=>$post['address']." ",
			'city_id'=>$post['city_id'],
			//'user_type_id'=>'4',
			'booked_by'=>$this->session->userdata('user')['user_id'],
			'created_date'=>date('Y-m-d'),
			//'amount'=>450,
		);
		
		if($this->db->insert('book_medicine', $pharmacy_appointment_array))
		{
			date_default_timezone_set("Asia/Calcutta");
			$datetime=date('Y-m-d H:i:s');
			$dateresult=explode(' ', $datetime);
			/*echo $dateresult[0];
			echo "<pre>";
			print_r($dateresult);
			exit;*/


                                    $message="Hi '".$post['name']."' we have scheduled your appointment today Dt '".$dateresult[0]."' & Time'".$dateresult[1]."'  If any change let us know on 7069073088.DR AT DOORSTEP. Regards Team Nisarg Wellness Pvt Ltd.
";
                                    $request =""; //initialise the request variable
                                    $param[method]= "sendMessage";
                                    $param[send_to] = "91".$post['mobile'];
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
			 $insert_id = $this->db->insert_id();

			 $this->db->select('user.email,user.mobile');
            $this->db->from('user');
            $this->db->where('user.user_id',$this->session->userdata('user')['user_id']);
            $user_data = $this->db->get()->row_array();

             $curl = curl_init();
              curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=u$r50af8590aba7563ac0f6f62d6a8bb799&secretKey=1fe2a018d6d37473ebca2efe69e77a0b72723a28&emailaddress='.$user_data[email].'',
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

           //   $date_of_birth=date($post['date_of_birth'].' H:i:s');
             
            $data_string = '{"RelatedProspectId":"'.$data[0]['ProspectID'].'","ActivityEvent":159,"ActivityNote":"Your Activity Note","ActivityDateTime":"'.date('Y-m-d H:i:s').'","Fields":[{"SchemaName":"mx_Custom_1","Value":"'.$post['name'].'"},{"SchemaName":"mx_Custom_2","Value":"'.$post['mobile'].'"},{"SchemaName":"mx_Custom_3","Value":"'.$post['city_id'].'"},{"SchemaName":"mx_Custom_4","Value":"'.$post['address'].'"},{"SchemaName":"mx_Custom_5","Value":"'.$get_img_profile[name].'"},]}';

           
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
                 // $data1 = json_decode($json_response, TRUE);
                 // echo "<pre>";
                 // print_r($data1);
                 // exit;
                curl_close($curl);
            } catch (Exception $ex) 
            { 
                curl_close($curl);
            }
			 
			  $this->General_model->uploadPharmacyImage('./uploads/pharmacy_document/', $insert_id,'profile_','img_profile', 'book_medicine','prescription');
		
			echo json_encode($post['btn']);
		}
		else
		{
			
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		//redirect(base_url().'AppointmentList');
    }


    public function addAmbulanceCartDetails()
    {

    	$post = $this->input->post(NULL, true);
    
    date_default_timezone_set("Asia/Kolkata");
         
        $date_holiday=date('Y-m-d');
    $this->db->select('holidays.*');
    $this->db->from('holidays');
    $this->db->where('hdate',$post['date']);
    $holiday = $this->db->get()->result_array();
    
        
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
        // $time= date('H:i:s');
        $time= $post['time'];
       

        $givendate=date('Y-m-d');
        $MyGivenDateIn = strtotime($post['date']);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);

          if(date('D') == 'Sun' || $ConverDateTomatch=='sunday' || $holiday[0][hdate]==$post['date'] || ($time >=$start && $time >= $end)) {

              

              if($post['type_valid']=="ONEWAY")
              {
         

               
                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               
                $this->db->where('manage_fees.submenu_type_id',1);
                $this->db->where('manage_fees.service_id',5);
              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$post['city_valid']);
                $fees_oneway = $this->db->get()->result_array();
         
        
                  foreach($fees_oneway as $oneway){

                       $amount = $oneway['fees_name'];
                  }
      }
              elseif($post['type_valid']=="ROUND TRIP")
              {
               

                        $this->db->select('manage_fees.*,fees_type.fees_type_name');
                        $this->db->from('manage_fees');
                        $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                       
                        $this->db->where('manage_fees.submenu_type_id',2);
                        $this->db->where('manage_fees.service_id',5);
                      //  $this->db->where('manage_fees.fees_type_id',1);
                         $this->db->where('manage_fees.city_id',$post['city_valid']);
                        $fees_roundtrip = $this->db->get()->result_array();
                
                        foreach($fees_roundtrip as $roundtrip){

                             $amount = $roundtrip['fees_name'];
                        }
              }
              else
              {
               
                      $this->db->select('manage_fees.*,fees_type.fees_type_name');
                        $this->db->from('manage_fees');
                        $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                       
                        $this->db->where('manage_fees.submenu_type_id',3);
                        $this->db->where('manage_fees.service_id',5);
                      //  $this->db->where('manage_fees.fees_type_id',1);
                         $this->db->where('manage_fees.city_id',$post['city_valid']);
                        $fees_multitrip = $this->db->get()->result_array();
                
                  foreach($fees_multitrip as $multitrip){

                       $amount = $multitrip['fees_name'];
                  }
            }
        }
          else
          {
              if($post['type_valid']=="ONEWAY")
              {
         
                
                

                $this->db->select('manage_fees.*,fees_type.fees_type_name');
                $this->db->from('manage_fees');
                $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
               
                $this->db->where('manage_fees.submenu_type_id',1);
                $this->db->where('manage_fees.service_id',5);
                $this->db->where('manage_fees.fees_type_id',1);

              //  $this->db->where('manage_fees.fees_type_id',1);
                 $this->db->where('manage_fees.city_id',$post['city_valid']);
                $fees_oneway = $this->db->get()->result_array();
                
        
                  foreach($fees_oneway as $oneway){

                       $amount = $oneway['fees_name'];
                  }
               }
              elseif($post['type_valid']=="ROUND TRIP")
              {
               

                        $this->db->select('manage_fees.*,fees_type.fees_type_name');
                        $this->db->from('manage_fees');
                        $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                       
                        $this->db->where('manage_fees.submenu_type_id',2);
                        $this->db->where('manage_fees.service_id',5);
                        $this->db->where('manage_fees.fees_type_id',1);
                      //  $this->db->where('manage_fees.fees_type_id',1);
                         $this->db->where('manage_fees.city_id',$post['city_valid']);
                        $fees_roundtrip = $this->db->get()->result_array();
                
                        foreach($fees_roundtrip as $roundtrip){

                             $amount = $roundtrip['fees_name'];
                        }
              }
              else
              {
               
                      $this->db->select('manage_fees.*,fees_type.fees_type_name');
                        $this->db->from('manage_fees');
                        $this->db->join('fees_type','fees_type.fees_type_id = manage_fees.fees_type_id');
                       
                        $this->db->where('manage_fees.submenu_type_id',3);
                        $this->db->where('manage_fees.service_id',5);
                        $this->db->where('manage_fees.fees_type_id',1);
                      //  $this->db->where('manage_fees.fees_type_id',1);
                         $this->db->where('manage_fees.city_id',$post['city_valid']);
                        $fees_multitrip = $this->db->get()->result_array();
                
                  foreach($fees_multitrip as $multitrip){

                       $amount = $multitrip['fees_name'];
                  }
            }
      }
    	/*if($post['type_valid']=="ONEWAY")
    	{
    		$this->db->select('*');
	        $this->db->from('manage_fees');
	        $this->db->where('manage_fees.submenu_type_id',1);
	        $this->db->where('manage_fees.service_id',5);
	         $this->db->where('manage_fees.city_id',$post['city_valid']);
	        $fees_oneway = $this->db->get()->result_array();
	        // echo $this->db->last_query();
	        // exit;
	      
	        foreach($fees_oneway as $oneway){

	             $amount = $oneway['fees_name'];
	        }
    	}
    	elseif($post['type_valid']=="ROUND TRIP")
    	{
    		$this->db->select('*');
	        $this->db->from('manage_fees');
	        $this->db->where('manage_fees.submenu_type_id',2);
	        $this->db->where('manage_fees.service_id',5);
	         $this->db->where('manage_fees.city_id',$post['city_valid']);
	        $fees_roundtrip = $this->db->get()->result_array();
	      
	        foreach($fees_roundtrip as $roundtrip){

	             $amount = $roundtrip['fees_name'];
	        }
    	}
      else
      {
        $this->db->select('*');
          $this->db->from('manage_fees');
          $this->db->where('manage_fees.submenu_type_id',3);
          $this->db->where('manage_fees.service_id',5);
           $this->db->where('manage_fees.city_id',$post['city_valid']);
          $fees_multitrip = $this->db->get()->result_array();
        
          foreach($fees_multitrip as $multitrip){

               $amount = $multitrip['fees_name'];
          }
      }*/



















    	
    	
    	if($post['type_valid']=="ONEWAY")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			'address'=>0,
			'mobileNumber'=>$post['mobile2'],
			'landlineNumber'=>$post['landline'],
			'cityId'=>$post['city_valid'],
			'from_address'=>$post['from_address']." ",
			'to_address'=>$post['to_address']." ",
			//'condition'=>$post['condition'],
			'user_type_id'=>'5',
			'type'=>1,
			'date'=>$post['date'],
			'time'=>$post['time'],
			'amount'=>$amount,
			);
    	}
    	if($post['type_valid']=="ROUND TRIP")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			//'contactPerson'=>$post['first_name']." ".$post['last_name'],
			//'age'=>$post['age'],
			//'gender'=>$post['gender_type_validate'],
			'address'=>0,
			'mobileNumber'=>$post['mobile2'],
			//'mobile2'=>$post['mobile2'],
			'landlineNumber'=>$post['landline'],
			'from_address'=>$post['from_address']." ",
			'to_address'=>$post['to_address']." ",
			'user_type_id'=>'5',
			'type'=>2,

			//'country_id'=>$post['country_id'],
			//'state_id'=>$post['state_id'],
			'cityId'=>$post['city_valid'],
			//'condition'=>$post['condition'],
			'date'=>$post['date'],
			'time'=>$post['time'],
			'amount'=>$amount,
			//'return_date'=>$post['return_date'],
			//'return_time'=>$post['return_time'],
			
			);
    	}

    	if($post['type_valid']=="MULTI CITY")
    	{
    		$ambulance_appointment_array = array(
    		'patient_id'=>$post['member_id'],
			'user_id'=>$this->session->userdata('user')['user_id'],
			//'contactPerson'=>$post['first_name']." ".$post['last_name'],
			//'age'=>$post['age'],
			//'gender'=>$post['gender_type_validate'],
			'address'=>0,
			'cityId'=>$post['city_valid'],
			'mobileNumber'=>$post['mobile2'],
			'user_type_id'=>'5',
			'type'=>3,
			'date'=>$post['date'],
			'time'=>$post['time'],
			//'mobile2'=>$post['mobile2'],
			'landlineNumber'=>$post['landline'],
			'amount'=>$amount,
			//'city_id'=>$post['city_id'],
			'multi_city'=>implode(',@#-0,',$post['multi_city_data'])

			
			);
    	}

		if($this->db->insert('cart',$ambulance_appointment_array))
		{
			$this->session->set_flashdata('message','Ambulance Appointment is added.');
			
	    }
	    else{
			
			$this->session->set_flashdata('message','Try Again. Something went wrong.');
		}	

		//redirect(base_url().'AppointmentList');
    }
	
    public function removeCartData()
	{

		$post = $this->input->post(NULL, true);
		//$delete_member_id = $post['btn_delete_member'];
		$this->db->where('cart_id',$post['cart_id']);
        $response=$this->db->delete('cart');
      //  echo $this->db->last_query();
		// extract($_POST);

		echo json_encode($response);
			exit;
	}
	public function memberAddressDisplay()
    {
     	extract($_POST);


    	$this->db->select('*');
        $this->db->from('add_address');
        $this->db->where('add_address.user_id',$user_id);
         $this->db->where('add_address.status',1);
         $this->db->order_by('add_address.address_id', 'DESC');
		$data['select_address'] = $this->db->get()->result();
		 
		$this->load->view('user/member_address_user',$data);
		
    }

    public function updateVoucherCode()
    {
    	extract($_POST);
    	
    	$this->db->select('*');
        $this->db->from('voucher');
        $this->db->where('voucher.code',$coupon_code);
        $this->db->where('voucher.from_date <=',date('Y-m-d'));
        $this->db->where('voucher.to_date >=',date('Y-m-d'));
        $this->db->where('voucher.city_id',$this->session->userdata('user')['city_id']);
       	$voucher = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('user_promocode_rel');
        $this->db->where('user_promocode_rel.voucher_id',$voucher[0]['voucher_id']);
        $this->db->where('user_promocode_rel.user_id',$this->session->userdata('user')['user_id']);
       $use_voucher = $this->db->get()->result_array();

       	//echo $this->db->last_query();
       
       //	if (count($voucher) > 0) {
       
       if($voucher[0]['voucher_id']!=$use_voucher[0]['voucher_id'] && $use_voucher[0]['user_id']!=$this->session->userdata('user')['user_id']) {

			echo json_encode(array(
						"statusCode"=>200,
						 "voucher_id"=>$voucher[0]['voucher_id'],
						"from_date"=>$voucher[0]['from_date'],
						"to_date"=>$voucher[0]['to_date'],
						"value"=>$voucher[0]['amount'],
						"service_id"=>$voucher[0]['service_id'],
						"package_id"=>$voucher[0]['package_id'],
						"all_service"=>$voucher[0]['all_service'],

					));
		}
		else
		{
			echo json_encode(array("statusCode"=>201));
		}
       	
    }
    
	
}
