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
