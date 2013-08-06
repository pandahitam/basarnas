<?php
class MY_Controller extends CI_Controller{
		
	var $model;
	
	function __construct(){
		parent::__construct();
	}
	
	function getAllData(){
		$data = $this->model->get_AllData();
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
                        
			if($this->model->Delete_Data($smkDeleted,$keys['id']) == FALSE)
			{
				$success = false;
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
        
        function noAssetGenerator($kd_brg, $kd_lokasi)
        {
            return $kd_brg.$kd_lokasi;
        }
		
}
?>