<?php 

	class CuatrimestresModel extends Mysql
	{
		//Propiedades correspondientes a la entidad en la BD
		public $intIdCuatri;
		public $strCicloEsc;
		public $strNom;
		public $intStatus;
		public $intIdCues;
 
		//Constructor que invoca al constructor de la clase padre para conectar a la BD
		public function __construct()
		{
			parent::__construct();
		}	

		//Devuelve todos los registros de la tabla
		public function selectCuatrimestres()
		{
			$sql = "SELECT c.idCuatrimestre, c.nombre, c.cicloEscolar, c.status, cues.nombreCuestionario 
			FROM cuatrimestre AS c 
			LEFT JOIN cuestionario AS cues 
			ON c.idCuestionario = cues.idCuestionario WHERE c.status != 0;";
			$request = $this->select_all($sql);
			return $request;
		}

		//Inserta un registro en la tabla
		public function insertCuatrimestre(string $strNombreCuatri, string $strCicloEscolar, string $strStatus, int $intCuestionario)
		{
			$this->strNom = $strNombreCuatri;
			$this->strCicloEsc = $strCicloEscolar;
			$this->intStatus = $strStatus;
			$this->intIdCues = $intCuestionario;
			$return = "";
			$sql = "SELECT * FROM cuatrimestre 
			WHERE nombre = '$this->strNom' AND cicloEscolar='$this->strCicloEsc' AND idCuestionario = '$this->intIdCues' AND status = '$this->intStatus'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO cuatrimestre (nombre, cicloEscolar, status, idCuestionario) VALUES (?,?,?,?)";
	        	$arrData = array($this->strNom, $this->strCicloEsc, $this->intStatus, $this->intIdCues);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
		
		//Devuelve el registro del que coincida el id
		public function selectCuatrimestre(int $idCuatrimestre)
		{
			$this->intIdCuatri = $idCuatrimestre;
			$sql = "SELECT c.idCuatrimestre, c.nombre, c.cicloEscolar, c.status, cues.nombreCuestionario, cues.idCuestionario 
			FROM cuatrimestre AS c 
			LEFT JOIN cuestionario AS cues 
			ON c.idCuestionario = cues.idCuestionario
			WHERE idCuatrimestre = $this->intIdCuatri AND c.status != 0";
			$request = $this->select($sql);
			return $request;
		}

		//Actualiza el registro indicado con los nuevos valores enviados
		public function updateCuatrimestre($idCuatrimestre, $strNombre, $strCicloEscolar, $strStatus, $intCuestionario)
		{
			$this->intIdCuatri = $idCuatrimestre;
			$this->strNom = $strNombre;
			$this->strCicloEsc = $strCicloEscolar;
			$this->intStatus = $strStatus;
			$this->intIdCues = $intCuestionario;
			$sql = "SELECT * FROM cuatrimestre 
			WHERE nombre = '$this->strNom' AND cicloEscolar='$this->strCicloEsc' AND idCuestionario = '$this->intIdCues' AND status = '$this->intStatus'"; 
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE cuatrimestre SET nombre = ?, cicloEscolar = ?, status = ?, idCuestionario = ? WHERE idCuatrimestre = $this->intIdCuatri;";
				$arrData = array($this->strNom, $this->strCicloEsc, $this->intStatus, $this->intIdCues);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}
		
		//Elimina el registro del que coincida el id
		public function deleteCuatrimestre(int $idcuatrimestre)
		{
			$this->intIdCuatri = $idcuatrimestre;
			$sql = "UPDATE cuatrimestre SET status = ? WHERE idCuatrimestre = $this->intIdCuatri";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}
		
	}
?>