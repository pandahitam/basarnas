<?php
class Dashboard extends CI_Controller{
  public function __construct(){
  	parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
      $data['title'] = 'LOGIN PENGGUNA';
      redirect('user/index','refresh');
    }
  }
	
  public function index(){
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
      
      $this->Get_By_Query($query);
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