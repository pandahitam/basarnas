<?php
class Panel_Ref extends CI_Controller {
	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    }
    $this->Session_Model->Clear_Session_Ref();
		$this->load->model('Browse_Ref_Model','',TRUE);
	}
	
	function index(){echo '';}
	
	function ref_pegawai(){
		if($this->input->post('id_open')){
			/*
			if($this->input->post('VKEY')){
				$this->session->set_userdata("sPgwPilih", $this->input->post('VKEY'));
			}
			if($this->input->post('VKEY1')){
				$this->session->set_userdata("sDupeg", $this->input->post('VKEY1'));
			}
			if($this->input->post('VKEY2')){
				$this->session->set_userdata("skode_unor", $this->input->post('VKEY2'));
			}
			if($this->input->post('VKEY3')){
				$this->session->set_userdata("skode_golru", $this->input->post('VKEY3'));
			}
			*/
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_pegawai_view', $data);
		}else{
			$this->load->view('panel_ref/ref_pegawai_view');
		}
	}

	function ref_pegawai_pddk(){
		if($this->input->post('id_open')){
			if($this->input->post('VKEY')){
				$this->session->set_userdata("sNIP", $this->input->post('VKEY'));
			}else{
				$this->session->unset_userdata("sNIP");
			}
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_pegawai_pddk_view', $data);
		}else{
			$this->load->view('panel_ref/ref_pegawai_pddk_view');
		}
	}

	function ref_pegawai_pangkat(){
		if($this->input->post('id_open')){
			if($this->input->post('VKEY')){
				$this->session->set_userdata("sNIP", $this->input->post('VKEY'));
			}else{
				$this->session->unset_userdata("sNIP");
			}
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_pegawai_pangkat_view', $data);
		}else{
			$this->load->view('panel_ref/ref_pegawai_pangkat_view');
		}
	}

	function ref_pegawai_unor(){
		if($this->input->post('id_open')){
			if($this->input->post('VKEY')){
				$this->session->set_userdata("sNIP", $this->input->post('VKEY'));
			}else{
				$this->session->unset_userdata("sNIP");
			}
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_pegawai_unor_view', $data);
		}else{
			$this->load->view('panel_ref/ref_pegawai_unor_view');
		}
	}

	function ref_pegawai_jab(){
		if($this->input->post('id_open')){
			if($this->input->post('VKEY')){
				$this->session->set_userdata("sNIP", $this->input->post('VKEY'));
			}else{
				$this->session->unset_userdata("sNIP");
			}
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_pegawai_jab_view', $data);
		}else{
			$this->load->view('panel_ref/ref_pegawai_jab_view');
		}
	}

	function ref_golru_up_level(){
		if($this->input->post('id_open')){
			if($this->input->post('VKEY')){
				//$this->session->set_userdata("skode_golru", $this->input->post('VKEY'));
			}
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_golru_up_level_view', $data);
		}else{
			$this->load->view('panel_ref/ref_golru_up_level_view');
		}
	}

	function ref_pddk(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_pddk_view', $data);
		}else{
			$this->load->view('panel_ref/ref_pddk_view');
		}
	}

	function ref_pekerjaan(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_pekerjaan_view', $data);
		}else{
			$this->load->view('panel_ref/ref_pekerjaan_view');
		}
	}

	function ref_unker(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_unker_view', $data);
		}else{
			$this->load->view('panel_ref/ref_unker_view');
		}
	}

	function ref_unor(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_unor_view', $data);
		}else{
			$this->load->view('panel_ref/ref_unor_view');
		}
	}

	function ref_jab_unor(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_jabatan_unor_view', $data);
		}else{
			$this->load->view('panel_ref/ref_jabatan_unor_view');
		}
	}

	function ref_jabatan(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_jabatan_view', $data);
		}else{
			$this->load->view('panel_ref/ref_jabatan_view');
		}
	}

	function ref_rumah_sakit(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_rumah_sakit_view', $data);
		}else{
			$this->load->view('panel_ref/ref_rumah_sakit_view');
		}
	}

	function ref_tugas_fung(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_tugas_fung_view', $data);
		}else{
			$this->load->view('panel_ref/ref_tugas_fung_view');
		}
	}

	function ref_gapok(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_gapok_view', $data);
		}else{
			$this->load->view('panel_ref/ref_gapok_view');
		}
	}

	function ref_diklat(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_diklat_view', $data);
		}else{
			$this->load->view('panel_ref/ref_diklat_view');
		}
	}

	function ref_penilai(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_penilai_view', $data);
		}else{
			$this->load->view('panel_ref/ref_penilai_view');
		}
	}

	function ref_reward(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_reward_view', $data);
		}else{
			$this->load->view('panel_ref/ref_reward_view');
		}
	}

	function ref_hukdis(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('panel_ref/ref_hukdis_view', $data);
		}else{
			$this->load->view('panel_ref/ref_hukdis_view');
		}
	}

}
?>