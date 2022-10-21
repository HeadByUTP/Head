document.addEventListener('DOMContentLoaded', function(){

    if(document.querySelector("#graficas")){
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Dashboard/selectGraficas';
        request.open("GET",ajaxUrl,true); 
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                $("#graficas").append(objData);
            }
        }
    }
});