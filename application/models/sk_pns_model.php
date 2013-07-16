<?php
class SK_PNS_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$sesi_kode_unker = $this->session->userdata("kode_unker_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_SK_PNS');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(TMT_PNS)',$this->input->post('bulan'));
    	$this->db->where('YEAR(TMT_PNS)',$this->input->post('tahun'));
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
  		$this->db->from("tTrans_SK_PNS");
  		$this->db->where_in('IDT_SK_PNS',$ID);
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
		if($this->input->post('tgl_sk_pns') == "dd/mm/yyyy"){
			$tgl_sk_pns = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_pns'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sk_pns = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_PNS') == "dd/mm/yyyy"){
			$TMT_PNS = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_PNS'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_PNS = date("Y-m-d", strtotime($format_tgl));
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
			'mk_th' => $this->input->post('mk_th'),
			'mk_bl' => $this->input->post('mk_bl'),
			'gapok' => $this->input->post('gapok'),
			'no_sk_pns' => $this->input->post('no_sk_pns'),
			'tgl_sk_pns' => $tgl_sk_pns,
			'TMT_PNS' => $TMT_PNS,
			'IDP_Pddk' => $this->input->post('IDP_Pddk'),
			'IDP_DP3' => $this->input->post('IDP_DP3'),
			'IDP_AK' => $this->input->post('IDP_AK'),
			'IDP_Diklat' => $this->input->post('IDP_Diklat'),
			'no_sk_rikes' => $this->input->post('no_sk_rikes'),
			'tgl_sk_rikes' => $tgl_sk_rikes,
			'ket' => $this->input->post('ket')
		);

  	if($this->input->post('IDT_SK_PNS')){
  		$data_ID = array('IDT_SK_PNS' => $this->input->post('IDT_SK_PNS'));
    	$this->db->trans_start();
    	$data_pns = array_merge($data, $data_s_update);
  		$this->db->update('tTrans_SK_PNS', $data_pns, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'));
  	$Q = $this->db->get_where('tTrans_SK_PNS', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
    	$data_pns = array_merge($data, $data_s_insert);
  		$this->db->insert('tTrans_SK_PNS', $data_pns);
  		$id = $this->db->insert_id();
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
  			$data_ID = array('IDT_SK_PNS' => $list['IDT_SK_PNS']);

				$data_kpkt = array(
					'NIP' => $list['NIP'],
					'jns_kpkt' => 'PNS',
					'kode_golru' => $list['kode_golru'],
					'no_sk_kpkt' => $list['no_sk_pns'],
					'TMT_kpkt' => $list['TMT_PNS'],
					'mk_th_kpkt' => $list['mk_th'],
					'mk_bl_kpkt' => $list['mk_bl'],
					'gapok_kpkt' => $list['gapok']
				);

    		$data_status = array_merge(array('status_data' => 1), $data_s_update);
    		$this->db->update('tTrans_SK_PNS',$data_status, $data_ID);
    		$s_update_profil = true;
    		
  			// Penambahan data pada tPegawai_Kepangkatan, dan Ubah IDP_Kpkt pada tPegawai
    		if($s_update_profil == true){
  				$W_NIP = array('NIP' => $list['NIP']);
  				$data_kpkt_ok = array_merge($data_kpkt, $data_s_insert);
    			$this->db->insert('tPegawai_Kepangkatan', $data_kpkt_ok);
  				$IDP_Kpkt = $this->Last_IDP_Model->KPKT($list['NIP']);
  				$this->db->update('tPegawai', array_merge(array('IDP_Kpkt' => $IDP_Kpkt), $data_s_update), $W_NIP);
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
    				$this->db->delete('tTrans_SK_PNS', array('IDT_SK_PNS' => $list['IDT_SK_PNS']));
    			}
    		}else{
    			$this->db->delete('tTrans_SK_PNS', array('IDT_SK_PNS' => $list['IDT_SK_PNS']));
    		}
    	}
  		$this->db->trans_complete();
		}
	}
	
	// PERIODE SK PNS --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_SK_PNS');
		
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
    $this->db->from('tPeriode_SK_PNS');
		return $this->db->count_all_results();
	}
	// PERIODE SK PNS --------------------------------------------------------- END
	
	// CETAK SK PNS ----------------------------------------------------------- START
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
		$this->db->where_in('IDT_SK_PNS', $selected);
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
	// CETAK SK PNS ----------------------------------------------------------- END
	
}
?>