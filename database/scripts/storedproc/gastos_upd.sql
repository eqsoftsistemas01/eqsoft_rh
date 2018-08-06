-- ----------------------------
-- Procedure structure for gastos_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `gastos_upd`;
DELIMITER ;;
CREATE PROCEDURE `gastos_upd`(

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

vcategoria int,

vidgastos int)
BEGIN

                                                  

  DECLARE EXIT handler for sqlexception select 0; 

  UPDATE gastos SET fecha = vfecha, 

					id_proveedor = vproveedor, 

                    nro_factura = vfactura, 

                    nro_autorización = vautorizacion, 

                    descripcion = vdescripcion, 

					tipo_compra = vtipocompra, 

                    apiva = vapiva, 

                    subtotal = vsubtotal, 

                    descuento = vdescuento, 

                    subtotaldesc = vsubtotaldesc, 

                    montoiva = vmontoiva, 

					total = vtotal, 

                    id_usu = vidusu, 

                    estatus = vestatus, 

                    dias = vdias, 

                    fecha_pago = vfechapago, 

                    categoria = vcategoria

			  WHERE id_gastos = vidgastos; 



 select 1;

END
;;
DELIMITER ;
