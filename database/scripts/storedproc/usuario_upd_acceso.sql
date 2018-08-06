-- ----------------------------
-- Procedure structure for usuario_upd_acceso
-- ----------------------------
DROP PROCEDURE IF EXISTS `usuario_upd_acceso`;
DELIMITER ;;
CREATE PROCEDURE `usuario_upd_acceso`(
vidusu int
)
BEGIN
  SET time_zone = '-5:00';
  update usu_sistemas set ultimoacceso = now() where id_usu = vidusu;
END
;;
DELIMITER ;
