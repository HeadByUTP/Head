<?php
headerAdmin($data);
?>
<main class="app-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <form id="formPregunta" name="formPregunta" class="form-horizontal">
            <input type="hidden" name="idpregunta" id="idpregunta">

            <div class="form-group col-md-12">
              <label for="listCuestionario">Seleccione el cuestionario</label>
              <select class="form-control selectpicker" id="listCuestionario" name="listCuestionario" data-none-selected-text="Seleccione una opcion..." required>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label for="listSeccion">Seleccione la sección</label>
              <select class="form-control selectpicker" id="listSeccion" name="listSeccion" data-none-selected-text="Seleccione una opcion..." required>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label for="listTIpopreg">Seleccione el tipo de pregunta</label>
              <select class="form-control selectpicker" id="listTIpopreg" name="listTIpopreg" data-none-selected-text="Seleccione una opcion..." required>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">Ingresa la pregunta</font>
                </font>
              </label>
              <textarea class="form-control" id="pregunta" rows="4" placeholder="Ingrese la pregunta"></textarea>
            </div>
            <div class="form-group col-md-12">
              <label for="textoMixto">Ingresa el mensaje a mostrar</label>
              <input class="form-control" id="textoMixto" type="text" name="textoMixto" placeholder="Ingresa el texto de ayuda">
            </div>
            <div class="form-group col-md-12 mt-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="tile">
                    <h4 class="tile-title">Seleccione las opciones que se le asignarán a la pregunta</h4>
                    <table class="table table-striped" id="opcionExiste">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Opción</th>
                          <th>Retroalimentacion</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="tile">
                    <h4 class="tile-title">Ingrese una nueva opción</h4>
                    <table class="table table-striped" id="nuevaopcion">
                      <thead>
                        <tr>
                          <th>Opción</th>
                          <th>Retroalimentacion</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-group">
                              <input type="text" class="form-control opcionNueva" onClick="arequiredretro()" name="optionNueva[]" id="optionNueva" placeholder="Ingrese la nueva opcion">
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <textarea class="form-control retroalimentacionNueva" id="retroNueva" name="retroNueva[]" rows="4" placeholder="Ingrese la retroalimentacion"></textarea>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="form-group">
                              <input type="text" class="form-control opcionNueva" onClick="arequiredretro()" name="optionNueva[]" id="optionNueva" placeholder="Ingrese la nueva opcion">
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <textarea class="form-control retroalimentacionNueva" id="retroNueva" name="retroNueva[]" rows="4" placeholder="Ingrese la retroalimentacion"></textarea>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="form-group">
                              <input type="text" class="form-control opcionNueva" onClick="arequiredretro()" name="optionNueva[]" id="optionNueva" placeholder="Ingrese la nueva opcion">
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <textarea class="form-control retroalimentacionNueva" id="retroNueva" name="retroNueva[]" rows="4" placeholder="Ingrese la retroalimentacion"></textarea>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="form-group">
                              <input type="text" class="form-control opcionNueva" onClick="arequiredretro()" name="optionNueva[]" id="optionNueva" placeholder="Ingrese la nueva opcion">
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <textarea class="form-control retroalimentacionNueva" id="retroNueva" name="retroNueva[]" rows="4" placeholder="Ingrese la retroalimentacion"></textarea>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="form-group">
                              <input type="text" class="form-control opcionNueva" onClick="arequiredretro()" name="optionNueva[]" id="optionNueva" placeholder="Ingrese la nueva opcion">
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <textarea class="form-control retroalimentacionNueva" id="retroNueva" name="retroNueva[]" rows="4" placeholder="Ingrese la retroalimentacion"></textarea>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="form-group">
                              <input type="text" class="form-control opcionNueva" onClick="arequiredretro()" name="optionNueva[]" id="optionNueva" placeholder="Ingrese la nueva opcion">
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <textarea class="form-control retroalimentacionNueva" id="retroNueva" name="retroNueva[]" rows="4" placeholder="Ingrese la retroalimentacion"></textarea>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="form-group">
                              <input type="text" class="form-control opcionNueva" onClick="arequiredretro()" name="optionNueva[]" id="optionNueva" placeholder="Ingrese la nueva opcion">
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <textarea class="form-control retroalimentacionNueva" id="retroNueva" name="retroNueva[]" rows="4" placeholder="Ingrese la retroalimentacion"></textarea>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>

            <div class="form-group col-md-8">
              <button id="guardarPregunta" type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php footerAdmin($data); ?>