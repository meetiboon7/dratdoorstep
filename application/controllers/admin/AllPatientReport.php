<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");
require APPPATH . 'libraries/Excel.php';

class AllPatientReport extends GeneralController {

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
		$data['city'] = $this->db->get_where('city', array('city_status'=>1))->result_array();
		$this->load->view(HEADER,$this->viewdata);
		$this->load->view('admin/AllPatientReport', $data);
		$this->load->view(FOOTER);
	}
	public function generateAllPatientReport(){

		$post = $this->input->post(NULL, true);
		
		// $start_date=$post['from_date'];
		// $end_date=$post['to_date'];

		$start_date      = date("Y-m-d",strtotime($post['from_date']));
        $end_date        = date("Y-m-d",strtotime($post['to_date']));
		//echo "fsf0"
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('All Patient Report');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Date');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Patient');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Service');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Total');
		$this->excel->getActiveSheet()->setCellValue('E1', 'Discount');
		$this->excel->getActiveSheet()->setCellValue('F1', 'Voucher');
		$this->excel->getActiveSheet()->setCellValue('G1', 'Credit');


        // $this->db->select('appointment_book.txndate AS [d_date], book_nurse.txndate AS n_date, book_laboratory_test.txndate AS l_date, book_ambulance.txndate AS a_date, member.name, appointment_book.service AS d_service, nurse_service_type.nurse_service_name, lab_test_type.lab_test_type_name, book_ambulance.service AS a_service, appointment_book.total AS d_total, book_laboratory_test.total AS l_total, book_nurse.total AS n_total, book_ambulance.amount, appointment_book.discount, book_nurse.discount AS n_discount, appointment_book.voucher, book_nurse.voucher AS n_voucher, appointment_book.credit, book_nurse.credit AS n_credit');

        $this->db->select('appointment_book.txndate , book_nurse.txndate AS n_date, member.name, appointment_book.service AS d_service, nurse_service_type.nurse_service_name, appointment_book.total AS d_total, book_nurse.total AS n_total, appointment_book.discount, book_nurse.discount AS n_discount, appointment_book.voucher, book_nurse.voucher AS n_voucher, appointment_book.credit, book_nurse.credit AS n_credit');
        $this->db->from('member');
        $this->db->join('appointment_book', 'appointment_book.patient_id = member.member_id', 'LEFT');
        $this->db->join('book_nurse', 'book_nurse.patient_id = member.member_id', 'LEFT');
        $this->db->join('nurse_service_type','nurse_service_type.nurse_service_id = book_nurse.type','LEFT');
        // $this->db->join('book_laboratory_test', 'book_laboratory_test.patient_id = member.member_id', 'LEFT');
        // $this->db->join('lab_test_type', 'lab_test_type.lab_test_id = book_laboratory_test.lab_test_id', 'LEFT');
        // $this->db->join('book_ambulance','book_ambulance.patient_id = member.member_id','LEFT');
        $this->db->where('txndate BETWEEN "'.$start_date. '" and "'. $end_date.'"');
        $this->db->where('n_date BETWEEN "'.$start_date. '" and "'. $end_date.'"');
        // $this->db->where('DATE(l_date) BETWEEN "'.$start_date. '" and "'. $end_date.'"');
        // $this->db->where('DATE(a_date) BETWEEN "'.$start_date. '" and "'. $end_date.'"');
        $setSql = $this->db->get()->result_array();
        echo $this->db->last_query();
		exit;
        $exceldata = array();
		if(count($setSql)>0)
		{
	       foreach ($setSql as $row){
	            $exceldata[] = $row;
	        }
			foreach ($exceldata as $key => $value) 
	        {
	            $value['service'] = !empty($value['service']) ? '' : 'Doctor Type';
	            $exceldata[$key] = $value;
	        }
		} 
		else
		{
			$exceldata[]= "no matching records found";
		}

        $this->excel->getActiveSheet()->fromArray($exceldata,null,'A3');
        $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $filename='Tele_Consulting'; //save our workbook as this file name
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
