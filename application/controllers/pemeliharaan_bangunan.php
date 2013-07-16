<?php
class Pemeliharaan_Bangunan extends MY_Controller {


	function __construct() {
		parent::__construct();
                
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pemeliharaan_Bangunan_Model','',TRUE);
		$this->model = $this->Pemeliharaan_Bangunan_Model;		
	}
	
	
	function index()
	{
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/pemeliharaan_bangunan_view',$data);
		}else{
			$this->load->view('process_asset/pemeliharaan_bangunan_view');
		}
	}
	
	function modifyPemeliharaanBangunan(){
                $data = array();
                
	  	$fields = array(
                   'id','kd_brg', 'kd_lokasi', 'no_aset', 'kode_unor', 
                    'jenis', 'subjenis', 'pelaksana_nama', 'pelaksana_startdate', 
                    'pelaksana_endate', 'deskripsi', 'biaya', 'image_url', 'document_url'
                );
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 
                
		$this->modifyData(null,$data);
	}
	
	function deletePemeliharaanBangunan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
	
	function getSpecificPemeliharaanBangunan()
	{
		$kd_lokasi = $this->input->post("kd_lokasi");
		$kd_brg = $this->input->post("kd_brg");
		$no_aset = $this->input->post("no_aset");
		$data = $this->model->get_Pemeliharaan($kd_lokasi, $kd_brg, $no_aset);
		echo json_encode($data);
	}
}
?>