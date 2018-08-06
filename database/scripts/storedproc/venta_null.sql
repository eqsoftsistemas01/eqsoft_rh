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
