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
