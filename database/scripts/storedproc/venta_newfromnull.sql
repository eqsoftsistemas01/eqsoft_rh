-- ----------------------------
-- Procedure structure for venta_newfromnull
-- ----------------------------
DROP PROCEDURE IF EXISTS `venta_newfromnull`;
DELIMITER ;;
CREATE PROCEDURE `venta_newfromnull`(
vidventaanulada int,
vcausaanulacion text,
vfecha date, 
vtipo_doc int,
vnro_factura varchar(255), 
vtipo_ident varchar(255), 
vnro_ident varchar(255), 
vnom_cliente varchar(255), 
vtelf_cliente varchar(255), 
vdir_cliente varchar(255), 
vidusu int)
BEGIN
  declare vid int;                                                      
  DECLARE EXIT handler for sqlexception select 0; 
  SET time_zone = '-5:00';
  UPDATE venta set estatus = 3 WHERE id_venta = vidventaanulada;
  
  INSERT INTO venta_anulada (idventa, idusuario, fecha, causa_anulacion)
    VALUES (vidventaanulada, vidusu, now(), vcausaanulacion);
  

  INSERT INTO venta (fecha, area, mesa, mesero, tipo_doc, nro_factura, tipo_ident, nro_ident, nom_cliente,
					 telf_cliente, dir_cliente, valiva, subconiva, subsiniva, desc_monto,
					 descsubconiva, descsubsiniva, montoiva, montototal, idusu, estatus, montoimpuestoespecial)
	SELECT vfecha, area, mesa, mesero, vtipo_doc, vnro_factura, vtipo_ident, 
           vnro_ident, vnom_cliente, vtelf_cliente, vdir_cliente, 
           valiva, subconiva, subsiniva, desc_monto,
		   descsubconiva, descsubsiniva, montoiva, montototal, vidusu, 1, montoimpuestoespecial
      FROM venta where id_venta = vidventaanulada;     

  set vid=(select last_insert_id());

  INSERT INTO venta_detalle (id_venta, id_producto, cantidad, precio, subtotal,
                             iva, montoiva, descmonto, descsubtotal)
    SELECT vid, id_producto, cantidad, precio, subtotal,
           iva, montoiva, descmonto, descsubtotal
      FROM venta_detalle WHERE id_venta = vidventaanulada;       
      

  INSERT INTO venta_formapago (id_venta, id_formapago, monto)
    SELECT vid, id_formapago, monto
      FROM venta_formapago WHERE id_venta = vidventaanulada;        

  select vid;
END
;;
DELIMITER ;
