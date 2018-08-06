-- ----------------------------
-- Procedure structure for area_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `area_ins`;
DELIMITER ;;
CREATE PROCEDURE `area_ins`(

vnom varchar(255)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO area(nom_area) VALUES(vnom);

  select last_insert_id();

END
;;
DELIMITER ;
