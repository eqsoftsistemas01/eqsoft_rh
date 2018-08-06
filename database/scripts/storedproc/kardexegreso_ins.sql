-- ----------------------------
-- Procedure structure for kardexegreso_ins
-- ----------------------------
DROP PROCEDURE IF EXISTS `kardexegreso_ins`;
DELIMITER ;;
CREATE PROCEDURE `kardexegreso_ins`(
vidpro int, 
vdocumento varchar(255), 
vdetalle varchar(255), 
vcantidad decimal(11,2),
vvalorunitario decimal(11,2), 
vcostototal decimal(11,2), 
vunidad int,
vidusu int)
BEGIN
  declare vsaldocant decimal(11,2);  
  declare vsaldovalorunit decimal(11,2);  
  declare vsaldocosto decimal(11,2);  
  declare vid int;                                                      

  DECLARE EXIT handler for sqlexception select 0; 

  if (vcantidad != 0) then
    set vvalorunitario = round(vcostototal / vcantidad, 2); 
  else  
    set vvalorunitario = 0;
  end if;
  
  set vsaldocant = 0;
  set vsaldovalorunit = 0;
  set vsaldocosto = 0;
  
  set @maxid = ifnull((select max(id_kardex) as maxid from kardex where id_producto = vidpro), 0);
  if (@maxid > 0) then
    set vsaldocant  = ifnull((select saldocantidad from kardex where id_kardex = @maxid),0);                                                      
    set vsaldovalorunit = ifnull((select saldovalorunitario from kardex where id_kardex = @maxid),0);                                                      
    set vsaldocosto  = ifnull((select saldocostototal from kardex where id_kardex = @maxid),0);                                                      
  end if;  

  set vsaldocant = vsaldocant - vcantidad;
  set vsaldocosto = vsaldocosto - vcostototal;
  if (vsaldocant > 0) then
	set vsaldovalorunit = round(vsaldocosto / vsaldocant,2);
  else 
	set vsaldocant = 0;
	set vsaldovalorunit = 0;
	set vsaldocosto = 0;
  end if;  
    
  INSERT INTO kardex (id_producto, documento, detalle, tipomovimiento, 
                     cantidad, valorunitario, costototal, saldocantidad, 
                     saldovalorunitario, saldocostototal, idunidadstock, idusuario)
	VALUE (vidpro, vdocumento, vdetalle, 0, vcantidad, 
		   vvalorunitario, vcostototal, vsaldocant, 
           vsaldovalorunit, vsaldocosto, vunidad, vidusu); 

  set vid=(select last_insert_id());

  select vid;

END
;;
DELIMITER ;
