<?php
class Asset_Angkutan_Laut extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    	}
		$this->load->model('Asset_Angkutan_Laut_Model','',TRUE);
		$this->model = $this->Asset_Angkutan_Laut_Model;		
	}
	
	function angkutan_laut(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('pengelolaan_asset/angkutan_laut_view',$data);
		}else{
			$this->load->view('pengelolaan_asset/angkutan_laut_view');
		}
	}
	
	function modifyAngkutanLaut(){

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
			'kd_lokasi', 'kd_brg', 'no_aset', 'kuantitas', 'no_kib', 'merk', 'type', 'pabrik', 'thn_rakit', 'thn_buat', 'negara', 'muat', 'bobot', 'daya', 
			'msn_gerak', 'jml_msn', 'bhn_bakar', 'no_mesin', 'no_rangka', 'no_polisi', 'no_bpkb', 'lengkap1', 'lengkap2', 'lengkap3', 'jns_trn', 
			'dari', 'tgl_prl', 'rph_aset', 'dasar_hrg', 'sumber', 'no_dana', 'tgl_dana', 'unit_pmk', 'alm_pmk', 'catatan', 'kondisi', 'tgl_buku', 
			'rphwajar', 'status'
                );
                
                $extFields = array(
                        'kd_lokasi', 'kd_brg', 'no_aset', 'id',
                        'kode_unor','image_url', 'document_url','kd_klasifikasi_aset',
                        'laut_stkk_no','laut_stkk_keterangan','laut_stkk_masa_berlaku','laut_stkk_file',
                        'laut_surat_ukur_no','laut_surat_ukur_keterangan','laut_surat_ukur_masa_berlaku',
                        'laut_sertifikasi_keselamatan_no','laut_sertifikasi_keselamatan_keterangan','laut_sertifikasi_keselamatan_masa_berlaku','laut_sertifikasi_keselamatan_file',
                        'laut_sertifikasi_radio_no','laut_sertifikasi_radio_keterangan','laut_sertifikasi_radio_masa_berlaku','laut_sertifikasi_radio_file',
                        'laut_surat_ijin_berlayar_no','laut_surat_ijin_berlayar_keterangan','laut_surat_ijin_berlayar_masa_berlaku','laut_surat_ijin_berlayar_file'
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
                
		$this->modifyData($dataSimak, $dataExt);
	}
	
	function deleteAngkutanLaut()
	{
		$data = $this->input->post('data');
                
		return $this->deleteData($data);
	}
        
        function getSpecificPerlengkapanAngkutanLaut()
        {
            if($_POST['open'] == 1)
            {
                $data = $this->model->getSpecificPerlengkapanAngkutanLaut($_POST['id_ext_asset']);
                //                $total = $this->model->get_CountData();
//                $dataSend['total'] = $total;
		$dataSend['results'] = $data;
		echo json_encode($dataSend);
                
            }
        }
        
        function modifyPerlengkapanAngkutanLaut()
        {
            $dataPerlengkapanLaut = array();
            $dataPerlengkapanLautFields = array(
                'id','id_ext_asset','jenis_perlengkapan','no','nama','keterangan'
            );
            
            foreach ($dataPerlengkapanLautFields as $field) {
			$dataPerlengkapanLaut[$field] = $this->input->post($field);
            }
                $this->db->set($dataPerlengkapanLaut);
                $this->db->replace('ext_asset_angkutan_laut_perlengkapan');
               
        }
        
        function deletePerlengkapanAngkutanLaut()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                foreach($data as $deleted)
                {
                    $deletedArray[] =$deleted['id'];
                }
                $this->db->where_in('id',$deletedArray);
                
		$this->db->delete('ext_asset_angkutan_laut_perlengkapan');
	}
        
        function requestIdExtAsset()
        {
            $receivedData = array(
              'kd_brg'=>$_POST['kd_brg'],
              'kd_lokasi'=>$_POST['kd_lokasi'],
              'no_aset'=>$_POST['no_aset'],
            );
            $this->db->insert('ext_asset_angkutan',$receivedData);
            $idExt = $this->db->insert_id();
            $sendData = array(
              'status'=>'success',
              'idExt'=>$idExt
            );
            
            echo json_encode($sendData);
        }
}
?>