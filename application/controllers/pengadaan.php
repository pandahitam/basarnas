<?php
class Pengadaan extends MY_Controller {

	function __construct() {
		parent::__construct();
                
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pengadaan_Model','',TRUE);
		$this->model = $this->Pengadaan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/pengadaan_view',$data);
		}else{
			$this->load->view('process_asset/pengadaan_view');
		}
	}
	
	function modifyPengadaan(){
                $data = array();

	  	$fields = array(
			'id', 'kode_unker', 'kode_unor', 'id_vendor', 'kd_lokasi','kd_brg','no_aset','merek','model','nama',
                        'tahun_angaran', 'perolehan_sumber', 'perolehan_bmn', 'perolehan_tanggal',
                        'no_sppa', 'asal_pengadaan', 'harga_total', 'deskripsi', 
                        'faktur_no', 'faktur_tanggal', 'kuitansi_no', 'kuitansi_tanggal', 
                        'sp2d_no', 'sp2d_tanggal', 'mutasi_no', 'mutasi_tanggal', 
                        'garansi_berlaku', 'garansi_keterangan', 'pelihara_berlaku', 'pelihara_keterangan', 
                        'spk_no', 'spk_jenis', 'spk_berlaku', 'spk_keterangan', 'is_terpelihara', 
                        'is_garansi', 'is_spk', 'data_kontrak','document_url','image_url'
                );
                
                foreach ($fields as $field) {
                        $data[$field] = $this->input->post($field);
		} 
                
//		$this->modifyData(null,$data);
                if($data['id'] == '')
                {
                    $this->db->insert('pengadaan',$data);
                    $id = $this->db->insert_id();
                    $kd_lokasi = $data['kd_lokasi'];
                    $this->createLog('INSERT PENGADAAN','pengadaan');
                    
                }
                else
                {
                    $id = $data['id'];
                    $kd_lokasi = $data['kd_lokasi'];
                    $this->db->set($data);
                    $this->db->replace('pengadaan');
                    $this->createLog('UPDATE PENGADAAN','pengadaan');
                }
                
                
                echo "{success:true,id:$id}";
	}
        
        function insertPengadaanInAssetPerlengkapan(){
                $id_asset_perlengkapan = $this->input->post("id_asset_perlengkapan");
                $jenis_perlengkapan = $this->input->post("jenis_perlengkapan");
                $data = array();
//                var_dump($jenis_perlengkapan);
//                die;
	  	$fields = array(
			'id', 'kode_unker', 'kode_unor', 'id_vendor', 'kd_lokasi','kd_brg','no_aset','merek','model','nama',
                        'tahun_angaran', 'perolehan_sumber', 'perolehan_bmn', 'perolehan_tanggal',
                        'no_sppa', 'asal_pengadaan', 'harga_total', 'deskripsi', 
                        'faktur_no', 'faktur_tanggal', 'kuitansi_no', 'kuitansi_tanggal', 
                        'sp2d_no', 'sp2d_tanggal', 'mutasi_no', 'mutasi_tanggal', 
                        'garansi_berlaku', 'garansi_keterangan', 'pelihara_berlaku', 'pelihara_keterangan', 
                        'spk_no', 'spk_jenis', 'spk_berlaku', 'spk_keterangan', 'is_terpelihara', 
                        'is_garansi', 'is_spk', 'data_kontrak','document_url','image_url'
                );
                
                foreach ($fields as $field) {
                        $data[$field] = $this->input->post($field);
		} 
                
//		$this->modifyData(null,$data);
                if($data['id'] == '')
                {
                    if($this->input->post("pengadaan_existing_id") >0)
                    {
                        unset($data['id'],$data['kode_unker'],$data['kode_unor'],$data['kd_lokasi'],$data['kd_brg'],$data['no_aset']);
                        $id = $this->input->post("pengadaan_existing_id");
                        $this->db->set($data);
                        $this->db->where('id',$id);
                        $this->db->update('pengadaan');
                    }
                    else
                    {
                        $this->db->insert('pengadaan',$data);
                        $id = $this->db->insert_id();
                    }
                    
//                    $kd_lokasi = $data['kd_lokasi'];
                    if($jenis_perlengkapan == "Part")
                    {
                        $this->db->where('id',$id_asset_perlengkapan);
                        $query = $this->db->get('asset_perlengkapan');
                        $result = $query->row();
                        $data_pengadaan = array(
                            'id_source'=>$id,
                            'kd_brg'=>$result->kd_brg,
                            'no_aset'=>$result->no_aset,
                            'part_number'=>$result->part_number,
                            'serial_number'=>$result->serial_number,
                            'status_barang'=>$result->kondisi,
                            'qty'=>$result->kuantitas,
                            'asal_barang'=>$result->dari,
                            'id_asset_perlengkapan'=>$result->id
                        );
                        $this->db->insert("pengadaan_data_perlengkapan",$data_pengadaan);
                        
                        $this->db->where('id',$id_asset_perlengkapan);
                        $this->db->update('asset_perlengkapan',array("id_pengadaan"=>$id));
                        
                    }
                    else if($jenis_perlengkapan == "Sub Part")
                    {
                        $this->db->where('id',$id_asset_perlengkapan);
                        $query = $this->db->get('asset_perlengkapan_sub_part');
                        $result = $query->row();
                        $data_pengadaan = array(
                            'id_source'=>$id,
                            'kd_brg'=>$result->kd_brg,
                            'no_aset'=>$result->no_aset,
                            'part_number'=>$result->part_number,
                            'serial_number'=>$result->serial_number,
                            'status_barang'=>$result->kondisi,
                            'qty'=>$result->kuantitas,
                            'asal_barang'=>$result->dari,
                            'id_asset_perlengkapan_sub_part'=>$result->id
                        );
                        $this->db->insert("pengadaan_data_perlengkapan_sub_part",$data_pengadaan);
                        
                        $this->db->where('id',$id_asset_perlengkapan);
                        $this->db->update('asset_perlengkapan_sub_part',array("id_pengadaan"=>$id));
                    }
                    else if($jenis_perlengkapan == "Sub Sub Part")
                    {
                        $this->db->where('id',$id_asset_perlengkapan);
                        $query = $this->db->get('asset_perlengkapan_sub_sub_part');
                        $result = $query->row();
                        $data_pengadaan = array(
                            'id_source'=>$id,
                            'kd_brg'=>$result->kd_brg,
                            'no_aset'=>$result->no_aset,
                            'part_number'=>$result->part_number,
                            'serial_number'=>$result->serial_number,
                            'status_barang'=>$result->kondisi,
                            'qty'=>$result->kuantitas,
                            'asal_barang'=>$result->dari,
                            'id_asset_perlengkapan_sub_sub_part'=>$result->id
                        );
                        $this->db->insert("pengadaan_data_perlengkapan_sub_sub_part",$data_pengadaan);
                        
                        $this->db->where('id',$id_asset_perlengkapan);
                        $this->db->update('asset_perlengkapan_sub_sub_part',array("id_pengadaan"=>$id));
                    }
                    $this->createLog('INSERT PENGADAAN','pengadaan');
                    
                }
                
                
                echo "{success:true}";
	}
	
	function deletePengadaan()
	{
		$data = $this->input->post('data');
                $deleted_pengadaan_part = array();
                $deleted_pengadaan_sub_part = array();
                $deleted_pengadaan_sub_sub_part = array();
                foreach($data as $dataContent)
                {

                    $associated_part_query = $this->db->query("select * from pengadaan_data_perlengkapan where id_asset_perlengkapan != null and id_asset_perlengkapan != 0 and id_source = ".$dataContent['id']);
                    $associated_sub_part_query = $this->db->query("select * from pengadaan_data_perlengkapan_sub_part where id_asset_perlengkapan_sub_part != null and id_asset_perlengkapan_sub_part != 0 and id_source =".$dataContent['id']);
                    $associated_sub_sub_part_query = $this->db->query("select * from pengadaan_data_perlengkapan_sub_sub_part where id_asset_perlengkapan_sub_sub_part != null and id_asset_perlengkapan_sub_sub_part != 0 and id_source=".$dataContent['id']);
                    
                    if($associated_part_query->num_rows() >0)
                    {
                        foreach($associated_part_query->result() as $data2)
                        {
                            $deleted_pengadaan_part[] = $data2->id_asset_perlengkapan;
                        }
                    }
                    
                    if($associated_sub_part_query->num_rows() >0)
                    {
                        foreach($associated_sub_part_query->result() as $data2)
                        {
                            $deleted_pengadaan_sub_part[] = $data2->id_asset_perlengkapan_sub_part;
                        }
                    }
                    
                    if($associated_sub_sub_part_query->num_rows() >0)
                    {
                        foreach($associated_sub_sub_part_query->result() as $data2)
                        {
                            $deleted_pengadaan_sub_sub_part[] = $data2->id_asset_perlengkapan_sub_sub_part;
                        }
                    }
                    $this->createLog('DELETE PENGADAAN','pengadaan');
                }

                if(count($deleted_pengadaan_part) > 0)
                {
                    $this->db->where_in('id',$deleted_pengadaan_part);
                    $this->db->update("asset_perlengkapan",array('id_pengadaan'=>0));
                }
                
                if(count($deleted_pengadaan_sub_part)>0)
                {
                    $this->db->where_in('id',$deleted_pengadaan_sub_part);
                    $this->db->update("asset_perlengkapan_sub_part",array('id_pengadaan'=>0));
                }
                
                if(count($deleted_pengadaan_sub_sub_part) > 0)
                {
                    $this->db->where_in('id',$deleted_pengadaan_sub_sub_part);
                    $this->db->update("asset_perlengkapan_sub_sub_part",array('id_pengadaan'=>0));
                }

//                var_dump(array($deleted_pengadaan_part,$deleted_pengadaan_sub_part,$deleted_pengadaan_sub_sub_part));
//                die;
                
		return $this->deleteProcess($data);
	}
	
	function getByID()
	{
		$id = $this->input->post('id_pengadaan');
		$data = $this->model->get_ByID($id);
                if(isset($_POST['isAssetPerlengkapan']))
                {
                    echo json_encode($data['data']);
                }
                else
                {
                    echo json_encode($data);
                }
		
	}
        
        function getByKode()
	{
		$kd_lokasi = $this->input->post('kd_lokasi');
                $kd_brg = $this->input->post('kd_brg');
                $no_aset = $this->input->post('no_aset');
                
		$data = $this->model->get_ByKode($kd_lokasi,$kd_brg,$no_aset);
		echo json_encode($data['data']);
	}
        
        function alertPengadaanAction()
        {
            $id = $_POST['id'];
            $update_alert_viewed_status = array(
                'alert_viewed_status'=>1
            );
            $this->db->where('id',$id);
            $this->db->update('pengadaan',$update_alert_viewed_status);
            echo 1;
        }
        
}
?>
