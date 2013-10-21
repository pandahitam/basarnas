<?php
class Pengelolaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pengelolaan';
                $this->table = 'pengelolaan';
                $this->viewTable = 'pengelolaan';
                
                $this->selectColumn = "SELECT id, nama_operasi, pic,tanggal_mulai,tanggal_selesai,deskripsi, image_url, document_url, kd_lokasi, kode_unor, kd_brg, no_aset, nama";
	}
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){

                
                $query = "$this->selectColumn FROM $this->extTable ";
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
                                    pic like '%$searchByField%' OR
                                    nama_operasi like '%$searchByField%' OR
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
                                    pic like '%$searchByField%' OR
                                    nama_operasi like '%$searchByField%' OR
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
                    return $this->Get_By_Query($query,false,'pengelolaan');	
                }
                else
                {
                    return $this->Get_By_Query($query);	
                }	
	}
        
        function get_Pengelolaan($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "SELECT t.id, t.nama_operasi, t.pic,t.tanggal_mulai,t.tanggal_selesai,t.deskripsi, t.image_url, t.document_url, t.kd_lokasi, t.kode_unor, t.kd_brg, t.no_aset, t.nama
                        FROM $this->table AS t
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        where t.kd_lokasi = '$kd_lokasi' and t.kd_brg = '$kd_barang' and t.no_aset = '$no_aset'";
		
                return $this->Get_By_Query($query);
	}
	
	
}
?>
