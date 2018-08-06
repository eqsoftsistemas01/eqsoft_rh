-- ----------------------------
-- Procedure structure for formapago_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `formapago_ins`;
DELIMITER ;;
CREATE PROCEDURE `formapago_ins`(

vcod varchar(45),

vnom varchar(45)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO formapago(cod_formapago, nombre_formapago) 

    VALUES(vcod,vnom);

  select last_insert_id();

END
;;
DELIMITER ;
