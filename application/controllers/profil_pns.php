<?php
class Profil_PNS extends CI_Controller {
	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    }
		$this->load->model('Profil_PNS_Model','',TRUE);
		$this->load->model('Filters_Profil_Model','',TRUE);
		$this->load->model('UploadFILE_Model','',TRUE);
	}
	
	function index(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/profil_pns_view',$data);
		}else{
			$this->load->view('profil_pns/profil_pns_view');
		}
	}

	function ext_get_all(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData();	  			 	
			$total = $this->Profil_PNS_Model->get_CountData();	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}

	// UPLOAD PHOTO --------------------------------------------- START
	function upload_photo(){		
		if($this->input->post('NIP')){
			$NIP = str_replace(" ","", trim($this->input->post('NIP'))); 
			$NIP = str_replace("/","_", $NIP); 
			$Path = "";
			if(strlen($NIP) == 18){
				$photo_folder = substr($NIP,8,6)."/";	
				$Path = './assets/photo/'.$photo_folder.'/';	
				if(!is_dir($Path)){
					mkdir($Path, 0700);
				}
			}elseif(strlen($NIP) == 9){
				$photo_folder = "nip_lama/";	
				$Path = './assets/photo/'.$photo_folder.'/';	
				if(!is_dir($Path)){
					mkdir($Path, 0700);
				}
			}else{
				$photo_folder = "tnipolri/";	
				$Path = './assets/photo/'.$photo_folder.'/';	
				if(!is_dir($Path)){
					mkdir($Path, 0700);
				}
			}
			$photo_info = $this->UploadFILE_Model->upload_set_photo($Path, "filephoto", $NIP);
			if($photo_info){
				if($photo_info == "GAGAL"){
					echo "{success:false, errors: { reason: 'File harus berekstensi jpg !' }}";
				}else{
					echo "{success:true, errors: { reason: 'SUKSES' }}";
				}
			}else{
				echo "{success:false, errors: { reason: 'Gagal Upload !' }}";
			}
		}else{
			echo "{success:false, errors: { reason: 'NIP Pegawai tidak ditemukan !' }}";
		}
	}
	// UPLOAD PHOTO --------------------------------------------- END

	// HAPUS PHOTO --------------------------------------------- START
	function delete_photo(){
		if($this->input->post("photo_nip")){
			$NIP = str_replace(" ","", trim($this->input->post('photo_nip'))); 
			$NIP = str_replace("/","_", $NIP); 
			if(strlen($NIP) == 18){
				$photo_folder = substr($NIP,8,6)."/";	
				$Path = './assets/photo/'.$photo_folder.'/';	
				$FullPath = $Path . $NIP.".jpg";
			}elseif(strlen($NIP) == 9){
				$photo_folder = "nip_lama/";
				$Path = 'assets/photo/'.$photo_folder.'/';	
				$Path = './assets/photo/'.$photo_folder.'/';	
				$FullPath = $Path . $NIP.".jpg";
			}else{
				$photo_folder = "tnipolri/";
				$Path = 'assets/photo/'.$photo_folder.'/';	
				$Path = './assets/photo/'.$photo_folder.'/';	
				$FullPath = $Path . $NIP.".jpg";
			}
			
			if(!is_dir($FullPath) && file_exists($FullPath)){
				unlink($FullPath);
			}
		}
	}
	// HAPUS PHOTO --------------------------------------------- END

	
	// CARI NIP --------------------------------------------- START
	function check_nip(){
		if($this->input->post("id_open") && $this->input->post("NIP_Cari")){
			$data = $this->Profil_PNS_Model->CariNIP($this->input->post("NIP_Cari"));
			if(count($data)){
				echo "ADA";
			}else{
				echo "TIDAK ADA";
			}
		}
	}
	// CARI NIP --------------------------------------------- END

	// PROFIL POPUP --------------------------------------------- START
	function profil_popup(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/profil_pns_popup',$data);
		}else{
			$this->load->view('profil_pns/profil_pns_popup');
		}
	}
	// PROFIL POPUP --------------------------------------------- END
	
	// DAFTAR NOMINATIF PEGAWAI --------------------------------------------- START
	function dnp_page(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/daftar_nominatif_pegawai_view',$data);
		}else{
			$this->load->view('profil_pns/daftar_nominatif_pegawai_view');
		}
	}
	
  function ext_delete_dnp(){
		$this->Profil_PNS_Model->Delete_DNP();	
  }
	
	function cetak_profil($ID_Pgw=''){
		if($ID_Pgw){
			$data_cetak = $this->Profil_PNS_Model->get_SelectedDataPrint($ID_Pgw);
			if(count($data_cetak)){
				$data['data_pribadi'] = $data_cetak['pribadi'];
				$data['suami_istri'] = $data_cetak['suami_istri'];
				$data['anak'] = $data_cetak['anak'];
				$data['Bpk_Ibu_Kandung'] = $data_cetak['Bpk_Ibu_Kandung'];
				$data['Bpk_Ibu_Mertua'] = $data_cetak['Bpk_Ibu_Mertua'];
				$data['Saudara'] = $data_cetak['Saudara'];
				$data['kepangkatan'] = $data_cetak['kepangkatan'];
				$data['jabatan'] = $data_cetak['jabatan'];
				$data['penghargaan'] = $data_cetak['penghargaan'];
				$data['pengalaman_KLN'] = $data_cetak['pengalaman_KLN'];
				$data['organisasi'] = $data_cetak['organisasi'];
				$data['keterangan_lain'] = $data_cetak['keterangan_lain'];

				//$data['diklat_prajabatan'] = $data_cetak['diklat_prajabatan'];
				//$data['diklat_struktural'] = $data_cetak['diklat_struktural'];
				//$data['diklat_teknis'] = $data_cetak['diklat_teknis'];
				//$data['diklat_fungsional'] = $data_cetak['diklat_fungsional'];
				$data['pendidikan'] = $data_cetak['pendidikan'];
				$data['pendidikan_nf'] = $data_cetak['pendidikan_nf'];
				//$data['dp3'] = $data_cetak['dp3'];
				//$data['kgb'] = $data_cetak['kgb'];
				//$data['seminar'] = $data_cetak['seminar'];
				//$data['pengalaman_kerja'] = $data_cetak['pengalaman_kerja'];
				//$data['karya_tulis'] = $data_cetak['karya_tulis'];
				//$data['disiplin'] = $data_cetak['disiplin'];
				$this->load->view('profil_pns/profil_pns_pdf',$data);
			}
		}
	}
	
	function custom_filter(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/profil_pns_custom_filter',$data);
		}else{
			$this->load->view('profil_pns/profil_pns_custom_filter');
		}
	}
	// DAFTAR NOMINATIF PEGAWAI --------------------------------------------- END
	
	// CETAK NOMINATIF PEGAWAI --------------------------------------------- START
  function print_dialog_dnp(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_Pegawai';
			$data['Grid_ID'] = 'Grid_Profil_PNS';
			$data['Params_Print'] = 'Params_PPNS';
			$data['uri_all'] = 'profil_pns/cetak_nominatif/all';
			$data['uri_selected'] = 'profil_pns/cetak_nominatif/selected';
			$data['uri_by_rows'] = 'profil_pns/cetak_nominatif/by_rows/';
			$this->load->view('print_dialog/print_dialog_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_view');
		}
  }

	function cetak_nominatif($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			$data['pttd_NIP'] = $this->input->post('pttd_NIP');
			$data['pttd_nama'] = $this->input->post('pttd_nama');
			$data['pttd_pangkat'] = $this->input->post('pttd_pangkat');
			$data['pttd_golru'] = $this->input->post('pttd_golru');
			$data['pttd_jab'] = $this->input->post('pttd_jab');
			$data['pttd_unker'] = $this->input->post('pttd_unker');
			
			if($p_mode == "all"){
				$data['data_cetak'] = $this->Profil_PNS_Model->get_AllDNPPrint();
			}elseif($p_mode == "selected"){
				$data['data_cetak'] = $this->Profil_PNS_Model->get_SelectedDNPPrint();
			}elseif($p_mode == "by_rows"){
				$data['data_cetak'] = $this->Profil_PNS_Model->get_ByRowsDNPPrint($dari, $sampai);
				$data['start_num'] = $dari;
			}			
			$this->load->view('profil_pns/dnp_pdf',$data);
		}
	}
	// CETAK NOMINATIF PEGAWAI --------------------------------------------- END

	// CSV NOMINATIF PEGAWAI --------------------------------------------- START
  function csv_dialog_dnp(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_Pegawai';
			$data['Grid_ID'] = 'Grid_Profil_PNS';
			$data['Params_Print'] = 'Params_PPNS';
			$data['uri_all'] = 'profil_pns/cetak_nom_csv/all';
			$data['uri_selected'] = 'profil_pns/cetak_nom_csv/selected';
			$data['uri_by_rows'] = 'profil_pns/cetak_nom_csv/by_rows/';
			$this->load->view('print_dialog/csv_dialog_view',$data);
		}else{
			$this->load->view('print_dialog/csv_dialog_view');
		}
  }

	function cetak_nom_csv($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data_cetak = $this->Profil_PNS_Model->get_AllDNPCSVPrint();
			}elseif($p_mode == "selected"){
				$data_cetak = $this->Profil_PNS_Model->get_SelectedDNPCSVPrint();
			}elseif($p_mode == "by_rows"){
				$data_cetak = $this->Profil_PNS_Model->get_ByRowsDNPCSVPrint($dari, $sampai);
			}
			$this->load->dbutil();
			$delimiter = ",";
			$newline = "\r\n";
			$data['data_csv'] = $this->dbutil->csv_from_result($data_cetak, $delimiter, $newline); 
			$this->load->view('csv_viewer', $data);
		}
	}
	
	// CSV NOMINATIF PEGAWAI --------------------------------------------- END

	// EXCEL NOMINATIF PEGAWAI --------------------------------------------- START
  function xls_dialog_dnp(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_Pegawai';
			$data['Grid_ID'] = 'Grid_Profil_PNS';
			$data['Params_Print'] = 'Params_PPNS';
			$data['uri_all'] = 'profil_pns/cetak_nom_xls/all';
			$data['uri_selected'] = 'profil_pns/cetak_nom_xls/selected';
			$data['uri_by_rows'] = 'profil_pns/cetak_nom_xls/by_rows/';
			$this->load->view('print_dialog/xls_dialog_view',$data);
		}else{
			$this->load->view('print_dialog/xls_dialog_view');
		}
  }
	
	function cetak_nom_xls($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data_cetak = $this->Profil_PNS_Model->get_AllDNPPrint();
			}elseif($p_mode == "selected"){
				$data_cetak = $this->Profil_PNS_Model->get_SelectedDNPPrint();
			}elseif($p_mode == "by_rows"){
				$data_cetak = $this->Profil_PNS_Model->get_ByRowsDNPPrint($dari, $sampai);
			}
			session_write_close();
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('nominatif');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DAFTAR NOMINATIF PEGAWAI');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(11);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			//$this->excel->getActiveSheet()->mergeCells('A1:D1');
			
			// Set Paper Size
			$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
			$this->excel->getActiveSheet()->getPageSetup()->setScale(80);
			
			$this->excel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$this->excel->getActiveSheet()->getPageMargins()->setRight(0.25);
			$this->excel->getActiveSheet()->getPageMargins()->setLeft(0.6);
			$this->excel->getActiveSheet()->getPageMargins()->setBottom(0.75);		
			
			// Set Header
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->setCellValue('B3', 'NIP');
			$this->excel->getActiveSheet()->setCellValue('C3', 'NAMA LENGKAP');
			$this->excel->getActiveSheet()->setCellValue('D3', 'PANGKAT');
			$this->excel->getActiveSheet()->setCellValue('E3', 'GOLRU');
			$this->excel->getActiveSheet()->setCellValue('F3', 'JABATAN');
			$this->excel->getActiveSheet()->setCellValue('G3', 'UNIT ORGANISASI');
			$this->excel->getActiveSheet()->setCellValue('H3', 'UNIT KERJA');
			$this->excel->getActiveSheet()->setCellValue('I3', 'DUPEG');
			
			$this->excel->getActiveSheet()->setCellValue('A4', '1');
			$this->excel->getActiveSheet()->setCellValue('B4', '2');
			$this->excel->getActiveSheet()->setCellValue('C4', '3');
			$this->excel->getActiveSheet()->setCellValue('D4', '4');
			$this->excel->getActiveSheet()->setCellValue('E4', '5');
			$this->excel->getActiveSheet()->setCellValue('F4', '6');
			$this->excel->getActiveSheet()->setCellValue('G4', '7');
			$this->excel->getActiveSheet()->setCellValue('H4', '8');
			$this->excel->getActiveSheet()->setCellValue('I4', '9');		

			// Set Alignment Header
			$this->excel->getActiveSheet()->getStyle('A3:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3:I4')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A3:I4')->getFont()->setSize(11);
			
			// Set Width Header
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);

			// Set Fill Color and Border Header
			$this->excel->getActiveSheet()->getStyle('A4:I4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCCCCCC');

			$BorderArray_01 = array(
				'borders' => array(
					'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
					'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
					'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
					'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				),
			);

			$BorderArray_02 = array(
				'borders' => array(
					'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
					'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,),
					'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
					'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				),
			);
			
			$AllBorderArray = array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				),
			);
			
			$this->excel->getActiveSheet()->getStyle('A3')->applyFromArray($BorderArray_01);
			$this->excel->getActiveSheet()->getStyle('B3')->applyFromArray($BorderArray_01);
			$this->excel->getActiveSheet()->getStyle('C3')->applyFromArray($BorderArray_01);
			$this->excel->getActiveSheet()->getStyle('D3')->applyFromArray($BorderArray_01);
			$this->excel->getActiveSheet()->getStyle('E3')->applyFromArray($BorderArray_01);
			$this->excel->getActiveSheet()->getStyle('F3')->applyFromArray($BorderArray_01);
			$this->excel->getActiveSheet()->getStyle('G3')->applyFromArray($BorderArray_01);
			$this->excel->getActiveSheet()->getStyle('H3')->applyFromArray($BorderArray_01);
			$this->excel->getActiveSheet()->getStyle('I3')->applyFromArray($BorderArray_01);
			
			$this->excel->getActiveSheet()->getStyle('A4')->applyFromArray($BorderArray_02);
			$this->excel->getActiveSheet()->getStyle('B4')->applyFromArray($BorderArray_02);
			$this->excel->getActiveSheet()->getStyle('C4')->applyFromArray($BorderArray_02);
			$this->excel->getActiveSheet()->getStyle('D4')->applyFromArray($BorderArray_02);
			$this->excel->getActiveSheet()->getStyle('E4')->applyFromArray($BorderArray_02);
			$this->excel->getActiveSheet()->getStyle('F4')->applyFromArray($BorderArray_02);
			$this->excel->getActiveSheet()->getStyle('G4')->applyFromArray($BorderArray_02);
			$this->excel->getActiveSheet()->getStyle('H4')->applyFromArray($BorderArray_02);
			$this->excel->getActiveSheet()->getStyle('I4')->applyFromArray($BorderArray_02);

			// Set Row Repeat
			$this->excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(3, 4);
			
			$i = 4; $n = 1;
			foreach($data_cetak as $key => $list){
				$i++; 
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $n);
				$this->excel->getActiveSheet()->setCellValue('B'.$i, $list['NIP']);
				$this->excel->getActiveSheet()->setCellValue('C'.$i, $list['f_namalengkap']);
				$this->excel->getActiveSheet()->setCellValue('D'.$i, $list['nama_pangkat']);
				$this->excel->getActiveSheet()->setCellValue('E'.$i, $list['nama_golru']);
				$this->excel->getActiveSheet()->setCellValue('F'.$i, $list['nama_jab']);
				$this->excel->getActiveSheet()->setCellValue('G'.$i, $list['nama_unor']);
				$this->excel->getActiveSheet()->setCellValue('H'.$i, $list['nama_unker']);
				$this->excel->getActiveSheet()->setCellValue('I'.$i, $list['nama_dupeg']);
				$n++;
			}
			$this->excel->getActiveSheet()->getStyle('A5:I'.$i)->getFont()->setSize(10);
			$this->excel->getActiveSheet()->getStyle('E3:E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A5:I'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->getStyle('A5:I'.$i)->getAlignment()->setWrapText(true);
			$this->excel->getActiveSheet()->getStyle('A5:I'.$i)->getBorders()->applyFromArray($AllBorderArray);
			$this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:I'.$i);
			
			// Set Footer
			$this->excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . 'Nominatif Pegawai' . '&RHal. &P dari &N');
			
			// Set Data XLS
			$filename = $this->session->userdata('iduser_zs_simpeg')."_nominatif_pegawai";
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			$objWriter->save("./assets/xls/".$filename.".xls");
			echo base_url()."./assets/xls/".$filename.".xls";
			session_start();
		}
	}
	
	// EXCEL NOMINATIF PEGAWAI --------------------------------------------- END
		
	// BIODATA PEGAWAI --------------------------------------------- START
	function biodata_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/biodata_pns_view',$data);
		}else{
			$this->load->view('profil_pns/biodata_pns_view');
		}
	}
	
	function biodata_data(){
		$type_user = $this->session->userdata("type_zs_simpeg");
		$string = $this->session->userdata("a_kode_unker_zs_simpeg");
		$s_data = false;
		if($this->input->post("id_open") && $this->input->post("ID_Pgw")){
			$array = explode(",", $this->input->post("ID_Pgw"));
			$ID_Pgw = $array[0];
			$data = $this->Profil_PNS_Model->getData_Biodata($ID_Pgw);
			$s_data = true;
		}elseif($this->input->post("id_open") && $this->input->post("NIP")){
			$array = explode(",", $this->input->post("NIP"));
			$NIP = $array[0];
			$data = $this->Profil_PNS_Model->getData_Biodata_ByNIP($NIP);
			$s_data = true;
		}else{
			echo "GAGAL";
		}
		if($s_data == true){
			$find = $data['kode_unker']; 
			if($type_user == 'OPD' && strpos($string, $find) === false){
				echo "GAGAL";
				return false;
			}
			$NIP = str_replace(" ","", trim($data['NIP'])); 
			$NIP = str_replace("/","_", $NIP); 
			$photo_path = "";
			if(trim(strlen($NIP)) == 18){
				$photo_folder = substr($NIP,8,6)."/";
				$photo_name = $NIP.".jpg";
				$photo_path = 'assets/photo/'.$photo_folder.$photo_name;
			}elseif(trim(strlen($NIP)) == 9){
				$photo_folder = "nip_lama/";
				$photo_name = $NIP.".jpg";
				$photo_path = 'assets/photo/'.$photo_folder.$photo_name;
			}elseif(trim(strlen($NIP)) > 4){
				$photo_folder = "tnipolri/";
				$photo_name = $NIP.".jpg";
				$photo_path = 'assets/photo/'.$photo_folder.$photo_name;
			}
			if(!is_dir($photo_path) && file_exists($photo_path)){
				$photo_path = base_url().$photo_path;
			}else{
				$photo_path = base_url()."assets/photo/anonymous.jpg";
			}
			echo '({photo:"'.$photo_path.'",results:'.json_encode($data).'})';
		}
	}

	function head_data(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Profil_PNS_Model->getData_Head($this->input->post("NIP"));
			echo '({results:'.json_encode($data).'})';
		}else{
			echo "GAGAL";
		}		
	}

  function ext_insert_biodata(){
		$Status = $this->Profil_PNS_Model->Insert_Biodata();
		if($Status == TRUE){
			echo "{success:true}";
		}else{
			echo "{success:false, errors: { reason: 'Gagal Menambah Data !' }}";
		}
  }

  function ext_insert_posisi_d_jab(){
		$Status = $this->Profil_PNS_Model->Insert_Posisi_d_Jab();
		if($Status == TRUE){
			echo "{success:true}";
		}else{
			echo "{success:false, errors: { reason: 'Gagal Menambah Data !' }}";
		}
  }

  function ext_insert_data_lainnya(){
		$Status = $this->Profil_PNS_Model->Insert_Data_Lainnya();
		if($Status == TRUE){
			echo "{success:true}";
		}else{
			echo "{success:false, errors: { reason: 'Gagal Menambah Data !' }}";
		}
  }
	// BIODATA PEGAWAI --------------------------------------------- END

	// KELUARGA PEGAWAI --------------------------------------------- START
	function keluarga_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/keluarga_pns_view',$data);
		}else{
			$this->load->view('profil_pns/keluarga_pns_view');
		}
	}
	
	function ext_get_all_suami_istri(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Profil_PNS_Model->get_AllData_Suami_Istri($this->input->post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Suami_Istri($this->input->post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}

  function ext_insert_suami_istri(){  	
		$Status = $this->Profil_PNS_Model->Insert_Suami_Istri();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Suami/Istri dengan nama \"".$this->input->post('nama_si')."\" sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }

  function ext_delete_suami_istri(){
  	if($this->input->post("id_open") && $this->input->post('postdata')){
			$this->Profil_PNS_Model->Delete_Suami_Istri();
		}
  }

	function ext_get_all_anak(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Profil_PNS_Model->get_AllData_Anak($this->input->post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Anak($this->input->post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}

  function ext_insert_anak(){  	
		$Status = $this->Profil_PNS_Model->Insert_Anak();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Anak dengan nama \"".$this->input->post('nama_anak')."\" sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_anak(){
  	if($this->input->post("id_open") && $this->input->post('postdata')){
			$this->Profil_PNS_Model->Delete_Anak();
		}
  }

	function ext_get_all_bpk_ibu_kandung(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Profil_PNS_Model->get_AllData_Bpk_Ibu_Kandung($this->input->post("NIP"));	  			 	
   		echo '({results:'.json_encode($data).'})';
  	}
	}

  function ext_insert_bpk_ibu_kandung(){  	
		$Status = $this->Profil_PNS_Model->Insert_Bpk_Ibu_Kandung();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Bapak & Ibu Kandung sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
  
	function ext_get_all_bpk_ibu_mertua(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Profil_PNS_Model->get_AllData_Bpk_Ibu_Mertua($this->input->post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Bpk_Ibu_Mertua($this->input->post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}

  function ext_insert_bpk_ibu_mertua(){  	
		$Status = $this->Profil_PNS_Model->Insert_Bpk_Ibu_Mertua();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Bapak & Ibu Mertua sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }

  function ext_delete_bpk_ibu_mertua(){
  	if($this->input->post("id_open") && $this->input->post('postdata')){
			$this->Profil_PNS_Model->Delete_Bpk_Ibu_Mertua();
		}
  }

	function ext_get_all_saudara(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Profil_PNS_Model->get_AllData_Saudara($this->input->post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Saudara($this->input->post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}

  function ext_insert_saudara(){  	
		$Status = $this->Profil_PNS_Model->Insert_Saudara();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Saudara dengan nama \"".$this->input->post('nama_sdr')."\" sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_saudara(){
  	if($this->input->post("id_open") && $this->input->post('postdata')){
			$this->Profil_PNS_Model->Delete_Saudara();
		}
  }
	
	// KELUARGA PEGAWAI --------------------------------------------- END

	// PENDIDIKAN PEGAWAI --------------------------------------------- START
	function pendidikan_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/pendidikan_pns_view',$data);
		}else{
			$this->load->view('profil_pns/pendidikan_pns_view');
		}
	}
	
	function ext_get_all_pendidikan(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Pendidikan($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Pendidikan($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_pendidikan(){  	
		$Status = $this->Profil_PNS_Model->Insert_Pendidikan();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data pendidikan sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}elseif($Status == "Over"){
			echo "{success:false, info: { reason: 'Anda tidak diijinkan untuk menambah/merubah data pendidikan yang Anda inginkan !' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_pendidikan(){
		$this->Profil_PNS_Model->Delete_Pendidikan();	
  }		
	// PENDIDIKAN PEGAWAI --------------------------------------------- END

	// PENDIDIKAN NON FORMAL PEGAWAI --------------------------------------------- START
	function pddk_nf_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/pendidikan_nf_pns_view',$data);
		}else{
			$this->load->view('profil_pns/pendidikan_nf_pns_view');
		}
	}
	
	function ext_get_all_pddk_nf(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Pendidikan_NF($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Pendidikan_NF($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_pddk_nf(){  	
		$Status = $this->Profil_PNS_Model->Insert_Pendidikan_NF();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data pendidikan Non Formal sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_pddk_nf(){
		$this->Profil_PNS_Model->Delete_Pendidikan_NF();	
  }		
	// PENDIDIKAN NON FORMAL PEGAWAI --------------------------------------------- END
	
	// KEPANGKATAN PEGAWAI --------------------------------------------- START
	function kepangkatan_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/kepangkatan_pns_view',$data);
		}else{
			$this->load->view('profil_pns/kepangkatan_pns_view');
		}
	}
	
	function ext_get_all_kepangkatan(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Kepangkatan($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Kepangkatan($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_kepangkatan(){  	
		$Status = $this->Profil_PNS_Model->Insert_Kepangkatan();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data kepangkatan sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}elseif($Status == "CPNS"){
			echo "{success:false, info: { reason: 'Jenis Kepangkatan CPNS sudah ada !' }}";
		}elseif($Status == "PNS"){
			echo "{success:false, info: { reason: 'Jenis Kepangkatan PNS sudah ada !' }}";
		}elseif($Status == "Over"){
			echo "{success:false, info: { reason: 'Anda tidak diijinkan untuk menambah/merubah data kepangkatan yang Anda inginkan !' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_kepangkatan(){
		$this->Profil_PNS_Model->Delete_Kepangkatan();	
  }	
	// KEPANGKATAN PEGAWAI --------------------------------------------- END
	
	// JABATAN PEGAWAI --------------------------------------------- START
	function jabatan_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/jabatan_pns_view',$data);
		}else{
			$this->load->view('profil_pns/jabatan_pns_view');
		}
	}
	
	function ext_get_all_jabatan(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Jabatan($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Jabatan($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_jabatan(){  	
		$Status = $this->Profil_PNS_Model->Insert_Jabatan();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data jabatan sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_jabatan(){
		$this->Profil_PNS_Model->Delete_Jabatan();	
  }	
	// JABATAN PEGAWAI --------------------------------------------- END
	
	// DIKLAT KEDINASAN PEGAWAI --------------------------------------------- START
	function diklat_kedinasan_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/diklat_kedinasan_pns_view',$data);
		}else{
			$this->load->view('profil_pns/diklat_kedinasan_pns_view');
		}
	}
	
	function ext_get_all_diklat_kedinasan(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Diklat_Kedinasan($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Diklat_Kedinasan($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_diklat_kedinasan(){  	
		$Status = $this->Profil_PNS_Model->Insert_Diklat_Kedinasan();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Diklat sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_diklat_kedinasan(){
		$this->Profil_PNS_Model->Delete_Diklat_Kedinasan();	
  }	
	// DIKLAT PEGAWAI --------------------------------------------- END	
	
	// DP3 PEGAWAI --------------------------------------------- START
	function dp3_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/dp3_pns_view',$data);
		}else{
			$this->load->view('profil_pns/dp3_pns_view');
		}
	}
	
	function ext_get_all_dp3(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_DP3($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_DP3($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_dp3(){  	
		$Status = $this->Profil_PNS_Model->Insert_DP3();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data DP3 sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_dp3(){
		$this->Profil_PNS_Model->Delete_DP3();	
  }
	// DP3 PEGAWAI --------------------------------------------- END		
	
	// ANGKA KREDIT PEGAWAI --------------------------------------------- START
	function ak_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/ak_pns_view',$data);
		}else{
			$this->load->view('profil_pns/ak_pns_view');
		}
	}
	
	function ext_get_all_ak(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_AK($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_AK($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_ak(){  	
		$Status = $this->Profil_PNS_Model->Insert_AK();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Angka Kredit sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_ak(){
		$this->Profil_PNS_Model->Delete_AK();	
  }
	// ANGKA KREDIT PEGAWAI --------------------------------------------- END		
		
	// GAJI BERKALA PEGAWAI --------------------------------------------- START
	function gaji_berkala_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/gaji_berkala_pns_view',$data);
		}else{
			$this->load->view('profil_pns/gaji_berkala_pns_view');
		}
	}
	
	function ext_get_all_gaji_berkala(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Gaji_Berkala($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Gaji_Berkala($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_gaji_berkala(){  	
		$Status = $this->Profil_PNS_Model->Insert_Gaji_Berkala();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Gaji Berkala sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_gaji_berkala(){
		$this->Profil_PNS_Model->Delete_Gaji_Berkala();	
  }
	// GAJI BERKALA PEGAWAI --------------------------------------------- END		

	// TUNJANGAN RESIKO PEGAWAI --------------------------------------------- START
	function tunjangan_resiko_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/tunjangan_resiko_pns_view',$data);
		}else{
			$this->load->view('profil_pns/tunjangan_resiko_pns_view');
		}
	}
	
	function ext_get_all_tunjangan_resiko(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Tunjangan_Resiko();	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Tunjangan_Resiko();
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_tunjangan_resiko(){  	
		$Status = $this->Profil_PNS_Model->Insert_Tunjangan_Resiko();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Tunjangan Resiko sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_tunjangan_resiko(){
		$this->Profil_PNS_Model->Delete_Tunjangan_Resiko();	
  }
	// TUNJANGAN RESIKO PEGAWAI --------------------------------------------- END		
	
	// PENGHARGAAN PEGAWAI --------------------------------------------- START
	function penghargaan_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/penghargaan_pns_view',$data);
		}else{
			$this->load->view('profil_pns/penghargaan_pns_view');
		}
	}
	
	function ext_get_all_penghargaan(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Penghargaan($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Penghargaan($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_penghargaan(){  	
		$Status = $this->Profil_PNS_Model->Insert_Penghargaan();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Penghargaan sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_penghargaan(){
		$this->Profil_PNS_Model->Delete_Penghargaan();	
  }
	// PENGHARGAAN PEGAWAI --------------------------------------------- END		

	// DISIPLIN KEPEGAWAIAN PEGAWAI --------------------------------------------- START
	function disiplin_kepegawaian_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/disiplin_kepegawaian_pns_view',$data);
		}else{
			$this->load->view('profil_pns/disiplin_kepegawaian_pns_view');
		}
	}
	
	function ext_get_all_disiplin_kepegawaian(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_HukDis($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_HukDis($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_disiplin_kepegawaian(){  	
		$Status = $this->Profil_PNS_Model->Insert_HukDis();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Disiplin Kepegawaian sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_disiplin_kepegawaian(){
		$this->Profil_PNS_Model->Delete_HukDis();	
  }
	// DISIPLIN KEPEGAWAIAN PEGAWAI --------------------------------------------- END		

	// SEMINAR PEGAWAI --------------------------------------------- START
	function seminar_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/seminar_pns_view',$data);
		}else{
			$this->load->view('profil_pns/seminar_pns_view');
		}
	}
	
	function ext_get_all_seminar(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Seminar($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Seminar($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_seminar(){  	
		$Status = $this->Profil_PNS_Model->Insert_Seminar();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Seminar sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_seminar(){
		$this->Profil_PNS_Model->Delete_Seminar();	
  }
	// SEMINAR PEGAWAI --------------------------------------------- END		

	// KARYA TULIS PEGAWAI --------------------------------------------- START
	function karya_tulis_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/karya_tulis_pns_view',$data);
		}else{
			$this->load->view('profil_pns/karya_tulis_pns_view');
		}
	}
	
	function ext_get_all_karya_tulis(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Karya_Tulis($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Karya_Tulis($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_karya_tulis(){  	
		$Status = $this->Profil_PNS_Model->Insert_Karya_Tulis();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Karya Tulis sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_karya_tulis(){
		$this->Profil_PNS_Model->Delete_Karya_Tulis();	
  }
	// KARYA TULIS PEGAWAI --------------------------------------------- END		

	// ORGANISASI PEGAWAI --------------------------------------------- START
	function organisasi_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/organisasi_pns_view',$data);
		}else{
			$this->load->view('profil_pns/organisasi_pns_view');
		}
	}
	
	function ext_get_all_organisasi(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Organisasi($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Organisasi($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_organisasi(){  	
		$Status = $this->Profil_PNS_Model->Insert_Organisasi();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Organisasi sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_organisasi(){
		$this->Profil_PNS_Model->Delete_Organisasi();	
  }
	// ORGANISASI PEGAWAI --------------------------------------------- END		

	// KARIR SEBELUM PNS PEGAWAI --------------------------------------------- START
	function karir_sebelum_pns_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/karir_sebelum_pns_pns_view',$data);
		}else{
			$this->load->view('profil_pns/karir_sebelum_pns_pns_view');
		}
	}
	
	function ext_get_all_karir_sebelum_pns(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Karir_SPNS($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Karir_SPNS($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_karir_sebelum_pns(){  	
		$Status = $this->Profil_PNS_Model->Insert_Karir_SPNS();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Karir Sebelum PNS sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_karir_sebelum_pns(){
		$this->Profil_PNS_Model->Delete_Karir_SPNS();	
  }
	// KARIR SEBELUM PNS PEGAWAI --------------------------------------------- END		

	// PENGALAMAN KE LUAR NEGERI PEGAWAI --------------------------------------------- START
	function pengalaman_kln_page(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/pengalaman_kln_pns_view',$data);
		}else{
			$this->load->view('profil_pns/pengalaman_kln_pns_view');
		}
	}
	
	function ext_get_all_pengalaman_kln(){
		if($this->input->post("id_open")){
			$data = $this->Profil_PNS_Model->get_AllData_Pengalaman_KLN($this->input->get_post("NIP"));	  			 	
			$total = $this->Profil_PNS_Model->get_CountData_Pengalaman_KLN($this->input->get_post("NIP"));	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	
  function ext_insert_pengalaman_kln(){  	
		$Status = $this->Profil_PNS_Model->Insert_Pengalaman_KLN();
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Data Pengalaman Ke Luar Negeri sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }
	
  function ext_delete_pengalaman_kln(){
		$this->Profil_PNS_Model->Delete_Pengalaman_KLN();	
  }
	// PENGALAMAN KE LUAR NEGERI PEGAWAI --------------------------------------------- END		
		
	// CHECK STATUS PMK --------------------------------------------- START
	function ext_check_pmk(){
		if($this->input->post('NIP')){
			$data = $this->Profil_PNS_Model->Check_PMK();
			if(count($data)){
				echo "{success:true, info: { reason: 'PMK : ".$data['mk_th_usul']." TH ".$data['mk_bl_usul']." BL' + ', TMT : ". strftime("%d-%m-%Y",strtotime($data['TMT_pmkg']))."' }}";
			}else{
				echo "{success:false, info: { reason: '' }}";
			}
		}else{
			echo "{success:false, info: { reason: '' }}";
		}
	}
	// CHECK STATUS PMK --------------------------------------------- END		

	// CHECK STATUS MUTASI --------------------------------------------- START
	function ext_check_mutasi(){
		if($this->input->post('NIP')){
			$r_data = $this->Profil_PNS_Model->Check_Mutasi();
			if($r_data){
				echo "{success:true, info: { reason: '".$r_data."' }}";
			}else{
				echo "{success:false, info: { reason: '' }}";
			}
		}else{
			echo "{success:false, info: { reason: '' }}";
		}
	}
	// CHECK STATUS MUTASI --------------------------------------------- END		

}
?>