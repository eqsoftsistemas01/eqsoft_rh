-- ----------------------------
-- Procedure structure for area_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `area_del`;
DELIMITER ;;
CREATE PROCEDURE `area_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from area WHERE id_area = vid;

  select 1;

END
;;
DELIMITER ;
