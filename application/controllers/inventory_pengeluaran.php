<?php
class inventory_pengeluaran extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
		$this->load->model('Inventory_Pengeluaran_Model','',TRUE);
		$this->model = $this->Inventory_Pengeluaran_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('inventory/pengeluaran_view',$data);
		}else{
			$this->load->view('inventory/pengeluaran_view');
		}
	}
	
	function modifyInventoryPengeluaran(){
                
//                var_dump($_POST);
//                die;
		$dataSimak = array();
	  	$simakFields = array(
			'id','tgl_berita_acara','nomor_berita_acara','kd_lokasi','nama_org',
                        'date_created',
                        'keterangan','kode_unor',
                        'tgl_pengeluaran','kode_unor'
                );
                
                

		foreach ($simakFields as $field) {
			$dataSimak[$field] = $this->input->post($field);
		}
                
//                $dataPenyimpanan = array(
//                    'qty'=> $dataSimak['qty'] - $dataSimak['qty_barang_keluar']
//                );
//                
//                /*UPDATE QTY IN PENYIMPANAN */
//                $this->db->where('id',$dataSimak['id_penyimpanan']);
//                $this->db->update('inventory_penyimpanan',$dataPenyimpanan);
//
//                $this->modifyData($dataSimak, null);
                
                if($dataSimak['id'] == '')
                {
                    $this->db->insert('inventory_pengeluaran',$dataSimak);
                    $id = $this->db->insert_id();
                    $this->createLog('INSERT INVENTORY PENGELUARAN','inventory_pengeluaran');
                }
                else
                {
                    $id = $dataSimak['id'];
                    $this->db->set($dataSimak);
                    $this->db->replace('inventory_pengeluaran');
                    $this->createLog('UPDATE INVENTORY PENGELUARAN','inventory_pengeluaran');
                }
                echo "{success:true, id:$id}";
                
	}
	
	function deleteInventoryPengeluaran()
	{
            $input_data = $this->input->post('data');
            foreach($input_data as $data)
            {
                $this->createLog('DELETE INVENTORY PENGELUARAN','inventory_pengeluaran');
                //Return the quantity back to inventory_penyimpanan on deletion of inventory pengeluaran
                $this->db->where('id_source', $data['id']);
                $pengeluaran = $this->db->get('inventory_pengeluaran_data_perlengkapan');
                
                if($pengeluaran->num_rows > 0)
                {
                    $data_pengeluaran = $pengeluaran->result();
                    
                    foreach($data_pengeluaran as $row_pengeluaran)
                    {
                        $this->db->where('id', $row_pengeluaran->id_penyimpanan_data_perlengkapan);
                        $penyimpanan_result = $this->db->get('inventory_penyimpanan_data_perlengkapan');
                        
                        if($penyimpanan_result->num_rows > 0)
                        {
                            $data_penyimpanan = $penyimpanan_result->row();
                            $qty_akhir = array(
                                'qty' => (int) $data_penyimpanan->qty + (int) $row_pengeluaran->qty_keluar
                            );
                            $this->db->where('id', $data_penyimpanan->id);
                            $this->db->update('inventory_penyimpanan_data_perlengkapan', $qty_akhir);
                            
                            
                        }
                    }
                    
                }
                
                //delete inventory pengeluaran data
                $this->db->where('id',$data['id']);
                $this->db->delete('inventory_pengeluaran');
            }
	}
        
        
}
?>