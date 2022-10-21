var tableOE;

$(document).ready(function() {

    tableOE = $('#opcionExiste').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Preguntas/getOpciones",
            "dataSrc": ""
        },
        "columns": [{
                render: function(data, type, row, meta) {
                    return ' <div class="form-check col-sm-5 w-100"> <input type="checkbox" onClick="crequired()" class="form-check-input nretro_checkbox" value="' + row.idOpcion + '" id="idsOE" name="idsOE[]"> </div>';
                }
            },
            { "data": "nombreOpcion" },
            {
                render: function(data, type, row, meta) {
                    return '<div class="form-group"> <textarea class="form-control retroalimentacionOEX" id="retroOEX" name="retroOEX[]" rows="4" placeholder="Ingrese la retroalimentacion"></textarea>  </div>';
                }
            }
        ],
        'select': {
            'style': 'multi'
        },
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10
    });


    var htmlc = []
    var htmls = []
    var htmlt = []

    $.ajax({
        type: "GET",
        url: base_url + '/Preguntas/getSelectSecciones',
        dataType: "json",
        success: function(response) {


            /*  var campo = $.parseJSON(response);
             if (campo) {
                 for (i in campo) {
                     htmlc += '<option value="' + campo.cuestionario[i].idCuestionario + '">' + campo.cuestionario[i].nombreCuestionario + '</option>'
                 }
             } */

            for (let c = 0; c < (response.cuestionario).length; c++) {
                htmlc += "<option value=" + response.cuestionario[c].idCuestionario + ">" + response.cuestionario[c].nombreCuestionario + "</option>"

            }



            for (let s = 0; s < (response.secciones).length; s++) {
                htmls += "<option value=" + response.secciones[s].idSeccion + ">" + response.secciones[s].nombreSeccion + "</option>"
                    //console.log(response.secciones[s].nombreSeccion)
            }

            for (let t = 0; t < (response.tiposp).length; t++) {
                htmlt += "<option value=" + response.tiposp[t].idTipopregunta + ">" + response.tiposp[t].descTipopregunta + "</option>"
                    //console.log(response.tiposp[t].descTipopregunta)
            }

            $("#listCuestionario").html(htmlc)
            $("#listSeccion").html(htmls)
            $("#listTIpopreg").html(htmlt)



            $('select[name=listCuestionario]').selectpicker();
            var cVal = $('select[name=ValueCuestionario] option:first').val();
            $('select[name=listCuestionario]').val(sVal);
            $('select[name=listCuestionario]').selectpicker('refresh');


            $('select[name=listSeccion]').selectpicker();
            var sVal = $('select[name=ValueSeccion] option:first').val();
            $('select[name=listSeccion]').val(sVal);
            $('select[name=listSeccion]').selectpicker('refresh');


            $('select[name=listTIpopreg]').selectpicker();
            var lVal = $('select[name=ValuelistTIpopreg] option:first').val();
            $('select[name=listTIpopreg]').val(sVal);
            $('select[name=listTIpopreg]').selectpicker('refresh');


            /*  $('#listSeccion').selectpicker('refresh');
             $('#listTIpopreg').selectpicker('refresh'); */

        }
    });

    // $('#opcionExiste').on('search.dt', function() {
    //     var value = $('.dataTables_filter input').val();
    //     if(value == ""){
    //         console.log("wey"); // <-- the value
    //     }
    // });

    $(document).on("submit", "#formPregunta", function(e) {

        e.preventDefault();

        let rows = $("#opcionExiste").dataTable().fnGetNodes();
        var resultado = [];
        var nopciones = [];
        // $('.dataTables_filter input').val("");
        let idpregunta = $("#idpregunta").val();
        let textoMixto = $("#textoMixto").val();
        let cuestionario = $("#listCuestionario").val();
        let seccion = $("#listSeccion").val()
        let tipopregunta = $("#listTIpopreg").val()
        let pregunta = $("#pregunta").val()

        if (cuestionario == "" || seccion == "" || tipopregunta == "" || pregunta == "") {
            console.log("Todos los campos son necesarios")
        } else {
            $(rows).each(function() {
                if ($(this).find(".nretro_checkbox").is(':checked')) {
                    let idOpcion = $(this).find("#idsOE").val();
                    let desRetroalimentacion = $(this).find("#retroOEX").val();

                    resultadoo = [{
                        idopcion: idOpcion,
                        retroalimentacionOE: desRetroalimentacion
                    }];
                    resultado.push(resultadoo);
                }
            });

            $("#nuevaopcion tr").each(function() {
                let nuevaop = $(this).find("#optionNueva").val();
                let nretro = $(this).find("#retroNueva").val();

                if (nuevaop != "" && nuevaop != undefined) {
                    resopciones = [{
                        opcionnueva: nuevaop,
                        retroalimentacionueva: nretro
                    }];
                    nopciones.push(resopciones);
                }
            });

            $.ajax({
                type: "POST",
                url: " " + base_url + "/Preguntas/setPregunta",
                data: {
                    "idpregunta": idpregunta,
                    "textoMixto": textoMixto,
                    "cuestionario": cuestionario,
                    "seccion": seccion,
                    "tipopregunta": tipopregunta,
                    "pregunta": pregunta,
                    "opcionesexisten": resultado,
                    "opcionesnuevas": nopciones
                },
                dataType: "json",
                success: function(response) {
                    console.log(response)
                    if (response.status) {
                        swal("Pregunta", response.msg, "success");
                    } else {
                        swal("Error", response.msg, "error");
                    }
                }
            });

        }

    });



});

function crequired() {
    $('.nretro_checkbox').on('change', function() {
        let rowschk = $("#opcionExiste").dataTable().fnGetNodes();
        $(rowschk).each(function() {
            if ($(this).find(".nretro_checkbox").is(':checked')) {
                $(this).find("#retroOEX").prop('required', true);
                // $(".paginate_button").css("display","none");
            } else {
                $(this).find("#retroOEX").prop('required', false);
            }
        });
    });
}

function arequiredretro() {
    $(".opcionNueva").keyup(function() {
        $("#nuevaopcion tr").each(function() {
            let keyop = $(this).find("#optionNueva").val();
            if (keyop != "" && keyop != undefined) {
                $(this).find("#retroNueva").prop('required', true);
            } else {
                $(this).find("#retroNueva").prop('required', false);
            }
        });
    });
}