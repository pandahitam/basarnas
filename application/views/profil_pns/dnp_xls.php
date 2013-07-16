<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	// Output to browser with appropriate mime type, you choose
	$html = "<?php ";
	$html .= " ";
	$html .= "$this->excel->setActiveSheetIndex(0); ";
	$html .= "$this->excel->getActiveSheet()->setTitle('test worksheet'); ";
	$html .= "$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value'); ";
	$html .= "$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20); ";
	$html .= "$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); ";
	$html .= "$this->excel->getActiveSheet()->mergeCells('A1:D1'); ";
	$html .= "$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); ";
	$html .= " ";
	$html .= " ";
	$html .= "@header('Content-Type: application/vnd.ms-excel'); ";
	$html .= "@header(\"Content-Disposition: attachment; filename=test.xls\"); ";
	$html .= "@header('Cache-Control: max-age=0'); ";
	$html .= "$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); ";
	$html .= "$objWriter->save('php://output');";
	$html .= " ?>";
	$temp_path = "./assets/temp/";
	if(write_file($temp_path."xls_temp.php", $html)){
		echo base_url().$temp_path."xls_temp.php";
	}

?>