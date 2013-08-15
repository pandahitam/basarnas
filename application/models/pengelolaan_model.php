<?php
class Pengelolaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pengelolaan';
                
                $this->selectColumn = "SELECT id, nama, no_document, tanggal_document, pembuat, perihal, date_upload, image_url, document_url";
	}
	
	function get_AllData(){
		$query = "$this->selectColumn FROM $this->extTable";

		return $this->Get_By_Query($query);	
	}
	
	
}
?>
