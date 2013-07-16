<?php
class Test extends CI_Controller{
  function __construct(){
  	parent::__construct();
  }
	
  function index(){
  	//$this->load->view('test_lagi_view');
  	//$this->load->view('test_wkhtmltopdf_view');
  	//write_file('./assets/temp/test.html', 'Test');
  	/*
		$bulan_4 = date("Y-m-d", strtotime(date('Y')."-04-01"));
		$bulan_10 = date("Y-m-d", strtotime(date('Y')."-10-01"));
		if(intval(date('m')) <= 4){
			$hasil = $bulan_4;
		}elseif(intval(date('m')) <= 10){
			$hasil = $bulan_10;
		}else{
			$add_year = strtotime ( '+1 year' , strtotime($bulan_4)) ;
			$hasil = date("Y-m-d", $add_year);
		}
		//echo $hasil;
		$string = $this->session->userdata("a_kode_unker_zs_simpeg");
		$find = $this->session->userdata("kode_unker_zs_simpeg");  
		if(strpos($string, $find) ===false){
			echo 'NO - Did not find <u style="color:red;">'.$find.'</u> in <b>'.$string.'</b>';
		}else{
			echo '<BR>YES - Found <u style="color:green;">'.$find.'</u> in <b>'.$string.'</b>';
		} 
		*/
		echo substr('195607101986031006',8,6);	
		//131259949
  }
  
  function excel(){
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$filename='just_some_random_name.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		//$objWriter->save('./assets/temp/tessssxt.xls');
  }
  
  function excel_reader(){
  	$this->load->library('excel_reader');
  	$uploadpath = "./assets/xls/example.xls";	
  	$this->excel_reader->read($uploadpath);
  	$worksheetrows = $this->excel_reader->val(1,1);
  	echo $this->excel_reader->rowcount();
  	//$worksheetrows = $this->excel_reader->worksheets[0];
  	//$worksheetcolumns = 5;
  	/*
  	echo "<table>";
		foreach($worksheetrows as $worksheetrow){
		 	echo "<tr>";
		  for($i=0; $i < $worksheetcolumns; $i++){
				// if the field is not blank -- otherwise CI will throw warnings
		    if (isset($worksheetrow[$i]))
		    	echo "<td>".$worksheetrow[$i]."</td>";
		    // empty field
		    else
		    	echo "<td>&nbsp; </td>";
		  }
		  echo "</tr>";
		} 
		echo "</table>";
		*/
	}
}
?>