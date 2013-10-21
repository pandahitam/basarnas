<?php
class Perencanaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'perencanaan';
                $this->viewTable = 'view_perencanaan';
                
                $this->selectColumn = "SELECT id, kd_lokasi, kd_brg, no_aset,
                            kode_unor, kode_unker, nama_unker, nama_unor,tahun_angaran, nama, 
                            kebutuhan, keterangan, satuan, quantity, 
                            harga_satuan, harga_total, is_realisasi, image_url, document_url";
                
	}
	
	function get_AllData($start = null, $limit = null, $searchByBarcode = null,$gridFilter=null, $searchByField = null){
		$query = " $this->selectColumn FROM $this->viewTable";
                $isGridFilter = false;
                if($start !=null && $limit != null)
                {
                    $query = " $this->selectColumn FROM $this->viewTable LIMIT $start, $limit";
                    if($searchByBarcode != null)
                    {
                        $query = "$this->selectColumn
                                    FROM $this->viewTable
                                    where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
                                    LIMIT $start, $limit";
                    }
                    else if($searchByField != null)
                    {
                        $query = "$this->selectColumn
                                    FROM $this->viewTable
                                    where
                                    kd_brg like '%$searchByField%' OR
                                    kd_lokasi like '%$searchByField%' OR
                                    nama_unker like '%$searchByField%' OR
                                    nama_unor like '%$searchByField%' OR
                                    nama like '%$searchByField%' OR
                                    tahun_angaran like '%$searchByField%'
                                    LIMIT $start, $limit";
                    }
                    else if($gridFilter != null)
                    {
                        $query = "$this->selectColumn
                                   FROM $this->viewTable
                                   where $gridFilter
                                   LIMIT $start, $limit
                                    ";
                        $isGridFilter = true;
                    }
                }
                else
                {
                    $query = " $this->selectColumn FROM $this->viewTable LIMIT $start, $limit";
                    if($searchByBarcode != null)
                    {
                        $query = "$this->selectColumn
                                    FROM $this->viewTable
                                    where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchByBarcode'
                                    ";
                    }
                    else if($searchByField != null)
                    {
                        $query = "$this->selectColumn
                                    FROM $this->viewTable
                                    where
                                    kd_brg like '%$searchByField%' OR
                                    kd_lokasi like '%$searchByField%' OR
                                    nama_unker like '%$searchByField%' OR
                                    nama_unor like '%$searchByField%' OR
                                    nama like '%$searchByField%' OR
                                    tahun_angaran like '%$searchByField%'
                                    ";
                    }
                    else if($gridFilter != null)
                    {
                        $query = "$this->selectColumn
                                   FROM $this->viewTable
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
                    return $this->Get_By_Query($query,false,'view_perencanaan');	
                }
                else
                {
                    return $this->Get_By_Query($query);	
                }	
	}
	
	function get_ByID($id)
	{
		$query = "SELECT id, kd_lokasi, kd_brg, no_aset, 
                            kode_unor, kode_unker, nama_unker,nama_unor,tahun_angaran, nama, 
                            kebutuhan, keterangan, satuan, quantity, 
                            harga_satuan, harga_total, is_realisasi, image_url, document_url FROM $this->viewTable
							where id = $id";

		return $this->Get_By_Query($query);
	}
	
	
}
?>
