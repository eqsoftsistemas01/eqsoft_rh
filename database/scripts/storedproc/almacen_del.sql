-- ----------------------------
-- Procedure structure for almacen_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `almacen_del`;
DELIMITER ;;
CREATE PROCEDURE `almacen_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from almacen where almacen_id=vid;        

  select 1;

END
;;
DELIMITER ;
