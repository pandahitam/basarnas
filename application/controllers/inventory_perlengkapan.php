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
                $data = $this->model->get_InventoryPerlengkapan($id,'pengadaan_data_perlengkapan','pengadaan');
                $datasend["results"] = $data['data'];
                $datasend["total"] = $data['count'];
                echo json_encode($datasend);
            }
            
            
        }
        
        /*
         * INVENTORY PENERIMAAN/PEMERIKSAAN
         */
	function createInventoryPenerimaanPemeriksaanPerlengkapan(){
            $data = json_decode($this->input->post('data'));
           
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->insert('inventory_penerimaan_pemeriksaan_data_perlengkapan',$row);
                }
            }
            else
            {
                $this->db->insert('inventory_penerimaan_pemeriksaan_data_perlengkapan',$data);
            }
            
            echo "{success:true}";
	}
        
       function updateInventoryPenerimaanPemeriksaanPerlengkapan(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->set($row);
                    $this->db->replace('inventory_penerimaan_pemeriksaan_data_perlengkapan');
                }
            }
            else
            {
                    $this->db->set($data);
                    $this->db->replace('inventory_penerimaan_pemeriksaan_data_perlengkapan');
            }
            
           

            echo "{success:true}"; 
       }
	
	function destroyInventoryPenerimaanPemeriksaanPerlengkapan()
	{
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->delete('inventory_penerimaan_pemeriksaan_data_perlengkapan', array('id' => $row->id));
                }
            }
            else
            {
                    $this->db->delete('inventory_penerimaan_pemeriksaan_data_perlengkapan', array('id' => $data->id));
            }
            
		 echo "{success:true}"; 
	}
        
        function getSpecificInventoryPenerimaanPemeriksaanPerlengkapan()
        {
            $data = array();
            if(isset($_POST['id_source']))
            {
                $id = $this->input->post('id_source');
                $data = $this->model->get_InventoryPerlengkapan($id,'inventory_penerimaan_pemeriksaan_data_perlengkapan','inventory_penerimaan_pemeriksaan');
                $datasend["results"] = $data['data'];
                $datasend["total"] = $data['count'];
                echo json_encode($datasend);
                
            }
            
            
        }
        
        
        /*
         * INVENTORY PENYIMPANAN
         */
	function createInventoryPenyimpananPerlengkapan(){
            $data = json_decode($this->input->post('data'));
           
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    unset($row->nama_warehouse,$row->nama_ruang,$row->nama_rak,$row->invalid_grid_field_count);
                    $this->db->insert('inventory_penyimpanan_data_perlengkapan',$row);
                }
            }
            else
            {
                unset($data->nama_warehouse,$data->nama_ruang,$data->nama_rak,$data->invalid_grid_field_count);
                $this->db->insert('inventory_penyimpanan_data_perlengkapan',$data);
            }
            
            echo "{success:true}";
	}
        
       function updateInventoryPenyimpananPerlengkapan(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    unset($row->nama_warehouse,$row->nama_ruang,$row->nama_rak,$row->invalid_grid_field_count);
                    $this->db->set($row);
                    $this->db->replace('inventory_penyimpanan_data_perlengkapan');
                }
            }
            else
            {
                    unset($data->nama_warehouse,$data->nama_ruang,$data->nama_rak,$data->invalid_grid_field_count);
                    $this->db->set($data);
                    $this->db->replace('inventory_penyimpanan_data_perlengkapan');
            }
            
           

            echo "{success:true}"; 
       }
	
	function destroyInventoryPenyimpananPerlengkapan()
	{
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->delete('inventory_penyimpanan_data_perlengkapan', array('id' => $row->id));
                }
            }
            else
            {
                    $this->db->delete('inventory_penyimpanan_data_perlengkapan', array('id' => $data->id));
            }
            
		 echo "{success:true}"; 
	}
        
        function getSpecificInventoryPenyimpananPerlengkapan()
        {
            $data = array();
            if(isset($_POST['id_source']))
            {
                $id = $this->input->post('id_source');
                $data = $this->model->get_InventoryPerlengkapanPenyimpanan($id);
                $datasend["results"] = $data['data'];
                $datasend["total"] = $data['count'];
                echo json_encode($datasend);
            }
            
            
        }
        
        
        /*
         * INVENTORY PENYIMPANAN
         */
	function createInventoryPengeluaranPerlengkapan(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $qty_akhir = ($row->qty) - ($row->qty_keluar);
                    unset($row->qty,$row->nomor_berita_acara,$row->part_number);
                    $this->db->insert('inventory_pengeluaran_data_perlengkapan',$row);
                    $query = "update inventory_penyimpanan_data_perlengkapan set qty= $qty_akhir where id=$row->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
                }
            }
            else
            {
                $qty_akhir = ($data->qty) - ($data->qty_keluar);
                unset($data->qty,$data->nomor_berita_acara,$data->part_number);
                $this->db->insert('inventory_pengeluaran_data_perlengkapan',$data);
                $query = "update inventory_penyimpanan_data_perlengkapan set qty= $qty_akhir where id=$data->id_penyimpanan_data_perlengkapan";
                $this->db->query($query);
            }
            
            echo "{success:true}";
	}
        
       function updateInventoryPengeluaranPerlengkapan(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $qty_akhir = ($row->qty) - ($row->qty_keluar);
                    unset($row->qty,$row->nomor_berita_acara,$row->part_number);
                    $this->db->set($row);
                    $this->db->replace('inventory_pengeluaran_data_perlengkapan');
                    $query = "update inventory_penyimpanan_data_perlengkapan set qty= $qty_akhir where id=$row->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
                }
            }
            else
            {
                    $qty_akhir = ($data->qty) - ($data->qty_keluar);
                    unset($data->qty,$data->nomor_berita_acara,$data->part_number);
                    $this->db->set($data);
                    $this->db->replace('inventory_pengeluaran_data_perlengkapan');
                    $query = "update inventory_penyimpanan_data_perlengkapan set qty= $qty_akhir where id=$data->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
            }
            
           

            echo "{success:true}"; 
       }
	
	function destroyInventoryPengeluaranPerlengkapan()
	{
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->delete('inventory_pengeluaran_data_perlengkapan', array('id' => $row->id));
                     $query = "update inventory_penyimpanan_data_perlengkapan set qty= (qty + $row->qty_keluar) where id=$row->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
                }
            }
            else
            {
                    $this->db->delete('inventory_pengeluaran_data_perlengkapan', array('id' => $data->id));
                    $query = "update inventory_penyimpanan_data_perlengkapan set qty= (qty + $data->qty_keluar) where id=$data->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
            }
            
		 echo "{success:true}"; 
	}
        
        function getSpecificInventoryPengeluaranPerlengkapan()
        {
            $data = array();
            if(isset($_POST['id_source']))
            {
                $id = $this->input->post('id_source');
                $data = $this->model->get_InventoryPerlengkapanPengeluaran($id);
                $datasend["results"] = $data['data'];
                $datasend["total"] = $data['count'];
                echo json_encode($datasend);
            }
            
            
        }
        
        
        
        
}
?>