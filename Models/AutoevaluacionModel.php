<?php
class AutoevaluacionModel extends Mysql
{
    private $intIdPersona;
    private $intIdPregunta;
    private $strPregunta;
    private $intIdSeccion;
    private $intTipoPregunta;
    private $intIdCuestionario;
    private $intIdCuatrimestre;
    private $intIdOpcion;
    private $strOpcion;
    private $strRespuesta;
    private $intIdRespuesta;
    private $strnombreCuatrimestre;
    private $intIdRetroalimentacion;
    private $strRetroalimentacion;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectUsuario(int $idpersona)
    {
        $this->intIdUsuario = $idpersona;

        $sql = "SELECT p.idpersona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,r.idrol,r.nombrerol,p.status, DATE_FORMAT(p.fecha_nacimiento, '%d-%m-%Y') as fechaRegistro 
                FROM persona p
                INNER JOIN rol r
                ON p.rolid = r.idrol
                WHERE p.idpersona = $this->intIdUsuario";
        $request = $this->select($sql);
        if (count($request) > 0) {
            $sqlUni = "SELECT idUniversidad, nombreUniversidad FROM universidad";
            $resUni = $this->select_all($sqlUni);
            if (count($resUni) > 0) {
                for ($u = 0; $u < count($resUni); $u++) {
                    $intIdUni = $resUni[$u]['idUniversidad'];

                    $sqlCarr = "SELECT idCarrera, nombreCarrera FROM carrera";
                    $arrCarr = $this->select_all($sqlCarr);
                    $resUni[$u]['carreras'] = $arrCarr;
                }
            }

            $intIdUsuario = $request['idpersona'];
            $sqlUniCarr = "
                SELECT u.idUniversidad, u.nombreUniversidad, c.idCarrera, c.nombreCarrera FROM persona_unicarr AS puc 
                INNER JOIN universidad AS u ON puc.idUniversidad = u.idUniversidad
                INNER JOIN carrera AS c ON puc.idCarrera = c.idCarrera
                WHERE puc.idPersona = $intIdUsuario";
            $arrUC = $this->select_all($sqlUniCarr);
            if (count($arrUC) > 0) {
                $request['datosacademicos'] = $arrUC;
            }
            $request['unicarreras'] = $resUni;
        }
        return $request;
    }

    public function selectPreguntas()
    {

        $sqlc = "SELECT DISTINCT idCuatrimestre, nombre, cicloEscolar FROM cuatrimestre
            WHERE status = 1";
        $request = $this->select($sqlc);
        $idCuatri = $request["idCuatrimestre"];

        if (count($request) > 0) {
            $sqlt = "SELECT idTema, nombreTema FROM tema;";
            $requestT = $this->select_all($sqlt);

            for ($t = 0; $t < count($requestT); $t++) {
                $request["temas"][$t] = $requestT[$t];
                $idTema = $requestT[$t]['idTema'];

                $sqls = "SELECT idSeccion, nombreSeccion FROM seccion
                    WHERE idTema = $idTema;";
                $requestS = $this->select_all($sqls);

                for ($s = 0; $s < count($requestS); $s++) {
                    $request["temas"][$t]["secciones"][$s] = $requestS[$s];
                    $idSeccion = $requestS[$s]["idSeccion"];

                    $sqlp = "SELECT DISTINCT p.idPregunta,p.pregunta, p.descripcionMixta, tp.idTipopregunta, tp.descTipopregunta FROM pregunta AS p 
                        INNER JOIN seccion AS s ON p.idSeccion = s.idSeccion
                        INNER JOIN cuestionario AS c ON p.idCuestionario = c.idCuestionario
                        INNER JOIN cuatrimestre AS cu ON cu.idCuestionario = c.idCuestionario
                        INNER JOIN tipopregunta AS tp ON p.idTipopregunta = tp.idTipopregunta
                        WHERE s.idSeccion = $idSeccion AND c.idCuestionario = $idCuatri";
                    $requestP = $this->select_all($sqlp);

                    for ($p = 0; $p < count($requestP); $p++) {
                        $request["temas"][$t]["secciones"][$s]["preguntas"][$p] = $requestP[$p];
                        $idPregunta = $requestP[$p]["idPregunta"];

                        $sqlre = "SELECT DISTINCT r.idPregunta ,o.idOpcion, o.nombreOpcion,r.idRetroalimentacion, r.descRetroalimentacion FROM retroalimentacion AS r 
                           INNER JOIN opcion AS o ON r.idOpcion = o.idOpcion WHERE r.idPregunta = $idPregunta";
                        $requestRe = $this->select_all($sqlre);

                        for ($r = 0; $r < count($requestRe); $r++) {
                            $request["temas"][$t]["secciones"][$s]["preguntas"][$p]["opciones"][$r] = $requestRe[$r];
                        }
                    }
                }
            }
        }

        return $request;
    }

    public function setRespuesta($idcuatri, $nomcuatri, $idper)
    {
        $this->intIdCuatrimestre = $idcuatri;
        $this->strnombreCuatrimestre = $nomcuatri;
        $this->intIdPersona = $idper;

        $sql = "SELECT * FROM respuesta WHERE 
					idCuatrimestre = '{$this->intIdCuatrimestre}' AND idPersona = '{$this->intIdPersona}' ";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert  = "INSERT INTO respuesta(idCuatrimestre, cuatrimestre, idPersona) 
								VALUES(?,?,?)";
            $arrData = array(
                $this->intIdCuatrimestre,
                $this->strnombreCuatrimestre,
                $this->intIdPersona
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

  
    public function setDetalleResp($pregunta, $idopcion, $opcion, $retro, $respuesta = "",$idpreg, $idresp)
    {
        $this->strPregunta = $pregunta;
        $this->intIdOpcion = $idopcion;
        $this->strOpcion = $opcion;
        $this->strRetroalimentacion = $retro;
        $respuesta = $respuesta;
        $this->intIdPregunta = $idpreg;
        $this->intIdRespuesta = $idresp;

        if($respuesta == ""){

            $query_insert  = "INSERT INTO detallerespuesta(pregunta, idOpcion, opcion, retroalimentacion, idPregunta, idRespuesta) 
            VALUES(?,?,?,?,?,?)";
    
            $arrData = array(
                $this->strPregunta,
                $this->intIdOpcion,
                $this->strOpcion,
                $this->strRetroalimentacion,
                $this->intIdPregunta,
                $this->intIdRespuesta
            );

        }else{
            
            $query_insert  = "INSERT INTO detallerespuesta(pregunta, idOpcion, opcion, retroalimentacion, respuesta, idPregunta, idRespuesta) 
            VALUES(?,?,?,?,?,?,?)";

            $arrData = array(
                $this->strPregunta,
                $this->intIdOpcion,
                $this->strOpcion,
                $this->strRetroalimentacion,
                $respuesta,
                $this->intIdPregunta,
                $this->intIdRespuesta
            );
        }



        $request_insert = $this->insert($query_insert, $arrData);

        return $request_insert;
    }
}
