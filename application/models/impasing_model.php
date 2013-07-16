<?php
class Impasing_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$sesi_kode_unker = $this->session->userdata("kode_unker_zs_simpeg");
		$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
    $this->db->select('*');
    $this->db->from('tView_Trans_Impasing');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD' && $sesi_kode_unker != 30028){
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(TMT_impg)',$this->input->post('bulan'));
    	$this->db->where('YEAR(TMT_impg)',$this->input->post('tahun'));
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
		
		$this->db->order_by("kode_golru", "DESC");
		
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
  		$this->db->from("tTrans_Impasing");
  		$this->db->where_in('IDT_IMPG',$ID);
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
		if($this->input->post('tgl_sk_impg') == "dd/mm/yyyy"){
			$tgl_sk_impg = null;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_impg'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sk_impg = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_impg') == "dd/mm/yyyy"){
			$TMT_impg = null;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_impg'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_impg = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_kgb_yad') == "dd/mm/yyyy"){
			$TMT_kgb_yad = null;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_kgb_yad'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_kgb_yad = date("Y-m-d", strtotime($format_tgl));
		}
		
		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_golru' => $this->input->post('kode_golru'),
			'mk_th_impg' => $this->input->post('mk_th_impg'),
			'mk_bl_impg' => $this->input->post('mk_bl_impg'),
			'gapok_lama' => $this->input->post('gapok_lama'),
			'gapok_baru' => $this->input->post('gapok_baru'),
			'mk_th_u_kgb' => $this->input->post('mk_th_u_kgb'),
			'mk_bl_u_kgb' => $this->input->post('mk_bl_u_kgb'),
			'no_sk_impg' => $this->input->post('no_sk_impg'),
			'tgl_sk_impg' => $tgl_sk_impg,
			'TMT_impg' => $TMT_impg,
			'TMT_kgb_yad' => $TMT_kgb_yad
		);

  	if($this->input->post('IDT_IMPG')){
  		$data_ID = array('IDT_IMPG' => $this->input->post('IDT_IMPG'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_Impasing',array_merge($data, $data_s_update), $data_ID);
  		$this->db->trans_complete();
  		$this->Session_Model->Write_Log_User("UPDATE INPASSING (tTrans_Impasing) IDT_IMPG=".$this->input->post('IDT_IMPG')." NIP=".$this->input->post('NIP'));
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'), 'status_data' => 0);
  	$Q = $this->db->get_where('tTrans_Impasing', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_Impasing', array_merge($data, $data_s_insert));
  		$id = $this->db->insert_id();
  		$this->db->trans_complete();
			$this->Session_Model->Write_Log_User("INSERT INPASSING (tTrans_Impasing) IDT_IMPG=".$id." NIP=".$this->input->post('NIP'));
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}
	
	function Proses_Data(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		$records = explode('-', $this->input->post('postdata'), -1);
		$data = $this->getBy_ArrayID($records);
		if(count($data)){
    	$this->db->trans_start();
    	foreach($data as $key => $list){		
    		if($list['no_sk_impg']){
	  			$s_update_profil = false;
	    		$data_proses = array_merge(array('status_data' => 1), $data_s_update);
	    		$this->db->update('tTrans_Impasing', $data_proses, array('IDT_IMPG' => $list['IDT_IMPG']));
	    		$this->Session_Model->Write_Log_User('PROSES INPASSING (tTrans_Impasing) IDT_IMPG='.$list['IDT_IMPG']." NIP=".$list['NIP']);
	    		
	  			// Ubah data pada tPegawai dan tPegawai_GajiBerkala
	    		if($s_update_profil == true){
	  				$W_NIP = array('NIP' => $list['NIP']);
	    		}
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
    		if($sesi_type == 'OPD' && $list['status_data'] == 1){
    			echo "Denied"; exit;
    		}else{
	    		$this->db->delete('tTrans_Impasing', array('IDT_IMPG' => $list['IDT_IMPG']));
	    		$this->Session_Model->Write_Log_User("DELETE INPASSING (tTrans_Impasing) IDT_IMPG=".$list['IDT_IMPG']." NIP=".$list['NIP']);
	    	}
    	}
  		$this->db->trans_complete();
		}
	}
	
	// AUTO IMPASING -------------------------------------------------------------- START
	function get_Count_Progress(){
    $this->db->select('*');
    $this->db->from('tView_Pegawai_Biodata');
    $this->db->where_in('kode_dupeg', array(1,17));
		return $this->db->count_all_results();
	}
	// AUTO IMPASING -------------------------------------------------------------- END
	
	// PERIODE INPASSING --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_Impasing');
		
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
    $this->db->from('tPeriode_Impasing');
		return $this->db->count_all_results();
	}
	// PERIODE INPASSING --------------------------------------------------------- END
	
	// CETAK IMPASING PNS -------------------------------------------- START
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
		$this->db->where_in('IDT_IMPG', $selected);
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
	// CETAK IMPASING PNS -------------------------------------------- END
	
}
?>