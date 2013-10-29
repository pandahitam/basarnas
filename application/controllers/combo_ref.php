<?php

class Combo_Ref extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->my_usession->logged_in == FALSE) {
            echo "window.location = '" . base_url() . "user/index';";
            exit;
        }
    }

    function index() {
        echo '';
    }

    function combo_allasset() {
        $data = array();

        $query = $this->db->query('(SELECT t.kd_brg, t.kd_lokasi,t.no_aset, b.ur_sskel as nama FROM `asset_alatbesar` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LIMIT 0,100)
                                        UNION
                                        (SELECT t.kd_brg, t.kd_lokasi,t.no_aset, b.ur_sskel FROM `asset_angkutan` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LIMIT 0,100)
                                        UNION
                                        (SELECT t.kd_brg, t.kd_lokasi,t.no_aset, b.ur_sskel  FROM `asset_bangunan` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LIMIT 0,100)
                                        UNION
                                        (SELECT t.kd_brg, t.kd_lokasi,t.no_aset, b.ur_sskel FROM `asset_perairan` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LIMIT 0,100)
                                        UNION
                                        (SELECT t.kd_brg, t.kd_lokasi,t.no_aset, b.ur_sskel FROM `asset_senjata` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LIMIT 0,100)
                                        UNION
                                        (SELECT t.kd_brg, t.kd_lokasi,t.no_aset, b.ur_sskel  FROM `asset_tanah` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LIMIT 0,100)
                                        ');

        foreach ($query->result() as $obj) {
            $data[] = $obj;
        }

        echo json_encode($data);
    }
    
    function combo_asset_perlengkapan_part()
    {
        $data = array();
        if($this->input->get_post("id_open"))
        {
            $query = "select id, part_number, serial_number from asset_perlengkapan 
                      where warehouse_id > 0 and ruang_id > 0";
            if($_POST['id_open'] == 2)
            {
                $query = 'select id, part_number, serial_number from asset_perlengkapan';
            }
            
            $query_data = $this->db->query($query);
            
            
            foreach($query_data->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }
    
    function combo_parts_inventory_pengeluaran()
    {
        $data = array();
        if($this->input->get_post("id_open"))
        {
//            if($this->input->get_post("excludedValue"))
//            {
//                $excludedValue = $this->input->post('excludedValue');
//                $query = $this->db->query("select id, nomor_berita_acara from inventory_penyimpanan where id=$excludedValue");
//            }
//            else
//            {
//                 $query = $this->db->query('select id, nomor_berita_acara from inventory_penyimpanan where qty > 0');
//            }
            
           
            if($this->input->get_post("id_penyimpanan"))
            {
                if($this->input->get_post("excluded_id_penyimpanan_data_perlengkapan") != '')
                {
                     $query = $this->db->query('select t.id, a.nama from inventory_penyimpanan_data_perlengkapan as t LEFT JOIN ref_perlengkapan as a on t.part_number = a.part_number where id_source='.$this->input->get_post("id_penyimpanan").' AND t.id NOT IN('.$this->input->get_post("excluded_id_penyimpanan_data_perlengkapan").')');
                }
                else
                {
                    $query = $this->db->query('select t.id, a.nama from inventory_penyimpanan_data_perlengkapan as t LEFT JOIN ref_perlengkapan as a on t.part_number = a.part_number where id_source='.$this->input->get_post("id_penyimpanan"));
                }
                
            }
            else
            {
                 $query = $this->db->query('select t.id, a.nama  from inventory_penyimpanan_data_perlengkapan as t LEFT JOIN ref_perlengkapan as a on t.part_number = a.part_number');
            }
            
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }
    
    function combo_penyimpanan()
    {
        $data = array();
        if($this->input->get_post("id_open"))
        {
//            if($this->input->get_post("excludedValue"))
//            {
//                $excludedValue = $this->input->post('excludedValue');
//                $query = $this->db->query("select id, nomor_berita_acara from inventory_penyimpanan where id=$excludedValue");
//            }
//            else
//            {
//                 $query = $this->db->query('select id, nomor_berita_acara from inventory_penyimpanan where qty > 0');
//            }
            
            $query = $this->db->query('select id, nomor_berita_acara from inventory_penyimpanan');
            
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }
    
    function combo_penerimaan_pemeriksaan()
    {
        $data = array();
        if($this->input->get_post("id_open"))
        {
            if($this->input->get_post("excludedValue"))
            {
                $excludedValue = $this->input->post('excludedValue');
                $query = $this->db->query("select id, nomor_berita_acara from inventory_penerimaan_pemeriksaan where id NOT IN(select id_penerimaan_pemeriksaan from inventory_penyimpanan where id_penerimaan_pemeriksaan NOT LIKE '$excludedValue') ");
            }
            else
            {
                 $query = $this->db->query('select id, nomor_berita_acara from inventory_penerimaan_pemeriksaan where id NOT IN(select id_penerimaan_pemeriksaan from inventory_penyimpanan)');
            }
            
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }
    
    function combo_penerimaan()
    {
        $data = array();
        if($this->input->get_post("id_open"))
        {
            if($this->input->get_post("excludedValue"))
            {
                $excludedValue = $this->input->post('excludedValue');
                $query = $this->db->query("select id, nomor_berita_acara from inventory_penerimaan where id NOT IN(select id_penerimaan from inventory_pemeriksaan where id_penerimaan NOT LIKE '$excludedValue') ");
            }
            else
            {
                 $query = $this->db->query('select id, nomor_berita_acara from inventory_penerimaan where id NOT IN(select id_penerimaan from inventory_pemeriksaan)');
            }
            
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }
    
    function combo_pengadaan()
    {
        $data = array();
//        $spesial_pengadaan = ($this->input->get_post("filterdatapengadaan") ? true : false);
//        if($this->input->get_post("id_open"))
//        {
//            $query = $this->db->query('select id, no_sppa from pengadaan');
//            foreach($query->result() as $obj)
//            {
//                if($spesial_pengadaan){
//                    $query_check = $this->db->query("select * from inventory_penerimaan_pemeriksaan where id_pengadaan=".$obj->id);
//                    $result_check = $query_check->result();
//                    if(count($result_check) > 0){
//                        //do something...
//                    }else{
//                        $data[] = $obj;
//                    }
//                }else{
//                    $data[] = $obj;
//                }
//            }
        //            echo json_encode($data);
//        }
        
        if($this->input->get_post("id_open"))
        {
            //$query = $this->db->query('select id, no_sppa from pengadaan');
            $query = $this->db->query('select id, no_sppa from pengadaan where id not in (select id_pengadaan from inventory_penerimaan_pemeriksaan)');
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }


    }
    
    function combo_klasifikasiAset_lvl1()
    {
        $data = array();
        if($this->input->get_post("id_open"))
        {
            $query = $this->db->query('select kd_lvl1, nama from ref_klasifikasiaset_lvl1');
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }
    
    function combo_klasifikasiAset_lvl2()
    {
        $data = array();
        if($this->input->get_post("id_open"))
        {
            $kd_lvl1 = $this->input->get_post("kd_lvl1");
            $query = $this->db->query("select kd_lvl2, nama from ref_klasifikasiaset_lvl2 where kd_lvl1 =$kd_lvl1");
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
//            $this->db->select('kd_lvl2,nama');
//            $this->db->from('ref_klasifikasiaset_lvl2');
//
//            if ($this->input->get_post('query')) {
//                $this->db->like('nama', $this->input->get_post('query'));
//            }
//
//            if ($this->input->post('kd_lvl1') > 0) {
//                $this->db->where('kd_lvl1', $this->input->post('kd_lvl1'));
//            }
//
//            $this->db->order_by('nama', 'ASC');
//            $Q = $this->db->get('');
//            foreach ($Q->result() as $obj) {
//                $data[] = $obj;
//            }
//
//            echo json_encode($data);
        }
    }
    
    function combo_klasifikasiAset_lvl3()
    {
        $data = array();
        if($this->input->get_post("id_open"))
        {
            $kd_lvl1 = $this->input->get_post("kd_lvl1");
            $kd_lvl2 = $this->input->get_post("kd_lvl2");
            $query = $this->db->query("select kd_lvl3, nama from ref_klasifikasiaset_lvl3 where kd_lvl1 =$kd_lvl1 and kd_lvl2 = $kd_lvl2");
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
//            $this->db->select('kd_lvl3,nama');
//            $this->db->from('ref_klasifikasiaset_lvl3');
//
//            if ($this->input->get_post('query')) {
//                $this->db->like('nama', $this->input->get_post('query'));
//            }
//
//            if ($this->input->post('kd_lvl1') > 0 && $this->input->post('kd_lvl2') > 0) {
//                $this->db->where('kd_lvl1', $this->input->post('kd_lvl1'));
//                $this->db->where('kd_lvl2', $this->input->post('kd_lvl2'));
//            }
//
//            $this->db->order_by('nama', 'ASC');
//            $Q = $this->db->get('');
//            foreach ($Q->result() as $obj) {
//                $data[] = $obj;
//            }
//
//            echo json_encode($data);
        }
    }
    
    function combo_warehouse(){
    
        $data = array();
        if($this->input->get_post("id_open"))
        {
            $query = $this->db->query('select id, nama from ref_warehouse');
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }
    
    function combo_warehouseRuang(){
    
        $data = array();
        if($this->input->get_post("id_open"))
        {
            $id_warehouse = $this->input->get_post("warehouse_id");
            if($id_warehouse != '')
            {
                 $query = $this->db->query("select id, nama from ref_warehouseruang where warehouse_id = $id_warehouse");
                foreach($query->result() as $obj)
                {
                    $data[] = $obj;
                }

                echo json_encode($data);
            }
           
        }
    }
    
    function combo_warehouseRak(){
    
        $data = array();
        if($this->input->get_post("id_open"))
        {
            $id_warehouseruang = $this->input->get_post("warehouseruang_id");
            $query = $this->db->query("select id, nama from ref_warehouserak where warehouseruang_id = $id_warehouseruang");
            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }
    
    function combo_partNumber(){
        $data = array();
        if($this->input->get_post("id_open"))
        {
            $query = $this->db->query('Select part_number,kd_brg,nama from ref_perlengkapan');

            foreach($query->result() as $obj)
            {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }

    function combo_prov() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_prov', $this->input->get_post('query'));
            }
            $this->db->select('kode_prov,nama_prov');
            $this->db->from('tRef_Provinsi');
            $this->db->order_by('kode_prov', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_kabkota() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('kode_kabkota,nama_kabkota,ID_KK');
            $this->db->from('tRef_KabKota');

            if ($this->input->post('query')) {
                $this->db->like('nama_kabkota', $this->input->post('query'));
            }


            if ($this->input->post('kode_prov') != NULL) {
                $this->db->where_in('kode_prov', array($this->input->post('kode_prov'), 0));
            }

            $this->db->order_by('kode_kabkota', 'ASC');

            $Q = $this->db->get('');

            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_kec() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('kode_kec,nama_kec');
            $this->db->from('tRef_Kecamatan');
            if ($this->input->post('query')) {
                $this->db->like('nama_kec', $this->input->post('query'));
            }
            $this->db->where_in('kode_kabkota', array($this->input->post('kode_kabkota'), 0));
            $this->db->order_by('kode_kec', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_assetgolongan() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('*');
            $this->db->from('ref_golongan');

            if ($this->input->get_post('query')) {
                $this->db->like('ur_gol', $this->input->get_post('query'));
            }

            $this->db->order_by('ur_gol', 'ASC');
            $this->db->group_by('kd_gol');
            $Q = $this->db->get('');

            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }

    function combo_assetbidang() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('kd_bid,ur_bid');
            $this->db->from('ref_bidang');

            if ($this->input->get_post('query')) {
                $this->db->like('ur_bid', $this->input->get_post('query'));
            }

            if ($this->input->post('kd_gol') > 0) {
                $this->db->where('kd_gol', $this->input->post('kd_gol'));
            }
            
            if($this->input->get_post('excludeBidang'))
            {
                $this->db->where_not_in('kd_bid',$this->input->post('excludeBidang'));
            }

            $this->db->order_by('ur_bid', 'ASC');
            $this->db->group_by('kd_bid');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }

    function combo_kelompok() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('kd_kel,ur_kel');
            $this->db->from('ref_kel');

            if ($this->input->get_post('query')) {
                $this->db->like('ur_kel', $this->input->get_post('query'));
            }

            if ($this->input->post('kd_gol') > 0 && $this->input->post('kd_bid') > 0) {
                $this->db->where('kd_gol', $this->input->post('kd_gol'));
                $this->db->where('kd_bid', $this->input->post('kd_bid'));
            }

            $this->db->order_by('ur_kel', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }

    function combo_subKelompok() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('kd_skel,ur_skel');
            $this->db->from('ref_subkel');

            if ($this->input->get_post('query')) {
                $this->db->like('ur_skel', $this->input->get_post('query'));
            }

            if ($this->input->post('kd_gol') > 0 && $this->input->post('kd_bid') > 0 && $this->input->post('kd_kel') > 0) {
                $this->db->where('kd_gol', $this->input->post('kd_gol'));
                $this->db->where('kd_bid', $this->input->post('kd_bid'));
                $this->db->where('kd_kel', $this->input->post('kd_kel'));
            }

            $this->db->order_by('ur_skel', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }

    function combo_subsubKelompok() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('kd_sskel,ur_sskel');
            $this->db->from('ref_subsubkel');

            if ($this->input->get_post('query')) {
                $this->db->like('ur_sskel', $this->input->get_post('query'));
            }

            if ($this->input->post('kd_gol') > 0) {
                $this->db->where('kd_gol', $this->input->post('kd_gol'));
            }

            if ($this->input->post('kd_bid') > 0) {
                $this->db->where('kd_bid', $this->input->post('kd_bid'));
            }

            if ($this->input->post('kd_kel') > 0) {
                $this->db->where('kd_kel', $this->input->post('kd_kel'));
            }

            if ($this->input->post('kd_skel') > 0) {
                $this->db->where('kd_skel', $this->input->post('kd_skel'));
            }

            $this->db->order_by('ur_sskel', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }

    function combo_wilayah() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('*');
            $this->db->from('ref_wilayah');

            if ($this->input->get_post('query')) {
                $this->db->like('ur_wilayah', $this->input->get_post('query'));
            }

            $this->db->order_by('ur_upb', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }

    function combo_simak_unker() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('ur_upb,kdlok');
            $this->db->from('ref_unker');

            if ($this->input->get_post('query')) {
                $this->db->like('ur_upb', $this->input->get_post('query'));
            }

            $this->db->order_by('ur_upb', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }

    function combo_unor() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('nama_unor,kode_unor,kd_lokasi');
            $this->db->from('ref_unor');

            if ($this->input->get_post('query')) {
                $this->db->like('jabatan_unor', $this->input->get_post('query'));
            }

            if ($this->input->post('kd_lokasi') > 0) {
                $this->db->where('kd_lokasi', $this->input->post('kd_lokasi'));
            }

            $this->db->order_by('nama_unor', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }

            echo json_encode($data);
        }
    }

    function combo_ruang() {
        $data = array();
        $this->db->select('ur_ruang,kd_ruang');
        $this->db->from('ref_ruang');


        if ($this->input->post('kd_lokasi') > 0) {
            $this->db->where('kd_lokasi', $this->input->post('kd_lokasi'));
        }

        $this->db->order_by('ur_ruang', 'ASC');
        $Q = $this->db->get('');

        foreach ($Q->result() as $obj) {
            $data[] = $obj;
        }

        echo json_encode($data); 
    }

    function combo_jns_unit_kerja() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->where('kode_jns_unker !=', 0);
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

    function combo_unit_kerja() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('*');
            $this->db->from('ref_unitkerja');
            if ($this->input->get_post('query')) {
                $this->db->like('nama_unker', $this->input->get_post('query'));
            }
            $this->db->where('status_data', 1);
            $this->db->order_by('kode_uki', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_induk_unit_kerja() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_unker', $this->input->get_post('query'));
            }
            $this->db->select('kode_unker AS kode_uki,nama_unker AS nama_uki');
            $this->db->from('tRef_UnitKerja');
            $this->db->where('status_data', 1);
            $this->db->where_in("LEFT(kode_jns_unker,1)", array(0, 1, 2, 3, 5));
            $this->db->order_by('kode_unker', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_atasan_unor() {
        if ($this->input->get_post("id_open")) {
            $kode_eselon = ($this->input->post('kode_eselon') > 0) ? (int) $this->input->post('kode_eselon') - 1 : 0;
            $data = array();
            $data_empty = array('kode_unor' => '', 'jabatan_unor' => '-');
            $this->db->select('kode_unor,jabatan_unor');
            $this->db->from('ref_unitorganisasi');

            $kode_unker = $this->input->post('kode_unker');

            if ($this->input->post('kode_unker') > 0) {
                $this->db->where('kode_unker', $this->input->post('kode_unker'));
            }

            $this->db->where('kode_eselon <=', $kode_eselon);

            $this->db->order_by('urut_unor', 'ASC');

            $Q = $this->db->get('');

            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            if (count($data)) {
                echo json_encode($data);
            } else {
                echo json_encode($data_empty);
            }
        }
    }

    function combo_jns_jabatan() {
        if ($this->input->get_post("id_open")) {
            $this->db->where('kode_jenis_jab !=', 0);
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
            $this->db->where('kode_jpeg', $this->input->post("kode_jpeg"));
            $this->db->order_by('kode_golru', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function get_nama_golru() {
        $nama_golru = "";
        $data = array();
        $Q = $this->db->get_where("tRef_Golru", array('kode_golru' => $this->input->post('kode_golru'), 'kode_jpeg' => $this->input->post('kode_jpeg')), 1);
        if ($Q->num_rows() > 0) {
            $data = $Q->row_array();
            $nama_golru = $data['nama_golru'];
        }
        $Q->free_result();
        $this->db->close();
        echo $nama_golru;
    }

    function combo_klp_jabatan() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('kode_klp_jab,klp_jab');
            $this->db->from('tRef_Jabatan_Klpk');
            $this->db->where('kode_klp_jab !=', 0);
            if ($this->input->get_post('query')) {
                $this->db->like('klp_jab', $this->input->get_post('query'));
            }
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
            $this->db->select('ID_Jab,kode_jab,nama_jab,kode_eselon');
            $this->db->from('tRef_Jabatan');
            if ($this->input->get_post('query')) {
                $this->db->like('nama_jab', $this->input->get_post('query'));
            }
            $this->db->order_by('kode_jab', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_eselon_2() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->select('kode_eselon,nama_eselon');
            $this->db->from('tRef_Eselon');
            if ($this->input->get_post('query')) {
                $this->db->like('nama_eselon', $this->input->get_post('query'));
            }
            $this->db->where_in('kode_eselon', array(11, 12, 21, 22, 31, 32, 41, 42));
            $this->db->order_by('kode_eselon', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_jenis_diklat() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            $this->db->where('kode_jns_diklat !=', 0);
            if ($this->input->get_post('query')) {
                $this->db->like('jns_diklat', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Diklat_Jns');
            $this->db->order_by('kode_jns_diklat', 'ASC');
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
            $this->db->select('*');
            $this->db->from('tRef_HukDis_Tkt');
            $this->db->where('kode_tkt_hukdis !=', 0);
            if ($this->input->get_post('query')) {
                $this->db->like('tkt_hukdis', $this->input->get_post('query'));
            }
            $this->db->order_by('kode_tkt_hukdis', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_jenjang_pendidikan() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_jenjang_pddk', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Pendidikan_Jenjang');
            $this->db->order_by('kode_jenjang_pddk', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_pendidikan() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_pddk', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Pendidikan');
            $this->db->join('tRef_Pendidikan_Jenjang', 'tRef_Pendidikan.kode_jenjang_pddk = tRef_Pendidikan_Jenjang.kode_jenjang_pddk');
            $this->db->order_by('kode_pddk', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_jns_pgw() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('jenis_pegawai', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Jns_Pgw');
            $this->db->order_by('kode_jpeg', 'ASC');
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

    function combo_dupeg_2() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_dupeg', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Dupeg');
            $this->db->where('kode_dupeg !=', 0);
            $this->db->order_by('kode_dupeg', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_sumber_dana() {
        if ($this->input->get_post("id_open")) {
            $data = array();
            if ($this->input->get_post('query')) {
                $this->db->like('nama_sumber_dana', $this->input->get_post('query'));
            }
            $this->db->select('*');
            $this->db->from('tRef_Sumber_Dana');
            $this->db->order_by('kode_sumber_dana', 'ASC');
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
            $this->db->order_by('nama_pekerjaan', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_pp_gapok() {
        if ($this->input->post("id_open")) {
            $data = array();
            $this->db->select('*');
            $this->db->from('tRef_Gapok_PP');
            if (!$this->input->post('status_data')) {
                $this->db->where('status_data', 1);
            }
            if ($this->input->get_post('query')) {
                $this->db->like('nama_pp', $this->input->get_post('query'));
            }
            $this->db->order_by('nama_pp', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_fung() {
        if ($this->input->post("id_open")) {
            $data = array();
            $this->db->select('*');
            $this->db->from('tRef_Fungsional');
            $this->db->where('status_data', 1);
            if ($this->input->get_post('query')) {
                $this->db->like('nama_fung', $this->input->get_post('query'));
            }
            $this->db->order_by('nama_fung', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_jns_pensiun() {
        if ($this->input->post("id_open")) {
            $data = array();
            $this->db->select('ID_PJ,kode_jns_pensiun,jns_pensiun');
            $this->db->from('tRef_Pensiun_Jns');
            $this->db->where('status_data', 1);
            if ($this->input->get_post('query')) {
                $this->db->like('jns_pensiun', $this->input->get_post('query'));
            }
            $this->db->order_by('kode_jns_pensiun', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function combo_ket_berhenti() {
        if ($this->input->post("id_open")) {
            $data = array();
            $this->db->select('ID_KB,kode_ket_berhenti,ket_berhenti');
            $this->db->from('tRef_Ket_Berhenti');
            $this->db->where('status_data', 1);
            if ($this->input->get_post('query')) {
                $this->db->like('ket_berhenti', $this->input->get_post('query'));
            }
            $this->db->order_by('kode_ket_berhenti', 'ASC');
            $Q = $this->db->get('');
            foreach ($Q->result() as $obj) {
                $data[] = $obj;
            }
            echo json_encode($data);
        }
    }

    function get_golru_pengabdian() {
        if ($this->input->post("id_open")) {
            $data = array();
            $data_temp = array();
            $level = 0;
            $Q = $this->db->get_where("tRef_Golru", array('kode_golru' => $this->input->post('kode_golru'), 'kode_jpeg' => $this->input->post('kode_jpeg')), 1);
            if ($Q->num_rows() > 0) {
                $data_temp = $Q->row_array();
                $level = $data_temp['level'] + 1;
            }
            $Q->free_result();

            $Q = $this->db->get_where("tRef_Golru", array('level' => $level, 'kode_jpeg' => $this->input->post('kode_jpeg')), 1);
            if ($Q->num_rows() > 0) {
                $data = $Q->row_array();
            }
            $Q->free_result();
            $this->db->close();
            echo '({results:' . json_encode($data) . '})';
        }
    }

    function get_tmt_pensiun() {
        if ($this->input->post("id_open") && $this->input->post("NIP")) {
            $data_temp = array();
            $nama_dupeg = '';
            $TMT_pensiun = '';
            $Q = $this->db->get_where("tView_Pegawai_Biodata", array('NIP' => $this->input->post('NIP')), 1);
            if ($Q->num_rows() > 0) {
                $data_temp = $Q->row_array();
                $nama_dupeg = $data_temp['nama_dupeg'];
                $TMT_pensiun = $data_temp['TMT_BUP'];
            }
            $Q->free_result();

            if ($nama_dupeg == 'Meninggal') {
                $Q = $this->db->get_where("tTrans_Duka_Cita", array('NIP' => $this->input->post('NIP')), 1);
                if ($Q->num_rows() > 0) {
                    $data_temp = $Q->row_array();
                    $OneMonthAdded = date("Y-m", strtotime('+1 month', strtotime($data_temp['tgl_dc'])));
                    $TMT_pensiun = date('Y-m-d', strtotime($OneMonthAdded . '-01'));
                }
                $Q->free_result();
            }
            $this->db->close();
            echo $TMT_pensiun;
        }
    }

    function get_golru_up_level() {
        if ($this->input->post("id_open")) {
            $data = array();
            $data_temp = array();
            $level = 0;
            $Q = $this->db->get_where("tRef_Golru", array('kode_golru' => $this->input->post('kode_golru')), 1);
            if ($Q->num_rows() > 0) {
                $data_temp = $Q->row_array();
                $level = $data_temp['level'] + 1;
            }
            $Q->free_result();

            $Q = $this->db->get_where("tRef_Golru", array('level' => $level), 1);
            if ($Q->num_rows() > 0) {
                $data = $Q->row_array();
            }
            $Q->free_result();
            $this->db->close();
            echo '({results:' . json_encode($data) . '})';
        }
    }

    function get_kepala_bkppd() {
        if ($this->input->post("id_open")) {
            $data = array();
            $this->db->select("NIP, f_namalengkap, kode_unor, kode_jab");
            $this->db->from("tView_Pegawai_Browse");
            $this->db->where("kode_dupeg", 1);
            $this->db->where("kode_unor", 420);
            $this->db->limit(1);
            $Q = $this->db->get();
            if ($Q->num_rows() > 0) {
                $data = $Q->row_array();
            }
            $Q->free_result();
            $this->db->close();
            echo '({results:' . json_encode($data) . '})';
        }
    }

    function get_jns_fung() {
        $jns_fung = "";
        $data = array();
        $Q = $this->db->get_where("tRef_Fungsional", array('kode_fung' => $this->input->post('kode_fung')), 1);
        if ($Q->num_rows() > 0) {
            $data = $Q->row_array();
            $jns_fung = $data['jns_fung'];
        }
        $Q->free_result();
        $this->db->close();
        echo $jns_fung;
    }

}

?>