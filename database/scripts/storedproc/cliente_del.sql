-- ----------------------------
-- Procedure structure for cliente_del
-- ----------------------------
DROP PROCEDURE IF EXISTS `cliente_del`;
DELIMITER ;;
CREATE PROCEDURE `cliente_del`(

vid int

)
BEGIN

  DECLARE EXIT handler for sqlexception select 0; 

  delete from clientes where id_cliente=vid;        

  select 1;

END
;;
DELIMITER ;
