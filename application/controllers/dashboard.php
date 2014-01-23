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
  
  function alert_perlengkapan()
  {
      $query = "SELECT id,warehouse_id,ruang_id,rak_id,nama_warehouse,nama_rak,nama_ruang,no_induk_asset,
                            serial_number, part_number,kd_brg,kd_lokasi,nama_unker,nama_unor,
                            no_aset,kondisi, kuantitas, dari,
                            tanggal_perolehan,no_dana,penggunaan_waktu,
                            penggunaan_freq,unit_waktu,unit_freq,disimpan, 
                            dihapus,image_url,document_url,kode_unor
                            ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                            kd_lvl1,kd_lvl2,kd_lvl3,id_pengadaan,nama_part,umur,jenis_asset,nama_kelompok,alert
                FROM view_asset_perlengkapan
                WHERE alert =1  and umur_maks - umur <= 10 and (no_induk_asset != '' or no_induk_asset is not null)";
      
      $new_query ="
          SELECT t.id,warehouse_id,ruang_id,rak_id,nama_warehouse,nama_rak,nama_ruang,no_induk_asset,
                            t.serial_number, t.part_number,kd_brg,kd_lokasi,nama_unker,nama_unor,
                            no_aset,kondisi, kuantitas, dari,
                            tanggal_perolehan,no_dana,penggunaan_waktu,
                            penggunaan_freq,unit_waktu,unit_freq,disimpan, 
                            dihapus,image_url,document_url,kode_unor
                            ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                            kd_lvl1,kd_lvl2,kd_lvl3,id_pengadaan,nama_part,jenis_asset,nama_kelompok,t.alert, t.umur,t.umur_maks,t.cycle, t.cycle_maks,
		            a.nama AS sub_part_nama,a.cycle AS sub_part_cycle, a.cycle_maks AS sub_part_cycle_maks, a.umur AS sub_part_umur, 
		            a.umur_maks AS sub_part_umur_maks,
		            b.nama AS sub_sub_part_nama,b.cycle AS sub_sub_part_cycle,b.cycle_maks AS sub_sub_part_cycle_maks, 
		            b.umur AS sub_sub_part_umur,
		            b.umur_maks AS sub_sub_part_umur_maks
                FROM view_asset_perlengkapan AS t
                INNER JOIN asset_perlengkapan_sub_part AS a ON t.id = a.id_part
		INNER JOIN asset_perlengkapan_sub_sub_part AS b ON a.id = b.id_sub_part
		WHERE t.alert = 1
		AND (no_induk_asset != '' OR no_induk_asset IS NOT NULL)
		AND (
		(t.umur_maks - t.umur < 10 OR (CASE WHEN t.is_cycle = 1 AND t.cycle_maks - t.cycle <10 THEN TRUE ELSE FALSE END))
		OR
		(a.is_kelompok = 0 AND (a.umur_maks - a.umur < 10 OR (CASE WHEN a.is_cycle = 1 AND a.cycle_maks - a.cycle <10 THEN TRUE ELSE FALSE END)))
		OR
		(b.umur_maks - b.umur < 10 OR (CASE WHEN b.is_cycle = 1 AND b.cycle_maks - b.cycle <10 THEN TRUE ELSE FALSE END))
		)
                group by t.id
          ";
      $data = $this->Get_By_Query($new_query);
//      var_dump($data);
//      die;
       $dataSend['results'] = $data;
       echo json_encode($dataSend);
  }
  
  function getAlertPerlengkapanListRequiredPemeliharaan()
  {
      $id = $this->input->post("id");
      
      $query_part = $this->db->query("SELECT 'Part' AS tipe, 
                t.nama_part as nama, t.part_number,t.serial_number, 
                (t.umur_maks - t.umur) AS  perbedaan_umur,
                IF(t.is_cycle = 1,(t.cycle_maks - t.cycle),'-') AS perbedaan_cycle
                FROM view_asset_perlengkapan AS  t
          WHERE alert = 1
		AND (no_induk_asset != '' OR no_induk_asset IS NOT NULL)
		AND
                (t.umur_maks - t.umur < 10 OR (CASE WHEN t.is_cycle = 1 AND t.cycle_maks - t.cycle <10 THEN TRUE ELSE FALSE END))
		");
      
      $query_sub_part = $this->db->query("select 'Sub Part' as tipe, 
                t.nama, t.part_number,t.serial_number, 
                (t.umur_maks - t.umur) as  perbedaan_umur,
                IF(t.is_cycle = 1,(t.cycle_maks - t.cycle),'-') as perbedaan_cycle 
                from asset_perlengkapan_sub_part as t
                INNER JOIN asset_perlengkapan as a on a.id = t.id_part
                WHERE a.alert = 1
		AND (a.no_induk_asset != '' OR a.no_induk_asset IS NOT NULL)
                AND t.is_kelompok = 0
		AND
                (t.umur_maks - t.umur < 10 OR (CASE WHEN t.is_cycle = 1 AND t.cycle_maks - t.cycle <10 THEN TRUE ELSE FALSE END))
		");
      
      $query_sub_sub_part = $this->db->query("select 'Sub Sub Part' as tipe, 
                t.nama, t.part_number,t.serial_number, 
                (t.umur_maks - t.umur) as  perbedaan_umur,
                IF(t.is_cycle = 1,(t.cycle_maks - t.cycle),'-') as perbedaan_cycle
                from asset_perlengkapan_sub_sub_part as t
                INNER JOIN asset_perlengkapan_sub_part as b on b.id = t.id_sub_part
                INNER JOIN asset_perlengkapan as a on a.id = b.id_part
                WHERE a.alert = 1
		AND (a.no_induk_asset != '' OR a.no_induk_asset IS NOT NULL)
		AND
                (t.umur_maks - t.umur < 10 OR (CASE WHEN t.is_cycle = 1 AND t.cycle_maks - t.cycle <10 THEN TRUE ELSE FALSE END))
		");
      
      $data = array();
      
      if($query_part->num_rows() > 0)
      {
            foreach ($query_part->result() as $obj)
            {
                $data[] = $obj;
            }  
      }
      
      if($query_sub_part->num_rows() > 0)
      {
            foreach ($query_sub_part->result() as $obj)
            {
                $data[] = $obj;
            }  
      }
      
      if($query_sub_sub_part->num_rows() > 0)
      {
            foreach ($query_sub_sub_part->result() as $obj)
            {
                $data[] = $obj;
            }  
      }
      
       $dataSend['results'] = $data;
       echo json_encode($dataSend);
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
            
            $newQuery3 = "SELECT
                        `a`.`ur_upb`             AS `nama_unker`,
                        `b`.`nama_unor`          AS `nama_unor`,
                        `t`.`kode_unor`          AS `kode_unor`,
                        `t`.`kode_unker`         AS `kode_unker`,
                        `t`.`id`                 AS `id`,
                        `t`.`kd_lokasi`          AS `kd_lokasi`,
                        `t`.`kd_brg`             AS `kd_brg`,
                        `t`.`no_aset`            AS `no_aset`,
                        `t`.`tahun_angaran`      AS `tahun_angaran`,
                        `t`.`jenis`              AS `jenis`,
                        `t`.`nama`               AS `nama`,
                        `t`.`pelaksana_tgl`      AS `pelaksana_tgl`,
                        `t`.`pelaksana_nama`     AS `pelaksana_nama`,
                        `t`.`kondisi`            AS `kondisi`,
                        `t`.`deskripsi`          AS `deskripsi`,
                        `t`.`harga`              AS `harga`,
                        `t`.`kode_angaran`       AS `kode_angaran`,
                        `t`.`unit_waktu`         AS `unit_waktu`,
                        `t`.`unit_pengunaan`     AS `unit_pengunaan`,
                        `t`.`freq_waktu`         AS `freq_waktu`,
                        `t`.`freq_pengunaan`     AS `freq_pengunaan`,
                        `t`.`status`             AS `status`,
                        `t`.`durasi`             AS `durasi`,
                        `t`.`rencana_waktu`      AS `rencana_waktu`,
                        `t`.`rencana_pengunaan`  AS `rencana_pengunaan`,
                        `t`.`rencana_keterangan` AS `rencana_keterangan`,
                        `t`.`alert`              AS `alert`,
                        `t`.`image_url`          AS `image_url`,
                        `t`.`document_url`       AS `document_url`,
                        `c`.`total_penggunaan`       AS `total_penggunaan`
                        FROM `pemeliharaan` `t`
                            LEFT JOIN `ref_unker` `a`
                              ON `t`.`kd_lokasi` = `a`.`kdlok`
                           LEFT JOIN `ref_unor` `b`
                             ON `t`.`kode_unor` = `b`.`kode_unor`
                            LEFT JOIN(
                                SELECT a.kd_brg,a.kd_lokasi,a.no_aset,SUM(CASE
                                                WHEN satuan_penggunaan = 1 THEN jumlah_penggunaan/1000
                                                WHEN satuan_penggunaan = 3 THEN jumlah_penggunaan * 1.60934
                                                ELSE
                                                jumlah_penggunaan
                                                END) AS total_penggunaan
                                        FROM ext_asset_angkutan_detail_penggunaan AS t
                                        LEFT JOIN ext_asset_angkutan AS a ON t.`id_ext_asset` = a.id
                                        GROUP BY a.kd_brg,a.kd_lokasi,a.no_aset
                                UNION ALL
                                SELECT t.kd_brg,t.kd_lokasi,t.no_aset, 
                                (GREATEST(t.udara_inisialisasi_mesin1,t.udara_inisialisasi_mesin2)+SUM(a.jumlah_penggunaan)) AS total_penggunaan
                                FROM view_asset_angkutan_udara AS t
                                LEFT JOIN ext_asset_angkutan_udara_detail_penggunaan AS a
                                ON t.id = a.`id_ext_asset`
                                GROUP BY t.kd_brg,t.kd_lokasi,t.no_aset ) AS c ON c.no_aset = t.`no_aset` AND c.kd_lokasi = t.`kd_lokasi` AND c.kd_brg = t.`kd_brg`
                                WHERE alert=1
                                AND
                                ((DATEDIFF( DATE( rencana_waktu ) , CURDATE() ) <=0
                                AND rencana_waktu != '0000-00-00')
                                OR
                                (
                                total_penggunaan >= (CASE
                                                WHEN unit_pengunaan = 1 THEN (freq_pengunaan/1000)
						WHEN unit_pengunaan = 2 THEN freq_pengunaan
                                                WHEN unit_pengunaan = 3 THEN (freq_pengunaan * 1.60934)
                                                ELSE 0
                                              END)
                                AND unit_pengunaan != 0
                                
                                )
                                )
                                ";
            
	    //$this->Get_By_Query($query);
	    $data = $this->Get_By_Query($newQuery3);
	    $dataSend['results'] = $data;
	    echo json_encode($dataSend);
  }
  
  function alert_pengadaan()
  {
      $query = "SELECT id,nama_unker,kd_brg,nama,garansi_berlaku AS tanggal_garansi_expired FROM view_pengadaan
                WHERE is_garansi = 1 AND alert_viewed_status = 0 
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
  
  function alert_pengelolaan()
  {
      $query = "SELECT t.id, t.nama_operasi, t.pic,t.tanggal_mulai,t.tanggal_selesai,t.deskripsi, t.image_url, t.document_url, t.kd_lokasi, t.kode_unor, t.kd_brg, t.no_aset, t.nama,c.ur_upb as nama_unker
                FROM pengelolaan AS t
                LEFT JOIN ref_unker AS c ON t.kd_lokasi = c.kdlok
                WHERE DATEDIFF( DATE( tanggal_selesai ) , CURDATE() ) <=0
                AND t.alert_viewed_status = 0
                AND tanggal_selesai != '0000-00-00'";
      
       $data = $this->Get_By_Query($query);
       $dataSend['results'] = $data;
       echo json_encode($dataSend);
  }
  
  function alert_pendayagunaan()
  {
      $query = "SELECT id, kd_lokasi, kd_brg, no_aset, nama,pihak_ketiga, nama_unor,
                part_number,serial_number,mode_pendayagunaan,tanggal_start,description,
                tanggal_end,document,nama_unker,
                kd_gol,kd_bid,kd_kelompok,kd_skel,kd_sskel
                ,nama_klasifikasi_aset, kd_klasifikasi_aset,
                kd_lvl1,kd_lvl2,kd_lvl3
                FROM view_pendayagunaan
                WHERE DATEDIFF( DATE( tanggal_end) , CURDATE() ) <=0
                AND alert_viewed_status = 0
                AND tanggal_end != '0000-00-00'";
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
		$query = " SELECT 'Peralatan' AS `gol`, `x`.kd_lokasi AS kd_lokasi, `x`.kd_brg AS kd_brg, `x`.no_aset,
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
  
  function cari_global_getFormData()
  {
      $jenis_asset = strtolower($_POST['jenis_asset']);
      $kd_brg = $_POST['kd_brg'];
      $kd_lokasi = $_POST['kd_lokasi'];
      $no_aset = $_POST['no_aset'];
      $formData = null;
      
      switch($jenis_asset){
          case "peralatan" : 
              $this->load->model('Asset_Alatbesar_Model');
              $formData = $this->Asset_Alatbesar_Model->get_Alatbesar($kd_lokasi,$kd_brg,$no_aset);
              break;
          case "angkutan_darat":
              $this->load->model('Asset_Angkutan_Darat_Model');
              $formData = $this->Asset_Angkutan_Darat_Model->get_AngkutanDarat($kd_lokasi,$kd_brg,$no_aset);
              break;
          case "angkutan_laut":
              $this->load->model('Asset_Angkutan_Laut_Model');
              $formData = $this->Asset_Angkutan_Laut_Model->get_AngkutanLaut($kd_lokasi,$kd_brg,$no_aset);
              break;
          case "angkutan_udara":
              $this->load->model('Asset_Angkutan_Udara_Model');
              $formData = $this->Asset_Angkutan_Udara_Model->get_AngkutanUdara($kd_lokasi,$kd_brg,$no_aset);
              break;
          case "bangunan":
              $this->load->model('Asset_Bangunan_Model');
              $formData = $this->Asset_Bangunan_Model->get_Bangunan($kd_lokasi,$kd_brg,$no_aset);
              break;
          case "dil":
              $this->load->model('Asset_Luar_Model');
              $formData = $this->Asset_Luar_Model->get_Luar($kd_lokasi,$kd_brg,$no_aset);
              break;
          case "perairan":
              $this->load->model('Asset_Perairan_Model');
              $formData = $this->Asset_Perairan_Model->get_Perairan($kd_lokasi,$kd_brg,$no_aset);
              break;
          case "ruang":
              $this->load->model('Asset_Ruang_Model');
              $formData = $this->Asset_Ruang_Model->get_Ruang($kd_lokasi,$kd_brg,$no_aset);
              break;
          case "senjata":
              $this->load->model('Asset_Senjata_Model');
              $formData = $this->Asset_Senjata_Model->get_Senjata($kd_lokasi,$kd_brg,$no_aset);
              break;
          case "tanah":
              $this->load->model('Asset_Tanah_Model');
              $formData = $this->Asset_Tanah_Model->get_Tanah($kd_lokasi,$kd_brg,$no_aset);
              break;
          default: break;
      }
      
      echo json_encode($formData);
      
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
            UNION
            select kd_lokasi, ur_upb, rph_aset from ext_asset_ruang as a inner join ref_unker on ref_unker.kdlok = a.kd_lokasi
            UNION
            select kd_lokasi, ur_upb, rph_aset from ext_asset_dil as a inner join ref_unker on ref_unker.kdlok = a.kd_lokasi
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
                (select (sum(rph_aset)/1000000) from asset_angkutan) as "Angkutan",
                (select (sum(rph_aset)/1000000) from asset_bangunan) as "Bangunan",
                (select (sum(rph_aset)/1000000) from ext_asset_dil) as "Luar",
                (select (sum(rph_aset)/1000000) from asset_perairan) as "Perairan",
                (select (sum(rph_aset)/1000000) from asset_alatbesar) as "Peralatan",
                (select (sum(rph_aset)/1000000) from ext_asset_ruang) as "Ruang",
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
  
  function memo()
  {
      $user_kd_lokasi = $this->session->userdata('temp_kode_unker_zs_simpeg');
      $user_kode_unor = $this->session->userdata('temp_kode_unor_zs_simpeg');
      if($user_kd_lokasi == 0 || $user_kd_lokasi == null)
      {
          $user_kd_lokasi = '';
      }
      else
      {
          $user_kd_lokasi = "AND t.kd_lokasi='".$user_kd_lokasi."' ";
      }
      
      if($user_kode_unor == 0 || $user_kode_unor == null)
      {
          $user_kode_unor = '';
      }
      else
      {
          $user_kode_unor = "AND t.kode_unor='".$user_kode_unor."' ";
      }
      
      $query = "SELECT t.id, t.kd_brg, t.kd_lokasi, t.no_aset, DATE_FORMAT(t.date_created,'%b %d %Y (%H:%i)') as date_created,t.created_by, t.isi, a.ur_upb AS nama_unker, b.nama_unor, c.ur_sskel as nama
                                 FROM memo AS t
                                 LEFT JOIN ref_unker AS a ON t.kd_lokasi = a.kdlok
                                 LEFT JOIN ref_unor AS b ON t.kode_unor = b.kode_unor
                                 LEFT JOIN ref_subsubkel as c on t.kd_brg = c.kd_brg
                                 WHERE
                                 is_read = 0
                                 $user_kd_lokasi $user_kode_unor";
      
      $data = $this->Get_By_Query($query);
       $dataSend['results'] = $data;
       echo json_encode($dataSend);
  }
  

}
?>