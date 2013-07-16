<?php
class Ext_Check_Sesi extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index(){
 		if ($this->my_usession->logged_in == FALSE){
 			echo "0";
    }else{
    	echo "1";
    }
	}
}
?>