<?php
class Satya_Lencana_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_Satya_Lencana');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(tgl_usul)',$this->input->post('bulan'));
    	$this->db->where('YEAR(tgl_usul)',$this->input->post('tahun'));
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
  		$this->db->from("tTrans_Satya_Lencana");
  		$this->db->where_in('IDT_SL',$ID);
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
		if($this->input->post('tgl_usul') == "dd/mm/yyyy"){
			$tgl_usul = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_usul'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_usul = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_reward') == "dd/mm/yyyy"){
			$TMT_reward = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_reward'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_reward = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('tgl_sk_reward') == "dd/mm/yyyy"){
			$tgl_sk_reward = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_reward'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sk_reward = date("Y-m-d", strtotime($format_tgl));
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
			'no_usul' => $this->input->post('no_usul'),
			'tgl_usul' => $tgl_usul,
			'kode_reward' => $this->input->post('kode_reward'),
			'TMT_reward' => $TMT_reward,
			'no_sk_reward' => $this->input->post('no_sk_reward'),
			'tgl_sk_reward' => $tgl_sk_reward,
			'pemberi_reward' => $this->input->post('pemberi_reward'),
			'asal_perolehan' => $this->input->post('asal_perolehan')
		);

  	if($this->input->post('IDT_SL')){
  		$data_ID = array('IDT_SL' => $this->input->post('IDT_SL'));
  		$data_ok = array_merge($data, $data_s_update);
    	$this->db->trans_start();
  		$this->db->update('tTrans_Satya_Lencana',$data_ok, $data_ID);
  		$this->db->trans_complete();
  		$this->Session_Model->Write_Log_User('UPDATE SATYA LENCANA (tTrans_Satya_Lencana) IDT_SL='.$this->input->post('IDT_SL')." NIP=".$this->input->post('NIP'));
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'), 'status_data' => 0);
  	$Q = $this->db->get_where('tTrans_Satya_Lencana', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$data_ok = array_merge($data, $data_s_insert);
    	$this->db->trans_start();
  		$this->db->insert('tTrans_Satya_Lencana', $data_ok);
  		$id = $this->db->insert_id();
  		$this->db->trans_complete();
  		$this->Session_Model->Write_Log_User('UPDATE SATYA LENCANA (tTrans_Satya_Lencana) IDT_SL='.$id." NIP=".$this->input->post('NIP'));
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}
	
	function Update_Data_Usul($p_mode='all', $dari = null, $sampai = null){
		$data = array();
		if($this->input->post('tgl_usul') == "dd/mm/yyyy"){
			$tgl_usul = NULL;
		}else{
			$temp_tgl_usul = substr($this->input->post('tgl_usul'),0,10);
			$tgl_usul = date("Y-m-d", strtotime($temp_tgl_usul));
		}
		$data_usul = array('no_usul' => $this->input->post('no_usul'), 'tgl_usul' => $tgl_usul);
		
		if($p_mode == "all"){
			$data = $this->get_AllPrint();
		}elseif($p_mode == "selected"){
			$data = $this->get_SelectedPrint();
		}elseif($p_mode == "by_rows"){
			$data = $this->get_ByRowsPrint($dari, $sampai);
		}
		if(count($data)){
			foreach($data as $key => $list){
				$this->db->trans_start();
				$this->db->update('tTrans_Satya_Lencana', $data_usul, array('IDT_SL' => $list['IDT_SL']));
				$this->db->trans_complete();
			}
		}
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
  			$s_update_profil = true;
  			$data_ID = array('IDT_SL' => $list['IDT_SL']);
  			$data_proses = array_merge(array('status_data' => 1), $data_s_update);
    		$this->db->update('tTrans_Satya_Lencana', $data_proses, $data_ID);
    		$this->Session_Model->Write_Log_User('PROSES SATYA LENCANA (tTrans_Satya_Lencana) IDT_SL='.$list['IDT_SL']." NIP=".$list['NIP']);
    		
  			// Perubahan Profil tPegawai_Reward
    		if($s_update_profil == true){
  				$W_NIP = array('NIP' => $list['NIP']);
					$data_Reward = array(
						'NIP' => $list['NIP'],
						'kode_unor' => $list['kode_unor'],
						'kode_golru' => $list['kode_golru'],
						'kode_jab' => $list['kode_jab'],
						'mk_th' => $list['mk_th'],
						'mk_bl' => $list['mk_bl'],
						'kode_reward' => $list['kode_reward'],
						'TMT_reward' => $list['TMT_reward'],
						'no_sk_reward' => $list['no_sk_reward'],
						'tgl_sk_reward' => $list['tgl_sk_reward'],
						'pemberi_reward' => $list['pemberi_reward'],
						'asal_perolehan' => $list['asal_perolehan']
					);
					$data_Reward_ok = array_merge($data_Reward, data_s_insert);

    			$this->db->insert('tPegawai_Reward', $data_Reward_ok);
  				$IDP_Reward = $this->Last_IDP_Model->REWARD($list['NIP']);
  				$this->db->update('tPegawai', array_merge('IDP_Reward'=>$IDP_Reward, $data_s_update), $W_NIP);
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
	    		$this->db->delete('tTrans_Satya_Lencana', array('IDT_SL' => $list['IDT_SL']));
	    		$this->Session_Model->Write_Log_User('DELETE SATYA LENCANA (tTrans_Satya_Lencana) IDT_SL='.$list['IDT_SL']." NIP=".$list['NIP']);
	    	}
    	}
  		$this->db->trans_complete();
		}
	}
	
	// PERIODE SATYA LENCANA --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_Satya_Lencana');
		
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
    $this->db->from('tPeriode_Satya_Lencana');
		return $this->db->count_all_results();
	}
	// PERIODE SATYA LENCANA --------------------------------------------------------- END
	
	// CETAK SATYA LENCANA PNS -------------------------------------------- START
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
		$this->db->where_in('IDT_SL', $selected);
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
	// CETAK SATYA LENCANA PNS -------------------------------------------- END
	
}
?>