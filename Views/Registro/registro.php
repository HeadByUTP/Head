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
                                    <h2>Crear Cuenta</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final Hero -->
            <!--================Register Area =================-->
        <section class="login_part section_padding  mt-120 mb-120">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="login_part_text text-center">
                            <div class="login_part_text_iner">
                                <h2>¿Ya tienes una cuenta?</h2>
                                <p>Si ya tienes una cuenta de usuario, puedes iniciar sesión para
                                contestar la Autoevaluación dando clic en el botón de <b>Iniciar Sesión</b>.
                                </p>
                                <a href="<?= base_url(); ?>/iniciar" class="btn_3">Iniciar Sesión</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="login_part_form">
                            <div class="login_part_form_iner">
                                <h1 class="title2">Bienvenido</h>
                                <h5>Realiza tu registro ahora proporcionando los siguientes datos:</h5>
                                <form class="row contact_form mt-4"  id="formRegister">
                                    <div class="col-md-12 form-group p_star">
                                        <input type="text" class="form-control" required id="txtMatricula" name="txtMatricula" value=""
                                            placeholder="Ingrese su matrícula">
                                    </div>
                                    <div class="col-md-12 form-group p_star">
                                        <input type="text" class="form-control" required id="txtNombre" name="txtNombre" value=""
                                            placeholder="Ingrese su nombre(s)">
                                    </div>
                                    <div class="col-md-12 form-group p_star">
                                        <input type="text" class="form-control" required id="txtApellidos" name="txtApellidos" value=""
                                            placeholder="Ingrese sus apellidos">
                                    </div>
                                    <div class="col-md-12 form-group p_star">
                                        <input type="text" class="form-control" required id="txtTelefono" name="txtTelefono" value=""
                                            placeholder="Ingrese su número de teléfono">
                                    </div>
                                    <div class="col-md-12 form-group p_star">
                                        <input type="text" class="form-control" required id="txtEmail" name="txtEmail" value=""
                                            placeholder="Ingrese su correo electrónico">
                                    </div>
                                    <div class="col-md-12 form-group p_star">
                                        <label for="txtEdad">Ingrese su fecha de nacimiento</label>
                                        <input type="date" class="form-control" required id="txtEdad" name="txtEdad" value=""
                                            placeholder="Ingrese su edad">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <button type="submit" value="submit" class="btn_3">
                                            Registrarme
                                        </button>
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