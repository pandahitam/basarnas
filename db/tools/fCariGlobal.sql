DELIMITER $$

USE `db_asset_basarnas`$$

DROP PROCEDURE IF EXISTS `pCariGlobal`$$

CREATE   PROCEDURE `pCariGlobal`( IN _keyword VARCHAR(50) )
    READS SQL DATA
BEGIN
	  SELECT "alatbesar" AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, `x`.merk, `x`.`type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_alatbesar AS `x`
	INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg  INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
	WHERE 
	`x`.kd_lokasi LIKE   CONCAT('%',_keyword,'%') OR
	`x`.kd_brg LIKE  CONCAT('%',_keyword,'%') OR
	`x`.no_aset LIKE  CONCAT('%',_keyword,'%') OR
	`x`.merk LIKE  CONCAT('%',_keyword,'%') OR
	`x`.`type` LIKE  CONCAT('%',_keyword,'%') OR
	`y`.`ur_sskel` LIKE  CONCAT('%',_keyword,'%') OR
	`z`.ur_upb LIKE   CONCAT('%',_keyword,'%') 
	UNION
	SELECT "angkutan" AS `gol`, `x`.kd_lokasi, `x`.kd_brg,  `x`.no_aset, `x`.merk, `x`.`type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_angkutan AS `x`
	INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
	WHERE 
	`x`.kd_lokasi LIKE  CONCAT('%',_keyword,'%') OR
	`x`.kd_brg LIKE  CONCAT('%',_keyword,'%') OR
	`x`.no_aset LIKE  CONCAT('%',_keyword,'%') OR
	`x`.merk LIKE  CONCAT('%',_keyword,'%') OR
	`x`.`type` LIKE  CONCAT('%',_keyword,'%') OR
	`y`.`ur_sskel` LIKE  CONCAT('%',_keyword,'%') OR
	`z`.ur_upb LIKE   CONCAT('%',_keyword,'%') 
	UNION
	SELECT "bangunan" AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, "" AS merk, "" AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_bangunan AS `x`
	INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
	WHERE 
	`x`.kd_lokasi LIKE  CONCAT('%',_keyword,'%') OR
	`x`.kd_brg LIKE  CONCAT('%',_keyword,'%') OR
	`x`.no_aset LIKE  CONCAT('%',_keyword,'%') OR
	`y`.`ur_sskel` LIKE  CONCAT('%',_keyword,'%') OR
	`z`.ur_upb LIKE   CONCAT('%',_keyword,'%') 
	UNION
	SELECT "dil" AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, "" AS merk, "" AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_dil AS `x`
	INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
	WHERE 
	`x`.kd_lokasi LIKE  CONCAT('%',_keyword,'%') OR
	`x`.kd_brg LIKE  CONCAT('%',_keyword,'%') OR
	`x`.no_aset LIKE  CONCAT('%',_keyword,'%') OR
	`y`.`ur_sskel` LIKE  CONCAT('%',_keyword,'%') OR
	`z`.ur_upb LIKE   CONCAT('%',_keyword,'%') 
	UNION
	SELECT "perairan" AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, "" AS merk, "" AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_perairan AS `x`
	INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
	WHERE 
	`x`.kd_lokasi LIKE  CONCAT('%',_keyword,'%') OR
	`x`.kd_brg LIKE  CONCAT('%',_keyword,'%') OR
	`x`.no_aset LIKE  CONCAT('%',_keyword,'%') OR
	`y`.`ur_sskel` LIKE  CONCAT('%',_keyword,'%') OR
	`z`.ur_upb LIKE   CONCAT('%',_keyword,'%') 
	UNION
	SELECT "ruang" AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, "" AS merk, "" AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_ruang AS `x`
	INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
	WHERE 
	`x`.kd_lokasi LIKE  CONCAT('%',_keyword,'%') OR
	`x`.kd_brg LIKE  CONCAT('%',_keyword,'%') OR
	`x`.no_aset LIKE  CONCAT('%',_keyword,'%') OR
	`y`.`ur_sskel` LIKE  CONCAT('%',_keyword,'%') OR
	`z`.ur_upb LIKE   CONCAT('%',_keyword,'%') 
	UNION
	SELECT "senjata" AS `gol`, `x`.kd_lokasi, `x`.kd_brg, `x`.no_aset, `x`.merk, `x`.`type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_senjata AS `x`
	INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
	WHERE 
	`x`.kd_lokasi LIKE  CONCAT('%',_keyword,'%') OR
	`x`.kd_brg LIKE  CONCAT('%',_keyword,'%') OR
	`x`.no_aset LIKE  CONCAT('%',_keyword,'%') OR
	`x`.merk LIKE  CONCAT('%',_keyword,'%') OR
	`x`.`type` LIKE  CONCAT('%',_keyword,'%') OR
	`y`.`ur_sskel` LIKE  CONCAT('%',_keyword,'%') OR
	`z`.ur_upb LIKE   CONCAT('%',_keyword,'%') 
	UNION
	SELECT "tanah" AS `gol`, `x`.kd_lokasi, `x`.kd_brg, no_aset, "" AS merk, "" AS `type`, `y`.ur_sskel, `z`.`ur_upb` FROM asset_tanah AS `x`
	INNER JOIN ref_subsubkel AS `y` ON `x`.kd_brg = `y`.kd_brg    INNER JOIN ref_unker AS `z` ON `x`.`kd_lokasi` =  `z`.`kdlok`
	WHERE 
	`x`.kd_lokasi LIKE  CONCAT('%',_keyword,'%') OR
	`x`.kd_brg LIKE  CONCAT('%',_keyword,'%') OR
	`x`.no_aset LIKE  CONCAT('%',_keyword,'%') OR
	`y`.`ur_sskel` LIKE  CONCAT('%',_keyword,'%') OR
	`z`.ur_upb LIKE   CONCAT('%',_keyword,'%') 
   ;
END$$

DELIMITER ;