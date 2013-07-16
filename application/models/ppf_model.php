<?php
class PPF_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY_Bpjkt(){
    $this->db->select('*');
    $this->db->from('tView_Trans_PPF_Bpjkt');
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Bpjkt(){
		$data = array();		
		$this->get_QUERY_Bpjkt();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;

		$this->db->order_by('IDT_PPF_Bpjkt', 'ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }     
    
    return $data;
	}
	
	function get_CountData_Bpjkt(){
		$this->get_QUERY_Bpjkt();
		return $this->db->count_all_results();
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
	
	function getBy_ArrayID(){
		$data = array();
		$this->db->select('*');
  	$this->db->from("tTrans_PPF_Bpjkt");
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	 	}
  	}
    $Q->free_result();
    return $data;
	}
	
	// START - BAPERJAKAT
	function getLast_IDT_PPF_Bpjkt(){
  	$data = array();
  	$IDT_PPF_Bpjkt = null;
		$this->db->select('IDT_PPF_Bpjkt');
  	$this->db->from("tTrans_PPF_Bpjkt");
  	$this->db->order_by('IDT_PPF_Bpjkt', 'DESC');
  	$this->db->limit(1);
  	$Q = $this->db->get("");
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
  		$IDT_PPF_Bpjkt = $data['IDT_PPF_Bpjkt'];
    }
    $Q->free_result();
    return $IDT_PPF_Bpjkt;
	}
	
	function Insert_Data_Bpjkt(){
		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_unor_baru' => $this->input->post('kode_unor_baru'),
			'kode_jab_baru' => $this->input->post('kode_jab_baru'),
			'ket_jab' => $this->input->post('ket_jab')
		);
		
  	$this->db->select("*");
  	$this->db->from("tTrans_PPF_Bpjkt");
  	$this->db->where("NIP", $this->input->post('NIP'));
  	$this->db->or_where("kode_unor_baru", $this->input->post('kode_unor_baru'));
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
			$IDT_PPF_Bpjkt = $this->getLast_IDT_PPF_Bpjkt();
			if ($IDT_PPF_Bpjkt){
				$IDT_PPF_Bpjkt = (int)$IDT_PPF_Bpjkt + 1;
			}else{
				$IDT_PPF_Bpjkt = 1;
			}

    	$a_IDT_PPF_Bpjkt = array('IDT_PPF_Bpjkt' => $IDT_PPF_Bpjkt);
    	$data_bpjkt = array_merge($data, $a_IDT_PPF_Bpjkt);

    	$this->db->trans_start();
  		$this->db->insert('tTrans_PPF_Bpjkt', $data_bpjkt);
  		$id = $this->db->insert_id();
  		$this->db->update('tTrans_PPF_Bpjkt', $data_s_insert, array('IDT_PPF_Bpjkt' => $id));
  		$this->db->trans_complete();	
  		
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}

	function Delete_Data_Bpjkt(){
    if($this->input->post('NIP')){
	    $this->db->trans_start();
	    $this->db->delete('tTrans_PPF_Bpjkt', array('NIP' => $this->input->post('NIP')));
	  	$this->db->trans_complete();
	  	return true;
  	}
	}
	// END - BAPERJAKAT
	
	// START - JABATAN KONFLIK
	function get_QUERY_Jab_Konflik(){
    $this->db->select('*');
    $this->db->from('tView_Trans_PPF_Konflik');
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Jab_Konflik(){
		$this->Check_PPF_Konflik();
		
		$data = array();		
		$this->get_QUERY_Jab_Konflik();

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
	
	function get_CountData_Jab_Konflik(){
		$this->get_QUERY_Jab_Konflik();
		return $this->db->count_all_results();
	}

	function Check_PPF_Konflik(){
		$this->db->trans_start();
		$this->db->query("TRUNCATE TABLE tTrans_PPF_Konflik");
		$Q = $this->db->get("tTrans_PPF_Bpjkt");
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$Q1 = $this->db->get_where("tView_Pegawai_Browse", array('NIP !=' => $row['NIP'], 'kode_unor' => $row['kode_unor_baru'], 'kode_jab' => $row['kode_jab_baru'], 'kode_dupeg' => 1), 1);
				if($Q1->num_rows() > 0){
					$dataQ1 = $Q1->row_array();
					$data = array(
						'NIP' => $dataQ1['NIP'],
						'kode_unor' => $dataQ1['kode_unor'],
						'kode_jab' => $dataQ1['kode_jab'],
						'kode_golru' => $dataQ1['kode_golru']
					);
					$this->db->insert('tTrans_PPF_Konflik', $data);
				}
				$Q1->free_result();
			}
			$Q->free_result();
		}
		$this->db->trans_complete();		
		$this->Hapus_PPF_Konflik();
	}
	
	function Hapus_PPF_Konflik(){
		$this->db->trans_start();
		$Q = $this->db->get("tTrans_PPF_Bpjkt");
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$this->db->delete('tTrans_PPF_Konflik', array('NIP' => $row['NIP']));
			}
			$Q->free_result();
		}
		$this->db->trans_complete();		
	}
	// END - JABATAN KONFLIK

	// START - DISPOSISI
	function get_QUERY_Disposisi(){
    $this->db->select('*');
    $this->db->from('tView_Trans_PPF_Disposisi');
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Disposisi(){
		$data = array();		
		$this->get_QUERY_Disposisi();
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
	
	function get_CountData_Disposisi(){
		$this->get_QUERY_Disposisi();
		return $this->db->count_all_results();
	}

	function Insert_Data_Disposisi(){
		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jab' => $this->input->post('kode_jab')
		);
		
  	$this->db->select("*");
  	$this->db->from("tTrans_PPF_Disposisi");
  	$this->db->where("NIP", $this->input->post('NIP'));
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$data_disposisi = array_merge($data, $data_s_insert);

    	$this->db->trans_start();
  		$this->db->insert('tTrans_PPF_Disposisi', $data_disposisi);
  		$id = $this->db->insert_id();
  		$this->db->trans_complete();	
  		
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}

	function Delete_Data_Disposisi(){
		$records = explode('-', $this->input->post('postdata'));
    $this->db->trans_start();
    foreach($records as $id)
    {
     	$this->db->delete('tTrans_PPF_Disposisi', array('IDT_PPF_Disposisi' => $id));
    }
  	$this->db->trans_complete();
	}
	// END - DISPOSISI

	// START - JABATAN KOSONG
	function get_QUERY_Jab_Kosong(){
    $this->db->select('*');
    $this->db->from('tView_Trans_PPF_Jab_Kosong');
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Jab_Kosong(){
    $this->Check_Jab_Kosong();

		$data = array();		
		$this->get_QUERY_Jab_Kosong();
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
    $this->db->limit($limit, $start);

		$this->db->order_by('urut_unor', 'ASC');
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }
    return $data;
	}
	
	function get_CountData_Jab_Kosong(){
		$this->get_QUERY_Jab_Kosong();
		return $this->db->count_all_results();
	}
	
	function Check_Jab_Kosong(){
		$Q = $this->db->get('tView_KepSek_Kosong');
		if($Q->num_rows() > 0){
			$this->db->trans_start();
			$this->db->query("TRUNCATE TABLE tTrans_PPF_Jab_Kosong");
			foreach ($Q->result_array() as $row){
				$this->db->insert('tTrans_PPF_Jab_Kosong', array('kode_unor_baru' => $row['kode_unor_baru']));
			}
			$this->HT_Jab_Kosong();
			$this->db->trans_complete();
		}
	}
	
	// HT = HAPUS TAMBAH
	function HT_Jab_Kosong(){
		$Q = $this->db->get('tTrans_PPF_Bpjkt');
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				// Cari id unor kosong, apakah kode_unor ada di dalamnya ?
				$Q1_status = false;
				$Q1 = $this->db->get_where('tView_KepSek_Kosong', array('kode_unor_baru' => $row['kode_unor_baru']), 1);
				if($Q1->num_rows() > 0){
					$Q1_status = true;
				}
				
				// Cari di jabatan kosong, apakah kode_unor ada di dalamnya ?
				$Q2_status = false;
				$Q2 = $this->db->get_where('tTrans_PPF_Jab_Kosong', array('kode_unor_baru' => $row['kode_unor_baru']), 1);
				if($Q2->num_rows() > 0){
					$Q2_status = true;
				}
				
				if($Q1_status == true && $Q2_status == true){
					$this->db->delete('tTrans_PPF_Jab_Kosong', array('kode_unor_baru' => $row['kode_unor_baru']));
				}
			}
		}
	}
	// END - JABATAN KOSONG
	
	function Proses_Data(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));

		if($this->input->post('tgl_sk_jab') == "dd/mm/yyyy"){
			$tgl_sk_jab = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sk_jab'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sk_jab = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('TMT_jab') == "dd/mm/yyyy"){
			$TMT_jab = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('TMT_jab'));
			$format_tgl = "$tahun-$bulan-$hari";
			$TMT_jab = date("Y-m-d", strtotime($format_tgl));
		}
		
		$data = $this->getBy_ArrayID();
		if(count($data)){
    	$this->db->trans_start();
    	foreach($data as $key => $list){		
  			$s_update_profil = false;
  			$data_ID = array('IDT_PPF_Bpjkt' => $list['IDT_PPF_Bpjkt']);
				
				$data_Jab = array(
					'NIP' => $list['NIP'],
					'kode_unor' => $list['kode_unor_baru'],
					'kode_jab' => $list['kode_jab_baru'],
					'kode_golru' => $list['kode_golru'],
					'no_sk_jab' => $this->input->post('no_sk_jab'),
					'tgl_sk_jab' => $tgl_sk_jab,
					'TMT_jab' => $TMT_jab,
					'ket_jab' => $list['ket_jab'],
					'status_data' => 1
				);

    		if($sesi_type == 'OPD'){
    			if($list['createdBy'] == $this->session->userdata("user_zs_simpeg")){
    				$this->db->insert('tTrans_PPF', array_merge($data_Jab, array('ket_jab' => $list['ket_jab']), $data_s_insert, $data_s_update));
    				$this->db->delete('tTrans_PPF_Disposisi', array('NIP' => $lis['NIP']));
    				$s_update_profil = true;
    			}
    		}else{
    			$this->db->insert('tTrans_PPF', array_merge($data_Jab, array('ket_jab' => $list['ket_jab']), $data_s_insert, $data_s_update));
    			$this->db->delete('tTrans_PPF_Disposisi', array('NIP' => $list['NIP']));
    			$s_update_profil = true;
    		}
    		
  			// Tambah Data pada tPegawai_Jabatan dan update IDP_Jab pada tPegawai
    		if($s_update_profil == true){
  				$W_NIP = array('NIP' => $list['NIP']);
  				$m_data = array_merge($data_Jab, $data_s_insert);
    			$this->db->insert('tPegawai_Jabatan', $m_data);
  				$IDP_Jab = $this->Last_IDP_Model->JAB($list['NIP']);
  				$m_IDP = array_merge(array('kode_unor' => $list['kode_unor_baru'], 'IDP_Jab' => $IDP_Jab), $data_s_update);
  				$this->db->update('tPegawai', $m_IDP, $W_NIP);
    		}
    		$this->db->delete('tTrans_PPF_Bpjkt', $data_ID);
    		return true;
  		}
  		$this->db->trans_complete();
  	}
	}
	

	// PERIODE SK MPP --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_PPF');
		
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
    $this->db->from('tPeriode_PPF');
		return $this->db->count_all_results();
	}
	// PERIODE SK MPP --------------------------------------------------------- END
	
	// CETAK SK MPP PNS -------------------------------------------- START
	function get_AllPrint(){
		$data = array();		
		$this->get_QUERY_Bpjkt();
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
		$this->get_QUERY_Bpjkt();
		$this->db->where_in('IDT_PPF_Bpjkt', $selected);
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
		$this->get_QUERY_Bpjkt();
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
	// CETAK SK MPP PNS -------------------------------------------- END
	
}
?>