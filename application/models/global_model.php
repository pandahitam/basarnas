<?php
class Global_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function Get_Kepala_UnKer($kode_unker=''){
		if($kode_unker){
  		$data = array(); $NIP = '';
  		$Q = $this->db->query("SELECT f_nip_kepala_unker('".$kode_unker."') AS NIP");
  		if($Q->num_rows() > 0){
  			$data = $Q->row_array();
  			$NIP = $data['NIP'];
    	}
    	$Q->free_result();
    	$this->db->close();    	
    	return $this->Get_Biodata($NIP);
		}
	}

	function Get_Biodata($NIP=0){
  	$data = array();
  	$options = array('NIP' => $NIP);
  	$Q = $this->db->get_where('tView_Pegawai_Biodata', $options, 1);
  	if($Q->num_rows() > 0){
  		$data = $Q->row_array();
    }
    $Q->free_result();
    $this->db->close();
    return $data;
	}

	function get_kode_unker_child($kode_unker=null){
		if($kode_unker){
			$data = array(); $a_kode_unker = array();
			// Level 1
			$this->db->select('kode_unker');
		  $this->db->from("tRef_UnitKerja");
		  $this->db->where('kode_uki', $kode_unker);
		  $Q1 = $this->db->get('');
		  if($Q1->num_rows() > 0){
	  		foreach ($Q1->result_array() as $row1){
	  			$a_kode_unker[] = $row1['kode_unker'];

					// Level 2
					$this->db->select('kode_unker');
			  	$this->db->from("tRef_UnitKerja");
			  	$this->db->where('kode_uki', $row1['kode_unker']);
			  	$Q2 = $this->db->get('');
			  	if($Q2->num_rows() > 0){
			  		foreach ($Q2->result_array() as $row2){
			  			$a_kode_unker[] = $row2['kode_unker'];
				 		}
			  	}
			  	$Q2->free_result();
		  	}
		  }
		  $Q1->free_result();
		    	
		  $a_temp = array_merge(array($kode_unker), $a_kode_unker);
		  return $a_temp;
		}
	}
	
	function Simpan_Barcode($ID_Proses=null, $kode_barcode=null, $barcode=null, $file_path=null){
		if($ID_Proses && $kode_barcode && $barcode && $file_path){
			$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
			$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
			
			$data = array();
			$data_barcode = array(
				'ID_Proses' => $ID_Proses,
				'kode_barcode' => $kode_barcode,
				'barcode' => strtoupper($barcode),
				'file_path' => $file_path
			);

			$Q = $this->db->get_where('tTrans_Barcode', array('ID_Proses' => $ID_Proses, 'kode_barcode' => $kode_barcode), 1);
			if($Q->num_rows() > 0){
				$data = $Q->row_array();
				$ID_Barcode = $data['ID_Barcode'];
				$this->db->update('tTrans_Barcode', array_merge($data_barcode, $data_s_update), array('ID_Barcode' => $ID_Barcode));
			}else{
				$this->db->insert('tTrans_Barcode', array_merge($data_barcode, $data_s_insert));
			}			
		}
	}

}
?>