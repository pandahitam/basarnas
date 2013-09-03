<?php
class Master_Data extends CI_Controller {
	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    }
		$this->load->model('Unit_Kerja_Model','',TRUE);
                $this->load->model('Unit_Organisasi_Model','',TRUE);
                $this->load->model('Klasifikasi_Aset_Lvl1_Model','',TRUE);
                $this->load->model('Klasifikasi_Aset_Lvl2_Model','',TRUE);
                $this->load->model('Klasifikasi_Aset_Lvl3_Model','',TRUE);
                $this->load->model('Warehouse_Model','',TRUE);
                $this->load->model('Ruang_Model','',TRUE);
                $this->load->model('Rak_Model','',TRUE);
//		$this->load->model('Jabatan_Model','',TRUE);
		
//		$this->load->model('TTD_Model','',TRUE);
//		$this->load->model('Prov_Model','',TRUE);
//		$this->load->model('KabKota_Model','',TRUE);
//		$this->load->model('Kec_Model','',TRUE);
//		$this->load->model('Tasset_tanah_Model','',TRUE);		
//		$this->load->model('Tasset_bangunan_Model','',TRUE);
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/master_data_view',$data);
		}else{
			$this->load->view('master/master_data_view');
		}
	}
	
	function combo_jns_unit_kerja(){
		if($this->input->get_post("id_open")){
			$data = array();
    	if ($this->input->get_post('query')){
    		$this->db->like('jns_unker', $this->input->get_post('query'));
    	}
			$this->db->select('*');
			$this->db->from('tRef_Unker_Jns');
			$this->db->order_by('kode_jns_unker','ASC');
    	$Q = $this->db->get('');
    	foreach ($Q->result() as $obj)
    	{
    		$data[] = $obj;
    	}
   		echo json_encode($data);
  	}
	}

	function combo_jns_jabatan(){
		if($this->input->get_post("id_open")){
			$data = array();
    	if ($this->input->get_post('query')){
    		$this->db->like('jenis_jab', $this->input->get_post('query'));
    	}
			$this->db->select('kode_jenis_jab,jenis_jab');
			$this->db->from('tRef_Jabatan_jns');
			$this->db->order_by('kode_jenis_jab','ASC');
    	$Q = $this->db->get('');
    	foreach ($Q->result() as $obj)
    	{
    		$data[] = $obj;
    	}
   		echo json_encode($data);
  	}
	}

	function combo_golru(){
		if($this->input->get_post("id_open")){
			$data = array();
    	if ($this->input->get_post('query')){
    		$this->db->like('nama_pangkat', $this->input->get_post('query'));
    		$this->db->or_like('nama_golru', $this->input->get_post('query'));
    	}
			$this->db->select('*');
			$this->db->from('tRef_Golru');
			$this->db->order_by('kode_golru','ASC');
    	$Q = $this->db->get('');
    	foreach ($Q->result() as $obj)
    	{
    		$data[] = $obj;
    	}
   		echo json_encode($data);
  	}
	}

	function combo_klp_jabatan(){
		if($this->input->get_post("id_open")){
			$data = array();
    	if ($this->input->get_post('query')){
    		$this->db->like('klp_jab', $this->input->get_post('query'));
    	}
			$this->db->select('kode_klp_jab,klp_jab');
			$this->db->from('tRef_Jabatan_Klpk');
			$this->db->order_by('kode_klp_jab','ASC');
    	$Q = $this->db->get('');
    	foreach ($Q->result() as $obj)
    	{
    		$data[] = $obj;
    	}
   		echo json_encode($data);
  	}
	}

	function combo_jabatan(){
		if($this->input->get_post("id_open")){
			$data = array();
    	if ($this->input->get_post('query')){
    		$this->db->like('nama_jab', $this->input->get_post('query'));
    	}
			$this->db->select('ID_Jab,kode_jab,nama_jab');
			$this->db->from('tRef_Jabatan');
			$this->db->order_by('kode_jab','ASC');
    	$Q = $this->db->get('');
    	foreach ($Q->result() as $obj)
    	{
    		$data[] = $obj;
    	}
   		echo json_encode($data);
  	}
	}

	function combo_eselon(){
		if($this->input->get_post("id_open")){
			$data = array();
    	if ($this->input->get_post('query')){
    		$this->db->like('nama_eselon', $this->input->get_post('query'));
    	}
			$this->db->select('kode_eselon,nama_eselon');
			$this->db->from('tRef_Eselon');
			$this->db->order_by('kode_eselon','ASC');
    	$Q = $this->db->get('');
    	foreach ($Q->result() as $obj)
    	{
    		$data[] = $obj;
    	}
   		echo json_encode($data);
  	}
	}
	
	function combo_tkt_hukdis(){
		if($this->input->get_post("id_open")){
			$data = array();
    	if ($this->input->get_post('query')){
    		$this->db->like('tkt_hukdis', $this->input->get_post('query'));
    	}
			$this->db->select('*');
			$this->db->from('tRef_HukDis_Tkt');
			$this->db->order_by('kode_tkt_hukdis','ASC');
    	$Q = $this->db->get('');
    	foreach ($Q->result() as $obj)
    	{
    		$data[] = $obj;
    	}
   		echo json_encode($data);
  	}
	}

	function combo_dupeg(){
		if($this->input->get_post("id_open")){
			$data = array();
    	if ($this->input->get_post('query')){
    		$this->db->like('nama_dupeg', $this->input->get_post('query'));
    	}
			$this->db->select('*');
			$this->db->from('tRef_Dupeg');
			$this->db->order_by('kode_dupeg','ASC');
    	$Q = $this->db->get('');
    	foreach ($Q->result() as $obj)
    	{
    		$data[] = $obj;
    	}
   		echo json_encode($data);
  	}
	}

	function combo_pekerjaan(){
		if($this->input->get_post("id_open")){
			$data = array();
    	if ($this->input->get_post('query')){
    		$this->db->like('nama_pekerjaan', $this->input->get_post('query'));
    	}
			$this->db->select('*');
			$this->db->from('tRef_Pekerjaan');
			$this->db->order_by('kode_pekerjaan','ASC');
    	$Q = $this->db->get('');
    	foreach ($Q->result() as $obj)
    	{
    		$data[] = $obj;
    	}
   		echo json_encode($data);
  	}
	}
	
	// MASTER UNIT KERJA ------------------------------------------- START
	function unit_kerja(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/unit_kerja_view',$data);
		}else{
			$this->load->view('master/unit_kerja_view');
		}
	}

	function ext_get_all_unit_kerja(){
		if($this->input->get_post("id_open")){
			$data = $this->Unit_Kerja_Model->get_AllData();	  			 	
			$total = $this->Unit_Kerja_Model->get_CountData();	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';	
  	}
	}
	
  function ext_insert_unit_kerja(){  	
		$Status = $this->Unit_Kerja_Model->Insert_Data();	 
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Nama Unit Kerja sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }

  function ext_delete_unit_kerja(){
		if($this->Unit_Kerja_Model->Delete_Data() == TRUE){
			echo "{success:true}";
		}else{
			echo "{success:false, errors: { reason: 'Unit Kerja Induk Tidak dapat dihapus !' }}";
		}
  }

	// CETAK UNIT KERJA ---------------------------------------------
  function print_dialog_unker(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_UK';
			$data['Grid_ID'] = 'Grid_UK';
			$data['Params_Print'] = 'Params_M_UK';
			$data['uri_all'] = 'master_data/cetak_unker/all';
			$data['uri_selected'] = 'master_data/cetak_unker/selected';
			$data['uri_by_rows'] = 'master_data/cetak_unker/by_rows/';
			$this->load->view('print_dialog/print_dialog_no_ttd_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_no_ttd_view');
		}
  }
	
	function cetak_unker($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data['data_cetak'] = $this->Unit_Kerja_Model->get_AllPrint();
			}elseif($p_mode == "selected"){
				$data['data_cetak'] = $this->Unit_Kerja_Model->get_SelectedPrint();
			}elseif($p_mode == "by_rows"){
				$data['data_cetak'] = $this->Unit_Kerja_Model->get_ByRowsPrint($dari, $sampai);
			}
			$this->load->view('master/unit_kerja_pdf',$data);
		}
	}
	// MASTER UNIT KERJA ------------------------------------------- START

	// MASTER JABATAN ------------------------------------------- START
	function jabatan(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/jabatan_view',$data);
		}else{
			$this->load->view('master/jabatan_view');
		}
	}
	
	function ext_get_all_jabatan(){
		if($this->input->get_post("id_open")){
			$data = $this->Jabatan_Model->get_AllData();	
			$total = $this->Jabatan_Model->get_CountData();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}  
	
  function ext_insert_jabatan(){  	
		$Status = $this->Jabatan_Model->Insert_Data();	 
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Nama Jabatan sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }

  function ext_delete_jabatan(){
		$this->Jabatan_Model->Delete_Data();	
  }

	// CETAK JABATAN ------------------------------------------------------------
  function print_dialog_jab(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_Jab';
			$data['Grid_ID'] = 'grid_Jabatan';
			$data['Params_Print'] = 'Params_M_Jab';
			$data['uri_all'] = 'master_data/cetak_jab/all';
			$data['uri_selected'] = 'master_data/cetak_jab/selected';
			$data['uri_by_rows'] = 'master_data/cetak_jab/by_rows/';
			$this->load->view('print_dialog/print_dialog_no_ttd_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_no_ttd_view');
		}
  }
	
	function cetak_jab($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data['data_cetak'] = $this->Jabatan_Model->get_AllPrint();
			}elseif($p_mode == "selected"){
				$data['data_cetak'] = $this->Jabatan_Model->get_SelectedPrint();
			}elseif($p_mode == "by_rows"){
				$data['data_cetak'] = $this->Jabatan_Model->get_ByRowsPrint($dari, $sampai);
			}
			$this->load->view('master/jabatan_pdf',$data);
		}
	}	
	// MASTER JABATAN ------------------------------------------- END
	
	// MASTER UNIT ORGANISASI ------------------------------------------- START
	function unit_organisasi(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/unit_organisasi_view',$data);
		}else{
			$this->load->view('master/unit_organisasi_view');
		}
	}
	
	function ext_get_all_unit_organisasi(){
		if($this->input->get_post("id_open")){
			$data = $this->Unit_Organisasi_Model->get_AllData();	
			$total = $this->Unit_Organisasi_Model->get_CountData();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  		}
	}  
	
  function ext_insert_unit_organisasi(){  	
		$Status = $this->Unit_Organisasi_Model->Insert_Data();	 
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Nama Unit Organisasi sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }

  function ext_delete_unit_organisasi(){
		$this->Unit_Organisasi_Model->Delete_Data();	
  }

	function get_next_urut_unor(){
		if($this->input->post("id_open")){	
			$data = array();		
			$this->db->select("urut_unor");
			$this->db->from("tRef_Unor");
			$this->db->order_by("urut_unor", "DESC");
			$this->db->limit(1);
			$Q = $this->db->get();
			if($Q->num_rows() > 0){
				$data = $Q->row_array();
				$next_urut_unor = (int)$data['urut_unor'] + 1;
			}else{
				$next_urut_unor = 1;
			}
			echo $next_urut_unor;
		}
	}
 function print_dialog_tb(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'id';
			$data['Grid_ID'] = 'grid_tb';
			$data['Params_Print'] = 'Params_M_TB';
			$data['uri_all'] = 'master_data/cetak_tb/all';
			$data['uri_selected'] = 'master_data/cetak_tb/selected';
			$data['uri_by_rows'] = 'master_data/cetak_tb/by_rows/';
			$this->load->view('print_dialog/print_dialog_no_ttd_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_no_ttd_view');
		}
  }
  
  function cetak_tb($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			$data = array();
			$dataTanah = array();
			$dataBangunan = array();
			
			if($p_mode == "all" || $p_mode == "by_rows"){
				$dataTanah = $this->Tasset_tanah_Model->get_AllData();	  			 	
				$dataBangunan = $this->Tasset_bangunan_Model->get_AllData();
				
			}
			elseif($p_mode == "selected"){
				$idt = $this->input->post('idTanah');
				$idb = $this->input->post('idBangunan');
				$selectedTanah = explode('-',$idt);
				$selectedBangunan = explode('-',$idb);
				$dataTanah = $this->Tasset_tanah_Model->get_byIDs($selectedTanah);
				$dataBangunan = $this->Tasset_bangunan_Model->get_byIDs($selectedBangunan);
			}
			
			if(count($dataTanah) > 0 )
				{
					foreach($dataTanah as $e){//tanah
						$val = array('alamat'=> $e->alamat,
									'nama'=>' - ',
									'nama_unker'=> $e->nama_unker,
									'jabatan_unor'=>$e->jabatan_unor,
									'nama_prov'=>$e->nama_prov,
									'nama_kabkota'=>$e->nama_kabkota,
									'id'=>$e->id,
									'kode_pos'=>strval($e->kode_pos),
									'luas_tanah'=>strval($e->luas_tanah),
									'luas_bangunan'=>' - ',
									'tipe'=>'TANAH'
									);
						$data[] = $val;		
					}
				}
			if(count($dataBangunan) > 0)
			{
				foreach($dataBangunan as $e){
					$val = array('alamat'=> $e->alamat,
								'nama'=>$e->nama,
								'nama_unker'=> $e->nama_unker,
								'jabatan_unor'=>$e->jabatan_unor,
								'nama_prov'=>$e->nama_prov,
								'nama_kabkota'=>$e->nama_kabkota,
								'id'=>$e->id,
								'kode_pos'=>strval($e->kode_pos),
								'luas_tanah'=>strval($e->luas_tanah),
								'luas_bangunan'=>strval($e->luas_bangunan),
								'tipe'=>'BANGUNAN'
								);
					$data[] = $val;		
				}
			}
			
			if ($p_mode == "by_rows"){
				if (isset($dari) && isset($sampai))
				{
					$offset = $dari - 1;
					$numrows = $sampai - $offset;
					$data = array_slice($data,$offset,$numrows);
				}
			}
				
			$dataSend['data_cetak'] = $data;
			
			
			
			$this->load->view('pengelolaan_asset/tanah_bangunan_pdf',$dataSend);
		}
	}
	
	// CETAK UNIT ORGANISASI ---------------------------------------------
  function print_dialog_unor(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'id';
			$data['Grid_ID'] = 'grid_Unor';
			$data['Params_Print'] = 'Params_M_Unor';
			$data['uri_all'] = 'master_data/cetak_unor/all';
			$data['uri_selected'] = 'master_data/cetak_unor/selected';
			$data['uri_by_rows'] = 'master_data/cetak_unor/by_rows/';
			$this->load->view('print_dialog/print_dialog_no_ttd_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_no_ttd_view');
		}
  }
	
	function cetak_unor($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data = $this->Unit_Organisasi_Model->get_AllPrint();
				$data['data_cetak'] = $data;
			}elseif($p_mode == "selected"){
				$data = $this->Unit_Organisasi_Model->get_SelectedPrint();
				$data['data_cetak'] = $data;
			}elseif($p_mode == "by_rows"){
				$data = $this->Unit_Organisasi_Model->get_ByRowsPrint($dari, $sampai);
				$data['data_cetak'] = $data;
			}
			$this->load->view('master/unit_organisasi_pdf',$data);
		}
	}
		
	// MASTER UNIT ORGANISASI ------------------------------------------- END
	
	// MASTER PEJABAT PENANDATANGAN ------------------------------------------- START
	function ttd(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/ttd_view',$data);
		}else{
			$this->load->view('master/ttd_view');
		}
	}
	
	function ext_get_all_ttd(){
		if($this->input->post("id_open")){
			$data = $this->TTD_Model->get_AllData();	
			$total = $this->TTD_Model->get_CountData();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}  
	
  function ext_insert_ttd(){  	
		$Status = $this->TTD_Model->Insert_Data();	 
		if($Status == "Exist"){
			echo "{success:false, info: { reason: 'Pejabat Penandatangan sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_numeric($Status)){
			echo "{success:true, info: { reason: '".$Status."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }

  function ext_delete_ttd(){
		$this->TTD_Model->Delete_Data();	
  }
	
	// CETAK PEJABAT PENANDATANGAN ---------------------------------------------
  function print_dialog_ttd(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'IDT_TTD';
			$data['Grid_ID'] = 'grid_TTD';
			$data['Params_Print'] = 'Params_M_TTD';
			$data['uri_all'] = 'master_data/cetak_ttd/all';
			$data['uri_selected'] = 'master_data/cetak_ttd/selected';
			$data['uri_by_rows'] = 'master_data/cetak_ttd/by_rows/';
			$this->load->view('print_dialog/print_dialog_no_ttd_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_no_ttd_view');
		}
  }
	
	function cetak_ttd($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data['data_cetak'] = $this->TTD_Model->get_AllPrint();
			}elseif($p_mode == "selected"){
				$data['data_cetak'] = $this->TTD_Model->get_SelectedPrint();
			}elseif($p_mode == "by_rows"){
				$data['data_cetak'] = $this->TTD_Model->get_ByRowsPrint($dari, $sampai);
			}
			$this->load->view('master/ttd_pdf',$data);
		}
	}	
	// MASTER PEJABAT PENANDATANGAN ------------------------------------------- END

	// MASTER PROVINSI ------------------------------------------- START
	function prov(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/prov_view',$data);
		}else{
			$this->load->view('master/prov_view');
		}
	}
	
	function ext_get_all_prov(){
		if($this->input->post("id_open")){
			$data = $this->Prov_Model->get_AllData();	
			$total = $this->Prov_Model->get_CountData();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}  
	
  function ext_insert_prov(){  	
		$Status = $this->Prov_Model->Insert_Data();	 
		if($Status == "Kode Exist"){
			echo "{success:false, info: { reason: 'Kode Provinsi sudah ada !' }}";
		}elseif($Status == "Exist"){
			echo "{success:false, info: { reason: 'Nama Provinsi sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_array($Status) && is_numeric($Status[0])){
			echo "{success:true, info: { reason: '".$Status[0]."', kode: '".$Status[1]."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }

  function ext_delete_prov(){
		$this->Prov_Model->Delete_Data();	
  }
	
	// CETAK PROVINSI ---------------------------------------------
  function print_dialog_prov(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_Prov';
			$data['Grid_ID'] = 'Grid_MProv';
			$data['Params_Print'] = 'Params_MProv';
			$data['uri_all'] = 'master_data/cetak_prov/all';
			$data['uri_selected'] = 'master_data/cetak_prov/selected';
			$data['uri_by_rows'] = 'master_data/cetak_prov/by_rows/';
			$this->load->view('print_dialog/print_dialog_no_ttd_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_no_ttd_view');
		}
  }
	
	function cetak_prov($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data['data_cetak'] = $this->Prov_Model->get_AllPrint();
			}elseif($p_mode == "selected"){
				$data['data_cetak'] = $this->Prov_Model->get_SelectedPrint();
			}elseif($p_mode == "by_rows"){
				$data['data_cetak'] = $this->Prov_Model->get_ByRowsPrint($dari, $sampai);
			}
			$this->load->view('master/prov_pdf',$data);
		}
	}	
	// MASTER PROVINSI ------------------------------------------- END

	// MASTER KABUPATEN / KOTA ------------------------------------------- START
	function kabkota(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/kabkota_view',$data);
		}else{
			$this->load->view('master/kabkota_view');
		}
	}
	
	function ext_get_all_kabkota(){
		if($this->input->post("id_open")){
			$data = $this->KabKota_Model->get_AllData();	
			$total = $this->KabKota_Model->get_CountData();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}  
	
  function ext_insert_kabkota(){  	
		$Status = $this->KabKota_Model->Insert_Data();	 
		if($Status == "Kode Exist"){
			echo "{success:false, info: { reason: 'Kode Kabupaten/Kota sudah ada !' }}";
		}elseif($Status == "Exist"){
			echo "{success:false, info: { reason: 'Nama Kabupaten/Kota sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_array($Status) && is_numeric($Status[0])){
			echo "{success:true, info: { reason: '".$Status[0]."', kode: '".$Status[1]."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }

  function ext_delete_kabkota(){
		$this->KabKota_Model->Delete_Data();	
  }
	
	// CETAK KABUPATEN / KOTA ---------------------------------------------
  function print_dialog_kabkota(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_KK';
			$data['Grid_ID'] = 'Grid_MKabKota';
			$data['Params_Print'] = 'Params_MKabKota';
			$data['uri_all'] = 'master_data/cetak_kabkota/all';
			$data['uri_selected'] = 'master_data/cetak_kabkota/selected';
			$data['uri_by_rows'] = 'master_data/cetak_kabkota/by_rows/';
			$this->load->view('print_dialog/print_dialog_no_ttd_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_no_ttd_view');
		}
  }
	
	function cetak_kabkota($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data['data_cetak'] = $this->KabKota_Model->get_AllPrint();
			}elseif($p_mode == "selected"){
				$data['data_cetak'] = $this->KabKota_Model->get_SelectedPrint();
			}elseif($p_mode == "by_rows"){
				$data['data_cetak'] = $this->KabKota_Model->get_ByRowsPrint($dari, $sampai);
			}
			$this->load->view('master/kabkota_pdf',$data);
		}
	}	
	// MASTER KABUPATEN / KOTA ------------------------------------------- END

	// MASTER KECAMATAN ------------------------------------------- START
	function kec(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/kec_view',$data);
		}else{
			$this->load->view('master/kec_view');
		}
	}
	
	function ext_get_all_kec(){
		if($this->input->post("id_open")){
			$data = $this->Kec_Model->get_AllData();	
			$total = $this->Kec_Model->get_CountData();	
			echo '({total:'. $total . ',results:'.json_encode($data).'})';  	
  	}
	}  
	
  function ext_insert_kec(){  	
		$Status = $this->Kec_Model->Insert_Data();	 
		if($Status == "Kode Exist"){
			echo "{success:false, info: { reason: 'Kode Kecamatan sudah ada !' }}";
		}elseif($Status == "Exist"){
			echo "{success:false, info: { reason: 'Nama Kecamatan sudah ada !' }}";
		}elseif($Status == "Updated"){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}elseif(is_array($Status) && is_numeric($Status[0])){
			echo "{success:true, info: { reason: '".$Status[0]."', kode: '".$Status[1]."' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
		}
  }

  function ext_delete_kec(){
		$this->Kec_Model->Delete_Data();	
  }
	
	// CETAK KECAMATAN ---------------------------------------------
  function print_dialog_kec(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$data['Data_ID'] = 'ID_Kec';
			$data['Grid_ID'] = 'Grid_MKec';
			$data['Params_Print'] = 'Params_MKec';
			$data['uri_all'] = 'master_data/cetak_kec/all';
			$data['uri_selected'] = 'master_data/cetak_kec/selected';
			$data['uri_by_rows'] = 'master_data/cetak_kec/by_rows/';
			$this->load->view('print_dialog/print_dialog_no_ttd_view',$data);
		}else{
			$this->load->view('print_dialog/print_dialog_no_ttd_view');
		}
  }
	
	function cetak_kec($p_mode='all', $dari = null, $sampai = null){
		if($this->input->post("id_open")){
			if($p_mode == "all"){
				$data['data_cetak'] = $this->Kec_Model->get_AllPrint();
			}elseif($p_mode == "selected"){
				$data['data_cetak'] = $this->Kec_Model->get_SelectedPrint();
			}elseif($p_mode == "by_rows"){
				$data['data_cetak'] = $this->Kec_Model->get_ByRowsPrint($dari, $sampai);
			}
			$this->load->view('master/kec_pdf',$data);
		}
	}	
	// MASTER KECAMATAN ------------------------------------------- END
	
	function petunjuk(){
		$this->load->view('petunjuk/master_data_petunjuk');
	}
        
        //MASTER KLASIFIKASI ASET LVL3
        function klasifikasi_aset_lvl3()
        {
            if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/klasifikasi_aset_lvl3_view',$data);
            }else{
                    $this->load->view('master/klasifikasi_aset_lvl3_view');
            }
        }
        
        function klasifikasi_aset_lvl3_getAllData()
        {
            if($this->input->get_post("id_open"))
            {
		$data = $this->Klasifikasi_Aset_Lvl3_Model->get_AllData();
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
//   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
                echo '({results:'.json_encode($data).'})';
            }
        }
        
        //MASTER KLASIFIKASI ASET LVL2
        function klasifikasi_aset_lvl2()
        {
            if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/klasifikasi_aset_lvl2_view',$data);
            }else{
                    $this->load->view('master/klasifikasi_aset_lvl2_view');
            }
        }
        
        function klasifikasi_aset_lvl2_getAllData()
        {
            if($this->input->get_post("id_open"))
            {
		$data = $this->Klasifikasi_Aset_Lvl2_Model->get_AllData();
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
//   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
                echo '({results:'.json_encode($data).'})';
            }
        }
        
        //MASTER KLASIFIKASI ASET LVL1
        function klasifikasi_aset_lvl1()
        {
            if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/klasifikasi_aset_lvl1_view',$data);
            }else{
                    $this->load->view('master/klasifikasi_aset_lvl1_view');
            }
        }
        
        function klasifikasi_aset_lvl1_getAllData()
        {
            if($this->input->get_post("id_open"))
            {
		$data = $this->Klasifikasi_Aset_Lvl1_Model->get_AllData();
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
//   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
                echo '({results:'.json_encode($data).'})';
            }
        }
        
        //MASTER WAREHOUSE
        function warehouse()
        {
            if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/warehouse_view',$data);
            }else{
                    $this->load->view('master/warehouse_view');
            }
        }
        
        function warehouse_getAllData()
        {
            if($this->input->get_post("id_open"))
            {
		$data = $this->Warehouse_Model->get_AllData();
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
//   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
                echo '({results:'.json_encode($data).'})';
            }
        }
        
        //MASTER RUANG
        function ruang()
        {
            if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/ruang_view',$data);
            }else{
                    $this->load->view('master/ruang_view');
            }
        }
        
        function ruang_getAllData()
        {
            if($this->input->get_post("id_open"))
            {
		$data = $this->Ruang_Model->get_AllData();
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
//   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
                echo '({results:'.json_encode($data).'})';
            }
        }
        
        //MASTER RAK
        function rak()
        {
            if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('master/rak_view',$data);
            }else{
                    $this->load->view('master/rak_view');
            }
        }
        
        function rak_getAllData()
        {
            if($this->input->get_post("id_open"))
            {
		$data = $this->Rak_Model->get_AllData();
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
//   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
                echo '({results:'.json_encode($data).'})';
            }
        }
}
?>