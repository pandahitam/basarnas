<?php
class Mutasi_Masuk_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_Mutasi_Masuk');
    $this->db->where('status_data', $this->input->post('status_data'));
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('tahun')){
    	$this->db->where('YEAR(TMT_mtm)',$this->input->post('tahun'));
    }
    if ($this->input->get_post('query')){
   		$qfilter_1 = str_replace(" ","",trim($this->input->post('query')));
   		$qfilter_2 = str_replace(".","",trim($this->input->post('query')));
   		if(is_numeric($qfilter_1) || is_numeric($qfilter_2)){
   			$this->db->like('NIP', trim($this->input->post('query')));
   		}else{
   			$this->db->like('nama_lengkap', trim($this->input->post('query')));
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
	
	function getLast_IDP_Kpkt($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Kpkt = '';
  		$Q = $this->db->query("SELECT f_idp_kpkt('".$NIP."') AS IDP_Kpkt");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Kpkt = $data['IDP_Kpkt'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Kpkt;			
		}
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
  		$this->db->from("tView_Trans_Mutasi_Masuk");
  		$this->db->where_in('IDT_MTM',$ID);
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
		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_mtm'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tgl_sk_mtm = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_mtm'));
		$format_tgl = "$tahun-$bulan-$hari";
		$TMT_mtm = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_CPNS'));
		$format_tgl = "$tahun-$bulan-$hari";
		$TMT_CPNS = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_PNS'));
		$format_tgl = "$tahun-$bulan-$hari";
		$TMT_PNS = date("Y-m-d", strtotime($format_tgl));

		list($hari,$bulan,$tahun) = explode("/",$this->input->post('tanggal_lahir'));
		$format_tgl = "$tahun-$bulan-$hari";
		$tanggal_lahir = date("Y-m-d", strtotime($format_tgl));

		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'kode_jpeg' => $this->input->post('kode_jpeg'),
			'NIP' => $this->input->post('NIP'),
			'NIP_Lama' => $this->input->post('NIP_Lama'),
			'nama_lengkap' => $this->input->post('nama_lengkap'),
			'gelar_d' => $this->input->post('gelar_d'),
			'gelar_b' => $this->input->post('gelar_b'),
			'tempat_lahir' => $this->input->post('tempat_lahir'),
			'tanggal_lahir' => $tanggal_lahir,
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'no_KARPEG' => $this->input->post('no_KARPEG'),
			'kode_golru_cpns' => $this->input->post('kode_golru_cpns'),
			'TMT_CPNS' => $TMT_CPNS,
			'mk_th_cpns' => $this->input->post('mk_th_cpns'),
			'mk_bl_cpns' => $this->input->post('mk_bl_cpns'),
			'kode_golru_pns' => $this->input->post('kode_golru_pns'),
			'TMT_PNS' => $TMT_PNS,
			'mk_th_pns' => $this->input->post('mk_th_pns'),
			'mk_bl_pns' => $this->input->post('mk_bl_pns'),
			'kode_pddk' => $this->input->post('kode_pddk'),
			'jurusan' => $this->input->post('jurusan'),
			'tahun_lulus' => $this->input->post('tahun_lulus'),
			'jns_mtm' => $this->input->post('jns_mtm'),
			'berdasarkan' => $this->input->post('berdasarkan'),
			'jabatan_lama' => $this->input->post('jabatan_lama'),
			'instansi_lama' => $this->input->post('instansi_lama'),
			'alamat_instansi' => $this->input->post('alamat_instansi'),
			'kode_unor_baru' => $this->input->post('kode_unor_baru'),
			'kode_jab_baru' => $this->input->post('kode_jab_baru'),
			'no_sk_mtm' => $this->input->post('no_sk_mtm'),
			'tgl_sk_mtm' => $tgl_sk_mtm,
			'TMT_mtm' => $TMT_mtm
		);

  	if($this->input->post('IDT_MTM')){
  		$data_ID = array('IDT_MTM' => $this->input->post('IDT_MTM'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_Mutasi_Masuk',$data, $data_ID);
  		$this->db->update('tTrans_Mutasi_Masuk',$data_s_update, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'));
  	$Q = $this->db->get_where('tTrans_Mutasi_Masuk', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_Mutasi_Masuk', $data);
  		$id = $this->db->insert_id();
  		$this->db->update('tTrans_Mutasi_Masuk', $data_s_insert, array('IDT_MTM' => $id));
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

		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));

		if(count($data)){
    	$this->db->trans_start();
    	foreach($data as $key => $list){		
  			$s_insert_profil = false;
  			$data_profil = array(
					'NIP' => $list['NIP'],
					'NIP_Lama' => $list['NIP_Lama'],
					'nama_lengkap' => $list['nama_lengkap'],
					'gelar_d' => $list['gelar_d'],
					'gelar_b' => $list['gelar_b'],
					'tempat_lahir' => $list['tempat_lahir'],
					'tanggal_lahir' => $list['tanggal_lahir'],
					'jenis_kelamin' => $list['jenis_kelamin'],
					'kode_dupeg' => 1,
					'kode_unor' => $list['kode_unor_baru'],
					'kode_jab' => $list['kode_jab_baru'],
					'kode_golru' => $list['kode_golru_pns'],
					'no_KARPEG' => $list['no_KARPEG']
  			);
  			$data_alamat = array('NIP' => $list['NIP'], 'status_data' => 1);
  			$data_kpkt_cpns = array(
  				'NIP' => $list['NIP'],
  				'jns_kpkt' => 'CPNS',
  				'kode_golru' => $list['kode_golru_cpns'],
  				'no_sk_kpkt' => '-',
  				'TMT_kpkt' => $list['TMT_CPNS'],
  				'mk_th_kpkt' => $list['mk_th_cpns'],
  				'mk_bl_kpkt' => $list['mk_bl_cpns']
  			);
  			$data_kpkt_pns = array(
  				'NIP' => $list['NIP'],
  				'jns_kpkt' => 'PNS',
  				'kode_golru' => $list['kode_golru_pns'],
  				'no_sk_kpkt' => '-',
  				'TMT_kpkt' => $list['TMT_PNS'],
  				'mk_th_kpkt' => $list['mk_th_pns'],
  				'mk_bl_kpkt' => $list['mk_bl_pns']
  			);
  			$data_jab = array(
  				'NIP' => $list['NIP'],
  				'kode_jab' => $list['kode_jab_baru'],
  				'no_sk_jab' => $list['no_sk_mtm'],
  				'tgl_sk_jab' => $list['tgl_sk_mtm'],
  				'TMT_jab' => $list['TMT_mtm'],
  				'kode_golru' => $list['kode_golru_pns'],
  				'kode_unor' => $list['kode_unor_baru']
  			);
  			$s_insert_profil = ($sesi_type == 'OPD') ? false : true;
    		if($s_insert_profil == true){
    			$W_NIP = array('NIP' => $list['NIP']);
    			$Q = $this->db->get_where('tPegawai', $W_NIP, 1);
    			if($Q->num_rows() <= 0){
    				$this->db->insert('tPegawai', $data_profil);
    				$this->db->insert('tPegawai_Alamat', $data_alamat);
    				$this->db->insert('tPegawai_Kepangkatan', $data_kpkt_cpns);
    				$this->db->insert('tPegawai_Kepangkatan', $data_kpkt_pns);
    				$this->db->insert('tPegawai_Jabatan', $data_jab);

  					$IDP_Kpkt = $this->getLast_IDP_Kpkt($list['NIP']);
  					$this->db->update('tPegawai', array('IDP_Kpkt' => $IDP_Kpkt), $W_NIP);
  					$IDP_Jab = $this->getLast_IDP_Jab($list['NIP']);
  					$this->db->update('tPegawai', array('IDP_Jab' => $IDP_Jab), $W_NIP);
  					
  					$this->db->update('tTrans_Mutasi_Masuk', array('status_data' => 1), array('IDT_MTM' => $list['IDT_MTM']));

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
    		if($sesi_type != 'OPD'){
  				if($list['status_data'] == 1){
  					if($sesi_type == 'ADMIN' || $sesi_type == 'SUPER ADMIN'){
  						$W_NIP = array('NIP' => $list['NIP']);
    					$this->db->delete('tPegawai', $W_NIP);
     					$this->db->delete('tPegawai_Alamat', $W_NIP);
     					$this->db->delete('tPegawai_Ortu', $W_NIP);
     					$this->db->delete('tPegawai_Suami_Istri', $W_NIP);
     					$this->db->delete('tPegawai_Anak', $W_NIP);
     					$this->db->delete('tPegawai_Kepangkatan', $W_NIP);
     					$this->db->delete('tPegawai_Jabatan', $W_NIP);
     					$this->db->delete('tPegawai_Diklat', $W_NIP);
     					$this->db->delete('tPegawai_Pendidikan', $W_NIP);
     					$this->db->delete('tPegawai_DP3', $W_NIP);
     					$this->db->delete('tPegawai_GajiBerkala', $W_NIP);
     					$this->db->delete('tPegawai_Seminar', $W_NIP);
     					$this->db->delete('tPegawai_Reward', $W_NIP);
     					$this->db->delete('tPegawai_HukDis', $W_NIP);
     					$this->db->delete('tPegawai_Karya_Tulis', $W_NIP);
     					$this->db->delete('tPegawai_Organisasi', $W_NIP);
     					$this->db->delete('tPegawai_Pengalaman_Kerja', $W_NIP);
    					$this->db->delete('tTrans_Mutasi_Masuk', array('IDT_MTM' => $list['IDT_MTM']));
    				}
     			}else{
    				$this->db->delete('tTrans_Mutasi_Masuk', array('IDT_MTM' => $list['IDT_MTM']));
    			}
    		}
    	}
  		$this->db->trans_complete();
		}
	}
	
	// PERIODE MUTASI MASUK --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_Mutasi_Masuk');
		
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
    $this->db->from('tPeriode_Mutasi_Masuk');
		return $this->db->count_all_results();
	}
	// PERIODE MUTASI MASUK --------------------------------------------------------- END
	
	// CETAK MUTASI MASUK -------------------------------------------- START
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
		$this->db->where_in('IDT_MTM', $selected);
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
	// CETAK MUTASI MASUK -------------------------------------------- END
	
}
?>