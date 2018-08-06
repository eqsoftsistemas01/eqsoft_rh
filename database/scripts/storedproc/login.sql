-- ----------------------------
-- Procedure structure for login
-- ----------------------------
DROP PROCEDURE IF EXISTS `login`;
DELIMITER ;;
CREATE PROCEDURE `login`(vlogusu varchar(255), vpasusu varchar(255))
BEGIN
    DECLARE vidusu INT;
    DECLARE vtiempo INT;
	DECLARE EXIT handler for sqlexception select 0;
    
    SET vidusu = IFNULL((SELECT id_usu FROM usu_sistemas WHERE log_usu = vlogusu AND pwd_usu = MD5(vpasusu)), 0);
    SET vtiempo = IFNULL((SELECT TIME_TO_SEC(TIMEDIFF(NOW(),ultimoacceso)) AS difseg FROM usu_sistemas WHERE id_usu = vidusu), 0);    
    IF vidusu <> 0 THEN 
		IF vtiempo > 12 THEN     
			SELECT *, 1 AS val FROM usu_sistemas WHERE log_usu = vlogusu AND pwd_usu = MD5(vpasusu); 
		ELSE 
			SELECT 999999999 AS val;
		END IF;
	ELSE 
		SELECT 0 AS val;
	END IF;	
END
;;
DELIMITER ;
