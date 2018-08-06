-- ----------------------------
-- Procedure structure for cajagastos_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `cajagastos_ins`;
DELIMITER ;;
CREATE PROCEDURE `cajagastos_ins`(

vid_mov int,
vid_usu int,
vdescripcion varchar(255),
vmonto decimal(11,2),
vemi varchar(255),
vrec varchar(255)

)
BEGIN
	
    DECLARE vcont INT;

	DECLARE EXIT handler for sqlexception select 0; 
    
    SET vcont = (SELECT valor + 1 FROM contador WHERE id_contador = 9);

	INSERT INTO caja_egreso(id_mov, id_usu, descripcion, monto, emisor, receptor, nroegreso)
        VALUES(vid_mov, vid_usu, vdescripcion, vmonto, vemi, vrec, vcont);
        
	UPDATE contador SET valor = vcont  WHERE id_contador = 9;        

  SELECT vid_mov;

END
;;
DELIMITER ;
