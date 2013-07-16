<?php
class Global_MAP extends CI_Controller {
	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    }
    $this->load->model('Utility_Simpeg_Model','',TRUE);
	}
	
	function index(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('global_map/global_map_view',$data);
		}else{
			$this->load->view('global_map/global_map_view');
		}
	}

}
?>