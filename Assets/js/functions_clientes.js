let tableClientes; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableClientes = $('#tableClientes').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Clientes/getClientes",
            "dataSrc":""
        },
        "columns":[
            {"data":"idpersona"},
            {"data":"identificacion"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email_user"},
            {"data":"telefono"},
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

	if(document.querySelector("#formCliente"))
    {
        let formCliente = document.querySelector("#formCliente");
        formCliente.onsubmit = function(e) {
            e.preventDefault();
            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let bueno = document.getElementsByClassName("carrera");
            let resAcademic = []
            let resFinal = []

            for (let r = 0; r < bueno.length; r++) {
                if(bueno[r].checked){
                    resAcademic = [{
                        idUni : bueno[r].dataset.iduni,
                        idCarrera : bueno[r].dataset.idcarre
                    }];
                    resFinal.push(resAcademic)
                }
            }

            if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' )
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
            let ajaxUrl = base_url+'/Clientes/setCliente'; 
            let formData = new FormData(formCliente);
            formData.append("datos",JSON.stringify(resFinal));
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableClientes.api().ajax.reload();
                        }else{
                           rowTable.cells[1].textContent =  strIdentificacion;
                           rowTable.cells[2].textContent =  strNombre;
                           rowTable.cells[3].textContent =  strApellido;
                           rowTable.cells[4].textContent =  strEmail;
                           rowTable.cells[5].textContent =  intTelefono;
                           rowTable = "";
                        }
                        $('#modalFormCliente').modal("hide");
                        formCliente.reset();
                        swal("Profesores", objData.msg ,"success");
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }


}, false);

function cambio(checkbox)
{
    if(checkbox.checked){
        checkbox.classList.add("carrera");
    }else{
        checkbox.classList.remove("carrera")
    }
}

function fntViewInfo(idpersona)
{
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                var uni = [];
                var html = "";
                document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro; 
                document.querySelector("#celDatosAcademicos").innerHTML = ""
                for (let i = 0; i < (objData.data.datosacademicos).length; i++) {
                    if(uni.includes(objData.data.datosacademicos[i].idUniversidad)){
                        html = 
                        `
                            <label id="carrera">${objData.data.datosacademicos[i]['nombreCarrera']}</label><br>
                        `;

                    }else{
                        uni.push(objData.data.datosacademicos[i].idUniversidad);
                        html = 
                        `
                            <b>${objData.data.datosacademicos[i]['nombreUniversidad']}</b><br>
                            <div>
                            <label id="carrera">${objData.data.datosacademicos[i]['nombreCarrera']}</label>
                            </div>
                        `;
                    }

                    $("#celDatosAcademicos").append(html);
                    
                }
                $('#modalViewCliente').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(element, idpersona)
{
    rowTable = element.parentNode.parentNode.parentNode;
    document.getElementById('datosAC').innerHTML = "";
    document.querySelector('#dataca').innerHTML = "Datos Académicos";
    document.querySelector('#titleModal').innerHTML ="Actualizar Cliente";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idUsuario").value = objData.data.idpersona;
                document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                document.querySelector("#txtNombre").value = objData.data.nombres;
                document.querySelector("#txtApellido").value = objData.data.apellidos;
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                document.querySelector("#txtEmail").value = objData.data.email_user;
            
                for (let u = 0; u < (objData.data.unicarreras).length; u++) {
                    var html = 
                        `
                            <!--Universidad-->
                            <div class="col-6">
                            <div class="col"> 
                                <h6>Universidad</h6>
                                <div class="col">                
                                    <input type="checkbox" class="chkvuni" value="${objData.data.unicarreras[u]['idUniversidad']}" id="chkuni" name="chkuni[]">
                                    <label for="idUniversidad" id="chkuni">${objData.data.unicarreras[u]['nombreUniversidad']}</label>
                                </div>
                                <!--Carreras-->
                                <div class="col-sm">
                                    <h6 class="subtitle">Carrera(s)</h6>                                           
                                </div>                   
                            </div>

                        `
                    for (let c = 0; c < (objData.data.unicarreras[u]['carreras']).length; c++) {
                        html += 
                            ` 
                                <div class="col">
                                    <div class="col-sm">
                                        <div class="col-sm">
                                            <input type="checkbox" class="setdel" data-iduni="${objData.data.unicarreras[u]['idUniversidad']}" data-idcarre="${objData.data.unicarreras[u].carreras[c]['idCarrera']}" id="idCarrera" onclick="cambio(this)" name="idCarrera[]">
                                            <label for="idCarrera">${objData.data.unicarreras[u].carreras[c]['nombreCarrera']}</label>
                                        </div>
                                    </div>
                                </div>
                            `  
                    }

                    html+= `<div></div><br><br></div>`
                    $("#datosAC").append(html);
                }

                var chk_arr =  document.getElementsByName("chkuni[]");
                for(k=0;k< chk_arr.length;k++)
                {
                    if(objData.data.datosacademicos){
                        for (let a = 0; a < (objData.data.datosacademicos).length; a++){
                            if(chk_arr[k].value == objData.data.datosacademicos[a]['idUniversidad']){
                                chk_arr[k].checked = true;
                                
                            }
                        }

                    }
                }

                let chk_carr = document.getElementsByName("idCarrera[]");
                //   console.log(i)
                for (let x = 0; x < chk_arr.length; x++) {
                    if(chk_arr[x].checked){
                        // console.log(chk_arr[x].value)
                        for (let i = 0; i < chk_carr.length; i++) {
                            if(chk_carr[i].dataset.iduni == chk_arr[x].value){
                                chk_carr[i].classList.add('buenos');
                            }
                            
                        }
                    }
                    
                }

                let bueno = document.getElementsByClassName("buenos");
                for (let e = 0; e < (objData.data.unicarreras[0].carreras).length; e++) {
                    for (let j = 0; j < bueno.length; j++) {
                        for (let m = 0; m < (objData.data.datosacademicos).length; m++) {
                            if(bueno[j].dataset.idcarre == objData.data.datosacademicos[m]['idCarrera'] && bueno[j].dataset.iduni == objData.data.datosacademicos[m]['idUniversidad']){
                                    bueno[j].checked = true;
                                    bueno[j].classList.add("carrera");
                            }
                                
                        }
                    }
                    
                } 

            }
        }
        $('#modalFormCliente').modal('show');
    }
}

function fntDelInfo(idpersona)
{
    swal({
        title: "Eliminar Profesor",
        text: "¿Realmente quiere eliminar al profesor?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar", 
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Clientes/delCliente';
            let strData = "idUsuario="+idpersona;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableClientes.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}

function openModal()
{
    rowTable = "";
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    document.querySelector('#datosAC').innerHTML = "";
    document.querySelector('#dataca').innerHTML = "";
    document.querySelector("#formCliente").reset();
    $('#modalFormCliente').modal('show');
}