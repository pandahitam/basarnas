<?php

class asset_master extends CI_Controller {
    
    function __construct() {
            parent::__construct();
            if ($this->my_usession->logged_in == FALSE){
                    echo "window.location = '".base_url()."user/index';";
                    exit;
            }
            
            $this->load->model('master_model','',TRUE);
            $this->model = $this->master_model;
    }
    
    function index(){echo '';}
    
    function allAsset()
    {
        if(isset($_POST['write_filter']))
        {
            $kd_brg = $this->input->post('kd_brg');
            $kd_lokasi = $this->input->post('kd_lokasi');
            $no_aset = $this->input->post('no_aset');
            
            $data = $this->model->AssetWithWriteFilter($kd_lokasi,$kd_brg,$no_aset);
            
        }
        else
        {
            $kd_gol = '';
            $kd_bid = '';
            $kd_kel = '';
            $kd_skel = '';
            $kd_sskel = '';
            $kd_lokasi = '';

            if ($this->input->post('kd_gol') > 0)
            {
                $kd_gol = $this->input->post('kd_gol');
            }

            if ($this->input->post('kd_bid') > 0)
            {
                $kd_bid = $this->input->post('kd_bid');
            }

            if ($this->input->post('kd_kel') > 0)
            {
                $kd_kel = $this->input->post('kd_kel');
            }

            if ($this->input->post('kd_skel') > 0)
            {
                $kd_skel = $this->input->post('kd_skel');
            }

            if ($this->input->post('kd_sskel') > 0)
            {
                $kd_sskel = $this->input->post('kd_sskel');
            }

            if ($this->input->post('kd_lokasi') > 0)
            {
                $kd_lokasi = $this->input->post('kd_lokasi');
            }

            $data = $this->model->AssetWithFilter($kd_gol,$kd_bid,$kd_kel,$kd_skel,$kd_sskel,$kd_lokasi);
        }
        

        echo json_encode($data);
    }
    
    function assetAngkutan($jenis_angkutan)
    {
        if($jenis_angkutan == "darat")
        {
            $viewTable = "view_asset_angkutan_darat";
        }
        else if($jenis_angkutan == "laut")
        {
            $viewTable = "view_asset_angkutan_laut";
        }
        else
        {
            $viewTable = "view_asset_angkutan_udara";
        }
        $kd_gol = '';
        $kd_bid = '';
        $kd_kel = '';
        $kd_skel = '';
        $kd_sskel = '';
        $kd_lokasi = '';
        $kd_brg = '';
        $no_aset = '';
        $write_filter = '';
        
        if ($this->input->post('kd_gol') > 0)
        {
            $kd_gol = $this->input->post('kd_gol');
        }
        
        if ($this->input->post('kd_bid') > 0)
        {
            $kd_bid = $this->input->post('kd_bid');
        }
        
        if ($this->input->post('kd_kel') > 0)
        {
            $kd_kel = $this->input->post('kd_kel');
        }
        
        if ($this->input->post('kd_skel') > 0)
        {
            $kd_skel = $this->input->post('kd_skel');
        }
        
        if ($this->input->post('kd_sskel') > 0)
        {
            $kd_sskel = $this->input->post('kd_sskel');
        }
        
        if($this->input->post('write_filter') == 1)
        {
            $write_filter = $this->input->post('write_filter');
        }
        
        if($this->input->post('kd_lokasi'))
        {
            $kd_lokasi = $this->input->post('kd_lokasi');
            $this->db->where('kd_lokasi',$kd_lokasi);
        }
        
        if($write_filter == 1)
        {
            if($this->input->post('kd_brg'))
            {
                $kd_brg = $this->input->post('kd_brg');
                $this->db->where('t.kd_brg',$kd_brg);
            }
            
            if($this->input->post('no_aset'))
            {
                $no_aset = $this->input->post('no_aset');
                $this->db->where('no_aset',$no_aset);
            }
        }
        else
        {
            $this->db->like('t.kd_brg',$kd_gol.$kd_bid.$kd_kel.$kd_skel.$kd_sskel,'after');
        }
        
        $this->db->select("nama_unker as unker, t.kd_brg,kd_lokasi,no_aset, a.ur_sskel as nama");
        $this->db->from("$viewTable as t");
        $this->db->join("ref_subsubkel as a","t.kd_brg = a.kd_brg");
        
        $result = $this->db->get();
//        if($kd_lokasi != '')
//        {
//            
//            
//            $result = $this->db->query("SELECT nama_unker AS unker, t.kd_brg,kd_lokasi,no_aset, a.ur_sskel AS nama FROM view_asset_angkutan_udara AS t
//                                    LEFT JOIN ref_subsubkel AS a ON t.kd_brg = a.kd_brg
//                                    where t.kd_brg like '".$kd_gol.$kd_bid.$kd_kel.$kd_skel.$kd_sskel."%' and t.kd_lokasi = '$kd_lokasi'");
//        }
//        else
//        {
//           
//            $result = $this->db->query("SELECT nama_unker AS unker, t.kd_brg,kd_lokasi,no_aset, a.ur_sskel AS nama FROM view_asset_angkutan_udara AS t
//                                    LEFT JOIN ref_subsubkel AS a ON t.kd_brg = a.kd_brg
//                                    where t.kd_brg like '".$kd_gol.$kd_bid.$kd_kel.$kd_skel.$kd_sskel."%'");
//        }
        
        $data = array();
        if ($result->num_rows() > 0)
        {
            foreach ($result->result() as $obj)
            {
                $data[] = $obj;
            }  
        }
        
        echo json_encode($data);
        
    }
    
    function allReference()
    {
        $kd_gol = '';
        $kd_bid = '';
        $kd_kel = '';
        $kd_skel = '';
        $kd_sskel = '';
        
        if ($this->input->post('kd_gol') > 0)
        {
            $kd_gol = $this->input->post('kd_gol');
        }
        
        if ($this->input->post('kd_bid') > 0)
        {
            $kd_bid = $this->input->post('kd_bid');
        }
        
        if ($this->input->post('kd_kel') > 0)
        {
            $kd_kel = $this->input->post('kd_kel');
        }
        
        if ($this->input->post('kd_skel') > 0)
        {
            $kd_skel = $this->input->post('kd_skel');
        }
        
        if ($this->input->post('kd_sskel') > 0)
        {
            $kd_sskel = $this->input->post('kd_sskel');
        }
        
        
        $data = $this->model->RefBarangWithFilter($kd_gol,$kd_bid,$kd_kel,$kd_skel,$kd_sskel);
        
        echo json_encode($data);
    }
    
}
?>
