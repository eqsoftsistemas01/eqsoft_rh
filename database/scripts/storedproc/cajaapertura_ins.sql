-- ----------------------------
-- Procedure structure for cajaapertura_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajaapertura_ins`;
DELIMITER ;;
CREATE PROCEDURE `cajaapertura_ins`(

vusuario int,

vmonto double

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 
  SET time_zone = '-5:00';
  INSERT INTO caja_movimiento(id_usuario, fecha_apertura, monto_apertura, estado) 

    VALUES(vusuario,  NOW(), vmonto, 0);

  select last_insert_id();

END
;;
DELIMITER ;
