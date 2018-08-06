-- ----------------------------
-- Procedure structure for mesa_sel
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesa_sel`;
DELIMITER ;;
CREATE PROCEDURE `mesa_sel`()
BEGIN

  SELECT m.id_mesa, m.nom_mesa, m.capacidad, a.nom_area 

                     FROM mesa m

                     INNER JOIN area a ON a.id_area = m.id_area;

END
;;
DELIMITER ;
