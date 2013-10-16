<?php
class Asset_Angkutan_Detail_Penggunaan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'ext_asset_angkutan_detail_penggunaan';
                $this->extTable = 'ext_asset_angkutan_detail_penggunaan';
               
                
	}
	
	function getSpecificDetailPenggunaanAngkutan($id_ext_asset)
        {
            if($_POST['open'] == 1)
            {
                $query = "select id,id_ext_asset,tanggal,jumlah_penggunaan,satuan_penggunaan,keterangan 
                        FROM ext_asset_angkutan_detail_penggunaan WHERE id_ext_asset = $id_ext_asset";
                return $this->Get_By_Query($query);
            }
        }
        
        function getSpecificDetailPenggunaanAngkutanUdara($id_ext_asset,$mesin)
        {
            if($_POST['open'] == 1)
            {

                    $query = "select id,id_ext_asset,tanggal,jumlah_penggunaan,satuan_penggunaan,keterangan 
                        FROM ext_asset_angkutan_udara_detail_penggunaan_mesin$mesin WHERE id_ext_asset = $id_ext_asset";
                
                return $this->Get_By_Query($query);
            }
        }
}
?>