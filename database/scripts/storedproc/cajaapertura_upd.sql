-- ----------------------------
-- Procedure structure for cajaapertura_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajaapertura_upd`;
DELIMITER ;;
CREATE PROCEDURE `cajaapertura_upd`(

vusuario int,
vefectivo double,
vtarjeta double,
vegreso double,
vcompras double,
vtotalcaja double,
vnotacierre text,
vsalida decimal(11,2),
vjusti text

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 
  SET time_zone = '-5:00';
	UPDATE caja_movimiento
    SET	estado = 1, 
		fecha_cierre = Now(),
		ingresoefectivo = vefectivo,
		ingresotarjeta = vtarjeta,
		pagos = vegreso,
		compras = vcompras,
		existente = vtotalcaja,
		observaciones = vnotacierre,
		salida = vsalida,
		justificacion = vjusti
	WHERE id_usuario=vusuario and estado=0;

  select 1;

END
;;
DELIMITER ;
