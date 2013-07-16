<?php
class Report_Pgw_Pensiun_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
    $sesi_type = $this->session->userdata("type_zs_simpeg");
    $a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
    $this->db->select('*');
    $this->db->from('tView_Trans_Pensiun');
    if($sesi_type == 'OPD'){
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
    }elseif($this->input->post('kode_unker')){
			$this->db->where('kode_unker', $this->input->post('kode_unker'));
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
		$this->db->where("status_data", 1);
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData(){
		$data = array();
		
		$this->get_QUERY();

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
	
	function get_CountData(){
		$this->get_QUERY();
		return $this->db->count_all_results();
	}

	function get_AllData_Rekap_Gol(){
		$data = array();
		
		$this->db->select("*");
		$this->db->from("tView_Rekap_Golru_Pensiun");
		
		if($this->input->post('tahun')){
			$this->db->where("tahun", $this->input->post('tahun'));
		}else{
			$this->db->where("tahun", date('Y'));
		}
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

	function get_CountData_Rekap_Gol(){
		return $this->db->count_all("tView_Rekap_Golru_Pensiun");
	}

	// PERIODE --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_Pensiun_Tahun');
		
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
	
	function get_CountData_Periode(){
    $this->db->select('*');
    $this->db->from('tPeriode_Pensiun_Tahun');
		return $this->db->count_all_results();
	}
	// PERIODE --------------------------------------------------------- END
	
	// CETAK DAFTAR NOMINATIF PNS -------------------------------------------- START
	function get_AllPrint(){
		$data = array();		
		$this->get_QUERY();
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}

	function get_SelectedPrint(){
		$data = array();		
		$selected = explode('-', $this->input->post('postdata'));
		$this->get_QUERY();
		$this->db->where_in('IDT_Pensiun', $selected);
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}

	function get_ByRowsPrint($dari = null, $sampai = null){
		$data = array();
  	$offset = $dari - 1;
  	$numrows = $sampai - $offset;
		$this->get_QUERY();
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
	// CETAK DAFTAR NOMINATIF PNS -------------------------------------------- END

}
?>