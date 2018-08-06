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
