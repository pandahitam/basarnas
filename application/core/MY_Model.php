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
        
        function filterByUserUnkerUnor($query,$unkerControl,$unorControl)
        {
             $extra_qr = $this->extractLimitQuery($query);
			$gorupid_zs_simpeg = $this->session->userdata("gorupid_zs_simpeg");
			if($gorupid_zs_simpeg == '4' ){
				$q_ori = $query;
				
				$temp_kode_unker_zs_simpeg = $this->session->userdata("temp_kode_unker_zs_simpeg");
				$temp_kode_unor_zs_simpeg = $this->session->userdata("temp_kode_unor_zs_simpeg");
				
				if(((str_replace(' ','', strtolower($temp_kode_unker_zs_simpeg))=="badansarnasional") || $temp_kode_unker_zs_simpeg=='107010199414370000KP') && $temp_kode_unor_zs_simpeg!=0){
					if($unorControl == true){
						$split_where = explode(' where ', $extra_qr['query']);
						$query_wo_where = $split_where[0];
						$split_where[0] = '';
						$split_where2 = implode('', $split_where);
					
						$extra_qr['byss'] = "where kode_unor = '".$temp_kode_unor_zs_simpeg."'".(strlen($split_where2) > 1 ? ' and ' : '');
						$q_ori = $query_wo_where.' '.$extra_qr['byss'].' '.$split_where2.' '.$extra_qr['limit_num'];
						
					}
				}else{
					if($unkerControl == true){
						$split_where = explode(' where ', $extra_qr['query']);
						$query_wo_where = $split_where[0];
						$split_where[0] = '';
						$split_where2 = implode('', $split_where);
					
						$extra_qr['byss'] = "where kd_lokasi = '".$temp_kode_unker_zs_simpeg."'".(strlen($split_where2) > 1 ? ' and ' : '');
						$q_ori = $query_wo_where.' '.$extra_qr['byss'].' '.$split_where2.' '.$extra_qr['limit_num'];
					}
				}
			
				return $this->db->query($q_ori);
			}
                        else
                        {
                                return $this->db->query($query);
                        }
        }
        
        /*PARAMS
         * $query = the main query
         * $countQuery = the query for determining the total row of $query
         * $nilaiAssetQuery = query to set total nilai asset in the grid
         * $accessControl = access control for OPD user which can only view their respectives unker or unor data.
         *                  There are 2 options, unker only, and unker and unor
         *                  All query will be filtered again by the access control if the user is opd plus the access control option
         */
        function Get_By_Query_New($query,$countQuery,$accessControl = null,$nilaiAssetQuery =null)
        {
            $unkerControl = false;
            $unorControl = false;
            if(isset($accessControl['unker']))
            {
                $unkerControl = true;
            }
            
            if(isset($accessControl['unor']))
            {
                $unorControl = true;
            }
              
            $total_rph_aset = null;
            $query_count = $this->filterByUserUnkerUnor($countQuery,$unkerControl,$unorControl);
            $count = $query_count->row()->total;
            if($nilaiAssetQuery != null)
            {
                $query_nilai_asset = $this->filterByUserUnkerUnor($nilaiAssetQuery,$unkerControl,$unorControl);
                $total_rph_aset = $query_nilai_asset->row()->nilai_asset;
            }
            $r = $this->filterByUserUnkerUnor($query,$unkerControl,$unorControl);
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
            if($total_rph_aset != null)
            {
                $returnedData['total_rph_aset'] = $total_rph_aset;
            }
            return $returnedData;
              
            
            
        }
	
	function Get_By_Query($query,$isGridFilter = null, $searchByFieldTable =null)
	{	
            $extra_qr = $this->extractLimitQuery($query);
			
			$r = $this->db->query($query);
			
			$gorupid_zs_simpeg = $this->session->userdata("gorupid_zs_simpeg");
			if($gorupid_zs_simpeg == '4' ){
				$q_ori = $query;
				
				$temp_kode_unker_zs_simpeg = $this->session->userdata("temp_kode_unker_zs_simpeg");
				$temp_kode_unor_zs_simpeg = $this->session->userdata("temp_kode_unor_zs_simpeg");
				
				if(((str_replace(' ','', strtolower($temp_kode_unker_zs_simpeg))=="badansarnasional") || $temp_kode_unker_zs_simpeg=='107010199414370000KP') && $temp_kode_unor_zs_simpeg!=0){
					if(strpos($q_ori, 'kode_unor')!==false){
						$split_where = explode(' where ', $extra_qr['query']);
						$query_wo_where = $split_where[0];
						$split_where[0] = '';
						$split_where2 = implode('', $split_where);
					
						$extra_qr['byss'] = "where kode_unor = '".$temp_kode_unor_zs_simpeg."'".(strlen($split_where2) > 1 ? ' and ' : '');
						$q_ori = $query_wo_where.' '.$extra_qr['byss'].' '.$split_where2.' '.$extra_qr['limit_num'];
						
					}
				}else{
					if(strpos($q_ori, 'kd_lokasi')!==false){
						$split_where = explode(' where ', $extra_qr['query']);
						$query_wo_where = $split_where[0];
						$split_where[0] = '';
						$split_where2 = implode('', $split_where);
					
						$extra_qr['byss'] = "where kd_lokasi = '".$temp_kode_unker_zs_simpeg."'".(strlen($split_where2) > 1 ? ' and ' : '');
						$q_ori = $query_wo_where.' '.$extra_qr['byss'].' '.$split_where2.' '.$extra_qr['limit_num'];
					}
				}
			
				$r = $this->db->query($q_ori);
			}
			
            $count = $this->getQueryCountWithoutLimit($extra_qr['query'],$isGridFilter,$searchByFieldTable);
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
        
        function getQueryCountWithoutLimit($noLimitQuery,$isGridFilter,$searchByFieldTable)
        {
            $temp = explode('from',$noLimitQuery,2);
            $temp2 = explode('where',$temp[1],2);
            if(isset($temp2[1]))
            {
//                if($isGridFilter == true)
//                {
//                    $query = "select count(*) as total from ".$this->viewTable." as t where ".$temp2[1];
//                }
//                else if($this->table != null)
//                {
//                    $query = "select count(*) as total from ".$this->table." as t where ".$temp2[1];
//                }
//                else
//                {
//                    $query = "";
//                }
                
                if($isGridFilter == true)
                {
                    $query = "select count(*) as total from ".$this->viewTable." where ".$temp2[1];
                }
                else if($searchByFieldTable != null)
                {
                     $query = "select count(*) as total from ".$searchByFieldTable." where ".$temp2[1];
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
            $tmp1 = $this->Get_By_Query($query); $tmp2 = $tmp1['data'];
            return $tmp2[0];
            
        }
        
        function GetExtAsset_byKode($kd_lokasi,$kd_brg,$no_aset)
        {
            $query = "SELECT * FROM $this->extTable WHERE kd_brg = $kd_brg AND kd_lokasi = '$kd_lokasi' AND no_aset = $no_aset";
            $tmp1 = $this->Get_By_Query($query); $tmp2 = $tmp1['data'];
            return $tmp2[0];
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