<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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

		$all_permission = $this->General_model->list_menu();
		

        if($all_permission)
        {
            $this->viewdata['all_permission'] = $all_permission;
        }
        else
        {
            $this->viewdata['all_permission'] = '';
        }

		$this->load->view(HEADER,$this->viewdata);
		$this->load->view(FOOTER);
	}

}
