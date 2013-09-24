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
	$Logo = array('src'=> base_url().'assets/images/Logobsnbsr.gif','style'=>'width: 150px; padding: 2px 2px 2px 2px;');
	$Line = array('src'=> base_url().'assets/images/line_cover.jpg','width'=>'22px','style'=>'padding: 2px 2px 2px 2px;');
	
	foreach($dataprn as $row){
	$gambar = array();
	if (!empty($row['image_url']) and ($row['image_url'] != '')) {
        $pic = explode(",", $row['image_url']);
        
        for ($i=0;$i<count($pic);$i++) {
            $gambar[] = array('src'=> base_url().'uploads/images/'.$pic[$i],'style'=>'width: 315px; padding: 2px 2px 2px 2px;');
        }
    }
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
		$html .= "<tr><td class='txtcover'>UNIT ORGANISASI</td><td class='txtcover'>:</td><td class='txtcover'>".strtoupper($row['nama_unor'])."</td></tr>";
		$html .= "<tr><td class='txtcover'>GOLONGAN</td><td class='txtcover'>:</td><td class='txtcover'>".strtoupper($bidang[0]['ur_gol'])."</td></tr>";
      $html .= "<tr><td class='txtcover'>BIDANG</td><td class='txtcover'>:</td><td class='txtcover'>".strtoupper($bidang[1]['ur_bid'])."</td></tr>";
      $html .= "<tr><td class='txtcover'>KELOMPOK</td><td class='txtcover'>:</td><td class='txtcover'>".strtoupper($bidang[2]['ur_kel'])."</td></tr>";
      $html .= "<tr><td class='txtcover'>SUB KELOMPOK</td><td class='txtcover'>:</td><td class='txtcover'>".strtoupper($bidang[3]['ur_skel'])."</td></tr>";
      $html .= "<tr><td class='txtcover'>SUB SUB KELOMPOK</td><td class='txtcover'>:</td><td class='txtcover'>".strtoupper($bidang[4]['ur_sskel'])."</td></tr>";
		$html .= "</table>";
		$html .= "</div>";
      $html .= "<br><br><br><br>";
		$html .= "<div id='foot_cover'>BADAN SAR NASIONAL <br><br></div>";
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
		$html .= "<tr><td width='100'>Kondisi</td><td></td></tr>";
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
		$html .= "<tr><td width='100'>Luas Dasar</td><td>".$row['luas_dsr']."</td></tr>";
		$html .= "<tr><td>Luas Bangunan</td><td>".$row['luas_bdg']."</td></tr>";
      $html .= "<tr><td>Lantai</td><td>".$row['jml_lt']."</td></tr>";
      $html .= "<tr><td>Tahun Selesai</td><td>".$row['thn_sls']."</td></tr>";
		$html .= "<tr><td>Tahun Pakai</td><td>".$row['thn_pakai']."</td></tr>";
      $html .= "<tr><td>No KIB Tanah</td><td>".$row['no_kib']."</td></tr>";
      $html .= "<tr><td>No IMB</td><td>".$row['no_imb']."</td></tr>";
      $html .= "<tr><td>Tgl IMB</td><td>".$row['tgl_imb']."</td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		
		
      $html .= "<div id='subtitle_profil'><br><br>IV. GAMBAR</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		if (count($gambar) > 0) {
			$html .= "<tr><td>";
				for ($i = 0;$i<count($gambar);$i++) {
					$html .= img($gambar[$i]);
				}
			$html .= "</td></tr>";
		} else {
			$html .= "<tr><td align='center'>-</td></tr>";
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
		
      $html .= "<div id='title_profil'><br><br>DATA TAMBAHAN</div>";
      $html .= "<div id='subtitle_profil'><br><br></div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>NJKP</td><td>".$row['njkp']."</td></tr>";
		$html .= "<tr><td>NOP</td><td>".$row['nop']."</td></tr>";
      $html .= "<tr><td>Setoran Pajak</td><td>".$row['setoran_pajak']."</td></tr>";
      $html .= "<tr><td>Waktu Pembayaran</td><td>".$row['waktu_pembayaran']."</td></tr>";
		$html .= "<tr><td>Keterangan</td><td>".$row['keterangan']."</td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
      $html .= "<div id='subtitle_profil'><br><br>RIWAYAT PAJAK</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr align='center' style='font-weight:bold;background:#D3D3D3'><td width='20'>No</td><td>Tahun Pajak</td><td>Tanggal Pembayaran</td><td>Jumlah Setoran</td><td>Keterangan</td></tr>";
      if ($riwayatpajak) {
        $i=1;
      foreach($riwayatpajak as $rowpajak){
        $html .= "<tr><td>".$i."</td><td>".$rowpajak['tahun_pajak']."</td><td>".$rowpajak['tanggal_pembayaran']."</td><td>".$rowpajak['jumlah_setoran']."</td><td>".$rowpajak['keterangan']."</td></tr>";
        $i++;
      }
      } else {
      $html .= "<tr><td colspan='5' align='center'>-</td></tr>";
      }
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
      foreach($pengadaan as $row1){
      
      $html .= "<div id='title_profil'><br><br>PENGADAAN</div>";
      $html .= "<div id='subtitle_profil'></div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>Part Number</td><td>".$row1['part_number']."</td></tr>";
		$html .= "<tr><td>Serial Number</td><td>".$row1['serial_number']."</td></tr>";
      $html .= "<tr><td>Tahun Anggaran</td><td>".$row1['tahun_angaran']."</td></tr>";
      $html .= "<tr><td>Sumber</td><td>".$row1['perolehan_sumber']."</td></tr>";
		$html .= "<tr><td>Perolehan BMN</td><td>".$row1['perolehan_bmn']."</td></tr>";
      $html .= "<tr><td>Perolehan Tanggal</td><td>".$row1['perolehan_tanggal']."</td></tr>";
      $html .= "<tr><td>No Kwitansi</td><td>".$row1['kuitansi_no']."</td></tr>";
      $html .= "<tr><td>Tanggal Kwitansi</td><td>".$row1['kuitansi_tanggal']."</td></tr>";
      $html .= "<tr><td>Bergaransi</td><td>".$row1['is_garansi']."</td></tr>";
      $html .= "<tr><td>Garansi Berlaku</td><td>".$row1['garansi_berlaku']."</td></tr>";
      $html .= "<tr><td>Garansi Ket.</td><td>".$row1['garansi_keterangan']."</td></tr>";
      $html .= "<tr><td>No SPPA</td><td>".$row1['no_sppa']."</td></tr>";
      $html .= "<tr><td>Asal Pengadaan</td><td>".$row1['asal_pengadaan']."</td></tr>";
      $html .= "<tr><td>Total Harga</td><td>".$row1['harga_total']."</td></tr>";
      $html .= "<tr><td>No SP2D</td><td>".$row1['sp2d_no']."</td></tr>";
      $html .= "<tr><td>Tanggal SP2D</td><td>".$row1['sp2d_tanggal']."</td></tr>";
      $html .= "<tr><td>Terpelihara</td><td>".$row1['is_terpelihara']."</td></tr>";
      $html .= "<tr><td>Pelihara Berlaku</td><td>".$row1['pelihara_berlaku']."</td></tr>";
      $html .= "<tr><td>Garansi Ket.</td><td>".$row1['garansi_keterangan']."</td></tr>";
      $html .= "<tr><td>Data Kontrak</td><td>".$row1['data_kontrak']."</td></tr>";
      $html .= "<tr><td>Deskripsi</td><td>".$row1['deskripsi']."</td></tr>";
      $html .= "<tr><td>No Faktur</td><td>".$row1['faktur_no']."</td></tr>";
      $html .= "<tr><td>Tanggal Faktur</td><td>".$row1['faktur_tanggal']."</td></tr>";
      $html .= "<tr><td>No Mutasi</td><td>".$row1['mutasi_no']."</td></tr>";
      $html .= "<tr><td>Tanggal Mutasi</td><td>".$row1['mutasi_tanggal']."</td></tr>";
      $html .= "<tr><td>SPK</td><td>".$row1['is_spk']."</td></tr>";
      $html .= "<tr><td>SPK Berlaku</td><td>".$row1['spk_berlaku']."</td></tr>";
      $html .= "<tr><td>SPK Ket.</td><td>".$row1['spk_keterangan']."</td></tr>";
      $html .= "<tr><td>SPK No.</td><td>".$row1['spk_no']."</td></tr>";
      $html .= "<tr><td>SPK Jenis</td><td>".$row1['spk_jenis']."</td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      }
      
      foreach($pemeliharaan as $row2){
      
      $html .= "<div id='title_profil'><br><br>PEMELIHARAAN</div>";
      $html .= "<div id='subtitle_profil'></div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>Jenis</td><td>".$row2['jenis']."</td></tr>";
		$html .= "<tr><td>Sub Jenis</td><td> </td></tr>";
      $html .= "<tr><td>Tanggal Start Pelaksanaan</td><td></td></tr>";
      $html .= "<tr><td>Tanggal End Pelaksanaan</td><td></td></tr>";
		$html .= "<tr><td>Kondisi</td><td></td></tr>";
      $html .= "<tr><td>Deskripsi</td><td></td></tr>";
      $html .= "<tr><td>Biaya</td><td></td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      }
      
      $html .= "<div id='title_profil'><br><br>PEMINDAHAN</div>";
      $html .= "<div id='subtitle_profil'></div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr align='center' style='font-weight:bold;background:#D3D3D3'><td>No</td><td>No SPPA</td><td>Kode Barang</td><td>Tahun Anggaran</td><td>Tanggal Perolehan</td><td>Kondisi</td><td>Jenis Trn</td><td>Rph Aset</td><td>Merk Type</td><td>Asal Perolehan</td></tr>";
		//if ($pemindahan) {
        //$i=1;
        //foreach($pendayagunaan as $row3){
         // $html .= "<tr><td>".$i."</td><td>".$row3['nama_klasifikasi_aset']."</td><td>".$row3['nama_unker']."</td><td></td><td>".$row3['part_number']."</td><td>".$row3['serial_number']."</td><td>".$row3['mode_pendayagunaan']."</td><td>".$row3['pihak_ketiga']."</td> <td>".$row3['tanggal_start']."</td><td>".$row3['tanggal_end']."</td><td>".$row3['description']."</td></tr>";
         //  $i++;
        //}
      //} else {
      $html .= "<tr><td colspan='10' align='center'>-</td></tr>";
      //}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
		
      $html .= "<div id='title_profil'><br><br>PENGHAPUSAN</div>";
      $html .= "<div id='subtitle_profil'></div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td width='100'>No SPPA</td><td></td></tr>";
		$html .= "<tr><td>Tahun Anggaran</td><td></td></tr>";
		$html .= "<tr><td>Kode Asset</td><td></td></tr>";
		$html .= "<tr><td>No Awal</td><td></td></tr>";
		$html .= "<tr><td>No Akhir</td><td></td></tr>";
		$html .= "<tr><td>Tanggal Perolehan</td><td></td></tr>";
		$html .= "<tr><td>Tanggal Buku</td><td></td></tr>";
		$html .= "<tr><td>No SK</td><td></td></tr>";
		$html .= "<tr><td>Tanggal SK</td><td></td></tr>";
		$html .= "<tr><td>Keterangan</td><td></td></tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
      
      
      $html .= "<div id='title_profil'><br><br>PENDAYAGUNAAN</div>";
      $html .= "<div id='subtitle_profil'></div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr align='center' style='font-weight:bold;background:#D3D3D3'><td>No</td><td>Klasifikasi Aset</td><td>Unit Kerja</td><td>Unit Organisasi</td><td>Part Number</td><td>Serial Number</td><td>Mode Pendayagunaan</td><td>Pihak ke-Tiga</td><td>Tanggal Mulai</td><td>Tanggal Selesai</td><td>Deskripsi</td></tr>";
		if ($pendayagunaan) {
        $i=1;
        foreach($pendayagunaan as $row3){
          $html .= "<tr><td>".$i."</td><td>".$row3['nama_klasifikasi_aset']."</td><td>".$row3['nama_unker']."</td><td></td><td>".$row3['part_number']."</td><td>".$row3['serial_number']."</td><td>".$row3['mode_pendayagunaan']."</td><td>".$row3['pihak_ketiga']."</td>
          <td>".$row3['tanggal_start']."</td><td>".$row3['tanggal_end']."</td><td>".$row3['description']."</td></tr>";
          $i++;
        }
      } else {
      $html .= "<tr><td colspan='11' align='center'>-</td></tr>";
      }
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";

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
pdf_create(gzcompress($html,9), "SIMASS BASARNAS - Bangunan", false);

?>