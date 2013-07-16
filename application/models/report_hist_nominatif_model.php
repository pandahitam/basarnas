<?php
class Report_Hist_Nominatif_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
    $sesi_type = $this->session->userdata("type_zs_simpeg");
    $a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
    $this->db->select('*');
    $this->db->from('tView_Rpt_Pegawai_History');
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
    $this->db->where_in('kode_dupeg', array(1,17));

		$this->db->order_by("kode_eselon", "ASC");
	  $this->db->order_by("kode_golru", "DESC");
	  $this->db->order_by("TMT_Kpkt", "ASC");
	  $this->db->order_by("urut_unor", "ASC");
	
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

	function getBy_ArrayID($ID = array()){
		if(count($ID)){
			$data = array();
			$this->db->select('*');
  		$this->db->from("tRpt_Periode_History");
  		$this->db->where_in('ID_PHistory',$ID);
  		$Q = $this->db->get('');
  		if($Q->num_rows() > 0){
  			foreach ($Q->result_array() as $row){
  				$data[] = $row;
  	  	}
  		}
    	$Q->free_result();
    	return $data;
		}
	}

	function Insert_Data(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		if($sesi_type != "OPD"){
			if($this->input->post('tgl_rpt') == "dd/mm/yyyy"){
				$tgl_rpt = NULL;
			}else{
				list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_rpt'));
				$format_tgl = "$tahun-$bulan-$hari";
				$tgl_rpt = date("Y-m-d", strtotime($format_tgl));
			}
			
			$data = array(
				'tgl_rpt' => $tgl_rpt,
				'ket_rpt' => $this->input->post('ket_rpt'),
				'createdBy' => $this->session->userdata("user_zs_simpeg"),
				'createdDate' => date("Y-m-d H:i:s")
			);
			
	  	$options = array('tgl_rpt' => $tgl_rpt);
	  	$Q = $this->db->get_where('tRpt_Periode_History', $options,1);
	  	if($Q->num_rows() > 0){
	  	  return "Exist";
	    }else{
	    	$this->db->trans_start();
	  		$this->db->insert('tRpt_Periode_History', $data);
	  		$id = $this->db->insert_id();
	  		$call_p = $this->db->query("CALL Proc_Rpt_History_Pegawai (".$id.", @_hasil)");
	  		$this->db->trans_complete();
	  	  return $id;
	    }
	  	$Q->free_result();
	  	$this->db->close();
	  }else{
	  	return "Failed";
	  }
	}

	function Delete_Data(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		if($sesi_type != "OPD"){
			$records = explode('-', $this->input->post('postdata'), -1);
			$data = $this->getBy_ArrayID($records);
			if(count($data)){
	    	$this->db->trans_start();
	    	foreach($data as $key => $list){	
	    		if($sesi_type != 'OPD'){
	    			$this->db->delete('tRpt_Periode_History', array('ID_PHistory' => $list['ID_PHistory']));
	    			$this->db->delete('tRpt_Pegawai_History', array('ID_PHistory' => $list['ID_PHistory']));
	    		}
	    	}
	  		$this->db->trans_complete();
			}
		}
	}

	// PERIODE --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tRpt_Periode_History');
		
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
    $this->db->from('tRpt_Periode_History');
		return $this->db->count_all_results();
	}
	// PERIODE --------------------------------------------------------- END

	// GROUP UNIT KERJA --------------------------------------------------------- START
	function get_AllData_Group_Unker(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tView_Rpt_Pegawai_History_GUK');
		$this->db->where('ID_PHistory', $this->input->post('ID_PHistory'));
		
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
		$this->Filters_Model->get_FILTER();
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj){
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Group_Unker(){
    $this->db->select('*');
    $this->db->from('tView_Rpt_Pegawai_History_GUK');
    $this->db->where('ID_PHistory', $this->input->post('ID_PHistory'));
    $this->Filters_Model->get_FILTER();
		return $this->db->count_all_results();
	}
	// GROUP UNIT KERJA --------------------------------------------------------- END
	
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
		$this->db->where_in('ID_Pegawai', $selected);
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