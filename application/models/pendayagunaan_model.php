<?php
class Pendayagunaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
                $this->table = 'pendayagunaan';
		$this->extTable = 'pendayagunaan';
                $this->viewTable = 'view_pendayagunaan';
                
//                $this->selectColumn = "SELECT t.id, t.kd_lokasi, t.kd_brg, t.no_aset, t.nama,t.pihak_ketiga,
//                        t.part_number,t.serial_number,t.mode_pendayagunaan,t.tanggal_start,t.description,
//                        t.tanggal_end,t.document,
//                        c.ur_upb as nama_unker,
//                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
//                        ,f.nama as nama_klasifikasi_aset, t.kd_klasifikasi_aset,
//                        f.kd_lvl1,f.kd_lvl2,f.kd_lvl3";
                
                $this->selectColumn = "SELECT id, kd_lokasi, kd_brg, no_aset, nama,pihak_ketiga, nama_unor,
                        part_number,serial_number,mode_pendayagunaan,tanggal_start,description,
                        tanggal_end,document,
                        nama_unker,
                        kd_gol,kd_bid,kd_kelompok,kd_skel,kd_sskel
                        ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                        kd_lvl1,kd_lvl2,kd_lvl3";
	}
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
//                if($start != null && $limit !=null)
//                {
//                    $query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        LIMIT $start, $limit";
//                    if($searchByBarcode != null)
//                    {
//                        $query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchByBarcode' 
//                        LIMIT $start, $limit";
//                    }
//                }
//                else
//                {
//                    $query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        ";
//                    if($searchByBarcode != null)
//                    {
//                        $query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchByBarcode' 
//                        ";
//                    }
//                }    
//                
//		return $this->Get_By_Query($query);	
            
            $query = "$this->selectColumn FROM $this->viewTable ";
            $isGridFilter = false;
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn FROM $this->viewTable 
                                LIMIT $start, $limit";
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
                                  description like '%$searchByField%' 
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
                $query = "$this->selectColumn FROM $this->viewTable
                                ";

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
                                description like '%$searchByField%'
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
                return $this->Get_By_Query($query,false,'view_pendayagunaan');	
            }
            else
            {
                return $this->Get_By_Query($query);	
            }
	}
	
	function get_Pendayagunaan($kd_lokasi, $kd_barang, $no_aset)
	{
//		$query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        where t.kd_lokasi = '$kd_lokasi' and t.kd_brg = '$kd_barang' and t.no_aset = '$no_aset'";
//		
//                return $this->Get_By_Query($query);
            
                $query = "$this->selectColumn
                        FROM $this->viewTable
                        where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
                return $this->Get_By_Query($query);
	}

	function get_PendayagunaanForPrint($kd_lokasi, $kd_barang, $no_aset)
	{
//		$query = "$this->selectColumn
//                        FROM $this->table AS t
//                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
//                        where t.kd_lokasi = '$kd_lokasi' and t.kd_brg = '$kd_barang' and t.no_aset = '$no_aset'";
//		$this->load->database();
//		$result = $this->db->query($query)->result_array();
//		$this->db->close();				  
//		return $result;	
                
                $query = "$this->selectColumn
                        FROM $this->viewTable
                        where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
		$this->load->database();
		$result = $this->db->query($query)->result_array();
		$this->db->close();				  
		return $result;	
	}
}
?>