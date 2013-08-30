<?php
class MY_Controller extends CI_Controller{
		
	var $model;
	
	function __construct(){
		parent::__construct();
	}
	
	function getAllData(){
                $start = null;
                $limit = null;
                if(isset($_POST['start']) && isset($_POST['limit']))
                {
                    $start = $_POST['start'];
                    $limit = $_POST['limit'];
                }
                
		$data = $this->model->get_AllData($start,$limit);
                $total = $this->model->get_CountData();
                $dataSend['total'] = $total;
		$dataSend['results'] = $data;
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
		
}
?>