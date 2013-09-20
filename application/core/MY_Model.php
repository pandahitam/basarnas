<?php
class MY_Model extends CI_Model{
	
	var $table;
        var $extTable;
        var $viewTable;
        var $countTable;
	var $limit = 100;
	var $query_semar = null;
        
	function __construct(){
		parent::__construct();
	}
	
	function cariAliasTable($query, $fieldname){
		
		$table_alisa = "";
		
		$explode_char_tbl = explode($fieldname,$query);
		if(isset($explode_char_tbl[0])){
			$table_alisa = substr($explode_char_tbl[0], -1).".";
		}
		
		if(strpos($query, $fieldname)==false){
			$table_alisa = "";
		}
			
		return $table_alisa;
	}
	
	function extractLimitQuery($query){
		$query_ex = explode("limit", strtolower($query));
		$query = trim($query_ex[0]);
		
		$limit_num = null;
		if(isset($query_ex[1])){
			$limit_num = " LIMIT ".trim($query_ex[1]);
		}
		return array('limit_num'=>$limit_num, 'query'=>$query);
	}
	
	function checkingFieldAllowed($property){
		$status = false;
		switch($property){
			case "kd_brg" :
				$status = true;
			break;
		}
		return $status;
	}
	
	function makeQueryLikeFromFields($query, $likeme){
		$query_ex = explode("from", strtolower($query));
		$query = trim($query_ex[0]);
		
		$query_ex = explode("select", strtolower($query));
		if(count($query_ex) > 0){
			$query_like_or = array();
			$query = trim($query_ex[1]);
			$fields = explode(',', $query);
			foreach($fields as $key => $value){
				$extrac_aliasn = explode(' as ', trim($value));
				$query_like_or[] = trim($extrac_aliasn[0])." like '%".$likeme."%'";
			}
			return $query_like_or;
		}else{
			return false;
		}
	}
	
	function Get_By_Query($query)
	{
		$extra_qr = $this->extractLimitQuery($query);
		$query = $extra_qr['query'];
		$limit_num = $extra_qr['limit_num'];
		
		$filter = null;
		$query_pencarian = null;
                if(isset($_POST['query']))
                {
			$query_pencarian = $_POST['query'];
		}
		
                if(isset($_POST['filter']))
                {
			$filter = json_decode($_POST['filter']);
		}
		
		$statusx = 0;
		$statusx_query = 0;
		
		if($query_pencarian!=null && strlen($query_pencarian) > 0){
			$statusx_query = 1;
		}
		
		if(count($filter) > 0){
			if(isset($filter[0]->field)){
				$statusx = 1;
			}else if($this->checkingFieldAllowed($filter[0]->property)){
				$statusx = 2;
			}
		}
		$filter_lainnya = false;
		if(($statusx == 1 || $statusx == 2) && $statusx_query == 0){
			$temp_query = " where ";
			$statusloopex = false;
			foreach($filter as $key=>$value)
			{
				$temp = null;
				if($statusx == 1){
					
					switch($value->field){
						case "nama_unker" :
							$table_alisa = $this->cariAliasTable($query, '.ur_upb as nama_unker');
							$temp = $table_alisa."ur_upb";
							break;
						case "kd_brg" :
							$table_alisa = $this->cariAliasTable($query, '.kd_brg');
							$temp = $table_alisa."kd_brg";
							break;
					}
				}else if($statusx == 2){
					switch($value->property){
						case "kd_brg" :
							$table_alisa = $this->cariAliasTable($query, '.kd_brg');
							$temp = $table_alisa."kd_brg";
							break;
					}
				}
				if($temp!=null){
					$statusloopex = true;
					$temp_query.=$temp." like '%".$value->value."%'";
				}
			}
			if($statusloopex){
				$filter_lainnya = true;
				$query.= $temp_query;
			}
		}else if($statusx_query == 1){
			$temp_query = "";
			if($filter_lainnya==false){
				$temp_query = " where ";
			}else{
				$temp_query = " or ";
			}
			$statusloopex = false;
			$makeQueryLikeFromFields = $this->makeQueryLikeFromFields($query, $query_pencarian);
			if(count($makeQueryLikeFromFields) > 0){
				$statusloopex = true;
				$temp_query.= implode(" or ", $makeQueryLikeFromFields);
			}
			if($statusloopex){
				$query.= $temp_query;
			}
		}
		$this->query_semar = $query;
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
		if($this->query_semar!=null){
			if($this->countTable != null)
			{
			    //return $this->db->count_all_results("$this->countTable");
			    $r_count = $this->db->query($this->query_semar);
			    return $r_count->num_rows();
			}
			else
			{
			    //return $this->db->count_all_results("$this->table");
			    $r_count = $this->db->query($this->query_semar);
			    return $r_count->num_rows();
			}
		}else{
			if($this->countTable != null)
			{
			    return $this->db->count_all_results("$this->countTable");
			}
			else
			{
			    return $this->db->count_all_results("$this->table");
			}
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