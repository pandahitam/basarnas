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
                
                if($dataExt['id'] != '')
                {
                    $this->createLog('UPDATE ASSET PERAIRAN','asset_perairan,ext_asset_perairan');
                }
                else
                {
                    $this->createLog('INSERT ASSET PERAIRAN','asset_perairan,ext_asset_perairan');
                }
                
		$this->modifyData($dataSimak,$dataExt);
	}
	
	function deletePerairan()
	{
		$data = $this->input->post('data');
                foreach($data as $dataContent)
                {
                    $this->createLog('DELETE ASSET PERAIRAN','asset_perairan,ext_asset_perairan');
                }
		return $this->deleteData($data);
	}
	
	function cetak($input){
		$data_cetak = $this->model->get_SelectedDataPrint($input);
			if(count($data_cetak)){
				
				$xid = $data_cetak['0']['id'];
				$xkd_lokasi = $data_cetak['0']['kd_lokasi'];
				$xkd_brg = $data_cetak['0']['kd_brg'];
				$xno_aset = $data_cetak['0']['no_aset'];
				
				$xkd_gol = $data_cetak['0']['kd_gol'];
				$xkd_bid = $data_cetak['0']['kd_bid'];
				$xkd_kelompok = $data_cetak['0']['kd_kelompok'];
				$xkd_skel = $data_cetak['0']['kd_skel'];
				$xkd_sskel = $data_cetak['0']['kd_sskel'];
				
				
				$data['dataprn'] = $data_cetak;
				//$addata = array();

				
				$query = $this->db->query(" SELECT ur_gol FROM ref_golongan WHERE kd_gol = '$xkd_gol' LIMIT 1 ");
				foreach ($query->result_array() as $rw) {$addata[] = $rw;}
				$query = $this->db->query(" SELECT ur_bid FROM ref_bidang WHERE kd_gol = '$xkd_gol' AND  kd_bid = '$xkd_bid' LIMIT 1 ");
				foreach ($query->result_array() as $rw) {$addata[] = $rw;}
				$query = $this->db->query(" SELECT ur_kel FROM ref_kel WHERE kd_gol = '$xkd_gol' AND kd_bid = '$xkd_bid' AND kd_kel = '$xkd_kelompok' LIMIT 1 ");
				foreach ($query->result_array() as $rw) {$addata[] = $rw;}
				$query = $this->db->query(" SELECT ur_skel FROM ref_subkel WHERE kd_gol = '$xkd_gol' AND kd_bid = '$xkd_bid' AND kd_kel = '$xkd_kelompok' AND kd_skel = '$xkd_skel' LIMIT 1 ");
				foreach ($query->result_array() as $rw) {$addata[] = $rw;}
				$query = $this->db->query(" SELECT ur_sskel FROM ref_subsubkel WHERE kd_gol = '$xkd_gol' AND kd_bid = '$xkd_bid' AND  kd_kel = '$xkd_kelompok' AND kd_skel = '$xkd_skel' AND kd_sskel = '$xkd_sskel' LIMIT 1 ");
				foreach ($query->result_array() as $rw) {$addata[] = $rw;}
		  
				$data['bidang'] = $addata;
				
				$this->load->model("Pengadaan_Model");
				$data['pengadaan'] = json_decode(json_encode($this->Pengadaan_Model->get_ByKodeForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->model("Pemeliharaan_Model");
				$data['pemeliharaan'] = json_decode(json_encode($this->Pemeliharaan_Model->get_PemeliharaanForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->model("Penghapusan_Model");
				$data['penghapusan'] = json_decode(json_encode($this->Penghapusan_Model->get_PenghapusanForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->model("Pendayagunaan_Model");
				$data['pendayagunaan'] = json_decode(json_encode($this->Pendayagunaan_Model->get_PendayagunaanForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->view('pengelolaan_asset/perairan_pdf',$data);
			}
	}
}
?>