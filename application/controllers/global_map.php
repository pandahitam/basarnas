<?php
class Global_MAP extends MY_Controller {
	function __construct() 
	{
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE)
		{
 			echo "window.location = '".base_url()."user/index';";
 			exit;
		}
		$this->load->model('global_map_model','',TRUE);
		$this->model = $this->global_map_model;
	}
	
	function index()
	{
		if($this->input->post('id_open'))
		{
			$data['jsscript'] = TRUE;
			$this->load->view('global_map/global_map_view', $data);
		}else
		{
			$this->load->view('global_map/global_map_view');
		}
	}

   function req_all_asset($location)
	{
        $dataOut = array();
		$this->load->model('global_map_model');
		$result =  $this->global_map_model->get_byLoc($location);
		foreach($result as $obj)
		{
			$dataOut[] = $obj;
		}
		echo json_encode($dataOut);
	}
	
   function map_pop_up($location)
	{
		if($this->input->post("id_open") && $this->session->userdata("iduser_zs_simpeg"))
		{
			$data['jsscript'] = TRUE;
			$data['location'] = $location;
			$this->load->view('global_map/map_pop_up_view', $data);
		} else
		{
			$this->load->view('global_map/map_pop_up_view');
		}		
	}

}
?>