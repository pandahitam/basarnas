<?php
class Asset_Angkutan_Udara extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    	}
		$this->load->model('Asset_Angkutan_Udara_Model','',TRUE);
		$this->model = $this->Asset_Angkutan_Udara_Model;		
	}
	
	function angkutan_udara(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('pengelolaan_asset/angkutan_udara_view',$data);
		}else{
			$this->load->view('pengelolaan_asset/angkutan_udara_view');
		}
	}
	
	function modifyAngkutanUdara(){

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
                        'udara_surat_bukti_kepemilikan_no','udara_surat_bukti_kepemilikan_keterangan','udara_surat_bukti_kepemilikan_file',
                        'udara_sertifikat_pendaftaran_pesawat_udara_no','udara_sertifikat_pendaftaran_pesawat_udara_keterangan','udara_sertifikat_pendaftaran_pesawat_udara_masa_berlaku','udara_sertifikat_pendaftaran_pesawat_udara_file',
                        'udara_sertifikat_kelaikan_udara_no','udara_sertifikat_kelaikan_udara_keterangan','udara_sertifikat_kelaikan_udara_masa_berlaku','udara_sertifikat_kelaikan_udara_file'
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
	
	function deleteAngkutanUdara()
	{
		$data = $this->input->post('data');
                
		return $this->deleteData($data);
	}
        
        function getSpecificPerlengkapanAngkutanUdara()
        {
            if($_POST['open'] == 1)
            {
                $data = $this->model->getSpecificPerlengkapanAngkutanUdara($_POST['id_ext_asset']);
                //                $total = $this->model->get_CountData();
//                $dataSend['total'] = $total;
		$dataSend['results'] = $data;
		echo json_encode($dataSend);
                
            }
        }
        
        function modifyPerlengkapanAngkutanUdara()
        {
            $dataPerlengkapanUdara = array();
            $dataPerlengkapanUdaraFields = array(
                'id','id_ext_asset','jenis_perlengkapan','no','nama','keterangan','part_number','serial_number'
            );
            
            foreach ($dataPerlengkapanUdaraFields as $field) {
			$dataPerlengkapanUdara[$field] = $this->input->post($field);
            }
            
            if($dataPerlengkapanUdara['part_number'] == '' || $dataPerlengkapanUdara['part_number'] == null)
            {
                $dataPerlengkapanUdara['part_number'] = '-';
            }
            if($dataPerlengkapanUdara['serial_number'] == '' || $dataPerlengkapanUdara['serial_number'] == null)
            {
                $dataPerlengkapanUdara['serial_number'] = '-';
            }
            if($dataPerlengkapanUdara['keterangan'] == '' || $dataPerlengkapanUdara['keterangan'] == null)
            {
                $dataPerlengkapanUdara['keterangan'] = '-';
            }
                $this->db->set($dataPerlengkapanUdara);
                $this->db->replace('ext_asset_angkutan_udara_perlengkapan');
               
        }
        
        function deletePerlengkapanAngkutanUdara()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                foreach($data as $deleted)
                {
                    $deletedArray[] =$deleted['id'];
                }
                $this->db->where_in('id',$deletedArray);
                
		$this->db->delete('ext_asset_angkutan_udara_perlengkapan');
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
	
	function cetak($input){
		$data_cetak = $this->model->get_SelectedDataPrint($input);
			if(count($data_cetak)){
				$data['dataprn'] = $data_cetak['dataasset'];
				$this->load->view('pengelolaan_asset/angkutan_udara_pdf',$data);
			}
	}
}
?>