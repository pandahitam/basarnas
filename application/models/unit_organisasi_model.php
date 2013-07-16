<?php
class Unit_Organisasi_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
    $this->db->select('*');
    $this->db->from('tView_Ref_Unor');
    if ($this->input->get_post('query')){
    	$this->db->like('kode_unor', $this->input->get_post('query'));
    	$this->db->or_like('nama_unor', $this->input->get_post('query'));
    	$this->db->or_like('jabatan_unor', $this->input->get_post('query'));
    	$this->db->or_like('nama_unker', $this->input->get_post('query'));
      $this->db->or_like('nama_eselon', $this->input->get_post('query'));
    }
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData(){
		$data = array();
		
		$this->get_QUERY();

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
	
	function get_CountData(){
		$this->get_QUERY();
		return $this->db->count_all_results();
	}
	
	function getLast_kode_unor(){
  	$data = array();
  	$Q = $this->db->query("SELECT f_last_kode_unor() AS kode_unor");
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
  		$kode_unor = $data['kode_unor'];
    }
    $Q->free_result();
    $this->db->close();
    return $kode_unor;
	}

	function Insert_Data(){
		$status_data = $this->input->post('status_data') ? 1:0;
		$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
		$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
		$data = array(
			'urut_unor' => $this->input->post('urut_unor'),
			'nama_unor' => $this->input->post('nama_unor'),
			'jabatan_unor' => $this->input->post('jabatan_unor'),
			'kode_unker' => $this->input->post('kode_unker'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_eselon' => $this->input->post('kode_eselon'),
			'kode_parent' => $this->input->post('kode_parent'),
			'status_data' => $status_data
		);

  	if($this->input->post('ID_Unor')){
  		$data_ID = array('ID_Unor' => $this->input->post('ID_Unor'));
    	$this->db->trans_start();
  		$this->db->update('tRef_Unor',$data, $data_ID);
  		$this->db->update('tRef_Unor',$data_s_update, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}
  	
  	$options = array('kode_unker' => $this->input->post('kode_unker'), 'kode_jab' => $this->input->post('kode_jab'), 'nama_unor' => $this->input->post('nama_unor'));
  	$Q = $this->db->get_where('tRef_Unor', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
			$kode_unor_baru = "";
			$kode_unor_baru = $this->getLast_kode_unor($this->input->post('kode_jns_unker'));
			if ($kode_unor_baru){
				$kode_unor_baru = (int)$kode_unor_baru + 1;
			}else{
				$kode_unor_baru = 1;
			}
    	
    	$a_kode_unor_baru = array('kode_unor' => $kode_unor_baru);
    	$data_unor = array_merge($data,$a_kode_unor_baru);
    	
    	$this->db->trans_start();
  		$this->db->insert('tRef_Unor', $data_unor);
  		$id = $this->db->insert_id();
  		$this->db->update('tRef_Unor',$data_s_insert, array('ID_Unor' => $id));
  		$this->db->trans_complete();
  	  return $id;
    }
  	$Q->free_result();
  	$this->db->close();
	}

	function Delete_Data(){
		$records = explode('-', $this->input->post('postdata'), -1);
    $this->db->trans_start();
    foreach($records as $id)
    {
    	$this->db->where('ID_Unor', $id);
     	$this->db->delete('tRef_Unor');
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
  	$this->db->from('tView_Ref_Unor');
  	$this->db->where_in('ID_Unor',$selected);
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