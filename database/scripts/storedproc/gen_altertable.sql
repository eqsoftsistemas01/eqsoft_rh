-- ----------------------------
-- Procedure structure for gen_altertable
-- ----------------------------
DROP PROCEDURE IF EXISTS `gen_altertable`;
DELIMITER ;;
CREATE PROCEDURE `gen_altertable`(
vtabla text, 
vcolumna text,
vtipodato text,
vconsulta text
)
BEGIN
  DECLARE EXIT handler for sqlexception select 0;
  
  /*START TRANSACTION;*/
  
  SET @s = CONCAT('ALTER TABLE `',vtabla,'`',' ADD `',vcolumna,'` ',vtipodato);
  PREPARE stmtd FROM @s;
  EXECUTE stmtd;  
  
  select 1;
END
;;
DELIMITER ;
