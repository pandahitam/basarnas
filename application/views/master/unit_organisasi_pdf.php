<?php
$filenamez = "Data_Unit_Organisasi";

$html = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html lang=\"en-US\" xml:lang=\"en-US\" xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<link href='" . base_url() . "assets/css/pdf_css.css' rel='stylesheet' type='text/css' media='all' />
</head>
<body>
";	

if(isset($data_cetak) && count($data_cetak)){
	$html .= "<p><h3>.:: DAFTAR UNIT ORGANISASI</h3></p>";
	
	$i = 0;
	$data_group = "*";
	foreach($data_cetak as $key => $list){
		if($data_group != $list['kode_unker']){
			$i = 0;
			if($data_group != $list['kode_unker'] && $data_group != "*"){$html .= "</tbody></table></div>";}
			if($data_group != "*"){$html .= "<div style='page-break-before: always;'></div>";}
			$data_group = $list['kode_unker'];
			$html .= "<div>";
			$html .= "<table width='100%' style='border-collapse: collapse;'>\n";
			$html .= "<tr><td colspan='5' class='ClsGroup'>UNIT KERJA : ".$list['nama_unker']."</td></tr>";
			$html .= "<thead>";
			$html .= "<tr>";
			$html .= "<td class='ClsTh_start' width='25'>NO</td>";
			$html .= "<td class='ClsTh' width='45'>KODE</td>";
			$html .= "<td class='ClsTh'>NAMA JABATAN</td>";
			$html .= "<td class='ClsTh'>NAMA UNIT ORGANISASI</td>";
			$html .= "<td class='ClsTh' width='45'>ESELON</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<td class='ClsTh2_start'>1</td>";
			$html .= "<td class='ClsTh2'>2</td>";
			$html .= "<td class='ClsTh2'>3</td>";
			$html .= "<td class='ClsTh2'>4</td>";
			$html .= "<td class='ClsTh2'>5</td>";
			$html .= "</tr>";		
			$html .= "</thead>";
		}
		
		$i++;
		$tr_param = "bgcolor=#e7eaec";
		if($i % 2){$tr_param="bgcolor=#ffffff";}
		$html .= ($i == 1) ? "<tbody>":"";
		$html .= "<tr valign='top' $tr_param>";
		$html .= "<td class='centers_start'>".$i."</td>";
		$html .= "<td class='texts'>".$list['kode_unor']."</td>";
		$html .= "<td class='texts'>".$list['jabatan_unor']."</td>";
		$html .= "<td class='texts'>".$list['nama_unor']."</td>";
		$html .= "<td class='texts'>".$list['nama_eselon']."</td>";
		$html .= "</tr>";
	}

	$html .= "</tbody></table></div>";
}

$html .= "
</body>
</html>		
";

$script = '<script type="text/php">';
$script .= '$text_version="'.$this->Version->show().'";';
$script .= '$user_info="'.$this->session->userdata("fullname_zs_simpeg").'";';
$script .= '$tanggal="'.$this->Functions_Model->Tanggal_Indo(date("Y-m-d")).'";';
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
$filenamez = $this->session->userdata('iduser_zs_simpeg')."_unker";
$r_html = pdf_create(gzcompress($html,9),$filenamez, true, "save", "folio", "Landscape");
if($r_html){
	echo base_url().$r_html;
}else{
	echo 'Gagal';
}

?>