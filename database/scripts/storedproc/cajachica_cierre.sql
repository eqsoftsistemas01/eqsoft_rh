-- ----------------------------
-- Procedure structure for cajachica_cierre
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajachica_cierre`;
DELIMITER ;;
CREATE PROCEDURE `cajachica_cierre`(
vidusuario int,
vfecha date,
vmonto decimal(11,2),
vobs text
)
BEGIN
set @id=(SELECT id_caja FROM caja_chica where estatus=0 limit 1);
SET time_zone = '-5:00';
update caja_chica set 
  fechacierre = vfecha,
  fecharegistrocierre = now(),
  usuariocierre = vidusuario,
  montocierre = vmonto,
  estatus = 1,
  obs = vobs
  where id_caja = @id;
END
;;
DELIMITER ;
