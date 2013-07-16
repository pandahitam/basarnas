<?php
class Tasset_lainya_Model extends CI_Model {
	
	var $table;
	
	function __construct(){
		parent::__construct();
		$this->table = 'tasset_lainya';
	}
	
	function get_AllData($start = NULL, $limit=NULL){
		//$start = isset($start) ? $start : 0;
		//$limit = isset($limit) ? $limit : 20;
		
		$this->db->select('id,nama_unker,kode_asset,kode_wilayah,kode_registrasi,kode_unit_kerja,jabatan_unor,kode_unit_organisasi,nama,asal_usul,keterangan,
						harga,perolehan,merek,nomor_reg,tipe,bahan,tahun_pembelian,ukuran,image_url');
		$this->db->join('tref_unor', 'tref_unor.kode_Unor = '.$this->table.'.kode_unit_organisasi');
		$this->db->join('tref_unitkerja', 'tref_unitkerja.kode_unker = '.$this->table.'.kode_unit_kerja');
		$this->db->order_by('nama','ASC');
		//$this->db->limit($limit,$start);
		
		$r = $this->db->get($this->table);
		$data = array();
		if (isset($r))
		{
			foreach ($r->result() as $obj)
		    {
		    	$data[] = $obj;
		    }  
		}
		
		$r->free_result();
	    return $data;		
	}
	
	function Modify_Data($id = '',$arrayData){
		if($id == ''){//inssert
			$this->db->set($arrayData);
			$this->db->insert($this->table);
			return 1;
		}else{
			$this->db->where('id', $id);
			$this->db->update($this->table, $arrayData); 
			return 2;
		}
	}
	
	function Delete_Data($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table);
		return TRUE;
	}
	
	function ConstructKode($kode_golongan = NULL,$kode_asset= NULL){
		$kode = NULL;
		
		if ($kode_golongan != NULL && $kode_asset != NULL)
		{
			$kode = '2' . $kode_golongan . $kode_asset;
		}
		
		return $kode;
	}
}
?>