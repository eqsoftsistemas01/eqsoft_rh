-- ----------------------------
-- Procedure structure for area_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `area_upd`;
DELIMITER ;;
CREATE PROCEDURE `area_upd`(

vid int,

vnom varchar(255)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  UPDATE area SET 

    nom_area = vnom

  WHERE id_area = vid;

  select 1;

END
;;
DELIMITER ;
