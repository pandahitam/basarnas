<?php
class Pengelolaan_ASSET extends CI_Controller {

	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    	}
		$this->load->model('Tasset_tanah_Model','',TRUE);		
		$this->load->model('Tasset_bangunan_Model','',TRUE);		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('pengelolaan_asset/pengelolaan_asset_view',$data);
		}else{
			$this->load->view('pengelolaan_asset/pengelolaan_asset_view');
		}
	}
	
	// MASTER TANAH BANGUNAN ------------------------------------------- START
	function tanah_bangunan(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('pengelolaan_asset/tanah_bangunan_view',$data);
		}else{
			$this->load->view('pengelolaan_asset/tanah_bangunan_view');
		}
	}

	function ext_get_all_tanah_bangunan(){
		if($this->input->get_post("id_open")){
			//$start = $_REQUEST['start'];
			//$limit = $_REQUEST['limit'];
			$total = 0;
			
			$dataTanah = $this->Tasset_tanah_Model->get_AllData();	  			 	
			
			$dataBangunan = $this->Tasset_bangunan_Model->get_AllData();	  			 	
			
			$dataSend = array();
			if(count($dataTanah) > 0 )
			{
				foreach($dataTanah as $e){//tanah
					$e->tipe = 1;
					$dataSend[] = $e;		
				}
				$total += count($dataTanah);  
			}
			
			if(count($dataBangunan) > 0)
			{
				foreach($dataBangunan as $e){//bangunan
					$e->tipe = 2;
					$dataSend[] = $e;		
				}
				$total += count($dataBangunan);  
			}
							  
			$data['total'] = $total;
			
			$data['results'] = $dataSend;		
			
			echo json_encode($data);
		}
	}
	
	function ext_modify_tanah_bangunan(){
		$id = $this->input->post('id');
		$tipe = $this->input->post('tipe');
		if($tipe === '1'){//tanah				
		  	$data = array(
				'kode_unit_kerja' => $this->input->post('nama_unker'),
				'kode_unit_organisasi' => $this->input->post('nama_unor'),
				'alamat' => $this->input->post('alamat'),
				'kode_kota' => $this->input->post('nama_kabkota'),
				'kode_provinsi' => $this->input->post('nama_prov'),
				'kode_pos' => $this->input->post('kode_pos'),
				'luas_tanah' => $this->input->post('luas_tanah'),
				'image_url' => $this->input->post('image_url')
			);
			$status = $this->Tasset_tanah_Model->Modify_Data($id,$data);	 	
		}else{//bangunan
			$data = array(
				'kode_unit_kerja' => $this->input->post('nama_unker'),
				'kode_unit_organisasi' => $this->input->post('nama_unor'),
				'nama' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'kode_kota' => $this->input->post('nama_kabkota'),
				'kode_provinsi' => $this->input->post('nama_prov'),
				'kode_pos' => $this->input->post('kode_pos'),
				'luas_tanah' => $this->input->post('luas_tanah'),
				'luas_bangunan' => $this->input->post('luas_bangunan'),
				'image_url' => $this->input->post('image_url')
			);
			
			$status = $this->Tasset_bangunan_Model->Modify_Data($id,$data);	 
		}
		if($status === 2){
			echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
		}else if($status === 1){
			echo "{success:true, info: { reason: 'Sukses menambah data !' }}";
		}else{
			echo "{success:false, info: { reason: 'Gagal memodifikasi data !' }}";
		}
	}

	function do_upload()
	{
		$file = $_FILES;
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		/*$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
*/

		$this->upload->initialize($config);
		
		$this->load->library('upload', $config);
		
		header("Content-Type: text/html");
		
		if (!$this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors(),
							'success'=>false);
			echo json_encode($error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data(),
							'success'=>true);
			echo json_encode($data);
		}
	}
	
	public function delete_image()
	{
		$file = $this->input->post('file');

		$success = false;
		if(unlink(FCPATH.'uploads/' .$file))
		{
			$success = true;
		}
		
		$info = array('success'=>$success,
					'path'=>base_url().'uploads/' .$file, 
					'file'=>is_file(FCPATH.'uploads/' .$file));
		
		echo json_encode($info);
	}		

	// DELETE
	function ext_delete_tanah_bangunan()
	{
		$ids = $this->input->post('id');
		$fail = array();
		$success = true;
		foreach($ids as $id)
		{
			if ($id['type'] == 1)
			{
				if($this->Tasset_tanah_Model->Delete_Data($id['id']) == FALSE)
				{
					$fail[] = $id;
					$success = false;
				}
			}
			elseif ($id['type'] == 2)
			{
				if($this->Tasset_bangunan_Model->Delete_Data($id['id']) == FALSE)
				{
					$fail[] = $id;
					$success = false;
				}
			}
		}
		
		$result = array('fail' => $fail,
						'success'=>$success);
						
		echo json_encode($result);
	}
	
}
?>