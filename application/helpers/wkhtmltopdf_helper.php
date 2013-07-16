<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function wkhtmltopdf_create($config = array(), $html)
{
	require_once('pdfgenerator.php');

	$pdf = new PDFGenerator();
	$pdf->setInputHTML($html);
	$pdf->setPageSize('57.15mm', '12.7mm');
	$pdf->setMargins(0);
	$pdf->streamToClient();
}

function wkhtmltopdf_createXX($config = array(), $html)
{
	if($html){
		$os_string = php_uname('s');
		if (strpos(strtoupper($os_string), 'WIN')!==false){
			// For Windows
			$cmd = '"C:\\Program Files\\wkhtmltopdf\\wkhtmltopdf.exe"';
		}else{
			// For Linux
			$cmd = "wkhtmltopdf";		
			
		}
		
		// Set Path
		$filenamez = $config['file_name'];	
		$temp_path = "./assets/temp/";	
		$full_filename = $config['file_name'];
		$html_path = $temp_path . $full_filename.".html";
		$url_html = base_url().$temp_path . $full_filename.".html";
		$pdf_dest = $temp_path . $full_filename.".pdf";
		
		// Set Default Options		
		$options = " ";
		$options .= "--dpi 150 ";
		//$options .= "--zoom 1.3 ";		
		$options .= "--footer-font-size 8 ";
		$options .= "--footer-spacing 5 ";
		$options .= "--footer-font-name Arial ";
		$options .= "--print-media-type ";
		$options .= "--encoding UTF-8 ";
		$options .= "--disable-smart-shrinking ";

		// Set Variabel Options
		if($config['paper_size'] == "Folio"){
			$options .= "--page-width 215.9 ";
			$options .= "--page-height 330.2 ";
		}else{
			$options .= "--page-size ".$config['paper_size']." ";
		}
		$options .= "--orientation ".$config['orientation']." ";
		$options .= "--margin-top ".$config['T']." ";
		$options .= "--margin-bottom ".$config['B']." ";
		$options .= "--margin-left ".$config['L']." ";
		$options .= "--margin-right ".$config['R']." ";

		$options .= ($config['footer_line']==true) ? "--footer-line " : "";
		//$options .= ($config['footer_right_numbering']==true) ? "--footer-right \"Hal. [page] dari [toPage]\" " : "";
		//$options .= ($config['text_footer_left']) ? "--footer-left \"".$config['text_footer_left'] ."\" " : "";
		
		// Create HTML Template
		if(write_file($temp_path.$full_filename.".html", $html)){
			// Generate PDF
			$full_cmd = $cmd .' '. $options .' '. $url_html .' '. $pdf_dest . ' 2>&1';
			session_write_close();
			$result = array();
			exec($full_cmd, $result);
			unlink($html_path);
			//print_r($result);
			if(substr($result[0],0,13) == "Loading pages") {				
				return $pdf_dest; 
			}else{
				return false;
			}
			session_start();			
		}else{
			return false;
		}
		
	}
}

?>