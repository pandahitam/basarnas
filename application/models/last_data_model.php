<?php
class Last_Data_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function kode_unor($NIP=''){
		if($NIP){
  		$data = array(); $kode_unor = '';
  		$Q = $this->db->query("SELECT kode_unor FROM tPegawai_Jabatan WHERE NIP='".$NIP."' ORDER BY TMT_Jab DESC LIMIT 1");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$kode_unor = $data['kode_unor'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $kode_unor;
		}
	}

	function kode_eselon($NIP=''){
		if($NIP){
  		$data = array(); $kode_eselon = '';
  		$Q = $this->db->query("SELECT kode_eselon FROM tPegawai_Jabatan WHERE NIP='".$NIP."' ORDER BY TMT_Jab DESC LIMIT 1");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$kode_eselon = $data['kode_eselon'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $kode_eselon;
		}
	}
	
	function kode_jab($NIP=''){
		if($NIP){
  		$data = array(); $kode_jab = '';
  		$Q = $this->db->query("SELECT kode_jab FROM tPegawai_Jabatan WHERE NIP='".$NIP."' ORDER BY TMT_Jab DESC LIMIT 1");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$kode_jab = $data['kode_jab'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $kode_jab;
		}
	}
	
	function kode_golru($NIP=''){
		if($NIP){
  		$data = array(); $kode_golru = '';
  		$Q = $this->db->query("SELECT kode_golru FROM tPegawai_Kepangkatan WHERE NIP='".$NIP."' ORDER BY TMT_Kpkt DESC LIMIT 1");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$kode_golru = $data['kode_golru'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $kode_golru;
		}
	}

	function TMT_Kpkt($NIP=''){
		if($NIP){
  		$data = array(); $TMT_Kpkt = '';
  		$Q = $this->db->query("SELECT TMT_Kpkt FROM tPegawai_Kepangkatan WHERE NIP='".$NIP."' ORDER BY TMT_Kpkt DESC LIMIT 1");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$TMT_Kpkt = $data['TMT_Kpkt'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $TMT_Kpkt;
		}
	}
	
}
?>