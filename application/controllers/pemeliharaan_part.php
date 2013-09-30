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
                $dataSimak = array();
	  	$simakFields = array(
			'id','id_pemeliharaan','id_penyimpanan','qty_pemeliharaan'
                );
                
                

		foreach ($simakFields as $field) {
			$dataSimak[$field] = $this->input->post($field);
		}
                
                $qty_awal= $this->input->post('qty');
                
                $this->db->where('id',$dataSimak['id_penyimpanan']);
                $query = $this->db->get('inventory_penyimpanan');
                $result = $query->row();
                
                
                $dataPenyimpanan = array(
                    'qty'=> $qty_awal - $dataSimak['qty_pemeliharaan']
                );
                
                /*UPDATE QTY IN PENYIMPANAN */
                $this->db->where('id',$dataSimak['id_penyimpanan']);
                $this->db->update('inventory_penyimpanan',$dataPenyimpanan);

                $this->modifyData($dataSimak, null);
	}
	
	function deletePemeliharaanPart()
	{
                $input_data = $this->input->post('data');
                
                foreach($input_data as $data)
                {
                    
                    $this->db->where('id',$data['id']);
                    $this->db->delete('pemeliharaan_part');
                    
                    //Return the quantity back to inventory_penyimpanan when deleted
                    $this->db->where('id',$data['id_penyimpanan']);
                    $penyimpanan_result = $this->db->get('inventory_penyimpanan');
                   if($penyimpanan_result->num_rows == 1)
                   {
                       $data_penyimpanan = $penyimpanan_result->row();
                       $qty_akhir = array( 
                           'qty'=>(int)$data_penyimpanan->qty + (int)$data['qty_pemeliharaan']
                               );
                       $this->db->where('id',$data['id_penyimpanan']);
                       $this->db->update('inventory_penyimpanan',$qty_akhir);
                               
                   }
                }
	}
	
	
	function getSpecificPemeliharaanPart()
	{
		$id_pemeliharaan = $this->input->post("id_pemeliharaan");
		$data = $this->model->get_PemeliharaanPart($id_pemeliharaan);
		$datasend["results"] = $data;
		echo json_encode($datasend);
	}
}
?>