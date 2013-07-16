<?php
class Version extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function show(){
		return "SIMPEG V.1.0.0";
	}
}
?>
