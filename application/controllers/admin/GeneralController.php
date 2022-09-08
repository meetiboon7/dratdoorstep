<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralController extends CI_Controller {

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
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}	
	}

	public function index()
	{
		if($this->session->userdata('admin_user')['role_id']=="-1")
		{
			
			// $this->db->select('*');
	  //       $this->db->from('menu');
	  //       //$this->db->join('menu','menu.id = role_permission.menu_id');
	  //      // $this->db->where('role_permission.role_id');
	  //      // $this->db->where('role_permission.status',1);
	  //        $this->db->where('menu.status',1);
	  //        $this->db->order_by('menu.menu', 'ASC');

	  //       $query = $this->db-> get();

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
			
			$this->db->select('*');
	        $this->db->from('role_permission');
	        $this->db->join('menu','menu.id = role_permission.menu_id');
	        $this->db->where('role_permission.role_id',$this->session->userdata('admin_user')['role_id']);
	        $this->db->where('role_permission.status',1);
	         $this->db->where('menu.status',1);
	         $this->db->order_by('menu.menu', 'ASC');

	        $query = $this->db-> get();
		}
		
        // echo $this->db->last_query();
        // exit;

        if($query -> num_rows() > 0)
        {
            $all_permission = $query->result_array();
		

	        if($all_permission)
	        {
	            $this->viewdata['all_permission'] = $all_permission;
	        }
	        else
	        {
	            $this->viewdata['all_permission'] = '';
	        }
        }
	}
	
	
	
}
