<?php
class laporan_aset_kategoribarang extends MY_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
//		$this->load->model('Asset_Alatbesar_Model','',TRUE);
//		$this->model = $this->Asset_Alatbesar_Model;		
	}
	
        public function index()
        {
            if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('laporan/laporan_aset_kategoribarang_view',$data);
		}else{
			$this->load->view('laporan/laporan_aset_kategoribarang_view');
		}
	}
        
        public function getLaporanChart()
        {
            $kategori = null;
            $tahun = null;
            $query = '';
              
            if(isset($_POST['kategori']))
            {
                $kategori = $_POST['kategori'];
            }
            if(isset($_POST['tahun']))
            {
                $tahun = $_POST['tahun'];
            }
            
            if($kategori == 1 && ($tahun !='' || $tahun != null)) //Alat Besar
            {
                $query = "select kd_lokasi, ur_upb, sum(rph_aset)as totalAset from asset_alatbesar as a inner join ref_unker on ref_unker.kdlok = 
                          a.kd_lokasi where YEAR(tgl_buku) = $tahun group by kd_lokasi";
            }
            else if($kategori == 2 && ($tahun !='' || $tahun != null)) //Angkutan
            {
                $query = "select kd_lokasi, ur_upb, sum(rph_aset)as totalAset from asset_angkutan as a inner join ref_unker on ref_unker.kdlok = 
                          a.kd_lokasi where YEAR(tgl_buku) = $tahun group by kd_lokasi";
            }
            else if($kategori == 3 && ($tahun !='' || $tahun != null)) //Bangunan
            {
                $query = "select kd_lokasi, ur_upb, sum(rph_aset)as totalAset from asset_bangunan as a inner join ref_unker on ref_unker.kdlok = 
                          a.kd_lokasi where YEAR(tgl_buku) = $tahun group by kd_lokasi";
            }
            else if($kategori == 4 && ($tahun !='' || $tahun != null)) //Perairan
            {
                $query = "select kd_lokasi, ur_upb, sum(rph_aset)as totalAset from asset_perairan as a inner join ref_unker on ref_unker.kdlok = 
                          a.kd_lokasi where YEAR(tgl_buku) = $tahun group by kd_lokasi";
            }
            else if($kategori == 5 && ($tahun !='' || $tahun != null)) //Senjata
            {
                $query = "select kd_lokasi, ur_upb, sum(rph_aset)as totalAset from asset_senjata as a inner join ref_unker on ref_unker.kdlok = 
                          a.kd_lokasi where YEAR(tgl_buku) = $tahun group by kd_lokasi";
            }
            else if($kategori == 6 && ($tahun !='' || $tahun != null)) //Tanah
            {
                $query = "select kd_lokasi, ur_upb, sum(rph_aset)as totalAset from asset_alatbesar as a inner join ref_unker on ref_unker.kdlok = 
                          a.kd_lokasi where YEAR(tgl_buku) = $tahun group by kd_lokasi";
            }
          
          if($query != '')
          {
              $r = $this->db->query($query);
                    $data = array();
                    $totalRows = $r->num_rows(); 
                    if ($totalRows > 0)
                    {
                        foreach ($r->result() as $obj)
                        {
                            $data[] = $obj;
                        }  
                    }

                    $dataSend['results'] = $data;
//                    $dataSend['total'] = $totalRows;
                    echo json_encode($dataSend);
          }
        }
        
        public function getLaporanGrid()
        {
            $kategori = null;
            $tahun = null;
            $query = '';
              
            if(isset($_POST['kategori']))
            {
                $kategori = $_POST['kategori'];
            }
            if(isset($_POST['tahun']))
            {
                $tahun = $_POST['tahun'];
            }
            
            if($kategori == 1 && ($tahun !='' || $tahun != null)) //Alat Besar
            {
                $query = "select * from asset_alatbesar where YEAR(tgl_buku) = $tahun";
            }
            else if($kategori == 2 && ($tahun !='' || $tahun != null)) //Angkutan
            {
                $query = "select * from asset_angkutan where YEAR(tgl_buku) = $tahun";
            }
            else if($kategori == 3 && ($tahun !='' || $tahun != null)) //Bangunan
            {
                $query = "select * from asset_bangunan where YEAR(tgl_buku) = $tahun";
            }
            else if($kategori == 4 && ($tahun !='' || $tahun != null)) //Perairan
            {
                $query = "select * from asset_perairan where YEAR(tgl_buku) = $tahun";
            }
            else if($kategori == 5 && ($tahun !='' || $tahun != null)) //Senjata
            {
                $query = "select * from asset_senjata where YEAR(tgl_buku) = $tahun";
            }
            else if($kategori == 6 && ($tahun !='' || $tahun != null)) //Tanah
            {
                $query = "select * from asset_tanah where YEAR(tgl_buku) = $tahun";
            }
          
          if($query != '')
          {
              $r = $this->db->query($query);
                    $data = array();
                    $totalRows = $r->num_rows(); 
                    if ($totalRows > 0)
                    {
                        foreach ($r->result() as $obj)
                        {
                            $data[] = $obj;
                        }  
                    }

                    $dataSend['results'] = $data;
//                    $dataSend['total'] = $totalRows;
                    echo json_encode($dataSend);
          }
          
        }
}
?>