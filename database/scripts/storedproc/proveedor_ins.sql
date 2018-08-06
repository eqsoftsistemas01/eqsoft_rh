-- ----------------------------
-- Procedure structure for proveedor_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `proveedor_ins`;
DELIMITER ;;
CREATE PROCEDURE `proveedor_ins`(

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

  insert into proveedor (nom_proveedor, tip_ide_proveedor, nro_ide_proveedor,

                         razon_social, telf_proveedor, correo_proveedor,

                         ciudad_proveedor, direccion_proveedor, relacionada) 

    values (vnombre, vtipo, videntificador, vrazonsocial, vtelefono,

            vcorreo, vciudad, vdireccion, vrelacionada);

  select last_insert_id();

END
;;
DELIMITER ;
