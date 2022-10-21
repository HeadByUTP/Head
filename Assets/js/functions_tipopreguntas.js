let tablePreguntas;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tablePreguntas = $('#tablePreguntas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Tipopreguntas/getTipopreguntas",
            "dataSrc":""
        },
        "columns":[
            {"data":"idTipopregunta"},
            {"data":"descTipopregunta"},
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
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    if(document.querySelector("#formPreguntas")){
        let formPreguntas = document.querySelector("#formPreguntas");
        formPreguntas.onsubmit = function(e) {
            e.preventDefault();
            let strDescripcion = document.querySelector('#txtDesctipopreg').value;

            if(strDescripcion == '' )
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
            let ajaxUrl = base_url+'/Tipopreguntas/setTipopreguntas'; 
            let formData = new FormData(formPreguntas);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    { 
                        if(rowTable == ""){
                            tablePreguntas.api().ajax.reload();
                        }else{
                           rowTable.cells[1].textContent =  strDescripcion;
                           rowTable = "";
                        }
                        $('#modalFormPreguntas').modal("hide");
                        formPreguntas.reset();
                        swal("Hecho", objData.msg ,"success");
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
},false);

function fntViewInfo(idTipopregunta){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tipopreguntas/getTipopregunta/'+idTipopregunta;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange=function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#celTipo").innerHTML = objData.data.idTipopregunta;
                document.querySelector("#celDescripcion").innerHTML = objData.data.descTipopregunta;
                $('#modalViewPreguntas').modal('show');
            }else{
                swal("Error", objData.msg, "error");
            }
        }
    }
}
function fntEditInfo(element, idTipopregunta){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Tipo de pregunta";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tipopreguntas/getTipopregunta/'+idTipopregunta;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            console.log(request.responseText);
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idPreguntas").value = objData.data.idTipopregunta;
                document.querySelector("#txtDesctipopreg").value = objData.data.descTipopregunta;
            }
        }
        $('#modalFormPreguntas').modal('show');
    }
}

function fntDelInfo(idTipopregunta)
{
    var idtipo = idTipopregunta;
    swal({
        title: "Eliminar tipo de pregunta",
        text: "¿Realmente quiere eliminar el tipo de pregunta?",
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
            let ajaxUrl = base_url+'/Tipopreguntas/delTipopreguntas';
            let strData = "idPreguntas="+idtipo;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function()
            {
                if(request.readyState == 4 && request.status == 200)
                {
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Hecho", objData.msg , "success");
                        tablePreguntas.api().ajax.reload();
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
            }
        }
    });
}

function openModal(){
    rowTable = "";
    document.querySelector('#idPreguntas').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML="Guardar";
    document.querySelector('#titleModal').innerHTML="Nuevo Tipo Pregunta";
    document.querySelector('#formPreguntas').reset();
    $('#modalFormPreguntas').modal('show');
}