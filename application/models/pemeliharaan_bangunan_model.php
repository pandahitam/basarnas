<?php
class Pemeliharaan_Bangunan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pemeliharaan_bangunan';
                $this->viewTable = 'view_pemeliharaanBangunan';
                
                $this->selectColumn = "SELECT id, nama_unker, nama_unor,kd_brg, kd_lokasi, no_aset,
                            kode_unor, jenis, subjenis, pelaksana_nama, pelaksana_startdate, 
                            pelaksana_endate, deskripsi, biaya, image_url, document_url,nama,kondisi";
	}
	
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
		
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
                                    kd_brg like '%$searchByField%' OR
                                    kd_lokasi like '%$searchByField%' OR
                                    nama_unker like '%$searchByField%' OR
                                    nama_unor like '%$searchByField%' OR
                                    nama like '%$searchByField%' OR
                                    deskripsi like '%$searchByField%'
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
                                    kd_brg like '%$searchByField%' OR
                                    kd_lokasi like '%$searchByField%' OR
                                    nama_unker like '%$searchByField%' OR
                                    nama_unor like '%$searchByField%' OR
                                    nama like '%$searchByField%' OR
                                    deskripsi like '%$searchByField%'
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
                    return $this->Get_By_Query($query,false,'view_pemeliharaanBangunan');	
                }
                else
                {
                    return $this->Get_By_Query($query);	
                }	
	}
	
	function get_Pemeliharaan($kd_lokasi, $kd_brg, $no_aset)
	{
		$query = "$this->selectColumn FROM $this->viewTable
                            where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_brg' and no_aset = '$no_aset'";

		return $this->Get_By_Query($query);	
	}
}
?>