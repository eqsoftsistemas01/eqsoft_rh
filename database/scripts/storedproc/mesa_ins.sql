-- ----------------------------
-- Procedure structure for mesa_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesa_ins`;
DELIMITER ;;
CREATE PROCEDURE `mesa_ins`(

vnom varchar(255),

varea int,

vcap varchar(255),

vimp int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO mesa (nom_mesa, id_area, capacidad, id_comanda)

    VALUES(vnom, varea, vcap, vimp);

  select last_insert_id();

END
;;
DELIMITER ;
