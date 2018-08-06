-- ----------------------------
-- Procedure structure for categoria_id
-- ----------------------------
DROP PROCEDURE IF EXISTS `categoria_id`;
DELIMITER ;;
CREATE PROCEDURE `categoria_id`(id NUMERIC(10))
SELECT cat_id, cat_descripcion FROM categorias WHERE cat_id = id
;;
DELIMITER ;
