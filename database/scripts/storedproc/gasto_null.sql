-- ----------------------------
-- Procedure structure for gasto_null
-- ----------------------------
DROP PROCEDURE IF EXISTS `gasto_null`;
DELIMITER ;;
CREATE PROCEDURE `gasto_null`(
vidgasto int, 
vidusu int,
vcausa text
)
BEGIN
  DECLARE EXIT handler for sqlexception select 0;
  
  /*START TRANSACTION;*/
  SET time_zone = '-5:00';
  UPDATE gastos set estatus = 3 WHERE id_gastos = vidgasto;
  
  INSERT INTO gasto_anulado (idgasto, idusuario, fecha, causa_anulacion)
    VALUES (vidgasto, vidusu, now(), vcausa);

  /*COMMIT;*/
  
  select 1;
END
;;
DELIMITER ;
