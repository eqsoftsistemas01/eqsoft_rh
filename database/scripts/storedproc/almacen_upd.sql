-- ----------------------------
-- Procedure structure for almacen_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `almacen_upd`;
DELIMITER ;;
CREATE PROCEDURE `almacen_upd`(

vid int,

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

  UPDATE almacen SET 

    almacen_nombre = vnomalm, 

    almacen_direccion = vdiralm, 

    almacen_responsable = vresalm, 

    almacen_descripcion = vdesalm, 

    sucursal_id = vsucalm,

    almacen_deposito = vdepalm, 
    
    almacen_idproducto = vprodalm 
   
  WHERE almacen_id = vid;

  select 1;

END
;;
DELIMITER ;
