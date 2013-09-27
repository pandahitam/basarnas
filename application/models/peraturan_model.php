<?php
class Peraturan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'peraturan';
                $this->table = 'peraturan';
                
                $this->selectColumn = "SELECT id, nama, no_dokumen,tanggal_dokumen,initiator,perihal, date_upload, document";
	}
	
	function get_AllData(){
		$query = "$this->selectColumn FROM $this->extTable";

		return $this->Get_By_Query($query);	
	}
	
	
}
?>
