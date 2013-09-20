<?php
class master_model extends MY_Model{
    function __construct(){
		parent::__construct();
    }
    
    function AllAsset()
    {
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
        return $data;
    }
    
    function AllRefBarang()
    {
        $query = 'SELECT kd_gol,kd_bid,kd_kel, kd_skel, kd_sskel, kd_brg, ur_sskel as nama FROM `ref_subsubkel`';
        $data = $this->Get_By_Query($query);
        return $data;
    }
    
    function AllAssetServices()
    {
        $query = "SELECT master.*, ref.ur_sskel as nama_barang, reflok.ur_upb as nama_unker FROM 
(SELECT t.kd_brg as kode_barang, t.kd_lokasi as kode_lokasi, t.no_aset, tgl_prl as tanggal_perolehan, b.image_url, dari, no_dana, (CASE WHEN kondisi = '1' THEN 'Baik' WHEN kondisi = '2' THEN 'Rusak Ringan' WHEN kondisi = '3' THEN 'Rusak Berat' END) as kondisi FROM asset_alatbesar as t LEFT JOIN ext_asset_alatbesar as b ON t.kd_brg = b.kd_brg AND t.kd_lokasi = b.kd_lokasi AND t.no_aset = b.no_aset
UNION
SELECT t.kd_brg, t.kd_lokasi, t.no_aset, t.tgl_prl,b.image_url, t.dari, t.no_dana, (CASE WHEN kondisi = '1' THEN 'Baik' WHEN kondisi = '2' THEN 'Rusak Ringan' WHEN kondisi = '3' THEN 'Rusak Berat' END) as kondisi FROM asset_angkutan as t LEFT JOIN ext_asset_angkutan as b ON t.kd_brg = b.kd_brg AND t.kd_lokasi = b.kd_lokasi AND t.no_aset = b.no_aset
UNION
SELECT kd_brg, kd_lokasi, no_aset, tanggal_perolehan, image_url, dari, no_dana,(CASE WHEN kondisi = '1' THEN 'Baik' WHEN kondisi = '2' THEN 'Rusak Ringan' WHEN kondisi = '3' THEN 'Rusak Berat' END) as kondisi FROM asset_perlengkapan) as master 
LEFT JOIN ref_subsubkel as ref ON master.kode_barang = ref.kd_brg LEFT JOIN ref_unker as reflok ON master.kode_lokasi = reflok.kdlok
";
        
        $data = $this->Get_By_Query($query);
        return $data;
    }
    
    function AssetServicesWithFilter($kd_brg,$kd_lokasi,$no_aset)
    {
        $data = $this->AllAssetServices();
        
        $filterComponent = array();
        
        if (strlen($kd_brg)>0)
        {
            $filterComponent['kode_barang'] = $kd_brg;
        }
        
        if (strlen($kd_lokasi)>0)
        {
            $filterComponent['kode_lokasi'] = $kd_lokasi;
        }
        
        if (strlen($no_aset)>0)
        {
            $filterComponent['no_aset'] = $no_aset;
        }
        
        $filteredData = $this->FilteredArray($data, $filterComponent);
        
        return array_values($filteredData);
        
    }
    
    function AssetWithFilter($kd_gol,$kd_bid,$kd_kel,$kd_skel,$kd_sskel,$kd_lokasi)
    {
        $data = $this->AllAsset();
        
        $filterComponent = array();
        
        if (strlen($kd_gol)>0)
        {
            $filterComponent['kd_gol'] = $kd_gol;
        }
        
        if (strlen($kd_bid)>0)
        {
            $filterComponent['kd_bid'] = $kd_bid;
        }
        
        if (strlen($kd_kel)>0)
        {
            $filterComponent['kd_kel'] = $kd_kel;
        }
        
        if (strlen($kd_skel)>0)
        {
            $filterComponent['kd_skel'] = $kd_skel;
        }
        
        if (strlen($kd_sskel)>0)
        {
            $filterComponent['kd_sskel'] = $kd_sskel;
        }
        
        if (strlen($kd_lokasi)>0)
        {
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
    
    function RefBarangWithFilter($kd_gol,$kd_bid,$kd_kel,$kd_skel,$kd_sskel)
    {
        $data = $this->AllRefBarang();
        
        $filterComponent = array();
        
        if (strlen($kd_gol)>0)
        {
            $filterComponent['kd_gol'] = $kd_gol;
        }
        
        if (strlen($kd_bid)>0)
        {
            $filterComponent['kd_bid'] = $kd_bid;
        }
        
        if (strlen($kd_kel)>0)
        {
            $filterComponent['kd_kel'] = $kd_kel;
        }
        
        if (strlen($kd_skel)>0)
        {
            $filterComponent['kd_skel'] = $kd_skel;
        }
        
        if (strlen($kd_sskel)>0)
        {
            $filterComponent['kd_sskel'] = $kd_sskel;
        }
        
        $filteredData = $this->FilteredArray($data, $filterComponent);
        
        return array_values($filteredData);
    }

    
    function FilteredArray($array,$filterComponent)
    {
        $filteredData = array_filter($array,
                function ($row) use ($filterComponent)
                {
                    $inserted = false;
                    $count = 0;
                    foreach (array_keys($filterComponent) as $key)
                    {
                        $val2 = $filterComponent[$key];
                        $val1 = $row->$key;
                        
                        if($val1 == $val2)
                        {
                            $count++;
                        }
                    }
                    
                    if ($count == count($filterComponent))
                    {
                        $inserted = true;
                    }

                    return $inserted;
                }
        );
        
        return $filteredData;
    }
}
?>
