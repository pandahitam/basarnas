<?php
class Pemeliharaan_Perlengkapan extends MY_Controller {


	function __construct() {
		parent::__construct();

 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pemeliharaan_Perlengkapan_Model','',TRUE);
		$this->model = $this->Pemeliharaan_Perlengkapan_Model;		
	}
	
	function index(){
//		if($this->input->post("id_open")){
//			$data['jsscript'] = TRUE;
//			$this->load->view('process_asset/pemeliharaan_view',$data);
//		}else{
//			$this->load->view('process_asset/pemeliharaan_view');
//		}
	}
	
	function modifyPemeliharaan(){
                $data = array();
                
	  	$fields = array(
                    'id', 'kd_brg', 'kd_lokasi', 'no_aset',
                    'kode_unker', 'kode_unor', 'jenis', 'nama', 
                    'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 
                    'kondisi', 'deskripsi', 'harga', 'kode_angaran', 
                    'unit_waktu', 'unit_pengunaan',
                    'freq_waktu', 'freq_pengunaan', 'status', 'durasi', 
                    'rencana_waktu', 'rencana_pengunaan', 'rencana_keterangan', 'alert', 
                    'document_url','image_url','umur','cycle'
                );
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 
                
//                if($data['nama'] == null || $data['nama'] == '')
//                {
//                    if($data['kd_brg'] != null || $data['kd_brg'] != '')
//                    {
//                        $this->db->where('kd_brg',$data['kd_brg']);
//                        $query = $this->db->get('ref_subsubkel');
//                        $result = $query->row();
////                        var_dump($result);
////                        die;
//                        if($query->num_rows > 0)
//                        {
//                            $data['nama'] = $result->ur_sskel;
//                        }
//                    }
//                    
//                }
                
                /*
                 * as of this time of writing this controller seems not yet updated
                 * with the latest structure like the one in asset inventaris
                 * therefore please uncomment the generasi of no_aset when changes had been made
                 */
                //GENERASI NO_ASET 
//                if($dataSimak['no_aset'] == null || $dataSimak['no_aset'] == "")
//                {
//                    $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'], $dataSimak['kd_lokasi']);
//                    $dataExt['no_aset'] = $dataSimak['no_aset'];
//                }
                
//		$this->modifyData(null,$data);
                
                if($data['id'] == '')
                {
                    $this->db->where('kd_brg',$data['kd_brg']);
                    $this->db->where('kd_lokasi',$data['kd_lokasi']);
                    $this->db->where('no_aset',$data['no_aset']);
                    $this->db->set('umur','umur -'.$data['umur'],false);
                    $this->db->update('asset_perlengkapan');
                    
                    $this->db->where('kd_brg',$data['kd_brg']);
                    $this->db->where('kd_lokasi',$data['kd_lokasi']);
                    $this->db->where('no_aset',$data['no_aset']);
                    $this->db->where('is_cycle',1);
                    $this->db->set('cycle','cycle -'.$data['cycle'],false);
                    $this->db->update('asset_perlengkapan');
                    
                    
                    
                    //update sub part and sub sub part
                    $this->db->query("update asset_perlengkapan_sub_part set umur= umur-".$data['umur']." 
                                 where id_part in (select id from asset_perlengkapan where 
                                 kd_brg = '".$data['kd_brg']."' AND
                                 kd_lokasi = '".$data['kd_lokasi']."' AND
                                 no_aset = '".$data['no_aset']."') ");
               
                    $this->db->query("update asset_perlengkapan_sub_part set cycle= cycle-".$data['cycle']." 
                                    where id_part in (select id from asset_perlengkapan where 
                                    kd_brg = '".$data['kd_brg']."' AND
                                    kd_lokasi = '".$data['kd_lokasi']."' AND
                                    no_aset = '".$data['no_aset']."')
                                    AND is_cycle = 1");

                    $this->db->query("update asset_perlengkapan_sub_sub_part set umur= umur-".$data['umur']." 
                                    where id_sub_part in (select id from asset_perlengkapan_sub_part where id_part in (select id from asset_perlengkapan where 
                                    kd_brg = '".$data['kd_brg']."' AND
                                    kd_lokasi = '".$data['kd_lokasi']."' AND
                                    no_aset = '".$data['no_aset']."')) ");

                    $this->db->query("update asset_perlengkapan_sub_sub_part set cycle= cycle-".$data['cycle']." 
                                    where id_sub_part in (select id from asset_perlengkapan_sub_part where id_part in (select id from asset_perlengkapan where 
                                    kd_brg = '".$data['kd_brg']."' AND
                                    kd_lokasi = '".$data['kd_lokasi']."' AND
                                    no_aset = '".$data['no_aset']."')) 
                                    AND is_cycle = 1");
                    
                    
                    
                    $this->db->insert('pemeliharaan_perlengkapan',$data);
                    $id = $this->db->insert_id();
                    $this->createLog('INSERT PEMELIHARAAN PERLENGKAPAN','pemeliharaan_perlengkapan');
                }
                else
                {
                    $id = $data['id'];
                    $this->db->set($data);
                    $this->db->replace('pemeliharaan_perlengkapan');
                    $this->createLog('UPDATE PEMELIHARAAN PERLENGKAPAN','pemeliharaan_perlengkapan');
                }
                echo "{success:true, id:$id}";
	}
	
	function deletePemeliharaan()
	{
		$data = $this->input->post('data');
                foreach($data as $dataContent)
                {
                    $this->db->query("update asset_perlengkapan set umur=umur+".$dataContent['umur']." where
                        kd_lokasi='".$dataContent['kd_lokasi']."' AND
                        kd_brg='".$dataContent['kd_brg']."' AND
                        no_aset='".$dataContent['no_aset']."'");
                    $this->db->query("update asset_perlengkapan set cycle=cycle+".$dataContent['cycle']." where
                        kd_lokasi='".$dataContent['kd_lokasi']."' AND
                        kd_brg='".$dataContent['kd_brg']."' AND
                        no_aset='".$dataContent['no_aset']."' AND is_cycle = 1");
                    
                    //update sub part and sub sub part
                    $this->db->query("update asset_perlengkapan_sub_part set umur= umur+".$dataContent['umur']." 
                                 where id_part in (select id from asset_perlengkapan where 
                                 kd_brg = '".$dataContent['kd_brg']."' AND
                                 kd_lokasi = '".$dataContent['kd_lokasi']."' AND
                                 no_aset = '".$dataContent['no_aset']."') ");
               
                    $this->db->query("update asset_perlengkapan_sub_part set cycle= cycle+".$dataContent['cycle']." 
                                    where id_part in (select id from asset_perlengkapan where 
                                    kd_brg = '".$dataContent['kd_brg']."' AND
                                    kd_lokasi = '".$dataContent['kd_lokasi']."' AND
                                    no_aset = '".$dataContent['no_aset']."')
                                    AND is_cycle = 1");

                    $this->db->query("update asset_perlengkapan_sub_sub_part set umur= umur+".$dataContent['umur']." 
                                    where id_sub_part in (select id from asset_perlengkapan_sub_part where id_part in (select id from asset_perlengkapan where 
                                    kd_brg = '".$dataContent['kd_brg']."' AND
                                    kd_lokasi = '".$dataContent['kd_lokasi']."' AND
                                    no_aset = '".$dataContent['no_aset']."')) ");

                    $this->db->query("update asset_perlengkapan_sub_sub_part set cycle= cycle+".$dataContent['cycle']." 
                                    where id_sub_part in (select id from asset_perlengkapan_sub_part where id_part in (select id from asset_perlengkapan where 
                                    kd_brg = '".$dataContent['kd_brg']."' AND
                                    kd_lokasi = '".$dataContent['kd_lokasi']."' AND
                                    no_aset = '".$dataContent['no_aset']."')) 
                                    AND is_cycle = 1");
                    
                    $this->createLog('DELETE PEMELIHARAAN PERLENGKAPAN','pemeliharaan_perlengkapan');
                }
		return $this->deleteProcess($data);
	}
	
	
	function getSpecificPemeliharaan()
	{
		$kd_lokasi = $this->input->post("kd_lokasi");
		$kd_brg = $this->input->post("kd_brg");
		$no_aset = $this->input->post("no_aset");
		$data = $this->model->get_Pemeliharaan($kd_lokasi, $kd_brg, $no_aset);
		$datasend["results"] = $data['data'];
                $datasend["total"] = $data['count'];
		echo json_encode($datasend);
	}
        
        function getLatestUmur()
        {
            $kd_lokasi = $this->input->post("kd_lokasi");
            $kd_brg = $this->input->post("kd_brg");
            $no_aset = $this->input->post("no_aset");
            $this->db->where('kd_lokasi',$kd_lokasi);
            $this->db->where('kd_brg',$kd_brg);
            $this->db->where('no_aset',$no_aset);
            $query = $this->db->get('asset_perlengkapan');
            $result = array();
            $result["cycle"] = $query->row()->cycle;
            $result["umur"] = $query->row()->umur;
            echo json_encode($result);
        }
        
        function modifyPemeliharaanSubPart(){
                $data = array();
	  	$fields = array(
                    'id', 'jenis', 'nama', 'id_sub_part','part_number',
                    'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 
                    'kondisi', 'deskripsi', 'harga', 'kode_angaran', 
                    'unit_waktu', 'unit_pengunaan',
                    'freq_waktu', 'freq_pengunaan', 'status', 'durasi', 
                    'rencana_waktu', 'rencana_pengunaan', 'rencana_keterangan', 'alert', 
                    'document_url','image_url','umur','cycle'
                );
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 
                
//                if($data['nama'] == null || $data['nama'] == '')
//                {
//                    if($data['kd_brg'] != null || $data['kd_brg'] != '')
//                    {
//                        $this->db->where('kd_brg',$data['kd_brg']);
//                        $query = $this->db->get('ref_subsubkel');
//                        $result = $query->row();
////                        var_dump($result);
////                        die;
//                        if($query->num_rows > 0)
//                        {
//                            $data['nama'] = $result->ur_sskel;
//                        }
//                    }
//                    
//                }
                
                /*
                 * as of this time of writing this controller seems not yet updated
                 * with the latest structure like the one in asset inventaris
                 * therefore please uncomment the generasi of no_aset when changes had been made
                 */
                //GENERASI NO_ASET 
//                if($dataSimak['no_aset'] == null || $dataSimak['no_aset'] == "")
//                {
//                    $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'], $dataSimak['kd_lokasi']);
//                    $dataExt['no_aset'] = $dataSimak['no_aset'];
//                }
                
//		$this->modifyData(null,$data);
                
                if($data['id'] == '')
                {
                    $this->db->where('id',$data['id_sub_part']);
                    $this->db->set('umur','umur -'.$data['umur'],false);
                    $this->db->update('asset_perlengkapan_sub_part');
                    
                    $this->db->where('id',$data['id_sub_part']);
                    $this->db->where('is_cycle',1);
                    $this->db->set('cycle','cycle -'.$data['cycle'],false);
                    $this->db->update('asset_perlengkapan_sub_part');
                    
                    //update sub sub part
                     $this->db->query("update asset_perlengkapan_sub_sub_part set umur= umur-".$data['umur']." 
                                    where id_sub_part ='".$data['id_sub_part']."'");

                    $this->db->query("update asset_perlengkapan_sub_sub_part set cycle= cycle-".$data['cycle']." 
                                    where id_sub_part ='".$data['id_sub_part']."'
                                    AND is_cycle=1");
                    
                    $this->db->insert('pemeliharaan_perlengkapan_sub_part',$data);
                    $id = $this->db->insert_id();
                    $this->createLog('INSERT PEMELIHARAAN PERLENGKAPAN SUB PART','pemeliharaan_perlengkapan_sub_part');
                }
                else
                {
                    $id = $data['id'];
                    $this->db->set($data);
                    $this->db->replace('pemeliharaan_perlengkapan_sub_part');
                    $this->createLog('UPDATE PEMELIHARAAN PERLENGKAPAN SUB PART','pemeliharaan_perlengkapan_sub_part');
                }
                echo "{success:true, id:$id}";
	}
	
	function deletePemeliharaanSubPart()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                $fail = array();
                $success = true;
                foreach($data as $deleted)
                {
                    $this->db->query("update asset_perlengkapan_sub_part set umur=umur+".$deleted['umur']." where
                        id='".$deleted['id_sub_part']."'");
                    
                    $this->db->query("update asset_perlengkapan_sub_part set cycle=cycle+".$deleted['cycle']." where
                        id='".$deleted['id_sub_part']."' AND is_cycle = 1");
                    
                    
                    $this->db->query("update asset_perlengkapan_sub_sub_part set umur= umur+".$deleted['umur']." 
                                    where id_sub_part ='".$deleted['id_sub_part']."' ");

                    $this->db->query("update asset_perlengkapan_sub_sub_part set cycle= cycle+".$deleted['cycle']." 
                                    where id_sub_part ='".$deleted['id_sub_part']."' 
                                    AND is_cycle = 1");
                    
                    $this->createLog('DELETE PEMELIHARAAN PERLENGKAPAN SUB PART','pemeliharaan_perlengkapan_sub_part');
                    $deletedArray[] =$deleted['id'];
                }
                    
                     $this->db->where_in('id',$deletedArray);
		     $this->db->delete('pemeliharaan_perlengkapan_sub_part');
		
		
		$result = array('fail' => $fail,
                                'success'=>$success);
						
		echo json_encode($result);
	}
	
	
	function getSpecificPemeliharaanSubPart()
	{
           $id_part = $this->input->post('id');		
           $query = "select * FROM pemeliharaan_perlengkapan_sub_part where id_sub_part IN(select id from asset_perlengkapan_sub_part where id_part = '$id_part')";
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
        
        function getSpecificPemeliharaanSubPart2()
	{
           $id = $this->input->post('id');		
           $query = "select * FROM pemeliharaan_perlengkapan_sub_part where id_sub_part = '$id'";
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
        
        function modifyPemeliharaanSubSubPart(){
                $data = array();

	  	$fields = array(
                    'id', 'jenis', 'nama', 'id_sub_sub_part','part_number',
                    'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 
                    'kondisi', 'deskripsi', 'harga', 'kode_angaran', 
                    'unit_waktu', 'unit_pengunaan',
                    'freq_waktu', 'freq_pengunaan', 'status', 'durasi', 
                    'rencana_waktu', 'rencana_pengunaan', 'rencana_keterangan', 'alert', 
                    'document_url','image_url','umur','cycle'
                );
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 

                
                if($data['id'] == '')
                {
                    $this->db->where('id',$data['id_sub_sub_part']);
                    $this->db->set('umur','umur -'.$data['umur'],false);
                    $this->db->update('asset_perlengkapan_sub_sub_part');
                    
                    $this->db->where('id',$data['id_sub_sub_part']);
                    $this->db->where('is_cycle',1);
                    $this->db->set('cycle','cycle -'.$data['cycle'],false);
                    $this->db->update('asset_perlengkapan_sub_sub_part');
                    
                    $this->db->insert('pemeliharaan_perlengkapan_sub_sub_part',$data);
                    $id = $this->db->insert_id();
                    $this->createLog('INSERT PEMELIHARAAN PERLENGKAPAN SUB SUB PART','pemeliharaan_perlengkapan_sub_sub_part');
                }
                else
                {
                    $id = $data['id'];
                    $this->db->set($data);
                    $this->db->replace('pemeliharaan_perlengkapan_sub_sub_part');
                    $this->createLog('UPDATE PEMELIHARAAN PERLENGKAPAN SUB SUB PART','pemeliharaan_perlengkapan_sub_sub_part');
                }
                echo "{success:true, id:$id}";
	}
	
	function deletePemeliharaanSubSubPart()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                $fail = array();
                $success = true;
                foreach($data as $deleted)
                {
                    $this->db->query("update asset_perlengkapan_sub_sub_part set umur=umur+".$deleted['umur']." where
                        id='".$deleted['id_sub_sub_part']."'");
                    
                    $this->db->query("update asset_perlengkapan_sub_sub_part set cycle=cycle+".$deleted['cycle']." where
                        id='".$deleted['id_sub_sub_part']."' AND is_cycle = 1");
                    
                    $this->createLog('DELETE PEMELIHARAAN PERLENGKAPAN SUB SUB PART','pemeliharaan_perlengkapan_sub_sub_part');
                    $deletedArray[] =$deleted['id'];
                }
                    
                     $this->db->where_in('id',$deletedArray);
		     $this->db->delete('pemeliharaan_perlengkapan_sub_sub_part');
		
		
		$result = array('fail' => $fail,
                                'success'=>$success);
						
		echo json_encode($result);
	}
	
	
	function getSpecificPemeliharaanSubSubPart()
	{
           $id_part = $this->input->post('id');		
           $query = "SELECT t.*, a.id_sub_part FROM pemeliharaan_perlengkapan_sub_sub_part AS t
                INNER JOIN asset_perlengkapan_sub_sub_part AS a ON a.id = t.id_sub_sub_part
                where id_sub_sub_part 
               IN(select id from asset_perlengkapan_sub_sub_part where id_sub_part 
               IN(select id from asset_perlengkapan_sub_part where id_part = '$id_part'))";
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
        
        function getSpecificPemeliharaanSubSubPart2()
	{
           $id = $this->input->post('id');		
           $query = "SELECT * FROM pemeliharaan_perlengkapan_sub_sub_part where id_sub_sub_part = '$id'";
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