USE db_asset_basarnas;
UPDATE ext_asset_alatbesar SET kode_unor = NULL
WHERE kd_lokasi <> "107010199414370000KP";
UPDATE ext_asset_angkutan SET kode_unor = NULL
WHERE kd_lokasi <> "107010199414370000KP";
UPDATE ext_asset_bangunan SET kode_unor = NULL
WHERE kd_lokasi <> "107010199414370000KP";
UPDATE ext_asset_dil SET kode_unor = NULL
WHERE kd_lokasi <> "107010199414370000KP";
UPDATE ext_asset_perairan SET kode_unor = NULL
WHERE kd_lokasi <> "107010199414370000KP";
UPDATE ext_asset_ruang SET kode_unor = NULL
WHERE kd_lokasi <> "107010199414370000KP"; 
UPDATE ext_asset_senjata SET kode_unor = NULL
WHERE kd_lokasi <> "107010199414370000KP"; 
UPDATE ext_asset_tanah SET kode_unor = NULL
WHERE kd_lokasi <> "107010199414370000KP"; 