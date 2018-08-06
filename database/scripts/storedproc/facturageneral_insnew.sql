-- ----------------------------
-- Procedure structure for facturageneral_insnew
-- ----------------------------
DROP PROCEDURE IF EXISTS `facturageneral_insnew`;
DELIMITER ;;
CREATE PROCEDURE `facturageneral_insnew`(
vusu int,
vtipodoc int,
vtipcancelacion int
)
BEGIN

  declare vid int;
  declare vidprof int;
  declare vidreg int;
  declare vidabono int;
  declare done int;
 
  declare cur1 cursor for 
   SELECT idreg
    FROM formapago_tmp t
    INNER JOIN venta_tmp v on v.id_venta = t.id_venta
    WHERE v.idusu = vusu AND id_tipcancelacion = vtipcancelacion; 

  DECLARE EXIT handler for sqlexception select 0; 
  declare continue handler for not found set done=1;                                      
  
  SET vidprof = (SELECT id_proforma FROM venta_tmp WHERE idusu = vusu);
  
  UPDATE contador SET valor = valor WHERE id_contador = vtipodoc;
  

  insert into venta (fecha, area, mesa, mesero, tipo_doc, nro_factura, tipo_ident, nro_ident, nom_cliente, telf_cliente,
                     dir_cliente, correo_cliente, ciu_cliente, valiva, subconiva, subsiniva, desc_monto,
                     descsubconiva, descsubsiniva, montoiva, montototal, fecharegistro, idusu, estatus, 
                     id_cliente, id_tipcancelacion, montoimpuestoadicional)
	SELECT curdate(), area, mesa, mesero, vtipodoc, 
			(select case vtipodoc when 2 
					 then concat((select valor from parametros where id=4),'-',(select valor from parametros where id=5),'-',LPAD(valor, 9, '0')) 
					 else LPAD(valor, 9, '0') 
					end 
			  from contador where id_contador=vtipodoc), 
		   tipo_ident, nro_ident, nom_cliente, telf_cliente,
		   dir_cliente, correo_cliente, ciu_cliente, 
           ifnull((select valor from parametros where id=1),0.12) as valiva, 
           subconiva, subsiniva, desc_monto,
		   descsubconiva, descsubsiniva, montoiva, 
		   round(descsubconiva + descsubsiniva + montoiva + round((descsubconiva + descsubsiniva) * ifnull((select valor from parametros where id=13),0) / 100 ,2),2) as montototal, now(), 
           idusu, 1, id_cliente, vtipcancelacion,
           round((descsubconiva + descsubsiniva) * ifnull((select valor from parametros where id=13),0) / 100 ,2) as impuestoadicional
	FROM venta_tmp
	where idusu = vusu;
                                    
  set vid = (select last_insert_id());

  UPDATE contador SET valor = valor + 1 WHERE id_contador = vtipodoc;
  
  
  INSERT INTO venta_detalle (id_venta, id_producto, cantidad, precio, subtotal, iva, montoiva, descmonto, descsubtotal, id_almacen, tipprecio)
    SELECT vid, d.id_producto, d.cantidad, d.precio, d.subtotal, d.iva, d.montoiva, d.descmonto, d.descsubtotal, d.id_almacen, tipprecio
      FROM venta_detalle_tmp d
      INNER JOIN venta_tmp v on v.id_venta = d.id_venta
      WHERE v.idusu = vusu;
                                      	   
  set done = 0;
  open cur1;
  igmLoop: loop
      fetch cur1 into vidreg;
      if done = 1 then leave igmLoop; end if;

	  INSERT INTO venta_formapago (id_venta, id_formapago, monto, fecha, nro_comprobante) 
		SELECT vid, id_formapago, 
               case when id_tipcancelacion=1 and id_formapago=1 then 
                 (select montototal from venta where id_venta=vid) - 
                 ifnull((select sum(f2.monto) from formapago_tmp f2 
                           INNER JOIN venta_tmp v on v.id_venta = f2.id_venta
                           WHERE v.idusu = vusu AND f2.id_tipcancelacion=1 and id_formapago!=1),0)
                 else monto
               end, 
               now(), 
               case when vtipcancelacion = 2 then
                  ifnull((select valor from contador WHERE id_contador = 7),1) 
                 else 0
               end  
		FROM formapago_tmp 
		WHERE idreg = vidreg;
											
      set vidabono = (select last_insert_id());
      
      if vtipcancelacion = 2 then 
		UPDATE contador set valor=ifnull(valor,1)+1 WHERE id_contador = 7;
      end if;  
											
	  INSERT INTO venta_formapagobanco (id_abono, id_banco, fechaemision, fechacobro, numerocuenta, 
										numerodocumento, descripciondocumento) 
		SELECT vidabono, id_banco, fechaemision, fechacobro, numerocuenta, numerodocumento, descripciondocumento 
		FROM formapago_tmp t
        INNER JOIN formapago f on f.id_formapago = t.id_formapago
		WHERE idreg = vidreg and esinstrumentobanco = 1;

	  INSERT INTO venta_formapagotarjeta (id_abono, id_tarjeta, id_banco, fechaemision, numerotarjeta, 
										  numerodocumento, descripciondocumento) 
		SELECT vidabono, id_tarjeta, id_banco, fechaemision, numerotarjeta, numerodocumento, descripciondocumento 
		FROM formapago_tmp t
        INNER JOIN formapago f on f.id_formapago = t.id_formapago
		WHERE idreg = vidreg and estarjeta = 1;

      if vtipcancelacion = 2 then 
        INSERT INTO venta_creditoabonoinicial (id_abono) Values(vidabono); 
      end if;

  end loop igmLoop;
  close cur1;    
                                        
  if vtipcancelacion = 2 then 
	INSERT INTO venta_credito (id_venta, fechalimite, dias, p100interes_credito, p100interes_mora,
                               cantidadcuotas, abonoinicial, montobasecredito, montointerescredito,
                               montocredito, id_estado)
      SELECT vid, fechalimite, dias, p100interes_credito, p100interes_mora,
             cantidadcuotas, abonoinicial, montobasecredito, montointerescredito,
             montocredito, 1
        FROM venta_credito_tmp t                       
        INNER JOIN venta_tmp v on v.id_venta = t.id_venta
        where v.idusu = vusu;
        
	INSERT INTO venta_creditocuota (id_venta, fechalimite, monto)
      SELECT vid, fechalimite, monto
        FROM venta_creditocuota_tmp t                       
        INNER JOIN venta_tmp v on v.id_venta = t.id_venta
        where v.idusu = vusu;
        
  end if;
  
  DELETE FROM pedido WHERE id_mesa = ifnull((SELECT idmesa FROM venta_tmp where idusu = vusu),0);
  DELETE FROM pedido_detalle WHERE id_mesa = ifnull((SELECT idmesa FROM venta_tmp where idusu = vusu),0);
  
  DELETE FROM formapago_tmp WHERE id_venta in (select id_venta from venta_tmp where idusu = vusu);
  DELETE FROM venta_creditocuota_tmp WHERE id_venta in (select id_venta from venta_tmp where idusu = vusu);
  DELETE FROM venta_credito_tmp WHERE id_venta in (select id_venta from venta_tmp where idusu = vusu);
  
  DELETE FROM venta_detalle_tmp WHERE id_venta in (select id_venta from venta_tmp where idusu = vusu);
  DELETE FROM venta_tmp where idusu = vusu;
  
	IF vidprof > 0 THEN
		UPDATE proforma SET id_factura = vid WHERE id_proforma = vidprof;
	END IF;  
  
  SELECT vid;

END
;;
DELIMITER ;
