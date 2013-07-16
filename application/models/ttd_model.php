<?php
class TTD_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
    $this->db->select('*');
    $this->db->from('tView_Trans_TTD');
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
		
    $this->db->order_by('no_urut','ASC');
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
	
	function Insert_Data(){
		$status_data = $this->input->post('status_data') ? 1:0;
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'nama_lengkap' => $this->input->post('nama_lengkap'),
			'kode_unor' => $this->input->post('kode_unor'),
			'kode_jab' => $this->input->post('kode_jab'),
			'kode_golru' => $this->input->post('kode_golru'),
			'no_urut' => $this->input->post('no_urut'),
			'status_data' => $status_data
		);

  	if($this->input->post('IDT_TTD')){
  		$data_ID = array('IDT_TTD' => $this->input->post('IDT_TTD'));
    	$this->db->trans_start();
  		$this->db->update('tTrans_TTD',$data, $data_ID);
  		$this->db->trans_complete();
  	 	return "Updated"; exit;
  	}

  	$options = array('NIP' => $this->input->post('NIP'));
  	$Q = $this->db->get_where('tTrans_TTD', $options,1);
  	if($Q->num_rows() > 0){
  	  return "Exist";
    }else{
    	$this->db->trans_start();
  		$this->db->insert('tTrans_TTD', $data);
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
    	$this->db->where('IDT_TTD', $id);
     	$this->db->delete('tTrans_TTD');
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
  	$this->db->from('tTrans_TTD');
  	$this->db->where_in('IDT_TTD', $selected);
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