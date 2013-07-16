<?php
class SK_CPNS_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$sesi_kode_unker = $this->session->userdata("kode_unker_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_SK_CPNS');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(TMT_CPNS)',$this->input->post('bulan'));
    	$this->db->where('YEAR(TMT_CPNS)',$this->input->post('tahun'));
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
  		$this->db->from("tTrans_SK_CPNS");
  		$this->db->where_in('IDT_SK_CPNS',$ID);
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
		if($this->input->post('tanggal_lahir') == "dd/mm/yyyy"){
			$tanggal_lahir = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tanggal_lahir'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tanggal_lahir = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('tgl_bkn') == "dd/mm/yyyy"){
			$tgl_bkn = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_bkn'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_bkn = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('tgl_sk_cpns') == "dd/mm/yyyy"){
			$tgl_sk_cpns = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_cpns'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sk_cpns = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_CPNS') == "dd/mm/yyyy"){
			$TMT_CPNS = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_CPNS'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_CPNS = date("Y-m-d", strtotime($format_tgl));
		}

		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'no_registrasi' => $this->input->post('no_registrasi'),
			'tahun_formasi' => $this->input->post('tahun_formasi'),
			'NIP' => $this->input->post('NIP'),
			'nama_lengkap' => $this->input->post('nama_lengkap'),
			'gelar_d' => $this->input->post('gelar_d'),
			'gelar_b' => $this->input->post('gelar_b'),
			'tempat_lahir' => $this->input->post('tempat_lahir'),
			'tanggal_lahir' => $tanggal_lahir,
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jpeg' => $this->input->post('kode_jpeg'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_pddk' => $this->input->post('kode_pddk'),
			'tahun_lulus' => $this->input->post('tahun_lulus'),
			'mk_th' => $this->input->post('mk_th'),
			'mk_bl' => $this->input->post('mk_bl'),
			'gapok_pns' => $this->input->post('gapok_pns'),
			'gapok_cpns' => $this->input->post('gapok_cpns'),
			'no_bkn' => $this->input->post('no_bkn'),
			'tgl_bkn' => $tgl_bkn,
			'no_sk_cpns' => $this->input->post('no_sk_cpns'),
			'tgl_sk_cpns' => $tgl_sk_cpns,
			'TMT_CPNS' => $TMT_CPNS
		);

  	if($this->input->post('IDT_SK_CPNS')){
  		$data_ID = array('IDT_SK_CPNS' => $this->input->post('IDT_SK_CPNS'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_SK_CPNS',$data, $data_ID);
  		$this->db->update('tTrans_SK_CPNS',$data_s_update, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'));
  	$Q = $this->db->get_where('tTrans_SK_CPNS', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_SK_CPNS', $data);
  		$id = $this->db->insert_id();
  		$this->db->update('tTrans_SK_CPNS', $data_s_insert, array('IDT_SK_CPNS' => $id));
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
  			$data_ID = array('IDT_SK_CPNS' => $list['IDT_SK_CPNS']);
  			
				$data_pgw = array(
					'NIP' => $list['NIP'],
					'nama_lengkap' => $list['nama_lengkap'],
					'tempat_lahir' => $list['tempat_lahir'],
					'tanggal_lahir' => $list['tanggal_lahir'],
					'jenis_kelamin' => $list['jenis_kelamin'],
					'gelar_d' => $list['gelar_d'],
					'gelar_b' => $list['gelar_b'],
					'kode_dupeg' => 17,
					'kode_golru' => $list['kode_golru'],
					'kode_unor' => $list['kode_unor'],
					'kode_jab' => $list['kode_jab']
				);
				
				$data_kpkt = array(
					'NIP' => $list['NIP'],
					'jns_kpkt' => 'CPNS',
					'kode_golru' => $list['kode_golru'],
					'no_sk_kpkt' => $list['no_sk_cpns'],
					'tgl_sk_kpkt' => $list['tgl_sk_cpns'],
					'TMT_kpkt' => $list['TMT_CPNS'],
					'mk_th_kpkt' => $list['mk_th'],
					'mk_bl_kpkt' => $list['mk_bl'],
					'gapok_kpkt' => $list['gapok_pns']
				);
				
				$data_jab = array(
					'NIP' => $list['NIP'],
					'kode_unor' => $list['kode_unor'],
					'kode_jab' => $list['kode_jab'],
					'kode_eselon' => 99,
					'kode_golru' => $list['kode_golru'],
					'no_sk_jab' => $list['no_sk_cpns'],
					'tgl_sk_jab' => $list['tgl_sk_cpns'],
					'TMT_jab' => $list['TMT_CPNS']
				);

				$data_pddk = array(
					'NIP' => $list['NIP'],
					'kode_pddk' => $list['kode_pddk'],
					'tahun_lulus' => $list['tahun_lulus']
				);
				
				if($list['NIP']){
					$W_NIP = array('NIP' => $list['NIP']);
	    		
	    		// Update tTrans_SK_CPNS dengan status_data = 1
	    		$data_status = array_merge(array('status_data' => 1), $data_s_update);
	    		$this->db->update('tTrans_SK_CPNS', $data_status, $data_ID);
	    		
	  			// Penambahan data pada tPegawai_Kepangkatan
	  			$data_kpkt_ok = array_merge($data_kpkt, $data_s_insert);
	    		$this->db->insert('tPegawai_Kepangkatan', $data_kpkt_ok);
	  			$IDP_Kpkt = $this->Last_IDP_Model->KPKT($list['NIP']);

	  			// Penambahan data pada tPegawai_Jabatan
	  			$data_jab_ok = array_merge($data_jab, $data_s_insert);
	    		$this->db->insert('tPegawai_Jabatan', $data_jab_ok);
	  			$IDP_Jab = $this->Last_IDP_Model->JAB($list['NIP']);
	  			
	  			// Penambahan data pada tPegawai_Pendidikan
	  			$data_pddk_ok = array_merge($data_pddk, $data_s_insert);
	    		$this->db->insert('tPegawai_Pendidikan', $data_pddk_ok);
	  			$IDP_Pddk = $this->Last_IDP_Model->PDDK($list['NIP']);
	  			
	  			$data_pgw_ok = array_merge($data_pgw, array('IDP_Kpkt' => $IDP_Kpkt), array('IDP_Jab' => $IDP_Jab), array('IDP_Pddk' => $IDP_Pddk), $data_s_insert);	  			
	  			$this->db->insert('tPegawai', $data_pgw_ok);
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
    				$this->db->delete('tTrans_SK_CPNS', array('IDT_SK_CPNS' => $list['IDT_SK_CPNS']));
    			}
    		}else{
    			$this->db->delete('tTrans_SK_CPNS', array('IDT_SK_CPNS' => $list['IDT_SK_CPNS']));
    		}
    	}
  		$this->db->trans_complete();
		}
	}
	
	// PERIODE SK CPNS --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_SK_CPNS');
		
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
    $this->db->from('tPeriode_SK_CPNS');
		return $this->db->count_all_results();
	}
	// PERIODE SK CPNS --------------------------------------------------------- END
	
	// CETAK SK CPNS ----------------------------------------------------------- START
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
		$this->db->where_in('IDT_SK_CPNS', $selected);
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
	// CETAK SK CPNS ----------------------------------------------------------- END
	
}
?>