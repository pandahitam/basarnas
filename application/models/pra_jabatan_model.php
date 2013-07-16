<?php
class Pra_Jabatan_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
    $this->db->select('*');
    $this->db->from('tView_Trans_Diklat');
    $this->db->where('status_data', $this->input->post('status_data'));
		// Kode Jenis Diklat Prajabatan
		$this->db->where('kode_jns_diklat', 1);
		if($sesi_type == 'OPD'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(tgl_sttpp)',$this->input->post('bulan'));
    	$this->db->where('YEAR(tgl_sttpp)',$this->input->post('tahun'));
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
    $this->db->order_by("angkatan", "ASC");
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
  		$this->db->from("tTrans_Diklat");
  		$this->db->where_in('IDT_Diklat',$ID);
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
		if($this->input->post('tgl_mulai') == "dd/mm/yyyy"){
			$tgl_mulai = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_mulai'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_mulai = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('tgl_selesai') == "dd/mm/yyyy"){
			$tgl_selesai = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_selesai'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_selesai = date("Y-m-d", strtotime($format_tgl));
		}

		if($this->input->post('tgl_sttpp') == "dd/mm/yyyy"){
			$tgl_sttpp = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_sttpp'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_sttpp = date("Y-m-d", strtotime($format_tgl));
		}

		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_diklat' => $this->input->post('kode_diklat'),
			'penyelenggara' => $this->input->post('penyelenggara'),
			'lokasi' => $this->input->post('lokasi'),
			'kode_sumber_dana' => $this->input->post('kode_sumber_dana'),
			'angkatan' => $this->input->post('angkatan'),
			'tgl_mulai' => $tgl_mulai,
			'tgl_selesai' => $tgl_selesai,
			'lama_diklat' => $this->input->post('lama_diklat'),
			'predikat' => $this->input->post('predikat'),
			'no_sttpp' => $this->input->post('no_sttpp'),
			'tgl_sttpp' => $tgl_sttpp
		);

  	if($this->input->post('IDT_Diklat')){
  		$data_ID = array('IDT_Diklat' => $this->input->post('IDT_Diklat'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_Diklat',$data, $data_ID);
  		$this->db->update('tTrans_Diklat',$data_s_update, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'), 'kode_diklat' => $this->input->post('kode_diklat'), 'tgl_selesai' => $tgl_selesai);
  	$Q = $this->db->get_where('tTrans_Diklat', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_Diklat', $data);
  		$id = $this->db->insert_id();
  		$this->db->update('tTrans_Diklat', $data_s_insert, array('IDT_Diklat' => $id));
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
  			$data_ID = array('IDT_Diklat' => $list['IDT_Diklat']);

    		$this->db->update('tTrans_Diklat', $data_s_update, $data_ID);
    		$this->db->update('tTrans_Diklat', array('status_data' => 1), $data_ID);
    		$s_update_profil = true;
    		
  			// Tambah data pada tPegawai_Diklat, ubah IDP_Dik_PraJab pada tPegawai
    		if($s_update_profil == true){
  				$W_NIP = array('NIP' => $list['NIP']);
					$data = array(
						'NIP' => $list['NIP'],
						'kode_unor' => $list['kode_unor'],
						'kode_golru' => $list['kode_golru'],
						'kode_jab' => $list['kode_jab'],
						'kode_diklat' => $list['kode_diklat'],
						'penyelenggara' => $list['penyelenggara'],
						'lokasi' => $list['lokasi'],
						'kode_sumber_dana' => $list['kode_sumber_dana'],
						'angkatan' => $list['angkatan'],
						'tgl_mulai' => $list['tgl_mulai'],
						'tgl_selesai' => $list['tgl_selesai'],
						'lama_diklat' => $list['lama_diklat'],
						'predikat' => $list['predikat'],
						'no_sttpp' => $list['no_sttpp'],
						'tgl_sttpp' => $list['tgl_sttpp']
					);
					$data_Diklat = array_merge($data, $data_s_insert);
    			$this->db->insert('tPegawai_Diklat', $data_Diklat);
  				$IDP_Diklat = $this->Last_IDP_Model->PRAJAB($list['NIP']);
  				$data_IDP = array_merge(array('IDP_Dik_PraJab' => $IDP_Diklat), $data_s_update);
  				$this->db->update('tPegawai', $data_IDP, $W_NIP);
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
    				$this->db->delete('tTrans_Diklat', array('IDT_Diklat' => $list['IDT_Diklat']));
    			}
    		}else{
    			$this->db->delete('tTrans_Diklat', array('IDT_Diklat' => $list['IDT_Diklat']));
    		}
    	}
  		$this->db->trans_complete();
		}
	}

	// SEARCH NAMA DIKLAT BY GOLRU ----------------------------------------------------- START
	function getData_Nama_Diklat_By_Golru($kode_golru=0){
  	$data = array(); $options = array();
  	switch($kode_golru){
  		case 11:
  		case 12:
  		case 13:
  		case 14:
  			$options = array('nama_diklat' => 'Diklat Prajabatan Gol I');
  			break;
  		case 21:
  		case 22:
  		case 23:
  		case 24:
  			$options = array('nama_diklat' => 'Diklat Prajabatan Gol II');
  			break;
  		case 31:
  		case 32:
  		case 33:
  		case 34:
  			$options = array('nama_diklat' => 'Diklat Prajabatan Gol III');
  			break;  		
  		default:
  	}
  	if(count($options)){
	  	$Q = $this->db->get_where('tRef_Diklat', $options, 1);
	  	if($Q->num_rows() > 0){
	  		$data = $Q->row_array();
	    }
	    $Q->free_result();
	    $this->db->close();
	  }
    return $data;
	}
	// SEARCH NAMA DIKLAT BY GOLRU ----------------------------------------------------- END
	
	// PERIODE DIKLAT --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_Diklat_Prajab');
		
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
    $this->db->from('tPeriode_Diklat_Prajab');
		return $this->db->count_all_results();
	}
	// PERIODE DIKLAT --------------------------------------------------------- END
	
	// CETAK DIKLAT PNS -------------------------------------------- START
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
		$this->db->where_in('IDT_Diklat', $selected);
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
	// CETAK DIKLAT PNS -------------------------------------------- END
	
}
?>