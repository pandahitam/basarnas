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
			'id','tgl_berita_acara','nomor_berita_acara','kd_brg','kd_lokasi','id_perlengkapan','nama_org',
                        'no_aset', 'part_number','serial_number','date_created',
                        'keterangan','kode_unor',
                        'status_barang','qty','tgl_pengeluaran','asal_barang','kode_unor','qty_barang_keluar'
                );
                
                

		foreach ($simakFields as $field) {
			$dataSimak[$field] = $this->input->post($field);
		}
                
                $dataPerlengkapan = array(
                    'kuantitas'=> $dataSimak['qty'] - $dataSimak['qty_barang_keluar']
                );
                
                /*UPDATE QTY IN PERLENGKAPAN */
                $this->db->where('id',$dataSimak['id_perlengkapan']);
                $this->db->update('asset_perlengkapan',$dataPerlengkapan);

                $this->modifyData($dataSimak, null);
	}
	
	function deleteInventoryPengeluaran()
	{
		$input_data = $this->input->post('data');
                
                foreach($input_data as $data)
                {
                    
                    $this->db->where('id',$data['id']);
                    $this->db->delete('inventory_pengeluaran');
                    
                    //Return the quantity back to asset_perlengkapan when deleted
                    $this->db->where('id',$data['id_perlengkapan']);
                    $perlengkapan_result = $this->db->get('asset_perlengkapan');
                   if($perlengkapan_result->num_rows == 1)
                   {
                       $data_perlengkapan = $perlengkapan_result->row();
                       $qty_akhir = array( 
                           'kuantitas'=>(int)$data_perlengkapan->kuantitas + (int)$data['qty_barang_keluar']
                               );
                       $this->db->where('id',$data['id_perlengkapan']);
                       $this->db->update('asset_perlengkapan',$qty_akhir);
                               
                   }
                }
//		return $this->deleteData($data);
	}
}
?>