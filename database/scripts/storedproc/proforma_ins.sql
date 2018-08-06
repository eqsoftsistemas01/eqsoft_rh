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
