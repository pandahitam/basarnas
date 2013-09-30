<?php

class services extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('master_model', '', TRUE);
        $this->model = $this->master_model;
    }

    function assetByKode($kd_brg = null, $kd_lokasi = null, $no_aset = null) {
        $result = null;
        if (isset($kd_brg) && isset($kd_lokasi) && isset($no_aset)) {
            $asset = $this->model->AssetForMobileServicesWithFilter($kd_brg, $kd_lokasi, $no_aset);
            if (isset($asset) && count($asset) > 0) {
                $temp = $asset[0];
                $images = array();
                if (isset($temp->image_url)) {
                    $imageArray = explode(",", $temp->image_url);


                    foreach ($imageArray as $str) {
                        $img_src = base_url() . 'uploads/images/' . $str;
                        $type = pathinfo($img_src, PATHINFO_EXTENSION);
                        $imgbinary = file_get_contents($img_src);
                        $images[] = array("type" => $type, "data" => base64_encode($imgbinary));
                        clearstatcache();
                    }
                } else {
                    $temp->image_url = "";
                }

                $temp->images = json_encode($images);
                $result = get_object_vars($temp);
                
                foreach($result as $key => $value)
                {
                    $result[$key] = trim($value);
                }
            }
        }



        echo json_encode($result);
    }

    function updateAssetByKode() {
        $result = 0;
        $data = $_POST["data"];
        if (isset($data)) {
            if (isset($data['kd_brg']) && isset($data['kd_lokasi']) && isset($data['no_aset']) && isset($data['table'])) {
                $result = $this->model->UpdateAssetForMobileServices($data);
            }
        }

        echo json_encode($result);
    }

}

?>