<?php
class Data_Nominatif_Pegawai extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		if($this->input->post()){
			$data['jsscript'] = TRUE;
			$this->load->view('data_nominatif_pegawai_view',$data);
		}else{
			$this->load->view('data_nominatif_pegawai_view');
		}
	}
}
?>