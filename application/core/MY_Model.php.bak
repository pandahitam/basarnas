<?php
class MY_Model extends CI_Model{
	
	var $table;
        var $extTable;
        var $viewTable;
        var $countTable;
	var $limit = 100;
        
	function __construct(){
		parent::__construct();
	}
	
	function Get_By_Query($query)
	{
		$query_ex = explode("limit", strtolower($query));
		$query = trim($query_ex[0]);
		
		$explode_char_tbl = explode('.ur_upb as nama_unker',$query);
		$table_alisa = 'c';
		if(isset($explode_char_tbl[0])){
			$table_alisa = substr($explode_char_tbl[0], -1);
		}
		
		$limit_num = null;
		if(isset($query_ex[1])){
			$limit_num = " LIMIT ".trim($query_ex[1]);
		}
		
		$filter = null;
		
                if(isset($_POST['filter']))
                {
			$filter = json_decode($_POST['filter']);
		}
		
		$statusx = false;
		if(count($filter) > 0){
			if(isset($filter[0]->field)){
				$statusx = true;
			}
		}
		if($statusx){
			$temp_query = " where ";
			$statusloopex = false;
			foreach($filter as $key=>$value)
			{
				$temp = null;
				switch($value->field){
					case "nama_unker" :
						$temp = $table_alisa.".ur_upb";
						break;
				}
				if($temp!=null){
					$statusloopex = true;
					$temp_query.=$temp." like '%".$value->value."%'";
				}
			}
			if($statusloopex){
				$query.= $temp_query;
			}
		}
		if($limit_num!=null){
			$query .= $limit_num;
		}
		
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
//		$this->db->get("$this->table");
//                
//                var_dump($this->db->count_all_results("$this->table"));
//                die;
            if($this->countTable != null)
            {
                return $this->db->count_all_results("$this->countTable");
            }
            else
            {
                return $this->db->count_all_results("$this->table");
            }
            
            
		
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