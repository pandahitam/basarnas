<?php
class MY_Controller extends CI_Controller{
		
	var $model;
	
	function __construct(){
		parent::__construct();
	}
        
        function parseNumericFilterComparisonOperator($operator)
        {
            if($operator == 'gt')
            {
                return '>';
            }
            else if($operator == 'lt')
            {
                return '<';
            }
            else if($operator == 'eq')
            {
                return '=';
            }
        }
        
        function generateFilterQueryString($filter)
        {
            $filterData= json_decode($filter);
            $queryString = "";
            
            for($i = 0; $i<count($filterData); $i++)
            {
                if($i == count($filterData)-1)
                {
                    if($filterData[$i]->type == 'numeric')
                    {
                        $queryString .= $filterData[$i]->field.' '.$this->parseNumericFilterComparisonOperator($filterData[$i]->comparison). ' '.$filterData[$i]->value;
    //                    $this->db->where($filterData->field.' '.$this->parseNumericFilterComparisonOperator($this->comparison),$filterData->value);
                    }
                    else if($filterData[$i]->type == 'string')
                    {
                        $queryString .= $filterData[$i]->field." LIKE '%".$filterData[$i]->value."%'";
//                        $this->db->like($filterData[$i]->field,$filterData->value);
                    }
                    else
                    {
                        $queryString = null;
                    }
                }
                else
                {
                    if($filterData[$i]->type == 'numeric')
                    {
                        $queryString .= $filterData[$i]->field.' '.$this->parseNumericFilterComparisonOperator($filterData[$i]->comparison). ' '.$filterData[$i]->value.' AND ';
    //                    $this->db->where($filterData->field.' '.$this->parseNumericFilterComparisonOperator($this->comparison),$filterData->value);
                    }
                    else if($filterData[$i]->type == 'string')
                    {
                        $queryString .= $filterData[$i]->field." LIKE '%".$filterData[$i]->value."%' AND ";
//                        $this->db->like($filterData[$i]->field,$filterData[$i]->value);
                    }
                    else
                    {
                        $queryString = null;
                    }
                }
            }
//            foreach($decodedJson as $filterData)
//            {
//                if($filterData->type == 'numeric')
//                {
//                    $queryString .= $filterData->field.' '.$this->parseNumericFilterComparisonOperator($filterData->comparison). ' '."'$filterData->value'".' AND ';
////                    $this->db->where($filterData->field.' '.$this->parseNumericFilterComparisonOperator($this->comparison),$filterData->value);
//                }
//                else if($filterData->type == 'string')
//                {
//                    $queryString .= $filterData->field.' LIKE %'.$filterData->value."% AND ";
//                    $this->db->like($filterData->field,$filterData->value);
//                }
//            }
//            $this->db->get();
//            
//            $queryString = $this->db->_compile_select();
            return $queryString;
            
        }
	
	function getAllData(){
//                var_dump(json_decode($_POST['filter']));
//                die;
            
		$searchByBarcode =  null;
                $start = null;
                $limit = null;
                $filterString = null;
                $searchByField = null;
                
                
                if(isset($_POST['gridFilter']))
                {
                    $filterString = $this->generateFilterQueryString($_POST['gridFilter']);
                }
                
                if(isset($_POST['query']))
                {
                    //$this->model->get_FilteredData(json_decode($_POST['filter']));
		    $searchByBarcode = $_POST['query'];
                }
                
                if(isset($_POST['search']))
                {
                    //$this->model->get_FilteredData(json_decode($_POST['filter']));
		    $searchByField = $_POST['search'];
                }
                
                
                if(isset($_POST['start']) && isset($_POST['limit']))
                {
                    $start = $_POST['start'];
                    $limit = $_POST['limit'];
                }
                
		$queryData = $this->model->get_AllData($start,$limit,$searchByBarcode,$filterString,$searchByField);
//                $total = $this->model->get_CountData();
//                $countData = $this->model->get_AllData();              
//                $total = count($countData);
                $dataSend['total'] = $queryData['count'];
		$dataSend['results'] = $queryData['data'];
                if(isset($queryData['total_rph_aset']))
                {
                    $dataSend['total_rph_aset'] = $queryData['total_rph_aset'];
                }
                
		echo json_encode($dataSend);
	}
	
	function modifyData($dataSimak,$dataExt){		
		$status = $this->model->Modify_Data($dataSimak,$dataExt);	 
                
                if (isset($status))
                {
                    if($status === 2){
                            echo "{success:true, info: { reason: 'Sukses merubah data !' }}";
                    }else if($status === 1){
                            echo "{success:true, info: { reason: 'Sukses menambah data !' }}";
                    }else{
                            echo "{success:false, info: { reason: 'Gagal memodifikasi data !' }}";
                    }
                }
                else
                {
                    echo "Model Error";
                }
	}
	
	function deleteData($dataDeleted)
	{
		$fail = array();
		$success = true;
		
		foreach($dataDeleted as $keys)
		{
                        $smkDeleted = array('kd_lokasi' => $keys['kd_lokasi'],
                                            'kd_brg' => $keys['kd_brg'],
                                            'no_aset'=> $keys['no_aset']);
                        
                        if(isset($keys['id']))
                        {
                            if($this->model->Delete_Data($smkDeleted,$keys['id']) == FALSE)
                            {
                                    $success = false;
                            }
                        }
                        else
                        {
                            if($this->model->Delete_Data($smkDeleted) == FALSE)
                            {
                                    $success = false;
                            }
                        }
			
		}
		
		$result = array('fail' => $fail,
                                'success'=>$success);
						
		echo json_encode($result);
	}
        
        function deleteProcess($dataDeleted)
        {
            $fail = array();
            $success = true;

            foreach($dataDeleted as $keys)
            {
                    if($this->model->Delete_Data(null,$keys['id']) == FALSE)
                    {
                        $success = false;
                    }
            }

            $result = array('fail' => $fail,
                            'success'=>$success);

            echo json_encode($result);
        }
        
        function codeGenerator($dataKode)
        {
            return implode("",$dataKode);
        }
        
        function kodeKlasifikasiAsetGenerator($dataKlasifikasi)
        {
            return implode("",$dataKlasifikasi);
        }
        
        function noAssetGenerator($kd_brg, $kd_lokasi)
        {
            
            $this->db->where("kd_brg",$kd_brg);
            $this->db->where("kd_lokasi",$kd_lokasi);
            $this->db->order_by("no_aset",'desc');
            $query = $this->db->get('view_noasetgenerator');
            $result = $query->row();
            if($query->num_rows() === 0)
            {
                return '0';
            }
            else
            {
                if($result->no_aset != null && $result->no_aset != '')
                {
                    $previous_no_aset = $result->no_aset;
                    $incrementor = (int)$previous_no_aset + 1;
                    return $incrementor;
                }
                else
                {
                    return '0';
                }
                
            }
            return '0';
        }
        
        function createLog($description,$table_name)
        {
            $data = array(
                'logIP'=>$this->session->userdata("ip_address"),
                'logDateTime'=>date('Y-m-d H:i:s'),
                'logUser'=>$this->session->userdata("user_zs_simpeg"),
                'description'=>$description.' ('.$table_name.') ID_USER='.$this->session->userdata("iduser_zs_simpeg").' NIP='.$this->session->userdata("nip_zs_simpeg"),
            );
            
            $this->db->insert('tlog',$data);
        }
		
}
?>