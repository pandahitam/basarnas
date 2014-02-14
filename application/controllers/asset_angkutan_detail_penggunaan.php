<?php
class Asset_Angkutan_Detail_Penggunaan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    	}
		$this->load->model('Asset_Angkutan_Detail_Penggunaan_Model','',TRUE);
		$this->model = $this->Asset_Angkutan_Detail_Penggunaan_Model;		
	}
        
        function getSpecificDetailPenggunaanAngkutan()
        {
            if($_POST['open'] == 1)
            {
                $data = $this->model->getSpecificDetailPenggunaanAngkutan($_POST['id_ext_asset']);
                //                $total = $this->model->get_CountData();
                $dataSend['total'] = $data['count'];
		$dataSend['results'] = $data['data'];
		echo json_encode($dataSend);
                
            }
        }
        
        function modifyDetailPenggunaanAngkutanDarat()
        {
            $dataPenggunaan = array();
            $dataPenggunaanFields = array(
                'id','id_ext_asset','tanggal','jumlah_penggunaan','satuan_penggunaan','keterangan'
            );
            
            foreach ($dataPenggunaanFields as $field) {
			$dataPenggunaan[$field] = $this->input->post($field);
            }
                $this->db->set($dataPenggunaan);
                $this->db->replace('ext_asset_angkutan_detail_penggunaan');
            
           if($dataPenggunaan['id'] != '')
           {
               $this->createLog('UPDATE DETAIL PENGGUNAAN ANGKUTAN [id_ext_asset='.$dataPenggunaan['id'].']','ext_asset_angkutan_detail_penggunaan');
           }
           else
           {
               $penggunaan = (double)0;
               $satuan_penggunaan = $dataPenggunaan['satuan_penggunaan'];
                if($satuan_penggunaan == 1) //satuan in meter
                {
                    $penggunaan = (double)$dataPenggunaan['jumlah_penggunaan']/(double)1000;

                }
                else if($satuan_penggunaan == 2) //satuan in km
                {
                    $penggunaan = (double)$dataPenggunaan['jumlah_penggunaan'];
                }
                else if($satuan_penggunaan == 3) //satuan in mil
                {
                    $penggunaan = (double)$dataPenggunaan['jumlah_penggunaan'] * (double)1.60934;
                }
               $this->db->query("update asset_perlengkapan set umur= umur+".$penggunaan." 
                                 where id in (select id_asset_perlengkapan from ext_asset_angkutan_darat_perlengkapan where id_ext_asset =".$dataPenggunaan['id_ext_asset']." ) ");
               $this->createLog('INSERT DETAIL PENGGUNAAN ANGKUTAN [id_ext_asset='.$dataPenggunaan['id'].']','ext_asset_angkutan_detail_penggunaan');
           }
               
        }
        
        function deleteDetailPenggunaanAngkutanDarat()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                foreach($data as $deleted)
                {
                    $this->createLog('DELETE DETAIL PENGGUNAAN ANGKUTAN [id_ext_asset='.$deleted['id_ext_asset'].']','ext_asset_angkutan_detail_penggunaan');
                    $penggunaan = (double)0;
                    $satuan_penggunaan = $deleted['satuan_penggunaan'];
                     if($satuan_penggunaan == 1) //satuan in meter
                     {
                         $penggunaan = (double)$deleted['jumlah_penggunaan']/(double)1000;

                     }
                     else if($satuan_penggunaan == 2) //satuan in km
                     {
                         $penggunaan = (double)$deleted['jumlah_penggunaan'];
                     }
                     else if($satuan_penggunaan == 3) //satuan in mil
                     {
                         $penggunaan = (double)$deleted['jumlah_penggunaan'] * (double)1.60934;
                     }
                    $this->db->query("update asset_perlengkapan set umur= umur-".$penggunaan." 
                                 where id in (select id_asset_perlengkapan from ext_asset_angkutan_darat_perlengkapan where id_ext_asset =".$deleted['id_ext_asset']." ) ");
                    $deletedArray[] =$deleted['id'];
                }
                $this->db->where_in('id',$deletedArray);
                
		$this->db->delete('ext_asset_angkutan_detail_penggunaan');
	}
	
        function modifyDetailPenggunaanAngkutanLaut()
        {
            $dataPenggunaan = array();
            $dataPenggunaanFields = array(
                'id','id_ext_asset','tanggal','jumlah_penggunaan','satuan_penggunaan','keterangan'
            );
            
            foreach ($dataPenggunaanFields as $field) {
			$dataPenggunaan[$field] = $this->input->post($field);
            }
                $this->db->set($dataPenggunaan);
                $this->db->replace('ext_asset_angkutan_detail_penggunaan');
            
           if($dataPenggunaan['id'] != '')
           {
               $this->createLog('UPDATE DETAIL PENGGUNAAN ANGKUTAN [id_ext_asset='.$dataPenggunaan['id'].']','ext_asset_angkutan_detail_penggunaan');
           }
           else
           {
               $this->db->query("update asset_perlengkapan set umur= umur+".$dataPenggunaan['jumlah_penggunaan']." 
                                 where id in (select id_asset_perlengkapan from ext_asset_angkutan_laut_perlengkapan where id_ext_asset =".$dataPenggunaan['id_ext_asset']." ) ");
               $this->createLog('INSERT DETAIL PENGGUNAAN ANGKUTAN [id_ext_asset='.$dataPenggunaan['id'].']','ext_asset_angkutan_detail_penggunaan');
           }
               
        }
        
        function deleteDetailPenggunaanAngkutanLaut()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                foreach($data as $deleted)
                {
                    $this->createLog('DELETE DETAIL PENGGUNAAN ANGKUTAN [id_ext_asset='.$deleted['id_ext_asset'].']','ext_asset_angkutan_detail_penggunaan');
                    $this->db->query("update asset_perlengkapan set umur= umur-".$deleted['jumlah_penggunaan']." 
                                 where id in (select id_asset_perlengkapan from ext_asset_angkutan_laut_perlengkapan where id_ext_asset =".$deleted['id_ext_asset']." ) ");
                    $deletedArray[] =$deleted['id'];
                }
                $this->db->where_in('id',$deletedArray);
                
		$this->db->delete('ext_asset_angkutan_detail_penggunaan');
	}
        
        function getSpecificDetailPenggunaanAngkutanUdara()
        {
            if($_POST['open'] == 1)
            {
                $data = $this->model->getSpecificDetailPenggunaanAngkutanUdara($_POST['id_ext_asset']);
                //                $total = $this->model->get_CountData();
                $dataSend['total'] = $data['count'];
		$dataSend['results'] = $data['data'];
		echo json_encode($dataSend);
                
            }
        }
        
        function modifyDetailPenggunaanAngkutanUdara()
        {
            $dataPenggunaan = array();
            $dataPenggunaanFields = array(
                'id','id_ext_asset','tanggal','jumlah_penggunaan','satuan_penggunaan','keterangan','jumlah_cycle'
            );
            
            foreach ($dataPenggunaanFields as $field) {
			$dataPenggunaan[$field] = $this->input->post($field);
            }
                $this->db->set($dataPenggunaan);
                $this->db->replace("ext_asset_angkutan_udara_detail_penggunaan");
           if($dataPenggunaan['id'] != '')
           {
               $this->createLog('UPDATE DETAIL PENGGUNAAN ANGKUTAN [id_ext_asset='.$dataPenggunaan['id'].']','ext_asset_angkutan_udara_detail_penggunaan');
           }
           else
           {
               $this->db->query("update asset_perlengkapan set umur= umur+".$dataPenggunaan['jumlah_penggunaan']." 
                                 where id in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$dataPenggunaan['id_ext_asset']." ) ");
               
               $this->db->query("update asset_perlengkapan set cycle= cycle+".$dataPenggunaan['jumlah_cycle']." 
                                 where id in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$dataPenggunaan['id_ext_asset']." )
                                 AND is_cycle = 1");
               
               $this->db->query("update asset_perlengkapan_sub_part set umur= umur+".$dataPenggunaan['jumlah_penggunaan']." 
                                 where id_part in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$dataPenggunaan['id_ext_asset']." ) ");
               
               $this->db->query("update asset_perlengkapan_sub_part set cycle= cycle+".$dataPenggunaan['jumlah_cycle']." 
                                 where id_part in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$dataPenggunaan['id_ext_asset']." )
                                 AND is_cycle = 1");
               
               $this->db->query("update asset_perlengkapan_sub_sub_part set umur= umur+".$dataPenggunaan['jumlah_penggunaan']." 
                                 where id_sub_part in (select id from asset_perlengkapan_sub_part where id_part in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$dataPenggunaan['id_ext_asset']." )) ");
               
               $this->db->query("update asset_perlengkapan_sub_sub_part set cycle= cycle+".$dataPenggunaan['jumlah_cycle']." 
                                 where id_sub_part in (select id from asset_perlengkapan_sub_part where id_part in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$dataPenggunaan['id_ext_asset']." )) 
                                 AND is_cycle = 1");
               
               $this->db->query("update ext_asset_angkutan set udara_umur_pesawat = udara_umur_pesawat+".$dataPenggunaan['jumlah_penggunaan']." where id = ".$dataPenggunaan['id_ext_asset']) ;
               
               $this->createLog('INSERT DETAIL PENGGUNAAN ANGKUTAN [id_ext_asset='.$dataPenggunaan['id'].']','ext_asset_angkutan_udara_detail_penggunaan');
           }
               
        }
        
        function deleteDetailPenggunaanAngkutanUdara()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                foreach($data as $deleted)
                {
                    $this->createLog('DELETE DETAIL PENGGUNAAN ANGKUTAN [id_ext_asset='.$deleted['id_ext_asset'].']','ext_asset_angkutan_detail_penggunaan');
                     $this->db->query("update asset_perlengkapan set umur= umur-".$deleted['jumlah_penggunaan']." 
                                 where id in (select id_asset_perlengkapan from ext_asset_angkutan_laut_perlengkapan where id_ext_asset =".$deleted['id_ext_asset']." ) ");
                     $this->db->query("update asset_perlengkapan set cycle= cycle-".$deleted['jumlah_cycle']." 
                                 where id in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$deleted['id_ext_asset']." )
                                 AND is_cycle = 1");
               
                    $this->db->query("update asset_perlengkapan_sub_part set umur= umur-".$deleted['jumlah_penggunaan']." 
                                      where id_part in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$deleted['id_ext_asset']." ) ");

                    $this->db->query("update asset_perlengkapan_sub_part set cycle= cycle-".$deleted['jumlah_cycle']." 
                                      where id_part in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$deleted['id_ext_asset']." )
                                      AND is_cycle = 1");

                    $this->db->query("update asset_perlengkapan_sub_sub_part set umur= umur-".$deleted['jumlah_penggunaan']." 
                                      where id_sub_part in (select id from asset_perlengkapan_sub_part where id_part in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$deleted['id_ext_asset']." )) ");

                    $this->db->query("update asset_perlengkapan_sub_sub_part set cycle= cycle-".$deleted['jumlah_cycle']." 
                                      where id_sub_part in (select id from asset_perlengkapan_sub_part where id_part in (select id_asset_perlengkapan from ext_asset_angkutan_udara_perlengkapan where id_ext_asset =".$deleted['id_ext_asset']." )) 
                                      AND is_cycle = 1");
                    
                    $this->db->query("update ext_asset_angkutan set udara_umur_pesawat = udara_umur_pesawat-".$deleted['jumlah_penggunaan']." where id = ".$deleted['id_ext_asset']) ;
                    
                    $deletedArray[] =$deleted['id'];
                }
                $this->db->where_in('id',$deletedArray);
                
		$this->db->delete("ext_asset_angkutan_udara_detail_penggunaan");
	}
        
        function getTotalPenggunaanAngkutanUdara()
        {
            $receivedData = array(
              'tipe_angkutan'=>$_POST['tipe_angkutan'],
              'id_ext_asset'=>$_POST['id_ext_asset'],
            );
            
            $queryMesin = $this->db->query("select SUM(jumlah_penggunaan) AS jumlah_penggunaan
                                FROM ext_asset_angkutan_udara_detail_penggunaan
                                where id_ext_asset =".$receivedData['id_ext_asset']);
//            $queryInisialisaiMesin = $this->db->query("select udara_inisialisasi_mesin1, udara_inisialisasi_mesin2
//                                                       FROM ext_asset_angkutan where id =".$receivedData['id_ext_asset']);
//            $queryMesin2 = $this->db->query("SELECT SUM(jumlah_penggunaan) AS jumlah_penggunaan_mesin2
//                                FROM ext_asset_angkutan_udara_detail_penggunaan_mesin2
//                                where id_ext_asset =".$receivedData['id_ext_asset']);
            $resultMesin = $queryMesin->row();
//            $resultInisialisasi = $queryInisialisaiMesin->row();
//            $resultMesin2 = $queryMesin2->row();
//            $totalPenggunaanMesin1 = $resultMesin1->jumlah_penggunaan_mesin1;
//            $totalPenggunaanMesin2 = $resultMesin2->jumlah_penggunaan_mesin2;
              $totalPenggunaan = $resultMesin->jumlah_penggunaan;
            
            
//            $sendData = array(
//                    'total_mesin1' => (int)$totalPenggunaan + (int)$resultInisialisasi->udara_inisialisasi_mesin1,
//                    'total_mesin2' =>(int)$totalPenggunaan + (int)$resultInisialisasi->udara_inisialisasi_mesin2,
//                    'status' => 'success'
//                    );
              $sendData = array(
                    'total_mesin1' => (int)$totalPenggunaan,
                    'total_mesin2' =>(int)$totalPenggunaan,
                    'status' => 'success'
                    );
              
//              $sendData = array(
//                    'total_penggunaan' => $totalPenggunaan,
//                    'status' => 'success'
//                    );
            echo json_encode($sendData);
        }
        
        
        function getTotalPenggunaan()
        {
            $receivedData = array(
              'tipe_angkutan'=>$_POST['tipe_angkutan'],
              'id_ext_asset'=>$_POST['id_ext_asset'],
            );
            
            $query = $this->db->query("select jumlah_penggunaan, satuan_penggunaan 
                                from ext_asset_angkutan_detail_penggunaan
                                where id_ext_asset =".$receivedData['id_ext_asset']);
           
           $this->calculateTotalPenggunaan($receivedData, $query);
        }
        
        function getTotalPenggunaanWithoudIdExtAsset()
        {
            
            $receivedData = array(
              'tipe_angkutan'=>$_POST['tipe_angkutan'],
              'kd_brg'=>$_POST['kd_brg'],
              'kd_lokasi'=>$_POST['kd_lokasi'],
              'no_aset'=>$_POST['no_aset'],
            );
            if($_POST['tipe_angkutan'] == 'udara')
            {
                
                $query = $this->db->query("select id 
                                from ext_asset_angkutan as a
                                LEFT JOIN asset_angkutan as c on a.kd_lokasi = c.kd_lokasi AND a.kd_brg=c.kd_brg AND a.no_aset = c.no_aset
                                where c.kd_brg ='".$receivedData['kd_brg']."' AND c.kd_lokasi='".$receivedData['kd_lokasi']."' AND c.no_aset ='".$receivedData['no_aset']."'");
                $result_query = $query->row();
                
                $queryMesin = $this->db->query("select SUM(jumlah_penggunaan) AS jumlah_penggunaan
                                FROM ext_asset_angkutan_udara_detail_penggunaan
                                where id_ext_asset =".$result_query->id);
                $queryInisialisaiMesin = $this->db->query("select udara_inisialisasi_mesin1, udara_inisialisasi_mesin2
                                                       FROM ext_asset_angkutan where id =".$result_query->id);
                $resultMesin = $queryMesin->row();
                $resultInisialisasi = $queryInisialisaiMesin->row();
                $totalPenggunaan = $resultMesin->jumlah_penggunaan;

                $sendData = array(
                        'total_mesin1' => (int)$totalPenggunaan + (int)$resultInisialisasi->udara_inisialisasi_mesin1,
                        'total_mesin2' =>(int)$totalPenggunaan + (int)$resultInisialisasi->udara_inisialisasi_mesin2,
                        'status' => 'success'
                        );
                echo json_encode($sendData);
            }
            else
            {
                $query = $this->db->query("select jumlah_penggunaan, satuan_penggunaan 
                                from ext_asset_angkutan_detail_penggunaan as t
                                LEFT JOIN ext_asset_angkutan as a on t.id_ext_asset = a.id
                                LEFT JOIN asset_angkutan as c on a.kd_lokasi = c.kd_lokasi AND a.kd_brg=c.kd_brg AND a.no_aset = c.no_aset
                                where c.kd_brg ='".$receivedData['kd_brg']."' AND c.kd_lokasi='".$receivedData['kd_lokasi']."' AND c.no_aset ='".$receivedData['no_aset']."'");
            
                $this->calculateTotalPenggunaan($receivedData, $query);
            }
            
        }
        
        
        function calculateTotalPenggunaan($receivedData,$query)
        {
            $totalPenggunaan = (double)0;
             
            if($receivedData['tipe_angkutan'] == 'darat')
            {
                
               
                if($query->num_rows() > 0 )
                {
                    //start value conversion to km
                    foreach($query->result() as $row)
                    {
                        if($row->satuan_penggunaan == 1) //satuan in meter
                        {
                            $value = (double)$row->jumlah_penggunaan/(double)1000;
                            $totalPenggunaan += (double)$value;
                            
                        }
                        else if($row->satuan_penggunaan == 2) //satuan in km
                        {
                            $value = (double)$row->jumlah_penggunaan;
                            $totalPenggunaan += (double)$value;
                        }
                        else if($row->satuan_penggunaan == 3) //satuan in mil
                        {
                            $value = (double)$row->jumlah_penggunaan * (double)1.60934;
                            $totalPenggunaan += (double)$value;
                        }
                    }
                    
                }
                
            }
            else if($receivedData['tipe_angkutan'] == 'laut')
            {
                foreach($query->result() as $row)
                {
                    $totalPenggunaan += $row->jumlah_penggunaan;
                }
                
            }
            
             $sendData = array(
                        'total' => $totalPenggunaan,
                        'status' => 'success'
                        );
            
            
            echo json_encode($sendData);
        }
}
?>