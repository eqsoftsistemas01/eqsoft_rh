-- ----------------------------
-- Procedure structure for proveedor_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `proveedor_del`;
DELIMITER ;;
CREATE PROCEDURE `proveedor_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from proveedor where id_proveedor=vid;        

  select 1;

END
;;
DELIMITER ;
