<?php
class asset_bangunan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    	}
		$this->load->model('Asset_Bangunan_Model','',TRUE);
		$this->model = $this->Asset_Bangunan_Model;		
	}
	
	function bangunan(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('pengelolaan_asset/bangunan_view',$data);
		}else{
			$this->load->view('pengelolaan_asset/bangunan_view');
		}
	}
      
	
	function modifyBangunan(){
                $dataSimak = array();
                $dataExt = array();
                $dataKode = array();
                
                $kodeFields = array(
                        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel'
                );
                
	  	$simakFields = array(
			'kd_lokasi', 'kd_brg', 'no_aset', 
                        'kuantitas', 'no_kib', 'type', 
                        'thn_sls', 'thn_pakai', 'no_imb', 'tgl_imb', 
                        'kd_prov', 'kd_kab', 'kd_kec', 'kd_kel', 
                        'alamat', 'kd_rtrw', 'no_kibtnh', 
                        'dari', 'kondisi', 'unit_pmk', 
                        'alm_pmk', 'catatan', 'rphwajar', 
                        'rphnjop', 'status', 'luas_dsr', 
                        'luas_bdg', 'jml_lt', 
                );
                
                $extFields = array(
                        'kd_lokasi', 'kd_brg', 'no_aset', 'id','kode_unor',
                        'nop','njkp','waktu_pembayaran','setoran_pajak','keterangan',
                        'image_url','document_url'
                );
                
                foreach ($kodeFields as $field) {
			$dataKode[$field] = $this->input->post($field);
		}
                $kd_brg = $this->codeGenerator($dataKode);
                
		foreach ($simakFields as $field) {
			$dataSimak[$field] = $this->input->post($field);
		}
                $dataSimak['kd_brg'] = $kd_brg;
                
                foreach ($extFields as $field) {
			$dataExt[$field] = $this->input->post($field);
		} 
                $dataExt['kd_brg'] = $kd_brg;
                
		$this->modifyData($dataSimak,$dataExt);
	}
	
	function deleteBangunan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteData($data);
	}
	
}
?>