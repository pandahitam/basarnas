<?php
class inventory_pemeriksaan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
		$this->load->model('Inventory_Pemeriksaan_Model','',TRUE);
		$this->model = $this->Inventory_Pemeriksaan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('inventory/pemeriksaan_view',$data);
		}else{
			$this->load->view('inventory/pemeriksaan_view');
		}
	}
	
	function modifyInventoryPemeriksaan(){
		$dataSimak = array();
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
	  	$simakFields = array(
			'id','tgl_berita_acara','nomor_berita_acara','kd_brg','kd_lokasi','id_penerimaan','nama_org',
                        'no_aset', 'part_number','serial_number','date_created',
                        'keterangan', 'status_barang','qty','tgl_pemeriksaan','asal_barang'
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
	
	function deleteInventoryPemeriksaan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
        
        function getSpecificInventoryPemeriksaan()
        {
            $id = $this->input->post('id');
            $result = $this->model->get_InventoryPemeriksaan($id);
            echo json_encode($result);
        }
        
}
?>