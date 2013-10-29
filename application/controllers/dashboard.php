<?php
class Dashboard extends CI_Controller{
  public function __construct(){
  	parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
      $data['title'] = 'LOGIN PENGGUNA';
      redirect('user/index','refresh');
    }
	$this->load->model('Pengguna_Login_Model','',TRUE);
  }
	
  public function index(){
	
	$MenuDashboard = $this->Pengguna_Login_Model->get_AllData_Menu_ExtJS();
//	if(strlen($MenuDashboard) > 7){
//	    $MenuDashboard.=",";
//	}
	
	$data['MenuDashboard'] = $MenuDashboard;
	
  	$data['main'] = "home";
    $this->load->view('dashboard_view',$data);
  }
  
  function print_dialog(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('print_dialog_view',$data);
		}else{
			$this->load->view('print_dialog_view');
		}
  }
  
  function Get_By_Query($query)
    {	
        $r = $this->db->query($query);
        $data = array();
        if ($r->num_rows() > 0)
        {
            foreach ($r->result() as $obj)
            {
                $data[] = $obj;
            }  
        }


        $r->free_result();
        return $data;
    }
  
  function alert_pemeliharaan()
  {
      //      $query = "select ur_upb,nama, max(rencana_waktu) as tanggal_kadaluarsa from pemeliharaan as a
      //                inner join ref_unker as b on a.kd_lokasi = b.kdlok
      //                where DATEDIFF(DATE(rencana_waktu),CURDATE()) <= 0
      //                group by kd_lokasi, kd_brg, no_aset";
	    $query = "SELECT a.id,kd_lokasi,kd_brg,no_aset,ur_upb, nama, max( rencana_waktu ) as tanggal_kadaluarsa
		      FROM pemeliharaan AS a
		      INNER JOIN ref_unker AS b ON a.kd_lokasi = b.kdlok
		      WHERE DATEDIFF( DATE( rencana_waktu ) , CURDATE() ) <=0
		      AND alert = 1
		      AND
		      NOT EXISTS
		      (
			      SELECT kd_lokasi,kd_brg,no_aset FROM pemeliharaan
			      WHERE a.kd_lokasi = pemeliharaan.kd_lokasi
			      AND
			      a.kd_brg = pemeliharaan.kd_brg
			      AND
			      a.no_aset = pemeliharaan.no_aset
			      and
			      DATEDIFF( DATE( rencana_waktu ) , CURDATE() ) >=0
		      )
		      GROUP BY kd_lokasi, kd_brg, no_aset";
		      
	    $newQuery = "SELECT a.id, kd_lokasi,kd_brg,no_aset,ur_upb, nama, max( rencana_waktu ) as tanggal_kadaluarsa
		      FROM pemeliharaan AS a
		      INNER JOIN ref_unker AS b ON a.kd_lokasi = b.kdlok
		      WHERE DATEDIFF( DATE( rencana_waktu ) , CURDATE() ) <=0
		      AND alert = 1
                      AND rencana_waktu != '0000-00-00'
		      GROUP BY kd_lokasi, kd_brg, no_aset";
            $newQuery2 = "SELECT id, kd_brg, kd_lokasi, no_aset,
                            kode_unker, kode_unor, nama_unker, nama_unor,jenis, nama, 
                            tahun_angaran, pelaksana_tgl, pelaksana_nama, 
                            kondisi, deskripsi, harga, kode_angaran,
                            unit_waktu, unit_pengunaan,
                            freq_waktu, freq_pengunaan, status, durasi, 
                            rencana_waktu, rencana_pengunaan, rencana_keterangan, image_url,document_url, alert
                            FROM view_pemeliharaan
                            WHERE DATEDIFF( DATE( rencana_waktu ) , CURDATE() ) <=0
                            AND alert = 1
                            AND rencana_waktu != '0000-00-00'
                            
                            ";
            
	    //$this->Get_By_Query($query);
	    $data = $this->Get_By_Query($newQuery2);
	    $dataSend['results'] = $data;
	    echo json_encode($dataSend);
  }
  
  function alert_pengadaan()
  {
      $query = "SELECT id,nama_unker,kd_brg,nama,garansi_berlaku AS tanggal_garansi_expired FROM view_pengadaan
                WHERE is_garansi = 1 AND expired_viewed_status = 0 
                AND DATEDIFF( DATE( garansi_berlaku ) , CURDATE() ) <=0 
                AND garansi_berlaku != '0000-00-00'";
       $data = $this->Get_By_Query($query);
       $dataSend['results'] = $data;
       echo json_encode($dataSend);
  }
  
  function alert_kendaraan_darat()
  {
      $query = "SELECT kd_lokasi, kd_brg, no_aset, kuantitas, no_kib, merk, type, pabrik, thn_rakit, thn_buat, negara, muat, bobot, daya, 
                            msn_gerak, jml_msn, bhn_bakar, no_mesin, no_rangka, no_polisi, no_bpkb, lengkap1, lengkap2, lengkap3, jns_trn, dari, tgl_prl, rph_aset, 
                            dasar_hrg, sumber, no_dana, tgl_dana, unit_pmk, alm_pmk, catatan, kondisi, tgl_buku, rphwajar, status,
                            id, kode_unor, image_url, document_url, 
                            nama_unker, nama_unor,
                            kd_gol,kd_bid,kd_kelompok,kd_skel, kd_sskel,ur_sskel
                            ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                            kd_lvl1,kd_lvl2,kd_lvl3,
                            darat_no_stnk,darat_masa_berlaku_stnk,darat_masa_berlaku_pajak,
                            darat_jumlah_pajak, darat_keterangan_lainnya
                            FROM view_asset_angkutan_darat
                            WHERE DATEDIFF( DATE( darat_masa_berlaku_stnk ) , CURDATE() ) <=0
                            OR
                            DATEDIFF( DATE( darat_masa_berlaku_pajak ) , CURDATE() ) <=0
                            AND darat_masa_berlaku_stnk != '0000-00-00'
                            AND darat_masa_berlaku_pajak != '0000-00-00'";
      $data = $this->Get_By_Query($query);
       $dataSend['results'] = $data;
       echo json_encode($dataSend);
  }
  
  function inventaris_assetumum() {
      $query = "SELECT * FROM t_tempall";
	   $data = $this->Get_By_Query($query);
	   $dataSend['results'] = $data;
	   echo json_encode($dataSend);
  }
  function cari_global() {
	$keyword="carab";
	$keyword = $this->input->post('query');
	$data = array();
	if($keyword!=null){
		$query = " SELECT 'Peralatan' AS `gol`, `x`.kd_lokasi AS kode_lokasi, `x`.kd_brg AS kode_barang, `x`.no_aset,
		`x`.merk, `x`.`type` as tipe, `y`.ur_sskel as nama_barang, `z`.`ur_upb` as nama_unker
		FROM asset_alatbesar AS `x`
		INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg  INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
		WHERE 
		`x`.kd_lokasi LIKE   '%".$keyword."%'OR
		`x`.kd_brg LIKE  '%".$keyword."%'OR
		`x`.no_aset LIKE  '%".$keyword."%'OR
		`x`.merk LIKE  '%".$keyword."%'OR
		`x`.`type` LIKE  '%".$keyword."%'OR
		`y`.`ur_sskel` LIKE  '%".$keyword."%'OR
		`z`.ur_upb LIKE   '%".$keyword."%'
		UNION
		SELECT 'Angkutan' AS `gol`, `x`.kd_lokasi, `x`.kd_brg,  `x`.no_aset, `x`.merk, `x`.`type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_angkutan AS `x`
		INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
		WHERE 
		`x`.kd_lokasi LIKE  '%".$keyword."%'OR
		`x`.kd_brg LIKE  '%".$keyword."%'OR
		`x`.no_aset LIKE  '%".$keyword."%'OR
		`x`.merk LIKE  '%".$keyword."%'OR
		`x`.`type` LIKE  '%".$keyword."%'OR
		`y`.`ur_sskel` LIKE  '%".$keyword."%'OR
		`z`.ur_upb LIKE   '%".$keyword."%'
		UNION
		SELECT 'Bangunan' AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, '' AS merk, '' AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_bangunan AS `x`
		INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
		WHERE 
		`x`.kd_lokasi LIKE  '%".$keyword."%'OR
		`x`.kd_brg LIKE  '%".$keyword."%'OR
		`x`.no_aset LIKE  '%".$keyword."%'OR
		`y`.`ur_sskel` LIKE  '%".$keyword."%'OR
		`z`.ur_upb LIKE   '%".$keyword."%'
		UNION
		SELECT 'Dil' AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, '' AS merk, '' AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_dil AS `x`
		INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
		WHERE 
		`x`.kd_lokasi LIKE  '%".$keyword."%'OR
		`x`.kd_brg LIKE  '%".$keyword."%'OR
		`x`.no_aset LIKE  '%".$keyword."%'OR
		`y`.`ur_sskel` LIKE  '%".$keyword."%'OR
		`z`.ur_upb LIKE   '%".$keyword."%'
		UNION
		SELECT 'Perairan' AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, '' AS merk, '' AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_perairan AS `x`
		INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
		WHERE 
		`x`.kd_lokasi LIKE  '%".$keyword."%'OR
		`x`.kd_brg LIKE  '%".$keyword."%'OR
		`x`.no_aset LIKE  '%".$keyword."%'OR
		`y`.`ur_sskel` LIKE  '%".$keyword."%'OR
		`z`.ur_upb LIKE   '%".$keyword."%'
		UNION
		SELECT 'Ruang' AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, '' AS merk, '' AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_ruang AS `x`
		INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
		WHERE 
		`x`.kd_lokasi LIKE  '%".$keyword."%'OR
		`x`.kd_brg LIKE  '%".$keyword."%'OR
		`x`.no_aset LIKE  '%".$keyword."%'OR
		`y`.`ur_sskel` LIKE  '%".$keyword."%'OR
		`z`.ur_upb LIKE   '%".$keyword."%'
		UNION
		SELECT 'Senjata' AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, `x`.merk, `x`.`type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_senjata AS `x`
		INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
		WHERE 
		`x`.kd_lokasi LIKE  '%".$keyword."%'OR
		`x`.kd_brg LIKE  '%".$keyword."%'OR
		`x`.no_aset LIKE  '%".$keyword."%'OR
		`x`.merk LIKE  '%".$keyword."%'OR
		`x`.`type` LIKE  '%".$keyword."%'OR
		`y`.`ur_sskel` LIKE  '%".$keyword."%'OR
		`z`.ur_upb LIKE   '%".$keyword."%'
		UNION
		SELECT 'Tanah' AS `gol`, `x`.kd_lokasi, `x`.kd_brg, no_aset, '' AS merk, '' AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_tanah AS `x`
		INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
		WHERE 
		`x`.kd_lokasi LIKE  '%".$keyword."%'OR
		`x`.kd_brg LIKE  '%".$keyword."%'OR
		`x`.no_aset LIKE  '%".$keyword."%'OR
		`y`.`ur_sskel` LIKE  '%".$keyword."%'OR
		`z`.ur_upb LIKE   '%".$keyword."%'";
		$data = $this->Get_By_Query($query);
	}
	$dataSend['results'] = $data;
	echo json_encode($dataSend);
  }
  
  
  function grafik_unker_totalaset()
  {
      $query = "select kd_lokasi, UnitKerjaTotalAsset.ur_upb, (sum(rph_aset)/1000000) as totalAset
        from
        (
        select kd_lokasi, ur_upb, rph_aset from asset_alatbesar as a inner join ref_unker on ref_unker.kdlok = 
        a.kd_lokasi
            UNION
            select kd_lokasi, ur_upb, rph_aset from asset_angkutan as a inner join ref_unker on ref_unker.kdlok = 
        a.kd_lokasi
            UNION
            select kd_lokasi, ur_upb, rph_aset from asset_bangunan as a inner join ref_unker on ref_unker.kdlok = 
        a.kd_lokasi
            UNION
            select kd_lokasi, ur_upb, rph_aset from asset_perairan as a inner join ref_unker on ref_unker.kdlok = 
        a.kd_lokasi
            UNION
            select kd_lokasi, ur_upb, rph_aset from asset_senjata as a inner join ref_unker on ref_unker.kdlok = 
        a.kd_lokasi
            UNION
            select kd_lokasi, ur_upb, rph_aset from asset_tanah as a inner join ref_unker on ref_unker.kdlok = a.kd_lokasi
        ) as UnitKerjaTotalAsset inner join ref_unker on ref_unker.kdlok = UnitKerjaTotalAsset.kd_lokasi
        group by kd_lokasi
        ";
      
      //$this->Get_By_Query($query);
      $data = $this->Get_By_Query($query);
      $dataSend['results'] = $data;
      echo json_encode($dataSend);
      
  }
  
  function grafik_kategoribarang_totalaset()
  {
      $query = $this->db->query( 'select 
                (select (sum(rph_aset)/1000000) from asset_alatbesar) as "Alat Besar", 
                (select (sum(rph_aset)/1000000) from asset_angkutan) as "Angkutan",
                (select (sum(rph_aset)/1000000) from asset_bangunan) as "Bangunan",
                (select (sum(rph_aset)/1000000) from asset_perairan) as "Perairan",
                (select (sum(rph_aset)/1000000) from asset_senjata) as "Senjata",
                (select (sum(rph_aset)/1000000) from asset_tanah) as "Tanah"');
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
?>