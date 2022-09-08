<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
	
	
	public function check_admin_login()
	{
		
		if($this->session->has_userdata('admin_user')){
			return true;
		}else{
			return false;
		}
	}

	function getRows($params = array()){

        $this->db->select('*'); 
        $this->db->from('user'); 
         
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
    function getRowsemp($params = array()){

        $user_type_id = array('1','2','3','4','5','6','7','8');
        $this->db->select('*'); 
        $this->db->from('user');
        $this->db->where_in('user_type_id', $user_type_id);
 
       // $this->db->where("(user_type_id = 99 OR user_type_id = 0)");
         
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
     public function ForgotPasswordUser($email)
    {
        $this->db->select('email');
        $this->db->from('user');
        $this->db->where('email', $email);
        $query=$this->db->get();
        return $query->row_array();
    }
   

    public function sendpasswordUser($data)
    {
       // echo "hii";

        //$this->load->config('email');
        $this->load->library('email');
         $email = $data['email'];

        $query1=$this->db->query("SELECT *  from user where email = '".$email."' ");

        $row=$query1->result_array();
       
        if ($query1->num_rows()>0)
        {

            $this->load->library('email');


                $passwordplain = "";
                $passwordplain  = rand(1000,9999);
                $newpass['password'] = md5($passwordplain);
                $this->db->where('email', $email);
                $this->db->update('user', $newpass);
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

                //echo 'Your Email has successfully been sent.';
               // redirect(base_url().'forgotPin');
                $this->session->set_flashdata('message', 'Your Email has successfully been sent.');
                redirect(base_url().'forgotPinAdmin');
        }
        else 
        {
                show_error($this->email->print_debugger());
                redirect(base_url().'forgotPinAdmin');
        }
           // redirect(base_url());
        }
        
    }


















	   public function ForgotPassword($email)
    {
        $this->db->select('email');
        $this->db->from('user');
        $this->db->where('email', $email);
        $query=$this->db->get();
        return $query->row_array();
    }
   

    public function sendpassword($data)
    {
       // echo "hii";

        //$this->load->config('email');
        $this->load->library('email');
         $email = $data['email'];
         

        $query1=$this->db->query("SELECT *  from employee_master where email = '".$email."' ");
       

        $row=$query1->result_array();
       
        if ($query1->num_rows()>0)
        {

            $this->load->library('email');


                $passwordplain = "";
                $passwordplain  = mt_rand(1000,9999);
                $newpass['password'] = md5($passwordplain);
                  $this->db->where('email', $email);
                $this->db->update('user', $newpass);
                $mail_message='Dear '.$row[0]['first_name'].' '.$row[0]['last_name'].','. "\r\n";
                $mail_message.='Congratulation and Welcome to Dr at Doorstep,<br> You can Login with Your email id <b>'.$row[0]['email'].'</b> or Mobile No. <b>'.$row[0]['mobile_no'].'</b> and <b>Pin</b> is <b>'.$passwordplain.'</b> as Password.'."\r\n";
                //$mail_message.='<br>Please Update your password.';
                $mail_message.='<br>Please Contact Admistrator if any contact information is incorrect';
                $mail_message.='<br>Thanks & Regards';
                $mail_message.='<br>Dratdoorstep';


                // echo $mail_message;
                // exit;
                
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';

                $config['mailtype'] = 'html'; // or html
          //  $this->load->library('email');
          //  $this->email->from('no-reply@example.com');
            $this->email->initialize($config);

            $this->email->from('info@dratdoorstep.com','Dratdoorstep');
            $this->email->to($email);
            $this->email->subject('Welcome to Dr at Doorstep');
            $this->email->message($mail_message);
                  
        if ($this->email->send()) 
        {
        	return true;
        		//echo "1";
              // echo 'Your Email has successfully been sent.';
               // exit;
               // redirect(base_url().'adminEmployee');
                //redirect(base_url().'forgotPin');
        }
        else 
        {
        	return false;
        	//echo "2";
        	//exit;
               // show_error($this->email->print_debugger());
            // redirect(base_url().'forgotPin');
        }
           // redirect(base_url());
        }
        
    }
	

}