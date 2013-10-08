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
                        'rphnjop', 'status', 'smilik'
                );
                
                $extFields = array(
                        'kd_lokasi', 'kd_brg', 'no_aset', 'id','kode_unor',
                        'nop','njkp','waktu_pembayaran','setoran_pajak','keterangan',
                        'image_url','document_url','kd_klasifikasi_aset'
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
        
        function getSpecificRiwayatPajak()
        {
            if($_POST['open'] == 1)
            {
                $data = $this->model->getSpecificRiwayatPajak($_POST['id_ext_asset']);
                //                $total = $this->model->get_CountData();
//                $dataSend['total'] = $total;
		$dataSend['results'] = $data['data'];
                $dataSend['total'] = $data['count'];
		echo json_encode($dataSend);
                
            }
        }
        
        function modifyRiwayatPajak()
        {
            $dataRiwayatPajak = array();
            $dataRiwayatPajakFields = array(
                'id','id_ext_asset','tahun_pajak','tanggal_pembayaran','jumlah_setoran','file_setoran','keterangan'
            );
            
            foreach ($dataRiwayatPajakFields as $field) {
			$dataRiwayatPajak[$field] = $this->input->post($field);
            }
                $this->db->set($dataRiwayatPajak);
                $this->db->replace('ext_asset_tanah_riwayat_pajak');
                echo "{success:true, info: { reason: 'Sukses!' }}";
            
            
               
        }
        
        function deleteRiwayatPajak()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                foreach($data as $deleted)
                {
                    $deletedArray[] =$deleted['id'];
                }
                $this->db->where_in('id',$deletedArray);
                
		$this->db->delete('ext_asset_tanah_riwayat_pajak');
	}
        
        function requestIdExtAsset()
        {
            $receivedData = array(
              'kd_brg'=>$_POST['kd_brg'],
              'kd_lokasi'=>$_POST['kd_lokasi'],
              'no_aset'=>$_POST['no_aset'],
            );
            $this->db->insert('ext_asset_tanah',$receivedData);
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

				$data['riwayatpajak'] = json_decode(json_encode($this->model->getRiwayatPajakForPrint($xid),TRUE),TRUE);

				$this->load->model("Pengadaan_Model");
				$data['pengadaan'] = json_decode(json_encode($this->Pengadaan_Model->get_ByKodeForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->model("Pemeliharaan_Model");
				$data['pemeliharaan'] = json_decode(json_encode($this->Pemeliharaan_Model->get_PemeliharaanForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->model("Penghapusan_Model");
				$data['penghapusan'] = json_decode(json_encode($this->Penghapusan_Model->get_PenghapusanForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->model("Pendayagunaan_Model");
				$data['pendayagunaan'] = json_decode(json_encode($this->Pendayagunaan_Model->get_PendayagunaanForPrint($xkd_lokasi,$xkd_brg,$xno_aset),TRUE),TRUE);
				
				$this->load->view('pengelolaan_asset/tanah_pdf',$data);
			}
	}
}
?>