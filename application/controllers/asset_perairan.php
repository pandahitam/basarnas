<?php
class Asset_Perairan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    	}
		$this->load->model('Asset_Perairan_Model','',TRUE);
		$this->model = $this->Asset_Perairan_Model;		
	}
	
	function perairan(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('pengelolaan_asset/perairan_view',$data);
		}else{
			$this->load->view('pengelolaan_asset/perairan_view');
		}
	}
	
	function modifyPerairan(){
                $dataSimak = array();
                $dataExt = array();
                $dataKode = array();
                $dataKlasifikasiAset = array();
                
                $klasifikasiAsetFields = array(
                    'kd_lvl1','kd_lvl2','kd_lvl3'
                );
                
                $kodeFields = array(
                        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel'
                );
                
	  	$simakFields = array(
			'kd_lokasi', 'kd_brg', 'no_aset', 'kuantitas', 'rph_aset', 'no_kib', 'luas_bdg', 'luas_dsr', 'kapasitas', 'thn_sls', 'thn_pakai', 
			'no_imb', 'tgl_imb', 'kd_prov', 'kd_kab', 'kd_kec', 'kd_kel', 'alamat', 'kd_rtrw', 'no_kibtnh', 'jns_trn', 'dari', 'tgl_prl', 
			'kondisi', 'rph_wajar', 'dasar_hrg', 'sumber', 'no_dana', 'tgl_dana', 'unit_pmk', 'alm_pmk', 'catatan', 'tgl_buku', 'kons_sist', 
			'rphwajar', 'status'
                );
                
                $extFields = array(
                        'kd_lokasi', 'kd_brg', 'no_aset', 'id',
                        'kode_unor','image_url','document_url','kd_klasifikasi_aset'
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
                
                foreach($klasifikasiAsetFields as $field)
                {
                    $dataKlasifikasiAset[$field] =  $this->input->post($field);
                }
                
                $dataExt['kd_klasifikasi_aset'] = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasiAset);
                
                                //GENERASI NO_ASET 
                if($dataSimak['no_aset'] == null || $dataSimak['no_aset'] == "")
                {
                    $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'], $dataSimak['kd_lokasi']);
                    $dataExt['no_aset'] = $dataSimak['no_aset'];
                }
		$this->modifyData($dataSimak,$dataExt);
	}
	
	function deletePerairan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteData($data);
	}
}
?>