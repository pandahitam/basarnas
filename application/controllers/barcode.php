<?php
class Barcode extends CI_Controller{
  function __construct(){
  	parent::__construct();
  }
	
  function index(){
  	if($this->input->get_post('code')){
  		$data['barcode_text'] = $this->input->get_post('code');
  		$this->load->view('barcode_view', $data);
  	}else{
  		$data['barcode_text'] = 'Test';
  		$this->load->view('barcode_view', $data);
  	}
  }
  
}
?>