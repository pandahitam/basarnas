<?php
class Penyesuaian_MKG_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_PMKG');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(TMT_pmkg)',$this->input->post('bulan'));
    	$this->db->where('YEAR(TMT_pmkg)',$this->input->post('tahun'));
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
  		$this->db->from("tTrans_PMKG");
  		$this->db->where_in('IDT_PMKG',$ID);
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
		list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_pmkg'));
		$format_tgl = "$tahun-$bulan-$hari";
		$TMT_pmkg = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_honor'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tgl_sk_honor = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_honor_m'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tgl_honor_m = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_honor_s'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tgl_honor_s = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_terhitung_m'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tgl_terhitung_m = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_terhitung_s'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tgl_terhitung_s = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_usul'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tgl_usul = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_bkn'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tgl_bkn = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_yad'));
		$format_tgl = "$tahun-$bulan-$hari";
		$TMT_yad = date("Y-m-d", strtotime($format_tgl));

		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_pddk' => $this->input->post('kode_pddk'),
			'tahun_lulus' => $this->input->post('tahun_lulus'),
			'mk_th_lama' => $this->input->post('mk_th_lama'),
			'mk_bl_lama' => $this->input->post('mk_bl_lama'),
			'gapok_lama' => $this->input->post('gapok_lama'),
			'kode_golru_usul' => $this->input->post('kode_golru_usul'),
			'mk_th_usul' => $this->input->post('mk_th_usul'),
			'mk_bl_usul' => $this->input->post('mk_bl_usul'),
			'gapok_usul' => $this->input->post('gapok_usul'),
			'TMT_pmkg' => $TMT_pmkg,
			'no_sk_honor' => $this->input->post('no_sk_honor'),
			'tgl_sk_honor' => $tgl_sk_honor,
			'tgl_honor_m' => $tgl_honor_m,
			'tgl_honor_s' => $tgl_honor_s,
			'mk_th_honor' => $this->input->post('mk_th_honor'),
			'mk_bl_honor' => $this->input->post('mk_bl_honor'),
			'tgl_terhitung_m' => $tgl_terhitung_m,
			'tgl_terhitung_s' => $tgl_terhitung_s,
			'mk_th_terhitung' => $this->input->post('mk_th_terhitung'),
			'mk_bl_terhitung' => $this->input->post('mk_bl_terhitung'),
			'no_usul' => $this->input->post('no_usul'),
			'tgl_usul' => $tgl_usul,
			'no_bkn' => $this->input->post('no_bkn'),
			'tgl_bkn' => $tgl_bkn,
			'TMT_yad' => $TMT_yad,
			'mk_th_yad' => $this->input->post('mk_th_yad'),
			'mk_bl_yad' => $this->input->post('mk_bl_yad')
		);

  	if($this->input->post('IDT_PMKG')){
  		$data_ID = array('IDT_PMKG' => $this->input->post('IDT_PMKG'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_PMKG',$data, $data_ID);
  		$this->db->update('tTrans_PMKG',$data_s_update, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'));
  	$Q = $this->db->get_where('tTrans_PMKG', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_PMKG', $data);
  		$id = $this->db->insert_id();
  		$this->db->update('tTrans_PMKG', $data_s_insert, array('IDT_PMKG' => $id));
  		$this->db->trans_complete();
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}
	
	function Proses_Data(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$records = explode('-', $this->input->post('postdata'));
		$data = $this->getBy_ArrayID($records);
		if(count($data)){
    	$this->db->trans_start();
    	foreach($data as $key => $list){		
    		if($list['no_bkn'] && $list['tgl_bkn']){
    			$this->db->update('tTrans_PMKG', array('status_data' => 1), array('IDT_PMKG' => $list['IDT_PMKG']));
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
    		if($sesi_type != 'OPD'){
    			$this->db->delete('tTrans_PMKG', array('IDT_PMKG' => $list['IDT_PMKG']));
    		}
    	}
  		$this->db->trans_complete();
		}
	}
	
	// PERIODE PENYESUAIAN MKG --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_PMKG');
		
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
    $this->db->from('tPeriode_PMKG');
		return $this->db->count_all_results();
	}
	// PERIODE PENYESUAIAN MKG --------------------------------------------------------- END
	
	// CETAK PENYESUAIAN MKG -------------------------------------------- START
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
		$this->db->where_in('IDT_PMKG', $selected);
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
	// CETAK PENYESUAIAN MKG -------------------------------------------- END
	
}
?>