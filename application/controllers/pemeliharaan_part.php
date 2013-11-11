<?php
class Pemeliharaan_Part extends MY_Controller {


	function __construct() {
		parent::__construct();

 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pemeliharaan_Part_Model','',TRUE);
		$this->model = $this->Pemeliharaan_Part_Model;		
	}
	
//	function index(){
//		if($this->input->post("id_open")){
//			$data['jsscript'] = TRUE;
//			$this->load->view('process_asset/pemeliharaan_view',$data);
//		}else{
//			$this->load->view('process_asset/pemeliharaan_view');
//		}
//	}
	
	function modifyPemeliharaanPart(){
//                var_dump($_POST);
//                die;
//                $dataSimak = array();
//	  	$simakFields = array(
//			'id','id_pemeliharaan','id_penyimpanan','qty_pemeliharaan'
//                );
//                
//                
//
//		foreach ($simakFields as $field) {
//			$dataSimak[$field] = $this->input->post($field);
//		}
//                
//                $qty_awal= $this->input->post('qty');
//                
//                $this->db->where('id',$dataSimak['id_penyimpanan']);
//                $query = $this->db->get('inventory_penyimpanan');
//                $result = $query->row();
//                
//                
//                $dataPenyimpanan = array(
//                    'qty'=> $qty_awal - $dataSimak['qty_pemeliharaan']
//                );
//                
//                /*UPDATE QTY IN PENYIMPANAN */
//                $this->db->where('id',$dataSimak['id_penyimpanan']);
//                $this->db->update('inventory_penyimpanan',$dataPenyimpanan);
//
//                $this->modifyData($dataSimak, null);
	}
	
	function deletePemeliharaanPart()
	{
//                $input_data = $this->input->post('data');
//                
//                foreach($input_data as $data)
//                {
//                    
//                    $this->db->where('id',$data['id']);
//                    $this->db->delete('pemeliharaan_part');
//                    
//                    //Return the quantity back to inventory_penyimpanan when deleted
//                    $this->db->where('id',$data['id_penyimpanan']);
//                    $penyimpanan_result = $this->db->get('inventory_penyimpanan');
//                   if($penyimpanan_result->num_rows == 1)
//                   {
//                       $data_penyimpanan = $penyimpanan_result->row();
//                       $qty_akhir = array( 
//                           'qty'=>(int)$data_penyimpanan->qty + (int)$data['qty_pemeliharaan']
//                               );
//                       $this->db->where('id',$data['id_penyimpanan']);
//                       $this->db->update('inventory_penyimpanan',$qty_akhir);
//                               
//                   }
//                }
	}
        
                /*
         * PEMELIHARAAN PARTS
         */
	function createPemeliharaanParts(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $qty_akhir = ($row->qty) - ($row->qty_pemeliharaan);
                    unset($row->qty,$row->part_number,$row->nama);
                    $this->db->insert('pemeliharaan_part',$row);
                    $query = "update inventory_penyimpanan_data_perlengkapan set qty= $qty_akhir where id=$row->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
                }
            }
            else
            {
                $qty_akhir = ($data->qty) - ($data->qty_pemeliharaan);
                unset($data->qty,$data->part_number,$data->nama);
                $this->db->insert('pemeliharaan_part',$data);
                $query = "update inventory_penyimpanan_data_perlengkapan set qty= $qty_akhir where id=$data->id_penyimpanan_data_perlengkapan";
                $this->db->query($query);
            }
            
            echo "{success:true}";
	}
        
       function updatePemeliharaanParts(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $qty_akhir = ($row->qty) - ($row->qty_pemeliharaan);
                    unset($row->qty,$row->part_number,$row->nama);
                    $this->db->set($row);
                    $this->db->replace('pemeliharaan_part');
                    $query = "update inventory_penyimpanan_data_perlengkapan set qty= $qty_akhir where id=$row->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
                }
            }
            else
            {
                    $qty_akhir = ($data->qty) - ($data->qty_pemeliharaan);
                    unset($data->qty,$data->part_number,$data->nama);
                    $this->db->set($data);
                    $this->db->replace('pemeliharaan_part');
                    $query = "update inventory_penyimpanan_data_perlengkapan set qty= $qty_akhir where id=$data->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
            }
            
           

            echo "{success:true}"; 
       }
	
	function destroyPemeliharaanParts()
	{
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->delete('pemeliharaan_part', array('id' => $row->id));
                     $query = "update inventory_penyimpanan_data_perlengkapan set qty= (qty + $row->qty_pemeliharaan) where id=$row->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
                }
            }
            else
            {
                    $this->db->delete('pemeliharaan_part', array('id' => $data->id));
                    $query = "update inventory_penyimpanan_data_perlengkapan set qty= (qty + $data->qty_pemeliharaan) where id=$data->id_penyimpanan_data_perlengkapan";
                    $this->db->query($query);
            }
            
		 echo "{success:true}"; 
	}
        
        function getSpecificPemeliharaanParts()
        {
            $data = array();
            if(isset($_POST['id_pemeliharaan']))
            {
                $id = $this->input->post('id_pemeliharaan');
                $data = $this->model->get_PemeliharaanParts($id);
                $datasend["results"] = $data['data'];
                $datasend["total"] = $data['count'];
                echo json_encode($datasend);
            }
            
            
        }
        
        
        //ANGKUTAN UDARA
        function createPemeliharaanPartsAngkutanUdara(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                   
                    if($row->jenis_perlengkapan == "Part Pesawat")
                    {
                        $query_pesawat = $this->db->query("select kd_brg,kd_lokasi,no_aset from ext_asset_angkutan where id = $row->id_ext_asset");
                        $query_pesawat_result = $query_pesawat->row();
                        $this->db->where('id',$row->id_asset_perlengkapan);
                        $updateWithNomorInduk = array(
                            'warehouse_id'=>0,
                            'ruang_id'=>0,
                            'rak_id'=>0,
                            'no_induk_asset'=>$query_pesawat_result->kd_brg.$query_pesawat_result->kd_lokasi.$query_pesawat_result->no_aset,
                        );
                        $this->db->update('asset_perlengkapan',$updateWithNomorInduk);
                    }
                    unset($row->part_number,$row->serial_number,$row->kd_brg);
                    $this->db->insert('ext_asset_angkutan_udara_perlengkapan',$row);
                }
            }
            else
            {
                
                if($data->jenis_perlengkapan == "Part Pesawat")
                {
                    $query_pesawat = $this->db->query("select kd_brg,kd_lokasi,no_aset from ext_asset_angkutan where id = $data->id_ext_asset");
                    $query_pesawat_result = $query_pesawat->row();
                    $this->db->where('id',$data->id_asset_perlengkapan);
                    $updateWithNomorInduk = array(
                        'warehouse_id'=>0,
                        'ruang_id'=>0,
                        'rak_id'=>0,
                        'no_induk_asset'=>$query_pesawat_result->kd_brg.$query_pesawat_result->kd_lokasi.$query_pesawat_result->no_aset,
                    );
                    $this->db->update('asset_perlengkapan',$updateWithNomorInduk);
                }
                unset($data->part_number,$data->serial_number,$data->kd_brg);
                $this->db->insert('ext_asset_angkutan_udara_perlengkapan',$data);
            }
            
            echo "{success:true}";
	}
        
       function updatePemeliharaanPartsAngkutanUdara(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    unset($row->part_number,$row->serial_number,$row->kd_brg);
                    $this->db->set($row);
                    $this->db->replace('ext_asset_angkutan_udara_perlengkapan');
                }
            }
            else
            {
                    unset($data->part_number,$data->serial_number,$data->kd_brg);
                    $this->db->set($data);
                    $this->db->replace('ext_asset_angkutan_udara_perlengkapan');
            }
            
            echo "{success:true}"; 
       }
	
	function destroyPemeliharaanPartsAngkutanUdara()
	{
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->delete('ext_asset_angkutan_udara_perlengkapan', array('id' => $row->id));
                    if($row->jenis_perlengkapan == "Part Pesawat")
                    {
                        $this->db->where('id',$row->id_asset_perlengkapan);
                        $removedFromAngkutanUdara = array(
                            'warehouse_id'=>0,
                            'ruang_id'=>0,
                            'rak_id'=>0,
                            'no_induk_asset'=>''
                        );
                        $this->db->update('asset_perlengkapan',$removedFromAngkutanUdara);
                    }
                    
                }
            }
            else
            {
                    $this->db->delete('ext_asset_angkutan_udara_perlengkapan', array('id' => $data->id));
                    if($data->jenis_perlengkapan == "Part Pesawat")
                    {
                        $this->db->where('id',$data->id_asset_perlengkapan);
                        $removedFromAngkutanUdara = array(
                            'warehouse_id'=>0,
                            'ruang_id'=>0,
                            'rak_id'=>0,
                            'no_induk_asset'=>''
                        );
                        $this->db->update('asset_perlengkapan',$removedFromAngkutanUdara);
                    }
            }
            
		 echo "{success:true}"; 
	}
        
        function getSpecificPemeliharaanPartsAngkutanUdara()
        {
            $data = array();
            if(isset($_POST['id_ext_asset']))
            {
                $id_ext_asset = $this->input->post('id_ext_asset');
                $query = "select t.id,t.id_ext_asset,t.id_asset_perlengkapan,t.jenis_perlengkapan,t.no,t.nama,t.keterangan,a.part_number,a.serial_number, a.kd_brg
                        FROM ext_asset_angkutan_udara_perlengkapan as t
                        LEFT JOIN asset_perlengkapan as a on t.id_asset_perlengkapan = a.id
                        WHERE id_ext_asset = $id_ext_asset";
//                return $this->Get_By_Query($query);
                $r = $this->db->query($query);
                $data = array();
                if ($r->num_rows() > 0)
		{
		    foreach ($r->result() as $obj)
		    {
			$data[] = $obj;
		    }  
		}
                
                $datasend["results"] = $data;
//                $datasend["total"] = $data['count'];
                echo json_encode($datasend);
            }
            
            
        }
        
        //ANGKUTAN DARAT
        function createPemeliharaanPartsAngkutanDarat(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                   
                    if($row->jenis_perlengkapan == "Part")
                    {
                        $query_asset = $this->db->query("select kd_brg,kd_lokasi,no_aset from ext_asset_angkutan where id = $row->id_ext_asset");
                        $query_asset_result = $query_asset->row();
                        $this->db->where('id',$row->id_asset_perlengkapan);
                        $updateWithNomorInduk = array(
                            'warehouse_id'=>0,
                            'ruang_id'=>0,
                            'rak_id'=>0,
                            'no_induk_asset'=>$query_asset_result->kd_brg.$query_asset_result->kd_lokasi.$query_asset_result->no_aset,
                        );
                        $this->db->update('asset_perlengkapan',$updateWithNomorInduk);
                    }
                    unset($row->part_number,$row->serial_number,$row->kd_brg);
                    $this->db->insert('ext_asset_angkutan_darat_perlengkapan',$row);
                }
            }
            else
            {
                
                if($data->jenis_perlengkapan == "Part")
                {
                    $query_asset = $this->db->query("select kd_brg,kd_lokasi,no_aset from ext_asset_angkutan where id = $data->id_ext_asset");
                    $query_asset_result = $query_asset->row();
                    $this->db->where('id',$data->id_asset_perlengkapan);
                    $updateWithNomorInduk = array(
                        'warehouse_id'=>0,
                        'ruang_id'=>0,
                        'rak_id'=>0,
                        'no_induk_asset'=>$query_asset_result->kd_brg.$query_asset_result->kd_lokasi.$query_asset_result->no_aset,
                    );
                    $this->db->update('asset_perlengkapan',$updateWithNomorInduk);
                }
                unset($data->part_number,$data->serial_number,$data->kd_brg);
                $this->db->insert('ext_asset_angkutan_darat_perlengkapan',$data);
            }
            
            echo "{success:true}";
	}
        
       function updatePemeliharaanPartsAngkutanDarat(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    unset($row->part_number,$row->serial_number,$row->kd_brg);
                    $this->db->set($row);
                    $this->db->replace('ext_asset_angkutan_darat_perlengkapan');
                }
            }
            else
            {
                    unset($data->part_number,$data->serial_number,$data->kd_brg);
                    $this->db->set($data);
                    $this->db->replace('ext_asset_angkutan_darat_perlengkapan');
            }
            
            echo "{success:true}"; 
       }
	
	function destroyPemeliharaanPartsAngkutanDarat()
	{
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->delete('ext_asset_angkutan_darat_perlengkapan', array('id' => $row->id));
                    if($row->jenis_perlengkapan == "Part")
                    {
                        $this->db->where('id',$row->id_asset_perlengkapan);
                        $removedFromAngkutan = array(
                            'warehouse_id'=>0,
                            'ruang_id'=>0,
                            'rak_id'=>0,
                            'no_induk_asset'=>''
                        );
                        $this->db->update('asset_perlengkapan',$removedFromAngkutan);
                    }
                    
                }
            }
            else
            {
                    $this->db->delete('ext_asset_angkutan_darat_perlengkapan', array('id' => $data->id));
                    if($data->jenis_perlengkapan == "Part")
                    {
                        $this->db->where('id',$data->id_asset_perlengkapan);
                        $removedFromAngkutan = array(
                            'warehouse_id'=>0,
                            'ruang_id'=>0,
                            'rak_id'=>0,
                            'no_induk_asset'=>''
                        );
                        $this->db->update('asset_perlengkapan',$removedFromAngkutan);
                    }
            }
            
		 echo "{success:true}"; 
	}
        
        function getSpecificPemeliharaanPartsAngkutanDarat()
        {
            $data = array();
            if(isset($_POST['id_ext_asset']))
            {
                $id_ext_asset = $this->input->post('id_ext_asset');
                $query = "select t.id,t.id_ext_asset,t.id_asset_perlengkapan,t.jenis_perlengkapan,t.no,t.nama,t.keterangan,a.part_number,a.serial_number, a.kd_brg
                        FROM ext_asset_angkutan_darat_perlengkapan as t
                        LEFT JOIN asset_perlengkapan as a on t.id_asset_perlengkapan = a.id
                        WHERE id_ext_asset = $id_ext_asset";
//                return $this->Get_By_Query($query);
                $r = $this->db->query($query);
                $data = array();
                if ($r->num_rows() > 0)
		{
		    foreach ($r->result() as $obj)
		    {
			$data[] = $obj;
		    }  
		}
                
                $datasend["results"] = $data;
//                $datasend["total"] = $data['count'];
                echo json_encode($datasend);
            }
            
            
        }
        
        
	
}
?>