<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");
require APPPATH . 'libraries/Excel.php';

class LabReport extends GeneralController {

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
		 $this->load->view('admin/labReport', $data);
		 $this->load->view(FOOTER);

		
	}
	public function generateLabReport(){

		$post = $this->input->post(NULL, true);
		
		$start_date=$post['from_date'];
		$end_date=$post['to_date'];
		//echo "fsf0"
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Doctor');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Date');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Patient');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Service');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Total');
		
		

         $query=$this->db->query("select book_laboratory_test.txndate,member.name,lab_test_type.lab_test_type_name,book_laboratory_test.total from book_laboratory_test 
         	LEFT JOIN member ON book_laboratory_test.patient_id=member.member_id 
            LEFT JOIN lab_test_type ON lab_test_type.lab_test_id=book_laboratory_test.lab_test_id where DATE(txndate) BETWEEN '$start_date' and '$end_date'");

         // $setSql = "select book_laboratory_test.txndate,patient.name,book_laboratory_test.type,book_laboratory_test.total from book_laboratory_test LEFT JOIN patient ON book_laboratory_test.patient_id=patient.patient_id  where DATE(txndate) BETWEEN '$from' and '$to'";
         $setSql = $query->result_array();
         // echo $this->db->last_query();
         // exit;

        $exceldata = array();
		if(count($setSql)>0)
		{
			
	        foreach ($setSql as $row){
	        	
	                $exceldata[] = $row;


	        }
			
			
		} 
		else
		{
			// echo "ggfd";
			// exit;
			$exceldata[]= "no matching records found";
		}      
        
              
                $this->excel->getActiveSheet()->fromArray($exceldata,null,'A3');
                $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                $filename='Lab'; //save our workbook as this file name
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
