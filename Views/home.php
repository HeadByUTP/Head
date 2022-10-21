<?php 
    headerHaed($data); 
?>
<main>
                      <!-- ======= Hero Section ======= -->
  <section id="hero">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
                <div>
                    <h1 class="title1"><?= $data['page_title']; ?></h1>
                    <a href="<?= base_url(); ?>/autoevaluacion" class="btn-get-started scrollto">Contestar evaluación</a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
                <img src="<?= media(); ?>/haedclient/images/hero.png" alt="" width="6000" height="330">
            </div>
        </div>
    </div></section><!-- End Hero -->
            <!-- ======= About Section ======= -->
            <section id="about" class="about">
                <div class="container">

                    <div class="row">

                        <div class="col-lg-6" data-aos="zoom-in">
                            <img src="<?= media(); ?>/haedclient/images/img2_portfolio.jpg" class="img-fluid" alt="">
                        </div>
                        
                        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                            <div class="content pt-4 pt-lg-0">
                                <h3 class="title2">Herramienta enfocada al mejoramiento de la calidad educativa universitaria</h3>
                                <p>
                                    HAED es un herramienta alternativa de autoevaluación docente propuesta por los cuerpos académicos:
                                </p>
                                <ul>
                                    <li>
                                        <i class="icofont-check-circled"></i>
                                        TIC Educativa.</li>
                                    <li>
                                        <i class="icofont-check-circled"></i>
                                        Calidad y Competitividad.</li>
                                    <li>
                                </ul>
                                <p>
                                    Está basada en competencias y considera aspectos integrales que incluyen al docente como persona, su desarrollo profesional y su relación con la comunidad universitaria, especialmente con el estudiante.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!-- End About Section -->

            <!-- ======= CA Section ======= -->
            <section id="features" class="features mt-5">
                <div class="container">

                    <div class="row">
                        <div class="col-lg-6 order-2 order-lg-1">
                            <ul class="nav nav-tabs flex-column">
                                <li class="nav-item" data-aos="fade-up">
                                    <div class="section-title" data-aos="fade-up">
                                        <h2 class="title1">Cuerpos académicos</h2>
                                        <p class="info-help">*Para más información da clic sobre el nombre del cuerpo académico.</p>
                                    </div>
                                </li>
                                <li class="nav-item mt-2" data-aos="fade-up" data-aos-delay="80">
                                    <a class="nav-link" data-toggle="tab" href="#tab-2">
                                        <h4>TIC Educativa</h4>
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="title2">Clave: </h5><p>nUTPUE-CA-8</p>
                                            </div>
                                            <div class="col">
                                                <h5 class="title2">Grado: </h5><p>En formación</p>
                                            </div>
                                        </div>                                                 
                                    </a>
                                </li>
                                <li class="nav-item mt-2" data-aos="fade-up" data-aos-delay="80">
                                    <a class="nav-link" data-toggle="tab" href="#tab-3">
                                        <h4>Calidad y Competitividad</h4>
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="title2">Clave: </h5><p>UTPUE-CA-6</p>
                                            </div>
                                            <div class="col">
                                                <h5 class="title2">Grado: </h5><p>Consolidado</p>
                                            </div>
                                        </div>                                       
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tab-1">
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <figure>
                                        <img src="<?= media(); ?>/haedclient/images/cuerpos.png" alt="" class="img-fluid">
                                    </figure>
                                </div>
                                <div class="tab-pane" id="tab-2">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="title2">Objetivo: </h5>
                                            <p>Desarrollar propuestas de mejora, fundamentadas y relacionadas
                                            con el estudio de diferentes ambientes de aprendizaje; de igual
                                            manera, propiciar la colaboración y creación de materiales
                                            educativos que apoyen distintos escenarios de estudio para ser
                                            aprovechados por las futuras generaciones elevando así el
                                            autoaprendizaje y la conciencia social.</p>
                                        </div>                                 
                                    </div><br>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="title2">Líneas de investigación: </h5>
                                            <ul>
                                                <li>Estudio de ambientes de aprendizaje y propuestas de mejora</li>
                                                <li>Material Didáctico</li>
                                            </ul>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="title2">Integrantes: </h5>
                                            <ul>
                                                <li>Mtra. Verónica Lizardi Rojo</li>
                                                <li>Mtra. Norma Angélica Roldán Oropeza</li>
                                                <li>Lic. Rosalba Bolaños Ortega</li>
                                            </ul>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="title2">Contacto: </h5>
                                            <p>tic-educativa@utpuebla.edu.mx</p>
                                        </div>
                                    </div>             
                                </div>
                                <div class="tab-pane" id="tab-3">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="title2">Objetivo: </h5>
                                            <p>Investigar y desarrollar propuestas de mejora enfocadas a la mejora
                                                de la calidad y optimización de empresas, instituciones y
                                                universidades, con el fin de mejorar sus procesos, productos o
                                                servicios para que generen una ventaja competitiva.</p>
                                        </div>                                 
                                    </div><br>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="title2">Líneas de investigación: </h5>
                                            <ul>
                                                <li>Normalización de los Sistemas de Gestión de la Calidad ISO 9000</li>
                                                <li>Automatización y robótica para optimizar los sistemas de control</li>
                                            </ul>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="title2">Integrantes: </h5>
                                            <ul>
                                                <li>Mtro. Héctor De Sampedro Poblano</li>
                                                <li>Dra. Luz del Carmen Morán Bravo</li>
                                                <li>Dr. Gustavo Herrera Sánchez</li>
                                                <li>Dr. Alejandro Silva Juárez</li>
                                            </ul>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="title2">Contacto: </h5>
                                            <p>hector.desampedro@utpuebla.edu.mx</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-4">
                                    <figure>
                                        <img src="" alt="" class="img-fluid">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!-- End CA Section -->

            <!-- ======= Services Section ======= -->
            <section id="services" class="services section-bg">
                <div class="container">

                    <div class="section-title" data-aos="fade-up">
                        <h2 class="title1">Temas</h2>
                        <p>Los temas a tocar dentro del cuestionario de autoevalución son los siguientes:</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in">
                            <div class="icon-box icon-box-cyan">
                                <div class="icon">
                                <i class="icofont-unique-idea"></i>
                                </div><br>
                                <h4 class="title">
                                    <a href="">Práctica Reflexiva</a>
                                </h4>
                                <p class="description">Dirigido a que el participante reconozca y analice los hechso de manera libre mediante una observación científica no estructurada.</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="100">
                            <div class="icon-box icon-box-cyan">
                                <div class="icon">
                                <i class="icofont-imac"></i>
                                </div><br>
                                <h4 class="title">
                                    <a href="">Aspectos Tecnológicos</a>
                                </h4>
                                <p class="description">Son habilidades que Greg Thompson menciona como elementos indispensables que el docente debe incorporar y enseñar a sus discentes.</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
                            <div class="icon-box icon-box-cyan">
                                <div class="icon">
                                <i class="icofont-teacher"></i>
                                </div><br>
                                <h4 class="title">
                                    <a href="">Profesionalización Docente</a>
                                </h4>
                                <p class="description"></p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="300">
                            <div class="icon-box icon-box-cyan">
                                <div class="icon">
                                <i class="icofont-web"></i>
                                </div><br>
                                <h4 class="title">
                                    <a href="">Sobre la herramienta</a>
                                </h4>
                                <p class="description">Cuestionamientos en apoyo a la mejora de la herramienta.</p>
                            </div>
                        </div>

                    </div>

                </div>
            </section>
            <!-- End Services Section -->

            <!-- ======= Portfolio Section ======= -->
            <section id="portfolio" class="portfolio mt-5">
                <div class="container">

                    <div class="section-title" data-aos="fade-up">
                        <h2 class="title1">Portafolio de imágenes de HAED</h2>
                    </div>

                    <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

                        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                            <div class="portfolio-wrap">
                                <img src="<?= media(); ?>/haedclient/images/img1_portfolio.jpg" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>Imagen 1</h4>
                                </div>
                                <div class="portfolio-links">
                                    <a href="<?= media(); ?>/haedclient/images/img1_portfolio.jpg" data-gall="portfolioGallery" class="venobox" title="Imagen 1">
                                    <i class="icofont-ui-zoom-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                            <div class="portfolio-wrap">
                                <img src="<?= media(); ?>/haedclient/images/img3_portfolio.jpg" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>Imagen 2</h4>
                                </div>
                                <div class="portfolio-links">
                                    <a href="<?= media(); ?>/haedclient/images/img3_portfolio.jpg" data-gall="portfolioGallery" class="venobox" title="Imagen 2">
                                    <i class="icofont-ui-zoom-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                            <div class="portfolio-wrap">
                                <img src="<?= media(); ?>/haedclient/images/img4_portfolio.jpg" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>Imagen 3</h4>
                                </div>
                                <div class="portfolio-links">
                                    <a href="<?= media(); ?>/haedclient/images/img4_portfolio.jpg" data-gall="portfolioGallery" class="venobox" title="Imagen 3">
                                    <i class="icofont-ui-zoom-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>                       

                    </div>

                </div>
            </section>
            <!-- End Portfolio Section -->

        </main>
<?php 
footerHaed($data); 
?>