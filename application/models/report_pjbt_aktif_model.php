<?php
class Report_Pjbt_Aktif_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY($eselon=null){
    $sesi_type = $this->session->userdata("type_zs_simpeg");
    $a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
    $this->db->select('*');
    $this->db->from('tView_Pejabat_Aktif');
    if($sesi_type == 'OPD'){
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
    }elseif($this->input->post('kode_unker')){
			$this->db->where('kode_unker', $this->input->post('kode_unker'));
    }
    if($eselon == "I"){
    	$this->db->where_in('kode_eselon', array(11,12));
    	//$this->db->where_not_in('nama_jab', array("Camat", "Lurah"));
    }elseif($eselon == "II"){
    	$this->db->where_in('kode_eselon', array(21,22));
    }elseif($eselon == "III"){
    	$this->db->where_in('kode_eselon', array(31,32));
    }elseif($eselon == "IV"){
    	$this->db->where_in('kode_eselon', array(41,42));
    }elseif($eselon == "Camat"){
    	$this->db->where('nama_jab', "Camat");
    }elseif($eselon == "Lurah"){
    	$this->db->where('nama_jab', "Lurah");
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

	function get_AllData($eselon){
		$data = array();
		
		$this->get_QUERY($eselon);

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
   	$this->db->limit($limit, $start);
   	$this->db->order_by("kode_unor", "ASC");
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }
    return $data;
	}
	
	function get_CountData($eselon){
		$this->get_QUERY($eselon);
		return $this->db->count_all_results();
	}

	// START - CETAK DAFTAR NOMINATIF
	function get_AllPrint($eselon = null){
		$data = array();		
		$this->get_QUERY($eselon);
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}

	function get_SelectedPrint($eselon = null){
		$data = array();		
		$selected = explode('-', $this->input->post('postdata'));
		$this->get_QUERY();
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

	function get_ByRowsPrint($dari = null, $sampai = null, $eselon = null){
		$data = array();
  	$offset = $dari - 1;
  	$numrows = $sampai - $offset;
		$this->get_QUERY($eselon);
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