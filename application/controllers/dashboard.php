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
	    $query = "SELECT kd_lokasi,kd_brg,no_aset,ur_upb, nama, max( rencana_waktu ) as tanggal_kadaluarsa
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
		      
	    $newQuery = "SELECT kd_lokasi,kd_brg,no_aset,ur_upb, nama, max( rencana_waktu ) as tanggal_kadaluarsa
		      FROM pemeliharaan AS a
		      INNER JOIN ref_unker AS b ON a.kd_lokasi = b.kdlok
		      WHERE DATEDIFF( DATE( rencana_waktu ) , CURDATE() ) <=0
		      AND alert = 1
		      GROUP BY kd_lokasi, kd_brg, no_aset";
		      
	    //$this->Get_By_Query($query);
	    $data = $this->Get_By_Query($newQuery);
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
      $query = "SELECT id,nama_unker,kd_brg,merk,darat_masa_berlaku_stnk, darat_masa_berlaku_pajak FROM view_asset_angkutan_darat
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