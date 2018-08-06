-- ----------------------------
-- Procedure structure for compra_null
-- ----------------------------
DROP PROCEDURE IF EXISTS `compra_null`;
DELIMITER ;;
CREATE PROCEDURE `compra_null`(
vidcompra int, 
vidusu int,
vcausa text
)
BEGIN
  DECLARE EXIT handler for sqlexception select 0;
  
  /*START TRANSACTION;*/
 
  UPDATE compra set estatus = 3 WHERE id_comp = vidcompra;
  SET time_zone = '-5:00';
  INSERT INTO compra_anulada (idcompra, idusuario, fecha, causa_anulacion)
    VALUES (vidcompra, vidusu, now(), vcausa);

  UPDATE almapro as a
    INNER JOIN compra_det v on v.id_pro = a.id_pro
    SET existencia = a.existencia - v.cantidad	
    WHERE (v.id_comp = vidcompra);

  UPDATE almapro as a
    SET existencia = 0 	
    WHERE (existencia < 0);
   
  /*COMMIT;*/
  
  select 1;
END
;;
DELIMITER ;
