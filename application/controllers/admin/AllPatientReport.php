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

		// $query = $this->db->query("SELECT extra_invoice.date, member.name, member.contact_no, extra_invoice.list, CONCAT_WS('', add_address.address_1, '', add_address.address_2) AS address, IF(extra_invoice.type != '' , 'DONE', 'CANCEL'), extra_invoice.price, city.city, employee_master.first_name
		// FROM extra_invoice 
		// LEFT JOIN member ON member.member_id = extra_invoice.patient_id 
		// LEFT JOIN add_address ON add_address.user_id = member.user_id 
		// LEFT JOIN city ON city.city_id = member.city_id
		// LEFT JOIN assign_appointment ON assign_appointment.patient_id = member.member_id 
		// LEFT JOIN employee_master ON employee_master.emp_id = assign_appointment.emp_id
		// WHERE DATE( extra_invoice.date ) BETWEEN '2022-08-01' AND '2022-08-10' AND member.status = '1' AND add_address.status = '1'
		// ORDER BY extra_invoice.date DESC;");
		
		$query = $this->db->query("SELECT extra_invoice.date, member.name, member.contact_no, extra_invoice.list, CONCAT_WS('', add_address.address_1, '', add_address.address_2) AS address, IF(extra_invoice.type != '' , 'DONE', 'CANCEL'), extra_invoice.price, city.city, IF(extra_invoice.appointment_book_id != 0 , 'Doctor', IF(extra_invoice.book_nurse_id != 0 , 'Nurse', IF(extra_invoice.book_laboratory_test_id != 0 , 'Laboratory', IF(extra_invoice.book_ambulance_id != 0 , 'Ambulance', NULL)))) AS service_name
		FROM extra_invoice
		LEFT JOIN member ON member.member_id = extra_invoice.patient_id
		LEFT JOIN add_address ON add_address.user_id = member.user_id
		LEFT JOIN city ON city.city_id = member.city_id
		WHERE DATE( extra_invoice.date ) BETWEEN '$start_date' AND '$end_date' AND member.status = '1' AND add_address.status = '1'
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
