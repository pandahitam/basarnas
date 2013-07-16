<?php
class SK_MPP_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_SK_MPP');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('tahun')){
    	$this->db->where('YEAR(TMT_sk_mpp)',$this->input->post('tahun'));
    }
    if ($this->input->get_post('query')){
   		$qfilter_1 = str_replace(" ","",trim($this->input->post('query')));
   		$qfilter_2 = str_replace(".","",trim($this->input->post('query')));
   		if(is_numeric($qfilter_1) || is_numeric($qfilter_2)){
   			$this->db->like('NIP', trim($this->input->post('query')));
   		}else{
   			$this->db->like('f_namalengkap', trim($this->input->post('query')));
   		}
    }
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
	
	function getLast_IDP_Jab($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Jab = '';
  		$Q = $this->db->query("SELECT f_idp_jab('".$NIP."') AS IDP_Jab");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Jab = $data['IDP_Jab'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Jab;			
		}
	}

	function getNIP_Kepala_Unker($kode_unker=''){
		if($kode_unker){
  		$data = array(); $NIP = '';
  		$Q = $this->db->query("SELECT f_nip_kepala_unker('".$kode_unker."') AS NIP");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$NIP = $data['NIP'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $NIP;			
		}
	}

	function CariNIP($NIP=0){
  	$data = array();
  	$options = array('NIP' => $NIP);
  	$Q = $this->db->get_where('tView_Pegawai_Biodata', $options, 1);
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	
	function getBy_ArrayID($ID = array()){
		if(count($ID)){
			$data = array();
			$this->db->select('*');
  		$this->db->from("tTrans_SK_MPP");
  		$this->db->where_in('IDT_SK_MPP',$ID);
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
		if($this->input->post('tgl_sk_mpp') == "dd/mm/yyyy"){
			$tgl_sk_mpp = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_mpp'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sk_mpp = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_sk_mpp') == "dd/mm/yyyy"){
			$TMT_sk_mpp = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_sk_mpp'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_sk_mpp = date("Y-m-d", strtotime($format_tgl));
		}

		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jab' => $this->input->post('kode_jab'),
			'no_sk_mpp' => $this->input->post('no_sk_mpp'),
			'tgl_sk_mpp' => $tgl_sk_mpp,
			'TMT_sk_mpp' => $TMT_sk_mpp
		);

  	if($this->input->post('IDT_SK_MPP')){
  		$data_ID = array('IDT_SK_MPP' => $this->input->post('IDT_SK_MPP'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_SK_MPP',$data, $data_ID);
  		$this->db->update('tTrans_SK_MPP',$data_s_update, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'));
  	$Q = $this->db->get_where('tTrans_SK_MPP', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_SK_MPP', $data);
  		$id = $this->db->insert_id();
  		$this->db->update('tTrans_SK_MPP', $data_s_insert, array('IDT_SK_MPP' => $id));
  		$this->db->trans_complete();
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}
	
	function Proses_Data(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		$records = explode('-', $this->input->post('postdata'), -1);
		$data = $this->getBy_ArrayID($records);
		if(count($data)){
    	$this->db->trans_start();
    	foreach($data as $key => $list){		
  			$s_update_profil = false;
  			$data_ID = array('IDT_SK_MPP' => $list['IDT_SK_MPP']);
    		if($sesi_type == 'OPD'){
    			if($list['createdBy'] == $this->session->userdata("user_zs_simpeg")){
    				$this->db->update('tTrans_SK_MPP',$data_s_update, $data_ID);
    				$this->db->update('tTrans_SK_MPP', array('status_data' => 1), $data_ID);
    				$s_update_profil = true;
    			}
    		}else{
    			$this->db->update('tTrans_SK_MPP',$data_s_update, $data_ID);
    			$this->db->update('tTrans_SK_MPP', array('status_data' => 1), $data_ID);
    			$s_update_profil = true;
    		}
    		
  			// Ubah kode_dupeg pada tPegawai
    		if($s_update_profil == true){
  				$W_NIP = array('NIP' => $list['NIP']);
  				$this->db->update('tPegawai', array('kode_dupeg' => 21), $W_NIP);
  				$this->db->update('tPegawai', $data_s_update, $W_NIP);
    		}
  		}
  		$this->db->trans_complete();
  	}
	}
	
	function Delete_Data(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$records = explode('-', $this->input->post('postdata'), -1);
		$data = $this->getBy_ArrayID($records);
		if(count($data)){
    	$this->db->trans_start();
    	foreach($data as $key => $list){	
    		$s_update_profil = false;	
    		if($sesi_type == 'OPD'){
    			if($list['createdBy'] == $this->session->userdata("user_zs_simpeg")){
    				$this->db->delete('tTrans_SK_MPP', array('IDT_SK_MPP' => $list['IDT_SK_MPP']));
    			}
    		}else{
    			$this->db->delete('tTrans_SK_MPP', array('IDT_SK_MPP' => $list['IDT_SK_MPP']));
    		}
    	}
  		$this->db->trans_complete();
		}
	}
	
	// PERIODE SK MPP --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_SK_MPP');
		
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
    $this->db->from('tPeriode_SK_MPP');
		return $this->db->count_all_results();
	}
	// PERIODE SK MPP --------------------------------------------------------- END
	
	// CETAK SK MPP PNS -------------------------------------------- START
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
		$this->db->where_in('IDT_SK_MPP', $selected);
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
	// CETAK SK MPP PNS -------------------------------------------- END
	
}
?>