<?php

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if ($this->my_usession->logged_in) {
            $data['title'] = 'USER INDEX';
            redirect(base_url() . 'dashboard');
        } else {
            $data['title'] = 'LOGIN PENGGUNA';
            $this->load->view('login', $data);
        }
    }

    function ext_logout() {
        $this->my_usession->unset_userdata("iduser_zs_simpeg");
        $this->my_usession->unset_userdata("user_zs_simpeg");
        $this->my_usession->unset_userdata("fullname_zs_simpeg");
        $this->my_usession->unset_userdata("type_zs_simpeg");
        $this->my_usession->unset_userdata("nip_zs_simpeg");     
        //$this->my_usession->unset_userdata("nama_unker_zs_simpeg");
        //$this->my_usession->unset_userdata("kode_unker_zs_simpeg");
        //$this->my_usession->unset_userdata("a_kode_unker_zs_simpeg");
        
        echo "{success:true}";
    }

    function ext_login() {
        $cond = array(
            'user' => $this->input->post('username'),
            'pass' => md5($this->input->post('password')) 
        );
        $query = $this->db->get_where('tuser', $cond, 1);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->my_usession->set_userdata('iduser_zs_simpeg', $row->ID_User);
            $this->my_usession->set_userdata('user_zs_simpeg', $row->user);
            $this->my_usession->set_userdata('fullname_zs_simpeg', $row->fullname);
            $this->my_usession->set_userdata('type_zs_simpeg', $row->type);
            $this->my_usession->set_userdata('nip_zs_simpeg', $row->NIP);
            //$this->my_usession->set_userdata('nama_unker_zs_simpeg', $row->nama_unker);
            $iduserok = $row->ID_User;
            $this->db->query("UPDATE tuser SET lastvisitDate=NOW() WHERE ID_User='" . $iduserok . "'");

//            $data_pwg = $this->getPegawai($row->NIP);
//            if (count($data_pwg)) {
//                $kode_unker = $data_pwg['kode_unker'];
//                $this->my_usession->set_userdata('kode_unker_zs_simpeg', $kode_unker);
//
//                // Mendapatkan Kode Unker Secara Bertingkat
//                $data1 = array();
//                $data2 = array();
//                $a_kode_unker = array();
//
//                // Level 1
//                $this->db->select('kode_unker');
//                $this->db->from("tRef_UnitKerja");
//                $this->db->where('kode_uki', $kode_unker);
//                $Q1 = $this->db->get('');
//                if ($Q1->num_rows() > 0) {
//                    foreach ($Q1->result_array() as $row1) {
//                        $a_kode_unker[] = $row1['kode_unker'];
//
//                        // Level 2
//                        $this->db->select('kode_unker');
//                        $this->db->from("tRef_UnitKerja");
//                        $this->db->where('kode_uki', $row1['kode_unker']);
//                        $Q2 = $this->db->get('');
//                        if ($Q2->num_rows() > 0) {
//                            foreach ($Q2->result_array() as $row2) {
//                                $a_kode_unker[] = $row2['kode_unker'];
//                            }
//                        }
//                        $Q2->free_result();
//                    }
//                }
//                $Q1->free_result();
//
//                $a_temp = implode(",", array_merge(array($kode_unker), $a_kode_unker));
//                $this->my_usession->set_userdata('a_kode_unker_zs_simpeg', $a_temp);
//            }
//            echo "{success:true}";
        } else {
            echo "{success:false, errors: { reason: 'Pengguna atau Kata Sandi tidak benar !' }}";
        }
    }

    function getPegawai($NIP = 0) {
        $data = array();
        $options = array('NIP' => $NIP);
        $Q = $this->db->get_where('tView_Pegawai_Biodata', $options, 1);
        if ($Q->num_rows() > 0) {
            $data = $Q->row_array();
        }
        $Q->free_result();
        $this->db->close();
        return $data;
    }

    // AKSES MENU --------------------------------------------- START
    function change_bool($val = 0) {
        if ($val == 1) {
            return 'true';
        } elseif ($val == 0) {
            return 'false';
        } else {
            return $val;
        }
    }

    function get_var_access() {
        $data = array();
        $sesi_iduser = $this->session->userdata("iduser_zs_simpeg");

        $option = array('ID_User' => $sesi_iduser);
        $Q = $this->db->get_where('tView_Menu', $option);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function set_var_access() {
        if ($this->input->post("id_open")) {
            $data['jsscript'] = TRUE;
            $data['var_menu'] = $this->get_var_access();
            $this->load->view('akses_menu_variabel', $data);
        } else {
            $this->load->view('akses_menu_variabel');
        }
    }

    // AKSES MENU --------------------------------------------- END
}

?>