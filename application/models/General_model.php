<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model
{
	public function uploadImage($upload_path,$get_last_id,$id_prefix,$image_name, $table_name,$image_field){
			
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg'; 				
		$config['upload_path']   = $upload_path;
		$config['overwrite'] = TRUE;
		$config['file_name'] = $id_prefix.'0'.$get_last_id.time();
		
		// if($get_last_id<=9)
		// { 	
		// $config['file_name'] = $id_prefix.'0'.$get_last_id.time();
		// }
		// else
		// {
		// $config['file_name'] = $id_prefix.$get_last_id.time();
		// }
		
		 // print_r($config);
		 $this->load->library('upload', $config);
		
		 $this->upload->initialize($config);		 
		
		 if($this->upload->do_upload($image_name))
		 {
		 	
		 	$this->db->where('user_id',$get_last_id);
			$this->db->update($table_name,array($image_field=>$this->upload->data('file_name')));
			return true;
		 } 
		 else
		 {
		  return $this->upload->display_errors(); 
		 }
	
	
	}
	public function uploadEmployeeImage($upload_path,$get_last_id,$id_prefix,$image_name,$table_name,$image_field){
			
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg'; 				
		$config['upload_path']   = $upload_path;
		$config['overwrite'] = TRUE;
		$config['file_name'] = $id_prefix.'0'.$get_last_id.time();


		 $this->load->library('upload', $config);
		
		 $this->upload->initialize($config);		 
		
		 if($this->upload->do_upload($image_name))
		 {
		 	
		 	$this->db->where('emp_id',$get_last_id);
			$this->db->update($table_name,array($image_field=>$this->upload->data('file_name')));
			   
			return true;
		 } 
		 else
		 {
		  return $this->upload->display_errors(); 
		 }
	
	
	}
	public function uploadEmployeeAadhaar($upload_path,$get_last_id,$id_prefix,$image_name,$table_name,$image_field){
			
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg'; 				
		$config['upload_path']   = $upload_path;
		$config['overwrite'] = TRUE;
		$config['file_name'] = $id_prefix.'0'.$get_last_id.time();

		
		 $this->load->library('upload', $config);
		
		 $this->upload->initialize($config);		 
		
		 if($this->upload->do_upload($image_name))
		 {
		 	
		 	$this->db->where('emp_id',$get_last_id);
			$this->db->update($table_name,array($image_field=>$this->upload->data('file_name')));
			   
			return true;
		 } 
		 else
		 {
		  return $this->upload->display_errors(); 
		 }
	
	
	}
	public function uploadEmployeeCertificate($upload_path,$get_last_id,$id_prefix,$image_name,$table_name,$image_field){
			
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg'; 				
		$config['upload_path']   = $upload_path;
		$config['overwrite'] = TRUE;
		$config['file_name'] = $id_prefix.'0'.$get_last_id.time();

		
		 $this->load->library('upload', $config);
		
		 $this->upload->initialize($config);		 
		
		 if($this->upload->do_upload($image_name))
		 {
		 	
		 	$this->db->where('emp_id',$get_last_id);
			$this->db->update($table_name,array($image_field=>$this->upload->data('file_name')));
			   
			return true;
		 } 
		 else
		 {
		  return $this->upload->display_errors(); 
		 }
	
	
	}
	public function uploadMemberImage($upload_path,$get_last_id,$id_prefix,$image_name,$table_name,$image_field){
			
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg'; 				
		$config['upload_path']   = $upload_path;
		$config['overwrite'] = TRUE;
		$config['file_name'] = $id_prefix.'0'.$get_last_id.time();

		
		$this->load->library('upload', $config);
		
		$this->upload->initialize($config);		 
		
		if($this->upload->do_upload($image_name))
		{		 	
		 	$this->db->where('member_id',$get_last_id);
			$this->db->update($table_name,array($image_field=>$this->upload->data('file_name')));
			   
			return true;
		} 
		else
		{
			return false; 
		}
	}
	public function uploadLabImage($upload_path,$get_last_id,$id_prefix,$image_name,$table_name,$image_field){
			
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 	
		$config['upload_path']   = $upload_path;
		$config['overwrite'] = TRUE;
		$config['file_name'] = $id_prefix.'0'.$get_last_id.time();
		

		 $this->load->library('upload', $config);
		
		 $this->upload->initialize($config);		 
		
		 if($this->upload->do_upload($image_name))
		 {
		 	
		 	
		 	$this->db->where('book_laboratory_test_id',$get_last_id);
			$this->db->update($table_name,array($image_field=>$this->upload->data('file_name')));
			   return true;
			
		 } 
		 else
		 {
			

		 	// echo $this->upload->display_errors(); 
		 	// exit;
		 	
					return $this->upload->display_errors(); 
		 }
	
	
	}
	public function uploadCartLabImage($upload_path,$get_last_id,$id_prefix,$image_name,$table_name,$image_field){
			
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 	
		$config['upload_path']   = $upload_path;
		$config['overwrite'] = TRUE;
		$config['file_name'] = $id_prefix.'0'.$get_last_id.time();
		

		 $this->load->library('upload', $config);
		
		 $this->upload->initialize($config);		 
		
		 if($this->upload->do_upload($image_name))
		 {
		 	
		 	$this->db->where('cart_id',$get_last_id);
			$this->db->update($table_name,array($image_field=>$this->upload->data('file_name')));
			   return true;
			
		 } 
		 else
		 {
			

		 	// echo $this->upload->display_errors(); 
		 	// exit;
		 	
					return $this->upload->display_errors(); 
					
		 }
	
	
	}
	public function uploadPharmacyImage($upload_path,$get_last_id,$id_prefix,$image_name,$table_name,$image_field){
			
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 	
		$config['upload_path']   = $upload_path;
		$config['overwrite'] = TRUE;
		$config['file_name'] = $id_prefix.'0'.$get_last_id.time();
		

		 $this->load->library('upload', $config);
		
		 $this->upload->initialize($config);		 
		
		 if($this->upload->do_upload($image_name))
		 {
		 	
		 	
		 	$this->db->where('book_medicine_id',$get_last_id);
			$this->db->update($table_name,array($image_field=>$this->upload->data('file_name')));
			   return true;
			
		 } 
		 else
		 {


		 	// 	$error[] = array('error' => $this->upload->display_errors());
				// return $error;
				return $this->upload->display_errors(); 
		 }
	
	
	}
	public function uploadCartPharmacyImage($upload_path,$get_last_id,$id_prefix,$image_name,$table_name,$image_field){
			
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 	
		$config['upload_path']   = $upload_path;
		$config['overwrite'] = TRUE;
		$config['file_name'] = $id_prefix.'0'.$get_last_id.time();
		

		 $this->load->library('upload', $config);
		
		 $this->upload->initialize($config);		 
		
		 if($this->upload->do_upload($image_name))
		 {
		 	
		 	
		 	$this->db->where('cart_id',$get_last_id);
			$this->db->update($table_name,array($image_field=>$this->upload->data('file_name')));
			   return true;
			
		 } 
		 else
		 {


		 	// 	$error[] = array('error' => $this->upload->display_errors());
				// return $error;
				return $this->upload->display_errors(); 
		 }
	
	
	}
	function view_single_user_profile($user_id="")
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if($query -> num_rows() > 0)
        {
            $result = $query->result();
            return $result[0]; 
        }
        else
        {
            return false;
        }
    }
     function list_zone()
    {
        $this->db->select('*');
        $this->db->from('zone_master');
        $this->db->where('zone_master.zone_status',1);
       
        
        $this->db->order_by('zone_master.zone_id', 'DESC');
        $query = $this->db-> get();


        if($query -> num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }

    }

     function list_cart()
    {


		$this->db->select('cart.*,member.name,user_type.user_type_name,manage_package.package_name,lab_test_type.lab_test_type_name');
		$this->db->from('cart');
		$this->db->join('member','member.member_id = cart.patient_id');
		$this->db->join('user_type','user_type.user_type_id = cart.user_type_id','LEFT');
		$this->db->join('manage_package','manage_package.package_id = cart.package_id','LEFT');
		$this->db->join('lab_test_type','lab_test_type.lab_test_id = cart.lab_test_id','LEFT');
		$this->db->where('member.user_id',$this->session->userdata('user')['user_id']);
		//$this->db->order_by('cart.cart_id','DESC');
		$this->db->order_by("cart.cart_id desc");
		 $query = $this->db->get();
        if($query -> num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }

    }

    function list_pharmacy()
    {


		$this->db->select('cart.*,user_type.user_type_name');
		$this->db->from('cart');
		$this->db->join('user_type','user_type.user_type_id = cart.user_type_id');
		$this->db->where('cart.user_id',$this->session->userdata('user')['user_id']);
		
		
		$this->db->order_by("cart.cart_id desc");
		 $query1 = $this->db->get();

        if($query1 -> num_rows() > 0)
        {
            return $query1->result_array();

        }
        else
        {
            return false;
        }

    }

     function list_menu()
    {
    	//echo "dasf".$this->session->userdata('admin_user')['role_id'];
    	//exit;
    	if($this->session->userdata('admin_user')['role_id']=="-1")
    	{
    		//echo "1";
    		//exit;
    		$this->db->select('*');
        	$this->db->from('role_permission');
        	$this->db->join('menu','menu.id = role_permission.menu_id');
        	$this->db->where('role_permission.role_id',-1);
        	$this->db->where('role_permission.status',1);
         	$this->db->where('menu.status',1);
          	$this->db->order_by('menu.menu', 'ASC');
          	$this->db->group_by('menu.id');

      // 	$this->db->order_by('zone_master.zone_id', 'DESC');
        $query = $this->db-> get();
    	}
    	else
    	{
    		//echo "2";
    		//exit;
    		$this->db->select('*');
        $this->db->from('role_permission');
        $this->db->join('menu','menu.id = role_permission.menu_id');
        $this->db->where('role_permission.role_id',$this->session->userdata('admin_user')['role_id']);
        $this->db->where('role_permission.status',1);
         $this->db->where('menu.status',1);
          $this->db->order_by('menu.menu', 'ASC');

      // 	$this->db->order_by('zone_master.zone_id', 'DESC');
        $query = $this->db-> get();
    	}
        

		// echo $this->db->last_query();
		// exit;


        if($query -> num_rows() > 0)
        {
            return $query->result_array();
            //$this->session->set_userdata('role',$query);
        }
        else
        {
            return false;
        }

    }

    public function check_unique_data($table_name,$field,$value)
	{
		$get_status=$this->db->get_where($table_name,array($field=>$value));
		
		if($get_status->num_rows()>0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function check_unique_mobile($table_name,$field,$value)
	{
		$get_status=$this->db->get_where($table_name,array($field=>$value));
		
		if($get_status->num_rows()>0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	function genRandomString()
    {
        $length     = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string     = '';
        
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters))];
        }
        
        return $string;
    }
  
   
   
}