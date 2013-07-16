<?php
class Last_IDP_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function PDDK($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Pddk = '';
  		$Q = $this->db->query("SELECT f_idp_pddk('".$NIP."') AS IDP_Pddk");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Pddk = $data['IDP_Pddk'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Pddk;			
		}
	}

	function KPKT($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Kpkt = '';
  		$Q = $this->db->query("SELECT f_idp_kpkt('".$NIP."') AS IDP_Kpkt");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Kpkt = $data['IDP_Kpkt'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Kpkt;			
		}
	}

	function JAB($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Jab = '';
  		$Q = $this->db->query("SELECT f_idp_jab('".$NIP."') AS IDP_Jab");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Jab = $data['IDP_Jab'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Jab;			
		}
	}

	function DIKLAT($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Diklat = '';
  		$Q = $this->db->query("SELECT f_idp_diklat('".$NIP."') AS IDP_Diklat");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Diklat = $data['IDP_Diklat'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Diklat;			
		}
	}

	function PRAJAB($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Diklat = '';
  		$Q = $this->db->query("SELECT f_idp_dik_prajab('".$NIP."') AS IDP_Diklat");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Diklat = $data['IDP_Diklat'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Diklat;			
		}
	}

	function DIK_PIM($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Diklat = '';
  		$Q = $this->db->query("SELECT f_idp_dik_pim('".$NIP."') AS IDP_Diklat");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Diklat = $data['IDP_Diklat'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Diklat;			
		}
	}

	function DP3($NIP=''){
		if($NIP){
  		$data = array(); $IDP_DP3 = '';
  		$Q = $this->db->query("SELECT f_idp_dp3('".$NIP."') AS IDP_DP3");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_DP3 = $data['IDP_DP3'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_DP3;			
		}
	}

	function KGB($NIP=''){
		if($NIP){
  		$data = array(); $IDP_KGB = '';
  		$Q = $this->db->query("SELECT f_idp_kgb('".$NIP."') AS IDP_KGB");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_KGB = $data['IDP_KGB'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_KGB;			
		}
	}

	function AK($NIP=''){
		if($NIP){
  		$data = array(); $IDP_AK = '';
  		$Q = $this->db->query("SELECT f_idp_ak('".$NIP."') AS IDP_AK");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_AK = $data['IDP_AK'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_AK;			
		}
	}

	function REWARD($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Reward = '';
  		$Q = $this->db->query("SELECT f_idp_reward('".$NIP."') AS IDP_Reward");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Reward = $data['IDP_Reward'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Reward;			
		}
	}

	function HUKDIS($NIP=''){
		if($NIP){
  		$data = array(); $IDP_HukDis = '';
  		$Q = $this->db->query("SELECT f_idp_hukdis('".$NIP."') AS IDP_HukDis");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_HukDis = $data['IDP_HukDis'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_HukDis;			
		}
	}

	function SEMINAR($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Seminar = '';
  		$Q = $this->db->query("SELECT f_idp_seminar('".$NIP."') AS IDP_Seminar");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Seminar = $data['IDP_Seminar'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Seminar;			
		}
	}

	function KARYA_TULIS($NIP=''){
		if($NIP){
  		$data = array(); $IDP_KT = '';
  		$Q = $this->db->query("SELECT f_idp_kt('".$NIP."') AS IDP_KT");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_KT = $data['IDP_KT'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_KT;			
		}
	}

	function ORG($NIP=''){
		if($NIP){
  		$data = array(); $IDP_Org = '';
  		$Q = $this->db->query("SELECT f_idp_org('".$NIP."') AS IDP_Org");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_Org = $data['IDP_Org'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_Org;			
		}
	}

	function PK($NIP=''){
		if($NIP){
  		$data = array(); $IDP_PK = '';
  		$Q = $this->db->query("SELECT f_idp_pk('".$NIP."') AS IDP_PK");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$IDP_PK = $data['IDP_PK'];
    	}
    	$Q->free_result();
    	$this->db->close();
    	return $IDP_PK;			
		}
	}
}
?>