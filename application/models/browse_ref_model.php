<?php
class Browse_Ref_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	// SEARCH PEGAWAI --------------------------------------------------------------------------- START
	function getData_Biodata($NIP=0){
  	$data = array();
  	$options = array('NIP' => $NIP);
  	$Q = $this->db->get_where('tView_Pegawai_Biodata', $options,1);
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH PEGAWAI ------------------------------------------------------------------- END

	// SEARCH BROWSE PEGAWAI ------------------------------------------------------------ START
	function getData_Pegawai_Browse($NIP=0){
  	$data = array();
  	$options = array('NIP' => $this->input->post("NIP"));
  	$Q = $this->db->get_where('tView_Pegawai_Browse', $options,1);
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH BROWSE PEGAWAI ------------------------------------------------------------ END

	// SEARCH SUAMI/ISTRI PEGAWAI ------------------------------------------------------- START
	function getData_Sumai_Istri($NIP=0){
  	$data = array();
  	$options = array('NIP' => $NIP);
  	$Q = $this->db->get_where('tPegawai_Suami_Istri', $options,1);
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH SUAMI/ISTRI PEGAWAI ------------------------------------------------------- END

	// SEARCH ALAMAT PEGAWAI ------------------------------------------------------------ START
	function getData_Alamat($NIP=0){
  	$data = array();
  	$options = array('NIP' => $NIP);
  	$Q = $this->db->get_where('tPegawai_Alamat', $options,1);
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH ALAMAT PEGAWAI ------------------------------------------------------------- END

	// SEARCH CPNS PEGAWAI --------------------------------------------------------------- START
	function getData_CPNS($NIP=0){
  	$data = array();
  	$this->db->select('*');
  	$this->db->from('tView_Pegawai_Kepangkatan');
  	$this->db->where('NIP', $NIP);
  	$this->db->where('jns_kpkt', 'CPNS');
  	$this->db->limit(1);
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH CPNS PEGAWAI --------------------------------------------------------------- END

	// SEARCH KPKT PEGAWAI --------------------------------------------------------------- START
	function getData_KPKT($NIP=0){
  	$data = array();
  	$this->db->select('*');
  	$this->db->from('tPegawai_Kepangkatan');
  	$this->db->where('NIP', $NIP);
  	$this->db->order_by('TMT_kpkt', 'DESC');
  	$this->db->limit(1);
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH KPKT PEGAWAI --------------------------------------------------------------- END

	// SEARCH ANGKA KREDIT PEGAWAI --------------------------------------------------------------- START
	function getData_AK($NIP=0){
  	$data = array();
  	$this->db->select('*');
  	$this->db->from('tPegawai_AK');
  	$this->db->where('NIP', $NIP);
  	$this->db->order_by('TMT_ak', 'DESC');
  	$this->db->limit(1);
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH ANGKA KREDIT PEGAWAI --------------------------------------------------------------- END

	// SEARCH PMKG PEGAWAI --------------------------------------------------------------- START
	function getData_PMKG($NIP=0){
  	$data = array();
  	$options = array('NIP' => $NIP);
  	$Q = $this->db->get_where('tTrans_PMKG', $options,1);
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH PMKG PEGAWAI --------------------------------------------------------------- END

	// SEARCH KGB PEGAWAI --------------------------------------------------------------- START
	function getData_KGB($NIP=0){
  	$data = array();
  	$this->db->from('tPegawai_GajiBerkala');
  	$this->db->where('NIP', $NIP);
  	$this->db->order_by('TMT_kgb', 'DESC');
  	$this->db->limit(1);
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH KGB PEGAWAI --------------------------------------------------------------- END

	// SEARCH DP3 PEGAWAI ---------------------------------------------------------------- START
	function getData_DP3($NIP=0){
  	$data = array();
  	$this->db->select('*');
  	$this->db->from('tView_Pegawai_DP3');
  	$this->db->where('NIP', $NIP);
  	$this->db->order_by('tgl_dp3', 'DESC');
  	$this->db->limit(1);
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH DP3 PEGAWAI ---------------------------------------------------------------- END

	// SEARCH PRA JABATAN PEGAWAI -------------------------------------------------------- START
	function getData_PraJab($NIP=0){
  	$data = array();
  	$this->db->select('*');
  	$this->db->from('tTrans_Diklat');
  	$this->db->where('NIP', $NIP);
  	$this->db->where_in('kode_diklat', array(10001, 10002, 10003));
  	$this->db->order_by('tgl_sttpp', 'DESC');
  	$this->db->limit(1);
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH PRA JABATAN PEGAWAI ------------------------------------------------------------ END

	// SEARCH RIWAYAT KESEHATAN PEGAWAI ------------------------------------------------------ START
	function getData_RiKes($NIP=0){
  	$data = array();
  	$this->db->select('*');
  	$this->db->from('tTrans_SK_RiKes');
  	$this->db->where('NIP', $NIP);
  	$this->db->order_by('tgl_sk_rikes', 'DESC');
  	$this->db->limit(1);
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH RIWAYAT KESEHATAN PEGAWAI ------------------------------------------------------ END

	// SEARCH PENSIUN PEGAWAI ---------------------------------------------------------------- START
	function getData_Pensiun($NIP=0){
  	$data = array();
  	$this->db->select('*');
  	$this->db->from('tView_Trans_Pensiun');
  	$this->db->where('NIP', $NIP);
  	$this->db->limit(1);
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// SEARCH PENSIUN PEGAWAI ---------------------------------------------------------------- END

	// PEGAWAI --------------------------------------------------------------------------- START
	function get_NIP_Blm_PMK(){
		$data = array(); $NIP='';
		$QPMK = $this->db->query("SELECT NIP FROM tTrans_PMKG");
		if($QPMK->num_rows() > 0){
			foreach ($QPMK->result_array() as $row){
				$data[] = $row['NIP'];
				$NIP = $row['NIP'];
			}
		}
		return $data;
	}
	
	function get_QUERY_Pegawai(){
    $this->db->select('*');
    $this->db->from('tView_Pegawai_Browse');
    $sesi_type = $this->session->userdata("type_zs_simpeg");
    if($sesi_type == 'OPD' && $this->input->post("sPgwPilih") != 'Atasan Langsung'){
			$a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
    }
    if($this->input->post("sDupeg")){
    	$this->db->where('kode_dupeg', $this->input->post("sDupeg"));
    }else{
    	$this->db->where_in('kode_dupeg', array(1,17));
    }
    if($this->input->post("sPgwPilih") != "Dokter"){
	    if($this->input->post('skode_unor')){
	    	$this->db->where('kode_unor', $this->input->post('skode_unor'));
	    }
	  }
    if($this->input->post("sPgwPilih") == "diklat_pim" || $this->input->post('eselon') == 1){
    	$this->db->where_in('kode_eselon', array(11,12,21,22,31,32,41,42));
    }
    if($this->input->post("sPgwPilih") == "Struktural, Fungsional Umum"){
    	$this->db->where_in('kode_klp_jab', array(1,5));
    }elseif($this->input->post("sPgwPilih") == "PraJab"){
    	$this->db->where_in('kode_dupeg', 17);
    }elseif($this->input->post("sPgwPilih") == "Dokter"){
    	$this->db->like('nama_jab', 'Dokter');
    	if($this->input->post("skode_unor")){
    		
    	}
    }elseif($this->input->post("sPgwPilih") == "Belum PMK"){
    	$NIP_a = $this->get_NIP_Blm_PMK();
    	if(count($NIP_a)){
    		$this->db->where_not_in("NIP", $NIP_a);
    	}
    }
    if($this->input->post('skode_golru')){
    	$this->db->where('kode_golru >=', $this->input->post('skode_golru'));
    }
    if ($this->input->post('query')){
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

	function get_AllData_Pegawai(){
		$data = array();
		
		$this->get_QUERY_Pegawai();
	  $this->db->order_by("kode_golru", "DESC");
	  $this->db->order_by("kode_eselon", "ASC");
	  $this->db->order_by("TMT_Kpkt", "ASC");
	  $this->db->order_by("urut_unor", "ASC");

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
	
	function get_CountData_Pegawai(){
		$this->get_QUERY_Pegawai();
		return $this->db->count_all_results();
	}
	// PEGAWAI --------------------------------------------------------------------------- END
	
	// PENILAI --------------------------------------------------------------------------- START
	function get_QUERY_Penilai(){
    $this->db->select('*');
    $this->db->from('tView_Pegawai_Penilai');
    $this->db->where_in('kode_eselon', array(41,42));
    $this->db->where_in('kode_dupeg', array(1,17));
    if($this->input->post('query')){
   		$qfilter_1 = str_replace(" ","",trim($this->input->post('query')));
   		$qfilter_2 = str_replace(".","",trim($this->input->post('query')));
   		if(is_numeric($qfilter_1) || is_numeric($qfilter_2)){
   			$this->db->like('NIP', trim($this->input->post('query')));
   		}else{
   			$this->db->like('nama_lengkap', trim($this->input->post('query')));
   		}
    }
	}

	function get_AllData_Penilai(){
		$data = array();
		
		$this->get_QUERY_Penilai();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('NIP','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Penilai(){
		$this->get_QUERY_Penilai();
		return $this->db->count_all_results();
	}
	// PENILAI --------------------------------------------------------------------------- END
	
	// PANGKAT, GOLRU PEGAWAI ------------------------------------------------------------ START
	function get_QUERY_Pangkat_Pgw(){
    $this->db->select('*');
    $this->db->from('tView_Pegawai_Kepangkatan');
    $this->db->where('NIP', $this->session->userdata("sNIP"));
    $this->db->order_by('kode_golru', 'DESC');
	}
	
	function get_AllData_Pangkat_Pgw(){
		$data = array();
		
		$this->get_QUERY_Pangkat_Pgw();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('TMT_kpkt','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Pangkat_Pgw(){
		$this->get_QUERY_Pangkat_Pgw();
		return $this->db->count_all_results();
	}

	// PANGKAT, GOLRU PEGAWAI ------------------------------------------------------------ START
	
	// PANGKAT, GOLRU UP LEVEL ------------------------------------------------------------ START
	function get_QUERY_Golru_Up_Level(){
    $this->db->select('*');
    $this->db->from('tRef_Golru');
    $this->db->where('kode_golru >', $this->input->post("kode_golru"));
	}
	
	function get_AllData_Golru_Up_Level(){
		$data = array();
		
		$this->get_QUERY_Golru_Up_Level();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_golru', 'ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Golru_Up_Level(){
		$this->get_QUERY_Golru_Up_Level();
		return $this->db->count_all_results();
	}

	// PANGKAT, GOLRU UP LEVEL ------------------------------------------------------------ START
	
	// PENDIDIKAN --------------------------------------------------------------------------- START
	function get_QUERY_Pendidikan(){
    $this->db->select('*');
    $this->db->from('tView_Ref_Pendidikan');
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
    if ($this->input->get_post('query')){
    	$this->db->like('kode_pddk', $this->input->get_post('query'));
    	$this->db->or_like('nama_pddk', $this->input->get_post('query'));
    }
	}
	
	function get_AllData_Pendidikan(){
		$data = array();
		
		$this->get_QUERY_Pendidikan();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_pddk','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Pendidikan(){
		$this->get_QUERY_Pendidikan();
		return $this->db->count_all_results();
	}

	function get_QUERY_Pddk_Pgw(){
    $this->db->select('*');
    $this->db->from('tView_Pegawai_Pendidikan');
    $this->db->where('NIP', $this->session->userdata("sNIP"));
	}
	
	function get_AllData_Pddk_Pgw(){
		$data = array();
		
		$this->get_QUERY_Pddk_Pgw();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_pddk','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Pddk_Pgw(){
		$this->get_QUERY_Pddk_Pgw();
		return $this->db->count_all_results();
	}

	function getData_Pddk($NIP=0){
  	$data = array();
  	$this->db->select('*');
  	$this->db->from('tView_Pegawai_Pendidikan');
  	$this->db->where('NIP', $NIP);
  	$this->db->order_by('tahun_lulus', 'DESC');
  	$this->db->limit(1);  	
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}
	// PENDIDIKAN --------------------------------------------------------------------------- END

	// PEKERJAAN --------------------------------------------------------------------------- START
	function get_QUERY_Pekerjaan(){
    $this->db->select('kode_pekerjaan,nama_pekerjaan');
    $this->db->from('tRef_Pekerjaan');
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
    if ($this->input->get_post('query')){
    	$this->db->or_like('nama_pekerjaan', $this->input->get_post('query'));
    }
	}

	function get_AllData_Pekerjaan(){
		$data = array();
		
		$this->get_QUERY_Pekerjaan();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_pekerjaan','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Pekerjaan(){
		$this->get_QUERY_Pekerjaan();
		return $this->db->count_all_results();
	}
	// PEKERJAAN --------------------------------------------------------------------------- END

	// GAPOK --------------------------------------------------------------------------- START
	function get_QUERY_Gapok(){
    $this->db->select('*');
    $this->db->from('tView_Ref_Gapok');
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
   	if($this->input->post('kode_golru')){
   		$this->db->where('kode_golru', $this->input->post('kode_golru'));
   	}
   	if($this->input->post('kode_jpeg')){
   		$this->db->where('kode_jpeg', $this->input->post('kode_jpeg'));
   	}
    if ($this->input->get_post('query')){
    	$this->db->like('nama_pangkat', $this->input->get_post('query'));
    	$this->db->or_like('nama_golru', $this->input->get_post('query'));
    }
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Gapok(){
		$data = array();
		
		$this->get_QUERY_Gapok();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_gapok','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Gapok(){
		$this->get_QUERY_Gapok();
		return $this->db->count_all_results();
	}
	// GAPOK --------------------------------------------------------------------------- END
	
	// DIKLAT --------------------------------------------------------------------------- START
	function get_QUERY_Diklat($kode_jns_diklat=''){
    $this->db->select('*');
    $this->db->from('tView_Ref_Diklat');
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
		if($kode_jns_diklat){
    	$this->db->where('kode_jns_diklat', $kode_jns_diklat);
		}
		if($this->input->post('Jns_Diklat') == 'Diklat PIM'){
			$this->db->where('kode_jns_diklat', 2);
		}
    if($this->input->get_post('query')){
    	$this->db->like('kode_diklat', $this->input->get_post('query'));
    	$this->db->or_like('nama_diklat', $this->input->get_post('query'));
    }
	}

	function get_AllData_Diklat($kode_jns_diklat=''){
		$data = array();
		
		$this->get_QUERY_Diklat($kode_jns_diklat);

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_diklat','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Diklat($kode_jns_diklat=''){
		$this->get_QUERY_Diklat($kode_jns_diklat);
		return $this->db->count_all_results();
	}
	// DIKLAT --------------------------------------------------------------------------- END

	// UNIT KERJA --------------------------------------------------------------------------- START
	function get_QUERY_Unker(){
    $sesi_type = $this->session->userdata("type_zs_simpeg");
    $a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
    $this->db->select('*');
    $this->db->from('tRef_UnitKerja');    
		if($sesi_type == 'OPD'){
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}else{
			$this->db->where('kode_unker !=', 0);
		}
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
    if ($this->input->get_post('query')){
    	$this->db->like('nama_unker', $this->input->get_post('query'));
    }
	}

	function get_AllData_Unker(){
		$data = array();
		
		$this->get_QUERY_Unker();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_unker','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Unker(){
		$this->get_QUERY_Unker();
		return $this->db->count_all_results();
	}	
	// UNIT KERJA --------------------------------------------------------------------------- END

	// UNIT ORGANISASI (UNOR) --------------------------------------------------------------------------- START
	function get_QUERY_Unor(){
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		$sesi_kode_unker = $this->session->userdata("kode_unker_zs_simpeg");
    $a_sesi_kode_unker = explode(",", $this->session->userdata("a_kode_unker_zs_simpeg"));
		$ab_kode_unker = $this->Global_Model->get_kode_unker_child($this->input->post('kode_unker'));
    $this->db->select('*');
    $this->db->from('tView_Ref_Unor');
    if ($this->input->get_post('query')){
    	$this->db->like('jabatan_unor', $this->input->get_post('query'));
    	$this->db->or_like('nama_unor', $this->input->get_post('query'));
    	$this->db->or_like('nama_unker', $this->input->get_post('query'));
    }
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
		if($this->input->post('jab_unor')){
	   	$this->db->where_in('jabatan_unor', $this->input->post('jab_unor'));
		}elseif($this->input->post('eselon') == 1){
	   	$this->db->where_in('kode_eselon', array(11,12,21,22,31,32,41,42));
		}elseif($this->input->post('non_eselon') == 1){
	   	$this->db->where_in('kode_eselon', array(0,99));
	  }
		if($sesi_type == 'OPD'){
			$this->db->where_in('kode_unker', $a_sesi_kode_unker);
		}else{
			$this->db->where_in('kode_unker', $ab_kode_unker);
		}
		$this->Filters_Model->get_FILTER();
	}

	function get_AllData_Unor(){
		$data = array();
		
		$this->get_QUERY_Unor();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_unor','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Unor(){
		$this->get_QUERY_Unor();
		return $this->db->count_all_results();
	}
	
	function get_QUERY_Unor_Pgw(){
    $this->db->select('*');
    $this->db->from('tView_Pegawai_Jabatan');
    $this->db->where('NIP', $this->session->userdata("sNIP"));
	}

	function get_AllData_Unor_Pgw(){
		$data = array();
		
		$this->get_QUERY_Unor_Pgw();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_unor','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Unor_Pgw(){
		$this->get_QUERY_Unor_Pgw();
		return $this->db->count_all_results();
	}	
	// UNIT ORGANISASI (UNOR) --------------------------------------------------------------------------- END
	
	// JABATAN --------------------------------------------------------------------------- START
	function get_QUERY_Jabatan(){
    $this->db->select('*');
    $this->db->from('tView_Ref_Jabatan');
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
		if($this->input->post('eselon') == 1){
	   	$this->db->where_in('kode_eselon', array(11,12,21,22,31,32,41,42));
		}elseif($this->input->post('non_eselon') == 1){
	   	$this->db->where_in('kode_eselon', array(0,99));
	  }
		if($this->input->post("kode_klp_jab")){
    	$this->db->where('kode_klp_jab', $this->input->post("kode_klp_jab"));
		}
		if($this->input->post("jenis_jab")){
    	$this->db->where('jenis_jab', $this->input->post("jenis_jab"));
		}
    if ($this->input->post('query')){
    	$this->db->like('nama_jab', $this->input->post('query'));
    }
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Jabatan(){
		$data = array();
		
		$this->get_QUERY_Jabatan();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('nama_jab','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Jabatan(){
		$this->get_QUERY_Jabatan();
		return $this->db->count_all_results();
	}
	// JABATAN --------------------------------------------------------------------------- END

	// RUMAH SAKIT --------------------------------------------------------------------------- START
	function get_QUERY_RS(){
    $this->db->select('*');
    $this->db->from('tView_Ref_Rumah_Sakit');
	}

	function get_AllData_RS(){
		$data = array();
		
		$this->get_QUERY_RS();

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
	
	function get_CountData_RS(){
		$this->get_QUERY_RS();
		return $this->db->count_all_results();
	}
	// RUMAH SAKIT --------------------------------------------------------------------------- END
	
	// FUNGSIONAL TERTENTU ---------------------------------------------- START
	function get_QUERY_FungTertentu(){
    $this->db->select('*');
    $this->db->from('tView_tRef_Fung_Tertentu');
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
    if ($this->input->get_post('query')){
    	$this->db->like('nama_fung_tertentu', $this->input->get_post('query'));
    }
	}

	function get_AllData_FungTertentu(){
		$data = array();
		
		$this->get_QUERY_FungTertentu();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_fung_tertentu','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_FungTertentu(){
		$this->get_QUERY_FungTertentu();
		return $this->db->count_all_results();
	}
	// FUNGSIONAL TERTENTU ------------------------------------------- END
	
	// REWARD --------------------------------------------------------------------------- START
	function get_QUERY_Reward(){
    $this->db->select('ID_Reward,kode_reward,nama_reward');
    $this->db->from('tRef_Reward');
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
    if ($this->input->get_post('query')){
    	$this->db->like('kode_reward', $this->input->get_post('query'));
    	$this->db->or_like('nama_reward', $this->input->get_post('query'));
    }
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_Reward(){
		$data = array();
		
		$this->get_QUERY_Reward();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_reward','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Reward(){
		$this->get_QUERY_Reward();
		return $this->db->count_all_results();
	}
	// REWARD --------------------------------------------------------------------------- END

	// HUKDIS --------------------------------------------------------------------------- START
	function get_QUERY_HukDis(){
    $this->db->select('ID_HukDis,kode_hukdis,nama_hukdis,tkt_hukdis,pp');
    $this->db->from('tView_Ref_HukDis');
    if($this->input->post('aktif') == 1){
    	$this->db->where('status_data', 1);
    }
    $this->db->where('kode_hukdis !=', 0);
    if ($this->input->get_post('query')){
    	$this->db->like('kode_hukdis', $this->input->get_post('query'));
    	$this->db->or_like('nama_hukdis', $this->input->get_post('query'));
    	$this->db->or_like('tkt_hukdis', $this->input->get_post('query'));
    }
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData_HukDis(){
		$data = array();
		
		$this->get_QUERY_HukDis();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_hukdis','ASC');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_HukDis(){
		$this->get_QUERY_HukDis();
		return $this->db->count_all_results();
	}
	// HUKDIS --------------------------------------------------------------------------- END

	// PENANDA TANGAN --------------------------------------------------------------------------- START
	function get_QUERY_Penanda_Tangan(){
    $sesi_type = $this->session->userdata("type_zs_simpeg");
    if($sesi_type == 'OPD'){
	    $this->db->select('*');
	    $this->db->from('tView_Pejabat_TTD');
			$sesi_kode_unker = $this->session->userdata("kode_unker_zs_simpeg");
			$this->db->where('kode_unker', $sesi_kode_unker);
    }else{
	    $this->db->select('*');
	    $this->db->from('tView_Trans_TTD');
    }
	}

	function get_AllData_Penanda_Tangan(){
		$data = array();
		
		$this->get_QUERY_Penanda_Tangan();

    $Q = $this->db->get();
    foreach ($Q->result() as $obj){
    	$data[] = $obj;
    }
    return $data;
	}
	
	function get_CountData_Penanda_Tangan(){
		$this->get_QUERY_Penanda_Tangan();
		return $this->db->count_all_results();
	}
	// PENANDA TANGAN --------------------------------------------------------------------------- END		
}
?>