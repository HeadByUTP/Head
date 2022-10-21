<?php 
    headerAdmin($data);
    // getModal('modalVideos',$data);
?>
  <main class="app-content">    
      <div class="app-title">
        <div> 
            <h1><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
                <?php if($_SESSION['permisosMod']['w']){ ?>
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
              <?php } ?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/videos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableVideos">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Título vídeo</th>
                          <th>Descripción</th>
                          <th>Autor</th>
                          <th>Categoría</th>
                          <th>URL</th>       
                          <th>Status</th>
                          <th>Fecha</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Vídeo 1</td>
                          <td>Primer vídeo subido al sitio</td>
                          <td>Desconocido</td>
                          <td>Diseño</td>
                          <td>htpps://urlprueba/</td>
                          <td>Activo</td>
                          <td>2020-03-19</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </main>

<?php 
    footerAdmin($data); 
?>
