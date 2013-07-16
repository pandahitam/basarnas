<?php
class Master_Data_Cetak extends CI_Controller {
	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    }
		$this->load->model('Unit_Kerja_Model','',TRUE);
		$this->load->model('Jabatan_Model','',TRUE);
		$this->load->model('Unit_Organisasi_Model','',TRUE);
		$this->load->model('Diklat_Model','',TRUE);
		$this->load->model('Penghargaan_Model','',TRUE);
		$this->load->model('HukDis_Model','',TRUE);
		$this->load->model('Pekerjaan_Model','',TRUE);
		$this->load->model('Pendidikan_Model','',TRUE);
		$this->load->model('Gapok_PP_Model','',TRUE);
		$this->load->model('Gapok_Model','',TRUE);
		$this->load->model('Fung_Model','',TRUE);
		$this->load->model('Fung_Tertentu_Model','',TRUE);
	}
	
	function index(){
		echo "";
	}
	
	// CETAK UNIT KERJA -------------------------------------------------------- START
  function print_dialog_unker(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_UK';
			$data['Grid_ID'] = 'Grid_UK';
			$data['Params_Print'] = 'Params_M_UK';
			$data['uri_all'] = 'master_data_cetak/cetak_sk/all';
			$data['uri_selected'] = 'master_data_cetak/cetak_sk/selected';
			$data['uri_by_rows'] = 'master_data_cetak/cetak_sk/by_rows/';
			$this->load->view('print_dialog/print_dialog_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_view');
		}
  }

	function cetak_unker($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data['data_cetak'] = $this->Unit_Kerja_Model->get_AllPrint();
			}elseif($p_mode == "selected"){
				$data['data_cetak'] = $this->Unit_Kerja_Model->get_SelectedPrint();
			}elseif($p_mode == "by_rows"){
				$data['data_cetak'] = $this->Unit_Kerja_Model->get_ByRowsPrint($dari, $sampai);
			}
			$this->load->view('unit_kerja_pdf',$data);
		}
	}
	// CETAK SK -------------------------------------------------------- END

}
?>