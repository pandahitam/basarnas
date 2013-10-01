USE db_asset_basarnas;
SELECT 'AlatBesar' AS `table`, COUNT(*) AS `jumlah` FROM asset_alatbesar
UNION
SELECT 'AlatBesarExt' AS `table`, COUNT(*) AS `jumlah` FROM ext_asset_alatbesar
UNION
SELECT 'Angkutan' AS `table`, COUNT(*) AS `jumlah` FROM asset_angkutan
UNION
SELECT 'AngkutanExt' AS `table`, COUNT(*) AS `jumlah` FROM ext_asset_angkutan
UNION
SELECT 'AngkutanDaratPerlengkapanExt' AS `table`, COUNT(*) AS `jumlah` FROM ext_asset_angkutan_darat_perlengkapan
UNION
SELECT 'AngkutanLautPerlengkapanExt' AS `table`, COUNT(*) AS `jumlah` FROM ext_asset_angkutan_laut_perlengkapan
UNION
SELECT 'AngkutanUdaraPerlengkapanExt' AS `table`, COUNT(*) AS `jumlah` FROM ext_asset_angkutan_udara_perlengkapan
UNION
SELECT 'AngkutanDetailPenggunaanExt' AS `table`, COUNT(*) AS `jumlah` FROM ext_asset_angkutan_detail_penggunaan
UNION
SELECT 'Bangunan' AS `table`, COUNT(*) AS `jumlah` FROM asset_bangunan
UNION
SELECT 'BangunanExt' AS `table`, COUNT(*) AS `rows` FROM ext_asset_bangunan
UNION
SELECT 'BangunanPajakExt' AS `table`, COUNT(*) AS `rows` FROM ext_asset_bangunan_riwayat_pajak
UNION
SELECT 'Luar' AS `table`, COUNT(*) AS `rows` FROM asset_dil
UNION
SELECT 'LuarExt' AS `table`, COUNT(*) AS `rows` FROM ext_asset_dil
UNION
SELECT 'Perairan' AS `table`, COUNT(*) AS `rows` FROM asset_perairan
UNION
SELECT 'PerairanExt' AS `table`, COUNT(*) AS `rows` FROM ext_asset_perairan
UNION
SELECT 'Ruang' AS `table`, COUNT(*) AS `rows` FROM asset_ruang
UNION
SELECT 'RuangExt' AS `table`, COUNT(*) AS `rows` FROM ext_asset_ruang
UNION
SELECT 'Senjata' AS `table`, COUNT(*) AS `rows` FROM asset_senjata
UNION
SELECT 'SenjataExt' AS `table`, COUNT(*) AS `rows` FROM ext_asset_senjata
UNION
SELECT 'Tanah' AS `table`, COUNT(*) AS `rows` FROM asset_tanah
UNION
SELECT 'TanahExt' AS `table`, COUNT(*) AS `rows` FROM ext_asset_tanah
UNION
SELECT 'TanahPajakExt' AS `table`, COUNT(*) AS `rows` FROM ext_asset_tanah_riwayat_pajak
UNION
SELECT 'Perlengkapan' AS `table`, COUNT(*) AS `rows` FROM asset_perlengkapan;