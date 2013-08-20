<?php
class laporan_aset_unitkerja extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
//		$this->load->model('Asset_Alatbesar_Model','',TRUE);
//		$this->model = $this->Asset_Alatbesar_Model;		
	}
	
        public function index()
        {
            if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('laporan/laporan_aset_unitkerja_view',$data);
		}else{
			$this->load->view('laporan/laporan_aset_unitkerja_view');
		}
	}
        
        public function getLaporanData()
        {
            $query = "select * from asset_angkutan";
            
//            $r = $this->db->query($query);
//            $dataX = array();
//            if ($r->num_rows() > 0)
//            {
//                foreach ($r->result() as $obj)
//                {
//                    $data[] = $obj;
//                }  
//            }
//            $r->free_result();
////            $data = $this->Get_By_Query($query);
//            $data = $dataX;
            $dataSend['results'] = $data;
            echo json_encode($dataSend);
        }
}
?>