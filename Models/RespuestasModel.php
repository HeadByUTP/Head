<?php 
class RespuestasModel extends Mysql{

	public function selectRespuestas()
	{
		$sql = "SELECT re.idRespuesta, p.nombres, p.apellidos, p.identificacion, re.cuatrimestre, re.fecha FROM respuesta AS re
				INNER JOIN persona AS p ON re.idPersona = p.idpersona ORDER BY idRespuesta DESC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectRespuestasProfesor($idUsuario)
	{
		$sql = "SELECT re.idRespuesta, p.nombres, p.apellidos, p.identificacion, re.cuatrimestre, re.fecha FROM respuesta AS re
				INNER JOIN persona AS p ON re.idPersona = p.idpersona WHERE re.idPersona = $idUsuario ORDER BY idRespuesta DESC";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectRespuesta(int $idRespuesta){
		
		$sqlc = "SELECT DISTINCT idCuatrimestre, nombre, cicloEscolar FROM cuatrimestre
		WHERE status = 1";
		$request = $this->select($sqlc);
		$idCuatri = $request["idCuatrimestre"];

		if (count($request) > 0) {
			$sqlt = "SELECT idTema, nombreTema FROM tema;";
			$requestT = $this->select_all($sqlt);

			//Obtener datos del usuario
			$sqlU = "SELECT respu.idRespuesta,perso.nombres, perso.apellidos, perso.identificacion FROM respuesta AS respu 
			INNER JOIN persona AS perso ON respu.idPersona = perso.idpersona 
			WHERE respu.idRespuesta = $idRespuesta;";
			$requestU = $this->select($sqlU);
			$request["usuario"] = $requestU;

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

						$sqlre = "SELECT dres.idPregunta,dres.opcion, dres.retroalimentacion FROM detallerespuesta AS dres WHERE dres.idPregunta = $idPregunta AND dres.idRespuesta = $idRespuesta;";
						
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

}
 ?>