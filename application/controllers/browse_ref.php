<?php
class Browse_Ref extends CI_Controller {
	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    }
		$this->load->model('Browse_Ref_Model','',TRUE);
	}
	
	function index(){echo '';}	

	function ext_search_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_Biodata($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}
	}

	function ext_search_pegawai_browse(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_Pegawai_Browse();
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_get_id_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_Biodata($this->input->post("NIP"));
			if(count($data)){
				echo $data['ID_Pegawai'];
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}
	
	function ext_search_si_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_Sumai_Istri($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_alamat_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_Alamat($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_pddk_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_Pddk($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_cpns_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_CPNS($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_kpkt_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_KPKT($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_ak_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_AK($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_pmkg_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_PMKG($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_kgb_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_KGB($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_dp3_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_DP3($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_prajab_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_PraJab($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_rikes_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_RiKes($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	function ext_search_pensiun_pegawai(){
		if($this->input->post("id_open") && $this->input->post("NIP")){
			$data = $this->Browse_Ref_Model->getData_Pensiun($this->input->post("NIP"));
			if(count($data)){
				echo '({results:'.json_encode($data).'})';
			}else{
				echo "GAGAL";
			}
		}else{
			echo "GAGAL";
		}		
	}

	// BROWSE PEGAWAI ------------------------------------------- START
	function ext_get_all_pegawai(){
		if($this->input->post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Pegawai();	
			$total = $this->Browse_Ref_Model->get_CountData_Pegawai();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}  
	// BROWSE PEGAWAI ------------------------------------------- END

	// BROWSE PANGKAT, GOLRU ------------------------------------------- START
	function ext_get_all_pangkat_pgw(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Pangkat_Pgw();	
			$total = $this->Browse_Ref_Model->get_CountData_Pangkat_Pgw();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE PANGKAT, GOLRU ------------------------------------------- END

	// BROWSE PANGKAT, GOLRU UP LEVEL ---------------------------------- START
	function ext_get_all_golru_up_level(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Golru_Up_Level();	
			$total = $this->Browse_Ref_Model->get_CountData_Golru_Up_Level();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE PANGKAT, GOLRU UP LEVEL ---------------------------------- END

	// BROWSE PENILAI ------------------------------------------- START
	function ext_get_all_penilai(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Penilai();	
			$total = $this->Browse_Ref_Model->get_CountData_Penilai();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}  
	// BROWSE PENILAI ------------------------------------------- END

	// BROWSE UNIT KERJA ------------------------------------------- START
	function ext_get_all_unit_kerja(){
		if($this->input->get_post("id_open")){
			$data = $this->Unit_Kerja_Model->get_AllData();	  			 	
			$total = $this->Unit_Kerja_Model->get_CountData();	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';	
  	}
	}
	// BROWSE UNIT KERJA ------------------------------------------- START

	// BROWSE JABATAN ------------------------------------------- START
	function ext_get_all_jabatan(){
		if($this->input->post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Jabatan();
			$total = $this->Browse_Ref_Model->get_CountData_Jabatan();
			echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	// BROWSE JABATAN ------------------------------------------- END

	// BROWSE FUNGSIONAL TERTENTU ------------------------------- START
	function ext_get_all_fung_tertentu(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_FungTertentu();
			$total = $this->Browse_Ref_Model->get_CountData_FungTertentu();
			echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	// BROWSE FUNGSIONAL TERTENTU------------------------------ END

	// BROWSE GAPOK ------------------------------------------- START
	function ext_get_all_gapok(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Gapok();
			$total = $this->Browse_Ref_Model->get_CountData_Gapok();
			echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}
	// BROWSE GAPOK ------------------------------------------- END

	// BROWSE UNIT KERJA ------------------------------------------- START
	function ext_get_all_unker(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Unker();
			$total = $this->Browse_Ref_Model->get_CountData_Unker();
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE UNIT KERJA ------------------------------------------- END
	
	// BROWSE UNIT ORGANISASI ------------------------------------------- START
	function ext_get_all_unor(){
		if($this->input->post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Unor();
			$total = $this->Browse_Ref_Model->get_CountData_Unor();
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	
	function ext_get_all_unor_pgw(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Unor_Pgw();
			$total = $this->Browse_Ref_Model->get_CountData_Unor_Pgw();
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE UNIT ORGANISASI ------------------------------------------- END

	// BROWSE RUMAH SAKIT ------------------------------------------- START
	function ext_get_all_rs(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_RS();
			$total = $this->Browse_Ref_Model->get_CountData_RS();
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE RUMAH SAKIT ------------------------------------------- END

	// BROWSE DIKLAT ------------------------------------------- START
	function ext_get_all_diklat(){
		if($this->input->get_post("id_open")){
			if($this->input->get_post('kode_jns_diklat')){
				$data = $this->Browse_Ref_Model->get_AllData_Diklat($this->input->get_post('kode_jns_diklat'));	
				$total = $this->Browse_Ref_Model->get_CountData_Diklat($this->input->get_post('kode_jns_diklat'));	
			}else{
				$data = $this->Browse_Ref_Model->get_AllData_Diklat();	
				$total = $this->Browse_Ref_Model->get_CountData_Diklat();	
			}
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE DIKLAT ------------------------------------------- END

	// BROWSE PENDIDIKAN ------------------------------------------- START
	function ext_get_all_pendidikan(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Pendidikan();	
			$total = $this->Browse_Ref_Model->get_CountData_Pendidikan();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	function ext_get_all_pddk_pgw(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Pddk_Pgw();	
			$total = $this->Browse_Ref_Model->get_CountData_Pddk_Pgw();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE PENDIDIKAN ------------------------------------------- END

	// BROWSE PEKERJAAN ------------------------------------------- START
	function ext_get_all_pekerjaan(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Pekerjaan();	
			$total = $this->Browse_Ref_Model->get_CountData_Pekerjaan();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE PEKERJAAN ------------------------------------------- END

	// BROWSE REWARD ------------------------------------------- START
	function ext_get_all_reward(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Reward();	
			$total = $this->Browse_Ref_Model->get_CountData_Reward();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE REWARD ------------------------------------------- END

	// BROWSE HUKDIS ------------------------------------------- START
	function ext_get_all_hukdis(){
		if($this->input->get_post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_HukDis();	
			$total = $this->Browse_Ref_Model->get_CountData_HukDis();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE HUKDIS ------------------------------------------- END

	// BROWSE PENANDA TANGAN ------------------------------------------- START
	function ext_get_all_p_ttd(){
		if($this->input->post("id_open")){
			$data = $this->Browse_Ref_Model->get_AllData_Penanda_Tangan();	
			$total = $this->Browse_Ref_Model->get_CountData_Penanda_Tangan();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}
	// BROWSE PENANDA TANGAN ------------------------------------------- END	

}
?>