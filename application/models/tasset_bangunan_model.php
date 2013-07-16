<?php
class Tasset_bangunan_Model extends MY_Model{
	
	function __construct(){
		parent::__construct();
		$this->table = 'tasset_bangunan';
	}
	
	function get_QUERY(){
	    $this->db->select('*');
		
	    $this->db->from('tasset_bangunan');
		
	    if ($this->input->get_post('query')){
	    	$this->db->like('kode_unor', $this->input->get_post('query'));
	    	$this->db->or_like('nama_unor', $this->input->get_post('query'));
	    	$this->db->or_like('jabatan_unor', $this->input->get_post('query'));
	    	$this->db->or_like('nama', $this->input->get_post('query'));
	      	$this->db->or_like('alamat', $this->input->get_post('query'));
	      	$this->db->or_like('nama_kabkota', $this->input->get_post('query'));
	      	$this->db->or_like('nama_prov', $this->input->get_post('query'));
	      	$this->db->or_like('kode_pos', $this->input->get_post('query'));
	      	$this->db->or_like('luas_tanah', $this->input->get_post('query'));
	      	$this->db->or_like('luas_bangunan', $this->input->get_post('query'));
	      	$this->db->or_like('image_url', $this->input->get_post('query'));
	    }
	    $this->Filters_Model->get_FILTER();
	}
	
	
	function get_AllData($start = NULL, $limit=NULL){
		$this->db->select('id,nama_unker,kode_unit_kerja,jabatan_unor,kode_unit_organisasi,kode_registrasi,kode_asset,kode_wilayah,
							nama,alamat,jalan,rt_rw,kecamatan,kelurahan,nama_kabkota,kode_kota,nama_prov,kode_provinsi,kode_pos,
							gedung_tanggal,gedung_nomor,bertingkat,beton,status,harga,keterangan,asal_usul,
							luas_tanah,luas_bangunan,luas_dasar_bangunan,jumlah_lantai,image_url');
		$this->db->join('tref_kabkota', 'tref_kabkota.ID_KK = '.$this->table.'.kode_kota');
		$this->db->join('tref_provinsi', 'tref_provinsi.kode_prov = '.$this->table.'.kode_provinsi');
		$this->db->join('tref_unor', 'tref_unor.kode_Unor = '.$this->table.'.kode_unit_organisasi');
		$this->db->join('tref_unitkerja', 'tref_unitkerja.kode_unker = '.$this->table.'.kode_unit_kerja');
		$this->db->order_by('alamat','ASC');
		
		if(isset($start) && isset($limit))
		{
			$this->db->limit($limit,$start);
		}
		
		
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
	
	function get_byIDs($ids)
	{
		$this->db->select('id,nama_unker,jabatan_unor,nama,alamat,nama_kabkota,nama_prov,kode_pos,luas_tanah,luas_bangunan,image_url');
		$this->db->join('tref_kabkota', 'tref_kabkota.ID_KK = '.$this->table.'.kode_kota');
		$this->db->join('tref_provinsi', 'tref_provinsi.kode_prov = '.$this->table.'.kode_provinsi');
		$this->db->join('tref_unor', 'tref_unor.kode_Unor = '.$this->table.'.kode_unit_organisasi');
		$this->db->join('tref_unitkerja', 'tref_unitkerja.kode_unker = '.$this->table.'.kode_unit_kerja');
		$this->db->order_by('alamat','ASC');
		$this->db->where_in('id',$ids);
		
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
	
	
	
	function get_AllPrint(){
	  	$data = array();
	  	$this->get_QUERY();
	  	$Q = $this->db->get('');
	  	if($Q->num_rows() > 0){
	  		foreach ($Q->result_array() as $row){
	  			$data[] = $row;
	  	  }
	  	}
	    $Q->free_result();
	    $this->db->close();
    	return $data;  	
	}
	
	
	function ConstructKode($kode_golongan = NULL,$kode_asset = NULL){
		$kode = NULL;
		
		if ($kode_golongan != NULL && $kode_asset != NULL)
		{
			$kode = '4' . $kode_golongan . $kode_asset;
		}
		
		return $kode;
	}
}
?>