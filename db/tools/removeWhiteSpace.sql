USE db_asset_basarnas;

UPDATE asset_angkutan SET rph_aset = 2674741245 WHERE rph_aset = 2674741245000; -- Salah entri data

UPDATE asset_alatbesar 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`), 
	`kd_brg` = TRIM(`kd_brg`), 
	`no_aset` = TRIM(`no_aset`), 
	`kuantitas` = TRIM(`kuantitas`), 
	`no_kib` = TRIM(`no_kib`), 
	`type` = TRIM(`type`), 
	`merk` = TRIM(`merk`), 
	`pabrik` = TRIM(`pabrik`), 
	`thn_rakit` = TRIM(`thn_rakit`), 
	`thn_buat` = TRIM(`thn_buat`), 
	`negara` = TRIM(`negara`), 
	`kapasitas` = TRIM(`kapasitas`), 
	`sis_opr` = TRIM(`sis_opr`), 
	`sis_dingin` = TRIM(`sis_dingin`), 
	`sis_bakar` = TRIM(`sis_bakar`), 
	`duk_alat` = TRIM(`duk_alat`), 
	`pwr_train` = TRIM(`pwr_train`), 
	`no_mesin` = TRIM(`no_mesin`), 
	`no_rangka` = TRIM(`no_rangka`), 
	`lengkap1` = TRIM(`lengkap1`), 
	`lengkap2` = TRIM(`lengkap2`), 
	`lengkap3` = TRIM(`lengkap3`), 
	`unit_pmk` = TRIM(`unit_pmk`), 
	`alm_pmk` = TRIM(`alm_pmk`), 
	`catatan` = TRIM(`catatan`), 
	`kondisi` = TRIM(`kondisi`), 
	`status` = TRIM(`status`), 
	`rphwajar` = TRIM(`rphwajar`), 
	`cad1` = TRIM(`cad1`), 
	`jns_trn` = TRIM(`jns_trn`), 
	`tgl_buku` = TRIM(`tgl_buku`), 
	`dari` = TRIM(`dari`), 
	`tgl_prl` = TRIM(`tgl_prl`), 
	`rph_aset` = TRIM(`rph_aset`), 
	`dasar_hrg` = TRIM(`dasar_hrg`), 
	`sumber` = TRIM(`sumber`), 
	`no_dana` = TRIM(`no_dana`), 
	`tgl_dana` = TRIM(`tgl_dana`);

UPDATE asset_angkutan 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`), 
	`kd_brg` = TRIM(`kd_brg`), 
	`no_aset` = TRIM(`no_aset`), 
	`kuantitas` = TRIM(`kuantitas`), 
	`no_kib` = TRIM(`no_kib`), 
	`merk` = TRIM(`merk`), 
	`type` = TRIM(`type`), 
	`pabrik` = TRIM(`pabrik`), 
	`thn_rakit` = TRIM(`thn_rakit`), 
	`thn_buat` = TRIM(`thn_buat`), 
	`negara` = TRIM(`negara`), 
	`muat` = TRIM(`muat`), 
	`bobot` = TRIM(`bobot`), 
	`daya` = TRIM(`daya`), 
	`msn_gerak` = TRIM(`msn_gerak`), 
	`jml_msn` = TRIM(`jml_msn`), 
	`bhn_bakar` = TRIM(`bhn_bakar`), 
	`no_mesin` = TRIM(`no_mesin`), 
	`no_rangka` = TRIM(`no_rangka`), 
	`no_polisi` = TRIM(`no_polisi`), 
	`no_bpkb` = TRIM(`no_bpkb`), 
	`lengkap1` = TRIM(`lengkap1`), 
	`lengkap2` = TRIM(`lengkap2`), 
	`lengkap3` = TRIM(`lengkap3`), 
	`unit_pmk` = TRIM(`unit_pmk`), 
	`alm_pmk` = TRIM(`alm_pmk`), 
	`catatan` = TRIM(`catatan`), 
	`status` = TRIM(`status`), 
	`rphwajar` = TRIM(`rphwajar`), 
	`kondisi` = TRIM(`kondisi`), 
	`cad1` = TRIM(`cad1`), 
	`jns_trn` = TRIM(`jns_trn`), 
	`tgl_buku` = TRIM(`tgl_buku`), 
	`dari` = TRIM(`dari`), 
	`tgl_prl` = TRIM(`tgl_prl`), 
	`rph_aset` = TRIM(`rph_aset`), 
	`dasar_hrg` = TRIM(`dasar_hrg`), 
	`sumber` = TRIM(`sumber`), 
	`no_dana` = TRIM(`no_dana`), 
	`tgl_dana` = TRIM(`tgl_dana`);

UPDATE asset_bangunan 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`), 
	`kd_brg` = TRIM(`kd_brg`), 
	`no_aset` = TRIM(`no_aset`), 
	`kuantitas` = TRIM(`kuantitas`), 
	`no_kib` = TRIM(`no_kib`), 
	`type` = TRIM(`type`), 
	`thn_sls` = TRIM(`thn_sls`), 
	`thn_pakai` = TRIM(`thn_pakai`), 
	`no_imb` = TRIM(`no_imb`), 
	`tgl_imb` = TRIM(`tgl_imb`), 
	`kd_prov` = TRIM(`kd_prov`), 
	`kd_kab` = TRIM(`kd_kab`), 
	`kd_kec` = TRIM(`kd_kec`), 
	`kd_kel` = TRIM(`kd_kel`), 
	`alamat` = TRIM(`alamat`), 
	`kd_rtrw` = TRIM(`kd_rtrw`), 
	`no_kibtnh` = TRIM(`no_kibtnh`), 
	`kondisi` = TRIM(`kondisi`), 
	`rph` = TRIM(`rph`), 
	`unit_pmk` = TRIM(`unit_pmk`), 
	`alm_pmk` = TRIM(`alm_pmk`), 
	`catatan` = TRIM(`catatan`), 
	`rphwajar` = TRIM(`rphwajar`), 
	`rphnjop` = TRIM(`rphnjop`), 
	`status` = TRIM(`status`), 
	`cad1` = TRIM(`cad1`), 
	`luas_dsr` = TRIM(`luas_dsr`), 
	`luas_bdg` = TRIM(`luas_bdg`), 
	`jml_lt` = TRIM(`jml_lt`), 
	`jns_trn` = TRIM(`jns_trn`), 
	`tgl_buku` = TRIM(`tgl_buku`), 
	`dari` = TRIM(`dari`), 
	`tgl_prl` = TRIM(`tgl_prl`), 
	`rph_aset` = TRIM(`rph_aset`), 
	`dasar_hrg` = TRIM(`dasar_hrg`), 
	`sumber` = TRIM(`sumber`), 
	`no_dana` = TRIM(`no_dana`), 
	`tgl_dana` = TRIM(`tgl_dana`);

UPDATE asset_dil 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`), 
	`kd_pemilik` = TRIM(`kd_pemilik`), 
	`kd_brg` = TRIM(`kd_brg`), 
	`no_aset` = TRIM(`no_aset`), 
	`lok_fisik` = TRIM(`lok_fisik`);

UPDATE db_asset_basarnas.asset_perairan 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`), 
	`kd_brg` = TRIM(`kd_brg`), 
	`no_aset` = TRIM(`no_aset`), 
	`kuantitas` = TRIM(`kuantitas`), 
	`no_kib` = TRIM(`no_kib`), 
	`luas_bdg` = TRIM(`luas_bdg`), 
	`luas_dsr` = TRIM(`luas_dsr`), 
	`kapasitas` = TRIM(`kapasitas`), 
	`thn_sls` = TRIM(`thn_sls`), 
	`thn_pakai` = TRIM(`thn_pakai`), 
	`no_imb` = TRIM(`no_imb`), 
	`tgl_imb` = TRIM(`tgl_imb`), 
	`kd_prov` = TRIM(`kd_prov`), 
	`kd_kab` = TRIM(`kd_kab`), 
	`kd_kec` = TRIM(`kd_kec`), 
	`kd_kel` = TRIM(`kd_kel`), 
	`alamat` = TRIM(`alamat`), 
	`kd_rtrw` = TRIM(`kd_rtrw`), 
	`no_kibtnh` = TRIM(`no_kibtnh`), 
	`kondisi` = TRIM(`kondisi`), 
	`rph_wajar` = TRIM(`rph_wajar`), 
	`unit_pmk` = TRIM(`unit_pmk`), 
	`alm_pmk` = TRIM(`alm_pmk`), 
	`catatan` = TRIM(`catatan`), 
	`kons_sist` = TRIM(`kons_sist`), 
	`rphwajar` = TRIM(`rphwajar`), 
	`status` = TRIM(`status`), 
	`jns_trn` = TRIM(`jns_trn`), 
	`tgl_buku` = TRIM(`tgl_buku`), 
	`tgl_prl` = TRIM(`tgl_prl`), 
	`dari` = TRIM(`dari`), 
	`rph_aset` = TRIM(`rph_aset`), 
	`dasar_hrg` = TRIM(`dasar_hrg`), 
	`sumber` = TRIM(`sumber`), 
	`no_dana` = TRIM(`no_dana`), 
	`tgl_dana` = TRIM(`tgl_dana`);
	
UPDATE db_asset_basarnas.asset_ruang 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`), 
	`kd_pemilik` = TRIM(`kd_pemilik`),
	`kd_brg` = TRIM(`kd_brg`),
	`no_aset` = TRIM(`no_aset`),
	`kd_ruang` = TRIM(`kd_ruang`);
	
UPDATE db_asset_basarnas.asset_senjata 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`),
	`kd_brg` = TRIM(`kd_brg`),
	`no_aset` = TRIM(`no_aset`),
	`no_kib` = TRIM(`no_kib`),
	`kuantitas` = TRIM(`kuantitas`),
	`nama` = TRIM(`nama`),
	`merk` = TRIM(`merk`),
	`type` = TRIM(`type`),
	`kaliber` = TRIM(`kaliber`),
	`no_pabrik` = TRIM(`no_pabrik`),
	`thn_buat` = TRIM(`thn_buat`),
	`surat` = TRIM(`surat`),
	`tgl_surat` = TRIM(`tgl_surat`),
	`lengkap1` = TRIM(`lengkap1`),
	`lengkap2` = TRIM(`lengkap2`),
	`lengkap3` = TRIM(`lengkap3`),
	`kondisi` = TRIM(`kondisi`),
	`unit_pmk` = TRIM(`unit_pmk`),
	`alm_pmk` = TRIM(`alm_pmk`),
	`catatan` = TRIM(`catatan`),
	`rphwajar` = TRIM(`rphwajar`),
	`status` = TRIM(`status`),
	`jns_trn` = TRIM(`jns_trn`),
	`tgl_buku` = TRIM(`tgl_buku`),
	`dari` = TRIM(`dari`),
	`tgl_prl` = TRIM(`tgl_prl`),
	`rph_aset` = TRIM(`rph_aset`),
	`dasar_hrg` = TRIM(`dasar_hrg`),
	`sumber` = TRIM(`sumber`),
	`no_dana` = TRIM(`no_dana`),
	`tgl_dana` = TRIM(`tgl_dana`);	
	

UPDATE db_asset_basarnas.asset_tanah 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`),
	`kd_brg` = TRIM(`kd_brg`),
	`no_aset` = TRIM(`no_aset`),
	`kuantitas` = TRIM(`kuantitas`),
	`no_kib` = TRIM(`no_kib`),
	`luas_tnhs` = TRIM(`luas_tnhs`),
	`luas_tnhb` = TRIM(`luas_tnhb`),
	`luas_tnhl` = TRIM(`luas_tnhl`),
	`luas_tnhk` = TRIM(`luas_tnhk`),
	`kd_prov` = TRIM(`kd_prov`),
	`kd_kab` = TRIM(`kd_kab`),
	`kd_kec` = TRIM(`kd_kec`),
	`kd_kel` = TRIM(`kd_kel`),
	`kd_rtrw` = TRIM(`kd_rtrw`),
	`alamat` = TRIM(`alamat`),
	`batas_u` = TRIM(`batas_u`),
	`batas_s` = TRIM(`batas_s`),
	`batas_t` = TRIM(`batas_t`),
	`batas_b` = TRIM(`batas_b`),
	`surat1` = TRIM(`surat1`),
	`surat2` = TRIM(`surat2`),
	`surat3` = TRIM(`surat3`),
	`unit_pmk` = TRIM(`unit_pmk`),
	`alm_pmk` = TRIM(`alm_pmk`),
	`catatan` = TRIM(`catatan`),
	`rphwajar` = TRIM(`rphwajar`),
	`rphnjop` = TRIM(`rphnjop`),
	`status` = TRIM(`status`),
	`smilik` = TRIM(`smilik`),
	`jns_trn` = TRIM(`jns_trn`),
	`tgl_buku` = TRIM(`tgl_buku`),
	`dari` = TRIM(`dari`),
	`tgl_prl` = TRIM(`tgl_prl`),
	`rph_m2` = TRIM(`rph_m2`),
	`rph_aset` = TRIM(`rph_aset`),
	`dasar_hrg` = TRIM(`dasar_hrg`),
	`sumber` = TRIM(`sumber`),
	`no_dana` = TRIM(`no_dana`),
	`tgl_dana` = TRIM(`tgl_dana`);
	

UPDATE db_asset_basarnas.ref_bidang 
	SET
	`kd_gol` = TRIM(`kd_gol`),
	`kd_bid` = TRIM(`kd_bid`),
	`ur_bid` = TRIM(`ur_bid`),
	`kd_bidbrg` = TRIM(`kd_bidbrg`);

UPDATE db_asset_basarnas.ref_kel 
	SET
	`kd_gol` = TRIM(`kd_gol`),
	`kd_bid` = TRIM(`kd_bid`),
	`kd_kel` = TRIM(`kd_kel`),
	`ur_kel` = TRIM(`ur_kel`),
	`kd_kelbrg` = TRIM(`kd_kelbrg`);

UPDATE db_asset_basarnas.ref_ruang 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`),
	`kd_ruang` = TRIM(`kd_ruang`),
	`ur_ruang` = TRIM(`ur_ruang`),
	`pj_ruang` = TRIM(`pj_ruang`),
	`nip_pjrug` = TRIM(`nip_pjrug`);

UPDATE db_asset_basarnas.ref_subkel 
	SET
	`kd_gol` = TRIM(`kd_gol`),
	`kd_bid` = TRIM(`kd_bid`),
	`kd_kel` = TRIM(`kd_kel`),
	`kd_skel` = TRIM(`kd_skel`),
	`ur_skel` = TRIM(`ur_skel`),
	`kd_skelbrg` = TRIM(`kd_skelbrg`);

UPDATE db_asset_basarnas.ref_subsubkel 
	SET
	`kd_gol` = TRIM(`kd_gol`),
	`kd_bid` = TRIM(`kd_bid`),
	`kd_kel` = TRIM(`kd_kel`),
	`kd_skel` = TRIM(`kd_skel`),
	`kd_sskel` = TRIM(`kd_sskel`),
	`satuan` = TRIM(`satuan`),
	`ur_sskel` = TRIM(`ur_sskel`),
	`kd_perk` = TRIM(`kd_perk`),
	`kd_brg` = TRIM(`kd_brg`),
	`dasar` = TRIM(`dasar`),
	`kdperkbr` = TRIM(`kdperkbr`);

UPDATE db_asset_basarnas.ref_trans 
	SET
	`jns_trn` = TRIM(`jns_trn`),
	`ur_trn` = TRIM(`ur_trn`);

UPDATE db_asset_basarnas.ref_unker 
	SET
	`kd_pebin` = TRIM(`kd_pebin`),
	`kd_pbi` = TRIM(`kd_pbi`),
	`kd_ppbi` = TRIM(`kd_ppbi`),
	`kd_upb` = TRIM(`kd_upb`),
	`kd_subupb` = TRIM(`kd_subupb`),
	`kd_jk` = TRIM(`kd_jk`),
	`ur_upb` = TRIM(`ur_upb`),
	`kdlok` = TRIM(`kdlok`);

UPDATE db_asset_basarnas.ref_wilayah 
	SET
	`kd_wilayah` = TRIM(`kd_wilayah`),
	`ur_wilayah` = TRIM(`ur_wilayah`);

UPDATE db_asset_basarnas.t_bid 
	SET
	`kd_gol` = TRIM(`kd_gol`),
	`kd_bid` = TRIM(`kd_bid`),
	`ur_bid` = TRIM(`ur_bid`),
	`kd_bidbrg` = TRIM(`kd_bidbrg`);
	
UPDATE db_asset_basarnas.t_croleh 
	SET
	`jns_trn` = TRIM(`jns_trn`),
	`ur_trn` = TRIM(`ur_trn`);

UPDATE db_asset_basarnas.t_dil 
	SET
	`kd_lokasi` = TRIM(`kd_lokasi`),
	`kd_pemilik` = TRIM(`kd_pemilik`),
	`kd_brg` = TRIM(`kd_brg`),
	`no_aset` = TRIM(`no_aset`),
	`lok_fisik` = TRIM(`lok_fisik`);

UPDATE db_asset_basarnas.t_kel 
	SET
	`kd_gol` = TRIM(`kd_gol`),
	`kd_bid` = TRIM(`kd_bid`),
	`kd_kel` = TRIM(`kd_kel`),
	`ur_kel` = TRIM(`ur_kel`),
	`kd_kelbrg` = TRIM(`kd_kelbrg`);

UPDATE db_asset_basarnas.t_masteru 
	SET
	`thn_ang` = TRIM(`thn_ang`),
	`periode` = TRIM(`periode`),
	`kd_lokasi` = TRIM(`kd_lokasi`),
	`no_sppa` = TRIM(`no_sppa`),
	`kd_brg` = TRIM(`kd_brg`),
	`no_aset` = TRIM(`no_aset`),
	`tgl_perlh` = TRIM(`tgl_perlh`),
	`tercatat` = TRIM(`tercatat`),
	`kondisi` = TRIM(`kondisi`),
	`tgl_buku` = TRIM(`tgl_buku`),
	`jns_trn` = TRIM(`jns_trn`),
	`dsr_hrg` = TRIM(`dsr_hrg`),
	`kd_data` = TRIM(`kd_data`),
	`flag_sap` = TRIM(`flag_sap`),
	`kuantitas` = TRIM(`kuantitas`),
	`rph_sat` = TRIM(`rph_sat`),
	`rph_aset` = TRIM(`rph_aset`),
	`flag_kor` = TRIM(`flag_kor`),
	`keterangan` = TRIM(`keterangan`),
	`merk_type` = TRIM(`merk_type`),
	`asal_perlh` = TRIM(`asal_perlh`),
	`no_bukti` = TRIM(`no_bukti`),
	`no_dsr_mts` = TRIM(`no_dsr_mts`),
	`tgl_dsr_mts` = TRIM(`tgl_dsr_mts`),
	`flag_ttp` = TRIM(`flag_ttp`),
	`flag_krm` = TRIM(`flag_krm`),
	`kdblu` = TRIM(`kdblu`),
	`setatus` = TRIM(`setatus`),
	`noreg` = TRIM(`noreg`),
	`kdbapel` = TRIM(`kdbapel`),
	`kdkpknl` = TRIM(`kdkpknl`),
	`umeko` = TRIM(`umeko`),
	`rph_res` = TRIM(`rph_res`),
	`kdkppn` = TRIM(`kdkppn`);
