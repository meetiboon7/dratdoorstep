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

		$start_date      = date("Y-m-d",strtotime($post['from_date']));
        $end_date        = date("Y-m-d",strtotime($post['to_date']));
		//echo "fsf0"
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('All Patient Report');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Date');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Patient');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Contact No');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Service Taken');
		$this->excel->getActiveSheet()->setCellValue('E1', 'Address');
		$this->excel->getActiveSheet()->setCellValue('F1', 'Service done/cancel');
		$this->excel->getActiveSheet()->setCellValue('G1', 'Receipt');
		$this->excel->getActiveSheet()->setCellValue('H1', 'City');
		$this->excel->getActiveSheet()->setCellValue('I1', 'Service provider name');

		$query = $this->db->query("SELECT extra_invoice.date, member.name, member.contact_no, extra_invoice.list, member.address, IF(extra_invoice.type != '' , 'DONE', 'CANCEL'), extra_invoice.price, city.city, IF(extra_invoice.appointment_book_id != 0 , 'Doctor', IF(extra_invoice.book_nurse_id != 0 , 'Nurse', IF(extra_invoice.book_laboratory_test_id != 0 , 'Laboratory', IF(extra_invoice.book_ambulance_id != 0 , 'Ambulance', NULL)))) AS service_name
		FROM extra_invoice
		LEFT JOIN member ON member.member_id = extra_invoice.patient_id
		LEFT JOIN user ON user.user_id = member.member_id 
		LEFT JOIN appointment_book ON appointment_book.appointment_book_id = extra_invoice.appointment_book_id
		LEFT JOIN book_nurse ON book_nurse.book_nurse_id = extra_invoice.book_nurse_id
		LEFT JOIN nurse_service_type ON nurse_service_type.nurse_service_id = book_nurse.type
		LEFT JOIN book_laboratory_test ON book_laboratory_test.book_laboratory_test_id = extra_invoice.book_laboratory_test_id
		LEFT JOIN lab_test_type ON lab_test_type.lab_test_id = book_laboratory_test.lab_test_id
		LEFT JOIN book_ambulance ON book_ambulance.book_ambulance_id = extra_invoice.book_ambulance_id
		LEFT JOIN city ON city.city_id = member.city_id
		WHERE DATE( extra_invoice.date ) BETWEEN  '$start_date' AND  '$end_date'
		ORDER BY extra_invoice.date DESC");
        $setSql = $query->result_array();
        $exceldata = array();
		if(count($setSql)>0)
		{
	       foreach ($setSql as $row){
	            $exceldata[] = $row;
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
		
        $filename='All_Patient'; //save our workbook as this file name
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
