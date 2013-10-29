<?php
class Pemeliharaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->extTable = 'pemeliharaan';
                $this->viewTable = 'view_pemeliharaan_lainnya';
                $this->countTable = 'view_pemeliharaan_lainnya';
                
                $this->selectColumn = "SELECT id, kd_brg, kd_lokasi, no_aset,
                            kode_unker, kode_unor, nama_unker, nama_unor,jenis, nama, 
                            tahun_angaran, pelaksana_tgl, pelaksana_nama, 
                            kondisi, deskripsi, harga, kode_angaran,
                            unit_waktu, unit_pengunaan,
                            freq_waktu, freq_pengunaan, status, durasi, 
                            rencana_waktu, rencana_pengunaan, rencana_keterangan, image_url,document_url, alert";
	}
	
	function get_AllData($start=null, $limit=null, $searchByBarcode = null, $gridFilter = null, $searchByField = null){
//		$query = "$this->selectColumn FROM $this->viewTable
//                        where kd_brg NOT LIKE '4%'
//                        AND kd_brg NOT LIKE '2%'
//                        AND kd_brg NOT LIKE '30205%'
//                        AND kd_brg NOT LIKE '30203%' AND kd_brg NOT LIKE '30204%'
//                        AND kd_brg NOT LIKE '30201%' AND kd_brg NOT LIKE '30202%'";
            
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
                                    tahun_angaran like '%$searchByField%'
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
                                    tahun_angaran like '%$searchByField%'
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
                    return $this->Get_By_Query($query,false,'view_pemeliharaan_lainnya');	
                }
                else
                {
                    return $this->Get_By_Query($query);	
                }	
	}
	
	function get_Pemeliharaan($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "$this->selectColumn FROM view_pemeliharaan where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
		
                return $this->Get_By_Query($query);
	}
	
	function get_PemeliharaanForPrint($kd_lokasi, $kd_barang, $no_aset)
	{
		$query = "$this->selectColumn FROM $this->viewTable where kd_lokasi = '$kd_lokasi' and kd_brg = '$kd_barang' and no_aset = '$no_aset'";
		$this->load->database();
		$result = $this->db->query($query)->result_array();
		$this->db->close();				  
		return $result;	
	}
}
?>
