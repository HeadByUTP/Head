let tablePreguntasinicio;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function() {
    tablePreguntasinicio = $('#tablePreguntasinicio').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Preguntasinicio/getPreguntasinicio",
            "dataSrc": ""
        },
        "columns": [
            { "data": "idPregunta" },
            { "data": "nombreCuestionario" },
            { "data": "nombreTema" },
            { "data": "nombreSeccion" },
            { "data": "pregunta" },
            { "data": "options" }
        ],
        'dom': 'lBfrtip',
        'buttons': [{
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr": "Copiar",
            "className": "btn btn-secondary"
        }, {
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr": "Exportar a Excel",
            "className": "btn btn-success"
        }, {
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr": "Exportar a PDF",
            "className": "btn btn-danger"
        }, {
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr": "Exportar a CSV",
            "className": "btn btn-info"
        }],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ]
    });

    if(document.querySelector("#formPreguntasinicio"))
    {
        let formPreguntasinicio = document.querySelector("#formPreguntasinicio");

        formPreguntasinicio.onsubmit = function(e)
        {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombreSeccion').value;
            let strPregunta = document.querySelector('#txtPregunta').value;
            // let intStatus = document.querySelector('#listStatus').value;
            

            if(strNombre == '' || strPregunta == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "warning");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos en rojo." , "warning");
                    return false;
                } 
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Preguntasinicio/setPreguntasInicio'; 
            let formData = new FormData(formCuatrimestres);
            request.open("POST",ajaxUrl,true);
            request.send(formData);

            request.onreadystatechange = function()
            {
                if(request.readyState == 4 && request.status == 200)
                {
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tablePreguntasinicio.api().ajax.reload();
                        }else{
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strPregunta;
                            // rowTable.cells[3].textContent = intStatus;
                            
                            rowTable="";
                        }
                        $('#modalFormPreguntasinicio').modal("hide");
                        formPreguntasinicio.reset();
                        swal("Hecho", objData.msg,"success");
                    }else{
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

    

}, false);


window.addEventListener('load', function(){
    fntCuestionarios();
}, false);




function fntViewPre(idPregunta) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Preguntasinicio/getPregunta/' + idPregunta;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            console.log(objData);
            if (objData.status) {
                document.querySelector("#celNombrecuestionario").innerHTML = objData.data.pregunta;
                document.querySelector("#celTema").innerHTML = objData.data.nombreSeccion;
                /*     document.querySelector("#celSeccion").innerHTML = objData.data.nombreSeccion;
                    document.querySelector("#celPregunta").innerHTML = objData.data.pregunta; */
                $('#modalViewPreguntasinicio').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntDelPre(idPregunta) {
    var idpre = idPregunta;
    swal({
            title: "Eliminar",
            text: "¿Realmente quiere eliminar la pregunta?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "No, cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Preguntasinicio/delPregunta/';
                let strData = "idpre=" + idpre;
                request.open("POST", ajaxUrl, true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function() {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            swal("Hecho", objData.msg, "success");
                            tableSecciones.api().ajax.reload();
                        } else {
                            swal("Error", objData.msg, "error");
                        }
                    }
                }
            }
        });
}


function fntEditPre(element, idPregunta){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Pregunta";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Preguntasinicio/getPregunta/'+idPregunta;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                console.log(objData.data);
                document.querySelector("#idPregunta").value = objData.data.idPregunta;
                document.querySelector("#txtNombreSeccion").value = objData.data.nombreSeccion;
                document.querySelector("#txtPregunta").value = objData.data.pregunta;
            }
        }
        $('#modalFormPreguntasinicio').modal('show');
    }
}




function openModal()
{
    document.querySelector('#idPregunta').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Pregunta";
    document.querySelector("#formPreguntasinicio").reset();
    $('#modalFormPreguntasinicio').modal('show');
}