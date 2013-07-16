<?php
class Functions_Model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function Header_Report_Landscape($title=""){
		$Logo = array('src'=> base_url().'assets/images/logo_pemda_100_bw.png','style'=>'width: 60px; padding: 2px 2px 2px 2px;');
		$html = "<div style='float: left; height: 80px; border: 0px #000000 solid; overflow: hidden;'>";
		$html .= "<table width='100%' border='0' style='border-collapse: collapse;'>";
		$html .= "<tr><td class='noborder' width='60'>";
		$html .= "<div style='width: 60px; min-height: 80px; border: 0px #000000 solid;'>";
		$html .= img($Logo);
		$html .= "</div>";
		$html .= "</td>";
		$html .= "<td class='noborder'>";
		$html .= "<div style='width: 750px; min-height: 80px; border: 0px #000000 solid;'>";
		$html .= "<b>".$title."</b>";
		$html .= "</div>";
		$html .= "</td></tr>";
		$html .= "</table>";
		$html .= "</div>";
		return $html;
	}
	
	function Footer_Report(){
		$script = '<script type="text/php">';
		$script .= '$text_version="'.$this->Version->show().'";';
		$script .= '$user_info="'.$this->session->userdata("fullname_zs_simpeg").'";';
		$script .= '$tanggal="'.$this->Tanggal_Indo(date("Y-m-d")).'";';
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
		return $script;
	}
	
	//format waktu: yyyy-mm-dd, misalnya: 2006-12-31
  function Tanggal_Hari_Indo($xwaktu){
		list($tahun,$bulan,$hari) = explode("-",$xwaktu);
		$waktu = "$hari-$bulan-$tahun";
		
		$jhari = 0;
		$array = explode("-", $waktu);
		$tgl = $array[0];
		$bln = $array[1];
		$thn = $array[2];

		$bulan = "Januari";
		switch($bln)
		{
			case 2: { $bulan = "Pebruari"; $jhari = 31; break; }
			case 3: { $bulan = "Maret"; $jhari = 59; break; }
			case 4: { $bulan = "April"; $jhari = 90; break; }
			case 5: { $bulan = "Mei"; $jhari = 120; break; }
			case 6: { $bulan = "Juni"; $jhari = 151; break; }
			case 7: { $bulan = "Juli"; $jhari = 181; break; }
			case 8: { $bulan = "Agustus"; $jhari = 212; break; }
			case 9: { $bulan = "September"; $jhari = 243; break; }
			case 10: { $bulan = "Oktober"; $jhari = 273; break; }
			case 11: { $bulan = "Nopember"; $jhari = 304; break; }
			case 12: { $bulan = "Desember"; $jhari = 334; }
		}
		
		$jml_kabisat = 1+($thn - ($thn % 4))/4;
		if($thn>100) $jml_kabisat -= ($thn - ($thn % 100))/100;
		if($thn>399) $jml_kabisat += ($thn - ($thn % 400))/400;
		if(($thn%4)<1 && $bln<3) $jml_kabisat--;

		$jmlhari = $thn*365+$jhari+$tgl+$jml_kabisat;

		$urutan_hari = $jmlhari % 7;

		switch($urutan_hari)
		{
			case 0: $hari = "Jumat"; break;
			case 1: $hari = "Sabtu"; break;
			case 2: $hari = "Minggu"; break;
			case 3: $hari = "Senin"; break;
			case 4: $hari = "Selasa"; break;
			case 5: $hari = "Rabu"; break;
			case 6: $hari = "Kamis";
		}

		$pasaran_jawa = $jmlhari % 5;
		switch($pasaran_jawa)
		{
			case 0: $hari_jawa = "Kliwon"; break;
			case 1: $hari_jawa = "Legi"; break;
			case 2: $hari_jawa = "Pahing"; break;
			case 3: $hari_jawa = "Pon"; break;
			case 4: $hari_jawa = "Wage";
		}

		//$hasil = $hari." ".$hari_jawa.", ".$tgl." ".$bulan." ".$thn;
		$hasil = $hari.", ".$tgl." ".$bulan." ".$thn;

		//blokir jika terjadi error saat eksekusi
		if($array[2]>5879610) $hasil = false;
		if($tgl>28)
		{
			if((($thn%4)>0 && $bln==2) || $tgl>30)
			{
				if($bln!=1 || $bln!=3 || $bln!=5 || $bln!=7 || $bln!=8 || $bln!=10 || $bln!=12)
				{
					$hasil = false;
				}
			}
		}
		return $hasil;
  }

	//format waktu: yyyy-mm-dd, misalnya: 2006-12-31
  function Tanggal_Indo($xwaktu){
  	$hasil = null;
		if($xwaktu){
			list($tahun,$bulan,$hari) = explode("-",$xwaktu);
			$waktu = "$hari-$bulan-$tahun";
			
			$jhari = 0;
			$array = explode("-", $waktu);
			$tgl = $array[0];
			$bln = $array[1];
			$thn = $array[2];
	
			$bulan = "Januari";
			switch($bln)
			{
				case 2: { $bulan = "Pebruari"; $jhari = 31; break; }
				case 3: { $bulan = "Maret"; $jhari = 59; break; }
				case 4: { $bulan = "April"; $jhari = 90; break; }
				case 5: { $bulan = "Mei"; $jhari = 120; break; }
				case 6: { $bulan = "Juni"; $jhari = 151; break; }
				case 7: { $bulan = "Juli"; $jhari = 181; break; }
				case 8: { $bulan = "Agustus"; $jhari = 212; break; }
				case 9: { $bulan = "September"; $jhari = 243; break; }
				case 10: { $bulan = "Oktober"; $jhari = 273; break; }
				case 11: { $bulan = "Nopember"; $jhari = 304; break; }
				case 12: { $bulan = "Desember"; $jhari = 334; }
			}
			
			$hasil = $tgl." ".$bulan." ".$thn;
		}		
		return $hasil;
  }

  function Bulan_Tahun($xwaktu){
  	$hasil = null;
		if($xwaktu){
			list($tahun,$bulan,$hari) = explode("-",$xwaktu);
			$waktu = "$hari-$bulan-$tahun";
			
			$array = explode("-", $waktu);
			$tgl = $array[0];
			$bln = $array[1];
			$thn = $array[2];
			
			$bulan = "";
			switch($bln)
			{
				case 1: { $bulan = "Januari"; break; }
				case 2: { $bulan = "Pebruari"; break; }
				case 3: { $bulan = "Maret";  break; }
				case 4: { $bulan = "April"; break; }
				case 5: { $bulan = "Mei"; break; }
				case 6: { $bulan = "Juni";  break; }
				case 7: { $bulan = "Juli"; break; }
				case 8: { $bulan = "Agustus"; break; }
				case 9: { $bulan = "September"; break; }
				case 10: { $bulan = "Oktober"; break; }
				case 11: { $bulan = "Nopember"; break; }
				case 12: { $bulan = "Desember"; break; }
				default:			
			}
	
			$hasil = $bulan." ".$thn;			
		}
		return $hasil;
  }

  function getListBulan(){
  	$Bulan = array();
  	$Bulan = array(
  		'01'=> 'Januari',
  		'02'=> 'Pebruari',
  		'03'=> 'Maret',
  		'04'=> 'April',
  		'05'=> 'Mei',
  		'06'=> 'Juni',
  		'07'=> 'Juli',
  		'08'=> 'Agustus',
  		'09'=> 'September',
  		'10'=> 'Oktober',
  		'11'=> 'Nopember',
  		'12'=> 'Desember'
  	);
  	return $Bulan;
  }	
	
	function getAwalTanggalKerja(){		
		$tgl_1 = date("Y-m-d", strtotime(date("Y-m")."-"."1"));
		$tgl_2 = date("Y-m-d", strtotime(date("Y-m")."-"."2"));
		$tgl_3 = date("Y-m-d", strtotime(date("Y-m")."-"."3"));
		$hasil = $this->checkTanggalKerja($tgl_1);
		if($hasil){
			return $hasil;
		}else{
			$hasil = $this->checkTanggalKerja($tgl_2);
			if($hasil){
				return $hasil;
			}else{
				$hasil = $this->checkTanggalKerja($tgl_3);
				if($hasil){
					return $hasil;
				}else{
					return false;
				}
			}
		}
	}
	
	function checkTanggalKerja($xwaktu){
		$dt = new DateTime($xwaktu);
		$day = $dt->format('l');
		if($day != "Saturday" && $day != "Sunday"){
			$hasil = $xwaktu;
		}else{
			$hasil = false;
		}
		return $hasil;		
	}
	
	// START - DIFF HARI/MINGGU/BULAN
	function Diff_Date($p_dt1=null, $p_dt2=null){
		if($p_dt1 && $p_dt2){
			$hasil = null;
			$dt1 = strtotime($p_dt1);
			$dt2 = strtotime($p_dt2);
			$diff = abs($dt2-$dt1);
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			if($years > 0 && $months > 0 && $days > 0){
				$hasil = $years ." tahun ". $months ." bulan ". $days ." hari";
			}elseif($months > 0 && $days > 0){
				$hasil = $months ." bulan ". $days ." hari";
			}elseif($years > 0){
				$hasil = $years ." tahun";
			}elseif($months > 0){
				$hasil = $months ." bulan";
			}elseif($days > 0){
				$hasil = $days ." hari";
			}
			return $hasil;
		}
	}

	function Diff_Date_Text($p_dt1=null, $p_dt2=null){
		if($p_dt1 && $p_dt2){
			$hasil = null;
			$dt1 = strtotime($p_dt1);
			$dt2 = strtotime($p_dt2);
			$diff = abs($dt2-$dt1);
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			if($years > 0 && $months > 0 && $days > 0){
				$hasil = $years . " (".$this->Terbilang($years,2).") " ." tahun ". $months ." (".$this->Terbilang($months,2).") " ." bulan ". $days ." (".$this->Terbilang($days,2).") " ." hari";
			}elseif($months > 0 && $days > 0){
				$hasil = $months ." (".$this->Terbilang($months,2).") " ." bulan ". $days ." (".$this->Terbilang($days,2).") " ." hari";
			}elseif($years > 0){
				$hasil = $years ." (".$this->Terbilang($years,2).") " ." tahun";
			}elseif($months > 0){
				$hasil = $months ." (".$this->Terbilang($months,2).") " ." bulan";
			}elseif($days > 0){
				$hasil = $days ." (".$this->Terbilang($days,2).") " ." hari";
			}
			return $hasil;
		}
	}

	// END - DIFF HARI/MINGGU/BULAN
	
	// START - TERBILANG
	function kekata($x=0) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = $this->kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . $this->kekata($x - 100);
    } else if ($x <1000) {
        $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . $this->kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
    }      
        return $temp;
	}
	
	function tkoma($x){
		$x = stristr($x, '.'); // digunakan untuk menemukan bilangan setelah koma. Output ".87"
		
		$angka = array ("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");	
		$temp = " ";
		$pjg = strlen($x); // menghitung panjang nilai $x output 3
		$pos = 1;
		
		while ($pos < $pjg){
			$char = substr($x, $pos, 1);	// Mengambil karakter pada posisi 1 sebanyak 1 karakter.
																		// Output : 8 (pengulangan pertama)
																		// 				  7 (pengulangan kedua)
			$pos++;
			$temp .= " " . $angka[$char];
		}
		
		return $temp;
	}
	
	function Terbilang($x=0, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim($this->kekata($x));
    } else {
        $poin = trim($this->tkoma($x));
        $hasil = trim($this->kekata($x));
    }      
    switch ($style) {
        case 1:
            if($poin){
            	$hasil = strtoupper($hasil) . ' KOMA ' . strtoupper($poin);
            }else{
            	$hasil = strtoupper($hasil);
            }
            break;
        case 2:
            if($poin){
            	$hasil = strtolower($hasil) . ' koma ' . strtolower($poin);
            }else{
            	$hasil = strtolower($hasil);
            }
            break;
        case 3:
            if($poin){
            	$hasil = ucwords($hasil) . ' Koma ' . ucwords($poin);
            }else{
            	$hasil = ucwords($hasil);
            }
            break;
        default:
            if($poin){
            	$hasil = ucfirst($hasil) . ' koma ' . ucfirst($poin);
            }else{
            	$hasil = ucfirst($hasil);
            }
            break;
    }      
    return $hasil;
	}	
	// END - TERBILANG
	
	function CAPTCHA(){
		$this->load->helper('captcha');
		
		$vals = array(
    'img_path' => './public/captcha/',
    'img_url' => base_url().'public/captcha/',
    'img_width' => '150',
    'img_height' => 50,
    'expiration' => 7200
    );
		$cap = create_captcha($vals);
		
		$data = array(
    'captcha_time' => $cap['time'],
    'ip_address' => $this->input->ip_address(),
    'word' => $cap['word']
    );
    
    $this->db->insert('captcha',$data);
    
		$form_CAPTCHA = $cap['image']."<br>";
    $form_CAPTCHA .= 'Tuliskan kata pada Gambar yang Anda lihat :<br>';
		$form_CAPTCHA .= '<input type="text" name="captcha" value="" />';
		
		return $form_CAPTCHA;
	}
	
	function Check_CAPTCHA(){
		// First, delete old captchas
		$expiration = time()-7200; // Two hour limit
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
		
		// Then see if a captcha exists:
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($this->input->post('captcha'), $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if ($row->count == 0){
    	return FALSE;
		}else{
			return TRUE;
		}		
	}
	
	function KabKota(){
		return "BADAN SAR NASIONAL";
	}

	function IbuKabKota(){
		return "Jakarta";
	}

	function Bupati_Walikota(){
		return "Kepala Badan SAR Nasional";
	}

	function Nama_Bupati_Walikota(){
		return "";
	}

	function AN_Bupati(){
		return "a.n. KEPALA BADAN SAR NASIONAL";
	}

	function Full_Jab_Unker($jab=null, $unker=null){
		if($jab == "Kepala Badan" || $jab == "Kepala Dinas" || $jab == "Kepala UPT" || $jab == "Kepala UPTD"  || $jab == "Kepala Kantor" || $jab == "Kepala Satuan" || substr($jab,0,3) == "Kepala Cabang"){
			return "Kepala ".$unker;
		}elseif(substr($jab,0,9) == "Inspektur" || $jab == "Sekretaris Daerah"){
			return $jab;
		}elseif($jab == "Direktur RSUD"){
			return "Direktur ".$unker;
		}elseif($jab == "Camat"){
			return "Camat ".str_replace("Kecamatan ", "", $unker);
		}elseif($jab == "Sekretaris Kecamatan"){
			return "Sekretaris Camat ".str_replace("Kecamatan ", "", $unker);
		}elseif($jab == "Lurah" || $jab == "Kepala Kelurahan"){
			return "Lurah ".str_replace("Kelurahan ", "", $unker);
		}elseif($jab == "Sekretaris Kelurahan"){
			return "Sekretaris Lurah ".str_replace("Kelurahan ", "", $unker);
		}else{
			return $jab.' '.$unker;
		}
	}

	function Predikat_DP3($nilai=null){
		if($nilai && is_numeric($nilai)){
			if($nilai >= 1 && $nilai <= 50){
				return "Kurang";
			}elseif($nilai >= 51 && $nilai <= 60){
				return "Sedang";
			}elseif($nilai >= 61 && $nilai <= 75){
				return "Cukup";
			}elseif($nilai >= 76 && $nilai <= 90){
				return "Baik";
			}elseif($nilai >= 91 && $nilai <= 100){
				return "Amat Baik";
			}else{
				return "-";
			}
		}
	}

	function Show_OS(){
		$os_string = php_uname('s');
		if (strpos(strtoupper($os_string), 'WIN')!==false){
			return 'win';
		}else{
			return 'linux';
		}
	}

}
?>