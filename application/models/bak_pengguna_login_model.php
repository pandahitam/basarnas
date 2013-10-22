<?php
class Pengguna_Login_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY(){
    $this->db->select('*');
    $this->db->from('tView_User');
    if ($this->input->get_post('query')){
    	$this->db->like('user', $this->input->get_post('query'));
    	$this->db->or_like('NIP', $this->input->get_post('query'));
    	$this->db->or_like('fullname', $this->input->get_post('query'));
      $this->db->or_like('email', $this->input->get_post('query'));
      $this->db->or_like('type', $this->input->get_post('query'));
      $this->db->or_like('status', $this->input->get_post('query'));
    }
    $this->Filters_Model->get_FILTER();
	}

	function get_AllData(){
		$data = array();
		$this->get_QUERY();
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
    //$this->db->order_by('ID_User');
   	$this->db->limit($limit, $start);
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }
    return $data;
	}

	function get_CountAllData(){
		$this->get_QUERY();
		return $this->db->count_all_results();
	}
	
	function Insert_Data(){
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'user' => $this->input->post('user'),
			'fullname' => $this->input->post('fullname'),
			'email' => $this->input->post('email'),
			'pass' => MD5($this->input->post('pass')),
			'type' => $this->input->post('type'),
			'status' => $this->input->post('status'),
			'registerDate' => date("Y-m-d H:i:s")
		);		
		
  	$options = array('user' => $this->input->post('user'));
  	$Q = $this->db->get_where('tUser', $options,1);
  	if($Q->num_rows() > 0){
  	  return FALSE;
    }else{
  		$this->db->insert('tUser',$data);
  		$id = $this->db->insert_id();

			if($this->input->post('type') == 'SUPER ADMIN' || $this->input->post('type') == 'ADMIN'){
				$query_menu = "
				INSERT INTO tUser_Menu(ID_User,ID_Menu,u_access,u_insert,u_update,u_delete,u_proses,u_print,u_print_sk) VALUES
				  (".$id.",1,1,9,9,9,9,9,9),(".$id.",2,1,1,1,1,9,1,9),(".$id.",3,1,9,9,9,9,9,9),(".$id.",4,1,1,1,1,9,1,9),(".$id.",5,1,1,1,1,9,1,9),
				  (".$id.",6,1,1,1,1,9,1,9),(".$id.",7,1,1,1,1,9,1,9),(".$id.",8,1,1,1,1,9,1,9),(".$id.",9,1,1,1,1,9,1,9),(".$id.",10,1,1,1,1,9,1,9),
				  (".$id.",11,1,1,1,1,9,1,9),(".$id.",12,1,1,1,1,9,1,9),(".$id.",13,1,1,1,1,9,1,9),(".$id.",14,1,1,1,1,9,1,9),(".$id.",15,1,1,1,1,9,1,9),
				  (".$id.",16,1,1,1,1,9,1,9),(".$id.",17,1,1,1,1,9,1,9),(".$id.",18,1,9,9,9,9,9,9),(".$id.",19,1,9,9,9,9,9,9),(".$id.",20,1,9,9,9,9,9,9),
				  (".$id.",21,1,1,1,1,1,1,1),(".$id.",22,1,1,1,1,1,1,1),(".$id.",23,1,1,1,1,1,1,1),(".$id.",24,1,1,1,1,1,1,1),(".$id.",25,1,1,1,1,1,1,1),
				  (".$id.",26,1,1,1,1,1,1,1),(".$id.",27,1,1,1,1,1,1,1),(".$id.",28,1,1,1,1,1,1,1),(".$id.",29,1,1,1,1,1,1,1),(".$id.",30,1,1,1,1,1,1,1),
				  (".$id.",31,1,1,1,1,1,1,1),(".$id.",32,1,1,1,1,1,1,1),(".$id.",33,1,1,1,1,1,1,1),(".$id.",34,1,9,9,9,9,9,1),(".$id.",35,1,1,1,1,1,1,1),
				  (".$id.",36,1,1,1,1,1,1,1),(".$id.",37,1,1,1,1,1,1,1),(".$id.",38,1,1,1,1,1,1,1),(".$id.",39,1,1,1,1,1,1,1),(".$id.",40,1,1,1,1,1,1,1),
				  (".$id.",41,1,1,1,1,1,1,1),(".$id.",42,1,1,1,1,1,1,1),(".$id.",43,1,1,1,1,1,1,1),(".$id.",44,1,1,1,1,1,1,1),(".$id.",45,1,1,1,1,1,1,1),
				  (".$id.",46,1,1,1,1,1,1,1),(".$id.",47,1,9,9,9,9,9,9),(".$id.",48,1,1,1,1,1,1,1),(".$id.",49,1,1,1,1,1,1,1),(".$id.",50,1,1,1,1,1,1,1),
				  (".$id.",51,1,1,1,1,1,1,1),(".$id.",52,1,9,9,9,9,9,9),(".$id.",53,1,9,9,9,9,1,9),(".$id.",54,1,9,9,9,9,1,9),(".$id.",55,1,9,9,9,9,1,9),
				  (".$id.",56,1,9,9,9,9,1,9),(".$id.",57,1,9,9,9,9,1,9),(".$id.",58,1,9,9,9,9,1,9),(".$id.",59,1,9,9,9,9,1,9),(".$id.",60,1,9,9,9,9,1,9),
				  (".$id.",61,1,9,9,9,9,1,9),(".$id.",62,1,9,9,9,9,1,9)
				";
			}elseif($this->input->post('type') == 'PENGELOLA SIMPEG'){
				$query_menu = "
				INSERT INTO tUser_Menu(ID_User,ID_Menu,u_access,u_insert,u_update,u_delete,u_proses,u_print,u_print_sk) VALUES
				  (".$id.",1,1,9,9,9,9,9,9),(".$id.",2,0,0,0,0,9,0,9),(".$id.",3,1,9,9,9,9,9,9),(".$id.",4,1,1,1,1,9,1,9),(".$id.",5,1,1,1,1,9,1,9),
				  (".$id.",6,1,1,1,1,9,1,9),(".$id.",7,1,1,1,1,9,1,9),(".$id.",8,1,1,1,1,9,1,9),(".$id.",9,1,1,1,1,9,1,9),(".$id.",10,1,1,1,1,9,1,9),
				  (".$id.",11,1,1,1,1,9,1,9),(".$id.",12,1,1,1,1,9,1,9),(".$id.",13,1,1,1,1,9,1,9),(".$id.",14,1,1,1,1,9,1,9),(".$id.",15,1,1,1,1,9,1,9),
				  (".$id.",16,1,1,1,1,9,1,9),(".$id.",17,1,1,1,1,9,1,9),(".$id.",18,0,9,9,9,9,9,9),(".$id.",19,0,9,9,9,9,9,9),(".$id.",20,1,9,9,9,9,9,9),
				  (".$id.",21,1,1,1,1,1,1,1),(".$id.",22,1,1,1,1,1,1,1),(".$id.",23,1,1,1,1,1,1,1),(".$id.",24,1,1,1,1,1,1,1),(".$id.",25,1,1,1,1,1,1,1),
				  (".$id.",26,1,1,1,1,1,1,1),(".$id.",27,1,1,1,1,1,1,1),(".$id.",28,1,1,1,1,1,1,1),(".$id.",29,1,1,1,1,1,1,1),(".$id.",30,1,1,1,1,1,1,1),
				  (".$id.",31,1,1,1,1,1,1,1),(".$id.",32,1,1,1,1,1,1,1),(".$id.",33,1,1,1,1,1,1,1),(".$id.",34,1,9,9,9,9,9,9),(".$id.",35,1,1,1,1,1,1,1),
				  (".$id.",36,1,1,1,1,1,1,1),(".$id.",37,1,1,1,1,1,1,1),(".$id.",38,1,1,1,1,1,1,1),(".$id.",39,1,1,1,1,1,1,1),(".$id.",40,1,1,1,1,1,1,1),
				  (".$id.",41,1,1,1,1,1,1,1),(".$id.",42,1,1,1,1,1,1,1),(".$id.",43,1,1,1,1,1,1,1),(".$id.",44,1,1,1,1,1,1,1),(".$id.",45,1,1,1,1,1,1,1),
				  (".$id.",46,1,1,1,1,1,1,1),(".$id.",47,1,9,9,9,9,9,9),(".$id.",48,1,1,1,1,1,1,1),(".$id.",49,1,1,1,1,1,1,1),(".$id.",50,1,1,1,1,1,1,1),
				  (".$id.",51,1,1,1,1,1,1,1),(".$id.",52,1,9,9,9,9,9,9),(".$id.",53,1,9,9,9,9,1,9),(".$id.",54,1,9,9,9,9,1,9),(".$id.",55,1,9,9,9,9,1,9),
				  (".$id.",56,1,9,9,9,9,1,9),(".$id.",57,1,9,9,9,9,1,9),(".$id.",58,1,9,9,9,9,1,9),(".$id.",59,1,9,9,9,9,1,9),(".$id.",60,1,9,9,9,9,1,9),
				  (".$id.",61,1,9,9,9,9,1,9),(".$id.",62,1,9,9,9,9,1,9)
				";
			}else{
				$query_menu = "
				INSERT INTO tUser_Menu(ID_User,ID_Menu,u_access,u_insert,u_update,u_delete,u_proses,u_print,u_print_sk) VALUES
				  (".$id.",1,1,9,9,9,9,9,9),(".$id.",2,0,0,0,0,9,0,9),(".$id.",3,0,9,9,9,9,9,9),(".$id.",4,0,0,0,0,9,0,9),(".$id.",5,0,0,0,0,9,0,9),
				  (".$id.",6,0,0,0,0,9,0,9),(".$id.",7,0,0,0,0,9,0,9),(".$id.",8,0,0,0,0,9,0,9),(".$id.",9,0,0,0,0,9,0,9),(".$id.",10,0,0,0,0,9,0,9),
				  (".$id.",11,0,0,0,0,9,0,9),(".$id.",12,0,0,0,0,9,0,9),(".$id.",13,0,0,0,0,9,0,9),(".$id.",14,0,0,0,0,9,0,9),(".$id.",15,0,0,0,0,9,0,9),
				  (".$id.",16,0,0,0,0,9,0,9),(".$id.",17,1,1,1,1,9,1,9),(".$id.",18,0,9,9,9,9,9,9),(".$id.",19,0,9,9,9,9,9,9),(".$id.",20,1,9,9,9,9,9,9),
				  (".$id.",21,1,1,1,1,0,1,0),(".$id.",22,1,1,1,1,0,1,0),(".$id.",23,1,1,1,1,0,1,0),(".$id.",24,1,1,1,1,0,1,0),(".$id.",25,1,1,1,1,0,1,0),
				  (".$id.",26,1,1,1,1,0,1,0),(".$id.",27,1,1,1,1,0,1,0),(".$id.",28,1,1,1,1,0,1,0),(".$id.",29,1,1,1,1,0,1,0),(".$id.",30,1,1,1,1,0,1,0),
				  (".$id.",31,1,1,1,1,0,1,0),(".$id.",32,1,1,1,1,0,1,0),(".$id.",33,1,1,1,1,0,1,0),(".$id.",34,1,9,9,9,9,9,9),(".$id.",35,0,0,0,0,0,0,0),
				  (".$id.",36,0,0,0,0,0,0,0),(".$id.",37,0,0,0,0,0,0,0),(".$id.",38,0,0,0,0,0,0,0),(".$id.",39,0,0,0,0,0,0,0),(".$id.",40,0,0,0,0,0,0,0),
				  (".$id.",41,0,0,0,0,0,0,0),(".$id.",42,0,0,0,0,0,0,0),(".$id.",43,0,0,0,0,0,0,0),(".$id.",44,0,0,0,0,0,0,0),(".$id.",45,0,0,0,0,0,0,0),
				  (".$id.",46,0,0,0,0,0,0,0),(".$id.",47,1,9,9,9,9,9,9),(".$id.",48,0,0,0,0,0,0,0),(".$id.",49,0,0,0,0,0,0,0),(".$id.",50,0,0,0,0,0,0,0),
				  (".$id.",51,0,0,0,0,0,0,0),(".$id.",52,1,9,9,9,9,9,9),(".$id.",53,1,9,9,9,9,1,9),(".$id.",54,1,9,9,9,9,1,9),(".$id.",55,1,9,9,9,9,1,9),
				  (".$id.",56,1,9,9,9,9,1,9),(".$id.",57,1,9,9,9,9,1,9),(".$id.",58,1,9,9,9,9,1,9),(".$id.",59,1,9,9,9,9,1,9),(".$id.",60,1,9,9,9,9,1,9),
				  (".$id.",61,1,9,9,9,9,1,9),(".$id.",62,1,9,9,9,9,1,9)
				";
			}
  		$this->db->query($query_menu);
  	  return TRUE;
  	}	
	}

	function Update_Data(){
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'fullname' => $this->input->post('fullname'),
			'email' => $this->input->post('email'),
			'type' => $this->input->post('type'),
			'status' => $this->input->post('status')
		);
  	$this->db->where('ID_User',$this->input->post('ID_User'));
    $this->db->update('tUser',$data); 
    $this->db->close();
    return TRUE;
	}

	function Delete_Data(){
		$records = explode('-', $this->input->post('postdata'));
    foreach($records as $id)
    {
    	if($id == 1 && $this->session->userdata("iduser_zs_simpeg") != 1){
    	}else{
    		$this->db->where('ID_User', $id);
     		$this->db->delete('tUser');
     	}
    }
    return TRUE;
	}

	function get_Type_User($ID_User=0){
  	$data = array(); $type='';
  	$options = array('ID_User' => $ID_User);
  	$Q = $this->db->get_where('tUser', $options,1);
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
  		$type = $data['type'];
    }
    $Q->free_result();
    return $type;
	}

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
		$this->db->select('*');
		$this->db->from('tView_User');
		$this->db->where_in('ID_User', $selected);
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
	
	function get_AllDataPrint(){
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

	function get_SelectedDataPrint($xterpilih=''){
  	$data = array();
  	$terpilih = explode('-', $xterpilih, -1);
  	$this->db->select('*');
  	$this->db->from('tUser');
  	$this->db->where_in('ID_User',$terpilih);
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

	function get_RangeDataPrint($xdari='',$xsampai=''){
  	$data = array();
  	$offset = $xdari - 1;
  	$numrows = $xsampai - $offset;
  	$this->get_QUERY();
  	$this->db->limit($numrows, $offset);
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
	
	// AKSES MENU ---------------------------------------------------- START
	function get_AllData_Parent_Menu(){
		$data = array();
    $this->db->select('*');
    $this->db->where('ID_User', $this->input->post('ID_User'));
    $this->db->where('parent_id', 0);
    $this->db->from('tView_Menu');
    $this->db->order_by('ID_Menu');
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    return $data;
	}

	function get_AllData_Child_Menu($parent_id=''){
		$data = array();
    $this->db->select('*');
    $this->db->where('ID_User', $this->input->post('ID_User'));
    $this->db->where('parent_id', $parent_id);
    $this->db->from('tView_Menu');
    $this->db->order_by('ID_Menu');
    $Q = $this->db->get();
  	if($Q->num_rows() > 0){
  		foreach ($Q->result_array() as $row){
  			$data[] = $row;
  	  }
  	}
    return $data;
	}
	// AKSES MENU ---------------------------------------------------- END

}
?>