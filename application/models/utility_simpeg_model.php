<?php
class Utility_Simpeg_Model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get_QUERY_Logs(){
    $this->db->select('*');
    $this->db->from('tLog');
	}

	function get_AllData_Logs(){
		$data = array();
		
		$this->get_QUERY_Logs();
		
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
		
   	$this->db->limit($limit, $start);
   	$this->db->order_by("logDateTime", "DESC");
    $Q = $this->db->get();
    foreach ($Q->result() as $obj)
    {
    	$data[] = $obj;
    }    		
    return $data;
	}
	
	function get_CountData_Logs(){
		$this->get_QUERY_Logs();
		return $this->db->count_all_results();
	}
}
?>