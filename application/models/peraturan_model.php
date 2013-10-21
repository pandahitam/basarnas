<?php
class Peraturan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'peraturan';
                $this->table = 'peraturan';
                $this->viewTable = 'peraturan';
                
                $this->selectColumn = "SELECT id, nama, no_dokumen,tanggal_dokumen,initiator,perihal, date_upload, document";
	}
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
		$query = "$this->selectColumn FROM $this->extTable";
                $isGridFilter = false;    
                if($start !=null && $limit != null)
                {
                    $query = "$this->selectColumn FROM $this->viewTable LIMIT $start, $limit";
                    if($searchByBarcode != null)
                    {
                        $query = "$this->selectColumn FROM $this->viewTable
                        where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode' 
                        LIMIT $start, $limit";
                    }
                    else if($searchByField != null)
                    {
                        $query = "$this->selectColumn
                                    FROM $this->viewTable
                                    where
                                    nama like '%$searchByField%' OR
                                    initiator like '%$searchByField%' OR
                                    perihal like '%$searchByField%'
                                    LIMIT $start, $limit";
                    }
                     else if($gridFilter != null)
                    {
                        $query = "$this->selectColumn FROM $this->viewTable
                                   where $gridFilter
                                   LIMIT $start, $limit
                                    ";
                        $isGridFilter = true;
                    }
                }
                else
                {
                    $query = "$this->selectColumn FROM $this->viewTable";
                    if($searchByBarcode != null)
                    {
                        $query = "$this->selectColumn FROM $this->viewTable
                        where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode' 
                        ";
                    }
                    else if($searchByField != null)
                    {
                        $query = "$this->selectColumn
                                    FROM $this->viewTable
                                    where
                                   nama like '%$searchByField%' OR
                                    initiator like '%$searchByField%' OR
                                    perihal like '%$searchByField%'
                                    ";
                    }
                    else if($gridFilter != null)
                    {
                        $query = "$this->selectColumn FROM $this->viewTable
                                   where $gridFilter
                                    ";
                        $isGridFilter = true;
                    }
                }
                
                if($isGridFilter == true)
                {
                    return $this->Get_By_Query($query,true);	
                }
                else if($searchByField != null)
                {
                    return $this->Get_By_Query($query,false,'peraturan');	
                }
                else
                {
                    return $this->Get_By_Query($query);	
                }	
	}
	
	
}
?>
