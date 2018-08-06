-- ----------------------------
-- Procedure structure for venta_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `venta_ins`;
DELIMITER ;;
CREATE PROCEDURE `venta_ins`(vfecha date, 

varea varchar(255), 

vmesa varchar(255), 

vmesero varchar(11), 

vtipo_doc int,

vnro_factura varchar(255), 

vtipo_ident varchar(255), 

vnro_ident varchar(255), 

vnom_cliente varchar(255), 

vtelf_cliente varchar(255), 

vdir_cliente varchar(255), 

vvaliva double, 

vsubconiva double, 

vsubsiniva double, 

vdesc_monto double,

vdescsubconiva double, 

vdescsubsiniva double, 

vmontoiva double, 

vmontototal double,

vidmesa int,

vidusu int)
BEGIN

  declare vid int;                                                      

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO venta (fecha, area, mesa, mesero, tipo_doc, nro_factura, tipo_ident, nro_ident, nom_cliente,

											telf_cliente, dir_cliente, valiva, subconiva, subsiniva, desc_monto,

											descsubconiva, descsubsiniva, montoiva, montototal, idusu, estatus)

							 VALUE (vfecha, varea, vmesa, vmesero, vtipo_doc, vnro_factura, vtipo_ident, vnro_ident, 

											vnom_cliente, vtelf_cliente, vdir_cliente, vvaliva, 

											vsubconiva, vsubsiniva, vdesc_monto,

											vdescsubconiva, vdescsubsiniva, vmontoiva, vmontototal, vidusu, 1); 

  set vid=(select last_insert_id());

  select vid;

END
;;
DELIMITER ;
