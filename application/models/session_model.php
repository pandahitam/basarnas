<?php
class Session_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function Clear_Session_Ref(){
		$this->session->unset_userdata("sjenis_jab");
		$this->session->unset_userdata("sNIP");
		$this->session->unset_userdata("sPgwPilih");
		$this->session->unset_userdata("sDupeg");
		$this->session->unset_userdata("skode_unor");
	}

	function Clear_Session_Login(){
  	$this->session->unset_userdata("iduser_zs_simpeg");
  	$this->session->unset_userdata("user_zs_simpeg");
  	$this->session->unset_userdata("fullname_zs_simpeg");
  	$this->session->unset_userdata("type_zs_simpeg");
  	$this->session->unset_userdata("nip_zs_simpeg");
  	$this->session->unset_userdata("kode_unker_zs_simpeg");
  	$this->session->unset_userdata("a_kode_unker_zs_simpeg");
	}
	
	function Write_Log_User($desc=''){
		$data = array(
			'logIP' => $_SERVER['REMOTE_ADDR'],
			'logDateTime' => date('Y-m-d H:i:s'),
			'logUser' => $this->session->userdata("user_zs_simpeg"),
			'Description' => $desc
		);
		$this->db->insert('tLog', $data);
	}
}
?>
