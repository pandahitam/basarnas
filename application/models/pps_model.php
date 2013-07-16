<?php
class PPS_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY_Bpjkt(){
    $this->db->select('*');
    $this->db->from('tView_Trans_PPS_Bpjkt');
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Bpjkt(){
		$data = array();		
		$this->get_QUERY_Bpjkt();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;

		$this->db->order_by('IDT_PPS_Bpjkt', 'ASC');
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
  	$this->db->from("tTrans_PPS_Bpjkt");
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
	function getLast_IDT_PPS_Bpjkt(){
  	$data = array();
  	$IDT_PPS_Bpjkt = null;
		$this->db->select('IDT_PPS_Bpjkt');
  	$this->db->from("tTrans_PPS_Bpjkt");
  	$this->db->order_by('IDT_PPS_Bpjkt', 'DESC');
  	$this->db->limit(1);
  	$Q = $this->db->get("");
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
  		$IDT_PPS_Bpjkt = $data['IDT_PPS_Bpjkt'];
    }
    $Q->free_result();
    return $IDT_PPS_Bpjkt;
	}
	
	function Insert_Data_Bpjkt(){
		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'kode_jpeg' => $this->input->post('kode_jpeg'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_unor_baru' => $this->input->post('kode_unor_baru'),
			'urut_unor_baru' => $this->input->post('urut_unor_baru'),
			'kode_jab_baru' => $this->input->post('kode_jab_baru'),
			'kode_eselon_baru' => $this->input->post('kode_eselon_baru'),
			'ket_jab_baru' => $this->input->post('ket_jab_baru')
		);
		
  	$this->db->select("*");
  	$this->db->from("tTrans_PPS_Bpjkt");
  	$this->db->where("NIP", $this->input->post('NIP'));
  	$this->db->or_where("kode_unor_baru", $this->input->post('kode_unor_baru'));
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data_bpjkt = array_merge($data, $data_s_update);
  	  $this->db->update('tTrans_PPS_Bpjkt', $data_bpjkt, array('NIP' => $this->input->post('NIP')));
  	  return "Updated";
    }else{
			$IDT_PPS_Bpjkt = $this->getLast_IDT_PPS_Bpjkt();
			if ($IDT_PPS_Bpjkt){
				$IDT_PPS_Bpjkt = (int)$IDT_PPS_Bpjkt + 1;
			}else{
				$IDT_PPS_Bpjkt = 1;
			}

    	$a_IDT_PPS_Bpjkt = array('IDT_PPS_Bpjkt' => $IDT_PPS_Bpjkt);
    	$data_bpjkt = array_merge($data, $a_IDT_PPS_Bpjkt, $data_s_insert);

    	$this->db->trans_start();
  		$this->db->insert('tTrans_PPS_Bpjkt', $data_bpjkt);
  		$id = $this->db->insert_id();  		
  		$this->db->trans_complete();	
  		
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}

	function Delete_Data_Bpjkt(){
    if($this->input->post('NIP')){
	    $this->db->trans_start();
	    $this->db->delete('tTrans_PPS_Bpjkt', array('NIP' => $this->input->post('NIP')));
	  	$this->db->trans_complete();
	  	return true;
  	}
	}
	// END - BAPERJAKAT
	
	// START - JABATAN KONFLIK
	function get_QUERY_Jab_Konflik(){
    $this->db->select('*');
    $this->db->from('tView_Trans_PPS_Konflik');
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Jab_Konflik(){
		$this->Check_PPS_Konflik();
		
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

	function Check_PPS_Konflik(){
		$this->db->trans_start();
		$this->db->query("TRUNCATE TABLE tTrans_PPS_Konflik");
		$Q = $this->db->get("tTrans_PPS_Bpjkt");
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$Q1 = $this->db->get_where("tView_Pegawai_Browse", array('NIP !=' => $row['NIP'], 'kode_unor' => $row['kode_unor_baru'], 'kode_jab' => $row['kode_jab_baru'], 'kode_eselon' => $row['kode_eselon_baru'], 'kode_dupeg' => 1), 1);
				if($Q1->num_rows() > 0){
					$dataQ1 = $Q1->row_array();
					$data = array(
						'NIP' => $dataQ1['NIP'],
						'kode_unor' => $dataQ1['kode_unor'],
						'kode_jab' => $dataQ1['kode_jab'],
						'kode_golru' => $dataQ1['kode_golru']
					);
					$this->db->insert('tTrans_PPS_Konflik', $data);
				}
				$Q1->free_result();
			}
			$Q->free_result();
		}
		$this->db->trans_complete();		
		$this->Hapus_PPS_Konflik();
	}
	
	function Hapus_PPS_Konflik(){
		$this->db->trans_start();
		$Q = $this->db->get("tTrans_PPS_Bpjkt");
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$this->db->delete('tTrans_PPS_Konflik', array('NIP' => $row['NIP']));
			}
			$Q->free_result();
		}
		$this->db->trans_complete();		
	}
	// END - JABATAN KONFLIK

	// START - DISPOSISI
	function get_QUERY_Disposisi(){
    $this->db->select('*');
    $this->db->from('tView_Trans_PPS_Disposisi');
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
			'kode_jpeg' => $this->input->post('kode_jpeg'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_golru' => $this->input->post('kode_golru'),
			'kode_jab' => $this->input->post('kode_jab')
		);
		
  	$this->db->select("*");
  	$this->db->from("tTrans_PPS_Disposisi");
  	$this->db->where("NIP", $this->input->post('NIP'));
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$data_disposisi = array_merge($data, $data_s_insert);

    	$this->db->trans_start();
  		$this->db->insert('tTrans_PPS_Disposisi', $data_disposisi);
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
     	$this->db->delete('tTrans_PPS_Disposisi', array('IDT_PPS_Disposisi' => $id));
    }
  	$this->db->trans_complete();
	}
	// END - DISPOSISI

	// START - JABATAN KOSONG
	function get_QUERY_Jab_Kosong(){
    $this->db->select('*');
    $this->db->from('tView_Trans_PPS_Jab_Kosong');
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Jab_Kosong(){
    $this->Check_Jab_Kosong();

		$data = array();		
		$this->get_QUERY_Jab_Kosong();
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
	
	function get_CountData_Jab_Kosong(){
		$this->get_QUERY_Jab_Kosong();
		return $this->db->count_all_results();
	}
	
	function Check_Jab_Kosong(){
		$Q = $this->db->get('tView_Unor_Kosong');
		if($Q->num_rows() > 0){
			$this->db->trans_start();
			$this->db->query("TRUNCATE TABLE tTrans_PPS_Jab_Kosong");
			foreach ($Q->result_array() as $row){
				$this->db->insert('tTrans_PPS_Jab_Kosong', array('kode_unor_baru' => $row['kode_unor_baru']));
			}
			$this->HT_Jab_Kosong();
			$this->db->trans_complete();
		}
	}
	
	// HT = HAPUS TAMBAH
	function HT_Jab_Kosong(){
		$Q = $this->db->get('tTrans_PPS_Bpjkt');
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				// Cari id unor kosong, apakah kode_unor ada di dalamnya ?
				$Q1_status = false;
				$Q1 = $this->db->get_where('tView_Unor_Kosong', array('kode_unor_baru' => $row['kode_unor_baru']), 1);
				if($Q1->num_rows() > 0){
					$Q1_status = true;
				}
				
				// Cari di jabatan kosong, apakah kode_unor ada di dalamnya ?
				$Q2_status = false;
				$Q2 = $this->db->get_where('tTrans_PPS_Jab_Kosong', array('kode_unor_baru' => $row['kode_unor_baru']), 1);
				if($Q2->num_rows() > 0){
					$Q2_status = true;
				}
				
				if($Q1_status == true && $Q2_status == true){
					$this->db->delete('tTrans_PPS_Jab_Kosong', array('kode_unor_baru' => $row['kode_unor_baru']));
				}

				// Cari di tPegawai Apakah sebelumnya yang bersangkutan Pemilik Unor yang lain
				$data = array();
				$this->db->select("kode_unor");
				$this->db->from("tPegawai");
				$this->db->where("NIP", $row['NIP']);
				$this->db->where_in("kode_eselon", array(11,12,21,22,31,32,41,42));				
				$Q3 = $this->db->get();
				if($Q3->num_rows() > 0){
					$data = $Q->row_array();
					$kode_unor_baru = $data['kode_unor'];
					$this->db->insert('tTrans_PPS_Jab_Kosong', array('kode_unor_baru' => $kode_unor_baru));
				}
			}
		}
	}
	// END - JABATAN KOSONG

	function Set_Data_SK(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
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

		if($this->input->post('tgl_spmt') == "dd/mm/yyyy"){
			$tgl_spmt = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_spmt'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_spmt = date("Y-m-d", strtotime($format_tgl));
		}
		
		if($this->input->post('tgl_spp') == "dd/mm/yyyy"){
			$tgl_spp = NULL;
		}else{
			list($hari,$bulan,$tahun) = explode("/",$this->input->post('tgl_spp'));
			$format_tgl = "$tahun-$bulan-$hari";
			$tgl_spp = date("Y-m-d", strtotime($format_tgl));
		}

		$data = $this->getBy_ArrayID();
		if(count($data)){
    	$this->db->trans_start();
    	foreach($data as $key => $list){		
				$data_sk = array(
					'no_sk_jab_baru' => $this->input->post('no_sk_jab'),
					'tgl_sk_jab_baru' => $tgl_sk_jab,
					'TMT_jab_baru' => $TMT_jab,
					'no_spmt_baru' => $this->input->post('no_spmt'),
					'tgl_spmt_baru' => $tgl_spmt,
					'no_spp_baru' => $this->input->post('no_spp'),
					'tgl_spp_baru' => $tgl_spp
				);
				$Data_ID = array('IDT_PPS_Bpjkt' => $list['IDT_PPS_Bpjkt'], 'kode_eselon_baru' => $this->input->post('kode_eselon'));
    		$this->db->update('tTrans_PPS_Bpjkt', array_merge($data_sk, $data_s_update), $Data_ID); 
  		}
  		$this->db->trans_complete();
  		
  		return true;
  	}
	}
		
	function Proses_Data(){		
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		
		// CHECK APAKAH MASIH TERDAPAT JABATAN KONFLIK
		$Jab_Konflik = $this->get_CountData_Jab_Konflik();
		if($Jab_Konflik > 0){
			return "Proses Gagal, masih terdapat Jabatan Konflik !";
		}
		
		$data = $this->getBy_ArrayID();
		if(count($data)){
 			// CHECK APAKAH TMT_jab_baru, tgl_spmt_baru dan tgl_spp_baru Sudah terisi
			$Q1 = $this->db->get_where('tTrans_PPS_Bpjkt', array('TMT_jab_baru' => NULL), 1);
			if($Q1->num_rows() > 0){
				return "Proses Gagal, masih terdapat TMT Jabatan yang kosong !";
			}
  			
    	$this->db->trans_start();
    	foreach($data as $key => $list){		
  			$data_ID = array('IDT_PPS_Bpjkt' => $list['IDT_PPS_Bpjkt']);
  			
				$data_Jab = array(
					'NIP' => $list['NIP'],
					'kode_unor' => $list['kode_unor_baru'],
					'kode_jab' => $list['kode_jab_baru'],
					'kode_eselon' => $list['kode_eselon_baru'],
					'kode_golru' => $list['kode_golru'],
					'no_sk_jab' => $list['no_sk_jab_baru'],
					'tgl_sk_jab' => $list['tgl_sk_jab_baru'],
					'TMT_jab' => $list['TMT_jab_baru'],
					'no_spmt' => $list['no_spmt_baru'],
					'tgl_spmt' => $list['tgl_spmt_baru'],
					'no_spp' => $list['no_spp_baru'],
					'tgl_spp' => $list['tgl_spp_baru'],
					'ket_jab' => $list['ket_jab_baru'],
					'status_data' => 1
				);
	
	  		// Tambah Data pada tPegawai_Jabatan dan update IDP_Jab pada tPegawai
	  		$W_NIP = array('NIP' => $list['NIP']);
	  		$m_data = array_merge($data_Jab, $data_s_insert);
	    	$this->db->insert('tPegawai_Jabatan', $m_data);
	  		$IDP_Jab = $this->Last_IDP_Model->JAB($list['NIP']);
	  		$m_IDP = array_merge(array('kode_unor' => $list['kode_unor_baru'], 'urut_unor' => $list['urut_unor_baru'], 'kode_jab' => $list['kode_jab_baru'], 'kode_eselon' => $list['kode_eselon_baru'], 'IDP_Jab' => $IDP_Jab), $data_s_update);
	  		$this->db->update('tPegawai', $m_IDP, $W_NIP);
	    	$this->db->delete('tTrans_PPS_Bpjkt', $W_NIP); 
	    	$this->db->delete('tTrans_PPS_Disposisi', $W_NIP);
  		}
  		$this->db->trans_complete();
  		
  		// MEMBUAT SOTK BARU UNTUK PERIODE BERDASARKAN WAKTU PROSES
  		$this->db->trans_start();
	  	$QSOTK = $this->db->get('tView_SOTK_Terbaru');
	  	if($QSOTK->num_rows() > 0){
	  		foreach ($QSOTK->result_array() as $row){
	  			$data_sotk = array(
	  				'NIP' => $row['NIP'],
	  				'nama_lengkap' => $row['f_namalengkap'],
	  				'kode_jpeg' => $row['kode_jpeg'],
	  				'kode_unor' => $row['kode_unor'],
	  				'urut_unor' => $row['urut_unor'],
	  				'kode_parent' => $row['kode_parent'],
	  				'kode_jab' => $row['kode_jab'],
	  				'kode_eselon' => $row['kode_eselon'],
	  				'kode_golru' => $row['kode_golru'],
						'no_sk_jab' => $row['no_sk_jab'],
						'tgl_sk_jab' => $row['tgl_sk_jab'],
						'TMT_jab' => $row['TMT_jab'],
						'no_spmt' => $row['no_spmt'],
						'tgl_spmt' => $row['tgl_spmt'],
						'no_spp' => $row['no_spp'],
						'tgl_spp' => $row['tgl_spp'],
						'ket_jab' => $row['ket_jab']
	  			);
	  			$data_sotk_ok = array_merge($data_sotk, $data_s_insert);
	  			$this->db->insert('tTrans_PPS', $data_sotk_ok);
	  	 	}
	  	}
	    $QSOTK->free_result();
  		
  		$this->db->trans_complete();
  		return "SUKSES";
  	}else{
  		return "Proses Gagal, tidak ada data yang dapat diproses !";
  	}
	}
	
	// PERIODE SOTK --------------------------------------------------------- START
	function get_AllData_Periode(){
		$data = array();
		
    $this->db->select('*');
    $this->db->from('tPeriode_PPS');
		
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
    $this->db->from('tPeriode_PPS');
		return $this->db->count_all_results();
	}
	// PERIODE SOTK --------------------------------------------------------- END

	// DATA SOTK ------------------------------------------------------------ START
	function get_QUERY_SOTK(){
    $this->db->select('*');
    $this->db->from('tView_Trans_PPS_SOTK');
    if ($this->input->post('bulan') && $this->input->post('tahun')){
    	$this->db->where('MONTH(createdDate)',$this->input->post('bulan'));
    	$this->db->where('YEAR(createdDate)',$this->input->post('tahun'));
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
    $this->db->order_by('urut_unor', 'ASC');
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_SOTK(){
		$data = array();		
		$this->get_QUERY_SOTK();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;

		$this->db->order_by('IDT_PPS', 'ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }     
    
    return $data;
	}
	
	function get_CountData_SOTK(){
		$this->get_QUERY_SOTK();
		return $this->db->count_all_results();
	}
	// DATA SOTK ------------------------------------------------------------ END

	// CETAK SOTK -------------------------------------------- START
	function get_AllPrint_SOTK(){
		$data = array();		
		$this->get_QUERY_SOTK();
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}

	function get_SelectedPrint_SOTK(){
		$data = array();		
		$selected = explode('-', $this->input->post('postdata'));
		$this->get_QUERY_SOTK();
		$this->db->where_in('IDT_PPS_SOTK', $selected);
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}

	function get_ByRowsPrint_SOTK($dari = null, $sampai = null){
		$data = array();
  	$offset = $dari - 1;
  	$numrows = $sampai - $offset;
		$this->get_QUERY_SOTK();
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
	// CETAK SOTK -------------------------------------------- START
			
	// CETAK BAPERJAKAT -------------------------------------------- START
	function get_AllPrint_Bpjkt(){
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

	function get_SelectedPrint_Bpjkt(){
		$data = array();		
		$selected = explode('-', $this->input->post('postdata'));
		$this->get_QUERY_Bpjkt();
		$this->db->where_in('IDT_PPS_Bpjkt', $selected);
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    return $data;
	}

	function get_ByRowsPrint_Bpjkt($dari = null, $sampai = null){
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
	// CETAK BAPERJAKAT -------------------------------------------- START
	
}
?>