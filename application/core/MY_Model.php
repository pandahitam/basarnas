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
	
	function Get_By_Query($query,$isGridFilter = null)
	{	
            $extra_qr = $this->extractLimitQuery($query);
            $r = $this->db->query($query);
            $count = $this->getQueryCountWithoutLimit($extra_qr['query'],$isGridFilter);
            $data = array();
            if ($r->num_rows() > 0)
            {
                foreach ($r->result() as $obj)
                {
                    $data[] = $obj;
                }  
            }


            $r->free_result();

            $returnedData = array(
                'data'=>$data,
                'count'=>$count,
            );
            return $returnedData;
//            $r = $this->db->query($query);
//            $data = array();
//            if ($r->num_rows() > 0)
//            {
//                foreach ($r->result() as $obj)
//                {
//                    $data[] = $obj;
//                }  
//            }
//
//
//            $r->free_result();
//	    return $data;
	}
        
        function getQueryCountWithoutLimit($noLimitQuery,$isGridFilter)
        {
            $temp = explode('from',$noLimitQuery,2);
            $temp2 = explode('where',$temp[1],2);
            if(isset($temp2[1]))
            {
                if($isGridFilter == true)
                {
                    $query = "select count(*) as total from ".$this->viewTable." as t where ".$temp2[1];
                }
                else if($this->table != null)
                {
                    $query = "select count(*) as total from ".$this->table." as t where ".$temp2[1];
                }
                else
                {
                    $query = "";
                }
                
            }
            else
            {
                if($isGridFilter == true)
                {
                    $query = "select count(*) as total from $this->viewTable";
                }
                else
                {
                    
                    if($this->countTable != null)
                    {
                         $query = "select count(*) as total from $this->countTable";
                    }
                    else if($this->table != null)
                    {
                         $query = "select count(*) as total from $this->table";
                    }
                    else
                    {
                        $query = "";
                    }
                   
                }
                
            }
            
            if($query != "")
            {
                    $count = $this->db->query($query);
                    return $count->row()->total;
                
            }
            else
            {
                return null;
            }
            
        }
        
        function GetAsset_byKode($kd_lokasi,$kd_brg,$no_aset)
        {
            $query = "SELECT * FROM $this->table WHERE kd_brg = $kd_brg AND kd_lokasi = '$kd_lokasi' AND no_aset = $no_aset";
            
            return $this->Get_By_Query($query)['data'][0];
            
        }
        
        function GetExtAsset_byKode($kd_lokasi,$kd_brg,$no_aset)
        {
            $query = "SELECT * FROM $this->extTable WHERE kd_brg = $kd_brg AND kd_lokasi = '$kd_lokasi' AND no_aset = $no_aset";
            
            return $this->Get_By_Query($query)['data'][0];
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