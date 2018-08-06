-- ----------------------------
-- Procedure structure for cliente_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `cliente_ins`;
DELIMITER ;;
CREATE PROCEDURE `cliente_ins`(

vnom varchar(255),

vtip_ide varchar(100),

vnro_ide varchar(100),

vniv varchar(255),

vref varchar(255),

vcorreo varchar(255),

vciu varchar(255),

vrel tinyint,

vdir longtext, 

vtelf varchar(255), 

vmay tinyint, 

vpre int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  insert into clientes(nom_cliente, tipo_ident_cliente, ident_cliente, nivel_est_cliente, 

                       ref_cliente, correo_cliente, ciudad_cliente, relacionado, direccion_cliente, 

                       telefonos_cliente, mayorista, tipo_precio)

    VALUES(vnom, vtip_ide, vnro_ide, vniv, vref, vcorreo, vciu, vrel, 

           vdir, vtelf, vmay, vpre);

  select last_insert_id();

END
;;
DELIMITER ;
