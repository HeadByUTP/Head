<?php 
headerHaed($data); 
// dep($data); 
$arrPreguntas = $data['preguntas']; 
$datosUsuario = $data['datosUsuario']; 
// dep($data['datosUsuario']['idpersona']); 
// dep($arrPreguntas); 
?>
<main>
    <!--? Inicio Hero -->
    <div class="slider-area2">
        <div class="slider-height2 hero-overly2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 text-center">
                            <h2>Autoevaluación</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Final Hero -->
    <div id="sigue"></div>
    <div class="container mt-120 mb-120">
        <!-- Inicio Formulario -->
        <div class="row">
            <?php
            if (empty($_SESSION['login'])) {
            ?>
                <div class="col-12">
                    <div class="alert alert-danger bg-danger text-white contact__msg" role="alert">
                        Inicie sesión para visualizar la evaluación: <a class="text-white" href="<?= base_url() ?>/iniciar"><b>Cick para iniciar sesión</b></a>
                    </div>
                </div>
            <?php } elseif (empty($_SESSION['datosUni'])) { ?>
                <div class="col-12">
                    <div class="alert alert-danger bg-danger text-white contact__msg" role="alert">
                        Datos de perfil incompletos: <a class="text-white" href="<?= base_url() ?>/usuarios/perfil"><b>Cick para completar datos de su perfil</b></a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-12 col-md-12 col-md-offset-3">
                    <center>
                        <h1 class="title1">Herramienta de Autoevaluación Docente</h1>
                        <h3 class="title2"><?= $arrPreguntas['nombre'] . ' (' . $arrPreguntas['cicloEscolar'] . ')' ?></h3>
                    </center><br>
                    <form id="form">

                        <ul id="progressbar">
                            <?php for ($t = 0; $t < count($arrPreguntas['temas']); $t++) {
                                if ($t == 0) { ?>
                                    <li class="active"><?= $arrPreguntas['temas'][$t]['nombreTema'] ?></li>
                                <?php } else { ?>
                                    <li><?= $arrPreguntas['temas'][$t]['nombreTema'] ?></li>
                            <?php }
                            } ?>
                        </ul>

                        <?php
                        for ($t = 0; $t < count($arrPreguntas['temas']); $t++) {
                        ?>

                            <fieldset id="todo">

                                <?php for ($s = 0; $s < count($arrPreguntas['temas'][$t]['secciones']); $s++) { ?>

                                    <div class="seccion">
                                        <h7>
                                            <b><?= $arrPreguntas['temas'][$t]['secciones'][$s]['nombreSeccion'] ?></b>
                                    </div><br>
                                    <!--   "for" donde empiezan las preguntas -->
                                    <?php for ($p = 0; $p < count($arrPreguntas['temas'][$t]['secciones'][$s]['preguntas']); $p++) { ?>
                                        <div class="pregunta" id="pre">
                                            <h7 id="subpregunta"><b><?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['pregunta'] ?></b></h7>
                                            <input type="hidden" id="preguntaenv" name="preguntaenv[]" data-idcuatri="<?= $arrPreguntas['idCuatrimestre'] ?>" data-nomcuatri="<?= $arrPreguntas['nombre'] . ' (' . $arrPreguntas['cicloEscolar'] . ')' ?>" data-idpreg="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['idPregunta'] ?>" value="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['pregunta'] ?>"><br>
                                            


                                            <?php
                                            if (array_key_exists('opciones', ($arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]))) {
                                                for ($o = 0; $o < count($arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones']); $o++) {
                                                    if ($arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['idTipopregunta'] == 1) { ?>
                                                        <div class="opciones mb-3 mt-3">
                                                            <div class="custom-control custom-control-inline custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input opcionEnv" onclick="verchkRetro(this,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta']?>,  <?= $arrPreguntas['idCuatrimestre'] ?> , '<?= $arrPreguntas['nombre'] ?>', <?= $datosUsuario['idpersona'] ?>)" name="chkElegido<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>[]" id="chkOpcion<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" data-idpregop="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" data-idopenv="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>" data-predes="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['pregunta'] ?>" data-nomopcion="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" value="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" data-iretroenvi="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>">
                                                                <label class="custom-control-label" for="chkOpcion<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>"><?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="retroalimentacion alert alert-primary" id="retroa<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" role="alert">
                                                            <div class="" id="txtRetro">
                                                                <?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>.

                                                            </div>
                                                            <input type="hidden" id="retroEnv[]" name="retroEnv[]" value="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>">

                                                        </div>

                                                        <!--   igual a dos que? -->
                                                    <?php } elseif ($arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['idTipopregunta'] == 2) { ?>
                                                        <div class="opciones mb-3 mt-3" id="divEliminar<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" data-idPreguntadiv="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>">
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="radopcionElegido<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" name="radElegido<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>[]" onclick="verradioRetro(this,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?> , <?= $arrPreguntas['idCuatrimestre'] ?> , '<?= $arrPreguntas['nombre'] ?>', <?= $datosUsuario['idpersona'] ?>)" data-idpregop="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" data-idopenv="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>" data-idopenv="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>" data-pregunta="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['pregunta'] ?>" data-nomopcion="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" value="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" data-iretroenvi="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>" class="custom-control-input opcionEnv">
                                                                <label class="custom-control-label" for="radopcionElegido<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>"><?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="retroalimentacion alert alert-primary radiodes<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" id="retroa<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" role="alert">
                                                            <div class="txtRetro" id="txtRetro">
                                                                <?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>
                                                            </div>
                                                            <input type="hidden" id="retroEnv[]" name="retroEnv[]" value="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>">

                                                        </div>

                                                    <?php } elseif ($arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['idTipopregunta'] == 4) { ?>
                                                        <div class="opciones mb-3 mt-3" id="divEliminardos<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" data-idPreguntadiv="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>">

                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="radopcionElegido<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" name="radElegido<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>[]" data-idpregop="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" data-predes="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['pregunta'] ?>"  data-idopenv="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>" data-nomopcion="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" data-desopcion="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" onclick="verradioRetroUTP(this,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?> )" value="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" data-iretroenvi="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>" class="custom-control-input opcionEnv">
                                                                <label class="custom-control-label" for="radopcionElegido<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>"><?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?></label>
                                                            </div>
                                                           
                                                        </div>
                                                        

                                                        <div class="retroalimentacion alert alert-primary radiodes<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" id="retroa<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" role="alert">
                                                            <div class="txtRetro" id="txtRetro">
                                                                <?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>.
                                                            </div>
                                                            <input type="hidden" id="retroEnv[]" name="retroEnv[]" value="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>">
                                                        </div>

                                                        <?php if ($o == count($arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones']) - 1) { ?>
                                                            <label for=""><b><?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['descripcionMixta'] ?></b></label>
                                                            <div class="form-group mb-3 mt-3">
                                                                <input type="text" class="form-control" name="txtRespuestaMR[]" id="txtRespuestaRadioMix<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>">
                                                                
                                                                <input type="button" class="btn btn-primary color" name="botonRadioMix"
                                                                data-despregunta="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['pregunta'] ?>" id="botonRadioMix" value="Enviar Respuesta" 
                                                                onclick="verradioRetroMix(this,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?> ,  <?= $arrPreguntas['idCuatrimestre'] ?> , '<?= $arrPreguntas['nombre'] ?>', <?= $datosUsuario['idpersona'] ?> )">
                                                            </div>
                                                        <?php } ?>

                                                    <?php } elseif ($arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['idTipopregunta'] == 5) { ?>
                                                        <div class="opciones mb-3 mt-3">
                                                            <div class="custom-control custom-control-inline custom-checkbox" id="opciones">

                                                                <input type="checkbox" class="custom-control-input opcionEnv" onclick="verchkRetro1(this,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>)" name="chkElegido<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>[]" id="chkOpcion<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" data-predes="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['pregunta'] ?>" data-nomopcion="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" data-idpregop="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" data-idopenv="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>" data-desopcion="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" value="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?>" data-iretroenvi="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>">
                                                                <label class="custom-control-label" for="chkOpcion<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>"><?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['nombreOpcion'] ?></label>

                                                            </div>
                                                        </div>
                                                        <div class="retroalimentacion alert alert-primary" id="retroa<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] . $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>" role="alert">
                                                            <div class="" id="txtRetro">
                                                                <?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>.
                                                            </div>
                                                            <input type="hidden" id="retroEnv[]" name="retroEnv[]" value="<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['descRetroalimentacion'] ?>">
                                                        </div>

                                                        <?php if ($o == count($arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones']) - 1) { ?>
                                                            <label for=""><b><?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['descripcionMixta'] ?></b></label>

                                                            <div class="form-group mb-3 mt-3">


                                                                <input type="text" class="form-control" name="txtRespuestaMCHK[]" id="txtRespuestaMCHK<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>">

                                                                <input type="button" class="btn btn-primary color" name="botonRadioMix" 
                                                                 id="botonRadioMixx" value="Enviar Respuesta" onclick="verchkRetro12(this,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idOpcion'] ?>,<?= $arrPreguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['idPregunta'] ?>,  <?= $arrPreguntas['idCuatrimestre'] ?> , '<?= $arrPreguntas['nombre'] ?>', <?= $datosUsuario['idpersona'] ?> )">


                                                            </div>
                                                        <?php } ?>

                                                    <?php } ?>
                                                <?php }
                                            } else { ?>
                                                <div class="form-group mb-3 mt-3">
                                                    <input type="text" class="form-control" name="txtRespuesta[]" id="txtRespuesta[]">
                                                </div>

                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                <?php } ?>

                                <?php
                                if ($t == 0) {
                                ?>
                                    <input type="button" title="Siguiente paso" name="next" class="next action-button" value="Siguiente">
                                <?php
                                } elseif ($t == count($arrPreguntas['temas']) - 1) {
                                ?>
                                    <input type="button" name="previous" class="previous action-button-previous" value="Anterior">
                                    <input type="submit" name="submit" class="submit action-button" value="Finalizar">
                                <?php
                                } else {
                                ?>
                                    <input type="button" name="previous" class="previous action-button-previous" value="Anterior">
                                    <input type="button" title="Siguiente paso" name="next" class="next action-button" value="Siguiente">
                                <?php
                                }
                                ?>
                            </fieldset>
                        <?php
                        }
                        ?>


                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- Final Formulario -->
</main>
<?php
footerHaed($data);
?>
<style>
    .noveo {
        display: none;
    }
    
</style>