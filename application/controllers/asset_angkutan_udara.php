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
                        'kd_lokasi', 'kd_brg', 'no_aset', 'id','udara_no_mesin2','udara_inisialisasi_mesin1','udara_inisialisasi_mesin2',
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
                
                if($dataExt['id'] != '')
                {
                    $this->createLog('UPDATE ASSET ANGKUTAN UDARA','asset_angkutan,ext_asset_angkutan_udara');
                }
                else
                {
                    $this->createLog('INSERT ASSET ANGKUTAN UDARA','asset_angkutan,ext_asset_angkutan_udara');
                }
                
		$this->modifyData($dataSimak, $dataExt);
	}
	
	function deleteAngkutanUdara()
	{
		$data = $this->input->post('data');
                foreach($data as $dataContent)
                {
                    $this->createLog('DELETE ASSET ANGKUTAN UDARA','asset_angkutan,ext_asset_angkutan_udara');
                }
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
        
        function getSpecificPerlengkapanAngkutanUdaraWithoutIdExtAsset()
        {
                $kd_brg = $_POST['kd_brg'];
                $kd_lokasi = $_POST['kd_lokasi'];
                $no_aset = $_POST['no_aset'];
                $queryIdExtAsset = $this->db->query("select id from ext_asset_angkutan where kd_brg = '$kd_brg' and kd_lokasi = '$kd_lokasi' and no_aset = '$no_aset'");
                $queryIdExtAsset_result = $queryIdExtAsset->row();
                $data = $this->model->getSpecificPerlengkapanAngkutanUdara($queryIdExtAsset_result->id);
                //                $total = $this->model->get_CountData();
//                $dataSend['total'] = $total;
		$dataSend['results'] = $data;
		echo json_encode($dataSend);
        }
        
        function modifyPerlengkapanAngkutanUdara()
        {
            $dataPerlengkapanUdara = array();
            $dataPerlengkapanUdaraFields = array(
                'id','id_ext_asset','jenis_perlengkapan','no','nama','keterangan','id_asset_perlengkapan'
            );
            
            foreach ($dataPerlengkapanUdaraFields as $field) {
			$dataPerlengkapanUdara[$field] = $this->input->post($field);
            }
            
//            if($dataPerlengkapanUdara['part_number'] == '' || $dataPerlengkapanUdara['part_number'] == null)
//            {
//                $dataPerlengkapanUdara['part_number'] = '-';
//            }
//            if($dataPerlengkapanUdara['serial_number'] == '' || $dataPerlengkapanUdara['serial_number'] == null)
//            {
//                $dataPerlengkapanUdara['serial_number'] = '-';
//            }
            if($dataPerlengkapanUdara['keterangan'] == '' || $dataPerlengkapanUdara['keterangan'] == null)
            {
                $dataPerlengkapanUdara['keterangan'] = '-';
            }
            
            $this->db->set($dataPerlengkapanUdara);
            $this->db->replace('ext_asset_angkutan_udara_perlengkapan');

            //update asset perlengkapan, remove from warehouse, set kode induk asset
            if($dataPerlengkapanUdara['id_asset_perlengkapan'] != ''  && $dataPerlengkapanUdara['id_asset_perlengkapan'] != 0)
            {
                $query_data_pesawat = $this->db->query("select kd_brg, no_aset, kd_lokasi from view_asset_angkutan_udara where id = ".$dataPerlengkapanUdara['id_ext_asset']);
                $query_result = $query_data_pesawat->row();
                $no_induk_pesawat = $query_result->kd_brg.$query_result->kd_lokasi.$query_result->no_aset;
                
                $update_data_no_induk = array(
                    'warehouse_id' => 0,
                    'ruang_id'=>0,
                    'rak_id'=>0,
                    'no_induk_asset'=>$no_induk_pesawat
                );
                $this->db->where('id',$dataPerlengkapanUdara['id_asset_perlengkapan']);
                $this->db->update('asset_perlengkapan',$update_data_no_induk);
            }
            
               
        }
        
        function deletePerlengkapanAngkutanUdara()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                $updatedAssetPerlengkapan = array();
                foreach($data as $deleted)
                {
                    $deletedArray[] =$deleted['id'];
                    
                    if($deleted['id_asset_perlengkapan'] != '' && $deleted['id_asset_perlengkapan'] != 0)
                    {
                        $updatedAssetPerlengkapan = $deleted['id_asset_perlengkapan'];
                    }
                }
                $this->db->where_in('id',$deletedArray);
		$this->db->delete('ext_asset_angkutan_udara_perlengkapan');
                if(!empty($updatedAssetPerlengkapan))
                {
                    $this->db->where_in('id',$updatedAssetPerlengkapan);
                    $this->db->update('asset_perlengkapan',array('no_induk_asset'=>''));
                }
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
        
        function getIdExtAsset()
        {
            $receivedData = array(
              'kd_brg'=>$_POST['kd_brg'],
              'kd_lokasi'=>$_POST['kd_lokasi'],
              'no_aset'=>$_POST['no_aset'],
            );
            $query = $this->db->query("select id from ext_asset_angkutan where kd_brg='".$receivedData['kd_brg']."' and kd_lokasi ='".$receivedData['kd_lokasi']."' and no_aset = '".$receivedData['no_aset']."'");
            $query_result = $query->row();
            $idExt = $query_result->id;
            $sendData = array(
              'status'=>'success',
              'idExt'=>$idExt
            );
            
            echo json_encode($sendData);
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
				
            $lvl1 = $data_cetak['0']['kd_lvl1'];
				$lvl2 = $data_cetak['0']['kd_lvl2'];
				$lvl3 = $data_cetak['0']['kd_lvl3'];
				
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
            
             $query = $this->db->query(" SELECT nama FROM ref_klasifikasiaset_lvl1 WHERE kd_lvl1 =  $lvl1");
            foreach ($query->result() as $rw) {$data['klasifikasi_lvl1'] = $rw;}
            
            $query = $this->db->query(" SELECT nama FROM ref_klasifikasiaset_lvl2 WHERE kd_lvl2 =  $lvl2");
            foreach ($query->result() as $rw) {$data['klasifikasi_lvl2'] = $rw;}
            
            $query = $this->db->query(" SELECT nama FROM ref_klasifikasiaset_lvl3 WHERE kd_lvl3 =  $lvl3");
            foreach ($query->result() as $rw) {$data['klasifikasi_lvl3'] = $rw;}
            
            $data['perlengkapan'] = json_decode(json_encode($this->model->getPerlengkapan_for_print($xid),TRUE),TRUE);
            $data['penggunaan'] = json_decode(json_encode($this->model->getPenggunaan_for_print($xid),TRUE),TRUE);
				
				$this->load->model("Pengadaan_Model");
				$data['pengadaan'] = json_decode(json_encode($this->Pengadaan_Model->get_ByKodeForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->model("Pemeliharaan_Model");
				$data['pemeliharaan'] = json_decode(json_encode($this->Pemeliharaan_Model->get_PemeliharaanForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->model("Penghapusan_Model");
				$data['penghapusan'] = json_decode(json_encode($this->Penghapusan_Model->get_PenghapusanForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->model("Pendayagunaan_Model");
				$data['pendayagunaan'] = json_decode(json_encode($this->Pendayagunaan_Model->get_PendayagunaanForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->view('pengelolaan_asset/angkutan_udara_pdf',$data);
			}
	}
}
?>