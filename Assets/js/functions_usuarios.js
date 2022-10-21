let tableUsuarios;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableUsuarios = $('#tableUsuarios').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Usuarios/getUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"idpersona"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email_user"},
            {"data":"telefono"},
            {"data":"nombrerol"},
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

    datosAcademicos();

    if(document.querySelector("#formUsuario")){
        let formUsuario = document.querySelector("#formUsuario");
        formUsuario.onsubmit = function(e) {
            e.preventDefault();
            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let intTipousuario = document.querySelector('#listRolid').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let intStatus = document.querySelector('#listStatus').value;
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

            if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || intTipousuario == '')
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
            let ajaxUrl = base_url+'/Usuarios/setUsuario'; 
            let formData = new FormData(formUsuario);
            formData.append("datos",JSON.stringify(resFinal));
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableUsuarios.api().ajax.reload();
                        }else{
                            htmlStatus = intStatus == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strApellido;
                            rowTable.cells[3].textContent = strEmail;
                            rowTable.cells[4].textContent = intTelefono;
                            rowTable.cells[5].textContent = document.querySelector("#listRolid").selectedOptions[0].text;
                            rowTable.cells[6].innerHTML = htmlStatus;
                            rowTable="";
                        }
                        $('#modalFormUsuario').modal("hide");
                        formUsuario.reset();
                        swal("Usuarios", objData.msg ,"success");
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
    //Actualizar Perfil
    if(document.querySelector("#formPerfil")){
        let formPerfil = document.querySelector("#formPerfil");
        formPerfil.onsubmit = function(e) {
            e.preventDefault();
            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;

            if(strIdentificacion == '' || strApellido == '' || strNombre == '' || intTelefono == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

            if(strPassword != "" || strPasswordConfirm != "")
            {   
                if( strPassword != strPasswordConfirm ){
                    swal("Atención", "Las contraseñas no son iguales." , "info");
                    return false;
                }           
                if(strPassword.length < 5 ){
                    swal("Atención", "La contraseña debe tener un mínimo de 5 caracteres." , "info");
                    return false;
                }
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
            let ajaxUrl = base_url+'/Usuarios/putPerfil'; 
            let formData = new FormData(formPerfil);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4 ) return; 
                if(request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        $('#modalFormPerfil').modal("hide");
                        swal({
                            title: "",
                            text: objData.msg,
                            type: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false,
                        }, function(isConfirm) {
                            if (isConfirm) {
                                location.reload();
                            }
                        });
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
    //Actualizar Datos Académicos
    if(document.querySelector("#formDataAcademic")){
        let formUsuario = document.querySelector("#formDataAcademic");
        formUsuario.onsubmit = function(e) {
            e.preventDefault();
            
            let user = document.querySelector("#User").value;
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
 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/setDatosAcademicos';  
            let formData = new FormData();
            formData.append("user",user);
            formData.append("datos",JSON.stringify(resFinal)); 
            request.open("POST",ajaxUrl,true);
            request.send(formData); 
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Datos académicos", objData.msg ,"success");
                        setTimeout(function(){ location.reload(); }, 1200);
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

function datosAcademicos()
{
    if(document.querySelector("#datosA")){
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Usuarios/getPerfil';
        request.open("GET",ajaxUrl,true); 
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                console.log(objData);
                if(objData.status){
                    document.querySelector("#User").value = objData.data.idpersona;
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

                        html+= `<div><br><br></div></div>`
                        $("#datosA").append(html);
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
                     //console.log(chk_arr.length)
                     //console.log(chk_carr)
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
        }
    }
}

function cambio(checkbox){
    if(checkbox.checked){
        checkbox.classList.add("carrera");
    }else{
        checkbox.classList.remove("carrera")
    }
}

window.addEventListener('load', function() {
        fntRolesUsuario();
}, false);

function fntRolesUsuario(){
    if(document.querySelector('#listRolid')){
        let ajaxUrl = base_url+'/Roles/getSelectRoles';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listRolid').innerHTML = request.responseText;
                $('#listRolid').selectpicker('render');
            }
        }
    }
}

function fntViewUsuario(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.log(objData)
            if(objData.status)
            {
               let estadoUsuario = objData.data.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                var uni = [];
                var html = "";
                document.querySelector("#celDatosAcademicos").innerHTML = ""
                document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombrerol;
                document.querySelector("#celEstado").innerHTML = estadoUsuario;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro; 
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
                $('#modalViewUser').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}
 
function fntEditUsuario(element,idpersona){

    rowTable = element.parentNode.parentNode.parentNode; 
    document.getElementById('datosAC').innerHTML = "";
    document.querySelector('#dataca').innerHTML = "Datos Académicos";
    document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
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
                document.querySelector("#listRolid").value =objData.data.idrol; 
                $('#listRolid').selectpicker('render'); 

                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');

                for (let u = 0; u < (objData.data.unicarreras).length; u++) {
                    var html = 
                        `
                            <!--Universidad-->
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

                    html+= `<div><br><br></div>`
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
        $('#modalFormUsuario').modal('show');
    }
}

function fntDelUsuario(idpersona){

    swal({
        title: "Eliminar Usuario",
        text: "¿Realmente quiere eliminar al usuario?",
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
            let ajaxUrl = base_url+'/Usuarios/delUsuario';
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
                        tableUsuarios.api().ajax.reload();
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
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector('#datosAC').innerHTML = "";
    document.querySelector('#dataca').innerHTML = "";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}

function openModalPerfil()
{
    $('#modalFormPerfil').modal('show');
}

// http://www.mediafire.com/file/hxvw0qcg5xxzvv7/SP_Flash_Tool_v5.17228_Win.zip/file