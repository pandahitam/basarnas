<?php
class Perencanaan extends MY_Controller {

	function __construct() {
		parent::__construct();
                
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Perencanaan_Model','',TRUE);
		$this->model = $this->Perencanaan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/perencanaan_view',$data);
		}else{
			$this->load->view('process_asset/perencanaan_view');
		}
	}
	
	function modifyPerencanaan(){
                $data = array();
                $dataKode = array();
                
	  	$fields = array(
			'id', 'kode_unor', 'kd_lokasi',
                        'kd_brg','no_aset', 'tahun_angaran', 'nama', 
                        'kebutuhan', 'keterangan', 'satuan', 'quantity', 
                        'harga_satuan', 'harga_total', 'is_realisasi','document_url','image_url'
                );
                
                $kodeFields = array(
                        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel'
                );
                
                foreach ($kodeFields as $field) {
			$dataKode[$field] = $this->input->post($field);
		}
                $kd_brg = $this->codeGenerator($dataKode);
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 
                $data['kd_brg'] = $kd_brg;
                
                   //GENERASI NO_ASET 
                if($data['no_aset'] == null || $data['no_aset'] == "")
                {
                    $data['no_aset'] = $this->noAssetGenerator($data['kd_brg'], $data['kd_lokasi']);
                }
                
                if($data['id'] != '')
                {
                    $this->createLog('UPDATE PERENCANAAN','perencanaan');
                }
                else
                {
                    $this->createLog('INSERT PERENCANAAN','perencanaan');
                }
                
		$this->modifyData(null,$data);
	}
	
	function deletePerencanaan()
	{
		$data = $this->input->post('data');
                foreach($data as $dataContent)
                {
                    $this->createLog('DELETE PERENCANAAN','perencanaan');
                }
		return $this->deleteProcess($data);
	}
	
	function getByID()
	{
		$id = $this->input->post('id_perencanaan');
		$data = $this->model->get_ByID($id);
		/*$datasend["results"] = $data;*/
		echo json_encode($data);
	}
}
?>