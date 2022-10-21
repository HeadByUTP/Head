<?php 
    headerAdmin($data); 
    // dep($data);
?>
  <main class="app-content">    
      <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/usuarios"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>

      <div class="tile mb-4">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h2 class="mb-3 line-head text-center" id="navs"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Resultados del cuestionario HAED <span id="titulocuestionario"></span></font></font></h2>
            </div>
          </div>
        </div>
        <div class="row" style="margin-bottom: 2rem;">
          <div class="col-lg-12">
            <div class="bs-component">
              <ul class="nav nav-tabs mb-4" id="temass">
              </ul>
              <div class="tab-content" id="temasgroup">

              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script>
        const cuatrimestre = "<?= $data['cuatrimestre']; ?>";
    </script>
<?php 
footerAdmin($data); 
?>

