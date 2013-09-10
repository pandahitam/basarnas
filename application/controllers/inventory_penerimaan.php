<?php
class inventory_penerimaan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
		$this->load->model('Inventory_Penerimaan_Model','',TRUE);
		$this->model = $this->Inventory_Penerimaan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('inventory/penerimaan_view',$data);
		}else{
			$this->load->view('inventory/penerimaan_view');
		}
	}
	
	function modifyInventoryPenerimaan(){
//            var_dump($_POST);
//            die;
		$dataSimak = array();
//                $dataExt = array();
//                $dataKode = array();
                
                
//                $klasifikasiAsetFields = array(
//                    'kd_lvl1','kd_lvl2','kd_lvl3'
//                );
//                $kodeFields = array(
//                        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel'
//                );
                
	  	$simakFields = array(
			'id','tgl_berita_acara','nomor_berita_acara','kd_brg','kd_lokasi','id_pengadaan','nama_org',
                                        'no_aset', 'part_number','serial_number','date_created',
                                        'keterangan', 'status_barang','qty','tgl_penerimaan','asal_barang'
                );
                
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
                
			
		$this->modifyData($dataSimak, null);
	}
	
	function deleteInventoryPenerimaan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
        
        function getSpecificInventoryPenerimaan()
        {
            $id = $this->input->post('id');
            $result = $this->model->get_InventoryPenerimaan($id);
            echo json_encode($result);
        }
}
?>