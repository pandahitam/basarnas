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
		
		$html .= "<div id='subtitle_profil'><br><br>I. ASSET</div>";
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
      
      
      $html .= "<div id='subtitle_profil'><br><br>II. ADDRESS (* dibutuhkan)</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>Provinsi</td><td>".$row['kd_prov']."</td></tr>";
		$html .= "<tr><td>Kabupaten</td><td>".$row['kd_kab']."</td></tr>";
      $html .= "<tr><td>Kecamatan</td><td>".$row['kd_kec']."</td></tr>";
      $html .= "<tr><td>Kelurahan</td><td>".$row['kd_kel']."</td></tr>";
		$html .= "<tr><td>RT/RW</td><td>".$row['kd_rtrw']."</td></tr>";
      $html .= "<tr><td>Alamat</td><td>".$row['alamat']."</td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
      $html .= "<div id='subtitle_profil'><br><br>III. DETAIL TANAH</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>Luas Seluruhnya</td><td>".$row['luas_tnhs']."</td></tr>";
		$html .= "<tr><td>Luas Bangunan</td><td>".$row['luas_tnhb']."</td></tr>";
      $html .= "<tr><td>Luas Lingkungan</td><td>".$row['luas_tnhl']."</td></tr>";
      $html .= "<tr><td>Luas Kosong</td><td>".$row['luas_tnhk']."</td></tr>";
		$html .= "<tr><td>Utara</td><td>".$row['batas_u']."</td></tr>";
      $html .= "<tr><td>Barat</td><td>".$row['batas_b']."</td></tr>";
      $html .= "<tr><td>Timur</td><td>".$row['batas_t']."</td></tr>";
      $html .= "<tr><td>Selatan</td><td>".$row['batas_s']."</td></tr>";
      $html .= "<tr><td>Surat 1</td><td>".$row['surat1']."</td></tr>";
      $html .= "<tr><td>Surat 2</td><td>".$row['surat2']."</td></tr>";
      $html .= "<tr><td>Surat 3</td><td>".$row['surat3']."</td></tr>";
      $html .= "<tr><td>Milik</td><td>".$row['smilik']."</td></tr>";
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