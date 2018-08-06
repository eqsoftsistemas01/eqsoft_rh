-- ----------------------------
-- Procedure structure for almacen_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `almacen_del`;
DELIMITER ;;
CREATE PROCEDURE `almacen_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from almacen where almacen_id=vid;        

  select 1;

END
;;
DELIMITER ;
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
-- ----------------------------
-- Procedure structure for almacen_sel
-- ----------------------------
DROP PROCEDURE IF EXISTS `almacen_sel`;
DELIMITER ;;
CREATE PROCEDURE `almacen_sel`()
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  SELECT a.almacen_id, a.almacen_nombre, a.almacen_direccion, a.almacen_responsable, 
         a.almacen_descripcion, s.nom_sucursal, a.almacen_deposito, a.almacen_idproducto

                     FROM almacen a

                     INNER JOIN sucursal s ON a.sucursal_id = s.id_sucursal;

END
;;
DELIMITER ;
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
-- ----------------------------
-- Procedure structure for area_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `area_del`;
DELIMITER ;;
CREATE PROCEDURE `area_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from area WHERE id_area = vid;

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for area_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `area_ins`;
DELIMITER ;;
CREATE PROCEDURE `area_ins`(

vnom varchar(255)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO area(nom_area) VALUES(vnom);

  select last_insert_id();

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for area_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `area_upd`;
DELIMITER ;;
CREATE PROCEDURE `area_upd`(

vid int,

vnom varchar(255)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  UPDATE area SET 

    nom_area = vnom

  WHERE id_area = vid;

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cajaapertura_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajaapertura_ins`;
DELIMITER ;;
CREATE PROCEDURE `cajaapertura_ins`(

vusuario int,

vmonto double

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 
  SET time_zone = '-5:00';
  INSERT INTO caja_movimiento(id_usuario, fecha_apertura, monto_apertura, estado) 

    VALUES(vusuario,  NOW(), vmonto, 0);

  select last_insert_id();

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cajaapertura_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajaapertura_upd`;
DELIMITER ;;
CREATE PROCEDURE `cajaapertura_upd`(

vusuario int,
vefectivo double,
vtarjeta double,
vegreso double,
vcompras double,
vtotalcaja double,
vnotacierre text,
vsalida decimal(11,2),
vjusti text

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 
  SET time_zone = '-5:00';
	UPDATE caja_movimiento
    SET	estado = 1, 
		fecha_cierre = Now(),
		ingresoefectivo = vefectivo,
		ingresotarjeta = vtarjeta,
		pagos = vegreso,
		compras = vcompras,
		existente = vtotalcaja,
		observaciones = vnotacierre,
		salida = vsalida,
		justificacion = vjusti
	WHERE id_usuario=vusuario and estado=0;

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cajachica_cierre
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajachica_cierre`;
DELIMITER ;;
CREATE PROCEDURE `cajachica_cierre`(
vidusuario int,
vfecha date,
vmonto decimal(11,2),
vobs text
)
BEGIN
set @id=(SELECT id_caja FROM caja_chica where estatus=0 limit 1);
SET time_zone = '-5:00';
update caja_chica set 
  fechacierre = vfecha,
  fecharegistrocierre = now(),
  usuariocierre = vidusuario,
  montocierre = vmonto,
  estatus = 1,
  obs = vobs
  where id_caja = @id;
END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cajachica_insapertura
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajachica_insapertura`;
DELIMITER ;;
CREATE PROCEDURE `cajachica_insapertura`(
vusuario int,
vfecha date,
vmonto double,
vdescripcion varchar(255)
)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 
  SET time_zone = '-5:00';
  INSERT INTO caja_chica(fechaapertura, fecharegistroapertura, usuarioapertura, 
                         descripcion, montoapertura, estatus) 
    VALUES(vfecha, NOW(), vusuario, vdescripcion, vmonto, 0);

  select last_insert_id();

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cajachica_movimientos
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajachica_movimientos`;
DELIMITER ;;
CREATE PROCEDURE `cajachica_movimientos`(
vid int
)
BEGIN

declare vdesde datetime;
declare vhasta datetime;

set vdesde = (select fechaapertura from caja_chica where id_caja = vid);
set vhasta = (select fechacierre from caja_chica where id_caja = vid);
set vhasta = ifnull(vhasta, now());
 
select fecha, nro_factura as numerodoc, montototal as valor, '' as descripcion, 'Egreso' as tipo  
  from compra 
  where cajachica = 1 and fecha between vdesde and vhasta
union  
select fecha, nro_factura as numerodoc, total as valor, descripcion, 'Egreso' as tipo  
  from gastos 
  where fecha between vdesde and vhasta
union
select fechaingreso as fecha, numeroingreso as numerodoc, monto as valor, descripcion, 'Ingreso' as tipo   
  from caja_chicaingreso
  where fechaingreso between vdesde and vhasta  
order by fecha;
END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cajachica_resumen
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajachica_resumen`;
DELIMITER ;;
CREATE PROCEDURE `cajachica_resumen`()
BEGIN
set @id=(SELECT id_caja FROM caja_chica where estatus=0 limit 1);
select fechaapertura, montoapertura, 
       ifnull((select sum(montototal) from compra 
         where cajachica = 1 and fecha between fechaapertura and ifnull(fechacierre, now())),0) as compras,
       ifnull((select sum(total) from gastos 
         where fecha between fechaapertura and ifnull(fechacierre, now())),0) as gastos,
       ifnull((select sum(monto) from caja_chicaingreso
         where fechaingreso between fechaapertura and ifnull(fechacierre, now())),0) as ingresos,
	   (montoapertura + ifnull((select sum(monto) from caja_chicaingreso
         where fechaingreso between fechaapertura and ifnull(fechacierre, now())),0) - 
				ifnull((select sum(montototal) from compra 
         where cajachica = 1 and fecha between fechaapertura and ifnull(fechacierre, now())),0) -	
				ifnull((select sum(total) from gastos 
         where fecha between fechaapertura and ifnull(fechacierre, now())),0)) as resumen         
  from caja_chica where id_caja = @id;
END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cajagastos_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajagastos_ins`;
DELIMITER ;;
CREATE PROCEDURE `cajagastos_ins`(

vid_mov int,
vid_usu int,
vdescripcion varchar(255),
vmonto decimal(11,2),
vemi varchar(255),
vrec varchar(255)

)
BEGIN
	
    DECLARE vcont INT;

	DECLARE EXIT handler for sqlexception select 0; 
    
    SET vcont = (SELECT valor + 1 FROM contador WHERE id_contador = 9);

	INSERT INTO caja_egreso(id_mov, id_usu, descripcion, monto, emisor, receptor, nroegreso)
        VALUES(vid_mov, vid_usu, vdescripcion, vmonto, vemi, vrec, vcont);
        
	UPDATE contador SET valor = vcont  WHERE id_contador = 9;        

  SELECT vid_mov;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for categoria_id
-- ----------------------------
DROP PROCEDURE IF EXISTS `categoria_id`;
DELIMITER ;;
CREATE PROCEDURE `categoria_id`(id NUMERIC(10))
SELECT cat_id, cat_descripcion FROM categorias WHERE cat_id = id
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cliente_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `cliente_del`;
DELIMITER ;;
CREATE PROCEDURE `cliente_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from clientes where id_cliente=vid;        

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cliente_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `cliente_ins`;
DELIMITER ;;
CREATE PROCEDURE `cliente_ins`(

vnom varchar(255),

vtip_ide varchar(100),

vnro_ide varchar(100),

vniv varchar(255),

vref varchar(255),

vcorreo varchar(255),

vciu varchar(255),

vrel tinyint,

vdir longtext, 

vtelf varchar(255), 

vmay tinyint, 

vpre int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  insert into clientes(nom_cliente, tipo_ident_cliente, ident_cliente, nivel_est_cliente, 

                       ref_cliente, correo_cliente, ciudad_cliente, relacionado, direccion_cliente, 

                       telefonos_cliente, mayorista, tipo_precio)

    VALUES(vnom, vtip_ide, vnro_ide, vniv, vref, vcorreo, vciu, vrel, 

           vdir, vtelf, vmay, vpre);

  select last_insert_id();

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for cliente_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `cliente_upd`;
DELIMITER ;;
CREATE PROCEDURE `cliente_upd`(

vid int,

vnom varchar(255),

vtip_ide varchar(100),

vnro_ide varchar(100),

vniv varchar(255),

vref varchar(255),

vcorreo varchar(255),

vciu varchar(255),

vrel tinyint,

vdir longtext, 

vtelf varchar(255), 

vmay tinyint, 

vpre int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  UPDATE clientes SET 

    nom_cliente = vnom,

	tipo_ident_cliente = vtip_ide,

	ident_cliente = vnro_ide,

	nivel_est_cliente = vniv,

	ref_cliente = vref,

	correo_cliente = vcorreo,

	ciudad_cliente = vciu,

	relacionado = vrel, 

	direccion_cliente = vdir, 

	telefonos_cliente = vtelf, 

	mayorista = vmay, 

	tipo_precio = vpre

  WHERE id_cliente = vid;

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for compra_null
-- ----------------------------
DROP PROCEDURE IF EXISTS `compra_null`;
DELIMITER ;;
CREATE PROCEDURE `compra_null`(
vidcompra int, 
vidusu int,
vcausa text
)
BEGIN
  DECLARE EXIT handler for sqlexception select 0;
  
  /*START TRANSACTION;*/
 
  UPDATE compra set estatus = 3 WHERE id_comp = vidcompra;
  SET time_zone = '-5:00';
  INSERT INTO compra_anulada (idcompra, idusuario, fecha, causa_anulacion)
    VALUES (vidcompra, vidusu, now(), vcausa);

  UPDATE almapro as a
    INNER JOIN compra_det v on v.id_pro = a.id_pro
    SET existencia = a.existencia - v.cantidad	
    WHERE (v.id_comp = vidcompra);

  UPDATE almapro as a
    SET existencia = 0 	
    WHERE (existencia < 0);
   
  /*COMMIT;*/
  
  select 1;
END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for correo_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `correo_upd`;
DELIMITER ;;
CREATE PROCEDURE `correo_upd`(

vusuario varchar(255),
vclave varchar(255),
vpuerto int,
vsmtp varchar(255)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  UPDATE correo SET 
	usuario = vusuario,
	clave = vclave,
	puerto = vpuerto,
	smtp = vsmtp;

END
;;
DELIMITER ;
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
  SET time_zone = '-5:00';
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
  
  select vid;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for formapago_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `formapago_del`;
DELIMITER ;;
CREATE PROCEDURE `formapago_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from formapago where id_formapago=vid;

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for formapago_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `formapago_ins`;
DELIMITER ;;
CREATE PROCEDURE `formapago_ins`(

vcod varchar(45),

vnom varchar(45)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO formapago(cod_formapago, nombre_formapago) 

    VALUES(vcod,vnom);

  select last_insert_id();

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for formapago_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `formapago_upd`;
DELIMITER ;;
CREATE PROCEDURE `formapago_upd`(

vid int,

vcod varchar(45),

vnom varchar(45)

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  update formapago set cod_formapago=vcod, nombre_formapago=vnom 

    where id_formapago=vid;

  select 1;

END
;;
DELIMITER ;
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
-- ----------------------------
-- Procedure structure for gasto_null
-- ----------------------------
DROP PROCEDURE IF EXISTS `gasto_null`;
DELIMITER ;;
CREATE PROCEDURE `gasto_null`(
vidgasto int, 
vidusu int,
vcausa text
)
BEGIN
  DECLARE EXIT handler for sqlexception select 0;
  
  /*START TRANSACTION;*/
  SET time_zone = '-5:00';
  UPDATE gastos set estatus = 3 WHERE id_gastos = vidgasto;
  
  INSERT INTO gasto_anulado (idgasto, idusuario, fecha, causa_anulacion)
    VALUES (vidgasto, vidusu, now(), vcausa);

  /*COMMIT;*/
  
  select 1;
END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for gen_altertable
-- ----------------------------
DROP PROCEDURE IF EXISTS `gen_altertable`;
DELIMITER ;;
CREATE PROCEDURE `gen_altertable`(
vtabla text, 
vcolumna text,
vtipodato text,
vconsulta text
)
BEGIN
  DECLARE EXIT handler for sqlexception select 0;
  
  /*START TRANSACTION;*/
  
  SET @s = CONCAT('ALTER TABLE `',vtabla,'`',' ADD `',vcolumna,'` ',vtipodato);
  PREPARE stmtd FROM @s;
  EXECUTE stmtd;  
  
  select 1;
END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for inventariomovimiento_guardar
-- ----------------------------
DROP PROCEDURE IF EXISTS `inventariomovimiento_guardar`;
DELIMITER ;;
CREATE PROCEDURE `inventariomovimiento_guardar`(
vidmov int,
vfecha datetime,
vtipodoc int
)
BEGIN

  declare vid int;                                                      

  DECLARE EXIT handler for sqlexception select 0; 
  SET time_zone = '-5:00';
  UPDATE contador SET valor = valor WHERE id_contador = vtipodoc;

  INSERT INTO inventariodocumento (id_tipodoc, id_usu, fecha, nro_documento, descripcion, total, estatus,
                                   fecharegistro, id_almacen) 
    SELECT id_tipodoc, id_usu, vfecha, 
           (select concat(prefijo,'-',LPAD(valor, 9, '0')) from contador where id_contador=vtipodoc) as nro,
           descripcion, montototal, 1, now(), id_almacen 
      FROM  tmp_movinv WHERE id_mov = vidmov;

  set vid=(select last_insert_id());
  
    UPDATE contador SET valor = valor + 1 WHERE id_contador = vtipodoc;
  
  INSERT INTO inventariodocumento_detalle (id_documento, id_pro, precio_compra, cantidad, id_unimed, montototal)
    SELECT vid, id_pro, precio_compra, cantidad, id_unimed, montototal
      FROM  tmp_movinv_det WHERE id_mov = vidmov;
      
  INSERT INTO almapro (id_pro, id_alm, existencia, id_unimed)
    select p.pro_id, t.id_almacen, 0, p.pro_idunidadmedida from producto p
      inner join tmp_movinv_det d on d.id_pro = p.pro_id
      inner join tmp_movinv t on t.id_mov = d.id_mov
      where t.id_mov = vidmov and
            not exists (select * from almapro where id_pro = pro_id and id_alm = t.id_almacen);      
/*
  set @ingresoegreso = (SELECT case id_tipodoc when 4 then 1 else -1 end
                          FROM tmp_movinv WHERE id_mov = vidmov);
*/

 /*UPDATE almapro 
    SET existencia = almapro.existencia +
                     (SELECT round(sum(
								  case when c.id_unimed = p.pro_idunidadmedida then 1
									   when ifnull(fd.idunidad1,0) != 0 then fd.cantidadequivalente
									   when ifnull(fi.idunidad1,0) != 0 then 1/fi.cantidadequivalente
									   else 0
								  end * c.cantidad),2) 
						 FROM tmp_movinv_det c 
						 inner join producto p on p.pro_id = c.id_pro 
						 left join unidadfactorconversion fd on fd.idunidad1 = c.id_unimed and fd.idunidadequivale = p.pro_idunidadmedida 
						 left join unidadfactorconversion fi on fi.idunidad1 = p.pro_idunidadmedida and fi.idunidadequivale = c.id_unimed 
						 WHERE id_mov = vidmov AND c.id_pro = almapro.id_pro) * @ingresoegreso
			WHERE id_alm=(SELECT id_almacen FROM tmp_movinv WHERE id_mov = vidmov) and 
                  id_pro IN (SELECT distinct id_pro FROM tmp_movinv_det  WHERE id_mov = vidmov);
                  
  DELETE FROM tmp_movinv_det WHERE id_mov = vidmov;                   
  DELETE FROM tmp_movinv WHERE id_mov = vidmov;  */                 
            
  select vid;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for kardexegreso_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `kardexegreso_ins`;
DELIMITER ;;
CREATE PROCEDURE `kardexegreso_ins`(
vidpro int, 
vdocumento varchar(255), 
vdetalle varchar(255), 
vcantidad decimal(11,2),
vvalorunitario decimal(11,2), 
vcostototal decimal(11,2), 
vunidad int,
vidusu int)
BEGIN
  declare vsaldocant decimal(11,2);  
  declare vsaldovalorunit decimal(11,2);  
  declare vsaldocosto decimal(11,2);  
  declare vid int;                                                      

  DECLARE EXIT handler for sqlexception select 0; 

  if (vcantidad != 0) then
    set vvalorunitario = round(vcostototal / vcantidad, 2); 
  else  
    set vvalorunitario = 0;
  end if;
  
  set vsaldocant = 0;
  set vsaldovalorunit = 0;
  set vsaldocosto = 0;
  
  set @maxid = ifnull((select max(id_kardex) as maxid from kardex where id_producto = vidpro), 0);
  if (@maxid > 0) then
    set vsaldocant  = ifnull((select saldocantidad from kardex where id_kardex = @maxid),0);                                                      
    set vsaldovalorunit = ifnull((select saldovalorunitario from kardex where id_kardex = @maxid),0);                                                      
    set vsaldocosto  = ifnull((select saldocostototal from kardex where id_kardex = @maxid),0);                                                      
  end if;  

  set vsaldocant = vsaldocant - vcantidad;
  set vsaldocosto = vsaldocosto - vcostototal;
  if (vsaldocant > 0) then
	set vsaldovalorunit = round(vsaldocosto / vsaldocant,2);
  else 
	set vsaldocant = 0;
	set vsaldovalorunit = 0;
	set vsaldocosto = 0;
  end if;  
    
  INSERT INTO kardex (id_producto, documento, detalle, tipomovimiento, 
                     cantidad, valorunitario, costototal, saldocantidad, 
                     saldovalorunitario, saldocostototal, idunidadstock, idusuario)
	VALUE (vidpro, vdocumento, vdetalle, 0, vcantidad, 
		   vvalorunitario, vcostototal, vsaldocant, 
           vsaldovalorunit, vsaldocosto, vunidad, vidusu); 

  set vid=(select last_insert_id());

  select vid;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for kardexingreso_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `kardexingreso_ins`;
DELIMITER ;;
CREATE PROCEDURE `kardexingreso_ins`(
vidpro int, 
vdocumento varchar(255), 
vdetalle varchar(255), 
vcantidad decimal(11,2),
vvalorunitario decimal(11,2), 
vcostototal decimal(11,2), 
vunidad int,
vidusu int)
BEGIN
  declare vsaldocant decimal(11,2);  
  declare vsaldovalorunit decimal(11,2);  
  declare vsaldocosto decimal(11,2);  
  declare vid int;                                                      

  DECLARE EXIT handler for sqlexception select 0; 
  
  if (vcantidad != 0) then
    set vvalorunitario = round(vcostototal / vcantidad, 2); 
  else  
    set vvalorunitario = 0;
  end if;

  set vsaldocant = 0;
  set vsaldovalorunit = 0;
  set vsaldocosto = 0;
  
  set @maxid = ifnull((select max(id_kardex) as maxid from kardex  where id_producto = vidpro), 0);
  if (@maxid > 0) then
    set vsaldocant  = ifnull((select saldocantidad from kardex where id_kardex = @maxid),0);                                                      
    set vsaldovalorunit = ifnull((select saldovalorunitario from kardex where id_kardex = @maxid),0);                                                      
    set vsaldocosto  = ifnull((select saldocostototal from kardex where id_kardex = @maxid),0);                                                      
  end if;  

  set vsaldocant = vsaldocant + vcantidad;
  set vsaldocosto = vsaldocosto + vcostototal;
  set vsaldovalorunit = vsaldovalorunit + vvalorunitario;
  if (vsaldocant > 0) then
	set vsaldovalorunit = round(vsaldocosto / vsaldocant,2);
  else 
	set vsaldocant = 0;
	set vsaldovalorunit = 0;
	set vsaldocosto = 0;
  end if;  
    
  INSERT INTO kardex (id_producto, documento, detalle, tipomovimiento, 
                     cantidad, valorunitario, costototal, saldocantidad, 
                     saldovalorunitario, saldocostototal, idunidadstock, idusuario)
	VALUE (vidpro, vdocumento, vdetalle, 1, vcantidad, 
		   vvalorunitario, vcostototal, vsaldocant, 
           vsaldovalorunit, vsaldocosto, vunidad, vidusu); 

  set vid=(select last_insert_id());

  select vid;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for login
-- ----------------------------
DROP PROCEDURE IF EXISTS `login`;
DELIMITER ;;
CREATE PROCEDURE `login`(vlogusu varchar(255), vpasusu varchar(255))
BEGIN
    DECLARE vidusu INT;
    DECLARE vtiempo INT;
	DECLARE EXIT handler for sqlexception select 0;
    
    SET vidusu = IFNULL((SELECT id_usu FROM usu_sistemas WHERE log_usu = vlogusu AND pwd_usu = MD5(vpasusu)), 0);
    SET vtiempo = IFNULL((SELECT TIME_TO_SEC(TIMEDIFF(NOW(),ultimoacceso)) AS difseg FROM usu_sistemas WHERE id_usu = vidusu), 0);    
    IF vidusu <> 0 THEN 
		IF vtiempo > 12 THEN     
			SELECT *, 1 AS val FROM usu_sistemas WHERE log_usu = vlogusu AND pwd_usu = MD5(vpasusu); 
		ELSE 
			SELECT 999999999 AS val;
		END IF;
	ELSE 
		SELECT 0 AS val;
	END IF;	
END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for mesa_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesa_del`;
DELIMITER ;;
CREATE PROCEDURE `mesa_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from mesa where id_mesa=vid;

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for mesa_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesa_ins`;
DELIMITER ;;
CREATE PROCEDURE `mesa_ins`(

vnom varchar(255),

varea int,

vcap varchar(255),

vimp int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO mesa (nom_mesa, id_area, capacidad, id_comanda)

    VALUES(vnom, varea, vcap, vimp);

  select last_insert_id();

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for mesa_sel
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesa_sel`;
DELIMITER ;;
CREATE PROCEDURE `mesa_sel`()
BEGIN

  SELECT m.id_mesa, m.nom_mesa, m.capacidad, a.nom_area 

                     FROM mesa m

                     INNER JOIN area a ON a.id_area = m.id_area;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for mesa_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesa_upd`;
DELIMITER ;;
CREATE PROCEDURE `mesa_upd`(

vid int,

vnom varchar(255),

varea int,

vcap varchar(255),

vimp int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  update mesa set nom_mesa=vnom, id_area=varea, capacidad=vcap, id_comanda=vimp

    where id_mesa=vid;

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for mesero_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesero_del`;
DELIMITER ;;
CREATE PROCEDURE `mesero_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from mesero where id_mesero=vid;

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for mesero_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesero_ins`;
DELIMITER ;;
CREATE PROCEDURE `mesero_ins`(

vtipide varchar(100), 

vnroide varchar(255), 

vnombre varchar(100), 

vtelf varchar(100), 

vcorreo varchar(100), 

vdir varchar(100), 

vfot longblob, 

vest varchar(3))
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO mesero (tipo_ident_mesero, ced_mesero, nom_mesero, telf_mesero,

                      correo_mesero, direccion_mesero, foto_mesero, estatus_mesero) 

    VALUES (vtipide, vnroide, vnombre, vtelf, vcorreo, vdir, vfot, vest);

  select last_insert_id();

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for mesero_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesero_upd`;
DELIMITER ;;
CREATE PROCEDURE `mesero_upd`(

vid int,

vtipide varchar(100), 

vnroide varchar(255), 

vnombre varchar(100), 

vtelf varchar(100), 

vcorreo varchar(100), 

vdir varchar(100), 

vfot longblob, 

vest varchar(3))
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  update mesero set

    tipo_ident_mesero=vtipide, ced_mesero=vnroide, 

    nom_mesero=vnombre, telf_mesero=vtelf,

    correo_mesero=vcorreo, direccion_mesero=vdir, 

    foto_mesero=vfot, estatus_mesero=vest

    where id_mesero=vid;

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for pedido_det_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `pedido_det_ins`;
DELIMITER ;;
CREATE PROCEDURE `pedido_det_ins`(
    vidpro int,
    vidalm int,
    vid_mesa int
)
BEGIN

  declare vid int;                                                      

  DECLARE EXIT handler for sqlexception select 0; 

	INSERT INTO pedido_detalle (id_mesa, id_producto, cantidad, precio, estatus, variante, id_almacen)

	SELECT vid_mesa, pro_id, 1, pro_precioventa, '0', habilitavariante, vidalm 
      FROM producto WHERE pro_id = vidpro ;

  set vid=(select last_insert_id());

  select vid;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for proforma_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `proforma_del`;
DELIMITER ;;
CREATE PROCEDURE `proforma_del`(vid INT)
BEGIN

  DECLARE EXIT handler for sqlexception select 0 as res; 
  
  DELETE FROM proforma_detalle WHERE id_proforma = vid; 

  DELETE FROM proforma WHERE id_proforma = vid; 
  
  SELECT 1 as res;

END
;;
DELIMITER ;
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
-- ----------------------------
-- Procedure structure for proforma_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `proforma_ins`;
DELIMITER ;;
CREATE PROCEDURE `proforma_ins`(vusu INT)
BEGIN

  DECLARE vid INT;
  DECLARE vcont INT;

  DECLARE EXIT handler for sqlexception select 0; 
  
	SET vcont = (SELECT valor FROM contador WHERE id_contador = 6);
  
	INSERT INTO proforma (fecha, nro_proforma, id_cliente, id_vendedor, id_puntoventa, valiva, subconiva, 
						  subsiniva, desc_monto, descsubconiva, descsubsiniva, montoiva, montototal, 
						  fecharegistro, idusu, id_factura, observaciones)
	SELECT fecha, vcont, id_cliente, id_vendedor, id_puntoventa, valiva, subconiva, 
				 subsiniva, desc_monto, descsubconiva, descsubsiniva, montoiva, montototal, fecharegistro, 
				 idusu, id_factura, observaciones 
	FROM proforma_tmp
	WHERE idusu = vusu;
									
	SET vid = (SELECT last_insert_id());
    
	INSERT INTO proforma_detalle (id_detalle, id_proforma, id_producto, cantidad, precio, subtotal, iva, montoiva, descmonto, 
                                  descsubtotal, id_almacen, tipprecio)
                                  SELECT  id_detalle, vid, id_producto, cantidad, precio, subtotal, iva, pd.montoiva, descmonto, 
                                          descsubtotal, id_almacen, tipprecio
                                  FROM proforma_detalle_tmp pd
                                  INNER JOIN proforma_tmp pt ON pt.id_proforma = pd.id_proforma
                                  WHERE pt.idusu = vusu;    
    
    UPDATE contador SET valor = valor + 1 WHERE id_contador = 6;   
    
	DELETE FROM proforma_detalle_tmp WHERE id_proforma IN (SELECT id_proforma from proforma_tmp WHERE idusu = vusu);
    DELETE FROM proforma_tmp WHERE idusu = vusu;    
   
	SELECT vid;
    

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for proforma_sel_id
-- ----------------------------
DROP PROCEDURE IF EXISTS `proforma_sel_id`;
DELIMITER ;;
CREATE PROCEDURE `proforma_sel_id`(vusu INT, idprof INT)
BEGIN
	DECLARE vid INT;
	DECLARE EXIT handler for sqlexception select 0; 
  
	DELETE FROM proforma_detalle_tmp WHERE id_proforma IN (SELECT id_proforma from proforma_tmp WHERE idusu = vusu);
    DELETE FROM proforma_tmp WHERE idusu = vusu; 	
  
	INSERT INTO proforma_tmp (id_proftmp, fecha, nro_proforma, id_cliente, id_vendedor, id_puntoventa, valiva, subconiva, 
						  subsiniva, desc_monto, descsubconiva, descsubsiniva, montoiva, montototal, 
						  fecharegistro, idusu, id_factura, observaciones)
	SELECT id_proforma, fecha, nro_proforma, id_cliente, id_vendedor, id_puntoventa, valiva, subconiva, 
				 subsiniva, desc_monto, descsubconiva, descsubsiniva, montoiva, montototal, fecharegistro, 
				 idusu, id_factura, observaciones 
	FROM proforma
	WHERE id_proforma = idprof;
    
    SET vid = (SELECT last_insert_id());
									
	INSERT INTO proforma_detalle_tmp (id_proforma, id_producto, cantidad, precio, subtotal, iva, montoiva, descmonto, 
                                  descsubtotal, id_almacen, tipprecio)
                                  SELECT vid, id_producto, cantidad, precio, subtotal, iva, pd.montoiva, descmonto, 
                                          descsubtotal, id_almacen, tipprecio
                                  FROM proforma_detalle pd
                                  INNER JOIN proforma pt ON pt.id_proforma = pd.id_proforma
                                  WHERE pt.id_proforma = idprof;    
    
    SELECT idprof;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for proforma_upd_id
-- ----------------------------
DROP PROCEDURE IF EXISTS `proforma_upd_id`;
DELIMITER ;;
CREATE PROCEDURE `proforma_upd_id`(vusu INT, idprof INT)
BEGIN

	DECLARE EXIT handler for sqlexception select 0; 
  
	UPDATE proforma p
	INNER JOIN proforma_tmp pt ON p.id_proforma = pt.id_proftmp
	SET p.fecha = pt.fecha,
		p.id_cliente = pt.id_cliente, 
		p.id_vendedor = pt.id_vendedor, 
		p.id_puntoventa = pt.id_puntoventa, 
		p.valiva = pt.valiva, 
		p.subconiva = pt.subconiva, 
		p.subsiniva = pt.subsiniva, 
		p.desc_monto = pt.desc_monto, 
		p.descsubconiva = pt.descsubconiva, 
		p.descsubsiniva = pt.descsubsiniva, 
		p.montoiva = pt.montoiva, 
		p.montototal = pt.montototal, 
		p.fecharegistro = pt.fecharegistro, 
		p.idusu = pt.idusu,
        p.observaciones = pt.observaciones
	WHERE p.id_proforma = idprof; 
    
    DELETE FROM proforma_detalle WHERE id_proforma = idprof;
									
	INSERT INTO proforma_detalle (id_detalle, id_proforma, id_producto, cantidad, precio, subtotal, iva, montoiva, descmonto, 
                                  descsubtotal, id_almacen, tipprecio)
                                  SELECT  id_detalle, pt.id_proftmp, id_producto, cantidad, precio, subtotal, iva, pd.montoiva, descmonto, 
                                          descsubtotal, id_almacen, tipprecio
                                  FROM proforma_detalle_tmp pd
                                  INNER JOIN proforma_tmp pt ON pt.id_proforma = pd.id_proforma
                                  WHERE pt.id_proftmp = idprof;    
                                  
	DELETE FROM proforma_detalle_tmp WHERE id_proforma IN (SELECT id_proforma from proforma_tmp WHERE idusu = vusu);
    DELETE FROM proforma_tmp WHERE idusu = vusu; 									
    
    SELECT idprof;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for proveedor_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `proveedor_del`;
DELIMITER ;;
CREATE PROCEDURE `proveedor_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from proveedor where id_proveedor=vid;        

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for proveedor_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `proveedor_ins`;
DELIMITER ;;
CREATE PROCEDURE `proveedor_ins`(

vnombre varchar(255),

vtipo varchar(3),

videntificador varchar(255),

vrazonsocial varchar(255),

vtelefono varchar(255),

vcorreo varchar(255),

vciudad varchar(255),

vdireccion longtext,

vrelacionada tinyint

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  insert into proveedor (nom_proveedor, tip_ide_proveedor, nro_ide_proveedor,

                         razon_social, telf_proveedor, correo_proveedor,

                         ciudad_proveedor, direccion_proveedor, relacionada) 

    values (vnombre, vtipo, videntificador, vrazonsocial, vtelefono,

            vcorreo, vciudad, vdireccion, vrelacionada);

  select last_insert_id();

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for proveedor_sel
-- ----------------------------
DROP PROCEDURE IF EXISTS `proveedor_sel`;
DELIMITER ;;
CREATE PROCEDURE `proveedor_sel`()
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  select nom_proveedor, tip_ide_proveedor, nro_ide_proveedor,

         razon_social, telf_proveedor, correo_proveedor,

         ciudad_proveedor, direccion_proveedor, relacionada

     from proveedor;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for proveedor_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `proveedor_upd`;
DELIMITER ;;
CREATE PROCEDURE `proveedor_upd`(

vid int,

vnombre varchar(255),

vtipo varchar(3),

videntificador varchar(255),

vrazonsocial varchar(255),

vtelefono varchar(255),

vcorreo varchar(255),

vciudad varchar(255),

vdireccion longtext,

vrelacionada tinyint

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  update proveedor set

    nom_proveedor=vnombre, 

    tip_ide_proveedor=vtipo, 

    nro_ide_proveedor=videntificador,

    razon_social=vrazonsocial, 

    telf_proveedor=vtelefono, 

    correo_proveedor=vcorreo,

    ciudad_proveedor=vciudad, 

    direccion_proveedor=vdireccion, 

    relacionada=vrelacionada

    where id_proveedor=vid;        

  select 1;

END
;;
DELIMITER ;
-- ----------------------------
-- Procedure structure for usuario_upd_acceso
-- ----------------------------
DROP PROCEDURE IF EXISTS `usuario_upd_acceso`;
DELIMITER ;;
CREATE PROCEDURE `usuario_upd_acceso`(
vidusu int
)
BEGIN
  SET time_zone = '-5:00';
  update usu_sistemas set ultimoacceso = now() where id_usu = vidusu;
END
;;
DELIMITER ;
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
-- ----------------------------
-- Procedure structure for venta_null
-- ----------------------------
DROP PROCEDURE IF EXISTS `venta_null`;
DELIMITER ;;
CREATE PROCEDURE `venta_null`(
vidventa int, 
vidusu int,
vcausa text
)
BEGIN
  DECLARE EXIT handler for sqlexception select 0;
  
  /*START TRANSACTION;*/
  SET time_zone = '-5:00';
  UPDATE venta set estatus = 3 WHERE id_venta = vidventa;
  
  INSERT INTO venta_anulada (idventa, idusuario, fecha, causa_anulacion)
    VALUES (vidventa, vidusu, now(), vcausa);

  UPDATE almapro as a
    INNER JOIN venta_detalle v on v.id_producto = a.id_pro and v.id_almacen = a.id_alm
    INNER JOIN producto p on p.pro_id = a.id_pro
    SET existencia = a.existencia + v.cantidad	
    WHERE (v.id_venta = vidventa) AND (IFNULL(p.preparado, 0) = 0);

  UPDATE almapro as a
    INNER JOIN producto_ingrediente i on i.id_proing = a.id_pro
    INNER JOIN producto p on p.pro_id = a.id_pro
    INNER JOIN venta_detalle v on v.id_producto = i.id_pro and v.id_almacen = a.id_alm
    INNER JOIN producto p1 on p1.pro_id = v.id_producto
    left join unidadfactorconversion fd on fd.idunidad1 = i.unimed and fd.idunidadequivale = p.pro_idunidadmedida 
    left join unidadfactorconversion fi on fi.idunidad1 = p.pro_idunidadmedida and fi.idunidadequivale = i.unimed 
    SET existencia = a.existencia + 
					 round(case when i.unimed = p.pro_idunidadmedida then 1
                                when ifnull(fd.idunidad1,0) != 0 then fd.cantidadequivalente
                                when ifnull(fi.idunidad1,0) != 0 then 1/fi.cantidadequivalente
                                else 0
                           end * i.cantidad * v.cantidad,2)                     
    WHERE (v.id_venta = vidventa) AND (IFNULL(p1.preparado, 0) = 1);
    
  /*COMMIT;*/
  
  select 1;
END
;;
DELIMITER ;
