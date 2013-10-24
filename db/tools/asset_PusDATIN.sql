-- please apply_this_first.sql
USE db_asset_basarnas;

UPDATE ext_asset_alatbesar SET kode_unor = 82 WHERE (kd_lokasi, kd_brg, no_aset) IN ( ("107010199414370000KP","3010304002",77) );

INSERT INTO asset_alatbesar (kd_lokasi, kd_brg, no_aset, kuantitas, jns_trn, `type`, merk, kondisi, rph_aset, tgl_buku, tgl_prl, dari, dasar_hrg, no_kib)
(
	SELECT kd_lokasi, kd_brg, no_aset, kuantitas, jns_trn, keterangan, merk_type, kondisi, rph_aset, tgl_buku, tgl_perlh, asal_perlh, dsr_hrg, no_aset FROM t_masteru 
	WHERE (kd_lokasi, kd_brg, no_aset) IN (
		("107010199414370000KP","3050105048",30),
		("107010199414370000KP","3050206020",10),
		("107010199414370000KP","3060101048",119),
		("107010199414370000KP","3060101068",18),
		("107010199414370000KP","3060102012",2),
		("107010199414370000KP","3060102132",1),
		("107010199414370000KP","3060102132",2),
		("107010199414370000KP","3060102132",3),
		("107010199414370000KP","3060207016",1),
		("107010199414370000KP","3060209010",2),
		("107010199414370000KP","3060406999",1),
		("107010199414370000KP","3100102003",26),
		("107010199414370000KP","3100204001",86),
		("107010199414370000KP","3100204001",87),
		("107010199414370000KP","3100204001",88),
		("107010199414370000KP","3100204001",97),
		("107010199414370000KP","3100204001",98),
		("107010199414370000KP","3100204015",2),
		("107010199414370000KP","3100204024",78),
		("107010199414370000KP","3100204024",79),
		("107010199414370000KP","3100204024",80),
		("107010199414370000KP","3100204024",81),
		("107010199414370000KP","3100204024",82),
		("107010199414370000KP","3100204026",16),
		("107010199414370000KP","3100204026",17),
		("107010199414370000KP","3100204026",18),
		("107010199414370000KP","3100204026",19),
		("107010199414370000KP","3100204026",20),
		("107010199414370000KP","3100204026",21),
		("107010199414370000KP","3100204999",53)
	) 
	AND (kd_lokasi, kd_brg, no_aset) NOT IN (
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_alatbesar
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_angkutan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_bangunan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_dil
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_perairan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_ruang
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_senjata
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_tanah
	)
	AND LEFT(jns_trn,1)="1"
);

INSERT INTO ext_asset_alatbesar (kd_lokasi, kd_brg, no_aset, kode_unor)
(
	SELECT kd_lokasi, kd_brg, no_aset, 82 AS `kode_unor` FROM t_masteru 
	WHERE (kd_lokasi, kd_brg, no_aset) IN (
		("107010199414370000KP","3050105048",30),
		("107010199414370000KP","3050206020",10),
		("107010199414370000KP","3060101048",119),
		("107010199414370000KP","3060101068",18),
		("107010199414370000KP","3060102012",2),
		("107010199414370000KP","3060102132",1),
		("107010199414370000KP","3060102132",2),
		("107010199414370000KP","3060102132",3),
		("107010199414370000KP","3060207016",1),
		("107010199414370000KP","3060209010",2),
		("107010199414370000KP","3060406999",1),
		("107010199414370000KP","3100102003",26),
		("107010199414370000KP","3100204001",86),
		("107010199414370000KP","3100204001",87),
		("107010199414370000KP","3100204001",88),
		("107010199414370000KP","3100204001",97),
		("107010199414370000KP","3100204001",98),
		("107010199414370000KP","3100204015",2),
		("107010199414370000KP","3100204024",78),
		("107010199414370000KP","3100204024",79),
		("107010199414370000KP","3100204024",80),
		("107010199414370000KP","3100204024",81),
		("107010199414370000KP","3100204024",82),
		("107010199414370000KP","3100204026",16),
		("107010199414370000KP","3100204026",17),
		("107010199414370000KP","3100204026",18),
		("107010199414370000KP","3100204026",19),
		("107010199414370000KP","3100204026",20),
		("107010199414370000KP","3100204026",21),
		("107010199414370000KP","3100204999",53)
	) 
	AND (kd_lokasi, kd_brg, no_aset) NOT IN (
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_alatbesar
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_angkutan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_bangunan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_dil
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_perairan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_ruang
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_senjata
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_tanah
	)
	AND LEFT(jns_trn,1)="1"
);

INSERT INTO asset_ruang (kd_lokasi, kd_brg, no_aset)
(
	SELECT kd_lokasi, kd_brg, no_aset FROM t_masteru 
	WHERE (kd_lokasi, kd_brg, no_aset) IN (
		("107010199414370000KP","8010101001",1),
		("107010199414370000KP","8010101001",174),
		("107010199414370000KP","8010101001",175),
		("107010199414370000KP","8010101001",176)
	) 
	AND (kd_lokasi, kd_brg, no_aset) NOT IN (
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_alatbesar
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_angkutan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_bangunan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_dil
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_perairan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_ruang
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_senjata
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM asset_tanah
	)
	AND LEFT(jns_trn,1)="1"
);

INSERT INTO ext_asset_ruang (kd_lokasi, kd_brg, no_aset, kode_unor)
(
	SELECT kd_lokasi, kd_brg, no_aset, 82 AS `kode_unor` FROM t_masteru 
	WHERE (kd_lokasi, kd_brg, no_aset) IN (
		("107010199414370000KP","8010101001",1),
		("107010199414370000KP","8010101001",174),
		("107010199414370000KP","8010101001",175),
		("107010199414370000KP","8010101001",176)
	) 
	AND (kd_lokasi, kd_brg, no_aset) NOT IN (
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_alatbesar
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_angkutan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_bangunan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_dil
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_perairan
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_ruang
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_senjata
		UNION
		SELECT kd_lokasi, kd_brg, no_aset FROM ext_asset_tanah
	)
	AND LEFT(jns_trn,1)="1"
);
