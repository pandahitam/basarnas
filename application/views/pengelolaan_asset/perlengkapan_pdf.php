<?php
$html = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html lang=\"en-US\" xml:lang=\"en-US\" xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<link href='" . base_url() . "assets/css/pdf_profil_css.css' rel='stylesheet' type='text/css' media='screen' />
";

$html .= "
</head>
<body>
";

if(isset($dataprn) && count($dataprn)){	
	$Logo = array('src'=> base_url().'assets/images/logo_pemda_150.png','style'=>'width: 150px; padding: 2px 2px 2px 2px;');
	$Line = array('src'=> base_url().'assets/images/line_cover.jpg','width'=>'22px','style'=>'padding: 2px 2px 2px 2px;');
	
	foreach($dataprn as $row){
		//print_r($row);
		// COVER ------------------------------------------------- START
		$html .= "<div id='frame_cover'>";
		$html .= "<div id='frame_logo'>".img($Logo)."</div>";
		$html .= "<div id='head_cover'><b><br> SISTEM APLIKASI ASSET BADAN SAR NASIONAL</div>";
		$html .= "<div id='head_sparator'></div>";
		$html .= "<div id='frame_line'>".img($Line)."</div>";
		$html .= "<div id='head_sparator'></div>";
		$html .= "<div id='data_cover'>";
		$html .= "<table width='500px' style='border-collapse: collapse;'>\n";
		$html .= "<tr><td class='txtcover' width='175px'>UNIT KERJA</td><td class='txtcover' width='20px'>:</td><td class='txtcover'>".$row['nama_unker']."</td></tr>";
		$html .= "<tr><td class='txtcover'>UNIT ORGANISASI</td><td class='txtcover'>:</td><td class='txtcover'>".$row['nama_unor']."</td></tr>";
		/*$html .= "<tr><td class='txtcover'>GOLONGAN</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_gol']."</td></tr>";
      $html .= "<tr><td class='txtcover'>BIDANG</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_bid']."</td></tr>";
      $html .= "<tr><td class='txtcover'>KELOMPOK</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_kelompok']."</td></tr>";
      $html .= "<tr><td class='txtcover'>SUB KELOMPOK</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_skel']."</td></tr>";
      $html .= "<tr><td class='txtcover'>SUB SUB KELOMPOK</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_sskel']."</td></tr>";
		*/$html .= "</table>";
		$html .= "</div>";
		$html .= "<div id='foot_cover'>BADAN SAR NASIONAL <br><br><br></div>";
		$html .= "</div>";
		// COVER ------------------------------------------------- END
		
		// DATA UTAMA ------------------------------------------------- START
		$html .= "<div style='page-break-before: always;'></div>";
		//$html .= "<div id='box_pp'>ASSET TANAH";
		//$html .= "</div>";
		
		$html .= "<div id='title_profil'><br><br>DATA UTAMA</div>";
		
      $html .= "<div id='subtitle_profil'><br><br>I. PERLENGKAPAN</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
   	$html .= "<tr><td width='100'>Warehouse</td><td>".$row['nama_warehouse']."</td></tr>";
      $html .= "<tr><td>Ruang</td><td>".$row['ruang_id']."</td></tr>";
      $html .= "<tr><td>Rak</td><td>".$row['rak_id']."</td></tr>";
      $html .= "<tr><td>Part Number</td><td>".$row['part_number']."</td></tr>";
      $html .= "<tr><td>Serial Number</td><td>".$row['serial_number']."</td></tr>";
      $html .= "<tr><td>Kondisi</td><td>".$row['kondisi']."</td></tr>";
      $html .= "<tr><td>Kuantitas</td><td>".$row['kuantitas']."</td></tr>";
      $html .= "<tr><td>Dari</td><td>".$row['dari']."</td></tr>";
	  
      $html .= "<tr><td>Tanggal Perolehan</td><td>".$row['tanggal_perolehan']."</td></tr>";
      $html .= "<tr><td>Umur</td><td>".$row['umur']."</td></tr>";
      $html .= "<tr><td>Umur Maksimum</td><td>".$row['umur_maks']."</td></tr>";
      $html .= "<tr><td>Memiliki Cycle</td><td>".$row['is_cycle']."</td></tr>";
      $html .= "<tr><td>Cycle</td><td>".$row['cycle']."</td></tr>";
      $html .= "<tr><td>Maks Cycle</td><td>".$row['cycle_maks']."</td></tr>";
	  if ($row['alert'] == '0') {$x =  'Ya';} else {$x = 'Tidak';}
      $html .= "<tr><td>Alert</td><td>".$x."</td></tr>";
  
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		
		
		$html .= "<div id='subtitle_profil'><br><br>II. DATA PERLENGKAPAN KHUSUS ANGKUTAN UDARA</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>Installation Date</td><td>".$row['installation_date']."</td></tr>";
		if ($row['jenis_asset'] == 'Udara') { 
		$html .= "<tr><td>Installation A/C TSN</td><td>".$row['installation_ac_tsn']."</td></tr>";
		$html .= "<tr><td>Installation COMP TSN</td><td>".$row['installation_comp_tsn']."</td></tr>";
		$html .= "<tr><td>Task</td><td>".$row['task']."</td></tr>";
		if ($row['is_oc'] == '0') {$x =  'Ya';} else {$x = 'Tidak';}
		$html .= "<tr><td>OC</td><td>".$x."</td></tr>";
		if ($row['is_engine'] == '0') {$x =  'Ya';} else {$x = 'Tidak';}
		$html .= "<tr><td>Engine/Mesin</td><td>".$x."</td></tr>";
		$html .= "<tr><td>ENG Type</td><td>".$row['eng_type']."</td></tr>";
		$html .= "<tr><td>ENG TSO</td><td>".$row['eng_tso']."</td></tr>";
		}

		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
		// DATA UTAMA ------------------------------------------------- END
		
		

		// HALAMAN BARU JIKA PROFIL YANG DICETAK LEBIH DARI SATU PROFIL
		
	}
}

$html .= "
</body>
</html>	
";

$script = '<script type="text/php">';
$script .= '$text_version="a";';
$script .= '$user_info="a";';
$script .= '$tanggal="a"';
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

	// Close the object (stop capture)
  $pdf->close_object();
  			
  // Add the object to every page. You can
  // also specify "all", "odd" or "even", for more see cpdf_adapter.cls.php or pdflib_adapter.cls.php
  $pdf->add_object($footer, "next");
	
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
}
</script>';

//echo $html; exit;


$html = str_replace('<body>', '<body>'.$script, $html); 
pdf_create(gzcompress($html,9), "SIMASS BASARNAS - Tanah", false);

?>