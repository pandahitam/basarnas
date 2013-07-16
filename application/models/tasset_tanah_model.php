<?php
class Tasset_tanah_Model extends MY_Model {
	
	var $table;
	
	function __construct(){
		parent::__construct();
		$this->table = 'tasset_tanah';
	}
	
	function get_AllData(){
		$query = 'SELECT id,nama_unker,kode_asset,kode_wilayah,kode_registrasi,kode_unit_kerja,jabatan_unor,kode_unit_organisasi,alamat,
							jalan,rt_rw,kelurahan,kecamatan,tanda_utara,tanda_selatan,tanda_barat,tanda_timur,
							nama,asal_usul,harga,keterangan,sertifikat_tanggal,sertifikat_nomor,hak,bangunan,
							nama_kabkota,kode_kota,nama_prov,kode_provinsi,kode_pos,luas_tanah,luas_tanah_kosong,luas_tanah_bangunan,
							luas_tanah_lingkungan,image_url
				  FROM '.$this->table.'
				  JOIN tref_kabkota on tref_kabkota.ID_KK = '.$this->table.'.kode_kota
				  JOIN tref_provinsi on tref_provinsi.kode_prov = '.$this->table.'.kode_provinsi
				  JOIN tref_unor on tref_unor.kode_Unor = '.$this->table.'.kode_unit_organisasi
				  JOIN tref_unitkerja on tref_unitkerja.kode_unker = '.$this->table.'.kode_unit_kerja
				  ORDER BY alamat ASC';
		return $this->Get_By_Query($query);	
	}
	
	function get_byIDs($ids)
	{		
		$query = 'SELECT id,nama_unker,jabatan_unor,alamat,nama_kabkota,nama_prov,kode_pos,luas_tanah,image_url
				  FROM '.$this->table.'
				  JOIN tref_kabkota on tref_kabkota.ID_KK = '.$this->table.'.kode_kota
				  JOIN tref_provinsi on tref_provinsi.kode_prov = '.$this->table.'.kode_provinsi
				  JOIN tref_unor on tref_unor.kode_Unor = '.$this->table.'.kode_unit_organisasi
				  JOIN tref_unitkerja on tref_unitkerja.kode_unker = '.$this->table.'.kode_unit_kerja
				  WHERE id IN ('.$this->prepare_Query($ids).')
				  ORDER BY alamat ASC';
		return $this->Get_By_Query($query);
	}
	
	
	function ConstructKode($kode_golongan = NULL,$kode_asset = NULL){
		$kode = NULL;
		if ($kode_golongan != NULL && $kode_asset != NULL)
		{
			$kode = '2' . $kode_golongan . $kode_asset;
		}	
		return $kode;
	}
}
?>