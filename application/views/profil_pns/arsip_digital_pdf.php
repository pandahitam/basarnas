<?php
$html = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html lang=\"en-US\" xml:lang=\"en-US\" xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<style>
body {font-family: Helvetica; font-size: 9pt; margin: 0em 0em 0em 0em;} 
p {margin-top: 0;}
#frame_arsip {float: left; margin-left: auto; margin-right: auto; padding: 10px; min-width: 600px; min-height: 180px; border: 0px #000000 solid; text-align: center;}
</style>
";

$html .= "
</head>
<body>
";

if(isset($pathfiles)){
	$html .= "<div align='center'><b><u>ARSIP DIGITAL KEPEGAWAIAN BADAN SAR NASIONAL</u></b></div>";
	if($jns_arsip == 'biodata'){
		$Arsip = array('src'=> $pathfiles,'style'=>'width: 320px; padding: 2px 2px 2px 2px;');
	}else{
		$Arsip = array('src'=> $pathfiles,'style'=>'width: 680px; padding: 2px 2px 2px 2px;');
	}
	
	$html .= "<div id='frame_arsip'>".img($Arsip)."</div>";
}

$html .= "
</body>
</html>	
";

	$script = '<script type="text/php">';
	$script .= '$text_version="'.$this->Version->show().'";';
	$script .= '$user_info="'.$this->session->userdata("fullname_zs_simpeg").'";';
	$script .= '$tanggal="'.$this->Functions_Model->Tanggal_Indo(date("Y-m-d")).'";';
	date_default_timezone_set('Asia/Jakarta');
	$script .= '$jam="'.date("H:i:s").'";';
	$script .= '
	if ( isset($pdf) ) {
		$footer = $pdf->open_object();
		$w = $pdf->get_width();
		$h = $pdf->get_height();
					
		// Draw a line along the bottom
		$y = $h - 2 * $text_height - 32;
		$pdf->line(40, $y, $w - 30, $y, $color, 1);
	
	  $text_footerInfo = "Dicetak Tanggal : " . $tanggal .", Jam : ". $jam .", Oleh : " . $user_info;
	  $text_footerNum = "Hal. {PAGE_NUM} dari {PAGE_COUNT}";
		
	  $font = Font_Metrics::get_font("Helvetica", "bold");
	  $width_version = Font_Metrics::get_text_width($text_version, $font, $size);
	  $pdf->page_text($width_version + 40, $h - 43, $text_version, $font, 7, array(0,0,0));
	
	  $font = Font_Metrics::get_font("Helvetica", "normal");
	  $width_footerInfo = Font_Metrics::get_text_width($text_footerNum, $font, $size);
	  $width_footerNum = Font_Metrics::get_text_width($text_footerNum, $font, $size);
	
	  $pdf->page_text($width_footerInfo + 40, $h - 30, $text_footerInfo, $font, 7, array(0,0,0));
	  $pdf->page_text($w - 16 - $width_footerNum - 55, $h - 30, $text_footerNum, $font, 7, array(0,0,0));				

		// Close the object (stop capture)
	  $pdf->close_object();
	  			
	  // Add the object to every page. You can
	  // also specify "odd" or "even"
	  $pdf->add_object($footer, "all"); 			
	}
	</script>';

//echo $html;
$filenamez = $this->session->userdata('iduser_zs_simpeg')."_arsip_digital";
$html = str_replace('<body>', '<body>'.$script, $html); 
$result_pdf = pdf_create(gzcompress($html,9),$filenamez, true, "save", "folio");

if($result_pdf){
	echo base_url().$result_pdf;
}else{
	echo 'Gagal';
}
?>