<?php
class inventory_penyimpanan extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
		$this->load->model('Inventory_Penyimpanan_Model','',TRUE);
		$this->model = $this->Inventory_Penyimpanan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('inventory/penyimpanan_view',$data);
		}else{
			$this->load->view('inventory/penyimpanan_view');
		}
	}
	
	function modifyInventoryPenyimpanan(){
		$dataSimak = array();
                
                $simakFields = array(
			'id','tgl_berita_acara','nomor_berita_acara','kd_lokasi','id_penerimaan_pemeriksaan','nama_org',
                                        'date_created',
                                        'keterangan','tgl_penyimpanan',
                );
                
		foreach ($simakFields as $field) {
			$dataSimak[$field] = $this->input->post($field);
		}
//                
//		$this->modifyData($dataSimak, null);
                
                if($dataSimak['id'] == '')
                {
                    $this->db->insert('inventory_penyimpanan',$dataSimak);
                    $id = $this->db->insert_id();
                    
                }
                else
                {
                    $id = $dataSimak['id'];
                    $this->db->set($dataSimak);
                    $this->db->replace('inventory_penyimpanan');
                }
                echo "{success:true, id:$id}";
	}
	
	function deleteInventoryPenyimpanan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
        
        function getSpecificInventoryPenyimpanan()
        {
            $id = $this->input->post('id');
            $result = $this->model->get_InventoryPenyimpanan($id);
            echo json_encode($result);
        }
        
        function checkServerQuantity()
        {
            $data = $this->input->post('data');
            $check_result = array();
            $i = 0;
            foreach($data as $row)
            {
                $check_result[] = $this->model->checkServerQuantity($row['id_penyimpanan_data_perlengkapan'],$row['qty_keluar'],$row['id_penyimpanan']);
                if($check_result[$i] === true)
                {
                    echo "pass";
                    die;
                }
                else
                {
                    if($check_result[$i] === false)
                    {
                        echo "Error pada server. Harap coba lagi atau hubungi teknisi";
                        die;
                    }
                }
                $i++;
            }
            
            echo json_encode($check_result);
        }
}
?>