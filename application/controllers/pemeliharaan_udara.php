<?php
class Pemeliharaan_Udara extends MY_Controller {


	function __construct() {
		parent::__construct();

 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pemeliharaan_Udara_Model','',TRUE);
		$this->model = $this->Pemeliharaan_Udara_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/pemeliharaan_udara_view',$data);
		}else{
			$this->load->view('process_asset/pemeliharaan_udara_view');
		}
	}
	
	function modifyPemeliharaanUdara(){
                $data = array();
                
	  	$fields = array(
                    'id', 'kd_brg', 'kd_lokasi', 'no_aset',
                    'kode_unker', 'kode_unor', 'jenis', 'nama', 
                    'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 
                    'kondisi', 'deskripsi', 'harga', 'kode_angaran', 
                    'unit_waktu', 'unit_pengunaan',
                    'freq_waktu', 'freq_pengunaan', 'status', 'durasi', 
                    'rencana_waktu', 'rencana_pengunaan', 'rencana_keterangan', 'alert', 
                    'document_url','image_url'
                );
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 
                
                if($data['nama'] == null || $data['nama'] == '')
                {
                    if($data['kd_brg'] != null || $data['kd_brg'] != '')
                    {
                        $this->db->where('kd_brg',$data['kd_brg']);
                        $query = $this->db->get('ref_subsubkel');
                        $result = $query->row();
//                        var_dump($result);
//                        die;
                        if($query->num_rows > 0)
                        {
                            $data['nama'] = $result->ur_sskel;
                        }
                    }
                    
                }
                
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
                
		if($data['id'] == '')
                {
                    $this->db->insert('pemeliharaan',$data);
                    $this->createLog('INSERT PEMELIHARAAN KENDARAAN UDARA','pemeliharaan');
                }
                else
                {
                    $this->db->set($data);
                    $this->db->replace('pemeliharaan');
                    $this->createLog('UPDATE PEMELIHARAAN KENDARAAN UDARA','pemeliharaan');
                }
//                echo "{success:true, id:$id}";
                
                $query_id_ext_asset = $this->db->query("select id from ext_asset_angkutan where kd_brg='".$data['kd_brg']."' and kd_lokasi='".$data['kd_lokasi']."' and no_aset= '".$data['no_aset']."'");
                $query_id_ext_asset_result = $query_id_ext_asset->row();
                echo "{success:true, id:$query_id_ext_asset_result->id}";
	}
	
	function deletePemeliharaanUdara()
	{
		$data = $this->input->post('data');
                foreach($data as $dataContent)
                {
                    $this->createLog('DELETE PEMELIHARAAN KENDARAAN UDARA','pemeliharaan');
                }
		return $this->deleteProcess($data);
	}
	
	
	function getSpecificPemeliharaanUdara()
	{
		$kd_lokasi = $this->input->post("kd_lokasi");
		$kd_brg = $this->input->post("kd_brg");
		$no_aset = $this->input->post("no_aset");
		$data = $this->model->get_Pemeliharaan($kd_lokasi, $kd_brg, $no_aset);
		$datasend["results"] = $data;
		echo json_encode($datasend);
	}
}
?>