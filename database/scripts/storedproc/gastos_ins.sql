-- ----------------------------
-- Procedure structure for gastos_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `gastos_ins`;
DELIMITER ;;
CREATE PROCEDURE `gastos_ins`(

vfecha date, 

vproveedor int,

vfactura varchar(255), 

vautorizacion varchar(255), 

vdescripcion text,

vtipocompra varchar(255), 

vapiva tinyint(1),

vsubtotal double, 

vdescuento double, 

vsubtotaldesc double, 

vmontoiva double,  

vtotal double, 

vidusu int,

vestatus varchar(255),

vdias int,

vfechapago date,

vcategoria int)
BEGIN

  declare vid int;                                                      

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO gastos (fecha, id_proveedor, nro_factura, nro_autorización, descripcion, 

					  tipo_compra, apiva, subtotal, descuento, subtotaldesc, montoiva, 

                      total, id_usu, estatus, dias, fecha_pago, categoria)

			   VALUE (vfecha, vproveedor, vfactura, vautorizacion, vdescripcion, 

					  vtipocompra, vapiva, vsubtotal, vdescuento, vsubtotaldesc, vmontoiva, 

                      vtotal, vidusu, vestatus, vdias, vfechapago, vcategoria); 

  set vid=(select last_insert_id());

  select vid;

END
;;
DELIMITER ;
