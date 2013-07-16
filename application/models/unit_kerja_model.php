<?php
class Unit_Kerja_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
    $this->db->select('*');
    $this->db->from('tView_Ref_UnitKerja');
    if ($this->input->get_post('query')){
    	$this->db->like('kode_unker', $this->input->get_post('query'));
    	$this->db->or_like('nama_unker', $this->input->get_post('query'));
      $this->db->or_like('alamat_unker', $this->input->get_post('query'));
      $this->db->or_like('telp_unker', $this->input->get_post('query'));
      $this->db->or_like('email_unker', $this->input->get_post('query'));
      $this->db->or_like('nama_kec', $this->input->get_post('query'));
    	$this->db->or_like('nama_uki', $this->input->get_post('query'));
    	$this->db->or_like('jns_unker', $this->input->get_post('query'));
    }
    $this->Filters_Model->get_FILTER();
	}
	
	function get_AllData(){
		$data = array();

		$this->get_QUERY();

		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 10;
		
	    $this->db->order_by('kode_unker','ASC');
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

  function get_Count_UKI($kode_uki){
  	$this->db->where('kode_uki', $kode_uki);
  	$this->db->from('tRef_UnitKerja');
    return $this->db->count_all_results();
  }
	
  function getData_ID($id){
  	$data = array();
  	$options = array('ID_UK' => $id);
  	$Q = $this->db->get_where('tRef_UnitKerja', $options,1);
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }  	
    $Q->free_result();
    $this->db->close();
    return $data;
  }
	
	function getLast_kode_unker($jns_unker=''){
  	$data = array();
  	$Q = $this->db->query("SELECT f_last_kode_unker(".$jns_unker.") AS kode_unker");
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
  		$kode_unker = $data['kode_unker'];
    }
    $Q->free_result();
    $this->db->close();
    return $kode_unker;
	}
	
	function Insert_Data(){
		$status_data = $this->input->post('status_data') ? 1:0;
		$data = array(
				'nama_unker' => $this->input->post('nama_unker'),
				'alamat_unker' => $this->input->post('alamat_unker'),
				'telp_unker' => $this->input->post('telp_unker'),
				'email_unker' => $this->input->post('email_unker'),
				'kode_kec' => $this->input->post('kode_kec'),
				'kode_uki' => $this->input->post('kode_uki'),
				'kode_jns_unker' => $this->input->post('kode_jns_unker'),
				'status_data' => $status_data
		);
		
	  	if($this->input->post('ID_UK')){
	  		$data_ID = array('ID_UK' => $this->input->post('ID_UK'));
	    	$this->db->trans_start();
	  		$this->db->update('tRef_UnitKerja',$data, $data_ID);
	  		$this->db->trans_complete();
	  	 	return "Updated"; exit;
	  	}
	  	
	  	$options = array('nama_unker' => $this->input->post('nama_unker'));
	  	$Q = $this->db->get_where('tRef_UnitKerja', $options,1);
	  	if($Q->num_rows() > 0){
	  	  return "Exist";
	    }else{
				$kode_unker_baru = "";
				$kode_unker_baru = $this->getLast_kode_unker($this->input->post('kode_jns_unker'));
				if ($kode_unker_baru){
					$kode_unker_baru = (int)$kode_unker_baru + 1;
				}else{
					$kode_unker_baru = $this->input->post('kode_jns_unker')."0001";
				}
	    	
	    	$a_kode_unker_baru = array('kode_unker' => $kode_unker_baru);
	    	$data_unker = array_merge($data,$a_kode_unker_baru);
	    	
	    	$this->db->trans_start();
	  		$this->db->insert('tRef_UnitKerja', $data_unker);
	  		$id = $this->db->insert_id();
	  		$this->db->trans_complete();
	  	  return $id;
	    }
	  	$Q->free_result();
	  	$this->db->close();
	}

	function Delete_Data(){
		$s_return = FALSE;	
		$records = explode('-', $this->input->post('postdata'), -1);
    foreach($records as $id)
    {
    	$data_uk = $this->getData_ID($id);
    	$kode_uki = $data_uk['kode_unker'];
    	$count_uki = $this->get_Count_UKI($kode_uki);
    	if ($count_uki > 0) {
    		$s_return = FALSE;
    	}else{
    		$this->db->trans_start();
    		$this->db->where('ID_UK', $id);
     		$this->db->delete('tRef_UnitKerja');
  			$this->db->trans_complete();
  			$s_return = TRUE;
  		}
    }    
    return $s_return;
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
	  	$this->db->from("tView_Ref_UnitKerja");
	  	$this->db->where_in('ID_UK',$selected);
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