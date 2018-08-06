-- ----------------------------
-- Procedure structure for correo_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `correo_upd`;
DELIMITER ;;
CREATE PROCEDURE `correo_upd`(

vusuario varchar(255),
vclave varchar(255),
vpuerto int,
vsmtp varchar(255)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  UPDATE correo SET 
	usuario = vusuario,
	clave = vclave,
	puerto = vpuerto,
	smtp = vsmtp;

END
;;
DELIMITER ;
