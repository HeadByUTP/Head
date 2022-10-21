<!-- Modal -->
<div class="modal fade" id="modalFormTemas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Tema</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formTemas" name="formTemas" class="form-horizontal">
              <input type="hidden" id="idTemas" name="idTemas" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <hr>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="txtNombretema">Nombre<span class="required">*</span></label>
                  <input type="text" class="form-control valid validText" id="txtNombretema" name="txtNombretema" required="">
                </div>
                </div>
              <hr>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="txtDesctema">Descripción<span class="required">*</span></label>
                  <input type="text" class="form-control valid validText" id="txtDesctema" name="txtDesctema" required="">
                </div>
                </div>
             <div class="form-row">
                
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



<!-- VER MODAL-->
<!-- Modal ver Tema -->
<div class="modal fade" id="modalViewTemas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del tema</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Nombre Tema:</td>
              <td id="celNombre">Tema</td>
            </tr>
            <tr>
              <td>Descripción:</td>
              <td id="celDescripcion">Descripcion</td>
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


