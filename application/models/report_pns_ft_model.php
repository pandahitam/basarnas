<?php
class Report_PNS_FT_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY($fung=null){
    $sesi_type = $this->session->userdata("type_zs_simpeg");
    $a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
    $this->db->select('*');
    $this->db->from('tView_PNS_FT');
    if($fung == "KEPSEK"){
    	$this->db->where('kode_klp_jab', 3);
    	$this->db->where('kode_fung', 5);
    }elseif($fung == "GK"){
    	$this->db->where('kode_klp_jab', 3);
    	$this->db->where('kode_fung', 1);
    }elseif($fung == "GMP"){
    	$this->db->where('kode_klp_jab', 3);
    	$this->db->where('kode_fung', 2);
    }elseif($fung == "GBK"){
    	$this->db->where('kode_klp_jab', 3);
    	$this->db->where('kode_fung', 3);
    }elseif($fung == "PS"){
    	$this->db->where('kode_klp_jab', 3);
    	$this->db->where('kode_fung', 6);
    }elseif($fung == "Dokter"){    	
    	$this->db->where('kode_klp_jab', 2);
    	$this->db->like('nama_jab', "Dokter");
    }elseif($fung == "Bidan"){
    	$this->db->where('kode_klp_jab', 2);
    	$this->db->like('nama_jab', "Bidan");
    }elseif($fung == "Perawat"){
    	$this->db->where('kode_klp_jab', 2);
    	$this->db->like('nama_jab', "Perawat");
    }elseif($fung == "Apoteker"){
    	$this->db->where('kode_klp_jab', 2);
    	$this->db->like('nama_jab', "Apoteker");
    }elseif($fung == "Teknis"){
    	$this->db->where('kode_klp_jab', 4);
    }
    if ($this->input->get_post('query')){
   		$qfilter_1 = str_replace(" ","",trim($this->input->post('query')));
   		$qfilter_2 = str_replace(".","",trim($this->input->post('query')));
   		if(is_numeric($qfilter_1) || is_numeric($qfilter_2)){
    		$this->db->like('NIP', trim($this->input->get_post('query')));
    	}else{
    		$this->db->like('f_namalengkap', trim($this->input->get_post('query')));
    	}
    }
	
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData($fung){
		$data = array();
		
		$this->get_QUERY($fung);

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }
    return $data;
	}
	
	function get_CountData($fung){
		$this->get_QUERY($fung);
		return $this->db->count_all_results();
	}

	// START - CETAK DAFTAR NOMINATIF
	function get_AllPrint($fung = null){
		$data = array();		
		$this->get_QUERY($fung);
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}

	function get_SelectedPrint($fung = null){
		$data = array();		
		$selected = explode('-', $this->input->post('postdata'));
		$this->get_QUERY($fung);
		$this->db->where_in('ID_Pegawai', $selected);
		$this->db->order_by("kode_unor", "ASC");
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}

	function get_ByRowsPrint($dari = null, $sampai = null, $fung = null){
		$data = array();
  	$offset = $dari - 1;
  	$numrows = $sampai - $offset;
		$this->get_QUERY($fung);
  	$this->db->limit($numrows, $offset);
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}
	// END - CETAK DAFTAR NOMINATIF

}
?>