let tableVideos;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function()
{
    tableVideos = $('#tableVideos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/videosyotube/getVideos", 
            "dataSrc":"" 
        },
        "columns":[
            {"data":"idVideo"},
            {"data":"nombreVideo"},
            {"data":"descVideo"},
            {"data":"autor"},
            {"data":"categoria"},
            {"data":"url"},
            {"data":"status"},
            {"data":"fecha"},
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

    if(document.querySelector("#formVideos"))
    {
        let formVideos = document.querySelector("#formVideos");

        formVideos.onsubmit = function(e)
        {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombrevideo').value;
            let strDesc = document.querySelector('#txtDesc').value;
            let strAutor = document.querySelector('#txtAutor').value;
            let strCat = document.querySelector('#txtCat').value;
            let strUrl = document.querySelector('#txtUrl').value;
            let intStatus = document.querySelector('#listStatus').value;
            let strFecha = document.querySelector('#txtFecha').value;

            if(strNombre == '' || strDesc == '' || strAutor == '' || strCat == '' || strUrl == '' || intStatus == '' || strFecha == '')
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
            let ajaxUrl = base_url+'/Videos/setVideo'; 
            let formData = new FormData(formVideos);
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
                            tableVideos.api().ajax.reload();
                        }else{
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strDesc;
                            rowTable.cells[3].textContent = strAutor;
                            rowTable.cells[4].textContent = strCat;
                            rowTable.cells[5].textContent = strUrl;
                            rowTable.cells[6].textContent = intStatus;
                            rowTable.cells[7].textContent = strFecha;
                            rowTable="";
                        }
                        $('#modalFormVideos').modal("hide");
                        formVideos.reset();
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

function fntViewVideo(idVideo)
{
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Videos/getVideo/'+idVideo;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function()
    {
        if(request.readyState == 4 && request.status == 200)
        {
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#celNombrevideo").innerHTML = objData.data.nombreVideo;
                document.querySelector("#celDescrip").innerHTML = objData.data.descVideo;
                document.querySelector("#celAutor").innerHTML = objData.data.autor;
                document.querySelector("#celCat").innerHTML = objData.data.categoria;
                document.querySelector("#celUrl").innerHTML = objData.data.url;
                if(objData.data.status == 1){
                    document.querySelector('#celStatus').innerHTML= "<span class=\"badge badge-success\">Activo</span>";
                }else if(objData.data.status == 0){
                    document.querySelector('#celStatus').innerHTML = "<span class=\"badge badge-danger\">Inactivo</span>";
                }
                document.querySelector("#celFecha").innerHTML = objData.data.fecha;
                $('#modalViewVideos').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}
 
function fntEditVideo(element,idVideo)
{
    rowTable = element.parentNode.parentNode.parentNode; 
    document.querySelector('#titleModal').innerHTML ="Actualizar Vídeo";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Videos/getVideo/'+idVideo;
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
                document.querySelector("#idVideo").value = objData.data.idVideo;
                document.querySelector("#txtNombrevideo").value = objData.data.nombreVideo;
                document.querySelector("#txtDesc").value = objData.data.descVideo;
                document.querySelector("#txtAutor").value = objData.data.autor;
                document.querySelector("#txtCat").value = objData.data.categoria;
                document.querySelector("#txtUrl").value = objData.data.url;
                if(objData.data.status == "1"){
                    document.getElementById('listStatus').value = "1";
                }else if(objData.data.status == "0"){
                    document.getElementById('listStatus').value = "0";
                }
                document.getElementById("listCuestionario").value = objData.data.fecha;
                $('#listStatus').selectpicker('render');
            }
        }
        $('#modalFormVideos').modal('show');
    }
}

function fntDelVideo(idVideo)
{
    var idvideo = idVideo;
    swal({
        title: "Eliminar",
        text: "¿Realmente quiere eliminar el vídeo? El Status pasará a 'Inactivo'.",
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
            let ajaxUrl = base_url+'/Videos/delVideo/';
            let strData = "idvideo="+idvideo;
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
                        swal("Hecho", objData.msg, "success");
                        tableVideos.api().ajax.reload();
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
    document.querySelector('#idVideo').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Vídeo";
    document.querySelector("#formVideos").reset();
    $('#modalFormVideos').modal('show');
}