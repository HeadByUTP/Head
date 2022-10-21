<?php 
class GraficasModel extends Mysql
{
	private $intIdCuatrimestre;

	public function __construct()
	{
		parent::__construct();
	}	

	public function selectIdCuatrimestre(int $idCuatrimestre)
	{
        $this->intIdCuatrimestre = $idCuatrimestre;
		$sql = "SELECT idCuatrimestre FROM cuatrimestre
				WHERE idCuatrimestre = '$this->intIdCuatrimestre'";
		$request = $this->select($sql);
        if(empty($request)){
            $request = 'noexist';
        }
		return $request;
	}

	public function getGraficas(int $idCuatrimestre){
		$this->intIdCuatrimestre = $idCuatrimestre;

		$sqlc = "SELECT DISTINCT idCuatrimestre, cuatrimestre FROM respuesta
		WHERE idCuatrimestre = $this->intIdCuatrimestre";
		$request = $this->select($sqlc);
		$idCuatri = $request["idCuatrimestre"];

		if(count($request) > 0){ 
			$sqlt = "SELECT idTema, nombreTema FROM tema;";
			$requestT = $this->select_all($sqlt);

			for ($t=0; $t < count($requestT); $t++) { 
				$request["temas"][$t] = $requestT[$t];
				$idTema = $requestT[$t]['idTema'];

				$sqls = "SELECT idSeccion, nombreSeccion FROM seccion
				WHERE idTema = $idTema;";
				$requestS = $this->select_all($sqls);

				for ($s=0; $s < count($requestS); $s++) { 
					$request["temas"][$t]["secciones"][$s] = $requestS[$s];
					$idSeccion = $requestS[$s]["idSeccion"];

					$sqlp = "SELECT DISTINCT p.idPregunta,dr.pregunta FROM detallerespuesta AS dr 
					INNER JOIN respuesta AS r ON dr.idRespuesta = r.idRespuesta
					INNER JOIN pregunta AS p ON dr.idPregunta = p.idPregunta
					WHERE r.idCuatrimestre = $idCuatri
					AND p.idSeccion = $idSeccion
					AND p.idTipopregunta != 3";
					$requestP = $this->select_all($sqlp);

					for ($p=0; $p < count($requestP); $p++) { 
						$request["temas"][$t]["secciones"][$s]["preguntas"][$p] = $requestP[$p];
						$idPregunta = $requestP[$p]["idPregunta"];

						$sqlo = "SELECT idOpcion,opcion, COUNT(idOpcion) AS conteo FROM detallerespuesta AS dr 
						INNER JOIN respuesta AS r ON dr.idRespuesta = r.idRespuesta
						WHERE idPregunta = $idPregunta AND r.idCuatrimestre = $idCuatri GROUP BY idOpcion";
						$requestO = $this->select_all($sqlo);

						for ($o=0; $o < count($requestO); $o++) { 
							$request["temas"][$t]["secciones"][$s]["preguntas"][$p]["opcioneseleccionadas"][$o] = $requestO[$o];
						}

					}

				}

			}

		}

		return $request;

	}

}

 ?>