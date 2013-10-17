<?php
class Perencanaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'perencanaan';
                $this->viewTable = 'view_perencanaan';
	}
	
	function get_AllData($start = null, $limit = null, $searchTextFilter = null,$gridFilter=null){
		$query = 'SELECT id, kd_lokasi, kd_brg, no_aset,
                            kode_unor, kode_unker, nama_unker, nama_unor,tahun_angaran, nama, 
                            kebutuhan, keterangan, satuan, quantity, 
                            harga_satuan, harga_total, is_realisasi, image_url, document_url FROM ' . $this->viewTable;
                $isGridFilter = false;
                if($start !=null && $limit != null)
                {
                    $query = "SELECT id, kd_lokasi, kd_brg, no_aset,
                            kode_unor, kode_unker, nama_unker, nama_unor,tahun_angaran, nama, 
                            kebutuhan, keterangan, satuan, quantity, 
                            harga_satuan, harga_total, is_realisasi, image_url, document_url FROM $this->viewTable LIMIT $start, $limit";
                    if($searchTextFilter != null)
                    {
                        $query = "SELECT id, kd_lokasi, kd_brg,no_aset,
                            kode_unor, kode_unker, nama_unker, nama_unor,tahun_angaran, nama, 
                            kebutuhan, keterangan, satuan, quantity, 
                            harga_satuan, harga_total, is_realisasi, image_url, document_url FROM $this->viewTable
                        where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter' 
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
                    $query = "SELECT id, kd_lokasi, kd_brg,no_aset,
                            kode_unor, kode_unker, nama_unker, nama_unor,tahun_angaran, nama, 
                            kebutuhan, keterangan, satuan, quantity, 
                            harga_satuan, harga_total, is_realisasi, image_url, document_url FROM $this->viewTable";
                    if($searchTextFilter != null)
                    {
                        $query = "SELECT id, kd_lokasi, kd_brg, no_aset,
                            kode_unor, kode_unker, nama_unker, nama_unor,tahun_angaran, nama, 
                            kebutuhan, keterangan, satuan, quantity, 
                            harga_satuan, harga_total, is_realisasi, image_url, document_url FROM $this->viewTable
                        where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter' 
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
