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

if(isset($data_pribadi) && count($data_pribadi)){	
	$Logo = array('src'=> base_url().'assets/images/logo_pemda_150.png','style'=>'width: 150px; padding: 2px 2px 2px 2px;');
	$Line = array('src'=> base_url().'assets/images/line_cover.jpg','width'=>'22px','style'=>'padding: 2px 2px 2px 2px;');
	$Jml_Profil = count($data_pribadi);
	foreach($data_pribadi as $key => $list){
		$cur_NIP = $list['NIP'];
		$cur_Nama_Lengkap = $list['f_namalengkap'];
		$cur_Nama_Pangkat = $list['nama_pangkat'];
		
		$NIP_photo = str_replace(" ","", trim($cur_NIP)); 
		$NIP_photo = str_replace("/","_", $NIP_photo); 
		
		$photo_path = "";
		if(trim(strlen($NIP_photo)) == 18){
			$photo_folder = substr($NIP_photo,8,6)."/";	
			$photo_name = $NIP_photo.".jpg";	
			$photo_path = 'assets/photo/'.$photo_folder.$photo_name;	
		}elseif(trim(strlen($NIP_photo)) == 9){
			$photo_folder = "nip_lama/";
			$photo_name = $NIP_photo.".jpg";
			$photo_path = 'assets/photo/'.$photo_folder.$photo_name;	
		}else{
			$photo_folder = "tnipolri/";
			$photo_name = $NIP_photo.".jpg";	
			$photo_path = 'assets/photo/'.$photo_folder.$photo_name;	
		}
		if(!is_dir($photo_path) && file_exists($photo_path)){
			$photo_path = base_url().$photo_path;
		}else{
			$photo_path = base_url()."assets/photo/anonymous.jpg";
		}
		$Photo = array('src'=> $photo_path,'width'=>'85px','style'=>'margin: 0 5px 0 5px; padding: 2px 2px 2px 2px;');

		// COVER ------------------------------------------------- START
		$html .= "<div id='frame_cover'>";
		$html .= "<div id='frame_logo'>".img($Logo)."</div>";
		$html .= "<div id='head_cover'><b><br> PROFIL PEGAWAI BADAN SAR NASIONAL</div>";
		$html .= "<div id='head_sparator'></div>";
		$html .= "<div id='frame_line'>".img($Line)."</div>";
		$html .= "<div id='head_sparator'></div>";
		$html .= "<div id='data_cover'>";
		$html .= "<table width='500px' style='border-collapse: collapse;'>\n";
		$html .= "<tr><td class='txtcover' width='120px'>Nama Lengkap</td><td class='txtcover' width='20px'>:</td><td class='txtcover'>".$list['f_namalengkap']."</td></tr>";
		$html .= "<tr><td class='txtcover'>NIP</td><td class='txtcover'>:</td><td class='txtcover'>".$list['NIP']."</td></tr>";
		$html .= "<tr><td class='txtcover'>Jabatan</td><td class='txtcover'>:</td><td class='txtcover'>".$list['nama_jab']."</td></tr>";
		$html .= "<tr><td class='txtcover'>Unit Kerja</td><td class='txtcover'>:</td><td class='txtcover'>".$list['unor_unker']."</td></tr>";
		$html .= "</table>";
		$html .= "</div>";
		$html .= "<div id='foot_cover'>BADAN SAR NASIONAL <br>".date("Y")."</div>";
		$html .= "</div>";
		// COVER ------------------------------------------------- END
		
		// KETERANGAN PERORANGAN ------------------------------------------------- START
		$html .= "<div style='page-break-before: always;'></div>";
		$html .= "<div id='box_pp'>ANAK LAMPIRAN 1.C KEPUTUSAN KEPALA BADAN KEPEGAWAIAN NEGARA";
		$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='border-collapse: collapse;'>\n";
		$html .= "<tr><td style='padding: 0 0 0 230px; border: 0px #000000 solid;'>NOMOR</td><td width='10px' style='padding: 0; border: 0px #000000 solid;'>:</td><td width='90px' style='padding: 0; border: 0px #000000 solid;'>11 TAHUN 2012</td></tr>";		
		$html .= "<tr><td style='padding: 0 0 0 230px; border: 0px #000000 solid;'>TANGGAL</td><td width='10px' style='padding: 0; border: 0px #000000 solid;'>:</td><td style='padding: 0; border: 0px #000000 solid;'>17 JUNI 2008</td></tr>";		
		$html .= "</table>";
		$html .= "</div>";
		
		$html .= "<div id='title_profil'><br><br><br><br><br>DAFTAR RIWAYAT HIDUP</div>";
		$html .= "<div id='box_photo'>".img($Photo)."</div>";
		$html .= "<div id='subtitle_profil'><br><br>I. KETERANGAN PERORANGAN</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<tbody>";
		$html .= "<tr><td class='centers' width='20'>1</td><td width='200' colspan='2'>Nama Lengkap</td><td>".$list['f_namalengkap']."</td></tr>";
		$html .= "<tr><td class='centers'>2</td><td colspan='2'>NIP</td><td>".$list['NIP']."</td></tr>";
		$html .= "<tr><td class='centers'>3</td><td colspan='2'>Pangkat dan golongan ruang</td><td>".$list['nama_pangkat'].", ".$list['nama_golru']."</td></tr>";
		$html .= "<tr><td class='centers'>4</td><td colspan='2'>Tempat Lahir, Tanggal Lahir</td><td>".$list['tempat_lahir'].", ".$this->Functions_Model->Tanggal_Indo($list['tanggal_lahir'])."</td></tr>";
		$html .= "<tr><td class='centers'>5</td><td colspan='2'>Jenis Kelamin</td><td>".$list['f_jenis_kelamin']."</td></tr>";
		$html .= "<tr><td class='centers'>6</td><td colspan='2'>Agama</td><td>".$list['agama']."</td></tr>";
		$html .= "<tr><td class='centers'>7</td><td colspan='2'>Status Perkawinan</td><td>".$list['status_kawin']."</td></tr>";

		$html .= "<tr><td class='centers' rowspan='5'>8</td><td rowspan='5'>Alamat Rumah</td><td>a. Jalan</td><td>".$list['alamat']."</td></tr>";
		$html .= "<tr><td>b. Kelurahan/Desa</td><td>".$list['desa']."</td></tr>";
		$html .= "<tr><td>c. Kecamatan</td><td>".$list['kecamatan']."</td></tr>";
		$html .= "<tr><td>d. Kabupaten/Kota</td><td>".$list['kabupaten']."</td></tr>";
		$html .= "<tr><td>e. Provinsi</td><td>".$list['provinsi']."</td></tr>";

		$html .= "<tr><td class='centers' rowspan='7'>9</td><td rowspan='7'>Keterangan Badan</td><td>a. Tinggi (cm)</td><td>".$list['tinggi']."</td></tr>";
		$html .= "<tr><td>b. Berat (kg)</td><td>".$list['berat']."</td></tr>";
		$html .= "<tr><td>c. Rambut</td><td>".$list['rambut']."</td></tr>";
		$html .= "<tr><td>d. Bentuk Muka</td><td>".$list['bentuk_muka']."</td></tr>";
		$html .= "<tr><td>e. Warna Kulit</td><td>".$list['warna_kulit']."</td></tr>";
		$html .= "<tr><td>f. Ciri-ciri Khas</td><td>".$list['ciri2_khas']."</td></tr>";
		$html .= "<tr><td>g. Cacat Tubuh</td><td>".$list['cacat_tubuh']."</td></tr>";

		$html .= "<tr><td class='centers'>10</td><td colspan='2'>Kegemaran (Hobby)</td><td>".$list['hobby']."</td></tr>";

		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		// KETERANGAN PERORANGAN ------------------------------------------------- END
		
		// PENDIDIKAN FORMAL ----------------------------------------------------- START
		$html .= "<div style='page-break-before: always;'></div>";
		$html .= "<div id='subtitle_profil'>II. PENDIDIKAN</div>";
		$html .= "<div id='subtitle_profil'>&nbsp;&nbsp;&nbsp;1. Pendidikan di Dalam dan Luar Negeri</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>TINGKAT</td><td>NAMA PENDIDIKAN</td><td>JURUSAN</td><td>STTB/TANDA LULUS/IJAZAH TAHUN</td><td>TEMPAT</td><td>NAMA KEPALA SEKOLAH/ DIREKTUR/ DEKAN/ PROMOTOR</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($pendidikan) && count($pendidikan)){
			$NIP_Pddk = ""; $i=1;
			foreach($pendidikan as $key => $list){
				$NIP_Pddk = $list['NIP'];
				if($cur_NIP == $NIP_Pddk){
					$html .= "<tr>";
					$html .= "<td class='centers'>".$i."</td>";
					$html .= "<td>".$list['nama_jenjang_pddk']."</td>";
					$html .= "<td>".$list['nama_institusi']."</td>";
					$html .= "<td>".$list['jurusan']."</td>";
					$html .= "<td>".$list['no_ijazah']." / ".$list['tahun_lulus']."</td>";
					$html .= "<td>".$list['alamat_institusi']."</td>";
					$html .= "<td>".$list['kepala_institusi']."</td>";
					$html .= "</tr>";
					$i++;
				}
			}
			if(count($pendidikan) < 5){
				for ($i = 1; $i <= 5 - count($pendidikan); $i++) {
					$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
				}	
			}
		}else{
			for ($i = 1; $i <= 5; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		}		
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		// PENDIDIKAN FORMAL ----------------------------------------------------- END

		// PENDIDIKAN NON FORMAL ----------------------------------------------------- START
		$html .= "<div id='subtitle_profil'><br><br>&nbsp;&nbsp;&nbsp;2. Kursus/Latihan di Dalam dan Luar Negeri</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>NAMA KURSUS/ LATIHAN</td><td>LAMANYA/ TGL/BLN/THN S.D. TGL/BLN/THN</td><td>IJAZAH/TANDA LULUS/SURAT KETERANGAN TAHUN</td><td>TEMPAT</td><td>KETERANGAN</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($pendidikan_nf) && count($pendidikan_nf)){
			$NIP_Pddk_NF = ""; $i=1;
			foreach($pendidikan_nf as $key => $list){
				$NIP_Pddk_NF = $list['NIP'];
				if($cur_NIP == $NIP_Pddk_NF){
					$html .= "<tr>";
					$html .= "<td class='centers'>".$i."</td>";
					$html .= "<td>".$list['nama_pddk_nf']."</td>";
					$html .= "<td>".$list['lama']." Jam <br>".date('d-m-Y', strtotime($list['tgl_m'])).' s.d. '.date('d-m-Y', strtotime($list['tgl_s']))."</td>";
					$html .= "<td>".$list['no_ijazah']."</td>";
					$html .= "<td>".$list['tempat']."</td>";
					$html .= "<td>".$list['ket']."</td>";
					$html .= "</tr>";
					$i++;
				}
			}
			if(count($pendidikan_nf) < 5){
				for ($i = 1; $i <= 5 - count($pendidikan_nf); $i++) {
					$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>";
				}	
			}
		}else{
			for ($i = 1; $i <= 5; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		}	
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		// PENDIDIKAN NON FORMAL ----------------------------------------------------- END
		
		// RIWAYAT JABATAN ----------------------------------------------------- START
		$html .= "<div style='page-break-before: always;'></div>";
		$html .= "<div id='subtitle_profil'>III. RIWAYAT JABATAN</div>";
		$html .= "<div id='subtitle_profil'>&nbsp;&nbsp;&nbsp;1. Riwayat kepangkatan golongan ruang penggajian</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td rowspan='2'>NO</td><td rowspan='2'>PANGKAT</td><td rowspan='2'>GOLRU</td><td rowspan='2'>BERLAKU TERHITUNG MULAI TANGGAL</td><td rowspan='2'>GAJI POKOK (Rp.)</td><td colspan='3'>SURAT KEPUTUSAN</td><td rowspan='2'>PERATURAN YANG DIJADIKAN DASAR</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td>PEJABAT</td><td>NOMOR</td><td>TANGGAL</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($kepangkatan) && count($kepangkatan)){
			$NIP_Kpkt = ""; $i=1;
			foreach($kepangkatan as $key => $list){
				$NIP_Kpkt = $list['NIP'];
				if($cur_NIP == $NIP_Kpkt){
					$html .= "<tr>";
					$html .= "<td class='centers'>".$i."</td>";
					$html .= "<td>".$list['nama_pangkat']."</td>";
					$html .= "<td>".$list['nama_golru']."</td>";
					$html .= "<td>".date("d-m-Y", strtotime($list['TMT_kpkt']))."</td>";
					$html .= "<td>".number_format($list['gapok_kpkt'],0,"",".")."</td>";
					$html .= "<td>".$list['nama_pejabat']."</td>";
					$html .= "<td>".$list['no_sk_kpkt']."</td>";
					$html .= "<td>".date("d-m-Y", strtotime($list['tgl_sk_kpkt']))."</td>";
					$html .= "<td>".$list['dasar_pp']."</td>";
					$html .= "</tr>";		
					$i++;			
				}
			}
			if(count($kepangkatan) < 5){
				for ($i = 1; $i <= 5 - count($kepangkatan); $i++) {
					$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
				}	
			}
		}else{
			for ($i = 1; $i <= 5; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div id='subtitle_profil'><br><br>&nbsp;&nbsp;&nbsp;2. Pengalaman jabatan/pekerjaan</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td rowspan='2'>NO</td><td rowspan='2'>JABATAN/PEKERJAAN</td><td rowspan='2'>MULAI DAN SAMPAI</td><td rowspan='2'>GOLRU</td><td rowspan='2'>GAJI POKOK (Rp.)</td><td colspan='3'>SURAT KEPUTUSAN</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td>PEJABAT</td><td>NOMOR</td><td>TANGGAL</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($jabatan) && count($jabatan)){
			$NIP_Jab = ""; $i=1;
			foreach($jabatan as $key => $list){
				$NIP_Jab = $list['NIP'];
				if (($cur_NIP == $NIP_Jab) and ($list['nama_jab'] <> 'Staf') and ($list['nama_jab'] <> 'Pelaksana') ) {
					$html .= "<tr>";
					$html .= "<td class='centers'>".$i."</td>";
					$html .= "<td>".$list['nama_jab']."</td>";
					$html .= "<td>".date("d-m-Y", strtotime($list['TMT_jab']))."</td>";
					$html .= "<td>".$list['nama_golru']."</td>";
					$html .= "<td>"."</td>";
					$html .= "<td>".$list['nama_pejabat']."</td>";
					$html .= "<td>".$list['no_sk_jab']."</td>";
					$html .= "<td>".date("d-m-Y", strtotime($list['tgl_sk_jab']))."</td>";
					$html .= "</tr>";
					$i++;
				}
			}
			if(count($jabatan) < 5){
				for ($i = 1; $i <= 5 - count($jabatan); $i++) {
					$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
				}	
			}
		}else{
			for ($i = 1; $i <= 5; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		// RIWAYAT JABATAN ----------------------------------------------------- END

		// START - TANDA JASA/PENGHARGAAN
		$html .= "<div style='page-break-before: always;'></div>";
		$html .= "<div id='subtitle_profil'>IV. TANDA JASA/PENGHARGAAN</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>NAMA BINTANG/SATYA <br>LENCANA PENGHARGAAN</td><td>TAHUN<br>PEROLEHAN</td><td>NAMA NEGARA/INSTANSI <br>YANG MEMBERI</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($penghargaan) && count($penghargaan)){
			$i=1;
			foreach($penghargaan as $key => $list){
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['nama_reward']."</td>";
				$html .= "<td>".date("Y", strtotime($list['tgl_sk_reward']))."</td>";
				$html .= "<td>".$list['asal_perolehan']."</td>";
				$html .= "</tr>";
				$i++;
			}
			if(count($penghargaan) < 5){
				for ($i = 1; $i <= 5 - count($penghargaan); $i++) {
					$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
				}	
			}
		}else{
			for ($i = 1; $i <= 5; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
			}
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		// END - TANDA JASA/PENGHARGAAN

		// START - PENGALAMAN KE LUAR NEGERI
		$html .= "<div id='subtitle_profil'>V. PENGALAMAN KE LUAR NEGERI</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>NEGARA</td><td>TUJUAN KUNJUNGAN</td><td>LAMANYA</td><td>YANG MEMBIAYAI</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($pengalaman_KLN) && count($pengalaman_KLN)){
			$i=1;
			foreach($pengalaman_KLN as $key => $list){
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['negara']."</td>";
				$html .= "<td>".$list['tujuan_kunjungan']."</td>";
				$html .= "<td>".$list['lamanya']."</td>";
				$html .= "<td>".$list['yang_membiayai']."</td>";
				$html .= "</tr>";
				$i++;
			}
			if(count($pengalaman_KLN) < 5){
				for ($i = 1; $i <= 5 - count($pengalaman_KLN); $i++) {
					$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>";
				}	
			}
		}else{
			for ($i = 1; $i <= 5; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>";
			}
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		// END - PENGALAMAN KE LUAR NEGERI

		// START - KETERANGAN KELUARGA
		$html .= "<div id='subtitle_profil'>VI. KETERANGAN KELUARGA</div>";
		$html .= "<div id='subtitle_profil'>&nbsp;&nbsp;&nbsp;1. Istri/Suami</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>NAMA</td><td>TEMPAT LAHIR</td><td>TANGGAL LAHIR</td><td>TANGGAL NIKAH</td><td>PEKERJAAN</td><td>KETERANGAN</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($suami_istri) && count($suami_istri)){
			$i=1;
			foreach($suami_istri as $key => $list){
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['nama_si']."</td>";
				$html .= "<td>".$list['tmpt_lahir_si']."</td>";
				$html .= "<td>".date('d-m-Y', strtotime($list['tgl_lahir_si']))."</td>";
				$html .= "<td>".date('d-m-Y', strtotime($list['tgl_nikah_si']))."</td>";
				$html .= "<td>".$list['pekerjaan_si']."</td>";
				$html .= "<td>".$list['ket_si']."</td>";
				$html .= "</tr>";
				$i++;
			}
		}else{
			$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div id='subtitle_profil'>&nbsp;&nbsp;&nbsp;2. Anak</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>NAMA</td><td>JK</td><td>TEMPAT LAHIR</td><td>TANGGAL LAHIR</td><td>SEKOLAH/PEKERJAAN</td><td>KETERANGAN</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($anak) && count($anak)){
			$i=1;
			foreach($anak as $key => $list){
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['nama_anak']."</td>";
				$html .= "<td>".$list['jk_anak']."</td>";
				$html .= "<td>".$list['tmpt_lahir_anak']."</td>";
				$html .= "<td>".date('d-m-Y', strtotime($list['tgl_lahir_anak']))."</td>";
				$html .= "<td>".$list['pekerjaan_anak']."</td>";
				$html .= "<td>".$list['ket_anak']."</td>";
				$html .= "</tr>";
				$i++;
			}
			if(count($anak) < 5){
				for ($i = 1; $i <= 5 - count($anak); $i++) {
					$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
				}
			}
		}else{
			for ($i = 1; $i <= 5; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div id='subtitle_profil'>&nbsp;&nbsp;&nbsp;3. Bapak dan Ibu Kandung</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>NAMA</td><td>TANGGAL LAHIR/<br>UMUR</td><td>PEKERJAAN</td><td>KETERANGAN</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($Bpk_Ibu_Kandung) && count($Bpk_Ibu_Kandung)){
			$i=1;
			foreach($Bpk_Ibu_Kandung as $key => $list){
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['nama_ayah']."</td>";
				$html .= "<td>".date('d-m-Y', strtotime($list['tgl_lahir_ayah']))."</td>";
				$html .= "<td>".$list['pekerjaan_ayah']."</td>";
				$html .= "<td>".$list['ket_ayah']."</td>";
				$html .= "</tr>";
				$i++;
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['nama_ibu']."</td>";
				$html .= "<td>".date('d-m-Y', strtotime($list['tgl_lahir_ibu']))."</td>";
				$html .= "<td>".$list['pekerjaan_ibu']."</td>";
				$html .= "<td>".$list['ket_ibu']."</td>";
				$html .= "</tr>";
			}
		}else{
			for ($i = 1; $i <= 1; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>";
			}
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div style='page-break-before: always;'></div>";
		$html .= "<div id='subtitle_profil'>&nbsp;&nbsp;&nbsp;4. Bapak dan Ibu Mertua</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>NAMA</td><td>TANGGAL LAHIR/<br>UMUR</td><td>PEKERJAAN</td><td>KETERANGAN</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($Bpk_Ibu_Mertua) && count($Bpk_Ibu_Mertua)){
			$i=1;
			foreach($Bpk_Ibu_Mertua as $key => $list){
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['nama_ayah_mertua']."</td>";
				$html .= "<td>".date('d-m-Y', strtotime($list['tgl_lahir_ayah_mertua']))."</td>";
				$html .= "<td>".$list['pekerjaan_ayah_mertua']."</td>";
				$html .= "<td>".$list['ket_ayah_mertua']."</td>";
				$html .= "</tr>";
				$i++;
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['nama_ibu_mertua']."</td>";
				$html .= "<td>".date('d-m-Y', strtotime($list['tgl_lahir_ibu_mertua']))."</td>";
				$html .= "<td>".$list['pekerjaan_ibu_mertua']."</td>";
				$html .= "<td>".$list['ket_ibu_mertua']."</td>";
				$html .= "</tr>";
			}
		}else{
			$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>";
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div id='subtitle_profil'>&nbsp;&nbsp;&nbsp;5. Saudara Kandung</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>NAMA</td><td>JENIS KELAMIN</td><td>TANGGAL LAHIR/<br>UMUR</td><td>PEKERJAAN</td><td>KETERANGAN</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($Saudara) && count($Saudara)){
			$i=1;
			foreach($Saudara as $key => $list){
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['nama_sdr']."</td>";
				$html .= "<td>".$list['jk_sdr']."</td>";
				$html .= "<td>".date('d-m-Y', strtotime($list['tgl_lahir_sdr']))."</td>";
				$html .= "<td>".$list['pekerjaan_sdr']."</td>";
				$html .= "<td>".$list['ket_sdr']."</td>";
				$html .= "</tr>";
				$i++;
			}
			if(count($Saudara) < 5){
				for ($i = 1; $i <= 5 - count($Saudara); $i++) {
					$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>";
				}
			}
		}else{
			for ($i = 1; $i <= 5; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		// END - KETERANGAN KELUARGA

		// START - KETERANGAN ORGANISASI
		$html .= "<div id='subtitle_profil'>VII. KETERANGAN ORGANISASI</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>NO</td><td>JENIS</td><td>NAMA ORGANISASI</td><td>KEDUDUKAN DALAM ORGANISASI</td><td>DALAM <br>THN S.D. THN</td><td>TEMPAT</td><td>NAMA PIMPINAN ORGANISASI</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		if(isset($organisasi) && count($organisasi)){
			$i=1;
			foreach($organisasi as $key => $list){
				$html .= "<tr>";
				$html .= "<td class='centers'>".$i."</td>";
				$html .= "<td>".$list['jenis_org']."</td>";
				$html .= "<td>".$list['nama_org']."</td>";
				$html .= "<td>".$list['jabatan_org']."</td>";
				$html .= "<td>".date('Y', strtotime($list['tgl_m_org']))."-".date('Y', strtotime($list['tgl_s_org']))."</td>";
				$html .= "<td>".$list['lokasi_org']."</td>";
				$html .= "<td>".$list['nama_pimp_org']."</td>";
				$html .= "</tr>";
				$i++;
			}
			if(count($organisasi) < 5){
				for ($i = 1; $i <= 5 - count($organisasi); $i++) {
					$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
				}
			}
		}else{
			for ($i = 1; $i <= 5; $i++) { 
				$html .= "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		// END - KETERANGAN ORGANISASI

		// START - KETERANGAN LAIN-LAIN
		$html .= "<div style='page-break-before: always;'></div>";
		$html .= "<div id='subtitle_profil'>VIII. KETERANGAN LAIN-LAIN</div>";
		$html .= "<div id='BoxTbl'>";
		$html .= "<table width='100%' class='report' style='border-collapse: collapse;'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td width='25px' rowspan='2'>NO</td><td rowspan='2'>NAMA</td><td colspan='3'>SURAT KETERANGAN</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td>PEJABAT</td><td>NOMOR</td><td>TANGGAL</td>";
		$html .= "</tr>";
		$html .= "<tr class='nh'>";
		$html .= "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		if(isset($keterangan_lain) && count($keterangan_lain)){
			$no_skd = $keterangan_lain['no_skd'];
			$pejabat_skd = $keterangan_lain['pejabat_skd'];
			$tgl_skd = date('d-m-Y', strtotime($keterangan_lain['tgl_skd']));
			$no_sbn = $keterangan_lain['no_sbn'];
			$pejabat_sbn = $keterangan_lain['pejabat_sbn'];
			$tgl_sbn = date('d-m-Y', strtotime($keterangan_lain['tgl_sbn']));
			$no_skck = $keterangan_lain['no_skck'];
			$pejabat_skck = $keterangan_lain['pejabat_skck'];
			$tgl_skck = date('d-m-Y', strtotime($keterangan_lain['tgl_skck']));
		}else{
			$no_skd = "";
			$pejabat_skd = "";
			$tgl_skd = "";
			$no_sbn = "";
			$pejabat_sbn = "";
			$tgl_sbn = "";
			$no_skck = "";
			$pejabat_skck = "";
			$tgl_skck = "";
		}
		$html .= "<tbody>";		
		$html .= "<tr>";
		$html .= "<td class='centers'>1</td><td>KETERANGAN BERKELAKUKAN BAIK</td><td>".$pejabat_skck."</td><td>".$no_skck."</td><td>".$tgl_skck."</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td class='centers'>2</td><td>KETERANGAN BERBADAN SEHAT</td><td>".$pejabat_skd."</td><td>".$no_skd."</td><td>".$tgl_skd."</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td class='centers'>3</td><td>KETERANGAN BEBAS NAPZA</td><td>".$pejabat_sbn."</td><td>".$no_sbn."</td><td>".$tgl_sbn."</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td class='centers'>4</td><td colspan='4' height='200px'>KETERANGAN LAIN YANG DIANGGAP PERLU</td>";
		$html .= "</tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";
		// END - KETERANGAN LAIN-LAIN

		$html .= "<br>";
		$html .= "<div id='txt_narasi'>";
		$html .= "Demikian daftar riwayat hidup ini saya buat dengan sesungguhnya dan apabila dikemudian hari terdapat keterangan yang tidak benar saya bersedia dituntut di muka pengadilan serta bersedia menerima segala tindakan yang diambil oleh Pemerintah";
		$html .= "</div>";
		
		// TTD YANG BERSANGKUTAN -------------------------------------------- START
		$html .= "<div id='ybs_sparator'></div>";
		$html .= "<div id='BoxTbl_YBS'>";
		$html .= "<table width='690px' style='border-collapse: collapse;'>\n";
		$html .= "<tr><td class='ClsTd_YBS_Left' width='400px'>&nbsp;</td><td class='ClsTd_YBS'>....................., ................................ ".date('Y')."</td></tr>";
		$html .= "<tr><td class='ClsTd_YBS_Left'>&nbsp;</td><td class='ClsTd_YBS'><b>Yang Membuat Pernyataan,</b></td></tr>";
		$html .= "<tr><td class='ClsTd_YBS_TTD'></td><td class='ClsTd_YBS_TTD'></td></tr>";
		$html .= "<tr><td class='ClsTd_YBS_Left'></td><td class='ClsTd_YBS'><b><u>".$cur_Nama_Lengkap."</u></b></td></tr>";
		$html .= "<tr><td class='ClsTd_YBS_Left'></td><td class='ClsTd_YBS'>NIP. ".$cur_NIP."</td></tr>";
		$html .= "<tr><td class='ClsTd_YBS_Left'></td><td class='ClsTd_YBS'>".$cur_Nama_Pangkat."</td></tr>";
		$html .= "</table>";
		$html .= "</div>";
		
		// TTD YANG BERSANGKUTAN -------------------------------------------- END

		// HALAMAN BARU JIKA PROFIL YANG DICETAK LEBIH DARI SATU PROFIL
		$Jml_Profil--;
		if($Jml_Profil > 0){
			$html .= "<div style='page-break-before: always;'></div>";
		}
	}
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

$filenamez = $this->session->userdata('iduser_zs_simpeg')."_Profil_Pegawai";
$html = str_replace('<body>', '<body>'.$script, $html); 
pdf_create(gzcompress($html,9), $filenamez, false);

?>