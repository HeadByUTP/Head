<?php 
    headerHaed($data); 
    $arrVideos = $data['videos'];
?>
<main>
              <!--? Inicio Hero -->
              <div class="slider-area2">
                <div class="slider-height2 hero-overly2 d-flex align-items-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="hero-cap hero-cap2 text-center">
                                    <h2><?=  $data['page_title'] ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final Hero -->
                <!-- ##### List Videos ##### -->
            <div class="vizew-archive-list-posts-area mt-120 mb-120">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-8">
                        <?php
                        if(count($arrVideos) > 0){ 
				       for ($p=0; $p < count($arrVideos); $p++) {   ?>
                        <div class='single-post-area style-2'>
                        <div class='row align-items-center'>
                            <div class='col-12 col-md-6'>
                                <div class='post-thumbnail'>
                                    <iframe src="<?= $arrVideos[$p]['url'] ?>" title="<?= $arrVideos[$p]['nombreVideo'] ?>" frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                                </div>
                            </div>
                            <div class='col-12 col-md-6'>
                                <!-- Post Content -->
                                <div class='post-content mt-0'>
                                    <a href='#' class='post-cata cata-sm cata-success'><?= $arrVideos[$p]['categoria'] ?></a>
                                    <a href="<?= $arrVideos[$p]['url_yt'] ?>" target='_blank' class='post-title mb-2'><?= $arrVideos[$p]['nombreVideo'] ?></a>
                                    <div class='post-meta d-flex align-items-center mb-2'>
                                        <a href='#' class='post-author'><?= $arrVideos[$p]['autor'] ?></a>
                                        <i class='fa fa-circle' aria-hidden='true'></i>
                                        <a href='#' class='post-date'><?= $arrVideos[$p]['fecha'] ?></a>
                                    </div>
                                    <p class='mb-2'><?= $arrVideos[$p]['descVideo'] ?>.</p>
                                </div>
                            </div>
                        </div>
                        </div>
                        <?php }
                        }else{
                        ?>
                        <p>No hay videos para mostrar <a href="<?= base_url() ?>/canal">Ver videos</a> </p>
                        <?php
                        }      
                        ?>
                            <!-- Pagination -->
                            <nav class="mt-50">
                                <ul class="pagination justify-content-center">
                                    <?php if(count($data['videos']) > 0){
                                        $prevPagina =  $data['pagina'] - 1;
                                        $nextPagina =  $data['pagina'] + 1;
                                    if($data['pagina'] > 1){
                                    ?>
                                        <li class="page-item"><a class="page-link" href="<?= base_url() ?>/Canal/page/<?= $prevPagina ?>"><i class="fa fa-angle-left"></i> Anterior </a></li>
                                    <?php } ?>
                                    <?php if($data['pagina'] != $data['total_paginas']){ ?>
                                        <li class="page-item"><a class="page-link" href="<?= base_url() ?>/Canal/page/<?= $nextPagina ?>">Siguiente <i class="fa fa-angle-right"></i></a></li>
                                    <?php } ?>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="sidebar-area">

                                <!-- ***** Single Widget ***** -->
                                <div class="single-widget newsletter-widget mb-50">
                                    <!-- Section Heading -->
                                    <div class="section-heading style-2 mb-30">
                                        <h4>Buscar video</h4>
                                        <div class="line"></div>
                                    </div>
                                    <!-- Newsletter Form -->
                                    <div class="newsletter-form">
                                        <form action="<?= base_url() ?>/canal/search" method="GET">
                                            <input type="hidden" name="p" value="1">
                                            <input type="text" name="s" class="form-control mb-15" id="s" placeholder="Buscar por nombre o categoria">
                                            <button type="submit" class="btn btn-main w-100"><i class="fa fa-search"></i> Buscar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
<?php 
footerHaed($data); 
?>