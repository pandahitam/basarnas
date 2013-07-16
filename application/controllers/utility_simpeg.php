<?php
class Utility_SIMPEG extends CI_Controller {
	function __construct() {
		parent::__construct();
 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
    }
    $this->load->model('Utility_Simpeg_Model','',TRUE);
	}
	
	function index(){
		echo "";
	}
	
	function backup_db(){
		// ON DEMOND SET PHP.INI
	 	ini_set("max_execution_time","900");
	 	ini_set("max_input_time","1800");
	 	ini_set("memory_limit","384M");

		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup();
		
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file('./assets/temp/mybackup.gz', $backup);
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download('mybackup.gz', $backup); 
	}

	function backup_table(){
		// ON DEMOND SET PHP.INI
	 	ini_set("max_execution_time","900");
	 	ini_set("max_input_time","1800");
	 	ini_set("memory_limit","384M");

		// Load the DB utility class
		$this->load->dbutil();
		
		$table = array('tables' => 'tPegawai', 'newline' => '\n');
		$backup =& $this->dbutil->backup($table);
		
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file('./assets/temp/mybackup/'.$table['tables'].".sql.zip", $backup);
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($table['tables'].".sql.zip", $backup);
	}
	
	function optimize_db(){
		$this->load->dbutil();
		$result = $this->dbutil->optimize_database();
		if ($result !== FALSE){
			 print_r($result);
		}
	}

	function optimize_tables(){
		$this->load->dbutil();
		$Q = $this->db->query("SHOW TABLES");
		if($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				if ($this->dbutil->optimize_table($row[0])){
				}				
			}
		}
	}
	
	function convert_to_csv($filename="csv_file"){
		$this->load->dbutil();
		$delimiter = ",";
		$newline = "\r\n";
		$query = $this->db->query("SELECT * FROM tView_Pegawai_Biodata WHERE kode_dupeg = 17");		
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline); 
		/*
		if ( ! write_file('./assets/temp/test.csv', $data)){
			echo 'Unable to write the file';
		}else{
		  echo 'File written!';
		}
		*/
		// Output to browser with appropriate mime type, you choose
		@header("Content-type: text/x-csv");
		@header("Content-Disposition: attachment; filename=".$filename.".csv");
		echo $data;
	}

	// START -USER LOGS
	function logs_user(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('logs_user_view',$data);
		}else{
			$this->load->view('logs_user_view');
		}
	}

	function logs_user_data(){
		if($this->input->post('id_open')){
			$data = $this->Utility_Simpeg_Model->get_AllData_Logs();	  			 	
			$total = $this->Utility_Simpeg_Model->get_CountData_Logs();	  
   		echo '({total:'. $total . ',results:'.json_encode($data).'})';
		}
	}
	// START -USER LOGS
	
	function database_tools(){
		if($this->input->post('id_open')){
			$data['jsscript'] = TRUE;
			$this->load->view('database_tools_view',$data);
		}else{
			$this->load->view('database_tools_view');
		}
	}
	
	function run_sql(){
		if($this->input->post('id_open') == 1){
			if($this->input->post('str_sql')){
				$sql = $this->db->query($this->input->post('str_sql'));
				if($sql){
					echo "Sukses Query :<br>". $this->db->last_query();
				}else{
					echo $this->db->_error_message();
				}
			}else{
				echo "GAGAL";
			}
		}
	}

	function restore_db_simpeg(){
		if($this->input->post('id_open') == 1){
			echo "{success:true, reason: 'SUKSES'}";
		}else{
			echo "{success:false, reason: 'GAGAL'}";
		}
	}

}
?>