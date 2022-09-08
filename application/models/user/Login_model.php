<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
	
	
	// function mail_exists($key)
 //    {
 //        $this->db->where('email',$key);
 //        $query = $this->db->get('users');
 //        if ($query->num_rows() > 0){
 //            return true;
 //        }
 //        else{
 //            return false;
 //        }
 //    }
    public function check_user_login()
    {
        
        if($this->session->has_userdata('user')){
            return true;
        }else{
            return false;
        }
    }
    function getRows($params = array()){

        $this->db->select('*'); 
        $this->db->from('user'); 
        $this->db->where("(user_type_id = 99 OR user_type_id = 0)");
         
        if(array_key_exists("conditions", $params)){

            foreach($params['conditions'] as $key => $val){ 
                $this->db->where($key, $val); 
            } 
        } 
         
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->db->count_all_results(); 
        }
        else
        { 
            if(array_key_exists("user_id", $params) || $params['returnType'] == 'single'){ 
                if(!empty($params['user_id'])){ 
                    $this->db->where('user_id', $params['user_id']); 
                } 
                $query = $this->db->get(); 
                $result = $query->row_array(); 
            }else{ 
                $this->db->order_by('user_id', 'desc'); 
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit'],$params['start']); 
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit']); 
                } 
                 
                $query = $this->db->get(); 
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
            } 
        } 
         
        // Return fetched data 
        return $result; 
    } 

     public function ForgotPassword($email)
    {
        // $this->db->select('email');
        // $this->db->from('user');
        // $this->db->where('email', $email);
       
        // $this->db->select('user.user_id,user.mobile,user.email,user.password');
        // $this->db->from('user');
        // $this->db->where("(user.email = '".$email."' OR user.mobile = '".$email."')");
        // $this->db->where("(user.user_type_id = 0 OR user.user_type_id = 99)");
        //  //$this->db->where('password', md5($post['password']));
        //   $query=$this->db->get();
         

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
           // echo "1";
                $this->db->select('user.user_id,user.mobile,user.email,user.password');
                $this->db->from('user');
                $this->db->where('email',$email);
                $this->db->where("(user.user_type_id = 0 OR user.user_type_id = 99)");
                 $query = $this->db->get();
                 return $query->row_array();
                    // echo $this->db->last_query();
                    // exit;
                    
            }
            else
            {
              //  echo "2";
                $this->db->select('user.user_id,user.mobile,user.email,user.password');
                $this->db->from('user');
                $this->db->where('mobile', $email);
                $this->db->where("(user.user_type_id = 0 OR user.user_type_id = 99)");
                 $query = $this->db->get();
                return $query->row_array();
                // echo $this->db->last_query();
                //  exit;
            }
        //return;

               // $user_exists= $this->db->get();
    }
   

    public function sendpassword($data)
    {
       // echo "hii";
        // echo "<pre>";
        // print_r($data);
        // exit;

        //$this->load->config('email');
        $this->load->library('email');
         $email = $data['email'];
         $mobile = $data['mobile'];

        $query1=$this->db->query("SELECT *  from user where email = '".$email."' or mobile = '".$mobile."' ");

        $row=$query1->result_array();
        // echo $this->db->last_query();
        // exit;

        // $this->db->select('*');
        //             $this->db->from('user');
        //             $this->db->where("(user.email = '".$post['login']."' OR user.mobile = '".$post['login']."')");
        //             $this->db->where('password', md5($post['password']));
        //             $user_details= $this->db->get()->row_array();
       
        if ($query1->num_rows()>0)
        {


                $this->load->library('email');


                $passwordplain = "";
                $passwordplain  = rand(1000,9999);
                $newpass['password'] = md5($passwordplain);
                $this->db->where('email', $email);
                $this->db->update('user', $newpass);
                // echo $email;
                // echo $mobile;
                // exit;
              
                 $message = urlencode("Thanks for contacting regarding to forgot pin. Your Pin is $passwordplain");
                    // echo $message;
                    // exit;
                    // $message.='<br>Please Update your password.';
                    // $message.='<br>Thanks & Regards';
                    // $message.='<br>Dratdoorstep';
                
                    $this->db->select('*');
                    $this->db->from('sms_detail');
                    $sms_detail = $this->db->get()->result_array();

                    $smsurl="http://".$sms_detail[0]['host']."/api/pushsms?user=".$sms_detail[0]['user_name']."&authkey=".$sms_detail[0]['authkey']."&sender=".$sms_detail[0]['sender_id']."&mobile=".$row[0]['mobile']."&text=".$message."&output=json";
                                    $response = file_get_contents($smsurl);


                $mail_message='Dear '.$row[0]['first_name'].' '.$row[0]['last_name'].','. "\r\n";
                $mail_message.='Thanks for contacting regarding to forgot pin,<br> Your <b>Pin</b> is <b>'.$passwordplain.'</b>'."\r\n";
                $mail_message.='<br>Please Update your password.';
                $mail_message.='<br>Thanks & Regards';
                $mail_message.='<br>Dratdoorstep';
                
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';

                $config['mailtype'] = 'html'; // or html
          //  $this->load->library('email');
          //  $this->email->from('no-reply@example.com');
            $this->email->initialize($config);

            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
            $this->email->to($email);
            $this->email->subject('Forgot Pin');
            $this->email->message($mail_message);
                  
        if ($this->email->send()) 
        {
                $this->session->set_flashdata('message','Your Email has successfully been sent.');

                redirect(base_url().'forgotPin');
               // echo 'Your Email has successfully been sent.';
              //  redirect(base_url().'forgotPin');
        }
        else 
        {
                show_error($this->email->print_debugger());
                redirect(base_url().'forgotPin');
        }
           // redirect(base_url());
        }
        
    }


   
 
}