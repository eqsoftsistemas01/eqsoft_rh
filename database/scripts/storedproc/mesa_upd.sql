-- ----------------------------
-- Procedure structure for mesa_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesa_upd`;
DELIMITER ;;
CREATE PROCEDURE `mesa_upd`(

vid int,

vnom varchar(255),

varea int,

vcap varchar(255),

vimp int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  update mesa set nom_mesa=vnom, id_area=varea, capacidad=vcap, id_comanda=vimp

    where id_mesa=vid;

  select 1;

END
;;
DELIMITER ;
