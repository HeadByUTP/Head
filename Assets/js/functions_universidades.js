let tableUniversidades;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableUniversidades = $('#tableUniversidades').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Universidades/getUniversidades",
            "dataSrc":""
        },
        "columns":[
            {"data":"idUniversidad"},
            {"data":"nombreUniversidad"},
            {"data":"status"},
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


    if(document.querySelector("#formUniversidades")){
        let formUniversidades = document.querySelector("#formUniversidades");
        formUniversidades.onsubmit = function(e) {
            e.preventDefault(); 
            let strNombreuni = document.querySelector('#txtNombreuni').value;
            let strStatus = document.querySelector('#listStatus').value;

            if(strNombreuni == '' || strStatus == '')
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
            let ajaxUrl = base_url+'/Universidades/setUniversidad'; 
            let formData = new FormData(formUniversidades);
            request.open("POST",ajaxUrl,true);
            request.send(formData); 
 
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    console.log(objData);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableUniversidades.api().ajax.reload(); 
                        }else{
                           rowTable.cells[1].textContent =  strNombreuni;
                           rowTable.cells[2].textContent =  strStatus; 
                           rowTable = "";
                        }
                        $('#modalFormUniversidades').modal("hide");
                        formUniversidades.reset();
                        swal("Universidad", objData.msg ,"success");
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


function fntViewUni(iduniversidad){ 
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Universidades/getUniversidad/'+iduniversidad;
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.log(objData);
            if(objData.status)
            {
                document.querySelector("#celNombre").innerHTML = objData.data.nombreUniversidad; 
                document.querySelector("#celStatus").innerHTML = objData.data.status; 
                $('#modalViewUniversidad').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditUni(element, iduniversidad){  
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Universidad";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Universidades/getUniversidad/'+iduniversidad;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){ 

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idUniversidad").value = objData.data.idUniversidad;
                document.querySelector("#txtNombreuni").value = objData.data.nombreUniversidad;
                document.querySelector("#listStatus").value = objData.data.status;
            }
        }
        $('#modalFormUniversidades').modal('show');
    }
}



function openModal()
{ 
    rowTable = "";
    document.querySelector('#idUniversidad').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister"); 
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Universidad";
    document.querySelector("#formUniversidades").reset();
    $('#modalFormUniversidades').modal('show');
}
 



