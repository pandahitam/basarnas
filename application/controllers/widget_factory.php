<?php
class Widget_Factory extends CI_Controller {

	function __construct() {
		parent::__construct();
                
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                	
	}
	
	function form(){
            $data['jsscript'] = TRUE;
            $this->load->view('widget_factory/form_factory',$data);
	}
        
        function grid(){
            $data['jsscript'] = TRUE;
            $this->load->view('widget_factory/grid_factory',$data);

	}
        function window(){
            $data['jsscript'] = TRUE;
            $this->load->view('widget_factory/window_factory',$data);
	}
        function model(){
            $this->load->view('widget_factory/model_factory');
        }
        function data(){
            $this->load->view('widget_factory/data_factory');
        }
	
}
?>