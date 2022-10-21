<!-- Modal AGREGAR Y ACTUALIZAR -->
<div class="modal fade" id="modalFormCuatrimestres" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Cuatrimestre</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formCuatrimestres" name="formCuatrimestres" class="form-horizontal">
              <input type="hidden" id="idCuatrimestre" name="idCuatrimestre" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <hr>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtNombrecuatri">Cuatrimestre<span class="required">*</span></label>
                  <input type="text" class="form-control valid" id="txtNombrecuatri" name="txtNombrecuatri" required="" placeholder="Ej. Septiembre - Diciembre">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtCicloescolar">Ciclo escolar<span class="required">*</span></label>
                  <input type="text" class="form-control valid" id="txtCicloescolar" name="txtCicloescolar" required="" placeholder="Ej. 2021 - 2022">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listStatus">Status</label>
                    <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="listCuestionario">Cuestionario</label>
                    <select class="form-control" data-live-search="true" id="listCuestionario" name="listCuestionario" required>
                    </select>
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
<div class="modal fade" id="modalViewCuatrimestres" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del cuatrimestre</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Cuatrimestre:</td>
              <td id="celCuatrimestre"></td>
            </tr>
            <tr>
              <td>Ciclo escolar:</td>
              <td id="celCicloescolar"></td>
            </tr>
            <tr>
              <td>Status:</td>
              <td id="celStatus"></td>
            </tr>
            <tr>
              <td>Cuestinario:</td>
              <td id="celCuestionario"></td>
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