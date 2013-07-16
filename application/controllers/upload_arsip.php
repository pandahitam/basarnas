<?php
class Upload_Arsip extends CI_Controller {
	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    }
    $this->load->helper('download');
		$this->load->model('UploadFILE_Model','',TRUE);
		$this->load->model('Upload_Arsip_Model','',TRUE);
	}
	
	function index(){
		echo '';
	}
	
	/* STRUKTUR FOLDER ARSIP
	Untuk PNS dengan NIP Baru :
	./assets/arsip/<kode_arsip>/<thn_tgl_cpns>/<NIP>/<NIP>_<IDFile>.jpg

	Untuk PNS dengan NIP Lama :
	./assets/arsip/<kode_arsip>/nip_lama/<NIP>/<NIP>_<IDFile>.jpg

	Untuk TNI/POLRI/Tenaga Kontrak :
	./assets/arsip/<kode_arsip>/tnipolri/<NIP>/<NIP>_<IDFile>.jpg

	*/
	
	// START - UPLOAD
	function get_arsip($jns_arsip=null){
		if($this->input->post('id_open') && $this->input->post('NIP') && $this->input->post('kode_arsip')){
			$pathfiles = $this->Upload_Arsip_Model->Get_Arsip($jns_arsip);
			echo $pathfiles;
		}
	}

	function insert_arsip($jns_arsip=null){
		if($this->input->post('NIP') && $this->input->post('kode_arsip')){
			$aNIP = explode(",", $this->input->post('NIP'));			
			$NIP = str_replace(" ","", trim($aNIP[0])); 
			$NIP = str_replace("/","_", $NIP);
			$kode_arsip = $this->input->post('kode_arsip');
			switch ($jns_arsip){
				case 'biodata':
					$FileName = $NIP;
					break;
				case 'pendidikan':
					$aIDP_Pddk = explode(",", $this->input->post('IDP_Pddk'));
					$FileName = $NIP."_".$aIDP_Pddk[0];
					break;
				case 'kepangkatan':
					$aIDP_Kpkt = explode(",", $this->input->post('IDP_Kpkt'));
					$FileName = $NIP."_".$aIDP_Kpkt[0];
					break;
				case 'jabatan':
					$aIDP_Jab = explode(",", $this->input->post('IDP_Jab'));
					$FileName = $NIP."_".$aIDP_Jab[0];
					break;
				case 'pendidikan_nf':
					$aIDP_Pddk_NF = explode(",", $this->input->post('IDP_Pddk_NF'));
					$FileName = $NIP."_".$aIDP_Pddk_NF[0];
					break;
				case 'reward':
					$aIDP_Reward = explode(",", $this->input->post('IDP_Reward'));
					$FileName = $NIP."_".$aIDP_Reward[0];
					break;
				default:
			}
			
			$FullPath = $this->UploadFILE_Model->check_folder_arsip($kode_arsip, $NIP);
			if($FullPath){
				$files_info = $this->UploadFILE_Model->upload_set_arsip($FullPath, "filearsip", $FileName);
				if($files_info){
					if($files_info == "GAGAL"){
						echo "{success:false, errors: { reason: 'File harus berekstensi jpg|jpeg|pdf|doc|docx|rar|zip|7z|tar' }}";
					}else{
						if(isset($files_info['file_name'])){
							$FullPathName = $FullPath.$FileName.$files_info['file_ext'];
							$this->Upload_Arsip_Model->Insert_Arsip($jns_arsip, $FullPathName);
							echo "{success:true, errors: { reason: 'SUKSES' }}";
						}else{
							echo "{success:false, errors: { reason: 'Gagal Upload !' }}";
						}
					}
				}else{
					echo "{success:false, errors: { reason: 'Gagal Upload !' }}";
				}
			}else{
				echo "{success:false, errors: { reason: 'Gagal Membuat Struktur Folder !' }}";
			}
		}else{
			echo "{success:false, errors: { reason: 'Ukuran File tidak boleh lebih dari 5 Mb !' }}";
		}
	}

	function delete_arsip($jns_arsip=null){
		if($this->input->post('NIP') && $this->input->post('kode_arsip')){
			$FullPathName = $this->Upload_Arsip_Model->Get_Arsip($jns_arsip);
			if(!is_dir($FullPathName) && file_exists($FullPathName)){
				unlink($FullPathName);
			}
			$this->Upload_Arsip_Model->Delete_Arsip($jns_arsip);
		}
	}	
	
	function cetak_arsip($jns_arsip=null){
		if($this->input->post('id_open') && $this->input->post('NIP') && $this->input->post('kode_arsip')){
			$pathfiles = $this->Upload_Arsip_Model->Get_Arsip($jns_arsip);
			if($pathfiles){
				$data['pathfiles'] = $pathfiles;
				$data['jns_arsip'] = $jns_arsip;
				$this->load->view('profil_pns/arsip_digital_pdf',$data);
			}else{
				echo "GAGAL";
			}
		}
	}

	function prepare_download($jns_arsip=null){
		if($this->input->post('id_open') && $this->input->post('NIP') && $this->input->post('kode_arsip')){
			$pathfiles = $this->Upload_Arsip_Model->Get_Arsip($jns_arsip);
			if($pathfiles && !is_dir($pathfiles) && file_exists($pathfiles)){
				$this->session->set_userdata('pathfiles', $pathfiles);
				echo "OK";
			}else{
				echo "GAGAL";
			}
		}
	}

	function download_arsip($status=null){
		if($status){
			$pathfiles = $this->session->userdata('pathfiles');
	  	$data = file_get_contents($pathfiles);
	    $FileInfo = pathinfo($pathfiles);
	    $name = $FileInfo['filename'].".".$FileInfo['extension'];
	    force_download($name, $data);
		}
	}
	
	// END - UPLOAD

}
?>