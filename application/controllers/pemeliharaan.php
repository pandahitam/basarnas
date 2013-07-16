<?php
class Pemeliharaan extends MY_Controller {


	function __construct() {
		parent::__construct();

 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pemeliharaan_Model','',TRUE);
		$this->model = $this->Pemeliharaan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/pemeliharaan_view',$data);
		}else{
			$this->load->view('process_asset/pemeliharaan_view');
		}
	}
	
	function modifyPemeliharaan(){
                $data = array();
                
	  	$fields = array(
                    'id', 'kd_brg', 'kd_lokasi', 'no_aset',
                    'kode_unker', 'kode_unor', 'jenis', 'nama', 
                    'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 
                    'kondisi', 'deskripsi', 'harga', 'kode_angaran', 
                    'unit_waktu', 'unit_pengunaan',
                    'freq_waktu', 'freq_pengunaan', 'status', 'durasi', 
                    'rencana_waktu', 'rencana_pengunaan', 'rencana_keterangan', 'alert', 
                    'document_url','image_url'
                );
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 
                
		$this->modifyData(null,$data);
	}
	
	function deletePemeliharaan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
	
	
	function getSpecificPemeliharaan()
	{
		$kd_lokasi = $this->input->post("kd_lokasi");
		$kd_brg = $this->input->post("kd_brg");
		$no_aset = $this->input->post("no_aset");
		$data = $this->model->get_Pemeliharaan($kd_lokasi, $kd_brg, $no_aset);
		$datasend["results"] = $data;
		echo json_encode($datasend);
	}
}
?>