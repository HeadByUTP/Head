<?php

class PreguntasinicioModel extends Mysql
{
    //Propiedades correspondientes a la entidad en la BD
    public $intIdSec;
    public $strNomSec;
    public $intIdTem;

    //Constructor que invoca al constructor de la clase padre para conectar a la BD
    public function __construct()
    {
        parent::__construct();
    }

    //Devuelve todos los registros de la tabla
    public function selectPreguntasinicio()
    {
        $sql = "SELECT ph.idPregunta, c.nombreCuestionario, t.nombreTema, s.nombreSeccion, ph.pregunta FROM pregunta AS ph 
            INNER JOIN cuestionario AS c ON 
            ph.idCuestionario=c.idCuestionario 
            INNER JOIN seccion AS s ON ph.idSeccion=s.idSeccion 
            INNER JOIN tema AS t ON s.idTema = t.idTema
            WHERE ph.status=1";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPregunta(int $idPregunta)
    {
        $this->intIdPre = $idPregunta;
        $sql = "SELECT ph.idPregunta, ph.pregunta, s.nombreSeccion
            FROM pregunta AS ph 
            LEFT JOIN seccion AS s 
            ON ph.idSeccion=s.idSeccion 
            WHERE idPregunta = $this->intIdPre";
        $request = $this->select($sql);
        return $request;
    }

    //Elimina el registro del que coincida el id
    public function deletePregunta(int $idPregunta)
    {
        $this->intIdPre = $idPregunta;
			$sql = "UPDATE pregunta SET status = ? WHERE idPregunta = $this->intIdPre ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
    }

    public function updatePreguntasInicio($idPregunta, $strNombre, $strDescripMixta, $intStatus)
		{
			$this->intIdPregunta = $idPregunta;
			$this->strNom = $strNombre;
			$this->strCicloEsc = $strCicloEscolar;
			$this->intStatus = $strStatus;
			$this->intIdCues = $intCuestionario;
			$sql = "SELECT * FROM pregunta 
			WHERE nombre = '$this->strNom' AND cicloEscolar='$this->strCicloEsc' AND idCuestionario = '$this->intIdCues' AND status = '$this->intStatus'"; 
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE cuatrimestre SET nombre = ?, cicloEscolar = ?, status = ?, idCuestionario = ? WHERE idCuatrimestre = $this->intIdPregunta;";
				$arrData = array($this->strNom, $this->strCicloEsc, $this->intStatus, $this->intIdCues);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}

    
}
