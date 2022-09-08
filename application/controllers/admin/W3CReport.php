<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/admin/GeneralController.php");
require APPPATH . 'libraries/Excel.php';

class W3CReport extends GeneralController {

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
		 $this->load->view('admin/W3CReport', $data);
		 $this->load->view(FOOTER);

		
	}
	public function generateW3CReport(){

		$post = $this->input->post(NULL, true);
		
		$start_date=date("Y-m-d", strtotime($_POST['from_date']));
		$end_date=date("Y-m-d", strtotime($_POST['to_date']));
		
		$city=$post['city_id'];
		if($city == 1){
   			$cityname = 'Ahmedabad';
		}else{
		    $cityname = 'Vadodara';
		}
		//echo "fsf0"
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('W3CReport');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Id');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Date');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Patient');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Service');
		$this->excel->getActiveSheet()->setCellValue('E1', 'Total');
		$this->excel->getActiveSheet()->setCellValue('F1', 'Discount');
		$this->excel->getActiveSheet()->setCellValue('G1', 'Voucher');
		$this->excel->getActiveSheet()->setCellValue('H1', 'Credit');
		$this->excel->getActiveSheet()->setCellValue('I1', 'Type');

		
      
               
   


$query=$this->db->query("SELECT patient_id, appmt_date, name, list, 
CASE WHEN patient_id IS NULL 
THEN CONCAT( price,  ' (total)' ) 
ELSE price
END AS  'Price,Rs', discount, voucher, credit,type
FROM (

SELECT extra_invoice.patient_id, extra_invoice.appmt_date, member.name, extra_invoice.list, extra_invoice.price, extra_invoice.discount, extra_invoice.voucher, extra_invoice.credit,extra_invoice.type
FROM extra_invoice
LEFT JOIN member ON extra_invoice.patient_id = member.member_id
WHERE member.city_id=$city AND DATE( appmt_date ) 
BETWEEN  '$start_date'
AND  '$end_date'
UNION ALL
SELECT NULL AS
    `extra_invoice.patient_id,member.member_id`,
    appmt_date AS `DATE`,
    NULL AS `extra_invoice.user_id`,
    NULL AS `extra_invoice.list`,
    SUM(extra_invoice.price) AS price,
    NULL AS `extra_invoice.discount`,
    NULL AS `extra_invoice.voucher`,
    NULL AS `extra_invoice.credit`,
    NULL AS `extra_invoice.type`
FROM
    extra_invoice
 JOIN 
    member
ON
 extra_invoice.patient_id = member.member_id
WHERE 
member.city_id = $city
 AND DATE( appmt_date ) 
BETWEEN  '$start_date'
AND  '$end_date'
GROUP BY DATE( appmt_date )
)a
ORDER BY DATE( appmt_date ) ASC , COALESCE(patient_id,0)
");

$setSql = $query->result_array();
       
//        echo "<pre>";
//        print_r($setSql);
//        echo "</pre>";
// exit;
       
		               // $exceldata="";
		
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
                $this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                $filename='download_excel_file'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
               // header('Content-Disposition: attachment;filename="'.$filename.'"'); 
               // header("Content-Disposition: attachment; filename=".$filename."_Reoprt.xls");
                header("Content-Disposition: attachment; filename=" . $filename ."_".$cityname."_Reoprt.xls");
                //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');


	
	}
	

	
	
}
