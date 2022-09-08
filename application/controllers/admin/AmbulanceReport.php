<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");
require APPPATH . 'libraries/Excel.php';

class AmbulanceReport extends GeneralController {

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
		$this->load->library('PHPExcel', NULL, 'excel');

		//$this->load->library('Excel');
		if(!$this->Login_model->check_admin_login()){
			redirect(base_url().'admin');
		}

	}

	public function index()
	{	
		 parent::index();

		
		
		 $this->load->view(HEADER,$this->viewdata);
		 $this->load->view('admin/ambulanceReport', $data);
		 $this->load->view(FOOTER);

		
	}
	public function generateAmbulanceReport(){

		$post = $this->input->post(NULL, true);
		
		$start_date=$post['from_date'];
		$end_date=$post['to_date'];
		//echo "fsf0"
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Ambulance');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Date');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Patient');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Service');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Total');
		
		

         // $query=$this->db->query("select book_ambulance.txndate,member.name,book_ambulance.service,book_ambulance.amount from book_ambulance LEFT Join  where DATE(txndate) BETWEEN '$start_date' and '$end_date'");
         // $setSql = $query->result_array();

        $this->db->select('book_ambulance.txndate,member.name,book_ambulance.service,book_ambulance.amount');
        $this->db->from('book_ambulance');
        $this->db->join('member','member.member_id = book_ambulance.patient_id','LEFT');
        $this->db->where('DATE(txndate) BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');

		  $setSql = $this->db->get()->result_array();

		  

		  $exceldata = array();
		if(count($setSql)>0)
		{
			
	        foreach ($setSql as $row){
	        	// echo "<pre>";
	        	// print_r($row);
	        	// exit;
	                $exceldata[] = $row;


	        }
			foreach ($exceldata as $key => $value) 
	        {
	                    $value['service'] = !empty($value['service']) ? '' : 'Ambulance';
	                    $exceldata[$key] = $value;
	        }
			
		} 
		else
		{
			// echo "ggfd";
			// exit;
			$exceldata[]= "no matching records found";
		}      
        


  //       $exceldata = array();
		// if(count($setSql)>0)
		// {
			
	 //        foreach ($setSql as $row){
	        	
	 //                $exceldata[] = $row;


	 //        }
			
			
		// } 
		// else
		// {
		// 	// echo "ggfd";
		// 	// exit;
		// 	$exceldata[]= "no matching records found";
		// }      
        
              
                $this->excel->getActiveSheet()->fromArray($exceldata,null,'A3');
                $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                $filename='Ambulance'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
               // header('Content-Disposition: attachment;filename="'.$filename.'"'); 
                header("Content-Disposition: attachment; filename=".$filename."_Reoprt.xls");
                //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');


	
	}
	

	
	
}
