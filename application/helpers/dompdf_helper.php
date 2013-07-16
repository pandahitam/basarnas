<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function pdf_create($html, $filename, $first_page = true, $mode='open', $paper_size = 'A4', $orientation = 'portrait')
{
	session_write_close();
	// ON DEMOND SET PHP.INI
 	ini_set("max_execution_time","900");
 	ini_set("max_input_time","1800");
 	ini_set("memory_limit","384M"); 	
	
	require_once("dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->set_paper($paper_size, $orientation);
	$pdf_path = "./assets/pdfs/";
	if(!is_dir($pdf_path)){
		mkdir($pdf_path, 0700);
	}
		
	$dompdf->load_html(gzuncompress($html), 'UTF-8');
	$dompdf->render();
		
	if($mode == 'save') {
		if(write_file($pdf_path.$filename.'.pdf', $dompdf->output(null, $first_page),"w+")) {
			return $pdf_path.$filename.'.pdf';
			session_start();
			exit;
		}else{
			show_error("PDF could not be written to the path");
		}
	}elseif($mode == 'open') {
	 	$options['Attachment'] = 0;
	  $options['Accept-Ranges'] = 0;
	  $options['compress'] = 1;
		if($dompdf->stream($filename.'.pdf', $options, $first_page)) {
			return TRUE;
			session_start();
			exit;
		}else{
			show_error("PDF could not be streamed");
		}
	}else{
		if($dompdf->stream($filename.'.pdf', null, $first_page)) {
			return TRUE;
			session_start();
		} else {
			show_error("PDF could not be streamed");
		}
	}
	session_start();
	exit;
}

function pdf_create_sk($html, $pdf_path = './assets/pdfs/', $filename, $first_page = true, $mode='save', $paper_size = 'folio', $orientation = 'portrait'){
	session_write_close();
	// ON DEMOND SET PHP.INI
 	ini_set("max_execution_time","900");
 	ini_set("max_input_time","1800");
 	ini_set("memory_limit","384M");

	// Check Folder & File
	if(!is_dir('./assets/arsip_sk/')){
		mkdir('./assets/arsip_sk/', 0700);
	}
	if(!is_dir($pdf_path)){
		mkdir($pdf_path, 0700);
	}
	
	require_once("dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->set_paper($paper_size, $orientation);
	$dompdf->load_html(gzuncompress($html), 'UTF-8');
	$dompdf->render();
		
	if(write_file($pdf_path.$filename.'.pdf', $dompdf->output(null, $first_page),"w+")) {
		return $pdf_path.$filename.'.pdf';
	}else{
		show_error("PDF could not be written to the path");
	}
	session_start();
	exit;
}
?>