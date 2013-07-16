<?php
class Test_Lagi extends CI_Controller{
  function __construct(){
  	parent::__construct();
  }
	
  function index(){
  	$data['main'] = "home";
  	if($this->input->post("id_open")){
			print($this->load->view('test_lagi_view'));
		}
  }
  
}
?>