<?php
class inventory_penerimaan_pemeriksaan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
		$this->load->model('Inventory_Penerimaan_Pemeriksaan_Model','',TRUE);
		$this->model = $this->Inventory_Penerimaan_Pemeriksaan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('inventory/penerimaan_pemeriksaan_view',$data);
		}else{
			$this->load->view('inventory/penerimaan_pemeriksaan_view');
		}
	}
	
	function modifyInventoryPenerimaanPemeriksaan(){
//            var_dump($_POST);
//            die;
		$dataSimak = array();
                
	  	$simakFields = array(
			'id','tgl_berita_acara','nomor_berita_acara','kd_lokasi','id_pengadaan','nama_org',
                        'no_aset', 'part_number','serial_number','date_created',
                        'keterangan', 'status_barang','qty','tgl_penerimaan','asal_barang'
                );
                ;
                
		foreach ($simakFields as $field) {
			$dataSimak[$field] = $this->input->post($field);
		}
                
			
//		$this->modifyData($dataSimak, null);
                if($dataSimak['id'] == '')
                {
                    $this->db->insert('inventory_penerimaan_pemeriksaan',$dataSimak);
                    $id = $this->db->insert_id();
                    $this->createLog('INSERT INVENTORY PENERIMAAN/PEMERIKSAAN','inventory_penerimaan_pemeriksaan');
                }
                else
                {
                    $id = $dataSimak['id'];
                    $this->db->set($dataSimak);
                    $this->db->replace('inventory_penerimaan_pemeriksaan');
                    $this->createLog('UPDATE INVENTORY PENERIMAAN/PEMERIKSAAN','inventory_penerimaan_pemeriksaan');
                }
                
                echo "{success:true, id:$id}";
	}
	
	function deleteInventoryPenerimaanPemeriksaan()
	{
		$data = $this->input->post('data');
                foreach($data as $dataContent)
                {
                    $this->createLog('DELETE INVENTORY PENERIMAAN/PEMERIKSAAN','inventory_penerimaan_pemeriksaan');
                }
		return $this->deleteProcess($data);
	}
        
        function getSpecificInventoryPenerimaanPemeriksaan()
        {
            $id = $this->input->post('id');
            $result = $this->model->get_InventoryPenerimaanPemeriksaan($id);
            echo json_encode($result);
        }
}
?>