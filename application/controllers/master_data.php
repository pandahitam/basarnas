<?php

class Master_Data extends MY_Controller {

    function __construct() {
        parent::__construct();
        if ($this->my_usession->logged_in == FALSE) {
            echo "window.location = '" . base_url() . "user/index';";
            exit;
        }
        $this->load->model('Unit_Kerja_Model', '', TRUE);
        $this->load->model('Unit_Organisasi_Model', '', TRUE);
        $this->load->model('Klasifikasi_Aset_Lvl1_Model', '', TRUE);
        $this->load->model('Klasifikasi_Aset_Lvl2_Model', '', TRUE);
        $this->load->model('Klasifikasi_Aset_Lvl3_Model', '', TRUE);
        $this->load->model('Warehouse_Model', '', TRUE);
        $this->load->model('Ruang_Model', '', TRUE);
        $this->load->model('Rak_Model', '', TRUE);
        $this->load->model('Part_Number_Model', '', TRUE);
        $this->load->model('Kd_Brg_Golongan_Model', '', TRUE);
        $this->load->model('Kd_Brg_Bidang_Model', '', TRUE);
        $this->load->model('Kd_Brg_Kelompok_Model', '', TRUE);
        $this->load->model('Kd_Brg_SubKelompok_Model', '', TRUE);
        $this->load->model('Kd_Brg_SubSubKelompok_Model', '', TRUE);
//		$this->load->model('Jabatan_Model','',TRUE);
//		$this->load->model('TTD_Model','',TRUE);
        $this->load->model('Kelompok_Part_Model','',TRUE);
	$this->load->model('Prov_Model','',TRUE);
        $this->load->model('KabKota_Model','',TRUE);
        $this->load->model('Referensi_Ruang_Model','',TRUE);
//		$this->load->model('Kec_Model','',TRUE);
//		$this->load->model('Tasset_tanah_Model','',TRUE);		
//		$this->load->model('Tasset_bangunan_Model','',TRUE);
    }

    function index() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/master_data_view', $data);
        } else {
            $this->load->view('master/master_data_view');
        }
    }

    function combo_jns_unit_kerja() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('jns_unker', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Unker_Jns');
            $this->db->order_by('kode_jns_unker', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_jns_jabatan() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('jenis_jab', $this->input->get_post('query'));
            }
            $this->db->select('kode_jenis_jab,jenis_jab');
            $this->db->from('tRef_Jabatan_jns');
            $this->db->order_by('kode_jenis_jab', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_golru() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_pangkat', $this->input->get_post('query'));
                $this->db->or_like('nama_golru', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Golru');
            $this->db->order_by('kode_golru', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_klp_jabatan() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('klp_jab', $this->input->get_post('query'));
            }
            $this->db->select('kode_klp_jab,klp_jab');
            $this->db->from('tRef_Jabatan_Klpk');
            $this->db->order_by('kode_klp_jab', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_jabatan() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_jab', $this->input->get_post('query'));
            }
            $this->db->select('ID_Jab,kode_jab,nama_jab');
            $this->db->from('tRef_Jabatan');
            $this->db->order_by('kode_jab', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_eselon() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_eselon', $this->input->get_post('query'));
            }
            $this->db->select('kode_eselon,nama_eselon');
            $this->db->from('tRef_Eselon');
            $this->db->order_by('kode_eselon', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_tkt_hukdis() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('tkt_hukdis', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_HukDis_Tkt');
            $this->db->order_by('kode_tkt_hukdis', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_dupeg() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_dupeg', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Dupeg');
            $this->db->order_by('kode_dupeg', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_pekerjaan() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_pekerjaan', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Pekerjaan');
            $this->db->order_by('kode_pekerjaan', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    // MASTER UNIT KERJA ------------------------------------------- START
     function checkUnitKerja()
    {

        $this->db->from('ref_unker');
        $this->db->where('kdlok',$_POST['kd_lokasi']);
        $result = $this->db->get();
//        var_dump($this->db->last_query());
//        var_dump($result->num_rows());
//        var_dump($_POST);
//        die;

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    function unit_kerja() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/unit_kerja_view', $data);
        } else {
            $this->load->view('master/unit_kerja_view');
        }
    }
    
        function unitkerja_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Unit_Kerja_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Unit_Kerja_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
//            echo '({results:' . json_encode($data) . '})';
        }
    }
    
    function unitkerja_createUnitKerja() {
        
        $data = array();
        
        $dataFields = array(
            'ur_upb', 'kdlok','kd_pebin','kd_pbi','kd_ppbi','kd_upb','kd_subupb','kd_jk'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $data['kdlok'] = $data['kd_pebin'].$data['kd_pbi'].$data['kd_ppbi'].$data['kd_upb'].$data['kd_subupb'].$data['kd_jk'];
        
        $this->db->set($data);
        $this->db->replace('ref_unker');
        $this->createLog('INSERT REFERENSI UNIT KERJA','ref_unker');
        echo "{success: true}";
    }
    
    function unitkerja_modifyUnitKerja() {
        
        $data = array();
        
        $dataFields = array(
            'ur_upb', 'kdlok','kd_pebin','kd_pbi','kd_ppbi','kd_upb','kd_subupb','kd_jk'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $data['kdlok'] = $data['kd_pebin'].$data['kd_pbi'].$data['kd_ppbi'].$data['kd_upb'].$data['kd_subupb'].$data['kd_jk'];
        
        $this->db->set($data);
        $this->db->replace('ref_unker');
        $this->createLog('UPDATE REFERENSI UNIT KERJA','ref_unker');
        echo "{success: true}";
    }
    
    
    function unitkerja_deleteUnitKerja()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('kdlok', $data['id']);
           $this->db->delete('ref_unker');
           $this->createLog('DELETE REFERENSI UNIT KERJA','ref_unker');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }


//    function ext_get_all_unit_kerja() {
//        if ($this->input->get_post("id_open")) {
//            echo json_encode($this->Unit_Kerja_Model->get_AllData());
//        }
//    }
//
//    function ext_insert_unit_kerja() {
//        $Status = $this->Unit_Kerja_Model->Insert_Data();
//        if ($Status == "Exist") {
//            echo "{success:false, info: { reason: 'Nama Unit Kerja sudah ada !' }}";
//        } elseif ($Status == "Updated") {
//            echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
//        } elseif (is_numeric($Status)) {
//            echo "{success:true, info: { reason: '" . $Status . "' }}";
//        } else {
//            echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
//        }
//    }
//
//    function ext_delete_unit_kerja() {
//        if ($this->Unit_Kerja_Model->Delete_Data() == TRUE) {
//            echo "{success:true}";
//        } else {
//            echo "{success:false, errors: { reason: 'Unit Kerja Induk Tidak dapat dihapus !' }}";
//        }
//    }
//
//    // CETAK UNIT KERJA ---------------------------------------------
//    function print_dialog_unker() {
//        if ($this->input->post("id_open")) {
//            $data['jsscript'] = TRUE;
//            $data['Data_ID'] = 'ID_UK';
//            $data['Grid_ID'] = 'Grid_UK';
//            $data['Params_Print'] = 'Params_M_UK';
//            $data['uri_all'] = 'master_data/cetak_unker/all';
//            $data['uri_selected'] = 'master_data/cetak_unker/selected';
//            $data['uri_by_rows'] = 'master_data/cetak_unker/by_rows/';
//            $this->load->view('print_dialog/print_dialog_no_ttd_view', $data);
//        } else {
//            $this->load->view('print_dialog/print_dialog_no_ttd_view');
//        }
//    }
//
//    function cetak_unker($p_mode = 'all', $dari = null, $sampai = null) {
//        if ($this->input->post("id_open")) {
//            if ($p_mode == "all") {
//                $data['data_cetak'] = $this->Unit_Kerja_Model->get_AllPrint();
//            } elseif ($p_mode == "selected") {
//                $data['data_cetak'] = $this->Unit_Kerja_Model->get_SelectedPrint();
//            } elseif ($p_mode == "by_rows") {
//                $data['data_cetak'] = $this->Unit_Kerja_Model->get_ByRowsPrint($dari, $sampai);
//            }
//            $this->load->view('master/unit_kerja_pdf', $data);
//        }
//    }

    // MASTER UNIT KERJA ------------------------------------------- START
    // MASTER JABATAN ------------------------------------------- START
    function jabatan() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/jabatan_view', $data);
        } else {
            $this->load->view('master/jabatan_view');
        }
    }

    function ext_get_all_jabatan() {
        if ($this->input->get_post("id_open")) {
            $data = $this->Jabatan_Model->get_AllData();
            $total = $this->Jabatan_Model->get_CountData();
            echo '({total:' . $total . ',results:' . json_encode($data) . '})';
        }
    }

    function ext_insert_jabatan() {
        $Status = $this->Jabatan_Model->Insert_Data();
        if ($Status == "Exist") {
            echo "{success:false, info: { reason: 'Nama Jabatan sudah ada !' }}";
        } elseif ($Status == "Updated") {
            echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
        } elseif (is_numeric($Status)) {
            echo "{success:true, info: { reason: '" . $Status . "' }}";
        } else {
            echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
        }
    }

    function ext_delete_jabatan() {
        $this->Jabatan_Model->Delete_Data();
    }

    // CETAK JABATAN ------------------------------------------------------------
    function print_dialog_jab() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $data['Data_ID'] = 'ID_Jab';
            $data['Grid_ID'] = 'grid_Jabatan';
            $data['Params_Print'] = 'Params_M_Jab';
            $data['uri_all'] = 'master_data/cetak_jab/all';
            $data['uri_selected'] = 'master_data/cetak_jab/selected';
            $data['uri_by_rows'] = 'master_data/cetak_jab/by_rows/';
            $this->load->view('print_dialog/print_dialog_no_ttd_view', $data);
        } else {
            $this->load->view('print_dialog/print_dialog_no_ttd_view');
        }
    }

    function cetak_jab($p_mode = 'all', $dari = null, $sampai = null) {
        if ($this->input->post("id_open")) {
            if ($p_mode == "all") {
                $data['data_cetak'] = $this->Jabatan_Model->get_AllPrint();
            } elseif ($p_mode == "selected") {
                $data['data_cetak'] = $this->Jabatan_Model->get_SelectedPrint();
            } elseif ($p_mode == "by_rows") {
                $data['data_cetak'] = $this->Jabatan_Model->get_ByRowsPrint($dari, $sampai);
            }
            $this->load->view('master/jabatan_pdf', $data);
        }
    }

    // MASTER JABATAN ------------------------------------------- END
    // MASTER UNIT ORGANISASI ------------------------------------------- START
    function unit_organisasi() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/unit_organisasi_view', $data);
        } else {
            $this->load->view('master/unit_organisasi_view');
        }
    }
    
    function unitorganisasi_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Unit_Organisasi_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Unit_Organisasi_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
//            echo '({results:' . json_encode($data) . '})';
        }
    }
    
    function unitorganisasi_modifyUnitOrganisasi() {
        
        $data = array();
        
        $dataFields = array(
            'ID_Unor', 'kode_unor','kd_lokasi','kode_jab','kode_eselon','kode_parent', 'nama_unor', 'jabatan_unor', 'urut_unor','status_data'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->set($data);
        $this->db->replace('ref_unor');
        
        if($data['ID_Unor'] != '')
        {
            $this->createLog('UPDATE REFERENSI UNIT ORGANISASI','ref_unor');
        }
        else
        {
            $this->createLog('INSERT REFERENSI UNIT ORGANISASI','ref_unor');
        }
        echo "{success: true}";
    }
    
    function unitorganisasi_deleteUnitOrganisasi()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('ID_Unor', $data['id']);
           $this->db->delete('ref_unor');
           $this->createLog('DELETE REFERENSI UNIT ORGANISASI','ref_unor');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function unitorganisasi_getLastKodeUnor()
    {
        $this->db->from('ref_unor');
        $this->db->select('kode_unor');
        $this->db->order_by('kode_unor','desc');
        $query = $this->db->get();
        $result = $query->row();
        echo $result->kode_unor + 1;
    }
    
    function checkKodeUnitOrganisasi()
    {

        $this->db->from('ref_unor');
        $this->db->where('kode_unor',$_POST['kode_unor']);
        $result = $this->db->get();
//        var_dump($this->db->last_query());
//        var_dump($result->num_rows());
//        var_dump($_POST);
//        die;

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }

//    function ext_get_all_unit_organisasi() {
//        if ($this->input->get_post("id_open")) {
//            echo json_encode($this->Unit_Organisasi_Model->get_AllData());
//        }
//    }
//
//    function ext_insert_unit_organisasi() {
//        $Status = $this->Unit_Organisasi_Model->Insert_Data();
//        if ($Status == "Exist") {
//            echo "{success:false, info: { reason: 'Nama Unit Organisasi sudah ada !' }}";
//        } elseif ($Status == "Updated") {
//            echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
//        } elseif (is_numeric($Status)) {
//            echo "{success:true, info: { reason: '" . $Status . "' }}";
//        } else {
//            echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
//        }
//    }
//
//    function ext_delete_unit_organisasi() {
//        $this->Unit_Organisasi_Model->Delete_Data();
//    }
//
//    function get_next_urut_unor() {
//        if ($this->input->post("id_open")) {
//            $data = array();
//            $this->db->select("urut_unor");
//            $this->db->from("tRef_Unor");
//            $this->db->order_by("urut_unor", "DESC");
//            $this->db->limit(1);
//            $Q = $this->db->get();
//            if ($Q->num_rows() > 0) {
//                $data = $Q->row_array();
//                $next_urut_unor = (int) $data['urut_unor'] + 1;
//            } else {
//                $next_urut_unor = 1;
//            }
//            echo $next_urut_unor;
//        }
//    }
//
//    function print_dialog_tb() {
//        if ($this->input->post("id_open")) {
//            $data['jsscript'] = TRUE;
//            $data['Data_ID'] = 'id';
//            $data['Grid_ID'] = 'grid_tb';
//            $data['Params_Print'] = 'Params_M_TB';
//            $data['uri_all'] = 'master_data/cetak_tb/all';
//            $data['uri_selected'] = 'master_data/cetak_tb/selected';
//            $data['uri_by_rows'] = 'master_data/cetak_tb/by_rows/';
//            $this->load->view('print_dialog/print_dialog_no_ttd_view', $data);
//        } else {
//            $this->load->view('print_dialog/print_dialog_no_ttd_view');
//        }
//    }
//
//    function cetak_tb($p_mode = 'all', $dari = null, $sampai = null) {
//        if ($this->input->post("id_open")) {
//            $data = array();
//            $dataTanah = array();
//            $dataBangunan = array();
//
//            if ($p_mode == "all" || $p_mode == "by_rows") {
//                $dataTanah = $this->Tasset_tanah_Model->get_AllData();
//                $dataBangunan = $this->Tasset_bangunan_Model->get_AllData();
//            } elseif ($p_mode == "selected") {
//                $idt = $this->input->post('idTanah');
//                $idb = $this->input->post('idBangunan');
//                $selectedTanah = explode('-', $idt);
//                $selectedBangunan = explode('-', $idb);
//                $dataTanah = $this->Tasset_tanah_Model->get_byIDs($selectedTanah);
//                $dataBangunan = $this->Tasset_bangunan_Model->get_byIDs($selectedBangunan);
//            }
//
//            if (count($dataTanah) > 0) {
//                foreach ($dataTanah as $e) {//tanah
//                    $val = array('alamat' => $e->alamat,
//                        'nama' => ' - ',
//                        'nama_unker' => $e->nama_unker,
//                        'jabatan_unor' => $e->jabatan_unor,
//                        'nama_prov' => $e->nama_prov,
//                        'nama_kabkota' => $e->nama_kabkota,
//                        'id' => $e->id,
//                        'kode_pos' => strval($e->kode_pos),
//                        'luas_tanah' => strval($e->luas_tanah),
//                        'luas_bangunan' => ' - ',
//                        'tipe' => 'TANAH'
//                    );
//                    $data[] = $val;
//                }
//            }
//            if (count($dataBangunan) > 0) {
//                foreach ($dataBangunan as $e) {
//                    $val = array('alamat' => $e->alamat,
//                        'nama' => $e->nama,
//                        'nama_unker' => $e->nama_unker,
//                        'jabatan_unor' => $e->jabatan_unor,
//                        'nama_prov' => $e->nama_prov,
//                        'nama_kabkota' => $e->nama_kabkota,
//                        'id' => $e->id,
//                        'kode_pos' => strval($e->kode_pos),
//                        'luas_tanah' => strval($e->luas_tanah),
//                        'luas_bangunan' => strval($e->luas_bangunan),
//                        'tipe' => 'BANGUNAN'
//                    );
//                    $data[] = $val;
//                }
//            }
//
//            if ($p_mode == "by_rows") {
//                if (isset($dari) && isset($sampai)) {
//                    $offset = $dari - 1;
//                    $numrows = $sampai - $offset;
//                    $data = array_slice($data, $offset, $numrows);
//                }
//            }
//
//            $dataSend['data_cetak'] = $data;
//
//
//
//            $this->load->view('pengelolaan_asset/tanah_bangunan_pdf', $dataSend);
//        }
//    }
//
//    // CETAK UNIT ORGANISASI ---------------------------------------------
//    function print_dialog_unor() {
//        if ($this->input->post("id_open")) {
//            $data['jsscript'] = TRUE;
//            $data['Data_ID'] = 'id';
//            $data['Grid_ID'] = 'grid_Unor';
//            $data['Params_Print'] = 'Params_M_Unor';
//            $data['uri_all'] = 'master_data/cetak_unor/all';
//            $data['uri_selected'] = 'master_data/cetak_unor/selected';
//            $data['uri_by_rows'] = 'master_data/cetak_unor/by_rows/';
//            $this->load->view('print_dialog/print_dialog_no_ttd_view', $data);
//        } else {
//            $this->load->view('print_dialog/print_dialog_no_ttd_view');
//        }
//    }
//
//    function cetak_unor($p_mode = 'all', $dari = null, $sampai = null) {
//        if ($this->input->post("id_open")) {
//            if ($p_mode == "all") {
//                $data = $this->Unit_Organisasi_Model->get_AllPrint();
//                $data['data_cetak'] = $data;
//            } elseif ($p_mode == "selected") {
//                $data = $this->Unit_Organisasi_Model->get_SelectedPrint();
//                $data['data_cetak'] = $data;
//            } elseif ($p_mode == "by_rows") {
//                $data = $this->Unit_Organisasi_Model->get_ByRowsPrint($dari, $sampai);
//                $data['data_cetak'] = $data;
//            }
//            $this->load->view('master/unit_organisasi_pdf', $data);
//        }
//    }

    // MASTER UNIT ORGANISASI ------------------------------------------- END
    // MASTER PEJABAT PENANDATANGAN ------------------------------------------- START
    function ttd() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/ttd_view', $data);
        } else {
            $this->load->view('master/ttd_view');
        }
    }

    function ext_get_all_ttd() {
        if ($this->input->post("id_open")) {
            $data = $this->TTD_Model->get_AllData();
            $total = $this->TTD_Model->get_CountData();
            echo '({total:' . $total . ',results:' . json_encode($data) . '})';
        }
    }

    function ext_insert_ttd() {
        $Status = $this->TTD_Model->Insert_Data();
        if ($Status == "Exist") {
            echo "{success:false, info: { reason: 'Pejabat Penandatangan sudah ada !' }}";
        } elseif ($Status == "Updated") {
            echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
        } elseif (is_numeric($Status)) {
            echo "{success:true, info: { reason: '" . $Status . "' }}";
        } else {
            echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
        }
    }

    function ext_delete_ttd() {
        $this->TTD_Model->Delete_Data();
    }

    // CETAK PEJABAT PENANDATANGAN ---------------------------------------------
    function print_dialog_ttd() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $data['Data_ID'] = 'IDT_TTD';
            $data['Grid_ID'] = 'grid_TTD';
            $data['Params_Print'] = 'Params_M_TTD';
            $data['uri_all'] = 'master_data/cetak_ttd/all';
            $data['uri_selected'] = 'master_data/cetak_ttd/selected';
            $data['uri_by_rows'] = 'master_data/cetak_ttd/by_rows/';
            $this->load->view('print_dialog/print_dialog_no_ttd_view', $data);
        } else {
            $this->load->view('print_dialog/print_dialog_no_ttd_view');
        }
    }

    function cetak_ttd($p_mode = 'all', $dari = null, $sampai = null) {
        if ($this->input->post("id_open")) {
            if ($p_mode == "all") {
                $data['data_cetak'] = $this->TTD_Model->get_AllPrint();
            } elseif ($p_mode == "selected") {
                $data['data_cetak'] = $this->TTD_Model->get_SelectedPrint();
            } elseif ($p_mode == "by_rows") {
                $data['data_cetak'] = $this->TTD_Model->get_ByRowsPrint($dari, $sampai);
            }
            $this->load->view('master/ttd_pdf', $data);
        }
    }

    // MASTER PEJABAT PENANDATANGAN ------------------------------------------- END
    // MASTER PROVINSI ------------------------------------------- START
    function provinsi() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/prov_view', $data);
        } else {
            $this->load->view('master/prov_view');
        }
    }

    function provinsi_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Prov_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Prov_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function provinsi_createProvinsi() {
        
        $data = array();
        
        $dataFields = array(
            'ID_Prov','kode_prov','nama_prov'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->set($data);
        $this->db->replace('tref_provinsi');
        $this->createLog('INSERT REFERENSI PROVINSI','tref_provinsi');
        echo "{success: true}";
    }
    
    function provinsi_modifyProvinsi() {
        
        $data = array();
        
        $dataFields = array(
            'ID_Prov','kode_prov','nama_prov'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->where('ID_Prov', $data['ID_Prov']);
        unset($data['ID_Prov']);
        $this->db->update('tref_provinsi',$data);
         $this->createLog('UPDATE REFERENSI PROVINSI','tref_provinsi');
        echo "{success: true}";
    }
    
    function provinsi_deleteProvinsi()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('ID_Prov', $data['id']);
           $this->db->delete('tref_provinsi');
           $this->db->where('kode_prov',$data['kode_prov']);
           $this->db->delete('tref_kabkota');
           $this->createLog('DELETE REFERENSI PROVINSI','tref_provinsi');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function checkKdProvinsi()
    {

        $this->db->from('tref_provinsi');
        $this->db->where('kode_prov',$_POST['kode']);
        $result = $this->db->get();

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    function provinsi_getLastKodeProv()
    {
        $this->db->from('tref_provinsi');
        $this->db->select('kode_prov');
        $this->db->order_by('kode_prov','desc');
        $query = $this->db->get();
        $result = $query->row();
        echo $result->kode_prov + 1;
    }

    // MASTER PROVINSI ------------------------------------------- END
    // MASTER KABUPATEN / KOTA ------------------------------------------- START
   function kabkota() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/kabkota_view', $data);
        } else {
            $this->load->view('master/kabkota_view');
        }
    }

    function kabkota_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->KabKota_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('KabKota_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function kabkota_createKabkota() {
        
        $data = array();
        $dataFields = array(
            'ID_KK','kode_prov','kode_kabkota','nama_kabkota'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->set($data);
        $this->db->replace('tref_kabkota');
        $this->createLog('INSERT REFERENSI KOTA/KABUPATEN','tref_kabkota');
        echo "{success: true}";
    }
    
    function kabkota_modifyKabkota() {
        
        $data = array();
        
        $dataFields = array(
            'ID_KK','kode_prov','kode_kabkota','nama_kabkota'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->where('ID_KK', $data['ID_KK']);
        unset($data['ID_KK']);
        $this->db->update('tref_kabkota',$data);
         $this->createLog('UPDATE REFERENSI KOTA/KABUPATEN','tref_kabkota');
        echo "{success: true}";
    }
    
    function kabkota_deleteKabkota()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('ID_KK', $data['id']);
           $this->db->delete('tref_kabkota');
           $this->createLog('DELETE REFERENSI KOTA/KABUPATEN','tref_kabkota');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function checkKdKabkota()
    {

        $this->db->from('tref_kabkota');
        $this->db->where('kode_kabkota',$_POST['kabkota']);
        $this->db->where('kode_prov',$_POST['prov']);
        $result = $this->db->get();

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    function kabkota_getLastKodeKabkota()
    {
        $this->db->from('tref_kabkota');
        $this->db->select('kode_kabkota');
        $this->db->order_by('kode_kabkota','desc');
        $query = $this->db->get();
        $result = $query->row();
        echo $result->kode_kabkota + 1;
    }

    // MASTER KABUPATEN / KOTA ------------------------------------------- END
    // MASTER KECAMATAN ------------------------------------------- START
    function kec() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/kec_view', $data);
        } else {
            $this->load->view('master/kec_view');
        }
    }

    function ext_get_all_kec() {
        if ($this->input->post("id_open")) {
            $data = $this->Kec_Model->get_AllData();
            $total = $this->Kec_Model->get_CountData();
            echo '({total:' . $total . ',results:' . json_encode($data) . '})';
        }
    }

    function ext_insert_kec() {
        $Status = $this->Kec_Model->Insert_Data();
        if ($Status == "Kode Exist") {
            echo "{success:false, info: { reason: 'Kode Kecamatan sudah ada !' }}";
        } elseif ($Status == "Exist") {
            echo "{success:false, info: { reason: 'Nama Kecamatan sudah ada !' }}";
        } elseif ($Status == "Updated") {
            echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
        } elseif (is_array($Status) && is_numeric($Status[0])) {
            echo "{success:true, info: { reason: '" . $Status[0] . "', kode: '" . $Status[1] . "' }}";
        } else {
            echo "{success:false, info: { reason: 'Gagal menambah Data !' }}";
        }
    }

    function ext_delete_kec() {
        $this->Kec_Model->Delete_Data();
    }

    // CETAK KECAMATAN ---------------------------------------------
    function print_dialog_kec() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $data['Data_ID'] = 'ID_Kec';
            $data['Grid_ID'] = 'Grid_MKec';
            $data['Params_Print'] = 'Params_MKec';
            $data['uri_all'] = 'master_data/cetak_kec/all';
            $data['uri_selected'] = 'master_data/cetak_kec/selected';
            $data['uri_by_rows'] = 'master_data/cetak_kec/by_rows/';
            $this->load->view('print_dialog/print_dialog_no_ttd_view', $data);
        } else {
            $this->load->view('print_dialog/print_dialog_no_ttd_view');
        }
    }

    function cetak_kec($p_mode = 'all', $dari = null, $sampai = null) {
        if ($this->input->post("id_open")) {
            if ($p_mode == "all") {
                $data['data_cetak'] = $this->Kec_Model->get_AllPrint();
            } elseif ($p_mode == "selected") {
                $data['data_cetak'] = $this->Kec_Model->get_SelectedPrint();
            } elseif ($p_mode == "by_rows") {
                $data['data_cetak'] = $this->Kec_Model->get_ByRowsPrint($dari, $sampai);
            }
            $this->load->view('master/kec_pdf', $data);
        }
    }

    // MASTER KECAMATAN ------------------------------------------- END

    function petunjuk() {
        $this->load->view('petunjuk/master_data_petunjuk');
    }

    //MASTER KLASIFIKASI ASET LVL3
    function klasifikasi_aset_lvl3() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/klasifikasi_aset_lvl3_view', $data);
        } else {
            $this->load->view('master/klasifikasi_aset_lvl3_view');
        }
    }

    function klasifikasi_aset_lvl3_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Klasifikasi_Aset_Lvl3_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Klasifikasi_Aset_Lvl3_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function klasifikasi_aset_lvl3_createKlasifikasiAsetLvl3() {
        
        $data = array();
        
        $dataFields = array(
            'kd_lvl1','kd_lvl2','kd_lvl3','nama','kd_klasifikasi_aset'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $data['kd_klasifikasi_aset'] = $data['kd_lvl1'].$data['kd_lvl2'].$data['kd_lvl3'];
        
        $this->db->set($data);
        $this->db->replace('ref_klasifikasiaset_lvl3');
        $this->createLog('INSERT REFERENSI KLASIFIKASI ASET LVL 3','ref_klasifikasiaset_lvl3');
        echo "{success: true}";
    }
    
    function klasifikasi_aset_lvl3_modifyKlasifikasiAsetLvl3() {
        
        $data = array();
        
        $dataFields = array(
            'kd_lvl1','kd_lvl2','kd_lvl3','nama','kd_klasifikasi_aset'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $data['kd_klasifikasi_aset'] = $data['kd_lvl1'].$data['kd_lvl2'].$data['kd_lvl3'];
        $this->db->where('kd_lvl1',$data['kd_lvl1']);
        $this->db->where('kd_lvl2',$data['kd_lvl2']);
        $this->db->where('kd_lvl3',$data['kd_lvl3']);
        unset($data['kd_lvl1'],$data['kd_lvl2'],$data['kd_lvl3']);
        $this->db->update('ref_klasifikasiaset_lvl3',$data);
        $this->createLog('UPDATE REFERENSI KLASIFIKASI ASET LVL 3','ref_klasifikasiaset_lvl3');
        echo "{success: true}";
    }
    
    function klasifikasi_aset_lvl3_deleteKlasifikasiAsetLvl3()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('kd_klasifikasi_aset', $data['id']);
           $this->db->delete('ref_klasifikasiaset_lvl3');
           $this->createLog('DELETE REFERENSI KLASIFIKASI ASET LVL 3','ref_klasifikasiaset_lvl3');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }

    //MASTER KLASIFIKASI ASET LVL2
    function klasifikasi_aset_lvl2() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/klasifikasi_aset_lvl2_view', $data);
        } else {
            $this->load->view('master/klasifikasi_aset_lvl2_view');
        }
    }

    function klasifikasi_aset_lvl2_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Klasifikasi_Aset_Lvl2_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Klasifikasi_Aset_Lvl2_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function klasifikasi_aset_lvl2_createKlasifikasiAsetLvl2() {
        
        $data = array();
        
        $dataFields = array(
            'kd_lvl1','kd_lvl2','nama','kd_lvl2_brg'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $data['kd_lvl2_brg'] = $data['kd_lvl1'].$data['kd_lvl2'];
        
        $this->db->set($data);
        $this->db->replace('ref_klasifikasiaset_lvl2');
        $this->createLog('INSERT REFERENSI KLASIFIKASI ASET LVL 2','ref_klasifikasiaset_lvl2');
        echo "{success: true}";
    }
    
    function klasifikasi_aset_lvl2_modifyKlasifikasiAsetLvl2() {
        
        $data = array();
        
        $dataFields = array(
            'kd_lvl1','kd_lvl2','nama','kd_lvl2_brg'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $data['kd_lvl2_brg'] = $data['kd_lvl1'].$data['kd_lvl2'];
        
        $this->db->where('kd_lvl1',$data['kd_lvl1']);
        $this->db->where('kd_lvl2',$data['kd_lvl2']);
        unset($data['kd_lvl1'],$data['kd_lvl2']);
        $this->db->update('ref_klasifikasiaset_lvl2',$data);
        $this->createLog('UPDATE REFERENSI KLASIFIKASI ASET LVL 2','ref_klasifikasiaset_lvl2');
        
        echo "{success: true}";
    }
    
    function klasifikasi_aset_lvl2_deleteKlasifikasiAsetLvl2()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('kd_lvl2_brg', $data['id']);
           $this->db->delete('ref_klasifikasiaset_lvl2');
           $this->createLog('DELETE REFERENSI KLASIFIKASI ASET LVL 2','ref_klasifikasiaset_lvl2');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }

    //MASTER KLASIFIKASI ASET LVL1
    function klasifikasi_aset_lvl1() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/klasifikasi_aset_lvl1_view', $data);
        } else {
            $this->load->view('master/klasifikasi_aset_lvl1_view');
        }
    }

    function klasifikasi_aset_lvl1_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Klasifikasi_Aset_Lvl1_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Klasifikasi_Aset_Lvl1_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function klasifikasi_aset_lvl1_createKlasifikasiAsetLvl1() {
        
        $data = array();
        
        $dataFields = array(
            'kd_lvl1','nama'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->set($data);
        $this->db->replace('ref_klasifikasiaset_lvl1');
        $this->createLog('INSERT REFERENSI KLASIFIKASI ASET LVL 1','ref_klasifikasiaset_lvl1');
        echo "{success: true}";
    }
    
    function klasifikasi_aset_lvl1_modifyKlasifikasiAsetLvl1() {
        
        $data = array();
        
        $dataFields = array(
            'kd_lvl1','nama'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        
        $this->db->where('kd_lvl1', $data['kd_lvl1']);
        unset($data['kd_lvl1']);
        $this->db->update('ref_klasifikasiaset_lvl1',$data);
         $this->createLog('UPDATE REFERENSI KLASIFIKASI ASET LVL 1','ref_klasifikasiaset_lvl1');
        echo "{success: true}";
    }
    
    function klasifikasi_aset_lvl1_deleteKlasifikasiAsetLvl1()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('kd_lvl1', $data['id']);
           $this->db->delete('ref_klasifikasiaset_lvl1');
           $this->createLog('DELETE REFERENSI KLASIFIKASI ASET LVL 1','ref_klasifikasiaset_lvl1');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function checkKdKlasifikasiAset()
    {

        $key = $_POST['key'];
        $table_name = $_POST['table_name'];
        $this->db->from($table_name);
        $this->db->where($key,$_POST['value']['key']);
        $result = $this->db->get();
//        var_dump($this->db->last_query());
//        var_dump($result->num_rows());
//        var_dump($_POST);
//        die;

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }

    //MASTER WAREHOUSE
    function warehouse() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/warehouse_view', $data);
        } else {
            $this->load->view('master/warehouse_view');
        }
    }

    function warehouse_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Warehouse_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Warehouse_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
//            echo '({results:' . json_encode($data) . '})';
        }
    }
    
    function warehouse_createWarehouse() {
        
        $data = array();
        
        $dataFields = array(
            'id','kd_lokasi','nama','kode_unor'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        $this->db->set($data);
        $this->db->replace('ref_warehouse');
        $this->createLog('INSERT REFERENSI PENYIMPANAN WAREHOUSE','ref_warehouse');
        echo "{success: true}";
    }
    
    function warehouse_modifyWarehouse() {
        
        $data = array();
        
        $dataFields = array(
            'id','kd_lokasi','nama','kode_unor'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        
        $this->db->where('id', $data['id']);
        unset($data['id']);
        $this->db->update('ref_warehouse',$data);
        $this->createLog('UPDATE REFERENSI PENYIMPANAN WAREHOUSE','ref_warehouse');
        echo "{success: true}";
    }
    
    
    function warehouse_deleteWarehouse()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('id', $data['id']);
           $this->db->delete('ref_warehouse');
           $this->createLog('DELETE REFERENSI PENYIMPANAN WAREHOUSE','ref_warehouse');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }

    //MASTER RUANG
    function ruang() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/ruang_view', $data);
        } else {
            $this->load->view('master/ruang_view');
        }
    }

    function ruang_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Ruang_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Ruang_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
//            echo '({results:' . json_encode($data) . '})';
        }
    }
    
    function ruang_createRuang() {
        
        $data = array();
        
        $dataFields = array(
            'id','warehouse_id','nama'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->set($data);
        $this->db->replace('ref_warehouseruang');
        $this->createLog('INSERT REFERENSI PENYIMPANAN RUANG','ref_warehouseruang');
        echo "{success: true}";
    }
    
    function ruang_modifyRuang() {
        
        $data = array();
        
        $dataFields = array(
            'id','warehouse_id','nama'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->where('id', $data['id']);
        unset($data['id'],$data['warehouse_id']);
        $this->db->update('ref_warehouseruang',$data);
        $this->createLog('UPDATE REFERENSI PENYIMPANAN RUANG','ref_warehouseruang');
        echo "{success: true}";
    }
    
    function ruang_deleteRuang()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('id', $data['id']);
           $this->db->delete('ref_warehouseruang');
           $this->createLog('DELETE REFERENSI PENYIMPANAN RUANG','ref_warehouseruang');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }

    //MASTER RAK
    function rak() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/rak_view', $data);
        } else {
            $this->load->view('master/rak_view');
        }
    }

    function rak_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Rak_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Rak_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
//            echo '({results:' . json_encode($data) . '})';
        }
    }
    
        function rak_createRak() {
        
        $data = array();
        
        $dataFields = array(
            'id','warehouseruang_id','nama','warehouse_id',
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->set($data);
        $this->db->replace('ref_warehouserak');
        $this->createLog('INSERT REFERENSI PENYIMPANAN RAK','ref_warehouserak');
        echo "{success: true}";
    }
    
     function rak_modifyRak() {
        
        $data = array();
        
        $dataFields = array(
            'id','warehouseruang_id','nama','warehouse_id',
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
         $this->db->where('id', $data['id']);
        unset($data['id'],$data['warehouse_id'],$data['warehouseruang_id']);
        $this->db->update('ref_warehouserak',$data);
        $this->createLog('UPDATE REFERENSI PENYIMPANAN RAK','ref_warehouserak');
        echo "{success: true}";
    }
    
    function rak_deleteRak()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('id', $data['id']);
           $this->db->delete('ref_warehouserak');
           $this->createLog('DELETE REFERENSI PENYIMPANAN RAK','ref_warehouserak');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    //MASTER PART NUMBER
    function part_number() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/part_number_view', $data);
        } else {
            $this->load->view('master/part_number_view');
        }
    }

    function partNumber_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Part_Number_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Part_Number_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
//			$total = $this->Unit_Kerja_Model->get_CountData();	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
//            echo '({results:' . json_encode($data) . '})';
        }
    }
    
    function partNumber_modifyPartNumber() {
        
        $data = array();
        
        $dataFields = array(
            'id','vendor_id','id_kelompok_part','part_number','kd_brg','merek','jenis','nama','part_number_substitusi','umur_maks'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->set($data);
        $this->db->replace('ref_perlengkapan');
        
        if($data['id'] != '')
        {
            $this->createLog('UPDATE REFERENSI PART','ref_perlengkapan');
        }
        else
        {
            $this->createLog('INSERT REFERENSI PART','ref_perlengkapan');
        }
        
        
        echo "{success: true}";
    }
    
    function partNumber_deletePartNumber()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('id', $data['id']);
           $this->db->delete('ref_perlengkapan');
           $this->createLog('DELETE REFERENSI PART','ref_perlengkapan');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
       
        echo json_encode($result);
    }
    
    function checkPartNumber()
    {

        $this->db->from('ref_perlengkapan');
        $this->db->where('part_number',$_POST['part_number']);
        $result = $this->db->get();
//        var_dump($this->db->last_query());
//        var_dump($result->num_rows());
//        var_dump($_POST);
//        die;

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    
    // KODE BARANG GOLONGAN
    function kd_brg_golongan() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/kd_brg_golongan_view', $data);
        } else {
            $this->load->view('master/kd_brg_golongan_view');
        }
    }

    function kd_brg_golongan_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Kd_Brg_Golongan_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Kd_Brg_Golongan_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function kd_brg_golongan_createKdBrgGolongan() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','ur_gol'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->set($data);
        $this->db->replace('ref_golongan');
        $this->createLog('INSERT REFERENSI KODE BARANG GOLONGAN','ref_golongan');
        echo "{success: true}";
    }
    
    function kd_brg_golongan_modifyKdBrgGolongan() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','ur_gol'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->where('kd_gol', $data['kd_gol']);
        unset($data['kd_gol']);
        $this->db->update('ref_golongan',$data);
         $this->createLog('UPDATE REFERENSI KODE BARANG GOLONGAN','ref_golongan');
        echo "{success: true}";
    }
    
    function kd_brg_golongan_deleteKdBrgGolongan()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('kd_gol', $data['id']);
           $this->db->delete('ref_golongan');
           $this->createLog('DELETE REFERENSI KODE BARANG GOLONGAN','ref_golongan');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function checkKdBrgGolongan()
    {

        $this->db->from('ref_golongan');
        $this->db->where('kd_gol',$_POST['kode']);
        $result = $this->db->get();

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    // KODE BARANG BIDANG
    function kd_brg_bidang() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/kd_brg_bidang_view', $data);
        } else {
            $this->load->view('master/kd_brg_bidang_view');
        }
    }

    function kd_brg_bidang_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Kd_Brg_Bidang_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Kd_Brg_Bidang_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function kd_brg_bidang_createKdBrgBidang() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','kd_bid','ur_bid'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        $data['kd_bidbrg'] = $data['kd_gol'].$data['kd_bid'];
        $this->db->set($data);
        $this->db->replace('ref_bidang');
        $this->createLog('INSERT REFERENSI KODE BARANG BIDANG','ref_bidang');
        echo "{success: true}";
    }
    
    function kd_brg_bidang_modifyKdBrgBidang() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','kd_bid','ur_bid'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->where('kd_gol', $data['kd_gol']);
        $this->db->where('kd_bid', $data['kd_bid']);
        unset($data['kd_gol'],$data['kd_bid']);
        $this->db->update('ref_bidang',$data);
         $this->createLog('UPDATE REFERENSI KODE BARANG BIDANG','ref_bidang');
        echo "{success: true}";
    }
    
    function kd_brg_bidang_deleteKdBrgBidang()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('kd_gol', $data['kd_gol']);
            $this->db->where('kd_bid', $data['kd_bid']);
           $this->db->delete('ref_bidang');
           $this->createLog('DELETE REFERENSI KODE BARANG BIDANG','ref_bidang');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function checkKdBrgBidang()
    {

        $this->db->from('ref_bidang');
        $this->db->where('kd_gol',$_POST['kd_gol']);
        $this->db->where('kd_bid',$_POST['kd_bid']);
        $result = $this->db->get();

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    // KODE BARANG KELOMPOK
    function kd_brg_kelompok() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/kd_brg_kelompok_view', $data);
        } else {
            $this->load->view('master/kd_brg_kelompok_view');
        }
    }

    function kd_brg_kelompok_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Kd_Brg_Kelompok_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Kd_Brg_Kelompok_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function kd_brg_kelompok_createKdBrgKelompok() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','kd_bid','kd_kel','ur_kel'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $data['kd_kelbrg'] = $data['kd_gol'].$data['kd_bid'].$data['kd_kel'];
        
        $this->db->set($data);
        $this->db->replace('ref_kel');
        $this->createLog('INSERT REFERENSI KODE BARANG KELOMPOK','ref_kel');
        echo "{success: true}";
    }
    
    function kd_brg_kelompok_modifyKdBrgKelompok() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','kd_bid','kd_kel','ur_kel'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->where('kd_gol', $data['kd_gol']);
        $this->db->where('kd_bid', $data['kd_bid']);
        $this->db->where('kd_kel', $data['kd_kel']);
        unset($data['kd_gol'],$data['kd_bid'],$data['kd_kel']);
        $this->db->update('ref_kel',$data);
         $this->createLog('UPDATE REFERENSI KODE BARANG KELOMPOK','ref_kel');
        echo "{success: true}";
    }
    
    function kd_brg_kelompok_deleteKdBrgKelompok()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('kd_gol', $data['kd_gol']);
           $this->db->where('kd_bid', $data['kd_bid']);
           $this->db->where('kd_kel', $data['kd_kel']);
           $this->db->delete('ref_kel');
           $this->createLog('DELETE REFERENSI KODE BARANG KELOMPOK','ref_kel');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function checkKdBrgKelompok()
    {

        $this->db->from('ref_kel');
        $this->db->where('kd_gol',$_POST['kd_gol']);
        $this->db->where('kd_bid',$_POST['kd_bid']);
        $this->db->where('kd_kel',$_POST['kd_kel']);
        $result = $this->db->get();

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    // KODE BARANG SUB KELOMPOK
    function kd_brg_subkelompok() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/kd_brg_subkelompok_view', $data);
        } else {
            $this->load->view('master/kd_brg_subkelompok_view');
        }
    }

    function kd_brg_subkelompok_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Kd_Brg_SubKelompok_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Kd_Brg_SubKelompok_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function kd_brg_subkelompok_createKdBrgSubKelompok() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','kd_bid','kd_kel','kd_skel','ur_skel'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $data['kd_skelbrg'] = $data['kd_gol'].$data['kd_bid'].$data['kd_kel'].$data['kd_skel'];
        
        $this->db->set($data);
        $this->db->replace('ref_subkel');
        $this->createLog('INSERT REFERENSI KODE BARANG SUB KELOMPOK','ref_subkel');
        echo "{success: true}";
    }
    
    function kd_brg_subkelompok_modifyKdBrgSubKelompok() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','kd_bid','kd_kel','kd_skel','ur_skel'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->where('kd_gol', $data['kd_gol']);
        $this->db->where('kd_bid', $data['kd_bid']);
        $this->db->where('kd_kel', $data['kd_kel']);
        $this->db->where('kd_skel', $data['kd_skel']);
        unset($data['kd_gol'],$data['kd_bid'],$data['kd_kel'],$data['kd_skel']);
        $this->db->update('ref_subkel',$data);
         $this->createLog('UPDATE REFERENSI KODE BARANG SUB KELOMPOK','ref_subkel');
        echo "{success: true}";
    }
    
    function kd_brg_subkelompok_deleteKdBrgSubKelompok()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('kd_gol', $data['kd_gol']);
           $this->db->where('kd_bid', $data['kd_bid']);
           $this->db->where('kd_kel', $data['kd_kel']);
           $this->db->where('kd_skel', $data['kd_skel']);
           $this->db->delete('ref_subkel');
           $this->createLog('DELETE REFERENSI KODE BARANG SUB KELOMPOK','ref_subkel');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function checkKdBrgSubKelompok()
    {

        $this->db->from('ref_subkel');
        $this->db->where('kd_gol',$_POST['kd_gol']);
        $this->db->where('kd_bid',$_POST['kd_bid']);
        $this->db->where('kd_kel',$_POST['kd_kel']);
        $this->db->where('kd_skel', $_POST['kd_skel']);
        $result = $this->db->get();

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    // KODE BARANG SUB SUB KELOMPOK
    function kd_brg_subsubkelompok() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/kd_brg_subsubkelompok_view', $data);
        } else {
            $this->load->view('master/kd_brg_subsubkelompok_view');
        }
    }

    function kd_brg_subsubkelompok_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Kd_Brg_SubSubKelompok_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Kd_Brg_SubSubKelompok_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function kd_brg_subsubkelompok_createKdBrgSubSubKelompok() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','kd_bid','kd_kel','kd_skel','kd_sskel','ur_sskel'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $data['kd_brg'] = $data['kd_gol'].$data['kd_bid'].$data['kd_kel'].$data['kd_skel'].$data['kd_sskel'];
        
        $this->db->set($data);
        $this->db->replace('ref_subsubkel');
        $this->createLog('INSERT REFERENSI KODE BARANG SUB SUB KELOMPOK','ref_subkel');
        echo "{success: true}";
    }
    
    function kd_brg_subsubkelompok_modifyKdBrgSubSubKelompok() {
        
        $data = array();
        
        $dataFields = array(
            'kd_gol','kd_bid','kd_kel','kd_skel','kd_sskel','ur_sskel'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        $this->db->where('kd_gol', $data['kd_gol']);
        $this->db->where('kd_bid', $data['kd_bid']);
        $this->db->where('kd_kel', $data['kd_kel']);
        $this->db->where('kd_skel', $data['kd_skel']);
        $this->db->where('kd_sskel', $data['kd_sskel']);
        unset($data['kd_gol'],$data['kd_bid'],$data['kd_kel'],$data['kd_skel'],$data['kd_sskel']);
        $this->db->update('ref_subsubkel',$data);
        $this->createLog('UPDATE REFERENSI KODE BARANG SUB SUB KELOMPOK','ref_subsubkel');
        echo "{success: true}";
    }
    
    function kd_brg_subsubkelompok_deleteKdBrgSubSubKelompok()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('kd_gol', $data['kd_gol']);
           $this->db->where('kd_bid', $data['kd_bid']);
           $this->db->where('kd_kel', $data['kd_kel']);
           $this->db->where('kd_skel', $data['kd_skel']);
           $this->db->where('kd_sskel', $data['kd_sskel']);
           $this->db->delete('ref_subsubkel');
           $this->createLog('DELETE REFERENSI KODE BARANG SUB SUB KELOMPOK','ref_subsubkel');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function checkKdBrgSubSubKelompok()
    {

        $this->db->from('ref_subsubkel');
        $this->db->where('kd_gol',$_POST['kd_gol']);
        $this->db->where('kd_bid',$_POST['kd_bid']);
        $this->db->where('kd_kel',$_POST['kd_kel']);
        $this->db->where('kd_skel', $_POST['kd_skel']);
        $this->db->where('kd_sskel', $_POST['kd_sskel']);
        $result = $this->db->get();

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    //MASTER KELOMPOK PART
      function kelompok_part() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/kelompok_part_view', $data);
        } else {
            $this->load->view('master/kelompok_part_view');
        }
    }
    
    function kelompok_part_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Kelompok_Part_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Kelompok_Part_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
            echo '({total:'. $total . ',results:'.json_encode($data).'})';
        }
    }
    
    function kelompok_part_createKelompokPart() {
        
        $data = array();
        
        $dataFields = array(
            'id','nama_kelompok','jenis_asset'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        
        $this->db->set($data);
        $this->db->replace('ref_kelompok_part');
        $this->createLog('INSERT REFERENSI KELOMPOK PART','ref_kelompok_part');
        echo "{success: true}";
    }
    
    function kelompok_part_modifyKelompokPart() {
        
        $data = array();
        
        $dataFields = array(
            'id','nama_kelompok','jenis_asset'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        $this->db->where('id', $data['id']);
        unset($data['id']);
        $this->db->update('ref_kelompok_part',$data);
        $this->createLog('UPDATE REFERENSI KELOMPOK PART','ref_kelompok_part');
        echo "{success: true}";
    }
    
    function kelompok_part_deleteKelompokPart()
    {
       $deletedData = $this->input->post('data');

       foreach ($deletedData as $data)
       {
           $this->db->where('id', $data['id']);
           $this->db->delete('ref_kelompok_part');
           $this->createLog('DELETE REFERENSI KELOMPOK PART','ref_kelompok_part');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    //MASTER REFERENSI RUANG
    function referensi_ruang() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $this->load->view('master/referensi_ruang_view', $data);
        } else {
            $this->load->view('master/referensi_ruang_view');
        }
    }

    function referensi_ruang_getAllData() {
        if ($this->input->get_post("id_open")) {
//            $resultData = $this->Referensi_Ruang_Model->get_AllData($this->input->post("start"),$this->input->post("limit"));
            $resultData = $this->getDataWithFilter('Referensi_Ruang_Model');
            $data = $resultData['data'];
            $total = $resultData['count'];	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
//            echo '({results:' . json_encode($data) . '})';
        }
    }
    
    function referensi_ruang_createReferensiRuang() {
        
        $data = array();
        
        $dataFields = array(
            'kd_lokasi','kode_unor','kd_ruang','ur_ruang'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        $this->db->set($data);
        $this->db->replace('ref_ruang');
        $this->createLog('INSERT REFERENSI RUANG','ref_ruang');
        echo "{success: true}";
    }
    
    function referensi_ruang_modifyReferensiRuang() {
        
        $data = array();
        
        $dataFields = array(
             'kd_lokasi','kode_unor','kd_ruang','ur_ruang'
        );
        
        foreach ($dataFields as $field) {
            $data[$field] = $this->input->post($field);
        }
        
        
        $this->db->where('kd_lokasi', $data['kd_lokasi']);
        $this->db->where('kd_ruang', $data['kd_ruang']);
        unset($data['kd_lokasi'],$data['kd_ruang']);
        $this->db->update('ref_ruang',$data);
        $this->createLog('UPDATE REFERENSI RUANG','ref_ruang');
        echo "{success: true}";
    }
    
    
    function referensi_ruang_deleteReferensiRuang()
    {
       $deletedData = $this->input->post('data');
       foreach ($deletedData as $data)
       {
           $this->db->where('kd_lokasi', $data['kd_lokasi']);
           $this->db->where('kd_ruang', $data['kd_ruang']);
           $this->db->delete('ref_ruang');
           $this->createLog('DELETE REFERENSI RUANG','ref_ruang');
       }
       
       $result = array('fail' => false,
                       'success'=>true);
						
        echo json_encode($result);
    }
    
    function checkReferensiRuang()
    {

        $this->db->from('ref_ruang');
        $this->db->where('kd_lokasi',$_POST['kd_lokasi']);
        $this->db->where('kd_ruang',$_POST['kd_ruang']);
        $result = $this->db->get();

        if($result->num_rows() === 1)
        {
            
            if($_POST['edit'] == 'true')
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
            
        }
        else if ($result->num_rows() === 0)
        {
            
            echo "true";
        }
        else 
        {
            echo "false";
        }
    }
    
    private function getDataWithFilter($model_name)
    {
        $filterString = null;
        $searchByField = null;
        if(isset($_POST['gridFilter']))
        {
            $filterString = $this->generateFilterQueryString($_POST['gridFilter']);
        }
        if(isset($_POST['search']))
        {
            //$this->model->get_FilteredData(json_decode($_POST['filter']));
            $searchByField = $_POST['search'];
        }
        
        if(isset($_POST['start']) && isset($_POST['limit']))
        {
            $start = $_POST['start'];
            $limit = $_POST['limit'];
        }
                
        $queryData = $this->$model_name->get_AllData($start,$limit,$filterString,$searchByField);
        
        return $queryData;
    }

}

?>