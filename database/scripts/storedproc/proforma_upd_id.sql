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
