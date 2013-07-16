<?php
class MY_Model extends CI_Model{
	
	var $table;
        var $extTable;
        var $viewTable;
	var $limit = 100;
        
	function __construct(){
		parent::__construct();
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
	
	/**
	* @param int $id
	* @param array $arrayData
	* @return 1 -> succes insert
	* 		  2 -> succes update 
	*/
	function Modify_Data($dataSimak,$dataExt){
            
            if (isset($dataSimak))
            {
                $this->db->set($dataSimak);
                $this->db->replace($this->table);
            }

            if (isset($dataExt))
            {
                $this->db->set($dataExt);
                $this->db->replace($this->extTable);
            }

            return 1;
	}
	
	/**
	* @param int $id
	* @return TRUE if succes
	*/
	function Delete_Data($arrayKey,$idExt){
            if (isset($arrayKey))
            {
                $this->db->where($arrayKey);
		$this->db->delete($this->table);
            }
            
            if (isset($idExt))
            {
		$this->db->where('id', $idExt);
		$this->db->delete($this->extTable);
            }
            
            return TRUE;
	}
	
	function get_CountData(){
		$this->db->get($this->table);
		return $this->db->count_all_results();
	}
	
	
	function prepare_Query($array){
		if(isset($array)){
			$result = '';	
			for($i = 0;$i<count($array);$i++){
				if($i == (count($array)-1)){
					$result .= $array;	
				}else{
					$result .= $array[$i].', ';
				}
				
			}
			return $result;
		}
	}
}
?>