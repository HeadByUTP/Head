revisar 

Cuando no hay secciones en un tema

<fieldset>

<!-- radiobutton -->

<div class="seccion">
    <h7>
        <b>¿Qué tan a menudo tomas cursos para seguirte capacitando?</b>
</div><br>

<div class="pregunta">
    <h7 id="subpregunta"><b>En tu área de experiencia.</b></h7>
    <input type="hidden" id="preguntaenv[]" name="preguntaenv[]" value=""><br>

    <div class="opciones mb-3 mt-3">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="radopcionElegido[]" name="radopcionElegido[]" class="custom-control-input">
            <label class="custom-control-label" for="radopcionElegido">Generalmente no tomo cursos</label>
            <input type="hidden" id="opcionEnv[]" name="opcionEnv[]" value="">
        </div>
    </div>
    <div class="retroalimentacion alert alert-primary" role="alert">
        <div class="txtRetro" id="txtRetro">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vitae, minus facilis! Quae esse rerum magnam cum accusamus laborum quod sint, voluptatem consectetur porro reiciendis repudiandae sunt alias similique minus perferendis.
        </div>
        <input type="hidden" id="retroEnv[]" name="retroEnv[]" value="">
    </div>

</div>

<!-- checkbox -->

<div class="seccion mt-4">
    <h7>
        <b>Si observas a tus alumnos.</b>
    </h7><br>
</div><br>
<div class="pregunta">
    <h7 id="subpregunta"><b>¿Qué suelen hacer durante tu clase?</b></h7>
    <input type="hidden" id="preguntaenv[]" name="preguntaenv[]" value=""><br>
    <br>
    <div class="opciones mb-3 mt-3">
        <div class="custom-control custom-control-inline custom-checkbox">
            <input type="checkbox" class="custom-control-input"  name="chkOpcion[]" id="chkOpcion[]">
            <label class="custom-control-label" for="chkOpcion">No me doy cuenta</label>
            <input type="hidden" id="opcionEnv[]" name="opcionEnv[]" value="">
        </div>
    </div>
    <div class="retroalimentacion alert alert-primary" role="alert">
        <div class="" id="txtRetro">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vitae, minus facilis! Quae esse rerum magnam cum accusamus laborum quod sint, voluptatem consectetur porro reiciendis repudiandae sunt alias similique minus perferendis.
        </div>
        <input type="hidden" id="retroEnv[]" name="retroEnv[]" value="">
    </div>
</div>

<!-- libre -->

<div class="seccion mt-4">
    <h7>
        <b>Pregunta libre.</b>
    </h7><br>
</div><br>

<div class="pregunta">
    <h7 id="subpregunta"><b>¿Qué suelen hacer durante tu clase?</b></h7>
    <input type="hidden" id="preguntaenv[]" name="preguntaenv[]" value=""><br>
    <br>
    
    <div class="form-group">
        <input type="text" class="form-control" name="txtRespuesta[]" id="txtRespuesta[]">
    </div>
</div>

<input type="button" title="Siguiente paso" name="next" class="next action-button" value="Siguiente">

</fieldset>

<input type="button" name="previous" class="previous action-button-previous" value="Anterior">
<input type="submit" name="submit" class="submit action-button" value="Finalizar">


<!-- Paso 1 Crear Temas -->

<fieldset>



<input type="button" title="Siguiente paso" name="next" class="next action-button" value="Siguiente">

</fieldset>




