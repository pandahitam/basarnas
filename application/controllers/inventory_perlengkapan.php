<?php
class inventory_perlengkapan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
		$this->load->model('Inventory_Perlengkapan_Model','',TRUE);
		$this->model = $this->Inventory_Perlengkapan_Model;		
	}
	
//	function index(){
//		if($this->input->post("id_open")){
//			$data['jsscript'] = TRUE;
//			$this->load->view('inventory/pemeriksaan_view',$data);
//		}else{
//			$this->load->view('inventory/pemeriksaan_view');
//		}
//	}
        
        
        
        /*
         * PENGADAAN 
         */
        function createPengadaanPerlengkapan(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->insert('pengadaan_data_perlengkapan',$row);
                    $asset_perlengkapan_data = array(
                        'kd_brg'=>$row->kd_brg,
                        'part_number'=>$row->part_number,
                        'kondisi'=>$row->status_barang,
                        'dari'=>$row->asal_barang,
                        'serial_number'=>$row->serial_number,
                        'kuantitas'=>$row->qty,
                    );
                    $this->db->insert('asset_perlengkapan',$asset_perlengkapan_data);
                }
            }
            else
            {
                $this->db->insert('pengadaan_data_perlengkapan',$data);
                $asset_perlengkapan_data = array(
                        'kd_brg'=>$data->kd_brg,
                        'part_number'=>$data->part_number,
                        'kondisi'=>$data->status_barang,
                        'dari'=>$data->asal_barang,
                        'serial_number'=>$data->serial_number,
                        'kuantitas'=>$data->qty,
                    );
                $this->db->insert('asset_perlengkapan',$asset_perlengkapan_data);
            }
            
            echo "{success:true}";
	}
        
       function updatePengadaanPerlengkapan(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->set($row);
                    $this->db->replace('pengadaan_data_perlengkapan');
                }
            }
            else
            {
                    $this->db->set($data);
                    $this->db->replace('pengadaan_data_perlengkapan');
            }
            
           

            echo "{success:true}"; 
       }
	
	function destroyPengadaanPerlengkapan()
	{
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->delete('pengadaan_data_perlengkapan', array('id' => $row->id));
                }
            }
            else
            {
                    $this->db->delete('pengadaan_data_perlengkapan', array('id' => $data->id));
            }
            
		 echo "{success:true}"; 
	}
        
        function getSpecificPengadaanPerlengkapan()
        {
            $data = array();
            if(isset($_POST['id_source']))
            {
                $id = $this->input->post('id_source');
                $data = $this->model->get_InventoryPerlengkapan($id,'pengadaan_data_perlengkapan');
            }
            
            $datasend["results"] = $data;
            echo json_encode($datasend);
        }
        
        /*
         * INVENTORY PENERIMAAN/PEMERIKSAAN
         */
        
	function createInventoryPenerimaanPerlengkapan(){
            $data = json_decode($this->input->post('data'));
           
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->insert('inventory_penerimaan_data_perlengkapan',$row);
                }
            }
            else
            {
                $this->db->insert('inventory_penerimaan_data_perlengkapan',$data);
            }
            
            echo "{success:true}";
	}
        
       function updateInventoryPenerimaanPerlengkapan(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->set($row);
                    $this->db->replace('inventory_penerimaan_data_perlengkapan');
                }
            }
            else
            {
                    $this->db->set($data);
                    $this->db->replace('inventory_penerimaan_data_perlengkapan');
            }
            
           

            echo "{success:true}"; 
       }
	
	function destroyInventoryPenerimaanPerlengkapan()
	{
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->delete('inventory_penerimaan_data_perlengkapan', array('id' => $row->id));
                }
            }
            else
            {
                    $this->db->delete('inventory_penerimaan_data_perlengkapan', array('id' => $data->id));
            }
            
		 echo "{success:true}"; 
	}
        
        function getSpecificInventoryPenerimaanPerlengkapan()
        {
            $data = array();
            if(isset($_POST['id_inventory']))
            {
                $id = $this->input->post('id_inventory');
                $data = $this->model->get_InventoryPerlengkapan($id,'inventory_penerimaan_data_perlengkapan');
            }
            
            $datasend["results"] = $data;
            echo json_encode($datasend);
        }
        
        
        
        
}
?>