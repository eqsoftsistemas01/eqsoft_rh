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
