<?php
class Pengelolaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pengelolaan';
                $this->table = 'pengelolaan';
                
                $this->selectColumn = "SELECT id, nama_operasi, pic,tanggal_mulai,tanggal_selesai,deskripsi, image_url, document_url, kd_lokasi, kode_unor, kd_brg, no_aset, nama";
	}
	
	function get_AllData($start=null, $limit=null, $searchTextFilter = null, $gridFilter = null){

                
                $query = "$this->selectColumn FROM $this->extTable ";
                $isGridFilter = false;
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn FROM $this->extTable 
                                LIMIT $start, $limit";
                if($searchTextFilter != null)
                {
                    $query = "$this->selectColumn FROM $this->extTable
                                where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter'
                                LIMIT $start, $limit";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn FROM $this->extTable
                               where $gridFilter
                               LIMIT $start, $limit
                                ";
                    $isGridFilter = true;
                }
            }
            else
            {
                $query = "$this->selectColumn FROM $this->extTable
                                ";

                if($searchTextFilter != null)
                {
                    $query = "$this->selectColumn FROM $this->extTable
                               where CONCAT(kd_brg,kd_lokasi,no_aset) = '$searchTextFilter'
                                ";
                }
                else if($gridFilter != null)
                {
                    $query = "$this->selectColumn FROM $this->extTable
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
