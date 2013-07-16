<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	// Output to browser with appropriate mime type, you choose
	@header("Content-type: text/x-csv");
	@header("Content-Disposition: attachment; filename=test.csv");
	echo $data_csv;

?>