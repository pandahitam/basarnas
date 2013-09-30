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
//                $dataSend['total'] = $total;
		$dataSend['results'] = $data;
		echo json_encode($dataSend);
                
            }
        }
	
        function modifyDetailPenggunaanAngkutan()
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
               
        }
        
        function deleteDetailPenggunaanAngkutan()
	{
		$data = $this->input->post('data');
                $deletedArray = array();
                foreach($data as $deleted)
                {
                    $deletedArray[] =$deleted['id'];
                }
                $this->db->where_in('id',$deletedArray);
                
		$this->db->delete('ext_asset_angkutan_detail_penggunaan');
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
            
            $query = $this->db->query("select jumlah_penggunaan, satuan_penggunaan 
                                from ext_asset_angkutan_detail_penggunaan as t
                                LEFT JOIN ext_asset_angkutan as a on t.id_ext_asset = a.id
                                LEFT JOIN asset_angkutan as c on a.kd_lokasi = c.kd_lokasi AND a.kd_brg=c.kd_brg AND a.no_aset = c.no_aset
                                where c.kd_brg ='".$receivedData['kd_brg']."' AND c.kd_lokasi='".$receivedData['kd_lokasi']."' AND c.no_aset ='".$receivedData['no_aset']."'");
            
            $this->calculateTotalPenggunaan($receivedData, $query);
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
            else if($receivedData['tipe_angkutan'] == 'laut' || $receivedData['tipe_angkutan'] == 'udara')
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