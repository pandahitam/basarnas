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
                $dataKlasifikasiAset = array();
                
                $klasifikasiAsetFields = array(
                    'kd_lvl1','kd_lvl2','kd_lvl3'
                );
                
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
                        'luas_bdg', 'jml_lt'
                );
                
                $extFields = array(
                        'kd_lokasi', 'kd_brg', 'no_aset', 'id','kode_unor',
                        'nop','njkp','waktu_pembayaran','setoran_pajak','keterangan',
                        'image_url','document_url','kd_klasifikasi_aset', 
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
	
	function deleteBangunan()
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
		$dataSend['results'] = $data;
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
                $this->db->replace('ext_asset_bangunan_riwayat_pajak');
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
                
		$this->db->delete('ext_asset_bangunan_riwayat_pajak');
	}
        
        function requestIdExtAsset()
        {
            $receivedData = array(
              'kd_brg'=>$_POST['kd_brg'],
              'kd_lokasi'=>$_POST['kd_lokasi'],
              'no_aset'=>$_POST['no_aset'],
            );
            $this->db->insert('ext_asset_bangunan',$receivedData);
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
				$this->load->view('pengelolaan_asset/bangunan_pdf',$data);
			}
	}
	
}
?>