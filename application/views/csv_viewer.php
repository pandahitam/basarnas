<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	// Output to browser with appropriate mime type, you choose
	$html = "<?php ";
	$html .= "@header(\"Content-type: text/x-csv\"); ";
	$html .= "@header(\"Content-Disposition: attachment; filename=test.csv\"); ";
	$html .= "echo '$data_csv';";
	$html .= " ?>";
	$temp_path = "./assets/temp/";
	if(write_file($temp_path."csv_temp.php", $html)){
		echo base_url().$temp_path."csv_temp.php";
	}

?>