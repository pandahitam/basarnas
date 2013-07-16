<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$through_print = "wkhtmldopdfX";
$filenamez = $this->session->userdata('iduser_zs_simpeg')."_nominatif_pegawai";

$html = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html lang=\"en-US\" xml:lang=\"en-US\" xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<link href='" . base_url() . "assets/css/pdf_nominatif_css.css' rel='stylesheet' type='text/css' media='all' />
";

$html .= "
</head>
<body>
";

function start_table(){
	return "<table width='100%' style='border-collapse: collapse;'>";	
}

function end_table(){
	return "</table>";
}

function head_table(){
	$f_html = "<thead>";
	$f_html .= "<tr>";
	$f_html .= "<td rowspan='2' width='2%'>NO</td>";
	$f_html .= "<td rowspan='2' width='14%'>NAMA DAN <br>TEMPAT TANGGAL <br>LAHIR</td>";
	$f_html .= "<td rowspan='2' width='9%'>NIP / NRP <br>KARPEG</td>";
	$f_html .= "<td rowspan='2' width='3%'>AGAMA</td>";
	$f_html .= "<td rowspan='2' width='1.5%'>JK</td>";
	$f_html .= "<td colspan='2' width='4%'>JUMLAH <br>KELUARGA</td>";
	$f_html .= "<td rowspan='2' width='7%'>PENDIDIKAN <br>TERAKHIR <br>JURUSAN <br>THN LULUS</td>";
	$f_html .= "<td rowspan='2' width='5%'>CPNS <br>GOL. <br>TMT</td>";
	$f_html .= "<td colspan='2' width='10%'>PANGKAT TERAKHIR</td>";
	$f_html .= "<td colspan='2' width='3%'>MASA <br>KERJA</td>";
	$f_html .= "<td colspan='4' width='15%'>KURSUS / <br>DIKLAT TEKNIS</td>";
	$f_html .= "<td rowspan='2' width='10%'>LATIHAN <br>JABATAN</td>";
	$f_html .= "<td rowspan='2' width='16.5%'>JABATAN <br>TMT <br>ESELON</td>";
	$f_html .= "</tr>";

	$f_html .= "<tr>";
	$f_html .= "<td>ISTRI/ SUAMI</td>";
	$f_html .= "<td>ANAK</td>";
	$f_html .= "<td width='3%'>GOL. TMT</td>";
	$f_html .= "<td width='7%'>NO. / TGL SK</td>";
	$f_html .= "<td>THN</td>";
	$f_html .= "<td>BLN</td>";
	$f_html .= "<td width='10%'>NAMA DIKLAT</td>";
	$f_html .= "<td width='1.5%'>LAMA</td>";
	$f_html .= "<td width='2%'>TEMPAT</td>";
	$f_html .= "<td width='1.5%'>THN</td>";
	$f_html .= "</tr>";
	
	$f_html .= "<tr class='nh'>";
	$f_html .= "<td>1</td>";
	$f_html .= "<td>2</td>";
	$f_html .= "<td>3</td>";
	$f_html .= "<td>4</td>";
	$f_html .= "<td>5</td>";
	$f_html .= "<td>6</td>";
	$f_html .= "<td>7</td>";
	$f_html .= "<td>8</td>";
	$f_html .= "<td>9</td>";
	$f_html .= "<td>10</td>";
	$f_html .= "<td>11</td>";
	$f_html .= "<td>12</td>";
	$f_html .= "<td>13</td>";
	$f_html .= "<td>14</td>";
	$f_html .= "<td>15</td>";
	$f_html .= "<td>16</td>";
	$f_html .= "<td>17</td>";
	$f_html .= "<td>18</td>";
	$f_html .= "<td>19</td>";
	$f_html .= "</tr>";
	$f_html .= "</thead>";
	return $f_html;
}

function break_table(){
	$f_html = "</tbody>";
	$f_html .= end_table();
	$f_html .= "</div>";
	$f_html .= "<div style='page-break-after: always;'>&nbsp;</div>";
	$f_html .= "<div>";
	$f_html .= start_table();
	$f_html .= head_table();
	$f_html .= "<tbody>";		
	return $f_html;	
}

if(isset($data_cetak) && count($data_cetak)){
	$Logo = array('src'=> base_url().'assets/images/logo_pemda_100_bw.png','style'=>'width: 60px; padding: 2px 2px 2px 2px;');
	$html .= "<div id='box_title'>";
	$html .= "<table width='100%' border='0' style='border-collapse: collapse;'>";
	$html .= "<tr><td class='noborder' width='60'>";
	$html .= "<div id='box_logo'>".img($Logo)."</div>";
	$html .= "</td>";
	$html .= "<td class='noborder'>";
	$html .= "<div id='txt_title'>";
	$html .= "<b>DAFTAR NOMINATIF PEGAWAI <br> BADAN SAR NASIONAL <br>BULAN ".strtoupper($this->Functions_Model->Bulan_Tahun(date('Y-m-d')))."</b>";
	$html .= "</div>";
	$html .= "</td></tr>";
	$html .= "</table>";
	$html .= "</div>";

	$html .= "<div>";
	$html .= start_table();
	$html .= head_table();
	$html .= "<tbody>";
	$i = (isset($start_num)) ? $start_num : 1;	
	foreach($data_cetak as $key => $list){
		$tr_param = ($i % 2) ? "bgcolor='#ffffff'" : "bgcolor='#e7eaec'";

		// START - GET DIKLAT TEKNIS
		$temp = ""; $tr_DT1 = ""; $tr_DT2 = "";
		$diklat_teknis = $this->Profil_PNS_Model->get_DIKLAT_TEKNIS($list['NIP']);
		if(count($diklat_teknis)){
			$rowspan = " rowspan='".count($diklat_teknis)."'";
			foreach($diklat_teknis as $key2 => $list2){
				if($tr_DT1 == ""){
					$tr_DT1 .= "<td class='texts'>".$list2['nama_diklat']."</td>";
					$tr_DT1 .= "<td class='texts'>".$list2['lama_diklat']."</td>";
					$tr_DT1 .= "<td class='texts'>".$list2['lokasi']."</td>";
					$tr_DT1 .= "<td class='centers'>".date('Y', strtotime($list2['tgl_sttpp']))."</td>";
				}else{
					$tr_DT2 .= "<tr valign='top'>";
					$tr_DT2 .= "<td class='texts'>".$list2['nama_diklat']."</td>";
					$tr_DT2 .= "<td class='texts'>".$list2['lama_diklat']."</td>";
					$tr_DT2 .= "<td class='texts'>".$list2['lokasi']."</td>";
					$tr_DT2 .= "<td class='centers'>".date('Y', strtotime($list2['tgl_sttpp']))."</td>";
					$tr_DT2 .= "</tr>";
				}
			}
		}else{
			$rowspan = "";
			$tr_DT1 .= "<td></td>";
			$tr_DT1 .= "<td></td>";
			$tr_DT1 .= "<td></td>";
			$tr_DT1 .= "<td></td>";
		}
		// END - GET DIKLAT TEKNIS

		$html .= "<tr valign='top' $tr_param>";
		$html .= "<td class='centers'".$rowspan.">".$i."</td>";
		$html .= "<td class='texts'".$rowspan.">".$list['f_namalengkap']."<br>".$list['tempat_lahir'].",<br>".date('d-m-Y', strtotime($list['tanggal_lahir']))."</td>";
		$html .= "<td class='texts'".$rowspan.">".$list['NIP']."<br>".$list['no_KARPEG']."</td>";
		$html .= "<td class='texts'".$rowspan.">".$list['agama']."</td>";
		$html .= "<td class='centers'".$rowspan.">".$list['jenis_kelamin']."</td>";
		$html .= "<td class='centers'".$rowspan.">".$list['jml_si']."</td>";
		$html .= "<td class='centers'".$rowspan.">".$list['jml_anak']."</td>";
		$html .= "<td class='texts'".$rowspan.">".$list['nama_pddk']."<br>".$list['jurusan']."<br>".$list['tahun_lulus']."</td>";
		$html .= "<td class='texts'".$rowspan.">".$list['nama_pangkat_cpns']."<br>".$list['nama_golru_cpns']."<br>".date('d-m-Y', strtotime($list['TMT_CPNS']))."</td>";
		$html .= "<td class='texts'".$rowspan.">".$list['nama_pangkat']."<br>".$list['nama_golru']."<br>".date('d-m-Y', strtotime($list['TMT_kpkt']))."</td>";
		$html .= "<td class='texts'".$rowspan.">".$list['no_sk_kpkt']."<br>".date('d-m-Y', strtotime($list['tgl_sk_kpkt']))."</td>";
		$html .= "<td class='centers'".$rowspan.">".substr($list['masa_kerja'],0,2)."</td>";
		$html .= "<td class='centers'".$rowspan.">".substr($list['masa_kerja'],3,2)."</td>";
		$html .= $tr_DT1;
		$diklat_pim = $this->Profil_PNS_Model->get_DIKLAT_PIM($list['NIP']);
		if(count($diklat_pim)){
			$html .= "<td class='texts'".$rowspan.">";
			foreach($diklat_pim as $key3 => $list3){
				$html .= $list3['nama_diklat'].",<br>";
			}
			$html .= "</td>";
		}else{
			$html .= "<td class='texts'".$rowspan.">"."</td>";
		}
		$html .= "<td class='texts'".$rowspan.">".$list['nama_jab']."<br>".date('d-m-Y', strtotime($list['TMT_jab']))."<br>".$list['nama_eselon']."</td>";
		$html .= "</tr>";
		$html .= $tr_DT2;
		$i++;
	}
	$html .= "</tbody>";
	$html .= end_table();
	$html .= "</div>";
	
	if(isset($pttd_nama) && $pttd_nama){
		$html .= "<div id='txt_tm_center'>";
		$html .= $this->Functions_Model->IbuKabKota().", ".$this->Functions_Model->Tanggal_Indo(date('Y-m-d'))."<br><br>";
		$html .= "<b>".strtoupper($this->Functions_Model->Full_Jab_Unker($pttd_jab, $pttd_unker))."</b><br>";
		$html .= "<br><br><br><br>";
		$html .= "<b><u>".$pttd_nama."</u></b><br>";
		$html .= $pttd_pangkat."<br>";
		$html .= "NIP. ".$pttd_NIP."<br>";
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