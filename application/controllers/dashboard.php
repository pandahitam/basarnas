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

}
?>