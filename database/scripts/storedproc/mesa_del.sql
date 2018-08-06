-- ----------------------------
-- Procedure structure for mesa_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesa_del`;
DELIMITER ;;
CREATE PROCEDURE `mesa_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from mesa where id_mesa=vid;

  select 1;

END
;;
DELIMITER ;
