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
	
}
?>