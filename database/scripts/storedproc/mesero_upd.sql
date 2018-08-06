-- ----------------------------
-- Procedure structure for mesero_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `mesero_upd`;
DELIMITER ;;
CREATE PROCEDURE `mesero_upd`(

vid int,

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

  update mesero set

    tipo_ident_mesero=vtipide, ced_mesero=vnroide, 

    nom_mesero=vnombre, telf_mesero=vtelf,

    correo_mesero=vcorreo, direccion_mesero=vdir, 

    foto_mesero=vfot, estatus_mesero=vest

    where id_mesero=vid;

  select 1;

END
;;
DELIMITER ;
