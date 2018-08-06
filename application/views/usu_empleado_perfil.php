                                <select class="form-control" id="cmb_mesero" name="cmb_mesero">
                                    <?php 
                                      if(@$mesero != NULL){ ?>
                                        <option  value="0" selected="TRUE">Seleccione...</option>
                                    <?php }  
                                              if (count($mesero) > 0) {
                                                foreach ($mesero as $me):
                                                    if(@$fic_usu->id_mesero != NULL){
                                                        if($me->id_mesero == $fic_usu->id_mesero){ ?>
                                                            <option  value="<?php  print $me->id_mesero; ?>" selected="TRUE"><?php  print $me->nom_mesero ?></option> 
                                                            <?php
                                                        }else{ ?>
                                                            <option value="<?php  print $me->id_mesero; ?>"> <?php  print $me->nom_mesero ?> </option>
                                                            <?php
                                                        }
                                                    }else{ ?>
                                                        <option value="<?php  print $me->id_mesero; ?>"> <?php  print $me->nom_mesero ?> </option>
                                                        <?php
                                                        }   ?>
                                                    <?php

                                                endforeach;
                                              }
                                              ?>
                                </select>
