<?php
class Peraturan extends MY_Controller {


	function __construct() {
		parent::__construct();

 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                
		$this->load->model('Peraturan_Model','',TRUE);
		$this->model = $this->Peraturan_Model;		
	}
	
	function index(){
		if($this->input->post("id_open")){
			$data['jsscript'] = TRUE;
			$this->load->view('process_asset/peraturan_view',$data);
		}else{
			$this->load->view('process_asset/peraturan_view');
		}
	}
	
	function modifyPeraturan(){
                $data = array();
	  	$fields = array(
                    'id','nama','no_dokumen','tanggal_dokumen','initiator',
                    'perihal','date_upload', 'document',
                );
                
                foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		} 
                
                if($data['date_upload'] == '' || $data['date_upload'] == '0000-00-00')
                {
                    $data['date_upload'] = date('Y-m-d');
                }
                if($data['id'] != '')
                {
                    $this->createLog('UPDATE PERATURAN','peraturan');
                }
                else
                {
                    $this->createLog('INSERT PERATURAN','peraturan');
                }
//                $today = new DateTime();
//                $data['date_upload'] = $today->format('Y-m-d');
                
		$this->modifyData(null,$data);
	}
	
	function deletePeraturan()
	{
		$data = $this->input->post('data');
                foreach($data as $dataContent)
                {
                    $this->createLog('DELETE PERATURAN','peraturan');
                }
		return $this->deleteProcess($data);
	}
	
	
}
?>