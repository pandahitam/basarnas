<?php
class Asset_Tanah extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    	}
		$this->load->model('Asset_Tanah_Model','',TRUE);
		$this->model = $this->Asset_Tanah_Model;		
	}
	
	function tanah(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('pengelolaan_asset/tanah_view',$data);
		}else{
			$this->load->view('pengelolaan_asset/tanah_view');
		}
	}
	
	
	function modifyTanah(){
                
  
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
			'kd_lokasi', 'kd_brg', 'no_aset', 'kuantitas', 
                        'rph_aset', 'no_kib', 'luas_tnhs', 'luas_tnhb', 
                        'luas_tnhl', 'luas_tnhk', 'kd_prov', 'kd_kab', 
                        'kd_kec', 'kd_kel', 'kd_rtrw', 'alamat', 
                        'batas_u', 'batas_s', 'batas_t', 'batas_b', 
                        'jns_trn', 'sumber', 'dari', 'dasar_hrg', 
                        'no_dana', 'tgl_dana', 'surat1', 'surat2', 
                        'surat3', 'rph_m2', 'unit_pmk', 'alm_pmk', 
                        'catatan', 'tgl_prl', 'tgl_buku', 'rphwajar', 
                        'rphnjop', 'status', 'smilik','kd_klasifikasi_aset'
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
                
                foreach($klasifikasiAsetFields as $field)
                {
                    $dataKlasifikasiAset[$field] =  $this->input->post($field);
                }
                
                $dataSimak['kd_klasifikasi_aset'] = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasiAset);

                //GENERASI NO_ASET 
                if($dataSimak['no_aset'] == null || $dataSimak['no_aset'] == "")
                {
                    $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'], $dataSimak['kd_lokasi']);
                    $dataExt['no_aset'] = $dataSimak['no_aset'];
                }
//                else //if update not creating new no_aset
//                {
//                    $this->db->where('kd_brg',$dataSimak['kd_brg']);
//                    $this->db->where('kd_lokasi',$dataSimak['kd_lokasi']);
//                    $query = $this->db->get('asset_tanah');
//                    $result = $query->row();
//                    if($query->num_rows === 0)
//                    {
//                        $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'], $dataSimak['kd_lokasi']);
//                    }
//                    else
//                    {
//                        $dataSimak['no_aset'] = $result->no_aset;
//                    }
//                    $dataExt['no_aset'] = $dataSimak['no_aset'];
//                }
                
                
                		
		$this->modifyData($dataSimak,$dataExt);
	}
	
	function deleteTanah()
	{
		$data = $this->input->post('data');
                
		return $this->deleteData($data);
	}
}
?>