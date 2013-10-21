<?php
class Pengadaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
                $this->viewTable = 'view_pengadaan';
		$this->extTable = 'pengadaan';
                $this->countTable = 'view_pengadaan';
    
                $this->selectColumn = "SELECT id, kd_lokasi, kd_brg, no_aset, kode_unor, merek, model, nama,
                            nama_unker, nama_unor, id_vendor, nama,
                            tahun_angaran, perolehan_sumber, perolehan_bmn, no_sppa, 
                            asal_pengadaan, harga_total, deskripsi, perolehan_tanggal, 
                            faktur_no, faktur_tanggal, kuitansi_no, kuitansi_tanggal, 
                            sp2d_no, sp2d_tanggal, mutasi_no, mutasi_tanggal, 
                            garansi_berlaku, garansi_keterangan, pelihara_berlaku, pelihara_keterangan, 
                            spk_no, spk_jenis, spk_berlaku, spk_keterangan, 
                            is_terpelihara, is_garansi, is_spk, data_kontrak,image_url,document_url";
	}
        
	
	function get_AllData($start = null, $limit = null, $searchByBarcode = null,$gridFilter=null,$searchByField = null){
		
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
                    return $this->Get_By_Query($query,false,'view_pengadaan');	
                }
                else
                {
                    return $this->Get_By_Query($query);	
                }
	}
	
	function get_ByID($id)
	{
		$query = "$this->selectColumn FROM $this->viewTable
							where id = $id";
		return $this->Get_By_Query($query);	
	}
        
        function get_ByKode($kd_lokasi,$kd_brg,$no_aset)
	{
		$query = "$this->selectColumn FROM $this->viewTable
                                where kd_lokasi = '$kd_lokasi' AND kd_brg = '$kd_brg' AND no_aset = $no_aset";
                
		return $this->Get_By_Query($query);	
	}
	
        function get_ByKodeForPrint($kd_lokasi,$kd_brg,$no_aset)
	{
		$query = "$this->selectColumn FROM $this->viewTable
                                where kd_lokasi = '$kd_lokasi' AND kd_brg = '$kd_brg' AND no_aset = $no_aset";
		$this->load->database();
		$result = $this->db->query($query)->result_array();
		$this->db->close();				  
		return $result;	
	}
}
?>
