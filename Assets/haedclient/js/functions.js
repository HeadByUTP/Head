let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function() {

    if (document.querySelector("#formLogin")) {
        let formLogin = document.querySelector("#formLogin");
        formLogin.onsubmit = function(e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#txtPassword').value;

            if (strEmail == "" || strPassword == "") {
                swal("Por favor", "Escribe usuario y contraseñaa.", "error");
                return false;
            } else {
                divLoading.style.display = "flex";
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url + '/Login/loginUser';
                var formData = new FormData(formLogin);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function() {
                    if (request.readyState != 4) return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            window.location.reload(false);
                        } else {
                            swal("Atención", objData.msg, "error");
                            document.querySelector('#txtPassword').value = "";
                        }
                    } else {
                        swal("Atención", "Error en el proceso", "error");
                    }
                    divLoading.style.display = "none";
                    return false;
                }
            }
        }
    }


    if (document.querySelector("#formRegister")) {
        let formRegister = document.querySelector("#formRegister");
        formRegister.onsubmit = function(e) {
            e.preventDefault();
            let strMatricula = document.querySelector('#txtMatricula').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellidos').value;
            let strTelefono = document.querySelector('#txtTelefono').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let fechanacimiento = document.querySelector('#txtEdad').value;

            if (strApellido == '' || strNombre == '' || strEmail == '' || strTelefono == '' || fechanacimiento == '' || strMatricula == '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Registro/setCliente';
            let formData = new FormData(formRegister);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Usuario", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

    if (document.querySelector("#formContacto")) {
        let frmContacto = document.querySelector("#formContacto");
        frmContacto.addEventListener('submit', function(e) {
            e.preventDefault();

            let nombre = document.querySelector('#nombreContacto').value;
            let correo = document.querySelector('#emailContacto').value;
            let asunto = document.querySelector('#asuntoContacto').value;
            let telefono = document.querySelector('#telefonoContacto').value;
            let mensaje = document.querySelector('#mensajeContacto').value;

            if (nombre == "" || correo == "" || asunto == "" || telefono == "" || mensaje == "") {
                swal("", "Los campos son obligatorios", "error");
                return false;
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Contacto/envio';
            let formData = new FormData(frmContacto);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Usuario", objData.msg, "success");
                        document.querySelector("#formContacto").reset();
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        });
    }

    if (document.querySelector("#form")) {
        let frmAutoevaluacion = document.querySelector("#form");
        frmAutoevaluacion.addEventListener('submit', function(e) {
            e.preventDefault();

            finalPreguntas = []
            finalOpciones = []
            finalEnvio = []

            let elementos = document.querySelectorAll("#preguntaenv");
            let opciones = document.querySelectorAll(".opcionEnv");

            for (let p = 0; p < elementos.length; p++) {

                preguntas = [{
                    idcuatrimestre: elementos[p].dataset.idcuatri,
                    nombreCuatrimestre: elementos[p].dataset.nomcuatri,
                    idpregunta: elementos[p].dataset.idpreg,
                    pregunta: elementos[p].value
                }];

                finalPreguntas.push(preguntas)

            }

            //console.log(finalPreguntas)

            for (let o = 0; o < opciones.length; o++) {

                if (opciones[o].checked) {
                    opcionese = [{
                        idpregunta: opciones[o].dataset.idpregop,
                        idopcion: opciones[o].dataset.idopenv,
                        opcion: opciones[o].value,
                        retroalimentacion: opciones[o].dataset.iretroenvi,
                        respuesta: ""
                    }]
                    finalOpciones.push(opcionese)
                }

            }

            //console.log(finalOpciones)
            opcionespreg = []
            contaropciones = 0;

            for (let ep = 0; ep < finalPreguntas.length; ep++) {

                for (let fo = 0; fo < finalOpciones.length; fo++) {
                    if ((finalOpciones[fo][0].idpregunta) == finalPreguntas[ep][0].idpregunta) {

                        // console.log(finalOpciones[fo][0])
                        // contaropciones++
                        opcionespreg.push(finalOpciones[fo][0])

                        finaljs = [{
                            idcuatrimestre: finalPreguntas[ep][0].idcuatrimestre,
                            nombreCuatrimestre: finalPreguntas[ep][0].nombreCuatrimestre,
                            idPregunta: finalPreguntas[ep][0].idpregunta,
                            pregunta: finalPreguntas[ep][0].pregunta,
                            seleccion: opcionespreg
                        }]
                        finalEnvio.push(finaljs)

                    }

                }

            }

            let set = new Set(finalEnvio.map(JSON.stringify))
            let arrSinDuplicaciones = Array.from(set).map(JSON.parse);

            // divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Autoevaluacion/setRegistro';
            let formData = new FormData();
            formData.append("datos", JSON.stringify(arrSinDuplicaciones));
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Autoevalueacion", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }


        })
    }




}, false);

function verchkRetro(element, idRetro, pregunta, idCuatrimestre, cuatrimestre, idPersona ) {
    //son para mostrar las retroalimentaciones.
    if (element.checked == true) {
        document.querySelector("#retroa" + idRetro + pregunta).style.display = "block";
        var desPregunta = element.dataset.predes;
        /*        console.log(desPregunta); */
        var idOpcion = element.dataset.idopenv;
        var idPregunta = element.dataset.idpregop;
        var nomOpcion = element.dataset.nomopcion;
        var retroalimentacion = element.dataset.iretroenvi;


        console.log(desPregunta);
        console.log(idOpcion);
        console.log(nomOpcion);
        console.log(retroalimentacion);
        console.log(idPregunta);

        let datosResp = {
            idCuatrimestre: idCuatrimestre,
            cuatrimestre: cuatrimestre,
            idPersona: idPersona
        };
        //dasactivar el checkbox haciendo que solo una vez se pueda presionar.

        $.ajax({
            type: "POST",
            url: base_url + '/Autoevaluacion/setDetallerespuesta',
            data: {
                tipoPregunta: "",
                datosRespuesta: datosResp,
                pregunta: desPregunta,
                idOpcion: idOpcion,
                opcion: nomOpcion,
                retroalimentacion: retroalimentacion,
                idPregunta: idPregunta
            },
            dataType: "JSON",
            success: function(response) {


                if (response.status == true) {
                    document.getElementById('chkOpcion' + idOpcion + idPregunta).disabled = true;
                }

            }
        });


    } else {
        //indicamos que ya no se puede deseleccionar.
        document.querySelector("#retroa" + idRetro + pregunta).style.display = "block";
    }
}

function verchkRetro1(element, idRetro, pregunta) {

    if (element.checked == true) {
        document.querySelector("#retroa" + idRetro + pregunta).style.display = "block";
        var desPregunta = element.dataset.predes;
        /*        console.log(desPregunta); */
        var idOpcion = element.dataset.idopenv;
        var idPregunta = element.dataset.idpregop;
        var nomOpcion = element.dataset.nomopcion;
        var retroalimentacion = element.dataset.iretroenvi;

        console.log(desPregunta);
        console.log(idOpcion);
        console.log(nomOpcion);
        console.log(retroalimentacion);
        console.log(idPregunta);

        document.getElementById('chkOpcion' + idOpcion + idPregunta).disabled = true;

    } else {
      
        document.querySelector("#retroa" + idRetro + pregunta).style.display = "block";
    }
}



function verchkRetro12(element, idRetro, pregunta, idCuatrimestre, cuatrimestre, idPersona) {
    var datos = [];
    var checarseleccionado = [];
    datos = document.querySelectorAll("input[id*='chkOpcion']");

    // console.log(datos);
    var inputs = new Array();

    for (let i = 0; i < datos.length; i++) {


        if (datos[i].dataset.idpregop.includes(pregunta)) {

            inputs[i] = datos[i];

        }

    }

    var filtered = inputs.filter(function(el) {
        return el != null;
    });

    // console.log(filtered);

    for (let d = 0; d < filtered.length; d++) {

        if (filtered[d].checked) {

            checarseleccionado[d] = {
                pregunta: filtered[d].dataset.predes,
                idPreguntaop: filtered[d].dataset.idopenv,
                desOpcion: filtered[d].dataset.desopcion,
                retroAlimem: filtered[d].dataset.iretroenvi,
                idPregunta: filtered[d].dataset.idpregop
            };
        }


    }
    // console.log(checarseleccionado);
    var longuitud = checarseleccionado.length;
    checarseleccionado[longuitud] = {
        respuestaLibre: document.getElementById("txtRespuestaMCHK" + pregunta).value
    }

    //para comenzar de 0 en los div
    var filteredResp = checarseleccionado.filter(function(el) {
        return el != null;
    });

    console.log(filteredResp);

    let datosResp = {
        idCuatrimestre: idCuatrimestre,
        cuatrimestre: cuatrimestre,
        idPersona: idPersona
    };

    $.ajax({
        type: "POST",
        url: base_url + '/Autoevaluacion/setDetallerespuesta',
        data: { tipoPregunta: "mixtaCheckbox" ,datosRespuesta: datosResp,datos: filteredResp },
        dataType: "JSON",
        success: function(response) {

            if (response.status == true) {



            }



        }

    })






}




function verradioRetro(element, idRetro, pregunta, idCuatrimestre, cuatrimestre, idPersona) {
    if (element.checked == true) {

        //todas las retroalimentaciones apeceran desabilitadas a la que no pertenezca a la opcion indicada.
        var x = document.getElementsByClassName("radiodes" + pregunta);

        for (let i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }

        //que aparezca la retroalimentacion de la opcion indicada
        document.querySelector("#retroa" + idRetro + pregunta).style.display = "block";

        var preguntaenvio = element.dataset.pregunta;
        var idOpcion = element.dataset.idopenv;
        var desOpcin = element.dataset.nomopcion;
        var descripRetro = element.dataset.iretroenvi;
        var idPregunta = element.dataset.idpregop;
        /*    console.log(idOpcion);
           console.log(preguntaenvio);
           console.log(desOpcin);
           console.log(descripRetro);
           console.log(idPregunta); */
           let datosResp = {
            idCuatrimestre: idCuatrimestre,
            cuatrimestre: cuatrimestre,
            idPersona: idPersona
        };
    
        var retro = element.dataset.iretroenvi;
        $.ajax({
            type: "POST",
            url: base_url + '/Autoevaluacion/setDetallerespuesta',
            data: {

                tipoPregunta : "",
                datosRespuesta: datosResp,
                pregunta: preguntaenvio,
                idOpcion: idOpcion,
                opcion: desOpcin,
                retroalimentacion: descripRetro,
                idPregunta: idPregunta
            },
            dataType: "JSON",
            success: function(response) {


                if (response.status == true) {



                    var datos = [];
                    datos = document.querySelectorAll("div[id*='divEliminar']");



                    // console.log(datos);
                    var inputs = new Array();

                    for (let i = 0; i < datos.length; i++) {

                        if (datos[i].dataset.idpreguntadiv.includes(pregunta)) {

                            inputs[i] = datos[i];

                        }

                    }

                    //para comenzar de 0 en los div
                    var filtered = inputs.filter(function(el) {
                        return el != null;
                    });



                    for (let d = 0; d < filtered.length; d++) {

                        if (filtered[d].id != ("divEliminar" + idOpcion + pregunta)) {

                            filtered[d].classList.add('noveo');
                            /*  console.log(filtered[d]) */
                        }

                    }
                    document.getElementById('radopcionElegido' + idOpcion + idPregunta).disabled = true;


                    // idOpcion = 41
                    // idPregunta = 35
                    var div = document.querySelector("#retroa" + idOpcion + idPregunta)
                    console.log(div)

                    if (div == document.querySelector("#retroa4135")) {
                        div.style.background = '#cce5ff';

                        // var div_dos = document.querySelector("#txtRetro")
                        // console.log(div_dos)
                        div.style.height = '110px';
                        div.style.overflowY = 'scroll';
                        div.width = '350px'

                    }


                }

            }
        });

    } else {
        //que desaparezca la retroalimentacion con el 
        document.querySelector("#retroa" + idRetro + pregunta).style.display = "none";
    }
}

function verradioRetroUTP(element, idRetro, pregunta) {
    console.log('radiobotton mixto')
    if (element.checked == true) {

        //todas las retroalimentaciones apeceran desabilitadas a la que no pertenezca a la opcion indicada.
        var x = document.getElementsByClassName("radiodes" + pregunta);

        for (let i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }

        //que aparezca la retroalimentacion de la opcion indicada
        document.querySelector("#retroa" + idRetro + pregunta).style.display = "block";

        var preguntaenvio = element.dataset.pregunta;
        var idOpcion = element.dataset.idopenv;
        var desOpcin = element.dataset.nomopcion;
        var descripRetro = element.dataset.iretroenvi;
        var idPregunta = element.dataset.idpregop;


        


                    var datos = [];
                    datos = document.querySelectorAll("div[id*='divEliminardos']");

                    // console.log(datos);
                    var inputs = new Array();

                    for (let i = 0; i < datos.length; i++) {

                        if (datos[i].dataset.idpreguntadiv.includes(pregunta)) {

                            inputs[i] = datos[i];

                        }

                    }

                    //para comenzar de 0 en los div
                    var filtered = inputs.filter(function(el) {
                        return el != null;
                    });



                    for (let d = 0; d < filtered.length; d++) {

                        if (filtered[d].id != ("divEliminardos" + idOpcion + pregunta)) {

                            filtered[d].classList.add('noveo');
                            /*  console.log(filtered[d]) */
                        }

                    }
                    document.getElementById('radopcionElegido' + idOpcion + idPregunta).disabled = true;


                    // idOpcion = 41
                    // idPregunta = 35
                    var div = document.querySelector("#retroa" + idOpcion + idPregunta)
                    console.log(div)

                    if (div == document.querySelector("#retroa4135")) {
                        div.style.background = '#cce5ff';

                        // var div_dos = document.querySelector("#txtRetro")
                        // console.log(div_dos)
                        div.style.height = '110px';
                        div.style.overflowY = 'scroll';
                        div.width = '350px'

                    }

    } else {
        //que desaparezca la retroalimentacion con el 
        document.querySelector("#retroa" + idRetro + pregunta).style.display = "none";
    }
}

function verradioRetroMix(element, idRetro, pregunta, idCuatrimestre, cuatrimestre, idPersona){
    var datos = [];
    var checarseleccionado = [];
    datos = document.querySelectorAll("input[id*='radopcionElegido']");

    // console.log(datos);
    var inputs = new Array();

    for (let i = 0; i < datos.length; i++) {


        if (datos[i].dataset.idpregop.includes(pregunta)) {

            inputs[i] = datos[i];

        }

    }

    var filtered = inputs.filter(function(el) {
        return el != null;
    });

    // console.log(filtered);

    for (let d = 0; d < filtered.length; d++) {

        if (filtered[d].checked) {

            checarseleccionado[d] = {
                pregunta: filtered[d].dataset.predes,
                idPreguntaop: filtered[d].dataset.idopenv,
                desOpcion: filtered[d].dataset.desopcion,
                retroAlimem: filtered[d].dataset.iretroenvi,
                idPregunta: filtered[d].dataset.idpregop
            };
        }


    }
    // console.log(checarseleccionado);
    var longuitud = checarseleccionado.length;
    checarseleccionado[longuitud] = {
        respuestaLibre: document.getElementById("txtRespuestaRadioMix" + pregunta).value
    }

    //para comenzar de 0 en los div
    var filteredResp = checarseleccionado.filter(function(el) {
        return el != null;
    });

    console.log(filteredResp);

    let datosResp = {
        idCuatrimestre: idCuatrimestre,
        cuatrimestre: cuatrimestre,
        idPersona: idPersona
    };

    $.ajax({
        type: "POST",
        url: base_url + '/Autoevaluacion/setDetallerespuesta',
        data: { 
        tipoPregunta: "mixtaRadio",
        datosRespuesta: datosResp,
        datos: filteredResp },
        dataType: "JSON",
        success: function(response) {

            if (response.status == true) {



            }



        }

    })



}