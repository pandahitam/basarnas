<?php

class master_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    // Return all type of asset
    function AllAsset() {
        $query = '(SELECT c.ur_upb as unker, b.ur_sskel as nama, b.kd_brg, t.kd_lokasi, t.no_aset, b.kd_gol, b.kd_bid, b.kd_kel, b.kd_skel, b.kd_sskel 
            FROM `asset_alatbesar` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LEFT JOIN ref_unker as c ON t.`kd_lokasi` = c.kdlok)
            UNION
            (SELECT c.ur_upb as unker, b.ur_sskel as nama, b.kd_brg, t.kd_lokasi, t.no_aset, b.kd_gol, b.kd_bid, b.kd_kel, b.kd_skel, b.kd_sskel 
            FROM `asset_angkutan` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LEFT JOIN ref_unker as c ON t.`kd_lokasi` = c.kdlok)
            UNION
            (SELECT c.ur_upb as unker, b.ur_sskel as nama, b.kd_brg, t.kd_lokasi, t.no_aset, b.kd_gol, b.kd_bid, b.kd_kel, b.kd_skel, b.kd_sskel 
            FROM `asset_bangunan` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LEFT JOIN ref_unker as c ON t.`kd_lokasi` = c.kdlok)
            UNION
            (SELECT c.ur_upb as unker, b.ur_sskel as nama, b.kd_brg, t.kd_lokasi, t.no_aset, b.kd_gol, b.kd_bid, b.kd_kel, b.kd_skel, b.kd_sskel 
            FROM `asset_perairan` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LEFT JOIN ref_unker as c ON t.`kd_lokasi` = c.kdlok)
            UNION
            (SELECT c.ur_upb as unker, b.ur_sskel as nama, b.kd_brg, t.kd_lokasi, t.no_aset, b.kd_gol, b.kd_bid, b.kd_kel, b.kd_skel, b.kd_sskel 
            FROM `asset_senjata` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LEFT JOIN ref_unker as c ON t.`kd_lokasi` = c.kdlok)
            UNION
            (SELECT c.ur_upb as unker, b.ur_sskel as nama, b.kd_brg, t.kd_lokasi, t.no_aset, b.kd_gol, b.kd_bid, b.kd_kel, b.kd_skel, b.kd_sskel 
            FROM `asset_tanah` as t LEFT JOIN ref_subsubkel as b ON t.`kd_brg` = b.`kd_brg` LEFT JOIN ref_unker as c ON t.`kd_lokasi` = c.kdlok)';

        $data = $this->Get_By_Query($query);
        return $data['data'];
    }
    
    // Return all reference asset from ref_subsubkel table
    function AllRefBarang() {
        $query = 'SELECT kd_gol,kd_bid,kd_kel, kd_skel, kd_sskel, kd_brg, ur_sskel as nama FROM `ref_subsubkel`';
        $data = $this->Get_By_Query($query);
        return $data['data'];
    }

    // return all type of asset that use in mobile services
    /*function AllAssetForMobileServices() {
        $query = "SELECT master.*, ref.ur_sskel as nama_barang, reflok.ur_upb as nama_unker FROM 
            (SELECT t.kd_brg as kode_barang, t.kd_lokasi as kode_lokasi, t.no_aset, tgl_prl as tanggal_perolehan, b.image_url, dari, no_dana, 
            (CASE WHEN kondisi = '1' THEN 'Baik' WHEN kondisi = '2' THEN 'Rusak Ringan' WHEN kondisi = '3' THEN 'Rusak Berat' END) 
            as kondisi, 1 FROM asset_alatbesar as t LEFT JOIN ext_asset_alatbesar as b ON t.kd_brg = b.kd_brg AND t.kd_lokasi = b.kd_lokasi AND t.no_aset = b.no_aset
            UNION
            SELECT t.kd_brg, t.kd_lokasi, t.no_aset, t.tgl_prl,b.image_url, t.dari, t.no_dana, 
            (CASE WHEN kondisi = '1' THEN 'Baik' WHEN kondisi = '2' THEN 'Rusak Ringan' WHEN kondisi = '3' THEN 'Rusak Berat' END) 
            as kondisi, 2 FROM asset_angkutan as t LEFT JOIN ext_asset_angkutan as b ON t.kd_brg = b.kd_brg AND t.kd_lokasi = b.kd_lokasi AND t.no_aset = b.no_aset
            UNION
            SELECT kd_brg, kd_lokasi, no_aset, tanggal_perolehan, image_url, dari, no_dana,
            (CASE WHEN kondisi = '1' THEN 'Baik' WHEN kondisi = '2' THEN 'Rusak Ringan' WHEN kondisi = '3' THEN 'Rusak Berat' END) 
            as kondisi, 3 FROM asset_perlengkapan) as master 
            LEFT JOIN ref_subsubkel as ref ON master.kode_barang = ref.kd_brg LEFT JOIN ref_unker as reflok ON master.kode_lokasi = reflok.kdlok
            ";

        $data = $this->Get_By_Query($query);
        return $data['data'];
    }*/

    // filtering asset for mobile services by kd_brg, kd_lokasi, no_aset
    function AssetForMobileServicesWithFilter($kd_brg, $kd_lokasi, $no_aset) {
        $kondisi = Array("-" => "-", "1"=>"Baik", "2"=>"Rusak Ringan", "3"=>"Rusak Berat");
		$query /* kayaknya paling panjang */ = " 
				SELECT `x`.*, `y`.`ur_sskel` AS `nama_barang`, `z`.`ur_upb` AS `nama_unker`
				FROM
				(
					SELECT `m`.`kd_brg` AS `kode_barang`, `m`.kd_lokasi AS `kode_lokasi`, `m`.no_aset, `m`.tgl_prl AS `tanggal_perolehan`, `e`.image_url, `m`.dari, `m`.no_dana, `m`.kondisi
							FROM 
							( SELECT kd_brg, kd_lokasi, no_aset, tgl_prl, dari, no_dana, kondisi FROM asset_alatbesar WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `m`
							INNER JOIN
							( SELECT kd_brg, kd_lokasi, no_aset, image_url FROM ext_asset_alatbesar WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `e`
							ON `m`.`kd_brg` = `e`.`kd_brg` AND `m`.`kd_lokasi` = `e`.`kd_lokasi` AND `m`.`no_aset` = `e`.`no_aset`
					UNION
					SELECT `m`.`kd_brg` AS `kode_barang`, `m`.kd_lokasi AS `kode_lokasi`, `m`.no_aset, `m`.tgl_prl AS `tanggal_perolehan`, `e`.image_url, `m`.dari, `m`.no_dana, `m`.kondisi
							FROM 
							( SELECT kd_brg, kd_lokasi, no_aset, tgl_prl, dari, no_dana, kondisi FROM asset_angkutan WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `m`
							INNER JOIN
							( SELECT kd_brg, kd_lokasi, no_aset, image_url FROM ext_asset_angkutan WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `e`
							ON `m`.`kd_brg` = `e`.`kd_brg` AND `m`.`kd_lokasi` = `e`.`kd_lokasi` AND `m`.`no_aset` = `e`.`no_aset`
					UNION
					SELECT `m`.`kd_brg` AS `kode_barang`, `m`.kd_lokasi AS `kode_lokasi`, `m`.no_aset, `m`.tgl_prl AS `tanggal_perolehan`, `e`.image_url, `m`.dari, `m`.no_dana, `m`.kondisi
							FROM 
							( SELECT kd_brg, kd_lokasi, no_aset, tgl_prl, dari, no_dana, kondisi FROM asset_bangunan WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `m`
							INNER JOIN
							( SELECT kd_brg, kd_lokasi, no_aset, image_url FROM ext_asset_bangunan WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `e`
							ON `m`.`kd_brg` = `e`.`kd_brg` AND `m`.`kd_lokasi` = `e`.`kd_lokasi` AND `m`.`no_aset` = `e`.`no_aset`
					UNION
					SELECT `m`.`kd_brg` AS `kode_barang`, `m`.kd_lokasi AS `kode_lokasi`, `m`.no_aset, `m`.tgl_prl AS `tanggal_perolehan`, `e`.image_url, `m`.dari, `m`.no_dana, `m`.kondisi
							FROM 
							( SELECT kd_brg, kd_lokasi, no_aset, tgl_prl, dari, no_dana, kondisi FROM asset_perairan WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `m`
							INNER JOIN
							( SELECT kd_brg, kd_lokasi, no_aset, image_url FROM ext_asset_perairan WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `e`
							ON `m`.`kd_brg` = `e`.`kd_brg` AND `m`.`kd_lokasi` = `e`.`kd_lokasi` AND `m`.`no_aset` = `e`.`no_aset`
					UNION
					SELECT `m`.`kd_brg` AS `kode_barang`, `m`.kd_lokasi AS `kode_lokasi`, `m`.no_aset, `m`.tgl_prl AS `tanggal_perolehan`, `e`.image_url, `m`.dari, `m`.no_dana, `m`.kondisi
							FROM 
							( SELECT kd_brg, kd_lokasi, no_aset, tgl_prl, dari, no_dana, kondisi FROM asset_senjata WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `m`
							INNER JOIN
							( SELECT kd_brg, kd_lokasi, no_aset, image_url FROM ext_asset_senjata WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `e`
							ON `m`.`kd_brg` = `e`.`kd_brg` AND `m`.`kd_lokasi` = `e`.`kd_lokasi` AND `m`.`no_aset` = `e`.`no_aset`
					UNION
					SELECT `m`.`kd_brg` AS `kode_barang`, `m`.kd_lokasi AS `kode_lokasi`, `m`.no_aset, `m`.tgl_prl AS `tanggal_perolehan`, `e`.image_url, `m`.dari, `m`.no_dana, `m`.kondisi
							FROM 
							( SELECT kd_brg, kd_lokasi, no_aset, tgl_prl, dari, no_dana, \"-\" as `kondisi` FROM asset_tanah WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `m`
							INNER JOIN
							( SELECT kd_brg, kd_lokasi, no_aset, image_url FROM ext_asset_tanah WHERE kd_brg=\"$kd_brg\" AND kd_lokasi =\"$kd_lokasi\" AND no_aset=\"$no_aset\" ) AS `e`
							ON `m`.`kd_brg` = `e`.`kd_brg` AND `m`.`kd_lokasi` = `e`.`kd_lokasi` AND `m`.`no_aset` = `e`.`no_aset`
				) AS `x`
				INNER JOIN ref_subsubkel AS `y` ON `x`.`kode_barang` = `y`.kd_brg
				INNER JOIN ref_unker AS `z` ON `x`.kode_lokasi = `z`.kdlok
		";

        $data = $this->Get_By_Query($query);
		$tmp = $data['data'];
		if(isset($tmp[0] -> kondisi)) $tmp[0] -> kondisi = $kondisi[$tmp[0]->kondisi];

		return($tmp);
    }

    // filtering all asset by kd_brg, kd_lokasi, no_aset
    function AssetWithFilter($kd_gol, $kd_bid, $kd_kel, $kd_skel, $kd_sskel, $kd_lokasi) {
        $data = $this->AllAsset();

        $filterComponent = array();

        if (strlen($kd_gol) > 0) {
            $filterComponent['kd_gol'] = $kd_gol;
        }

        if (strlen($kd_bid) > 0) {
            $filterComponent['kd_bid'] = $kd_bid;
        }

        if (strlen($kd_kel) > 0) {
            $filterComponent['kd_kel'] = $kd_kel;
        }

        if (strlen($kd_skel) > 0) {
            $filterComponent['kd_skel'] = $kd_skel;
        }

        if (strlen($kd_sskel) > 0) {
            $filterComponent['kd_sskel'] = $kd_sskel;
        }

        if (strlen($kd_lokasi) > 0) {
            $filterComponent['kd_lokasi'] = $kd_lokasi;
        }

        $filteredData = $this->FilteredArray($data, $filterComponent);

        return array_values($filteredData);
    }
    
    
    function AssetWithWriteFilter($kd_lokasi,$kd_brg,$no_aset)
    {
        $data = $this->AllAsset();
        
        $filterComponent = array();
        if($kd_lokasi != '')
        {
            $filterComponent['kd_lokasi'] = $kd_lokasi;
        }
        if($kd_brg != '')
        {
            $filterComponent['kd_brg'] = $kd_brg;
        }
        if($no_aset != '')
        {
            $filterComponent['no_aset'] = $no_aset;
        }
        
        
        $filteredData = $this->FilteredArray($data, $filterComponent);
        
        return array_values($filteredData);
    }
    
    // filtering asset reference by kd_brg, kd_lokasi, no_aset
    function RefBarangWithFilter($kd_gol, $kd_bid, $kd_kel, $kd_skel, $kd_sskel) {
        $data = $this->AllRefBarang();

        $filterComponent = array();

        if (strlen($kd_gol) > 0) {
            $filterComponent['kd_gol'] = $kd_gol;
        }

        if (strlen($kd_bid) > 0) {
            $filterComponent['kd_bid'] = $kd_bid;
        }

        if (strlen($kd_kel) > 0) {
            $filterComponent['kd_kel'] = $kd_kel;
        }

        if (strlen($kd_skel) > 0) {
            $filterComponent['kd_skel'] = $kd_skel;
        }

        if (strlen($kd_sskel) > 0) {
            $filterComponent['kd_sskel'] = $kd_sskel;
        }

        $filteredData = $this->FilteredArray($data, $filterComponent);

        return array_values($filteredData);
    }
    
    function UpdateAssetForMobileServices($data)
    {
        $fields = array('tgl_prl','dari','no_dana');
        $asset = null;
        $result = null;
        switch ($data['table'])
        {
            case 1 : {
                $this->load->model('Asset_Alatbesar_Model','',TRUE);
                $asset = get_object_vars($this->Asset_Alatbesar_Model->GetAsset_byKode($data["kd_lokasi"],$data["kd_brg"],$data["no_aset"]));
                break;
            }
            case 2 : {
                $this->load->model('Asset_Angkutan_Model','',TRUE);
                $asset = get_object_vars($this->Asset_Angkutan_Model->GetAsset_byKode($data["kd_lokasi"],$data["kd_brg"],$data["no_aset"]));
                break;
            }
            case 3 : {
                $this->load->model('Asset_Perlengkapan_Model','',TRUE);
                $asset = get_object_vars($this->Asset_Perlengkapan_Model->GetAsset_byKode($data["kd_lokasi"],$data["kd_brg"],$data["no_aset"]));
                break;
            }
            default : {
                
            }
        }
        
        
        if (isset($asset))
        {
            foreach($fields as $field)
            {
                $asset[$field] = $data[$field];
            }


            switch ($data['table'])
            {
                case 1 : {
                    
                    $result = $this->Asset_Alatbesar_Model->Modify_Data($asset,null);
                    break;
                }
                case 2 : {
                    
                    $result = $this->Asset_Angkutan_Model->Modify_Data($asset,null);
                    break;
                }
                case 3 : {
                    $result = $this->Asset_Perlengkapan_Model->Modify_Data($asset,null);
                    break;
                }
                default : {

                }
            }
        }
        
        return $result;
    }

    // filter function use in filtering all asset, asset for mobile service, and asset reference
    function FilteredArray($array, $filterComponent) {
        $filteredData = array_filter($array, function ($row) use ($filterComponent) {
                    $inserted = false;
                    $count = 0;
                    foreach (array_keys($filterComponent) as $key) {
                        $val2 = $filterComponent[$key];
                        $val1 = $row->$key;

                        if ($val1 == $val2) {
                            $count++;
                        }
                    }

                    if ($count == count($filterComponent)) {
                        $inserted = true;
                    }

                    return $inserted;
                }
        );

        return $filteredData;
    }

}

?>
