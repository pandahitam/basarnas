<?php
class Inventory_Perlengkapan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
//		$this->table = 'inventory_penyimpanan';
//                $this->extTable = 'inventory_penyimpanan';
//                $this->selectColumn = "SELECT t.id,t.tgl_berita_acara,t.nomor_berita_acara,t.kd_brg,t.kd_lokasi,t.nama_org,t.id_pemeriksaan,
//                                        t.no_aset, t.part_number,t.serial_number,t.date_created,
//                                        t.keterangan, t.status_barang,t.qty,t.tgl_penyimpanan,t.asal_barang,
//                                        c.ur_upb as nama_unker,
//                                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel,
//                                        d.nama_unor, t.kode_unor, t.warehouse_id,t.ruang_id,t.rak_id";
                                        }
	
	function get_AllData($start=null, $limit=null, $searchTextFilter = null){
                
//            if($start != null && $limit != null)
//            {
//                $query = "$this->selectColumn
//                            FROM $this->table AS t
//                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
//                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                            LIMIT $start,$limit";
//                
//                if($searchTextFilter != null)
//                {
//                    $query = "$this->selectColumn
//                            FROM $this->table AS t
//                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
//                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                            where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
//                            LIMIT $start,$limit";
//                }
//		
//            }
//            else
//            {
//                $query = "$this->selectColumn
//                            FROM $this->table AS t
//                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
//                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
//                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                            ";
//                
//                if($searchTextFilter != null)
//                {
//                    $query = "$this->selectColumn
//                            FROM $this->table AS t
//                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
//                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
//                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
//                            where CONCAT(t.kd_brg,t.kd_lokasi,t.no_aset) = '$searchTextFilter'
//                            ";
//                }
//            }
//            
//            return $this->Get_By_Query($query);
			
	}
	
        function get_InventoryPerlengkapan($id,$table,$table_source)
	{
            $query = "select t.*, a.kd_lokasi,a.kode_unor
                     FROM $table as t
                     LEFT JOIN $table_source as a on a.id = t.id_source
                     where id_source = $id";
		
                return $this->Get_By_Query($query); 
	}
        
        
        function get_InventoryPerlengkapanPenyimpanan($id)
        {
            $query = "select t.*, a.nama as nama_warehouse, b.nama as nama_ruang, c.nama as nama_rak
                      FROM inventory_penyimpanan_data_perlengkapan as t
                      LEFT JOIN ref_warehouse as a on a.id = t.id_warehouse
                      LEFT JOIN ref_warehouseruang as b on b.id = t.id_warehouse_ruang
                      LEFT JOIN ref_warehouserak as c on c.id =  t.id_warehouse_rak
                      where id_source =$id";
            return $this->Get_By_Query($query); 
        }
        
        function get_InventoryPerlengkapanPengeluaran($id)
        {
            $query = "select t.*, a.nomor_berita_acara, b.part_number
                      FROM inventory_pengeluaran_data_perlengkapan as t
                      LEFT JOIN inventory_penyimpanan as a on a.id = t.id_penyimpanan
                      LEFT JOIN inventory_penyimpanan_data_perlengkapan as b on b.id = t.id_penyimpanan_data_perlengkapan
                      where t.id_source =$id";
            return $this->Get_By_Query($query); 
        }
        
	
	
//	function ConstructKode($kode_golongan = NULL,$kode_asset = NULL){
//		$kode = NULL;
//		if ($kode_golongan != NULL && $kode_asset != NULL)
//		{
//			$kode = '2' . $kode_golongan . $kode_asset;
//		}	
//		return $kode;
//	}
}
?>