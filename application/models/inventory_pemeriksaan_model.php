<?php
class Inventory_Pemeriksaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'inventory_pemeriksaan';
                $this->extTable = 'inventory_pemeriksaan';
                $this->selectColumn = "SELECT t.id,t.tgl_berita_acara,t.nomor_berita_acara,t.kd_brg,t.kd_lokasi,t.id_penerimaan,t.nama_org,
                                        t.no_aset, t.part_number,t.serial_number,t.date_created,
                                        t.keterangan, t.status_barang,t.qty,t.tgl_pemeriksaan,t.asal_barang,
                                        c.ur_upb as nama_unker,
                                        e.kd_gol,e.kd_bid,e.kd_kel as kd_kelompok,e.kd_skel, e.kd_sskel,
                                        d.nama_unor, t.kode_unor";
                                        }
	
	function get_AllData($start=null, $limit=null){
                
            if($start != null && $limit != null)
            {
                $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                            LIMIT $start,$limit";
		
            }
            else
            {
                $query = "$this->selectColumn
                            FROM $this->table AS t
                            LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                            LEFT JOIN ref_unor AS d ON b.kode_unor = d.kode_unor
                            LEFT JOIN ref_unor d ON t.kode_unor = d.kode_unor
                            LEFT JOIN ref_subsubkel AS e ON t.kd_brg = e.kd_brg
                            ";
            }
            
            return $this->Get_By_Query($query);
			
	}
        
        function get_InventoryPemeriksaan($id)
	{		
            $this->db->from($this->table);
            $this->db->where('id',$id);
            $query = $this->db->get();
            return $query->row();
	}
	

	
	

}
?>