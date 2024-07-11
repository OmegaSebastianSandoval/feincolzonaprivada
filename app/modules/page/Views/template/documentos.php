<div class="docs-container docs-container-<?php echo $contenedor->contenido_id; ?> <?php echo $contenedor->contenido_columna; ?> my-4 <?php if ($contenedor->contenido_caja == 1) { echo 'caja-tipografica'; } ?>" style="<?php if($contenedor->contenido_top){ echo ' padding-top:'.$contenedor->contenido_top.'px; ';} ?><?php if($contenedor->contenido_bottom){ echo ' padding-bottom: '.$contenedor->contenido_bottom.'px; ';} ?><?php if($contenedor->contenido_left){ echo ' padding-left:'.$contenedor->contenido_left.'px; ';} ?><?php if($contenedor->contenido_right){ echo ' padding-right:'.$contenedor->contenido_right.'px; ';} ?>">
  <div class="row mx-0">
    <div class="col-12 docs-header" data-id="docs-<?php echo $contenedor->contenido_id; ?>" style="background: <?php echo $contenedor->contenido_fondo_color; ?>;">
      <h3><?php echo $contenedor->contenido_titulo; ?></h3>
    </div>
    <div class="col-12">
      <div class="row items-docs-row">
        <?php foreach ($rescontenido['hijos'] as $hijos) { ?>
          <?php $docs = $hijos['detalle']; ?>
            <?php if(!$docs->contenido_archivo){ ?>
              <div class="col-12 mb-3" id="nivel1_<?php echo $docs->contenido_id; ?>">
                <div class="row">
                  <div class="col-12 doc-item-theme prueba" data-id="docs-<?php echo $docs->contenido_id; ?>" style="background: <?php echo $docs->contenido_fondo_color; ?>;">
                    <div class="row d-flex justify-content-center align-items-center">
                      <div class="col-9 pl-4">
                        <h4><?php echo $docs->contenido_titulo; ?></h4>
                      </div>
                      <div class="col-3 d-flex justify-content-end align-items-center">
                        <img class="img-docs" src="/skins/page/images/down.png" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="col-12 cont-docs" style="padding-left: 35px; padding-right: 35px;" id="docs-<?php echo $docs->contenido_id; ?>">
                    <div class="row docs">
                      <?php foreach ($hijos['hijos'] as $ddoc2) { ?>
                      <?php $d = $ddoc2['nietos'] ?>
                        <?php if(!$d->contenido_archivo){ ?>
                          <div class="d-flex w-100 flex-column">
                            <div class="col-12 doc-item-theme my-2" data-id="docs-<?php echo $d->contenido_id; ?>" style="background: <?php echo $d->contenido_fondo_color; ?>;">
                              <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-9 pl-4">
                                  <h4 id="nivel2_<?php echo $d->contenido_id; ?>"><?php echo $d->contenido_titulo; ?></h4>
                                </div>
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                  <img class="img-docs" src="/skins/page/images/down.png" alt="">
                                </div>
                              </div>
                            </div>
                            <div class="col-12 cont-docs mb-2" style="padding-left: 35px; padding-right: 35px;" id="docs-<?php echo $d->contenido_id; ?>">
                              <div class="row docs">
                                <?php foreach ($ddoc2['detalle'] as $r2) { ?>
                                  <?php $r = $r2['subsubnietos'] ?>
                                  <?php if(!$r->contenido_archivo){ ?>
                                    <div class="d-flex w-100 flex-column">
                                      <div class="col-12 doc-item-theme my-2 prueba" data-id="docs-<?php echo $r->contenido_id; ?>" style="background: <?php echo $r->contenido_fondo_color; ?>;">
                                        <div class="row d-flex justify-content-center align-items-center">
                                          <div class="col-9 pl-4">
                                            <h4 id="nivel3_<?php echo $r->contenido_id; ?>"><?php echo $r->contenido_titulo; ?></h4>
                                          </div>
                                          <div class="col-3 d-flex justify-content-end align-items-center">
                                            <img class="img-docs" src="/skins/page/images/down.png" alt="">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-12 cont-docs mb-2" style="padding-left: 35px; padding-right: 35px;" id="docs-<?php echo $r->contenido_id; ?>">
                                        <div class="row docs">

                                          <?php foreach ($ddoc2['subnietos'] as $r3) { ?>
                                            <?php foreach($r3['subsubnietos'] as $r1){ ?>
                                              <?php if($r1->contenido_padre==$r->contenido_id){ ?>  



                                                <?php if(!$r1->contenido_archivo){ ?>
                                                  <div class="d-flex w-100 flex-column">
                                                    <div class="col-12 doc-item-theme my-2 prueba" data-id="docs-<?php echo $r1->contenido_id; ?>" style="background: <?php echo $r1->contenido_fondo_color; ?>;">
                                                      <div class="row d-flex justify-content-center align-items-center">
                                                        <div class="col-9 pl-4">
                                                          <h4 id="nivel4_<?php echo $r1->contenido_id; ?>"><?php echo $r1->contenido_titulo; ?></h4>
                                                        </div>
                                                        <div class="col-3 d-flex justify-content-end align-items-center">
                                                          <img class="img-docs" src="/skins/page/images/down.png" alt="">
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-12 cont-docs mb-2" style="padding-left: 35px; padding-right: 35px;" id="docs-<?php echo $r1->contenido_id; ?>">
                                                      <div class="row docs">

                                                <?php
                                                if($_GET['prueba2']==1){
                                                  print_r($this->contenidos['hijos_'.$r1->contenido_id]);
                                                }
                                                ?>

                                                        <?php foreach($this->contenidos['hijos_'.$r1->contenido_id] as $bis3){ ?>
                                                          <?php if($bis3->contenido_id>0){ ?>


                                                                    <?php if(!$bis3->contenido_archivo){ ?>

                                                                        <div class="d-flex w-100 flex-column">
                                                                          <div class="col-12 doc-item-theme my-2 prueba" data-id="docs-<?php echo $bis3->contenido_id; ?>" style="background: <?php echo $bis3->contenido_fondo_color; ?>;">
                                                                            <div class="row d-flex justify-content-center align-items-center">
                                                                              <div class="col-9 pl-4">
                                                                                <h4 id="nivel5_<?php echo $bis3->contenido_id; ?>"><?php echo $bis3->contenido_titulo; ?></h4>
                                                                              </div>
                                                                              <div class="col-3 d-flex justify-content-end align-items-center">
                                                                                <img class="img-docs" src="/skins/page/images/down.png" alt="">
                                                                              </div>
                                                                            </div>
                                                                          </div>
                                                                          <div class="col-12 cont-docs mb-2" style="padding-left: 35px; padding-right: 35px;" id="docs-<?php echo $padre5=$bis3->contenido_id; ?>">
                                                                            <div class="row docs">
                                                                              <?php foreach($ddoc2['hijos'] as $bis1){ ?>
                                                                                <?php foreach($bis1['subsubnietos'] as $bis2){ ?>
                                                                                  <?php foreach($bis2['bisnietos'] as $bis3){ ?>
                                                                                    <?php foreach($bis3['bisnietos2'] as $bis4){ ?>
                                                                                      <?php if($bis4->contenido_id>0 and $bis4->contenido_padre==$padre5){ ?>
                                                                                        
                                                                                        <?php if($bis4->contenido_archivo){ ?>
                                                                                          <div class="col-12 doc">
                                                                                            <div class="row d-flex justify-content-start align-items-center">
                                                                                              <div class="col-10">
                                                                                                <h5 id="nivel6_<?php echo $bis4->contenido_id; ?>"><?php echo $bis4->contenido_titulo; ?></h5>
                                                                                              </div>
                                                                                              <?php if ($bis4->contenido_archivo) { ?>
                                                                                                <div class="col-2 d-flex justify-content-end">
                                                                                                  <a href="/files/<?php echo $bis4->contenido_archivo ?>" target="_blank"><img class="img-docs" src="/skins/page/images/pdf.png" alt=""></a>
                                                                                                </div>
                                                                                              <?php } ?>
                                                                                            </div>
                                                                                          </div>       
                                                                                        <?php }else{ ?>
                                                                                          <div class="d-flex w-100 flex-column">
                                                                                            <div class="col-12 doc-item-theme my-2 prueba" data-id="docs-<?php echo $bis4->contenido_id; ?>" style="background: <?php echo $bis4->contenido_fondo_color; ?>;">
                                                                                              <div class="row d-flex justify-content-center align-items-center">
                                                                                                <div class="col-9 pl-4">
                                                                                                  <h4 id="nivel5_<?php echo $bis4->contenido_id; ?>"><?php echo $bis4->contenido_titulo; ?></h4>
                                                                                                </div>
                                                                                                <div class="col-3 d-flex justify-content-end align-items-center">
                                                                                                  <img class="img-docs" src="/skins/page/images/down.png" alt="">
                                                                                                </div>
                                                                                              </div>
                                                                                            </div>
                                                                                            

                                                                                            <div class="col-12 cont-docs mb-2" style="padding-left: 35px; padding-right: 35px;" id="docs-<?php echo $padre6=$bis4->contenido_id; ?>">
                                                                                              <div class="row docs">
                                                                                                <?php foreach($this->contenidos['hijos_'.$padre6] as $bis5){ ?>
                                                                                                  <?php if($bis5->contenido_archivo){ ?>
                                                                                                    <div class="col-12 doc">
                                                                                                      <div class="row d-flex justify-content-start align-items-center">
                                                                                                        <div class="col-10">
                                                                                                          <h5 id="nivel7_<?php echo $bis5->contenido_id; ?>"><?php echo $bis5->contenido_titulo; ?></h5>
                                                                                                        </div>
                                                                                                        <?php if ($bis5->contenido_archivo) { ?>
                                                                                                          <div class="col-2 d-flex justify-content-end">
                                                                                                            <a href="/files/<?php echo $bis5->contenido_archivo ?>" target="_blank"><img class="img-docs" src="/skins/page/images/pdf.png" alt=""></a>
                                                                                                          </div>
                                                                                                        <?php } ?>
                                                                                                      </div>
                                                                                                    </div>       
                                                                                                  <?php } ?>                                                                                                
                                                                                                <?php } ?>
                                                                                              </div>
                                                                                            </div> 
                                                                                          </div>   

                                                                                        <?php } ?>                                      
                                                                                      <?php } ?>

                                                                                    <?php } ?>

                                                                                  <?php } ?>
                                                                                <?php } ?>
                                                                              <?php } ?>
                                                                            </div>
                                                                          </div>
                                                                        </div>

                                                                    <?php } ?>

                                                                    <?php if (!$bis3->contenido_icono) { ?>
                        
                                                                      <?php if ($bis3->contenido_id>0) { ?>
                                                                        <div class="col-12 doc">
                                                                          <div class="row d-flex justify-content-start align-items-center">
                                                                            <div class="col-10">
                                                                              <h5 class="h5_1"><?php echo $bis3->contenido_titulo; ?></h5>
                                                                            </div>
                                                                            <?php if ($bis3->contenido_archivo) { ?>
                                                                              <div class="col-2 d-flex justify-content-end">
                                                                                <a href="/files/<?php echo $bis3->contenido_archivo ?>" target="_blank"><img class="img-docs" src="/skins/page/images/pdf.png" alt=""></a>
                                                                              </div>
                                                                            <?php } ?>
                                                                          </div>
                                                                        </div>                           
                                                                      <?php } ?>
                                                                    <?php } else { ?>
                                                                      <div class="col-12 doc" style="border-radius: 0 0 10px 10px;">
                                                                        <div class="row d-flex justify-content-end align-items-center">
                                                                          <?php if ($bis3->contenido_archivo) { ?>
                                                                            <div class="col-1 d-flex justify-content-end">
                                                                              <a href="/files/<?php echo $bis3->contenido_archivo ?>" target="_blank"><img class="img-docs ms-auto" src="/images/<?php echo $bis3->contenido_icono ?>" alt="" style="width: 70px;"></a>
                                                                            </div>
                                                                          <?php } ?>
                                                                          <div class="col-11">
                                                                            <h5 style="color: var(--cian); font-family: 'mont-semi-bold';"><?php echo $bis3->contenido_titulo; ?></h5>
                                                                          </div>
                                                                        </div>
                                                                      </div>
                                                                    <?php } ?>

                                                          <?php } ?>

                                                        <?php } ?>
                                                      </div>
                                                    </div>
                                                  </div>
                                                <?php }else{ ?>
                                                  <?php if (!$r1->contenido_icono) { ?>
                                                    <div class="col-12 doc">
                                                      <div class="row d-flex justify-content-start align-items-center">
                                                        <div class="col-10">
                                                          <h5 class="h5_2"><?php echo $r1->contenido_titulo; ?></h5>
                                                        </div>
                                                        <?php if ($r1->contenido_archivo) { ?>
                                                          <div class="col-2 d-flex justify-content-end">
                                                            <a href="/files/<?php echo $r1->contenido_archivo ?>" target="_blank"><img class="img-docs" src="/skins/page/images/pdf.png" alt=""></a>
                                                          </div>
                                                        <?php } ?>
                                                      </div>
                                                    </div>
                                                  <?php } else { ?>
                                                    <div class="col-12 doc" style="border-radius: 0 0 10px 10px;">
                                                      <div class="row d-flex justify-content-end align-items-center">
                                                        <?php if ($r1->contenido_archivo) { ?>
                                                          <div class="col-1 d-flex justify-content-end">
                                                            <a href="/files/<?php echo $r1->contenido_archivo ?>" target="_blank"><img class="img-docs ms-auto" src="/images/<?php echo $r1->contenido_icono ?>" alt="" style="width: 70px;"></a>
                                                          </div>
                                                        <?php } ?>
                                                        <div class="col-11">
                                                          <h5 style="color: var(--cian); font-family: 'mont-semi-bold';"><?php echo $r1->contenido_titulo; ?></h5>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  <?php } ?>
                                                <?php } ?>
                                              <?php } ?>  
                                            <?php } ?>
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>
                                    <?php }else{ ?>
                                    <?php if (!$r->contenido_icono) { ?>
                                      <div class="col-12 doc">
                                        <div class="row d-flex justify-content-start align-items-center">
                                          <div class="col-10">
                                            <h5 class="h5_3"><?php echo $r->contenido_titulo; ?></h5>
                                          </div>
                                          <?php if ($r->contenido_archivo) { ?>
                                            <div class="col-2 d-flex justify-content-end">
                                              <a href="/files/<?php echo $r->contenido_archivo ?>" target="_blank"><img class="img-docs" src="/skins/page/images/pdf.png" alt=""></a>
                                            </div>
                                          <?php } ?>
                                        </div>
                                      </div>
                                    <?php } else { ?>
                                      <div class="col-12 doc" style="border-radius: 0 0 10px 10px;">
                                        <div class="row d-flex justify-content-end align-items-center">
                                          <?php if ($r->contenido_archivo) { ?>
                                            <div class="col-1 d-flex justify-content-end">
                                              <a href="/files/<?php echo $r->contenido_archivo ?>" target="_blank"><img class="img-docs ms-auto" src="/images/<?php echo $r->contenido_icono ?>" alt="" style="width: 70px;"></a>
                                            </div>
                                          <?php } ?>
                                          <div class="col-11">
                                            <h5 style="color: var(--cian); font-family: 'mont-semi-bold';"><?php echo $r->contenido_titulo; ?></h5>
                                          </div>
                                        </div>
                                      </div>
                                    <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                          <?php }else{ ?>
                          <?php if (!$d->contenido_icono) { ?>
                            <div class="col-12 doc">
                              <div class="row d-flex justify-content-start align-items-center">
                                <div class="col-10">
                                  <h5 class="h5_4"><?php echo $d->contenido_titulo; ?></h5>
                                </div>
                                <?php if ($d->contenido_archivo) { ?>
                                  <div class="col-2 d-flex justify-content-end">
                                    <a href="/files/<?php echo $d->contenido_archivo ?>" target="_blank"><img class="img-docs" src="/skins/page/images/pdf.png" alt=""></a>
                                  </div>
                                <?php } ?>
                              </div>
                            </div>
                          <?php } else { ?>
                            <div class="col-12 doc" style="border-radius: 0 0 10px 10px;">
                              <div class="row d-flex justify-content-end align-items-center">
                                <?php if ($d->contenido_archivo) { ?>
                                  <div class="col-1 d-flex justify-content-end">
                                    <a href="/files/<?php echo $d->contenido_archivo ?>" target="_blank"><img class="img-docs ms-auto" src="/images/<?php echo $d->contenido_icono ?>" alt="" style="width: 70px;"></a>
                                  </div>
                                <?php } ?>
                                <div class="col-11">
                                  <h5 style="color: var(--cian); font-family: 'mont-semi-bold';"><?php echo $d->contenido_titulo; ?></h5>
                                </div>
                              </div>
                            </div>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php }else{ ?>
              <div class="col-12 mb-3">
                <div class="row pl-3 d-flex justify-content-center align-items-center">
                  <div class="col-12 doc-item-file">
                    <div class="row d-flex justify-content-center align-items-center">
                      <a target="_blank" href="/files/<?php echo $docs->contenido_archivo; ?>" class="col-1 p-0 d-flex justify-content-end align-items-center">
                        <img class="img-docs" src="/skins/page/images/pdf.png" alt="">
                      </a>
                      <div class="col-11 pl-4">
                        <h4><?php echo $docs->contenido_titulo; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>