<?php
class laporan_aset_unitkerja extends MY_Controller {

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
			$this->load->view('laporan/laporan_aset_unitkerja_view',$data);
		}else{
			$this->load->view('laporan/laporan_aset_unitkerja_view');
		}
	}
        
        public function getLaporanChart()
        {
            $kd_lokasi = null;
            $kd_unor = null;
            $tahun = null;
            
            if(isset($_POST['kd_lokasi']))
            {
                $kd_lokasi = $_POST['kd_lokasi'];
            }
            if(isset($_POST['kd_unor']))
            {
                $kd_unor = $_POST['kd_unor'];
            }
            if(isset($_POST['tahun']))
            {
                $tahun = $_POST['tahun'];
            }
            
            if($kd_unor !=null || $kd_unor != '')
            {
                if($kd_lokasi !=null && $tahun !=null)
                {
                    $query = $this->db->query( "select 
                    (select (sum(rph_aset)/1000000) from asset_alatbesar as t 
                    LEFT JOIN ext_asset_alatbesar AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                    where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."' and kode_unor ='".$kd_unor."') 
                    as 'Alat Besar', 
                    (select (sum(rph_aset)/1000000) from asset_angkutan as t LEFT JOIN ext_asset_angkutan AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                    where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."' and kode_unor ='".$kd_unor."') 
                    as 'Angkutan',
                    (select (sum(rph_aset)/1000000) from asset_bangunan as t LEFT JOIN ext_asset_bangunan AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                    where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."' and kode_unor ='".$kd_unor."') 
                    as 'Bangunan',
                    (select (sum(rph_aset)/1000000) from asset_perairan as t LEFT JOIN ext_asset_perairan AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                    where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."' and kode_unor ='".$kd_unor."') 
                    as 'Perairan',
                    (select (sum(rph_aset)/1000000) from asset_senjata as t LEFT JOIN ext_asset_senjata AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                    where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."' and kode_unor ='".$kd_unor."') 
                    as 'Senjata',
                    (select (sum(rph_aset)/1000000) from asset_tanah as t LEFT JOIN ext_asset_tanah AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                    where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."' and kode_unor ='".$kd_unor."') 
                    as 'Tanah'");
                    $result = $query->row_array();
                    $result_array = array();
                    foreach($result as $key=>$value)
                    {
                        $temp_array["nama"] = $key;
                        $temp_array["totalAset"] = $value;
                        array_push($result_array,$temp_array);
                    }

                    $data = $result_array;
                    $dataSend['results'] = $data;
                    echo json_encode($dataSend);
                }
            }
            else
            {
                if($kd_lokasi !=null && $tahun !=null)
                {
                    $query = $this->db->query( "select 
                    (select (sum(rph_aset)/1000000) from asset_alatbesar where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."') as 'Alat Besar', 
                    (select (sum(rph_aset)/1000000) from asset_angkutan where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."') as 'Angkutan',
                    (select (sum(rph_aset)/1000000) from asset_bangunan where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."') as 'Bangunan',
                    (select (sum(rph_aset)/1000000) from asset_perairan where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."') as 'Perairan',
                    (select (sum(rph_aset)/1000000) from asset_senjata where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."') as 'Senjata',
                    (select (sum(rph_aset)/1000000) from asset_tanah where kd_lokasi='".$kd_lokasi."' and YEAR(tgl_buku) ='".$tahun."') as 'Tanah'");
                    $result = $query->row_array();
                    $result_array = array();
                    foreach($result as $key=>$value)
                    {
                        $temp_array["nama"] = $key;
                        $temp_array["totalAset"] = $value;
                        array_push($result_array,$temp_array);
                    }

                    $data = $result_array;
                    $dataSend['results'] = $data;
                    echo json_encode($dataSend);
                }
            }
        }
        
        public function getLaporanGrid()
        {
            $kd_lokasi = null;
            $kd_unor = null;
            $tahun = null;
            $start = $_POST['start'];
            $limit = $_POST['limit'];
            
            if(isset($_POST['kd_lokasi']))
            {
                $kd_lokasi = $_POST['kd_lokasi'];
            }
            if(isset($_POST['kd_unor']))
            {
                $kd_unor = $_POST['kd_unor'];
            }
            if(isset($_POST['tahun']))
            {
                $tahun = $_POST['tahun'];
            }

            /*tidak ada tgl: dil, ruang
             * tidak ada kode_unor: perlengkapan */
            if($kd_unor !=null || $kd_unor != '')
            {
                if($kd_lokasi !=null && $tahun !=null)
                {
                        $query = "select kode_unor,kd_lokasi,no_aset,kd_brg,type,merk,kondisi,kategori_aset from
                          (
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Alat Besar' as kategori_aset from asset_alatbesar as t
                          LEFT JOIN ext_asset_alatbesar AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."'
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Angkutan' as kategori_aset from asset_angkutan as t
                          LEFT JOIN ext_asset_angkutan AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."'
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,type,'-','-','Bangunan' as kategori_aset from asset_bangunan as t
                          LEFT JOIN ext_asset_angkutan AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."'
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi,'Senjata' as kategori_aset from asset_senjata as t
                          LEFT JOIN ext_asset_senjata AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."'
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','DIL' as kategori_aset from asset_dil as t
                          LEFT JOIN ext_asset_dil AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and b.kode_unor = '".$kd_unor."'
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Perairan' as kategori_aset from asset_perairan as t
                          LEFT JOIN ext_asset_perairan AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."'
                          UNION
                          select '-' as kode_unor,kd_brg,kd_lokasi,no_aset,'-','-',kondisi,'Perlengkapan' as kategori_aset from asset_perlengkapan
                          where kd_lokasi = '".$kd_lokasi."' and YEAR(tanggal_perolehan) = '".$tahun."' 
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Ruang' as kategori_aset from asset_ruang as t
                          LEFT JOIN ext_asset_ruang AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and b.kode_unor = '".$kd_unor."'
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Tanah' as kategori_aset from asset_tanah as t
                          LEFT JOIN ext_asset_tanah AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."'
                          ) as result
                          Limit $start,$limit

                          ";

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
            else
            {
                if($kd_lokasi !=null && $tahun !=null)
                {
                    
                        $query = "select kd_lokasi,no_aset,kd_brg,type,merk,kondisi,kategori_aset from
                          (
                          select t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Alat Besar' as kategori_aset from asset_alatbesar as t
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                          UNION
                          select t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Angkutan' as kategori_aset from asset_angkutan as t
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                          UNION
                          select t.kd_lokasi,t.no_aset,t.kd_brg,type,'-','-','Bangunan' as kategori_aset from asset_bangunan as t
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                          UNION
                          select t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi,'Senjata' as kategori_aset from asset_senjata as t
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                          UNION
                          select t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','DIL' as kategori_aset from asset_dil as t
                          where t.kd_lokasi = '".$kd_lokasi."'
                          UNION
                          select t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Perairan' as kategori_aset from asset_perairan as t
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                          UNION
                          select kd_brg,kd_lokasi,no_aset,'-','-',kondisi,'Perlengkapan' as kategori_aset from asset_perlengkapan
                          where kd_lokasi = '".$kd_lokasi."' and YEAR(tanggal_perolehan) = '".$tahun."'
                          UNION
                          select t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Ruang' as kategori_aset from asset_ruang as t
                          where t.kd_lokasi = '".$kd_lokasi."'
                          UNION
                          select t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Tanah' as kategori_aset from asset_tanah as t
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                          ) as result
                          Limit $start,$limit

                          ";

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
}
?>