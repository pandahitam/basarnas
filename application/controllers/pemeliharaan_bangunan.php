<?php
class Pemeliharaan_Bangunan extends MY_Controller {


	function __construct() {
		parent::__construct();
                
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pemeliharaan_Bangunan_Model','',TRUE);
		$this->model = $this->Pemeliharaan_Bangunan_Model;		
	}
	
	
	function index()
	{
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/pemeliharaan_bangunan_view',$data);
		}else{
			$this->load->view('process_asset/pemeliharaan_bangunan_view');
		}
	}
	
	function modifyPemeliharaanBangunan(){
                $data = array();
//                var_dump($_POST);
//                die;
	  	$fields = array(
                   'id','kd_brg', 'kd_lokasi', 'no_aset', 'kode_unor', 
                    'jenis', 'subjenis', 'pelaksana_nama', 'pelaksana_startdate', 
                    'pelaksana_endate', 'deskripsi', 'biaya', 'image_url', 'document_url','nama','kondisi'
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
		$this->modifyData(null,$data);
	}
	
	function deletePemeliharaanBangunan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
	
	function getSpecificPemeliharaanBangunan()
	{
		$kd_lokasi = $this->input->post("kd_lokasi");
		$kd_brg = $this->input->post("kd_brg");
		$no_aset = $this->input->post("no_aset");
		$data = $this->model->get_Pemeliharaan($kd_lokasi, $kd_brg, $no_aset);
                
                $datasend["results"] = $data['data'];
                $datasend["total"] = $data['count'];
		echo json_encode($datasend);
	}
}
?>