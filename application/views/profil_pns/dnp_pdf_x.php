<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$through_print = "wkhtmldopdf";
$filenamez = $this->session->userdata('iduser_zs_simpeg')."_nominatif_pegawai";

$html = "
<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html lang=\"en-US\" xml:lang=\"en-US\" xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<link href='" . base_url() . "assets/css/pdf_wk_landscape_css.css' rel='stylesheet' type='text/css' media='all' />";
/*
$html .= "
<script src=\"".base_url()."assets/js/jquery-1.7.min.js\"></script>
<script src=\"".base_url()."assets/js/splitter_table.js\"></script>
";
*/
$html .= "
</head>
<body>
";

function start_table(){
	return "<table width='100%' class='report' style='border-collapse: collapse;'>";	
}

function end_table(){
	return "</table>";
}

function head_table(){
	$f_html = "<thead>";
	$f_html .= "<tr>";
	$f_html .= "<td>NO</td>";
	$f_html .= "<td>NIP</td>";
	$f_html .= "<td>NAMA LENGKAP</td>";
	$f_html .= "<td>PANGKAT</td>";
	$f_html .= "<td>GOLRU</td>";
	$f_html .= "<td>JABATAN</td>";
	$f_html .= "<td>UNIT ORGANISASI</td>";
	$f_html .= "<td>UNIT KERJA</td>";
	$f_html .= "<td>DUPEG</td>";
	$f_html .= "</tr>";
	$f_html .= "<tr class='nb'>";
	$f_html .= "<td>1</td>";
	$f_html .= "<td>2</td>";
	$f_html .= "<td>3</td>";
	$f_html .= "<td>4</td>";
	$f_html .= "<td>5</td>";
	$f_html .= "<td>6</td>";
	$f_html .= "<td>7</td>";
	$f_html .= "<td>8</td>";
	$f_html .= "<td>9</td>";
	$f_html .= "</tr>";
	$f_html .= "</thead>";
	return $f_html;
}

function break_table(){
	$f_html = "</tbody>";
	$f_html .= end_table();
	$f_html .= "</div>";
	$f_html .= "<div style='page-break-before: always;'>&nbsp;</div>";
	$f_html .= "<div>";
	$f_html .= start_table();
	$f_html .= head_table();
	$f_html .= "<tbody>";		
	return $f_html;	
}

if(isset($data_cetak) && count($data_cetak)){
	$html .= $this->Functions_Model->Header_Report_Landscape("DAFTAR NOMINATIF PEGAWAI <br> PEMERINTAH KABUPATEN CIREBON");
	$html .= "<div>";
	$html .= start_table();
	$html .= head_table();
	$html .= "<tbody>";
	$i = 0; $counter = 0; $count_data = count($data_cetak);
	$hal_pertama = 1; $jml_line = 0;
	foreach($data_cetak as $key => $list){
		$i++; $counter++;
		$tr_param = "bgcolor=#e7eaec";
		if($i % 2){$tr_param="bgcolor=#ffffff";}
		$html .= "<tr valign='top' $tr_param>";
		$html .= "<td class='centers' width='25'>".$i."</td>";
		$html .= "<td class='texts' width='190'>".$list['NIP']."</td>";
		$html .= "<td class='texts' width='230'>".$list['f_namalengkap']."</td>";
		$html .= "<td class='texts' width='150'>".$list['nama_pangkat']."</td>";
		$html .= "<td class='centers' width='50'>".$list['nama_golru']."</td>";
		$html .= "<td class='texts' width='200'>".$list['nama_jab']."</td>";
		$html .= "<td class='texts'>".$list['nama_unor']."</td>";
		$html .= "<td class='texts' width='200'>".$list['nama_unker']."</td>";
		$html .= "<td class='texts' width='50'>".$list['nama_dupeg']."</td>";
		$html .= "</tr>";
		
		/*
		1 => 9,17,22,24
		2 => 29,31,33,42,36
		3 => 52,49,70
		*/
		$len_nama = strlen($list['f_namalengkap']);
		$len_jab = strlen($list['nama_jab']);
		$len_unor = strlen($list['nama_unor']);
		$len_unker = strlen($list['nama_unker']);
		
		$len_jml = $len_jab + $len_unor + $len_unker;
		
		if($len_jab >= 80 || $len_unor >= 80 || $len_unker >= 80){
			$jml_line = $jml_line + 5;
		}elseif($len_jab >= 63 || $len_unor >= 63 || $len_unker >= 63){
			$jml_line = $jml_line + 4;
		}elseif(($len_jab >= 36 && $len_jab <= 70) || ($len_unor >= 36 && $len_unor <= 70) || ($len_unker >= 36 && $len_unker <= 70)){
			$jml_line = $jml_line + 3;
		}elseif($len_nama > 25 && ($len_jab <= 23 || $len_unor <= 22)){
			$jml_line = $jml_line + 2;
		}elseif(($len_jab >= 29 && $len_jab <= 33) || ($len_unor >= 29 && $len_unor <= 33)){
			$jml_line = $jml_line + 2;
		}elseif($len_jml <= 45 && $len_unor < 27){
			$jml_line = $jml_line + 1;
		}elseif($len_jml <= 95){
			$jml_line = $jml_line + 2;
		}else{
			$jml_line = $jml_line + 3;
		}
		
		if($jml_line >= 29 && $hal_pertama==1){
			$html .= break_table();	
			$counter=0;
			$jml_line = 0;
			$hal_pertama++;
		}elseif($jml_line >= 34){
			$html .= break_table();	
			$counter=0;
			$jml_line = 0;
			$hal_pertama++;
		}
	}
	$html .= "</tbody>";
	$html .= end_table();
	$html .= "</div>";

	if(isset($pttd_nama) && $pttd_nama){
		$html .= "<div id='txt_tm_center'>";
		$html .= $this->Functions_Model->IbuKabKota().", ".$this->Functions_Model->Tanggal_Indo(date('Y-m-d'))."<br><r>";
		$html .= "<b>".strtoupper($this->Functions_Model->Full_Jab_Unker($pttd_jab, $pttd_unker))."</b><br>";
		$html .= "<br><br><br><br>";
		$html .= "<b><u>".$pttd_nama."</u></b><br>";
		if(substr($pttd_jab,0,6) != "BUPATI" && substr($pttd_jab,0,8) != "WALIKOTA"){
			$html .= $pttd_pangkat."<br>";
			$html .= "NIP. ".$pttd_NIP."<br>";
		}
		$html .= "</div>";
	}
	
}

$html .= "
</body>
</html>		
";

if($through_print == "wkhtmldopdf"){
	$config['file_name'] = $filenamez;
	$config['paper_size'] = "Folio";
	$config['orientation'] = "Landscape";
	$config['T'] = 15;
	$config['B'] = 15;
	$config['L'] = 15;
	$config['R'] = 15;
	
	date_default_timezone_set('Asia/Jakarta');
	$text_footer = "Dicetak Tanggal : ".$this->Functions_Model->Tanggal_Indo(date("Y-m-d")).", ";
	$text_footer .= "Jam : ".date("H:i:s").", ";
	$text_footer .= "Oleh : ".$this->session->userdata("fullname_zs_simpeg");
	
	$config['text_footer_left'] = $text_footer;
	$config['footer_right_numbering'] = true;
	$config['footer_line'] = true;
	
	$result_pdf = wkhtmltopdf_create($config, $html);
	
}else{	
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
	
	$html = str_replace('<body>', '<body>'.$script, $html); 
	
	$result_pdf = pdf_create(gzcompress($html,9),$filenamez, true, "save", "folio", "Landscape");
}

if($result_pdf){
	echo base_url().$result_pdf;
}else{
	echo 'Gagal';
}

?>