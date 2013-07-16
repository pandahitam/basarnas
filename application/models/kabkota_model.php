<?php
class KabKota_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
    $this->db->select('*');
    $this->db->from('tView_Ref_KabKota');
    if ($this->input->get_post('query')){
    	$this->db->like('kode_kabkota', $this->input->get_post('query'));
    	$this->db->or_like('nama_kabkota', $this->input->get_post('query'));
    }
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData(){
		$data = array();
		
		$this->get_QUERY();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
	    $this->db->order_by('kode_kabkota','ASC');
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
	
	function getLast_kode_kabkota(){
  	$data = array();
  	$Q = $this->db->query("SELECT f_last_kode_kabkota() AS kode_kabkota");
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
  		$kode_kabkota = $data['kode_kabkota'];
    }
    $Q->free_result();
    $this->db->close();
    return $kode_kabkota;
	}
	
	function Insert_Data(){
		$status_data = $this->input->post('status_data') ? 1:0;
		$data = array(
			'kode_prov' => $this->input->post('kode_prov'),
			'nama_kabkota' => $this->input->post('nama_kabkota'),
			'status_data' => $status_data
		);

  	if($this->input->post('ID_KK')){
  		$data_ID = array('ID_KK' => $this->input->post('ID_KK'));
    	$this->db->trans_start();
  		$this->db->update('tRef_KabKota',$data, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}
		
		$kode_kabkota_baru = $this->input->post('kode_kabkota');
		if($this->input->post('kode_kabkota')){
	  	$options = array('kode_kabkota' => $this->input->post('kode_kabkota'));
	  	$Q = $this->db->get_where('tRef_KabKota', $options,1);
	  	if($Q->num_rows() > 0){
	  	  return "Kode Exist";
	    }
		}else{			
			$kode_kabkota_baru = $this->getLast_kode_kabkota();
			if($kode_kabkota_baru){
				$kode_kabkota_baru = (int)$kode_kabkota_baru + 1;
			}else{
				$kode_kabkota_baru = 1;
			}
		}
		
  	$options = array('kode_prov' => $this->input->post('kode_prov'), 'nama_kabkota' => $this->input->post('nama_kabkota'));
  	$Q = $this->db->get_where('tRef_KabKota', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{    	
    	$data_prov = array_merge($data, array('kode_kabkota' => $kode_kabkota_baru));    	
    	$this->db->trans_start();
  		$this->db->insert('tRef_KabKota', $data_prov);
  		$id = $this->db->insert_id();
  		$this->db->trans_complete();
  	  return array($id, $kode_kabkota_baru);
    }
  	$Q->free_result();
  	$this->db->close();
	}

	function Delete_Data(){
		$records = explode('-', $this->input->post('postdata'));
    $this->db->trans_start();
    foreach($records as $id)
    {
    	$this->db->where('ID_KK', $id);
     	$this->db->delete('tRef_KabKota');
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
  	$this->db->from('tView_Ref_KabKota');
  	$this->db->where_in('ID_KK', $selected);
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