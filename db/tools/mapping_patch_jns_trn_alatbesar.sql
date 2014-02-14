UPDATE asset_alatbesar AS `a` INNER JOIN
(
  SELECT kd_lokasi, kd_brg, no_aset, jns_trn FROM t_masteru
  WHERE kd_brg LIKE "3%" AND kd_lokasi="107010199414370000KP" AND kd_brg NOT LIKE "302%"
  GROUP BY kd_lokasi, kd_brg, no_aset
  HAVING COUNT(jns_trn) = 1
) AS `b` ON `a`.kd_lokasi=`b`.kd_lokasi AND `a`.kd_brg=`b`.kd_brg AND `a`.no_aset=`b`.no_aset
SET `a`.jns_trn = `b`.jns_trn
WHERE `a`.jns_trn IS NULL 
AND `a`.kd_lokasi=`b`.kd_lokasi 
AND `a`.kd_brg=`b`.kd_brg 
AND `a`.no_aset=`b`.no_aset;