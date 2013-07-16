<?php
class KGB_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_KGB');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(TMT_kgb)',$this->input->post('bulan'));
    	$this->db->where('YEAR(TMT_kgb)',$this->input->post('tahun'));
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
  		$this->db->from("tTrans_KGB");
  		$this->db->where_in('IDT_KGB',$ID);
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
		if($this->input->post('tgl_sk_lama') == "dd/mm/yyyy"){
			$tgl_sk_lama = null;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_lama'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sk_lama = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('tgl_sk_kgb') == "dd/mm/yyyy"){
			$tgl_sk_kgb = null;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_kgb'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sk_kgb = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_kgb') == "dd/mm/yyyy"){
			$TMT_kgb = null;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_kgb'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_kgb = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_lama') == "dd/mm/yyyy"){
			$TMT_lama = null;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_lama'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_lama = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_yad') == "dd/mm/yyyy"){
			$TMT_yad = null;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_yad'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_yad = date("Y-m-d", strtotime($format_tgl));
		}
		
		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_golru' => $this->input->post('kode_golru'),
			'no_sk_lama' => $this->input->post('no_sk_lama'),
			'tgl_sk_lama' => $tgl_sk_lama,
			'mk_th_lama' => $this->input->post('mk_th_lama'),
			'mk_bl_lama' => $this->input->post('mk_bl_lama'),
			'gapok_lama' => $this->input->post('gapok_lama'),
			'TMT_lama' => $TMT_lama,
			'pejabat_lama' => $this->input->post('pejabat_lama'),
			'mk_th_baru' => $this->input->post('mk_th_baru'),
			'mk_bl_baru' => $this->input->post('mk_bl_baru'),
			'gapok_baru' => $this->input->post('gapok_baru'),
			'no_sk_kgb' => $this->input->post('no_sk_kgb'),
			'tgl_sk_kgb' => $tgl_sk_kgb,
			'TMT_kgb' => $TMT_kgb,
			'TMT_yad' => $TMT_yad
		);

  	if($this->input->post('IDT_KGB')){
  		$data_ID = array('IDT_KGB' => $this->input->post('IDT_KGB'));
    	$this->db->trans_start();
    	$data_kgb = array_merge($data, $data_s_update);
  		$this->db->update('tTrans_KGB',$data_kgb, $data_ID);
  		$this->db->trans_complete();
  		$this->Session_Model->Write_Log_User("UPDATE KGB (tTrans_KGB) IDT_KGB=".$this->input->post('IDT_KGB')." NIP=".$this->input->post('NIP'));
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'), 'status_data' => 0);
  	$Q = $this->db->get_where('tTrans_KGB', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
    	$data_kgb = array_merge($data, $data_s_update);
  		$this->db->insert('tTrans_KGB', $data_kgb);
  		$id = $this->db->insert_id();
  		$this->db->trans_complete();
  		$this->Session_Model->Write_Log_User("INSERT KGB (tTrans_KGB) IDT_KGB=".$id." NIP=".$this->input->post('NIP'));
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
		$data_proses = $this->getBy_ArrayID($records);
		if(count($data_proses)){
    	$this->db->trans_start();
    	foreach($data_proses as $key => $list){		
    		if($list['no_sk_kgb'] && $list['TMT_kgb']){
	  			$s_update_profil = false;
	  			$data = array(
						'NIP' => $list['NIP'],
						'gapok_lama' => $list['gapok_lama'],
						'no_sk_kgb' => $list['no_sk_kgb'],
						'tgl_sk_kgb' => $list['tgl_sk_kgb'],
						'gapok_baru' => $list['gapok_baru'],
						'mk_th_kgb' => $list['mk_th_baru'],
						'mk_bl_kgb' => $list['mk_bl_baru'],
						'TMT_kgb' => $list['TMT_kgb'],
						'TMT_berikutnya' => $list['TMT_yad'],
						'kode_golru' => $list['kode_golru']
	  			);

	    		$this->db->update('tTrans_KGB', array_merge(array('status_data' => 1), $data_s_update), array('IDT_KGB' => $list['IDT_KGB']));
	    		$s_update_profil = true;
	    		$this->Session_Model->Write_Log_User("PROSES KGB (tTrans_KGB) IDT_KGB=".$list['IDT_KGB']." NIP=".$list['NIP']);
	    		
	  			// Ubah data pada tPegawai dan tPegawai_GajiBerkala
	    		if($s_update_profil == true){
	    			$data_kgb = array_merge($data, $data_s_insert);
	  				$this->db->insert('tPegawai_GajiBerkala', $data_kgb);
	  				$IDP_KGB = $this->Last_IDP_Model->KGB($list['NIP']);
	  				$W_NIP = array('NIP' => $this->input->post('NIP'));
	  				$this->db->update('tPegawai', array_merge(array('IDP_KGB' => $IDP_KGB), $data_s_update), $W_NIP);
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
	    		$this->db->delete('tTrans_KGB', array('IDT_KGB' => $list['IDT_KGB']));
	    		$this->Session_Model->Write_Log_User("DELETE KGB (tTrans_KGB) IDT_KGB=".$list['IDT_KGB']." NIP=".$list['NIP']);
	    	}
    	}
  		$this->db->trans_complete();
		}
	}
	
	function getData_KGB_Baru(){
		$data_kgb = array();
  	$Q = $this->db->query("CALL Proc_Get_KGB_Baru('".$this->input->post('NIP')."')");
  	if($Q->num_rows() > 0){
  		$data_kgb = $Q->row_array();
    }
    $Q->free_result();
    return $data_kgb;
	}
			
	// AUTO KGB -------------------------------------------------------------- START
	function get_Count_Progress(){
    $this->db->select('*');
    $this->db->from('tPegawai');
    $this->db->where_in('kode_dupeg', array(1,17));
		return $this->db->count_all_results();
	}
	
	function Get_Data_Pegawai(){
		$data = array();
		$this->db->select('*');
  	$this->db->from("tView_Pegawai_Biodata");
  	$this->db->where_in('kode_dupeg', array(1,17));
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	 	}
  	}
    $Q->free_result();
    return $data;
	}
	
	function Insert_Data_Auto(){
		$data_pgw = $this->Get_Data_Pegawai();
		if(count($data_pgw)){
 			ini_set("time_limit","0");
 			ini_set("max_execution_time","900");
 			ini_set("max_input_time","1800");
 			ini_set("memory_limit","384M");
  		
  		$tgl_kgb = date('Y-m-d', strtotime('01/01'.date('Y')));
  		foreach($data_pgw as $key => $list){
  			$this->db->trans_start();
  			$options = array('NIP' => $list['NIP'], 'status_data' => 0);
  			$Q = $this->db->get_where('tTrans_KGB', $options);
  			if($Q->num_rows() <= 0){
					$data_insert = array(
						'NIP' => $list['NIP'],
						'kode_unor' => $list['kode_unor'],
						'kode_jab' => $list['kode_jab'],
						'kode_golru' => $list['kode_golru'],
						'mk_th_lama' => $list['mk_th_kgb'],
						'mk_bl_lama' => $list['mk_bl_kgb'],
						'gapok_lama' => $list['gapok_baru'],
						'gapok_baru' => null,
						'mk_th_baru' => null,
						'mk_bl_baru' => null,
						'no_sk_kgb' => null,
						'tgl_sk_kgb' => $tgl_kgb,
						'TMT_kgb' => $tgl_kgb,
						'TMT_yad' => $tgl_kgb
					);
  				$this->db->insert('tTrans_KGB', $data_insert);
  				$id = $this->db->insert_id();
  				$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
  				$this->db->update('tTrans_KGB', $data_s_insert, array('IDT_KGB' => $id));
    		}
  			$Q->free_result();
  			$this->db->trans_complete();
  		}
  		$this->Session_Model->Write_Log_User('AUTO KGB (tTrans_KGB)');
  		return "Sukses";
  	}else{
  		return "Gagal";
  	}
	}
	
	function Insert_Data_On_Loop($data_insert = array()){
	}
	// AUTO KGB -------------------------------------------------------------- END
	
	// PERIODE KGB --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_KGB');
		
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
    $this->db->from('tPeriode_KGB');
		return $this->db->count_all_results();
	}
	// PERIODE KGB --------------------------------------------------------- END
	
	// CETAK KGB PNS -------------------------------------------- START
	function get_AllPrint(){
		$data = array();		
		$this->get_QUERY();
		$this->db->order_by('TMT_kgb', 'ASC');
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
		$this->db->where_in('IDT_KGB', $selected);
		$this->db->order_by('TMT_kgb', 'ASC');
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
		$this->db->order_by('TMT_kgb', 'ASC');
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
	// CETAK KGB PNS -------------------------------------------- END
	
}
?>