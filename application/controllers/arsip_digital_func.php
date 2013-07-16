<?php
class Arsip_Digital_Func extends CI_Controller{
  function __construct(){
  	parent::__construct();
  }
	
  function index(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/arsip_digital_func',$data);
		}else{
			$this->load->view('profil_pns/arsip_digital');
		}  	
  }  
}
?>