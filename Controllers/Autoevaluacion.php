<?php

class Autoevaluacion extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
    }

    public function autoevaluacion()
    {
        if (!empty($_SESSION['login'])) {
           
            $idusuario = intval($_SESSION['userData']['idpersona']);
            $arrData = $this->model->selectUsuario($idusuario);

            if (array_key_exists('datosacademicos', $arrData)) {
                $_SESSION['datosUni'] = true;
            } else {
                $_SESSION['datosUni'] = false;
            }
        }

        $data['page_tag'] = "HAED - Autoevaluacion";
        $data['page_title'] = "Canal de Youtube";
        $data['page_name'] = "HAED - Canal Youtube";
        $data['preguntas'] = $this->model->selectPreguntas();
        $data['datosUsuario'] = $_SESSION['userData'];
        $this->views->getView($this, "autoevaluacion", $data);
        
    }

    public function setRegistro()
    {
        if ($_POST) {
            $datos = json_decode($_POST["datos"]);

            for ($i = 0; $i < count($datos); $i++) {
                $datosPregunta[$i] = [
                    'idCuatrimestre' => $datos[$i][0]->idcuatrimestre,
                    'nombreCuatrimestre' => $datos[$i][0]->nombreCuatrimestre,
                    'idPregunta' => $datos[$i][0]->idPregunta,
                    'pregunta' => $datos[$i][0]->pregunta,

                ];

                for ($o = 0; $o < count($datos[$i][0]->seleccion); $o++) {
                    $datosOpciones[$o] = [
                        'idpregunta' => $datos[$i][0]->seleccion[$o]->idpregunta,
                        'idopcion' => $datos[$i][0]->seleccion[$o]->idopcion,
                        'opcion' => $datos[$i][0]->seleccion[$o]->opcion,
                        'retroalimentacion' => $datos[$i][0]->seleccion[$o]->retroalimentacion,
                        'respuesta' => $datos[$i][0]->seleccion[$o]->respuesta

                    ];
                }
            }

            for ($p = 0; $p < count($datosPregunta); $p++) {

                for ($j = 0; $j < count($datosOpciones); $j++) {

                    if ($datosPregunta[$p]['idPregunta'] == $datosOpciones[$j]['idpregunta']) {
                        $datosPregunta[$p]['respuestas'][] = $datosOpciones[$j];
                    }
                }
            }

            $idPersona = intval($_SESSION['userData']['idpersona']);

            $arrData = $this->model->setRespuesta($datosPregunta[0]['idCuatrimestre'], $datosPregunta[0]['nombreCuatrimestre'], $idPersona);

            if (intval($arrData) > 0) {

                for ($f = 0; $f < count($datosPregunta); $f++) {

                    for ($r = 0; $r < count($datosPregunta[$f]['respuestas']); $r++) {
                        $arrDatadr[] = $this->model->setDetalleRespuesta($datosPregunta[$f]['pregunta'], $datosPregunta[$f]['respuestas'][$r]['idopcion'], $datosPregunta[$f]['respuestas'][$r]['opcion'], $datosPregunta[$f]['respuestas'][$r]['retroalimentacion'], $datosPregunta[$f]['respuestas'][$r]['respuesta'], $datosPregunta[$f]['respuestas'][$r]['idpregunta'], $arrData);
                    }
                }

                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            } elseif ($arrData == "exist") {
                $arrResponse = array('status' => false, 'msg' => 'No puede contestar la Autoevaluacion dos veces.');
            } else {
                $arrResponse = array("status" => false, "msg" => 'No fue posible almacenar los datos, intente más tarde.');
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setDetallerespuesta()
    {
 
        if ($_POST) {

            // dep($_POST);
            // exit();

            if(array_key_exists('StatusEvaluacion',$_SESSION['userData'])){

                $_SESSION['userData']['StatusEvaluacion'] = "Pendiente";
               
                //***************************************************************/

                if (array_key_exists('tipoPregunta', $_POST)) {
                    $tipoPregunta = strClean($_POST["tipoPregunta"]);
                }else{
                    $tipoPregunta = "";
                }
              
    
                if($tipoPregunta == "mixtaCheckbox"){

                    $idRespuesta = $_SESSION['userData']['idRespuesta'];
                    $respuestaDetallada = strClean(end($_POST["datos"])["respuestaLibre"]);

                    for($i=0; $i < (count($_POST["datos"]) - 1); $i++){
                        
                        $pregunta = strClean($_POST["datos"][$i]["pregunta"]);
                        $idOpcion = strClean($_POST["datos"][$i]["idPreguntaop"]);
                        $desOpci = strClean($_POST["datos"][$i]["desOpcion"]);
                        $descripRetro = strClean($_POST["datos"][$i]["retroAlimem"]);
                        $idPregunta = strClean($_POST["datos"][$i]["idPregunta"]);
         
                        $arrData = $this->model->setDetalleResp($pregunta, $idOpcion, $desOpci, $descripRetro, $respuestaDetallada, $idPregunta, $idRespuesta);
                    }
                    //declaracion de variables cuando las preguntas son mixtas
                }else if($tipoPregunta == "mixtaRadio"){
                    //declaracion de variables cuando las preguntas son mixtas
                    $pregunta = strClean($_POST["datos"][0]["pregunta"]);
                    $idOpcion = strClean($_POST["datos"][0]["idPreguntaop"]);
                    $desOpci = strClean($_POST["datos"][0]["desOpcion"]);
                    $descripRetro = strClean($_POST["datos"][0]["retroAlimem"]);
                    $idPregunta = strClean($_POST["datos"][0]["idPregunta"]);
                    $idRespuesta = $_SESSION['userData']['idRespuesta'];
                    $respuestaDetallada = strClean($_POST["datos"][1]["respuestaLibre"]);
     
                    $arrData = $this->model->setDetalleResp($pregunta, $idOpcion, $desOpci, $descripRetro, $respuestaDetallada, $idPregunta, $idRespuesta);
                }else{
                     
                    //los campos del post deben ser igual a la base de datos, esta es cuando las preguntas no son mixtas
                    $pregunta = strClean($_POST['pregunta']);
                    $idOpcion = strClean($_POST['idOpcion']);
                    $desOpci = strClean($_POST['opcion']);
                    $descripRetro = strClean($_POST['retroalimentacion']);
                    $respuestaDetallada = "";
                    $idPregunta = strClean($_POST['idPregunta']);
                    $idRespuesta = $_SESSION['userData']['idRespuesta'];
    
                    $arrData = $this->model->setDetalleResp($pregunta, $idOpcion, $desOpci, $descripRetro, $respuestaDetallada,$idPregunta, $idRespuesta);
                }

            }else{

                $idCuatrimestre = strClean($_POST["datosRespuesta"]["idCuatrimestre"]);
                $cuatrimestre = strClean($_POST["datosRespuesta"]["cuatrimestre"]);
                $idPersona = strClean($_POST["datosRespuesta"]["idPersona"]);

                $_SESSION['userData']['StatusEvaluacion'] = "Pendiente"; 
                $arrDataRespuesta = $this->model->setRespuesta($idCuatrimestre, $cuatrimestre, $idPersona);
                $_SESSION['userData']['idRespuesta'] = $arrDataRespuesta;

                //******************************************************* */

                if (array_key_exists('tipoPregunta', $_POST)) {
                    $tipoPregunta = strClean($_POST["tipoPregunta"]);
                }else{
                    $tipoPregunta = "";
                }
    
                if($tipoPregunta == "mixtaCheckbox"){

                    //declaracion de variables cuando las preguntas son mixtas
                    $idRespuesta = $_SESSION['userData']['idRespuesta'];
                    $respuestaDetallada = strClean(end($_POST["datos"])["respuestaLibre"]);

                    for($i=0; $i < (count($_POST["datos"]) - 1); $i++){
                        
                        $pregunta = strClean($_POST["datos"][$i]["pregunta"]);
                        $idOpcion = strClean($_POST["datos"][$i]["idPreguntaop"]);
                        $desOpci = strClean($_POST["datos"][$i]["desOpcion"]);
                        $descripRetro = strClean($_POST["datos"][$i]["retroAlimem"]);
                        $idPregunta = strClean($_POST["datos"][$i]["idPregunta"]);
         
                        $arrData = $this->model->setDetalleResp($pregunta, $idOpcion, $desOpci, $descripRetro, $respuestaDetallada, $idPregunta, $idRespuesta);
                    }


                }else if($tipoPregunta == "mixtaRadio"){
                    //declaracion de variables cuando las preguntas son mixtas
                    $pregunta = strClean($_POST["datos"][0]["pregunta"]);
                    $idOpcion = strClean($_POST["datos"][0]["idPreguntaop"]);
                    $desOpci = strClean($_POST["datos"][0]["desOpcion"]);
                    $descripRetro = strClean($_POST["datos"][0]["retroAlimem"]);
                    $idPregunta = strClean($_POST["datos"][0]["idPregunta"]);
                    $idRespuesta =  $_SESSION['userData']['idRespuesta'];
                    $respuestaDetallada = strClean($_POST["datos"][1]["respuestaLibre"]);
     
                    $arrData = $this->model->setDetalleResp($pregunta, $idOpcion, $desOpci, $descripRetro, $respuestaDetallada, $idPregunta, $idRespuesta);
                }else{
                     
                    //los campos del post deben ser igual a la base de datos, esta es cuando las preguntas no son mixtas
                    $pregunta = strClean($_POST['pregunta']);
                    $idOpcion = strClean($_POST['idOpcion']);
                    $desOpci = strClean($_POST['opcion']);
                    $descripRetro = strClean($_POST['retroalimentacion']);
                    $respuestaDetallada = "";
                    $idPregunta = strClean($_POST['idPregunta']);
                    $idRespuesta =  $_SESSION['userData']['idRespuesta'];
    
                    $arrData = $this->model->setDetalleResp($pregunta, $idOpcion, $desOpci, $descripRetro, $respuestaDetallada,$idPregunta, $idRespuesta);
                }

            }

          

            
            if (intval($arrData) > 0) {
                $arrResponse = array('status' => true, 'msg' => 'inserción a la base de datos.');
            } else {
                $arrResponse = array("status" => false, "msg" => 'No fue posible insertar a la base de datos.');
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

}
