-- ----------------------------
-- Procedure structure for cliente_upd
-- ----------------------------
DROP PROCEDURE IF EXISTS `cliente_upd`;
DELIMITER ;;
CREATE PROCEDURE `cliente_upd`(

vid int,

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

  UPDATE clientes SET 

    nom_cliente = vnom,

	tipo_ident_cliente = vtip_ide,

	ident_cliente = vnro_ide,

	nivel_est_cliente = vniv,

	ref_cliente = vref,

	correo_cliente = vcorreo,

	ciudad_cliente = vciu,

	relacionado = vrel, 

	direccion_cliente = vdir, 

	telefonos_cliente = vtelf, 

	mayorista = vmay, 

	tipo_precio = vpre

  WHERE id_cliente = vid;

  select 1;

END
;;
DELIMITER ;
