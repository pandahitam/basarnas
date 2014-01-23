<?php
class Asset_Perlengkapan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    	}
		$this->load->model('Asset_Perlengkapan_Model','',TRUE);
		$this->model = $this->Asset_Perlengkapan_Model;		
	}
	
	function perlengkapan(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('pengelolaan_asset/perlengkapan_view',$data);
		}else{
			$this->load->view('pengelolaan_asset/perlengkapan_view');
		}
	}
	
        function salinKeAssetPerlengkapan()
        {
            $data = array(
                'kd_lokasi'=>$_POST['kd_lokasi'],
                'part_number'=>$_POST['part_number'],
                'serial_number'=>$_POST['serial_number']
            );
            
            $partNumberDetails = $this->model->get_partNumberDetails($data['part_number']);
            $data['kd_brg'] = $partNumberDetails->kd_brg;
            $data['umur'] = $partNumberDetails->umur_maks;
            
//            if($data['kd_brg'] == '' || $data['kd_brg'] == null)
//            {
//                $data['kd_brg'] = '-';
//            }
            
            $data['no_aset'] = $this->noAssetGenerator($data['kd_brg'], $data['kd_lokasi']);
            $this->createLog('SALIN KE ASSET PERLENGKAPAN','asset_perlengkapan');
            $this->db->insert('asset_perlengkapan',$data);
            echo "{success:true}";
        }
        
	function modifyPerlengkapan(){
            
                $dataSimak = array();
                $dataKlasifikasiAset = array();
                
                $klasifikasiAsetFields = array(
                    'kd_lvl1','kd_lvl2','kd_lvl3'
                );
                //$dataExt = array();
//                $dataKode = array();
                
//                $kodeFields = array(
//                        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel'
//                );
                
	  	$simakFields = array(
			'id','warehouse_id','ruang_id','rak_id','umur',
                        'serial_number', 'part_number','kd_brg','kd_lokasi',
                        'no_aset','kondisi', 'kuantitas', 'dari',
                        'tanggal_perolehan','no_dana','penggunaan_waktu',
                        'penggunaan_freq','unit_waktu','unit_freq','disimpan', 
                        'dihapus','image_url','document_url','kd_klasifikasi_aset','kode_unor','alert','no_induk_asset',
                        'installation_date','installation_ac_tsn','installation_comp_tsn','task','is_oc','umur_maks',
                        'is_engine','cycle','cycle_maks','is_cycle','eng_type','eng_tso'
                    );
                
//                $extFields = array(
//                        'kd_lokasi', 'kd_brg', 'no_aset', 'id',
//                        'kode_unor','image_url','document_url'
//                );
//		

		foreach ($simakFields as $field) {
			$dataSimak[$field] = $this->input->post($field);
		}
                
                if(!isset($dataSimak['disimpan']))
                {
                    $dataSimak['disimpan'] = 0;
                }
                
                if(!isset($dataSimak['dihapus']))
                {
                    $dataSimak['dihapus'] = 0;
                }
                
                $partNumberDetails = $this->model->get_partNumberDetails($dataSimak['part_number']);
                $dataSimak['kd_brg'] = $partNumberDetails->kd_brg;
//                if($dataSimak['kd_brg'] == '' || $dataSimak['kd_brg'] == null)
//                {
//                    $dataSimak['kd_brg'] = '-';
//                }
                foreach($klasifikasiAsetFields as $field)
                {
                    $dataKlasifikasiAset[$field] =  $this->input->post($field);
                }
                if($dataKlasifikasiAset != '')
                {
                    $dataSimak['kd_klasifikasi_aset'] = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasiAset);
                }
                
                
                //GENERATE NO ASET
                if($dataSimak['no_aset'] == null || $dataSimak['no_aset'] == "")
                {
                    $this->db->where('id',$dataSimak['id']);
                    $query = $this->db->get('asset_perlengkapan');
                    $result = $query->row();
                    if($query->num_rows === 0)
                    {
                        $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'], $dataSimak['kd_lokasi']);
                    }
                    else
                    {
                        $dataSimak['no_aset'] = $result->no_aset;
                    }
                }
                
                if($dataSimak['id'] != '')
                {
                    $this->createLog('UPDATE ASSET PERLENGKAPAN','asset_perlengkapan');
                }
                else
                {
//                    $dataSimak['umur'] = $partNumberDetails->umur_maks;
                    $this->createLog('INSERT ASSET PERLENGKAPAN','asset_perlengkapan');
                }
                
//                $dataSimak['part_number'] = $partNumberDetails->part_number;
//                $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'],$dataSimak['kd_lokasi']);
                
//                foreach ($extFields as $field) {
//			$dataExt[$field] = $this->input->post($field);
//		} 
//                
//                $dataExt['kd_brg'] = $kd_brg;	
                
		$this->modifyData($dataSimak, null);
	}
	
	function deletePerlengkapan()
	{
            /*
             * NOTES:
             * The current built in function generates an error due to not having an ext table
             * that's why i made a custom one
             */
		$data = $this->input->post('data');
                $fail = array();
		$success = true;
		
		foreach($data as $keys)
		{              
                     $this->createLog('DELETE ASSET PERLENGKAPAN','asset_perlengkapan');
			if($this->model->deleteData($keys['id']) == FALSE)
			{
				$success = false;
			}
		}
		
		$result = array('fail' => $fail,
                                'success'=>$success);
						
		echo json_encode($result);
	}
	
	function cetak($input){
		$data_cetak = $this->model->get_SelectedDataPrint($input);
			if(count($data_cetak)){
				$data['dataprn'] = $data_cetak['dataasset'];
				$this->load->view('pengelolaan_asset/perlengkapan_pdf',$data);
			}
	}
        
        function getSpecificPerlengkapan()
        {
            $id = $this->input->post('id');
            $result = $this->model->get_Perlengkapan($id);
            echo json_encode($result);
        }
        
        
        
       function modifySubPart(){
            
                $data = array();
                //$dataExt = array();
//                $dataKode = array();
                
//                $kodeFields = array(
//                        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel'
//                );
	  	$dataFields = array(
			'id','id_part','nama','serial_number','part_number',
                        'installation_date','installation_ac_tsn','installation_comp_tsn','task','is_oc',
                        'umur','umur_maks','cycle','cycle_maks','is_cycle','is_engine','is_kelompok'
                    );

		foreach ($dataFields as $field) {
			$data[$field] = $this->input->post($field);
		}
                
                if($data['id'] != '')
                {
                    $id = $data['id'];
                    $this->db->set($data);
                    $this->db->replace('asset_perlengkapan_sub_part');
                    $this->createLog('UPDATE ASSET PERLENGKAPAN SUB PART','asset_perlengkapan_sub_part');
                }
                else
                {
                    $this->db->insert('asset_perlengkapan_sub_part',$data);
                    $id = $this->db->insert_id();
                    $this->createLog('INSERT ASSET PERLENGKAPAN SUB PART','asset_perlengkapan_sub_part');
                }
                
                echo "{success:true,id:$id}";
                
	}
	
	function deleteSubPart()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                $fail = array();
                $success = true;
                foreach($data as $deleted)
                {
                    $this->createLog('DELETE ASSET PERLENGKAPAN SUB PART','asset_perlengkapan_sub_part');
                    $deletedArray[] =$deleted['id'];
                }
                    
                     $this->db->where_in('id',$deletedArray);
		     $this->db->delete('asset_perlengkapan_sub_part');
		
		
		$result = array('fail' => $fail,
                                'success'=>$success);
						
		echo json_encode($result);
	}
        
        function getSpecificSubPart()
        {
           $id_part = $this->input->post('id_part');		
           $query = "select * FROM asset_perlengkapan_sub_part where id_part = '$id_part'";
           $r = $this->db->query($query); 
           $data = array();
            if ($r->num_rows() > 0)
            {
                foreach ($r->result() as $obj)
                {
                    $data[] = $obj;
                }  
            }
            $dataSend['results'] = $data;
            echo json_encode($dataSend);
        }
        
        
        function createSubSubPart(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $insert_data = array(
                        'id_sub_part'=>$row->id_sub_part,
                        'nama'=>$row->nama,
                        'part_number'=>$row->part_number,
                        'serial_number'=>$row->serial_number,
                        'umur'=>$row->umur,
                        'umur_maks'=>$row->umur_maks,
                        'is_cycle'=>$row->is_cycle,
                        'cycle'=>$row->cycle,
                        'cycle_maks'=>$row->cycle_maks,
                        'task'=>$row->task,
                        'is_engine'=>$row->is_engine,
                        'installation_date'=>$row->installation_date,
                        'installation_ac_tsn'=>$row->installation_ac_tsn,
                        'installation_comp_tsn'=>$row->installation_comp_tsn,
                        'is_oc'=>$row->is_oc,
                    );
                    $this->db->insert('asset_perlengkapan_sub_sub_part',$insert_data);
                    $id_insert = $this->db->insert_id();
                    
                    $this->createLog('INSERT ASSET PERLENGKAPAN SUB SUB PART [id='.$id_insert.']','asset_perlengkapan_sub_sub_part');
                    
                }
            }
            else
            {
                
                $insert_data = array(
                        'id_sub_part'=>$data->id_sub_part,
                        'nama'=>$data->nama,
                        'part_number'=>$data->part_number,
                        'serial_number'=>$data->serial_number,
                        'umur'=>$data->umur,
                        'umur_maks'=>$data->umur_maks,
                        'is_cycle'=>$data->is_cycle,
                        'cycle'=>$data->cycle,
                        'cycle_maks'=>$data->cycle_maks,
                        'task'=>$data->task,
                        'is_engine'=>$data->is_engine,
                        'installation_date'=>$data->installation_date,
                        'installation_ac_tsn'=>$data->installation_ac_tsn,
                        'installation_comp_tsn'=>$data->installation_comp_tsn,
                        'is_oc'=>$data->is_oc,
                    );
                    $this->db->insert('asset_perlengkapan_sub_sub_part',$insert_data);
                    $id_insert = $this->db->insert_id();
                    
                    $this->createLog('INSERT ASSET PERLENGKAPAN SUB SUB PART [id='.$id_insert.']','asset_perlengkapan_sub_sub_part');
            }
            
            echo "{success:true}";
	}
        
       function updateSubSubPart(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->set($row);
                    $this->db->replace('asset_perlengkapan_sub_sub_part');
                    $this->createLog('UPDATE ASSET PERLENGKAPAN SUB SUB PART [id='.$row->id.']','asset_perlengkapan_sub_sub_part');
                }
            }
            else
            {
                    $this->db->set($data);
                    $this->db->replace('asset_perlengkapan_sub_sub_part');
                    $this->createLog('UPDATE ASSET PERLENGKAPAN SUB SUB PART [id='.$data->id.']','asset_perlengkapan_sub_sub_part');
            }
            
            echo "{success:true}"; 
       }
	
	function destroySubSubPart()
	{
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $this->db->delete('asset_perlengkapan_sub_sub_part', array('id' => $row->id));
                    $this->createLog('UPDATE ASSET PERLENGKAPAN SUB SUB PART [part='.$row->part_number.']','asset_perlengkapan_sub_sub_part');
                }
            }
            else
            {
                    $this->db->delete('asset_perlengkapan_sub_sub_part', array('id' => $data->id));
                    $this->createLog('UPDATE ASSET PERLENGKAPAN SUB SUB PART [part='.$data->part_number.']','asset_perlengkapan_sub_sub_part');
            }
		    echo "{success:true}"; 
	}
        
        function getSpecificSubSubPart()
        {
           $id_sub_part = $this->input->post('id_sub_part');		
           $query = "select * FROM asset_perlengkapan_sub_sub_part where id_sub_part = '$id_sub_part'";
           $r = $this->db->query($query); 
           $data = array();
            if ($r->num_rows() > 0)
            {
                foreach ($r->result() as $obj)
                {
                    $data[] = $obj;
                }  
            }
            $dataSend['results'] = $data;
            echo json_encode($dataSend);
            
            
        }
}
?>