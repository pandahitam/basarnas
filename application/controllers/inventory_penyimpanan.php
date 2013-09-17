<?php
class inventory_penyimpanan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
		$this->load->model('Inventory_Penyimpanan_Model','',TRUE);
		$this->model = $this->Inventory_Penyimpanan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('inventory/penyimpanan_view',$data);
		}else{
			$this->load->view('inventory/penyimpanan_view');
		}
	}
	
	function modifyInventoryPenyimpanan(){
		$dataSimak = array();
                $dataPerlengkapan = array();
//                $dataExt = array();
//                $dataKode = array();
//                
//                $dataKlasifikasiAset = array();
//                
//                $klasifikasiAsetFields = array(
//                    'kd_lvl1','kd_lvl2','kd_lvl3'
//                );
//                $kodeFields = array(
//                        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel'
//                );
//              
                $perlengkapanFields = array(
                                    'kd_brg','kd_lokasi','no_aset', 'part_number',
                                    'serial_number','kuantitas','kondisi','kode_unor',
                                    'warehouse_id','ruang_id','rak_id','dari'
                );
                
                $simakFields = array(
			'id','tgl_berita_acara','nomor_berita_acara','kd_brg','kd_lokasi','id_pemeriksaan','nama_org',
                                        'no_aset', 'part_number','serial_number','date_created',
                                        'keterangan', 'status_barang','qty','tgl_penyimpanan','asal_barang',
                                        'warehouse_id','ruang_id','rak_id'
                );
//                
//                $extFields = array(
//                        'kd_lokasi', 'kd_brg', 'no_aset', 'id',
//                        'kode_unor','image_url','document_url',
//                        'kd_klasifikasi_aset'
//                );
//		
//		foreach ($kodeFields as $field) {
//			$dataKode[$field] = $this->input->post($field);
//		}
//                $kd_brg = $this->codeGenerator($dataKode);
//                
		foreach ($simakFields as $field) {
			$dataSimak[$field] = $this->input->post($field);
		}
                
                foreach ($perlengkapanFields as $field) {
			$dataPerlengkapan[$field] = $this->input->post($field);
		}
                $dataPerlengkapan['kondisi'] = $dataSimak['status_barang'];
                $dataPerlengkapan['kuantitas'] = $dataSimak['qty'];
                $dataPerlengkapan['dari'] = $dataSimak['asal_barang'];
                $this->db->set($dataPerlengkapan);
                $this->db->replace('asset_perlengkapan');
//                $dataSimak['kd_brg'] = $kd_brg;
//                
//                foreach ($extFields as $field) {
//			$dataExt[$field] = $this->input->post($field);
//		} 
//                $dataExt['kd_brg'] = $kd_brg;
//                
//                foreach($klasifikasiAsetFields as $field)
//                {
//                    $dataKlasifikasiAset[$field] =  $this->input->post($field);
//                }
//                
//                $dataExt['kd_klasifikasi_aset'] = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasiAset);
//                
//                 //GENERASI NO_ASET 
//                if($dataSimak['no_aset'] == null || $dataSimak['no_aset'] == "")
//                {
//                    $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'], $dataSimak['kd_lokasi']);
//                    $dataExt['no_aset'] = $dataSimak['no_aset'];
//                }
//			
		$this->modifyData($dataSimak, null);
	}
	
	function deleteInventoryPenyimpanan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
        
        function getSpecificInventoryPenyimpanan()
        {
            $id = $this->input->post('id');
            $result = $this->model->get_InventoryPenyimpanan($id);
            echo json_encode($result);
        }
}
?>