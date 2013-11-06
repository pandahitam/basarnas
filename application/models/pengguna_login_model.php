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
			//$this->db->or_like('type', $this->input->get_post('query'));
			$this->db->or_like('status', $this->input->get_post('query'));
		}
		$this->db->join('tuser_semar_menu_group_collections', 'tView_User.group = tuser_semar_menu_group_collections.id_groupcollections', 'left');
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
	
	/*
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
				  (".$id.",16,1,1,1,1,9,1,9),(".$id.",17,1,1,1,1,9,1,9),(".$id.",18,1,1,1,1,9,1,9),(".$id.",19,1,1,1,1,9,1,9),(".$id.",20,1,1,1,1,9,1,9),
				  (".$id.",21,1,1,1,1,9,1,9),(".$id.",22,1,1,1,1,9,1,9),(".$id.",23,1,9,9,9,9,9,9),(".$id.",24,1,9,9,9,9,9,9),(".$id.",25,1,9,9,9,9,9,9),
				  (".$id.",26,1,1,1,1,1,1,1),(".$id.",27,1,1,1,1,1,1,1),(".$id.",28,1,1,1,1,1,1,1),(".$id.",29,1,1,1,1,1,1,1),(".$id.",30,1,1,1,1,1,1,1),
				  (".$id.",31,1,1,1,1,1,1,1),(".$id.",32,1,1,1,1,1,1,1),(".$id.",33,1,1,1,1,1,1,1),(".$id.",34,1,1,1,1,1,1,1),(".$id.",35,1,1,1,1,1,1,1),
				  (".$id.",36,1,1,1,1,1,1,1),(".$id.",37,1,1,1,1,1,1,1),(".$id.",38,1,1,1,1,1,1,1),(".$id.",39,1,9,9,9,9,9,9),(".$id.",40,1,1,1,1,1,1,1),
				  (".$id.",41,1,1,1,1,1,1,1),(".$id.",42,1,1,1,1,1,1,1),(".$id.",43,1,1,1,1,1,1,1),(".$id.",44,1,1,1,1,1,1,1),(".$id.",45,1,1,1,1,1,1,1),
				  (".$id.",46,1,1,1,1,1,1,1),(".$id.",47,1,1,1,1,1,1,1),(".$id.",48,1,1,1,1,1,1,1),(".$id.",49,1,1,1,1,1,1,1),(".$id.",50,1,1,1,1,1,1,1),
				  (".$id.",51,1,1,1,1,1,1,1),(".$id.",52,1,9,9,9,9,9,9),(".$id.",53,1,1,1,1,1,1,1),(".$id.",54,1,1,1,1,1,1,1),(".$id.",55,1,1,1,1,1,1,1),
				  (".$id.",56,1,1,1,1,1,1,1),(".$id.",57,1,1,1,1,1,1,1),(".$id.",58,1,9,9,9,9,9,9),(".$id.",59,1,9,9,9,9,1,9),(".$id.",60,1,9,9,9,9,1,9),
				  (".$id.",61,1,9,9,9,9,1,9),(".$id.",62,1,9,9,9,9,1,9),(".$id.",63,1,9,9,9,9,1,9),(".$id.",64,1,9,9,9,9,1,9),(".$id.",65,1,9,9,9,9,1,9),
				  (".$id.",66,1,9,9,9,9,1,9),(".$id.",67,1,9,9,9,9,1,9),(".$id.",68,1,9,9,9,9,1,9),(".$id.",69,1,9,9,9,9,1,9),(".$id.",70,1,9,9,9,9,1,9),
				  (".$id.",71,1,1,1,1,1,1,1)
				";
			}elseif($this->input->post('type') == 'PENGELOLA SIMPEG'){
				$query_menu = "
				INSERT INTO tUser_Menu(ID_User,ID_Menu,u_access,u_insert,u_update,u_delete,u_proses,u_print,u_print_sk) VALUES
				  (".$id.",1,1,9,9,9,9,9,9),(".$id.",2,0,0,0,0,9,0,9),(".$id.",3,0,0,0,0,9,0,9),(".$id.",4,0,0,0,0,9,0,9),(".$id.",5,0,0,0,0,9,0,9),
				  (".$id.",6,0,0,0,0,9,0,9),(".$id.",7,0,0,0,0,9,0,9),(".$id.",8,0,0,0,0,9,0,9),(".$id.",9,0,0,0,0,9,0,9),(".$id.",10,0,0,0,0,9,0,9),
				  (".$id.",11,0,0,0,0,9,0,9),(".$id.",12,0,0,0,0,9,0,9),(".$id.",13,0,0,0,0,9,0,9),(".$id.",14,0,0,0,0,9,0,9),(".$id.",15,0,0,0,0,9,0,9),
				  (".$id.",16,0,0,0,0,9,0,9),(".$id.",17,0,0,0,0,9,0,9),(".$id.",18,0,0,0,0,9,0,9),(".$id.",19,0,0,0,0,9,0,9),(".$id.",20,0,0,0,0,9,0,9),
				  (".$id.",21,0,0,0,0,9,0,9),(".$id.",22,1,1,1,1,9,1,9),(".$id.",23,0,9,9,9,9,9,9),(".$id.",24,0,9,9,9,9,9,9),(".$id.",25,1,9,9,9,9,9,9),
				  (".$id.",26,1,1,1,1,1,1,1),(".$id.",27,1,1,1,1,1,1,1),(".$id.",28,1,1,1,1,1,1,1),(".$id.",29,1,1,1,1,1,1,1),(".$id.",30,1,1,1,1,1,1,1),
				  (".$id.",31,1,1,1,1,1,1,1),(".$id.",32,1,1,1,1,1,1,1),(".$id.",33,1,1,1,1,1,1,1),(".$id.",34,1,1,1,1,1,1,1),(".$id.",35,1,1,1,1,1,1,1),
				  (".$id.",36,1,1,1,1,1,1,1),(".$id.",37,1,1,1,1,1,1,1),(".$id.",38,1,1,1,1,1,1,1),(".$id.",39,1,9,9,9,9,9,9),(".$id.",40,1,1,1,1,1,1,1),
				  (".$id.",41,1,1,1,1,1,1,1),(".$id.",42,1,1,1,1,1,1,1),(".$id.",43,1,1,1,1,1,1,1),(".$id.",44,1,1,1,1,1,1,1),(".$id.",45,1,1,1,1,1,1,1),
				  (".$id.",46,1,1,1,1,1,1,1),(".$id.",47,1,1,1,1,1,1,1),(".$id.",48,1,1,1,1,1,1,1),(".$id.",49,1,1,1,1,1,1,1),(".$id.",50,1,1,1,1,1,1,1),
				  (".$id.",51,1,1,1,1,1,1,1),(".$id.",52,1,9,9,9,9,9,9),(".$id.",53,1,1,1,1,1,1,1),(".$id.",54,1,1,1,1,1,1,1),(".$id.",55,1,1,1,1,1,1,1),
				  (".$id.",56,1,1,1,1,1,1,1),(".$id.",57,1,1,1,1,1,1,1),(".$id.",58,1,9,9,9,9,9,9),(".$id.",59,1,9,9,9,9,1,9),(".$id.",60,1,9,9,9,9,1,9),
				  (".$id.",61,1,9,9,9,9,1,9),(".$id.",62,1,9,9,9,9,1,9),(".$id.",63,1,9,9,9,9,1,9),(".$id.",64,1,9,9,9,9,1,9),(".$id.",65,1,9,9,9,9,1,9),
				  (".$id.",66,1,9,9,9,9,1,9),(".$id.",67,1,9,9,9,9,1,9),(".$id.",68,1,9,9,9,9,1,9),(".$id.",69,1,9,9,9,9,1,9),(".$id.",70,1,9,9,9,9,1,9),(".$id.",71,1,1,1,1,1,1,1)
				";
			}else{
				$query_menu = "
				INSERT INTO tUser_Menu(ID_User,ID_Menu,u_access,u_insert,u_update,u_delete,u_proses,u_print,u_print_sk) VALUES
				  (".$id.",1,1,9,9,9,9,9,9),(".$id.",2,0,0,0,0,9,0,9),(".$id.",3,0,0,0,0,9,0,9),(".$id.",4,0,0,0,0,9,0,9),(".$id.",5,0,0,0,0,9,0,9),
				  (".$id.",6,0,0,0,0,9,0,9),(".$id.",7,0,0,0,0,9,0,9),(".$id.",8,0,0,0,0,9,0,9),(".$id.",9,0,0,0,0,9,0,9),(".$id.",10,0,0,0,0,9,0,9),
				  (".$id.",11,0,0,0,0,9,0,9),(".$id.",12,0,0,0,0,9,0,9),(".$id.",13,0,0,0,0,9,0,9),(".$id.",14,0,0,0,0,9,0,9),(".$id.",15,0,0,0,0,9,0,9),
				  (".$id.",16,0,0,0,0,9,0,9),(".$id.",17,0,0,0,0,9,0,9),(".$id.",18,0,0,0,0,9,0,9),(".$id.",19,0,0,0,0,9,0,9),(".$id.",20,0,0,0,0,9,0,9),
				  (".$id.",21,0,0,0,0,9,0,9),(".$id.",22,1,1,1,1,9,1,9),(".$id.",23,0,9,9,9,9,9,9),(".$id.",24,0,9,9,9,9,9,9),(".$id.",25,1,9,9,9,9,9,9),
				  (".$id.",26,1,1,1,1,1,1,1),(".$id.",27,1,1,1,1,1,1,1),(".$id.",28,1,1,1,1,1,1,1),(".$id.",29,1,1,1,1,1,1,1),(".$id.",30,1,1,1,1,1,1,1),
				  (".$id.",31,1,1,1,1,1,1,1),(".$id.",32,1,1,1,1,1,1,1),(".$id.",33,1,1,1,1,1,1,1),(".$id.",34,1,1,1,1,1,1,1),(".$id.",35,1,1,1,1,1,1,1),
				  (".$id.",36,1,1,1,1,1,1,1),(".$id.",37,1,1,1,1,1,1,1),(".$id.",38,1,1,1,1,1,1,1),(".$id.",39,0,9,9,9,9,9,9),(".$id.",40,0,0,0,0,0,0,0),
				  (".$id.",41,0,0,0,0,0,0,0),(".$id.",42,0,0,0,0,0,0,0),(".$id.",43,0,0,0,0,0,0,0),(".$id.",44,0,0,0,0,0,0,0),(".$id.",45,0,0,0,0,0,0,0),
				  (".$id.",46,0,0,0,0,0,0,0),(".$id.",47,0,0,0,0,0,0,0),(".$id.",48,0,0,0,0,0,0,0),(".$id.",49,0,0,0,0,0,0,0),(".$id.",50,0,0,0,0,0,0,0),
				  (".$id.",51,0,0,0,0,0,0,0),(".$id.",52,1,9,9,9,9,9,9),(".$id.",53,1,1,1,1,1,1,1),(".$id.",54,1,1,1,1,1,1,1),(".$id.",55,1,1,1,1,1,1,1),
				  (".$id.",56,1,1,1,1,1,1,1),(".$id.",57,1,1,1,1,1,1,1),(".$id.",58,1,9,9,9,9,9,9),(".$id.",59,1,9,9,9,9,1,9),(".$id.",60,1,9,9,9,9,1,9),
				  (".$id.",61,1,9,9,9,9,1,9),(".$id.",62,1,9,9,9,9,1,9),(".$id.",63,1,9,9,9,9,1,9),(".$id.",64,1,9,9,9,9,1,9),(".$id.",65,1,9,9,9,9,1,9),
				  (".$id.",66,1,9,9,9,9,1,9),(".$id.",67,1,9,9,9,9,1,9),(".$id.",68,1,9,9,9,9,1,9),(".$id.",69,1,9,9,9,9,1,9),(".$id.",70,1,9,9,9,9,1,9),
				  (".$id.",71,1,1,1,1,1,1,1)
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
	*/
	
	
	
	function Insert_Data(){
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'user' => $this->input->post('user'),
			'fullname' => $this->input->post('fullname'),
			'email' => $this->input->post('email'),
			'pass' => MD5($this->input->post('pass')),
			//'type' => $this->input->post('type'),
			'group' => $this->input->post('group'),
			'status' => $this->input->post('status'),
			'registerDate' => date("Y-m-d H:i:s")
		);
		
		$bak_nama_unker = $this->input->post('nama_unker');
		if($bak_nama_unker!=null){
			$data['temp_kode_unker'] = $bak_nama_unker;
			
			if((str_replace(' ','', strtolower($bak_nama_unker))=="badansarnasional") || $bak_nama_unker=='107010199414370000KP'){
				$bak_nama_unor = $this->input->post('nama_unor');
				if($bak_nama_unor!=null){
					$data['temp_kode_unor'] = $bak_nama_unor;
				}else{
					$data['temp_kode_unor'] = 0;
				}
			}else{
				$data['temp_kode_unor'] = 0;
			}
		}
		
		$options = array('user' => $this->input->post('user'));
		$Q = $this->db->get_where('tUser', $options,1);
		if($Q->num_rows() > 0){
			return FALSE;
		}else{
			$this->db->insert('tUser',$data);
			$id = $this->db->insert_id();
			return TRUE;
		}	
	}
	
	function Update_Data(){
		$data = array(
			'NIP' => $this->input->post('NIP'),
			'fullname' => $this->input->post('fullname'),
			'email' => $this->input->post('email'),
			'group' => $this->input->post('group'),
			'status' => $this->input->post('status')
		);
		
		$bak_nama_unker = $this->input->post('nama_unker');
		if($bak_nama_unker!=null){
			$data['temp_kode_unker'] = $bak_nama_unker;
			
			if((str_replace(' ','', strtolower($bak_nama_unker))=="badansarnasional") || $bak_nama_unker=='107010199414370000KP'){
				$bak_nama_unor = $this->input->post('nama_unor');
				if($bak_nama_unor!=null){
					$data['temp_kode_unor'] = $bak_nama_unor;
				}else{
					$data['temp_kode_unor'] = 0;
				}
			}else{
				$data['temp_kode_unor'] = 0;
			}
		}
		
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
				$this->db->close();
				$this->deleteMenuUser($id);
			}
		}
		return TRUE;
	}
	
	private function deleteMenuUser($idx){
		$this->db->where('ID_User', $idx);
		$this->db->delete('tUser_Menu');
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
	
	
	//menu
	function getAllVariableJSMenuUser(){
		$result = array();
		$gorupid_zs_simpeg = $this->session->userdata("gorupid_zs_simpeg");
		$this->db->select('*');
		$this->db->from('tuser_semar_menu_group_menu');
		$this->db->join('tuser_semar_menu_group_collections', 'tuser_semar_menu_group_menu.ID_Group_Menu_ID_Group = tuser_semar_menu_group_collections.id_groupcollections', 'left');
		$this->db->join('tuser_semar_menu', 'tuser_semar_menu_group_menu.ID_Group_Menu_ID_Menu = tuser_semar_menu.idmenu', 'left');
		$this->db->where('id_groupcollections',$gorupid_zs_simpeg);
		$this->db->order_by('ID_Group_Menu');
		$Q = $this->db->get();
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$general_variableprefix = $row['general_variableprefix'];
				if(strlen($general_variableprefix) > 0){
					$result[] = "var ".$general_variableprefix."_insert = !".($row['u_insert'] ? "true" : "false");
					$result[] = "var ".$general_variableprefix."_update = !".($row['u_update'] ? "true" : "false");
					$result[] = "var ".$general_variableprefix."_delete = !".($row['u_delete'] ? "true" : "false");
					$result[] = "var ".$general_variableprefix."_access = !".($row['u_access'] ? "true" : "false");
					$result[] = "var ".$general_variableprefix."_print = !".($row['u_print'] ? "true" : "false");
					$result[] = "var ".$general_variableprefix."_print_sk = !".($row['u_print_sk'] ? "true" : "false");
					$result[] = "var ".$general_variableprefix."_proses = !".($row['u_proses'] ? "true" : "false");
					
					//variable tambhana yg ada disistem berjalan
					$result[] = "var ".$general_variableprefix."_insert_pgw = !".($row['u_insert'] ? "true" : "false");
					$result[] = "var ".$general_variableprefix."_delete_pgw = !".($row['u_delete'] ? "true" : "false");
					//end variable tambhana yg ada disistem berjalan
				}
			}
		}
		return implode("\n", $result);
	}
	function checkMenuForUser($idmenu){
		$status = false;
		$gorupid_zs_simpeg = $this->session->userdata("gorupid_zs_simpeg");
		$this->db->select('*');
		$this->db->from('tuser_semar_menu_group_menu');
		$this->db->where('ID_Group_Menu_ID_Menu',$idmenu);
		$this->db->where('ID_Group_Menu_ID_Group',$gorupid_zs_simpeg);
		
		$Q = $this->db->get();
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				if($row['u_access']==1 && $status==false){
					$status = true;
					break;
				}
			}
		}
		return $status;
	}
	function get_AllData_Menu_ExtJS($orderby='idmenu', $wherex=null){
		
		$resultmenu = array();
		$temp = $this->get_AllData_Menu($orderby, $wherex);
		
		foreach($temp as $key => $value){
			
			if((strtolower($value['general_type'])=='mainmenu' && $value['general_url']!="#") || ((strtolower($value['general_type'])=='tabpage' || strtolower($value['general_type'])=='popup' || strtolower($value['general_type'])=='page') && $value['parent_idmenu']==0 )){
				
				if(((strtolower($value['general_type'])=='tabpage' || strtolower($value['general_type'])=='popup' || strtolower($value['general_type'])=='page') && $value['parent_idmenu']==0 )){
					$temp_handl = 'Load_TabPage';
					if(strtolower($value['general_type'])=='popup'){
						$temp_handl = 'Load_Popup';
					}else if(strtolower($value['general_type'])=='page'){
						$temp_handl = 'Load_Page';
					}
					$resultmenu[] = "{text: '".$value['general_text']."',iconCls: '".$value['general_iconclass']."', id: '".$value['general_idbutton']."', handler: function(){".$temp_handl."('".$value['general_idnewtab_popup']."', BASE_URL + '".$value['general_url']."');}}";
				}else if((strtolower($value['general_type'])=='mainmenu' && $value['general_url']!="#")){
					$temp_child = $this->get_AllData_Menu_ExtJS('idmenu', array('key'=>'parent_idmenu', 'val'=>$value['idmenu']));
					$temp_resultmenu = "";
					if(strlen($temp_child) > 7){
						$temp_resultmenu = ", menu:{items:[".$temp_child."]}";
					}
					if(strtolower($value['general_status'])=='active' && $value['general_ismenu']==1 && $this->checkMenuForUser($value['idmenu'])==true){
						$resultmenu[] = "{text: '".$value['general_text']."',iconCls: '".$value['general_iconclass']."', id: '".$value['general_idbutton']."'".$temp_resultmenu."}";
					}
				}
				
			}else if(((strtolower($value['general_type'])=='mainmenu' && $value['general_url']=="#") || (strtolower($value['general_type'])=='tabpage' || strtolower($value['general_type'])=='popup' || strtolower($value['general_type'])=='page')) && $wherex!=null){
				if(strtolower($value['general_type'])=='mainmenu'){
					$temp_child = $this->get_AllData_Menu_ExtJS('idmenu', array('key'=>'parent_idmenu', 'val'=>$value['idmenu']));
					$temp_resultmenu = "";
					if(strlen($temp_child) > 7){
						$temp_resultmenu = ", menu:{items:[".$temp_child."]}";
					}
					if(strtolower($value['general_status'])=='active' && $value['general_ismenu']==1 && $this->checkMenuForUser($value['idmenu'])==true){
						$resultmenu[] = "{text: '".$value['general_text']."',iconCls: '".$value['general_iconclass']."', id: '".$value['general_idbutton']."'".$temp_resultmenu."}";
					}
				}else if((strtolower($value['general_type'])=='tabpage' || strtolower($value['general_type'])=='popup' || strtolower($value['general_type'])=='page')){
					$temp_handl = 'Load_TabPage';
					if(strtolower($value['general_type'])=='popup'){
						$temp_handl = 'Load_Popup';
					}else if(strtolower($value['general_type'])=='page'){
						$temp_handl = 'Load_Page';
					}
					if(strtolower($value['general_status'])=='active' && $value['general_ismenu']==1 && $this->checkMenuForUser($value['idmenu'])==true){
						$lp_temp = array();
						$lp_temp[] = "{text: '".$value['general_text']."',iconCls: '".$value['general_iconclass']."', id: '".$value['general_idbutton']."', handler: function(){".$temp_handl."('".$value['general_idnewtab_popup']."', BASE_URL + '".$value['general_url']."');}}";
						if(strtolower($value['general_bottombreak'])==1){
							$lp_temp[] ="'-'";
						}
						$lp_temp = implode(",", $lp_temp);
						$resultmenu[] =$lp_temp;
					}
				}
			}
		}
		return implode(",", $resultmenu);
	}
	function get_AllData_Menu($orderby='idmenu', $wherex=null){
		$data = array();
		$this->db->select('*');
		$this->db->from('tuser_semar_menu');
		$this->db->order_by($orderby);
		if($wherex!=null){
			$this->db->where($wherex['key'], $wherex['val']);
		}
		$Q = $this->db->get();
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$temp_row = $row;
				if($row['parent_idmenu']!=0 && $wherex==null){
					$t_row_parent = $this->get_AllData_Menu('idmenu', array('key'=>'idmenu', 'val'=>$row['parent_idmenu']));
					if(count($t_row_parent) > 0){
						$temp_row['parent_text'] = $t_row_parent[0]['general_text'];
					}
				}
				$data[] = $temp_row;
			}
		}
		return $data;
	}
	
	function Insert_Data_Menu(){
		$idmenu = $this->input->post('idmenu');
		$data = array(
			'parent_idmenu' => $this->input->post('parent_idmenu'),
			'general_ismenu' => ($this->input->post('general_ismenu')==('on'||1) ? 1 : 0),
			'general_text' => $this->input->post('general_text'),
			'general_variableprefix' => $this->input->post('general_variableprefix'),
			'general_iconclass' => $this->input->post('general_iconclass'),
			'general_idbutton' => $this->input->post('general_idbutton'),
			'general_idnewtab_popup' => $this->input->post('general_idnewtab_popup'),
			'general_url' => $this->input->post('general_url'),
			'general_type' => $this->input->post('general_type'),
			'general_bottombreak' => ($this->input->post('general_bottombreak')==('on'||1) ? 1 : 0),
			'general_status' => $this->input->post('general_status'),
			'process_view' => ($this->input->post('process_view')==('on'||1) ? 1 : 0),
			'process_tambah' => ($this->input->post('process_tambah')==('on'||1) ? 1 : 0),
			'process_ubah' => ($this->input->post('process_ubah')==('on'||1) ? 1 : 0),
			'process_hapus' => ($this->input->post('process_hapus')==('on'||1) ? 1 : 0),
			'process_proses' => ($this->input->post('process_proses')==('on'||1) ? 1 : 0),
			'process_cetak' => ($this->input->post('process_cetak')==('on'||1) ? 1 : 0),
			'process_cetaksk' => ($this->input->post('process_cetaksk')==('on'||1) ? 1 : 0),
		);
		if(is_numeric($idmenu) && $idmenu!=0){
			$this->db->where('idmenu', $idmenu);
			$this->db->update('tuser_semar_menu',$data);
		}else{
			$this->db->insert('tuser_semar_menu',$data);
		}
		return TRUE;	
	}
	//end menu
	
	//group
	function get_AllData_Group(){
		$id_groupcollections = $this->input->post('id_groupcollections');
		$data = array();
		$this->db->select('*');
		$this->db->from('tuser_semar_menu_group_menu');
		$this->db->join('tuser_semar_menu_group_collections', 'tuser_semar_menu_group_menu.ID_Group_Menu_ID_Group = tuser_semar_menu_group_collections.id_groupcollections', 'left');
		$this->db->join('tuser_semar_menu', 'tuser_semar_menu_group_menu.ID_Group_Menu_ID_Menu = tuser_semar_menu.idmenu', 'left');
		if($id_groupcollections!=0 && $id_groupcollections!=null && is_numeric($id_groupcollections)){
			$this->db->where('ID_Group_Menu_ID_Group', $id_groupcollections);
		}
		$this->db->order_by('ID_Group_Menu');
		$Q = $this->db->get();
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$temp_row = $row;
				if($row['parent_idmenu']!=0){
					$t_row_parent = $this->get_AllData_Menu('idmenu', array('key'=>'idmenu', 'val'=>$row['parent_idmenu']));
					if(count($t_row_parent) > 0){
						$temp_row['parent_text'] = $t_row_parent[0]['general_text'];
					}
				}
				$data[] = $temp_row;
			}
		}
		return $data;
	}
	
	function Sync_Data_Group($timpah=0){
		if($timpah!=0){
			$this->db->query('delete from tuser_semar_menu_group_menu');
		}
		
		$status = true;
		$MenuCollections = $this->get_AllData_Menu('parent_idmenu');
		$GroupCollections  = $this->get_AllData_GroupCollections();
		foreach($GroupCollections as $key => $value){
			$id_groupcollections = $value['id_groupcollections'];
			foreach($MenuCollections as $key2 => $value2){
				$data = array(
					'u_access' => $value2['process_view'],
					'u_insert' => $value2['process_tambah'],
					'u_update' => $value2['process_ubah'],
					'u_delete' => $value2['process_hapus'],
					'u_proses' => $value2['process_proses'],
					'u_print' => $value2['process_cetak'],
					'u_print_sk' => $value2['process_cetaksk'],
					'ID_Group_Menu_ID_Menu' => $value2['idmenu'],
					'ID_Group_Menu_ID_Group' => $id_groupcollections
				);
				
				$options = array('ID_Group_Menu_ID_Menu' => $value2['idmenu'], 'ID_Group_Menu_ID_Group' => $id_groupcollections);
				$Q = $this->db->get_where('tuser_semar_menu_group_menu', $options,1);
				if($Q->num_rows() > 0){
					if($timpah==1){
						foreach ($Q->result_array() as $row){
							$this->db->delete('tuser_semar_menu_group_menu', array('ID_Group_Menu'=>$row['ID_Group_Menu']));
						}
						$this->db->insert('tuser_semar_menu_group_menu',$data);
					}
				}else{
					$this->db->insert('tuser_semar_menu_group_menu',$data);
				}
			}
		}
		return $status;
	}
	
	function Insert_Data_Group(){
		$ID_Group_Menu = $this->input->post('ID_Group_Menu');
		$data = array(
			'u_access' => ($this->input->post('u_access')==('on'||1) ? 1 : 0),
			'u_insert' => ($this->input->post('u_insert')==('on'||1) ? 1 : 0),
			'u_update' => ($this->input->post('u_update')==('on'||1) ? 1 : 0),
			'u_delete' => ($this->input->post('u_delete')==('on'||1) ? 1 : 0),
			'u_proses' => ($this->input->post('u_proses')==('on'||1) ? 1 : 0),
			'u_print' => ($this->input->post('u_print')==('on'||1) ? 1 : 0),
			'u_print_sk' => ($this->input->post('u_print_sk')==('on'||1) ? 1 : 0),
			'ID_Group_Menu_ID_Menu' => $this->input->post('ID_Group_Menu_ID_Menu'),
			'ID_Group_Menu_ID_Group' => $this->input->post('ID_Group_Menu_ID_Group')
		);
		$options = array('ID_Group_Menu_ID_Menu' => $this->input->post('ID_Group_Menu_ID_Menu'), 'ID_Group_Menu_ID_Group' => $this->input->post('ID_Group_Menu_ID_Group'));
		$Q = $this->db->get_where('tuser_semar_menu_group_menu', $options,1);
		
		if(is_numeric($ID_Group_Menu) && $ID_Group_Menu!=0){
			$this->db->where('ID_Group_Menu', $ID_Group_Menu);
			$this->db->update('tuser_semar_menu_group_menu',$data);
			return TRUE;
		}else{
			if($Q->num_rows() > 0){
				return FALSE;
			}else{
				$this->db->insert('tuser_semar_menu_group_menu',$data);
				return TRUE;
			}
		}	
	}
	//end menu
	
	//group
	function get_AllData_GroupCollections(){
		$data = array();
		$this->db->select('*');
		$this->db->from('tuser_semar_menu_group_collections');
		$this->db->order_by('id_groupcollections');
		$Q = $this->db->get();
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}
	
	function Insert_Data_GroupCollections(){
		$id_groupcollections = $this->input->post('id_groupcollections');
		$data = array(
			'general_group_name' => $this->input->post('general_group_name'),
			'general_group_active' => ($this->input->post('general_group_active')==('on'||1) ? 1 : 0),
		);
		if(is_numeric($id_groupcollections) && $id_groupcollections!=0){
			$this->db->where('id_groupcollections', $id_groupcollections);
			$this->db->update('tuser_semar_menu_group_collections',$data);
		}else{
			$this->db->insert('tuser_semar_menu_group_collections',$data);
		}
		return TRUE;	
	}
	//end menu
	
	//wizard
	function getAllTableFromDatabase(){
		$data = array();
		$tables = $this->db->list_tables();
		foreach ($tables as $table)
		{
		   $data[] = array('tablename' => $table);
		}
		return $data;
	}
	function getAllFieldsFromTable(){
		$data1 = array();
		$data2 = array();
		$data3 = array();
		$tablename = $this->input->post('tablename');
		if($tablename!=null){
			$fields = $this->db->list_fields($tablename);
			foreach ($fields as $field)
			{
			   $data1[$field] = false;
			   $data2[$field] = $field;
			   $data3[$field] = 0;
			}
		}
		$data = array('boolean'=>$data1,'string'=>$data2,'int'=>$data3);
		return $data;
	}
	//end wizard

}
?>