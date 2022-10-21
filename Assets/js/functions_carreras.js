let tableCarreras;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){

    tableCarreras = $('#tableCarreras').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Carreras/getCarreras",
            "dataSrc":""
        },
        "columns":[
            {"data":"idCarrera"},
            {"data":"nombreCarrera"},
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


    if(document.querySelector("#formCarreras"))
    {
        let formCarreras = document.querySelector("#formCarreras");
        formCarreras.onsubmit = function(e) 
        {
            e.preventDefault(); 
            let strNombrecarr = document.querySelector('#txtNombrecarr').value;

            if(strNombrecarr == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Carreras/setCarrera'; 
            let formData = new FormData(formCarreras);
            request.open("POST",ajaxUrl,true);
            request.send(formData); 
 
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    console.log(objData);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableCarreras.api().ajax.reload(); 
                        }else{
                           rowTable.cells[1].textContent =  strNombrecarr;
                           rowTable = "";
                        }
                        $('#modalFormCarreras').modal("hide");
                        formCarreras.reset();
                        swal("Carrera", objData.msg ,"success");
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


function fntViewCarr(idcarrera){ 
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Carreras/getCarrera/'+idcarrera;
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.log(objData);
            if(objData.status)
            {
                document.querySelector("#celNombre").innerHTML = objData.data.nombreCarrera;
                $('#modalViewCarrera').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditCarr(element, idcarrera){  
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Carrera";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Carreras/getCarrera/'+idcarrera;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){ 

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idCarrera").value = objData.data.idCarrera;
                document.querySelector("#txtNombrecarr").value = objData.data.nombreCarrera;
            }
        }
        $('#modalFormCarreras').modal('show');
    }
}

function fntDelCarr(idCarrera)
{
    var idcarr = idCarrera;
    swal({
        title: "Eliminar",
        text: "¿Realmente quiere eliminar la carrera?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, 
    function(isConfirm)
    {
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Carreras/delCarrera/';
            let strData = "idcarr="+idcarr;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function()
            {
                console.log(request);
                if(request.readyState == 4 && request.status == 200)
                {   
                    console.log(request.objData);
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Hecho", objData.msg, "success");
                        tableCarreras.api().ajax.reload();
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
    rowTable = "";
    document.querySelector('#idCarrera').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister"); 
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Carrera";
    document.querySelector("#formCarreras").reset();
    $('#modalFormCarreras').modal('show');
}
 



