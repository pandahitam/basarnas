<?php
class Profil_Func extends CI_Controller{
  function __construct(){
  	parent::__construct();
  }
	
  function index(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('profil_pns/profil_func',$data);
		}else{
			$this->load->view('profil_pns/profil_func');
		}  	
  }  
}
?>