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
		$html .= "<tr><td class='txtcover'>GOLONGAN</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_gol']."</td></tr>";
      $html .= "<tr><td class='txtcover'>BIDANG</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_bid']."</td></tr>";
      $html .= "<tr><td class='txtcover'>KELOMPOK</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_kelompok']."</td></tr>";
      $html .= "<tr><td class='txtcover'>SUB KELOMPOK</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_skel']."</td></tr>";
      $html .= "<tr><td class='txtcover'>SUB SUB KELOMPOK</td><td class='txtcover'>:</td><td class='txtcover'>".$row['kd_sskel']."</td></tr>";
		$html .= "</table>";
		$html .= "</div>";
		$html .= "<div id='foot_cover'>BADAN SAR NASIONAL <br><br><br></div>";
		$html .= "</div>";
		// COVER ------------------------------------------------- END
		
		// DATA UTAMA ------------------------------------------------- START
		$html .= "<div style='page-break-before: always;'></div>";
		//$html .= "<div id='box_pp'>ASSET TANAH";
		//$html .= "</div>";
		
		$html .= "<div id='title_profil'><br><br>DATA UTAMA</div>";
		
      $html .= "<div id='subtitle_profil'><br><br>I. KLASIFIKASI ASSET</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>Level 1</td><td>".$row['kd_lvl1']."</td></tr>";
		$html .= "<tr><td>Level 2</td><td>".$row['kd_lvl2']."</td></tr>";
      $html .= "<tr><td>Level 3</td><td>".$row['kd_lvl3']."</td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
		$html .= "<div id='subtitle_profil'><br><br>II. ASSET</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>Kondisi</td><td>xx</td></tr>";
		$html .= "<tr><td>Unit Kerja</td><td>".$row['unit_pmk']."</td></tr>";
      $html .= "<tr><td>Alamat Unit</td><td>".$row['alm_pmk']."</td></tr>";
      $html .= "<tr><td>Kuantitas</td><td>".$row['kuantitas']."</td></tr>";
		$html .= "<tr><td>No. KIB</td><td>".$row['no_kib']."</td></tr>";
      $html .= "<tr><td>Catatan</td><td>".$row['catatan']."</td></tr>";
		$html .= "<tr><td>Status</td><td>".$row['status']."</td></tr>";
      $html .= "<tr><td>Harga Wajar</td><td>".$row['rph_aset']."</td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
      
      $html .= "<div id='subtitle_profil'><br><br>III. DETAIL ALAT / KENDARAAN</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>Merek</td><td>".$row['merk']."</td></tr>";
		$html .= "<tr><td>Tipe</td><td>".$row['type']."</td></tr>";
      $html .= "<tr><td>Pabrik</td><td>".$row['pabrik']."</td></tr>";
      $html .= "<tr><td>No. Mesin</td><td>".$row['no_mesin']."</td></tr>";
		$html .= "<tr><td>Tahun Buat</td><td>".$row['thn_buat']."</td></tr>";
      $html .= "<tr><td>Tahun Rakit </td><td>".$row['thn_rakit']."</td></tr>";
      $html .= "<tr><td>Negara</td><td>".$row['negara']."</td></tr>";
      $html .= "<tr><td>No. Rangka</td><td>".$row['no_rangka']."</td></tr>";
      $html .= "<tr><td>Lengkap 1</td><td>".$row['lengkap1']."</td></tr>";
      $html .= "<tr><td>Lengkap 2</td><td>".$row['lengkap2']."</td></tr>";
      $html .= "<tr><td>Lengkap 3</td><td>".$row['lengkap3']."</td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
      $html .= "<div id='subtitle_profil'><br><br>III. DETAIL ALAT BESAR</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>Sistem Operasi</td><td>".$row['sis_opr']."</td></tr>";
		$html .= "<tr><td>Kapasitas</td><td>".$row['kapasitas']."</td></tr>";
      $html .= "<tr><td>Sistem Dingin</td><td>".$row['sis_dingin']."</td></tr>";
      $html .= "<tr><td>Duk Alat</td><td>".$row['duk_alat']."</td></tr>";
		$html .= "<tr><td>Sistem Bakar</td><td>".$row['sis_bakar']."</td></tr>";
      $html .= "<tr><td>Power</td><td>".$row['pwr_train']."</td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      //$html .= "'.$data.'";
      
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