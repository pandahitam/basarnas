<?php
class Pddk_Formal_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_Pddk');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('kode_jenjang_pddk')){
    	$this->db->where('kode_jenjang_pddk',$this->input->post('kode_jenjang_pddk'));
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
	
	function getLast_IDP_Pddk($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Pddk = '';
  		$Q = $this->db->query("SELECT f_idp_pddk('".$NIP."') AS IDP_Pddk");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Pddk = $data['IDP_Pddk'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Pddk;			
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
  		$this->db->from("tTrans_Pddk");
  		$this->db->where_in('IDT_Pddk',$ID);
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
		if($this->input->post('tgl_ijazah') == "dd/mm/yyyy"){
			$tgl_ijazah = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_ijazah'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_ijazah = date("Y-m-d", strtotime($format_tgl));
		}

		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_pddk' => $this->input->post('kode_pddk'),
			'jurusan' => $this->input->post('jurusan'),
			'nama_institusi' => $this->input->post('nama_institusi'),
			'akreditas_institusi' => $this->input->post('akreditas_institusi'),
			'status_institusi' => $this->input->post('status_institusi'),
			'alamat_institusi' => $this->input->post('alamat_institusi'),
			'tahun_masuk' => $this->input->post('tahun_masuk'),
			'tahun_lulus' => $this->input->post('tahun_lulus'),
			'no_ijazah' => $this->input->post('no_ijazah'),
			'tgl_ijazah' => $tgl_ijazah,
			'rata2_ijazah' => $this->input->post('rata2_ijazah')
		);

  	if($this->input->post('IDT_Pddk')){
  		$data_ID = array('IDT_Pddk' => $this->input->post('IDT_Pddk'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_Pddk',$data, $data_ID);
  		$this->db->update('tTrans_Pddk',$data_s_update, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'), 'kode_pddk' => $this->input->post('kode_pddk'));
  	$Q = $this->db->get_where('tTrans_Pddk', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_Pddk', $data);
  		$id = $this->db->insert_id();
  		$this->db->update('tTrans_Pddk', $data_s_insert, array('IDT_Pddk' => $id));
  		$this->db->trans_complete();
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
  			$data_ID = array('IDT_Pddk' => $list['IDT_Pddk']);

    		if($sesi_type == 'OPD'){
    			if($list['createdBy'] == $this->session->userdata("user_zs_simpeg")){
    				$this->db->update('tTrans_Pddk', $data_s_update, $data_ID);
    				$this->db->update('tTrans_Pddk', array('status_data' => 1), $data_ID);
    				$s_update_profil = true;
    			}
    		}else{
    			$this->db->update('tTrans_Pddk', $data_s_update, $data_ID);
    			$this->db->update('tTrans_Pddk', array('status_data' => 1), $data_ID);
    			$s_update_profil = true;
    		}
    		
  			// Perubahan pada Profil (tPegawai_Pendidikan)
    		if($s_update_profil == true){
  				$W_NIP = array('NIP' => $list['NIP']);

					$data_Pddk = array(
						'NIP' => $list['NIP'],
						'kode_pddk' => $list['kode_pddk'],
						'jurusan' => $list['jurusan'],
						'nama_institusi' => $list['nama_institusi'],
						'akreditas_institusi' => $list['akreditas_institusi'],
						'status_institusi' => $list['status_institusi'],
						'alamat_institusi' => $list['alamat_institusi'],
						'tahun_masuk' => $list['tahun_masuk'],
						'tahun_lulus' => $list['tahun_lulus'],
						'no_ijazah' => $list['no_ijazah'],
						'tgl_ijazah' => $list['tgl_ijazah'],
						'rata2_ijazah' => $list['rata2_ijazah']
					);
					
		  		$this->db->insert('tPegawai_Pendidikan', array_merge($data_Pddk, $data_s_insert));
		  		$IDP_Pddk = $this->Last_IDP_Model->PDDK($list['NIP']);
		  		$this->db->update('tPegawai', array_merge($data_s_update, array('IDP_Pddk' => $id)), $W_NIP);
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
    				$this->db->delete('tTrans_Pddk', array('IDT_Pddk' => $list['IDT_Pddk']));
    			}
    		}else{
    			$this->db->delete('tTrans_Pddk', array('IDT_Pddk' => $list['IDT_Pddk']));
    		}
    	}
  		$this->db->trans_complete();
		}
	}
	
	// PERIODE PRA JABATAN --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_PraJab');
		
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
    $this->db->from('tPeriode_PraJab');
		return $this->db->count_all_results();
	}
	// PERIODE PRA JABATAN --------------------------------------------------------- END
	
	// CETAK PRA JABATAN PNS -------------------------------------------- START
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
		$this->db->select('*');
		$this->db->from('tView_Trans_Pddk');
		$this->db->where_in('IDT_Pddk', $selected);
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
	// CETAK PRA JABATAN PNS -------------------------------------------- END
	
}
?>