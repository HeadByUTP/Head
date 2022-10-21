<?php 
// dep($data);
// exit;
$preguntas = $data;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancia</title>
    <style>
        table {
            width: 100%;
        }
        
        table td,
        table th {
            font-size: 12px;
        }
        
        h4 {
            margin-bottom: 0px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-left1 {
            
        }
        
        .wd33 {
            width: 33.33%;
        }
        
        .wd35 {
            width: 35%;
        }
        
        .wd30 {
            width: 30%;
        }
        
        .wd25 {
            width: 25%;
        }
        
        .tbl-cliente {
            border: 1px solid #CCC;
            border-radius: 10px;
            padding: 5px;
        }
        
        .imglogocdh img {
            width: 700px;
        }
        
        .imgNoDejarse img {
            width: 320px;
            display: block;
            margin: auto;
            margin-left: 60px;
        }
        
        .qrconstancia img {
            width: 160px;
            float: right;
        }
        
        .wd10 {
            width: 10%;
        }
        
        .wd15 {
            width: 15%;
        }
        
        .wd40 {
            width: 40%;
        }
        
        .wd55 {
            width: 55%;
        }
        
        .tbl-detalle {
            border-collapse: collapse;
        }
        
        .tbl-detalle thead th {
            padding: 5px;
            background-color: #009688;
            color: #FFF;
        }
        
        .tbl-detalle tbody td {
            border-bottom: 1px solid #CCC;
            padding: 5px;
        }
        
        .tbl-detalle tfoot td {
            padding: 5px;
        }
        
        .texto1 {
            font-size: 30px;
            font-weight: normal;
            margin-bottom: 0px;
            margin-top: 0px;
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .texto2 {
            font-size: 30px;
            font-weight: bold;
            margin-top: 0px;
            margin-bottom: 0px;
            text-align: center;
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .textotres {
            font-size: 25px;
            font-weight: bold;
            margin-top: 0px;
            margin-bottom: 0px;
            text-align: center;
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .texto_dos_ver {
            font-size: 20px;
            font-weight: normal;
            margin-top: 0px;
            margin-bottom: 0px;
            text-align: center;
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .texto3 {
            font-size: 25px;
            font-weight: normal;
            text-align: center;
            margin-top: 0px;
            margin-bottom: 0px;
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .texto4 {
            font-size: 25px;
            font-weight: bold;
            text-align: center;
            margin-top: 0px;
            margin-bottom: 0px;
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .textoPreguntas {
            font-size: 25px;
            font-weight: bold;
            text-align: center;
            margin-top: 0px;
            margin-bottom: 0px;
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .textoPreguntasdos {
            font-size: 20px;
            font-weight: normal;
            margin-top: 0px;
            text-align: center;
            
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .textoPreguntastres {
            font-size: 20px;
            font-weight: normal;
            margin-top: 0px;
            margin-bottom: 0px;
            padding-left: 50px;
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .textoTitulo {
            font-size: 20px;
            font-weight: bold;
            margin-top: 0px;
            margin-bottom: 0px;
            padding-left: 40px;
            /* font-family: "Montserrat", sans-serif; */
        }
        
        .textoPreguntascuatro {
            font-size: 20px;
            text-align: justify;
            margin-top: 0px;
            margin-bottom: 0px;
            padding-left: 50px;
            /* font-family: "Montserrat", sans-serif; */
            font-style: italic;
            color: blue;
        }
    </style>
</head>

<body>
    <table class="tbl-hader">
        <tbody>
            <tr>
                <td class="wd33 imglogocdh">
                    <img src="<?= media() ?>/images/banner.jpg" alt="Logo">
                </td>
                <!-- <td class="wd33 imgNoDejarse">
                    <img src="logos/Logo_no_dejarse.png" alt="Logo">
                </td> --> 
                <!-- <td class="wd33 qrconstancia">
                    <img src="logos/utpuebla.png" alt="Logo">
                </td> -->
            </tr>
        </tbody>
    </table>
   
    <div class="text-center">
   
        <h2 class="texto2">Herramienta de Autoevaluación Docente</h2><br><br>
        <h4 class="texto1"><?= $preguntas['nombre']; ?> (<?= $preguntas['cicloEscolar']; ?>)</h4><br>
        <h2 class="textotres">Resultados a nombre de: </h2> <br>
        <h4 class="texto_dos_ver"> <?= $preguntas['usuario']['nombres'].' '.$preguntas['usuario']['apellidos']; ?> </h4><br>
        <h2 class="textotres">Matricula: </h2> <br>
        <h4 class="texto_dos_ver"> <?= $preguntas['usuario']['identificacion']; ?> </h4>

        <!-- <h4 class="texto4">Puebla, Pue., a 28 de marzo de 2022</h4> -->
    </div>
    <br><br>

    <?php
        for ($t = 0; $t < count($preguntas['temas']); $t++) {
    ?>
    <div class="text-left1" style="margin-top: 20px;">
        <!-- Tema -->
        <h1 class="textoPreguntas"><?= $preguntas['temas'][$t]['nombreTema'] ?></h1><br>

        <?php
            for ($s = 0; $s < count($preguntas['temas'][$t]['secciones']); $s++) {
        ?>
        <!-- Seccion -->
        <div id="seccionPdf" class="seccionPdf">
            <p class="textoPreguntasdos"><?= $preguntas['temas'][$t]['secciones'][$s]['nombreSeccion'] ?></p><br>
        
            <?php
                 for ($p = 0; $p < count($preguntas['temas'][$t]['secciones'][$s]['preguntas']); $p++) {
            ?>
            <div id="preguntasPdf" class="preguntasPdf" style="width: 95%;">
                <!-- Pregunta -->
                <p class="textoTitulo"><?= $preguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['pregunta'] ?></p><br>

                <?php
                if (array_key_exists('opciones', ($preguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]))) {
                for ($o = 0; $o < count($preguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones']); $o++) {
                ?>
                <div id="respuestasPdf" class="respuestasPdf">
                    <!-- Respuesta -->
                    <p class="textoPreguntastres">-<?= $preguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['opcion'] ?></p>

                    <div id="retrosPdf" class="retrosPdf" style="width: 90%;">
                        <!-- Retroalimentacion -->
                        <p class="textoPreguntascuatro"><?= $preguntas['temas'][$t]['secciones'][$s]['preguntas'][$p]['opciones'][$o]['retroalimentacion'] ?></p>
                    
                    </div><br>

                </div>
                <?php
                    }
                }
                ?>
                
            </div>
            <?php
                }
            ?>

        </div>
        <?php
            }
        ?>
        
    </div>
    <?php
        }
    ?>


    <br>
    
</body>

</html>