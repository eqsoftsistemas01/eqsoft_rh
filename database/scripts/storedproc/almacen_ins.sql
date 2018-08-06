-- ----------------------------
-- Procedure structure for almacen_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `almacen_ins`;
DELIMITER ;;
CREATE PROCEDURE `almacen_ins`(

vnomalm varchar(255),

vdiralm varchar(255),

vresalm varchar(255),

vdesalm varchar(255),

vsucalm int,

vdepalm int,

vprodalm int


)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO almacen(almacen_nombre, almacen_direccion, almacen_responsable, 

                      almacen_descripcion, sucursal_id, almacen_deposito, almacen_idproducto)

    VALUES(vnomalm, vdiralm, vresalm, vdesalm, vsucalm, vdepalm, vprodalm);

  select last_insert_id() as id;

END
;;
DELIMITER ;
