<?php
class Surat_Tugas_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_Surat_Tugas');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker_baru', $a_sesi_kode_unker);
		}
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(TMT_st)',$this->input->post('bulan'));
    	$this->db->where('YEAR(TMT_st)',$this->input->post('tahun'));
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
  		$this->db->from("tTrans_Surat_Tugas");
  		$this->db->where_in('IDT_ST',$ID);
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
		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_st'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tgl_sk_st = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_st'));
		$format_tgl = "$tahun-$bulan-$hari";
		$TMT_st = date("Y-m-d", strtotime($format_tgl));

		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_fung_tertentu' => $this->input->post('kode_fung_tertentu'),
			'jns_st' => $this->input->post('jns_st'),
			'berdasarkan' => $this->input->post('berdasarkan'),
			'kode_unor_baru' => $this->input->post('kode_unor_baru'),
			'kode_jab_baru' => $this->input->post('kode_jab_baru'),
			'kode_fung_tertentu_baru' => $this->input->post('kode_fung_tertentu_baru'),
			'deskripsi_st' => $this->input->post('deskripsi_st'),
			'no_sk_st' => $this->input->post('no_sk_st'),
			'tgl_sk_st' => $tgl_sk_st,
			'TMT_st' => $TMT_st
		);

  	if($this->input->post('IDT_ST')){
  		$data_ID = array('IDT_ST' => $this->input->post('IDT_ST'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_Surat_Tugas',$data, $data_ID);
  		$this->db->update('tTrans_Surat_Tugas',$data_s_update, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'), 'kode_unor_baru' => $this->input->post('kode_unor_baru'), 'kode_jab_baru' => $this->input->post('kode_jab_baru'), 'TMT_st' => $TMT_st);
  	$Q = $this->db->get_where('tTrans_Surat_Tugas', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_Surat_Tugas', $data);
  		$id = $this->db->insert_id();
  		$this->db->update('tTrans_Surat_Tugas', $data_s_insert, array('IDT_ST' => $id));
  		$this->db->trans_complete();
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}
	
	function Proses_Data(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$records = explode('-', $this->input->post('postdata'), -1);
		$data = $this->getBy_ArrayID($records);
		if(count($data)){
    	$this->db->trans_start();
    	foreach($data as $key => $list){		
  			$s_update_profil = false;
  			$data_jab = array(
					'NIP' => $list['NIP'],
					'kode_unor' => $list['kode_unor_baru'],
					'kode_golru' => $list['kode_golru'],
					'kode_jab' => $list['kode_jab_baru'],
					'kode_eselon' => 99,
					'kode_fung_tertentu' => $list['kode_fung_tertentu_baru'],
					'no_sk_jab' => $list['no_sk_st'],
					'tgl_sk_jab' => $list['tgl_sk_st'],
					'TMT_jab' => $list['TMT_st']
  			);
    		
    		$this->db->update('tTrans_Surat_Tugas', array('status_data' => 1), array('IDT_ST' => $list['IDT_ST']));
    		$s_update_profil = true;
    		
  			// Ubah data pada tPegawai dan tPegawai_Jabatan
    		if($s_update_profil == true){
  				$this->db->insert('tPegawai_Jabatan', $data_jab);
  				$IDP_Jab = $this->getLast_IDP_Jab($list['NIP']);
  				$W_NIP = array('NIP' => $list['NIP']);
  				$this->db->update('tPegawai', array('IDP_Jab' => $IDP_Jab, 'kode_unor' => $list['kode_unor_baru'], 'kode_jab' => $list['kode_jab_baru'], 'kode_eselon' => 99), $W_NIP);
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
    				$this->db->delete('tPegawai_Jabatan', array('NIP' => $list['NIP'], 'TMT_jab' => $list['TMT_st'], 'tgl_sk_jab' => $list['tgl_sk_st']));    				
  					$W_NIP = array('NIP' => $list['NIP']);
  					$IDP_Jab = $this->getLast_IDP_Jab($list['NIP']);
  					$this->db->update('tPegawai', array('IDP_Jab' => $IDP_Jab), $W_NIP);
    				$this->db->delete('tTrans_Surat_Tugas', array('IDT_ST' => $list['IDT_ST']));
    			}
    		}else{
    			$this->db->delete('tPegawai_Jabatan', array('NIP' => $list['NIP'], 'TMT_jab' => $list['TMT_st'], 'tgl_sk_jab' => $list['tgl_sk_st']));    				
  				$W_NIP = array('NIP' => $list['NIP']);
  				$IDP_Jab = $this->getLast_IDP_Jab($list['NIP']);
  				$this->db->update('tPegawai', array('IDP_Jab' => $IDP_Jab), $W_NIP);
    			$this->db->delete('tTrans_Surat_Tugas', array('IDT_ST' => $list['IDT_ST']));
    		}
    	}
  		$this->db->trans_complete();
		}
	}
	
	// PERIODE SURAT TUGAS --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_Surat_Tugas');
		
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
    $this->db->from('tPeriode_Surat_Tugas');
		return $this->db->count_all_results();
	}
	// PERIODE SURAT TUGAS --------------------------------------------------------- END
	
	// CETAK SURAT TUGAS PNS -------------------------------------------- START
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
		$this->db->where_in('IDT_ST', $selected);
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
	// CETAK SURAT TUGAS PNS -------------------------------------------- END
	
}
?>