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
                    unset($dataSimak['no_induk_asset']);
                    if($dataSimak["warehouse_id"] != "" && $dataSimak["warehouse_id"] != null)
                    {
                        if($dataSimak["warehouse_id"] > 0)
                        {
                            $this->db->query("delete from ext_asset_angkutan_darat_perlengkapan where id_asset_perlengkapan =".$dataSimak["id"]);
                            $this->db->query("delete from ext_asset_angkutan_laut_perlengkapan where id_asset_perlengkapan =".$dataSimak["id"]);
                            $this->db->query("delete from ext_asset_angkutan_udara_perlengkapan where id_asset_perlengkapan =".$dataSimak["id"]);
                            $this->db->query("update asset_perlengkapan set no_induk_asset = null where id =".$dataSimak["id"]);
                        }
                    }
//                    $this->db->set($dataSimak);
//                    $this->db->replace('asset_perlengkapan');
                    $this->db->where('id',$dataSimak['id']);
                    $this->db->update('asset_perlengkapan',$dataSimak);
                    $this->createLog('UPDATE ASSET PERLENGKAPAN','asset_perlengkapan');
                    echo "{success:true}";
                }
                else
                {
                    $this->db->set($dataSimak);
                    $this->db->replace('asset_perlengkapan');
//                    $dataSimak['umur'] = $partNumberDetails->umur_maks;
                    $this->createLog('INSERT ASSET PERLENGKAPAN','asset_perlengkapan');
                    echo "{success:true}";
                }
                
//                $dataSimak['part_number'] = $partNumberDetails->part_number;
//                $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'],$dataSimak['kd_lokasi']);
                
//                foreach ($extFields as $field) {
//			$dataExt[$field] = $this->input->post($field);
//		} 
//                
//                $dataExt['kd_brg'] = $kd_brg;	
                
//		$this->modifyData($dataSimak, null);
	}
	
	function deletePerlengkapan()
	{
            /*
             * NOTES:
             * The current built in function generates an error due to not having an ext table
             * that's why i made a custom one
             */
		$data = $this->input->post('data');
//                var_dump($_POST);
//                die;
                $fail = array();
		$success = true;
		
                $unattachPart = array(
                    "id_part" => 0
                );
                
                
		foreach($data as $keys)
		{              
                     $this->createLog('DELETE ASSET PERLENGKAPAN','asset_perlengkapan');
			if($this->model->deleteData($keys['id']) == FALSE)
			{
				$success = false;
			}
                    
                     $this->db->where('id_part',$keys['id']);
                     $this->db->update('asset_perlengkapan_sub_part',$unattachPart);
                    $this->db->query("delete from ext_asset_angkutan_darat_perlengkapan where id_asset_perlengkapan =".$keys['id']);
                    $this->db->query("delete from ext_asset_angkutan_laut_perlengkapan where id_asset_perlengkapan =".$keys['id']);
                    $this->db->query("delete from ext_asset_angkutan_udara_perlengkapan where id_asset_perlengkapan =".$keys['id']);
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
           
           if($this->input->get_post("id_sub_part_existing"))
           {
               $id_part = $this->input->post("id_part_existing");
               $id_sub_part = $this->input->post("id_sub_part_existing");
               $this->db->query("update asset_perlengkapan_sub_part set id_part = $id_part where id=$id_sub_part");
               $this->createLog('UPDATE ASSET PERLENGKAPAN SUB PART','asset_perlengkapan_sub_part');
               echo "{success:true,id:$id_sub_part}";
           }
           else
           {
               $data = array();
                $dataKlasifikasiAset = array();
                
                $klasifikasiAsetFields = array(
                    'kd_lvl1','kd_lvl2','kd_lvl3'
                );
                
	  	$dataFields = array(
			'id','id_part','nama','serial_number','part_number',
                        'installation_date','installation_ac_tsn','installation_comp_tsn','task','is_oc',
                        'umur','umur_maks','cycle','cycle_maks','is_cycle','is_engine','is_kelompok',
                        'kd_brg','kd_lokasi',
                        'no_aset','kondisi', 'kuantitas', 'dari',
                        'tanggal_perolehan','no_dana','document_url','image_url','kd_klasifikasi_aset','kode_unor',
                        'warehouse_id','ruang_id','rak_id'
                    );

		foreach ($dataFields as $field) {
			$data[$field] = $this->input->post($field);
		}
                
                foreach($klasifikasiAsetFields as $field)
                {
                    $dataKlasifikasiAset[$field] =  $this->input->post($field);
                }
                if($dataKlasifikasiAset != '')
                {
                    $data['kd_klasifikasi_aset'] = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasiAset);
                }
                if($data['no_aset'] == null || $data['no_aset'] == "")
                {
                    $this->db->where('id',$data['id']);
                    $query = $this->db->get('asset_perlengkapan_sub_part');
                    $result = $query->row();
                    if($query->num_rows === 0)
                    {
                        $data['no_aset'] = $this->noAssetGenerator($data['kd_brg'], $data['kd_lokasi']);
                    }
                    else
                    {
                        if($result->no_aset == null || $result->no_aset == "")
                        {
                            $data['no_aset'] = $this->noAssetGenerator($data['kd_brg'], $data['kd_lokasi']);
                        }
                        else
                        {
                            $data['no_aset'] = $result->no_aset;
                        }
                    }
                }
                
                
                
                if($data['id'] != '')
                {
                    $id = $data['id'];
                    if($data["warehouse_id"] != "" && $data["warehouse_id"] != null)
                    {
                        if($data["warehouse_id"] > 0)
                        {
                            $data["id_part"] = 0;
                        }
                    }
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
                
                
	}
	
	function deleteSubPart()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                $fail = array();
                $success = true;
                foreach($data as $deleted)
                {
//                    $this->createLog('DELETE ASSET PERLENGKAPAN SUB PART','asset_perlengkapan_sub_part');
                    $deletedArray[] =$deleted['id'];
                }
                
                $unattach = array(
                    'id_part' => 0,
                );
                    
                     $this->db->where_in('id',$deletedArray);
		     $this->db->update('asset_perlengkapan_sub_part',$unattach);
		
		
		$result = array('fail' => $fail,
                                'success'=>$success);
						
		echo json_encode($result);
	}
        
        function deleteSubPart2()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                $fail = array();
                $success = true;
                $unattach_sub_part = array(
                    "id_sub_part"=>0
                );
                foreach($data as $deleted)
                {
                    $this->createLog('DELETE ASSET PERLENGKAPAN SUB PART','asset_perlengkapan_sub_part');
                    $deletedArray[] =$deleted['id'];
                }
                    
                     $this->db->where_in('id',$deletedArray);
		     $this->db->delete('asset_perlengkapan_sub_part');
                     
                     $this->db->where_in('id_sub_part',$deletedArray);
                     $this->db->update("asset_perlengkapan_sub_sub_part",$unattach_sub_part);
		
		$result = array('fail' => $fail,
                                'success'=>$success);
						
		echo json_encode($result);
	}
        
        function getSpecificSubPart()
        {
           $id_part = $this->input->post('id_part');		
           $query = "select t.*,a.kd_lvl1,a.kd_lvl2,a.kd_lvl3 FROM asset_perlengkapan_sub_part as t
               left join ref_klasifikasiaset_lvl3 as a on a.kd_klasifikasi_aset = t.kd_klasifikasi_aset
               where id_part = '$id_part'";
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
        
        function subPartStoreToWarehouse()
        {
            $id_collection = array_filter(explode(',',$this->input->post("id_collection")));
            $warehouse_id = $this->input->post("warehouse_id");
            $ruang_id = $this->input->post("ruang_id");
            $rak_id = $this->input->post("rak_id");
            $update_data = array(
                "id_part"=>0,
                "warehouse_id"=>$warehouse_id,
                "ruang_id"=>$ruang_id,
                "rak_id"=>$rak_id
            );
                    
            $this->db->where_in("id",$id_collection);
            $this->db->update("asset_perlengkapan_sub_part",$update_data);
            echo "{success:true}";
        }
        
        
        function createSubSubPart(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $dataKlasifikasi = array(
                        'kd_lvl1'=>$row->kd_lvl1,
                        'kd_lvl2'=>$row->kd_lvl2,
                        'kd_lvl3'=>$row->kd_lvl3
                    );
            $row->kd_klasifikasi_aset = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasi);
            
                if($row->no_aset == null || $row->no_aset == "")
                {
                        $row->no_aset = $this->noAssetGenerator($row->kd_brg, $row->kd_lokasi);
                }
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
//                        'alert'=>$row->alert,
                        'warehouse_id'=>$row->warehouse_id,
                        'ruang_id'=>$row->ruang_id,
                        'rak_id'=>$row->rak_id,
                        'kd_brg'=>$row->kd_brg,
                        'kd_lokasi'=>$row->kd_lokasi,
                        'no_aset'=>$row->no_aset,
                        'kondisi'=>$row->kondisi,
                        'kuantitas'=>$row->kuantitas,
                        'dari'=>$row->dari,
                        'tanggal_perolehan'=>$row->tanggal_perolehan,
                        'no_dana'=>$row->no_dana,
                        'image_url'=>$row->image_url,
                        'document_url'=>$row->document_url,
                        'kd_klasifikasi_aset'=>$row->kd_klasifikasi_aset,
                        'kode_unor'=>$row->kode_unor
                    );
                    $this->db->insert('asset_perlengkapan_sub_sub_part',$insert_data);
                    $id_insert = $this->db->insert_id();
                    
                    $this->createLog('INSERT ASSET PERLENGKAPAN SUB SUB PART [id='.$id_insert.']','asset_perlengkapan_sub_sub_part');
                    
                }
            }
            else
            {
                $dataKlasifikasi = array(
                'kd_lvl1'=>$data->kd_lvl1,
                'kd_lvl2'=>$data->kd_lvl2,
                'kd_lvl3'=>$data->kd_lvl3
            );
            $data->kd_klasifikasi_aset = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasi);
            if($data->no_aset == null || $data->no_aset == "")
            {
                    $data->no_aset = $this->noAssetGenerator($data->kd_brg, $data->kd_lokasi);
            }
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
                    //   'alert'=>$row->alert,
                        'warehouse_id'=>$data->warehouse_id,
                        'ruang_id'=>$data->ruang_id,
                        'rak_id'=>$data->rak_id,
                        'kd_brg'=>$data->kd_brg,
                        'kd_lokasi'=>$data->kd_lokasi,
                        'no_aset'=>$data->no_aset,
                        'kondisi'=>$data->kondisi,
                        'kuantitas'=>$data->kuantitas,
                        'dari'=>$data->dari,
                        'tanggal_perolehan'=>$data->tanggal_perolehan,
                        'no_dana'=>$data->no_dana,
                        'image_url'=>$data->image_url,
                        'document_url'=>$data->document_url,
                        'kd_klasifikasi_aset'=>$data->kd_klasifikasi_aset,
                        'kode_unor'=>$data->kode_unor
                    );
                    $this->db->insert('asset_perlengkapan_sub_sub_part',$insert_data);
                    $id_insert = $this->db->insert_id();
                    
                    $this->createLog('INSERT ASSET PERLENGKAPAN SUB SUB PART [id='.$id_insert.']','asset_perlengkapan_sub_sub_part');
            }
            
            echo "{success:true}";
	}
        
         function createSubSubPart2(){
            $data = array();
            $dataKlasifikasiAset = array();
            $klasifikasiAsetFields = array(
                'kd_lvl1','kd_lvl2','kd_lvl3'
            );
            
            $dataFields = array(
			'id','id_sub_part','nama','serial_number','part_number',
                        'installation_date','installation_ac_tsn','installation_comp_tsn','task','is_oc',
                        'umur','umur_maks','cycle','cycle_maks','is_cycle','is_engine',
                        'kd_brg','kd_lokasi',
                        'no_aset','kondisi', 'kuantitas', 'dari',
                        'tanggal_perolehan','no_dana','document_url','image_url','kd_klasifikasi_aset','kode_unor',
                        'warehouse_id','ruang_id','rak_id'
                    );

		foreach ($dataFields as $field) {
			$data[$field] = $this->input->post($field);
		}
                
                
                foreach($klasifikasiAsetFields as $field)
                {
                    $dataKlasifikasiAset[$field] =  $this->input->post($field);
                }
                if($dataKlasifikasiAset != '')
                {
                    $data['kd_klasifikasi_aset'] = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasiAset);
                }
                
                 if($data['no_aset'] == null || $data['no_aset'] == "")
                {
                        $data['no_aset'] = $this->noAssetGenerator($data['kd_brg'], $data['kd_lokasi']);
                }
                
                    $this->db->insert('asset_perlengkapan_sub_sub_part',$data);
                    $id_insert = $this->db->insert_id();
                    $this->createLog('INSERT ASSET PERLENGKAPAN SUB SUB PART [id='.$id_insert.']','asset_perlengkapan_sub_sub_part');
                    echo "{success:true}";
        }
        
        function updateSubSubPart2(){
            $data = array();
            $dataKlasifikasiAset = array();
            $klasifikasiAsetFields = array(
                'kd_lvl1','kd_lvl2','kd_lvl3'
            );
            
            $dataFields = array(
			'id','id_sub_part','nama','serial_number','part_number',
                        'installation_date','installation_ac_tsn','installation_comp_tsn','task','is_oc',
                        'umur','umur_maks','cycle','cycle_maks','is_cycle','is_engine',
                        'kd_brg','kd_lokasi',
                        'no_aset','kondisi', 'kuantitas', 'dari',
                        'tanggal_perolehan','no_dana','document_url','image_url','kd_klasifikasi_aset','kode_unor',
                        'warehouse_id','ruang_id','rak_id'
                    );

		foreach ($dataFields as $field) {
			$data[$field] = $this->input->post($field);
		}
                
                
                foreach($klasifikasiAsetFields as $field)
                {
                    $dataKlasifikasiAset[$field] =  $this->input->post($field);
                }
                if($dataKlasifikasiAset != '')
                {
                    $data['kd_klasifikasi_aset'] = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasiAset);
                }
                
                if($data['no_aset'] == null || $data['no_aset'] == "")
                {
                    $this->db->where('id',$data['id']);
                    $query = $this->db->get('asset_perlengkapan_sub_sub_part');
                    $result = $query->row();
                    if($query->num_rows === 0)
                    {
                        $data['no_aset'] = $this->noAssetGenerator($data['kd_brg'], $data['kd_lokasi']);
                    }
                    else
                    {
                        if($result->no_aset == null || $result->no_aset == "")
                        {
                            $data['no_aset'] = $this->noAssetGenerator($data['kd_brg'], $data['kd_lokasi']);
                        }
                        else
                        {
                            $data['no_aset'] = $result->no_aset;
                        }
                    }
                }
                
                $id = $data['id'];
                if($data["warehouse_id"] != "" && $data["warehouse_id"] != null)
                    {
                        if($data["warehouse_id"] > 0)
                        {
                            $data["id_sub_part"] = 0;
                        }
                    }
                    $this->db->set($data);
                    $this->db->replace('asset_perlengkapan_sub_sub_part');
                    $this->createLog('UPDATE ASSET PERLENGKAPAN SUB SUB PART [id='.$id.']','asset_perlengkapan_sub_sub_part');
                    echo "{success:true}";
        }
        
       function updateSubSubPart(){
            $data = json_decode($this->input->post('data'));
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                    $dataKlasifikasi = array(
                        'kd_lvl1'=>$row->kd_lvl1,
                        'kd_lvl2'=>$row->kd_lvl2,
                        'kd_lvl3'=>$row->kd_lvl3
                    );
                    $row->kd_klasifikasi_aset = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasi);
                    unset($row->kd_lvl1,$row->kd_lvl2,$row->kd_lvl3);
                    if($row->warehouse_id != "" && $row->warehouse_id != null)
                    {
                        if($row->warehouse_id > 0)
                        {
                            $row->id_sub_part = 0;
                        }
                    }
                    $this->db->set($row);
                    $this->db->replace('asset_perlengkapan_sub_sub_part');
                    $this->createLog('UPDATE ASSET PERLENGKAPAN SUB SUB PART [id='.$row->id.']','asset_perlengkapan_sub_sub_part');
                }
            }
            else
            {
                    $dataKlasifikasi = array(
                        'kd_lvl1'=>$data->kd_lvl1,
                        'kd_lvl2'=>$data->kd_lvl2,
                        'kd_lvl3'=>$data->kd_lvl3
                    );
                    $data->kd_klasifikasi_aset = $this->kodeKlasifikasiAsetGenerator($dataKlasifikasi);
                    unset($data->kd_lvl1,$data->kd_lvl2,$data->kd_lvl3);
                    if($data->warehouse_id != "" && $data->warehouse_id != null)
                    {
                        if($data->warehouse_id > 0)
                        {
                            $data->id_sub_part = 0;
                        }
                    }
                    $this->db->set($data);
                    $this->db->replace('asset_perlengkapan_sub_sub_part');
                    $this->createLog('UPDATE ASSET PERLENGKAPAN SUB SUB PART [id='.$data->id.']','asset_perlengkapan_sub_sub_part');
            }
            
            echo "{success:true}"; 
       }
       
       function destroySubSubPart2()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                $fail = array();
                $success = true;
                foreach($data as $deleted)
                {
                    $this->createLog('DELETE ASSET PERLENGKAPAN SUB SUB PART','asset_perlengkapan_sub_sub_part');
                    $deletedArray[] =$deleted['id'];
                }
                    
                     $this->db->where_in('id',$deletedArray);
		     $this->db->delete('asset_perlengkapan_sub_sub_part');
		
		
		$result = array('fail' => $fail,
                                'success'=>$success);
						
		echo json_encode($result);
	}
	
	function destroySubSubPart()
	{
            $data = json_decode($this->input->post('data'));

            $unattach = array(
                "id_sub_part" => 0,
            );
            if(count($data) > 1)
            {
                foreach($data as $row)
                {
                     $this->db->where('id',$row->id);
                     if(isset($row->warehouse_id))
                     {
                         $unattach["warehouse_id"] = $row->warehouse_id;
                         $unattach["ruang_id"] = $row->ruang_id;
                         $unattach["rak_id"] = $row->rak_id;
                     }
                     $this->db->update('asset_perlengkapan_sub_sub_part',$unattach);
//                    $this->db->delete('asset_perlengkapan_sub_sub_part', array('id' => $row->id));
//                    $this->createLog('DELETE ASSET PERLENGKAPAN SUB SUB PART [part='.$row->part_number.']','asset_perlengkapan_sub_sub_part');
                }
            }
            else
            {
                     $this->db->where('id',$data->id);
                     if(isset($data->warehouse_id))
                     {
                         $unattach["warehouse_id"] = $data->warehouse_id;
                         $unattach["ruang_id"] = $data->ruang_id;
                         $unattach["rak_id"] = $data->rak_id;
                     }
		     $this->db->update('asset_perlengkapan_sub_sub_part',$unattach);
//                    $this->db->delete('asset_perlengkapan_sub_sub_part', array('id' => $data->id));
//                    $this->createLog('DELETE ASSET PERLENGKAPAN SUB SUB PART [part='.$data->part_number.']','asset_perlengkapan_sub_sub_part');
            }
		    echo "{success:true}"; 
	}
        
        function getSpecificSubSubPart()
        {
           $id_sub_part = $this->input->post('id_sub_part');		
           $query = "select t.*,a.kd_lvl1,a.kd_lvl2,a.kd_lvl3 FROM asset_perlengkapan_sub_sub_part as t
               left join ref_klasifikasiaset_lvl3 as a on a.kd_klasifikasi_aset = t.kd_klasifikasi_aset
               where t.id_sub_part = '$id_sub_part'";
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
        
        function getNamaPartInduk()
        {
            $id = $this->input->post("id");
            $type = $this->input->post("type");
            if($type == "Part")
            {
                $query = $this->db->query("select nama from ref_perlengkapan as t 
                    INNER JOIN asset_perlengkapan as a on t.part_number = a.part_number
                    where a.id = $id");
                $result = $query->row();
                echo json_encode($result->nama);
            }
            else if($type == "SubPart")
            {
                $query = $this->db->query("select t.nama from asset_perlengkapan_sub_part as t 
                    INNER JOIN asset_perlengkapan_sub_sub_part as a on t.id = a.id_sub_part
                    where t.id = $id");
                $result = $query->row();
                echo json_encode($result->nama);
            }
            
        }
        
        function getNamaPartIndukByPartNumber()
        {
            $part_number = $this->input->post("part_number");
            $type = $this->input->post("type");
            if($type == "Part")
            {
                $query = $this->db->query("select nama from ref_perlengkapan
                    where part_number = '$part_number'");
                $result = $query->row();
                echo json_encode($result->nama);
            }
            else if($type == "SubPart")
            {
                $query = $this->db->query("select nama from ref_sub_part where part_number = '$part_number'");
                $result = $query->row();
                echo json_encode($result->nama);
            }
            
        }
}
?>