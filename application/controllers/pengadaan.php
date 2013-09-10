<?php
class Pengadaan extends MY_Controller {

	function __construct() {
		parent::__construct();
                
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Pengadaan_Model','',TRUE);
		$this->model = $this->Pengadaan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/pengadaan_view',$data);
		}else{
			$this->load->view('process_asset/pengadaan_view');
		}
	}
	
	function modifyPengadaan(){
                $data = array();
                
	  	$fields = array(
			'id', 'kode_unker', 'kode_unor', 'id_vendor', 'kd_lokasi','kd_brg','no_aset','part_no','merek','model', 'nama',
                        'tahun_angaran', 'perolehan_sumber', 'perolehan_bmn', 'perolehan_tanggal', 
                        'no_sppa', 'asal_pengadaan', 'harga_total', 'deskripsi', 
                        'faktur_no', 'faktur_tanggal', 'kuitansi_no', 'kuitansi_tanggal', 
                        'sp2d_no', 'sp2d_tanggal', 'mutasi_no', 'mutasi_tanggal', 
                        'garansi_berlaku', 'garansi_keterangan', 'pelihara_berlaku', 'pelihara_keterangan', 
                        'spk_no', 'spk_jenis', 'spk_berlaku', 'spk_keterangan', 'is_terpelihara', 
                        'is_garansi', 'is_spk', 'data_kontrak','document_url','image_url'
                );
                
                foreach ($fields as $field) {
                        $data[$field] = $this->input->post($field);
		} 
                
		$this->modifyData(null,$data);
	}
	
	function deletePengadaan()
	{
		$data = $this->input->post('data');
                
		return $this->deleteProcess($data);
	}
	
	function getByID()
	{
		$id = $this->input->post('id_pengadaan');
		$data = $this->model->get_ByID($id);
		echo json_encode($data);
	}
        
        function getByKode()
	{
		$kd_lokasi = $this->input->post('kd_lokasi');
                $kd_brg = $this->input->post('kd_brg');
                $no_aset = $this->input->post('no_aset');
                
		$data = $this->model->get_ByKode($kd_lokasi,$kd_brg,$no_aset);
		echo json_encode($data);
	}
}
?>