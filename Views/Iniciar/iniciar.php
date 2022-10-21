<?php 
    headerHaed($data); 
?>
    <main>
              <!--? Inicio Hero --> 
              <div class="slider-area2">
                <div class="slider-height2 hero-overly2 d-flex align-items-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="hero-cap hero-cap2 text-center">
                                    <h2>Iniciar sesión</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final Hero -->
        <!--================login_part Area =================-->
        <section class="login_part section_padding  mt-120 mb-120">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="login_part_text text-center">
                            <div class="login_part_text_iner">
                                <h2>¿No tienes una cuenta?</h2>
                                <p>Para poder contestar la Autoevaluación es necesario tener
                                    una cuenta de usuario, si aún no la tiene, de clic en el
                                    botón de <b>Crear cuenta</b>.
                                </p>
                                <a href="<?= base_url(); ?>/registro" class="btn_3">Crear cuenta</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="login_part_form">
                            <div class="login_part_form_iner">
                                <h1 class="title2">Bienvenido</h>
                                <h3>Inicie sesión ahora</h3>
                                <form class="row contact_form" name="formLogin" id="formLogin" action="">
                                    <div class="col-md-12 form-group p_star">
                                        <!-- <label for="txtEmail">Ingrese su correo electrónico</label> -->
                                        <input type="email" class="form-control" id="txtEmail" name="txtEmail" required placeholder="Ingrese su correo electrónico" title="Asegurese de que su dirección de correo esté bien escrita y el dominio coincida con 'utpuebla.edu.mx'">
                                    </div>
                                    <div class="col-md-12 form-group p_star">
                                        <!-- <label for="txtPassword">Ingrese su contraseña</label> -->
                                        <input type="password" class="form-control" id="txtPassword" name="txtPassword" required placeholder="Ingrese su contraseña">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div class="creat_account d-flex align-items-center">
                                            <input type="checkbox" id="f-option" name="selector">
                                            <label for="f-option">Ver contraseña</label>
                                        </div>
                                        <div id="alertLogin" class="text-center"></div>
                                        <button type="submit" value="submit" class="btn_3">
                                            Ingresar
                                        </button>
                                        <!-- <a class="lost_pass" href="#">¿Olvidó su contraseña?</a> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php 
footerHaed($data); 
?>