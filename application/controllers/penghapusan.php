<?php
class Penghapusan extends MY_Controller {

	function __construct() {
		parent::__construct();
                
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Penghapusan_Model','',TRUE);
		$this->model = $this->Penghapusan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/penghapusan_view',$data);
		}else{
			$this->load->view('process_asset/penghapusan_view');
		}
	}
	
	function modifyPenghapusan(){
           /*     $data = array();
                
	  	$fields = array(
                    'id', 'kd_brg', 'kd_lokasi', 'no_aset',
                    'kode_unker', 'kode_unor', 'jenis', 'nama', 
                    'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 
                    'kondisi', 'deskripsi', 'harga', 'kode_angaran', 
                    'freq_waktu', 'freq_pengunaan', 'status', 'durasi', 
                    'rencana_waktu', 'rencana_pengunaan', 'rencana_keterangan', 'alert', 
                    'document_url','image_url'
                );
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 
                
		$this->modifyData(null,$data);*/
	}
	
	function deletePenghapusan()
	{
		/*$data = $this->input->post('data');
                
		return $this->deleteProcess($data);*/
	}
}
?>