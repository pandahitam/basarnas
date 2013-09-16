<?php
class services extends MY_Controller {

	function __construct() {
		parent::__construct();
 		
                $this->load->model('master_model','',TRUE);
		$this->model = $this->master_model;
	}

   	function assetByKode($kd_brg = null, $kd_lokasi = null, $no_aset = null)
        {
            $result = null;
            if (isset($kd_brg) && isset($kd_lokasi) && isset($no_aset))
            {
                $temp = $this->model->AssetForMobileServicesWithFilter($kd_brg,$kd_lokasi,$no_aset);
                $result = $temp[0];
                $imageArray = explode(",", $result->image_url);
                $images = array();
                foreach ($imageArray as $str)
                {
                    $img_src = base_url() . 'uploads/images/' . $str;
                    $type = pathinfo($img_src, PATHINFO_EXTENSION);
                    $imgbinary = file_get_contents($img_src);
                    $images[] = array("type" => $type, "data" => base64_encode($imgbinary));
                    clearstatcache();
                }

                $result->images = json_encode($images);
            }
            
            
            
            echo json_encode($result);
        }
        
        function updateAssetByKode()
        {
            $result = 0;
            $data = $_POST["data"];
            if (isset($data))
            {
                if (isset($data['kd_brg']) && isset($data['kd_lokasi']) && isset($data['no_aset']) && isset($data['table']) )
                {
                    $result = $this->model->UpdateAssetForMobileServices($data);
                }
            }
            
            echo json_encode($result);
        }
	
        function assetByPart($partNumber = "", $serialNumber = "")
        {
            
        }
}
?>