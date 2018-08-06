-- ----------------------------
-- Procedure structure for venta_ins_copy
-- ----------------------------
DROP PROCEDURE IF EXISTS `venta_ins_copy`;
DELIMITER ;;
CREATE PROCEDURE `venta_ins_copy`(

vfecha date, 

varea varchar(255), 

vmesa varchar(255), 

vmesero varchar(11), 

vnro_factura varchar(255), 

vtipo_ident varchar(255), 

vnro_ident varchar(255), 

vnom_cliente varchar(255), 

vtelf_cliente varchar(255), 

vdir_cliente varchar(255), 

vformapago varchar(255), 

vvaliva double, 

vsubconiva double, 

vsubsiniva double, 

vdesc_monto double,

vdescsubconiva double, 

vdescsubsiniva double, 

vmontoiva double, 

vmontototal double,

vidmesa int,

vidusu int

)
BEGIN

  declare vid int;                                                      

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO venta (fecha, area, mesa, mesero, nro_factura, tipo_ident, nro_ident, nom_cliente,

                                                      telf_cliente, dir_cliente, formapago, valiva, subconiva, subsiniva, desc_monto,

                                                      descsubconiva, descsubsiniva, montoiva, montototal, idusu)

                                               VALUE (vfecha, varea, vmesa, vmesero, vnro_factura, vtipo_ident, vnro_ident, 

                                                      vnom_cliente, vtelf_cliente, vdir_cliente, vformapago, vvaliva, 

                                                      vsubconiva, vsubsiniva, vdesc_monto,

                                                      vdescsubconiva, vdescsubsiniva, vmontoiva, vmontototal, vidusu); 

  set vid=(select last_insert_id());

  INSERT INTO venta_detalle (id_venta, id_producto, cantidad, precio, subtotal)

                                   SELECT vid, id_producto, cantidad, precio, (cantidad * precio) AS subtotal 

                                   FROM pedido_detalle WHERE id_mesa = vidmesa;

  select vid;

END
;;
DELIMITER ;
