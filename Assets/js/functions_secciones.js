let tableSecciones;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function() {
    tableSecciones = $('#tableSecciones').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Secciones/getSecciones",
            "dataSrc": ""
        },
        "columns": [
            { "data": "idSeccion" },
            { "data": "nombreSeccion" },
            { "data": "nombreTema" },
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

    if (document.querySelector("#formSecciones")) {
        let formSecciones = document.querySelector("#formSecciones");

        formSecciones.onsubmit = function(e) {
            e.preventDefault();
            let strSeccion = document.querySelector('#txtNombreseccion').value;
            let strTema = document.querySelector('#listTema').value;

            if (strSeccion == '' || strTema == '') {
                swal("Atención", "Todos los campos son obligatorios.", "warning");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if (elementsValid[i].classList.contains('is-invalid')) {
                    swal("Atención", "Por favor verifique los campos en rojo.", "warning");
                    return false;
                }
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Secciones/setSeccion';
            let formData = new FormData(formSecciones);
            request.open("POST", ajaxUrl, true);
            request.send(formData);

            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        if (rowTable == "") {
                            tableSecciones.api().ajax.reload();
                        } else {
                            rowTable.cells[1].textContent = strSeccion;
                            rowTable.cells[2].textContent = strTema;
                            rowTable = "";
                        }
                        $('#modalFormSecciones').modal("hide");
                        formSecciones.reset();
                        swal("Hecho", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

}, false);

//SELECT DINÁMICO : Carga los datos en el select traídos desde la base de datos

//Ejecuta la función ftnTemas cuando carga la ventana actual
//para tener preparados los datos cuando el usuario los requiera
window.addEventListener('load', function() {
    fntTemas();
}, false);

//Función para recuperar y mostrar los registros de una entidad de la BD en un select
function fntTemas() {
    if (document.querySelector('#listTema')) {
        let ajaxUrl = base_url + '/Temas/getSelectTemas';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        console.log(request);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                console.log(request.responseText);
                document.querySelector('#listTema').innerHTML = request.responseText;
                $('#listTema').selectpicker('render');
            }
        }
    }
}

function fntViewSec(idSeccion) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Secciones/getSeccion/' + idSeccion;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#celSecciones").innerHTML = objData.data.nombreSeccion;
                document.querySelector("#celTema").innerHTML = objData.data.nombreTema;
                $('#modalViewSecciones').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntEditSec(element, idSeccion) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Sección";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Secciones/getSeccion/' + idSeccion;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#idSeccion").value = objData.data.idSeccion;
                document.querySelector("#txtNombreseccion").value = objData.data.nombreSeccion;
                document.getElementById("listTema").value = objData.data.idTema;
                $('#listTema').selectpicker('render');
            }
        }
        $('#modalFormSecciones').modal('show');
    }
}

function fntDelSec(idSeccion) {
    var idsec = idSeccion;
    swal({
            title: "Eliminar",
            text: "¿Realmente quiere eliminar la sección?",
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
                let ajaxUrl = base_url + '/Secciones/delSeccion/';
                let strData = "idsec=" + idsec;
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

function openModal() {
    rowTable = "";
    document.querySelector('#idSeccion').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Sección";
    document.querySelector('#formSecciones').reset();
    $('#modalFormSecciones').modal('show');
}