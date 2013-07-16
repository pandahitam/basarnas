<?php
class Upload_Arsip_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	// START - PENDIDIKAN
	function Get_Arsip($jns_arsip=null){
		$pathfiles = "";
		$Options = array(
			'NIP' => $this->input->post('NIP'),
			'kode_arsip' => $this->input->post('kode_arsip')
		);
		switch ($jns_arsip){
			case 'biodata':
				$tbl_name = "tArsip_Biodata";
				$WHERE = $Options;
				break;
			case 'pendidikan':
				$tbl_name = "tArsip_Pendidikan";
				$WHERE = array_merge($Options, array('IDP_Pddk' => $this->input->post('ID_Field')));
				break;
			case 'kepangkatan':
				$tbl_name = "tArsip_Kepangkatan";
				$WHERE = array_merge($Options, array('IDP_Kpkt' => $this->input->post('ID_Field')));
				break;
			case 'jabatan':
				$tbl_name = "tArsip_Jabatan";
				$WHERE = array_merge($Options, array('IDP_Jab' => $this->input->post('ID_Field')));
				break;
			case 'pendidikan_nf':
				$tbl_name = "tArsip_Pendidikan_NF";
				$WHERE = array_merge($Options, array('IDP_Pddk_NF' => $this->input->post('ID_Field')));
				break;
			case 'reward':
				$tbl_name = "tArsip_Reward";
				$WHERE = array_merge($Options, array('IDP_Reward' => $this->input->post('ID_Field')));
				break;
			default:
		}
		if($tbl_name){
			$Q = $this->db->get_where($tbl_name, $WHERE, 1);
			if($Q->num_rows() > 0){
				$data = $Q->row_array(); $pathfiles = $data['pathfiles'];
			}
			$Q->free_result();
			return $pathfiles;
		}
	}
	
	function Insert_Arsip($jns_arsip=null, $p_filename=null){
		if($jns_arsip && $p_filename){
			$data_s_insert = array('createdBy' => $this->session->userdata("user_zs_simpeg"), 'createdDate' => date("Y-m-d H:i:s"));
			$data_s_update = array('updatedBy' => $this->session->userdata("user_zs_simpeg"), 'updatedDate' => date("Y-m-d H:i:s"));
			$Options = array(
				'NIP' => $this->input->post('NIP'),
				'kode_arsip' => $this->input->post('kode_arsip')
			);
			$data_temp = array(
				'NIP' => $this->input->post('NIP'),
				'kode_arsip' => $this->input->post('kode_arsip'),
				'pathfiles' => $p_filename
			);

			switch ($jns_arsip){
				case 'biodata':
					$tbl_name = "tArsip_Biodata";
					$WHERE = $Options;
					$data = $data_temp;
					break;
				case 'pendidikan':
					$tbl_name = "tArsip_Pendidikan";
					$WHERE = array_merge($Options, array('IDP_Pddk' => $this->input->post('IDP_Pddk')));
					$data = array_merge($data_temp, array('IDP_Pddk' => $this->input->post('IDP_Pddk')));
					break;
				case 'kepangkatan':
					$tbl_name = "tArsip_Kepangkatan";
					$WHERE = array_merge($Options, array('IDP_Kpkt' => $this->input->post('IDP_Kpkt')));
					$data = array_merge($data_temp, array('IDP_Kpkt' => $this->input->post('IDP_Kpkt')));
					break;
				case 'jabatan':
					$tbl_name = "tArsip_Jabatan";
					$WHERE = array_merge($Options, array('IDP_Jab' => $this->input->post('IDP_Jab')));
					$data = array_merge($data_temp, array('IDP_Jab' => $this->input->post('IDP_Jab')));
					break;
				case 'pendidikan_nf':
					$tbl_name = "tArsip_Pendidikan_NF";
					$WHERE = array_merge($Options, array('IDP_Pddk_NF' => $this->input->post('IDP_Pddk_NF')));
					$data = array_merge($data_temp, array('IDP_Pddk_NF' => $this->input->post('IDP_Pddk_NF')));
					break;
				case 'reward':
					$tbl_name = "tArsip_Reward";
					$WHERE = array_merge($Options, array('IDP_Reward' => $this->input->post('IDP_Reward')));
					$data = array_merge($data_temp, array('IDP_Reward' => $this->input->post('IDP_Reward')));
					break;
				default:
			}

			if($tbl_name){			
				$this->db->trans_start();
				$Q = $this->db->get_where($tbl_name, $WHERE, 1);
				if($Q->num_rows() > 0){
					$data_ok = array_merge($data, $data_s_update);
					$this->db->update($tbl_name, $data_ok, $WHERE);
				}else{
					$data_ok = array_merge($data, $data_s_insert);
					$this->db->insert($tbl_name, $data_ok);
				}
				$this->db->trans_complete();
			}
		}
	}

	function Delete_Arsip($jns_arsip=null){
		$Options = array(
			'NIP' => $this->input->post('NIP'),
			'kode_arsip' => $this->input->post('kode_arsip')
		);
		switch ($jns_arsip){
			case 'biodata':
				$tbl_name = "tArsip_Biodata";
				$WHERE = $Options;
				break;
			case 'pendidikan':
				$tbl_name = "tArsip_Pendidikan";
				$WHERE = array_merge($Options, array('IDP_Pddk' => $this->input->post('ID_Field')));
				break;
			case 'kepangkatan':
				$tbl_name = "tArsip_Kepangkatan";
				$WHERE = array_merge($Options, array('IDP_Kpkt' => $this->input->post('ID_Field')));
				break;
			case 'jabatan':
				$tbl_name = "tArsip_Jabatan";
				$WHERE = array_merge($Options, array('IDP_Jab' => $this->input->post('ID_Field')));
				break;
			case 'pendidikan_nf':
				$tbl_name = "tArsip_Pendidikan_NF";
				$WHERE = array_merge($Options, array('IDP_Pddk_NF' => $this->input->post('ID_Field')));
				break;
			case 'reward':
				$tbl_name = "tArsip_Reward";
				$WHERE = array_merge($Options, array('IDP_Reward' => $this->input->post('ID_Field')));
				break;
			default:
		}
		if($tbl_name){
			$this->db->delete($tbl_name, $WHERE);
		}
	}

	function Get_Cetak_Arsip($jns_arsip=null){
		$pathfiles = "";
		$Options = array(
			'NIP' => $this->input->post('NIP'),
			'kode_arsip' => $this->input->post('kode_arsip')
		);
		switch ($jns_arsip){
			case 'biodata':
				$tbl_name = "tArsip_Biodata";
				$WHERE = $Options;
				break;
			case 'pendidikan':
				$tbl_name = "tArsip_Pendidikan";
				$WHERE = array_merge($Options, array('IDP_Pddk' => $this->input->post('ID_Field')));
				break;
			case 'kepangkatan':
				$tbl_name = "tArsip_Kepangkatan";
				$WHERE = array_merge($Options, array('IDP_Kpkt' => $this->input->post('ID_Field')));
				break;
			case 'jabatan':
				$tbl_name = "tArsip_Jabatan";
				$WHERE = array_merge($Options, array('IDP_Jab' => $this->input->post('ID_Field')));
				break;
			case 'pendidikan_nf':
				$tbl_name = "tArsip_Pendidikan_NF";
				$WHERE = array_merge($Options, array('IDP_Pddk_NF' => $this->input->post('ID_Field')));
				break;
			case 'reward':
				$tbl_name = "tArsip_Reward";
				$WHERE = array_merge($Options, array('IDP_Reward' => $this->input->post('ID_Field')));
				break;
			default:
		}
		if($tbl_name){
			$Q = $this->db->get_where($tbl_name, $WHERE, 1);
			if($Q->num_rows() > 0){
				$data = $Q->row_array(); $pathfiles = $data['pathfiles'];
			}
			$Q->free_result();
			return $pathfiles;
		}
	}
	
	// END - PENDIDIKAN
	


}
?>