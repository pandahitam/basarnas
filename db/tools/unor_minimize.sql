USE db_asset_basarnas;
UPDATE ref_unor SET kd_lokasi="107010199414370000KP";
DELETE FROM ref_unor WHERE kode_parent = 0;
DELETE FROM ref_unor WHERE kode_eselon > 30;
DELETE FROM ref_unor WHERE nama_unor LIKE "Kantor SAR Kelas%" OR nama_unor LIKE "Kepala Kantor SAR Kelas%";