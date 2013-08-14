<?php
class Asset_Ruang extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    	}
		$this->load->model('Asset_Ruang_Model','',TRUE);
		$this->model = $this->Asset_Ruang_Model;		
	}
	
	function ruang(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('pengelolaan_asset/ruang_view',$data);
		}else{
			$this->load->view('pengelolaan_asset/ruang_view');
		}
	}
	
	function modifyRuang(){
            
            
            
                /*
                 * as of this time of writing this controller seems not yet updated
                 * with the latest structure like the others in asset inventaris
                 * therefore please uncomment the generasi of no_aset when changes had been made
                 */
                //GENERASI NO_ASET 
//                if($dataSimak['no_aset'] == null || $dataSimak['no_aset'] == "")
//                {
//                    $dataSimak['no_aset'] = $this->noAssetGenerator($dataSimak['kd_brg'], $dataSimak['kd_lokasi']);
//                    $dataExt['no_aset'] = $dataSimak['no_aset'];
//                }
	}
	
	function deleteRuang()
	{
		
	}
}
?>