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

