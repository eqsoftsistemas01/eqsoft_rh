-- ----------------------------
-- Procedure structure for cajachica_insapertura
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajachica_insapertura`;
DELIMITER ;;
CREATE PROCEDURE `cajachica_insapertura`(
vusuario int,
vfecha date,
vmonto double,
vdescripcion varchar(255)
)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 
  SET time_zone = '-5:00';
  INSERT INTO caja_chica(fechaapertura, fecharegistroapertura, usuarioapertura, 
                         descripcion, montoapertura, estatus) 
    VALUES(vfecha, NOW(), vusuario, vdescripcion, vmonto, 0);

  select last_insert_id();

END
;;
DELIMITER ;
