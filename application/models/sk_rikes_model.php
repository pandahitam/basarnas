<?php
class SK_RiKes_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_SK_RiKes');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			//$this->db->where_in('kode_unker', $a_sesi_kode_unker);
			$this->db->where_in('kode_lokasi', $a_sesi_kode_unker);
		}
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(tgl_jadwal)',$this->input->post('bulan'));
    	$this->db->where('YEAR(tgl_jadwal)',$this->input->post('tahun'));
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
  		$this->db->from("tTrans_SK_RiKes");
  		$this->db->where_in('IDT_SK_RK',$ID);
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
		if($this->input->post('berdasarkan_tgl') == "dd/mm/yyyy"){
			$berdasarkan_tgl = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('berdasarkan_tgl'));
			$format_tgl = "$tahun-$bulan-$hari";
			$berdasarkan_tgl = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('tgl_permintaan') == "dd/mm/yyyy"){
			$tgl_permintaan = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_permintaan'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_permintaan = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('tgl_jadwal') == "dd/mm/yyyy"){
			$tgl_jadwal = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_jadwal'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_jadwal = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('tgl_sk_rikes') == "dd/mm/yyyy"){
			$tgl_sk_rikes = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_rikes'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sk_rikes = date("Y-m-d", strtotime($format_tgl));
		}

		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jab' => $this->input->post('kode_jab'),
			'berdasarkan' => $this->input->post('berdasarkan'),
			'berdasarkan_no' => $this->input->post('berdasarkan_no'),
			'berdasarkan_tgl' => $berdasarkan_tgl,
			'atas_permintaan' => $this->input->post('atas_permintaan'),
			'no_permintaan' => $this->input->post('no_permintaan'),
			'tgl_permintaan' => $tgl_permintaan,
			'kode_lokasi' => $this->input->post('kode_lokasi'),
			'tgl_jadwal' => $tgl_jadwal,
			'no_sk_rikes' => $this->input->post('no_sk_rikes'),
			'tgl_sk_rikes' => $tgl_sk_rikes,
			'kode_hasil_rikes' => $this->input->post('kode_hasil_rikes'),
			'NIP_ketua_penguji' => $this->input->post('NIP_ketua_penguji'),
			'nama_ketua_penguji' => $this->input->post('nama_ketua_penguji')
		);

  	if($this->input->post('IDT_SK_RK')){
  		$data_ID = array('IDT_SK_RK' => $this->input->post('IDT_SK_RK'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_SK_RiKes',array_merge($data, $data_s_update), $data_ID);
  		$this->db->trans_complete();
  		$this->Session_Model->Write_Log_User('UPDATE SK RIKES (tTrans_SK_RiKes) IDT_SK_RK='.$this->input->post('IDT_SK_RK')." NIP=".$this->input->post('NIP'));
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'), 'status_data' => 0);
  	$Q = $this->db->get_where('tTrans_SK_RiKes', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_SK_RiKes', array_merge($data, $data_s_insert));
  		$id = $this->db->insert_id();
  		$this->db->trans_complete();
  		$this->Session_Model->Write_Log_User('INSERT SK RIKES (tTrans_SK_RiKes) IDT_SK_RK='.$id." NIP=".$this->input->post('NIP'));
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
  			$s_update_profil = false;
  			$data_ID = array('IDT_SK_RK' => $list['IDT_SK_RK']);
  			$data_proses = array_merge(array('status_data' => 1), $data_s_update);
  			$this->db->update('tTrans_SK_RiKes', $data_proses, $data_ID);
  			$this->Session_Model->Write_Log_User('PROSES SK RIKES (tTrans_SK_RiKes) IDT_SK_RK='.$list['IDT_SK_RK']." NIP=".$list['NIP']);

  			// Tidak ada perubahan pada Profil Pegawai
    		if($s_update_profil == true){
  				$W_NIP = array('NIP' => $list['NIP']);
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
	    		$this->db->delete('tTrans_SK_RiKes', array('IDT_SK_RK' => $list['IDT_SK_RK']));
	    		$this->Session_Model->Write_Log_User('DELETE SK RIKES (tTrans_SK_RiKes) IDT_SK_RK='.$list['IDT_SK_RK']." NIP=".$list['NIP']);
	    	}
    	}
  		$this->db->trans_complete();
		}
	}

	function get_Ref_Hasil_Rikes(){
		$data = array();		
    $Q = $this->db->get('tRef_Hasil_Rikes');
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}
	
	// PERIODE SK RIKES --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_SK_RiKes');
		
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
    $this->db->from('tPeriode_SK_RiKes');
		return $this->db->count_all_results();
	}
	// PERIODE SK RIKES --------------------------------------------------------- END
	
	// CETAK SK RIKES -------------------------------------------- START
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
		$this->db->where_in('IDT_SK_RK', $selected);
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
	// CETAK SK RIKES -------------------------------------------- END
	
}
?>