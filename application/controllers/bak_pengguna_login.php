<?php
class Pengguna_Login extends CI_Controller{
  function __construct(){
  	parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    }  	
  	$this->load->model('Pengguna_Login_Model','',TRUE);
  	$this->load->model('Functions_Model','',TRUE);
  }
	
  function index(){  	
		$sesi_type = $this->session->userdata("type_zs_simpeg");
  	if($this->input->post("id_open") && ($sesi_type == 'SUPER ADMIN' || $sesi_type == 'ADMIN')){
  		$data['jsscript'] = TRUE;
			$this->load->view('pengguna_login_view',$data);
		}else{
			$this->load->view('pengguna_login_view');
		}
  }
	
	function ext_get_all(){
		if($this->input->post("id_open")){
			$data = $this->Pengguna_Login_Model->get_AllData();	   	
			$total = $this->Pengguna_Login_Model->get_CountAllData();	   	
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
  	}
	}  
	
  function ext_insert(){  	
		$sesi_type = $this->session->userdata("type_zs_simpeg");
		if(($this->input->post('type') == 'SUPER ADMIN' || $this->input->post('type') == 'ADMIN') && $sesi_type == 'ADMIN'){
			echo "{success:false, errors: { reason: 'Akses Ditolak  !' }}";		
		}elseif($sesi_type == 'SUPER ADMIN' || $sesi_type == 'ADMIN'){
			$Status = $this->Pengguna_Login_Model->Insert_Data();	 
			if($Status == TRUE){
				echo "{success:true}";
			}elseif($Status == FALSE){
				echo "{success:false, errors: { reason: 'Nama Pengguna sudah terdaftar !' }}";
			}else{
				echo "{success:false, errors: { reason: 'Gagal Menambah Data !' }}";
			}
    }else{
    	echo "{success:false, errors: { reason: 'Akses Ditolak  !' }}";
    }
  }

  function ext_update(){
  	$sesi_iduser = $this->session->userdata("iduser_zs_simpeg");
  	$sesi_type = $this->session->userdata("type_zs_simpeg");
		if($this->input->post('ID_User') == 1 && $sesi_iduser != 1){
			echo "{success:false, errors: { reason: 'Akses Ditolak  !' }}";		
		}elseif($this->input->post('ID_User') && ($this->input->post('type') == 'SUPER ADMIN') && ($sesi_type == 'ADMIN')){
			echo "{success:false, errors: { reason: 'Akses Ditolak  !' }}";		
		}elseif($this->input->post('ID_User') && ($sesi_type == 'SUPER ADMIN' || $sesi_type == 'ADMIN')){
			$Status = $this->Pengguna_Login_Model->Update_Data();	 
			if($Status == TRUE){
				echo "{success:true}";
			}else{
				echo "{success:false, errors: { reason: 'Gagal Merubah Data !' }}";
			}
		}else{
			echo "{success:false, errors: { reason: 'Akses Ditolak  !' }}";			
		}
  }

  function ext_delete(){
		// Control Penghapusan ada pada Pengguna_Login_Model
		$Status = $this->Pengguna_Login_Model->Delete_Data();	
		if($Status == TRUE){
			echo "{success:true}";
		}else{
			echo "{success:false}";
		}
  }
  
  function ext_changepass(){
  	$sesi_iduser = $this->session->userdata("iduser_zs_simpeg");
  	$sesi_type = $this->session->userdata("type_zs_simpeg");
  	$type_updated = $this->Pengguna_Login_Model->get_Type_User($this->input->post('ID_User'));
		if($this->input->post('ID_User') == 1 && $sesi_iduser != 1){
			echo "{success:false, errors: { reason: 'Akses Ditolak  !' }}";		
		}elseif(($type_updated == "SUPER ADMIN" && $sesi_type == "ADMIN") || ($type_updated == "ADMIN" && $sesi_type == "ADMIN" && $sesi_iduser != $this->input->post('ID_User'))){
			echo "{success:false, errors: { reason: 'Akses Ditolak  !' }}";		
		}elseif($this->input->post('ID_User')){
			$data = array('pass' => MD5($this->input->post('pass')));
  		$this->db->where('ID_User',$this->input->post('ID_User'));
    	$this->db->update('tUser',$data); 
    	$this->db->close();			
			echo "{success:true}";
		}else{
			echo "{success:false, errors: { reason: 'Gagal Merubah Kata Sandi !' }}";
		}
  }

	// START - CETAK PENGGUNA LOGIN 
  function print_dialog_dnp(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_User';
			$data['Grid_ID'] = 'gridUsers';
			$data['Params_Print'] = 'Params_User';
			$data['uri_all'] = 'pengguna_login/cetak_nom/all';
			$data['uri_selected'] = 'pengguna_login/cetak_nom/selected';
			$data['uri_by_rows'] = 'pengguna_login/cetak_nom/by_rows/';
			$this->load->view('print_dialog/print_dialog_no_ttd_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_no_ttd_view');
		}
  }
	
	function cetak_nom($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data['data_cetak'] = $this->Pengguna_Login_Model->get_AllPrint();
			}elseif($p_mode == "selected"){
				$data['data_cetak'] = $this->Pengguna_Login_Model->get_SelectedPrint();
			}elseif($p_mode == "by_rows"){
				$data['data_cetak'] = $this->Pengguna_Login_Model->get_ByRowsPrint($dari, $sampai);
			}
			$this->load->view('pengguna_login_pdf',$data);
		}
	}
	// END - CETAK PENGGUNA LOGIN 
	
	function ubahsandi(){
  	if($this->input->post("id_open") && $this->session->userdata("iduser_zs_simpeg")){
  		$data['jsscript'] = TRUE;
  		$data['sesi'] = $this->session->userdata("iduser_zs_simpeg");
			$this->load->view('pengguna_login_ubahsandi',$data);
		}else{
			$this->load->view('pengguna_login_ubahsandi');
		}		
	}
	
	function petunjuk(){		
		$this->load->view('petunjuk/pengguna_login_petunjuk');
	}
	
	// AKSES MENU POPUP --------------------------------------------- START
	function akses_menu_popup(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('akses_menu_popup',$data);
		}else{
			$this->load->view('akses_menu_popup');
		}
	}

	function change_bool($val=0){
		if($val==1){return 'true';
		}elseif($val==0){return 'false';
		}else{return $val;}
	}
	
	function ext_get_all_akses_menu(){
		if($this->input->get_post("id_open")){			
			$p_data = $this->Pengguna_Login_Model->get_AllData_Parent_Menu();			
			if(count($p_data)){
				$Json = "";
				$Json .= "
				{\"text\":\".\",\"children\": [
				";
				$i = count($p_data);
				foreach ($p_data as $p_key => $p_list){
					$u_access = $this->change_bool($p_list['u_access']);
					$u_insert = $this->change_bool($p_list['u_insert']);
					$u_update = $this->change_bool($p_list['u_update']);
					$u_delete = $this->change_bool($p_list['u_delete']);
					$u_proses = $this->change_bool($p_list['u_proses']);
					$u_print = $this->change_bool($p_list['u_print']);
					$u_print_sk = $this->change_bool($p_list['u_print_sk']);
					
					$Json .= "
					 {menu: '".$p_list['menu']."',
        		u_access: ".$u_access.",
          	u_insert: ".$u_insert.",
          	u_update: ".$u_update.",
          	u_delete: ".$u_delete.",
          	u_proses: ".$u_proses.",
          	u_print: ".$u_print.",
          	u_print_sk: ".$u_print_sk.",
          	ID_Menu: ".$p_list['ID_Menu'].",
          	iconCls:  'task-folder',
          	expanded: '".$p_list['expanded']."'
					";
					
					// START MENU LEVEL 2 -------------------------------------------------- START
					$parent_0 = $p_list['ID_Menu'];
					$child_1 = $this->Pengguna_Login_Model->get_AllData_Child_Menu($parent_0);
					if(count($child_1)){
						$c1 = count($child_1);
						$Json .= ",children:[";						
						foreach ($child_1 as $c1_key => $c1_list){					
							$u_access = $this->change_bool($c1_list['u_access']);
							$u_insert = $this->change_bool($c1_list['u_insert']);
							$u_update = $this->change_bool($c1_list['u_update']);
							$u_delete = $this->change_bool($c1_list['u_delete']);
							$u_proses = $this->change_bool($c1_list['u_proses']);
							$u_print = $this->change_bool($c1_list['u_print']);
							$u_print_sk = $this->change_bool($c1_list['u_print_sk']);

							$Json .= "
					 		{menu: '".$c1_list['menu']."',
        				u_access: ".$u_access.",
          			u_insert: ".$u_insert.",
          			u_update: ".$u_update.",
          			u_delete: ".$u_delete.",
          			u_proses: ".$u_proses.",
          			u_print: ".$u_print.",
          			u_print_sk: ".$u_print_sk.",
          			ID_Menu: ".$c1_list['ID_Menu'].",
          			iconCls:  'task-folder',
          			leaf: ".$c1_list['leaf']."							
							";
							
							// START MENU LEVEL 3 -------------------------------------------------- START
							$parent_1 = $c1_list['ID_Menu'];
							$child_2 = $this->Pengguna_Login_Model->get_AllData_Child_Menu($parent_1);
							if(count($child_2)){
								$c2 = count($child_2);
								$Json .= ",children:[";
								foreach ($child_2 as $c2_key => $c2_list){
									$u_access = $this->change_bool($c2_list['u_access']);
									$u_insert = $this->change_bool($c2_list['u_insert']);
									$u_update = $this->change_bool($c2_list['u_update']);
									$u_delete = $this->change_bool($c2_list['u_delete']);
									$u_proses = $this->change_bool($c2_list['u_proses']);
									$u_print = $this->change_bool($c2_list['u_print']);
									$u_print_sk = $this->change_bool($c2_list['u_print_sk']);
									
									$Json .= "
					 				{menu: '".$c2_list['menu']."',
        					 u_access: ".$u_access.",
          				 u_insert: ".$u_insert.",
          				 u_update: ".$u_update.",
          				 u_delete: ".$u_delete.",
          				 u_proses: ".$u_proses.",
          				 u_print: ".$u_print.",
          				 u_print_sk: ".$u_print_sk.",
          				 ID_Menu: ".$c2_list['ID_Menu'].",
          				 iconCls:  'task-folder',
          				 leaf: ".$c2_list['leaf']."							
									";									
									$c2--;
									if($c2 == 0){
										$Json .= "}";
									}else{
										$Json .= "},";
									}
								}
								if($c2 == 0){
									$Json .= "]";
								}else{
									$Json . "],";
								}
							}
							// START MENU LEVEL 3 -------------------------------------------------- END
							
							$c1--;
							if($c1 == 0){
								$Json .= "}";
							}else{
								$Json .= "},";
							}
						}
						if($c1 == 0){
							$Json .= "]";
						}else{
							$Json . "],";
						}
					}
					// START MENU LEVEL 2 -------------------------------------------------- END
					
					$i--;
					if($i == 0){
						$Json .= "}";
					}else{
						$Json .= "},";
					}
				}
				$Json .= "
				]}
				";
				
				echo $Json;
			}
  	}
	}
	
  function ext_change_akses_menu(){
  	$sesi_iduser = $this->session->userdata("iduser_zs_simpeg");
  	$sesi_type = $this->session->userdata("type_zs_simpeg");
  	$type_updated = $this->Pengguna_Login_Model->get_Type_User($this->input->post('ID_User'));
		if($this->input->post('ID_User') == 1 && $sesi_iduser != 1){
			echo "{success:false, errors: { reason: 'Akses Ditolak !' }}";		
		}elseif(($type_updated == "SUPER ADMIN" && $sesi_type == "ADMIN") || ($type_updated == "ADMIN" && $sesi_type == "ADMIN" && $sesi_iduser != $this->input->post('ID_User'))){
			echo "{success:false, errors: { reason: 'Akses Ditolak  !' }}";		
		}elseif($this->input->post('ID_User')){
			if($this->input->post('u_access') == 'true'){
				$u_access = 1;
			}elseif($this->input->post('u_access') == 'false'){
				$u_access = 0;
			}else{
				$u_access = $this->input->post('u_access');
			}

			if($this->input->post('u_insert') == 'true'){
				$u_insert = 1;
			}elseif($this->input->post('u_insert') == 'false'){
				$u_insert = 0;
			}else{
				$u_insert = $this->input->post('u_insert');
			}
			
			if($this->input->post('u_update') == 'true'){
				$u_update = 1;
			}elseif($this->input->post('u_update') == 'false'){
				$u_update = 0;
			}else{
				$u_update = $this->input->post('u_update');
			}
			
			if($this->input->post('u_delete') == 'true'){
				$u_delete = 1;
			}elseif($this->input->post('u_delete') == 'false'){
				$u_delete = 0;
			}else{
				$u_delete = $this->input->post('u_delete');
			}

			if($this->input->post('u_proses') == 'true'){
				$u_proses = 1;
			}elseif($this->input->post('u_proses') == 'false'){
				$u_proses = 0;
			}else{
				$u_proses = $this->input->post('u_proses');
			}

			if($this->input->post('u_print') == 'true'){
				$u_print = 1;
			}elseif($this->input->post('u_print') == 'false'){
				$u_print = 0;
			}else{
				$u_print = $this->input->post('u_print');
			}

			if($this->input->post('u_print_sk') == 'true'){
				$u_print_sk = 1;
			}elseif($this->input->post('u_print_sk') == 'false'){
				$u_print_sk = 0;
			}else{
				$u_print_sk = $this->input->post('u_print_sk');
			}
			
			$data = array(
				'ID_User' => $this->input->post('ID_User'),
				'ID_Menu' => $this->input->post('ID_Menu'),
				'u_access' => $u_access,
				'u_insert' => $u_insert,
				'u_update' => $u_update,
				'u_delete' => $u_delete,
				'u_proses' => $u_proses,
				'u_print' => $u_print,
				'u_print_sk' => $u_print_sk
			);

  		$options = array('ID_User' => $this->input->post('ID_User'), 'ID_Menu' => $this->input->post('ID_Menu'));
  		$Q = $this->db->get_where('tUser_Menu', $options,1);
  		if($Q->num_rows() > 0){
  			$this->db->update('tUser_Menu', $data, $options);
  			$s_return = "{success:true}";
    	}
		}else{
			$s_return = "{success:false}";
		}
		echo $s_return;
  }
	
	// AKSES MENU --------------------------------------------- END

}
?>