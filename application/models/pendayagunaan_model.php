<?php
class Pendayagunaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
                $this->table = 'pendayagunaan';
		$this->extTable = 'pendayagunaan';
                $this->viewTable = 'pendayagunaan';
                
                $this->selectColumn = "SELECT t.id, t.kd_lokasi, t.kd_brg, t.no_aset, t.nama,t.pihak_ketiga,
                        t.part_number,t.serial_number,t.mode_pendayagunaan,t.tanggal_start,t.description,
                        t.tanggal_end,t.document,
                        c.ur_upb as nama_unker,
                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel
                        ,f.nama as nama_klasifikasi_aset, t.kd_klasifikasi_aset,
                        f.kd_lvl1,f.kd_lvl2,f.kd_lvl3";
	}
	
	function get_AllData($start=null, $limit=null, $searchTextFilter = null){
                if($start != null && $limit !=null)
                {
                    $query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                        LIMIT $start, $limit";
                    if($searchTextFilter != null)
                    {
                        $query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                        where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter' 
                        LIMIT $start, $limit";
                    }
                }
                else
                {
                    $query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                        ";
                    if($searchTextFilter != null)
                    {
                        $query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                        where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter' 
                        ";
                    }
                }    
                
		return $this->Get_By_Query($query);	
	}
	
	function get_Pendayagunaan($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "$this->selectColumn
                        FROM $this->table AS t
                        LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                        LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                        LEFT JOIN ref_klasifikasiaset_lvl3 AS f ON t.kd_klasifikasi_aset = f.kd_klasifikasi_aset
                        where t.kd_lokasi = '$kd_lokasi' and t.kd_brg = '$kd_barang' and t.no_aset = '$no_aset'";
		
                return $this->Get_By_Query($query);
	}
}
?>