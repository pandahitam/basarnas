<?php
class Pengelolaan extends MY_Controller {


	function __construct() {
		parent::__construct();

 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pengelolaan_Model','',TRUE);
		$this->model = $this->Pengelolaan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/pengelolaan_view',$data);
		}else{
			$this->load->view('process_asset/pengelolaan_view');
		}
	}
	
	function modifyPengelolaan(){
                $data = array();

	  	$fields = array(
                    'id','nama_operasi','pic','tanggal_mulai','tanggal_selesai',
                    'deskripsi','image_url', 'document_url',
                    'kd_lokasi', 'kode_unor', 'kd_brg','no_aset', 'nama'
                );
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 
//                $today = new DateTime();
//                $data['date_upload'] = $today->format('Y-m-d');
                
		$this->modifyData(null,$data);
	}
	
	function deletePengelolaan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
        
        function getSpecificPengelolaan()
	{
		$kd_lokasi = $this->input->post("kd_lokasi");
		$kd_brg = $this->input->post("kd_brg");
		$no_aset = $this->input->post("no_aset");
		$data = $this->model->get_Pengelolaan($kd_lokasi, $kd_brg, $no_aset);
		$datasend["results"] = $data['data'];
                $datasend["total"] = $data['count'];
		echo json_encode($datasend);
	}
        
        function alertPengelolaanAction()
        {
            $id = $_POST['id'];
            $update_alert_viewed_status = array(
                'alert_viewed_status'=>1
            );
            $this->db->where('id',$id);
            $this->db->update('pengelolaan',$update_alert_viewed_status);
            echo 1;
        }
	

}
?>