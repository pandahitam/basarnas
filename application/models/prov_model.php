<?php
class Prov_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
    $this->db->select('*');
    $this->db->from('tRef_Provinsi');
    if ($this->input->get_post('query')){
    	$this->db->like('kode_prov', $this->input->get_post('query'));
    	$this->db->or_like('nama_prov', $this->input->get_post('query'));
    }
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData(){
		$data = array();
		
		$this->get_QUERY();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
    $this->db->order_by('kode_prov','ASC');
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
	
	function getLast_kode_prov(){
  	$data = array();
  	$Q = $this->db->query("SELECT f_last_kode_prov() AS kode_prov");
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
  		$kode_prov = $data['kode_prov'];
    }
    $Q->free_result();
    $this->db->close();
    return $kode_prov;
	}
	
	function Insert_Data(){
		$status_data = $this->input->post('status_data') ? 1:0;
		$data = array(
			'nama_prov' => $this->input->post('nama_prov'),
			'status_data' => $status_data
		);

  	if($this->input->post('ID_Prov')){
  		$data_ID = array('ID_Prov' => $this->input->post('ID_Prov'));
    	$this->db->trans_start();
  		$this->db->update('tRef_Provinsi',$data, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}
		
		$kode_prov_baru = $this->input->post('kode_prov');
		if($this->input->post('kode_prov')){
	  	$options = array('kode_prov' => $this->input->post('kode_prov'));
	  	$Q = $this->db->get_where('tRef_Provinsi', $options,1);
	  	if($Q->num_rows() > 0){
	  	  return "Kode Exist";
	    }
		}else{			
			$kode_prov_baru = $this->getLast_kode_prov();
			if($kode_prov_baru){
				$kode_prov_baru = (int)$kode_prov_baru + 1;
			}else{
				$kode_prov_baru = 1;
			}
		}
		
  	$options = array('nama_prov' => $this->input->post('nama_prov'));
  	$Q = $this->db->get_where('tRef_Provinsi', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{    	
    	$data_prov = array_merge($data, array('kode_prov' => $kode_prov_baru));    	
    	$this->db->trans_start();
  		$this->db->insert('tRef_Provinsi', $data_prov);
  		$id = $this->db->insert_id();
  		$this->db->trans_complete();
  	  return array($id, $kode_prov_baru);
    }
  	$Q->free_result();
  	$this->db->close();
	}

	function Delete_Data(){
		$records = explode('-', $this->input->post('postdata'));
    $this->db->trans_start();
    foreach($records as $id)
    {
    	$this->db->where('ID_Prov', $id);
     	$this->db->delete('tRef_Provinsi');
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
    return $data;  	
	}

	function get_SelectedPrint(){
  	$data = array();
  	$selected = explode('-', $this->input->post('postdata'));
  	$this->db->select('*');
  	$this->db->from('tRef_Provinsi');
  	$this->db->where_in('ID_Prov', $selected);
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