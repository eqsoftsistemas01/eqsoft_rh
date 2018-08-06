-- ----------------------------
-- Procedure structure for mesero_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesero_ins`;
DELIMITER ;;
CREATE PROCEDURE `mesero_ins`(

vtipide varchar(100), 

vnroide varchar(255), 

vnombre varchar(100), 

vtelf varchar(100), 

vcorreo varchar(100), 

vdir varchar(100), 

vfot longblob, 

vest varchar(3))
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  INSERT INTO mesero (tipo_ident_mesero, ced_mesero, nom_mesero, telf_mesero,

                      correo_mesero, direccion_mesero, foto_mesero, estatus_mesero) 

    VALUES (vtipide, vnroide, vnombre, vtelf, vcorreo, vdir, vfot, vest);

  select last_insert_id();

END
;;
DELIMITER ;
