<?php
class Print_CheckSelected extends CI_Controller {
	function __construct(){
		parent::__construct();
	}
	
	function index(){
  	if($this->input->post("pilihan_cetak")){
  		$mode_cetak = $this->input->post("pilihan_cetak");
  		if($mode_cetak == "semua"){
  			echo "{success:true, mode_cetak: '" . $mode_cetak ."' }";		
  		}elseif($mode_cetak == "terpilih"){
  			echo "{success:true, mode_cetak: '" . $mode_cetak ."' }";		
  		}elseif($mode_cetak == "perbaris"){
  			if($this->input->post("dari") == 'Dari' || $this->input->post("sampai") == 'Sampai'){
  				echo "{success:false, errors: { reason: 'Tentukan batasan baris yang akan dicetak !' }}";  
  			}else{
  				echo "{success:true, mode_cetak: '" . $mode_cetak ."', record: {dari: '". $this->input->post("dari") ."', sampai: '" . $this->input->post("sampai") . "'}}";	 		
  			}
  		}else{
  			echo "{success:false, errors: { reason: 'Tentukan Pilihan Cetak !' }}";
  		}		
  	}			
	}
}
?>