-- ----------------------------
-- Procedure structure for formapago_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `formapago_del`;
DELIMITER ;;
CREATE PROCEDURE `formapago_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from formapago where id_formapago=vid;

  select 1;

END
;;
DELIMITER ;
