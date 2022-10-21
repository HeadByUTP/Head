document.addEventListener('DOMContentLoaded', function() {

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Graficas/getDatos/' + cuatrimestre;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            console.log(objData);

            document.getElementById("titulocuestionario").innerText = "(" + objData.cuatrimestre + ")";


            for (let t = 0; t < (objData.temas).length; t++) {
                 

                if (t == 0) {
                    $("#temass").append(
                        `
               <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tema${[t+1]}"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><h5>${objData.temas[t]['nombreTema']}</h5></font></font></a></li>
              `
                    );

                    $("#temasgroup").append(
                        `
              <div class="tab-pane fade" id="tema${[t+1]}">
                <div class="col-lg-12" id="nombreSeccion${[t]}">
                </div>
              </div>
              `
                    );

                    for (let s = 0; s < (objData.temas[t].secciones).length; s++) {

                        $("#nombreSeccion" + t + "").append(`
                <h3>${[objData.temas[t].secciones[s].nombreSeccion]}</h3>
                <div class="row" id="preg${[objData.temas[t].secciones[s].idSeccion]}">
              `);

                        for (let p = 0; p < (objData.temas[t].secciones[s].preguntas).length; p++) {
                            $("#preg" + objData.temas[t].secciones[s].idSeccion + "").append(`
                <div class="col-md-6 mt-4">
                  <div class="tile">
                    <canvas id="doughnutChartDemo${[objData.temas[t].secciones[s].preguntas[p].idPregunta]}" width="300" height="200"></canvas>
                  </div>
                </div>
                `);

                            let labels = []
                            let valor = []

                            //duda opcionseleccionadas.length

                            for (let o = 0; o < (objData.temas[t].secciones[s].preguntas[p].opcioneseleccionadas).length; o++) {
                                labels.push(objData.temas[t].secciones[s].preguntas[p].opcioneseleccionadas[o].opcion + "(" + objData.temas[t].secciones[s].preguntas[p].opcioneseleccionadas[o].conteo + ")")
                                valor.push(objData.temas[t].secciones[s].preguntas[p].opcioneseleccionadas[o].conteo)

                            }

                            const data = {
                                labels: labels,
                                datasets: [{
                                    label: 'Opciones seleccionadas',
                                    data: valor,
                                    backgroundColor: [
                                        'rgb(255, 205, 86)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 99, 132)'
                                    ],
                                    hoverOffset: 4
                                }],
                            };

                            var ctx = document.getElementById('doughnutChartDemo' + objData.temas[t].secciones[s].preguntas[p].idPregunta).getContext('2d');

                            var graph2 = new Chart(ctx, {
                                type: "bar",
                                data: data,
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        title: {
                                            display: true,
                                            text: "" + [objData.temas[t].secciones[s].preguntas[p].pregunta] + ""
                                        }
                                    }
                                },
                            });

                            // labels = [];
                            // valor = [];

                        }

                        //que es a ciencia cierta?????????????

                        if (s == ((objData.temas[t].secciones).length) - 1) {
                            $("#nombreSeccion" + t + "").append(`
                  </div>
              `);
                        }
                    }

                } else {
                    $("#temass").append(
                        `
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tema${[t+1]}"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><h5>${objData.temas[t]['nombreTema']}</h5></font></font></a></li>
              `
                    );

                    $("#temasgroup").append(
                        `
              <div class="tab-pane fade" id="tema${[t+1]}">
                <div class="col-lg-12" id="nombreSeccion${[t]}">
                </div>
              </div>
              `
                    );

                    for (let s = 0; s < (objData.temas[t].secciones).length; s++) {
                        $("#nombreSeccion" + t + "").append(`
                <h3>${[objData.temas[t].secciones[s].nombreSeccion]}</h3>
                <div class="row" id="preg${[objData.temas[t].secciones[s].idSeccion]}">
              `);

                        for (let p = 0; p < (objData.temas[t].secciones[s].preguntas).length; p++) {

                            $("#preg" + objData.temas[t].secciones[s].idSeccion + "").append(`
                <div class="col-md-6 mt-4">
                  <div class="tile">
                    <canvas id="doughnutChartDemo${[objData.temas[t].secciones[s].preguntas[p].idPregunta]}" width="300" height="200"></canvas>
                  </div>
                </div>
                `);

                            let labels = []
                            let valor = []

                            for (let o = 0; o < (objData.temas[t].secciones[s].preguntas[p].opcioneseleccionadas).length; o++) {
                                labels.push(objData.temas[t].secciones[s].preguntas[p].opcioneseleccionadas[o].opcion + "(" + objData.temas[t].secciones[s].preguntas[p].opcioneseleccionadas[o].conteo + ")")
                                valor.push(objData.temas[t].secciones[s].preguntas[p].opcioneseleccionadas[o].conteo)
                            }

                            const data = {
                                labels: labels,
                                datasets: [{
                                    label: 'Opciones seleccionadas',
                                    data: valor,
                                    backgroundColor: [
                                        'rgb(255, 205, 86)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 99, 132)'
                                    ],
                                    hoverOffset: 4
                                }]
                            };

                            var ctx = document.getElementById("doughnutChartDemo" + objData.temas[t].secciones[s].preguntas[p].idPregunta + "").getContext('2d')

                            var graph = new Chart(ctx, {
                                type: "doughnut",
                                data: data,
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        title: {
                                            display: true,
                                            text: "" + [objData.temas[t].secciones[s].preguntas[p].pregunta] + ""
                                        }
                                    }
                                },
                            });

                            labels = [];
                            valor = [];

                        }

                        if (s == ((objData.temas[t].secciones).length) - 1) {
                            $("#nombreSeccion" + t + "").append(`
                  </div>
                `);
                        }
                    }


                }




            }
        }
    }

})