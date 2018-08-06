-- ----------------------------
-- Procedure structure for pedido_det_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `pedido_det_ins`;
DELIMITER ;;
CREATE PROCEDURE `pedido_det_ins`(
    vidpro int,
    vidalm int,
    vid_mesa int
)
BEGIN

  declare vid int;                                                      

  DECLARE EXIT handler for sqlexception select 0; 

	INSERT INTO pedido_detalle (id_mesa, id_producto, cantidad, precio, estatus, variante, id_almacen)

	SELECT vid_mesa, pro_id, 1, pro_precioventa, '0', habilitavariante, vidalm 
      FROM producto WHERE pro_id = vidpro ;

  set vid=(select last_insert_id());

  select vid;

END
;;
DELIMITER ;
