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
