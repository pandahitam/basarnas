<?php
class Jabatan_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
    $this->db->select('*');
    $this->db->from('tView_Ref_Jabatan');
    if ($this->input->get_post('query')){
    	$this->db->like('kode_jab', $this->input->get_post('query'));
    	$this->db->or_like('nama_jab', $this->input->get_post('query'));
      $this->db->or_like('jenis_jab', $this->input->get_post('query'));
      $this->db->or_like('klp_jab', $this->input->get_post('query'));
      $this->db->or_like('nama_eselon', $this->input->get_post('query'));
    }
    $this->Filters_Model->get_FILTER();
    $this->db->order_by('jenis_jab','DESC');
  	$this->db->order_by('ID_Jab','ASC');
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
	
	function getLast_kode_jab($kode_klp_jab=''){
  	$data = array();
  	$Q = $this->db->query("SELECT f_last_kode_jab(".$kode_klp_jab.") AS kode_jab");
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
  		$kode_jab = $data['kode_jab'];
    }
    $Q->free_result();
    $this->db->close();
    return $kode_jab;
	}
	
	function Insert_Data(){
		$status_data = $this->input->post('status_data') ? 1:0;
		$data = array(
			'nama_jab' => $this->input->post('nama_jab'),
			'nama_jab_singkatan' => $this->input->post('nama_jab_singkatan'),
			'kode_klp_jab' => $this->input->post('kode_klp_jab'),
			'kode_eselon' => $this->input->post('kode_eselon'),
			'status_data' => $status_data
		);

  	if($this->input->post('ID_Jab')){
  		$data_ID = array('ID_Jab' => $this->input->post('ID_Jab'));
    	$this->db->trans_start();
  		$this->db->update('tRef_Jabatan',$data, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('nama_jab' => $this->input->post('nama_jab'));
  	$Q = $this->db->get_where('tRef_Jabatan', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
			$kode_jab_baru = "";
			$kode_jab_baru = $this->getLast_kode_jab($this->input->post('kode_klp_jab'));
			if ($kode_jab_baru){
				$kode_jab_baru = (int)$kode_jab_baru + 1;
			}else{
				$kode_jab_baru = $this->input->post('kode_klp_jab')."0001";
			}
    	
    	$a_kode_unker_baru = array('kode_jab' => $kode_jab_baru);
    	$data_jab = array_merge($data,$a_kode_unker_baru);
    	
    	$this->db->trans_start();
  		$this->db->insert('tRef_Jabatan', $data_jab);
  		$id = $this->db->insert_id();
  		$this->db->trans_complete();
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}

	function Delete_Data(){
		$records = explode('-', $this->input->post('postdata'));
    $this->db->trans_start();
    foreach($records as $id)
    {
    	$this->db->where('ID_Jab', $id);
     	$this->db->delete('tRef_Jabatan');
    }
  	$this->db->trans_complete();
	}
	
	function get_AllPrint(){
  	$data = array();
  	$this->get_QUERY();
  	$Q = $this->db->get('');
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    $Q->free_result();
    $this->db->close();
    return $data;  	
	}

	function get_SelectedPrint(){
  	$data = array();
  	$selected = explode('-', $this->input->post('postdata'));
  	$this->db->select('*');
  	$this->db->from('tView_Ref_Jabatan');
  	$this->db->where_in('ID_Jab',$selected);
  	$Q = $this->db->get('');
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
?>