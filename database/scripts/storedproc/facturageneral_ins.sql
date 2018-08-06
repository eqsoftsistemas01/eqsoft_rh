-- ----------------------------
-- Procedure structure for facturageneral_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `facturageneral_ins`;
DELIMITER ;;
CREATE PROCEDURE `facturageneral_ins`(vusu int,
vtipodoc int,
vefectivo decimal(11,2), 
vtarjeta decimal(11,2))
BEGIN

  declare vid int;

  DECLARE EXIT handler for sqlexception select 0; 
  SET time_zone = '-5:00';
  UPDATE contador SET valor = valor WHERE id_contador = vtipodoc;

  insert into venta (fecha, area, mesa, mesero, tipo_doc, nro_factura, tipo_ident, nro_ident, nom_cliente, telf_cliente,
                                                     dir_cliente, correo_cliente, ciu_cliente, valiva, subconiva, subsiniva, desc_monto,
                                                     descsubconiva, descsubsiniva, montoiva, montototal, fecharegistro, idusu, estatus, id_cliente)
                                    SELECT fecha, area, mesa, mesero, vtipodoc, 
                                            (select case vtipodoc when 2 
                                                     then concat((select valor from parametros where id=4),'-',(select valor from parametros where id=5),'-',LPAD(valor, 9, '0')) 
                                                     else LPAD(valor, 9, '0') 
                                                    end 
                                              from contador where id_contador=vtipodoc), 
                                           tipo_ident, nro_ident, nom_cliente, telf_cliente,
                                           dir_cliente, correo_cliente, ciu_cliente, valiva, subconiva, subsiniva, desc_monto,
                                           descsubconiva, descsubsiniva, montoiva, 
                                           round(descsubconiva + descsubsiniva + montoiva,2) as montototal, now(), idusu, 1, id_cliente 
                                    FROM venta_tmp
                                    where idusu = vusu;
                                    
  set vid = (select last_insert_id());

  UPDATE contador SET valor = valor + 1 WHERE id_contador = vtipodoc;
  
  INSERT INTO venta_formapago (id_venta, id_formapago, monto) VALUES (vid, 1, vefectivo);
  INSERT INTO venta_formapago (id_venta, id_formapago, monto) VALUES (vid, 2, vtarjeta);
  
  INSERT INTO venta_detalle (id_venta, id_producto, cantidad, precio, subtotal, iva, montoiva, descmonto, descsubtotal, id_almacen, tipprecio)
                                    SELECT vid, d.id_producto, d.cantidad, d.precio, d.subtotal, d.iva, d.montoiva, d.descmonto, d.descsubtotal, d.id_almacen, tipprecio
                                      FROM venta_detalle_tmp d
                                      INNER JOIN venta_tmp v on v.id_venta = d.id_venta
                                      WHERE v.idusu = vusu;
  
  DELETE FROM pedido WHERE id_mesa = (SELECT idmesa FROM venta_tmp where idusu = vusu);
  DELETE FROM pedido_detalle WHERE id_mesa = (SELECT idmesa FROM venta_tmp where idusu = vusu);
  
  DELETE FROM venta_detalle_tmp WHERE id_venta in (select id_venta from venta_tmp where idusu = vusu);
  DELETE FROM venta_tmp where idusu = vusu;
   
  select vid;

END
;;
DELIMITER ;
