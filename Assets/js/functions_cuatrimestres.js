let tableCuatrimestres;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function()
{
    tableCuatrimestres = $('#tableCuatrimestres').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Cuatrimestres/getCuatrimestres",
            "dataSrc":""
        },
        "columns":[
            {"data":"idCuatrimestre"},
            {"data":"nombre"},
            {"data":"cicloEscolar"},
            {"data":"status"},
            {"data":"nombreCuestionario"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    if(document.querySelector("#formCuatrimestres"))
    {
        let formCuatrimestres = document.querySelector("#formCuatrimestres");

        formCuatrimestres.onsubmit = function(e)
        {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombrecuatri').value;
            let strCicloEscolar = document.querySelector('#txtCicloescolar').value;
            let intStatus = document.querySelector('#listStatus').value;
            let intCuestionario = document.querySelector('#listCuestionario').value;

            if(strNombre == '' || strCicloEscolar == '' || intStatus == '' || intCuestionario == '')
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
            let ajaxUrl = base_url+'/Cuatrimestres/setCuatrimestre'; 
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
                            tableCuatrimestres.api().ajax.reload();
                        }else{
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strCicloEscolar;
                            rowTable.cells[3].textContent = intStatus;
                            rowTable.cells[4].textContent = intCuestionario;
                            rowTable="";
                        }
                        $('#modalFormCuatrimestres').modal("hide");
                        formCuatrimestres.reset();
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

//SELECT DINÁMICO : Carga los datos en el select traídos desde la base de datos

//Ejecuta la función ftnTemas cuando carga la ventana actual
//para tener preparados los datos cuando el usuario los requiera
window.addEventListener('load', function(){
    fntCuestionarios();
}, false);

//Función para recuperar y mostrar los registros de una entidad de la BD en un select
function fntCuestionarios()
{
    if(document.querySelector('#listCuestionario')){
        let ajaxUrl = base_url+'/Cuestionario/getSelectCuestionarios';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        console.log(request);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                console.log(request.responseText);
                document.querySelector('#listCuestionario').innerHTML = request.responseText;
                $('#listCuestionario').selectpicker('render');
            }
        }
    }
}

function fntViewCuatrimestre(idCuatrimestre)
{
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cuatrimestres/getCuatrimestre/'+idCuatrimestre;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function()
    {
        if(request.readyState == 4 && request.status == 200)
        {
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#celCuatrimestre").innerHTML = objData.data.nombre;
                document.querySelector("#celCicloescolar").innerHTML = objData.data.cicloEscolar;
                if(objData.data.status == 1){
                    document.querySelector('#celStatus').innerHTML= "<span class=\"badge badge-success\">Activo</span>";
                }else if(objData.data.status == 0){
                    document.querySelector('#celStatus').innerHTML = "<span class=\"badge badge-danger\">Inactivo</span>";
                }
                document.querySelector("#celCuestionario").innerHTML = objData.data.nombreCuestionario; 
                $('#modalViewCuatrimestres').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}
 
function fntEditCuatrimestre(element,idCuatrimestre)
{
    rowTable = element.parentNode.parentNode.parentNode; 
    document.querySelector('#titleModal').innerHTML ="Actualizar Cuatrimestre";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cuatrimestres/getCuatrimestre/'+idCuatrimestre;
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function()
    {
        if(request.readyState == 4 && request.status == 200)
        {
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                console.log(objData.data);
                document.querySelector("#idCuatrimestre").value = objData.data.idCuatrimestre;
                document.querySelector("#txtNombrecuatri").value = objData.data.nombre;
                document.querySelector("#txtCicloescolar").value = objData.data.cicloEscolar;
                if(objData.data.status == "1"){
                    document.getElementById('listStatus').value = "1";
                }else if(objData.data.status == "0"){
                    document.getElementById('listStatus').value = "0";
                }
                document.getElementById("listCuestionario").value = objData.data.idCuestionario;
                $('#listStatus').selectpicker('render');
                $('#listCuestionario').selectpicker('render');
            }
        }
        $('#modalFormCuatrimestres').modal('show');
    }
}

function fntDelCuatrimestre(idCuatrimestre)
{
    var idcuatri = idCuatrimestre;
    swal({
        title: "Eliminar",
        text: "¿Realmente quiere eliminar el cuatrimestre? El Status pasará a 'Inactivo'.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, 
    function(isConfirm){
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Cuatrimestres/delCuatrimestre/';
            let strData = "idcuatri="+idcuatri;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function()
            {
                if(request.readyState == 4 && request.status == 200)
                {
                    console.log(request.responseText)
                    let objData = JSON.parse(request.responseText);
                    console.log(objData)
                    if(objData.status)
                    {
                        swal("Hecho", objData.msg, "success");
                        tableCuatrimestres.api().ajax.reload();
                    }else{
                        swal("Error", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function openModal()
{
    document.querySelector('#idCuatrimestre').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cuatrimestre";
    document.querySelector("#formCuatrimestres").reset();
    $('#modalFormCuatrimestres').modal('show');
}