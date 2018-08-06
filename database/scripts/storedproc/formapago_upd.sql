-- ----------------------------
-- Procedure structure for formapago_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `formapago_upd`;
DELIMITER ;;
CREATE PROCEDURE `formapago_upd`(

vid int,

vcod varchar(45),

vnom varchar(45)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  update formapago set cod_formapago=vcod, nombre_formapago=vnom 

    where id_formapago=vid;

  select 1;

END
;;
DELIMITER ;
