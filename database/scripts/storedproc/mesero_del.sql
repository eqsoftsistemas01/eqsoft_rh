-- ----------------------------
-- Procedure structure for mesero_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesero_del`;
DELIMITER ;;
CREATE PROCEDURE `mesero_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from mesero where id_mesero=vid;

  select 1;

END
;;
DELIMITER ;
