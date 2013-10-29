<?php
class Pendayagunaan extends MY_Controller {

	function __construct() {
		parent::__construct();

 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pendayagunaan_Model','',TRUE);
		$this->model = $this->Pendayagunaan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/pendayagunaan_view',$data);
		}else{
			$this->load->view('process_asset/pendayagunaan_view');
		}
	}
	
	function modifyPendayagunaan(){
                $data = array();
                
                
	  	$fields = array(
                    'id', 'kd_brg', 'kd_lokasi', 'no_aset','nama',
                    'kd_klasifikasi_aset', 'part_number', 'serial_number', 'mode_pendayagunaan', 'pihak_ketiga',
                    'tanggal_start', 'tanggal_end', 'description', 
                    'document'
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
                
                
		$this->modifyData(null,$data);
	}
	
	function deletePendayagunaan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
	
	
	function getSpecificPendayagunaan()
	{
		$kd_lokasi = $this->input->post("kd_lokasi");
		$kd_brg = $this->input->post("kd_brg");
		$no_aset = $this->input->post("no_aset");
		$data = $this->model->get_Pendayagunaan($kd_lokasi, $kd_brg, $no_aset);
		$datasend["results"] = $data['data'];
                $datasend["total"] = $data['count'];
		echo json_encode($datasend);
	}
}
?>