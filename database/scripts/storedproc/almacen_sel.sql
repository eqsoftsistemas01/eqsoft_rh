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
