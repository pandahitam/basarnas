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
