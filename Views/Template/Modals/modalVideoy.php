<!-- Modal AGREGAR Y ACTUALIZAR -->
<div class="modal fade" id="modalFormVideos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Vídeo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formVideos" name="formVideos" class="form-horizontal">
              <input type="hidden" id="idVideo" name="idVideo" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <hr>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="txtNombrevideo">Título vídeo<span class="required">*</span></label>
                  <input type="text" class="form-control valid" id="txtNombrevideo" name="txtNombrevideo" required="">
                </div>
                <div class="form-group col-md-12">
                  <label for="txtDesc">Descripción<span class="required">*</span></label>
                  <textarea type="text" class="form-control valid" name="txtDesc" id="txtDesc" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="txtAutor">Autor<span class="required">*</span></label>
                    <input type="text" class="form-control valid" id="txtAutor" name="txtAutor" required="">
                </div>
                <div class="form-group col-md-6">
                    <label for="txtCat">Categoría<span class="required">*</span></label>
                    <input type="text" class="form-control valid" id="txtCat" name="txtCat" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="txtUrl">URL del vídeo<span class="required">*</span></label>
                  <input type="text" class="form-control valid" id="txtUrl" name="txtUrl" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listStatus">Status</label>
                    <select class="form-control selectpicker" id="listStatus" name="listStatus" required >
                        <option value="">Seleccionar status</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="txtFecha">Fecha<span class="required">*</span></label>
                    <input type="date" class="form-control valid" id="txtFecha" name="txtFecha" required="">
                </div>
              </div>

              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal VER -->
<div class="modal fade" id="modalViewVideos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del vídeo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Título del vídeo:</td>
              <td id="celNombrevideo"></td>
            </tr>
            <tr>
              <td>Descripción:</td>
              <td id="celDescrip"></td>
            </tr>
            <tr>
              <td>Autor:</td>
              <td id="celAutor"></td>
            </tr>
            <tr>
              <td>Categoría:</td>
              <td id="celCat"></td>
            </tr>
            <tr>
              <td>URL:</td>
              <td id="celUrl"></td>
            </tr>
            <tr>
              <td>Status:</td>
              <td id="celStatus"></td>
            </tr>
            <tr>
              <td>Fecha:</td>
              <td id="celFecha"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>