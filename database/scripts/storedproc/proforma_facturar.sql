-- ----------------------------
-- Procedure structure for proforma_facturar
-- ----------------------------
DROP PROCEDURE IF EXISTS `proforma_facturar`;
DELIMITER ;;
CREATE PROCEDURE `proforma_facturar`(idprof INT)
BEGIN
	declare vid int;
	declare idusuario int;
	declare idventa int;
	DECLARE EXIT handler for sqlexception select 0 as vid; 
    set vid = 999999;
  
    set idusuario = (SELECT idusu FROM proforma WHERE id_proforma = idprof);
    if not isnull(idusuario) then 
      set idventa = (SELECT id_venta FROM venta_tmp WHERE idusu = idusuario);
      if not isnull(idventa) then
        DELETE FROM venta_detalle_tmp where id_venta = idventa;
      end if;  
      DELETE FROM venta_tmp where idusu = idusuario;
    end if;
    /*DELETE FROM venta_tmp where idusu in (SELECT idusu FROM proforma WHERE id_proforma = idprof);*/
  
    INSERT INTO venta_tmp (fecha,mesa,mesero,tipo_doc,nro_factura,tipo_ident,
                           nro_ident,nom_cliente,telf_cliente,dir_cliente,correo_cliente,
						   ciu_cliente,valiva,subconiva,subsiniva,desc_monto,descsubconiva,
                           descsubsiniva,montoiva,montototal,fecharegistro,idusu,idmesa,id_cliente)
	  SELECT p.fecha, nom_mesa, nom_mesero, 2, '', c.tipo_ident_cliente, c.ident_cliente, c.nom_cliente, c.telefonos_cliente,
             c.direccion_cliente, c.correo_cliente, c.ciudad_cliente,
   		     p.valiva, p.subconiva, p.subsiniva, p.desc_monto, p.descsubconiva, p.descsubsiniva, 
		     p.montoiva, p.montototal, now(), p.idusu, p.id_puntoventa, p.id_cliente
      FROM proforma p
      LEFT JOIN mesa m on m.id_mesa = p.id_puntoventa
      LEFT JOIN mesero s on s.id_mesero = p.id_vendedor
      LEFT JOIN clientes c on c.id_cliente = p.id_cliente
	  WHERE id_proforma = idprof; 
								
    set vid = (select last_insert_id());                            
                                
	INSERT INTO venta_detalle_tmp (id_venta, id_producto, cantidad, precio, subtotal, iva, montoiva, 
                                   descmonto, descsubtotal, id_almacen, tipprecio)
	  SELECT  vid, id_producto, cantidad, precio, subtotal, iva, pd.montoiva, descmonto, 
			  descsubtotal, id_almacen, tipprecio
		  FROM proforma_detalle pd
		  WHERE id_proforma = idprof;    
                                  
    
    SELECT vid;

END
;;
DELIMITER ;
