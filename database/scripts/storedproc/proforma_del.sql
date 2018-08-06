-- ----------------------------
-- Procedure structure for proforma_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `proforma_del`;
DELIMITER ;;
CREATE PROCEDURE `proforma_del`(vid INT)
BEGIN

  DECLARE EXIT handler for sqlexception select 0 as res; 
  
  DELETE FROM proforma_detalle WHERE id_proforma = vid; 

  DELETE FROM proforma WHERE id_proforma = vid; 
  
  SELECT 1 as res;

END
;;
DELIMITER ;
